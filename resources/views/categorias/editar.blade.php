@extends('template.index')

@section('title')
Editar categoria
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="mx-3">
                <h1>Editar informações</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
                    <div class="breadcrumb-item"><a href="{{route('produtos.lista')}}">Produtos</a></div>
                    <div class="breadcrumb-item"><a href="{{route('categorias.lista')}}">Categorias</a></div>
                    <div class="breadcrumb-item active">Editar</div>
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

                <form method="POST" action="{{ route('categorias.editando', $categoria->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card" id="card-1">
                        <div class="card-header py-0">
                            <h5 class="section-title">Informações básicas</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group col-12">
                                <label class="custom-switch px-0">
                                    <input type="checkbox" name="ativo" class="custom-switch-input" {{( $categoria->ativo == 's' ? ' checked' : '')}}>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description"><b>Ativo</b></span>
                                </label>
                                <label class="custom-switch px-0 ml-5">
                                    <input type="checkbox" name="mostrar_na_home" class="custom-switch-input" {{( $categoria->mostrar_na_home == 's' ? ' checked' : '')}}>
                                    <span class="custom-switch-indicator indicator-blue"></span>
                                    <span class="custom-switch-description"><b>Destacar no menu</b></span>
                                </label>
                            </div>
                            <div class="form-group col-12">
                                <label>Nome da categoria <i class="text-danger">*</i></label>
                                <input type="text" name="nome" class="form-control" value="{{$categoria->nome}}" required>
                            </div>
                            <div class="form-group col-12">
                                <label>Descrição da categoria</label>
                                <textarea class="summernote" name="descricao">{{$categoria->descricao}}</textarea>
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
                                            <select class="form-control h-100" name="sub_categoria">
                                                    <option disabled>Selecione a categoria</option>
                                                    <option value="">Nenhuma</option>
                                                    @foreach($allcategorias as $allcategoria)
                                                        <option value="{{$allcategoria->id}}" {{($categoriapai['id_categoria_pai'] == $allcategoria->id ? ' selected' : '')}}>{{$allcategoria->nome}}</option>
                                                    @endforeach
                                            </select>
                                        </div>    
                                    </div> 
                                    <div class="form-group col-6">
                                        <label>Ordenar produtos por <i class="text-danger">*</i></label>
                                        <div class="input-group">
                                            <select class="form-control h-100" name="ordenar_produtos">
                                                <option value="mais vendidos"{{($categoria->ordenar_produtos == 'mais vendidos' ? ' selected' : '') }}>Mais vendidos</option>
                                                <option value="maior preço"{{($categoria->ordenar_produtos == 'maior preço' ? ' selected' : '') }}>Maior preço</option>
                                                <option value="menor preço"{{($categoria->ordenar_produtos == 'menor preço' ? ' selected' : '') }}>Menor preço</option>
                                                <option value="melhor avaliado"{{($categoria->ordenar_produtos == 'melhor avaliado' ? ' selected' : '') }}>Melhor avaliado</option>
                                                <option value="relevancia"{{($categoria->ordenar_produtos == 'relevancia' ? ' selected' : '') }}>Relevância</option>
                                                <option value="lançamentos"{{($categoria->ordenar_produtos == 'lançamentos' ? ' selected' : '') }}>Lançamentos</option>
                                                <option value="a-z"{{($categoria->ordenar_produtos == 'a-z' ? ' selected' : '') }}>A-Z</option>
                                                <option value="z-a"{{($categoria->ordenar_produtos == 'z-a' ? ' selected' : '') }}>Z-A</option>
                                                <option value="randômico"{{($categoria->ordenar_produtos == 'randômico' ? ' selected' : '') }}>Randômico</option>
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
                                      <div class="col-8">
                                        <div class="border p-3 col-12 rounded text-center">
                                          <img class="w-100" id="PreviewImage" src="{{ ( isset($categoria->RelationImagens2->caminho) ? asset('storage/app').'/'.$categoria->RelationImagens2->caminho.'?'.rand() : asset('public/img/product.png').'?'.rand()) }}" style="height: 200px;" >
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
                                <input type="text" name="titulo_pagina" class="form-control" value="{{$categoria->titulo_pagina}}">
                            </div>
                            <div class="form-group col-7">
                                <label>Link da página</label>
                                <input type="text" name="link_pagina" class="link form-control" value="{{$categoria->link_pagina}}">
                            </div>
                            <div class="form-group col-12">
                                <label>Descrição da página</label>
                                <textarea class="summernote" name="descricao_pagina">{{$categoria->descricao_pagina}}</textarea>
                            </div>
                            <div class="form-group col-7">
                                <label>URL crônica</label>
                                <i data-toggle="tooltip" data-placement="top" title="" data-original-title="Evite conteúdos duplicados! Esta página tem um conteúdo semelhante à outra e tem uma relevância menor? Indique neste campo qual é a URL Principal (Canônica)." class="fa fa-question-circle black-20 ml5" title="" aria-expanded="false"></i>
                                <input type="text" name="url_cronica" class="link form-control" value="{{$categoria->url_cronica}}">
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
