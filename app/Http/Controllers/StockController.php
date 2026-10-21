<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $movements = StockMovement::with(['product', 'user'])
            ->when(in_array($request->type, ['in', 'out'], true), fn ($q) => $q->where('type', $request->type))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('stock.index', compact('movements'));
    }

    public function create(Request $request)
    {
        return view('stock.create', [
            'products' => Product::orderBy('name')->get(),
            'type' => $request->type === 'out' ? 'out' : 'in',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:in,out'],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'max:255'],
        ]);

        // Stok dan histori berhasil bersama atau dibatalkan bersama.
        DB::transaction(function () use ($data) {
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);

            if ($data['type'] === 'out' && $data['quantity'] > $product->stock) {
                throw ValidationException::withMessages([
                    'quantity' => "Stok tidak cukup. Stok tersedia: {$product->stock}.",
                ]);
            }

            $product->stock += $data['type'] === 'in' ? $data['quantity'] : -$data['quantity'];
            $product->save();

            StockMovement::create($data + ['user_id' => auth()->id()]);
        });

        return redirect()->route('stock.index')->with('success', 'Transaksi stok berhasil dicatat.');
    }
}
