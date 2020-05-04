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
            <div class="breadcrumb-item active">Grupos de usuários</div>
        </div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="section-title my-0">Grupos de usuários</h3>  
              <div class="ml-auto">
                <button type="button" class="btn btn-sm btn-primary mx-1" id="adicionar" data-toggle="modal" data-target="#modal-adicionar"><i class="fa fa-plus" aria-hidden="true"></i> Novo grupo</button>
              </div>
            </div>
            <div class="card-body">
              <div class="col-12 table-responsive">
                <label>Gerencie os grupos e as permissões que cada usuário terá na plataforma.</label>
                <table class="table table-striped text-center w-100" id="table">
                  <thead class="text-center">
                    <tr class="cab">
                      <th>Nome</th>
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
<!-- Modal de grupos -->
<div class="modal fade" id="modal-adicionar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="card mb-0">
        <div class="card-header row pb-0">
          <div class="row col-12 mx-auto">
            <h5 class="mb-auto">Novo grupo</h5>
          </div>
          <div>
            <label class="col">Crie grupos de trabalho e gerencie as permissões de acesso de cada grupo.</label>
          </div>
        </div>
        <div id="err"></div>
        <div class="carregamento"></div>
        <form id="formAdicionar" enctype="multipart/form-data">
          @csrf
          <div class="card-body pb-0">
            <div class="col-12">
              <div class="form-group col-8 mb-4">
                <label>Nome <span class="text-danger">*</span></label>
                <div class="input-group"> 
                  <input type="text" class="form-control" name="nome" required>
                </div>
              </div>
              <div class="form-group col-12">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input permissao_total" id="customCheck" name="permissao_total">
                  <label class="custom-control-label" for="customCheck">Este grupo terá permissão total</label>
                </div>
              </div>
            </div>
            <div class="permissoes">
              <h6 class="mx-3">Permissões</h6>
              <hr class="mt-0 mx-3">
              <div class="row col-12">
                <div class="col-2 my-2">
                  <label class="border-bottom">Dashboard</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck1" name="visualizar_dashboard">
                      <label class="custom-control-label" for="customCheck12">Visualizar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Produtos</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck2" name="visualizar_produtos">
                      <label class="custom-control-label" for="customCheck2">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck3" name="gerenciar_produtos">
                      <label class="custom-control-label" for="customCheck3">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Marcas</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck4" name="visualizar_marcas">
                      <label class="custom-control-label" for="customCheck4">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck5" name="gerenciar_marcas">
                      <label class="custom-control-label" for="customCheck5">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Categorias</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck6" name="visualizar_categorias">
                      <label class="custom-control-label" for="customCheck6">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck7" name="gerenciar_categorias">
                      <label class="custom-control-label" for="customCheck7">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Variações</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck8" name="visualizar_variacoes">
                      <label class="custom-control-label" for="customCheck8">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck9" name="gerenciar_variacoes">
                      <label class="custom-control-label" for="customCheck9">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Clientes</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck10" name="visualizar_clientes">
                      <label class="custom-control-label" for="customCheck10">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck11" name="gerenciar_clientes">
                      <label class="custom-control-label" for="customCheck11">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Pedidos</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck12" name="visualizar_pedidos">
                      <label class="custom-control-label" for="customCheck12">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck13" name="gerenciar_pedidos">
                      <label class="custom-control-label" for="customCheck13">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Leads</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck14" name="visualizar_leads">
                      <label class="custom-control-label" for="customCheck14">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck15" name="gerenciar_leads">
                      <label class="custom-control-label" for="customCheck15">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom"><small>Config. Checkout</small></label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck16" name="visualizar_checkout">
                      <label class="custom-control-label" for="customCheck16">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck17" name="gerenciar_checkout">
                      <label class="custom-control-label" for="customCheck17">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom"><small>Config. Usuários</small></label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck18" name="visualizar_usuarios">
                      <label class="custom-control-label" for="customCheck18">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck19" name="gerenciar_usuarios">
                      <label class="custom-control-label" for="customCheck19">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom"><small>Config. Logística</small></label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck20" name="visualizar_logistica">
                      <label class="custom-control-label" for="customCheck20">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck21" name="gerenciar_logistica">
                      <label class="custom-control-label" for="customCheck21">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom"><small>Config. Geral</small></label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck22" name="visualizar_geral">
                      <label class="custom-control-label" for="customCheck22">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck23" name="gerenciar_geral">
                      <label class="custom-control-label" for="customCheck23">Gerenciar</label>
                    </div>
                  </div>
                </div>

                </div>
              </div>
            </div> 

            <hr>

            <div class="modal-footer">
              <button type="button" class="btn btn-lg col-2 btn-danger" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-lg col-2 btn-success">Salvar</button>
            </div>
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
            <div class="col-12">
              <div class="form-group col-8 mb-4">
                <label>Nome <span class="text-danger">*</span></label>
                <div class="input-group"> 
                  <input type="text" class="nome1 form-control" name="nome" required>
                </div>
              </div>
              <div class="form-group col-12">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input permissao_total" id="customCheck47" name="permissao_total">
                  <label class="custom-control-label" for="customCheck47">Este grupo terá permissão total</label>
                </div>
              </div>
            </div>
            <div class="permissoes">
              <h6 class="mx-3">Permissões</h6>
              <hr class="mt-0 mx-3">
              <div class="row col-12">
                <div class="col-2 my-2">
                  <label class="border-bottom">Dashboard</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_dashboard" id="customCheck24" name="visualizar_dashboard">
                      <label class="custom-control-label" for="customCheck24">Visualizar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Produtos</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_produtos" id="customCheck25" name="visualizar_produtos">
                      <label class="custom-control-label" for="customCheck25">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_produtos" id="customCheck26" name="gerenciar_produtos">
                      <label class="custom-control-label" for="customCheck26">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Marcas</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_marcas" id="customCheck27" name="visualizar_marcas">
                      <label class="custom-control-label" for="customCheck27">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_marcas" id="customCheck28" name="gerenciar_marcas">
                      <label class="custom-control-label" for="customCheck28">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Categorias</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_categorias" id="customCheck29" name="visualizar_categorias">
                      <label class="custom-control-label" for="customCheck29">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_categorias" id="customCheck30" name="gerenciar_categorias">
                      <label class="custom-control-label" for="customCheck30">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Variações</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_variacoes" id="customCheck31" name="visualizar_variacoes">
                      <label class="custom-control-label" for="customCheck31">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_variacoes" id="customCheck32" name="gerenciar_variacoes">
                      <label class="custom-control-label" for="customCheck32">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Clientes</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_clientes" id="customCheck33" name="visualizar_clientes">
                      <label class="custom-control-label" for="customCheck33">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_clientes" id="customCheck34" name="gerenciar_clientes">
                      <label class="custom-control-label" for="customCheck34">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Pedidos</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_pedidos" id="customCheck35" name="visualizar_pedidos">
                      <label class="custom-control-label" for="customCheck35">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_pedidos" id="customCheck36" name="gerenciar_pedidos">
                      <label class="custom-control-label" for="customCheck36">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom">Leads</label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_leads" id="customCheck37" name="visualizar_leads">
                      <label class="custom-control-label" for="customCheck37">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_leads" id="customCheck38" name="gerenciar_leads">
                      <label class="custom-control-label" for="customCheck38">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom"><small>Config. Checkout</small></label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_checkout" id="customCheck39" name="visualizar_checkout">
                      <label class="custom-control-label" for="customCheck39">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_checkout" id="customCheck40" name="gerenciar_checkout">
                      <label class="custom-control-label" for="customCheck40">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom"><small>Config. Usuários</small></label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_usuarios" id="customCheck41" name="visualizar_usuarios">
                      <label class="custom-control-label" for="customCheck41">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_usuarios" id="customCheck42" name="gerenciar_usuarios">
                      <label class="custom-control-label" for="customCheck42">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom"><small>Config. Logística</small></label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_logistica" id="customCheck43" name="visualizar_logistica">
                      <label class="custom-control-label" for="customCheck43">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_logistica" id="customCheck44" name="gerenciar_logistica">
                      <label class="custom-control-label" for="customCheck44">Gerenciar</label>
                    </div>
                  </div>
                </div>

                <div class="col-2 my-2">
                  <label class="border-bottom"><small>Config. Geral</small></label>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input visualizar_geral" id="customCheck45" name="visualizar_geral">
                      <label class="custom-control-label" for="customCheck45">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-12 p-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input gerenciar_geral" id="customCheck46" name="gerenciar_geral">
                      <label class="custom-control-label" for="customCheck46">Gerenciar</label>
                    </div>
                  </div>
                </div>

              </div>
            </div>          
            <hr>
            <div class="modal-footer">
              <button type="button" class="btn btn-lg col-2 btn-danger" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-lg col-2 btn-success">Salvar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal de grupos -->
