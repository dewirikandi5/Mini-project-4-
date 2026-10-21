@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('content')
<h1 class="h3 mb-3">Tambah Produk</h1>
<form method="POST" action="{{ route('products.store') }}">
    @include('products._form')
</form>
@endsection
