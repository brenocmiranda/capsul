<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use PagarMe;
use Correios;
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
use App\ConfigLogistica;


class CheckoutCtrl extends Controller
{
  public function __construct(){
      $this->checkout = ConfigCheckout::first();
      $this->geral = ConfigGeral::first();
  }

  // Criação do pedido
  public function Create($link){
    $produto = Produtos::where('link_produto', $link)->first();
    $pedido = Pedidos::create([
      'id_produto' => $produto->id, 
      'codigo' => preg_replace("/[^0-9]/", "", substr(uniqid(date('HisYmd')), 7, 12)), 
      'valor_compra' => $produto->preco_venda
    ]);
    return view('checkout.index')->with('produto', $produto)->with('pedido', $pedido)->with('checkout', $this->checkout)->with('geral', $this->geral);
  }




  // Atualização dos dados pessoais
  public function Form1(Request $FormRequest, $id){
    $dados = Clientes::where('documento', str_replace(".", "", str_replace("-", "", $FormRequest->documento)))->first();
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
        $pedido = Pedidos::where('id', $id)->update(['id_cliente' => $dados->id]);
    }else{
        // Cliente não cadaastrado
        $lead = Leads::create([
          'nome' => $FormRequest->nome, 
          'email' => $FormRequest->email
        ]);
        $cliente = Clientes::create([
          'tipo' => 'pf', 
          'ativo' => 1, 
          'nome' => $FormRequest->nome, 
          'email' => $FormRequest->email, 
          'documento' => str_replace(".", "", str_replace("-", "", $FormRequest->documento)), 
          'id_lead' => $lead->id
        ]);
        $telefone = Telefones::create([
          'id_cliente' => $cliente->id, 
          'numero' => str_replace("(", "+55", str_replace(") ", "", str_replace("-", "", $FormRequest->telefone)))
        ]);
        $pedido = Pedidos::where('id', $id)->update(['id_cliente' => $cliente->id]);
    }  
    return response()->json(['success' => true]);
  }



  // Atualização do endereço
  public function Form2(Request $FormRequest, $id){
    $pedido = Pedidos::where('id', $id)->first();
    $pedido = Pedidos::where('id', $id)->update([
        'id_endereco' => $FormRequest->endereco
      ]);
    $frete = ConfigLogistica::find($FormRequest->frete);
    $rastreamento = PedidosRastreamento::create([
      'tipo' => $frete->nome, 
      'prazo_envio' => $this->addDiasUteis(date('Y-m-d'), $frete->prazo_entrega), 
      'valor_envio' => $frete->valor
    ]);
    return response()->json(['success' => true]);
  }



  // Compra efetuada no cartão
  public function Form3(Request $FormRequest, $id){
    // Retornando os dados referente ao pedido
      $pedido = Pedidos::where('id', $id)->first();

      // Efetuando pagamento com cartão
      $pagarme = new PagarMe\Client($checkout->api_key);
      $transaction = $pagarme->transactions()->create([
        'amount' => number_format($pedido->valor_compra, 2, '', ''),
        'payment_method' => 'credit_card',
        'card_hash' => $FormRequest->card_hash,
        'installments' => $FormRequest->installments,
        'customer' => [
          'external_id' => '#'.$pedido->id_cliente,
          'name' => $pedido->RelationCliente->nome,
          'type' => 'individual',
          'country' => 'br',
          'documents' => [
            [
              'type' => 'cpf',
              'number' => $pedido->RelationCliente->documento
            ]
          ],
          'phone_numbers' => [ $pedido->RelationTelefones->numero ],
          'email' => $pedido->RelationCliente->email
        ],
        'billing' => [
          'name' => $pedido->RelationCliente->nome,
          'address' => [
            'country' => 'br',
            'street' => $pedido->RelationEndereco->rua,
            'street_number' => '"'.$pedido->RelationEndereco->numero.'"',
            'state' => $pedido->RelationEndereco->estado,
            'city' =>  $pedido->RelationEndereco->cidade,
            'complementary' => ($pedido->RelationEndereco->complemento != null ? $pedido->RelationEndereco->complemento : "Sem complemento"),
            'neighborhood' => $pedido->RelationEndereco->bairro,
            'zipcode' =>  $pedido->RelationEndereco->cep
          ]
        ],
        'shipping' => [
          'name' => $pedido->RelationCliente->nome,
          'fee' => 1020,
          'delivery_date' => date('Y-m-d'),
          'expedited' => false,
          'address' => [
            'country' => 'br',
            'street' => $pedido->RelationEndereco->rua,
            'street_number' => '"'.$pedido->RelationEndereco->numero.'"',
            'state' => $pedido->RelationEndereco->estado,
            'city' => $pedido->RelationEndereco->cidade,
            'complementary' => ($pedido->RelationEndereco->complemento != null ? $pedido->RelationEndereco->complemento : "Sem complemento"),
            'neighborhood' => $pedido->RelationEndereco->bairro,
            'zipcode' => $pedido->RelationEndereco->cep
          ]
        ],
        'items' => [
          [
            'id' => '#'.$pedido->RelationProduto->id,
            'title' => $pedido->RelationProduto->nome,
            'unit_price' => str_replace(".", "", $pedido->valor_compra),
            'quantity' => 1,
            'tangible' => true
          ]
        ]
      ]);

      // Fazendo controle do retorno da transção
      if($transaction->status == 'authorized' || $transaction->status == 'paid'){
        $statusID = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 3]);
        Pedidos::where('id', $id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '1', 'id_status' => $statusID->id]);
        return response()->json($transaction->status);

      }elseif($transaction->status == 'refunded' || $transaction->status == 'refused' || $transaction->status == 'chargedback' || $transaction->status == 'pending_refund'){
        $statusID = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 9]);
        Pedidos::where('id', $id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '1', 'id_status' => $statusID->id]);
        return response()->json($transaction->status);

      }elseif($transaction->status == 'waiting_payment' || $transaction->status == 'analyzing' || $transaction->status == 'pending_review' || $transaction->status == 'processing'){
        $statusID = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 1]);
        Pedidos::where('id', $id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '1', 'id_status' => $statusID->id]);
        return response()->json($transaction->status);
      }else{
        return false;
      }
  }

  // Compra efetuada no boleto
  public function Form4(Request $FormRequest, $id){
    // Retorno dos dados referente ao pedido
     $pedido = Pedidos::where('id', $id)->first();

     // Efetuando pagamento com boleto
     $dados = ConfigCheckout::first();
     $pagarme = new PagarMe\Client($dados->api_key);
     $transaction = $pagarme->transactions()->create([
      'amount' => str_replace('.', '',$pedido->valor_compra),
      'payment_method' => 'boleto',
      'async' => false,
      'customer' => [
        'external_id' => '"'.$pedido->id_cliente.'"',
        'name' =>  $pedido->RelationCliente->nome,
        'type' => 'individual',
        'country' => 'br',
        'documents' => [
          [
            'type' => 'cpf',
            'number' => $pedido->RelationCliente->documento
          ]
        ],
        'phone_numbers' => [ $pedido->RelationTelefones->numero ],
        'email' => $pedido->RelationCliente->email
      ]]);

      // Fazendo controle do retorno da transção
      if($transaction->status == 'authorized' || $transaction->status == 'paid'){
        $statusID = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 3]);
        Pedidos::where('id', $id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '2', 'link_boleto' => $transaction->boleto_url, 'id_status' => $statusID->id]);
        return response()->json(['boleto_url' => $transaction->boleto_url, 'status' => $transaction->status]);

      }elseif($transaction->status == 'refunded' || $transaction->status == 'refused' || $transaction->status == 'chargedback' || $transaction->status == 'pending_refund'){
        $statusID = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 9]);
        Pedidos::where('id', $id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '2', 'link_boleto' => $transaction->boleto_url, 'id_status' => $statusID->id]);
        return response()->json(['boleto_url' => $transaction->boleto_url, 'status' => $transaction->status]);

      }elseif($transaction->status == 'waiting_payment' || $transaction->status == 'analyzing' || $transaction->status == 'pending_review' || $transaction->status == 'processing'){
        $statusID = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 1]);
        Pedidos::where('id', $id)->update(['transacao_pagarme' => $transaction->id, 'id_forma_pagamento' => '2', 'link_boleto' => $transaction->boleto_url, 'id_status' => $statusID->id]);
        return response()->json(['boleto_url' => $transaction->boleto_url, 'status' => $transaction->status]);
      }
  }

  // Detalhes do cliente
  public function DetalhesCliente($documento){
      $clientes = Clientes::where('documento', $documento)->select('id', 'nome', 'email','data_nascimento')->first();
      if(!empty($clientes)){
         $clientes->telefone = Telefones::where('id_cliente', $clientes->id)->select('numero')->first();
         $clientes->endereco = Enderecos::where('id_cliente', $clientes->id)->get();
        return response()->json($clientes);
      }else{
        return false;
      }
  }

  // Cadastrando ou atualizar endereço do usuário
  public function UpdateEndereco(Request $request, $id){
    $pedido = Pedidos::where('id', $id)->first();
      if(empty($request->acao)){
        Enderecos::where('id_cliente', $pedido->id_cliente)->update(['status' => 0]);
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
    $total = Pedidos::where('id', $id)->update(['valor_compra' => ($pedido->RelationProduto->preco_venda * $quantidade)]);
    $dados = Pedidos::find($id);
    return response()->json($dados->valor_compra);
  }

  // Cadastrando retornando dados do endereço do usuário
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