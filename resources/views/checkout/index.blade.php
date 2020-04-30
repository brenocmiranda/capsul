@section('title')
Efetuar pedido
@endsection

@include('template.header')

<div id="app">
	<div class="main-wrapper">
		@include('template.carregar')
		<section class="section">
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

			@if($produto->quantidade <= $produto->quantidade_minima && $checkout->text_topo_mostrar == 1)
			<div class="col-12 alert alert-primary text-center mx-auto p-2 mb-0">
				<p><?=$checkout->texto_topo?></p>
				<div class="row">
					<h6 class="mb-0 ml-auto px-1"><i class="fas fa-clock"></i> Oferta termina em </h6>
					<h6 class="mb-0 mr-auto text-dark" id="clock"></h6>
				</div>
			</div>
			@endif

			<div class="section-body">
				<div class="row">
					<div class="row col-12 col-sm-12 col-md-11 mx-md-auto m-0">
						@include('checkout.header')
						<div class="col-12 col-sm-12 col-md-10 row">
							<div class="col-12 col-sm-12 col-md-7 my-3">
								<div class="tab-content">
									@include('checkout.card1')
							 		@include('checkout.card2')
							  		@include('checkout.card3')
								</div>	
							</div>

							@include('checkout.footer')
						</div>
					</div>
				</div>
				<footer class="text-right text-white fixed-bottom p-4 d-none d-md-block" style="z-index: -1;">
					<label class="mb-0">Todos os direitos reservados ao {{$geral->nome_loja}}</label><br>
					<label class="mb-0">CNPJ: {{$geral->cnpj}}</label>
				</footer>
			</div>
		</section>
	</div>
</div>

@section('support')
<script type="text/javascript">
function freteUteis(id){
	$.ajax({
		url: "../checkout/frete/"+id,
		type: 'GET',
		beforeSend: function () {
			$('#modal-processamento').modal('show');
		}, success: function(data){
			$('.envio').html('');
			if(data){
				$.each(data, function(e){
					@if($checkout->prazo_entrega == 1)
						@if($checkout->data_previsao == 1)
							$('.envio').append('<div class="col-6 px-2" style="line-height: 15px;"> <div class="h-100 border rounded d-flex p-3 text-left"> <div class="form-check"> <input type="radio" name="frete" value="'+data[e].id+'" class="form-check-input" id="exampleRad'+data[e].id+'" onclick="atualizarFrete('+data[e].valor+')"> <label class="form-check-label" for="exampleRad'+data[e].id+'"> <label class="d-block font-weight-bold mb-1">'+data[e].nome+'</label> <small class="d-block mb-0">Valor: '+data[e].valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})+' </small> <small class="d-block mb-0">Prazo entrega: até '+data[e].prazo_entrega+' dias</small><small class="d-block mb-0">Previsão (dias úteis): '+moment().businessAdd(data[e].prazo_entrega).format("DD/MM/YYYY")+'</small> </label> </div> </div> </div>'); 
						@else
							$('.envio').append('<div class="col-6 px-2" style="line-height: 15px;"> <div class="h-100 border rounded d-flex p-3 text-left"> <div class="form-check"> <input type="radio" name="frete" value="'+data[e].id+'" class="form-check-input" id="exampleRad'+data[e].id+'" onclick="atualizarFrete('+data[e].valor+')"> <label class="form-check-label" for="exampleRad'+data[e].id+'"> <label class="d-block font-weight-bold mb-1">'+data[e].nome+'</label> <small class="d-block mb-0">Valor: '+data[e].valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})+' </small> <small class="d-block mb-0">Prazo entrega: até '+data[e].prazo_entrega+' dias</small></label> </div> </div> </div>'); 
						@endif
					@else
						@if($checkout->data_previsao == 1)
							$('.envio').append('<div class="col-6 px-2" style="line-height: 15px;"> <div class="h-100 border rounded d-flex p-3 text-left"> <div class="form-check"> <input type="radio" name="frete" value="'+data[e].id+'" class="form-check-input" id="exampleRad'+data[e].id+'" onclick="atualizarFrete('+data[e].valor+')"> <label class="form-check-label" for="exampleRad'+data[e].id+'"> <label class="d-block font-weight-bold mb-1">'+data[e].nome+'</label> <small class="d-block mb-0">Valor: '+data[e].valor..toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})+' </small> <small class="d-block mb-0">Previsão (dias úteis): até '+moment().businessAdd(data[e].prazo_entrega).format("DD/MM/YYYY")+'</small> </label> </div> </div> </div>'); 
						@else
							$('.envio').append('<div class="col-6 px-2" style="line-height: 15px;"> <div class="h-100 border rounded d-flex p-3 text-left"> <div class="form-check"> <input type="radio" name="frete" value="'+data[e].id+'" class="form-check-input" id="exampleRad'+data[e].id+'" onclick="atualizarFrete('+data[e].valor+')"> <label class="form-check-label" for="exampleRad'+data[e].id+'"> <label class="d-block font-weight-bold mb-1">'+data[e].nome+'</label> <small class="d-block mb-0">Valor: '+data[e].valor..toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})+' </small></label> </div> </div> </div>'); 
						@endif
					@endif

				});
			}
			setTimeout(function(){
				$('#modal-processamento').modal('hide');
			}, 200);
		}, error: function(data){ 
			$('.envio').html('<label class="col-12 mt-n2 text-danger">Não foi possível indentificar formas de envio para esse endereço. Por gentileza tente com outro!</label>');
			setTimeout(function(){ 
				$('#modal-processamento').modal('hide');	
			}, 500);
		}
	});
}

