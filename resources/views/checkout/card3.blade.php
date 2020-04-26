<!-- Formas de pagamento-->
<div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
	<div class="card">
		<div class="card-body">
			<div class="wizard-content col-12 col-md-9 my-md-4 mb-4" id="step3"> 
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
							<label class="selectgroup-item border rounded-circle">
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
									<button type="submit" class="btn btn-success btn-block text-uppercase">Finalizar compra</button>
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
							<label class="selectgroup-item border rounded-circle">
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
								<button type="submit" class="btn btn-success shadow-none btn-block text-uppercase">Finalizar compra</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Formas de pagamento-->
