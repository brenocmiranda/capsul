@extends('template.index')

@section('title')
Carrinhos Abandonados
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Carrinhos Abandonados</h1>
                <small class="px-2">{{$carrinhos}} carrinhos</small>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('carrinhos.lista')}}">Carrinhos</a></div>
                    <div class="breadcrumb-item active">Ver todos</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive col-12">
                                <table class="table table-striped text-center w-100" id="table">
                                    <thead>
                                        <tr class="cab">
                                            <th>Produto</th>
                                            <th>Cliente</th>
                                            <th>Valor da compra</th>
                                            <th>Atualizado em</th>
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
    @include('carrinhos.detalhes')
@endsection

@section('support')
<script type="text/javascript">
    $(document).ready(function (){ 
        $('#table').DataTable({
            deferRender: true,
            order: [3, 'desc'],
            paging: true,
            select: true,
            searching: true,
            destroy: true,
            ajax: "{{ route('carrinhos.data') }}",
            serverSide: true,
            "columns": [ 
            { "data": "produto","name":"produto"},
            { "data": "cliente", "name":"cliente"},
            { "data": "valor", "name":"valor"},
            { "data": "data","name":"data"},
            ],
        });

        $('#table tbody').on('click', 'a#detalhes', function () {
            var table = $('#table').DataTable();
            var data = table.row('tr').data();

            $('#nome-produto').html('<a href="../produtos/editar/'+data.relation_produto.id+'">'+data.relation_produto.nome+'</a>');
            $('.prod_resume').attr('src', '../storage/app/'+data.relation_produto.relation_imagens_principal[0].caminho);
            $('#cod_sku').html(data.relation_produto.cod_sku);
            $('#preco_venda').html(data.relation_produto.preco_venda.toFixed(2).replace('.',','));
            $('#codigo').html('#'+data.codigo);
            $('#valor-total').html(data.valor_compra.toFixed(2).replace('.',','));
            $('#valor-subtotal').html(data.valor_compra.toFixed(2).replace('.',','));
            if(data.id_cliente != null){
                $('#cliente').html(data.relation_cliente.nome);
                $('#email').html(data.relation_cliente.email);
                $('#phone').html(data.telefone);
            }else{
                $('#cliente').html('<b>--</b>');
                $('#email').html('<b>--</b>');
                $('#phone').html('<b>--</b>');
            }
            
            $('#modal-detalhes').modal('show');
        });
        
    });
</script>
@endsection