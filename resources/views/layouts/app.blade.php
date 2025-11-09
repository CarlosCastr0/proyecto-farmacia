<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Farmacia' }}</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; margin:0; background:#f6f7fb; color:#111; }
        header, footer { background:#fff; border-bottom:1px solid #e5e7eb; }
        header .wrap, main .wrap { max-width:960px; margin:0 auto; padding:16px; }
        a { color:#2563eb; text-decoration:none; }
        .card { background:#fff; padding:20px; border-radius:8px; box-shadow:0 1px 2px rgba(0,0,0,0.06); }
        .row { display:flex; gap:16px; align-items:center; }
        .space { height:16px; }
        nav a { margin-right:12px; }
        .btn { background:#2563eb; color:#fff; padding:10px 14px; border-radius:6px; display:inline-block; }
        .btn-outline { background:#fff; color:#111; border:1px solid #d1d5db; }
        .error { color:#b91c1c; font-size:14px; }
        label { display:block; font-weight:600; margin-bottom:6px; }
        input { width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; }
    </style>
    @stack('head')
    @yield('head')
</head>
<body>
<header>
  <div class="wrap row" style="justify-content:space-between;">
    <div>
      <a href="/" class="row"><strong>🏥 Farmacia</strong></a>
    </div>
    <nav>
      <a href="/productos">Productos</a>
      @auth
        @if(auth()->user()->isAdmin())
          <a href="{{ route('admin.productos.create') }}">Admin</a>
        @endif
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
          @csrf
          <button class="btn btn-outline" type="submit">Salir</button>
        </form>
      @else
        <a class="btn btn-outline" href="{{ route('login') }}">Entrar</a>
        <a class="btn" href="{{ route('register') }}">Registrarse</a>
      @endauth
    </nav>
  </div>
</header>

<main>
  <div class="wrap">
    @yield('content')
  </div>
</main>

</body>
</html>
