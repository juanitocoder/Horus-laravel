<?php

namespace App\Models;                // Define el namespace donde está ubicado el modelo.

use Illuminate\Database\Eloquent\Model;                     // Importa la clase base de modelos Eloquent.
use Illuminate\Database\Eloquent\Factories\HasFactory;      // Importa el trait HasFactory para crear instancias en pruebas y semillas.    

class Rating extends Model                                   //clase Rating hereda de la clase Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'rating',
        'user_id',
        
    ];

     // Relación inversa: Un Rating pertenece a un User.
     // Permite acceder al usuario que realizó la calificación.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* Relación inversa: Un Rating pertenece a un Product.
     * Permite acceder al producto que fue calificado.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
