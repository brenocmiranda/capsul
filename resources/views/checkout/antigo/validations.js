$(document).ready(function (){
	// Mascaras 
	$('.documento').mask('000.000.000-00', {reverse: true});
	$('.telefone').mask('(00) 00000-0000');
	$('#cep').mask('00000-000');
	$('.card_expiration').mask('00/00');
	$('.card_number').mask('0000 0000 0000 0000');
	// Mascaras	

    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {
    	$("#endereco").attr('disabled', true);
    	$("#numero").attr('disabled', true);
    	$("#bairro").attr('disabled', true);
    	$(".country").html("");

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+cep+"/json/?callback=?", function(dados) {
                	if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#endereco").removeAttr('disabled');
				    	$("#numero").removeAttr('disabled');
				    	$("#bairro").removeAttr('disabled');
				    	$("#endereco").val("");
               			$("#bairro").val("");
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $(".country").html(dados.localidade+' - '+dados.uf);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);

                    }else {
                        //CEP pesquisado não foi encontrado.
                        $(".country").html('<b class="text-danger"> CEP não localizado.</b');
                    }
                });
            } else {
                //cep é inválido.
                $("#endereco").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#estado").val("");
                $(".country").html("");
                $(".country").html('<b class="text-danger">Formato de CEP inválido.</b');
            }
        }else {
            //cep sem valor, limpa formulário.
            $("#endereco").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#estado").val("");
            $("#cep").val("");
            $(".country").html("");
        }
    });

	// Contador de tempo da promoção
	$(".getting-started").countdown("{{date('Y/m/d') }}", function(event){
		$(this).text(event.strftime('%H:%M:%S'));
	});
	// Contador de tempo da promoção

	// Validação especial do CPF
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
	// Validação especial do CPF

	// Validações
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

	var validator2 = $('#step2').validate({
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
	// Validações

	// Envio dos dados ao banco
	$('#step1').submit(function(e){
	// Verificação de erros de validação
	if(validator1.errorList.length == 0){
		e.preventDefault();
		$.ajax({
			url: "./update/"+$('.pedido-id').val(),
			type: 'POST',
			data: new FormData(this),
			dataType:'JSON',
			contentType: false,
			cache: false,
			processData: false,    
			beforeSend: function () {
				$('#step1').fadeIn(500).addClass('d-none');
				$(".carregamento").append('<div class="processando mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only">Loading...</span></div><p>Salvando informações...</p></div>');
			}, success: function(data){
				$("input[name='destinatario']").val($("input[name='nome']").val());
				$('#step2').fadeIn(500).removeClass('d-none');
				$('#step1').fadeIn(500).addClass('d-none');
				$('.card-step1').fadeIn(500).removeClass('wizard-step-active');
				$('.card-step1').fadeIn(500).addClass('wizard-step-success');
				if($('.card-step2').hasClass('wizard-step-success')){
					$('.card-step2').fadeIn(500).removeClass('wizard-step-success');
					$('.card-step2 .edit-card').removeClass('d-none');
				}
				$('.card-step2').fadeIn(500).addClass('wizard-step-active');
				$('.card-step1 .edit-card').removeClass('d-none');

				if($('.card-step2').hasClass('wizard-step-success')){
					$('.card-step2').fadeIn(500).removeClass('wizard-step-success');
					$('.card-step2').fadeIn(500).addClass('wizard-step-active');
				}

				$(".processando").fadeIn(500).remove();
			}, error: function(data){ 
				setTimeout(function(){ 
					$('#step1').fadeIn(500).removeClass('d-none');
					$(".processando").fadeIn(500).remove();

					if(!data.responseJSON){
						console.log(data.responseText);
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
});

	$('#step2').submit(function(e){
	// Verificação de erros de validação
	if(validator2.errorList.length == 0){
		e.preventDefault();
		$.ajax({
			url: "./update/"+$('.pedido-id').val(),
			type: 'POST',
			data: new FormData(this),
			dataType:'JSON',
			contentType: false,
			cache: false,
			processData: false,    
			beforeSend: function () {
				$('#step2').fadeIn(500).addClass('d-none');
				$(".carregamento").append('<div class="processando mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only">Loading...</span></div><p>Salvando informações...</p></div>');
			}, success: function(data){
				$('#step3').fadeIn(500).removeClass('d-none');
				$('#step2').fadeIn(500).addClass('d-none');
				$('.card-step2').fadeIn(500).removeClass('wizard-step-active');
				$('.card-step2').fadeIn(500).addClass('wizard-step-success');
				$('.card-step3').fadeIn(500).addClass('wizard-step-active');
				$('.card-step2 .edit-card').removeClass('d-none');
				$(".processando").fadeIn(500).remove();
			}, error: function(data){ 
				console.log(data);
				setTimeout(function(){ 
					$('#step2').fadeIn(500).removeClass('d-none');
					$(".processando").fadeIn(500).remove();
					if(!data.responseJSON){
						console.log(data.responseText);
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
			pagarme.client.connect({ encryption_key: 'ek_test_6AzO7RhJjPNNJ3hkYVxzbl40LQt01g' })
			.then(client => client.security.encrypt(card))
			.then(card_hash => $('#card_hash').val(card_hash));
			
			  // o próximo passo aqui é enviar o card_hash para seu servidor, e
			  // em seguida criar a transação/assinatura 
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
			  		$(".carregamento").append('<div class="processando mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only">Loading...</span></div><p>Finalizando compra...</p></div>');
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
			  		$(".processando").fadeIn(500).remove();
			  	}, error: function(data){ 
			  		console.log(data);
			  		setTimeout(function(){ 
			  			$('#step3').fadeIn(500).removeClass('d-none');
			  			$(".processando").fadeIn(500).remove();
			  			if(!data.responseJSON){
			  				console.log(data.responseText);
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
					$(".carregamento").append('<div class="processando mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only">Loading...</span></div><p>Finalizando compra...</p></div>');
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
					$(".processando").fadeIn(500).remove();
				}, error: function(data){ 
					console.log(data);
					setTimeout(function(){ 
						$('#step3').fadeIn(500).removeClass('d-none');
						$(".processando").fadeIn(500).remove();
						if(!data.responseJSON){
							console.log(data.responseText);
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


	$(".card-step1 .edit-card").on('click', function(){
		// Ocultando forms e mostrando o editável
		$('.wizard-content').addClass('d-none');
		$('#step1').removeClass('d-none');

		// Trocando a cor dos cards e selecionando
		$('.wizard-step').fadeIn(500).removeClass('wizard-step-active');
		$('.card-step1').fadeIn(500).removeClass('wizard-step-success');
		$('.card-step1').fadeIn(500).addClass('wizard-step-active');
		$(".card-step1 .edit-card").addClass('d-none');
	});
	$(".card-step2 .edit-card").on('click', function(){
		// Ocultando forms e mostrando o editável
		$('.wizard-content').addClass('d-none');
		$('#step2').removeClass('d-none');

		// Trocando a cor dos cards e selecionando
		$('.wizard-step').fadeIn(500).removeClass('wizard-step-active');
		$('.card-step2').fadeIn(500).removeClass('wizard-step-success');
		$('.card-step2').fadeIn(500).addClass('wizard-step-active');
		$(".card-step2 .edit-card").addClass('d-none');
	});
});