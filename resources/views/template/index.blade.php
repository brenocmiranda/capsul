@include('template.header')

	@if(!empty(Auth::user()->email_verified_at))
		<div id="app">
			<div class="main-wrapper">
				<div class="navbar-bg"></div>

				@include('template.sidebar')		

				@include('template.navbar')	

				@yield('content')

			</div>
		</div>
		@yield('modal')
	@else
		@include('system.primeiroAcesso')
	@endif

@include('template.footer')

