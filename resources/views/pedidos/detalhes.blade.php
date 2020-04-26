@extends('template.index')

@section('title')
Detalhes do Pedido #{{$pedido->id}}
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Pedido: #{{$pedido->id}}</h1>
                <small class="px-2">em {{ date_format($pedido->created_at, "d/m/Y") }} às {{ date_format($pedido->created_at, "H:i:s") }}</small>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('pedidos.lista') }}">Pedidos</a></div>
                    <div class="breadcrumb-item">Detalhes</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="mb-3 d-flex px-1">
                <div id="statusAtual" class="my-auto status badge badge-{{($pedido->RelationStatus->last()['posicao']==1 ? 'warning' :
                    ($pedido->RelationStatus->last()['posicao']==2 || $pedido->RelationStatus->last()['posicao']==7 ? 'primary' : 
                    ($pedido->RelationStatus->last()['posicao']==3 || $pedido->RelationStatus->last()['posicao']==8 ? 'success' :
                    ($pedido->RelationStatus->last()['posicao']==4 ? 'info' : 
                    ($pedido->RelationStatus->last()['posicao']==5 ? 'secondary' : 
                    ($pedido->RelationStatus->last()['posicao']==6 ? 'success' : 
                    ($pedido->RelationStatus->last()['posicao']==9 ? 'danger' : '')))))))}}">{{strtoupper($pedido->RelationStatus->last()['nome'])}}
                </div>
                <div class="my-auto">
                    @if(!($pedido->RelationStatus->last()['posicao']==9))
                    <a href="javascript:"data-toggle="modal" data-target="#modal-status" class="f14 ml15 ml-4">Atualizar status</a>
                    @endif
                </div>
                <div class="ml-auto">
                    <div class="dropdown">
                      <button class="btn btn-outline-secondary btn-lg shadow-none dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#"><i class="fa fa-print px-1"></i> Imprimir pedido</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-file-alt px-1"></i> Declaração de conteúdo</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-share-square px-1"></i> Exportar para...</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <div class="col-12">
                    <div class="row">
                        <div class="col-3 cliente p-4">
                            <h1 class="resumo_title">Cliente</h1><br>
                            <div class="mt-2">
                                <label class="text-truncate mb-0 d-block"><a href="{{route('clientes.editar', $pedido->id_cliente)}}" class="text-decoration-none text-capitalize">{{strtolower($pedido->RelationCliente['nome'])}}</a></label>
                                <label class="d-block">{{$pedido->RelationCliente['email']}}</label>
                                <label class="d-block mb-0"><i class="fab fa-whatsapp text-success"></i><a target="_blank" href="https://api.whatsapp.com/send?phone={{$pedido->RelationTelefones['numero']}}" class="text-decoration-none"> {{str_replace('+55', '0' , $pedido->RelationTelefones['numero'])}}</a></label>
                                <label class="d-block mb-0"><b>{{($pedido->RelationCliente['tipo'] == 'pf' ? 'CPF:' : 'CNPJ:')}}</b> {{$pedido->RelationCliente['documento']}}</label>
                                <label class="d-block mb-0"><b>IP da compra:</b> {{ $transactions->ip }}</label>
                            </div>
                        </div>
                        <div class="col-3 pagamento p-4">
                            <h1 class="resumo_title">Pagamento</h1><br>
                            <div class="mt-2">
                                @if($pedido->id_forma_pagamento == 1)
                                <img data-v-a542e072="" src="http://download.seaicons.com/icons/iconsmind/outline/512/Credit-Card-3-icon.png" width="30" class="uk-float-left icon-payment mr-2">
                                <span class="h-100 mt-auto font-weight-bold" style="font-size: 15px !important;">{{ strtoupper($transactions->card_brand) }}</span>
                                <div>
                                    <p class="mb-0 pt-2" style="line-height: 20px;">{{ substr($transactions->card->first_digits,0,4) }}********{{ $transactions->card->last_digits }} </p>
                                    <h5 class="mb-0 pt-2">R$ {{ number_format($pedido->valor_compra,2, ",", ".") }}</h5> 
                                    <label class="font-weight-bold">em {{$transactions->installments}}x de R$ {{number_format( ($pedido->valor_compra/$transactions->installments),2, ",", ".") }}</label> 
                                </div>
                                @else
                                <img data-v-a542e072="" src="https://github.bubbstore.com/svg/billet.svg" width="40" class="uk-float-left icon-payment">
                                <div>
                                    <h4>Boleto bancário</h4>
                                    <a class="d-block" href="{{$pedido->link_boleto}}" target="_blank"><i class="fa fa-eye mr5"></i> Ver boleto</a>
                                    <a class="btn btn-outline-light my-2 p-0 px-4 text-success" href="https://api.whatsapp.com/send?phone={{$pedido->RelationTelefones['numero']}}&amp;text=Aqui está o boleto do produto *{{$pedido->RelationProduto->nome}}*, no valor de R$ {{number_format($pedido->RelationProduto->preco_venda,2, ',', '.') }}%0a%0aVencimento: *{{date('d/m/Y', strtotime($transactions->boleto_expiration_date))}}*%0a%0aCódigo de barras: *{{$transactions->boleto_barcode}}*%0a%0aLink: {{$pedido->link_boleto}}" target="_blank"><i class="fab fa-whatsapp"></i> Enviar no WhatsApp</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-3 entrega p-4">
                            <h1 class="resumo_title">Entrega</h1>
                            <a data-v-0a221458="" href="javascript:" class="entrega_edit" data-toggle="modal" data-target="#modal-endereco"><i data-v-0a221458="" class="fa fa-pencil-alt f12 mr5"></i> Editar</a><br>
                            <div class="mt-2">
                                <label class="d-block mb-0"><b id="destinatario">{{$pedido->RelationEndereco['destinatario']}}</b></label>
                                <label class="d-block mb-0" id="endereco">{{$pedido->RelationEndereco['rua'].', '.$pedido->RelationEndereco['numero'].', '.$pedido->RelationEndereco['complemento'].', '.$pedido->RelationEndereco['bairro'] }}</label>
                                <label class="d-block mb-0" id="cidade">{{$pedido->RelationEndereco['cidade']}} / {{$pedido->RelationEndereco['estado']}}</label>
                                <label class="d-block mb-0" id="cepAT">CEP: <b>{{$pedido->RelationEndereco['cep']}}</b></label>
                                <br>
                                <label class="d-block mb-0">*Prazo: 10 dias</label>
                                <label class="d-block mb-0">*Data prevista: 26/12/2019</label>
                            </div>
                        </div>
                        <div class="col-3 valor px-4 border-right border-top border-bottom">
                            <h1 class="resumo_title mt-4">Valor total</h1><br>
                            <div class="mt-2">
                                <h3 class="font-weight-bold">R$ {{ number_format($pedido->valor_compra,2, ",", ".") }}</h3>
                                <div class="mt-4 row col">
                                    <div>
                                        <p>Produtos: </p>
                                        @if($pedido->id_forma_pagamento == 1)
                                        <p>Juros: </p>
                                        @endif
                                        <p>Desconto: </p>
                                        <p>Frete:</p>
                                    </div>
                                    <div class="px-4">
                                        <p>R$ {{ number_format($pedido->RelationProduto['preco_venda'],2, ",", ".")}}</p>
                                        @if($pedido->id_forma_pagamento == 1)
                                        <p>R$ 20,00*</p>
                                        @endif
                                        <p class="text-danger">R$ {{ (isset($pedido->desconto_aplicado) ? number_format($pedido->desconto_aplicado, 2, ",", ".") : '0,00')}}</p>
                                        <p>R$ 20,00*</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="nav nav-pills nav-fill pb-3" id="myTab" role="tablist">
            <li class="nav-item px-1">
                <a class="nav-link active" id="resumo-tab" data-toggle="tab" href="#resumo" role="tab" aria-controls="resumo" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">RESUMO</font></font></a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" id="transacoes-tab" data-toggle="tab" href="#transacoes" role="tab" aria-controls="transacoes" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">TRANSAÇÕES</font></font></a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" id="nota-tab" data-toggle="tab" href="#nota" role="tab" aria-controls="nota" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">NOTA FISCAL</font></font></a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" id="rastreamento-tab" data-toggle="tab" href="#rastreamento" role="tab" aria-controls="rastreamento" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">RASTREAMENTO</font></font></a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" id="status-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">STATUS</font></font></a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" id="historico-tab" data-toggle="tab" href="#historico" role="tab" aria-controls="historico" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">HISTÓRICO</font></font></a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" id="emails-tab" data-toggle="tab" href="#emails" role="tab" aria-controls="emails" aria-selected="false"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">E-MAILS</font></font></a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="resumo" role="tabpanel" aria-labelledby="resumo-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="row text-center">
                                @if($pedido->RelationStatus->last()['posicao'] != 9)
                                <div class="col-2 lin_resume">
                                    @if($pedido->RelationStatus->last()['posicao'] >= 1 || $pedido->RelationStatus->last()['posicao'] >= 2)
                                    <div class="lin_1 progress-status"></div>
                                    <div class="holder-icon">
                                        <i class="icon-check fa fa-check"></i>
                                    </div>
                                    @else
                                    <div class="lin_1"></div>
                                    <div class="holder-icon-no">
                                        <i class="icon-check fa fa-check"></i>
                                    </div>
                                    @endif
                                    <p>Aguardando pagamento</p>
                                </div>
                                <div class="col-2 lin_resume">
                                   @if($pedido->RelationStatus->last()['posicao'] >= 3)
                                   <div class="lin_1 progress-status"></div>
                                   <div class="holder-icon">
                                    <i class="icon-check fa fa-check"></i>
                                </div>
                                @else
                                <div class="lin_1"></div>
                                <div class="holder-icon-no">
                                    <i class="icon-check fa fa-check"></i>
                                </div>
                                @endif
                                <p>Pagamento aprovado</p>
                            </div>
                            <div class="col-2 lin_resume">
                               @if($pedido->RelationStatus->last()['posicao'] >= 4)
                               <div class="lin_1 progress-status"></div>
                               <div class="holder-icon">
                                <i class="icon-check fa fa-check"></i>
                            </div>
                            @else
                            <div class="lin_1"></div>
                            <div class="holder-icon-no">
                                <i class="icon-check fa fa-check"></i>
                            </div>
                            @endif
                            <p>Produtos em separação</p>
                        </div>
                        <div class="col-2 lin_resume">

                           @if($pedido->RelationStatus->last()['posicao'] >= 5 || $pedido->RelationStatus->last()['posicao'] >= 6)
                           <div class="lin_1 progress-status"></div>
                           <div class="holder-icon">
                            <i class="icon-check fa fa-check"></i>
                        </div>
                        @else
                        <div class="lin_1"></div>
                        <div class="holder-icon-no">
                            <i class="icon-check fa fa-check"></i>
                        </div>
                        @endif
                        <p>Faturado</p>
                    </div>
                    <div class="col-2 lin_resume">
                       @if($pedido->RelationStatus->last()['posicao'] >= 7)
                       <div class="lin_1 progress-status"></div>
                       <div class="holder-icon">
                        <i class="icon-check fa fa-check"></i>
                    </div>
                    @else
                    <div class="lin_1"></div>
                    <div class="holder-icon-no">
                        <i class="icon-check fa fa-check"></i>
                    </div>
                    @endif
                    <p>Produtos em transporte</p>
                </div>
                <div class="col-2 lin_resume">
                   @if($pedido->RelationStatus->last()['posicao'] >= 8)
                   <div class="lin_1 progress-status"></div>
                   <div class="holder-icon">
                    <i class="icon-check fa fa-check"></i>
                </div>
                @else
                <div class="lin_1"></div>
                <div class="holder-icon-no">
                    <i class="icon-check fa fa-check"></i>
                </div>
                @endif
                <p>Entregue</p>
            </div>
            @else
            <div class="text-left alert alert-danger col-12 py-1"> Essa compra está cancelada, para mais informações entre em contato com o administrador.</div>
            @endif
        </div>
        <hr>
        <section id="lin_1">
            <h5>Produtos: 1</h5>
            <div class="card-body px-0">
                <div class="table-responsive text-center">
                    <table class="table-striped table">
                        <tbody>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor unitário</th>
                            <th>Subtotal</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="row text-left">
                                    <div class="px-3 my-auto">
                                        <img src="{{ url('storage/app/'.$pedido->RelationProduto->RelationImagens->last()['caminho'])}}" alt="Imagem atual" style="height: auto; width: 70px;" class="py-2 border rounded">
                                    </div>
                                    <div class="px-3">
                                        <a href="{{ route('produtos.editar', $pedido->RelationProduto->id) }}" class="text-decoration-none">
                                            <p class="n_pedido my-auto not-espaco"><b>{{$pedido->RelationProduto->nome}}</b></p>
                                        </a>
                                        <label>{{$pedido->RelationProduto->cod_sku}}</label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <label>1</label>
                            </td>
                            <td>
                                <label>R$ {{ number_format($pedido->RelationProduto['preco_venda'],2, ",", ".") }}</label>
                            </td>
                            <td>
                                <label>R$ {{ number_format($pedido->RelationProduto['preco_venda'],2, ",", ".") }}</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
