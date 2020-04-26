@extends('template.index')

@section('title')
Variações
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Variações</h1>
                <small class="px-2">{{$variacoes}} variacoes</small>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('produtos.lista')}}">Produtos</a></div>
                    <div class="breadcrumb-item"><a href="{{route('variacoes.lista')}}">Variações</a></div>
                    <div class="breadcrumb-item active">Ver todos</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if(Auth::user()->RelationGrupo->gerenciar_variacoes == 1)
                        <div class="d-flex ml-auto col-2 mt-4 button-edit"> 
                            <div class="">
                                <a href="{{ route('variacoes.adicionar') }}" class="btn btn-primary shadow-none"><i class="fas fa-plus"></i><b> Nova variação</b></a>
                            </div>
                        </div>
                        @endif
                        <div class="card-body">
                            <div class="table-responsive col-12">
                                <table class="table table-striped text-center w-100" id="table">
                                    <thead>
                                        <tr class="cab">
                                            <th>Nome</th>
                                            <th>Valor</th>
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
            order: [1, 'asc'],
            paging: true,
            select: true,
            searching: true,
            destroy: true,
            ajax: "{{ route('variacoes.data') }}",
            serverSide: true,
            "columns": [ 
            { "data": "variacao", "name":"variacao"},
            { "data": "valor", "name":"valor"},
            ],
        });
    });
</script>
@endsection