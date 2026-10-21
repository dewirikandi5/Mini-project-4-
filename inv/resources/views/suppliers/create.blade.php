@extends('layouts.app')
@section('title', 'Tambah Supplier')
@section('content')
<h1 class="h3 mb-3">Tambah Supplier</h1>
<form method="POST" action="{{ route('suppliers.store') }}">
    @include('suppliers._form')
</form>
@endsection
