<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class GraficaController extends Controller
{
    public function graficas()
    {
        $productos = Product::withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->orderByDesc('ratings_avg_rating')
            ->take(5)
            ->get();

        return view('modules.dashboard.auth.graficas', compact('productos'));
    }
}