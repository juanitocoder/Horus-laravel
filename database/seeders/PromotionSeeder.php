<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        Promotion::create([
            'name' => '15_descuento',
            'label' => 'COP {precio} <span class="line-through text-gray-400">Antes COP {precio}</span> <br><span class="text-red-600">COP {precioConDescuento}</span>',
            'subtext' => null,
            'color' => 'text-red-600'
        ]);

        Promotion::create([
            'name' => '2x1',
            'label' => 'COP {precio}',
            'subtext' => '<span class="text-green-700 font-semibold text-sm">Llévate 2 por el precio de 1</span>',
            'color' => 'text-green-600'
        ]);

        Promotion::create([
            'name' => 'Madre',
            'label' => 'COP {precio}',
            'subtext' => '<span class="text-pink-500 font-semibold text-sm">Edición especial Día de la Madre 💐</span>',
            'color' => 'text-pink-600'
        ]);
    }
}

