<?php

namespace App\Http\Controllers;
use App\Models\Rating;
use App\Models\Product;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;

use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);
    
        $existingRating = Rating::where('user_id', auth()->id())
                                ->where('product_id', $request->product_id)
                                ->first();
        
        if ($existingRating) {
            return response()->json(['error' => 'Ya has calificado este producto.'], 403);
            
        }
    
        Rating::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
        ]);
    
        return response()->json(['success' => 'Calificación guardada correctamente.']);
    }
}
