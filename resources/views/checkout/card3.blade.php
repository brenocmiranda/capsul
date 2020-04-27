<!-- Formas de pagamento-->
<div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
	<div class="card">
		<div class="card-body">
			
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

			<div class="row m-0" id="step3"> 
				<div class="col-12 mt-2">
					<h6> Formas de pagamento </h6>
					<hr class="mt-1">
				</div>
				<ul class="col-12 nav nav-pills px-3" id="myTab" role="tablist">
					<li class="nav-item w-50 p-2">
						<a class="nav-link h-100 shadow-none border rounded" id="cart-tab" data-toggle="tab" href="#cart" role="tab" aria-controls="cart" aria-selected="true">
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
						<a class="nav-link h-100 shadow-none border rounded" id="boleto-tab" data-toggle="tab" href="#boleto" role="tab" aria-controls="boleto" aria-selected="false">
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
					<div class="tab-pane fade show" id="cart" role="tabpanel" aria-labelledby="cart-tab">
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
									<input type="text" class="documento_titular form-control" placeholder="000.000.000-00" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" requerid>
									<div id="field_errors_cpf" class="pt-1 text-danger text-left">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12 mb-0">Parcelamento <span class="text-danger">*</span></label>
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
							<div class="form-group">
								<div class="row">
									<button class="btn btn-success btn-lg btn-icon icon-right btn-block shadow-none col-12 col-lg-6 mx-auto">Pagar com cartão de crédito</button>
								</div>
							</div>
						</form>
					</div>

					<div class="tab-pane fade" id="boleto" role="tabpanel" aria-labelledby="boleto-tab">
						<form class="col-12 text-justify mt-4" id="boleto">
							@csrf
							<input type="hidden" name="formcount" value="4">
							<div class="px-3">
								<b><label style="line-height: 20px;">{{$checkout->texto_boleto}}</label></b>
							</div>
							<div class="form-group text-left col-6 p-0">
								<label class="col-md-12 text-left mb-0">Documento <small>CPF/CNPJ</small> <span class="text-danger">*</span></label>
								<div class="col-lg-12 col-md-12">
									<input type="text" class="documento_titular form-control" name="documento_titular" placeholder="000.000.000-00" minlength="14" required>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<button class="btn btn-success btn-lg btn-icon icon-right btn-block shadow-none col-12 col-lg-6 mx-auto">Pagar boleto</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="my-4 col-12 mx-auto text-center d-none" id="pedido-confirmation">
				<div id="pedido-image"> 
					<img src="../public/img/status-pagamento/aprovado.png" class="mx-auto col-4"> 
				</div> 
				<div class="mt-3"> 
					<h3 id="pedido-status"></h3> 
				</div> 
				<h6>
					<span>Seu número de pedido é:</span>
					<b>{{$pedido->codigo}}</b>
				</h6>
				<div class="mt-5"> 
					<h6 class="mb-0 pedido-message">
					</h6>
					<a href="javascript:void(0)">Acompanhamento do pedido</a> 
				</div> 
			</div>


		</div>
	</div>
</div>
<!-- Formas de pagamento-->
