<!-- Card 2 -->
<div class="col-12 col-md-5 col-sm-12 my-3">
	<div class="card">
		<div class="card-header">
			<h5 class="section-title my-0">Resumo da compra</h5>
		</div>
		<div class="card-body">

			<div class="row px-3 mb-4">
				<div class="col-3 p-0">
					<img class="rounded w-100" src="{{ (isset($pedido->RelationProduto->RelationImagensPrincipal) ? asset('storage/app/'.$pedido->RelationProduto->RelationImagensPrincipal->first()->caminho) : asset('public/img/product.png') ) }}" >
				</div>
				<div class="col-9 text-left">
					<h6 class="font-weight-bold">{{ $pedido->RelationProduto->nome }}</h6>
					<small class="d-block"><b>Código SKU: </b>{{ $pedido->RelationProduto->cod_sku }}</small>
					<small class="d-block"><b>Marca: </b>{{ $pedido->RelationProduto->RelationMarcas->nome }}</small>
					<!--
					<div>
						<label>Quantidade</label>
						<input type="text" name="quantidade" id="quantidade" class="rounded text-center border col-2 p-0" value="{{($pedido->quantidade != 1 ? $pedido->quantidade : 1)}}" min="1" max="50">
						<a href="javascript:void(0)" class="text-decoration-none rounded px-1">
							<i class="mdi mdi-plus"></i>
						</a>
						<a href="javascript:void(0)" class="text-decoration-none rounded">
							<i class="mdi mdi-minus"></i>
						</a>
					</div>-->
				</div>
			</div>

			<div class="text-right col-12 p-0" id="carrinho">
				<div class="row m-0">
					<h6 class="pl-2">Produto</h6>
					@if($checkout->quantidade_itens == 1) 
						<div class="ml-auto">
							<label>Qtd.:</label>
							<input type="number" name="quantidade" id="quantidade" class="rounded text-center border col-3 p-0" value="{{($pedido->quantidade != 1 ? $pedido->quantidade : 1)}}" min="1" max="50">
							<label> x </label>
							@if(Request::segment(2) == "continuar")
								<label class="pl-1 valor_produto">R$ {{ number_format(($pedido->RelationProduto->preco_venda*$pedido->quantidade), 2 , ",", ".") }}</label>
								<input type="hidden" id="valor_produto_input" value="{{$pedido->RelationProduto->preco_venda*$pedido->quantidade}}">
							@else
								<label class="valor_produto">R$ {{ number_format($pedido->RelationProduto->preco_venda, 2 , ",", ".") }}</label>
								<input type="hidden" id="valor_produto_input" value="{{$pedido->RelationProduto->preco_venda}}">
							@endif
						</div>
					@else
						@if(Request::segment(2) == "continuar")
							<label class="ml-auto valor_produto">R$ {{ number_format(($pedido->RelationProduto->preco_venda*$pedido->quantidade), 2 , ",", ".") }}</label>
							<input type="hidden" id="valor_produto_input" value="{{$pedido->RelationProduto->preco_venda*$pedido->quantidade}}">
						@else
							<label class="ml-auto valor_produto">R$ {{ number_format($pedido->RelationProduto->preco_venda, 2 , ",", ".") }}</label>
							<input type="hidden" id="valor_produto_input" value="{{$pedido->RelationProduto->preco_venda}}">
						@endif
					@endif
				</div>
				<div class="row m-0">
					<h6 class="px-2 mr-auto">Descontos</h6> 
					@if(Request::segment(2) == "continuar")
						<label class="text-danger valor_desconto"> R$ {{ number_format($pedido->desconto_aplicado, 2 , ",", ".") }}</label>
						<input type="hidden" id="valor_desconto_input" value="{{@$pedido->desconto_aplicado}}">
					@else
						<label class="text-danger valor_desconto"> R$ 0,00</label>
						<input type="hidden" id="valor_desconto_input">
					@endif
				</div>
				<div class="row m-0">
					<h6 class="px-2 mr-auto">Frete</h6> 
					@if(Request::segment(2) == "continuar")
						<label class="valor_frete"> R$ {{ number_format(@$pedido->RelationRastreamento->valor_envio, 2 , ",", ".") }}</label>
						<input type="hidden" id="valor_frete_input" value="{{@$pedido->RelationRastreamento->valor_envio}}">
					@else
						<label class="valor_frete">R$ 0,00</label>
						<input type="hidden" id="valor_frete_input">
					@endif
				</div>

				<hr class="mb-0">

				<div>
					<p class="row">
						<h5 class="text-dark mr-auto">
							<span>Total:</span>
							@if(Request::segment(2) == "continuar")
								<span class="valor_total">R$ {{ number_format(($pedido->valor_compra-$pedido->desconto_aplicado+@$pedido->RelationRastreamento->valor_envio),2, ",", ".") }}</span>
								<input type="hidden" id="valor_total_input" value="{{$pedido->valor_compra}}">
							@else
								<span class="valor_total">R$ {{ number_format($pedido->valor_compra,2, ",", ".") }}</span>
								<input type="hidden" id="valor_total_input">
							@endif
						</h5>
						@if(Request::segment(2) == "continuar")
							<label class="text-dark valor_parcelado">ou até 12x de R$ {{ number_format(($pedido->valor_compra-$pedido->desconto_aplicado+@$pedido->RelationRastreamento->valor_envio)/12,2, ",", ".") }} sem juros</label>
						@else
							<label class="text-dark valor_parcelado">ou até 12x de R$ {{ number_format($pedido->RelationProduto->preco_venda/12, 2 , ",", ".") }} sem juros</label>
						@endif
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
