@php($title = 'Agregar producto')
@extends('layouts.app')

@section('content')
<h1 style="margin-top:0;">Agregar producto</h1>

@if($errors->any())
  <div class="card" style="border-left:4px solid #b91c1c;">{{ $errors->first() }}</div>
  <div class="space"></div>
@endif

<div class="card">
  <form method="POST" action="{{ route('admin.productos.store') }}" enctype="multipart/form-data">
    @include('admin.products._form')
  </form>
</div>
@endsection

