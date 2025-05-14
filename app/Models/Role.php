<?php

// Define el espacio de nombres donde se encuentra el modelo
namespace App\Models;

// Importa la clase base Eloquent Model
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Role
 * 
 * Representa la entidad "roles" en la base de datos.
 * Asume que existe una tabla "roles" por convención de Laravel.
 */
class Role extends Model
{
    /**
     * Relación uno a muchos con User.
     * 
     * Un rol puede tener muchos usuarios.
     * 
     * Ejemplo:
     * - Rol: 'Admin'
     * - Usuarios: Juan, Pedro, Maria (todos con rol 'Admin')
     */
    public function users()
    {
        // Define la relación hasMany con el modelo User
        return $this->hasMany(User::class);
    }
}

