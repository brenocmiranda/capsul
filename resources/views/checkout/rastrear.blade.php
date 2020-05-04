@section('title')
Acompanhamento
@endsection

@include('template.header')

<div id="app">
	<div class="main-wrapper">
		<section class="section vh-100">
			<div class="position-absolute w-100 vh-100 m-0" style="z-index: -1;">
				<div class="d-flex h-100">
					<img src="{{ asset('public/img/bg_banner1.png') }}" class="mt-auto w-100 h-50 fixed-bottom" style="transform: rotate(180deg);">
				</div>
			</div>

			<div class="section-header p-0">
				<header class="col-12 bg-white">
					<div class="row h-100 align-items-center justify-content-center">
						<div class="col-sm-12 col-md-2 py-sm-0 my-3 text-center">
							<img src="{{ asset('storage/app/system/capsul.png') }}" width="148" title="Logo Capsul">
						</div>
					</div>
				</header>
			</div>

			<div class="section-body h-75">
				<div class="container row m-auto h-100">
					<div class="card col-12 m-auto">
						<div class="card-header py-0">
							<div class="section-title">Pedido: #{{$pedido->codigo}}</div>
						</div>
						<div class="card-body">
							<div class="col-12">
								<div class="row text-center">
									@foreach($status as $todos)
										@if($todos->posicao != 10 && $pedido->RelationStatus->last()->posicao != 10)
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
												@if($todos->posicao == 9)
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
													@if($todos->posicao == 9)
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
													@if($todos->posicao == 9)
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
													@if($todos->posicao == 9)
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
													@if($todos->posicao == 9)
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
													@if($todos->posicao == 9)
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
													@if($todos->posicao == 9)
														<label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
													@endif
													</div>
												@endif
											@elseif($pedido->RelationStatus->last()->posicao == 5 && $todos->posicao <= 5)
												@if($todos->posicao != 3 && $todos->posicao != 1)
													<div class="col-2 lin_resume">
													<div class="lin_1 border-success"></div>
													<div class="holder-icon bg-success">
														<i class="mdi mdi-check"></i>
													</div>
													<p class="mb-0 mt-2">{{$todos->nome}}</p>
													@if($todos->posicao == 1)
														<label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
													@endif
													@if($todos->posicao == 9)
														<label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
													@endif
													</div>
												@endif
											@elseif( $pedido->RelationStatus->last()->posicao == 6 || $pedido->RelationStatus->last()->posicao == 7 && $todos->posicao <= 7)
												@if($todos->posicao != 2 && $todos->posicao != 4 && $todos->posicao != 7)
													<div class="col-2 lin_resume">
													<div class="lin_1 border-success"></div>
													<div class="holder-icon bg-success">
														<i class="mdi mdi-check"></i>
													</div>
													<p class="mb-0 mt-2">{{$todos->nome}}</p>
													@if($todos->posicao == 1)
														<label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
													@endif
													@if($todos->posicao == 9)
														<label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
													@endif
													</div>
												@endif
											@elseif($pedido->RelationStatus->last()->posicao == 8 && $todos->posicao <= 8)
												@if($todos->posicao != 2 && $todos->posicao != 4 && $todos->posicao != 7)
													<div class="col-2 lin_resume">
													<div class="lin_1 border-success"></div>
													<div class="holder-icon bg-success">
														<i class="mdi mdi-check"></i>
													</div>
													<p class="mb-0 mt-2">{{$todos->nome}}</p>
													@if($todos->posicao == 1)
														<label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
													@endif
													@if($todos->posicao == 9)
														<label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
													@endif
													</div>
												@endif
											@elseif($pedido->RelationStatus->last()->posicao == 9 && $todos->posicao <= 9)
												@if($todos->posicao != 2 && $todos->posicao != 4 && $todos->posicao != 7)
													<div class="col-2 lin_resume">
													<div class="lin_1 border-success"></div>
													<div class="holder-icon bg-success">
														<i class="mdi mdi-check"></i>
													</div>
													<p class="mb-0 mt-2">{{$todos->nome}}</p>
													@if($todos->posicao == 1)
														<label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
													@endif
													@if($todos->posicao == 9)
														<label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
													@endif
													</div>
												@endif
											@else
												@if($todos->posicao != 7)
													<div class="col-2 lin_resume">
													<div class="lin_1"></div>
													<div class="holder-icon-no d-block mx-auto">
														<i class="mdi"></i>
													</div>
													<p class="mb-0 mt-2">{{$todos->nome}}</p>
													@if($todos->posicao == 1)
														<label>{{date_format($pedido->created_at, 'd/m/Y')}}</label>
													@endif
													@if($todos->posicao == 9)
														<label>{{date_format(date_create($pedido->RelationRastreamento->prazo_envio), 'd/m/Y')}}</label>
													@endif
													</div>
												@endif
											@endif
										@else
											@if($pedido->RelationStatus->last()->posicao == 10)
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
									<div class="py-3 table-responsive text-center">
										<table class="table-striped table">
											<thead>
												<tr>
													<th>Produto</th>
													<th>Quantidade</th>
													<th>Valor unitário</th>
													<th>Valor desconto</th>
													<th>Valor frete</th>
													<th>Total</th>
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
																<p class="nome m-0"><b>{{$pedido->RelationProduto->nome}}</b></p>
																<label>{{$pedido->RelationProduto->cod_sku}}</label>
															</div>
														</div>
													</td>
													<td>
														<label>{{$pedido->quantidade}}</label>
													</td>
													<td>
														<label>R$ {{ number_format($pedido->RelationProduto['preco_venda'],2, ",", ".") }}</label>
													</td>
													<td>
														<label>R$ {{ number_format($pedido->desconto_aplicado,2, ",", ".") }}</label>
													</td>
													<td>
														<label>R$ {{ number_format($pedido->RelationRastreamento->valor_envio,2, ",", ".") }}</label>
													</td>
													<td>
														<h6>R$ {{ number_format(($pedido->valor_compra-$pedido->desconto_aplicado+$pedido->RelationRastreamento->valor_envio),2, ",", ".") }}</h6>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
				<footer class="text-right text-white fixed-bottom p-4 d-none d-md-block" style="z-index: -1;">
					<label class="mb-0">Todos os direitos reservados ao {{$geral->nome_loja}}</label><br>
					<label class="mb-0">CNPJ: {{$geral->cnpj}}</label>
				</footer>
			</div>
		</section>
	</div>
</div>

@include('template.footer')