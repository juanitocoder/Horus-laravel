<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function hombres()
    {
        $productos = Product::with('category')
            ->whereHas('category', function ($q) {
                $q->where('name', 'hombres');
            })
            ->get();
    
        return view('modules.dashboard.auth.hombres', compact('productos'));
    }
    
    public function mujeres()
    {
        $productos = Product::with('category')
            ->whereHas('category', function ($q) {
                $q->where('name', 'mujeres');
            })
            ->get();
    
        return view('modules.dashboard.auth.mujeres', compact('productos'));
    }
    
    public function parejas()
    {
        $productos = Product::with('category')
            ->whereHas('category', function ($q) {
                $q->where('name', 'parejas');
            })
            ->get();
    
        return view('modules.dashboard.auth.parejas', compact('productos'));
    }

    public function destroy(Product $product)
    {
        // Eliminar la imagen si existe
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return redirect()->back()->with('alert', 'Producto eliminado');
    }

    public function create()
    {
        $categorias = Category::all();
        return view('modules.dashboard.auth.crear', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $rutaImagen = null;
        if ($request->hasFile('image')) {
            $rutaImagen = $request->file('image')->store('productos', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $rutaImagen,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('product.create')->with('success', 'Producto agregado correctamente.');
    }

    public function calificar(Request $request, $id)
    {
        $producto = Product::findOrFail($id);
        $producto->rating = $request->input('rating');
        $producto->save();

        return response()->json(['success' => true]);
    }

    /**
     * Mostrar el formulario para editar un producto
     */
    public function edit(Product $product)
    {
        $categorias = Category::all();
        return view('modules.dashboard.auth.editar-producto', compact('product', 'categorias'));
    }

    /**
     * Actualizar un producto en la base de datos
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Si hay nueva imagen
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Guardar la nueva imagen
            $rutaImagen = $request->file('image')->store('productos', 'public');
            $product->image = $rutaImagen;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $product->image,
        ]);

        return redirect()->route('product.edit', $product)->with('success', 'Producto actualizado correctamente.');
    }
}