@extends('layouts.app')

@section('title', 'Nueva Venta')

@section('content')
<style>
    :root {
        --primary-color: #45247b;
        --primary-light: #6d4a9e;
        --primary-dark: #2e1957;
    }
    
    .page-wrapper {
        background-color: #f8f9fa;
        min-height: calc(100vh - 3.5rem);
        margin-left: 0;
    }
    
    .card {
        margin: 20px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        border-radius: 8px;
        border-top: 3px solid var(--primary-color);
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
    
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .form-label.required:after {
        content: " *";
        color: #dc3545;
    }
    
    .form-control {
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        transition: all 0.2s;
    }
    
    .form-control:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 0.25rem rgba(69, 36, 123, 0.25);
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        padding: 0.5rem 1.5rem;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-light);
        border-color: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(69, 36, 123, 0.2);
    }
    
    .btn-outline-secondary {
        border-radius: 6px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
    }
    
    .product-selector {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: white;
    }
    
    .item-total {
        font-weight: 600;
        color: var(--primary-dark);
    }
    
    #itemsTable thead th {
        background-color: #f5f5f5;
        color: var(--primary-dark);
        font-weight: 600;
        border-bottom: 2px solid var(--primary-color);
    }
    
    #itemsTable tbody tr:hover {
        background-color: rgba(69, 36, 123, 0.05);
    }
    
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        padding: 0.25rem 0.5rem;
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        .product-selector .row {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title mb-0">
        <i class="bi bi-cart-plus me-2"></i>Nueva Venta
    </h3>
    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Volver al listado
    </a>
</div>

    <div class="card-body">
        <form id="saleForm" method="POST" action="{{ route('sales.store') }}">
            @csrf
            
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label required">Fecha y Hora</label>
                        <input type="datetime-local" class="form-control" 
                               name="sale_date" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label required">Cliente</label>
                        <input type="text" class="form-control" 
                               name="customer_name" required>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label required">Productos</label>
                <div class="product-selector">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <select class="form-select product-select">
                                <option value="">Seleccionar Producto</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                    data-price="{{ $product->price }}"
                                    data-stock="{{ $product->stock }}">
                                    {{ $product->name }} (Stock: {{ $product->stock }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control quantity" 
                                   min="1" value="1" placeholder="Cantidad">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary w-100 add-item">
                                <i class="bi bi-plus-lg me-1"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table" id="itemsTable">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los items se agregarán aquí dinámicamente -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total General:</th>
                                <th id="grandTotal">$0</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Notas</label>
                <textarea class="form-control" name="notes" rows="3"></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-circle me-1"></i> Registrar Venta
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script cargado'); // Verificar carga del script
    
    const items = [];
    const addButton = document.querySelector('.add-item');
    const productSelect = document.querySelector('.product-select');
    const quantityInput = document.querySelector('.quantity');

    console.log('Elementos:', {addButton, productSelect, quantityInput}); // Verificar selección de elementos

    function updateGrandTotal() {
        const total = items.reduce((sum, item) => sum + (item.quantity * item.price), 0);
        document.getElementById('grandTotal').textContent = `$${total.toLocaleString()}`;
    }

    function addItemToTable(product) {
        console.log('Agregando producto:', product); // Depurar producto
        const tbody = document.querySelector('#itemsTable tbody');
        
        // Verificar si el producto ya existe
        const existingItem = items.find(item => item.id === product.id);
        if (existingItem) {
            console.log('Producto existente, actualizando cantidad'); 
            existingItem.quantity += product.quantity;
            const row = document.querySelector(`tr[data-product-id="${product.id}"]`);
            row.querySelector('td:nth-child(2)').textContent = existingItem.quantity;
            row.querySelector('.item-total').textContent = `$${(existingItem.quantity * existingItem.price).toLocaleString()}`;
        } else {
            console.log('Nuevo producto, creando fila');
            const tr = document.createElement('tr');
            tr.dataset.productId = product.id;
            tr.innerHTML = `
                <td>${product.name}</td>
                <td>${product.quantity}</td>
                <td>$${product.price.toLocaleString()}</td>
                <td class="item-total">$${(product.quantity * product.price).toLocaleString()}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item">
                        <i class="bi bi-trash"></i>
                    </button>
                    <input type="hidden" name="items[${items.length}][product_id]" value="${product.id}">
                    <input type="hidden" name="items[${items.length}][quantity]" value="${product.quantity}">
                </td>
            `;
            tbody.appendChild(tr);

            tr.querySelector('.remove-item').addEventListener('click', function() {
                console.log('Eliminando producto:', product.id);
                const index = items.findIndex(item => item.id === product.id);
                items.splice(index, 1);
                tr.remove();
                updateGrandTotal();
            });
        }
        updateGrandTotal();
    }

    addButton.addEventListener('click', function() {
        console.log('Botón clickeado'); // Verificar evento click
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        
        if (!selectedOption.value || !quantityInput.value) {
            alert('Selecciona un producto y cantidad');
            return;
        }

        console.log('Opción seleccionada:', selectedOption);
        
        const product = {
            id: selectedOption.value,
            name: selectedOption.text.split(' (')[0],
            price: parseFloat(selectedOption.dataset.price),
            quantity: parseInt(quantityInput.value),
            stock: parseInt(selectedOption.dataset.stock)
        };

        console.log('Producto parseado:', product); // Verificar datos del producto

        if (product.quantity > product.stock) {
            alert(`Stock insuficiente. Disponible: ${product.stock}`);
            return;
        }

        // Actualizar o agregar item
        const existingIndex = items.findIndex(item => item.id === product.id);
        if (existingIndex > -1) {
            items[existingIndex].quantity += product.quantity;
        } else {
            items.push(product);
        }

        addItemToTable(product);
        
        // Reset campos
        productSelect.value = '';
        quantityInput.value = 1;
        productSelect.focus();
    });

    document.getElementById('saleForm').addEventListener('submit', function(e) {
        if (items.length === 0) {
            e.preventDefault();
            alert('Debes agregar al menos un producto a la venta');
        }
    });
});
</script>
@endpush
@endsection