<?php



namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(10);
        return view('promociones.index', compact('promotions'));
    }

    public function create()
    {
        return view('promociones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50|unique:promotions',
            'value' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'title_color' => 'required|string',
            'price_color' => 'required|string',
            'description_text' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Promotion::create($request->all());

        return redirect()->route('promotions.index')
                        ->with('alert', 'Promoción creada exitosamente.');
    }

    public function edit(Promotion $promotion)
    {
        return view('promociones.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'value' => 'nullable|numeric|min:0',
        'title_color' => 'required|string',
        'price_color' => 'required|string',
        'description_text' => 'nullable|string',
        'is_active' => 'nullable|boolean',
        'discount_percentage' => 'nullable|numeric|min:0|max:100',
    ]);

    $promotion->update([
        'name' => $request->name,
        'value' => $request->value,
        'title_color' => $request->title_color,
        'price_color' => $request->price_color,
        'description_text' => $request->description_text,
        'is_active' => $request->has('is_active') ? 1 : 0,
        'discount_percentage' => $request->discount_percentage,
    ]);

    return redirect()->route('promotions.index')
                    ->with('alert', 'Promoción actualizada exitosamente.');
}

    public function destroy(Promotion $promotion)
    {
        // Verificar si hay productos usando esta promoción
        if ($promotion->products()->count() > 0) {
            return redirect()->route('promotions.index')
                            ->with('error', 'No se puede eliminar la promoción porque tiene productos asociados.');
        }

        $promotion->delete();

        return redirect()->route('promotions.index')
                        ->with('alert', 'Promoción eliminada exitosamente.');
    }

    /**
     * Alternar estado activo/inactivo
     */
    public function toggleActive(Promotion $promotion)
    {
        $promotion->update(['is_active' => !$promotion->is_active]);
        
        $status = $promotion->is_active ? 'activada' : 'desactivada';
        return redirect()->route('promotions.index')
                        ->with('alert', "Promoción {$status} exitosamente.");
    }
}

