@php($title = 'Dashboard')
@extends('layouts.app')

@section('content')
<h1 style="margin-top:0;">Dashboard de Ventas (últimos 30 días)</h1>

<div class="space"></div>

<div class="row" style="flex-wrap:wrap; gap:16px;">
  <div class="card" style="flex:1 1 420px;">
    <h3 style="margin-top:0;">Ventas por día</h3>
    <canvas id="ventasPorDia" height="140"></canvas>
  </div>
  <div class="card" style="flex:1 1 420px;">
    <h3 style="margin-top:0;">Top productos por unidades</h3>
    <canvas id="topProductos" height="140"></canvas>
  </div>
</div>

<div class="space"></div>

<div class="card">
  <h3 style="margin-top:0;">Stock bajo</h3>
  <ul style="margin:0; padding-left:18px; line-height:1.9;">
    @forelse($bajoStock as $p)
      <li>{{ $p->nombre }} — stock: {{ $p->stock }}</li>
    @empty
      <li>Sin alertas de stock.</li>
    @endforelse
  </ul>
</div>

@push('head')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

<script>
  const ventasData = @json($ventasPorDia->map(fn($v) => [\Carbon\Carbon::parse($v->fecha)->format('d/m'), (float) $v->monto, (int) $v->ventas]));
  const ventasLabels = ventasData.map(v => v[0]);
  const ventasMontos = ventasData.map(v => v[1]);
  const ventasConteo = ventasData.map(v => v[2]);

  const ctx1 = document.getElementById('ventasPorDia').getContext('2d');
  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: ventasLabels,
      datasets: [
        { label: 'Monto (COP $)', data: ventasMontos, backgroundColor: 'rgba(37,99,235,0.5)', borderColor: '#2563eb', borderWidth: 1 },
        { label: 'Ventas', data: ventasConteo, type: 'line', borderColor: '#16a34a', backgroundColor: 'rgba(22,163,74,0.2)', yAxisID: 'y1' }
      ]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true },
        y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } }
      }
    }
  });

  const topLabels = @json($topProductos->pluck('product.nombre'));
  const topUnidades = @json($topProductos->pluck('unidades')->map(fn($u) => (int)$u));
  const ctx2 = document.getElementById('topProductos').getContext('2d');
  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: topLabels,
      datasets: [{ label: 'Unidades vendidas', data: topUnidades, backgroundColor: 'rgba(99,102,241,0.6)', borderColor: '#6366f1', borderWidth: 1 }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
  });
</script>
@endsection

