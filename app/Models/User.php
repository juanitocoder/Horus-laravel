<?php

namespace App\Models; // Define el namespace del modelo User.

/**
 * Importaciones necesarias.
 */
use Illuminate\Database\Eloquent\Factories\HasFactory; // Trait para permitir uso de factories.
use Illuminate\Foundation\Auth\User as Authenticatable; // Clase base para usuarios autenticables.
use Illuminate\Notifications\Notifiable; // Trait para enviar notificaciones.
use Illuminate\Contracts\Auth\CanResetPassword; // Interfaz para habilitar restablecimiento de contraseñas.
use Illuminate\Auth\Notifications\ResetPassword as PasswordResetNotification; // Notificación de restablecimiento de contraseña.

class User extends Authenticatable implements CanResetPassword
{
    /** 
     * Permite que el modelo use las factorías y notificaciones.
     */
    use HasFactory, Notifiable;

    /**
     * Atributos que pueden ser asignados de manera masiva.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Atributos que deben ocultarse al serializar el modelo.
     * Se recomienda ocultar la contraseña y el token de sesión.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que deben ser casteados automáticamente.
     * Se transforma 'email_verified_at' a un objeto DateTime.
     * Se aplica hash a la contraseña automáticamente.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación inversa: el usuario pertenece a un rol.
     * Permite acceder al rol del usuario (por ejemplo, administrador, cliente).
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relación uno a uno: el usuario tiene un carrito.
     * Permite acceder directamente al carrito asociado al usuario.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }   
    
    /**
     * Relación uno a muchos: el usuario puede tener muchas calificaciones.
     * Permite acceder a todas las calificaciones hechas por el usuario.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Método para enviar la notificación personalizada de restablecimiento de contraseña.
     * Sobrescribe el método por defecto de Laravel para usar la notificación importada.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }
}
