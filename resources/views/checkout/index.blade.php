@section('title')
Compra
@endsection

@include('template.header')
@include('template.carregar')

<section class="section">
	<div class="position-absolute w-100 vh-100 m-0" style="z-index: -1;">
      <div class="d-flex h-100">
          <img src="{{ asset('public/img/bg_banner1.png') }}" class="mt-auto w-100 h-50 fixed-bottom" style="transform: rotate(180deg);">
      </div>
    </div>

	<div class="section-header p-0">
		<header class="col-12 bg-white">
			<div class="container px-5">
				<div class="row align-items-center">
					<div class="col-sm-12 col-md-2 py-sm-0 my-3 text-center">
						<img src="{{ asset('storage/app/system/capsul.png') }}" width="148" title="Logo Capsul">
					</div>
				</div>
			</div>
		</header>
	</div>

	@if($checkout->cupom_desconto == 1)
	<div class="col-12 alert alert-success text-center mx-auto">
		<p><?=$checkout->texto_topo?></p>
		<i class="fas fa-clock"></i> Oferta termina em <b><span class="getting-started text-dark"></span></b>
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
			<label>Todos os direitos reservados ao {{$geral->nome_loja}}</label><br>
			<label>CNPJ: {{$geral->cnpj}}</label>
		</footer>
	</div>
