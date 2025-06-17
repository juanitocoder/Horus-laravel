@extends('layouts.app')

@section('content')
<div class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Productos Más Vendidos del Mes</h1>

        @if($productos->isEmpty())
            <p class="text-center text-gray-500">No hay productos vendidos este mes.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($productos as $producto)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition duration-300 p-4">
                        <img src="{{ $producto->image ? asset('storage/' . $producto->image) : asset('images/default.png') }}" alt="{{ $producto->name }}" class="w-full h-40 object-cover rounded-xl mb-4">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">{{ $producto->name }}</h2>
                        <p class="text-sm text-gray-600 mb-3">Unidades vendidas: <span class="font-bold">{{ $producto->total_vendidos }}</span></p>
                        <a href="{{ route('productos.ver', $producto->id) }}" class="inline-block text-white bg-blue-600 hover:bg-blue-700 font-medium py-2 px-4 rounded-xl text-sm text-center">
                            Ver producto
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
