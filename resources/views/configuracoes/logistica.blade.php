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
                    <div class="breadcrumb-item active">Logística</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header py-0">
                            <h3 class="section-title">Logística</h3>
                            <div class="ml-auto">
                                <button type="button" class="btn btn-sm btn-primary mx-1" id="adicionar" data-toggle="modal" data-target="#modal-adicionar"><i class="fa fa-plus" aria-hidden="true"></i> Novo</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12 table-responsive">
                                <label>Gerencie seus centros de distribuição, estoques, embalagens e opções de fretes.</label>
                                <table class="table table-striped text-center w-100" id="table">
                                    <thead class="">
                                        <tr class="cab">
                                            <th>Nome</th>
                                            <th>Status</th>
                                            <th>CEP Inicial</th>
                                            <th>CEP Final</th>
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
                        <h5 class="mb-auto">Novo frete </h5>
                    </div>
                    <div>
                        <label class="col">Preencha os campos abaixo para adicionar uma nova condição para frete.</label>
                    </div>
                </div>
                <div id="err"></div>
                <div class="carregamento"></div>
                <form id="formAdicionar" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body pb-0">
                        <div class="form-group col-12">
                            <label class="custom-switch px-0">
                                <input type="checkbox" name="ativo" class="ativo custom-switch-input" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description"><b>Ativo</b></span>
                            </label>
                        </div> 
                        <div class="form-group col-8">
                            <label>Nome <span class="text-danger">*</span></label>
                            <input type="text" class="nome1 form-control" name="nome" required>  
                        </div>
                        <div class="row col">
                            <div class="form-group col-5">
                                <label>CEP Inicial <span class="text-danger">*</span></label>
                                <input type="text" class="cep_inicial form-control" name="cep_inicial" minlength="9" required>
                            </div>
                            <div class="form-group col-5">
                                <label>CEP Final <span class="text-danger">*</span></label>
                                <input type="text" class="cep_final form-control" name="cep_final" minlength="9" required>
                            </div>
                        </div>
                        <div class="row col">
                            <div class="form-group col-4">
                                <label>Porcentagem adicional</label>
                                <div class="input-group">
                                    <input type="text" class="porcentagem form-control" name="porcentagem" maxlength="3">
                                    <div class="input-group-append">
                                        <div class="input-group-text py-0">
                                            <b>%</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label>Valor</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text py-0">
                                            <b>R$</b>
                                        </div>
                                    </div>
                                    <input type="text" class="currency form-control" name="valor">
                                </div>   
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label>Prazo de entrega</label>
                            <div class="d-flex">
                                <input type="number" class="prazo_entrega form-control" name="prazo_entrega">
                                <label class="my-auto mx-2">dias</label>
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
                        <label class="col">Estão listadas abaixo as informações do item que deseja modificar.</label>
                    </div>
                </div>
                <div id="err"></div>
                <div class="carregamento"></div>
                <form id="formEditar" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body pb-0">
                        <div class="form-group col-12">
                            <label class="custom-switch px-0">
                                <input type="checkbox" name="ativo" class="ativo custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description"><b>Ativo</b></span>
                            </label>
                        </div> 
                        <div class="form-group col-8">
                            <label>Nome</label>
                            <input type="text" class="nome1 form-control" name="nome" required>
                        </div>
                        <div class="row col">
                            <div class="form-group col-5">
                                <label>CEP Inicial</label>
                                <input type="text" class="cep_inicial form-control" name="cep_inicial" minlength="9" required>
                            </div>
                            <div class="form-group col-5">
                                <label>CEP Final</label>
                                <input type="text" class="cep_final form-control" name="cep_final" minlength="9" required>
                            </div>
                        </div>
                        <div class="row col">
                            <div class="form-group col-4">
                                <label>Porcentagem adicional</label>
                                <div class="input-group">
                                    <input type="text" class="porcentagem form-control" name="porcentagem" maxlength="3">
                                    <div class="input-group-append">
                                        <div class="input-group-text py-0">
                                            <b>%</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label>Valor</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text py-0">
                                            <b>R$</b>
                                        </div>
                                    </div>
                                    <input type="text" class="currency form-control" name="valor">
                                </div>   
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label>Prazo de entrega</label>
                            <div class="d-flex">
                                <input type="number" class="prazo_entrega form-control" name="prazo_entrega">
                                <label class="my-auto mx-2">dias</label>
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
        $('.cep_inicial').mask('00000-000');
        $('.cep_final').mask('00000-000');
        $('.currency').mask('000.000.000.000.000,00', {reverse: true});

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
            ajax: "{{ route('configuracoes.logistica.lista') }}",
            serverSide: true,
            "columns": [ 
            { "data": "nome","name":"nome"},
            { "data": "status","name":"status"},
            { "data": "cep_inicial","name":"cep_inicial"},
            { "data": "cep_final", "name":"cep_final"},
            { "data": "acoes", "name":"acoes"},
            ],
        });

        $('.header-cab').remove();

        $('#table tbody').on('click', 'a#editar', function(){
            var table = $('#table').DataTable();
            table.$('tr.selected').removeClass('selected');
            $(this).parents('tr').addClass('selected');
            $(this).parent('tr').addClass('selected');
            var data = table.row('tr.selected').data();
            if(data.ativo == 1){
                $('.ativo').attr('checked', 'checked');
            }else{
                $('.ativo').removeAttr('checked');
            }
            $('.nome1').val(data.nome);
            $('.cep_inicial').val(data.cep_inicial);
            $('.cep_final').val(data.cep_final);
            $('.porcetagem_adicional').val(data.porcetagem_adicional);
            $('.currency').val(parseFloat(data.valor).toFixed(2).replace('.',','));
            $('.prazo_entrega').val(data.prazo_entrega);
            $('#modal-editar').modal('show');
        });

         // Removendo Itens
        $('#table tbody').on('click', 'a#excluir', function(e){
            var table = $('#table').DataTable();
            table.$('tr.selected').removeClass('selected');
            $(this).parents('tr').addClass('selected');
            $(this).parent('tr').addClass('selected');
            var data = table.row('tr.selected').data();
            e.preventDefault();
            if(confirm('Tem certeza que deseja remover essa configuração?')){
                $.ajax({
                    url: 'logistica/remover/'+data.id,
                    type: 'GET',
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
                url: '{{ route("configuracoes.logistica.adicionar") }}',
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
                url: 'logistica/editar/'+data.id,
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