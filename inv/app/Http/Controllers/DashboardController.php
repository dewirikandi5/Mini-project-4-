<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'totalProducts' => Product::count(),
            'inventoryValue' => Product::selectRaw('COALESCE(SUM(price * stock), 0) as total')->value('total'),
            'lowStock' => Product::with('category')
                ->whereColumn('stock', '<=', 'minimum_stock')->orderBy('stock')->get(),
            'totalIn' => StockMovement::where('type', 'in')->sum('quantity'),
            'totalOut' => StockMovement::where('type', 'out')->sum('quantity'),
            'recent' => StockMovement::with(['product', 'user'])->latest()->limit(5)->get(),
        ]);
    }
}
