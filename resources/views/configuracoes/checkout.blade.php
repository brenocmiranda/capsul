@extends('template.index')

@section('title')
Configurações
@endsection

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <div class="mx-3">
        <h1>Configurações</h1>
        
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
            <div class="breadcrumb-item"><a href="{{route('configuracoes')}}">Configurações</a></div>
            <div class="breadcrumb-item active">Checkout</div>
        </div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <form method="POST" action="{{ route('configuracoes.checkout.salvar') }}" enctype="multipart/form-data">
            @csrf

            @if(Session::has('confirm'))
            <p class="py-2 alert alert-dismissible alert-{{ Session::get('confirm')['class'] }}  fade show" role="alert">
              {{ Session::get('confirm')['mensagem'] }}
              <button type="button" class="close text-dark" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </p>
            @endif

            <div class="card">
              <div class="card-header py-0">
                <h3 class="section-title">Checkout</h3>  
              </div>
              <div class="card-body">
                <div class="col-12"> 
                  <h6>Afiliações de pagamento <small class="text-success"><b>Pagar.me</b></small></h6>
                  <hr class="mt-2">
                  <div class="mt-4 mb-5">
                    <div class="form-group col-8">
                      <label>API Key <span class="text-danger">*</span></label>
                      <div class="input-group"> 
                        <input type="text" class="form-control" name="api_key" value="{{$checkout->api_key}}" required>
                        <small class="col-12 row my-2">Código utilizado pelo meio de pagamento criar as transações.</small>
                      </div>
                    </div>
                    <div class="form-group col-8">
                      <label>API Criptografada <span class="text-danger">*</span></label>
                      <div class="input-group"> 
                        <input type="text" class="form-control" name="api_criptografada" value="{{$checkout->api_criptografada}}" required>
                        <small class="col-12 row my-2">Código utilizado pelo meio de pagamento para criar o hash que servirá para criar as transações.</small>
                      </div>
                    </div>
                  </div>

                  <h6>Regras</h6>
                  <hr class="mt-2">
                  <div class="mt-4 mb-5">
                    <div class="form-group col-12 mb-0">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck3" name="endereco_cliente" {{($checkout->endereco_cliente == 1 ? ' checked' : '')}}>
                        <label class="custom-control-label" for="customCheck3">Sempre solicitar o endereço do cliente</label>
                      </div>
                    </div>
                    <div class="form-group col-12 mb-0">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck4" name="prazo_entrega" {{($checkout->prazo_entrega == 1 ? ' checked' : '')}}>
                        <label class="custom-control-label" for="customCheck4">Mostrar prazo de entrega</label>
                      </div>
                    </div>
                    <div class="form-group col-12 mb-0">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck6" name="calculo_frete" {{($checkout->calculo_frete == 1 ? ' checked' : '')}}>
                        <label class="custom-control-label" for="customCheck6">Exibir cálculo de frete no carrinho</label>
                      </div>
                    </div>
                    <div class="form-group col-12 mb-0">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck7" name="cupom_desconto" {{($checkout->cupom_desconto == 1 ? ' checked' : '')}}>
                        <label class="custom-control-label" for="customCheck7">Exibir campo de cupom de desconto</label>
                      </div>
                    </div>
                    <div class="form-group col-12 mb-0">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck9" name="data_nascimento" {{($checkout->data_nascimento == 1 ? ' checked' : '')}}>
                        <label class="custom-control-label" for="customCheck9">Solicitar data de nascimento do cliente</label>
                      </div>
                    </div>
                    <div class="form-group col-12 mb-0">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck10" name="data_previsao" {{($checkout->data_previsao == 1 ? ' checked' : '')}}>
                        <label class="custom-control-label" for="customCheck10">Mostrar data de previsão de entrega</label>
                      </div>
                    </div>
                    <div class="form-group col-12 mb-0">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck11" name="maior_parcela" {{($checkout->maior_parcela == 1 ? ' checked' : '')}}>
                        <label class="custom-control-label" for="customCheck11">Selecionar a maior parcela automaticamente</label>
                      </div>
                    </div>
                    <div class="form-group col-12 mb-0">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck13" name="quantidade_itens" {{($checkout->quantidade_itens == 1 ? ' checked' : '')}}>
                        <label class="custom-control-label" for="customCheck13">Permitir mudança de quantidade dos itens</label>
                      </div>
                    </div>
                  </div>

                  <h6>Informações básicas</h6>
                  <hr class="mt-2">
                  <div class="mt-4 mb-5">
                    <div class="form-group col-4">
                      <label>Permitir compras de <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <select class="form-control h-100" name="compras_pessoa" required>
                          <option value="Nenhum">Nenhum</option>
                          <option value="Pessoa física e jurídica" {{($checkout->compras_pessoa == 'Pessoa física e jurídica' ? ' selected' : '')}}>Pessoa física e jurídica</option>
                          <option value="Pessoa física" {{($checkout->compras_pessoa == 'Pessoa física' ? ' selected' : '')}}>Pessoa física</option>
                          <option value="Pessoa jurídica" {{($checkout->compras_pessoa == 'Pessoa jurídica' ? ' selected' : '')}}>Pessoa jurídica</option>
                        </select>
                      </div>  
                    </div>  
                    <div class="form-group col-4">
                      <label>Pagamento preferencial</label>
                      <div class="input-group">
                        <select class="form-control h-100" name="pagamento_preferencial">
                          <option disabled="disabled">Selecione</option>
                          <option value="Cartão crédito" {{($checkout->pagamento_preferencial == 'Cartão crédito' ? ' selected' : '')}}>Cartão crédito</option>
                          <option value="Boleto" {{($checkout->pagamento_preferencial == 'Boleto' ? ' selected' : '')}}>Boleto</option>
                        </select>
                      </div>  
                    </div> 
                    <div class="row col">
                      <div class="form-group col-3">
                        <label>Máximo de pedidos diários por IP</label>
                        <div class="input-group">
                          <input type="number" class="form-control col-6" name="pedidos_ip" value="{{$checkout->pedidos_ip}}">
                        </div>  
                      </div>
                      <div class="form-group col-4">
                        <label>Tempo do cronômetro</label>
                        <div class="input-group">
                          <input type="number" class="form-control col-4" name="tempo_cronometro" value="{{$checkout->tempo_cronometro}}">
                          <label class="h-100 my-auto mx-2">minutos.</label>
                        </div>  
                      </div>
                    </div>

                    <div class="form-group col-12">
                      <label>Texto de destaque no topo <small>(Esse texto ficará fixo no topo do Checkout)</small></label>

                      <textarea class="summernote" name="texto_topo">{{$checkout->texto_topo}}</textarea>
                      
                    </div>
                    <div class="form-group col-12">
                      <label>Texto de observação para Entregas</label>
                      <textarea class="summernote" name="texto_entrega">{{$checkout->texto_entrega}}</textarea>
                    </div>
                    <div class="form-group col-12">
                      <label>Texto de observação para pagamento via Boleto Bancário</label>
                      <textarea class="summernote" name="texto_boleto">{{$checkout->texto_boleto}}</textarea>
                    </div>
                  </div>

                  <h6>Descontos</h6>
                  <hr class="mt-2">
                  <div class="mt-4 mb-5">
                    <div class="form-group col-3">
                      <label>Compras no boleto</label>
                      <div class="input-group"> 
                        <input type="text" class="form-control medida h-100" name="desconto_boleto"  value="{{$checkout->desconto_boleto}}">
                        <div class="input-group-append">
                          <div class="input-group-text py-0">
                            <b>%</b>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-3">
                      <label>Compras no cartão de crédito</label>
                      <div class="input-group"> 
                        <input type="text" class="form-control medida h-100" name="desconto_cartao" value="{{$checkout->desconto_cartao}}">
                        <div class="input-group-append">
                          <div class="input-group-text py-0">
                            <b>%</b>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <h6>URLS de redirecionamento</h6>
                  <hr class="mt-2">
                  <div class="mt-4 mb-5">
                    <div class="form-group col-8">
                      <label>Para boleto</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="url_boleto"  value="{{$checkout->url_boleto}}">
                      </div>
                    </div>
                    <div class="form-group col-8">
                      <label>Para cartão</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="url_cartao"  value="{{$checkout->url_cartao}}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <hr>
            <div class="col-12 mb-5 text-right">
              <a href="{{ route('configuracoes') }}" class="btn btn-danger btn-lg col-2 mx-1">Cancelar</a>
              <button class="btn btn-primary btn-lg col-2 mx-1">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
