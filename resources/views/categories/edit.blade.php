@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('content')
<h1 class="h3 mb-3">Edit Kategori</h1>
<form method="POST" action="{{ route('categories.update', $category) }}">
    @method('PUT')
    @include('categories._form')
</form>
@endsection
