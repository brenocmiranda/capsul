@section('title')
Avalição do pedido
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
					<form class="w-100 mt-4" method="POST" action="{{ route('avaliacao.pedido.salvar', $pedido->id) }}"  enctype="multipart/form-data">
						<div class="card col-12 m-auto">
							<div class="card-body">
								<div class="col-12">
									<p>
										<h4> Olá, {{ ucwords(strtolower(explode(" ", $pedido->RelationCliente->nome)[0])) }}</h4>
										<h6 class="font-weight-normal pb-2">Agora é com você, gostariamos de saber a avaliação da sua compra com o {{$geral->nome_loja}}.</h6>
									</p>
									<div class="col-12 p-0">										
										<div class="form-group">
											<label>O que você achou do produto? <i class="text-danger">*</i></label>
											<div class="row m-0">
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="produto" id="produto4" value="4">
													<label class="form-check-label" for="produto4">
														Ruim
													</label>
												</div>
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="produto" id="produto3" value="3">
													<label class="form-check-label" for="produto3">
														Regular
													</label>
												</div>
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="produto" id="produto2" value="2">
													<label class="form-check-label" for="produto2">
														Bom
													</label>
												</div>
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="produto" id="produto1" value="1" checked>
													<label class="form-check-label" for="produto1">
														Ótimo
													</label>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label>Qual seu grau de satisfação? <i class="text-danger">*</i></label>
											<div class="row m-0">
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="satisfacao" id="satisfacao1" value="1">
													<label class="form-check-label" for="satisfacao1">
														1
													</label>
												</div>
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="satisfacao" id="satisfacao2" value="2">
													<label class="form-check-label" for="satisfacao2">
														2
													</label>
												</div>
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="satisfacao" id="satisfacao3" value="3">
													<label class="form-check-label" for="satisfacao3">
														3
													</label>
												</div>
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="satisfacao" id="satisfacao4" value="4">
													<label class="form-check-label" for="satisfacao4">
														4
													</label>
												</div>
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="satisfacao" id="satisfacao5" value="5" checked=>
													<label class="form-check-label" for="satisfacao5">
														5
													</label>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label>Você recomendaria para amigos e familiares? <i class="text-danger">*</i></label>
											<div class="row m-0">
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="recomendacao" id="recomendacao1" value="s" checked>
													<label class="form-check-label" for="recomendacao1">
														Sim
													</label>
												</div>
												<div class="form-check mx-2">
													<input class="form-check-input" type="radio" name="recomendacao" id="recomendacao2" value="n">
													<label class="form-check-label" for="recomendacao2">
														Não
													</label>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label>Deixe seu comentário da sua compra</label>
											<textarea class="form-control"></textarea>
										</div>
									</div>
								</div>
							
								<hr>
		                
				                <div class="col-12 text-center">
				                    <button class="btn btn-success btn-lg col-3 mx-1 shadow-none">Enviar <i class="mdi mdi-arrow-right pl-2"></i></button>
				                </div>

			                </div>
						</div>
	                </form>
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