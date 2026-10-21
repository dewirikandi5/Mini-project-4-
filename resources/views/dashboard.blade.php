@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h1 class="h3 mb-3">Dashboard</h1>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="card"><div class="card-body"><small class="text-muted">Total Produk</small><div class="fs-4">{{ number_format($totalProducts) }}</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card"><div class="card-body"><small class="text-muted">Nilai Inventory</small><div class="fs-4">Rp {{ number_format($inventoryValue, 0, ',', '.') }}</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card"><div class="card-body"><small class="text-muted">Total Barang Masuk</small><div class="fs-4">{{ number_format($totalIn) }}</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card"><div class="card-body"><small class="text-muted">Total Barang Keluar</small><div class="fs-4">{{ number_format($totalOut) }}</div></div></div></div>
</div>

<h2 class="h5">Produk Stok Rendah</h2>
<div class="table-responsive mb-4">
<table class="table table-sm table-bordered bg-white">
    <thead><tr><th>SKU</th><th>Nama</th><th>Kategori</th><th>Stok</th><th>Minimum</th></tr></thead>
    <tbody>
    @forelse ($lowStock as $p)
        <tr><td>{{ $p->sku }}</td><td>{{ $p->name }}</td><td>{{ $p->category->name }}</td><td>{{ $p->stock }}</td><td>{{ $p->minimum_stock }}</td></tr>
    @empty
        <tr><td colspan="5" class="text-center">Tidak ada produk stok rendah.</td></tr>
    @endforelse
    </tbody>
</table>
</div>

<h2 class="h5">Transaksi Terakhir</h2>
<div class="table-responsive">
<table class="table table-sm table-bordered bg-white">
    <thead><tr><th>Waktu</th><th>Produk</th><th>Jenis</th><th>Jumlah</th></tr></thead>
    <tbody>
    @forelse ($recent as $m)
        <tr><td>{{ $m->created_at->format('d/m/Y H:i') }}</td><td>{{ $m->product->name }}</td><td>{{ $m->type === 'in' ? 'Masuk' : 'Keluar' }}</td><td>{{ $m->quantity }}</td></tr>
    @empty
        <tr><td colspan="4" class="text-center">Belum ada transaksi.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@endsection
