<div class="modal fade" id="modal-emails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card mb-0">
                <div class="card-header d-block col-12">
                    <div class="col-12 d-flex py-2">
                        <h4 class="titulo_modal titulo_modal">{{$pedido->RelationCliente->nome}}</h4>
                        <button type="button" class="ml-auto close" data-dismiss="modal" aria-label="Close"><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <td align="center">
                                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td class="header">
                                            <a href="{{ config('app.url') }}">
                                                <img src="{{ asset('storage/app/system/capsul.png').'?'.rand() }}" alt="Imagem logo" height="50">
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Email Body -->
                                    <tr>
                                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                                <!-- Body content -->
                                                <tr>
                                                    <td class="content-cell">
                                                        <h1> Olá, {{ ucwords(strtolower(explode(" ", $pedido->RelationCliente->nome)[0])) }}!</h1>

                                                        <p>A gente acabou de receber seu pedido de nº <b>{{$pedido->codigo}}</b>, ebaa!!</p>
                                                        <p>Agora, é só esperar a aprovação do pagamento, tá?</p>

                                                        <div align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                            <a href="{{route('acompanhamento.pedido', $pedido->codigo)}}" target="_blank" class="button button-primary">
                                                                <h5 style="margin: 0;">Acompanhar meu pedido</h5>
                                                            </a>                    
                                                        </div>
                                                        
                                                        <h5 style="margin-bottom: 2px;">Resumo da compra</h5>
                                                        <hr>
                                                        <p>
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <img src="{{ url('storage/app/'.$pedido->RelationProduto->RelationImagensPrincipal->first()->caminho) }}" alt="Produto" style="height: auto; width: 70px; border: 1px solid silver; border-radius: 6px; padding: 5px; margin-right: 10px">
                                                                    </td>
                                                                    <td>
                                                                        <label>{{$pedido->RelationProduto->nome}}</label>
                                                                        <br>
                                                                        <small><b>Marca:</b> {{$pedido->RelationProduto->RelationMarcas->nome}}</small>
                                                                        <br>
                                                                        <small><b>Valor:</b> R$ {{ number_format($pedido->valor_compra,2, ",", ".") }}</small>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </p>

                                                        <p> Abraços, <br> {{$geral->nome_loja}}.
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td class="content-cell" align="center">
                                                        <b>Equipe de suporte do {{ $geral->nome_loja }}!</b><br>
                                                        <label>{{ $geral->email }}</label><br>
                                                        <a href="{{ config('app.url') }}" target="_blank">{{ config('app.url') }}</a><br>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>