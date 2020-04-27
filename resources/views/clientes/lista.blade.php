@extends('template.index')

@section('title')
Clientes
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Clientes</h1>
                <small class="px-2">{{$clientes}} clientes</small>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('clientes.lista')}}">Clientes</a></div>
                    <div class="breadcrumb-item active">Ver todos</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if(Auth::user()->RelationGrupo->gerenciar_clientes == 1)
                        <div class="position-absolute row col-12 mt-4 px-5 button-edit"> 
                            <div class="ml-auto">
                                <a href="{{ route('clientes.adicionar') }}" class="btn btn-primary shadow-none"><i class="fas fa-plus"></i><b> Novo cliente</b></a>
                            </div>
                        </div>
                        @endif
                        <div class="card-body">
                            <div class="table-responsive col-12">
                                <table class="table table-striped text-center w-100" id="table">
                                    <thead>
                                        <tr class="cab">
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>Cadastro</th>
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
            order: [0, 'desc'],
            paging: true,
            select: true,
            searching: true,
            destroy: true,
            ajax: "{{ route('clientes.data') }}",
            serverSide: true,
            "columns": [ 
            { "data": "cliente", "name":"cliente"},
            { "data": "email","name":"email"},
            { "data": "data","name":"data"},
            ],
        });
    });
</script>
@endsection