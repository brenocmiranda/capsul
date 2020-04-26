<div class="modal fade" id="modal-endereco" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card mb-0">
                    <div class="card-header d-block col-12">
                        <div class="col-12 d-flex py-2">
                            <h4 class="titulo_modal titulo_modal">Editar informações</h4>
                            <button type="button" class="ml-auto close" data-dismiss="modal" aria-label="Close"><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div id="err"></div>
                    <div class="carregamento"></div>
                        <form id="formEndereco" enctype="multipart/form-data">
                            @csrf
                            <div class="wizard-pane">
                                <div class="form-group row px-3 mb-2">
                                    <label class="col-md-12 text-left">CEP <span class="text-danger">*</span></label>
                                    <div class="col-lg-5 col-md-5">
                                        <input type="text" name="cep" id="cep" class="form-control" maxlength="8" value="{{$pedido->RelationEndereco['cep']}}"  required>
                                    </div>
                                    <div class="col-lg-5 px-0 my-auto col-md-5">
                                        <label class="country mb-0">{{$pedido->RelationEndereco['cidade']}} - {{$pedido->RelationEndereco['estado']}}</label>
                                        <input id="cidade" type="hidden" name="cidade" value="{{$pedido->RelationEndereco['cidade']}}">
                                        <input id="estado" type="hidden" name="estado" value="{{$pedido->RelationEndereco['estado']}}">
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="col-md-12 text-left">Endereço <span class="text-danger">*</span></label>
                                    <div class="col-lg-10 col-md-10">
                                        <input type="text" name="endereco" id="endereco" class="form-control" value="{{$pedido->RelationEndereco['rua']}}" onkeyup="this.value = this.value.toUpperCase();" required>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <div class="row">
                                        <div class="form-group col-6 mb-0">
                                            <label class="col-md-12 text-left mt-2">Bairro <span class="text-danger">*</span></label>
                                            <div class="col-lg-12 col-md-12">
                                                <input type="text" class="form-control" name="bairro" id="bairro" value="{{$pedido->RelationEndereco['bairro']}}"  onkeyup="this.value = this.value.toUpperCase();" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-6 mb-0">
                                            <label class="col-md-12 text-left mt-2">Número <span class="text-danger">*</span></label>
                                            <div class="col-lg-8 col-md-8">
                                                <input type="number" class="form-control" name="numero" id="numero" value="{{$pedido->RelationEndereco['numero']}}"  required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="col-md-12 text-left mt-2">Complemento</label>
                                    <div class="col-lg-11 col-md-11">
                                        <input type="text" class="form-control" name="complemento" id="complemento" value="{{$pedido->RelationEndereco['complemento']}}"  placeholder="Ex. CASA, APT. 01, ANX
                                        2 " onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <label class="col-md-12 text-left mt-2">Destinatário <span class="text-danger">*</span></label>
                                    <div class="col-lg-10 col-md-10">
                                        <input type="text" class="form-control" name="destinatario" id="destinatario" value="{{$pedido->RelationEndereco['destinatario']}}"  onkeyup="this.value = this.value.toUpperCase();" required>
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