</section>


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
							$('.envio').append('<div class="col-6 px-3" style="line-height: 15px;"> <div class="h-100 border rounded d-flex p-3 text-left"> <div class="form-check"> <input type="radio" name="frete" value="'+data[e].id+'" class="form-check-input" id="exampleRad'+data[e].id+'" onclick="frete('+data[e].id+')"> <label class="form-check-label" for="exampleRad'+data[e].id+'"> <label class="d-block font-weight-bold mb-1">'+data[e].nome+'</label> <small class="d-block mb-0">Valor: R$ '+data[e].valor.toFixed(2)+' </small> <small class="d-block mb-0">Prazo entrega: '+data[e].prazo_entrega+' dias</small><small class="d-block mb-0">Previsão (dias úteis): '+moment().businessAdd(data[e].prazo_entrega).format("DD/MM/YYYY")+'</small> </label> </div> </div> </div>'); 
						@else
							$('.envio').append('<div class="col-6 px-3" style="line-height: 15px;"> <div class="h-100 border rounded d-flex p-3 text-left"> <div class="form-check"> <input type="radio" name="frete" value="'+data[e].id+'" class="form-check-input" id="exampleRad'+data[e].id+'" onclick="frete('+data[e].id+')"> <label class="form-check-label" for="exampleRad'+data[e].id+'"> <label class="d-block font-weight-bold mb-1">'+data[e].nome+'</label> <small class="d-block mb-0">Valor: R$ '+data[e].valor.toFixed(2)+' </small> <small class="d-block mb-0">Prazo entrega: '+data[e].prazo_entrega+' dias</small></label> </div> </div> </div>'); 
						@endif
					@else
						@if($checkout->data_previsao == 1)
							$('.envio').append('<div class="col-6 px-3" style="line-height: 15px;"> <div class="h-100 border rounded d-flex p-3 text-left"> <div class="form-check"> <input type="radio" name="frete" value="'+data[e].id+'" class="form-check-input" id="exampleRad'+data[e].id+'" onclick="frete('+data[e].id+')"> <label class="form-check-label" for="exampleRad'+data[e].id+'"> <label class="d-block font-weight-bold mb-1">'+data[e].nome+'</label> <small class="d-block mb-0">Valor: R$ '+data[e].valor.toFixed(2)+' </small> <small class="d-block mb-0">Previsão (dias úteis): '+moment().businessAdd(data[e].prazo_entrega).format("DD/MM/YYYY")+'</small> </label> </div> </div> </div>'); 
						@else
							$('.envio').append('<div class="col-6 px-3" style="line-height: 15px;"> <div class="h-100 border rounded d-flex p-3 text-left"> <div class="form-check"> <input type="radio" name="frete" value="'+data[e].id+'" class="form-check-input" id="exampleRad'+data[e].id+'" onclick="frete('+data[e].id+')"> <label class="form-check-label" for="exampleRad'+data[e].id+'"> <label class="d-block font-weight-bold mb-1">'+data[e].nome+'</label> <small class="d-block mb-0">Valor: R$ '+data[e].valor.toFixed(2)+' </small></label> </div> </div> </div>'); 
						@endif
					@endif

				});
			}
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
$(document).ready(function (){
	// Mascaras 
	$('#documento').mask('000.000.000-00', {reverse: true});
	$('#telefone').mask('(00) 00000-0000');
	$('#cep').mask('00000-000');
	$('.card_expiration').mask('00/00');
	$('.card_number').mask('0000 0000 0000 0000');
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
				minlength:14,
				cpf:true
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
		var documento = this.value.replace(".", "").replace(".", "").replace("-", "");
		if(documento && documento.length == 11 && validator2.errorList.length == 0){
			$.ajax({
				url: "../checkout/detalhes/"+documento,
				type: 'GET',    
				beforeSend: function () {
					$('#modal-processamento').modal('show');
				}, success: function(data){
					$('#nome').val(data.nome);
					$('#email').val(data.email);
					$('#telefone').unmask();
					$('#telefone').val(data.telefone.numero.replace("+55", ""));
					$('#telefone').mask('(00) 00000-0000');
					$('#data_nascimento').val(data.data_nascimento);

					if(data.endereco){
						$.each(data.endereco, function(e){
							$('.enderecos-list').prepend('<div class="col-6 p-2" style="line-height: 19px;"> <div class="h-100 border rounded d-flex p-3 text-left"> <div class="form-check"> <input type="radio" name="endereco" value="'+data.endereco[e].id+'" class="form-check-input" id="exampleRadios'+data.endereco[e].id+'" onclick="freteUteis('+data.endereco[e].id+')"> <label class="form-check-label" for="exampleRadios'+data.endereco[e].id+'"> <label class="d-block font-weight-bold mb-0">'+data.endereco[e].destinatario+'</label> <small class="d-block mb-0">'+data.endereco[e].endereco+', '+data.endereco[e].numero+', '+(data.endereco[e].complemento ? data.endereco[e].complemento+', ':'')+data.endereco[e].bairro+'</small> <small class="d-block mb-0">'+data.endereco[e].cidade+' - '+data.endereco[e].estado+'</small> </label> </div> </div> </div>');
						});
					}
					setTimeout(function(){
						$('#modal-processamento').modal('hide');
					}, 200);
				}, error: function(data){ 
					$('#modal-processamento').modal('hide');
					$('#nome').focus();
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
					$("input[name='destinatario']").val($("input[name='nome']").val());
					
					$('#myTab li a#profile-tab').addClass("bg-success text-white");
					$('#myTab li a#enderecos-tab').removeClass("disabled");
					$('#myTab li a#enderecos-tab').tab('show');

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
    $('#buttonNewEndereco').on('click', function(){
		$('#step2').fadeOut().addClass('d-none');
		$('#newEndereco').fadeIn().removeClass('d-none');
	});
	$('#buttonVoltarEndereco').on('click', function(){
		$('#step2').fadeIn().removeClass('d-none');
		$('#newEndereco').fadeOut().addClass('d-none');
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
					$('.enderecos-list').prepend('<div class="col-6 p-2" style="line-height: 19px;"> <div class="h-100 border rounded d-flex p-3 text-left"> <div class="form-check"> <input type="radio" name="endereco" value="'+data.id+'" class="form-check-input" id="exampleRadi'+data.id+'" onclick="freteUteis('+data.id+')"> <label class="form-check-label" for="exampleRadi'+data.id+'"> <label class="d-block font-weight-bold mb-0">'+data.destinatario+'</label> <small class="d-block mb-0">'+data.endereco+', '+data.numero+', '+(data.complemento ? data.complemento+', ':'')+data.bairro+'</small> <small class="d-block mb-0">'+data.cidade+' - '+data.estado+'</small> </label> </div> </div> </div>');
					$('#newEndereco').fadeOut().addClass('d-none');
					$('#step2').fadeIn().removeClass('d-none');
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
						$('#myTab li a#enderecos-tab').addClass("bg-success text-white");
						$('#myTab li a#payment-tab').removeClass("disabled");
						$('#myTab li a#payment-tab').tab('show');

						setTimeout(function(){
							$('#modal-processamento').modal('hide');
						}, 200);
					}, error: function(data){ 
						setTimeout(function(){ 
							$('#modal-processamento').modal('hide');	
						}, 500);
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
	$("#card_number").on('keyup', function(){
		$('#field_errors_number').html('');
	});
	$("#card_holder_name").on('keyup', function(){
		$('#field_errors_name').html('');
	});
	$("#card_expiration").on('keyup', function(){
		$('#field_errors_date').html('');
	});
	$("#card_cvv").on('keyup', function(){
		$('#field_errors_cvv').html('');
	});
	// Compra pelo cartão de crédito
	$('#step3 #card_credit').submit(function(event){
		event.preventDefault();
		var card = {} 
		card.card_holder_name = $("#step3 #card_holder_name").val();
		card.card_expiration_date = $("#step3 #card_expiration").val();
		card.card_number = $("#step3 #card_number").val();
		card.card_cvv = $("#step3 #card_cvv").val();
		// pega os erros de validação nos campos do form e a bandeira do cartão
		var cardValidations = pagarme.validate({card: card})
		// adiciona bandeira no campo
		$('.card_number').addClass(cardValidations.card.brand); 
		// verificação de campos inválidos
		if(!cardValidations.card.card_number){
			$('#field_errors_number').html('Número de cartão incorreto.');
		}else if($("#step3 #card_holder_name").val() == ""){
			$('#field_errors_name').html('Nome impresso no cartão inválido.');
		}else if(!cardValidations.card.card_expiration_date){
			$('#field_errors_date').html('Data de expiração inválida.');
		}else if(!cardValidations.card.card_cvv){
			$('#field_errors_cvv').html('Número CCV inválido.');
		}else{
			pagarme.client.connect({ encryption_key: "{{$checkout->api_criptografada}}" })
			.then(client => client.security.encrypt(card))
			.then(card_hash => $('#card_hash').val(card_hash));
			
			  // o próximo passo aqui é enviar o card_hash para seu servidor, e
			  // em seguida criar a transação/assinatura 
			  $.ajax({
			  	url: "{{route('checkout.form3', $pedido->id)}}",
			  	type: 'POST',
			  	data: new FormData(this),
			  	dataType:'JSON',
			  	contentType: false,
			  	cache: false,
			  	processData: false,    
			  	beforeSend: function () {
			  		$('#step3').fadeIn(500).addClass('d-none');
			  		$('#modal-processamento').modal('show');
			  	}, success: function(data){
			  		if(data == "paid" || data == "authorized"){
			  			$('.status').html('<div class="my-4 col-12 mx-auto text-center"><div> <img src="../public/img/status-pagamento/aprovado.png" class="mx-auto col-4"> </div> <div class="mt-4"> <h3>Pagamento aprovado!</h3> </div> <div class="mt-0 mb-5"> <h5 class="pb-5">Seu número de pedido é: <b>#'+$('.pedido-id').val()+'</b></h5> <h5>Seu pedido já foi recebido e em alguns dias estará a caminho, você receberá por e-mail as alterações nos status. Para mais informações, acesse: <a href="#">Acompanhamento do pedido</a></h5> </div> </div>');
			  			$('.card-step3').fadeIn(500).removeClass('wizard-step-active');
			  			$('.card-step3').fadeIn(500).addClass('wizard-step-success');
			  			$('.card-step1 .edit-card').addClass('d-none');
			  			$('.card-step2 .edit-card').addClass('d-none');
			  			$('.card-step3 .edit-card').addClass('d-none');
			  		}else if(data == "refused" || data == "chargedback" || data == "refunded"){
			  			$('.status').html('<div class="my-4 col-12 mx-auto text-center"><div> <img src="../public/img/status-pagamento/recusado.png" class="mx-auto col-4"> </div> <div class="mt-4"> <h3>Pagamento recusado!</h3> </div> <div class="mt-0 mb-5"> <h5>Ops!! Seu pedido foi recusado, tente novamente.</h5> </div> </div>');
			  			$('.card-step3').fadeIn(500).removeClass('wizard-step-active');
			  			$('.card-step3').fadeIn(500).addClass('wizard-step-danger');
			  			$('.card-step1 .edit-card').addClass('d-none');
			  			$('.card-step2 .edit-card').addClass('d-none');
			  			$('.card-step3 .edit-card').addClass('d-none');
			  		}else if(data == "processing" || data == "waiting_payment" || data == "analyzing" || data == "pending_review"){
			  			$('.status').html('<div class="my-4 col-12 mx-auto text-center"><div> <img src="../public/img/status-pagamento/analise.png" class="mx-auto col-4"> </div> <div class="mt-4"> <h3>Pagamento em análise!</h3> </div> <div class="mt-0 mb-5"> <h5 class="pb-5">Seu número de pedido é: <b>#'+$('.pedido-id').val()+'</b></h5> <h5>Seu pedido foi recebido e está em análise, a qualquer momento receberá por e-mail mais informações.</h5> </div> </div>');
			  			$('.card-step3').fadeIn(500).removeClass('wizard-step-active');
			  			$('.card-step3').fadeIn(500).addClass('wizard-step-warning');
			  			$('.card-step1 .edit-card').addClass('d-none');
			  			$('.card-step2 .edit-card').addClass('d-none');
			  			$('.card-step3 .edit-card').addClass('d-none');
			  		}	

			  		setTimeout(function(){
						$('#modal-processamento').modal('hide');
					}, 200);
			  	}, error: function(data){ 
			  		setTimeout(function(){ 
			  			$('#step3').fadeIn(500).removeClass('d-none');
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
			  		}, 500);
			  	}
			  });
			}
			return false;
	});
	// Compra pelo boleto bancário
	$('#step3 #boleto').submit(function(event){
		event.preventDefault();
		$.ajax({
			url: "./update/"+$('.pedido-id').val(),
			type: 'POST',
			data: new FormData(this),
			dataType:'JSON',
			contentType: false,
			cache: false,
			processData: false,    
			beforeSend: function () {
				$('#step3').fadeIn(500).addClass('d-none');
				$('#modal-processamento').modal('show');
			}, success: function(data){
				if(data.status == "paid" || data.status == "authorized"){
					$('.status').html('<div class="my-4 col-12 mx-auto text-center"><div> <img src="../public/img/status-pagamento/aprovado.png" class="mx-auto col-4"> </div> <div class="mt-4"> <h3>Pagamento efetuado com sucesso</h3> </div> <div class="mt-0 mb-5"> <h5 class="pb-5">Seu número de pedido é: <b>#'+$('.pedido-id').val()+'</b></h5> <h5>Seu pedido já foi recebido e em alguns dias estará a caminho, você receberá por e-mail as alterações nos status. Para mais informações, acesse: <a href="#">Acompanhamento do pedido</a></h5> </div> </div>');
					$('.card-step3').fadeIn(500).removeClass('wizard-step-active');
					$('.card-step3').fadeIn(500).addClass('wizard-step-success');
					$('.card-step1 .edit-card').addClass('d-none');
					$('.card-step2 .edit-card').addClass('d-none');
					$('.card-step3 .edit-card').addClass('d-none');
				}else if(data.status == "refused" || data.status == "chargedback" || data.status == "refunded"){
					$('.status').html('<div class="my-4 col-12 mx-auto text-center"><div> <img src="../public/img/status-pagamento/recusado.png" class="mx-auto col-4"> </div> <div class="mt-4"> <h3>Pagamento não efetivado</h3> </div> <div class="mt-0 mb-5"> <h5>Ops!! Seu pedido foi recusado, tente novamente.</h5> </div> </div>');
					$('.card-step3').fadeIn(500).removeClass('wizard-step-active');
					$('.card-step3').fadeIn(500).addClass('wizard-step-danger');
					$('.card-step1 .edit-card').addClass('d-none');
					$('.card-step2 .edit-card').addClass('d-none');
					$('.card-step3 .edit-card').addClass('d-none');
				}else if(data.status == "processing" || data.status == "waiting_payment" || data.status == "analyzing" || data.status == "pending_review"){
					$('.status').html('<div class="my-4 col-12 mx-auto text-center"><div> <img src="../public/img/status-pagamento/analise.png" class="mx-auto col-4"> </div> <div class="mt-4"> <h3>Aguardando o pagamento</h3> </div> <div class="mt-0 mb-5"> <h5 class="pb-5">Seu número de pedido é: <b>#'+$('.pedido-id').val()+'</b></h5> <h5>Seu pedido foi recebido, a confirmação de pagamento do boleto pode demorar em até 48 horas, a qualquer momento receberá por e-mail mais informações. <a href="'+data.boleto_url+'" target="_blank"> Clique aqui para donwload do boleto.</a> </h5> </div> </div>');
					$('.card-step3').fadeIn(500).removeClass('wizard-step-active');
					$('.card-step3').fadeIn(500).addClass('wizard-step-warning');
					$('.card-step1 .edit-card').addClass('d-none');
					$('.card-step2 .edit-card').addClass('d-none');
					$('.card-step3 .edit-card').addClass('d-none');
				}else{
					$('.card-step1 .edit-card').addClass('d-none');
					$('.card-step2 .edit-card').addClass('d-none');
					$('.card-step3 .edit-card').addClass('d-none');
				}
				window.open(data.boleto_url, '_blank');

				setTimeout(function(){
					$('#modal-processamento').modal('hide');
				}, 200);
			}, error: function(data){ 
				setTimeout(function(){ 
					$('#step3').fadeIn(500).removeClass('d-none');
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
				}, 500);
			}
		});
	});


	// Selecionando meios de pagamento
	$("#pay1").on('click', function(){
		$('#card_credit').removeClass('d-none');
		$('input[value=2]').removeAttr('checked');
		$('input[value=1]').attr('checked', 'checked');
		$('#boleto').addClass('d-none');
	});
	$("#pay2").on('click', function(){
		$('#boleto').removeClass('d-none');
		$('input[value=1]').removeAttr('checked');
		$('input[value=2]').attr('checked', 'checked');
		$('#card_credit').addClass('d-none');
	});
	// Selecionando meios de pagamento



	// Retornando bandeira do cartão
	$("#card_number").on('keyup', function(){
		var card = {} 
		card.card_number = $("#step3 #card_number").val();
		$('.card_number').attr('class', 'card_number form-control creditcard');
		var cardValidations = pagarme.validate({card: card})
		$('.card_number').addClass(cardValidations.card.brand); 
	});
	// Retornando bandeira do cartão

	/*
	$('#step1').on('change', function(){
		if(validator1.successList.length != 0){
			$( "#step1" ).submit();
		}
	});
	$('#step2').on('change', function(){
		if(validator2.successList.length != 0){
			$( "#step2" ).submit();
		}
	});*/


	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
		//$('#'+this.id).removeClass('bg-success text-white');	
	});

	
});
</script>
@endsection 

@include('template.footer')

