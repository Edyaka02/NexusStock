@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-0">Productos</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Nuevo Producto</a>
    </div>
</div>

<!-- Tabla de productos -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($products->isEmpty())
                    <p class="text-muted">No hay productos registrados.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                            <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection