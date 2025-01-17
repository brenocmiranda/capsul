<?php
namespace App\Http\Controllers;

use PagarMe;
use Correios;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Notifications\CarrinhoAbandonado;
use App\Notifications\NovoPedidoCliente;
use App\Notifications\NovoPedidoAdmin;
use App\Notifications\AlteracaoStatus;
use App\Avaliacoes;
use App\Produtos;
use App\PedidosStatus;
use App\PedidosRastreamento;
use App\Pedidos;
use App\Clientes;
use App\Leads;
use App\Telefones;
use App\Enderecos;
use App\ConfigCheckout;
use App\ConfigGeral;
use App\ConfigEmails;
use App\ConfigLogistica;
use App\ConfigSeguranca;
use App\Status;

class CheckoutCtrl extends Controller
{
  public function __construct(){
      $this->checkout = ConfigCheckout::first();
      $this->geral = ConfigGeral::first();
      $this->seguranca = ConfigSeguranca::all();
      $this->emails = ConfigEmails::first();
      $this->pagarme = new PagarMe\Client($this->checkout->api_key);
  }

  // Criação do pedido
  public function Create($link){
    foreach($this->seguranca as $seguranca){
      if($seguranca->ip_bloqueado == $_SERVER['REMOTE_ADDR']){
        return view('system.bloqueio');
      }
    } 
    $ip_max = Pedidos::whereNotNull('transacao_pagarme')->whereDate('created_at', date('Y-m-d'))->where('ip_compra', $_SERVER['REMOTE_ADDR'])->count();
    if($ip_max >= $this->checkout->pedidos_ip){
      return view('system.bloqueio');
    }else{
      $produto = Produtos::where('link_produto', $link)->first();
      if($produto){
        $pedido = Pedidos::create([
          'id_produto' => $produto->id, 
          'codigo' => preg_replace("/[^0-9]/", "", substr(uniqid(date('HisYmd')), -11)), 
          'valor_compra' => $produto->preco_venda,
          'quantidade' => 1,
          'ip_compra' => $_SERVER['REMOTE_ADDR'],
          'carrinho_abandonado' => 1
        ]);
        return view('checkout.index')->with('pedido', $pedido)->with('checkout', $this->checkout)->with('geral', $this->geral);
      }else{
          abort(404);
      }
    }
  }

  // Continua o pedido de onde parou
  public function Continuar($codigo){
    foreach($this->seguranca as $seguranca){
      if($seguranca->ip_bloqueado == $_SERVER['REMOTE_ADDR']){
        return view('system.bloqueio');
      }
    } 
    $ip_max = Pedidos::whereNotNull('transacao_pagarme')->whereDate('created_at', date('Y-m-d'))->where('ip_compra', $_SERVER['REMOTE_ADDR'])->count();
    if($ip_max >= $this->checkout->pedidos_ip){
      return view('system.bloqueio');
    }else{
      $pedido = Pedidos::where('codigo', $codigo)->first();
      if($pedido && @$pedido->RelationStatus->last()->posicao != 3 && @$pedido->RelationStatus->last()->posicao < 5){
        $enderecos = Enderecos::where('id_cliente', $pedido->id_cliente)->get();
        return view('checkout.index')->with('pedido', $pedido)->with('checkout', $this->checkout)->with('geral', $this->geral)->with('enderecos', $enderecos);
      }else{
        abort(404);
      }
    }
  }

