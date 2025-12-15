@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-0">Producto: {{ $product->name }}</h1>
        <div class="d-flex gap-2">
            @can('update', $product)
                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary">Editar</a>
            @endcan
            @can('delete', $product)
                <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                </form>
            @endcan
            <a href="{{ route('inventory.new-movement', ['product' => $product->id]) }}" class="btn btn-outline-info">Registrar Movimiento</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">SKU</dt>
                    <dd class="col-sm-9">{{ $product->sku }}</dd>

                    <dt class="col-sm-3">Nombre</dt>
                    <dd class="col-sm-9">{{ $product->name }}</dd>

                    <dt class="col-sm-3">Descripción</dt>
                    <dd class="col-sm-9">{{ $product->description ?: 'Sin descripción' }}</dd>

                    <dt class="col-sm-3">Precio</dt>
                    <dd class="col-sm-9">${{ number_format($product->price, 2) }}</dd>

                    <dt class="col-sm-3">Stock Actual</dt>
                    <dd class="col-sm-9">
                        @if($product->stock <= $product->min_stock)
                            <span class="badge bg-danger">{{ $product->stock }}</span> (Bajo)
                        @else
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Stock Mínimo</dt>
                    <dd class="col-sm-9">{{ $product->min_stock }}</dd>

                    <dt class="col-sm-3">Creado</dt>
                    <dd class="col-sm-9">{{ $product->created_at->format('d/m/Y H:i') }}</dd>

                    <dt class="col-sm-3">Actualizado</dt>
                    <dd class="col-sm-9">{{ $product->updated_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <!-- Movimientos recientes (opcional) -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Movimientos Recientes</h5>
            </div>
            <div class="card-body">
                @if($recentMovements->isNotEmpty())
                    <ul class="list-group list-group-flush">
                        @foreach($recentMovements as $movement)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ ucfirst($movement->type) }}</strong> - {{ $movement->quantity }}
                                    <br><small class="text-muted">{{ $movement->created_at->diffForHumans() }}</small>
                                </div>
                                <span class="badge bg-{{ $movement->type == 'purchase' ? 'success' : ($movement->type == 'sale' ? 'danger' : 'warning') }}">{{ $movement->type }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('inventory.movements', ['product' => $product->id]) }}" class="btn btn-sm btn-outline-primary mt-2">Ver todos</a>
                @else
                    <p class="text-muted">No hay movimientos recientes.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Volver a Productos</a>
    </div>
</div>
@endsection