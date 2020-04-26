<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;

use PagarMe;
use Correios;
use App\Produtos;
use App\Pedidos;
use App\Clientes;
use App\Leads;
use App\Telefones;
use App\Enderecos;
use App\FormaPagamentos;
use App\Status;
use App\PedidosStatus;
use App\PedidosNotas;
use App\PedidosRastreamento;
use App\ConfigCheckout;
use Carbon\Carbon;

class PedidosCtrl extends Controller
{   
    public function __construct(){
        $this->middleware('auth');
    }
    
    // Lista pedidos
    public function Exibir(){
        if(Auth::user()->RelationGrupo->visualizar_pedidos == 1 || Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            $pedidos = Pedidos::all()->count();
            $status = Status::all();
            $formas = FormaPagamentos::all();
            return view('pedidos.lista')->with('formaPagamentos', $formas)->with('status', $status)->with('pedidos', $pedidos);
        }else{
            return redirect(route('permission'));
        }
    }
    public function Lista(){
        return datatables()->of(Pedidos::WhereNotNull('transacao_pagarme')->get())
                    ->editColumn('transacao', function(Pedidos $dados){ 
                        return '<div>'.($dados->id_forma_pagamento == 1 ? '<img data-v-a542e072="" src="http://download.seaicons.com/icons/iconsmind/outline/512/Credit-Card-3-icon.png" width="30" class="uk-float-left icon-payment">' : '<img data-v-a542e072="" src="https://github.bubbstore.com/svg/billet.svg" width="40" class="uk-float-left icon-payment">').'</div>';
                    })->editColumn('cliente', function(Pedidos $dados){
                        return '<div class="text-left"><a href="'.route('pedidos.detalhe', $dados->id).'" class="nome text-decoration-none">'.$dados->codigo.'<p class="nome_pedido mb-0 text-capitalize">'.strtolower($dados->RelationCliente['nome']).'</p></a></div>';
                    })->editColumn('data', function(Pedidos $dados){
                        return '<div class="text-left">'.date_format($dados->created_at, "d/m/Y H:i:s").'</div><div class="text-left font-weight-bold">'.$dados->created_at->subMinutes(2)->diffForHumans().'</div>';
                    })->editColumn('valor', function(Pedidos $dados){
                        return 'R$ '.number_format($dados->valor_compra, 2, ',', '.');
                    })->editColumn('status', function(Pedidos $dados){
                        return '<div class="status badge badge-'.($dados->RelationStatus->last()['posicao']==1 ? 'warning' : ($dados->RelationStatus->last()['posicao']==2 || $dados->RelationStatus->last()['posicao']==7 ? 'primary' : ($dados[$key]->RelationStatus->last()['posicao']==3 || $dados->RelationStatus->last()['posicao']==8 ? 'success' : ($dados->RelationStatus->last()['posicao']==4 ? 'info' : ($dados[$key]->RelationStatus->last()['posicao']==5 ? 'secondary' : ($dados->RelationStatus->last()['posicao']==6 ? 'success' : ($dados->RelationStatus->last()['posicao']==9 ? 'danger' : ''))))))).'">'.strtoupper($dados->RelationStatus->last()['nome']).'</div>';
                    })->editColumn('entrega', function(Pedidos $dados){
                        return '<div class="text-'.($dados->RelationStatus->last()['posicao']==7 || $dados->RelationStatus->last()['posicao']==8 ? 'success' : 'danger').'"><a '.(isset($dados->cod_rastreio) ? 'href="http://www.websro.com.br/correios.php?P_COD_UNI='.$dados->cod_rastreio.'"' : '').' data-v-a542e072="" target="_blank" disabled="disabled" class="action-link holder-tooltip"><i data-v-a542e072="" class="fas fa-truck"></i> <span data-v-a542e072="" uk-tooltip="title: Rastrear pedido; pos: top; animation: none; cls: uk-active copy darker" class="tooltip" title="" aria-expanded="false"></span></a></div>';
                    })->rawColumns(['transacao', 'cliente', 'data', 'valor', 'status', 'entrega'])->make(true);
    }
    
   

