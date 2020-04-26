@extends('template.index')

@section('title')
Marcas
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Marcas</h1>
                <small class="px-2">{{$marcas}} marcas</small>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('produtos.lista')}}">Produtos</a></div>
                    <div class="breadcrumb-item"><a href="{{route('marcas.lista')}}">Marcas</a></div>
                    <div class="breadcrumb-item active">Ver todos</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if(Auth::user()->RelationGrupo->gerenciar_marcas == 1)
                        <div class="d-flex ml-auto col-2 mt-4 button-edit"> 
                            <div class="">
                                <a href="{{ route('marcas.adicionar') }}" class="btn btn-primary shadow-none"><i class="fas fa-plus"></i><b> Nova marca</b></a>
                            </div>
                        </div>
                        @endif
                        <div class="card-body">
                            <div class="table-responsive col-12">
                                <table class="table table-striped text-center w-100" id="table">
                                    <thead>
                                        <tr class="cab">
                                            <th>Nome</th>
                                            <th>Mostrar na home</th>
                                            <th>Ativo</th>
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
        ajax: "{{ route('marcas.data') }}",
        serverSide: true,
        "columns": [ 
        { "data": "marca", "name":"marca"},
        { "data": "home","name":"home"},
        { "data": "status", "name":"status"},
        ],
    });
   });
</script>
@endsection