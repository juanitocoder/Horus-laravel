<?php

    namespace App\Http\Controllers;
    use App\Models\Product;
    use Illuminate\Http\Request;
    use App\Models\Category;
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

                
            }
