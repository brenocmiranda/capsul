@extends('template.index')

@section('title')
Configurações
@endsection

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <div class="mx-3">
        <h1>Configurações</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
            <div class="breadcrumb-item"><a href="{{route('configuracoes')}}">Configurações</a></div>
            <div class="breadcrumb-item active">Geral</div>
        </div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <form method="POST" action="{{ route('configuracoes.geral.salvar') }}" enctype="multipart/form-data">
            @csrf

            @if(Session::has('confirm'))
            <p class="py-2 alert alert-dismissible alert-{{ Session::get('confirm')['class'] }}  fade show" role="alert">
              {{ Session::get('confirm')['mensagem'] }}
              <button type="button" class="close text-dark" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </p>
            @endif

            <div class="card">
              <div class="card-header">
                <h3 class="section-title my-0">Geral</h3>  
              </div>
              <div class="card-body">
                <div class="col-12">
                  <h6>Descrição da loja</h6>
                  <hr class="mt-2">
                  <div class="mt-4 mb-5">
                    
                    <div class="form-group col-5">
                      <label>Nome da loja <span class="text-danger">*</span></label>
                      <div class="input-group"> 
                        <input type="text" class="form-control" name="nome_loja" value="{{$geral->nome_loja}}" required>
                      </div>
                    </div>
                    <div class="form-group col-7">
                      <label>E-mail para recebimento dos pedidos <span class="text-danger">*</span></label>
                      <div class="input-group"> 
                        <input type="text" class="form-control" name="email_pedidos" value="{{$geral->email_pedidos}}" required>
                      </div>
                    </div>
                    <div class="form-group col-12 mb-0">
                      <label>Descrição da loja <span class="text-danger">*</span></label>
                      <textarea class="summernote" name="descricao_loja">{{$geral->descricao_loja}}</textarea>
                    </div>
                    <div class="d-flex">
                      <div class="form-group col-3">
                        <label>Logotipo <span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-12">
                            <div class="border p-3 rounded text-center">
                              <img src="{{ asset('storage/app/system/capsul.png').'?'.rand() }}?<?php echo rand();?>" style="height: 50px;" id="PreviewImage" value="1">
                              <input type="file" class="px-0 col-12 position-absolute mx-auto h-100  pointer" style="opacity: 0; top: 0%; left: 0%" accept=".png, .jpg, .jpeg" name="logotipo" id="logotipo" onchange="image(this);" title="Selecione seu ícone">
                            </div>
                            <small class="my-2">Aceitamos .png, .jpg ou .svg</small>
                          </div>
                        </div>                            
                      </div>
                      <div class="form-group col-3">
                        <label>Icone <span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-12">
                            <div class="border p-3 rounded text-center">
                              <img src="{{ asset('storage/app/system/icon.png').'?'.rand() }}?<?php echo rand();?>"  style="height: 50px;" id="PreviewImage">
                              <input type="file" class="px-0 col-12 position-absolute mx-auto h-100  pointer" style="opacity: 0; top: 0%; left: 0%" accept=".png, .jpg, .jpeg" name="icone" id="icone" onchange="image(this);" title="Selecione seu ícone">
                            </div>
                            <small class="my-2">Aceitamos .png, .jpg ou .svg</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <h6>Endereço</h6>
                  <hr class="mt-2">
                  <div class="mt-4 mb-5">
                    <div class="form-group col-3">
                        <label>CEP <i class="text-danger">*</i></label>
                        <input type="text" name="cep" class="cep form-control" placeholder="39270-000" value="{{$geral->cep}}" required>
                        <small class="error"></small>
                    </div>
                    <div class="d-flex">
                        <div class="form-group col-8 p-02">
                            <label>Endereço <i class="text-danger">*</i></label>
                            <input type="text" name="endereco" class="form-control" placeholder="Rua da Antonio Nascimento" onkeyup="this.value = this.value.toUpperCase();" value="{{$geral->endereco}}" required>
                        </div>
                        <div class="form-group col-3 p-0">
                            <label>Numero <i class="text-danger">*</i></label>
                            <input type="number" name="numero" class="form-control" placeholder="268" value="{{$geral->numero}}" required>
                        </div>
                    </div>
                    <div class="form-group col-5">
                        <label>Bairro <i class="text-danger">*</i></label>
                        <input type="text" name="bairro" class="bairro form-control" onkeyup="this.value = this.value.toUpperCase();" value="{{$geral->bairro}}" disabled>
                        <input type="hidden" name="bairro1" class="bairro1" value="{{$geral->bairro}}">
                    </div>
                    <div class="d-flex">
                      <div class="form-group col-4">
                          <label>Cidade <i class="text-danger">*</i></label>
                          <input type="text" name="cidade" class="cidade form-control" onkeyup="this.value = this.value.toUpperCase();" value="{{$geral->cidade}}" disabled>
                          <input type="hidden" name="cidade1" class="cidade1" value="{{$geral->cidade}}">
                      </div>
                      <div class="form-group col-3">
                          <label>Estado <i class="text-danger">*</i></label>
                          <input type="text" name="estado" class="estado form-control" onkeyup="this.value = this.value.toUpperCase();" value="{{$geral->estado}}" disabled>
                          <input type="hidden" name="estado1" class="estado1" value="{{$geral->estado}}">
                      </div> 
                    </div> 
                    <div class="form-group col-8">
                      <label>Complemento</label>
                      <input type="text" name="complemento" placeholder="Ex.: Apt., Loja 1, Casa" class="form-control" onkeyup="this.value = this.value.toUpperCase();" value="{{$geral->complemento}}">
                    </div>                                
                </div>

                  <h6>Contato</h6>
                  <hr class="mt-2">
                  <div class="mt-4 mb-5">
                    <div class="form-group col-5">
                      <label>Razão social  <span class="text-danger">*</span></label>
                      <div class="input-group"> 
                        <input type="text" class="form-control" name="razao_social" value="{{$geral->razao_social}}" required>
                      </div>
                    </div>
                    <div class="form-group col-3">
                      <label>CNPJ <span class="text-danger">*</span></label>
                      <div class="input-group"> 
                        <input type="text" class="form-control cnpj" name="cnpj" value="{{$geral->cnpj}}" required>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <label>E-mail <span class="text-danger">*</span></label>
                      <div class="input-group"> 
                        <input type="email" class="form-control" name="email" value="{{$geral->email}}" required>
                      </div>
                    </div>
                    <div class="row col">
                      <div class="form-group col-3">
                        <label>Telefone ou Celular <span class="text-danger">*</span></label>
                        <div class="input-group"> 
                          <input type="text" class="telefone form-control" name="telefone"  value="{{$geral->telefone}}" required>
                        </div>
                      </div>
                      <div class="form-group col-3">
                        <label>WhatsApp <span class="text-danger">*</span></label>
                        <div class="input-group"> 
                          <input type="text" class="telefone form-control" name="whatsapp" value="{{$geral->whatsapp}}" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>

            <div class="col-12 mb-5 text-right">
              <a href="{{ route('configuracoes') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
              <button class="btn btn-primary btn-lg col-2 mx-1">Salvar</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('support')