</div>
</div>
</div>

<div class="tab-pane fade" id="transacoes" role="tabpanel" aria-labelledby="transacoes-tab">
    <div class="card">
        <div class="card-body">
            <div class="col-12 border rounded p-4">
                <div class="pb-3 d-flex">
                    <label style="font-size: 18px !important;">Transação <b>#{{$transactions->id}}</b></label>
                    <div class="icon-pagarme ml-auto my-2 mx-3"></div>
                </div>
                <div>
                    <div class="py-2 col">
                        @if($pedido->id_forma_pagamento == 1)
                        <img data-v-a542e072="" src="http://download.seaicons.com/icons/iconsmind/outline/512/Credit-Card-3-icon.png" width="45" class="border rounded icon-payment mr-2 p-2">
                        <span class="h-100 my-auto font-weight-bold" style="font-size: 18px !important;">{{ strtoupper($transactions->card_brand) }}</span>
                        <div class="py-3">
                            <p class="mb-0" style="line-height: 20px;">{{ substr($transactions->card->first_digits,0,4) }}********{{ $transactions->card->last_digits }} </p>
                            <p class="mb-0" style="line-height: 20px;">Titular do cartão: <span><b>{{ strtoupper($transactions->card_holder_name) }}</b></span></p>
                            <p class="mb-0" style="line-height: 20px;">Documento do titular: <span><b>{{ $pedido->RelationCliente->documento }}</b></span></p>
                        </div>
                        <div class="">
                            <h3>R$ {{ number_format($pedido->valor_compra,2, ",", ".") }}</h3> 
                            <h6 class="f15">em {{$transactions->installments}}x de {{number_format( ($pedido->valor_compra/$transactions->installments),2, ",", ".") }}</h6> 
                        </div>
                        <div class="transaction_status mt10 f11 bold">
                            <div class="my-auto status badge badge-{{($transactions->status == 'processing' || $transactions->status == 'waiting_payment' ? 'warning' : ($transactions->status == 'authorized' || $transactions->status == 'paid' ? 'success' : ($transactions->status == 'refunded' || $transactions->status ==  'pending_refund' || $transactions->status == 'refused' ? 'danger' : '')))}}">
                                {{($transactions->status == 'processing' || $transactions->status == 'waiting_payment' ? 'Pendente de pagamento' : ($transactions->status == 'authorized' || $transactions->status == 'paid' ? 'Pagamento aprovado' : ($transactions->status == 'refunded' || $transactions->status ==  'pending_refund' || $transactions->status == 'refused' ? 'Pagamento recusado' : '')))}}
                            </div>
                            <small class="font-weight-bold">em {{date('d/m/Y \á\s H:i:s', strtotime($transactions->date_created))}}</small>
                        </div>
                        @else
                        <img src="https://github.bubbstore.com/svg/billet.svg" width="45" class="border rounded icon-payment mr-2 p-2">
                        <span class="h-100 my-auto font-weight-bold" style="font-size: 18px !important;">Boleto bancário</span>
                        <div>
                            <h3 class="mt-2">R$ {{ number_format($pedido->valor_compra,2, ",", ".") }}</h3>
                        </div>
                        <div class="my-auto status badge badge-{{($transactions->status == 'processing' || $transactions->status == 'waiting_payment' ? 'warning' : ($transactions->status == 'authorized' || $transactions->status == 'paid' ? 'success' : ($transactions->status == 'refunded' || $transactions->status ==  'pending_refund' || $transactions->status == 'refused' ? 'danger' : '')))}}">
                            {{($transactions->status == 'processing' || $transactions->status == 'waiting_payment' ? 'Pendente de pagamento' : ($transactions->status == 'authorized' || $transactions->status == 'paid' ? 'Pagamento aprovado' : ($transactions->status == 'refunded' || $transactions->status ==  'pending_refund' || $transactions->status == 'refused' ? 'Pagamento recusado' : '')))}}
                        </div>
                        <small class="font-weight-bold">em {{date('d/m/Y \á\s H:i:s', strtotime($transactions->date_created))}}</small>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="d-flex pb-3">
                    <div class="col-4">
                        <p class="mb-0">Afiliação: Pagar.me - grupocapsul</p>
                        <p class="mb-0">ID-pagar.me: <b id="transactions">{{ $transactions->id }}</b>
                            <a href="javascript:" class="copiando">
                                <i class="far fa-copy ml5"></i>
                            </a>
                        </p>
                    </div>
                    <div class="col-8 my-auto text-right">
                        <div class="buttons">
                            @if($transactions->payment_method == 'credit_card' && ($transactions->status == 'processing' || $transactions->status == 'waiting_payment' || $transactions->status == 'authorized' || $transactions->status == 'paid'))
                            <a href="#" class="btn btn-icon icon-left btn-danger" id="btn-cancelar" style="font-size: 16px !important;"><i class="fas fa-times"></i> Cancelar transação</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane fade" id="nota" role="tabpanel" aria-labelledby="nota-tab">
    <div class="card">
        <div class="card-body">
            @if($pedido->RelationStatus->last()['posicao'] == 1)
            <div class="alert alert-light">
                <div class="alert-title">
                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Esse pedido ainda não possui nota fiscal.</font></font>
                </div>
                <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Você precisa confirmar o pagamento do pedido para prosseguir com a Nota Fiscal.</font></font>
            </div>
            @elseif($pedido->RelationStatus->last()['posicao'] > 3 && $pedido->RelationStatus->last()['posicao'] < 9 && isset($pedido->RelationNotas))
            <div class="border rounded">
                <div class="valor border-0 d-flex">
                    <div class="col-6 p-4 d-block px-5">
                        <h1 class="resumo_title border-0 mb-0 d-block">NÚMERO DA NOTA</h1>
                        <h5 id="numero_nota">{{$pedido->RelationNotas->numero_nota}}</h5>
                    </div>
                    <div class="col-6 p-4">
                        <h1 class="resumo_title border-0 mb-0 d-block">DATA DE EMISSÃO</h1>
                        <h5 id="data_emissao">{{date('d/m/Y', strtotime($pedido->RelationNotas->data_emissao))}}</h5>
                    </div>
                    <hr>
                </div>
                <div class="px-5 pt-4">
                    <div>
                        <label class="d-block mb-0 not-espaco">Número de série</label>
                        <label class="font-weight-bold" id="numero_serie">{{(isset($pedido->RelationNotas->numero_serie) ? $pedido->RelationNotas->numero_serie : '-')}}</label>
                        <a href="javascript:" class="copiando">
                            <i class="far fa-copy ml5"></i>
                        </a>
                    </div>
                    <div>
                        <label class="d-block mb-0 not-espaco">Chave</label>
                        <label class="font-weight-bold" id="chave">{{(isset($pedido->RelationNotas->chave) ? $pedido->RelationNotas->chave : '-')}}</label>
                    </div>
                    <div class="d-flex">
                        <div class="">
                            <label class="d-block mb-0 not-espaco">Valor da nota</label>
                            <label class="font-weight-bold">R$ {{number_format($pedido->valor_compra,2, ",", ".")}}</label>
                        </div>
                        <div class="mx-5">
                            <label class="d-block mb-0 not-espaco">Valor dos produtos</label>
                            <label class="font-weight-bold">R$ {{number_format($pedido->RelationProduto->preco_venda,2, ",", ".")}}</label>
                        </div>
                    </div>
                    <div>
                        <label class="d-block mb-0 not-espaco">URL da Nota</label>
                        <label class="font-weight-bold" id="url_nota">{{(isset($pedido->RelationNotas->url_nota) ? $pedido->RelationNotas->url_nota : '-')}}</label>
                    </div>
                </div>
                <hr>
                <div class="col-12 text-center pb-4">
                    <a href="javascript:" class="col-3 btn btn-icon icon-left btn-outline-secondary w-100" data-toggle="modal" data-target="#modal-nota" ><i class="fas fa-edit"></i> Editar</a>
                </div>
            </div>
            @else
            <div class="alert alert-light">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">Não é possível inserir nota fiscal nesse pedido.</font>
                </font>
            </div>
            <div class="col-12 text-center">
                @if($pedido->RelationStatus->last()['posicao'] > 2 && $pedido->RelationStatus->last()['posicao'] < 9)
                <hr>
                <a href="javascript:" class="col-3 btn btn-icon icon-left btn-outline-secondary w-100" data-toggle="modal" data-target="#modal-nota" ><i class="fas fa-plus"></i> Adicionar</a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

