@extends('template.index')

@section('title')
Adicionar marca
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Nova marca</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('produtos.lista')}}">Produtos</a></div>
                    <div class="breadcrumb-item"><a href="{{route('marcas.lista')}}">Marcas</a></div>
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

            <form method="POST" action="{{ route('marcas.salvar') }}" enctype="multipart/form-data">
                @csrf
                <div class="card" id="card-1">
                    <div class="card-header py-0">
                        <h5 class="section-title">Informações básicas</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group col-12">
                            <label class="custom-switch px-0">
                                <input type="checkbox" name="ativo" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description"><b>Ativo</b></span>
                            </label>
                            <label class="custom-switch px-0" style="margin-left: 30px;">
                                <input type="checkbox" name="mostrar_na_home" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator indicator-blue"></span>
                                <span class="custom-switch-description"><b>Não mostrar na Home</b></span>
                            </label>
                        </div>
                        <div class="form-group col-10">
                            <label>Nome da marca <i class="text-danger">*</i></label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <label>Descrição da marca</label>
                            <textarea class="summernote" name="descricao"></textarea>
                        </div>
                        <div class="form-group col-4">
                            <div class="text-left">
                                <div class="col-12 mb-3 px-0">
                                    <h6 class="mb-0">Selecione a imagem <i class="text-danger">*</i></h6>
                                    <small>Aceitamos .png, .jpg ou .svg</small>
                                </div>
                                <div class="row">
                                  <div class="col-10">
                                    <div class="border p-3 col-12 rounded text-center">
                                      <img class="w-100" id="PreviewImage" src="{{ asset('public/img/product.png').'?'.rand() }}" style="height: 240px;" >
                                      <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept="image/*" name="id_imagem_marca" id="id_imagem_marca" onchange="image(this);" title="Selecione sua imagem">
                                  </div>
                              </div>
                          </div>  
                      </div>
                  </div>
              </div>
          </div>

          <hr>
          
          <div class="col-12 mb-5 text-right">
            <a href="{{ route('marcas.lista') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
            <button class="btn btn-primary btn-lg col-2 mx-1">Salvar</button>
        </div>
    </div>
</form>
</div>
</section>
</div>
@endsection
