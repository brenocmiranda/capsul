<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg text-dark"><i class="mdi mdi-menu mdi-24px"></i></a></li>
        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
      </ul>
      <!-- <div class="search-element">
        <input class="form-control" type="search" placeholder="Buscar..." aria-label="Search" data-width="250">
        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
      </div> -->
    </form>
    <ul class="navbar-nav navbar-right">
      <li class="dropdown dropdown-list-toggle">
        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">
          <i class="mdi mdi-bell-outline mdi-24px"></i>
        </a>
        <div class="dropdown-menu dropdown-list dropdown-menu-right">
          <div class="dropdown-header">Notificações
            <div class="float-right">
              <a href="#">Marcar todas como lidas</a>
            </div>
          </div>
          <div class="dropdown-list-content dropdown-list-icons">
            
            <a href="#" class="dropdown-item dropdown-item-unread">
              <div class="dropdown-item-icon bg-primary text-white">
                <i class="fas fa-code"></i>
              </div>
              <div class="dropdown-item-desc">
                Template update is available now!
                <div class="time text-primary">2 Min Ago</div>
              </div>
            </a>

          </div>
          <div class="dropdown-footer text-center">
            <a href="#">Ver todas <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </li>
      <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
          <img alt="image" src="{{ (isset(Auth::user()->RelationImagens) ? asset('storage/app/'.Auth::user()->RelationImagens->caminho.'?'.rand()) : asset('public/img/user.png')) }}" class="rounded-circle mr-1" title="Imagem de perfil">
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="{{route('perfil')}}" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Perfil
          </a>
          <a href="{{route('atividades')}}" class="dropdown-item has-icon">
            <i class="fas fa-bolt"></i> Atividades
          </a>
          <a href="{{route('configuracoes')}}" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> Configurações
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>