@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-0">Gestión de Usuarios</h1>
        @can('create', App\Models\User::class)
            <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo Usuario</a>
        @endcan
    </div>
</div>

<!-- Tabla de usuarios -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($users->isEmpty())
                    <p class="text-muted">No hay usuarios registrados.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Creado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'secondary' }}">{{ ucfirst($user->role) }}</span>
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @can('update', $user)
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                            @endcan
                                            @if($user->id !== Auth::id() && Auth::user()->role === 'admin')
                                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $users->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection