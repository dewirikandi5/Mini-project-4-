@extends('layouts.app')
@section('title', 'Transaksi Stok')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Transaksi Stok</h1>
    <div>
        <a href="{{ route('stock.create', ['type' => 'in']) }}" class="btn btn-success">Barang Masuk</a>
        <a href="{{ route('stock.create', ['type' => 'out']) }}" class="btn btn-danger">Barang Keluar</a>
    </div>
</div>
<div class="mb-3">
    <a href="{{ route('stock.index') }}" class="btn btn-sm btn-outline-secondary">Semua</a>
    <a href="{{ route('stock.index', ['type' => 'in']) }}" class="btn btn-sm btn-outline-success">Masuk</a>
    <a href="{{ route('stock.index', ['type' => 'out']) }}" class="btn btn-sm btn-outline-danger">Keluar</a>
</div>
<div class="table-responsive">
<table class="table table-bordered bg-white">
    <thead><tr><th>Waktu</th><th>Produk</th><th>Jenis</th><th>Jumlah</th><th>Catatan</th><th>User</th></tr></thead>
    <tbody>
    @forelse ($movements as $m)
        <tr>
            <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $m->product->name }}</td>
            <td>{{ $m->type === 'in' ? 'Masuk' : 'Keluar' }}</td>
            <td>{{ $m->quantity }}</td>
            <td>{{ $m->note }}</td>
            <td>{{ $m->user->name ?? '-' }}</td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center">Belum ada transaksi.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $movements->links() }}
@endsection
