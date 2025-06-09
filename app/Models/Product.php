<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    public function category()
    {
    return $this->belongsTo(Category::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'promotion_type',
        'promotion_id',
    ];

    public function comments()
{
    return $this->hasMany(Comment::class);
}


    /**
     * Relación con promoción
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * Obtener precio con descuento aplicado
     */
    public function getDiscountedPriceAttribute()
    {
        if ($this->promotion) {
            return $this->promotion->calculateDiscountedPrice($this->price);
        }
        return $this->price;
    }

    /**
     * Verificar si tiene promoción activa
     */
    public function hasActivePromotion()
    {
        return $this->promotion && $this->promotion->is_active;
    }
}
