@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-3xl text-white font-bold mb-8 text-center">Análisis de Productos con Mejor Rating</h1>

    @if($productos->count())
        @php
            $topProducto = $productos->first();
        @endphp

        <!-- Productos con mayor rating -->
        <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto mb-12">
            <h2 class="text-2xl font-bold text-center mb-6">Top 5 Productos con Mejor Valoración</h2>

            <div class="space-y-8">
                @foreach($productos as $producto)
                    <div class="flex flex-col md:flex-row items-center gap-6 border-b pb-6">
                        <img src="{{ asset('storage/' . $producto->image) }}" alt="{{ $producto->name }}" class="w-32 h-32 object-cover rounded-md">
                        <div class="text-center md:text-left md:flex-1">
                            <h3 class="text-xl font-semibold">{{ $producto->name }}</h3>
                            <p class="text-gray-600 mt-1">Categoría: <span class="font-medium">{{ $producto->category->name ?? 'Sin categoría' }}</span></p>
                            <p class="text-gray-600 mt-1">Promedio de valoración: 
                                <span class="font-bold">{{ number_format($producto->ratings_avg_rating, 2) }} / 5</span>
                            </p>
                            <p class="text-gray-800 font-bold mt-1">Precio: COP {{ number_format($producto->price, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500 mt-1">Cantidad de valoraciones: {{ $producto->ratings_count }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Gráficas centradas -->
<div class="flex flex-col items-center justify-center  mb-12">
    <div class="w-full max-w-5xl flex flex-col md:flex-row justify-center items-start gap-8">
        <div class="flex-1 flex flex-col items-center">
            <h2 class="text-xl font-semibold mb-4 text-white text-center">Promedio de calificación por producto</h2>
            <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-xs">
                <canvas id="ratingChart"></canvas>
            </div>
        </div>
        <div class="flex-1 flex flex-col items-center">
            <h2 class="text-xl font-semibold mb-4 text-white text-center">Cantidad de valoraciones por producto</h2>
            <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-xs">
                <canvas id="countChart"></canvas>
            </div>
        </div>
    </div>
</div>
    @else
        <p class="text-center text-gray-600">No hay productos con valoraciones aún.</p>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

function generarColores(n) {
    const coloresFondo = [];
    const coloresBorde = [];

    for (let i = 0; i < n; i++) {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);

        coloresFondo.push(`rgba(${r}, ${g}, ${b}, 0.6)`);
        coloresBorde.push(`rgba(${r}, ${g}, ${b}, 1)`);
    }

    return { coloresFondo, coloresBorde };
}

const productos = @json($productos);

const nombres = productos.map(p => p.name);
const promedios = productos.map(p => parseFloat(p.ratings_avg_rating).toFixed(2));
const cantidades = productos.map(p => p.ratings_count);

const { coloresFondo, coloresBorde } = generarColores(productos.length);

// Gráfico de promedio de ratings
const ctxRating = document.getElementById('ratingChart').getContext('2d');
new Chart(ctxRating, {
    type: 'bar',
    data: {
        labels: nombres,
        datasets: [{
            label: 'Promedio de Rating',
            data: promedios,
            backgroundColor: coloresFondo,
            borderColor: coloresBorde,
            borderWidth: 1,
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 5
            }
        }
    }
});

// Gráfico de cantidad de ratings
const ctxCount = document.getElementById('countChart').getContext('2d');
new Chart(ctxCount, {
    type: 'bar',
    data: {
        labels: nombres,
        datasets: [{
            label: 'Cantidad de Valoraciones',
            data: cantidades,
            backgroundColor: coloresFondo,
            borderColor: coloresBorde,
            borderWidth: 1,
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection