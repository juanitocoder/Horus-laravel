<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    // Relación con Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Obtener total de productos vendidos en esta categoría
    public function getTotalProductosVendidosAttribute()
    {
        return OrderItem::whereHas('product', function($query) {
            $query->where('category_id', $this->id);
        })->sum('cantidad');
    }

    // Obtener ingresos totales de esta categoría
    public function getIngresosGeneradosAttribute()
    {
        return OrderItem::whereHas('product', function($query) {
            $query->where('category_id', $this->id);
        })->sum(\DB::raw('cantidad * precio_unitario'));
    }
}