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
            <div class="breadcrumb-item active">Status de pedidos</div>
        </div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
            <div class="card">
              <div class="card-header py-0">
                <h3 class="section-title">Status dos pedidos</h3>  
              </div>
              <div class="card-body">
                    <div class="col-12 table-responsive">
                      <label>Gerencie os estados que os pedidos podem atingir na plataforma.</label>
                      <table class="table table-striped text-center w-100" id="table">
                        <thead>
                          <tr class="cab">
                            <th>Nome</th>
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
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="card mb-0">
        <div class="card-header pb-0">
          <h4 class="titulo_modal titulo_modal">Editar informações</h4>
          <button type="button" class="ml-auto mb-auto close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="err"></div>
        <div class="carregamento"></div>
        <form id="formStatus" enctype="multipart/form-data">
          @csrf
          <div class="card-body pb-0">
            <div class="form-group col-12 mb-2">
              <label class="custom-switch px-0">
                <input type="checkbox" name="enviar" class="enviar custom-switch-input">
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description"><b>Enviar</b></span>
              </label>
            </div> 
            <div class="form-group col-10">
              <label>Nome</label>
              <div class="input-group">
                <input type="text" class="nome1 form-control" name="nome">
              </div>  
            </div>
            <div class="form-group col-12">
              <label>Descrição</label>
              <textarea class="descricao" name="descricao"></textarea>
            </div>
          </div>
          <hr class="mb-0">
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
    $('#table').DataTable({
        deferRender: true,
        order: [0, 'asc'],
        paging: true,
        select: true,
        searching: true,
        destroy: true,
        ajax: "{{ route('configuracoes.status.lista') }}",
        serverSide: true,
        "columns": [ 
        { "data": "nome1","name":"nome1"},
        { "data": "status","name":"status"},
        { "data": "acoes","name":"acoes"},
        ],
    });

    $('.header-cab').remove();
    
    $('#table tbody').on('click', 'a#editar', function(){
      var table = $('#table').DataTable();
      table.$('tr.selected').removeClass('selected');
      $(this).parents('tr').addClass('selected');
      $(this).parent('tr').addClass('selected');
      var data = table.row('tr.selected').data();

      if(data.enviar == 1){
        $('.modal .enviar').attr('checked', 'checked');
      }else{
        $('.modal .enviar').removeAttr('checked');
      }
      $('.modal .nome1').val(data.nome);
      $('.modal .descricao').html(data.descricao);
      $('.modal .descricao').summernote({height: 30});
      $('#modal-editar').modal('show');
    });
      
    // Salvado dados
    $('#formStatus').on('submit', function(e){
      var table = $('#table').DataTable();
      var data = table.row('tr.selected').data();
      e.preventDefault();
      $.ajax({
        url: 'status/salvar/'+data.id,
        type: 'POST',
        data: $('#modal-editar #formStatus').serialize(),
        beforeSend: function(){
          $('#modal-editar #formStatus').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="spinner-border my-3" role="status"><span class="sr-only"> Loading... </span></div><label class="col-12">Salvando informações...</label></div>');
        },
        success: function(data){
          $('#modal-editar #formStatus').addClass('d-none');
          $('.carregamento').html('<div class="mx-auto text-center my-5"><div class="col-sm-12 col-md-12 col-lg-12"><i class="col-sm-2 fa fa-check my-3" style="font-size:62px;"></i></div><h6 class="my-3">Informações alteradas com sucesso!</h6></div>');
          setTimeout(function(){
            $('#modal-editar #formEditar').each (function(){
              this.reset();
            });
            table.row('tr.selected').remove().draw(false);
            table.row.add(data).draw(false);
            $('input').removeClass('border border-danger');
            $('.carregamento').html('');
            $('#modal-editar #formStatus').removeClass('d-none');
            $('#modal-editar').modal('hide');
          }, 1000);
        }, error: function (data) {
          setTimeout(function(){
            $('#modal-editar #formStatus').removeClass('d-none');
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