<div class="modal fade" id="variacao-opcao" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="card mb-0">
                <div class="card-header" style="padding-bottom: 0px !important">
                    <h4 class="titulo_modal titulo_modal">Nova opção</h4>
                </div>
                <div id="err"></div>
                <div class="carregamento"></div>
                <div class="card-body">
                    <form method="POST" id="formOpcao" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">
                            <div class="row mx-auto">
                                <div class="col-8 pl-0">
                                    <div class="form-group col-12">
                                        <label>Nome <span class="text-danger">*</span></label>
                                        <input type="text" name="nome" class="form-control">
                                    </div>       
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer py-2">
                            <button type="button" class="btn btn-lg col-3 shadow-none btn-outline-danger" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-lg col-3 shadow-none btn-outline-success">Criar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
