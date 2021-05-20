<!-- Card 1 -->
<div class="col-lg-2 col-md-2 col-12 my-3" id="myTab">
	<ul class="nav nav-pills flex-column" role="tablist">
	  <li class="nav-item shadow rounded my-2 bg-white">
	  	@if(Request::segment(2) == "continuar")
	  		<a class="nav-link p-3 {{(isset($pedido->id_cliente) ? 'bg-success text-white' : 'active')}}" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
		    	<i class="mdi mdi-account-outline mdi-24px"></i> 
		    	<span class="font-weight-bold px-3 px-lg-2">Dados Pessoais</span>
		    	<i></i>
			</a>
	  	@else
		  	<a class="nav-link p-3 active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
		    	<i class="mdi mdi-account-outline mdi-24px"></i> 
		    	<span class="font-weight-bold px-3 px-lg-2">Dados Pessoais</span>
		    	<i></i>
			</a>
	  	@endif
	  </li>
	  <li class="nav-item shadow rounded my-2 bg-white">
	    @if(Request::segment(2) == "continuar")
			<a class="nav-link p-3 {{(isset($pedido->id_endereco) && isset($pedido->id_rastreamento) && isset($pedido->id_cliente) ? 'bg-success text-white' : (isset($pedido->id_cliente) ? 'active' : 'disabled'))}}" id="enderecos-tab" data-toggle="tab" href="#enderecos" role="tab" aria-controls="enderecos" aria-selected="false">
		    	<i class="mdi mdi-truck-fast-outline mdi-24px"></i>
		    	<span class="font-weight-bold px-3 px-lg-2">Endereço</span>
		    </a>
	  	@else
		  	<a class="nav-link p-3 disabled" id="enderecos-tab" data-toggle="tab" href="#enderecos" role="tab" aria-controls="enderecos" aria-selected="false">
		    	<i class="mdi mdi-truck-fast-outline mdi-24px"></i>
		    	<span class="font-weight-bold px-3 px-lg-2">Endereço</span>
		    </a>
	  	@endif
	  </li>
	  <li class="nav-item shadow rounded my-2 bg-white">
	  	@if(Request::segment(2) == "continuar")
		  	<a class="nav-link p-3 {{(isset($pedido->id_endereco) && isset($pedido->id_rastreamento) && isset($pedido->id_cliente) ? 'active' : 'disabled')}}" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">
		    	<i class="mdi mdi-credit-card-multiple-outline mdi-24px"></i>
		    	<span class="font-weight-bold px-3 px-lg-2">Pagamento</span>
		    </a>
	  	@else
		  	<a class="nav-link disabled p-3" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">
		    	<i class="mdi mdi-credit-card-multiple-outline mdi-24px"></i>
		    	<span class="font-weight-bold px-3 px-lg-2">Pagamento</span>
		    </a>
	  	@endif
	  </li>
	</ul>
</div>

				