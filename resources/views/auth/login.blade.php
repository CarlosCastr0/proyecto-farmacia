@php($title = 'Iniciar sesión')
@extends('layouts.app')

@section('content')
<div class="card" style="max-width:420px; margin:32px auto;">
  <h1 style="margin-top:0;">Iniciar sesión</h1>

  @if($errors->any())
    <div class="error" style="margin-bottom:12px;">
      {{ $errors->first() }}
    </div>
  @endif

  <form method="POST" action="{{ route('login.attempt') }}">
    @csrf

    <div class="space"></div>
    <label for="email">Correo electrónico</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @error('email')<div class="error">{{ $message }}</div>@enderror

    <div class="space"></div>
    <label for="password">Contraseña</label>
    <input id="password" type="password" name="password" required>
    @error('password')<div class="error">{{ $message }}</div>@enderror

    <div class="space"></div>
    <label style="display:flex; align-items:center; gap:8px; font-weight:400;">
      <input type="checkbox" name="remember" value="1"> Recordarme
    </label>

    <div class="space"></div>
    <button type="submit" class="btn" style="width:100%;">Entrar</button>
  </form>

  <div class="space"></div>
  <p>¿No tienes cuenta? <a href="{{ route('register') }}">Crear una cuenta</a></p>
</div>
@endsection

