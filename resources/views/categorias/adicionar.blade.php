@extends('template.index')

@section('title')
Adicionar categoria
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Nova categoria</h1>
                
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('produtos.lista')}}">Produtos</a></div>
                    <div class="breadcrumb-item"><a href="{{route('categorias.lista')}}">Categorias</a></div>
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

            <form method="POST" action="{{ route('categorias.salvar') }}" enctype="multipart/form-data">
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
                            <label class="custom-switch px-0 ml-5">
                                <input type="checkbox" name="mostrar_na_home" class="custom-switch-input" checked>
                                <span class="custom-switch-indicator indicator-blue"></span>
                                <span class="custom-switch-description"><b>Destacar no menu</b></span>
                            </label>
                        </div>
                        <div class="form-group col-12">
                            <label>Nome da categoria <i class="text-danger">*</i></label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <label>Descrição da categoria</label>
                            <textarea class="summernote" name="descricao"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Sub-categoria</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </div>
                                        <select class="sub_categoria form-control h-100" name="sub_categoria">
                                            <option disabled="disabled">Selecione a categoria</option>
                                            <option value="">Nenhuma</option>
                                            @foreach($categorias as $categoria)
                                            <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>    
                                </div> 
                                <div class="form-group col-6">
                                    <label>Ordenar produtos por <i class="text-danger">*</i></label>
                                    <div class="input-group">
                                        <select class="form-control h-100" name="ordenar_produtos">
                                            <option value="mais vendidos">Mais vendidos</option>
                                            <option value="maior preço">Maior preço</option>
                                            <option value="menor preço">Menor preço</option>
                                            <option value="melhor avaliado">Melhor avaliado</option>
                                            <option value="relevancia">Relevância</option>
                                            <option value="lançamentos">Lançamentos</option>
                                            <option value="a-z">A-Z</option>
                                            <option value="z-a">Z-A</option>
                                            <option value="randômico">Randômico</option>
                                        </select>
                                    </div>     
                                </div>     
                            </div>                                
                        </div>
                    </div>
                </div>

                <div class="card" id="card-2">
                    <div class="card-header py-0">
                        <h5 class="section-title">Banners</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group col-4">
                            <div class="text-left">
                                <div class="col-12 mb-3 px-0">
                                    <h6 class="mb-0">Selecione a imagem <i class="text-danger">*</i></h6>
                                    <small>Aceitamos .png, .jpg ou .svg</small>
                                </div>
                                
                                <div class="row">
                                  <div class="col-9">
                                    <div class="border p-3 rounded text-center">
                                      <img class="w-100" id="PreviewImage" src="{{ asset('public/img/product.png').'?'.rand() }}?<?php echo rand();?>" style="height: 200px;" >
                                      <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept="image/*" name="id_imagem_categoria" id="id_imagem_categoria" onchange="image(this);" title="Selecione sua imagem">
                                  </div>
                                  
                              </div>
                          </div>  
                      </div>
                  </div>
              </div>
          </div>

          <div class="card" id="card-3">
            <div class="card-header py-0">
                <h5 class="section-title">Google / SEO</h5>
            </div>
            <div class="card-body">
                <div class="form-group col-8">
                    <label>Título da página</label>
                    <input type="text" name="titulo_pagina" class="form-control">
                </div>
                <div class="form-group col-7">
                    <label>Link da página</label>
                    <input type="text" name="link_pagina" class="link form-control">
                </div>
                <div class="form-group col-12">
                    <label>Descrição da página</label>
                    <textarea class="summernote" name="descricao_pagina"></textarea>
                </div>
                <div class="form-group col-7">
                    <label>URL crônica</label>
                    <i data-toggle="tooltip" data-placement="top" title="" data-original-title="Evite conteúdos duplicados! Esta página tem um conteúdo semelhante à outra e tem uma relevância menor? Indique neste campo qual é a URL Principal (Canônica)." class="fa fa-question-circle black-20 ml5" title="" aria-expanded="false"></i>
                    <input type="text" name="url_cronica" class="link form-control">
                </div>
            </div>
        </div>

        <hr>

        <div class="col-12 mb-5 text-right">
            <a href="{{ route('categorias.lista') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
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
      $('.link').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {'translation': {
        A: {pattern: /[a-z0-9]/},
    }});
  });
</script>
@endsection
