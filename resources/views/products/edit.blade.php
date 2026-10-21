@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')
<h1 class="h3 mb-3">Edit Produk</h1>
<p class="text-muted">Stok saat ini: {{ $product->stock }} (ubah melalui menu Transaksi Stok).</p>
<form method="POST" action="{{ route('products.update', $product) }}">
    @method('PUT')
    @include('products._form')
</form>
@endsection
