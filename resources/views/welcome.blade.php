@php($title = 'Inicio')
@extends('layouts.app')

@section('content')
<div class="card" style="padding:0; overflow:hidden; border:none; box-shadow:none; background:transparent;">
  <div style="background: linear-gradient(135deg, #2563eb 0%, #22c55e 100%); border-radius:14px; padding:36px; color:#fff; position:relative;">
    <div style="position:absolute; inset:0; background:radial-gradient(1200px 200px at -10% -20%, rgba(255,255,255,.15), transparent), radial-gradient(900px 200px at 110% 120%, rgba(255,255,255,.12), transparent);"></div>
    <div style="position:relative; z-index:1; display:flex; gap:28px; align-items:center; flex-wrap:wrap; justify-content:space-between;">
      <div style="flex:1 1 420px; min-width:320px;">
        <div style="display:inline-block; background:rgba(255,255,255,.18); padding:6px 10px; border-radius:999px; font-size:12px; margin-bottom:12px;">Tu farmacia en línea</div>
        <h1 style="margin:0 0 6px 0; font-size:36px; line-height:1.15;">Bienvenido a GenFarma</h1>
        <p style="margin:0; opacity:.95; font-size:16px;">Compra medicamentos y productos de salud de forma rápida y segura, con seguimiento de pedidos y recibo en PDF.</p>

        <div class="space"></div>
        @guest
          <div class="row" style="gap:12px;">
            <a class="btn" href="{{ route('login') }}" style="background:#fff; color:#2563eb;">Iniciar sesión</a>
            <a class="btn btn-outline" href="{{ route('register') }}" style="background:transparent; color:#fff; border-color:rgba(255,255,255,.5);">Crear cuenta</a>
          </div>
        @else
          <div class="row" style="gap:12px;">
            <a class="btn" href="{{ route('productos.index') }}" style="background:#fff; color:#2563eb;">Ver productos</a>
            <a class="btn btn-outline" href="{{ route('carrito.index') }}" style="background:transparent; color:#fff; border-color:rgba(255,255,255,.5);">Ir al carrito</a>
            @if(auth()->user()->isAdmin())
              <a class="btn btn-outline" href="{{ route('admin.productos.create') }}" style="background:transparent; color:#fff; border-color:rgba(255,255,255,.5);">Panel Admin</a>
            @endif
          </div>
        @endguest
      </div>

      <div style="flex:1 1 340px; min-width:280px;">
        <div class="row" style="gap:12px; flex-wrap:wrap;">
          <div style="flex:1 1 160px; background:rgba(255,255,255,.15); padding:14px; border-radius:12px;">
            <div style="font-weight:700;">Envío Rápido</div>
            <div style="opacity:.9; font-size:13px;">A todo el país</div>
          </div>
          <div style="flex:1 1 160px; background:rgba(255,255,255,.15); padding:14px; border-radius:12px;">
            <div style="font-weight:700;">Compra Segura</div>
            <div style="opacity:.9; font-size:13px;">Pagos protegidos</div>
          </div>
          <div style="flex:1 1 160px; background:rgba(255,255,255,.15); padding:14px; border-radius:12px;">
            <div style="font-weight:700;">Soporte</div>
            <div style="opacity:.9; font-size:13px;">7 días / semana</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="space"></div>

<div class="card">
  <div class="row" style="justify-content:space-between; align-items:center;">
    <h2 class="wrap-title" style="margin:0;">Productos destacados</h2>
    <a class="btn btn-outline" href="{{ route('productos.index') }}">Ver todo</a>
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
        <div style="font-weight:700; color:#16a34a;">COP $ {{ number_format($p->precio, 0, ',', '.') }}</div>
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

