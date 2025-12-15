@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3">Registrar Movimiento de Inventario</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('inventory.store-movement') }}">
                    @csrf

                    <!-- Product -->
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Producto <span class="text-danger">*</span></label>
                        <select id="product_id" class="form-select @error('product_id') is-invalid @enderror" name="product_id" required>
                            <option value="">Seleccionar producto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>
                                    {{ $product->sku }} - {{ $product->name }} (Stock: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipo de Movimiento <span class="text-danger">*</span></label>
                        <select id="type" class="form-select @error('type') is-invalid @enderror" name="type" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="purchase" {{ old('type') == 'purchase' ? 'selected' : '' }}>Compra (aumenta stock)</option>
                            <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>Venta (disminuye stock)</option>
                            <option value="adjustment" {{ old('type') == 'adjustment' ? 'selected' : '' }}>Ajuste (manual)</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantidad <span class="text-danger">*</span></label>
                        <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required min="1">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Para ventas/ajustes, asegúrate de que no exceda el stock actual.</div>
                    </div>

                    <!-- Reason (opcional) -->
                    <div class="mb-3">
                        <label for="reason" class="form-label">Motivo (opcional)</label>
                        <textarea id="reason" class="form-control @error('reason') is-invalid @enderror" name="reason" rows="3">{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
                        <a href="{{ route('inventory.movements') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection