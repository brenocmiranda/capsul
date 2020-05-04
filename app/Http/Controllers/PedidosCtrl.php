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
use App\ConfigGeral;
use Carbon\Carbon;

class PedidosCtrl extends Controller
{   
    public function __construct(){
        $this->checkout = ConfigCheckout::first();
        $this->geral = ConfigGeral::first();
        $this->pagarme = new PagarMe\Client($this->checkout->api_key);
        $this->middleware('auth');
    }
    
    // Lista pedidos
    public function Exibir(){
        if(Auth::user()->RelationGrupo->visualizar_pedidos == 1 || Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            $pedidos = Pedidos::WhereNotNull('transacao_pagarme')->count();
            $status = Status::all();
            $formas = FormaPagamentos::all();
            return view('pedidos.lista')->with('formaPagamentos', $formas)->with('status', $status)->with('pedidos', $pedidos);
        }else{
            return redirect(route('permission'));
        }
    }
    public function Lista(){
        return datatables()->of(Pedidos::WhereNotNull('transacao_pagarme')->orderBy('created_at', 'DESC')->get())
                    ->editColumn('transacao', function(Pedidos $dados){ 
                        return '<div>'.($dados->id_forma_pagamento == 1 ? '<img data-v-a542e072="" src="http://download.seaicons.com/icons/iconsmind/outline/512/Credit-Card-3-icon.png" width="30" class="uk-float-left icon-payment">' : '<img data-v-a542e072="" src="https://github.bubbstore.com/svg/billet.svg" width="40" class="uk-float-left icon-payment">').'</div>';
                    })->editColumn('cliente', function(Pedidos $dados){
                        return '<div class="text-left"><a href="'.route('pedidos.detalhes', $dados->id).'" class="nome text-decoration-none m-0">'.$dados->codigo.'<p class="mb-0 text-capitalize text-dark">'.strtolower($dados->RelationCliente['nome']).'</p></a></div>';
                    })->editColumn('data', function(Pedidos $dados){
                        return '<div class="text-left">'.date_format($dados->created_at, "d/m/Y H:i:s").'</div><div class="text-left font-weight-bold">'.$dados->created_at->subMinutes(2)->diffForHumans().'</div>';
                    })->editColumn('valor', function(Pedidos $dados){
                        return 'R$ '.number_format( ($dados->valor_compra - $dados->desconto_aplicado + $dados->RelationRastreamento->valor_envio) , 2, ',', '.');
                    })->editColumn('status', function(Pedidos $dados){
                        return '<div class="status badge badge-'.($dados->RelationStatus->last()->posicao==1 || $dados->RelationStatus->last()->posicao==7 ? 'dark' :
                    ($dados->RelationStatus->last()->posicao==2 || $dados->RelationStatus->last()->posicao==6 || $dados->RelationStatus->last()->posicao==8 ? 'warning' : 
                    ($dados->RelationStatus->last()->posicao==3 || $dados->RelationStatus->last()->posicao==5 || $dados->RelationStatus->last()->posicao==9 ? 'success' :
                    ($dados->RelationStatus->last()->posicao==4 || $dados->RelationStatus->last()->posicao==10 ? 'danger' :  '')))).'">'.strtoupper($dados->RelationStatus->last()['nome']).'</div>';
                    })->editColumn('status1', function(Pedidos $dados){
                        return $dados->RelationStatus->last()->posicao;
                    })->editColumn('acoes', function(Pedidos $dados){
                        return '<div class="dropdown">
                        <button class="btn btn-outline-secondary shadow-none dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-cog mdi-18px"> </i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#"><i class="mdi mdi-printer px-1"></i> Imprimir pedido</a>
                            <a class="dropdown-item" href="#"><i class="mdi mdi-file-alert-outline px-1"></i> Declaração de conteúdo</a>
                        </div>
                    </div>';
                    })->rawColumns(['transacao', 'cliente', 'data', 'valor', 'status', 'acoes'])->make(true);
    }
    
