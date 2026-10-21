@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('content')
<h1 class="h3 mb-3">Tambah Kategori</h1>
<form method="POST" action="{{ route('categories.store') }}">
    @include('categories._form')
</form>
@endsection
