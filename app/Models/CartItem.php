<?php

namespace App\Models;// Define el namespace del modelo, ubicándolo dentro de App\Models.

use Illuminate\Database\Eloquent\Model; // Importa la clase base Model de Eloquent ORM.

class CartItem extends Model
{
        // Define los campos que se pueden asignar de manera masiva.
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    //Relación inversa: Un CartItem pertenece a un Cart.
    // Permite acceder al carrito al que pertenece este ítem.
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

     /**
     * Relación inversa: Un CartItem pertenece a un Product.
     * Permite acceder al producto asociado a este ítem en el carrito.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    
}
