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
            <div class="breadcrumb-item active"><a href="{{route('configuracoes')}}">Configurações</a></div>
        </div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="col-12 mx-5 my-4 pb-2">
                <a href="{{route('configuracoes.carrinhos')}}" class="row text-decoration-none ">
                  <div class="mx-3 my-auto border py-2 px-3 rounded h-100 text-center text-muted" style="font-size: 15px; width: 53px">
                    <i class="mdi mdi-cart-outline mdi-24px"></i>
                  </div>
                  <div class="my-auto">
                    <h6 class="mb-0">Carrinhos abandonados</h6>
                    <label class="text-dark mb-0">Configure o assunto dos e-mails e SMS.</label>
                  </div>
                </a>
              </div>
              <div class="col-12 mx-5 my-4 pb-2">
                <a href="{{route('configuracoes.checkout')}}" class="row text-decoration-none">
                  <div class="mx-3 my-auto border py-2 px-3 rounded h-100 text-center text-muted" style="font-size: 15px; width: 53px">
                    <i class="mdi mdi-credit-card-settings-outline mdi-24px" aria-hidden="true"></i>
                  </div>
                  <div class="my-auto">
                    <h6 class="mb-0">Checkout</h6>
                    <label class="text-dark mb-0">Gerencie o ambiente de pagamento disponibilizando seus meios de pagamento.</label>
                  </div>
                </a>
              </div>
              <div class="col-12 mx-5 my-4 pb-2">
                <a href="{{route('configuracoes.emails')}}" class="row text-decoration-none">
                  <div class="mx-3 my-auto border py-2 px-3 rounded h-100 text-center text-muted" style="font-size: 15px; width: 53px">
                    <i class="mdi mdi-email-outline mdi-24px"></i>
                  </div>
                  <div class="my-auto">
                    <h6 class="mb-0">E-mails transacionais</h6>
                    <label class="mb-0 text-dark">Gerencie o remetente, os status dos pedidos e as mensagens que os seus clientes receberão por e-mail.</label>
                  </div>
                </a>
              </div>
              <div class="col-12 mx-5 my-4 pb-2">
                <a href="{{route('configuracoes.geral')}}" class="row text-decoration-none">
                  <div class="mx-3 my-auto border py-2 px-3 rounded h-100 text-center text-muted" style="font-size: 15px; width: 53px">
                    <i class="mdi mdi-home-edit-outline mdi-24px"></i>
                  </div>
                  <div class="my-auto">
                    <h6 class="mb-0">Geral</h6>
                    <label class="text-dark mb-0">Veja e atualize as informações da sua loja, como título, descrição etc..</label>
                  </div>
                </a>
              </div>
              <div class="col-12 mx-5 my-4 pb-2">
                <a href="{{route('configuracoes.integracoes')}}" class="row text-decoration-none">
                  <div class="mx-3 my-auto border py-2 px-3 rounded h-100 text-center text-muted" style="font-size: 15px; width: 53px">
                    <i class="mdi mdi-share-variant mdi-24px"></i>
                  </div>
                  <div class="my-auto">
                    <h6 class="mb-0">Integrações</h6>
                    <label class="text-dark mb-0">Configure suas integrações de chat, marketing, logística, entre outras.</label>
                  </div>
                </a>
              </div>
              <div class="col-12 mx-5 my-4 pb-2">
                <a href="{{route('configuracoes.logistica')}}" class="row text-decoration-none">
                  <div class="mx-3 my-auto border py-2 px-3 rounded h-100 text-center text-muted" style="font-size: 15px; width: 53px">
                    <i class="mdi mdi-truck-outline mdi-24px"></i>
                  </div>
                  <div class="my-auto">
                    <h6 class="mb-0">Logística</h6>
                    <label class="text-dark mb-0">Gerencie as opções de fretes, valores e dias de entregas que estarão disponíveis para seus clientes.</label>
                  </div>
                </a>
              </div>
              <div class="col-12 mx-5 my-4 pb-2">
                <a href="{{route('configuracoes.seguranca')}}" class="row text-decoration-none">
                  <div class="mx-3 my-auto border py-2 px-3 rounded h-100 text-center text-muted" style="font-size: 15px; width: 53px">
                    <i class="mdi mdi-lock-outline mdi-24px"></i>
                  </div>
                  <div class="my-auto">
                    <h6 class="mb-0">Segurança</h6>
                    <label class="text-dark mb-0">Bloqueie o acesso de clientes na sua loja.</label>
                  </div>
                </a>
              </div>
              <div class="col-12 mx-5 my-4 pb-2">
                <a href="{{route('configuracoes.status')}}" class="row text-decoration-none">
                  <div class="mx-3 my-auto border py-2 px-3 rounded h-100 text-center text-muted" style="font-size: 15px; width: 53px">
                    <i class="mdi mdi-state-machine mdi-24px"></i>
                  </div>
                  <div class="my-auto">
                    <h6 class="mb-0">Status</h6>
                    <label class="text-dark mb-0">Gerencie os estados que os pedidos podem atingir na plataforma.</label>
                  </div>
                </a>
              </div>
              <div class="col-12 mx-5 my-4 pb-2">
                <a href="{{route('configuracoes.usuarios')}}" class="row text-decoration-none">
                  <div class="mx-3 my-auto border py-2 px-3 rounded h-100 text-center text-muted" style="font-size: 15px; width: 53px">
                    <i class="mdi mdi-account-cog-outline mdi-24px"></i>
                  </div>
                  <div class="my-auto">
                    <h6 class="mb-0">Usuários</h6>
                    <label class="text-dark mb-0">Gerencie os usuários que poderão acessar a sua loja.</label>
                  </div>
                </a>
              </div>
              <div class="col-12 mx-5 my-4 pb-2">
                <a href="{{route('configuracoes.grupos')}}" class="row text-decoration-none">
                  <div class="mx-3 my-auto border py-2 px-3 rounded h-100 text-center text-muted" style="font-size: 15px; width: 53px">
                    <i class="mdi mdi-account-group-outline mdi-24px"></i>
                  </div>
                  <div class="my-auto">
                    <h6 class="mb-0">Grupos de usuários</h6>
                    <label class="text-dark mb-0">Gerencie os grupos e as permissões que cada usuário terá na plataforma.</label>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
</div>
@endsection

@section('support')
<script type="text/javascript">
  $(document).ready(function (){

  });
</script>
@endsection