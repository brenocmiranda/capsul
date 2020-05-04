@extends('template.index')

@section('title')
Editar cliente
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Editar informações</h1>

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

            <div>
                <div class="m-4 mb-1 py-0">
                    <ul class="nav nav-pills col-12" id="myTab" role="tablist">
                        <li class="nav-item text-center col-2">
                            <a class="nav-link active mx-1" id="informacao-tab" data-toggle="tab" href="#informacao" role="tab" aria-controls="informacao" aria-selected="true">Informações</a>
                        </li>
                        <li class="nav-item text-center col-3">
                            <a class="nav-link mx-1" id="pedidos-tab" data-toggle="tab" href="#pedidos" role="tab" aria-controls="pedidos" aria-selected="false">Últimos pedidos <span class="badge badge-light badge-pill">{{count($pedidos)}}</span></a>
                        </li>
                        <li class="nav-item text-center col-3">
                            <a class="nav-link mx-1" id="carrinhos-tab" data-toggle="tab" href="#carrinhos" role="tab" aria-controls="carrinhos" aria-selected="false">Carrinhos abandonados <span class="badge badge-light badge-pill">{{count($carrinhos)}}</span></a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="mx-3">

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="informacao" role="tabpanel" aria-labelledby="informacao-tab">
                    <form method="POST" action="{{ route('clientes.editando', $cliente->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card" id="card-1">
                            <div class="card-body">
                                <div class="row mx-3">
                                    <h5 class="section-title my-3">Informações básicas</h5><small class="mx-3 text-primary my-auto"><b>{{($cliente->tipo == 'pf' ? 'PESSOA FÍSICA' : 'PESSOA JURÍDICA')}}</b></small>
                                </div>
                                <hr>

                                <div class="form-group col-12 mb-2 mt-4">
                                    <label class="custom-switch px-0">
                                        <input type="checkbox" name="ativo" class="custom-switch-input" {{($cliente->ativo == 1 ? ' checked' : '')}}>
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
                                            <option value="{{$grupo->id}}" {{($grupo->id == $cliente->id_grupo_cliente ? ' selected' : '')}}>{{$grupo->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>    
                                </div> 
                                <div class="form-group col-6">
                                    <label>Nome completo <i class="text-danger">*</i></label>
                                    <input type="text" name="nome" class="form-control" value="{{$cliente->nome}}" required>
                                </div>
                                <div class="form-group col-6">
                                    <label>Email <i class="text-danger">*</i></label>
                                    <input type="email" name="email" class="form-control" placeholder="cliente@grupocapsul.com.br" value="{{$cliente->email}}" required>
                                </div>
                                <div class="row col-8">
                                    <div class="form-group col-6">
                                        <label>CPF <i class="text-danger">*</i></label>
                                        <input type="text" name="documento" class="documento form-control" value="{{$cliente->documento}}" placeholder="000.000.000-00"  required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Telefone ou Celular <i class="text-danger">*</i></label>
                                        <input type="text" name="telefone" class="telefone form-control" value="{{(isset($cliente->RelationTelefone->numero) ? str_replace('+55', '', $cliente->RelationTelefone->numero) : '')}}" placeholder="(00) 00000-0000" required>
                                    </div>
                                </div>
                                <div class="form-group col-3">
                                    <label>Data de nascimento</label>
                                    <input type="date" name="data_nascimento" class="form-control" value="{{(isset($cliente->data_nascimento) ? $cliente->data_nascimento : '')}}" placeholder="__ / __ / ____">
                                </div> 
                                <div class="form-group col-12">
                                    <label>Observações</label>
                                    <textarea class="summernote" name="observacoes">{{(isset($cliente->observacoes) ? $cliente->observacoes : '')}}</textarea>
                                </div>
                                <hr class="mx-3">
                                <div class="form-group col-12">
                                    <h6>
                                        <a href="javascript:void(0)" id="alterarSenha" class="btn btn-light shadow-none">Alterar senha <i class="fa fa-caret-down"></i></a>
                                    </h6>

                                    <div class="alterarSenha d-none">
                                        <div class="form-group col-4">
                                            <label>Senha <i class="text-danger">*</i></label>
                                            <input type="password" name="password" class="password form-control">
                                        </div> 
                                        <div class="form-group col-4">
                                            <label>Confirme a senha <i class="text-danger">*</i></label>
                                            <input type="password" name="senha" class="senha form-control">
                                            <small class="mt-2 coincidem"></small>
                                        </div> 
                                    </div>
                                </div> 

                            </div>
                        </div>

                        <div id="localizacao">
                            @if(!empty($enderecos))
                            @foreach($enderecos as $key => $endereco)
                            <div class="card" id="card-{{$key+2}}">
                                <div class="card-header py-0">
                                    <h5 class="section-title d-flex">
                                        <input type="text" name="nomeEndereco[]" class="border-0" placeholder="Nome do seu endereço" value="{{$endereco->nome}}" required>
                                    </h5>
                                    <a href="javascript:void(0)" onclick="removeCard({{$key+2}})" class="ml-auto" title="Remover endereço">
                                        <i class="mdi mdi-close mdi-24px"></i>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="form-group col-3">
                                        <label>CEP <i class="text-danger">*</i></label>
                                        <input type="text" name="cep[]" class="cep form-control" placeholder="39270-000" value="{{$endereco->cep}}" required>
                                        <input type="hidden" name="id_endereco[]" value="{{$endereco->id}}">
                                        <small class="error"></small>
                                    </div>
                                    <div class="d-flex">
                                        <div class="form-group col-8 p-02">
                                            <label>Endereço <i class="text-danger">*</i></label>
                                            <input type="text" name="endereco[]" class="form-control" placeholder="Rua da Antonio Nascimento" onkeyup="this.value = this.value.toUpperCase();"  value="{{$endereco->endereco}}" required>
                                        </div>
                                        <div class="form-group col-3 p-0">
                                            <label>Numero <i class="text-danger">*</i></label>
                                            <input type="number" name="numero[]" class="form-control" placeholder="268" value="{{$endereco->numero}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-10">
                                        <label>Complemento</label>
                                        <input type="text" name="complemento[]" placeholder="Ex.: Apt., Loja 1, Casa" class="form-control" onkeyup="this.value = this.value.toUpperCase();" value="{{$endereco->complemento}}">
                                    </div>
                                    <div class="form-group col-5">
                                        <label>Bairro <i class="text-danger">*</i></label>
                                        <input type="text" name="bairro[]" class="bairro form-control" onkeyup="this.value = this.value.toUpperCase();" value="{{$endereco->bairro}}" requerid>
                                        <input type="hidden" name="bairro1[]" class="bairro1" value="{{$endereco->bairro}}">
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Cidade <i class="text-danger">*</i></label>
                                        <input type="text" name="cidade[]" class="cidade form-control" onkeyup="this.value = this.value.toUpperCase();" value="{{$endereco->cidade}}" disabled>
                                        <input type="hidden" name="cidade1[]" class="cidade1" value="{{$endereco->cidade}}">
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Estado <i class="text-danger">*</i></label>
                                        <input type="text" name="estado[]" class="estado form-control" onkeyup="this.value = this.value.toUpperCase();" value="{{$endereco->estado}}" disabled>
                                        <input type="hidden" name="estado1[]" class="estado1" value="{{$endereco->estado}}">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Destinatário <i class="text-danger">*</i></label>
                                        <input type="text" name="destinatario[]" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="COMPRECA MARKETPLACE" value="{{$endereco->destinatario}}" requerid>
                                    </div>                                  
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>

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
                </div>

                <div class="tab-pane fade" id="pedidos" role="tabpanel" aria-labelledby="pedidos-tab">
                    <div class="card" id="card-2">
                        <div class="card-header">
                            <h5 class="section-title my-0">Últimos pedidos</h5>
                        </div>
                        <div class="card-body">
                            <div class="col-12 table-responsive mt-3">
                                @if(count($pedidos) > 0)
                                <table class="table text-center">
                                    <thead class="text-uppercase">
                                        <tr>
                                            <th>Produtos</th>
                                            <th>Data</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>N. do pedido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pedidos as $ped)
                                        <tr>
                                            <td class="ml-2">
                                                <div class="row text-left">
                                                    <div class="px-3 my-auto">
                                                        <img src="{{ url('storage/app/'.$ped->RelationProduto->RelationImagensPrincipal->first()->caminho)}}" alt="Imagem atual" style="height: auto; width: 70px;" class="p-1 border rounded">
                                                    </div>
                                                    <div class="px-3 my-auto">
                                                        <p class="nome m-0"><b>{{$ped->RelationProduto->nome}}</b></p>
                                                        <label>{{$ped->RelationProduto->cod_sku}}</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                               <div class="col-12">
                                                    {{date_format($ped->created_at, "d/m/Y H:i:s")}}
                                                </div>
                                                <div class="col-12 font-weight-bold">
                                                    {{$ped->created_at->subMinutes(2)->diffForHumans()}}
                                                </div>
                                            </td>
                                            <td>
                                                R$ {{number_format(($ped->valor_compra - $ped->desconto_aplicado + $ped->RelationRastreamento->valor_envio), 2, ',', '.')}}
                                            </td>
                                            <td>
                                                <div class="status badge badge-{{
                                                    ($ped->RelationStatus->last()->posicao==1 || $ped->RelationStatus->last()->posicao==7 ? 'dark' :
                                                    ($ped->RelationStatus->last()->posicao==2 || $ped->RelationStatus->last()->posicao==6 || $ped->RelationStatus->last()->posicao==8 ? 'warning' : 
                                                    ($ped->RelationStatus->last()->posicao==3 || $ped->RelationStatus->last()->posicao==5 || $ped->RelationStatus->last()->posicao==9 ? 'success' :
                                                    ($ped->RelationStatus->last()->posicao==4 || $ped->RelationStatus->last()->posicao==10 ? 'danger' :  ''))))}}">
                                                <span>{{strtoupper($ped->RelationStatus->last()->nome)}}</span>
                                            </div>
                                            </td>
                                            <td>
                                                <a href="{{route('pedidos.detalhes', $ped->id)}}" class="nome text-decoration-none">#{{$ped->codigo}}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="alert alert-light">O cliente não possui outros pedidos.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="carrinhos" role="tabpanel" aria-labelledby="carrinhos-tab">
                    <div class="card" id="card-3">
                        <div class="card-body">
                            <div class="row mx-3">
                                <h5 class="section-title my-3">Carrinhos abandondos</h5>
                            </div>
                            <hr>
                            <div>
                                <section id="lin_1">
                                    <div class="table-responsive mt-3">
                                        @if(count($carrinhos) > 0)
                                        <table class="table text-center">
                                            <thead class="text-uppercase">
                                                <tr>
                                                    <th>Produto</th>
                                                    <th>Quantidade</th>
                                                    <th>Valor</th>
                                                    <th>Data</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($carrinhos as $carrinho)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="my-auto mx-3">
                                                                <img src="{{ url('storage/app/'.$carrinho->RelationProduto->RelationImagensPrincipal->first()->caminho) }}" alt="Imagem do produto" style="height: auto; width: 55px;">
                                                            </div>
                                                            <div class="my-auto text-left">
                                                                <a href="{{route('produtos.editar', $carrinho->id_produto)}}" class="text-decoration-none">
                                                                    <label class="nome col-12 m-0 pointer">{{$carrinho->RelationProduto->nome}}
                                                                    </label>
                                                                    <label class="col-12 mb-0 text-dark">
                                                                        {{$carrinho->RelationProduto->cod_sku}}
                                                                    </label>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{$carrinho->quantidade}}
                                                    </td>
                                                    <td>
                                                        R$ {{number_format(($ped->valor_compra - $ped->desconto_aplicado + $ped->RelationRastreamento->valor_envio), 2, ',', '.')}}
                                                    </td>
                                                    <td class="text-center">
                                                       <div class="col-12">
                                                            {{date_format($carrinho->created_at, "d/m/Y H:i:s")}}
                                                        </div>
                                                        <div class="col-12 font-weight-bold">
                                                            {{$carrinho->created_at->subMinutes(2)->diffForHumans()}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <div class="alert alert-light">Nenhum carrinho encontrado.</div>
                                        @endif
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
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
                <input type="hidden" name="id_endereco[]" value="">
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
        // Mascaras
        @if($cliente->tipo == 'pf')
            $('.documento').mask('000.000.000-00', {reverse: true});
        @else
            $('.documento').mask('00.000.000/0000-00', {reverse: true});
        @endif
        
        $('.cep').mask('00000-000');
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

        // Novos endereços
        var endereco = "{{(isset($key) ? $key+3: 2)}}";
        $('.novaLocalizacao').on('click', function(){
            $('#localizacao').append($('#card-localizacao').html());
            $('#localizacao .card:last-child').attr('id', 'card-'+endereco);
            $('#localizacao .card-header a:last-child').attr('onclick', 'removeCard('+endereco+')');
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
                        $.getJSON("https://viacep.com.br/ws/"+cep+"/json/?callback=?", function(dados) {
                            if (!("erro" in dados)) {
                                $(".card:last-child .error").html('');
                                //Atualiza os campos com os valores da consulta.
                                if(dados.localidade){
                                    $('.card:last-child .cidade').attr('disabled', 'disabled');
                                    $('.card:last-child .cidade').val(dados.localidade.toUpperCase());
                                    $(".card:last-child .cidade1").val(dados.localidade.toUpperCase());
                                }else{
                                    $(".card:last-child .cidade").removeAttr('disabled');
                                }
                                if(dados.uf){
                                    $(".card:last-child .estado").attr('disabled', 'disabled');
                                    $(".card:last-child .estado").val(dados.uf.toUpperCase());
                                    $(".card:last-child .estado1").val(dados.uf.toUpperCase());
                                }else{
                                    $(".card:last-child .estado").removeAttr('disabled');
                                }
                                if(dados.bairro){
                                    $(".card:last-child .bairro").attr('disabled', 'disabled');
                                    $(".card:last-child .bairro").val(dados.bairro.toUpperCase());
                                    $(".card:last-child .bairro1").val(dados.bairro.toUpperCase());
                                }else{
                                    $(".card:last-child .bairro").removeAttr('disabled');
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
                    $.getJSON("https://viacep.com.br/ws/"+cep+"/json/?callback=?", function(dados) {
                        if (!("erro" in dados)) {
                            $(".card:last-child .error").html('');
                            //Atualiza os campos com os valores da consulta.
                            if(dados.localidade){
                                $('.card:last-child .cidade').attr('disabled', 'disabled');
                                $('.card:last-child .cidade').val(dados.localidade.toUpperCase());
                                $(".card:last-child .cidade1").val(dados.localidade.toUpperCase());
                            }else{
                                $(".card:last-child .cidade").removeAttr('disabled');
                            }
                            if(dados.uf){
                                $(".card:last-child .estado").attr('disabled', 'disabled');
                                $(".card:last-child .estado").val(dados.uf.toUpperCase());
                                $(".card:last-child .estado1").val(dados.uf.toUpperCase());
                            }else{
                                $(".card:last-child .estado").removeAttr('disabled');
                            }
                            if(dados.bairro){
                                $(".card:last-child .bairro").attr('disabled', 'disabled');
                                $(".card:last-child .bairro").val(dados.bairro.toUpperCase());
                                $(".card:last-child .bairro1").val(dados.bairro.toUpperCase());
                            }else{
                                $(".card:last-child .bairro").removeAttr('disabled');
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
            }
        });
    });
</script>
@endsection
