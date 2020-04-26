<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card mb-0">
                <div class="card-header row pb-0">
                    <div class="row col-12 my-4">
                        <h3 class="col">Carrinho <span id="codigo"></span></h3>
                        <button type="button" class="close ml-auto mb-auto" data-dismiss="modal" aria-label="Close"><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>
                        </button>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="row col-12">
                        <div class="col-6">
                            <div class="mb-3">
                                <b class="text-uppercase">Cliente</b>
                            </div>
                            <div class="mb-2">
                                <i class="fa fa-user px-2"></i>
                                <b id="cliente" class="text-capitalize"></b>
                            </div>
                            <div class="my-2">
                                <i class="fa fa-envelope px-2"></i>
                                <span id="email"></span>
                            </div>
                            <div class="my-2">
                                <i class="fa fa-phone px-2"></i>
                                <span id="phone"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <b class="text-uppercase">Valor Total</b>
                            </div>
                            <div>
                                <b><h3> R$ <span id="valor-total"></span></h3></b>
                            </div>
                            <div class="my-3">
                                <a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Retornar ao carrinho</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="card-body p-0">
                            <section id="lin_1">
                                <div class="table-responsive mt-3">
                                    <table class="table text-center">
                                        <thead class="text-uppercase">
                                            <tr>
                                                <th>Produto</th>
                                                <th>Qtd.</th>
                                                <th>Valor unitário</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">
                                                    <div class="row mt-3">
                                                        <div class="col-2">
                                                            <img src="#" alt="" class="prod_resume">
                                                        </div>
                                                        <div class="col-9 mx-2">
                                                            <a data-v-81a36fee="" href="#" class="product-title" target="_blank" id="nome-produto">
                                                            </a>
                                                            <p>SKU: <span id="cod_sku"></span></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p>1</p>
                                                </td>
                                                <td>
                                                    <p>R$ <span id="preco_venda"></span></p>
                                                </td>
                                                <td>
                                                    <p>R$ <span id="valor-subtotal"></span></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>