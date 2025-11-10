@php($title = 'Mi carrito')
@extends('layouts.app')

@section('content')
<h1 style="margin-top:0;">Mi carrito</h1>

@if(session('status'))
  <div class="card" style="border-left:4px solid #16a34a;">{{ session('status') }}</div>
  <div class="space"></div>
@endif

@if($items->isEmpty())
  <div class="card">Tu carrito está vacío. <a href="{{ route('productos.index') }}">Ver productos</a></div>
@else
  <div class="card">
    <div class="row" style="flex-direction:column; gap:16px;">
      @foreach($items as $item)
        <div class="row" style="gap:16px; align-items:center;">
          <div style="width:90px; height:90px; background:#f3f4f6; display:flex; align-items:center; justify-content:center; border-radius:6px;">
            @if($item->product?->imagen)
              <img src="{{ asset('storage/'.$item->product->imagen) }}" alt="{{ $item->product?->nombre }}" style="max-height:100%; max-width:100%;">
            @else
              <span style="font-size:12px; color:#6b7280;">Sin imagen</span>
            @endif
          </div>
          <div style="flex:1;">
            <a href="{{ route('productos.show', $item->product?->id) }}"><strong>{{ $item->product?->nombre }}</strong></a>
            <div style="color:#6b7280; font-size:13px;">Stock: {{ $item->product?->stock ?? 0 }}</div>
          </div>
          <div style="width:140px;">COP $ {{ number_format($item->product?->precio ?? 0, 0, ',', '.') }}</div>
          <form method="POST" action="{{ route('carrito.update', $item) }}" class="row" style="gap:6px; align-items:center;">
            @csrf
            @method('PUT')
            <input type="number" min="0" max="{{ (int)($item->product?->stock ?? 0) }}" name="cantidad" value="{{ $item->cantidad }}" style="width:80px;">
            <button class="btn btn-outline" type="submit">Actualizar</button>
          </form>
          <form method="POST" action="{{ route('carrito.destroy', $item) }}" onsubmit="return confirm('Eliminar del carrito?');">
            @csrf
            @method('DELETE')
            <button class="btn" style="background:#b91c1c;">Eliminar</button>
          </form>
        </div>
      @endforeach
    </div>
  </div>

  <div class="space"></div>

  <div class="card">
    @if($errors->has('cart'))
      <div class="error" style="margin-bottom:10px;">{{ $errors->first('cart') }}</div>
    @endif
    <form method="POST" action="{{ route('ventas.store') }}" class="row" style="justify-content:space-between; align-items:center; gap:12px;">
      @csrf
      <div><strong>Total:</strong> COP $ {{ number_format($total, 0, ',', '.') }}</div>
      <div class="row" style="gap:10px; align-items:center;">
        <label for="metodo_pago" style="margin:0;">Método de pago</label>
        <select id="metodo_pago" name="metodo_pago" style="padding:8px; border:1px solid #d1d5db; border-radius:6px;">
          <option value="efectivo">Efectivo</option>
          <option value="tarjeta">Tarjeta</option>
          <option value="transferencia">Transferencia</option>
        </select>
        @error('metodo_pago')<div class="error">{{ $message }}</div>@enderror
        <button class="btn" type="submit">Continuar a pagar</button>
      </div>
    </form>
  </div>
@endif
@endsection
