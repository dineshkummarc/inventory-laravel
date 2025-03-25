<?php

namespace App\Http\Controllers;

// Importaciones necesarias
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['user', 'items.product'])->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_date' => 'required|date',
            'customer_name' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);
    
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'sale_date' => $validated['sale_date'],
                'customer_name' => $validated['customer_name'],
                'total' => 0,
                'notes' => $validated['notes'] ?? null,
                'user_id' => auth()->id()
            ]);
    
            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Verificar stock nuevamente por seguridad
                if ($item['quantity'] > $product->stock) {
                    throw new \Exception("Stock insuficiente para {$product->name}");
                }
                
                $saleItem = $sale->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price
                ]);
                
                $total += $saleItem->quantity * $saleItem->unit_price;
                $product->decrement('stock', $item['quantity']);
            }
    
            $sale->update(['total' => $total]);
            
            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Venta registrada correctamente');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['items.product', 'user']);
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        DB::beginTransaction();
        try {
            foreach ($sale->items as $item) {
                $product = Product::find($item->product_id);
                if($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
            
            $sale->delete();
            DB::commit();
            
            return redirect()->route('sales.index')->with('success', 'Venta eliminada correctamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }
}