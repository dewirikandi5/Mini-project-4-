@extends('layouts.app')
@section('title', $product->name)
@section('content')
<h1 class="h3">{{ $product->name }}</h1>
<dl class="row">
    <dt class="col-sm-3">SKU</dt><dd class="col-sm-9">{{ $product->sku }}</dd>
    <dt class="col-sm-3">Kategori</dt><dd class="col-sm-9">{{ $product->category->name }}</dd>
    <dt class="col-sm-3">Harga</dt><dd class="col-sm-9">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
    <dt class="col-sm-3">Stok</dt><dd class="col-sm-9">{{ $product->stock }} (minimum {{ $product->minimum_stock }})</dd>
    <dt class="col-sm-3">Supplier</dt><dd class="col-sm-9">{{ $product->suppliers->pluck('name')->join(', ') ?: '-' }}</dd>
</dl>
<h2 class="h5">Histori Stok (10 terakhir)</h2>
<ul>
@forelse ($product->stockMovements as $m)
    <li>{{ $m->created_at->format('d/m/Y H:i') }} - {{ $m->type === 'in' ? 'Masuk' : 'Keluar' }} {{ $m->quantity }}</li>
@empty
    <li>Belum ada histori.</li>
@endforelse
</ul>
<a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
