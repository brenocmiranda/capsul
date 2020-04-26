@extends('template.index')

@section('title')
Leads
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Leads</h1>
                <small class="px-2">{{$leads}} leads</small>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('clientes.lista')}}">Clientes</a></div>
                    <div class="breadcrumb-item"><a href="{{route('leads.lista')}}">Leads</a></div>
                    <div class="breadcrumb-item active">Ver todos</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if(Auth::user()->RelationGrupo->gerenciar_clientes == 1)
                        <div class="d-flex ml-auto col-2 mt-4 button-edit"> 
                            <div class="">
                                <a href="{{route('leads.adicionar')}}" class="btn btn-primary shadow-none"><i class="fas fa-plus"></i><b> Nova lead</b></a>
                            </div>
                        </div>
                        @endif
                        <div class="card-body">
                            <div class="table-responsive col-12">
                                <table class="table table-striped text-center w-100" id="table">
                                    <thead>
                                        <tr class="cab">
                                            <th>E-mail</th>
                                            <th>Nome</th>
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

@section('support')
<script type="text/javascript">
    $(document).ready(function (){ 
        $('#table').DataTable({
            deferRender: true,
            order: [0, 'asc'],
            paging: true,
            select: true,
            searching: true,
            destroy: true,
            ajax: "{{ route('leads.data') }}",
            serverSide: true,
            "columns": [ 
            { "data": "nome1","name":"nome1"},
            { "data": "email", "name":"email"},
            ],
        });

        $('#table tbody').on('click', 'tr.leads', function () {
            var table = $('#table').DataTable();
            
            if (!($(this).hasClass('selected'))) {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                var data = table.row('tr.selected').data();
                $('.nome').val(data.nome);
                $('.email').val(data.email);
                $('#modal-editar').modal('show');

            }
        });

        // Adicionando lead
        $('#modal-adicionar #formAdicionar').on('submit', function(e){
            var table = $('#table').DataTable();
            e.preventDefault();
            $.ajax({
                url: '{{ route("leads.adicionar") }}',
                type: 'POST',
                data: $('#modal-adicionar #formAdicionar').serialize(),
                beforeSend: function(){
                    $('#modal-adicionar #formAdicionar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
                },
                success: function(data){
                    $('#modal-adicionar #formAdicionar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check my-3" style="font-size:62px;"></i></div><h6>Informação inserida com sucesso!</h6></div>');

                    setTimeout(function(){
                        $('#modal-adicionar #formAdicionar').each (function(){
                            this.reset();
                        });
                        table.row.add(data).draw(false);
                        $('input').removeClass('border border-danger');
                        $('.carregamento').html('');
                        $('#modal-adicionar #formAdicionar').removeClass('d-none');
                        $('#modal-adicionar').modal('hide');
                    }, 800);
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
                    }, 800);
                }
            });
        });

        // Editando os leads
        $('#modal-editar #formEditar').on('submit', function(e){
            var table = $('#table').DataTable();
            var data = table.row('tr.selected').data();
            e.preventDefault();
            $.ajax({
                url: 'clientes/leads/editar/'+data.id,
                type: 'POST',
                data: $('#modal-editar #formEditar').serialize(),
                beforeSend: function(){
                    $('#modal-editar #formEditar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
                },
                success: function(data){
                    $('#modal-editar #formEditar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check my-3" style="font-size:62px;"></i></div><h6>Informações alteradas com sucesso!</h6></div>');                 
                    setTimeout(function(){
                        $('#produtos-variantes #formVariantes').each (function(){
                            this.reset();
                        });
                        table.row('tr.selected').remove().draw(false);
                        table.row.add(data).draw(false);
                        $('input').removeClass('border border-danger');
                        $('.carregamento').html('');
                        $('#modal-editar #formEditar').removeClass('d-none');
                        $('#modal-editar').modal('hide');
                    }, 800);
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
                    }, 800);
                }
            });
        });
});
</script>
@endsection