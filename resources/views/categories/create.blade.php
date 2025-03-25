{{-- categories/create.blade.php y categories/edit.blade.php --}}
@extends('layouts.app')

@section('title', isset($category) ? 'Editar Categoría' : 'Crear Nueva Categoría')

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
        transition: all 0.2s;
    }
    
    .invalid-feedback {
        font-size: 0.85rem;
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
                        <i class="bi bi-tag me-2"></i>
                        {{ isset($category) ? 'Editar Categoría' : 'Nueva Categoría' }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
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
                    <form method="POST" 
                          action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}">
                        @csrf
                        @isset($category) @method('PUT') @endisset

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Nombre -->
                                <div class="mb-4">
                                    <label class="form-label required">Nombre de la Categoría</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           name="name" 
                                           value="{{ old('name', $category->name ?? '') }}" 
                                           placeholder="Ej: Electrónica" 
                                           required 
                                           autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Descripción -->
                                <div class="mb-4">
                                    <label class="form-label">Descripción</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              name="description" 
                                              rows="4"
                                              placeholder="Agrega una descripción opcional">{{ old('description', $category->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                {{ isset($category) ? 'Actualizar' : 'Guardar' }} Categoría
                            </button>
                            <button type="reset" class="btn btn-outline-secondary ms-2">
                                <i class="bi bi-eraser me-1"></i> Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación básica del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const nameInput = this.elements.name;
            
            if (nameInput.value.trim() === '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Campo requerido',
                    text: 'El nombre de la categoría es obligatorio',
                    confirmButtonColor: '#45247b'
                });
                nameInput.focus();
            }
        });
    });
</script>
@endpush