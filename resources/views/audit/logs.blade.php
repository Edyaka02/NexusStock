@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3">Logs de Auditoría</h1>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('audit.logs') }}" class="row g-3">
                    <div class="col-md-3">
                        <select name="event_type" class="form-select">
                            <option value="">Todos los eventos</option>
                            <option value="login" {{ request('event_type') == 'login' ? 'selected' : '' }}>Login</option>
                            <option value="logout" {{ request('event_type') == 'logout' ? 'selected' : '' }}>Logout</option>
                            <option value="create" {{ request('event_type') == 'create' ? 'selected' : '' }}>Crear</option>
                            <option value="update" {{ request('event_type') == 'update' ? 'selected' : '' }}>Actualizar</option>
                            <option value="delete" {{ request('event_type') == 'delete' ? 'selected' : '' }}>Eliminar</option>
                            <option value="movement" {{ request('event_type') == 'movement' ? 'selected' : '' }}>Movimiento</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="severity" class="form-select">
                            <option value="">Todas las severidades</option>
                            <option value="low" {{ request('severity') == 'low' ? 'selected' : '' }}>Baja</option>
                            <option value="medium" {{ request('severity') == 'medium' ? 'selected' : '' }}>Media</option>
                            <option value="high" {{ request('severity') == 'high' ? 'selected' : '' }}>Alta</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">Filtrar</button>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('audit.logs') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de logs -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($logs->isEmpty())
                    <p class="text-muted">No hay logs registrados.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Evento</th>
                                    <th>Descripción</th>
                                    <th>IP</th>
                                    <th>Severidad</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>{{ ucfirst($log->event_type) }}</td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->ip_address }}</td>
                                        <td>
                                            <span class="badge bg-{{ $log->severity == 'high' ? 'danger' : ($log->severity == 'medium' ? 'warning' : 'info') }}">
                                                {{ ucfirst($log->severity) }}
                                            </span>
                                        </td>
                                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $logs->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection