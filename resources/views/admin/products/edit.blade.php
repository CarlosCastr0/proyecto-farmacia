@php($title = 'Editar producto')
@extends('layouts.app')

@section('content')
<h1 style="margin-top:0;">Editar producto</h1>

@if($errors->any())
  <div class="card" style="border-left:4px solid #b91c1c;">{{ $errors->first() }}</div>
  <div class="space"></div>
@endif

<div class="card">
  <form method="POST" action="{{ route('admin.productos.update', ['producto' => $product]) }}" enctype="multipart/form-data">
    @method('PUT')
    @include('admin.products._form', ['product' => $product])
  </form>
</div>
@endsection
