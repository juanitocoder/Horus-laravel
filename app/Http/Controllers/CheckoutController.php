<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class CheckoutController extends Controller
{
    public function finalizarCompra(Request $request)
    {
    $user = Auth::user();
    $cart = $user->cart;

    if (!$cart || $cart->items->isEmpty()) {
        return back()->with('error', 'Tu carrito está vacío.');
    }

    // Crear factura
    $factura = new Factura();
    $factura->user_id = $user->id;
    $factura->total = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);
    $factura->save();

    // Asociar productos a la factura
    foreach ($cart->items as $item) {
        $factura->detalles()->create([
            'product_id' => $item->product_id,
            'cantidad' => $item->quantity,
            'precio_unitario' => $item->product->price,
        ]);
    }

    // Vaciar carrito
    $cart->items()->delete();

    return redirect()->route('factura.ver', $factura->id)->with('success', 'Compra finalizada. Factura generada.');
    }


    public function verFactura($id)
    {
    $factura = Factura::with('detalles.product')->findOrFail($id);
    return view('modules.dashboard.auth.facturas', compact('factura'));
    }

    public function descargarFactura($id)
    {
    $factura = Factura::with('user', 'detalles.product')->findOrFail($id);

    $pdf = Pdf::loadView('modules.dashboard.auth.pdf', compact('factura'));

    return $pdf->download("factura_{$factura->id}.pdf");
    }

}
