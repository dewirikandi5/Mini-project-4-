@extends('layouts.app')
@section('title', 'Edit Supplier')
@section('content')
<h1 class="h3 mb-3">Edit Supplier</h1>
<form method="POST" action="{{ route('suppliers.update', $supplier) }}">
    @method('PUT')
    @include('suppliers._form')
</form>
@endsection
