<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;
use App\Models\Product;

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
