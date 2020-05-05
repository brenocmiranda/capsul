@extends('template.index')

@section('title')
Adicionar cliente
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Novo cliente</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('clientes.lista')}}">Clientes</a></div>
                    <div class="breadcrumb-item active">Adicionar</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('clientes.salvar') }}" enctype="multipart/form-data">
                @csrf
                <div class="row col mb-3 mx-auto">
                    <div class="col-3 border rounded-lg mx-1 text-center bg-white border-primary" id="variante1" style="cursor: pointer">
                        <div class="pt-3">
                            <label class="colorinput mx-2">
                                <input type="radio" name="tipo" value="pf" class="colorinput-input" checked>
                                <span class="colorinput-color bg-light border rounded-circle"></span>
                            </label>
                            <i class="fa fa-user f20" style="font-size: 25px"></i>
                        </div>
                        <div class="py-2">
                            <label class="font-weight-bold">Pessoa Física</label>
                        </div>
                    </div>
                    <div class="col-3 border rounded-lg mx-1 text-center bg-white" id="variante2" style="cursor: pointer">
                        <div class="pt-3">
                            <label class="colorinput mx-2">
                                <input type="radio" name="tipo" value="pj" class="colorinput-input">
                                <span class="colorinput-color bg-light border rounded-circle"></span>
                            </label>
                            <i class="fa fa-industry f20" style="font-size: 25px"></i>
                        </div>
                        <div class="py-2">
                            <label class="font-weight-bold">Pessoa jurídica</label>
                        </div>
                    </div>
                </div>

                <div class="card" id="card-1">
                    <div class="card-header">
                        <h5 class="section-title my-3 col">Informações básicas</h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="form-group col-12">
                            <label class="custom-switch px-0">
                                <input type="checkbox" name="ativo" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description"><b>Ativo</b></span>
                            </label>
                        </div>
                        <div class="form-group col-4">
                            <label>Grupos</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                                <select class="grupos form-control" name="id_grupo_cliente">
                                    <option disabled="disabled">Selecione um grupo</option>
                                    <option value="">Nenhum</option>
                                    @foreach($grupos as $grupo)
                                    <option value="{{$grupo->id}}">{{$grupo->nome}}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div> 
                        <div class="form-group col-6">
                            <label><span id="nome">Nome completo</span> <i class="text-danger">*</i></label>
                            <input type="text" name="nome" class="form-control" onkeyup="this.value = this.value.toUpperCase();" required>
                        </div>
                        <div class="form-group col-6">
                            <label>Email <i class="text-danger">*</i></label>
                            <input type="email" name="email" class="form-control" placeholder="cliente@grupocapsul.com.br" required autocomplete="new-password">
                        </div>
                        <div class="row col-8">
                            <div class="form-group col-6">
                                <label><span id="nomeDocumento">CPF</span> <i class="text-danger">*</i></label>
                                <input type="text" name="documento" class="documento form-control" required>
                            </div>
                            <div class="form-group col-6">
                                <label>Telefone ou Celular <i class="text-danger">*</i></label>
                                <input type="text" name="telefone" class="telefone form-control" placeholder="(00) 00000-0000" required>
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <label>Data de nascimento</label>
                            <input type="date" name="data_nascimento" class="form-control" placeholder="__ / __ / ____">
                        </div> 
                        <div class="form-group col-12">
                            <label>Observações</label>
                            <textarea class="summernote" name="observacoes"></textarea>
                        </div>
                        <hr class="mx-3">
                        <div class="form-group col-12">
                            <h6>
                                <a href="javascript:void(0)" id="alterarSenha" class="btn btn-light shadow-none">Alterar senha <i class="fa fa-caret-down"></i>
                                </a>
                            </h6>
                        </div> 
                        <div class="alterarSenha d-none">
                            <div class="form-group col-4">
                                <label>Senha <i class="text-danger">*</i></label>
                                <input type="password" name="password" class="password form-control" autocomplete="new-password">
                            </div> 
                            <div class="form-group col-4">
                                <label>Confirme a senha <i class="text-danger">*</i></label>
                                <input type="password" name="senha" class="senha form-control" autocomplete="new-password">
                                <small class="mt-2 coincidem"></small>
                            </div> 
                        </div>
                    </div>
                </div>

                <div id="localizacao"></div>

                <a href="javascript:void(0)" class="novaLocalizacao mx-2 mb-3">
                    <i class="mdi mdi-plus"></i>  
                    <span class="px-1">Adicionar um novo endereço</span>
                </a>

                <hr>

                <div class="col-12 mb-5 text-right">
                    <a href="{{ route('clientes.lista') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
                    <button class="btn btn-primary btn-lg col-2 mx-1">Salvar</button>
                </div>
            </form>
        </section>
    </div>
    @endsection

    @section('modal')
    <div id="card-localizacao" class="d-none">
        <div class="card">
            <div class="card-header py-0">
                <h5 class="section-title d-flex">
                    <input type="text" name="nomeEndereco[]" class="border-0" placeholder="Nome do seu endereço" required>
                </h5>
                <a href="javascript:void(0)" class="ml-auto" title="Remover endereço">
                    <i class="mdi mdi-close mdi-24px"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="form-group col-3">
                    <label>CEP <i class="text-danger">*</i></label>
                    <input type="text" name="cep[]" class="cep form-control" placeholder="39270-000" required>
                    <small class="error"></small>
                </div>
                <div class="d-flex">
                    <div class="form-group col-8 p-02">
                        <label>Endereço <i class="text-danger">*</i></label>
                        <input type="text" name="endereco[]" class="form-control" placeholder="Rua da Antonio Nascimento" onkeyup="this.value = this.value.toUpperCase();" required>
                    </div>
                    <div class="form-group col-3 p-0">
                        <label>Numero <i class="text-danger">*</i></label>
                        <input type="number" name="numero[]" class="form-control" placeholder="268" required>
                    </div>
                </div>
                <div class="form-group col-10">
                    <label>Complemento</label>
                    <input type="text" name="complemento[]" placeholder="Ex.: Apt., Loja 1, Casa" class="form-control" onkeyup="this.value = this.value.toUpperCase();">
                </div>
                <div class="form-group col-5">
                    <label>Bairro <i class="text-danger">*</i></label>
                    <input type="text" name="bairro[]" class="bairro form-control" onkeyup="this.value = this.value.toUpperCase();" required>
                    <input type="hidden" name="bairro1[]" class="bairro1">
                </div>
                <div class="form-group col-4">
                    <label>Cidade <i class="text-danger">*</i></label>
                    <input type="text" name="cidade[]" class="cidade form-control" onkeyup="this.value = this.value.toUpperCase();" required>
                    <input type="hidden" name="cidade1[]" class="cidade1">
                </div>
                <div class="form-group col-3">
                    <label>Estado <i class="text-danger">*</i></label>
                    <input type="text" name="estado[]" class="estado form-control" onkeyup="this.value = this.value.toUpperCase();" required>
                    <input type="hidden" name="estado1[]" class="estado1">
                </div>
                <div class="form-group col-6">
                    <label>Destinatário <i class="text-danger">*</i></label>
                    <input type="text" name="destinatario[]" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="GRUPO CAPSUL" requerid>
                </div>                                  
            </div>
        </div>
    </div>
    @endsection

    @section('support')
    <script type="text/javascript">
        function removeCard(id){
            $('#card-'+id).remove();
        }

        $(document).ready(function (){
            $('.documento').mask('000.000.000-00', {reverse: true});
            $('.telefone').mask('(00) 00000-0000');

            $('#alterarSenha').click(function(){
                if ($('.alterarSenha').hasClass('d-none')){
                    $('.alterarSenha').removeClass('d-none');
                }else{
                    $('.alterarSenha').addClass('d-none');
                }
            });

            $('.senha, .password').blur(function(){
                $('.senha').removeClass('border-danger');
                if ($('.senha').val() == $('.password').val()){
                    $('.coincidem').html('<div class="text-success m-2">Suas senhas estão iguais!</div>');
                }else{
                    $('.coincidem').html('<div class="text-danger m-2">As senhas não coincidem!</div>');
                    $('.senha').addClass('border-danger');
                }
            });

            // Tipo de produto
            $('#variante1').on('click', function(){
                $('#variante2').removeClass('border-primary');
                $('#variante2 input').removeAttr('checked');
                $(this).addClass('border-primary');
                $('#nome').html('Nome completo');
                $('#nomeDocumento').html('CPF');
                $('.documento').mask('000.000.000-00', {reverse: true});
                $('#variante1 input').attr('checked', 'checked');
            });
            $('#variante2').on('click', function(){
                $('#variante1').removeClass('border-primary');
                $('#variante1 input').removeAttr('checked');
                $(this).addClass('border-primary');
                $('#nome').html('Razão social');
                $('#nomeDocumento').html('CNPJ');
                $('.documento').mask('00.000.000/0000-00', {reverse: true});
                $('#variante2 input').attr('checked', 'checked');
            });
            
            // Novos endereços
            var endereco = 1;
            $('.novaLocalizacao').on('click', function(){
                $('#localizacao').append($('#card-localizacao').html());
                $('#localizacao .card:last-child').attr('id', 'card-'+endereco);
                $('#localizacao .card-header a:last-child').attr('onclick', 'removeCard('+endereco+')');
                $('#localizacao .card:last-child .section-title').html('Endereço '+endereco);
                $('#localizacao .cep').mask('00000-000');

                //Quando o campo cep perde o foco.
                $(".cep").blur(function() {
                    //Nova variável "cep" somente com dígitos.
                    var cep = $(this).val().replace(/\D/g, '');
                    //Verifica se campo cep possui valor informado.
                    if (cep != "") {
                        //Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;
                        //Valida o formato do CEP.
                        if(validacep.test(cep)) {
                            //Consulta o webservice viacep.com.br/
                            $.getJSON("https://ws.apicep.com/cep/"+cep+".json", function(dados) {
                                if (!("erro" in dados)) {
                                    $(".card:last-child .error").html('');
                                    //Atualiza os campos com os valores da consulta.
                                    if(dados.city){
                                        $('.card:last-child .cidade').attr('disabled', 'disabled');
                                        $('.card:last-child .cidade').val(dados.city.toUpperCase());
                                        $(".card:last-child .cidade1").val(dados.city.toUpperCase());
                                    }else{
                                        $(".card:last-child .cidade").removeAttr('disabled');
                                    }
                                    if(dados.state){
                                        $(".card:last-child .estado").attr('disabled', 'disabled');
                                        $(".card:last-child .estado").val(dados.state.toUpperCase());
                                        $(".card:last-child .estado1").val(dados.state.toUpperCase());
                                    }else{
                                        $(".card:last-child .estado").removeAttr('disabled');
                                    }
                                    if(dados.district){
                                        $(".card:last-child .bairro").attr('disabled', 'disabled');
                                        $(".card:last-child .bairro").val(dados.district.toUpperCase());
                                        $(".card:last-child .bairro1").val(dados.district.toUpperCase());
                                    }else{
                                        $(".card:last-child .bairro").removeAttr('disabled');
                                    }
                                    if(dados.address){
                                        $(".card:last-child .endereco").val(dados.address.toUpperCase());
                                    }
                                }else {
                                    //CEP pesquisado não foi encontrado.
                                    $(".card:last-child .error").html('O seu CEP não pode ser encontrado!')
                                }
                            });
                        } else {
                            //cep é inválido.
                            $(".card:last-child .error").html('O seu CEP é inválido!')
                        }
                    }else {
                        //cep sem valor, limpa formulário.
                        $(".card:last-child .cidade").val('');
                        $(".card:last-child .estado").val('');
                        $(".card:last-child .cidade").val('');
                        $(".card:last-child .cep").val('');
                        $(".card:last-child .error").html('');
                        $(".card:last-child .bairro").removeAttr('disabled');
                        $(".card:last-child .cidade").removeAttr('disabled');
                        $(".card:last-child .estado").removeAttr('disabled');
                    }
                });

            endereco++;
            });
        });
    </script>
    @endsection
