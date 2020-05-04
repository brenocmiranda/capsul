@extends('template.index')

@section('title')
Adicionar lead
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Novo lead</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('clientes.lista')}}">Clientes</a></div>
                    <div class="breadcrumb-item"><a href="{{route('leads.lista')}}">Leads</a></div>
                    <div class="breadcrumb-item active">Adicionar</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('leads.salvar') }}" enctype="multipart/form-data">
                @csrf
                <div class="card" id="card-1">
                    <div class="card-header">
                        <h5 class="section-title my-0">Informações básicas</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group col-8">
                            <label>Nome <i class="text-danger">*</i></label>
                            <input type="text" name="nome" class="form-control" onkeyup="this.value = this.value.toUpperCase();" required>
                        </div>
                        <div class="form-group col-7">
                            <label>E-mail <i class="text-danger">*</i></label>
                            <input type="email" name="email" class="form-control" placeholder="contato@grupocapsul.com" required>
                        </div>
                    </div>
                </div>

                <hr>
                
                <div class="col-12 mb-5 text-right">
                    <a href="{{ route('leads.lista') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
                    <button class="btn btn-primary btn-lg col-2 mx-1">Salvar</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
