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
                    <div class="breadcrumb-item active">Integrações</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="section-title my-0">Integrações</h3>  
                        </div>
                        <div class="card-body">
                            <label>Nenhuma integração realizada, módulo em desenvolvimento.</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
