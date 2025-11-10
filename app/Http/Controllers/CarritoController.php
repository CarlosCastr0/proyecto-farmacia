<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $items = Carrito::with('product')
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->get();

        $total = $items->reduce(function ($carry, $item) {
            $precio = (float) optional($item->product)->precio ?? 0;
            return $carry + ($precio * $item->cantidad);
        }, 0);

        return view('carrito.index', compact('items', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'cantidad' => ['nullable', 'integer', 'min:1'],
        ]);

        $user = $request->user();
        $cantidad = (int) ($data['cantidad'] ?? 1);

        $product = Product::findOrFail($data['product_id']);
        $cantidad = max(1, min($cantidad, (int) $product->stock));

        $item = Carrito::firstOrNew([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $item->cantidad = ($item->exists ? $item->cantidad : 0) + $cantidad;
        $item->cantidad = min($item->cantidad, (int) $product->stock);
        $item->save();

        return back()->with('status', 'Producto agregado al carrito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Carrito $carrito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrito $carrito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrito $carrito): RedirectResponse
    {
        abort_if($carrito->user_id !== $request->user()->id, 403);

        $data = $request->validate([
            'cantidad' => ['required', 'integer', 'min:0'],
        ]);

        if ($data['cantidad'] <= 0) {
            $carrito->delete();
            return back()->with('status', 'Producto eliminado del carrito.');
        }

        $stock = (int) optional($carrito->product)->stock ?? 0;
        $carrito->cantidad = min((int) $data['cantidad'], $stock);
        $carrito->save();

        return back()->with('status', 'Carrito actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Carrito $carrito): RedirectResponse
    {
        abort_if($carrito->user_id !== $request->user()->id, 403);
        $carrito->delete();
        return back()->with('status', 'Producto eliminado del carrito.');
    }
}
