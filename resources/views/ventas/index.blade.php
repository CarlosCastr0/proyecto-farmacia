@php($title = 'Mis compras')
@extends('layouts.app')

@section('content')
<h1 style="margin-top:0;">Mis compras</h1>

@if(session('status'))
  <div class="card" style="border-left:4px solid #16a34a;">{{ session('status') }}</div>
  <div class="space"></div>
@endif

<div class="card">
  @forelse($ventas as $v)
    <div class="row" style="justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #eee;">
      <div>
        <strong>#{{ $v->id }}</strong> — {{ $v->created_at->format('d/m/Y H:i') }} — Estado: {{ ucfirst($v->estado) }}
      </div>
      <div>
        <strong>Total:</strong> COP $ {{ number_format($v->total, 0, ',', '.') }}
        <a class="btn btn-outline" href="{{ route('ventas.show', $v) }}" style="margin-left:8px;">Ver</a>
      </div>
    </div>
  @empty
    <p style="margin:0;">Aún no tienes compras.</p>
  @endforelse
</div>

<div class="space"></div>
{{ $ventas->links() }}
@endsection

