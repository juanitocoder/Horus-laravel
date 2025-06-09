<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'value',
        'discount_percentage',
        'title_color',
        'price_color',
        'description_text',
        'is_active'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'discount_percentage' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relación con productos que tienen esta promoción
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'promotion_id');
    }

    /**
     * Obtener el precio con descuento aplicado
     */
    public function calculateDiscountedPrice($originalPrice)
    {
        if ($this->discount_percentage) {
            return round($originalPrice * (1 - $this->discount_percentage / 100));
        }
        return $originalPrice;
    }

    /**
     * Obtener configuración de estilos para la tarjeta
     */
    public function getCardStylesAttribute()
    {
        return [
            'title_color' => $this->title_color ?? 'text-gray-900',
            'price_color' => $this->price_color ?? 'text-gray-900',
            'description' => $this->description_text ?? '',
        ];
    }

    /**
     * Scope para promociones activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