@endsection

@section('support')
<script type="text/javascript">
  $(document).ready(function (){
    // Selecionando todos checkbox
    $('.permissao_total').on('click', function(){
      if ($(this).prop('checked')){
        $('.permissoes').addClass('d-none');
        for (var i = 1; i < 47; i++){      
          $('#customCheck'+i).attr('checked', 'checked');
        }
      }else{
        $('.permissoes').removeClass('d-none');
        for (var i = 1; i < 47; i++){      
          $('#customCheck'+i).removeAttr('checked');
        }
      }
    });

    $('#table').DataTable({
        deferRender: true,
        order: [0, 'asc'],
        paging: true,
        select: true,
        searching: true,
        destroy: true,
        ajax: "{{ route('configuracoes.grupos.lista') }}",
        serverSide: true,
        "columns": [ 
        { "data": "nome","name":"nome"},
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

        $('.permissao_total').removeAttr('checked');
        $('.nome1').val(data.nome);

        if(data.visualizar_produtos == 1 && data.visualizar_marcas == 1 && data.visualizar_categorias == 1 && data.visualizar_variacoes == 1 && data.visualizar_clientes == 1 && data.visualizar_pedidos == 1 && data.visualizar_leads == 1 && data.visualizar_checkout == 1 && data.visualizar_usuarios == 1 && data.visualizar_logistica == 1 && data.visualizar_geral == 1 && data.visualizar_dashboard == 1 && data.gerenciar_produtos == 1 && data.gerenciar_marcas == 1 && data.gerenciar_categorias == 1 && data.gerenciar_variacoes == 1 && data.gerenciar_clientes == 1 && data.gerenciar_pedidos == 1 && data.gerenciar_leads == 1 && data.gerenciar_checkout == 1 && data.gerenciar_usuarios == 1 && data.gerenciar_logistica == 1 && data.gerenciar_geral == 1){
          $('.permissao_total').attr('checked', 'true');
          $('.permissoes').addClass('d-none');
          for (var i = 24; i < 48; i++){      
            $('#customCheck'+i).attr('checked', 'true');
          }
        }else{
          $('.permissoes').removeClass('d-none');
          if(data.visualizar_dashboard){
            $('#customCheck24').attr('checked', 'true');
          }else{
            $('#customCheck24').removeAttr('checked');
          }

          if(data.visualizar_produtos){
            $('#customCheck25').attr('checked', 'true');
          }else{
            $('#customCheck25').removeAttr('checked');
          }
          if(data.gerenciar_produtos){
            $('#customCheck26').attr('checked', 'true');
          }else{
            $('#customCheck26').removeAttr('checked');
          }

          if(data.visualizar_marcas){
            $('#customCheck27').attr('checked', 'true');
          }else{
            $('#customCheck27').removeAttr('checked');
          }
          if(data.gerenciar_marcas){
            $('#customCheck28').attr('checked', 'true');
          }else{
            $('#customCheck28').removeAttr('checked');
          }

          if(data.visualizar_categorias){
            $('#customCheck29').attr('checked', 'true');
          }else{
            $('#customCheck29').removeAttr('checked');
          }
          if(data.gerenciar_categorias){
            $('#customCheck30').attr('checked', 'true');
          }else{
            $('#customCheck30').removeAttr('checked');
          }

          if(data.visualizar_variacoes){
            $('#customCheck31').attr('checked', 'true');
          }else{
            $('#customCheck31').removeAttr('checked');
          }
          if(data.gerenciar_variacoes){
            $('#customCheck32').attr('checked', 'true');
          }else{
            $('#customCheck32').removeAttr('checked');
          }

          if(data.visualizar_clientes){
            $('#customCheck33').attr('checked', 'true');
          }else{
            $('#customCheck33').removeAttr('checked');
          }
          if(data.gerenciar_clientes){
            $('#customCheck34').attr('checked', 'true');
          }else{
            $('#customCheck34').removeAttr('checked');
          }

          if(data.visualizar_pedidos){
            $('#customCheck35').attr('checked', 'true');
          }else{
            $('#customCheck35').removeAttr('checked');
          }
          if(data.gerenciar_pedidos){
            $('#customCheck36').attr('checked', 'true');
          }else{
            $('#customCheck36').removeAttr('checked');
          }

          if(data.visualizar_leads){
            $('#customCheck37').attr('checked', 'true');
          }else{
            $('#customCheck37').removeAttr('checked');
          }
          if(data.gerenciar_leads){
            $('#customCheck38').attr('checked', 'true');
          }else{
            $('#customCheck38').removeAttr('checked');
          }

          if(data.visualizar_checkout){
            $('#customCheck39').attr('checked', 'true');
          }else{
            $('#customCheck39').removeAttr('checked');
          }
          if(data.gerenciar_checkout){
            $('#customCheck40').attr('checked', 'true');
          }else{
            $('#customCheck40').removeAttr('checked');
          }

          if(data.visualizar_usuarios){
            $('#customCheck41').attr('checked', 'true');
          }else{
            $('#customCheck41').removeAttr('checked');
          }
          if(data.gerenciar_usuarios){
            $('#customCheck42').attr('checked', 'true');
          }else{
            $('#customCheck42').removeAttr('checked');
          }

          if(data.visualizar_logistica){
            $('#customCheck43').attr('checked', 'true');
          }else{
            $('#customCheck43').removeAttr('checked');
          }
          if(data.gerenciar_logistica){
            $('#customCheck44').attr('checked', 'true');
          }else{
            $('#customCheck44').removeAttr('checked');
          }

          if(data.visualizar_geral){
            $('#customCheck45').attr('checked', 'true');
          }else{
            $('#customCheck45').removeAttr('checked');
          }
          if(data.gerenciar_geral){
            $('#customCheck46').attr('checked', 'true');
          }else{
            $('#customCheck46').removeAttr('checked');
          }
        }
        $('#modal-editar').modal('show');
      });


      $('#table tbody').on('click', 'a#excluir', function(){
        var table = $('#table').DataTable();
        table.$('tr.selected').removeClass('selected');
        $(this).parents('tr').addClass('selected');
        $(this).parent('tr').addClass('selected');
        var data = table.row('tr.selected').data();

        e.preventDefault();
        if(confirm('Tem certeza que deseja remover essa configuração?')){
          $.ajax({
            url: 'grupos/remover/'+data.id,
            type: 'GET',
            success: function(data){
              table.row('tr.selected').remove().draw(false);
              $('#alerta').html('<p class="py-2 alert alert-success"> Informação foi removida com sucesso! </p>');
              table.$('tr.selected').removeClass('selected');
            }, error: function (data) {
              console.log(data);
              $('#alerta').html('<p class="py-2 alert alert-danger"> Não foi possível remover, caso o erro persista, contate o suporte! </p>');
            },
          });
        }
      });

      // Adicionando novos
      $('#modal-adicionar #formAdicionar').on('submit', function(e){
        var table = $('#table').DataTable();
        var data = table.row('tr.selected').data();
        e.preventDefault();
        $.ajax({
          url: '{{ route("configuracoes.grupos.adicionar") }}',
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

      // Editando grupos
      $('#modal-editar #formEditar').on('submit', function(e){
        var table = $('#table').DataTable();
        var data = table.row('tr.selected').data();
        e.preventDefault();
        $.ajax({
          url: 'grupos/editar/'+data.id,
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