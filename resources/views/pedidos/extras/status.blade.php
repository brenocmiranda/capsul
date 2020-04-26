<div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card mb-0">
                    <div class="card-header d-block col-12">
                        <div class="col-12 d-flex py-2">
                            <h4 class="titulo_modal titulo_modal">Alterar status</h4>
                            <button type="button" class="ml-auto close" data-dismiss="modal" aria-label="Close"><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div id="err"></div>
                    <div class="carregamento"></div>
                        <form id="formStatus" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-6">
                                <label>Status <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <select class="form-control h-100" name="id_status" required>
                                        <option disabled="disabled">Selecione</option>
                                        @foreach($status as $status)
                                        <option value="{{$status->id}}" {{($pedido->RelationStatus->last()['id'] == $status->id ? ' selected' : '')}}>{{$status->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>     
                            </div>
                            <div class="form-group col-12 form-group">
                                <label>Observações</label>
                                <textarea class="form-control" name="observacoes">Criado por {{Auth::user()->nome}}</textarea>
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