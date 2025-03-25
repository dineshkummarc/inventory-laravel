@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Hoy</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Semana</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Mes</button>
        </div>
    </div>
</div>

<!-- Tarjetas de Métricas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Productos en Stock</h6>
                        <h3 class="mb-0">{{ number_format(1245) }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded">
                        <i class="bi bi-box-seam text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-success"><i class="bi bi-arrow-up"></i> 12.5%</span>
                    <span class="text-muted">vs mes anterior</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Ventas del Mes</h6>
                        <h3 class="mb-0">${{ number_format(245580, 2) }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded">
                        <i class="bi bi-currency-dollar text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-success"><i class="bi bi-arrow-up"></i> 8.3%</span>
                    <span class="text-muted">vs mes anterior</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Productos Bajos</h6>
                        <h3 class="mb-0">24</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-danger"><i class="bi bi-arrow-up"></i> 3.2%</span>
                    <span class="text-muted">vs mes anterior</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-1">Gastos del Mes</h6>
                        <h3 class="mb-0">${{ number_format(45230, 2) }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded">
                        <i class="bi bi-graph-down text-info" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-success"><i class="bi bi-arrow-down"></i> 2.1%</span>
                    <span class="text-muted">vs mes anterior</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0">Ventas Mensuales</h6>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0">Categorías de Productos</h6>
            </div>
            <div class="card-body">
                <canvas id="categoriesChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Productos con stock bajo - Versión manual -->
<div class="card shadow-sm">
    <div class="card-header">
        <h6 class="mb-0">Productos con Stock Bajo</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Código</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ejemplo con datos manuales -->
                    <tr>
                        <td>Laptop HP EliteBook</td>
                        <td>LP-HP-001</td>
                        <td><span class="badge bg-danger">3</span></td>
                        <td>10</td>
                        <td><a href="#" class="btn btn-sm btn-outline-primary">Reabastecer</a></td>
                    </tr>
                    <tr>
                        <td>Mouse Inalámbrico</td>
                        <td>MS-LG-005</td>
                        <td><span class="badge bg-danger">2</span></td>
                        <td>15</td>
                        <td><a href="#" class="btn btn-sm btn-outline-primary">Reabastecer</a></td>
                    </tr>
                    <tr>
                        <td>Teclado Mecánico</td>
                        <td>TK-RB-012</td>
                        <td><span class="badge bg-danger">4</span></td>
                        <td>10</td>
                        <td><a href="#" class="btn btn-sm btn-outline-primary">Reabastecer</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de ventas con datos manuales
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Ventas 2023',
                data: [65000, 59000, 80000, 81000, 56000, 75000, 92000],
                backgroundColor: 'rgba(13, 110, 253, 0.5)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Gráfico de categorías con datos manuales
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    const categoriesChart = new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Electrónica', 'Oficina', 'Hogar', 'Alimentos'],
            datasets: [{
                data: [35, 25, 20, 20],
                backgroundColor: [
                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#fd7e14'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + '%';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection