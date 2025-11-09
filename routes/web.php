<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\VentaController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de catálogo público
Route::resource('productos', ProductController::class)->only(['index', 'show']);

// Rutas de usuario autenticado
Route::middleware(['auth'])->group(function () {
    Route::resource('carrito', CarritoController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('ventas', VentaController::class)->only(['index', 'show', 'store']);
});

// Rutas de administración
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('productos', ProductController::class)->except(['index', 'show']);
});
