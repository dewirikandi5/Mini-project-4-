@extends('layouts.app')
@section('title', 'Produk')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Daftar Produk</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah</a>
</div>

<form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-3">
    <div class="col-md-4"><input name="search" class="form-control" placeholder="Cari nama / SKU" value="{{ request('search') }}"></div>
    <div class="col-md-3">
        <select name="category_id" class="form-select">
            <option value="">Semua kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="sort" class="form-select">
            <option value="name" @selected($sort === 'name')>Nama</option>
            <option value="price" @selected($sort === 'price')>Harga</option>
            <option value="stock" @selected($sort === 'stock')>Stok</option>
        </select>
    </div>
    <div class="col-md-2">
        <select name="direction" class="form-select">
            <option value="asc" @selected($dir === 'asc')>ASC</option>
            <option value="desc" @selected($dir === 'desc')>DESC</option>
        </select>
    </div>
    <div class="col-md-1 d-grid"><button class="btn btn-outline-primary">Cari</button></div>
</form>

<div class="table-responsive">
<table class="table table-bordered bg-white">
    <thead><tr><th>SKU</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th style="width:210px">Aksi</th></tr></thead>
    <tbody>
    @forelse ($products as $p)
        <tr>
            <td>{{ $p->sku }}</td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->category->name }}</td>
            <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
            <td>{{ $p->stock }}</td>
            <td>
                <a href="{{ route('products.show', $p) }}" class="btn btn-sm btn-info">Detail</a>
                <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a>
                <form method="POST" action="{{ route('products.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center">Belum ada produk.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $products->links() }}
@endsection
