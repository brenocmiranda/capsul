@extends('template.index')

@section('title')
Pedidos
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Pedidos</h1>
                <small class="px-2">{{$pedidos}} pedidos</small>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('pedidos.lista')}}">Pedidos</a></div>
                    <div class="breadcrumb-item active">Ver todos</div>
                </div>
            </div>
        </div>
        
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="">
                        <div class="buttons d-flex">
                            <button class="mx-auto border btn text-primary btn-light shadow-none btn-filter" value="5"><span>PEDIDO AUTORIZADO</span></button>
                            <button class="mx-auto border btn text-warning btn-light shadow-none btn-filter" value="2"><span>AGUARDAN. PAGAMENTO</span></button>
                            <button class="mx-auto border btn text-success btn-light shadow-none btn-filter" value="3"><span>PAGAMENTO APROVADO</span></button>
                            <button class="mx-auto border btn text-danger btn-light shadow-none btn-filter" value="4"><span>PAGAM. NÃO APROVADO</span></button>
                            <button class="mx-auto border btn text-dark btn-light shadow-none btn-filter" value="6"><span>EM SEPARAÇÃO</span></button>
                            <button class="mx-auto border btn text-primary btn-light shadow-none btn-filter" value="7"><span>FATURADO</span></button>
                            <button class="mx-auto border btn text-info btn-light shadow-none btn-filter" value="8"><span>EM TRANSPORTE</span></button>
                            <button class="mx-auto border btn text-success btn-light shadow-none btn-filter" value="9"><span>ENTREGUE</span></button>
                            <button class="mx-auto border btn text-danger btn-light shadow-none btn-filter" value="10"><span>CANCELADO</span></button>
                        </div>
                        <hr>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive col-12">
                                <table class="table table-striped text-center w-100" id="table">
                                    <thead>
                                        <tr class="cab">
                                            <th>Transação</th>
                                            <th>Número do pedido</th>
                                            <th>Data</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
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
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px !important">
                        <h4 class="titulo_modal titulo_modal">Filtrar</h4>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="card-body" style="padding-top: 0px !important">
                        <div class="">Agrupar por:</div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="agrupar_cliente">
                                <label class="custom-control-label" for="agrupar_cliente">Cliente</label>
                            </div>
                        </div>

                        <div class="">Campanhas:</div>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="campanha_1">
                                    <label class="custom-control-label" for="campanha_1">Carrinho abandonado 1</label>
                                </div>
                                <div class="custom-control custom-checkbox" style="margin-left: 30px">
                                    <input type="checkbox" class="custom-control-input" id="campanha_2">
                                    <label class="custom-control-label" for="campanha_2">Carrinho abandonado 2</label>
                                </div>
                                <div class="custom-control custom-checkbox" style="margin-left: 30px">
                                    <input type="checkbox" class="custom-control-input" id="campanha_3">
                                    <label class="custom-control-label" for="campanha_3">Carrinho abandonado 3</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6" style="margin-left: -15px !important;">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                            </div>
                                            <select id="atualizacao" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Data de atualização</b></option>
                                                <option value="hoje">Hoje</option>
                                                <option value="ontem">Ontem</option>
                                                <option value="mes_atual">Mês atual</option>
                                                <option value="mes_passado">Mês passado</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                            </div>
                                            <select id="cancelamento" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Data de cancelamento</b></option>
                                                <option value="hoje">Hoje</option>
                                                <option value="ontem">Ontem</option>
                                                <option value="mes_atual">Mês atual</option>
                                                <option value="mes_passado">Mês passado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <div class="form-group">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6" style="margin-left: -15px !important;">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                            </div>
                                            <select id="criacao" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Data de criação</b></option>
                                                <option value="hoje">Hoje</option>
                                                <option value="ontem">Ontem</option>
                                                <option value="mes_atual">Mês atual</option>
                                                <option value="mes_passado">Mês passado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                            </div>
                                            <select id="pagamento" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Data de pagamento</b></option>
                                                <option value="hoje">Hoje</option>
                                                <option value="ontem">Ontem</option>
                                                <option value="mes_atual">Mês atual</option>
                                                <option value="mes_passado">Mês passado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6" style="margin-left: -15px !important;">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                            </div>
                                            <select id="previsao" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Data de previsão de entrega</b></option>
                                                <option value="hoje">Hoje</option>
                                                <option value="ontem">Ontem</option>
                                                <option value="mes_atual">Mês atual</option>
                                                <option value="mes_passado">Mês passado</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-4">
                                        <!-- <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                            </div>
                                            <select class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Data de criação</b></option>
                                                <option value="hoje">Hoje</option>
                                                <option value="ontem">Ontem</option>
                                                <option value="mes_atual">Mês atual</option>
                                                <option value="mes_passado">Mês passado</option>
                                            </select>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="form-group">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6" style="margin-left: -15px !important;">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-truck"></i></div>
                                            </div>
                                            <select id="formaEntrega" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Forma de entrega</b></option>
                                                <option value="hoje">Hoje</option>
                                                <option value="ontem">Ontem</option>
                                                <option value="mes_atual">Mês atual</option>
                                                <option value="mes_passado">Mês passado</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
                                            </div>
                                            <select id="formaPagamento" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Formas de pagamento</b></option>
                                                @foreach($formaPagamentos as $forma)
                                                <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <div class="form-group">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6" style="margin-left: -15px !important;">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-bullhorn"></i></div>
                                            </div>
                                            <select id="origens" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Origens</b></option>
                                                <option value="hoje">Hoje</option>
                                                <option value="ontem">Ontem</option>
                                                <option value="mes_atual">Mês atual</option>
                                                <option value="mes_passado">Mês passado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-tag"></i></div>
                                            </div>
                                            <select id="produtos" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Produtos</b></option>
                                                <option value="hoje">Hoje</option>
                                                <option value="ontem">Ontem</option>
                                                <option value="mes_atual">Mês atual</option>
                                                <option value="mes_passado">Mês passado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6" style="margin-left: -15px !important;">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-th-list"></i></div>
                                            </div>
                                            <select id="status" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Status</b></option>
                                                @foreach($status as $stat)
                                                <option value="{{ $stat->id }}">{{ $stat->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-users"></i></div>
                                            </div>
                                            <select id="usuarios" class="form-control form-control-sm">
                                                <option selected hidden disabled value=""><b>Usuários</b></option>
                                                <option value="hoje">Hoje</option>
                                                <option value="ontem">Ontem</option>
                                                <option value="mes_atual">Mês atual</option>
                                                <option value="mes_passado">Mês passado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Aplicar filtros</button>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('support')
    <script type="text/javascript">
        function filtrar(){
            let data = {}
            let atualizacao = $("#atualizacao").val()
            let cancelamento = $("#cancelamento").val()
            let criacao = $("#criacao").val()
            let pagamento = $("#pagamento").val()
            let previsao = $("#previsao").val()
            let formaEntrega = $("#formaEntrega").val()
            let formaPagamento = $("#formaPagamento").val()
            let origens = $("#origens").val()
            let produtos = $("#produtos").val()
            let status = $("#status").val()
            let usuarios = $("#usuarios").val()
            if(atualizacao && atualizacao != '')
                data['atualizacao'] = atualizacao
            if(cancelamento && cancelamento != '')
                data['cancelamento'] = cancelamento
            if(criacao && criacao != '')
                data['criacao'] = criacao
            if(pagamento && pagamento != '')
                data['pagamento'] = pagamento
            if(previsao && previsao != '')
                data['previsao'] = previsao
            if(formaEntrega && formaEntrega != '')
                data['formaEntrega'] = formaEntrega
            if(formaPagamento && formaPagamento != '')
                data['formaPagamento'] = formaPagamento
            if(origens && origens != '')
                data['origens'] = origens
            if(produtos && produtos != '')
                data['produtos'] = produtos
            if(status && status != '')
                data['status'] = status
            if(usuarios && usuarios != '')
                data['usuarios'] = usuarios
            $('#table').DataTable({
                deferRender: true,
                order: [2, 'desc'],
                paging: true,
                select: true,
                searching: true,
                destroy: true,
                ajax: "{{ route('pedidos.data') }}",
                serverSide: true,
                "columns": [ 
                { "data": "transacao","name":"transacao"},
                { "data": "cliente", "name":"cliente"},
                { "data": "data","name":"data"},
                { "data": "valor", "name":"valor"},
                { "data": "status","name":"status"},
                { "data": "acoes", "name":"acoes"},
                ],
            });
        }
        
        $(document).ready(function (){ 
            $('#table').DataTable({
                sPaginationType: "simple_numbers",
                deferRender: true,
                order: true,
                paging: true,
                destroy: true,
                select: true,
                searching: true,
                destroy: true,
                ajax: "{{ route('pedidos.data') }}",
                serverSide: true,
                "columns": [ 
                { "data": "transacao","name":"transacao"},
                { "data": "cliente", "name":"cliente"},
                { "data": "data","name":"data"},
                { "data": "valor", "name":"valor"},
                { "data": "status","name":"status"},
                { "data": "acoes", "name":"acoes"},
                ],
            });

            $('.btn-filter').on('click', function(){
                $('#table').dataTable({
                    destroy: true,
                    ajax: {
                        "url": "{{ route('pedidos.data') }}",
                        "data": {
                            "status1": this.value,
                        }
                    },
                    "columns": [ 
                    { "data": "transacao","name":"transacao"},
                    { "data": "cliente", "name":"cliente"},
                    { "data": "data","name":"data"},
                    { "data": "valor", "name":"valor"},
                    { "data": "status","name":"status"},
                    { "data": "acoes", "name":"acoes"},
                    ],
                });
            });

        });
    </script>
    @endsection