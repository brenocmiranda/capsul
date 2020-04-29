
<div id="app" class="h-100">
	<section class="h-100">
		<div class="position-absolute w-100 vh-100 m-0" style="z-index: -1">
			<div class="d-flex h-100">
				<img src="{{ asset('public/img/bg_banner.png') }}" class="mt-auto w-100 h-75" style="transform: rotate(180deg);">
			</div>
		</div>

		<div class="absolute-center text-center m-auto" style="width: 500px !important;">
			
			<div class="py-4">
				<img src="{{ asset('storage/app/system/capsul.png') }}" alt="logo" width="200">
			</div>

			<div class="text-dark px-5">
				<div class="card shadow mb-4">
					<div class="card-header">
						<h5 class="mx-auto my-auto">Seu primeiro acesso</h5>
					</div>
					<div class="card-body text-left">
						<form method="POST" enctype="multipart/form-data" action="{{route('novo')}}">
							@csrf
							<div class="text-left mx-3">
								<h6 class="my-2">Seja bem-vindo, {{explode(" ", Auth::user()->nome)[0]}}!</h6>
								<label>Detectamos que este é seu primeiro acesso, cadastre sua nova senha para acessar a nova plataforma.</label>
							</div>							
							<div class="col-12 my-3">
								<label><b>Nova senha:</b></label>
								<input type="password" class="password form-control" placeholder="******" name="password" minlength="6">
							</div>
							<div class="col-12 my-3">
								<label><b>Confirme senha:</b></label>
								<input type="password" class="confirmpassword form-control" placeholder="******" name="confirmpassword" minlength="6">
								<input type="hidden" name="id" value="{{Auth::user()->id}}">
							</div>
							<div id="err"></div>
							<div class="col-12 mt-4 mb-3 text-center">
								<button type="submit" class="btn btn-secondary btn-lg btn-icon icon-left col-5 mx-1 shadow-none" id="submit" disabled>
									<span>Salvar</span>
									<i class="mdi mdi-check"></i> 
								</button>
							</div>
							
						</form>
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
		$('.password, .confirmpassword').on('keyup', function(){
			$('#err').html('');
			if($('.password').val() == $('.confirmpassword').val()){
				if($('.password').val().length >= 6 && $('.confirmpassword').val().length >= 6){
					$('#submit').removeAttr('disabled');
					$('#submit').addClass('btn-success');
				}else{
					$('#err').html('<div class="text-danger text-center col"> São necessários no mínimo 6 caracteres.</div>')
				}
			}else{
				$('#submit').attr('disabled', 'disabled');
				$('#submit').removeClass('btn-success');
			}
		});
	});
	
</script>
@endsection