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
            table.$('tr.selected').removeClass('selected');
            $(this).parents('tr').addClass('selected');
            $(this).parent('tr').addClass('selected');
            var data = table.row('tr.selected').data();
            var cliente = JSON.parse(data.relation_cliente);
            var produto = JSON.parse(data.relation_produto);
            $('#nome-produto').html('<a href="../produtos/editar/'+data.id_produto+'">'+produto.nome+'</a>');
            $('.prod_resume').attr('src', '../storage/app/'+produto.relation_imagens_principal[0].caminho);
            $('#cod_sku').html(produto.cod_sku);
            $('#precoVenda').html(produto.preco_venda.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
            $('#codigo').html('#'+data.codigo);
            $('#linkCarrinho').attr('href', '../checkout/continuar/'+data.codigo);
            $('#valorSubtotal').html(Number(data.valor_compra).toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
            $('#valorTotal').html(Number(data.valor_compra).toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
            $('#quantidade').html(data.quantidade);
            $('#atualizacao').html(data.updated_at)
            
            if(data.id_cliente != null){
                $('#cliente').html(cliente.nome);
                $('#cliente').attr('href', '../clientes/editar/'+cliente.id);
                $('#email').html(cliente.email);
                $('#phone').attr('href', "https://api.whatsapp.com/send?phone="+data.telefone)
                $('#phone').html("("+data.telefone.replace('+55', '').substr(0,2)+") "+data.telefone.replace('+55', '').substr(2,5)+"-"+data.telefone.replace('+55', '').substr(7,10));
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