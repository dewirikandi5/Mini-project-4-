<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Allowlist: nilai dari pengguna tidak pernah dipakai langsung sebagai nama kolom.
        $sort = in_array($request->sort, ['name', 'price', 'stock'], true) ? $request->sort : 'name';
        $dir = $request->direction === 'desc' ? 'desc' : 'asc';

        $products = Product::with('category')
            ->when($request->search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->category_id, fn ($q, $id) => $q->where('category_id', $id))
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'sort', 'dir'));
    }

    public function create()
    {
        return view('products.create', [
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules() + [
            'sku' => ['required', 'max:50', 'unique:products,sku'],
            'stock' => ['required', 'integer', 'min:0'], // stok awal; selanjutnya lewat transaksi stok
        ]);

        $product = Product::create($validated);
        $product->suppliers()->sync($request->input('supplier_ids', []));

        return redirect()->route('products.index')->with('success', 'Produk berhasil disimpan.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'suppliers', 'stockMovements' => fn ($q) => $q->latest()->limit(10)]);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product->load('suppliers'),
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        // Stok tidak diubah di sini agar histori tetap konsisten.
        $validated = $request->validate($this->rules() + [
            'sku' => ['required', 'max:50', 'unique:products,sku,' . $product->id],
        ]);

        $product->update($validated);
        $product->suppliers()->sync($request->input('supplier_ids', []));

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->stockMovements()->exists()) {
            return back()->with('error', 'Produk memiliki histori stok dan tidak dapat dihapus.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'max:150'],
            'price' => ['required', 'numeric', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'supplier_ids' => ['nullable', 'array'],
            'supplier_ids.*' => ['exists:suppliers,id'],
        ];
    }
}
