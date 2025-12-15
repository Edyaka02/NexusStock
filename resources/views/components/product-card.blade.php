<div class="card h-100">
  <div class="card-body d-flex flex-column">
    <div class="d-flex justify-content-between mb-2">
      <span class="badge bg-secondary">{{ $product->sku }}</span>
      <span class="text-muted small">{{ $product->created_at->format('Y-m-d') }}</span>
    </div>

    <h5 class="card-title">{{ $product->name }}</h5>
    <p class="card-text text-truncate">{{ $product->description }}</p>

    <div class="mt-auto">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
          <strong>${{ number_format($product->price,2) }}</strong>
        </div>
        <div>
          @if($product->stock <= $product->min_stock)
            <span class="badge bg-danger">Stock: {{ $product->stock }}</span>
          @else
            <span class="badge bg-success">Stock: {{ $product->stock }}</span>
          @endif
        </div>
      </div>

      <div class="d-flex gap-2">
        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">Ver</a>
        @can('update', $product)
          <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
        @endcan
      </div>
    </div>
  </div>
</div>