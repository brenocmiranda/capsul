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
                    <div class="breadcrumb-item active">Segurança</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="section-title my-0">Segurança</h3>
                            <div class="ml-auto">
                                <button type="button" class="btn btn-sm btn-primary mx-1" id="adicionar" data-toggle="modal" data-target="#modal-adicionar"><i class="fa fa-plus" aria-hidden="true"></i> Novo</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12 table-responsive">
                                <label>Bloqueie o acesso de clientes na sua loja.</label>
                                <table class="table table-striped text-center w-100" id="table">
                                    <thead class="">
                                        <tr class="cab">
                                            <th>Nome</th>
                                            <th>IP Bloqueado</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
<div class="modal fade" id="modal-adicionar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="card mb-0">
            <div class="card-header row pb-0">
                <div class="row col-12 mx-auto">
                    <h5 class="mb-auto">Novo IP bloqueado </h5>
                </div>
                <div>
                    <label class="col">Preencha os campos abaixo para bloquear um novo IP.</label>
                </div>
            </div>
            <div id="err"></div>
            <div class="carregamento"></div>
            <form id="formAdicionar" enctype="multipart/form-data">
                @csrf
                <div class="card-body pb-0">
                    <div class="form-group col-8">
                        <label>Nome <span class="text-danger">*</span></label>
                        <input type="text" class="nome1 form-control" name="nome" required>
                    </div>
                    <div class="form-group col-4">
                        <label>IP Bloqueado<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="ip_bloqueado form-control" name="ip_bloqueado" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg col-2 btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-lg col-2 btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="card mb-0">
          <div class="card-header row pb-0">
            <div class="row col-12 mx-auto">
                <h5 class="mb-auto">Editar informações </h5>
            </div>
            <div>
                <label class="col">Preencha os campos abaixo para bloquear um novo IP.</label>
            </div>
        </div>
        <div id="err"></div>
        <div class="carregamento"></div>
        <form id="formEditar" enctype="multipart/form-data">
            @csrf
            <div class="card-body pb-0">
                <div class="form-group col-8">
                    <label>Nome <span class="text-danger">*</span></label>
                    <input type="text" class="nome1 form-control" name="nome" required>
                </div>
                <div class="form-group col-4">
                    <label>IP Bloqueado<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="ip_bloqueado form-control" name="ip_bloqueado" required>
                    </div>
                </div>
            </div>
            <hr>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg col-2 btn-danger" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-lg col-2 btn-success">Salvar</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection

