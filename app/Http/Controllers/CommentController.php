<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{


    public function index($productoId)
    {
    $comentarios = \App\Models\Comment::where('product_id', $productoId)
        ->with('user') // Asumiendo que Comment tiene relación con User
        ->latest()
        ->get();

    return response()->json($comentarios);
}


public function store(Request $request, $id)
{
    $validated = $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $usuarioId = auth()->id();

    // Verificar si ya comentó este producto
    $yaComento = Comment::where('product_id', $id)
        ->where('user_id', $usuarioId)
        ->exists();

    if ($yaComento) {
        return response()->json(['message' => 'Ya has comentado este producto.'], 409); // Código 409: conflicto
    }

    // Guardar nuevo comentario
    $comentario = new Comment();
    $comentario->product_id = $id;
    $comentario->user_id = $usuarioId;
    $comentario->content = $validated['content'];
    $comentario->save();

    $comentario->load('user');

    return response()->json($comentario, 201);
}


public function update(Request $request, $id)
{
    $comentario = Comment::findOrFail($id);

    if (auth()->id() !== $comentario->user_id) {
        return response()->json(['message' => 'No autorizado'], 403);
    }

    $validated = $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $comentario->content = $validated['content'];
    $comentario->save();

    return response()->json($comentario);
}

public function destroy($id)
{
    $comentario = Comment::findOrFail($id);

    if (auth()->id() !== $comentario->user_id) {
        return response()->json(['message' => 'No autorizado'], 403);
    }

    $comentario->delete();

    return response()->json(['message' => 'Comentario eliminado']);
}



}