function updateEndereco(id){
	$('#step2').fadeOut().addClass('d-none');
	$('#newEndereco').fadeIn().removeClass('d-none');
	$('#newEndereco input[name=acao]').val(id);
	$.ajax({
		url: "../checkout/endereco/detalhes/"+id,
		type: 'GET',    
		beforeSend: function () {
			$('#modal-processamento').modal('show');
		}, success: function(data){
			$('#cep').unmask();
			$('#cep').val(data.cep);
			$('#cep').mask('00000-000');
			$(".country").html(data.cidade+' - '+data.estado);
			$('#cidade').val(data.cidade);
			$('#estado').val(data.estado);
			$('#endereco').val(data.endereco);
			$('#bairro').val(data.bairro);
			$('#numero').val(data.numero);
			$('#complemento').val(data.complemento);
			$('#destinatario').val(data.destinatario);
			setTimeout(function(){
				$('#modal-processamento').modal('hide');
			}, 200);
		}, error: function(data){ 
			$('#modal-processamento').modal('hide');
			$('#nome').focus();
		}
	});
}

function atualizarFrete(valor){
	// Atualizando dados de frete
	valor_frete = Number(valor);
	valor_atual = Number($('#carrinho #valor_total_input').val()) + valor_frete;
	$('#carrinho .valor_frete').html('');
	$('#carrinho .valor_frete').html(valor_frete.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
	$('#carrinho #valor_frete_input').val(valor_frete);
	$('#step2 button').removeAttr('disabled');

	atualizarTotal();
}

function atualizarQuantidade(valor){
	// Insere pela quantidade
	valor_atual = Number(valor);
	$('#carrinho .valor_produto').html('');
	$('#carrinho .valor_produto').html(valor_atual.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
	$('#carrinho #valor_produto_input').val(valor_atual);
	atualizarTotal();
}

function atualizarDesconto(valor){
	// Insere valores de desconto
	valor_desconto = Number(valor);
	valor_atual = Number($('#carrinho #valor_total_input').val()) + valor_desconto;
	$('#carrinho .valor_desconto').html('');
	$('#carrinho .valor_desconto').html(valor_desconto.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
	$('#carrinho #valor_desconto_input').val(valor_desconto);
	$.ajax({
		url: "../checkout/descontos/{{$pedido->id}}/"+valor_desconto,
		type: 'GET',  
		beforeSend: function () {
			$('#modal-processamento').modal('show');
		}, success: function(data){
			atualizarTotal();
			setTimeout(function(){
				$('#modal-processamento').modal('hide');
			}, 50);
		}, error: function(data){ 
			setTimeout(function(){ 
				$('#modal-processamento').modal('hide');	
			}, 50);
		}
	});

	
}

function atualizarTotal(){
	// Cálcula valor do carrinho
	valor_atual = Number($('#carrinho #valor_produto_input').val()) - Number($('#carrinho #valor_desconto_input').val()) + Number($('#carrinho #valor_frete_input').val());
	$('#carrinho .valor_total').html('');
	$('#carrinho .valor_total').html(valor_atual.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
	$('#step3 .valor_total').html(valor_atual.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
	$('#carrinho #valor_total_input').val(valor_atual);
	// Retorna parcelas
	$.ajax({
		url: "../checkout/parcelas/"+valor_atual,
		type: 'GET',  
		beforeSend: function () {
			$('#modal-processamento').modal('show');
		}, success: function(data){
			if(data.installments){
				$('#step3 form#card_credit #installments').html('');
				$.each(data.installments, function(e, element){
					var valor_parcela = element.installment_amount.toString();
					var valor = parseFloat(valor_parcela.substr(0, valor_parcela.length - 2)+"."+valor_parcela.substr(valor_parcela.length - 2));
					@if($checkout->maior_parcela == 1)
						if(parcela < e){
							var parcela = element.installment; 
							$('#step3 form#card_credit #installments').append('<option value="'+element.installment+'">'+element.installment+'x de '+valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})+' sem juros </option>');
						}else{
							$('#step3 form#card_credit #installments').append('<option value="'+element.installment+'" selected>'+element.installment+'x de '+valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})+' sem juros </option>');
							$('.valor_parcelado').html('ou até '+element.installment+'x de '+valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})+' sem juros');
						}
					@else
						$('#step3 form#card_credit #installments').append('<option value="'+element.installment+'">'+element.installment+'x de '+valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})+' sem juros </option>');
					@endif
				});
			}
			setTimeout(function(){
				$('#modal-processamento').modal('hide');
			}, 50);
		}, error: function(data){ 
			setTimeout(function(){ 
				$('#modal-processamento').modal('hide');	
			}, 50);
		}
	});
}

