@php($title = 'Recibo #'.$venta->id)
@extends('layouts.app')

@section('content')
  <div class="card">
    <h1 style="margin-top:0;">Recibo de compra #{{ $venta->id }}</h1>
    <p>Fecha: {{ $venta->created_at->format('d/m/Y H:i') }}</p>
    <p>Método de pago: {{ ucfirst($venta->metodo_pago) }} | Estado: {{ ucfirst($venta->estado) }}</p>

    <table style="width:100%; border-collapse:collapse;">
      <thead>
        <tr>
          <th style="text-align:left; border-bottom:1px solid #e5e7eb; padding:6px;">Producto</th>
          <th style="text-align:right; border-bottom:1px solid #e5e7eb; padding:6px;">Cantidad</th>
          <th style="text-align:right; border-bottom:1px solid #e5e7eb; padding:6px;">Subtotal (COP $)</th>
        </tr>
      </thead>
      <tbody>
        @foreach($venta->detalles as $d)
          <tr>
            <td style="padding:6px;">{{ $d->product->nombre ?? 'Producto eliminado' }}</td>
            <td style="text-align:right; padding:6px;">{{ $d->cantidad }}</td>
            <td style="text-align:right; padding:6px;">{{ number_format($d->subtotal, 0, ',', '.') }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td></td>
          <td style="text-align:right; padding:6px;"><strong>Total</strong></td>
          <td style="text-align:right; padding:6px;"><strong>{{ number_format($venta->total, 0, ',', '.') }}</strong></td>
        </tr>
      </tfoot>
    </table>
  </div>
@endsection