  // Atualização dos dados pessoais
  public function Form1(Request $FormRequest, $id){
    $dados = Clientes::where('documento', preg_replace('/[^0-9]/', '', $FormRequest->documento))->first();
    if(isset($dados)){
        // Cliente já cadastrado
        $lead = Leads::find($dados->id_lead)->update([
          'nome' => $FormRequest->nome, 
          'email' => $FormRequest->email
        ]);
        $cliente = Clientes::find($dados->id)->update([
          'nome' => $FormRequest->nome, 
          'email' => $FormRequest->email, 
          'data_nascimento' => (isset($FormRequest->data_nascimento) ? $FormRequest->data_nascimento : null)
        ]);
        $telefone = Telefones::where('id_cliente', $dados->id)->update([
          'numero' => str_replace("(", "+55", str_replace(") ", "", str_replace("-", "", $FormRequest->telefone)))
        ]);
        Pedidos::find($id)->update(['id_cliente' => $dados->id]);

        /*
        if($this->emails->ativo_carrinho){
          $pedido = Pedidos::find($id);
          $pedido->RelationCliente->notify((new CarrinhoAbandonado($pedido))->delay(now()->addMinutes(1)));
        }  
        */
    }else{
        // Cliente não cadaastrado
        $lead = Leads::create([
          'nome' => $FormRequest->nome, 
          'email' => $FormRequest->email
        ]);
        if(strlen(preg_replace('/[^0-9]/', '', $FormRequest->documento)) == 14){
          $cliente = Clientes::create([
            'tipo' => 'pj', 
            'ativo' => 1, 
            'nome' => $FormRequest->nome, 
            'email' => $FormRequest->email, 
            'documento' => preg_replace('/[^0-9]/', '', $FormRequest->documento), 
            'id_lead' => $lead->id
          ]);
        }else{
          $cliente = Clientes::create([
            'tipo' => 'pf', 
            'ativo' => 1, 
            'nome' => $FormRequest->nome, 
            'email' => $FormRequest->email, 
            'documento' => preg_replace('/[^0-9]/', '', $FormRequest->documento),  
            'id_lead' => $lead->id
          ]);
        }
        
        $telefone = Telefones::create([
          'id_cliente' => $cliente->id, 
          'numero' => str_replace("(", "+55", str_replace(") ", "", str_replace("-", "", $FormRequest->telefone)))
        ]);
        Pedidos::find($id)->update(['id_cliente' => $cliente->id]);

        /*
        if($this->emails->ativo_carrinho){
          $pedido = Pedidos::find($id);
          $pedido->RelationCliente->notify((new CarrinhoAbandonado($pedido))->delay(now()->addMinutes(1)));
        }*/  
    }  
    return response()->json(['success' => true]);
  }

  // Atualização do endereço
  public function Form2(Request $FormRequest, $id){
    $pedido = Pedidos::find($id);
    $frete = ConfigLogistica::find($FormRequest->frete);

    $rastreamento = PedidosRastreamento::create([
      'tipo' => $frete->nome, 
      'prazo_envio' => $this->addDiasUteis(date('Y-m-d'), $frete->prazo_entrega),
      'prazo' =>  $frete->prazo_entrega,
      'valor_envio' => $frete->valor
    ]);
    $pedido = Pedidos::find($id)->update([
        'id_endereco' => $FormRequest->endereco,
        'id_rastreamento' => $rastreamento->id
      ]);
    return response()->json(['success' => true]);
  }

