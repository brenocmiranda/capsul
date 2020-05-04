<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Imprimir pedido #{{$pedido->id}} &#183 {{ env('APP_NAME') }} </title>

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('storage/app/system/icon.png').'?'.rand() }}" type="image/x-icon">

  <!-- Template CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.0.45/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{ asset('public/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/codemirror/lib/codemirror.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/codemirror/theme/duotone-dark.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/jquery-selectric/selectric.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/datatables.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
  <style type="text/css">
  	@media print {
	  	* {
		background:transparent !important;
		color:black !important;
		text-shadow:none !important;
		filter:none !important;
		-ms-filter:none !important;
		}

		body {
		margin:0;
		padding:0;
		line-height: 1.4em;
		color: black !important;
		}

		@page {
		margin: 0.5cm;
		}
	}

	body {
		margin:0;
		padding:0;
		line-height: 1.4em;
		color: black !important;
	}
  </style>
</head>

<body>
<div class="container p-0 py-5" style="width:850px">
    <section class="section">
		<div class="card">
            <div class="card-body mt-2 mx-1">

            	<div class="row col-12 m-auto p-0">
            		<div class="col-4 p-4" style="border: 1px dashed black !important;">
            			<h5>Remetente</h5>
            			<label class="d-block mb-0 font-weight-bold text-uppercase">{{$geral->nome_loja}}</label>
            			<label class="d-block mb-0">{{ucwords(strtolower($geral->endereco)) .', '.$geral->numero.', '.(isset($geral->complemento) ? $geral->complemento.', ' : '').ucwords(strtolower($geral->bairro)) }}</label>
            			<label class="d-block mb-0">{{ucwords(strtolower($geral->cidade))}} - {{$geral->estado}}</label>
            			<label class="d-block mb-0">
            				<span>CEP: </span>
                            <b>{{substr($geral->cep, 0, 5)."-".substr($geral->cep, 5, 7)}}</b>
                        </label>
            		</div>
            		<div class="col-4 p-4" style="border-top: 1px dashed black !important;border-bottom: 1px dashed black !important;">
            			<h5>Destinatário</h5>
            			<label class="d-block mb-0 font-weight-bold">{{$pedido->RelationEndereco->destinatario}}</label>
            			<label class="d-block mb-0">{{ucwords(strtolower($pedido->RelationEndereco->endereco)).', '.$pedido->RelationEndereco->numero.', '.(isset($pedido->RelationEndereco->complemento) ? $pedido->RelationEndereco->complemento.', ' : '').ucwords(strtolower($pedido->RelationEndereco->bairro))}}</label>
            			<label class="d-block mb-0">{{ucwords(strtolower($pedido->RelationEndereco->cidade))}} - {{$pedido->RelationEndereco->estado}}</label>
            			<label class="d-block mb-0">
            				<span>CEP: </span>
                            <b>{{substr($pedido->RelationEndereco->cep, 0, 5)."-".substr($pedido->RelationEndereco->cep, 5, 7)}}</b>
                        </label>
            		</div>
            		<div class="col-4" style="border: 1px dashed black !important;"></div>
            	</div>

            	<div style="border-top: 4px dashed #666 !important;" class="my-5">
            		<i class="mdi mdi-content-cut mdi-36px position-absolute mt-n3 mx-5 bg-white"></i>
            	</div>

            	<h3>Pedido: {{$pedido->codigo}}</h3>
            	<label>Feito em {{ date_format($pedido->created_at, "d/m/Y") }} às {{ date_format($pedido->created_at, "H:i:s") }}</label>

            	<hr>

                <div class="row col-12 p-0 mx-auto">
                    <div class="col-3 cliente">
                        <h1 class="resumo_title">Cliente</h1><br>
                        <div class="mt-2">
                            <label class="text-truncate mb-0 d-block">
                                <span class="text-capitalize font-weight-bold">{{strtolower($pedido->RelationCliente['nome'])}}</span>
                            </label>
                            <label class="d-block">
                                <span>{{$pedido->RelationCliente['email']}}</span>
                            </label>
                            <label class="d-block mb-0 font-weight-bold">
                                <i class="mdi mdi-whatsapp"></i>
                                <span>{{"(".substr(str_replace("+55", "", $pedido->RelationTelefones->numero), 0, 2).") ".substr(str_replace("+55", "", $pedido->RelationTelefones->numero), 2, 5)."-".substr(str_replace("+55", "", $pedido->RelationTelefones->numero), 7, 10)}}</span>
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
                    <div class="col-3 pagamento">
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
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-3 entrega">
                        <h1 class="resumo_title">Entrega</h1>
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
                                <b>{{$pedido->RelationEndereco->cep}}</b>
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
                    <div class="col-3">
                        <h1 class="resumo_title mt-4">Valor total</h1><br>
                        <div class="mt-2">
                            <h3 class="font-weight-bold">
                                <span>R$ {{ number_format(($pedido->valor_compra - $pedido->desconto_aplicado + $pedido->RelationRastreamento->valor_envio), 2, ",", ".") }}</span>
                            </h3>
                            <div class="mt-4 row col">
                                <div class="text-left">
                                    <p class="mb-0">Produtos: </p>
                                    <p class="mb-0 not-espaco">Desconto: </p>
                                    <p class="mb-0">Frete:</p>
                                </div>
                                <div class="text-right pl-2">
                                    <p class="mb-0">R$ {{ number_format( ($pedido->RelationProduto->preco_venda * $pedido->quantidade), 2, ",", ".")}}</p>
                                    <p class="mb-0 text-danger not-espaco">R$ {{ (isset($pedido->desconto_aplicado) ? number_format($pedido->desconto_aplicado, 2, ",", ".") : '0,00')}}</p>
                                    <p class="mb-0">R$ {{ number_format($pedido->RelationRastreamento->valor_envio, 2, ",", ".")}}</p>
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>

                <hr>
                
                <section>
                	<h5 class="mt-2">Produtos <span class="badge badge-light rounded-circle mx-2">{{$pedido->quantidade}}</span></h5>
                    <div class="card-body p-0">
                        <div class="table-responsive text-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="bg-white">Produto</th>
                                        <th class="bg-white">Quantidade</th>
                                        <th class="bg-white">Valor unitário</th>
                                        <th class="bg-white">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-top border-bottom">
                                        <td>
                                            <div class="row text-left">
                                                <div class="px-3 my-auto">
                                                    <img src="{{ url('storage/app/'.$pedido->RelationProduto->RelationImagensPrincipal->first()->caminho)}}" alt="Imagem atual" style="height: auto; width: 70px;" class="p-1 border rounded">
                                                </div>
                                                <div class="px-3 my-auto">
                                                    <a href="{{ route('produtos.editar', $pedido->RelationProduto->id) }}" class="text-decoration-none">
                                                        <p class="n_pedido my-auto not-espaco"><b>{{$pedido->RelationProduto->nome}}</b></p>
                                                    </a>
                                                    <label><b>SKU:</b>{{$pedido->RelationProduto->cod_sku}}</label>
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
    </section>
</div>

@section('support')
<script type="text/javascript">
	$(document).ready(function (){
		window.print();
	});
</script>
@endsection

@include('template.footer')