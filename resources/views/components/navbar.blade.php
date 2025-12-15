
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container-fluid">
    <button class="btn btn-sm btn-outline-secondary me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand fw-bold" href="{{ route('dashboard.index') }}">{{ config('app.name','NexusStock') }}</a>

    <form class="d-flex ms-auto me-3" action="{{ route('products.index') }}" method="GET">
      <input class="form-control form-control-sm me-2" name="q" type="search" placeholder="Buscar producto..." aria-label="Buscar">
      <button class="btn btn-sm btn-outline-primary" type="submit">Buscar</button>
    </form>

    @auth
      <div class="dropdown">
        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" href="#">
          <div class="me-2">
            <span class="badge bg-secondary text-uppercase">{{ Auth::user()->role }}</span>
          </div>
          <strong>{{ Auth::user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="{{ route('profile.show') }}">Perfil</a></li>
          @if(Auth::user()->role === 'admin')
            <li><a class="dropdown-item" href="{{ route('users.index') }}">Usuarios</a></li>
          @endif
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}" class="px-3">
              @csrf
              <button class="btn btn-sm btn-outline-danger w-100" type="submit">Cerrar sesión</button>
            </form>
          </li>
        </ul>
      </div>
    @endauth
  </div>
</nav>