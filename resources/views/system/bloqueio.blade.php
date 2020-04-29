@section('title')
Bloqueio de Zona
@endsection

@include('template.header')

<div class="h-100">
	<section class="h-100 section">
		<div class="position-absolute w-100 vh-100 m-0" style="z-index: -1;">
			<div class="d-flex h-100">
				<img src="{{ asset('public/img/bg_banner1.png') }}" class="mt-auto w-100 h-50 fixed-bottom" style="transform: rotate(180deg);">
			</div>
		</div>

		<div class="section-header p-0">
			<header class="col-12 bg-white">
				<div class="container row m-auto">
					<div class="col-6">
						<div class="row h-100 align-items-center justify-content-start">
							<div class="col-sm-12 col-md-2 py-sm-0 my-3 text-center">
								<img src="{{ asset('storage/app/system/capsul.png') }}" width="148" title="Logo Capsul">
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="row h-100 align-items-center justify-content-end">
							<img src="https://dka575ofm4ao0.cloudfront.net/pages-transactional_logos/retina/1949/PagarMe_Logo_PRINCIPAL-02.png" height="30" alt="PagarME" class="mb-2">
						</div>
					</div>
				</div>
			</header>
		</div>

		<div class="row h-100">
			<div class="mt-5 mx-auto text-center">
				<i class="mdi mdi-lock-outline mdi-48px mdi-dark"></i>
				<h5> Você não pode acessar esse conteúdo. Tente iniciar de outro dispositivo!</h5>
			</div>
		</div>
	</section>
</div>

@include('template.footer')

