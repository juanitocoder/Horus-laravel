@php
    $userRating = auth()->check()
        ? $producto->ratings()->where('user_id', auth()->id())->first()
        : null;

    $precio = $producto->price;
    $precioConDescuento = $producto->promotion_type === '15_descuento'
        ? round($precio * 0.85)
        : $precio;
@endphp

<div class="group relative overflow-hidden rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1 mx-4 my-4 bg-[#2d2f4a] text-white w-81">

    <!-- Imagen con etiquetas -->
    <div class="relative h-72 overflow-hidden rounded-t-2xl">
        @if($producto->category->name == 'Promociones' && $producto->promotion_type)
            @if($producto->promotion_type == '15_descuento')
                <div class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-lg shadow-lg z-10">15% OFF</div>
            @elseif($producto->promotion_type == '2x1')
                <div class="absolute top-2 left-2 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-lg shadow-lg z-10">2x1</div>
            @elseif($producto->promotion_type == 'Madre')
                <div class="absolute top-2 left-2 bg-pink-500 text-white text-xs font-bold px-2 py-1 rounded-lg shadow-lg z-10">Día de la Madre</div>
            @endif
        @endif

        <img 
            src="{{ asset('storage/'.$producto->image) }}" 
            alt="{{ $producto->name }}" 
            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
        />

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
            <div class="p-4 w-full">
                <span
                    @click.stop="abrirModal({
                        name: '{{ $producto->name }}',
                        description: `{{ $producto->description }}`,
                        price: 'COP {{ number_format($precioConDescuento, 0, ',', '.') }}',
                        image: '{{ asset('storage/'.$producto->image) }}',
                        id: {{ $producto->id }},
                        @auth
                            role: '{{ Auth::user()->role->name }}',
                        @else
                            role: 'guest',
                        @endauth
                        deleteUrl: '{{ route('product.destroy', $producto->id) }}',
                        addToCartUrl: '{{ route('cart.add', $producto->id) }}',
                        editUrl: '{{ route('product.edit', $producto->id) }}'
                    })"
                    class="block text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-3 text-center cursor-pointer transition"
                >
                    Ver detalle
                </span>
            </div>
        </div>
    </div>

    <!-- Información -->
    <div class="p-5 bg-white">
        <h5 class="text-xl font-bold tracking-tight text-gray-900 mb-2">{{ $producto->name }}</h5>

        <!-- Rating -->
        <div class="flex items-center mb-3">
            <div class="bg-gray-100 rounded-lg px-2 py-1 flex items-center">
                <div x-data="{
                    rating: {{ $userRating ? $userRating->rating : 0 }},
                    hoverRating: 0,
                    alreadyRated: {{ $userRating ? 'true' : 'false' }}
                }" class="flex space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg
                            @click="if (!alreadyRated) { rating = {{ $i }}; submitRating({{ $producto->id }}, {{ $i }}) }"
                            @mouseenter="if (!alreadyRated) hoverRating = {{ $i }}"
                            @mouseleave="hoverRating = 0"
                            :class="(hoverRating >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-500' : 'text-gray-500'"
                            class="w-5 h-5 cursor-pointer transition-colors duration-200"
                            :class="{ 'cursor-not-allowed': alreadyRated }"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.167c.969 0 1.371 1.24.588 1.81l-3.374 2.455a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.538 1.118l-3.374-2.455a1 1 0 00-1.175 0l-3.374 2.455c-.783.57-1.838-.197-1.538-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.05 9.384c-.783-.57-.38-1.81.588-1.81h4.167a1 1 0 00.95-.69l1.286-3.957z" />
                        </svg>
                    @endfor
                </div>
                <span class="text-blue-800 text-xs font-semibold ml-2">
                    {{ number_format($producto->averageRating() ?? 0, 1) }}/5
                </span>
            </div>
        </div>

        <!-- Precio y botón -->
        <div class="flex items-center justify-between mt-2">
            @if ($producto->promotion_type === '15_descuento')
                <div class="flex flex-col">
                    <span class="text-sm text-gray-400 line-through">
                        COP {{ number_format($precio, 0, ',', '.') }}
                    </span>
                    <span class="text-2xl font-bold text-red-600">
                        COP {{ number_format($precioConDescuento, 0, ',', '.') }}
                    </span>
                </div>
            @elseif ($producto->promotion_type === '2x1')
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-green-600">
                        COP {{ number_format($precio, 0, ',', '.') }}
                    </span>
                    <span class="text-sm text-green-700 font-semibold">Llévate 2 por el precio de 1</span>
                </div>
            @elseif ($producto->promotion_type === 'dia_madre')
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-pink-600">
                        COP {{ number_format($precio, 0, ',', '.') }}
                    </span>
                    <span class="text-sm text-pink-500 font-semibold">Edición especial para mamá 💐</span>
                </div>
            @else
                <span class="text-2xl font-bold text-pink-500">
                    COP {{ number_format($precio, 0, ',', '.') }}
                </span>
            @endif

            <button
                @click.stop="abrirModal({ 
                    name: '{{ $producto->name }}',
                    description: `{{ $producto->description }}`,
                    price: 'COP {{ number_format($precioConDescuento, 0, ',', '.') }}',
                    image: '{{ asset('storage/'.$producto->image) }}',
                    id: {{ $producto->id }},
                    @auth
                        role: '{{ Auth::user()->role->name }}',
                    @else
                        role: 'guest',
                    @endauth
                    deleteUrl: '{{ route('product.destroy', $producto->id) }}',
                    addToCartUrl: '{{ route('cart.add', $producto->id) }}'
                })"
                class="rounded-full bg-blue-50 p-2 text-blue-600 hover:bg-blue-100 transition-colors duration-300"
                aria-label="Ver más detalles"
            >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 5a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H6a1 1 0 010-2h3V6a1 1 0 011-1z" />
                </svg>
            </button>
        </div>
    </div>
</div>