    // Detalhes do pedido
    public function Detalhes($id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            $pedido = Pedidos::find($id);
            $pedidos = Pedidos::where('id_cliente', $pedido->id_cliente)->WhereNotNull('transacao_pagarme')->where('id', '<>', $id)->orderBy('created_at', 'desc')->paginate(6);
            $status = Status::all();
            $statusPedido = PedidosStatus::where('id_pedido', $id)->get();
            // Retornando informações da transação
            $transactions = $this->pagarme->transactions()->get(['id' => $pedido->transacao_pagarme]);
            // Movimentação entrega correios
            if(isset($pedido->RelationRastreamento->cod_rastreamento)){
                $correios = Correios::rastrear($pedido->RelationRastreamento->cod_rastreamento);
            }else{
                $correios = null;            
            }
            return view('pedidos.detalhes')->with('pedido', $pedido)->with('status', $status)->with('transactions', $transactions)->with('statusPedido', $statusPedido)->with('correios', $correios)->with('pedidos', $pedidos);
        }else{
            return redirect(route('permission'));
        }
    }

    // Atualizar status
    public function AtualizarStatus(Request $request, $id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            PedidosStatus::create(['id_pedido' => $id, 'id_status' => $request->id_status, 'observacoes' => $request->observacoes]);
            return response()->json(['success' => true]);   
        }else{
            return redirect(route('permission'));
        }  
    }

    // Atualizar Nota fiscal
    public function AtualizarNota(Request $request, $id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            // Retorno dos dados do pedido
            $pedido = Pedidos::find($id);
            // Verificações de existencia de nota
            if(isset($pedido->id_nota)){
                PedidosNotas::find($pedido->id_nota)->update(['numero_nota' => $request->numero_nota, 'data_emissao' => $request->data_emissao, 'numero_serie' => $request->numero_serie, 'chave' => $request->chave, 'url_nota' => $request->url_nota]);
                // Alterando status caso solicitado
                if($request->alterar_status == 'on'){
                    $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 7]);
                }
            }else{
                $dados = PedidosNotas::create(['numero_nota' => $request->numero_nota, 'data_emissao' => $request->data_emissao, 'numero_serie' => $request->numero_serie, 'chave' => $request->chave, 'url_nota' => $request->url_nota]);
                Pedidos::where('id', $id)->update(['id_nota' => $dados->id]);
                if($request->alterar_status == 'on'){
                    $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 7]);
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
            $pedido = Pedidos::find($id);
            $endereco = Enderecos::find($pedido->id_endereco)->update(['endereco' => $request->endereco, 'bairro' => $request->bairro, 'numero' => $request->numero, 'complemento' => $request->complemento, 'cep' => str_replace("-", "",$request->cep),'destinatario' => $request->destinatario, 'cidade' => $request->cidade, 'estado' => $request->estado]);
        }else{
            return redirect(route('permission'));
        }
    }

    // Atualizar Rastreamento
    public function AtualizarRastreamento(Request $request, $id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            $pedido = Pedidos::find($id);
            $endereco = PedidosRastreamento::where('id', $pedido->id_rastreamento)->update(['cod_rastreamento' => $request->cod_rastreamento, 'link_rastreamento' => $request->link_rastreamento]);
            if($request->alterar_status){
                $status = PedidosStatus::create(['id_pedido' => $id, 'id_status' => 8]);
            }
        }else{
            return redirect(route('permission'));
        }
    }

    // Cancelar transação
    public function CancelarTransacao($id){
        if(Auth::user()->RelationGrupo->gerenciar_pedidos == 1){
            // Retornando informações da transação
            $transactions = $this->pagarme->transactions()->refund(['id' => $id]);
            $pedido = Pedidos::where('transacao_pagarme', $id)->first();
            PedidosStatus::create(['id_pedido' => $pedido->id, 'id_status' => 10]);
            return response()->json(['success' => true]);
        }else{
            return redirect(route('permission'));
        }
    }

    // Imprimir pedido
    public function Imprimir($id){
        $pedido = Pedidos::find($id);
        $transactions = $this->pagarme->transactions()->get(['id' => $pedido->transacao_pagarme]);
        return view('pedidos.imprimir')->with('pedido', $pedido)->with('transactions', $transactions)->with('geral', $this->geral);
    }

    // Declaração de conteúdo
    public function Declaracao($id){
        $pedido = Pedidos::find($id);
        return view('pedidos.declaracao')->with('pedido', $pedido)->with('geral', $this->geral);
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
                $aux->cliente = '<div><a href="'.route('pedidos.detalhes', $aux->id).'" class="n_pedido text-decoration-none">'.$aux->codigo.'<p class="nome_pedido mb-0">'.$aux->RelationCliente['nome'].'</p></a></div>';
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