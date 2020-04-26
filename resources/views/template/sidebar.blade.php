<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ route('home') }}"><img src="{{ asset('storage/app/system/capsul.png').'?'.rand() }}" alt="Capsul" style="max-height: 50px;"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('home') }}"><img src="{{ asset('storage/app/system/icon.png').'?'.rand() }}" alt="Capsul" style="max-width: 32px;"></a>
    </div>

    <hr class="mx-4 mt-0">

    <div class="user-profile">
      <div class="col-12 row p-md-3 m-md-0 perfil">
        <div class="col-4 text-left image">
          <img src="{{ (isset(Auth::user()->RelationImagens) ? asset('storage/app/'.Auth::user()->RelationImagens->caminho.'?'.rand()) : asset('public/admin/img/user.png')) }}" alt="user-img" class="rounded-circle" width="60" height="60">
        </div>
        <div class="col-8 pl-2 text-left name my-auto">
            <label class="text-dark text-truncate font-weight-bold mb-n1 w-100">
                {{ Auth::user()->nome }}
            </label>
            <small class="text-uppercase font-weight-normal px-0 w-100">
              {{(isset(Auth::user()->RelationGrupo) ? Auth::user()->RelationGrupo->nome : 'Não atribuído') }}
            </small>
        </div>
      </div>
    </div>

    <ul class="sidebar-menu mt-2">
        <li class="menu-header">Gerencial</li>

        <li class="nav-item dropdown {{(Request::segment(1) == 'home' ? 'active' : '')}}">
          <a href="{{ route('home') }}" class="nav-link menu-border">
            <i class="mdi mdi-home-outline mdi-24px"></i><span>Página inicial</span>
          </a>
        </li>

        @if(Auth::user()->RelationGrupo->visualizar_dashboard == 1)
        <li class="nav-item dropdown {{(Request::segment(1) == 'dashboard' ? 'active' : '')}}">
          <a href="{{ route('dashboard') }}" class="nav-link menu-border">
            <i class="mdi mdi-finance mdi-24px"></i><span>Visão Geral</span>
          </a>
        </li>
        @endif
        
        @if(Auth::user()->RelationGrupo->visualizar_pedidos == 1 || Auth::user()->RelationGrupo->gerenciar_pedidos == 1)
        <li class="nav-item dropdown {{(Request::segment(1) == 'pedidos' ? 'active' : '')}}">
          <a href="#" class="nav-link has-dropdown menu-border" data-toggle="dropdown"><i class="mdi mdi-dolly mdi-24px"></i> <span>Pedidos</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link {{(Request::segment(1) == 'pedidos' &&  Request::segment(2) == '' ? 'font-weight-bold' : '')}}" href="{{ route('pedidos.lista') }}">Ver todos</a></li>
            <li><a class="nav-link {{(Request::segment(2) == 'carrinhos' ? 'font-weight-bold' : '')}}" href="{{ route('carrinhos.lista') }}">Carrinhos abandonados</a></li>
          </ul>
        </li>
        @endif

        @if(Auth::user()->RelationGrupo->visualizar_produtos == 1 || Auth::user()->RelationGrupo->gerenciar_produtos == 1 || Auth::user()->RelationGrupo->visualizar_marcas == 1 || Auth::user()->RelationGrupo->gerenciar_marcas == 1 || Auth::user()->RelationGrupo->visualizar_categorias == 1 || Auth::user()->RelationGrupo->gerenciar_categorias == 1 || Auth::user()->RelationGrupo->visualizar_variacoes == 1 || Auth::user()->RelationGrupo->gerenciar_variacoes == 1)
        <li class="nav-item dropdown {{(Request::segment(1) == 'produtos' ? 'active' : '')}}">
          <a href="#" class="nav-link has-dropdown menu-border" data-toggle="dropdown"><i class="mdi mdi-package-variant mdi-24px"></i> <span>Produtos</span></a>
          <ul class="dropdown-menu">
            @if(Auth::user()->RelationGrupo->visualizar_produtos == 1 || Auth::user()->RelationGrupo->gerenciar_produtos == 1)
            <li><a class="nav-link {{(Request::segment(1) == 'produtos' && Request::segment(2) == '' ? 'font-weight-bold' : '')}}" href="{{ route('produtos.lista') }}">Ver todos</a></li>
            @endif

            @if(Auth::user()->RelationGrupo->gerenciar_produtos == 1)
            <li><a class="nav-link {{(Request::segment(2) == 'adicionar' ? 'font-weight-bold' : '')}}" href="{{ route('produtos.adicionar') }}">+ Novo produto</a></li>
            @endif

            @if( (Auth::user()->RelationGrupo->visualizar_produtos == 1 || Auth::user()->RelationGrupo->gerenciar_produtos == 1) || (Auth::user()->RelationGrupo->visualizar_categorias == 1 || Auth::user()->RelationGrupo->gerenciar_categorias == 1) || (Auth::user()->RelationGrupo->visualizar_marcas == 1 || Auth::user()->RelationGrupo->gerenciar_marcas == 1) || (Auth::user()->RelationGrupo->visualizar_variacoes == 1 || Auth::user()->RelationGrupo->gerenciar_variacoes == 1))
            <hr class="mx-4">
            @endif

            @if(Auth::user()->RelationGrupo->visualizar_categorias == 1 || Auth::user()->RelationGrupo->gerenciar_categorias == 1)
            <li><a class="nav-link {{(Request::segment(2) == 'categorias' ? 'font-weight-bold' : '')}}" href="{{ route('categorias.lista') }}">Categorias</a></li>
            @endif

            @if(Auth::user()->RelationGrupo->visualizar_marcas == 1 || Auth::user()->RelationGrupo->gerenciar_marcas == 1)
            <li><a class="nav-link {{(Request::segment(2) == 'marcas' ? 'font-weight-bold' : '')}}" href="{{ route('marcas.lista') }}">Marcas</a></li>
            @endif

            @if(Auth::user()->RelationGrupo->visualizar_variacoes == 1 || Auth::user()->RelationGrupo->gerenciar_variacoes == 1)
            <li><a class="nav-link {{(Request::segment(2) == 'variacoes' ? 'font-weight-bold' : '')}}" href="{{ route('variacoes.lista') }}">Variações</a></li>
            @endif
          </ul>
        </li>
        @endif
        
        @if(Auth::user()->RelationGrupo->visualizar_clientes == 1 || Auth::user()->RelationGrupo->gerenciar_clientes == 1 || Auth::user()->RelationGrupo->visualizar_leads == 1 || Auth::user()->RelationGrupo->gerenciar_leads == 1)
        <li class="nav-item dropdown {{(Request::segment(1) == 'clientes' ? 'active' : '')}}">
          <a href="#" class="nav-link has-dropdown menu-border" data-toggle="dropdown"><i class="mdi mdi-account-group mdi-24px"></i> <span>Clientes</span></a>
          <ul class="dropdown-menu">
            @if(Auth::user()->RelationGrupo->visualizar_clientes == 1 || Auth::user()->RelationGrupo->gerenciar_clientes == 1)
            <li><a class="nav-link {{(Request::segment(1) == 'clientes' && Request::segment(2) == '' ? 'font-weight-bold' : '')}}" href="{{ route('clientes.lista') }}">Ver todos</a></li>
            <li><a class="nav-link {{(Request::segment(2) == 'grupos' ? 'font-weight-bold' : '')}}" href="{{ route('grupos.lista') }}">Grupos</a></li>
            @endif

            @if(Auth::user()->RelationGrupo->visualizar_leads == 1 || Auth::user()->RelationGrupo->gerenciar_leads == 1)
            <li><a class="nav-link {{(Request::segment(2) == 'leads' ? 'font-weight-bold' : '')}}" href="{{ route('leads.lista') }}">Leads</a></li>
            @endif
          </ul>
        </li>
        @endif

        <li class="nav-item dropdown {{(Request::segment(1) == 'marketing' ? 'active' : '')}}">
          <a href="#" class="nav-link has-dropdown menu-border" data-toggle="dropdown"><i class="mdi mdi-bullhorn-outline mdi-24px"></i> <span>Marketing</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="#">Cupons</a></li>
            <li><a class="nav-link" href="#">Faixas de desconto</a></li>
            <li><a class="nav-link" href="#">Pixels</a></li>
            <li><a class="nav-link" href="#">Promoções</a></li>
            <li><a class="nav-link" href="#">Upsell</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown {{(Request::segment(1) == 'relatorios' ? 'active' : '')}}">
          <a href="#" class="nav-link has-dropdown menu-border" data-toggle="dropdown"><i class="mdi mdi-file-outline mdi-24px"></i> <span>Relatórios</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="#">Vendas por produto</a></li>
            <li><a class="nav-link" href="#">Boletos por produtos</a></li>
          </ul>
        </li>
        
        <li class="nav-item dropdown {{(Request::segment(1) == 'configuracoes' ? 'active' : '')}}">
          <a href="{{route('configuracoes')}}" class="nav-link has-dropdown menu-border" data-toggle="dropdown"><i class="mdi mdi-cog-outline mdi-24px"></i> <span>Configurações</span></a>
          <ul class="dropdown-menu">                  
            
            @if(Auth::user()->RelationGrupo->visualizar_checkout == 1 || Auth::user()->RelationGrupo->gerenciar_checkout == 1)
              <li><a class="nav-link {{(Request::segment(2) == 'carrinhos' ? 'font-weight-bold' : '')}}" href="{{route('configuracoes.carrinhos')}}">Carrinhos abandonados</a></li>
              <li><a class="nav-link {{(Request::segment(2) == 'checkout' ? 'font-weight-bold' : '')}}" href="{{route('configuracoes.checkout')}}">Checkout</a></li> 
            @endif

            @if(Auth::user()->RelationGrupo->visualizar_geral == 1 || Auth::user()->RelationGrupo->gerenciar_geral == 1)
              <li><a class="nav-link {{(Request::segment(2) == 'geral' ? 'font-weight-bold' : '')}}" href="{{route('configuracoes.geral')}}">Geral</a></li> 
              <li><a class="nav-link {{(Request::segment(2) == 'emails' ? 'font-weight-bold' : '')}}" href="{{route('configuracoes.emails')}}">E-mails</a></li>
              <li><a class="nav-link {{(Request::segment(2) == 'status' ? 'font-weight-bold' : '')}}" href="{{route('configuracoes.status')}}">Status</a></li> 
            @endif

            @if(Auth::user()->RelationGrupo->visualizar_usuarios == 1 || Auth::user()->RelationGrupo->gerenciar_usuarios == 1)
              <li><a class="nav-link {{(Request::segment(2) == 'seguranca' ? 'font-weight-bold' : '')}}" href="{{route('configuracoes.seguranca')}}">Segurança</a></li> 
              <li><a class="nav-link {{(Request::segment(2) == 'usuarios' ? 'font-weight-bold' : '')}}" href="{{ route('configuracoes.usuarios') }}">Usuários</a></li>
              <li><a class="nav-link {{(Request::segment(2) == 'grupos' ? 'font-weight-bold' : '')}}" href="{{route('configuracoes.grupos')}}">Grupos de usuários</a></li> 
            @endif

            @if(Auth::user()->RelationGrupo->visualizar_logistica == 1 || Auth::user()->RelationGrupo->gerenciar_logistica == 1)
              <li><a class="nav-link {{(Request::segment(2) == 'logistica' ? 'font-weight-bold' : '')}}" href="{{route('configuracoes.logistica')}}">Logística</a></li> 
              <li><a class="nav-link {{(Request::segment(2) == 'integracoes' ? 'font-weight-bold' : '')}}" href="{{route('configuracoes.integracoes')}}">Integrações</a></li> 
            @endif
          </ul>
        </li>
      </ul> 
      
      <div class="mt-2 mb-2 p-3 hide-sidebar-mini">
        <a href="{{ route('logout') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
  </aside>
</div>