function refazerPayment(){
	$('#modal-processamento').modal('show');
	// Atualizando dados de frete
	setTimeout(function(){
		$('#myTab li a#profile-tab').removeClass("disabled");
		$('#myTab li a#enderecos-tab').removeClass("disabled");
		$('#myTab li a#payment-tab').removeClass("disabled");
		$('#myTab li a#payment-tab').removeClass("bg-danger bg-success text-white");
		$('#myTab li a#payment-tab').addClass("active");
		$('#pedido-status #pedido-image').attr('src', '');
		$('#pedido-status #pedido-nome').html('');
		$('#pedido-status #pedido-message').html('');
		$('#pedido-status #pedido-link').html('');
		$('#step3 #card_hash').val('');
		$('#pedido-status').fadeOut();
		$('#step3').fadeIn();
		$('#descontos').fadeIn();
	$('#modal-processamento').modal('hide');
	}, 1000);
}

$(document).ready(function (){
	// Mascaras 
	@if($checkout->compras_pessoa == "todos")
		var options = {
			onKeyPress : function(cpfcnpj, e, field, options) {
				var masks = ['000.000.000-000', '00.000.000/0000-00'];
				var mask = (cpfcnpj.length > 14) ? masks[1] : masks[0];
				$('#documento').mask(mask, options);
			}
		};
		$('#documento').mask('000.000.000-000', options);
    @elseif($checkout->compras_pessoa == "pf")
        $('#documento').mask('000.000.000-00', {reverse: true});
    @else
        $('#documento').mask('00.000.000/0000-00', {reverse: true});
    @endif

	$('.documento_titular').mask('000.000.000-00');
	$('#telefone').mask('(00) 00000-0000');
	$('#cep').mask('00000-000');
	$('#card_expiration').mask('00/00');
	$('#card_number').mask('0000 0000 0000 0000');
	$.validator.addMethod("cpf", function(value, element) {
		value = $.trim(value);
		value = value.replace('.','');
		value = value.replace('.','');
		cpf = value.replace('-','');
		while(cpf.length < 11) cpf = "0"+ cpf;
		var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
		var a = [];
		var b = new Number;
		var c = 11;
		for (i=0; i<11; i++){
			a[i] = cpf.charAt(i);
			if (i < 9) b += (a[i] * --c);
		}
		if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
			b = 0;
		c = 11;
		for (y=0; y<10; y++) b += (a[y] * c--);
			if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

		var retorno = true;
		if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

		return this.optional(element) || retorno;
	}, "Informe um CPF válido");

	// STEP 1 
	var validator1 = $('#step1').validate({
		rules: {
			nome: {
				required:true,
				minlength:9
			},
			email: {
				required:true,
				email: true
			},
			documento: {
				required:true,
				@if($checkout->compras_pessoa == "pf")
					minlength:14,
					cpf:true
				@elseif($checkout->compras_pessoa == "pj")
					minlength:18,
				@endif
			},
			telefone: {
				required:true,
				minlength:15
			} 
		},
		messages:{
			nome:{
				required:"Este campo é obrigatório.",
				minlength:"Dados preenchidos inválidos."
			},
			email:{
				required:"Este campo é obrigatório.",
				email: "E-mail inválido."
			},
			documento:{
				required:"Este campo é obrigatório.",
				minlength:"Dados preenchidos inválidos."
			},
			telefone:{
				required:"Este campo é obrigatório.",
				minlength:"Dados preenchidos inválidos."
			}
		},
		action : 'keyup, blur',
	});
	$('#documento').blur(function(){
		@if($checkout->compras_pessoa == "todos")
			if($("#documento").val().length == 14){
		       	var documento = this.value.replace(".", "").replace(".", "").replace("-", "");
		    } else {
		        var documento = this.value.replace(".", "").replace(".", "").replace("/", "").replace("-", "");
		    }
	    @elseif($checkout->compras_pessoa == "pf")
	       	var documento = this.value.replace(".", "").replace(".", "").replace("-", "");
	    @else
	        var documento = this.value.replace(".", "").replace(".", "").replace("/", "").replace("-", "");
	    @endif
		if(documento && (documento.length == 11 || documento.length == 14) && validator2.errorList.length == 0){
			$.ajax({
				url: "../checkout/detalhes/"+documento,
				type: 'GET',    
				beforeSend: function () {
					$('#modal-processamento').modal('show');
				}, success: function(data){
					$('#nome').val(data.nome);
					$('#destinatario').val(data.nome);
					$('#email').val(data.email);
					$('#telefone').unmask();
					$('#telefone').val(data.telefone.numero.replace("+55", ""));
					$('#telefone').mask('(00) 00000-0000');
					$('#data_nascimento').val(data.data_nascimento);
					if(data.endereco){
						$.each(data.endereco, function(e){
							$('.enderecos-list').prepend('<div class="col-6 px-2 pb-2 end'+data.endereco[e].id+'" style="line-height: 19px;"> <div class="h-100 border rounded row m-0 p-3 text-left"> <div class="form-check w-100 col-12 pr-0"> <input type="radio" name="endereco" value="'+data.endereco[e].id+'" class="form-check-input" id="exampleRadios'+data.endereco[e].id+'" onclick="freteUteis('+data.endereco[e].id+')"> <label class="form-check-label" for="exampleRadios'+data.endereco[e].id+'"> <label class="d-block font-weight-bold mb-0">'+data.endereco[e].destinatario+'</label> <small class="d-block mb-0">'+data.endereco[e].endereco+', '+data.endereco[e].numero+', '+(data.endereco[e].complemento ? data.endereco[e].complemento+', ':'')+data.endereco[e].bairro+'</small> <small class="d-block mb-0">'+data.endereco[e].cidade+' - '+data.endereco[e].estado+'</small><small class="d-block mb-0">'+data.endereco[e].cep.substr(0, 5)+'-'+data.endereco[e].cep.substr(5, 8)+'</small> </label> </div><div class="w-100 text-right col-12 p-0 align-self-end"> <a href="javascript:void(0)" class="" onclick="updateEndereco('+data.endereco[e].id+')"> <i class="ml-auto mdi mdi-pencil"></i> <small>Editar</small> </a></div></div></div>'); });
					}
					setTimeout(function(){
						$('#modal-processamento').modal('hide');
					}, 200);
				}, error: function(data){ 
					$('#step1 #nome').val('');
					$('#step1 #email').val('');
					$('#step1 #data_nascimento').val('');
					$('#step1 #telefone').val('');
					$('#destinatario').val('');
					setTimeout(function(){
						$('#modal-processamento').modal('hide');
						$('#step1 #nome').focus();
					}, 100);
				}
			});	
		}
	});
	$('#step1').submit(function(e){
		// Verificação de erros de validação
		if(validator1.errorList.length == 0){
			e.preventDefault();
			$.ajax({
				url: "{{route('checkout.form1', $pedido->id)}}",
				type: 'POST',
				data: new FormData(this),
				dataType:'JSON',
				contentType: false,
				cache: false,
				processData: false,    
				beforeSend: function () {
					$('#modal-processamento').modal('show');
				}, success: function(data){
					$('#myTab li a#profile-tab').removeClass("bg-warning");
					$('#myTab li a#profile-tab').addClass("bg-success text-white");
					$('#myTab li a#enderecos-tab').removeClass("disabled");

					if(!$('#myTab li a#enderecos-tab').hasClass('bg-success')){
						$('#myTab li a#enderecos-tab').tab('show');
					}else{
						$('#myTab li a#payment-tab').tab('show');
					}				

					setTimeout(function(){
						$('#modal-processamento').modal('hide');
					}, 100);
				}, error: function(data){ 
					setTimeout(function(){ 
						$('#modal-processamento').modal('hide');	
					}, 100);
				}
			});
		}
	});


	// STEP 2
	var validator2 = $('#newEndereco').validate({
		rules: {
			cep: {
				required:true,
				minlength:9
			},
			endereco: {
				required:true,
				minlength:5
			},
			bairro: {
				required:true,
				minlength:4
			},
			numero: {
				required:true,
				number:true
			},
			cidade: {
				required:true,
				minlength:5
			}, 
			estado: {
				required:true,
				minlength:2
			},		
			destinatario: {
				required:true,
				minlength:5
			}  
		},
		messages:{
			cep:{
				required:"Este campo é obrigatório.",
				minlength:"Dados preenchidos inválidos."
			},
			endereco:{
				required:"Este campo é obrigatório.",
				minlength:"Dados preenchidos inválidos."
			},
			bairro:{
				required:"Este campo é obrigatório.",
				minlength:"Dados preenchidos inválidos."
			},
			numero:{
				required:"Este campo é obrigatório.",
				minlength:"Dados preenchidos inválidos."
			},
			cidade:{
				required:"Este campo é obrigatório.",
				minlength:"Dados preenchidos inválidos."
			},
			estado:{
				required:"Este campo é obrigatório.",
				minlength:"Dados preenchidos inválidos."
			},
			destinatario:{
				required:"Este campo é obrigatório.",
				minlength:"Dados preenchidos inválidos."
			}
		},
		action : 'keyup, blur',
	});
	$("#cep").blur(function() {
    	$(".country").html("");
        var cep = $(this).val().replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if(validacep.test(cep)) {
                $.getJSON("https://viacep.com.br/ws/"+cep+"/json/?callback=?", function(dados) {
                	if (!("erro" in dados)) {
                        $(".country").html(dados.localidade+' - '+dados.uf);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                        $("#endereco").focus();
                    }else {
                        $(".country").html('<b class="text-danger"> CEP não localizado.</b');
                    }
                });
            } else {
                $("#cidade").val("");
                $("#estado").val("");
                $(".country").html("");
            }
        }
    });
    $('#newEndereco').submit(function(e){
		// Verificação de erros de validação
		if(validator2.errorList.length == 0){
			e.preventDefault();
			$.ajax({
				url: "{{route('checkout.endereco', $pedido->id)}}",
				type: 'POST',
				data: new FormData(this),
				dataType:'JSON',
				contentType: false,
				cache: false,
				processData: false,    
				beforeSend: function () {
					$('#modal-processamento').modal('show');
				}, success: function(data){
					if($('input[name=acao]').val() != ""){
						$('.end'+$('input[name=acao]').val()).remove();
					}
					$('.enderecos-list').prepend('<div class="col-6 p-2 end'+data.id+'" style="line-height: 19px;"> <div class="h-100 border rounded row m-0 p-3 text-left"> <div class="form-check w-100 col-12 pr-0"> <input type="radio" name="endereco" value="'+data.id+'" class="form-check-input" id="exampleRadi'+data.id+'" onclick="freteUteis('+data.id+')"> <label class="form-check-label" for="exampleRadi'+data.id+'"> <label class="d-block font-weight-bold mb-0">'+data.destinatario+'</label> <small class="d-block mb-0">'+data.endereco+', '+data.numero+', '+(data.complemento ? data.complemento+', ':'')+data.bairro+'</small> <small class="d-block mb-0">'+data.cidade+' - '+data.estado+'</small><small class="d-block mb-0">'+data.cep.substr(0, 5)+'-'+data.cep.substr(5, 8)+'</small> </label></div><div class="w-100 text-right col-12 p-0 align-self-end"> <a href="javascript:void(0)" class="" onclick="updateEndereco('+data.id+')"> <i class="ml-auto mdi mdi-pencil"></i> <small>Editar</small> </a></div>  </div> </div>');
					$('#newEndereco input[name=acao]').val('');
					$('#newEndereco').fadeOut().addClass('d-none');
					$('#step2').fadeIn().removeClass('d-none');
					setTimeout(function(){
						$('#modal-processamento').modal('hide');
					}, 100);
				}, error: function(data){ 
					setTimeout(function(){ 
						$('#modal-processamento').modal('hide');	
					}, 100);
				}
			});
		}		
	});
    $('#buttonNewEndereco').on('click', function(){
		$('#step2').fadeOut().addClass('d-none');
		$('#newEndereco').fadeIn().removeClass('d-none');
		$('#newEndereco').each (function(){
		  this.reset();
		});
		$('#newEndereco input[name=acao]').val('');
	});
	$('#buttonVoltarEndereco').on('click', function(){
		$('#step2').fadeIn().removeClass('d-none');
		$('#newEndereco').fadeOut().addClass('d-none');
		$('#newEndereco').each (function(){
		  this.reset();
		});
		$('#newEndereco input[name=acao]').val('');
	});
	$('#step2').submit(function(e){
		e.preventDefault();
		if($('input[type=radio][name=endereco]').is(':checked')){
			if($('input[type=radio][name=frete]').is(':checked')){
				$.ajax({
					url: "{{route('checkout.form2', $pedido->id)}}",
					type: 'POST',
					data: new FormData(this),
					dataType:'JSON',
					contentType: false,
					cache: false,
					processData: false,    
					beforeSend: function () {
						$('#modal-processamento').modal('show');
					}, success: function(data){
						atualizarTotal();
						$('#myTab li a#enderecos-tab').removeClass("bg-warning");
						$('#myTab li a#enderecos-tab').addClass("bg-success text-white");
						$('#myTab li a#payment-tab').removeClass("disabled");

						if(!$('#myTab li a#payment-tab').hasClass('bg-success')){
							$('#myTab li a#payment-tab').tab('show');
						}		

						setTimeout(function(){
							$('#modal-processamento').modal('hide');
						}, 100);
					}, error: function(data){ 
						setTimeout(function(){ 
							$('#modal-processamento').modal('hide');	
						}, 100);
					}
				});
			}else{
				alert('Selecione uma das formas de envio diponíveis');
			}
		}else{
			alert('Selecione um dos seus endereços.');
		}
	});


	// STEP 3 
	$("#step3 form#card_credit #card_number").on('keyup', function(){
		$('#field_errors_number').html('');
		var card = {} 
		card.card_number = $("#step3 form#card_credit #card_number").val();
		$('#step3 form#card_credit #card_number').attr('class', 'form-control creditcard');
		var cardValidations = pagarme.validate({card: card})
		$('#step3 form#card_credit #card_number').addClass(cardValidations.card.brand); 
	});
	$("#step3 form#card_credit #card_holder_name").on('keyup', function(){
		$('#field_errors_name').html('');
	});
	$("#step3 form#card_credit #card_expiration").on('keyup', function(){
		$('#field_errors_date').html('');
	});
	$("#step3 form#card_credit #card_cvv").on('keyup', function(){
		$('#field_errors_cvv').html('');
	});
	$("#step3 form#card_credit .documento_titular").on('keyup', function(){
		$('#field_errors_cpf_cart').html('');	
	});
	$("#step3 form#boleto .documento_titular").on('keyup', function(){
		$('#field_errors_cpf_boleto').html('');
	});
	$('#step3 form#card_credit').submit(function(e){
		e.preventDefault();
		var card = {} 
		card.card_holder_name = $("#step3 form#card_credit #card_holder_name").val();
		card.card_expiration_date = $("#step3 form#card_credit #card_expiration").val();
		card.card_number = $("#step3 form#card_credit #card_number").val();
		card.card_cvv = $("#step3 form#card_credit #card_cvv").val();
		// pega os erros de validação nos campos do form e a bandeira do cartão
		var cardValidations = pagarme.validate({card: card})
		// adiciona bandeira no campo
		$('#step3 form#card_credit #card_number').addClass(cardValidations.card.brand); 
		// verificação de campos inválidos
		if(!cardValidations.card.card_number){
			$('#field_errors_number').html('Número de cartão incorreto.');
		}else if($("#step3 #card_holder_name").val() == ""){
			$('#field_errors_name').html('Nome impresso no cartão inválido.');
		}else if(!cardValidations.card.card_expiration_date){
			$('#field_errors_date').html('Data de expiração inválida.');
		}else if(!cardValidations.card.card_cvv){
			$('#field_errors_cvv').html('Número CCV inválido.');
		}else if(this.documento_titular.value.length != 14){
			$('#field_errors_cpf_cart').html('Número de CPF incompleto.');
		}else{
			pagarme.client.connect({ encryption_key: "{{$checkout->api_criptografada}}" })
			.then(client => client.security.encrypt(card))
			.then(card_hash => $('#step3 form#card_credit #card_hash').val(card_hash));
		  	// o próximo passo aqui é enviar o card_hash para seu servidor, e em seguida criar a transação/assinatura 
		  	$.ajax({
			  	url: "{{route('checkout.form3', $pedido->id)}}",
			  	type: 'POST',
			  	data: new FormData(this),
			  	dataType:'JSON',
			  	contentType: false,
			  	cache: false,
			  	processData: false,    
			  	beforeSend: function () {
			  		$('#modal-processamento').modal('show');
			  	}, success: function(data){
			  		if(data){
			  			$('#pedido-status #pedido-image').attr('src', data.image);
				  		$('#pedido-status #pedido-nome').html(data.nome);
				  		$('#pedido-status #pedido-message').html(data.descricao);
				  		$('#pedido-status #pedido-link').html(data.link);
				  		$('#myTab li a#profile-tab').addClass("disabled");
				  		$('#myTab li a#enderecos-tab').addClass("disabled");
				  		$('#myTab li a#payment-tab').addClass("disabled");
				  		$('#myTab li a#payment-tab').addClass(data.estado);
				  		$('#myTab li a#payment-tab').removeClass("active");
				  		$('#pedido-status').fadeIn();
				  		$('#step3').fadeOut();
				  		$('#descontos').fadeOut();
				  		setTimeout(function(){
				  			if(data.url_redirect && data.posicao == 3){
								window.open(data.url_redirect, '_blank');
							}
						}, 2000);
			  		}
			  		setTimeout(function(){
						$('#modal-processamento').modal('hide');
					}, 100);
			  	}, error: function(data){ 
			  		setTimeout(function(){ 
			  			$('#pedido-status').fadeOut();
				  		$('#step3').fadeIn();
				  		$('#descontos').fadeIn();
						$('#modal-processamento').modal('hide');
			  			if(!data.responseJSON){
			  				$('#modal-editar #err').html(data.responseText);
			  			}else{
			  				$('#modal-editar #err').html('');
			  				$('input').removeClass('border border-danger');
			  				$.each(data.responseJSON.errors, function (key, value) {
			  					$('#modal-editar #err').append("<div class='text-danger ml-3'><p>"+value+"</p></div>");
			  					$('input[name="'+key+'"]').addClass("border border-danger");
			  				});
			  			}
			  		}, 100);
			  	}
		  	});
		}
		return false;
	});
	$('#step3 form#boleto').submit(function(e){
		e.preventDefault();
		if(this.documento_titular.value.length == 14){
			$.ajax({
				url: "{{route('checkout.form4', $pedido->id)}}",
				type: 'POST',
				data: new FormData(this),
				dataType:'JSON',
				contentType: false,
				cache: false,
				processData: false,    
				beforeSend: function () {
					$('#modal-processamento').modal('show');
				}, success: function(data){
					if(data){
			  			$('#pedido-status #pedido-image').attr('src', data.image);
				  		$('#pedido-status #pedido-nome').html(data.nome);
				  		$('#pedido-status #pedido-message').html(data.descricao);
				  		$('#pedido-status #pedido-link').html(data.link);
				  		$('#myTab li a#profile-tab').addClass("disabled");
				  		$('#myTab li a#enderecos-tab').addClass("disabled");
				  		$('#myTab li a#payment-tab').addClass("disabled");
				  		$('#myTab li a#payment-tab').addClass(data.estado);
				  		$('#myTab li a#payment-tab').removeClass("active");
				  		$('#pedido-status').fadeIn();
				  		$('#step3').fadeOut();
				  		$('#descontos').fadeOut();
				  		if(data.url_redirect && data.posicao == 1){
				  			window.open(data.link, '_blank');
				  		}
				  		setTimeout(function(){
				  			if(data.url_redirect && data.posicao == 3){
				  				window.open(data.url_redirect, '_blank');
				  			}
						}, 2000);
			  		}
			  		setTimeout(function(){
						$('#modal-processamento').modal('hide');
					}, 100);
				}, error: function(data){ 
					setTimeout(function(){ 
						$('#pedido-status').fadeOut();
				  		$('#step3').fadeIn();
				  		$('#descontos').fadeIn();
						$('#modal-processamento').modal('hide');
						if(!data.responseJSON){
							$('#modal-editar #err').html(data.responseText);
						}else{
							$('#modal-editar #err').html('');
							$('input').removeClass('border border-danger');
							$.each(data.responseJSON.errors, function (key, value) {
								$('#modal-editar #err').append("<div class='text-danger ml-3'><p>"+value+"</p></div>");
								$('input[name="'+key+'"]').addClass("border border-danger");
							});
						}
					}, 100);
				}
			});
		}else{
			$('#field_errors_cpf_boleto').html("Número de CPF incompleto.");
		}
	});
	

	// Funções extras
	$('#carrinho #quantidade').on('keyup', function(e){
		// Alterando quantidade de items do carrinho
		e.preventDefault();
		if(this.value != ""){
			$.ajax({
				url: "../checkout/quantidade/{{$pedido->id}}/"+this.value,
				type: 'GET',  
				beforeSend: function () {
					$('#modal-processamento').modal('show');
				}, success: function(data){
					atualizarQuantidade(data);
					setTimeout(function(){
						$('#modal-processamento').modal('hide');
					}, 200);
				}, error: function(data){ 
					setTimeout(function(){ 
						$('#modal-processamento').modal('hide');	
					}, 500);
				}
			});
		}	
	});
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {		
		// Salvando informações alteradas em Form já salvo
		if($("#"+e.relatedTarget.id).hasClass('bg-warning')){
			$('#'+e.relatedTarget.id.replace('-tab', '')+' form:first-child').submit(); 
		}
	});
	$('#step1').on('keyup', function(){
		// Pegando alterações em form já salvo
		if($('#profile-tab').hasClass('bg-success')){
			$('#profile-tab').addClass('bg-warning text-white');
			$('#profile-tab').removeClass('bg-success');
		}
	});	
	$('#step2').on('change', function(){
		// Pegando alterações em form já salvo
		if($('#enderecos-tab').hasClass('bg-success')){
			$('#enderecos-tab').addClass('bg-warning text-white');
			$('#enderecos-tab').removeClass('bg-success');
		}
	});
	$('#clock').countdown("{{date('Y-m-d H:i:s', strtotime('+'.$checkout->tempo_cronometro.' minutes'))}}", function(event) {
		// Contador de tempo
        $(this).html(event.strftime('%H:%M:%S'));
    });
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {	
		// Aplicando desconto estabelescidos no checkout
		if(e.target.id.replace('-tab', '') == 'payment' || e.target.id.replace('-tab', '') == 'cart'){
			valor_desconto = $('#carrinho #valor_produto_input').val() * (parseFloat('{{$checkout->desconto_cartao}}')/100);
			atualizarDesconto(valor_desconto);
		}else{
			valor_desconto = $('#carrinho #valor_produto_input').val() * (parseFloat('{{$checkout->desconto_boleto}}')/100);
			atualizarDesconto(valor_desconto);
		}
	});
});
</script>
@endsection 

@include('template.footer')