<div class="tab-pane fade" id="rastreamento" role="tabpanel" aria-labelledby="rastreamento-tab">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="d-flex col-12">
                    <div class="col-6 border rounded p-4" style="height: 234px;">
                       <p class="mb-0">Forma de entrega</p>
                       <label class="text-uppercase font-weight-bold">{{(isset($pedido->RelationRastreamento->tipo) ? $pedido->RelationRastreamento->tipo : "Frete") }}</label>

                       <p class="mb-0">Código de rastreamento</p> 
                       <label id="cod_ratreamento" class="font-weight-bold">{{(isset($pedido->RelationRastreamento->cod_rastreamento) ? $pedido->RelationRastreamento->cod_rastreamento : "Não cadastrado") }}</label>

                       <p class="mb-0">Link de rastreamento</p> 
                       <label id="link_rastreamento" class="font-weight-bold">{{(isset($pedido->RelationRastreamento->link_rastreamento) ? $pedido->RelationRastreamento->link_rastreamento : "Não cadastrado") }}</label>
                   </div>
                   <div class="col-6">
                    @if(isset($correios))
                    <div class="table-responsive px-4 pt-3 rounded valor border">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>DATA/HORA</th>
                                    <th>STATUS/LOCALIDADE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($correios as $correio)
                                <tr class="border-top">
                                    <td class="align-middle">
                                        <label class="font-weight-bold">{{$correio['data']}}
                                        </label>
                                    </td>
                                    <td class="align-middle align-middle pt-3">
                                        <div class="not-espaco">
                                            <label class="font-weight-bold mb-0">
                                                {{$correio['status']}}
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                {{str_replace('<label style="text-transform:capitalize;">', '', str_replace('</label>', '', $correio['local']))}}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-light">
                        <div class="text-center">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Informações de rastreamento indisponíveis.</font>
                            </font>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 text-center">
            @if($pedido->RelationStatus->last()['posicao'] > 2 && $pedido->RelationStatus->last()['posicao'] < 9)
            <hr>
            <a href="javascript:" class="col-4 btn btn-icon icon-left btn-outline-secondary w-100" data-toggle="modal" data-target="#modal-rastreamento" ><i class="far fa-edit"></i> Editar</a>
            @endif
        </div>
    </div>
