<?php

namespace App\Models; // Define el namespace del modelo, en la carpeta App\Models.

use Illuminate\Database\Eloquent\Factories\HasFactory;              // Importa el trait HasFactory para poder usar factories en pruebas y semillas.
use Illuminate\Database\Eloquent\Model;                             // Importa la clase base Model de Eloquent ORM->(Object Relational Mapper).

class Comment extends Model
{
    use HasFactory;                                                 // Usa el trait HasFactory para permitir la generación de instancias mediante factories.

     // Define los campos que pueden asignarse masivamente desde un formulario o petición.
    protected $fillable = ['product_id', 'user_id', 'content'];     

     //Relación inversa: Un comentario pertenece a un producto.
     //  Permite acceder al producto desde el comentario.
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //Relación inversa: Un comentario pertenece a un usuario.
     //Permite acceder al usuario que hizo el comentario.
     
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Relación indirecta: Obtiene la categoría a través del producto.
     //Se utiliza hasOneThrough cuando el comentario no tiene relación directa con la categoría,
     // pero sí puede acceder a ella a través del producto al que pertenece.
     //Estructura:
     //Categoria (categories) <- Product (products) <- Comment (comments).
    public function category()
{
    return $this->hasOneThrough(
        Category::class,                  // Modelo destino (Category).
        Product::class,                   // Modelo intermediario (Product).
        'id', // Foreign key in products table
        'id', // Foreign key in categories table
        'product_id', // Foreign key in comments table-> hace referencia a Product.
        'category_id' // Foreign key in products table->hace referencia a Category.
    );
}

}