@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Kategori</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Tambah</a>
</div>
<div class="table-responsive">
<table class="table table-bordered bg-white">
    <thead><tr><th>Nama</th><th>Jumlah Produk</th><th style="width:160px">Aksi</th></tr></thead>
    <tbody>
    @forelse ($categories as $c)
        <tr>
            <td>{{ $c->name }}</td>
            <td>{{ $c->products_count }}</td>
            <td>
                <a href="{{ route('categories.edit', $c) }}" class="btn btn-sm btn-warning">Edit</a>
                <form method="POST" action="{{ route('categories.destroy', $c) }}" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="3" class="text-center">Belum ada kategori.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $categories->links() }}
@endsection
