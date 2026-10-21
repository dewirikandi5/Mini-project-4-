@extends('layouts.app')
@section('title', 'Transaksi Stok')
@section('content')
<h1 class="h3 mb-3">Barang {{ $type === 'in' ? 'Masuk' : 'Keluar' }}</h1>
<form method="POST" action="{{ route('stock.store') }}">
    @csrf
    <input type="hidden" name="type" value="{{ $type }}">
    <div class="mb-3">
        <label class="form-label">Produk</label>
        <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
            <option value="">-- pilih --</option>
            @foreach ($products as $p)
                <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>{{ $p->sku }} - {{ $p->name }} (stok {{ $p->stock }})</option>
            @endforeach
        </select>
        @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Jumlah</label>
        <input name="quantity" type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
        @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Catatan</label>
        <input name="note" class="form-control @error('note') is-invalid @enderror" value="{{ old('note') }}">
        @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('stock.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
