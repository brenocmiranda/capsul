@section('title')
Checkout
@endsection

@include('template.header')
<div class="row">
	<header class="col-12 bg-white">
		<div class="container px-5">
			<div class="row align-items-center">
				<div class="col-sm-12 col-md-2 py-sm-0 py-4 text-center">
					<img src="{{ asset('storage/app/system/capsul.png') }}" width="148" title="Logo Capsul">
				</div>
				<div class="d-none d-md-flex row col-2 ml-auto mt-3">
					<div class="px-2 pt-2">
						<i class="fas fa-lock" style="font-size: 30px"></i>
					</div>
					<div class="px-2">
						pagamento <b><p class="text-success"> 100% seguro </p></b>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="container">
		<!-- Card 1 -->
		<div class="row mx-md-2">
			<div class="col-12 col-sm-12 col-md-7 my-3 order-2 order-md-1">
				<div class="card mb-0 mx-3 mx-md-0">
					<div class="card-body py-0">

						<div class="row my-3">
							<div class="col-12 col-sm-10 col-md-10 mx-auto px-0">
								<div class="wizard-steps d-flex mb-md-5 mb-1 text-muted">
									<div class="wizard-step card-step1 px-3 py-3 text-decoration-none wizard-step-active">
										<div class="edit-card position-absolute d-none">
											<span class="fas fa-edit pointer"></span>
										</div>
										<div class="wizard-step-icon">
											<i class="far fa-user"></i>
										</div>
										<div class="wizard-step-label">
											Dados Pessoais
										</div>
									</div>
									<div class="wizard-step card-step2 px-3 py-3 text-decoration-none">
										<div class="edit-card position-absolute d-none">
											<span class="fas fa-edit pointer"></span>
										</div>
										<div class="wizard-step-icon">
											<i class="fas fa-shipping-fast"></i>
										</div>
										<div class="wizard-step-label">
											Entrega
										</div>
									</div>
									<div class="wizard-step card-step3 px-3 py-3 text-decoration-none">
										<div class="edit-card position-absolute d-none">
											<span class="fas fa-edit pointer"></span>
										</div>
										<div class="wizard-step-icon">
											<i class="fas fa-credit-card"></i>
										</div>
										<div class="wizard-step-label">
											Pagamento
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="carregamento">
							<!-- Dados Pessoais -->
							<form class="wizard-content mt-5 mt-md-0" id="step1">
								@csrf
								<input type="hidden" name="formcount" value="1">
								<div class="wizard-pane">
									<div class="form-group col-md-6 p-0 mb-3">
										<label class="col-md-12 text-left mt-2">CPF <span class="text-danger">*</span></label>
										<div class="col-lg-12 col-md-12">
											<input type="text" class="documento form-control" name="documento" placeholder="000.000.000-00" minlength="14" required>
										</div>
									</div>
									<div class="form-group mb-3">
										<label class="col-md-12 text-left">Nome <span class="text-danger">*</span></label>
										<div class="col-lg-12 col-md-12">
											<input type="text" name="nome" class="nome1 form-control" onkeyup="this.value = this.value.toUpperCase();" required>
										</div>
									</div>
									<div class="form-group mb-3">
										<label class="col-md-12 text-left">Email <span class="text-danger">*</span></label>
										<div class="col-lg-12 col-md-12">
											<input type="email" name="email" class="email form-control" required>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<div class="row mb-3">
												<div class="form-group col-md-6">
													<label class="col-md-12 text-left mt-2">Data de nascimento <span class="text-danger">*</span></label>
													<div class="col-lg-12 col-md-12">
														<input type="date" class="data_nascimento form-control" name="data_nascimento" placeholder="00/00/0000" required>
													</div>
												</div>
												<div class="form-group col-md-6">
													<label class="col-md-12 text-left mt-2">Telefone ou Celular <span class="text-danger">*</span></label>
													<div class="col-lg-12 col-md-12">
														<input type="text" class="form-control telefone" name="telefone" placeholder="(00) 00000-0000" minlength="14" required>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="mx-auto col-lg-5 col-md-5">
											<button class="btn btn-icon icon-right btn-success btn-block" id="submit">Continue <i class="fas fa-arrow-right"></i></button>
										</div>
									</div>
								</div>
							</form>
							<!-- Entrega -->
							<form class="wizard-content mt-5 mt-md-0 d-none" id="step2">
								@csrf
								<input type="hidden" name="formcount" value="2">
								<div class="wizard-pane">
									<div class="form-group row px-3 mb-3">
										<label class="col-md-12 text-left">CEP <span class="text-danger">*</span></label>
										<div class="col-lg-5 col-md-5">
											<input type="text" name="cep" id="cep" class="form-control" maxlength="8" required>
										</div>
										<div class="col-lg-5 px-0 my-auto col-md-5">
											<label class="country"></label>
											<input id="cidade" type="hidden" name="cidade">
											<input id="estado" type="hidden" name="estado">
										</div>
									</div>
									<div class="form-group mb-3">
										<label class="col-md-12 text-left">Endereço <span class="text-danger">*</span></label>
										<div class="col-lg-12 col-md-12">
											<input type="text" name="endereco" id="endereco" class="form-control" onkeyup="this.value = this.value.toUpperCase();" disabled required>
										</div>
									</div>
									<div class="form-group mb-0">
										<div class="row">
											<div class="form-group col-6">
												<label class="col-md-12 text-left mt-2">Bairro <span class="text-danger">*</span></label>
												<div class="col-lg-12 col-md-12">
													<input type="text" class="form-control" name="bairro" id="bairro" onkeyup="this.value = this.value.toUpperCase();" disabled required>
												</div>
											</div>
											<div class="form-group col-6">
												<label class="col-md-12 text-left mt-2">Número <span class="text-danger">*</span></label>
												<div class="col-lg-8 col-md-8">
													<input type="number" class="form-control" name="numero" id="numero" disabled required>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group mb-3">
										<label class="col-md-12 text-left mt-2">Complemento</label>
										<div class="col-lg-11 col-md-11">
											<input type="text" class="form-control" name="complemento" placeholder="Ex. CASA, APT. 01, ANX
											2 " onkeyup="this.value = this.value.toUpperCase();">
										</div>
									</div>
									<div class="form-group mb-3">
										<label class="col-md-12 text-left mt-2">Destinatário <span class="text-danger">*</span></label>
										<div class="col-lg-10 col-md-10">
											<input type="text" class="form-control" name="destinatario" onkeyup="this.value = this.value.toUpperCase();" required>
										</div>
									</div>
									<div class="form-group row pt-3">
										<div class="mx-auto col-lg-5 col-md-5">
											<button class="btn btn-icon icon-right btn-success  btn-block" id="submit">Continue <i class="fas fa-arrow-right"></i></button>
										</div>
									</div>
									<input type="hidden" name="tipo" value="Normal">
									<input type="hidden" name="valor_envio" value="19.83">
									<input type="hidden" name="prazo_envio" value="2020-01-23">
								</div>
							</form>
							<!-- Formas de pagamento-->
							<div class="wizard-content col-12 col-md-9 my-md-4 mb-4 my-2 mx-auto d-none" id="step3"> 
								<div class="row border rounded px-3 py-3 text-center my-2" id="pay1">
									<div class="d-none d-md-block">
										<img src="https://image.flaticon.com/icons/png/512/126/126244.png" class="" width="50" height="50">
									</div>
									<div class="text-left pl-md-3">
										<label>Cartão de Crédito</label>
										<div class="card-brands-payment cards mt10">
											<img src="https://github.bubbstore.com/formas-de-pagamento/amex.svg?" height="20" alt="American Express" class="mr5">
											<img src="https://github.bubbstore.com/formas-de-pagamento/visa.svg?" height="20" alt="Visa" class="mr5">
											<img src="https://github.bubbstore.com/formas-de-pagamento/diners.svg?" height="20" alt="Diners" class="mr5">
											<img src="https://github.bubbstore.com/formas-de-pagamento/mastercard.svg?" height="20" alt="Mastercard" class="mr5">
											<img src="https://github.bubbstore.com/formas-de-pagamento/discover.svg?" height="20" alt="Discover" class="mr5">
											<img src="https://github.bubbstore.com/formas-de-pagamento/aura.svg?" height="20" alt="Aura" class="mr5">
											<img src="https://github.bubbstore.com/formas-de-pagamento/hipercard.svg?" height="20" alt="Hipercard" class="mr5">
										</div>
									</div>
									<div class="my-auto ml-auto">
										<div class="selectgroup selectgroup-pills">
											<label class="selectgroup-item" style="border: 1px solid silver; border-radius: 50%;">
												<input type="radio" name="icon-input" value="1" class="boleto selectgroup-input border rounded-circle">
												<span class="selectgroup-button selectgroup-button-icon" style="height: 16px;min-width: 1px;margin: 3px;"></span>
											</label>
										</div>
									</div>
									<form class="col-12 mt-5 mt-md-0 d-none" id="card_credit">
										@csrf
										<input type="hidden" name="formcount" value="3">
										<input type="hidden" name="card_hash" id="card_hash">
										<div class="wizard-pane mt-5">
											<div class="form-group mb-3">
												<label class="col-md-12 text-left">Número do cartão <span class="text-danger">*</span></label>
												<div class="col-lg-12 col-md-12">
													<input type="text" id="card_number" class="card_number form-control creditcard" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off  maxlength="16" placeholder="4509 9535 6623 3704" requerid>
													<div id="field_errors_number" class="pt-1 text-danger text-left">
													</div>
												</div>
											</div>
											<div class="form-group mb-3">
												<label class="col-md-12 text-left">Nome impresso <span class="text-danger">*</span></label>
												<div class="col-lg-10 col-md-10">
													<input type="text" id="card_holder_name" class="form-control" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off class="form-control" requerid>
													<div id="field_errors_name" class="pt-1 text-danger text-left">
													</div>
												</div>
											</div>
											<div class="form-group mb-3">
												<label class="col-md-12 text-left mt-2">Data Vencimento <span class="text-danger">*</span></label>
												<div class="col-lg-8 col-md-8">
													<input type="text" id="card_expiration" class="card_expiration form-control" maxlength="4" placeholder="00/00" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off class="form-control" requerid>
													<div id="field_errors_date" class="pt-1 text-danger text-left">
													</div>
												</div>
											</div>
											<div class="form-group mb-3">
												<label class="col-md-12 text-left mt-2">CCV <span class="text-danger">*</span></label>
												<div class="col-lg-6 col-md-6">
													<input type="text" id="card_cvv" class="form-control" maxlength="3" placeholder="000" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" requerid>
													<div id="field_errors_cvv" class="pt-1 text-danger text-left">
													</div>
												</div>
											</div>

											<div class="form-group mb-3">
												<label class="col-md-12 text-left mt-2">CPF do titular <span class="text-danger">*</span></label>
												<div class="col-lg-8 col-md-8">
													<input type="text" id="cpf_titular" class="form-control" maxlength="3" placeholder="000" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" requerid>
													<div id="field_errors_cpf" class="pt-1 text-danger text-left">
													</div>
												</div>
											</div>

											<div class="form-group mb-4">
												<label class="col-md-12 text-left mt-2">Parcelamento</label>
												<div class="col-lg-8 col-md-8">
													<select class="form-control h-100" name="installments">
														<option value="1">1x de R$ {{ number_format($produto->preco_venda/1, 2 , ",", ".") }}</option>
														<option value="2">2x de R$ {{ number_format($produto->preco_venda/2, 2 , ",", ".") }}</option>
														<option value="3">3x de R$ {{ number_format($produto->preco_venda/3, 2 , ",", ".") }}</option>
														<option value="4">4x de R$ {{ number_format($produto->preco_venda/4, 2 , ",", ".") }}</option>
														<option value="5">5x de R$ {{ number_format($produto->preco_venda/5, 2 , ",", ".") }}</option>
														<option value="6">6x de R$ {{ number_format($produto->preco_venda/6, 2 , ",", ".") }}</option>
														<option value="7">7x de R$ {{ number_format($produto->preco_venda/7, 2 , ",", ".") }}</option>
														<option value="8">8x de R$ {{ number_format($produto->preco_venda/8, 2 , ",", ".") }}</option>
														<option value="9">9x de R$ {{ number_format($produto->preco_venda/9, 2 , ",", ".") }}</option>
														<option value="10">10x de R$ {{ number_format($produto->preco_venda/10, 2 , ",", ".") }}</option>
														<option value="11"> 11x de R$ {{ number_format($produto->preco_venda/11, 2 , ",", ".") }}</option>
														<option value="12">12x de R$ {{ number_format($produto->preco_venda/12, 2 , ",", ".") }}</option>
													</select>
												</div>
											</div>

											<div class="form-group row pt-3">
												<div class="mx-auto col-lg-8 col-md-8">
													<button type="submit" class="btn btn-icon icon-right btn-success btn-block text-uppercase">Finalizar compra</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="row border rounded px-3 py-3 text-center my-2" id="pay2">
									<div>
										<img src="https://i0.wp.com/audiconsc.com/site/wp-content/uploads/2018/01/cards-boleto.png?fit=569%2C376&ssl=1" class="" width="50" height="40">
									</div>
									<div class="text-left pl-3">
										<label class="py-2">Boleto bancário</label>
									</div>
									<div class="my-auto ml-auto">
										<div class="selectgroup selectgroup-pills">
											<label class="selectgroup-item" style="border: 1px solid silver; border-radius: 50%;">
												<input type="radio" name="icon-input" value="2" class="boleto selectgroup-input border rounded-circle">
												<span class="selectgroup-button selectgroup-button-icon" style="height: 16px;min-width: 1px;margin: 3px;"></span>
											</label>
										</div>
									</div>
									<form class="text-justify mt-4 d-none" id="boleto">
										@csrf
										<input type="hidden" name="formcount" value="4">
										<div class="px-3">
											<b><label>{{$checkout->texto_boleto}}</label></b>
										</div>
										<div class="pt-3 px-3 text-center">
											<h4><b class="text-muted">Valor do produto:</b> R$ {{ number_format($produto->preco_venda,2, ",", ".") }} </h4>
										</div>
										<div class="form-group row pt-4">
											<div class="mx-auto col-lg-8 col-md-8">
												<button type="submit" class="btn btn-icon icon-right btn-success btn-block text-uppercase">Finalizar compra</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="status"></div>
						</div>
					</div>
				</div>
			</div>

			<!-- Card 2 -->
			<div class="col-12 col-md-5 col-sm-12 my-3 order-1 order-md-2">
				<div class="card text-center py-3 mb-0 mx-3 mx-md-0">
					<div class="pt-2">
						<h3>Resumo da Compra</h3>
					</div>
					<hr class="mx-5">
					<div class="row mx-auto">
						@if($produto->quantidade <= $produto->quantidade_minima)
						<div class="col-10 alert alert-success text-center mx-auto">
							<p><b>Parabéns</b>! Você conseguiu receber as <b>últimas </b>unidades.</p>
							<i class="fas fa-clock"></i> Oferta termina em <b><span class="getting-started text-dark"></span></b>
						</div>
						@endif
						<div class="p-3 col-10 col-md-10 mx-auto">
							<div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
			                     <div class="carousel-inner">
			                        <div class="carousel-item active">
			                          <img class="rounded d-block w-100" src="{{ (isset($produto->RelationImagensPrincipal) ? asset('storage/app/'.$produto->RelationImagensPrincipal->first()->caminho) : asset('public/img/product.png') ) }}" style="height: 230px">
			                        </div>

			                        @if(!empty($produto->RelationImagens->first()))
                                        @foreach ($produto->RelationImagens as $imagens)
				                        <div class="carousel-item">
				                          <img class="rounded d-block w-100" src="{{ asset('storage/app/'.$imagens->caminho).'?'.rand() }}" style="height: 230px">
				                        </div>
				                        @endforeach
			                        @endif
			                     </div>

			                     <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button" data-slide="prev">
			                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			                        <span class="sr-only">Anterior</span>
			                     </a>
			                     <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button" data-slide="next">
			                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
			                        <span class="sr-only">Próxima</span>
			                     </a>
		                    </div>
						</div>
						<div class="py-2 col-12 col-md-12 my-auto">
							<h5>{{ $produto->nome }}</h5>
							<input type="hidden" class="pedido-id" value="{{ $pedido->id }}">
						</div>
						<div class="text-center col-12 px-4">
							<div class="alert alert-light" role="alert">
								<p>Descontos - R$ {{ number_format($produto->preco_venda - $produto->preco_promocional, 2 , ",", ".") }}</p>
								<b>Valor: R$ {{ number_format($produto->preco_venda,2, ",", ".") }} ou até 12x de R$ {{ number_format($produto->preco_venda/12, 2 , ",", ".") }} *</b>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>

	<!--<footer class="h-100 py-3 col-12 bg-white text-center">
		<label>Todos os direitos reservados a Capsul.</label><br>
		<label>CNPJ: 22.352.852/0001-36</label>
	</footer>-->
</div>

@section('support')
<script src="{{ asset('public/js/validations.js') }}"></script>
@endsection 

@include('template.footer')