<?php

// Define el espacio de nombres del modelo.
namespace App\Models;

// Importa la clase base de Eloquent.
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Category
 * 
 * Representa la entidad "categories" en la base de datos.
 * Incluye la relación con productos.
 */
class Category extends Model
{
    /**
     * Define los campos que se pueden asignar de forma masiva.
     * Protege contra la asignación no deseada (Mass Assignment).
     */
    protected $fillable = ['name'];

    /**
     * Relación uno a muchos con Product.
     * Una categoría puede tener muchos productos.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

