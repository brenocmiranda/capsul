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
                    <div class="breadcrumb-item active">Carrinhos abandonados</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('configuracoes.carrinhos.salvar') }}" enctype="multipart/form-data">
                        @csrf

                        @if(Session::has('confirm'))
                            <p class="py-2 alert alert-dismissible alert-{{ Session::get('confirm')['class'] }} fade show" role="alert">
                                {{ Session::get('confirm')['mensagem'] }}
                                <button type="button" class="close text-dark" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </p>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h3 class="section-title my-0">Carrinhos abandonados</h3>  
                            </div>
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="mt-2 mb-5">
                                        <div class="form-group col-12">
                                            <label class="custom-switch px-0">
                                                <input type="checkbox" name="ativo" class="custom-switch-input" {{($carrinhos->ativo == 1 ? ' checked' : '')}}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description"><b>Envio de e-mails</b></span>
                                            </label>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1" name="enviar_cupom" {{($carrinhos->enviar_cupom == 's' ? ' checked' : '')}}>
                                                <label class="custom-control-label" for="customCheck1">Enviar cupom de desconto no primeiro e-mail</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Assunto do e-mail <span class="text-danger">*</span></label>
                                            <textarea class="summernote" name="assunto">{{$carrinhos->assunto}}</textarea>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>SMS</label>
                                            <textarea class="summernote" name="sms">{{$carrinhos->assunto}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        
                        <div class="col-12 mb-5 text-right">
                            <a href="{{ route('configuracoes') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
                            <button class="btn btn-primary btn-lg col-2 mx-1">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection