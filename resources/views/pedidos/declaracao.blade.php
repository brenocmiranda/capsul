<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Declaração do pedido #{{$pedido->codigo}} &#183 {{ env('APP_NAME') }} </title>

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
	.border-xl{
		border:2px solid black;
	}
	body {
		font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji" !important;
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
            	<div class="row border-xl">
            		<h3 class="text-uppercase mx-auto p-1">DECLARAÇÃO DE CONTEÚDO</h3>
            	</div>
            	<div class="row py-1">
            		<div class="col-6 p-0 pr-1">
            			<div class="col-12 border-xl p-0">
	            			<div class="border-bottom border-dark p-2 text-center">
	            				<h6 class="mb-0 text-uppercase" style="letter-spacing: 3px;">REMETENTE</h6>
	            			</div>
	            			<div class="border-bottom border-dark p-2">
	            				<label class="mb-0 text-uppercase">
		            				<span class="font-weight-bold">NOME:</span>
		            				<span>{{$geral->nome_loja}}</span>
	            				</label>
	            			</div>
	            			<div class="border-bottom border-dark p-2">
	            				<label class="mb-0 text-uppercase">
		            				<span class="font-weight-bold">ENDEREÇO:</span>
		            				<span>{{$geral->endereco}}, nº {{$geral->numero}} {{($geral->complemento ? ' - '.$geral->complemento : "")}}</span>
	            				</label>
	            			</div>
	            			<div class="row m-0 border-bottom border-dark">
	            				<div class="col-9 p-2"> 
	            					<label class="mb-0 text-uppercase">
			            				<span class="font-weight-bold">CIDADE:</span>
			            				<span>{{$geral->cidade}}</span>
		            				</label>
	            				</div>
	            				<div class="col-3 p-2 border-left border-dark">
	            					<label class="mb-0 text-uppercase">
			            				<span class="font-weight-bold">UF:</span>
			            				<span>{{$geral->estado}}</span>
		            				</label>
	            				</div>
	               			</div>
	            			<div class="row m-0 border-bottom border-dark">
	            				<div class="col-4 p-2"> 
	            					<label class="mb-0 text-uppercase">
			            				<span class="font-weight-bold">CEP:</span>
			            				<span>{{substr($geral->cep, 0, 5)."-".substr($geral->cep, 5, 7)}}</span>
		            				</label>
	            				</div>
	            				<div class="col-7 p-2 border-left border-dark">
	            					<label class="mb-0 text-uppercase">
			            				<span class="font-weight-bold">CPF/CNPJ:</span>
			            				<span>{{$geral->cnpj}}</span>
		            				</label>
	            				</div>
	            			</div>
	            		</div>
	            	</div>
            		<div class="col-6 p-0 pl-1">
	            		<div class="col-12 border-xl p-0">
	            			<div class="border-bottom border-dark p-2 text-center">
	            				<h6 class="mb-0 text-uppercase" style="letter-spacing: 3px;">DESTINATÁRIO</h6>
	            			</div>
	            			<div class="border-bottom border-dark p-2">
	            				<label class="mb-0 text-uppercase">
		            				<span class="font-weight-bold">NOME:</span>
		            				<span>{{$pedido->RelationCliente->nome}}</span>
	            				</label>
	            			</div>
	            			<div class="border-bottom border-dark p-2">
	            				<label class="mb-0 text-uppercase">
		            				<span class="font-weight-bold">ENDEREÇO:</span>
		            				<span>{{$pedido->RelationEndereco->endereco}}, nº {{$pedido->RelationEndereco->numero}} {{($pedido->RelationEndereco->complemento ? ' - '.$pedido->RelationEndereco->complemento : "")}}</span>
	            				</label>
	            			</div>
	            			<div class="row m-0 border-bottom border-dark">
	            				<div class="col-9 p-2"> 
	            					<label class="mb-0 text-uppercase">
			            				<span class="font-weight-bold">CIDADE:</span>
			            				<span>{{$pedido->RelationEndereco->cidade}}</span>
		            				</label>
	            				</div>
	            				<div class="col-3 p-2 border-left border-dark">
	            					<label class="mb-0 text-uppercase">
			            				<span class="font-weight-bold">UF:</span>
			            				<span>{{$pedido->RelationEndereco->estado}}</span>
		            				</label>
	            				</div>
	               			</div>
	            			<div class="row m-0 border-bottom border-dark">
	            				<div class="col-4 p-2"> 
	            					<label class="mb-0 text-uppercase">
			            				<span class="font-weight-bold">CEP:</span>
			            				<span>{{substr($pedido->RelationEndereco->cep, 0, 5)."-".substr($pedido->RelationEndereco->cep, 5, 7)}}</span>
		            				</label>
	            				</div>
	            				<div class="col-7 p-2 border-left border-dark">
	            					<label class="mb-0 text-uppercase">
			            				<span class="font-weight-bold">CPF/CNPJ:</span>
			            				<span>{{$pedido->RelationCliente->documento}}</span>
		            				</label>
	            				</div>
	            			</div>
	            		</div>
	            	</div>
            	</div>
            	<div class="row py-1">
            		<div class="col-12 border-xl p-0">
	            		<div class="text-center p-2">
	        				<h6 class="mb-0 text-uppercase" style="letter-spacing: 3px;">IDENTIFICAÇÃO DOS BENS</h6>
	        			</div>
	        		</div>
            		<div class="col-12 border-xl p-0 border-top-0">
	        			<div class="table-responsive">
	        				<table class="">
	        					<thead>
	        						<tr class="border-bottom border-dark text-center col-12">
	        							<th class="p-1 border-right border-dark" style="width: 150px">ITEM</th>
	        							<th class="p-1 border-right border-dark" style="width: 500px">CONTEÚDO</th>
	        							<th class="p-1 border-right border-dark" style="width: 150px">QUANT.</th>
	        							<th class="p-1" style="width: 200px">VALOR</th>
	        						</tr>
	        					</thead>
	        					<tbody>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">1</td>
	        							<td class="p-1 border-right border-dark">{{$pedido->RelationProduto->nome}}</td>
	        							<td class="p-1 border-right border-dark text-center">{{$pedido->quantidade}}</td>
	        							<td class="p-1">R$ {{number_format($pedido->RelationProduto->preco_venda * $pedido->quantidade,2, ",", ".")}}</td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">2</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">3</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">4</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">5</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">6</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">7</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">8</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">9</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">10</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">11</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">12</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">13</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark text-center">14</td>
	        							<td class="p-1 border-right border-dark"></td>
	        							<td class="p-1 border-right border-dark text-center"></td>
	        							<td class="p-1"></td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark bg-secondary font-weight-bold text-right" colspan="2"> TOTAIS</td>
	        							<td class="p-1 border-right border-dark text-center">{{$pedido->quantidade}}</td>
	        							<td class="p-1">R$ {{number_format($pedido->RelationProduto->preco_venda * $pedido->quantidade,2, ",", ".")}}</td>
	        						</tr>
	        						<tr class="border-bottom border-dark col-12">
	        							<td class="p-1 border-right border-dark bg-secondary font-weight-bold text-right" colspan="2"> PESO TOTAL(kg)</td>
	        							<td class="p-1 border-right border-dark text-center" colspan="2">{{number_format($pedido->RelationProduto->peso,2, ",", ".")}} kg</td>
	        						</tr>
	        					</tbody>
	        				</table>
	        			</div>
        			</div>
            	</div>
            	<div class="row py-1">
            		<div class="col-12 border-xl p-0">
	            		<div class="text-center p-2 border-bottom border-dark">
	        				<h6 class="mb-0 text-uppercase" style="letter-spacing: 3px;">DECLARAÇÃO</h6>
	        			</div>
	            		<div class="col-12 pt-3 pb-5">
	            			<p class="text-justify px-2 mb-0" style="line-height: 17px;"><span class="mx-4"></span>Declaro que não me enquadro no conceito de contribuinte previsto no art. 4º da Lei Complementar nº 87/1996, uma vez que não realizo, com habitualidade ou em volume que caracterize intuito comercial, operações de circulação de mercadoria, ainda que se iniciem no exterior, ou estou dispensado da emissão da nota fiscal por força da legislação tributária vigente, responsabilizando-me, nos termos da lei e a quem de direito, por informações inverídicas. </p> 
	            			<p class="text-justify px-2 mb-0" style="line-height: 17px;"><span class="mx-4"></span>Declaro ainda que não estou postando conteúdo inflamável, explosivo, causador de combustão espontânea, tóxico, corrosivo, gás ou qualquer outro conteúdo que constitua perigo, conforme o art. 13 da Lei Postal nº 6.538/78.</p>
	            		</div>
	            		<div class="row m-0 col-12">
	            			<label class="col-12 mb-0 text-right p-0">
	            				<span class="text-center border-bottom border-dark px-5">{{ucwords(strtolower($geral->cidade))}} - {{$geral->estado}}</span> 
	            				<span>, </span>
	            				<span class="text-center border-bottom border-dark px-5">{{date('d')}}</span>
	            				<span> de </span>
	            				<span class="text-center border-bottom border-dark px-5"><?php setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'); date_default_timezone_set('America/Sao_Paulo'); echo  strftime('%B'); ?></span>
	            				<span> de </span> 
	            				<span class="text-center border-bottom border-dark px-5">{{date('Y')}}</span> 
	            				<span class="text-center pl-2">______________________________________________</span>
	            			</label>
	            			<label class="ml-auto px-3">Assinatura do Declarante/Remetente</label>
	            		</div>
            		</div>
            	</div>
            	<div class="row py-1">
            		<div class="col-12 border-xl p-0">
	            		<div class="text-left p-3">
	        				<h6 class="mb-0 text-uppercase">OBSERVAÇÃO</h6>
	            			<p class="mb-0">Constitui crime contra a ordem tributária suprimir ou reduzir tributo, ou contribuição social e qualquer acessório (Lei 8.137/90 Art. 1º, V).</p> 
	            		</div>
            		</div>
            	</div>



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