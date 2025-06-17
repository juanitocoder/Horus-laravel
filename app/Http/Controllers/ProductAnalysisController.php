<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductAnalysisController extends Controller
{
    public function index()
    {
        // Productos con mejor rating (tu consulta existente)
        $productos = Product::with('category')
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->whereHas('ratings')
            ->orderBy('ratings_avg_rating', 'desc')
            ->take(5)
            ->get();

        // Productos más comprados basado en order_items
        $productosComprados = OrderItem::select(
                'product_id',
                DB::raw('SUM(cantidad) as total_vendido'),
                DB::raw('SUM(cantidad * precio_unitario) as ingresos_totales')
            )
            ->with('product:id,name,image') // Asumiendo que tienes la relación definida
            ->groupBy('product_id')
            ->orderBy('total_vendido', 'desc')
            ->take(7)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'name' => $item->product->name ?? 'Producto sin nombre',
                    'image' => $item->product->image ?? null,
                    'sales' => $item->total_vendido,
                    'revenue' => $item->ingresos_totales
                ];
            });

        // Productos que generan más ingresos
        $productosIngresos = OrderItem::select(
                'product_id',
                DB::raw('SUM(cantidad) as total_vendido'),
                DB::raw('SUM(cantidad * precio_unitario) as ingresos_totales')
            )
            ->with('product:id,name,image')
            ->groupBy('product_id')
            ->orderBy('ingresos_totales', 'desc')
            ->take(7)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'name' => $item->product->name ?? 'Producto sin nombre',
                    'image' => $item->product->image ?? null,
                    'sales' => $item->total_vendido,
                    'revenue' => $item->ingresos_totales
                ];
            });

        // Categorías más populares basado en productos vendidos
        $categoriasPopulares = OrderItem::select(
                'products.category_id',
                'categories.name as category_name',
                DB::raw('COUNT(order_items.id) as total_ordenes'),
                DB::raw('SUM(order_items.cantidad) as total_productos_vendidos'),
                DB::raw('SUM(order_items.cantidad * order_items.precio_unitario) as ingresos_categoria')
            )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('products.category_id', 'categories.name')
            ->orderBy('total_productos_vendidos', 'desc')
            ->take(7)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->category_name,
                    'visits' => $item->total_productos_vendidos, // Usando productos vendidos como métrica de "popularidad"
                    'orders' => $item->total_ordenes,
                    'revenue' => $item->ingresos_categoria
                ];
            });

        // Estadísticas adicionales
        $estadisticas = [
            'total_ventas' => OrderItem::sum(DB::raw('cantidad * precio_unitario')),
            'total_productos_vendidos' => OrderItem::sum('cantidad'),
            'total_ordenes' => OrderItem::distinct('order_id')->count('order_id'),
            'promedio_orden' => OrderItem::selectRaw('AVG(cantidad * precio_unitario) as promedio')
                ->groupBy('order_id')
                ->get()
                ->avg('promedio')
        ];

        return view('products.analysis', compact(
            'productos',
            'productosComprados',
            'productosIngresos',
            'categoriasPopulares',
            'estadisticas'
        ));
    }

    // Método adicional para obtener datos de ventas por período
    public function ventasPorPeriodo(Request $request)
    {
        $periodo = $request->get('periodo', 'mes'); // día, semana, mes, año
        
        $formato = match($periodo) {
            'dia' => '%Y-%m-%d',
            'semana' => '%Y-%u',
            'mes' => '%Y-%m',
            'año' => '%Y',
            default => '%Y-%m'
        };

        $ventasPorPeriodo = OrderItem::select(
                DB::raw("DATE_FORMAT(created_at, '$formato') as periodo"),
                DB::raw('SUM(cantidad) as productos_vendidos'),
                DB::raw('SUM(cantidad * precio_unitario) as ingresos'),
                DB::raw('COUNT(DISTINCT order_id) as ordenes')
            )
            ->groupBy('periodo')
            ->orderBy('periodo')
            ->get();

        return response()->json($ventasPorPeriodo);
    }

    // Método para obtener los productos más vendidos por categoría
    public function ventasPorCategoria($categoryId = null)
    {
        $query = OrderItem::select(
                'products.category_id',
                'categories.name as category_name',
                'products.id as product_id',
                'products.name as product_name',
                DB::raw('SUM(order_items.cantidad) as total_vendido'),
                DB::raw('SUM(order_items.cantidad * order_items.precio_unitario) as ingresos')
            )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('products.category_id', 'categories.name', 'products.id', 'products.name');

        if ($categoryId) {
            $query->where('products.category_id', $categoryId);
        }

        return $query->orderBy('total_vendido', 'desc')->get();
    }
}
