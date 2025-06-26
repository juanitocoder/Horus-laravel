<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    public function show()
    {
        $cart = Auth::user()->cart()->with('items.product')->firstOrCreate();     //Carrito del usuario
        return view('cart.show', compact('cart'));
    }

    public function add(Product $product)
    {
    $cart = Auth::user()->cart()->firstOrCreate();
    $item = $cart->items()->where('product_id', $product->id)->first();        // Buscar producto
    
    if ($item) {
        $item->quantity += 1;
        $item->save();
    } else {
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 1
        ]);
    }

    return redirect()->back()->with('alert', 'Producto agregado al carrito');
    }

    public function remove(CartItem $item)
    {
        $item->delete();
        return redirect()->back()->with('alert', 'Producto eliminado');
    }

    public function increase(CartItem $item)
    {
        $item->increment('quantity');
        return redirect()->back();
    }

    public function decrease(CartItem $item)
    {
        if ($item->quantity > 1) {
            $item->decrement('quantity');
        } else {
            $item->delete();
        }
        return redirect()->back();
    }

        public function clear()
        {
            $cart = Auth::user()->cart()->first();
            
            if ($cart) {
                $cart->items()->delete();
                return redirect()->back()->with('alert', 'Carrito limpiado');
            }
            
            return redirect()->back()->with('alert', 'El carrito ya estaba vacío');
        }

        public function finalizarCompra()
{
    $user = auth()->user();
    $cart = $user->cart; // Suponiendo que tienes relación entre usuario y carrito

    // Calcular total del carrito
    $total = $cart->items->sum(function ($item) {
        return $item->product->price * $item->quantity;
    });

    // Crear la orden
    $order = Order::create([
        'user_id' => $user->id,
        'total' => $total,
        'status' => 'completado', // o 'pendiente' si vas a esperar confirmación de ePayco
    ]);

    // Agregar productos a la orden
    foreach ($cart->items as $item) {
        $order->items()->create([
            'product_id' => $item->product_id,
            'cantidad' => $item->quantity,
            'precio_unitario' => $item->product->price,
        ]);
    }

    //  Vaciar el carrito
    $cart->items()->delete();

    return redirect()->route('orden.exito')->with('alert', '¡Orden completada con éxito!');
}
}
