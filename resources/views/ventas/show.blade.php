@php($title = 'Compra #'.$venta->id)
@extends('layouts.app')

@section('content')
<h1 style="margin-top:0;">Compra #{{ $venta->id }}</h1>

@if(session('status'))
  <div class="card" style="border-left:4px solid #16a34a;">{{ session('status') }}</div>
  <div class="space"></div>
@endif

<div class="card">
  <div class="row" style="justify-content:space-between;">
    <div>
      <div><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</div>
      <div><strong>Método de pago:</strong> {{ ucfirst($venta->metodo_pago) }}</div>
      <div><strong>Estado:</strong> {{ ucfirst($venta->estado) }}</div>
    </div>
    <div>
      <a class="btn" href="{{ route('ventas.recibo', $venta) }}">Descargar recibo</a>
    </div>
  </div>

  <div class="space"></div>

  <table style="width:100%; border-collapse:collapse;">
    <thead>
      <tr>
        <th style="text-align:left; border-bottom:1px solid #e5e7eb; padding:8px 0;">Producto</th>
        <th style="text-align:right; border-bottom:1px solid #e5e7eb; padding:8px 0;">Cantidad</th>
        <th style="text-align:right; border-bottom:1px solid #e5e7eb; padding:8px 0;">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($venta->detalles as $d)
        <tr>
          <td style="padding:8px 0;">{{ $d->product->nombre ?? 'Producto eliminado' }}</td>
          <td style="text-align:right; padding:8px 0;">{{ $d->cantidad }}</td>
          <td style="text-align:right; padding:8px 0;">COP $ {{ number_format($d->subtotal, 0, ',', '.') }}</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td style="text-align:right; padding-top:8px;"><strong>Total</strong></td>
        <td style="text-align:right; padding-top:8px;"><strong>COP $ {{ number_format($venta->total, 0, ',', '.') }}</strong></td>
      </tr>
    </tfoot>
  </table>
</div>
@endsection

