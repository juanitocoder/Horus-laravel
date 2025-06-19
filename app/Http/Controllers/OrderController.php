<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
public function historial()
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Opción 1: Redirigir al login
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tu historial de compras.');
            
        } else {
            // Usuario autenticado, obtener sus órdenes
            $user = Auth::user();
            $ordenes = $user->orders()->with('items.product')->orderBy('created_at', 'desc')->get();
        }

        return view('modules.dashboard.auth.historial', compact('ordenes'));
    }
}