<?php

// Importa la clase Inspiring y la clase Artisan de Laravel
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/**
 * Define un comando personalizado de Artisan llamado 'inspire'.
 * 
 * Este comando cuando se ejecuta en la consola mostrará una frase inspiradora aleatoria.
 * Se accede ejecutando:
 * 
 * php artisan inspire
 */
Artisan::command('inspire', function () {
    // Muestra en la consola una frase inspiradora obtenida de la clase Inspiring
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote'); // Define la descripción/purpose que aparece al listar los comandos con 'php artisan list'

