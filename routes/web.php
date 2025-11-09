<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\VentaController;
use App\Models\Product;

Route::get('/', function () {
    $destacados = Product::orderByDesc('id')->limit(8)->get();
    return view('welcome', compact('destacados'));
});

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

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
// Enlaza {producto} al modelo Product para rutas resource en español
Route::model('producto', Product::class);
