<!-- Card 2 -->
<div class="col-12 col-md-5 col-sm-12 my-3">
	<div class="card">
		<div class="card-header">
			<h5 class="section-title my-0">Resumo do pedido</h5>
		</div>
		<div class="card-body">

			<div class="row px-3 mb-5">
				<div class="col-3 p-0">
					<img class="rounded w-100" src="{{ (isset($produto->RelationImagensPrincipal) ? asset('storage/app/'.$produto->RelationImagensPrincipal->first()->caminho) : asset('public/img/product.png') ) }}" >
				</div>
				<div class="col-9 text-left">
					<label class="font-weight-bold">{{ $produto->nome }}</label>
					<small class="d-block"><b>Código SKU: </b>{{ $produto->cod_sku }}</small>
					<small class="d-block"><b>Marca: </b>{{ $produto->RelationMarcas->nome }}</small>

				</div>
			</div>

			<div class="text-right col-12 p-0" id="carrinho">
				<div class="row m-0">
					<h6 class="px-2">Produto</h6>
					@if($checkout->quantidade_itens == 1) 
						<div class="ml-auto">
							<label>(Qtd.:</label>
							<input type="text" name="quantidade" id="quantidade" class="text-center border-top-0 border-left-0 border-right-0 border-bottom w-25" value="1">
							<label>) x </label>
						</div>
						<label class="pl-1 valor_produto">R$ {{ number_format($produto->preco_venda, 2 , ",", ".") }}</label>
						<input type="hidden" id="valor_produto_input" value="{{$produto->preco_venda}}">
					@else
						<label class="ml-auto valor_produto">R$ {{ number_format($produto->preco_venda, 2 , ",", ".") }}</label>
						<input type="hidden" id="valor_produto_input" value="{{$produto->preco_venda}}">
					@endif
				</div>
				<div class="row m-0">
					<h6 class="px-2 mr-auto">Descontos</h6> 
					<label class="text-danger valor_desconto"> R$ 0,00</label>
					<input type="hidden" id="valor_desconto_input">
				</div>
				<div class="row m-0">
					<h6 class="px-2 mr-auto">Frete</h6> 
					<label class="valor_frete">R$ 0,00</label>
					<input type="hidden" id="valor_frete_input">
				</div>

				<hr class="mb-0">

				<div>
					<p class="row">
						<h5 class="text-dark mr-auto">
							<span>Total:</span>
							<span class="valor_total">R$ {{ number_format($produto->preco_venda,2, ",", ".") }}</span>
							<input type="hidden" id="valor_total_input">
						</h5>
						<label class="text-dark valor_parcelado">ou até 12x de R$ {{ number_format($produto->preco_venda/12, 2 , ",", ".") }} sem juros</label>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
