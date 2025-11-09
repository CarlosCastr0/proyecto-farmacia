@php($title = 'Registrarse')
@extends('layouts.app')

@section('content')
<div class="card" style="max-width:420px; margin:32px auto;">
  <h1 style="margin-top:0;">Crear cuenta</h1>

  @if($errors->any())
    <div class="error" style="margin-bottom:12px;">
      {{ $errors->first() }}
    </div>
  @endif

  <form method="POST" action="{{ route('register.store') }}">
    @csrf

    <div class="space"></div>
    <label for="name">Nombre</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @error('name')<div class="error">{{ $message }}</div>@enderror

    <div class="space"></div>
    <label for="email">Correo electrónico</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    @error('email')<div class="error">{{ $message }}</div>@enderror

    <div class="space"></div>
    <label for="password">Contraseña</label>
    <input id="password" type="password" name="password" required>
    @error('password')<div class="error">{{ $message }}</div>@enderror

    <div class="space"></div>
    <label for="password_confirmation">Confirmar contraseña</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>

    <div class="space"></div>
    <button type="submit" class="btn" style="width:100%;">Registrarse</button>
  </form>

  <div class="space"></div>
  <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
</div>
@endsection

