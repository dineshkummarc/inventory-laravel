<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->paginate(10);
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|unique:products'
        ]);
    
        Product::create($validated);
    
        return redirect()->route('products.index')
                       ->with('success', 'Producto creado exitosamente!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all(); // Añade esta línea
        return view('products.edit', compact('product', 'categories')); // Añade categories aquí
    }
    
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|unique:products,barcode,'.$product->id
        ]);
        
        $product->update($validated);
        
        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado correctamente');
    }
    
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('products.index')
                ->with('success', 'Producto eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'No se pudo eliminar el producto: ' . $e->getMessage());
        }
    }
}