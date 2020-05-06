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
          <div class="breadcrumb-item active">E-mails transacionais</div>
        </div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <form method="POST" action="{{ route('configuracoes.emails.salvar') }}" enctype="multipart/form-data">
            @csrf

            @if(Session::has('alteracao'))
            <p class="alert alert-{{ Session::get('alteracao')['class'] }} alert-dismissible">
                {{ Session::get('alteracao')['mensagem'] }}
                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </p>
            @endif

            <div class="card">
              <div class="card-header">
                <h3 class="section-title my-0">Geral</h3>  
                
              </div>
              <div class="card-body">
                <div class="col-12">
                  <div class="mt-2 mb-5">
                    <div class="form-group col-6">
                      <label>E-mail do remetente <span class="text-danger">*</span></label>
                      <div class="input-group"> 
                        <input type="text" class="form-control" name="email_remetente" value="{{$emails->email_remetente}}" required>
                      </div>
                    </div>
                    <div class="form-group col-5">
                      <label>Nome do remetente <span class="text-danger">*</span></label>
                      <div class="input-group"> 
                        <input type="text" class="form-control" name="nome_remetente" value="{{$emails->nome_remetente}}" required>
                      </div>
                    </div>
                    @if(Auth::user()->RelationGrupo->gerenciar_checkout == 1)
                    <div class="form-group col-12">
                      <label>Status do pedidos</label>
                      <div class="input-group"> 
                        <a href="{{route('configuracoes.status')}}">Gerencie as informações do status de pedidos disponíveis. </a>
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="section-title my-0">Carrinhos abandonados</h3>  
              </div>
              <div class="card-body">
                <div class="col-12">
                  <div class="mt-2 mb-5">
                    <div class="form-group col-12">
                      <label class="custom-switch px-0">
                        <input type="checkbox" name="ativo_carrinho" class="custom-switch-input" {{($emails->ativo_carrinho == 1 ? ' checked' : '')}}>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description"><b>Envio de e-mails</b></span>
                      </label>
                    </div>
                    <div class="form-group col-12">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="enviar_cupom" {{($emails->enviar_cupom == 's' ? ' checked' : '')}}>
                        <label class="custom-control-label" for="customCheck1">Enviar cupom de desconto no primeiro e-mail</label>
                      </div>
                    </div>
                    <div class="form-group col-12">
                      <label>Assunto do e-mail <span class="text-danger">*</span></label>
                      <textarea class="summernote" name="assunto">{{$emails->assunto}}</textarea>
                    </div>
                    <div class="form-group col-12">
                      <label>SMS</label>
                      <textarea class="summernote" name="sms">{{$emails->sms}}</textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="section-title my-0">Avaliação dos produtos</h3>  
              </div>
              <div class="card-body">
                <div class="col-12">
                  <div class="mt-2 mb-5">
                    <div class="form-group col-12">
                      <label>Envio de e-mails <span class="text-danger">*</span></label>
                      <div class="input-group m-2"> 
                        <label class="custom-switch px-0">
                          <input type="checkbox" name="ativo_avaliacao" class="custom-switch-input" {{($emails->ativo_avaliacao == 1 ? ' checked' : '')}}>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description"><b>Ativo</b></span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group col">
                      <label>Enviar e-mail para o cliente avaliar o produto depois de <span class="text-danger">*</span></label>
                      <div class="input-group"> 
                        <input type="number" class="form-control col-1"  value="{{$emails->avaliar_produto}}" name="avaliar_produto" required>
                        <label class="mx-2 my-auto">dias</label>
                        <small class="col-12 my-2 px-0">O e-mail será enviado {{$emails->avaliar_produto}} dias após o produto ser entregue.</small>
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