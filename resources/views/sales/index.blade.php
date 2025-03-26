@extends('layouts.app')

@section('title', 'Registro de Ventas')

@section('content')
<style>
    /* Estilos idénticos a la vista de productos */
    :root {
        --primary-color: #45247b;
        --primary-light: #6d4a9e;
        --primary-dark: #2e1957;
    }
    
    .card {
        margin: 20px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        border-radius: 8px;
        border-top: 3px solid var(--primary-color);
    }
    
    .header-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid rgba(0,0,0,.1);
        flex-wrap: wrap;
        gap: 15px;
        background-color: #f9f9f9;
    }
    
    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .btn-primary:hover {
        background-color: var(--primary-light);
        border-color: var(--primary-light);
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    #sales-table thead th {
        background-color: #f5f5f5;
        color: var(--primary-dark);
        font-weight: 600;
        border-bottom: 2px solid var(--primary-color);
    }
    
    #sales-table tbody tr:hover {
        background-color: rgba(69, 36, 123, 0.05);
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        color: var(--primary-color);
        border: 1px solid rgba(69, 36, 123, 0.3);
        transition: all 0.2s;
        background: none;
        padding: 0;
        cursor: pointer;
    }
    
    .action-btn:hover {
        background-color: rgba(69, 36, 123, 0.1);
        color: var(--primary-dark);
    }
    
    .card-header {
        background-color: #f9f9f9;
        border-bottom: 1px solid rgba(0,0,0,.1);
        padding: 15px 20px;
    }
    
    .card-title {
        color: var(--primary-dark);
        font-weight: 600;
    }
    
    .card-footer {
        background-color: #f9f9f9;
        border-top: 1px solid rgba(0,0,0,.1);
    }
    
    .category-badge {
        background-color: var(--primary-light);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85em;
    }
    
    @media (max-width: 768px) {
        .header-toolbar {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-actions {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>

<div class="">
    <div class="card-header">
        <h3 class="card-title">Historial de Ventas</h3>
    </div>
    
    <div class="header-toolbar">
        <div class="header-actions">
            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14"></path>
                    <path d="M5 12h14"></path>
                </svg>
                <span style="margin-left: 5px;">Nueva Venta</span>
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="sales-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Productos</th>
                        <th>Vendedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td></td>
                        <td>{{ $sale->customer_name }}</td>
                        <td>${{ number_format($sale->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="category-badge">{{ $sale->items->sum('quantity') }} productos</span>
                        </td>
                        <td>{{ $sale->user->name }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('sales.show', $sale->id) }}" class="action-btn" title="Ver">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" title="Anular" onclick="return confirm('¿Estás seguro de anular esta venta?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer d-flex justify-content-between">
        <div>Mostrando {{ $sales->firstItem() }} a {{ $sales->lastItem() }} de {{ $sales->total() }} registros</div>
        <div>{{ $sales->links() }}</div>
    </div>
</div>
@endsection