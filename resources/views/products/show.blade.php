@php($title = $product->nombre)
@extends('layouts.app')

@section('content')
<div class="row" style="gap:24px; align-items:flex-start; flex-wrap:wrap;">
  <div class="card" style="flex:0 1 360px; max-width:420px;">
    <div style="height:260px; background:#f3f4f6; display:flex; align-items:center; justify-content:center; border-radius:6px;">
      @if($product->imagen)
        <img src="{{ asset('storage/'.$product->imagen) }}" alt="{{ $product->nombre }}" style="max-height:100%; max-width:100%;">
      @else
        <span>Sin imagen</span>
      @endif
    </div>
  </div>

  <div class="card" style="flex:1 1 360px;">
    @if(session('status'))
      <div class="card" style="border-left:4px solid #16a34a;">{{ session('status') }}</div>
      <div class="space"></div>
    @endif

    <h1 style="margin-top:0;">{{ $product->nombre }}</h1>
    <div>COP $ {{ number_format($product->precio, 0, ',', '.') }}</div>
    <div style="font-size:13px; color:#6b7280;">Stock: {{ $product->stock }}</div>
    <div class="space"></div>
    <p style="white-space:pre-line;">{{ $product->descripcion }}</p>

    @auth
      @if(auth()->user()->isAdmin())
        <div class="space"></div>
        <div class="row" style="gap:8px;">
          <a class="btn btn-outline" href="{{ route('admin.productos.edit', ['producto' => $product]) }}">Editar</a>
          <form method="POST" action="{{ route('admin.productos.destroy', ['producto' => $product]) }}" onsubmit="return confirm('¿Eliminar producto?');">
            @csrf
            @method('DELETE')
            <button class="btn" style="background:#b91c1c;">Eliminar</button>
          </form>
        </div>
      @endif
    @endauth
  </div>
</div>
@endsection
