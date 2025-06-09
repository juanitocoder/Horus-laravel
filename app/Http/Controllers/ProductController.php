<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
   public function index(Request $request)
{
    $search = $request->input('search');

    $productos = Product::when($search, function ($query, $search) {
        return $query->where('name', 'like', '%' . $search . '%');
    })->get();

    return view('modules.dashboard.auth.home', compact('productos', 'search'));
}
public function show($id)
{
    $product = Product::findOrFail($id);
    $productos = collect([$product]); // colección con un solo producto
    return view('products.show', compact('product', 'productos'));
}
public function search(Request $request, $category)
{
    $search = $request->input('search');

    $categoryData = Category::where('name', $category)->firstOrFail();

    $products = Product::where('category_id', $categoryData->id)
        ->where(function($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })
        ->paginate(12);

    return view('products.search', compact('products', 'search', 'category'));
}


public function searchAjax(Request $request)
{
    $query = $request->input('search');

    $products = Product::where('name', 'like', "%$query%")
        ->orWhere('description', 'like', "%$query%")
        ->take(10)
        ->get();

    return response()->json([
        'products' => $products
    ]);
}
    public function hombres()
    {
        $productos = Product::with('category')
            ->whereHas('category', function ($q) {
                $q->where('name', 'hombres');
            })
            ->get();
    
        return view('modules.dashboard.auth.hombres', compact('productos'));
    }
    
    public function promo()
{
    $promotions = Promotion::with('products')->get();

    // Agrupar productos por tipo de promoción
    $promociones = $promotions->mapWithKeys(function ($promotion) {
        return [$promotion->name => $promotion->products];
    });         // agrupa por tipo

    return view('modules.dashboard.auth.promo', compact('promociones'));
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
    $promotions = Promotion::where('is_active', 1)->get(); // solo activas si quieres

    return view('modules.dashboard.auth.crear', compact('categorias', 'promotions'));

    }

    public function store(Request $request )
    
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'promotion_id' => 'nullable|exists:promotions,id',
        'image' => 'nullable|image|max:2048',
    ]);

    $product = new Product();
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->category_id = $request->category_id;
    $product->promotion_id = $request->promotion_id;

    if($request->hasFile('image')){
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
    }

    $product->save();

        return redirect()->route('product.create')->with('alert', 'Producto agregado correctamente.');
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
    $promociones = Promotion::all();

    return view('modules.dashboard.auth.editar-producto', compact('product', 'categorias', 'promociones'));
}

    /**
     * Actualizar un producto en la base de datos
     */
    public function update(Request $request, Product $product)
{
    $request->validate([
        'name'         => 'required|string|max:255',
        'description'  => 'nullable|string',
        'price'        => 'required|numeric|min:0',
        'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'category_id'  => 'required|exists:categories,id',
        'promotion_id' => 'nullable|exists:promotions,id',
    ]);

    // ID de categoría "Promociones"
    $promoCategoryId = 4;

    // Solo asignamos promotion_id si la categoría es Promociones
    $newPromotionId = $request->category_id == $promoCategoryId
        ? $request->promotion_id
        : null;

    // Actualizar producto
    $product->update([
        'name'         => $request->name,
        'description'  => $request->description,
        'price'        => $request->price,
        'category_id'  => $request->category_id,
        'promotion_id' => $newPromotionId,  // ← aquí va promotion_id
        'image'        => $product->image,  // solo si no cambió
    ]);

    // Actualizar imagen si se subió una nueva
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $product->update(['image' => $imagePath]);
    }

    return redirect()->back()->with('alert', 'Producto actualizado correctamente.');
}
}