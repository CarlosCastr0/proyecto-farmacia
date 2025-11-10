<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recibo #{{ $venta->id }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h1 { font-size: 18px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border-bottom: 1px solid #ddd; padding: 6px; text-align: left; }
    tfoot td { border: none; }
  </style>
  </head>
<body>
  <h1>Recibo de compra #{{ $venta->id }}</h1>
  <p>Fecha: {{ $venta->created_at->format('d/m/Y H:i') }}</p>
  <p>Método de pago: {{ ucfirst($venta->metodo_pago) }} | Estado: {{ ucfirst($venta->estado) }}</p>

  <table>
    <thead>
      <tr>
        <th>Producto</th>
        <th style="text-align:right;">Cantidad</th>
        <th style="text-align:right;">Subtotal (COP $)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($venta->detalles as $d)
        <tr>
          <td>{{ $d->product->nombre ?? 'Producto eliminado' }}</td>
          <td style="text-align:right;">{{ $d->cantidad }}</td>
          <td style="text-align:right;">{{ number_format($d->subtotal, 0, ',', '.') }}</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td style="text-align:right;"><strong>Total</strong></td>
        <td style="text-align:right;"><strong>{{ number_format($venta->total, 0, ',', '.') }}</strong></td>
      </tr>
    </tfoot>
  </table>
</body>
</html>

