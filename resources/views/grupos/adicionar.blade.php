@extends('template.index')

@section('title')
Adicionar grupo
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Novo grupo</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('clientes.lista')}}">Clientes</a></div>
                    <div class="breadcrumb-item"><a href="{{route('grupos.lista')}}">Grupos</a></div>
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

            <form method="POST" action="{{ route('grupos.salvar') }}" enctype="multipart/form-data">
                @csrf

                <div class="card" id="card-1">
                    <div class="card-header">
                        <h5 class="section-title my-0">Informações básicas</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-12 my-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="custom-switch px-0">
                                        <input type="checkbox" name="ativo" class="custom-switch-input" checked>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"><b>Ativo</b></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-8">
                            <label>Nome do grupo <i class="text-danger">*</i></label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="form-group col-10">
                            <label>Tipo de cliente <i class="text-danger">*</i></label>
                            <div class="d-flex mb-4 mx-auto">
                                <div class="col-3 border rounded-lg mx-1 text-center bg-white border-primary" id="variante1" style="cursor: pointer">
                                    <div class="my-3">
                                        <label class="colorinput mx-2 d-flex">
                                            <input type="radio" name="tipo" value="pf" class="colorinput-input" checked>
                                            <span class="colorinput-color bg-light border rounded-circle"></span>
                                            <label class="font-weight-bold px-3 mb-0">Pessoa Física</label>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3 border rounded-lg mx-1 text-center bg-white" id="variante2" style="cursor: pointer">
                                    <div class="my-3">
                                        <label class="colorinput mx-2 d-flex">
                                            <input type="radio" name="tipo" value="pj" class="colorinput-input">
                                            <span class="colorinput-color bg-light border rounded-circle"></span>
                                            <label class="font-weight-bold px-3 mb-0">Pessoa jurídica</label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" id="card-2">
                    <div class="card-header">
                        <h5 class="section-title my-0">Pedido mínimo <i class="fa fa-question-circle f16 black-20 ml10 px-2" data-toggle="tooltip" data-placement="top" title="O cliente só realizará um pedido se a soma dos produtos for igual o maior a este valor." aria-expanded="false"></i>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group input-group col-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text py-0">
                                    R$
                                </div>
                            </div>
                            <input type="text" class="form-control currency h-100" name="pedido_minimo">
                        </div>
                    </div>
                </div>

                <div class="card" id="card-3">
                    <div class="card-header">
                        <h5 class="section-title my-0">Alteração de preço</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="from-group col-12">
                                <label>Operação</label>
                                <div class="d-flex mb-4 mx-auto">
                                    <div class="col-2 border rounded-lg mx-1 text-center bg-white border-primary" id="variante3" style="cursor: pointer">
                                        <div class="my-3">
                                            <label class="colorinput mx-2 d-flex">
                                                <input type="radio" name="operacao" value="adicionar" class="colorinput-input" checked>
                                                <span class="colorinput-color bg-light border rounded-circle"></span>
                                                <label class="font-weight-bold px-3 mb-0">Adicionar</label>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-2 border rounded-lg mx-1 text-center bg-white" id="variante4" style="cursor: pointer">
                                        <div class="my-3">
                                            <label class="colorinput mx-2 d-flex">
                                                <input type="radio" name="operacao" value="subtrair" class="colorinput-input">
                                                <span class="colorinput-color bg-light border rounded-circle"></span>
                                                <label class="font-weight-bold px-3 mb-0">Subtrair</label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="from-group col-2">
                                <label>Porcentagem</label>
                                <div class="input-group">
                                    <input type="text" class="form-control  h-100" name="porcentagem">
                                    <div class="input-group-append">
                                        <div class="input-group-text py-0">%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" id="card-4">
                    <div class="card-header">
                        <h5 class="section-title my-0">Inserir automaticamente novos clientes</h5>
                        <label class="custom-switch px-5">
                            <input type="checkbox" name="inserrir_novos_clientes" class="custom-switch-input" checked>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"><b>Ativo</b></span>
                        </label>
                    </div>
                </div>

                <hr>

                <div class="col-12 mb-5 text-right">
                    <a href="{{ route('grupos.lista') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
                    <button class="btn btn-primary btn-lg col-2 mx-1">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>
</div>
@endsection

@section('support')
<script type="text/javascript">
    $(document).ready(function (){
        $('.currency').mask('000.000.000.000.000,00', {reverse: true});    

            // Tipo de pessoas
            $('#variante1').on('click', function(){
                $('#variante2').removeClass('border-primary');
                $('#variante2 input').removeAttr('checked');
                $(this).addClass('border-primary');
                $('#variante1 input').attr('checked', 'checked');
            });
            $('#variante2').on('click', function(){
                $('#variante1').removeClass('border-primary');
                $('#variante1 input').removeAttr('checked');
                $(this).addClass('border-primary');
                $('#variante2 input').attr('checked', 'checked');
            });

            // Tipo de operação
            $('#variante3').on('click', function(){
                $('#variante4').removeClass('border-primary');
                $('#variante4 input').removeAttr('checked');
                $(this).addClass('border-primary');
                $('#variante3 input').attr('checked', 'checked');
            });
            $('#variante4').on('click', function(){
                $('#variante3').removeClass('border-primary');
                $('#variante3 input').removeAttr('checked');
                $(this).addClass('border-primary');
                $('#variante4 input').attr('checked', 'checked');
            });
        });
    </script>
    @endsection
