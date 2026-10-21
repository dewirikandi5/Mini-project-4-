@extends('layouts.app')
@section('title', 'Supplier')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Supplier</h1>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Tambah</a>
</div>
<div class="table-responsive">
<table class="table table-bordered bg-white">
    <thead><tr><th>Nama</th><th>Telepon</th><th>Email</th><th>Produk</th><th style="width:160px">Aksi</th></tr></thead>
    <tbody>
    @forelse ($suppliers as $s)
        <tr>
            <td>{{ $s->name }}</td><td>{{ $s->phone }}</td><td>{{ $s->email }}</td><td>{{ $s->products_count }}</td>
            <td>
                <a href="{{ route('suppliers.edit', $s) }}" class="btn btn-sm btn-warning">Edit</a>
                <form method="POST" action="{{ route('suppliers.destroy', $s) }}" class="d-inline" onsubmit="return confirm('Hapus supplier ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center">Belum ada supplier.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $suppliers->links() }}
@endsection
