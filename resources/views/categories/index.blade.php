@extends('layouts.app')

@section('title', 'Gestión de Categorías')

@section('content')
<style>
    /* Mantenemos los mismos estilos de productos */
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
    
    .btn-outline-secondary {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }
    
    .btn-outline-secondary:hover {
        background-color: var(--primary-color);
        color: white;
    }
    
    .search-container .input-group {
        width: 300px;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    #categories-table thead th {
        background-color: #f5f5f5;
        color: var(--primary-dark);
        font-weight: 600;
        border-bottom: 2px solid var(--primary-color);
    }
    
    #categories-table tbody tr:hover {
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
        <h3 class="card-title">Listado de Categorías</h3>
    </div>
    
    <!-- Contenedor para botones y búsqueda -->
    <div class="header-toolbar">
        <div class="header-actions">
            <!-- Botón Nueva Categoría -->
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14"></path>
                    <path d="M5 12h14"></path>
                </svg>
                <span style="margin-left: 5px;">Nueva Categoría</span>
            </a>
            
    
  
        </div>
        
        <!-- Barra de búsqueda -->
        <div class="search-container">
            <div class="input-group">
                <input type="text" id="search-input" class="form-control" placeholder="Buscar categorías..." aria-label="Buscar categorías">
                <button class="btn btn-primary" type="button" id="search-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Tabla de categorías -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="categories-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Productos Asociados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr class="category-row">
                        <td class="category-name">{{ $category->name }}</td>
                        <td class="category-description">{{ Str::limit($category->description, 50) }}</td>
                        <td>
                            <span class="category-badge">{{ $category->products_count }} productos</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- Botón Editar -->
                                <a href="{{ route('categories.edit', $category->id) }}" class="action-btn" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                
                                <!-- Botón Eliminar -->
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
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
        <div>Mostrando {{ $categories->firstItem() }} a {{ $categories->lastItem() }} de {{ $categories->total() }} registros</div>
        <div>{{ $categories->links() }}</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');
    const exportBtn = document.getElementById('export-btn');
    const categoryRows = document.querySelectorAll('.category-row');
    
    // Función de búsqueda
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        
        categoryRows.forEach(row => {
            const name = row.querySelector('.category-name').textContent.toLowerCase();
            const description = row.querySelector('.category-description').textContent.toLowerCase();
            
            if (name.includes(searchTerm) || description.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Eventos
    searchInput.addEventListener('input', performSearch);
    searchBtn.addEventListener('click', performSearch);
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
    
    // Mensajes de éxito/error
    @if(session('success'))
        alert('{{ session('success') }}');
    @endif
    
    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
});
</script>
@endsection