@section('support')
<script type="text/javascript">
    $(document).ready(function (){
        $('.ip_bloqueado').mask('099.099.099.099');
        
        // Limpando as informações para adicionar
        $('#adicionar').on('click', function(){
            $('#modal-adicionar #formAdicionar').each (function(){
                this.reset();
                if ($(this).hasClass('border border-danger')){
                    this.removeClass('border border-danger');
                }
            });
            $('#modal-adicionar #err').html('');
        });

        $('#table').DataTable({
            deferRender: true,
            order: [0, 'asc'],
            paging: true,
            select: true,
            searching: true,
            destroy: true,
            ajax: "{{ route('configuracoes.seguranca.lista') }}",
            serverSide: true,
            "columns": [ 
            { "data": "nome","name":"nome"},
            { "data": "ip_bloqueado","name":"ip_bloqueado"},
            { "data": "acoes", "name":"acoes"},
            ],
        });


        $('.header-cab').remove();


        $('#table tbody').on('click', 'tr', function () {
            var table = $('#table').DataTable();
            if (!($(this).hasClass('selected'))) {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#excluir').removeAttr('disabled');
            }
        });

        $('#table tbody').on('click', 'a#editar', function(){
            var table = $('#table').DataTable();
            table.$('tr.selected').removeClass('selected');
            $(this).parents('tr').addClass('selected');
            $(this).parent('tr').addClass('selected');
            var data = table.row('tr.selected').data();
            $('.nome1').val(data.nome);
            $('.ip_bloqueado').val(data.ip_bloqueado);
            $('#modal-editar').modal('show');
        });

        $('#table tbody').on('click', 'a#excluir', function(e){
            var table = $('#table').DataTable();
            table.$('tr.selected').removeClass('selected');
            $(this).parents('tr').addClass('selected');
            $(this).parent('tr').addClass('selected');
            var data = table.row('tr.selected').data();
            e.preventDefault();
            if(confirm('Tem certeza que deseja remover essa configuração?')){
                $.ajax({
                    url: 'seguranca/remover/'+data.id,
                    type: 'GET',
                    data: data,
                    success: function(data){
                        table.row('tr.selected').remove().draw(false);
                        $('#alerta').html('<p class="py-2 alert alert-success"> Informação foi removida com sucesso! <button type="button" class="close text-dark" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></p>');
                        table.$('tr.selected').removeClass('selected');
                    }, error: function (data) {
                        $('#alerta').html('<p class="py-2 alert alert-danger"> Não foi possível remover, caso o erro persista, contate o suporte! </p>');
                    },
                });
            }
        });
 
        // Adicionando novos itens
        $('#modal-adicionar #formAdicionar').on('submit', function(e){
            var table = $('#table').DataTable();
            var data = table.row('tr.selected').data();
            e.preventDefault();
            $.ajax({
                url: '{{ route("configuracoes.seguranca.adicionar") }}',
                type: 'POST',
                data: $('#modal-adicionar #formAdicionar').serialize(),
                beforeSend: function(){
                    $('#modal-adicionar #formAdicionar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
                    $('#modal-adicionar #err').html('');
                },
                success: function(data){
                    $('#modal-adicionar #formAdicionar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check" style="font-size:50px;"></i></div><h6 class="my-3">Informações salvas com sucesso!</h6></div>');
                    setTimeout(function(){
                        $('#modal-adicionar #formAdicionar').each (function(){
                            this.reset();
                        });
                        table.row.add(data).draw(false);
                        $('input').removeClass('border border-danger');
                        $('.carregamento').html('');
                        $('#modal-adicionar #formAdicionar').removeClass('d-none');
                        $('#modal-adicionar').modal('hide');
                    }, 2000);
                }, error: function (data) {
                    setTimeout(function(){
                        $('#modal-adicionar #formAdicionar').removeClass('d-none');
                        $('.carregamento').html('');
                        if(!data.responseJSON){
                            console.log(data.responseText);
                            $('#modal-adicionar #err').html(data.responseText);
                        }else{
                            $('#modal-adicionar #err').html('');
                            $('input').removeClass('border border-danger');
                            $.each(data.responseJSON.errors, function(key, value){
                                $('#modal-adicionar #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
                                $('input[name="'+key+'"]').addClass('border border-danger');
                            });
                        }
                    }, 2000);
                }
            });
        });

        // Editando itens
        $('#modal-editar #formEditar').on('submit', function(e){
            var table = $('#table').DataTable();
            var data = table.row('tr.selected').data();
            e.preventDefault();
            $.ajax({
                url: 'seguranca/editar/'+data.id,
                type: 'POST',
                data: $('#modal-editar #formEditar').serialize(),
                beforeSend: function(){
                    $('#modal-editar #formEditar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
                    $('#modal-editar #err').html('');
                },
                success: function(data){
                    $('#modal-editar #formEditar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check" style="font-size:50px;"></i></div><h6 class="my-3">Informações alteradas com sucesso!</h6></div>');
                    setTimeout(function(){
                        $('#modal-editar #formEditar').each (function(){
                            this.reset();
                        });
                        table.row('tr.selected').remove().draw(false);
                        table.row.add(data).draw(false);
                        $('input').removeClass('border border-danger');
                        $('.carregamento').html('');
                        $('#modal-editar #formEditar').removeClass('d-none');
                        $('#modal-editar').modal('hide');
                    }, 2000);
                }, error: function (data) {
                    setTimeout(function(){
                        $('#modal-editar #formEditar').removeClass('d-none');
                        $('.carregamento').html('');
                        if(!data.responseJSON){
                            console.log(data.responseText);
                            $('#modal-editar #err').html(data.responseText);
                        }else{
                            $('#modal-editar #err').html('');
                            $('input').removeClass('border border-danger');
                            $.each(data.responseJSON.errors, function(key, value){
                                $('#modal-editar #err').append('<div class="text-danger ml-3"><p>'+value+'</p></div>');
                                $('input[name="'+key+'"]').addClass('border border-danger');
                            });
                        }
                    }, 2000);
                }
            });
        });

    
});
</script>
@endsection