</div>
</div>

<div class="tab-pane fade" id="status" role="tabpanel" aria-labelledby="status-tab">
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">ATUALIZADO EM</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">OBSERVAÇÕES</th>
                    </tr>
                </thead>
                <tbody class="historico">
                    @foreach($historicos as $historico)
                    <tr>
                        <td class="align-middle">
                            <p class="data_pedido">{{ date_format($historico->created_at, "d/m/Y H:i:s") }}</p>
                            <p class="temp_pedido">20 minutos</p>
                        </td>
                        <td class="align-middle">
                            <div class="my-auto status badge badge-{{($historico->RelationStatus1['posicao']==1 ? 'warning' :
                                ($historico->RelationStatus1['posicao']==2 || $historico->RelationStatus1['posicao']==7 ? 'primary' : 
                                ($historico->RelationStatus1['posicao']==3 || $historico->RelationStatus1['posicao']==8 ? 'success' :
                                ($historico->RelationStatus1['posicao']==4 ? 'info' : 
                                ($historico->RelationStatus1['posicao']==5 ? 'secondary' : 
                                ($historico->RelationStatus1['posicao']==6 ? 'success' : 
                                ($historico->RelationStatus1['posicao']==9 ? 'danger' : '')))))))}}">{{strtoupper($historico->RelationStatus1['nome'])}}
                            </div>
                        </td>
                        <td class="align-middle">
                            {{(isset($historico->observacoes) ? $historico->observacoes : 'Nenhuma observação.')}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <div>
                @if(!($pedido->RelationStatus->last()['posicao']==9))
                <a href="javascript:" data-toggle="modal" data-target="#modal-status" class="btn btn-outline-secondary shadow-none col-2">Atualizar status</a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="tab-pane fade" id="historico" role="tabpanel" aria-labelledby="historico-tab">
    <div class="card">
        <div class="card-body">
            <div class="alert alert-light">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">O cliente não possui outros pedidos.</font>
                </font>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane fade" id="emails" role="tabpanel" aria-labelledby="emails-tab">
    <div class="card">
        <div class="card-body">
            <div class="alert alert-light">
                <div class="row">
                    <div class="col-2">
                        <i class="icon-mail far fa-envelope"></i>
                    </div>
                    <div class="col-6">
                        <div class="holder-left">
                            <a href="javascript:" uk-toggle="target: #modal-email" class="f15">
                                {{$pedido->RelationCliente->nome}}, falta pouco!</a> <span class="ml5 f13 grey">há <span data-v-537c2a32="">um dia</span></span>
                                <div class="f15">Para: <span class="bold">{{$pedido->RelationCliente->email}}</span></div>
                            </div>
                        </div>
                        <div class="col-4 my-auto pr-5 text-right">
                            <button type="submit" class="btn btn-outline-dark">Reenviar e-mail</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</section>
</div>
@endsection

@section('modal')
@include('pedidos.extras.endereco')
@include('pedidos.extras..status')
@include('pedidos.extras..nota')
@include('pedidos.extras..rastreamento')
@endsection

@section('support')
<script type="text/javascript">
    $(document).ready(function (){
        $('#cep').mask('00000-000');

            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {
                $(".country").html("");

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {
                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;
                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {
                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+cep+"/json/?callback=?", function(dados) {
                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $(".country").html(dados.localidade+' - '+dados.uf);
                                $("#cidade").val(dados.localidade);
                                $("#estado").val(dados.uf);

                            }else {
                                //CEP pesquisado não foi encontrado.
                                $(".country").html('<label class="text-danger"> CEP não localizado.</b>');
                            }
                        });
                    } else {
                        //cep é inválido.
                        $(".country").html("");
                        $(".country").html('<b class="text-danger">Formato de CEP inválido.</b>');
                    }
                }else {
                    //cep sem valor, limpa formulário.
                    $("#cep").val("");
                    $(".country").html("");
                }
            });

            // Atualiza status
            $('#modal-status #formStatus').on('submit', function(e){
                var table = $('#table').DataTable();
                e.preventDefault();
                $.ajax({
                    url: '{{ route("atualizar.status", $pedido->id) }}',
                    type: 'POST',
                    data: $('#modal-status #formStatus').serialize(),
                    beforeSend: function(){
                        $('#modal-status #formStatus').addClass('d-none');
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
                    },
                    success: function(data){
                        $('#modal-status #formStatus').addClass('d-none');
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check my-3" style="font-size:62px;"></i></div><h6>Status alterado com sucesso!</h6></div>');
                        setTimeout(function(){
                           location.reload();
                       }, 800);
                    }, error: function (data) {
                        setTimeout(function(){
                            $('#modal-status #formStatus').removeClass('d-none');
                            $('.carregamento').html('');
                            if(!data.responseJSON){
                                console.log(data.responseText);
                                $('#modal-status #err').html(data.responseText);
                            }else{
                                $('#modal-status #err').html('');
                                $('input').removeClass('border border-danger');
                                $.each(data.responseJSON.errors, function(key, value){
                                    $('#modal-status #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
                                    $('input[name="'+key+'"]').addClass('border border-danger');
                                });
                            }
                        }, 500);
                    }
                });
            });

            // Adicionando nota fiscal
            $('#modal-nota #formNotas').on('submit', function(e){
                var table = $('#table').DataTable();
                e.preventDefault();
                $.ajax({
                    url: '{{ route("atualizar.nota", $pedido->id) }}',
                    type: 'POST',
                    data: $('#modal-nota #formNotas').serialize(),
                    beforeSend: function(){
                        $('#modal-nota #formNotas').addClass('d-none');
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
                    },
                    success: function(data){
                        $('#modal-nota #formNotas').addClass('d-none');
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check my-3" style="font-size:62px;"></i></div><h6>Informação inserida com sucesso!</h6></div>');
                        setTimeout(function(){
                           location.reload();
                       }, 800);
                    }, error: function (data) {
                        setTimeout(function(){
                            $('#modal-nota #formNotas').removeClass('d-none');
                            $('.carregamento').html('');
                            if(!data.responseJSON){
                                console.log(data.responseText);
                                $('#modal-nota #err').html(data.responseText);
                            }else{
                                $('#modal-nota #err').html('');
                                $('input').removeClass('border border-danger');
                                $.each(data.responseJSON.errors, function(key, value){
                                    $('#modal-nota #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
                                    $('input[name="'+key+'"]').addClass('border border-danger');
                                });
                            }
                        }, 800);
                    }
                });
            });
            
            // Adicionando código de rastreamento
            $('#modal-rastreamento #formRastreamento').on('submit', function(e){
                var table = $('#table').DataTable();
                e.preventDefault();
                $.ajax({
                    url: '{{ route("atualizar.rastreamento", $pedido->id) }}',
                    type: 'POST',
                    data: $('#modal-rastreamento #formRastreamento').serialize(),
                    beforeSend: function(){
                        $('#modal-rastreamento #formRastreamento').addClass('d-none');
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
                    },
                    success: function(data){
                        $('#modal-rastreamento #formRastreamento').addClass('d-none');
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check my-3" style="font-size:62px;"></i></div><h6>Informação inserida com sucesso!</h6></div>');
                        setTimeout(function(){
                           location.reload();
                       }, 800);
                    }, error: function (data) {
                        setTimeout(function(){
                            $('#modal-rastreamento #formRastreamento').removeClass('d-none');
                            $('.carregamento').html('');
                            if(!data.responseJSON){
                                console.log(data.responseText);
                                $('#modal-rastreamento #err').html(data.responseText);
                            }else{
                                $('#modal-rastreamento #err').html('');
                                $('input').removeClass('border border-danger');
                                $.each(data.responseJSON.errors, function(key, value){
                                    $('#modal-rastreamento #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
                                    $('input[name="'+key+'"]').addClass('border border-danger');
                                });
                            }
                        }, 800);
                    }
                });
            });
            
            // Alterando endereço
            $('#modal-endereco #formEndereco').on('submit', function(e){
                var table = $('#table').DataTable();
                e.preventDefault();
                $.ajax({
                    url: '{{ route("atualizar.endereco", $pedido->id) }}',
                    type: 'POST',
                    data: $('#modal-endereco #formEndereco').serialize(),
                    beforeSend: function(){
                        $('#modal-endereco #formEndereco').addClass('d-none');
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
                    },
                    success: function(data){
                        $('#modal-endereco #formEndereco').addClass('d-none');
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check my-3" style="font-size:62px;"></i></div><h6>Informação alteradas com sucesso!</h6></div>');
                        setTimeout(function(){
                           location.reload();
                       }, 800);
                    }, error: function (data) {
                        setTimeout(function(){
                            $('#modal-endereco #formEndereco').removeClass('d-none');
                            $('.carregamento').html('');
                            if(!data.responseJSON){
                                console.log(data.responseText);
                                $('#modal-endereco #err').html(data.responseText);
                            }else{
                                $('#modal-endereco #err').html('');
                                $('input').removeClass('border border-danger');
                                $.each(data.responseJSON.errors, function(key, value){
                                    $('#modal-endereco #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
                                    $('input[name="'+key+'"]').addClass('border border-danger');
                                });
                            }
                        }, 800);
                    }
                });
            });

            $('#btn-cancelar').on('click', function(e){
                e.preventDefault();
                if(confirm("Tem certeza que deseja cancelar a transação?")){
                 $.ajax({
                    url: '{{ route("cancelar.transacao", $transactions->id) }}',
                    type: 'GET',
                    success: function(data){
                        alert("Sua transação foi cancelada com sucesso!");
                        location.reload();
                    }, error: function (data) {
                        alert("Erro! Procure o administrador.");
                    }
                });
             }
         });
            
        });
    </script>
    @endsection




