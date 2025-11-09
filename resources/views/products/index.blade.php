@php($title = 'Productos')
@extends('layouts.app')

@section('content')
<div class="row" style="justify-content:space-between; align-items:center;">
  <h1 style="margin:0;">Productos</h1>
  @auth
    @if(auth()->user()->isAdmin())
      <a class="btn" href="{{ route('admin.productos.create') }}">Agregar producto</a>
    @endif
  @endauth
</div>

<div class="space"></div>

@if(session('status'))
  <div class="card" style="border-left:4px solid #16a34a;">{{ session('status') }}</div>
  <div class="space"></div>
@endif

<div class="row" style="flex-wrap:wrap; gap:16px;">
  @forelse($products as $p)
    <div class="card" style="flex:1 1 200px; max-width:220px;">
      <div style="height:120px; background:#f3f4f6; display:flex; align-items:center; justify-content:center; border-radius:6px;">
        @if($p->imagen)
          <img src="{{ asset('storage/'.$p->imagen) }}" alt="{{ $p->nombre }}" style="max-height:100%; max-width:100%;">
        @else
          <span>Sin imagen</span>
        @endif
      </div>
      <div class="space"></div>
      <strong>{{ $p->nombre }}</strong>
      <div>COP $ {{ number_format($p->precio, 0, ',', '.') }}</div>
      <div style="font-size:13px; color:#6b7280;">Stock: {{ $p->stock }}</div>
      <div class="space"></div>
      <a class="btn" href="{{ route('productos.show', $p) }}">Ver</a>
    </div>
  @empty
    <div class="card">No hay productos disponibles todavía.</div>
  @endforelse
</div>

<div class="space"></div>
{{ $products->links() }}
@endsection