    // Detalhes do pedido
    public function Detalhe($id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            $pedido = Pedidos::find($id);
            $status = Status::all();
            $historicos = PedidosStatus::where('id_pedido', $id)->get();
            // Retornando informações da transação
            $dados = ConfigCheckout::first();
            $pagarme = new PagarMe\Client($dados->api_key);
            $transactions = $pagarme->transactions()->get(['id' => $pedido->transacao_pagarme]);
            // Movimentação entrega correios
            if(isset($pedido->RelationRastreamento->cod_rastreamento)){
                $correios = Correios::rastrear($pedido->RelationRastreamento->cod_rastreamento);
            }else{
                $correios = null;            
            }
            return view('pedidos.detalhe_pedido')->with('pedido', $pedido)->with('status', $status)->with('transactions', $transactions)->with('historicos', $historicos)->with('correios', $correios);
        }else{
            return redirect(route('permission'));
        }
    }

    // Atualizar status
    public function AtualizarStatus(Request $request, $id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            $status1 = PedidosStatus::create(['id_pedido' => $id, 'id_status' => $request->id_status, 'observacoes' => $request->observacoes]);
            Pedidos::where('id', $id)->update(['id_status' => $status1->id]);
            $status = Status::where('id', $request->id_status)->first();
            return response()->json(['status' => $status, 'status1' => $status1]);   
        }else{
            return redirect(route('permission'));
        }  
    }

    // Atualizar Nota fiscal
    public function AtualizarNota(Request $request, $id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            // Retorno dos dados do pedido
            $pedido = Pedidos::where('id', $id)->first();
            // Verificações de existencia de nota
            if(isset($pedido->id_nota)){
                PedidosNotas::where('id', $pedido->id_nota)->update(['numero_nota' => $request->numero_nota, 'data_emissao' => $request->data_emissao, 'numero_serie' => $request->numero_serie, 'chave' => $request->chave, 'url_nota' => $request->url_nota]);
                // Alterando status caso solicitado
                if($request->alterar_status == 'on'){
                    $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 5]);
                    Pedidos::where('id', $id)->update(['id_status' => $status->id]);
                }
            }else{
                 $dados = PedidosNotas::create(['numero_nota' => $request->numero_nota, 'data_emissao' => $request->data_emissao, 'numero_serie' => $request->numero_serie, 'chave' => $request->chave, 'url_nota' => $request->url_nota]);
                  Pedidos::where('id', $id)->update(['id_nota' => $dados->id]);
                  // Alterando status caso solicitado
                if($request->alterar_status == 'on'){
                    $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 5]);
                    Pedidos::where('id', $id)->update(['id_status' => $status->id]);
                }
            }
            $nota = PedidosNotas::where('id', $pedido->id_nota)->first();
            return response()->json($nota);
        }else{
            return redirect(route('permission'));
        }
    }

    // Atualizar Endereço
    public function AtualizarEndereco(Request $request, $id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            // Retorno dos dados do pedido
            $pedido = Pedidos::where('id', $id)->first();
            // Atualização do endereço do cliente
            $endereco = Enderecos::where('id_cliente', $pedido->id_cliente)->update(['rua' => $request->endereco, 'bairro' => $request->bairro, 'numero' => $request->numero, 'complemento' => $request->complemento, 'cep' => str_replace("-", "",$request->cep),'destinatario' => $request->destinatario, 'cidade' => $request->cidade, 'estado' => $request->estado ]);
            $endereco = Enderecos::where('id_cliente', $pedido->id_cliente)->first();
            return response()->json($endereco);
        }else{
            return redirect(route('permission'));
        }
    }

    // Atualizar Rastreamento
    public function AtualizarRastreamento(Request $request, $id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            // Retorno dos dados do pedido
            $pedido = Pedidos::where('id', $id)->first();
            // Atualização dados de rastreamento
            $endereco = PedidosRastreamento::where('id', $pedido->id_rastreamento)->update(['cod_rastreamento' => $request->cod_rastreamento, 'link_rastreamento' => $request->link_rastreamento]);
            // Alterando status caso solicitado
            if($request->alterar_status){
                    $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 7]);
                    Pedidos::where('id', $id)->update(['id_status' => $status->id]);
                }
            $rastreamento = PedidosRastreamento::where('id', $pedido->id_rastreamento)->first();
            return $rastreamento;
        }else{
            return redirect(route('permission'));
        }
    }

    // Cancelar transação
    public function CancelarTransacao($id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            // Retornando informações da transação
            $dados = ConfigCheckout::first();
            $pagarme = new PagarMe\Client($dados->api_key);
            $transactions = $pagarme->transactions()->refund(['id' => $id]);
            return response()->json(['success' => true]);
        }else{
            return redirect(route('permission'));
        }
    }


    // Dados de determinado CEP
    public function DadosCorreios($cep){
        return Correios::rastrear(str_replace('-', '', $cep));
    }
    // Calculo do valo do frete
    public function CalculoFrete($id, $cep){
        // Retorno dos dados do pedido
        $pedido = Pedidos::where('id', $id)->first();
        $dados = [
        'tipo'              => 'sedex, pac', // Separar opções por vírgula (,) caso queira consultar mais de um (1) serviço. > Opções: `sedex`, `sedex_a_cobrar`, `sedex_10`, `sedex_hoje`, `pac`, 'pac_contrato', 'sedex_contrato' , 'esedex'
        'formato'           => 'caixa', // opções: `caixa`, `rolo`, `envelope`
        'cep_destino'       => '39510000', // Obrigatório
        'cep_origem'        => '89062080', // Obrigatorio
        //'empresa'         => '', // Código da empresa junto aos correios, não obrigatório.
        //'senha'           => '', // Senha da empresa junto aos correios, não obrigatório.
        'peso'              => $pedido->RelationProduto->peso, // Peso em kilos
        'comprimento'       => $pedido->RelationProduto->comprimento, // Em centímetros
        'altura'            => $pedido->RelationProduto->altura, // Em centímetros
        'largura'           => $pedido->RelationProduto->largura, // Em centímetros
        //'diametro'          => '0', // Em centímetros, no caso de rolo
        // 'mao_propria'       => '1', // Náo obrigatórios
        // 'valor_declarado'   => '1', // Náo obrigatórios
        // 'aviso_recebimento' => '1', // Náo obrigatórios
    ];
        return Correios::cep($pedido->RelationEndereco->cep);
    }


    public function ListaFiltro(Request $request){
        $dados = Pedidos::WhereNotNull('transacao_pagarme')->get();
        $retorno = [];
        $hoje = Carbon::now();
        $hoje->hour = 0;
        $hoje->minute = 0;
        $hoje->second = 0;
        foreach ($dados as $key => $value) {
            $insere = true;
            if($request->atualizacao){
                $data = Carbon::createFromFormat('Y-m-d', $value->updated_at);
                $data->hour = 0;
                $data->minute = 0;
                $data->second = 0;
                switch($requst->atualizacao){
                    case 'hoje':
                        if(!$data->isToday())
                            $insere = false;
                        break;
                    case 'ontem':
                        if(!$data->isYesterday())
                            $insere = false;
                        break;
                    case 'mes_atual':
                        if(!$data->isSameMonth($hoje))
                            $insere = false;
                        break;
                    case 'mes_passado':
                        $data->subMonth();
                        if(!$data->isSameMonth($hoje))
                            $insere = false;
                        $data->addMonth();
                        break;
                }
            }
            //if($request->cancelamento)
            //    if($request->cancelamento != $value->cancelamento)
            //        $insere = false;
            if($request->criacao){
                $data = Carbon::createFromFormat('Y-m-d', $value->created_at);
                $data->hour = 0;
                $data->minute = 0;
                $data->second = 0;
                switch($requst->criacao){
                    case 'hoje':
                        if(!$data->isToday())
                            $insere = false;
                        break;
                    case 'ontem':
                        if(!$data->isYesterday())
                            $insere = false;
                        break;
                    case 'mes_atual':
                        if(!$data->isSameMonth($hoje))
                            $insere = false;
                        break;
                    case 'mes_passado':
                        $data->subMonth();
                        if(!$data->isSameMonth($hoje))
                            $insere = false;
                        $data->addMonth();
                        break;
                }
            }
            //if($request->pagamento)
            //    if($request->pagamento != $value->pagamento)
            //        $insere = false;
            //if($request->previsao)
            //    if($request->previsao != $value->previsao)
            //        $insere = false;
            //if($request->formaEntrega)
            //    if($request->formaEntrega != $value->formaEntrega)
            //        $insere = false;
            if($request->formaPagamento)
                if($request->formaPagamento != $value->id_forma_pagamento)
                    $insere = false;
            //if($request->origens)
            //    if($request->origens != $value->origens)
            //        $insere = false;
            //if($request->produtos)
            //    if($request->produtos != $value->produtos)
            //        $insere = false;
            if($request->status)
                if($request->status != $value->id_status)
                    $insere = false;
            //if($request->usuarios)
            //    if($request->usuarios != $value->usuarios)
            //        $insere = false;
            if($insere){
                $aux = $dados[$key];
                $aux->transacao = '<div><b>'.$aux->transacao_pagarme.'</b></div><div>'.($aux->id_forma_pagamento == 1 ? '<img data-v-a542e072="" src="http://download.seaicons.com/icons/iconsmind/outline/512/Credit-Card-3-icon.png" width="30" class="uk-float-left icon-payment">' : '<img data-v-a542e072="" src="https://github.bubbstore.com/svg/billet.svg" width="40" class="uk-float-left icon-payment">').'</div>';
                $aux->cliente = '<div><a href="'.route('pedidos.detalhe', $aux->id).'" class="n_pedido text-decoration-none">'.$aux->codigo.'<p class="nome_pedido mb-0">'.$aux->RelationCliente['nome'].'</p></a></div>';
                $aux->data_pedido = date_format($aux->created_at, "d/m/Y H:i:s");
                $aux->valor = 'R$ '.number_format($aux->valor_compra, 2, ',', '.');
                $aux->status = '<div class="badge badge-'.($aux->RelationStatus->first()['posicao']==1 ? 'warning' : ($aux->RelationStatus->first()['posicao']==2 || $aux->RelationStatus->first()['posicao']==7 ? 'primary' : ($aux->RelationStatus->first()['posicao']==3 || $aux->RelationStatus->first()['posicao']==8 ? 'success' : ($aux->RelationStatus->first()['posicao']==4 ? 'info' : ($aux->RelationStatus->first()['posicao']==5 ? 'secondary' : ($aux->RelationStatus->first()['posicao']==6 ? 'success' : ($aux->RelationStatus->first()['posicao']==9 ? 'danger' : ''))))))).'">'.strtoupper($aux->RelationStatus->first()['nome']).'</div>';
                $aux->entrega = '<div class="text-'.(isset($aux->RelationRastreamento->cod_rastreamento) ? 'success' : 'danger').'"><a '.(isset($aux->RelationRastreamento->cod_rastreamento) ? 'href="http://www.websro.com.br/correios.php?P_COD_UNI='.$aux->RelationRastreamento->cod_rastreamento.'"' : '').' data-v-a542e072="" target="_blank" disabled="disabled" class="action-link holder-tooltip"><i data-v-a542e072="" class="fas fa-truck"></i> <span data-v-a542e072="" uk-tooltip="title: Rastrear pedido; pos: top; animation: none; cls: uk-active copy darker" class="tooltip" title="" aria-expanded="false"></span></a></div>';
                $retorno[] = $aux;
            }
        }
        return response()->json($retorno);
    }
}