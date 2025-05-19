<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $fillable = ['factura_id', 'product_id', 'cantidad', 'precio_unitario'];

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
