<!-- Dados Pessoais -->
<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
	<div class="card">
		<div class="card-body">
			<form id="step1">
				@csrf
				<div>
					<div class="col-12 mt-3">
						<h6> Dados Pessoais </h6>
						<hr class="mt-1">
					</div>
					<div class="form-group col-md-6 p-0 mb-3">
						<label class="col-md-12 text-left mb-0">Documento <small>CPF/CNPJ</small> <span class="text-danger">*</span></label>
						<div class="col-lg-12 col-md-12">
							<input type="text" id="documento" class="form-control" name="documento" required>
						</div>
					</div>
					<div class="form-group mb-3">
						<label class="col-md-12 text-left mb-0">Nome <span class="text-danger">*</span></label>
						<div class="col-lg-12 col-md-12">
							<input type="text" name="nome" id="nome" class="form-control" onkeyup="this.value = this.value.toUpperCase();" required>
						</div>
					</div>
					<div class="form-group mb-3">
						<label class="col-md-12 text-left mb-0">Email <span class="text-danger">*</span></label>
						<div class="col-lg-12 col-md-12">
							<input type="email" name="email" id="email" class="form-control" required>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="row mb-0">
								@if($checkout->data_nascimento == 1)
								<div class="form-group col-md-6">
									<label class="col-md-12 text-left mb-0">Data de nascimento <span class="text-danger">*</span></label>
									<div class="col-lg-12 col-md-12">
										<input type="date" class="form-control" name="data_nascimento" id="data_nascimento" placeholder="00/00/0000" required>
									</div>
								</div>
								@endif
								<div class="form-group col-md-6">
									<label class="col-md-12 text-left mb-0">Telefone ou Celular <span class="text-danger">*</span></label>
									<div class="col-lg-12 col-md-12">
										<input type="text" class="form-control telefone" name="telefone" id="telefone" placeholder="(00) 00000-0000" minlength="14" required>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group mb-0">
						<div class="ml-auto col-lg-5 col-md-5">
							<button class="btn btn-success btn-lg btn-icon icon-right btn-block shadow-none">Continue <i class="mdi mdi-send"></i></button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>