  // Compra efetuada no cartão de crédito
  public function Form3(Request $FormRequest, $id){

    // Realizando transação
    if(!empty($FormRequest->card_hash)){
      $pedido = Pedidos::find($id);
      $transaction = $this->pagarme->transactions()->create([
        'amount' => number_format($pedido->valor_compra, 2, '', '') + number_format($pedido->RelationRastreamento->valor_envio, 2, "","") - number_format($pedido->desconto_aplicado, 2, "",""),
        'payment_method' => 'credit_card',
        'soft_descriptor' => 'GRUPOCAPSUL',
        'card_hash' => $FormRequest->card_hash,
        'installments' => $FormRequest->installments,
        'customer' => [
          'external_id' => (string) $pedido->id_cliente,
          'name' => $pedido->RelationCliente->nome,
          'type' => 'individual',
          'country' => 'br',
          'documents' => [
            [
              'type' => 'cpf',
              'number' => str_replace(".", "", str_replace("-", "", $FormRequest->documento_titular))
            ]
          ],
          'phone_numbers' => [ $pedido->RelationTelefones->numero ],
          'email' => $pedido->RelationCliente->email
        ],
        'billing' => [
          'name' => $pedido->RelationCliente->nome,
          'address' => [
            'country' => 'br',
            'street' => $pedido->RelationEndereco->endereco,
            'street_number' => $pedido->RelationEndereco->numero,
            'state' => $pedido->RelationEndereco->estado,
            'city' =>  $pedido->RelationEndereco->cidade,
            'complementary' => ($pedido->RelationEndereco->complemento != null ? $pedido->RelationEndereco->complemento : "Sem complemento"),
            'neighborhood' => $pedido->RelationEndereco->bairro,
            'zipcode' =>  $pedido->RelationEndereco->cep
          ]
        ],
        'shipping' => [
          'name' => $pedido->RelationEndereco->destinatario,
          'fee' => number_format($pedido->RelationRastreamento->valor_envio, 2, "",""),
          'delivery_date' => $pedido->RelationRastreamento->prazo_envio,
          'expedited' => false,
          'address' => [
            'country' => 'br',
            'street' => $pedido->RelationEndereco->endereco,
            'street_number' => $pedido->RelationEndereco->numero,
            'state' => $pedido->RelationEndereco->estado,
            'city' => $pedido->RelationEndereco->cidade,
            'complementary' => ($pedido->RelationEndereco->complemento != null ? $pedido->RelationEndereco->complemento : "Sem complemento"),
            'neighborhood' => $pedido->RelationEndereco->bairro,
            'zipcode' => $pedido->RelationEndereco->cep
          ]
        ],
        'items' => [
          [
            'id' => (string) $pedido->RelationProduto->cod_sku,
            'title' => $pedido->RelationProduto->nome,
            'unit_price' => number_format($pedido->RelationProduto->preco_venda, 2, "",""),
            'quantity' => $pedido->quantidade,
            'tangible' => ($pedido->RelationProduto->tipo == 'fisico' ? true : false)
          ]
        ]
      ]);

      Pedidos::find($id)->update(['ip_compra' => $transaction->ip]);
      if($pedido->transacao_pagarme == null){
        PedidosStatus::create(['id_pedido' => $id, 'id_status' => 1]);
        $pedido->RelationCliente->notify(new NovoPedidoCliente($pedido));
        $this->emails->notify(new NovoPedidoAdmin($pedido));
      }
      
      // Retorno do status
      if(!empty($transaction)){
        if($transaction->status == 'authorized' || $transaction->status == 'paid'){
          // Aprovado
          $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 3]);
          $pedido->RelationCliente->notify((new AlteracaoStatus($status))->delay(now()->addMinutes(5)));
          Pedidos::find($id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '1', 'carrinho_abandonado' => 0]);
          Produtos::find($pedido->id_produto)->update(['quantidade' => ($pedido->RelationProduto->quantidade - $pedido->quantidade)]);
          $dados = Status::select('nome', 'descricao', 'posicao')->find(3);
          $dados->image = asset('public/img/status-pagamento/aprovado.png');
          $dados->link = '<a href="'.route('acompanhamento.pedido', $pedido->codigo).'" target="_blank">Acompanhamento do seu pedido</a> &#183 <a href="'.route('checkout.create', $pedido->RelationProduto->link_produto).'" target="_blank"> Comprar novamente</a>';
          $dados->estado = "bg-success text-white";
          $dados->url_redirect = $this->checkout->url_cartao;
          return json_encode($dados);
        }elseif($transaction->status == 'refunded' || $transaction->status == 'refused' || $transaction->status == 'chargedback' || $transaction->status == 'pending_refund'){
           // Recusado
          $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 4]);
          $pedido->RelationCliente->notify((new AlteracaoStatus($status))->delay(now()->addMinutes(5)));
          Pedidos::find($id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '1']);
          $dados = Status::select('nome', 'descricao', 'posicao')->find(4);
          $dados->image = asset('public/img/status-pagamento/recusado.png');
           $dados->link = '<a href="javascript:void(0)" onclick="refazerPayment()" class="btn btn-primary btn-lg btn-icon icon-left shadow-none"><i class="mdi mdi-arrow-left"></i> Tentar novamente</a>';
          $dados->estado = "bg-danger text-white";
          $dados->url_redirect = $this->checkout->url_cartao;
          return json_encode($dados);
        }elseif($transaction->status == 'waiting_payment' || $transaction->status == 'analyzing' || $transaction->status == 'pending_review' || $transaction->status == 'processing'){
          // Em análise
          $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 2]);
          $pedido->RelationCliente->notify((new AlteracaoStatus($status))->delay(now()->addMinutes(5)));
          Pedidos::find($id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '1', 'carrinho_abandonado' => 0]);
          $dados = Status::select('nome', 'descricao', 'posicao')->find(2);
          $dados->image = asset('public/img/status-pagamento/analise.png');
          $dados->link = '<a href="'.route('acompanhamento.pedido', $pedido->codigo).'" target="_blank">Acompanhamento do seu pedido</a> &#183 <a href="'.route('checkout.create', $pedido->RelationProduto->link_produto).'" target="_blank"> Comprar novamente</a>';
          $dados->estado = "bg-warning text-white";
          $dados->url_redirect = $this->checkout->url_cartao;
          return json_encode($dados);
        }
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  // Compra efetuada pelo boleto
  public function Form4(Request $FormRequest, $id){
    
    // Realizando transação
    if(!empty($FormRequest->documento_titular)){
      $pedido = Pedidos::find($id);
      $transaction = $this->pagarme->transactions()->create([
        'amount' => number_format($pedido->valor_compra, 2, '', '') + number_format($pedido->RelationRastreamento->valor_envio, 2, "","") - number_format($pedido->desconto_aplicado, 2, "",""),
        'payment_method' => 'boleto',
        'async' => false,
        'customer' => [
          'external_id' => (string) $pedido->id_cliente,
          'name' =>  $pedido->RelationCliente->nome,
          'type' => 'individual',
          'country' => 'br',
          'documents' => [
            [
              'type' => 'cpf',
              'number' => str_replace(".", "", str_replace("-", "", $FormRequest->documento_titular))
            ]
          ],
          'phone_numbers' => [ $pedido->RelationTelefones->numero ],
          'email' => $pedido->RelationCliente->email
        ]]); 

        Pedidos::find($id)->update(['ip_compra' => $transaction->ip]);
        if($pedido->transacao_pagarme == null){
          PedidosStatus::create(['id_pedido' => $id, 'id_status' => 1]);
          $pedido->RelationCliente->notify(new NovoPedidoCliente($pedido));
          $this->emails->notify(new NovoPedidoAdmin($pedido));
        }
   
      // Retorno do status
      if(!empty($transaction)){
        if($transaction->status == 'authorized' || $transaction->status == 'paid'){
          // Aprovado
          $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 3]);
          $pedido->RelationCliente->notify((new AlteracaoStatus($status))->delay(now()->addMinutes(5)));
          Pedidos::find($id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '2', 'link_boleto' => $transaction->boleto_url, 'carrinho_abandonado' => 0]);
          Produtos::find($pedido->id_produto)->update(['quantidade' => ($pedido->RelationProduto->quantidade - $pedido->quantidade)]);
          $dados = Status::select('nome', 'descricao', 'posicao')->find(3);
          $dados->image = asset('public/img/status-pagamento/aprovado.png');
          $dados->link = '<a href="'.route('acompanhamento.pedido', $pedido->codigo).'" target="_blank">Acompanhamento do seu pedido</a> &#183 <a href="'.route('checkout.create', $pedido->RelationProduto->link_produto).'" target="_blank"> Comprar novamente</a>';
          $dados->estado = "bg-success text-white";
          $dados->url_redirect = $this->checkout->url_boleto;
          return json_encode($dados);
        }elseif($transaction->status == 'refunded' || $transaction->status == 'refused' || $transaction->status == 'chargedback' || $transaction->status == 'pending_refund'){
           // Recusado
          $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 4]);
          $pedido->RelationCliente->notify((new AlteracaoStatus($status))->delay(now()->addMinutes(5)));
          Pedidos::find($id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '2', 'link_boleto' => $transaction->boleto_url]);
          $dados = Status::select('nome', 'descricao', 'posicao')->find(4);
          $dados->image = asset('public/img/status-pagamento/recusado.png');
          $dados->link = '<a href="javascript:void(0)" onclick="refazerPayment()" class="btn btn-primary btn-lg btn-icon icon-left shadow-none"><i class="mdi mdi-check"></i> Tentar novamente</a>';
          $dados->estado = "bg-danger text-white";
          $dados->url_redirect = $this->checkout->url_boleto;
          return json_encode($dados);
        }elseif($transaction->status == 'waiting_payment' || $transaction->status == 'analyzing' || $transaction->status == 'pending_review' || $transaction->status == 'processing'){
          // Em análise
          $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 2]);
          $pedido->RelationCliente->notify((new AlteracaoStatus($status))->delay(now()->addMinutes(5)));
          Pedidos::find($id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '2', 'link_boleto' => $transaction->boleto_url, 'carrinho_abandonado' => 0]);
          $dados = Status::select('nome', 'descricao', 'posicao')->find(2);
          $dados->image = asset('public/img/status-pagamento/analise.png');
          $dados->link = '<a href="'.route('acompanhamento.pedido', $pedido->codigo).'" target="_blank">Acompanhamento do seu pedido</a> &#183 <a href="'.route('checkout.create', $pedido->RelationProduto->link_produto).'" target="_blank"> Comprar novamente</a>';
          $dados->estado = "bg-warning text-white";
          $dados->url_redirect = $this->checkout->url_boleto;
          return json_encode($dados);
        }
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  // Detalhes do cliente
  public function DetalhesCliente($documento){
      $clientes = Clientes::where('documento', $documento)->select('id', 'nome', 'email','data_nascimento')->first();
      if(!empty($clientes)){
         $clientes->telefone = Telefones::where('id_cliente', $clientes->id)->select('numero')->first();
         $clientes->endereco = Enderecos::where('id_cliente', $clientes->id)->where('status', 1)->get();
        return response()->json($clientes);
      }else{
        return false;
      }
  }

  // Cadastrando ou atualizar endereço do usuário
  public function UpdateEndereco(Request $request, $id){
    $pedido = Pedidos::find($id);
      if(empty($request->acao)){
        $endereco = Enderecos::create([
          'endereco' => $request->endereco, 
          'bairro' => $request->bairro, 
          'numero' => $request->numero, 
          'complemento' => $request->complemento, 
          'cep' => str_replace("-", "",$request->cep),
          'destinatario' => $request->destinatario, 
          'cidade' => $request->cidade, 
          'estado' => $request->estado, 
          'status' => 1,
          'id_cliente' => $pedido->id_cliente
        ]);
      }else{
        Enderecos::find($request->acao)->update([
          'endereco' => $request->endereco, 
          'bairro' => $request->bairro, 
          'numero' => $request->numero, 
          'complemento' => $request->complemento, 
          'cep' => str_replace("-", "",$request->cep),
          'destinatario' => $request->destinatario, 
          'cidade' => $request->cidade, 
          'estado' => $request->estado, 
          'id_cliente' => $pedido->id_cliente
        ]);
        $endereco = Enderecos::find($request->acao);
      }
      return response()->json($endereco);
  }

  // Cadastrando ou atualizar endereço do usuário
  public function UpdateQuantidade($id, $quantidade){
    $pedido = Pedidos::find($id);
    if($quantidade <= $pedido->RelationProduto->quantidade){
      $total = Pedidos::where('id', $id)->update(['valor_compra' => ($pedido->RelationProduto->preco_venda * $quantidade), 'quantidade' => $quantidade]);
      $dados = Pedidos::find($id);
      return response()->json($dados->valor_compra);
    }else{
      $dados = Pedidos::find($id);
      return response()->json(['quantidade' => $dados->quantidade, 'dados' => $dados->valor_compra]);
    }   
  }

  // Retornando dados do endereço do usuário
  public function DetalhesEndereco($id){
      $endereco = Enderecos::find($id);
      return response()->json($endereco);
  }

  // Cálculo de frete, prazo e tipo
  public function CalculoFrete($id){
    $cep_origem = Enderecos::select('cep')->find($id);
    $formas_envio = ConfigLogistica::where('ativo', 1)->get();
    foreach ($formas_envio as $envio) {
      if ((int) $cep_origem->cep >= (int) $envio->cep_inicial && (int) $cep_origem->cep <= (int) $envio->cep_final){
        $dados[] = $envio;
      }
    }
    return response()->json($dados);
  }

  // Cálculo de frete, prazo e tipo
  public function ParcelasQuantidade($valor){
    $dados = $this->pagarme->transactions()->calculateInstallments([
      'amount' => number_format($valor, 2, '', ''),
      'free_installments' => '12',
      'max_installments' => '12',
      'interest_rate' => '4.59'
    ]);
    return response()->json($dados);
  }

  // Cálculo de frete, prazo e tipo
  public function DescontosCheckout($id,$valor){
    $valor_desconto = (double) $valor;
    if(!empty($valor_desconto)){
      Pedidos::find($id)->update(['desconto_aplicado' => $valor_desconto]);
    }else{
      Pedidos::find($id)->update(['desconto_aplicado' => 0]);
    }
    return response()->json(['success' => true]);
  }

  // Acompanhamento de pedido
  public function Acompanhamento($codigo){
    if(!empty($codigo)){
      $pedido = Pedidos::where('codigo', $codigo)->first();
      $status = Status::all();
      return view('pedidos.rastrear')->with('pedido', $pedido)->with('geral', $this->geral)->with('status', $status);
    }else{
      abort(404);
    }
  }

  // Avaliação do pedido
  public function Avaliacao($codigo){
    if(!empty($codigo)){
      $pedido = Pedidos::where('codigo', $codigo)->first();
      if(!$pedido->RelationAvaliacao){
        return view('pedidos.avaliacao')->with('pedido', $pedido)->with('geral', $this->geral);
      }else{
        \Session::flash('confirm', array(
                'class' => 'success',
                'mensagem' => 'Essa compra já foi avaliada. Muito obrigado!'
            ));
        return view('pedidos.avaliacao')->with('geral', $this->geral);
      }
    }else{
      
    }
  }
  public function SalvarAvaliacao(Request $request, $id){
    $avaliacao = Avaliacoes::create([
        'produto' => $request->produto, 
        'satisfacao' => $request->satisfacao, 
        'recomendacao' => $request->recomendacao, 
        'observacao' => (isset($request->observacao) ? $request->observacao : null),
      ]);
    Pedidos::find($id)->update(['id_avaliacao' => $avaliacao->id]);

     \Session::flash('confirm', array(
              'class' => 'success',
              'mensagem' => 'Sua avaliação foi enviada com sucesso. Muito obrigado!'
          ));
    return view('pedidos.avaliacao')->with('geral', $this->geral);
  }

  // Caclulando dias úteis
  public function addDiasUteis($str_data,$int_qtd_dias_somar = 7){
    // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
    // Transforma para DATE - aaaa-mm-dd
    $str_data = substr($str_data,0,10);
    // Se a data estiver no formato brasileiro: dd/mm/aaaa
    // Converte-a para o padrão americano: aaaa-mm-dd
    if ( preg_match("@/@",$str_data) == 1 )
    {
        $str_data = implode("-", array_reverse(explode("/",$str_data)));
    }
    $array_data = explode('-', $str_data);
    $count_days = 0;
    $int_qtd_dias_uteis = 0;
    while ( $int_qtd_dias_uteis < $int_qtd_dias_somar )
    {
        $count_days++;
        if ( ( $dias_da_semana = gmdate('w', strtotime('+'.$count_days.' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6' )
        {
           $int_qtd_dias_uteis++;
        }
    }
    return gmdate('Y-m-d',strtotime('+'.$count_days.' day',strtotime($str_data)));
  }
  
}