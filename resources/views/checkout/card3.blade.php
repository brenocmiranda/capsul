<!-- Formas de pagamento-->
<div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
	<div class="card">
		<div class="card-body">
			
			@if($checkout->cumpom_desconto == 1)
			<form class="row m-0" id="descontos">
				<div class="col-12 mt-3">
					<h6> Descontos </h6>
					<hr class="mt-1">
				</div>
				<div class="col-12 form-group">
                    <label class="mb-0">Cupom </label>
                    <div class="input-group">
                        <input type="text" class="form-control h-100 col-4" onkeyup="this.value = this.value.toUpperCase();" required>
                        <div class="input-group-append border rounded">
                            <a class="btn mx-2 pb-0 text-uppercase gerar">Aplicar</a>
                        </div>
                    </div>
                </div>
			</form>
			@endif

			<div class="row m-0 mb-2" id="step3"> 
				<div class="col-12 mt-2">
					<h6> Formas de pagamento </h6>
					<hr class="mt-1">
				</div>
				<ul class="col-12 nav nav-pills px-3" id="myTab" role="tablist">
					<li class="nav-item w-50 p-2">
						<a class="nav-link h-100 shadow-none border rounded {{($checkout->pagamento_preferencial == 'Cartão crédito' ? 'active' : '')}}" id="cart-tab" data-toggle="tab" href="#cart" role="tab" aria-controls="cart" aria-selected="true">
							<div class="row m-0 p-2 h-100" style="line-height: 20px;">
								<div class="col-2 p-0 m-auto">
									<i class="mdi mdi-credit-card-outline mdi-36px"></i>
								</div>
								<div class="col-10 p-3 m-auto">
									<span class="font-weight-bold">Cartão de Crédito</span>
									<div class="card-brands-payment cards text-truncate">
										<img src="https://github.bubbstore.com/formas-de-pagamento/mastercard.svg?" height="15" alt="Mastercard" class="mr5">
										<img src="https://github.bubbstore.com/formas-de-pagamento/visa.svg?" height="15" alt="Visa" class="mr5">
										<img src="https://github.bubbstore.com/formas-de-pagamento/elo.svg?" height="15" alt="Elo" class="mr5">
										<img src="https://github.bubbstore.com/formas-de-pagamento/hipercard-v2.svg?" height="15" alt="Hipercard" class="mr5">
										<img src="https://github.bubbstore.com/formas-de-pagamento/diners.svg?" height="15" alt="Diners" class="mr5">
									</div>
								</div>
							</div>
						</a>
					</li>
					<li class="nav-item w-50 p-2">
						<a class="nav-link h-100 shadow-none border rounded {{($checkout->pagamento_preferencial == 'Boleto' ? 'active' : '')}}" id="boleto-tab" data-toggle="tab" href="#boleto" role="tab" aria-controls="boleto" aria-selected="false">
							<div class="row m-0 p-2 h-100" style="line-height: 20px;">
								<div class="col-2 p-0 m-auto">
									<i class="mdi mdi-barcode mdi-36px"></i>
								</div>
								<div class="col-10 p-3 m-auto">
									<span class="font-weight-bold">Boleto</span>
								</div>
							</div>
						</a>
					</li>
				</ul>

				<div class="tab-content col-12" id="myTabContent">
					<div class="tab-pane fade {{($checkout->pagamento_preferencial == 'Cartão crédito' ? 'show active' : '')}}" id="cart" role="tabpanel" aria-labelledby="cart-tab">
						<form class="col-12 mt-3" id="card_credit">
							@csrf
							<input type="hidden" name="card_hash" id="card_hash">
							<div class="form-group mb-2">
								<label class="col-md-12 mb-0">Número do cartão <span class="text-danger">*</span></label>
								<div class="col-lg-12 col-md-12">
									<input type="text" id="card_number" class="form-control creditcard" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off  maxlength="16" placeholder="4509 9535 6623 3704" requerid>
									<div id="field_errors_number" class="pt-1 text-danger text-left">
									</div>
								</div>
							</div>
							<div class="form-group mb-2">
								<label class="col-md-12 mb-0">Nome impresso <span class="text-danger">*</span></label>
								<div class="col-lg-10 col-md-10">
									<input type="text" id="card_holder_name" class="form-control" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off class="form-control" requerid>
									<div id="field_errors_name" class="pt-1 text-danger text-left">
									</div>
								</div>
							</div>
							<div class="row m-0">
								<div class="col-4 p-0 form-group mb-2">
									<label class="col-lg-12 col-md-12 mb-0">Data Vencimento <span class="text-danger">*</span></label>
									<div class="col-lg-12 col-md-12">
										<input type="text" id="card_expiration" class=" form-control" maxlength="4" placeholder="00/00" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off class="form-control" requerid>
										<div id="field_errors_date" class="pt-1 text-danger text-left">
										</div>
									</div>
								</div>
								<div class="col-3 p-0 form-group mb-2">
									<label class="col-lg-12 col-md-12 mb-0">CCV <span class="text-danger">*</span></label>
									<div class="col-lg-12 col-md-12">
										<input type="text" id="card_cvv" class="form-control" maxlength="3" placeholder="000" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" requerid>
										<div id="field_errors_cvv" class="pt-1 text-danger text-left">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group mb-2">
								<label class="col-lg-6 col-md-6 mb-0">CPF do titular <span class="text-danger">*</span></label>
								<div class="col-lg-6 col-md-6">
									<input type="text" name="documento_titular" class="documento_titular form-control" placeholder="000.000.000-00" requerid>
									<div id="field_errors_cpf_cart" class="pt-1 text-danger text-left">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12 mb-0">Parcelamento <span class="text-danger">*</span></label>
								<div class="col-lg-8 col-md-8">
									<select class="form-control h-100" name="installments" id="installments" requerid>
										<option disabled> Selecione </option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<button class="btn btn-success btn-lg btn-icon icon-right btn-block shadow-none col-12 col-lg-6 mx-auto">Pagar com cartão de crédito</button>
								</div>
							</div>
						</form>
					</div>

					<div class="tab-pane fade {{($checkout->pagamento_preferencial == 'Boleto' ? 'show active' : '')}}" id="boleto" role="tabpanel" aria-labelledby="boleto-tab">
						<form class="col-12 text-justify mt-4" id="boleto">
							@csrf
							<input type="hidden" name="formcount" value="4">
							<div class="px-3">
								<b><label style="line-height: 20px;">{{$checkout->texto_boleto}}</label></b>
							</div>
							<div class="form-group text-left col-6 p-0">
								<label class="col-md-12 text-left mb-0">CPF do pagador <span class="text-danger">*</span></label>
								<div class="col-lg-12 col-md-12">
									<input type="text" class="documento_titular form-control" name="documento_titular" placeholder="000.000.000-00" minlength="14" required>
									<div id="field_errors_cpf_boleto" class="pt-1 text-danger text-left">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<button class="btn btn-success btn-lg btn-icon icon-right btn-block shadow-none col-12 col-lg-6 mx-auto">Pagar com boleto</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="my-4 col-12 mx-auto text-center" id="pedido-status" style="display:none;">
				<div> 
					<img src="" class="mx-auto col-4" id="pedido-image"> 
				</div> 
				<div class="mt-3"> 
					<h3 id="pedido-nome"></h3> 
				</div> 
				<label>
					<span>Seu número de pedido é:</span>
					<b>{{$pedido->codigo}}</b>
				</label>
				<div class="mt-4"> 
					<h6 id="pedido-message" style="line-height: 28px;">
					</h6>
					<a href="javascript:void(0)" id="pedido-link">Acompanhamento do pedido</a> 
				</div> 
			</div>


		</div>
	</div>
</div>
<!-- Formas de pagamento-->
