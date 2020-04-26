<!-- Carregamento de página -->
<div class="modal" id="modal-processamento" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="background: #00000066;">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="mx-auto">
            <div class="modal-body">
                <div class="row mx-auto">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="position-absolute">
                            <img src="{{ asset('storage/app/system/icon.png').'?'.rand() }}" style="height: 70px;">
                        </div>
                        <div class="spinner-border text-light" role="status" style="width: 5.5rem; height: 5.5rem;">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-white py-3">Carregando...</h6>
            </div>
        </div>
    </div>
</div>
<!-- Carregamento de página -->