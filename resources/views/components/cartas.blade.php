<div 
    x-data="{
        showModal: false,
        productoActivo: null,
        abrirModal(producto) {
            this.productoActivo = producto;
            this.showModal = true;
        },
        cerrarModal() {
            this.showModal = false;
            this.productoActivo = null;
        }
    }"
    x-cloak
>
    <!-- Tarjetas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-3 mt-3 container mx-auto items-center">
        @foreach($productos as $producto)
            @php
                $userRating = auth()->check()
                    ? $producto->ratings()->where('user_id', auth()->id())->first()
                    : null;
            @endphp
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="bg-[#F4F4B7] flex justify-center items-center h-48">
                <img 
                    src="{{ asset('storage/'.$producto->image) }}" 
                    alt="{{ $producto->name }}" 
                    class="w-full h-full object-cover " 
                />
            </div>
                <div class="px-5 pb-5 pt-4">
                    <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $producto->name }}</h5>
                    <div class="flex items-center mt-2.5 mb-5">
                        <div x-data="{ 
                                        rating: {{ $userRating ? $userRating->rating : 0 }}, 
                                        hoverRating: 0, 
                                        alreadyRated: {{ $userRating ? 'true' : 'false' }} 
                                    }" class="flex space-x-1 mt-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg
                                    @click="if (!alreadyRated) { rating = {{ $i }}; submitRating({{ $producto->id }}, {{ $i }}) }"
                                    @mouseenter="if (!alreadyRated) hoverRating = {{ $i }}"
                                    @mouseleave="hoverRating = 0"
                                    :class="(hoverRating >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-400' : 'text-gray-300'"
                                    class="w-6 h-6 cursor-pointer transition-colors duration-200"
                                    :class="{ 'cursor-not-allowed': alreadyRated }"
                                    fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 
                                    1 0 00.95.69h4.167c.969 0 1.371 1.24.588 1.81l-3.374 
                                    2.455a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 
                                    1.688-1.538 1.118l-3.374-2.455a1 1 0 00-1.175 
                                    0l-3.374 2.455c-.783.57-1.838-.197-1.538-1.118l1.287-3.957a1 
                                    1 0 00-.364-1.118L2.05 9.384c-.783-.57-.38-1.81.588-1.81h4.167a1 
                                    1 0 00.95-.69l1.286-3.957z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm dark:bg-blue-200 dark:text-blue-800 ms-3">
                            {{ number_format($producto->averageRating() ?? 0, 1) }}/5
                        </span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                        COP {{ number_format($producto->price, 0, ',', '.') }}
                        </span>
                        <span
                            @click.stop="abrirModal({ 
                                name: '{{ $producto->name }}', 
                                description: `{{ $producto->description }}`, 
                                price: 'COP {{ number_format($producto->price, 0, ',', '.') }}', 
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
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer"
                        >
                            Ver más
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div 
        x-show="showModal" 
        x-transition.opacity 
        x-cloak
        class="fixed inset-0 z-50 bg-black bg-opacity-60 flex justify-center items-center px-4"
    >
        <div 
            @click.outside="cerrarModal"
            class="bg-white rounded-2xl shadow-lg w-full max-w-md md:max-w-lg lg:max-w-xl p-6 relative"
        >
            <button @click="cerrarModal" class="absolute top-2 right-2 text-gray-600 hover:text-black text-2xl font-bold">
                &times;
            </button>

            <div class="flex flex-col items-center text-center">
                <img 
                    :src="productoActivo?.image" 
                    :alt="productoActivo?.name" 
                    class="w-48 h-48 sm:w-56 sm:h-56 md:w-60 md:h-60 object-contain rounded-lg mb-4"
                />

                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2" x-text="productoActivo?.name"></h2>
                <p class="text-sm sm:text-base text-gray-600 mb-2" x-text="productoActivo?.description"></p>
                <p class="text-lg sm:text-xl font-bold text-blue-600 mb-4" x-text="'$' + productoActivo?.price"></p>

                <!-- Botón para usuarios -->
                <template x-if="productoActivo?.role === 'user'">
                    <form :action="productoActivo.addToCartUrl" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded-xl transition w-full sm:w-auto">
                            Agregar al carrito
                        </button>
                    </form>
                </template>

                <!-- Botón para administradores -->
                <template x-if="productoActivo?.role === 'admin'">
                    <form :action="productoActivo.deleteUrl" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-6 py-2 rounded-xl transition w-full sm:w-auto">
                            Eliminar
                        </button>
                    </form>
                </template>
            </div>
        </div>
    </div>
</div>
