<?php

// Define el espacio de nombres del modelo
namespace App\Models;

// Importación del modelo base Eloquent y el trait HasFactory
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Clase Product
 * 
 * Representa la entidad "products" en la base de datos.
 * Incluye relaciones con categorías, calificaciones y comentarios.
 */
class Product extends Model
{
    // Usa el trait HasFactory para permitir crear datos de prueba (factories)
    use HasFactory;

    /**
     * Relación muchos a uno con Category.
     * Un producto pertenece a una categoría.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relación uno a muchos con Rating.
     * Un producto puede tener muchas calificaciones.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Calcula el promedio de calificaciones del producto.
     * 
     * Utiliza la relación ratings y la función de agregación avg().
     * Devuelve un float o null si no tiene calificaciones.
     */
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    /**
     * Relación uno a muchos con Comment.
     * Un producto puede tener muchos comentarios.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Define los campos que se pueden asignar masivamente (mass-assignment).
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'promotion_type',
    ];
}
