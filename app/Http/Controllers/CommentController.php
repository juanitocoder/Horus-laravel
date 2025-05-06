<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{


    public function comentariosPorProducto($productoId)
{
    $comentarios = Comment::where('product_id', $productoId)
        ->with('user')
        ->latest()
        ->get();

    return response()->json($comentarios);
}


    public function index(Request $request)
    {
        $comentarios = Comment::with(['user', 'product.category'])
            ->when($request->filled('categoria'), function ($query) use ($request) {
                $query->whereHas('product.category', function ($q) use ($request) {
                    $q->where('name', $request->categoria);
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.comentarios.index', compact('comentarios'));
    }

    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $usuarioId = auth()->id();

        $yaComento = Comment::where('product_id', $id)
            ->where('user_id', $usuarioId)
            ->exists();

        if ($yaComento) {
            return response()->json(['message' => 'Ya has comentado este producto.'], 409);
        }

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

    public function vistaComentarios(Request $request)
    {
        $query = Comment::with(['user', 'product.category'])->latest();

        if ($request->filled('categoria')) {
            $query->whereHas('product.category', function ($q) use ($request) {
                $q->where('name', $request->categoria);
            });
        }

        $comentarios = $query->paginate(10)->withQueryString();

        return view('modules.dashboard.auth.comentarios', compact('comentarios'));
    }

    public function adminIndex()
    {
        if (auth()->user()->role->name !== 'admin') {
            abort(403);
        }

        $comentarios = Comment::with(['user', 'product.category'])->latest()->paginate(20);

        return view('modules.dashboard.auth.comentarios', compact('comentarios'));
    }

    public function destroyAdmin($id)
    {
        if (auth()->user()->role->name !== 'admin') {
            abort(403);
        }

        $comentario = Comment::findOrFail($id);
        $comentario->delete();

        return redirect()->route('admin.comentarios')->with('alert', 'Comentario eliminado correctamente.');
    }
}

