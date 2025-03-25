<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories',
            'description' => 'nullable|string|max:500'
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
                       ->with('success', 'Categoría creada exitosamente!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string|max:500'
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
                       ->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
            // Opción 1: Eliminar productos relacionados primero
            // $category->products()->delete();
            
            // Opción 2: Prevent delete si tiene productos
            if($category->products_count > 0) {
                throw new \Exception('No se puede eliminar una categoría con productos asociados');
            }

            $category->delete();
            DB::commit();

            return redirect()->route('categories.index')
                           ->with('success', 'Categoría eliminada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('categories.index')
                           ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}