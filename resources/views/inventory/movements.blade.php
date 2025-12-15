@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-0">Historial de Movimientos</h1>
        <a href="{{ route('inventory.new-movement') }}" class="btn btn-primary">Registrar Movimiento</a>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('inventory.movements') }}" class="row g-3">
                    <div class="col-md-3">
                        <select name="product_id" class="form-select">
                            <option value="">Todos los productos</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->sku }} - {{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="type" class="form-select">
                            <option value="">Todos los tipos</option>
                            <option value="purchase" {{ request('type') == 'purchase' ? 'selected' : '' }}>Compra</option>
                            <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>Venta</option>
                            <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Ajuste</option>
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
                        <a href="{{ route('inventory.movements') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de movimientos -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($movements->isEmpty())
                    <p class="text-muted">No hay movimientos registrados.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Usuario</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movements as $movement)
                                    <tr>
                                        <td>{{ $movement->id }}</td>
                                        <td>{{ $movement->product->sku }} - {{ $movement->product->name }}</td>
                                        <td>{{ $movement->user->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $movement->type == 'purchase' ? 'success' : ($movement->type == 'sale' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($movement->type) }}
                                            </span>
                                        </td>
                                        <td>{{ $movement->quantity }}</td>
                                        <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $movements->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection