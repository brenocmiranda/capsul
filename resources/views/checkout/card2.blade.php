<!-- Entrega -->
<div class="tab-pane fade" id="enderecos" role="tabpanel" aria-labelledby="enderecos-tab">
	<div class="card">
		<div class="card-body">
			
			<form id="step2">
				@csrf	
				<div class="col-12 mt-3">
					<h6> Endereços </h6>
					<hr class="mt-1">
				</div>	
				<div class="row enderecos-list px-3">
					
					<div class="col-6 p-2" style="line-height: 19px;">
						<a href="javascript:void(0)" class="text-center text-secondary text-decoration-none my-auto" id="buttonNewEndereco"> 
							<div class="border p-3 rounded h-100">
								<div class="h-100 row align-items-center justify-content-center">
									<i class="col-12 mdi mdi-plus mdi-36px d-block"></i>
									<label class="col-12 d-block mb-0">Novo endereço</label>
								</div>
							</div>
						</a>
					</div>	
				</div>
				<div class="col-12 mt-3">
					<h6> Formas de envio </h6>
					<hr class="mt-1">
				</div>
				<div class="row px-3 envio">
					<label class="col-12 mt-n2">Selecione um endereço acima e veja as formas de envio disponíveis.</label>
				</div>

				<div class="form-group mt-4 mb-0">
					<div class="ml-auto col-lg-5 col-md-5">
						<button class="btn btn-success btn-lg btn-icon icon-right btn-block shadow-none" disabled>Continue <i class="mdi mdi-send"></i></button>
					</div>
				</div>
			</form>
			
			<form id="newEndereco" class="d-none">
			@csrf	
				<input type="hidden" name="acao" value="">
				<div class="form-group row px-3 mb-3">
					<label class="col-md-12 text-left mb-0">CEP <span class="text-danger">*</span></label>
					<div class="col-lg-5 col-md-5">
						<input type="text" name="cep" id="cep" class="form-control" maxlength="8" required>
					</div>
					<div class="col-lg-5 px-0 my-auto col-md-5">
						<label class="country mb-0 font-weight-bold"></label>
						<input id="cidade" type="hidden" name="cidade" required>
						<input id="estado" type="hidden" name="estado" required>
					</div>
				</div>
				<div class="form-group mb-3">
					<label class="col-md-12 text-left mb-0">Endereço <span class="text-danger">*</span></label>
					<div class="col-lg-12 col-md-12">
						<input type="text" name="endereco" id="endereco" class="form-control" onkeyup="this.value = this.value.toUpperCase();"  required>
					</div>
				</div>
				<div class="row mb-0">
					<div class="form-group mb-3 col-6 mb-0">
						<label class="col-md-12 text-left mb-0">Bairro <span class="text-danger">*</span></label>
						<div class="col-lg-12 col-md-12">
							<input type="text" class="form-control" name="bairro" id="bairro" onkeyup="this.value = this.value.toUpperCase();"  required>
						</div>
					</div>
					<div class="form-group mb-3 col-6 mb-0">
						<label class="col-md-12 text-left mb-0">Número <span class="text-danger">*</span></label>
						<div class="col-lg-8 col-md-8">
							<input type="number" class="form-control" name="numero" id="numero" required>
						</div>
					</div>
				</div>
				<div class="form-group mb-3">
					<label class="col-md-12 text-left mb-0">Complemento</label>
					<div class="col-lg-11 col-md-11">
						<input type="text" class="form-control" name="complemento" id="complemento" placeholder="Ex. CASA, APT. 01, ANX. 2 " onkeyup="this.value = this.value.toUpperCase();">
					</div>
				</div>
				<div class="form-group mb-3">
					<label class="col-md-12 text-left mb-0">Destinatário <span class="text-danger">*</span></label>
					<div class="col-lg-10 col-md-10">
						<input type="text" class="form-control" name="destinatario" id="destinatario" onkeyup="this.value = this.value.toUpperCase();" required>
					</div>
				</div>

				<div class="form-group mt-4 row mb-2">
					<div class="ml-auto px-2">
						<a href="javascript:void(0)" id="buttonVoltarEndereco" class="btn btn-primary btn-lg btn-icon icon-left shadow-none">
							<i class="mdi mdi-arrow-left"></i>  
							<span>Endereços</span>
						</a>
					</div>
					<div class="mr-auto px-2">
						<button class="btn btn-success btn-lg btn-icon icon-left shadow-none">
							<i class="mdi mdi-check"></i> 
							<span>Salvar </span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>	