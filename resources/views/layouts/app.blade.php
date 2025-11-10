<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Farmacia' }}</title>
    <style>
        :root {
            --bg: #f6f7fb;
            --surface: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --primary: #2563eb;
            --primary-600: #1d4ed8;
            --danger: #b91c1c;
            --success: #16a34a;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
            margin: 0; background: var(--bg); color: var(--text);
            -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;
        }

        header { background: var(--surface); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 20; }
        header .wrap, main .wrap { max-width: 1100px; margin: 0 auto; padding: 16px; }
        nav a { margin-right: 14px; color: var(--text); opacity: 0.85; transition: color .2s, opacity .2s; }
        nav a:hover { color: var(--primary); opacity: 1; }
        a { color: var(--primary); text-decoration: none; }

        .card { background: var(--surface); padding: 20px; border-radius: 10px; border: 1px solid var(--border);
                box-shadow: 0 1px 2px rgba(0,0,0,0.04); }
        .card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.06); transition: box-shadow .2s; }

        .row { display: flex; gap: 16px; align-items: center; }
        .space { height: 16px; }

        .btn { background: var(--primary); color: #fff; padding: 10px 14px; border-radius: 8px; display: inline-flex; align-items:center; gap:8px;
               border: 1px solid transparent; transition: background .2s, box-shadow .2s, transform .02s; cursor: pointer; }
        .btn:hover { background: var(--primary-600); box-shadow: 0 6px 16px rgba(37,99,235,0.25); }
        .btn:active { transform: translateY(1px); }
        .btn-outline { background: #fff; color: var(--text); border: 1px solid var(--border); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }
        .btn-danger { background: var(--danger); color: #fff; }

        label { display:block; font-weight: 600; margin-bottom: 6px; }
        input, select, textarea { width: 100%; max-width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; outline: none; background:#fff; color: var(--text); box-sizing: border-box; }
        input:focus, select:focus, textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.15); }

        .error { color: var(--danger); font-size: 14px; }
        .alert { padding: 10px 12px; border-radius: 8px; border: 1px solid var(--border); background: #fff; }
        .alert-success { border-left: 4px solid var(--success); }
        .alert-danger { border-left: 4px solid var(--danger); }

        .table { width:100%; border-collapse: collapse; }
        .table th, .table td { padding: 10px 8px; border-bottom: 1px solid var(--border); }
        .table th { text-align: left; color: var(--muted); font-weight: 600; }

        /* Helpers */
        .justify-between { justify-content: space-between; }
        .items-center { align-items: center; }
        .wrap-title { font-weight: 700; letter-spacing: .2px; }
        /* User chip */
        .user-chip { display:flex; align-items:center; gap:10px; background:#fff; border:1px solid var(--border); padding:6px 10px; border-radius:999px; }
        .user-chip .avatar { width:28px; height:28px; border-radius:50%; background: var(--primary); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; }
        .user-chip .who { line-height:1.05; font-size:12px; }
        .user-chip .who .name { font-weight:700; font-size:12px; }
        .user-chip .who .role { color:var(--muted); font-size:11px; }
    </style>
    @stack('head')
    @yield('head')
</head>
<body>
<header>
  <div class="wrap row" style="justify-content:space-between;">
    <div>
      <a href="/" class="row"><strong>🏥 GenFarma</strong></a>
    </div>
    <nav class="row" style="gap:12px;">
      <a href="/productos">Productos</a>
      @auth
        @php($cartCount = \App\Models\Carrito::where('user_id', auth()->id())->sum('cantidad'))
        <a href="{{ route('carrito.index') }}">Carrito ({{ $cartCount }})</a>
        @if(auth()->user()->isAdmin())
          <a href="{{ route('admin.dashboard') }}">Dashboard</a>
          <a href="{{ route('admin.productos.create') }}">Agregar producto</a>
        @endif
        <a href="{{ route('ventas.index') }}">Mis compras</a>
        <span class="user-chip">
          <span class="avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
          <span class="who">
            <span class="name">{{ auth()->user()->name }}</span><br>
            <span class="role">{{ auth()->user()->isAdmin() ? 'Admin' : 'Usuario' }}</span>
          </span>
        </span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left:6px;">
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
