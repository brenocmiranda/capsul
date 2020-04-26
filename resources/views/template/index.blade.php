@include('template.header')

<div id="app">
	<div class="main-wrapper">
		<div class="navbar-bg"></div>

		@include('template.sidebar')		

		@include('template.navbar')	

		@yield('content')

	</div>
</div>

@yield('modal')

@include('template.footer')
