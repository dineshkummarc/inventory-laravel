@extends('layouts.app')

@section('title', 'Inventario de Productos')

@section('content')
<style>
    /* Estilos generales con tu color corporativo */
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
    
    /* Estilos para el contenedor de herramientas */
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
    
    /* Botones principales */
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .btn-primary:hover {
        background-color: var(--primary-light);
        border-color: var(--primary-light);
    }
    
    .btn-outline-secondary {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }
    
    .btn-outline-secondary:hover {
        background-color: var(--primary-color);
        color: white;
    }
    
    /* Barra de búsqueda */
    .search-container {
        display: flex;
        align-items: center;
    }
    
    .search-container .input-group {
        width: 300px;
    }
    
    .search-container .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    /* Estilos para la tabla */
    .table-responsive {
        overflow-x: auto;
    }
    
    #products-table {
        margin-bottom: 0;
    }
    
    #products-table thead th {
        background-color: #f5f5f5;
        color: var(--primary-dark);
        font-weight: 600;
        border-bottom: 2px solid var(--primary-color);
    }
    
    #products-table tbody tr:hover {
        background-color: rgba(69, 36, 123, 0.05);
    }
    
    /* Estilos para los botones de acción */
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
    
    /* Barra de progreso */
    .progress {
        height: 8px;
        margin-bottom: 6px;
        background-color: #f0f0f0;
        border-radius: 4px;
    }
    
    .progress-bar {
        border-radius: 4px;
    }
    
    /* Badges de estado */
    .badge-success {
        background-color: #28a745;
    }
    
    .badge-danger {
        background-color: #dc3545;
    }
    
    /* Card header */
    .card-header {
        background-color: #f9f9f9;
        border-bottom: 1px solid rgba(0,0,0,.1);
        padding: 15px 20px;
    }
    
    .card-title {
        color: var(--primary-dark);
        font-weight: 600;
    }
    
    /* Footer */
    .card-footer {
        background-color: #f9f9f9;
        border-top: 1px solid rgba(0,0,0,.1);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .header-toolbar {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .search-container .input-group {
            width: 100%;
        }
        
        .header-actions {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>

<!-- Contenido principal -->
<div class="">
    <div class="card-header">
        <h3 class="card-title">Listado de Productos</h3>
    </div>
    
    <!-- Contenedor para botones y búsqueda -->
    <div class="header-toolbar">
        <div class="header-actions">
            <!-- Botón Nuevo Producto -->
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14"></path>
                    <path d="M5 12h14"></path>
                </svg>
                <span style="margin-left: 5px;">Nuevo Producto</span>
            </a>
            
            <!-- Botón Exportar -->
            <a href="#" class="btn btn-outline-secondary" id="export-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
                <span style="margin-left: 5px;">Exportar</span>
            </a>
        </div>
        
        <!-- Barra de búsqueda funcional -->
        <div class="search-container">
            <div class="input-group">
                <input type="text" id="search-input" class="form-control" placeholder="Buscar productos..." aria-label="Buscar productos">
                <button class="btn btn-primary" type="button" id="search-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Tabla de productos -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="products-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="product-row">
                        <td class="product-name">{{ $product->name }}</td>
                        <td class="product-code">{{ $product->code }}</td>
                        <td class="product-price">${{ number_format($product->price, 0, '', '.') }} CLP</td>
                        <td>
                            <div class="progress">
                                @php
                                    $percentage = min(100, ($product->stock / 100) * 100);
                                    $color = $product->stock < 20 ? 'bg-danger' : ($product->stock < 50 ? 'bg-warning' : 'bg-success');
                                @endphp
                                <div class="progress-bar {{ $color }}" style="width: {{ $percentage }}%"></div>
                            </div>
                            <small>{{ $product->stock }} unidades</small>
                        </td>
                        <td>
                            @if($product->stock < 5)
                            <span class="badge badge-danger">Bajo Stock</span>
                            @else
                            <span class="badge badge-success">Disponible</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- Botón Editar -->
                                <a href="{{ route('products.edit', $product->id) }}" class="action-btn" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                
                                <!-- Botón Eliminar -->
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
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
        <div>Mostrando {{ $products->firstItem() }} a {{ $products->lastItem() }} de {{ $products->total() }} registros</div>
        <div>{{ $products->links() }}</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');
    const exportBtn = document.getElementById('export-btn');
    const productRows = document.querySelectorAll('.product-row');
    
    // Función de búsqueda
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        
        productRows.forEach(row => {
            const name = row.querySelector('.product-name').textContent.toLowerCase();
            const code = row.querySelector('.product-code').textContent.toLowerCase();
            const price = row.querySelector('.product-price').textContent.toLowerCase();
            
            if (name.includes(searchTerm) || code.includes(searchTerm) || price.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Evento de búsqueda al escribir
    searchInput.addEventListener('input', performSearch);
    
    // Evento de búsqueda al hacer clic en el botón
    searchBtn.addEventListener('click', performSearch);
    
    // Evento para exportar
    exportBtn.addEventListener('click', function() {
        alert('Función de exportación se activará aquí');
        // Implementación real: window.location.href = '/products/export';
    });
    
    // Permitir búsqueda con Enter
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
    
    // Mostrar mensajes de éxito/error
    @if(session('success'))
        alert('{{ session('success') }}');
    @endif
    
    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
});
</script>
@endsection