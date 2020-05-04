<!-- Entrega -->
<div class="tab-pane fade {{((!isset($pedido->id_endereco) || !isset($pedido->id_rastreamento)) && isset($pedido->id_cliente) && Request::segment(2) == 'continuar' ? 'show active' : '')}}" id="enderecos" role="tabpanel" aria-labelledby="enderecos-tab">
	<div class="card">
		<div class="card-header">
			<h5 class="section-title my-0">Endereços</h5>
		</div>
		<div class="card-body px-0">
			<form id="step2">
				@csrf	
				<div class="row enderecos-list px-5">
					@if(Request::segment(2) == "continuar")
						@if($enderecos)
							@foreach($enderecos as $end)
								<div class="chw col-6 px-2 pb-2 end{{$end->id}}" style="line-height: 19px;"> 
									<div class="h-100 border rounded row m-0 p-3 text-left"> 
										<div class="form-check w-100 col-12 pr-0"> 
											<input type="radio" name="endereco" value="{{$end->id}}" class="form-check-input" id="exampleRadios{{$end->id}}" onclick="freteUteis({{$end->id}})"> 
											<label class="form-check-label" for="exampleRadios{{$end->id}}"> 
												<label class="d-block font-weight-bold mb-0">{{$end->destinatario}}</label> 
												<small class="d-block mb-0">{{$end->endereco}}, {{$end->numero}}, {{(isset($end->complemento) ? $end->complemento.', ' : '')}}{{$end->bairro}}</small> 
												<small class="d-block mb-0">{{$end->cidade}} - {{$end->estado}}</small>
												<small class="d-block mb-0">{{substr($end->cep, 0, 5)}}-{{substr($end->cep, 5, 8)}}</small> 
											</label> 
										</div>
										<div class="w-100 text-right col-12 p-0 align-self-end"> 
											<a href="javascript:void(0)" class="" onclick="updateEndereco({{$end->id}})"> 
												<i class="ml-auto mdi mdi-pencil"></i> 
												<small>Editar</small> 
											</a>
										</div>
									</div>
								</div>
							@endforeach
						@endif
					@endif
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
				<div class="card-header mb-3">
					<h5 class="section-title my-0">Formas de envio</h5>
				</div>
				<div class="row px-5 envio">
					<label class="col-12">Selecione um endereço acima e veja as formas de envio disponíveis.</label>
				</div>

				<div class="form-group mt-4 mb-0 px-4">
					<div class="ml-auto col-lg-5 col-md-5">
						<button class="btn btn-success btn-lg btn-icon icon-right btn-block shadow-none" disabled>Continue <i class="mdi mdi-send"></i></button>
					</div>
				</div>
			</form>
			
			<form id="newEndereco" class="px-4 d-none">
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
							<span>Voltar</span>
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