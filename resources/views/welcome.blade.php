@php($title = 'Inicio')
@extends('layouts.app')

@section('content')
<div class="row" style="align-items:stretch; gap:24px; flex-wrap:wrap;">
  <div class="card" style="flex:1 1 420px;">
    <h1 style="margin-top:0;">Bienvenido a GenFarma</h1>
    <p>Compra medicamentos y productos de salud de forma rápida y segura.</p>

    @guest
      <div class="space"></div>
      <div class="row" style="gap:12px;">
        <a class="btn" href="{{ route('login') }}">Iniciar sesión</a>
        <a class="btn btn-outline" href="{{ route('register') }}">Crear cuenta</a>
      </div>
    @else
      <div class="space"></div>
      <div class="row" style="gap:12px;">
        <a class="btn" href="{{ route('productos.index') }}">Ver productos</a>
        <a class="btn btn-outline" href="{{ route('carrito.index') }}">Ir al carrito</a>
        @if(auth()->user()->isAdmin())
          <a class="btn btn-outline" href="{{ route('admin.productos.create') }}">Panel Admin</a>
        @endif
      </div>
    @endguest
  </div>

  <div class="card" style="flex:1 1 260px;">
    <h2 style="margin-top:0;">¿Cómo funciona?</h2>
    <ol style="margin:0; padding-left:18px; line-height:1.8;">
      <li>Explora el catálogo de productos.</li>
      <li>Añade al carrito y confirma tu compra.</li>
      <li>Descarga tu recibo en PDF desde tus ventas.</li>
    </ol>
  </div>
</div>

<div class="space"></div>

<div class="card">
  <div class="row" style="justify-content:space-between; align-items:center;">
    <h2 style="margin:0;">Productos destacados</h2>
    <a href="{{ route('productos.index') }}">Ver todo</a>
  </div>
  <div class="space"></div>
  <div class="row" style="flex-wrap:wrap; gap:16px;">
    @forelse(($destacados ?? collect()) as $p)
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
      <p style="margin:0;">Aún no hay productos cargados.</p>
    @endforelse
  </div>
</div>
@endsection
