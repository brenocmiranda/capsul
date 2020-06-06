@extends('template.index')

@section('title')
Pedido #{{$pedido->codigo}}
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Pedido #{{$pedido->codigo}}</h1>
                <small class="px-2">em {{ date_format($pedido->created_at, "d/m/Y") }} às {{ date_format($pedido->created_at, "H:i:s") }}</small>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('pedidos.lista') }}">Pedidos</a></div>
                    <div class="breadcrumb-item">Detalhes</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="col-12 row m-0 mb-3">
                <div class="my-auto status badge badge-{{
                                                ($pedido->RelationStatus->last()->posicao==1 ? 'primary' :
                                                ($pedido->RelationStatus->last()->posicao==2 ? 'warning' : 
                                                ($pedido->RelationStatus->last()->posicao==3 ? 'success' :
                                                ($pedido->RelationStatus->last()->posicao==4 ? 'danger' :
                                                ($pedido->RelationStatus->last()->posicao==6 ? 'primary' :
                                                ($pedido->RelationStatus->last()->posicao==5 ? 'dark' : 
                                                ($pedido->RelationStatus->last()->posicao==7 ? 'info' : 
                                                ($pedido->RelationStatus->last()->posicao==8 ? 'success' :
                                                ($pedido->RelationStatus->last()->posicao==9 ? 'danger' : '')))))))))}}">
                    {{strtoupper($pedido->RelationStatus->last()->nome)}}
                </div>
                @if($pedido->RelationStatus->last()->posicao != 10)
                <div class="my-auto">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-status" class="ml-4">Atualizar status</a>
                </div>
                @endif
                <div class="ml-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-lg shadow-none dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span>Ações</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a href="{{route('pedidos.imprimir', $pedido->id)}}" target="_blank"  class="dropdown-item">
                                <i class="mdi mdi-printer px-1"></i> 
                                <span>Imprimir pedido</span>
                            </a>
                            <a href="{{route('pedidos.declaracao', $pedido->id)}}" target="_blank" class="dropdown-item">
                                <i class="mdi mdi-file-alert-outline px-1"></i> 
                                <span>Declaração de conteúdo</span>
                            </a>
                            @if($transactions->payment_method == 'credit_card' && ($transactions->status == 'processing' || $transactions->status == 'waiting_payment' || $transactions->status == 'authorized' || $transactions->status == 'paid'))
                            <a href="javascript:void(0)" class="dropdown-item btn-cancelar" >
                                <i class="mdi mdi-close px-1"></i> 
                                <span>Cancelar transação</span>
                            </a>
                            @endif
                            @if($pedido->RelationStatus->last()->posicao == 3 || ($pedido->RelationStatus->last()->posicao > 5 && $pedido->RelationStatus->last()->posicao < 9))
                            <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#modal-nota">
                                <i class="mdi mdi-file px-1"></i> 
                                <span>Faturar</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="row col-12 p-0 mx-auto">
                        <div class="col-3 cliente p-4">
                            <h1 class="resumo_title">Cliente</h1><br>
                            <div class="mt-2">
                                <label class="text-truncate mb-0 d-block">
                                    <a href="{{route('clientes.editar', $pedido->id_cliente)}}" class="text-decoration-none text-capitalize">
                                        <span>{{strtolower($pedido->RelationCliente['nome'])}}</span>
                                    </a>
                                </label>
                                <label class="d-block">
                                    <span>{{$pedido->RelationCliente['email']}}</span>
                                </label>
                                <label class="d-block mb-0">
                                    <i class="mdi mdi-whatsapp text-success"></i>
                                    <a target="_blank" href="https://api.whatsapp.com/send?phone={{$pedido->RelationTelefones['numero']}}" class="text-decoration-none"> 
                                        <span>{{"(".substr(str_replace("+55", "", $pedido->RelationTelefones->numero), 0, 2).") ".substr(str_replace("+55", "", $pedido->RelationTelefones->numero), 2, 5)."-".substr(str_replace("+55", "", $pedido->RelationTelefones->numero), 7, 10)}}</span>
                                    </a>
                                </label>
                                <label class="d-block mb-0">
                                    <b>{{($pedido->RelationCliente['tipo'] == 'pf' ? 'CPF:' : 'CNPJ:')}}</b> 
                                    <span>{{$pedido->RelationCliente['documento']}}</span>
                                </label>
                                <label class="d-block mb-0">
                                    <b>IP da compra:</b> 
                                    <span>{{ $pedido->ip_compra }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-3 pagamento p-4">
                            <h1 class="resumo_title">Pagamento</h1><br>
                            <div class="mt-2">
                                @if($pedido->id_forma_pagamento == 1)
                                <img src="http://download.seaicons.com/icons/iconsmind/outline/512/Credit-Card-3-icon.png" width="30" class="mr-2">
                                <span class="h-100 mt-auto font-weight-bold">
                                    {{ strtoupper($transactions->card_brand) }}
                                </span>
                                <div>
                                    <p class="mb-0 pt-2">
                                        <span>{{ substr($transactions->card->first_digits,0,4) }}********{{ $transactions->card->last_digits }} </span>
                                    </p>
                                    <h5 class="mb-0 pt-2">
                                        <span>R$ {{ number_format(($pedido->valor_compra - $pedido->desconto_aplicado + $pedido->RelationRastreamento->valor_envio),2, ",", ".") }}</span> 
                                    </h5> 
                                    <label class="font-weight-bold">
                                        <span>em {{$transactions->installments}}x de R$ {{number_format( (($pedido->valor_compra - $pedido->desconto_aplicado + $pedido->RelationRastreamento->valor_envio)/$transactions->installments),2, ",", ".") }}</span>
                                    </label> 
                                </div>
                                @else
                                <img src="https://github.bubbstore.com/svg/billet.svg" width="40">
                                <div>
                                    <h4>Boleto bancário</h4>
                                    <a class="d-block" href="{{$pedido->link_boleto}}" target="_blank">
                                        <i class="mdi mdi-eye-outline"></i> 
                                        <span>Ver boleto</span>
                                    </a>
                                    <a class="my-2 p-0 text-success" href="https://api.whatsapp.com/send?phone={{$pedido->RelationTelefones->numero}}&text=Aqui está o boleto do produto *{{$pedido->RelationProduto->nome}}*, no valor de R$ {{number_format(($pedido->valor_compra - $pedido->desconto_aplicado + $pedido->RelationRastreamento->valor_envio),2, ',', '.') }}.%0a%0aVencimento: *{{date('d/m/Y', strtotime($transactions->boleto_expiration_date))}}*%0a%0aCódigo de barras: *{{$transactions->boleto_barcode}}*%0a%0aLink: {{$pedido->link_boleto}}" target="_blank">
                                        <i class="mdi mdi-whatsapp"></i> 
                                        <span>Enviar no WhatsApp</span>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-3 entrega p-4">
                            <h1 class="resumo_title">Entrega</h1>
                            <a href="javascript:void(0)" class="entrega_edit" data-toggle="modal" data-target="#modal-endereco">
                                <i class="mdi mdi-pencil"></i>
                                <span> Editar </span>
                            </a>
                            <br>
                            <div class="mt-2">
                                <label class="d-block mb-0">
                                    <b id="destinatario">{{$pedido->RelationEndereco->destinatario}}</b>
                                </label>
                                <label class="d-block mb-0">
                                    <span>{{$pedido->RelationEndereco->endereco.', '.$pedido->RelationEndereco->numero.', '.(isset($pedido->RelationEndereco->complemento) ? $pedido->RelationEndereco->complemento.', ' : '').$pedido->RelationEndereco->bairro }}</span>
                                </label>
                                <label class="d-block mb-0">
                                    <span>{{$pedido->RelationEndereco->cidade}} / {{$pedido->RelationEndereco->estado}}</span>
                                </label>
                                <label class="d-block mb-0">
                                    <span>CEP: </span>
                                    <b>{{substr($pedido->RelationEndereco->cep, 0, 5)."-".substr($pedido->RelationEndereco->cep, 5, 7)}}</b>
                                </label>
                                <br>
                                <label class="d-block mb-0">
                                    <span>Prazo: </span>
                                    <span>{{$pedido->RelationRastreamento->prazo}}</span>
                                    <span> dias</span>
                                </label>
                                <label class="d-block mb-0">
                                    <span>Data prevista: </span>
                                    <span>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-3 valor px-4 border-right border-top border-bottom">
                            <h1 class="resumo_title mt-4">Valor total</h1><br>
                            <div class="mt-2">
                                <h3 class="font-weight-bold">
                                    <span>R$ {{ number_format(($pedido->valor_compra - $pedido->desconto_aplicado + $pedido->RelationRastreamento->valor_envio), 2, ",", ".") }}</span>
                                </h3>
                                <div class="mt-4 row col text-left">
                                    <div>
                                        <p>Produtos: </p>
                                        <p>Desconto: </p>
                                        <p>Frete:</p>
                                    </div>
                                    <div class="px-4 text-right">
                                        <p>R$ {{ number_format( ($pedido->RelationProduto->preco_venda * $pedido->quantidade), 2, ",", ".")}}</p>
                                        <p class="text-danger">R$ {{ (isset($pedido->desconto_aplicado) ? number_format($pedido->desconto_aplicado, 2, ",", ".") : '0,00')}}</p>
                                        <p>R$ {{ number_format($pedido->RelationRastreamento->valor_envio, 2, ",", ".")}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>              
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills nav-fill pb-3" id="myTab" role="tablist">
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold active" id="resumo-tab" data-toggle="tab" href="#resumo" role="tab" aria-controls="resumo" aria-selected="false">RESUMO</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold" id="transacoes-tab" data-toggle="tab" href="#transacoes" role="tab" aria-controls="transacoes" aria-selected="false">TRANSAÇÕES</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold" id="nota-tab" data-toggle="tab" href="#nota" role="tab" aria-controls="nota" aria-selected="false">NOTA FISCAL</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold" id="rastreamento-tab" data-toggle="tab" href="#rastreamento" role="tab" aria-controls="rastreamento" aria-selected="false">RASTREAMENTO</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold" id="status-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false">STATUS</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold" id="historico-tab" data-toggle="tab" href="#historico" role="tab" aria-controls="historico" aria-selected="false">HISTÓRICO</a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link font-weight-bold" id="emails-tab" data-toggle="tab" href="#emails" role="tab" aria-controls="emails" aria-selected="false">E-MAILS</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="resumo" role="tabpanel" aria-labelledby="resumo-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row text-center">
                                    @foreach($status as $todos)
                                        @if($todos->posicao != 9 && $pedido->RelationStatus->last()->posicao != 9)
                                            @if($pedido->RelationStatus->last()->posicao == 1 && $todos->posicao <= 1)
                                                <div class="col-2 lin_resume">
                                                <div class="lin_1 border-sucess"></div>
                                                <div class="holder-icon bg-sucess">
                                                    <i class="mdi mdi-check"></i>
                                                </div>
                                                <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                @if($todos->posicao == 1)
                                                    <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                @endif
                                                @if($todos->posicao == 8)
                                                    <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                @endif
                                                </div>
                                            @elseif($pedido->RelationStatus->last()->posicao == 2 && $todos->posicao <= 4)
                                                @if($todos->posicao == 1)
                                                    <div class="col-2 lin_resume">
                                                    <div class="lin_1 border-success"></div>
                                                    <div class="holder-icon bg-success">
                                                        <i class="mdi mdi-check"></i>
                                                    </div>
                                                    <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                    @if($todos->posicao == 1)
                                                        <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                    @endif
                                                    @if($todos->posicao == 8)
                                                        <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                    @endif
                                                    </div>
                                                @elseif($todos->posicao != 3 && $todos->posicao != 4)
                                                    <div class="col-2 lin_resume">
                                                    <div class="lin_1 border-warning"></div>
                                                    <div class="holder-icon bg-warning">
                                                        <i class="mdi mdi-information-variant"></i>
                                                    </div>
                                                    <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                    @if($todos->posicao == 1)
                                                        <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                    @endif
                                                    @if($todos->posicao == 8)
                                                        <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                    @endif
                                                    </div>
                                                @endif
                                            @elseif($pedido->RelationStatus->last()->posicao == 3 && $todos->posicao <= 4)
                                                @if($todos->posicao == 1)
                                                    <div class="col-2 lin_resume">
                                                    <div class="lin_1 border-success"></div>
                                                    <div class="holder-icon bg-success">
                                                        <i class="mdi mdi-check"></i>
                                                    </div>
                                                    <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                    @if($todos->posicao == 1)
                                                        <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                    @endif
                                                    @if($todos->posicao == 8)
                                                        <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                    @endif
                                                    </div>
                                                @elseif($todos->posicao != 2 && $todos->posicao != 4)
                                                    <div class="col-2 lin_resume">
                                                    <div class="lin_1 border-success"></div>
                                                    <div class="holder-icon bg-success">
                                                        <i class="mdi mdi-check"></i>
                                                    </div>
                                                    <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                    @if($todos->posicao == 1)
                                                        <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                    @endif
                                                    @if($todos->posicao == 8)
                                                        <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                    @endif
                                                    </div>
                                                @endif
                                            @elseif($pedido->RelationStatus->last()->posicao == 4 && $todos->posicao <= 4)
                                                @if($todos->posicao == 1)
                                                    <div class="col-2 lin_resume">
                                                    <div class="lin_1 border-success"></div>
                                                    <div class="holder-icon bg-success">
                                                        <i class="mdi mdi-check"></i>
                                                    </div>
                                                    <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                    @if($todos->posicao == 1)
                                                        <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                    @endif
                                                    @if($todos->posicao == 8)
                                                        <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                    @endif
                                                    </div>
                                                @elseif($todos->posicao != 2 && $todos->posicao != 3)
                                                    <div class="col-2 lin_resume">
                                                    <div class="lin_1 border-danger"></div>
                                                    <div class="holder-icon bg-danger">
                                                        <i class="mdi mdi-close"></i>
                                                    </div>
                                                    <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                    <a href="{{route('checkout.continuar', $pedido->codigo)}}" target="_blank"> Tentar novamente </a>
                                                    @if($todos->posicao == 1)
                                                        <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                    @endif
                                                    @if($todos->posicao == 8)
                                                        <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                    @endif
                                                    </div>
                                                @endif
                                            @elseif($pedido->RelationStatus->last()->posicao == 5 && $todos->posicao <= 5)
                                                @if($todos->posicao != 2 && $todos->posicao != 4)
                                                    <div class="col-2 lin_resume">
                                                    <div class="lin_1 border-success"></div>
                                                    <div class="holder-icon bg-success">
                                                        <i class="mdi mdi-check"></i>
                                                    </div>
                                                    <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                    @if($todos->posicao == 1)
                                                        <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                    @endif
                                                    @if($todos->posicao == 8)
                                                        <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                    @endif
                                                    </div>
                                                @endif
                                            @elseif(($pedido->RelationStatus->last()->posicao == 6) && $todos->posicao <= 6)
                                                @if($todos->posicao != 2 && $todos->posicao != 4)
                                                    <div class="col-2 lin_resume">
                                                    <div class="lin_1 border-success"></div>
                                                    <div class="holder-icon bg-success">
                                                        <i class="mdi mdi-check"></i>
                                                    </div>
                                                    <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                    @if($todos->posicao == 1)
                                                        <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                    @endif
                                                    @if($todos->posicao == 8)
                                                        <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                    @endif
                                                    </div>
                                                @endif
                                            @elseif($pedido->RelationStatus->last()->posicao == 7 && $todos->posicao <= 7)
                                                @if($todos->posicao != 2 && $todos->posicao != 4)
                                                    <div class="col-2 lin_resume">
                                                    <div class="lin_1 border-success"></div>
                                                    <div class="holder-icon bg-success">
                                                        <i class="mdi mdi-check"></i>
                                                    </div>
                                                    <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                    @if($todos->posicao == 1)
                                                        <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                    @endif
                                                    @if($todos->posicao == 8)
                                                        <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                    @endif
                                                    </div>
                                                @endif
                                            @elseif($pedido->RelationStatus->last()->posicao == 8 && $todos->posicao <= 8)
                                                @if($todos->posicao != 2 && $todos->posicao != 4)
                                                    <div class="col-2 lin_resume">
                                                    <div class="lin_1 border-success"></div>
                                                    <div class="holder-icon bg-success">
                                                        <i class="mdi mdi-check"></i>
                                                    </div>
                                                    <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                    @if($todos->posicao == 1)
                                                        <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                    @endif
                                                    @if($todos->posicao == 8)
                                                        <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                    @endif
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-2 lin_resume">
                                                <div class="lin_1"></div>
                                                <div class="holder-icon-no d-block mx-auto">
                                                    <i class="mdi"></i>
                                                </div>
                                                <p class="mb-0 mt-2">{{$todos->nome}}</p>
                                                @if($todos->posicao == 1)
                                                    <label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
                                                @endif
                                                @if($todos->posicao == 8)
                                                    <label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
                                                @endif
                                                </div>
                                            @endif
                                        @else
                                            @if($pedido->RelationStatus->last()->posicao == 9)
                                                <div class="alert alert-danger col-12"> 
                                                    <label class="mb-0">Essa compra foi cancelada. Entre em contato com suporte para mais informações.</label>
                                                </div>
                                                @break
                                            @endif
                                        @endif
                                    @endforeach
                                </div>

                                <hr>
                                
                                <section>
                                    <div class="card-body px-0">
                                        <div class="table-responsive text-center">
                                            <table class="table-striped table">
                                                <thead>
                                                    <tr>
                                                        <th>Produto</th>
                                                        <th>Quantidade</th>
                                                        <th>Valor unitário</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="row text-left">
                                                                <div class="px-3 my-auto">
                                                                    <img src="{{ url('storage/app/'.$pedido->RelationProduto->RelationImagensPrincipal->first()->caminho)}}" alt="Imagem atual" style="height: auto; width: 70px;" class="p-1 border rounded">
                                                                </div>
                                                                <div class="px-3 my-auto">
                                                                    <a href="{{ route('produtos.editar', $pedido->RelationProduto->id) }}" class="text-decoration-none">
                                                                        <p class="n_pedido my-auto not-espaco"><b>{{$pedido->RelationProduto->nome}}</b></p>
                                                                    </a>
                                                                    <label><b>SKU: </b>{{$pedido->RelationProduto->cod_sku}}</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <label>{{$pedido->quantidade}}</label>
                                                        </td>
                                                        <td>
                                                            <label>R$ {{ number_format($pedido->RelationProduto->preco_venda,2, ",", ".") }}</label>
                                                        </td>
                                                        <td>
                                                            <label>R$ {{ number_format(($pedido->RelationProduto->preco_venda*$pedido->quantidade),2, ",", ".") }}</label>
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
                                <div class="row col-12 p-2 mx-auto">
                                    <h6 class="mb-0 px-2">Transação <b>#{{$transactions->id}}</b></h6>
                                    <img src="https://dka575ofm4ao0.cloudfront.net/pages-transactional_logos/retina/1949/PagarMe_Logo_PRINCIPAL-02.png" height="30" alt="PagarME" class="ml-auto">
                                </div>
                                <div>
                                    <div class="py-2 col">
                                        @if($pedido->id_forma_pagamento == 1)
                                            <div class="row m-0">
                                                <img data-v-a542e072="" src="http://download.seaicons.com/icons/iconsmind/outline/512/Credit-Card-3-icon.png" width="35" class="mr-3">
                                                <h6 class="my-auto font-weight-bold">
                                                    {{ strtoupper($transactions->card_brand) }}
                                                </h6>
                                            </div>
                                            <div class="pb-3">
                                                <p class="mb-0">
                                                    {{ substr($transactions->card->first_digits,0,4) }} **** **** {{ $transactions->card->last_digits }} 
                                                </p>
                                                <p class="mb-0 not-espaco">
                                                    <span>Titular do cartão:</span>
                                                    <span><b>{{ strtoupper($transactions->card_holder_name) }}</b></span>
                                                </p>
                                                <p class="mb-0">
                                                    <span>Documento do titular:</span>
                                                    <span><b>{{ $pedido->RelationCliente->documento }}</b></span>
                                                </p>
                                            </div>
                                            <div class="mb-2 row mx-0">
                                                <h3 class="mb-0">
                                                    <span>R$ {{ number_format(($pedido->valor_compra - $pedido->desconto_aplicado + $pedido->RelationRastreamento->valor_envio),2, ",", ".") }}</span> 
                                                </h3> 
                                                <label class="row m-0 font-weight-bold px-2">
                                                    <span class="mt-auto">em {{$transactions->installments}}x de R$ {{number_format( (($pedido->valor_compra - $pedido->desconto_aplicado + $pedido->RelationRastreamento->valor_envio)/$transactions->installments),2, ",", ".") }}</span>
                                                </label> 
                                            </div>
                                            <div class="transaction_status mt10 f11 bold">
                                                <div class="my-auto status badge badge-{{($transactions->status == 'processing' || $transactions->status == 'waiting_payment' ? 'warning' : ($transactions->status == 'authorized' || $transactions->status == 'paid' ? 'success' : ($transactions->status == 'refunded' || $transactions->status ==  'pending_refund' || $transactions->status == 'refused' ? 'danger' : '')))}}">
                                                    {{($transactions->status == 'processing' || $transactions->status == 'waiting_payment' ? 'Pendente de pagamento' : ($transactions->status == 'authorized' || $transactions->status == 'paid' ? 'Pagamento aprovado' : ($transactions->status == 'refunded' || $transactions->status ==  'pending_refund' || $transactions->status == 'refused' ? 'Pagamento recusado' : '')))}}
                                                </div>
                                                <small class="font-weight-bold">em {{date('d/m/Y \á\s H:i:s', strtotime($transactions->date_created))}}</small>
                                            </div>
                                        @else
                                            <div class="row m-0">
                                                <img src="https://github.bubbstore.com/svg/billet.svg" width="35" class="mr-3">
                                                <h6 class="my-auto font-weight-bold">
                                                    Boleto bancário
                                                </h6>
                                            </div>
                                            <div>
                                                <h3 class="mt-2">
                                                    R$ {{ number_format(($pedido->valor_compra - $pedido->desconto_aplicado + $pedido->RelationRastreamento->valor_envio),2, ",", ".") }}
                                                </h3>
                                            </div>
                                            <div class="my-auto status badge badge-{{($transactions->status == 'processing' || $transactions->status == 'waiting_payment' ? 'warning' : ($transactions->status == 'authorized' || $transactions->status == 'paid' ? 'success' : ($transactions->status == 'refunded' || $transactions->status ==  'pending_refund' || $transactions->status == 'refused' ? 'danger' : '')))}}">
                                                {{($transactions->status == 'processing' || $transactions->status == 'waiting_payment' ? 'Pendente de pagamento' : ($transactions->status == 'authorized' || $transactions->status == 'paid' ? 'Pagamento aprovado' : ($transactions->status == 'refunded' || $transactions->status ==  'pending_refund' || $transactions->status == 'refused' ? 'Pagamento recusado' : '')))}}
                                            </div>
                                            <small class="font-weight-bold">em {{date('d/m/Y \á\s H:i:s', strtotime($transactions->date_created))}}</small>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row m-0 pb-3">
                                    <div class="col-4">
                                        <p class="mb-0">Afiliação: Pagar.me - grupocapsul</p>
                                        <p class="mb-0">ID-pagar.me: <b id="transactions">{{ $transactions->id }}</b>
                                            <a href="javascript:void(0)" class="copiando">
                                                <i class="mdi mdi-content-copy"></i>
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-8 text-right">
                                        <div class="buttons">
                                            @if($transactions->payment_method == 'credit_card' && ($transactions->status == 'processing' || $transactions->status == 'waiting_payment' || $transactions->status == 'authorized' || $transactions->status == 'paid'))
                                            <a href="javascript:void(0)" class="btn btn-icon icon-left btn-lg btn-danger shadow-none btn-cancelar font-weight-bold">
                                                <i class="mdi mdi-close"></i> 
                                                <span>Cancelar transação</span>
                                            </a>
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
                            @if($pedido->RelationStatus->last()->posicao == 1)
                                <div class="alert alert-light">
                                    <div class="alert-title">
                                        <span>Esse pedido ainda não possui nota fiscal.</span>
                                    </div>
                                    <div>
                                        <span>Você precisa confirmar o pagamento do pedido para prosseguir com a Nota Fiscal.</span>
                                    </div>
                                </div>
                            @elseif(isset($pedido->RelationNotas))
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
                                                <i class="mdi mdi-content-copy"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <label class="d-block mb-0 not-espaco">Chave</label>
                                            <label class="font-weight-bold" id="chave">{{(isset($pedido->RelationNotas->chave) ? $pedido->RelationNotas->chave : '-')}}</label>
                                        </div>
                                        <div class="d-flex">
                                            <div class="">
                                                <label class="d-block mb-0 not-espaco">Valor da nota</label>
                                                <label class="font-weight-bold">R$ {{ number_format(($pedido->valor_compra - $pedido->desconto_aplicado + $pedido->RelationRastreamento->valor_envio),2, ",", ".") }}</label>
                                            </div>
                                            <div class="mx-5">
                                                <label class="d-block mb-0 not-espaco">Valor dos produtos</label>
                                                <label class="font-weight-bold">R$ {{number_format($pedido->valor_compra,2, ",", ".")}}</label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="d-block mb-0 not-espaco">URL da Nota</label>
                                            <label class="font-weight-bold" id="url_nota">{{(isset($pedido->RelationNotas->url_nota) ? $pedido->RelationNotas->url_nota : '-')}}</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12 text-center pb-4">
                                        <a href="javascript:" class="col-3 btn btn-icon btn-lg icon-left btn-outline-secondary w-100 col-3" data-toggle="modal" data-target="#modal-nota" >
                                            <i class="mdi mdi-pencil"></i> 
                                            <span>Alterar</span>
                                        </a>
                                    </div>
                                </div>
                            @elseif($pedido->RelationStatus->last()->posicao == 3 || ($pedido->RelationStatus->last()->posicao > 5 && $pedido->RelationStatus->last()->posicao < 9))
                                <div class="alert alert-light">
                                    <span>Não é possível inserir nota fiscal nesse pedido.</span>
                                </div>
                                <div class="col-12 text-center">
                                    <hr>
                                    <a href="javascript:void(0)" class="btn btn-icon btn-lg icon-left btn-outline-secondary w-100 col-3" data-toggle="modal" data-target="#modal-nota">
                                        <i class="mdi mdi-plus"></i> 
                                        <span>Inserir nota fiscal</span>
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-light">
                                    <span>Não é possível inserir nota fiscal nesse pedido.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="rastreamento" role="tabpanel" aria-labelledby="rastreamento-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="row m-0 col-12">
                                    <div class="col-6 border rounded p-4 h-100">
                                        <p class="mb-0">Forma de entrega</p>
                                        <label class="not-espaco text-uppercase font-weight-bold">{{(isset($pedido->RelationRastreamento->tipo) ? $pedido->RelationRastreamento->tipo : "Nenhum") }}</label>

                                        <p class="mb-0">Código de rastreamento</p> 
                                        <label id="cod_ratreamento" class="not-espaco font-weight-bold">{{(isset($pedido->RelationRastreamento->cod_rastreamento) ? $pedido->RelationRastreamento->cod_rastreamento : "Não cadastrado") }}</label>

                                        <p class="mb-0">Link de rastreamento</p> 
                                        <label id="link_rastreamento" class="not-espaco font-weight-bold">
                                            <a href="{{(isset($pedido->RelationRastreamento->link_rastreamento) ? $pedido->RelationRastreamento->link_rastreamento : 'javascript:void(0)') }}" target="_blank">{{(isset($pedido->RelationRastreamento->link_rastreamento) ? $pedido->RelationRastreamento->link_rastreamento : "Não cadastrado") }}</a>
                                        </label>
                                   </div>
                                   <div class="col-6">
                                    @if(!empty($correios))
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
                                                        <label class="font-weight-bold">
                                                            {{$correio['data']}}
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
                                                                {{str_replace('<label class="text-capitalize">', '', str_replace('</label>', '', $correio['local']))}}
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
                                                <span>Informações de rastreamento indisponíveis.</span>
                                               
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                @if($pedido->RelationStatus->last()->posicao > 2 && $pedido->RelationStatus->last()->posicao < 9)
                                <hr>
                                <a href="javascript:void(0)" class="col-3 btn btn-icon btn-lg icon-left btn-outline-secondary w-100" data-toggle="modal" data-target="#modal-rastreamento">
                                    <i class="mdi mdi-pencil"></i> 
                                    <span>Alterar</span>
                                </a>
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
                                    @foreach($statusPedido as $historico)
                                    <tr>
                                        <td class="align-middle">
                                            <p class="data_pedido">{{ date_format($historico->created_at, "d/m/Y H:i:s") }}</p>
                                            <p class="temp_pedido">{{ $historico->created_at->subMinutes(2)->diffForHumans() }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <div class="my-auto status badge badge-{{
                                                ($historico->RelationStatus1->posicao==1 ? 'primary' :
                                                ($historico->RelationStatus1->posicao==2 ? 'warning' : 
                                                ($historico->RelationStatus1->posicao==3 ? 'success' :
                                                ($historico->RelationStatus1->posicao==4 ? 'danger' :
                                                ($historico->RelationStatus1->posicao==6 ? 'primary' :
                                                ($historico->RelationStatus1->posicao==5 ? 'dark' : 
                                                ($historico->RelationStatus1->posicao==7 ? 'info' : 
                                                ($historico->RelationStatus1->posicao==8 ? 'success' :
                                                ($historico->RelationStatus1->posicao==9 ? 'danger' : '')))))))))}}">{{strtoupper($historico->RelationStatus1->nome)}}
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            {{(isset($historico->observacoes) ? $historico->observacoes : 'Nenhuma observação.')}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($pedido->RelationStatus->last()->posicao !=10)
                            <hr>
                            <div class="col-12 text-center">
                                
                                <a href="javascript:void(0)" class="col-3 btn btn-lg btn-outline-secondary shadow-none" data-toggle="modal" data-target="#modal-status">
                                    <i class="mdi mdi-sync"></i> 
                                    <span>Atualizar status</span>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="historico" role="tabpanel" aria-labelledby="historico-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12 table-responsive mt-3">
                                @if(count($pedidos) > 0)
                                <table class="table text-center">
                                    <thead class="text-uppercase">
                                        <tr>
                                            <th>Produtos</th>
                                            <th>Data</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>N. do pedido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pedidos as $ped)
                                        <tr>
                                            <td class="ml-2">
                                                <div class="row text-left">
                                                    <div class="px-3 my-auto">
                                                        <img src="{{ url('storage/app/'.$ped->RelationProduto->RelationImagensPrincipal->first()->caminho)}}" alt="Imagem atual" style="height: auto; width: 70px;" class="p-1 border rounded">
                                                    </div>
                                                    <div class="px-3 my-auto">
                                                        <p class="nome m-0"><b>{{$ped->RelationProduto->nome}}</b></p>
                                                        <label>{{$ped->RelationProduto->cod_sku}}</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                               <div class="col-12">
                                                    {{date_format($ped->created_at, "d/m/Y H:i:s")}}
                                                </div>
                                                <div class="col-12 font-weight-bold">
                                                    {{$ped->created_at->subMinutes(2)->diffForHumans()}}
                                                </div>
                                            </td>
                                            <td>
                                                R$ {{number_format(($ped->valor_compra - $ped->desconto_aplicado + $ped->RelationRastreamento->valor_envio), 2, ',', '.')}}
                                            </td>
                                            <td>
                                                <div class="status badge badge-{{
                                                ($ped->RelationStatus->last()->posicao==1 ? 'primary' :
                                                ($ped->RelationStatus->last()->posicao==2 ? 'warning' : 
                                                ($ped->RelationStatus->last()->posicao==3 ? 'success' :
                                                ($ped->RelationStatus->last()->posicao==4 ? 'danger' :
                                                ($ped->RelationStatus->last()->posicao==6 ? 'primary' :
                                                ($ped->RelationStatus->last()->posicao==5 ? 'dark' : 
                                                ($ped->RelationStatus->last()->posicao==7 ? 'info' : 
                                                ($ped->RelationStatus->last()->posicao==8 ? 'success' :
                                                ($ped->RelationStatus->last()->posicao==9 ? 'danger' : '')))))))))}}">
                                                <span>{{strtoupper($ped->RelationStatus->last()->nome)}}</span>
                                            </div>
                                            </td>
                                            <td>
                                                <a href="{{route('pedidos.detalhes', $ped->id)}}" class="nome text-decoration-none">#{{$ped->codigo}}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row justify-content-center">
                                    {{ $pedidos->links() }}
                                </div>
                                @else
                                <div class="alert alert-light">O cliente não possui outros pedidos.</div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="emails" role="tabpanel" aria-labelledby="emails-tab">
                    <div class="card">
                        <div class="card-body">
                            @foreach($statusPedido as $historico)
                                <div class="alert alert-white border text-dark">
                                    <div class="row align-items-center align-content-center justify-content-center">
                                        <div class="col-2 text-center">
                                            <i class="mdi mdi-email-outline mdi-48px mdi-dark mdi-inactive row align-items-center align-content-center justify-content-center"></i>
                                        </div>
                                        <div class="col-6">
                                            <div class="holder-left">
                                                <a href="javascript:void(0)" class="text-primary" data-toggle="modal" data-target="#modal-{{$historico->id}}">
                                                    <span>{{ $historico->RelationStatus1->nome }}!</span>
                                                </a> 
                                                <span>{{$historico->created_at->subMinutes(2)->diffForHumans()}}</span>
                                                <div>Para: 
                                                    <span class="font-weight-bold">{{$pedido->RelationCliente->email}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 my-auto pr-5 text-right">
                                            @if($pedido->RelationStatus->last()->id == $historico->id_status)
                                            <button type="submit" class="btn btn-outline-dark" id="reenviarEmail">Reenviar e-mail</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
    @include('pedidos.extras.status')
    @include('pedidos.extras.nota')
    @include('pedidos.extras.rastreamento')
    @foreach($statusPedido as $historico)
    <div class="modal fade" id="modal-{{$historico->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel{{$historico->id}}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 600px;">
            <div class="modal-content">
                <div class="card mb-0">
                    <div class="card-header d-block col-12">
                        <div class="col-12 d-flex py-2">
                            <h4 class="titulo_modal titulo_modal">{{$historico->RelationStatus1->nome}}</h4>
                            <button type="button" class="ml-auto close" data-dismiss="modal" aria-label="Close"><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="border rounded">
                            <div class="col-12 p-3 text-center" style="background-color: #f5f5f5">
                                <a href="{{ config('app.url') }}">
                                    <img src="{{ asset('storage/app/system/capsul.png').'?'.rand() }}" alt="Imagem logo" height="40">
                                </a>
                            </div>

                            <div class="px-5 pt-3 content-cell">
                                <h3> Olá, {{ ucwords(strtolower(explode(" ", $pedido->RelationCliente->nome)[0])) }}!</h3>
                                <p>Temos uma ótima notícia para você, seu pedido teve uma nova atualização.</p>

                                <div class="lin_resume mb-3" align="center">
                                    <div align="center" style="margin-bottom: 5px">
                                        <img src="{{asset('public/img/emails/alterarStatus.png')}}" width="250">
                                    </div>
                                    <h5 style="text-align: center!important;">{{$historico->RelationStatus1->nome}}</h5>
                                    <div align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                        <a href="{{route('acompanhamento.pedido', $historico->RelationPedido1->codigo)}}" target="_blank">
                                            <label style="margin: 0;">Acompanhar meu pedido</label>
                                        </a>                    
                                    </div>
                                </div>

                                <p> {{$historico->RelationStatus1->descricao}} </p>

                                <p> Abraços, <br> {{$geral->nome_loja}}.</p>
                            </div>
                            
                            <div class="p-3 text-center" style="background-color: #f5f5f5">
                                <b class="d-block">Equipe de suporte do {{ $geral->nome_loja }}!</b>
                                <label class="d-block mb-0">{{ $geral->email }}</label>
                                <a href="{{ config('app.url') }}" target="_blank">{{ config('app.url') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
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
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 mdi mdi-check my-3" style="font-size:62px;"></i></div><h6>Informações salvas com sucesso!</h6></div>');
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
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 mdi mdi-check my-3" style="font-size:62px;"></i></div><h6>Informações salvas com sucesso!</h6></div>');
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
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 mdi mdi-check my-3" style="font-size:62px;"></i></div><h6>Informações salvas com sucesso!</h6></div>');
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
                        $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 mdi mdi-check my-3" style="font-size:62px;"></i></div><h6>Informações salvas com sucesso!</h6></div>');
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

            $('.btn-cancelar').on('click', function(e){
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

            $('#reenviarEmail').on('click', function(e){
                e.preventDefault();
                if(confirm("Tem certeza que deseja reenviar esse e-mail?")){
                    $.ajax({
                        url: '{{ route("reenviar.email", $pedido->RelationStatus->last()->id) }}',
                        type: 'GET',
                        success: function(data){
                            alert("O e-mail foi enviado para o cliente com sucesso!");
                        }, error: function (data) {
                            alert("Erro! Entre em contato com o administrador.");
                        }
                    });
                }
            });
            
        });
    </script>
    @endsection




