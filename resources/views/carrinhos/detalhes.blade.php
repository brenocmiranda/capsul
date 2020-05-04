<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card mb-0">
                <div class="card-header py-0" style="background-color: #f6f6f6;">
                    <div class="row col-12 my-4">
                        <h3 class="col">Carrinho 
                            <span id="codigo"></span>
                            <span id="atualzacao"></span>
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true"><i class="mdi mdi-close mdi-24px"></i></span>
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
                                <a href="javascript:void(0)" id="cliente" class="text-capitalize font-weight-bold"></a>
                            </div>
                            <div class="my-2">
                                <i class="fa fa-envelope px-2"></i>
                                <span id="email"></span>
                            </div>
                            <div class="my-2 text-success">
                                <i class="mdi mdi-whatsapp px-2"></i>
                                <a href="javascript:void(0)" target="_blank" class="text-decoration-none text-success" id="phone"> </a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <b class="text-uppercase">Valor Total</b>
                            </div>
                            <div>
                                <b><h3 id="valorTotal"></h3></b>
                            </div>
                            <div class="my-3">
                                <a href="javascript:void(0)" class="btn btn-primary shadow-none font-weight-bold" id="linkCarrinho" target="_blank"><i class="mdi mdi-cart px-1"></i> Simular ao carrinho</a>
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
                                                            <img src="#" alt="" class="rounded prod_resume">
                                                        </div>
                                                        <div class="col-9 mx-2">
                                                            <a data-v-81a36fee="" href="#" class="product-title" target="_blank" id="nome-produto">
                                                            </a>
                                                            <p>SKU: <span id="cod_sku"></span></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p id="quantidade">1</p>
                                                </td>
                                                <td>
                                                    <p id="precoVenda">R$</p>
                                                </td>
                                                <td>
                                                    <p id="valorSubtotal">R$</p>
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