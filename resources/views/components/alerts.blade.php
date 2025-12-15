{{-- @php
//   use App\Models\Product;
//   $lowProducts = Product::whereColumn('stock', '<=', 'min_stock')->orderBy('stock')->limit(5)->get();
@endphp

@if($lowProducts->isNotEmpty())
  <div class="alert alert-warning d-flex justify-content-between align-items-start" role="alert">
    <div>
      <h6 class="mb-1">Productos con stock bajo</h6>
      <ul class="mb-0">
        @foreach($lowProducts as $p)
          <li>
            <strong>{{ $p->sku }}</strong> — {{ $p->name }}:
            <span class="badge bg-{{ $p->stock==0 ? 'danger' : 'warning' }}">{{ $p->stock }}</span>
            (mín {{ $p->min_stock }})
          </li>
        @endforeach
      </ul>
    </div>
    <div class="ms-3">
      <a href="{{ route('products.index', ['filter' => 'low']) }}" class="btn btn-sm btn-outline-dark">Ver todos</a>
    </div>
  </div>
@endif --}}