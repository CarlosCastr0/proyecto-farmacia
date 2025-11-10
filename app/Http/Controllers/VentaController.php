<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Carrito;
use App\Models\DetalleVenta;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ventas = Venta::where('user_id', auth()->id())
            ->orderByDesc('id')
            ->paginate(10);

        return view('ventas.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No se usa (checkout via store)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'metodo_pago' => ['required', 'in:efectivo,tarjeta,transferencia'],
        ]);

        $items = Carrito::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($items->isEmpty()) {
            return back()->withErrors(['cart' => 'Tu carrito está vacío.']);
        }

        foreach ($items as $it) {
            if (!$it->product || $it->product->stock < $it->cantidad) {
                return back()->withErrors(['cart' => 'Stock insuficiente para: '.($it->product->nombre ?? 'Producto eliminado')]);
            }
        }

        $venta = DB::transaction(function () use ($user, $items, $validated) {
            $venta = Venta::create([
                'user_id' => $user->id,
                'total' => 0,
                'metodo_pago' => $validated['metodo_pago'],
                'estado' => 'pagado',
            ]);

            $total = 0;
            foreach ($items as $it) {
                $precio = (float) $it->product->precio;
                $subtotal = $precio * (int) $it->cantidad;

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'product_id' => $it->product_id,
                    'cantidad' => $it->cantidad,
                    'subtotal' => $subtotal,
                ]);

                $it->product->decrement('stock', (int) $it->cantidad);
                $total += $subtotal;
            }

            $venta->update(['total' => $total]);
            Carrito::where('user_id', $user->id)->delete();

            return $venta;
        });

        // Intento opcional de generar PDF si Dompdf está disponible
        try {
            // Preferir barryvdh/laravel-dompdf si está instalado
            $path = 'recibos/venta_'.$venta->id.'.pdf';
            if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('ventas.recibo-pdf', compact('venta'))->output();
                Storage::disk('local')->put($path, $pdf);
                $venta->update(['recibo_pdf' => $path]);
            }
            if (class_exists('Dompdf\\Dompdf')) {
                $html = view('ventas.recibo-pdf', compact('venta'))->render();
                $dompdf = new \Dompdf\Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $pdf = $dompdf->output();
                $path = 'recibos/venta_'.$venta->id.'.pdf';
                Storage::disk('local')->put($path, $pdf);
                $venta->update(['recibo_pdf' => $path]);
            }
        } catch (\Throwable $e) {
            // Silenciar errores de PDF
        }

        return redirect()->route('ventas.show', $venta)
            ->with('status', 'Compra realizada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta): View
    {
        abort_if($venta->user_id !== auth()->id(), 403);
        $venta->load(['detalles.product']);
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        //
    }

    public function update(Request $request, Venta $venta)
    {
        //
    }

    public function destroy(Venta $venta)
    {
        //
    }

    public function recibo(Venta $venta)
    {
        abort_if($venta->user_id !== auth()->id(), 403);

        // Generación en vivo del recibo: no dependemos de archivo previo

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $venta->load(['detalles.product']);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('ventas.recibo-pdf', compact('venta'));
            return $pdf->download('recibo_venta_'.$venta->id.'.pdf');
        }
        if (class_exists('Dompdf\\Dompdf')) {
            $venta->load(['detalles.product']);
            $html = view('ventas.recibo-pdf', compact('venta'))->render();
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="recibo_venta_'.$venta->id.'.pdf"',
            ]);
        }

        $venta->load(['detalles.product']);
        return view('ventas.recibo-html', compact('venta'));
    }
}
