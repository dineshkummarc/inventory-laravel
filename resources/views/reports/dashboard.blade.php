@extends('layouts.app')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Título y Filtros -->
        <div class="row mb-3">
            <div class="col-12">
                <h1 class="h2">Reportes de Inventario</h1>
                <div class="btn-group">
                    <button class="btn">Hoy</button>
                    <button class="btn">7 días</button>
                    <button class="btn">Este mes</button>
                </div>
            </div>
        </div>

        <!-- Cards de Resumen (Estilo GitHub) -->
        <div class="row row-deck row-cards mb-3">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Stock Total</div>
                        </div>
                        <div class="h1 mb-3">{{ $totalStock }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Valor Total</div>
                        </div>
                        <div class="h1 mb-3">${{ number_format($totalValue, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Tendencia (Estilo GitHub Insights) -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Movimientos por Mes</h3>
            </div>
            <div class="card-body">
                <div class="chart-lg">
                    <canvas id="movementsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabla de Movimientos Recientes -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Movimientos Recientes</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentMovements as $movement)
                            <tr>
                                <td>{{ $movement->product->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $movement->type === 'entry' ? 'success' : 'danger' }}">
                                        {{ $movement->type === 'entry' ? 'Entrada' : 'Salida' }}
                                    </span>
                                </td>
                                <td>{{ $movement->quantity }}</td>
                                <td>{{ $movement->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Líneas (Estilo GitHub)
    const ctx = document.getElementById('movementsChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($movements->keys()),
            datasets: [{
                label: 'Movimientos',
                data: @json($movements->values()),
                borderColor: '#2188ff', // Azul de GitHub
                backgroundColor: 'rgba(33, 136, 255, 0.05)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#e1e4e8' } // Gris de GitHub
                },
                x: {
                    grid: { color: '#e1e4e8' }
                }
            }
        }
    });
</script>
@endpush