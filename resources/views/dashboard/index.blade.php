@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-4">Dashboard</h1>
    </div>
</div>

<!-- Estadísticas principales -->
<div class="row mb-4">
    <div class="col-md-3">
        @include('components.stats-card', [
            'title' => 'Total Productos',
            'value' => $totalProducts ?? 0,
            'icon' => 'bi bi-box-seam',
            'bg' => 'bg-primary'
        ])
    </div>
    <div class="col-md-3">
        @include('components.stats-card', [
            'title' => 'Productos con Stock Bajo',
            'value' => $lowStockCount ?? 0,
            'icon' => 'bi bi-exclamation-triangle',
            'bg' => 'bg-warning'
        ])
    </div>
    <div class="col-md-3">
        @include('components.stats-card', [
            'title' => 'Movimientos Hoy',
            'value' => $movementsToday ?? 0,
            'icon' => 'bi bi-arrow-left-right',
            'bg' => 'bg-info'
        ])
    </div>
    <div class="col-md-3">
        @include('components.stats-card', [
            'title' => 'Valor Total Inventario',
            'value' => '$' . number_format($totalValue ?? 0, 2),
            'icon' => 'bi bi-cash',
            'bg' => 'bg-success'
        ])
    </div>
</div>

<!-- Gráfica de movimientos recientes (placeholder) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Movimientos Recientes</h5>
            </div>
            <div class="card-body">
                <canvas id="movementsChart" width="400" height="200"></canvas>
                <!-- Placeholder: integrar Chart.js aquí -->
                <p class="text-muted mt-2">Gráfica de compras vs ventas (últimos 7 días)</p>
            </div>
        </div>
    </div>
</div>

<!-- Productos con stock bajo -->
@if(isset($lowStockProducts) && $lowStockProducts->isNotEmpty())
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Productos con Stock Bajo</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($lowStockProducts as $product)
                        <div class="col-md-4 mb-3">
                            @include('components.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('products.index', ['filter' => 'low']) }}" class="btn btn-outline-primary">Ver todos</a>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ejemplo simple de gráfica (ajusta con datos reales)
    const ctx = document.getElementById('movementsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Compras',
                data: [12, 19, 3, 5, 2, 3, 9],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }, {
                label: 'Ventas',
                data: [2, 3, 20, 5, 1, 4, 7],
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Movimientos Semanales'
                }
            }
        }
    });
</script>
@endpush
@endsection