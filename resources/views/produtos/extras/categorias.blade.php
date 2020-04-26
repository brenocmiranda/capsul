<div class="modal fade" id="produtos-categorias" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card mb-0">
                <div class="py-0">
                    <div class="card-header d-block col-12 border-0">
                        <div class="col-12 d-flex py-2">
                            <h4 class="titulo_modal titulo_modal">Nova Categoria</h4>
                            <button type="button" class="ml-auto close" data-dismiss="modal" aria-label="Close"><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>
                            </button>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 pb-0">
                                <ul class="nav nav-tabs row" id="myTab" role="tablist">
                                    <li class="nav-item text-center">
                                        <a class="nav-link active mx-1" id="informacao-tab" data-toggle="tab" href="#informacao" role="tab" aria-controls="informacao" aria-selected="true">Informações</a>
                                    </li>
                                    <li class="nav-item text-center">
                                        <a class="nav-link mx-1" id="banners-tab" data-toggle="tab" href="#banners" role="tab" aria-controls="banners" aria-selected="false">Banners</a>
                                    </li>
                                    <li class="nav-item text-center">
                                        <a class="nav-link mx-1" id="google-tab" data-toggle="tab" href="#google" role="tab" aria-controls="google" aria-selected="false">Google / SEO</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body pt-0">
                <div id="err"></div>
                <div class="carregamento"></div>
                
                    <form id="formCategorias" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="acao" value="modal">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="informacao" role="tabpanel" aria-labelledby="informacao-tab">
                                    <div class="card-body py-1">
                                        <div class="form-group col-12 mb-2">
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
                                        <div class="form-group col-12 mb-2">
                                            <label>Nome da categoria <i class="text-danger">*</i></label>
                                            <input type="text" name="nome" class="form-control" required>
                                        </div>
                                        <div class="form-group col-12 mb-2">
                                            <label>Descrição da categoria</label>
                                            <textarea class="form-control" name="descricao"></textarea>
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

                                <div class="tab-pane fade" id="banners" role="tabpanel" aria-labelledby="banners-tab">
                                    <div class="card-body">
                                        <div class="form-group col-4 mb-0">
                                            <div class="text-center">
                                                <div class="row">
                                                  <div class="col-12">
                                                    <div class="border p-3 rounded text-center">
                                                      <img class="w-100" id="PreviewImage" src="{{ asset('public/img/product.png').'?'.rand() }}" style="height: 120px;" >
                                                      <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept="image/*" name="id_imagem_categoria" id="id_imagem_categoria" onchange="image(this);" title="Selecione sua imagem">
                                                    </div>
                                                    <small class="my-2">Aceitamos .png, .jpg ou .svg</small>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="google-tab">
                                    <div class="card-body py-2">
                                        <div class="form-group col-8 mb-2">
                                            <label>Título da página</label>
                                            <input type="text" name="titulo_pagina" class="form-control">
                                        </div>
                                        <div class="form-group col-10 mb-2">
                                            <label>Link da página</label>
                                            <input type="text" name="link_pagina" class="link_pagina form-control">
                                        </div>
                                        <div class="form-group col-12 mb-2">
                                            <label>Descrição da página</label>
                                            <textarea class="form-control" name="descricao_pagina"></textarea>
                                        </div>
                                        <div class="form-group col-8 mb-2">
                                            <label>URL crônica</label>
                                            <i data-toggle="tooltip" data-placement="top" title="" data-original-title="Evite conteúdos duplicados! Esta página tem um conteúdo semelhante à outra e tem uma relevância menor? Indique neste campo qual é a URL Principal (Canônica)." class="fa fa-question-circle black-20 ml5" title="" aria-expanded="false"></i>
                                            <input type="text" name="url_cronica" class="url_cronica form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <hr>

                        <div class="modal-footer py-1">
                            <div class="col-12 text-right">
                                <button class="btn btn-outline-danger btn-lg col-3 mx-1  shadow-none" data-dismiss="modal" aria-label="Close">Cancelar</button>
                                <button class="btn btn-success btn-lg col-3 mx-1 shadow-none">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
