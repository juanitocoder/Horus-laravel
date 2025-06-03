@extends('layouts.app')

@section('title', 'Laravel11 | Home')

@section('content')
<div class="bg-[#212235] min-h-screen">
   <!-- Sección de Inicio -->
    <div class="container mx-auto lg:px-8 py-2 lg:py-3">
        <x-inicio></x-inicio>
    </div>

    <!-- Sección de Carrusel -->
    <div class="container mx-auto lg:px-8 py-2 lg:py-3">
        <x-carrusel></x-carrusel>
    </div> 
   

    <!-- Buscador de Manillas -->
    <div class="container mx-auto px-4 py-8">
        <!-- Header del Buscador -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-white mb-2">
                <i class="fas fa-gem text-purple-400 mr-3"></i>
                Encuentra tu Manilla Perfecta
            </h2>
            <p class="text-gray-300">Manillas únicas para hombres, mujeres y parejas</p>
        </div>

        <!-- Formulario de búsqueda centrado -->
        <div class="flex justify-center mb-8">
            <div class="w-full max-w-2xl">
                <form method="GET" action="{{ route('home') }}" class="relative">
                    <div class="flex items-center bg-white rounded-full shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl text-gray-700">
                        <div class="flex-grow relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Buscar manillas por estilo, material o tipo..." 
                                class="w-full px-12 py-4 text-lg outline-none bg-transparent"
                            >
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        <button 
                            type="submit" 
                            class="px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold transition-all duration-300 hover:from-purple-600 hover:to-pink-600 hover:shadow-lg"
                        >
                            <i class="fas fa-search mr-2"></i>
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filtros rápidos por categoría -->
        <div class="flex justify-center mb-8">
            <div class="flex flex-wrap gap-3">
                
                <a href="{{ route('home') }}" 
                   class="bg-gray-600 text-white px-6 py-3 rounded-full hover:bg-gray-700 transition-colors duration-300">
                    <i class="fas fa-times mr-2"></i>Limpiar
                </a>
            </div>
        </div>

        <!-- Resultados -->
        @if(request('search'))
            <div id="resultados-busqueda" class="max-w-6xl mx-auto">
                <!-- Indicador de búsqueda -->
                <div class="mb-6 text-center">
                    <p class="text-gray-300">
                        Manillas encontradas para: <span class="font-semibold text-purple-400">"{{ request('search') }}"</span>
                        @if($productos->count() > 0)
                            <span class="text-sm text-gray-400">({{ $productos->count() }} {{ $productos->count() == 1 ? 'resultado' : 'resultados' }})</span>
                        @endif
                    </p>
                </div>

                <!-- Grid de productos -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse ($productos as $product)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-105 group">
                            <!-- Imagen del producto -->
                            <div class="relative overflow-hidden h-48 bg-gray-100">
                                @if($product->image)
                                    <img 
                                        src="{{ asset('storage/' . $product->image) }}" 
                                        alt="{{ $product->name }}" 
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-pink-100">
                                        <i class="fas fa-gem text-4xl text-purple-400"></i>
                                    </div>
                                @endif
                                
                                <!-- Badge de categoría -->
                                <div class="absolute top-3 right-3">
                                    @if(stripos($product->category, 'hombre') !== false || stripos($product->name, 'hombre') !== false)
                                        <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-mars mr-1"></i>Hombre
                                        </span>
                                    @elseif(stripos($product->category, 'mujer') !== false || stripos($product->name, 'mujer') !== false)
                                        <span class="bg-pink-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-venus mr-1"></i>Mujer
                                        </span>
                                    @elseif(stripos($product->category, 'pareja') !== false || stripos($product->name, 'pareja') !== false)
                                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-heart mr-1"></i>Pareja
                                        </span>
                                    @else
                                        <span class="bg-purple-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-gem mr-1"></i>Manilla
                                        </span>
                                    @endif
                                </div>

                                <!-- Badge de descuento si aplica -->
                                @if(isset($product->discount) && $product->discount > 0)
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            -{{ $product->discount }}%
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Contenido de la tarjeta -->
                            <div class="p-5">
                                <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    {{ $product->description }}
                                </p>
                                
                                <!-- Precio -->
                                <div class="flex items-center justify-between">
                                    <div class="text-2xl font-bold text-green-600">
                                        ${{ number_format($product->price, 0, '.', '.') }}
                                    </div>
                                    
                                    <!-- Botón de acción -->
                                    <button class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-4 py-2 rounded-lg transition-all duration-300 hover:from-purple-600 hover:to-pink-600 text-sm font-semibold hover:shadow-lg">
                                        <i class="fas fa-shopping-cart mr-1"></i>
                                        Comprar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Estado vacío -->
                        <div class="col-span-full">
                            <div class="text-center py-16">
                                <div class="mb-6">
                                    <i class="fas fa-search text-6xl text-gray-400"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-300 mb-2">
                                    No se encontraron manillas
                                </h3>
                                <p class="text-gray-400 mb-6">
                                    No encontramos manillas que coincidan con tu búsqueda.<br>
                                    Intenta con otros términos o explora nuestras categorías.
                                </p>
                                <div class="flex flex-wrap justify-center gap-3">
                                    <a href="{{ route('.hombres', ['search' => 'hombre']) }}" 
                                       class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-300">
                                        <i class="fas fa-mars mr-2"></i>Ver Manillas de Hombre
                                    </a>
                                    <a href="{{ route('.mujeres', ['search' => 'mujer']) }}" 
                                       class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-colors duration-300">
                                        <i class="fas fa-venus mr-2"></i>Ver Manillas de Mujer
                                    </a>
                                    <a href="{{ route('.parejas', ['search' => 'pareja']) }}" 
                                       class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-300">
                                        <i class="fas fa-heart mr-2"></i>Ver Manillas de Pareja
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            <!-- Estado inicial - Sin búsqueda -->
            <div class="text-center py-16">
                <div class="mb-8">
                    <i class="fas fa-gem text-8xl text-purple-300 mb-6"></i>
                    <h3 class="text-3xl font-bold text-white mb-4">
                        ¡Descubre nuestras manillas!
                    </h3>
                    <p class="text-gray-300 text-lg max-w-md mx-auto">
                        Explora nuestra colección de manillas únicas para cada estilo y ocasión
                    </p>
                </div>
                
                
            </div>
        @endif
    </div>
 
    <!-- Sección Nosotros -->
    <div class="container mx-auto lg:px-8 py-2 lg:py-3">
        <x-nosotros></x-nosotros>
    </div>

    <!-- Scroll to top button -->
    <button 
        id="scrollToTop"
        class="fixed bottom-6 right-6 bg-gradient-to-r from-purple-500 to-pink-500 text-white p-3 rounded-full shadow-lg hover:from-purple-600 hover:to-pink-600 transition-all duration-300 opacity-0 invisible"
        onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
    >
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Scroll to top functionality
        window.addEventListener('scroll', function() {
            const scrollButton = document.getElementById('scrollToTop');
            if (window.pageYOffset > 300) {
                scrollButton.classList.remove('opacity-0', 'invisible');
            } else {
                scrollButton.classList.add('opacity-0', 'invisible');
            }
        });

        // Auto-focus search input on page load
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput && !searchInput.value) {
                searchInput.focus();
            }
            
            // Auto-scroll to results after search
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('search')) {
                setTimeout(() => {
                    const resultadosSection = document.getElementById('resultados-busqueda');
                    if (resultadosSection) {
                        resultadosSection.scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 100);
            }
        });
    </script>
</div>
@endsection