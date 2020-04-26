<div class="modal fade" id="produtos-marcas" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card mb-0">
                <div class="card-header py-0">
                    <h4 class="titulo_modal titulo_modal">Cadastrar marca</h4>
                    <button type="button" class="ml-auto close" data-dismiss="modal" aria-label="Close"><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>
                    </button>
                </div>
                
                <div class="card-body" style="padding-top: 0px !important">
                    <div id="err"></div>
                    <div class="carregamento"></div>
                    <form id="formMarcas" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="acao" value="modal">
                        <div class="col-12 my-3">
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
                        <div class="form-group col-12 my-3">
                            <label>Nome da marca <i class="text-danger">*</i></label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="d-flex">
                            <div class="form-group col-8 mb-0">
                                <label>Descrição da marca</label>
                                <textarea class="summernote-simple" name="descricao"></textarea>
                            </div>
                            <div class="form-group col-4 mt-2">
                                <div class="col-12 text-center">
                                    <h6 class="col-12 row">Selecione a imagem</h6>
                                    <div class="row">
                                      <div class="col-12">
                                        <div class="border p-3 col-12 rounded text-center">
                                          <img class="w-100" id="PreviewImage" src="{{ asset('public/img/product.png').'?'.rand() }}" style="height: 150px;" >
                                          <input type="file" class="px-0 col-12 position-absolute mx-auto h-100 pointer" style="opacity: 0; top: 0%; left: 0%" accept="image/*" name="id_imagem_marca" id="id_imagem_marca" onchange="image(this);" title="Selecione sua imagem">
                                        </div>
                                        <small class="my-2">Aceitamos .png, .jpg ou .svg</small>
                                      </div>
                                    </div>  
                               </div>
                            </div>
                        </div>

                        <hr>

                        <div class="modal-footer py-1">
                            <div class="col-12 text-right">
                                <button class="btn btn-outline-danger btn-lg col-3 mx-1 shadow-none" data-dismiss="modal" aria-label="Close">Cancelar</button>
                                <button class="btn btn-success btn-lg col-3 mx-1 shadow-none">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

