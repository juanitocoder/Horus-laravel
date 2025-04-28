<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Producto;

class AdminController extends Controller
{
    public function graficas()
    {
        $productos = Product::withAvg('ratings', 'rating') // Asumiendo que tienes una relación ratings()
            ->orderByDesc('ratings_avg_rating')
            ->take(5)
            ->get();

        return view('modules.dashboard.auth.graficas', compact('productos'));
    }
}