<script type="text/javascript">     
  $(document).ready(function (){
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.telefone').mask('(00) 00000-0000');
    $('.cep').mask('00000-000');

    //Quando o campo cep perde o foco.
    $(".cep").blur(function(){
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
                        $(".error").html('');
                        //Atualiza os campos com os valores da consulta.
                        if(dados.localidade){
                            $('.cidade').attr('disabled', 'disabled');
                            $('.cidade').val(dados.localidade.toUpperCase());
                            $(".cidade1").val(dados.localidade.toUpperCase());
                        }else{
                            $(".cidade").removeAttr('disabled');
                        }
                        if(dados.uf){
                            $(".estado").attr('disabled', 'disabled');
                            $(".estado").val(dados.uf.toUpperCase());
                            $(".estado1").val(dados.uf.toUpperCase());
                        }else{
                            $(".estado").removeAttr('disabled');
                        }
                        if(dados.bairro){
                            $(".bairro").attr('disabled', 'disabled');
                            $(".bairro").val(dados.bairro.toUpperCase());
                            $(".bairro1").val(dados.bairro.toUpperCase());
                        }else{
                            $(".bairro").removeAttr('disabled');
                        }

                    }else {
                        //CEP pesquisado não foi encontrado.
                        $(".error").html('O seu CEP não pode ser encontrado!')
                    }
                });
            } else {
                //cep é inválido.
                $(".error").html('O seu CEP é inválido!')
            }
        }else {
            //cep sem valor, limpa formulário.
            $(".cidade").val('');
            $(".estado").val('');
            $(".cidade").val('');
            $(".cep").val('');
            $(".error").html('');
            $(".bairro").removeAttr('disabled');
            $(".cidade").removeAttr('disabled');
            $(".estado").removeAttr('disabled');
        }
    });

});
</script>
@endsection