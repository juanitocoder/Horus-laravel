<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $productos = collect(); // Colección vacía por defecto
        
        // Solo buscar si hay término de búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            
            $productos = Product::where(function($query) use ($searchTerm) {
                // Búsqueda básica en nombre y descripción
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('description', 'LIKE', "%{$searchTerm}%");
                      
                // Búsquedas específicas para manillas (solo en name y description)
                if (stripos($searchTerm, 'hombre') !== false || stripos($searchTerm, 'masculin') !== false) {
                    $query->orWhere('name', 'LIKE', '%hombre%')
                          ->orWhere('name', 'LIKE', '%masculin%')
                          ->orWhere('description', 'LIKE', '%hombre%')
                          ->orWhere('description', 'LIKE', '%masculin%');
                }
                
                if (stripos($searchTerm, 'mujer') !== false || stripos($searchTerm, 'femenin') !== false) {
                    $query->orWhere('name', 'LIKE', '%mujer%')
                          ->orWhere('name', 'LIKE', '%femenin%')
                          ->orWhere('description', 'LIKE', '%mujer%')
                          ->orWhere('description', 'LIKE', '%femenin%');
                }
                
                if (stripos($searchTerm, 'pareja') !== false || stripos($searchTerm, 'couple') !== false) {
                    $query->orWhere('name', 'LIKE', '%pareja%')
                          ->orWhere('name', 'LIKE', '%couple%')
                          ->orWhere('description', 'LIKE', '%pareja%')
                          ->orWhere('description', 'LIKE', '%couple%');
                }
                
                // Búsquedas por material
                if (stripos($searchTerm, 'oro') !== false) {
                    $query->orWhere('description', 'LIKE', '%oro%')
                          ->orWhere('name', 'LIKE', '%oro%');
                }
                
                if (stripos($searchTerm, 'plata') !== false) {
                    $query->orWhere('description', 'LIKE', '%plata%')
                          ->orWhere('name', 'LIKE', '%plata%');
                }
                
                if (stripos($searchTerm, 'acero') !== false) {
                    $query->orWhere('description', 'LIKE', '%acero%')
                          ->orWhere('name', 'LIKE', '%acero%');
                }
            })
            ->orderBy('name', 'asc')
            ->get();
        }
        
        return view('modules.dashboard/auth/home', compact('productos'));
    }

    
}
