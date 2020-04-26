<div class="modal fade" id="produtos-variantes" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card mb-0">
                <div class="card-header py-0">
                    <h4 class="titulo_modal titulo_modal">Nova variação</h4>
                    <button type="button" class="ml-auto close" data-dismiss="modal" aria-label="Close"><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>
                    </button>
                </div>
                
                <div class="card-body" style="padding-top: 0px !important">
                    <div id="err"></div>
                    <div class="carregamento"></div>
                    <form id="formVariantes" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="acao" value="modal">
                        <div class="card-body">
                            <div class="form-group col-12">
                                <label>Nome da variação <i class="text-danger">*</i></label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-8">
                                        <label>Opções</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </div>
                                            <select class="form-control">
                                                <option disabled>Selecione uma opção</option>
                                                @if(isset($opcoes))
                                                    @foreach($opcoes as $opcao)
                                                    <option value="{{$opcao->id}}">{{$opcao->nome}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>    
                                    </div>     
                                </div>                                
                            </div>
                        </div>

                        <hr>
                        
                        <div class="modal-footer">
                            <div class="col-12 text-right">
                                <button class="btn btn-outline-danger btn-lg col-2 mx-1 shadow-none" data-dismiss="modal" aria-label="Close">Cancelar</button>
                                <button class="btn btn-success btn-lg col-2 mx-1 shadow-none">Salvar</button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>

