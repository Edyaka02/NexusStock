<div class="position-sticky pt-3">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
        <i class="bi bi-box-seam me-2"></i> Productos
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.movements') }}">
        <i class="bi bi-arrow-left-right me-2"></i> Movimientos
      </a>
    </li>

    @if(optional(Auth::user())->role === 'admin')
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
          <i class="bi bi-people me-2"></i> Usuarios
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('audit.*') ? 'active' : '' }}" href="{{ route('audit.logs') }}">
          <i class="bi bi-journal-text me-2"></i> Auditoría
        </a>
      </li>
    @endif

    <li class="nav-item mt-3">
      <a class="nav-link text-muted small" 
      {{--href="{{ route('profile.show') }}"--}}
      >Mi cuenta</a>
    </li>
  </ul>
</div>