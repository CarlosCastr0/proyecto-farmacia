<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $from = now()->subDays(30)->startOfDay();

        $ventasPorDia = Venta::selectRaw('DATE(created_at) as fecha, COUNT(*) as ventas, SUM(total) as monto')
            ->where('created_at', '>=', $from)
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $topProductos = DetalleVenta::select('product_id', DB::raw('SUM(cantidad) as unidades'), DB::raw('SUM(subtotal) as ingresos'))
            ->where('created_at', '>=', $from)
            ->groupBy('product_id')
            ->with(['product:id,nombre'])
            ->orderByDesc('unidades')
            ->limit(5)
            ->get();

        $bajoStock = Product::orderBy('stock')
            ->where('stock', '<', 10)
            ->limit(5)
            ->get(['id', 'nombre', 'stock']);

        return view('admin.dashboard', compact('ventasPorDia', 'topProductos', 'bajoStock'));
    }
}

