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
                <div class="breadcrumb-item active">Usuários</div>
            </div>
          </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                      <div class="card-header py-0">
                        <h3 class="section-title">Usuários</h3>  
                        <div class="ml-auto">
                          <button type="button" class="btn btn-sm btn-primary mx-1" id="adicionar" data-toggle="modal" data-target="#modal-adicionar"><i class="fa fa-plus" aria-hidden="true"></i> Novo usuário</button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="col-12 table-responsive">
                          <label>Gerencie os usuários que poderão acessar a sua loja.</label>
                          <table class="table table-striped text-center w-100" id="table">
                              <thead class="text-center">
                                  <tr class="cab">
                                      <th>Nome</th>
                                      <th>E-mail</th>
                                      <th>Status</th>
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
                    <h5 class="mb-auto">Novo usuário</h5>
                </div>
                <div>
                    <label class="col">Preencha os campos abaixo para adicionar um novo usuário.</label>
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
                    <div class="input-group">
                        <input type="text" class="nome1 form-control" name="nome" required>
                    </div>  
                </div>
                <div class="form-group col-10">
                    <label>E-mail <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="email" class="email form-control" name="email" required>
                    </div>
                </div>
                <div class="form-group col-6">
                    <label>Grupo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select class="id_grupo form-control" name="id_grupo" required>
                            <option disabled>Selecione seu grupo</option>
                            @foreach($grupos as $grupo)
                              <option value="{{$grupo->id}}">{{$grupo->nome}}</option>
                            @endforeach
                        </select>
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
                <h5 class="mb-auto">Editar informações</h5>
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
                      <input type="checkbox" name="ativo" class="ativo custom-switch-input" checked>
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description"><b>Ativo</b></span>
                  </label>
              </div> 
              <div class="form-group col-8">
                <label>Nome <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="nome1 form-control" name="nome" required>
                </div>  
            </div>
            <div class="form-group col-10">
                <label>E-mail <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="email" class="email form-control" name="email" required>
                </div>
            </div>
            <div class="form-group col-6">
                <label>Grupo <span class="text-danger">*</span></label>
                <div class="input-group">
                    <select class="id_grupo form-control" name="id_grupo" required>
                        <option disabled>Selecione seu grupo</option>
                        @foreach($grupos as $grupo)
                          <option value="{{$grupo->id}}">{{$grupo->nome}}</option>
                        @endforeach
                    </select>
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
<!-- Modal de usuários -->
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
        ajax: "{{ route('configuracoes.usuarios.lista') }}",
        serverSide: true,
        "columns": [ 
        { "data": "nome","name":"nome"},
        { "data": "email","name":"email"},
        { "data": "status","name":"status"},
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
          $('.email').val(data.email);
          $('.id_grupo').val(data.id_grupo);
          $('#modal-editar-2').modal('show');
      });

      $('#table tbody').on('click', 'a#excluir', function(e){
          var table = $('#table').DataTable();
          table.$('tr.selected').removeClass('selected');
          $(this).parents('tr').addClass('selected');
          $(this).parent('tr').addClass('selected');
          var data = table.row('tr.selected').data();
    
          if(confirm('Tem certeza que deseja remover esse usuário?')){
            e.preventDefault();
            $.ajax({
                url: 'usuarios/remover/'+data.id,
                type: 'GET',
                success: function(data){
                    table.row('tr.selected').remove().draw(false);
                    $('#alerta').html('<p class="py-2 alert alert-success"> Usuário removido com sucesso! </p>');
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
                url: '{{ route("configuracoes.usuarios.adicionar") }}',
                type: 'POST',
                data: $('#modal-adicionar #formAdicionar').serialize(),
                beforeSend: function(){
                    $('#modal-adicionar #formAdicionar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
                    $('#modal-adicionar-2 #err').html('');
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
                url: 'usuarios/editar/'+data.id,
                type: 'POST',
                data: $('#modal-editar #formEditar').serialize(),
                beforeSend: function(){
                    $('#modal-editar #formEditar').addClass('d-none');
                    $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><p>Salvando informações...</p></div>');
                    $('#modal-editar-2 #err').html('');
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