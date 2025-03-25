@extends('layouts.app')

@section('title', 'Editar Producto')

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
    
    .page-title {
        color: var(--primary-dark);
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .page-title i {
        color: var(--primary-color);
    }
    
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .card-body {
        padding: 2rem;
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
    
    .form-control, .form-select {
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        transition: all 0.2s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 0.25rem rgba(69, 36, 123, 0.25);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        color: var(--primary-color);
        font-weight: 500;
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
        transition: all 0.2s;
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .invalid-feedback {
        font-size: 0.85rem;
    }
    
    #scanBarcode {
        transition: all 0.2s;
    }
    
    #scanBarcode:hover {
        background-color: var(--primary-color);
        color: white;
    }
    
    .bi {
        transition: transform 0.2s;
    }
    
    button:hover .bi {
        transform: scale(1.1);
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <i class="bi bi-pencil-square me-2"></i>Editar Producto
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('products.update', $product->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Columna izquierda -->
                            <div class="col-md-6">
                                <!-- Nombre -->
                                <div class="mb-3">
                                    <label class="form-label required">Nombre del Producto</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', $product->name) }}" placeholder="Ej: Laptop HP EliteBook" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Código -->
                                <div class="mb-3">
                                    <label class="form-label">Código/SKU</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                           name="code" value="{{ old('code', $product->code) }}" placeholder="Ej: LP-HP-001">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Categoría -->
                                <div class="mb-3">
                                    <label class="form-label required">Categoría</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                                        <option value="">Seleccione una categoría</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Columna derecha -->
                            <div class="col-md-6">
                                <!-- Precio -->
                                <div class="mb-3">
                                    <label class="form-label required">Precio</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                               name="price" value="{{ old('price', $product->price) }}" placeholder="0.00" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Stock -->
                                <div class="mb-3">
                                    <label class="form-label required">Stock</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                           name="stock" value="{{ old('stock', $product->stock) }}" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Stock Mínimo -->
                                <div class="mb-3">
                                    <label class="form-label required">Stock Mínimo</label>
                                    <input type="number" class="form-control @error('min_stock') is-invalid @enderror" 
                                           name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" required>
                                    @error('min_stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Código de Barras -->
                        <div class="mb-3">
                            <label class="form-label">Código de Barras</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="barcode" id="barcode" 
                                       value="{{ old('barcode', $product->barcode) }}" placeholder="Escanear o ingresar manualmente">
                                <button class="btn btn-outline-secondary" type="button" id="scanBarcode">
                                    <i class="bi bi-upc-scan"></i> Escanear
                                </button>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Actualizar Producto
                            </button>
                            <button type="reset" class="btn btn-outline-secondary ms-2">
                                <i class="bi bi-eraser me-1"></i> Restablecer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación de precio
        document.querySelector('form').addEventListener('submit', function(e) {
            const price = parseFloat(this.elements.price.value);
            if (price <= 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el precio',
                    text: 'El precio debe ser mayor que cero',
                    confirmButtonColor: '#45247b'
                });
            }
        });
        
        // Simulación de escaneo de código de barras
        document.getElementById('scanBarcode').addEventListener('click', function() {
            const randomBarcode = Math.floor(1000000000000 + Math.random() * 9000000000000);
            document.getElementById('barcode').value = randomBarcode;
            
            Swal.fire({
                icon: 'success',
                title: 'Código escaneado',
                text: 'Se ha simulado el escaneo de un código de barras',
                confirmButtonColor: '#45247b'
            });
        });
    });
</script>
@endpush
@endsection