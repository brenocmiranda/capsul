@extends('template.index')

@section('title')
Editar variação
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Editar variação</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('produtos.lista')}}">Produtos</a></div>
                    <div class="breadcrumb-item"><a href="{{route('variacoes.lista')}}">Variações</a></div>
                    <div class="breadcrumb-item active">Editar</div>
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

            <form method="POST" action="{{ route('variacoes.editando', $variacao->id) }}" >
                @csrf
                <div class="card" id="card-1">
                    <div class="card-body">
                        <div class="form-group col-10">
                            <label>Nome da variação <i class="text-danger">*</i></label>
                            <input type="text" name="nome" class="form-control" value="{{$variacao->nome}}" required>
                        </div>
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-8">
                                    <label>Opções</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </div>
                                        <select class="id_opcao form-control h-100" name="id_opcao">
                                            <option>Selecione uma opção</option>
                                            @foreach($opcoes as $opcao)
                                            <option value="{{$opcao->id}}" {{($opcao->id == $variacao->id_opcao ? 'selected' : '')}}>{{$opcao->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>    
                                </div> 
                                <div class="col-4 mt-4">
                                    <a class="btn btn-primary btn-lg text-white" style="width: 100% !important;" data-toggle="modal" data-target="#variacao-opcao"> <i class="fas fa-plus"></i> Cadastrar opção</a>
                                </div>     
                            </div>                                
                        </div>
                        <div class="form-group col-6">
                            <label>Valor <i class="text-danger">*</i></label>
                            <input type="text" name="valor" class="form-control" value="{{$variacao->valor}}" required>
                        </div>
                    </div>
                </div>

                <hr>
                
                <div class="col-12 mb-5 text-right">
                    <a href="{{ route('variacoes.lista') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
                    <button class="btn btn-primary btn-lg col-2 mx-1">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>
</div>
@endsection

@section('modal')
@include('variacoes.opcao')
@endsection

@section('support')
<script type="text/javascript">
   $(document).ready(function (){
       $('#variacao-opcao #formOpcao').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("variacoes.opcao") }}',
            type: 'POST',
            data: $('#variacao-opcao #formOpcao').serialize(),
            beforeSend: function(){
                $('#variacao-opcao #formOpcao').addClass('d-none');
                $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
            },
            success: function(data){
                $('#variacao-opcao #formOpcao').addClass('d-none');
                $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check my-3" style="font-size:62px;"></i></div><label>Opção adicionada com sucesso!</label></div>');
                setTimeout(function(){
                    $('#variacao-opcao #formOpcao').each (function(){
                        this.reset();
                    });
                    $('.id_opcao').html('');
                    $(data).each(function(index, element){
                        $('.id_opcao').append('<option value="'+element.id+'">'+element.nome+'</option>');
                    });
                    $('input').removeClass('border border-danger');
                    $('.carregamento').html('');
                    $('#variacao-opcao #formOpcao').removeClass('d-none');
                    $('#variacao-opcao').modal('hide');
                }, 800);
            }, error: function (data) {
                setTimeout(function(){
                    $('#variacao-opcao #formOpcao').removeClass('d-none');
                    $('.carregamento').html('');
                    if(!data.responseJSON){
                        console.log(data.responseText);
                        $('#variacao-opcao #err').html(data.responseText);
                    }else{
                        $('#variacao-opcao #err').html('');
                        $('input').removeClass('border border-danger');
                        $.each(data.responseJSON.errors, function(key, value){
                            $('#variacao-opcao #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
                            $('input[name="'+key+'"]').addClass('border border-danger');
                        });
                    }
                }, 800);
            }
        });
    });
   });
</script>
@endsection
