<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        
        // CORRECCIÓN 1: Usar where() en lugar de whereColumn() para comparar con valor fijo
        $lowStockProducts = Product::where('stock', '<', 5)->count();
        
        // CORRECCIÓN 2: Si realmente necesitas comparar con min_stock, primero verifica si existe
        $lowStockItems = [];
        if (\Schema::hasColumn('products', 'min_stock')) {
            $lowStockItems = Product::whereColumn('stock', '<', 'min_stock')
                                  ->orderBy('stock', 'asc')
                                  ->limit(5)
                                  ->get();
        } else {
            // Fallback: productos con menos de 5 unidades
            $lowStockItems = Product::where('stock', '<', 5)
                                  ->orderBy('stock', 'asc')
                                  ->limit(5)
                                  ->get();
        }

        $monthlySales = $this->getMonthlySales();
        $monthlyExpenses = $this->getMonthlyExpenses();
        $categoriesDistribution = $this->getCategoriesDistribution();

        return view('dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'monthlySales',
            'monthlyExpenses',
            'categoriesDistribution',
            'lowStockItems'
        ));
    }

    private function getMonthlySales()
    {
        return [
            'current' => 245580,
            'previous' => 226780,
            'change' => 8.3
        ];
    }

    private function getMonthlyExpenses()
    {
        return [
            'current' => 45230,
            'previous' => 46200,
            'change' => -2.1
        ];
    }

    private function getCategoriesDistribution()
    {
        return [
            'Electrónica' => 35,
            'Oficina' => 25,
            'Hogar' => 20,
            'Alimentos' => 20
        ];
    }
}