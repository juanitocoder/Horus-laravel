<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'content'];

    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
{
    return $this->hasOneThrough(
        Category::class,
        Product::class,
        'id', // Foreign key in products table
        'id', // Foreign key in categories table
        'product_id', // Foreign key in comments table
        'category_id' // Foreign key in products table
    );
}

}