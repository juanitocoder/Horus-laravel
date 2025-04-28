<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    public function show()
    {
        $cart = Auth::user()->cart()->with('items.product')->firstOrCreate();
        return view('cart.show', compact('cart'));
    }

    public function add(Product $product)
    {
    $cart = Auth::user()->cart()->firstOrCreate();
    $item = $cart->items()->where('product_id', $product->id)->first();
    
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
}
