<div 
    x-data="{
        showModal: false,
        productoActivo: null,
        abrirModal(producto) {
            this.productoActivo = producto;
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },
        cerrarModal() {
            this.showModal = false;
            this.productoActivo = null;
            document.body.style.overflow = '';
        }
    }"
    x-cloak
>
    <!-- Tarjetas de Productos Rediseñadas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-6 mt-6 container mx-auto">
        @foreach($productos as $producto)
            @php
                $userRating = auth()->check()
                    ? $producto->ratings()->where('user_id', auth()->id())->first()
                    : null;
            @endphp
            <div class="group relative overflow-hidden rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1">
                <!-- Imagen destacada con overlay al hacer hover -->
                <div class="relative h-72 overflow-hidden">
                    <img 
                        src="{{ asset('storage/'.$producto->image) }}" 
                        alt="{{ $producto->name }}" 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                        <div class="p-4 w-full">
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
                                class="w-full block text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-all duration-300"
                            >
                                Ver detalle
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Información del producto -->
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
                            <span class="text-blue-800 text-xs font-semibold ml-2">
                                {{ number_format($producto->averageRating() ?? 0, 1) }}/5
                            </span>
                        </div>
                    </div>
                    
                    <!-- Precio -->
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-2xl font-bold text-gray-900">
                            COP {{ number_format($producto->price, 0, ',', '.') }}
                        </span>
                        <button
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
                            class="rounded-full bg-blue-50 p-2 text-blue-600 hover:bg-blue-100 transition-colors duration-300"
                            aria-label="Ver más detalles"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Rediseñado -->
    <div 
        x-show="showModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
        class="fixed inset-0 z-50 flex justify-center items-center px-4 py-6"
    >
        <!-- Overlay con efecto blur -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="cerrarModal"></div>
        
        <!-- Contenido del modal -->
        <div 
            @click.outside="cerrarModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="bg-white rounded-3xl shadow-2xl w-full max-w-xl p-0 relative overflow-hidden"
        >
            <!-- Botón de cerrar -->
            <button 
                @click="cerrarModal" 
                class="absolute top-4 right-4 z-10 bg-white/80 backdrop-blur-sm rounded-full p-2 text-gray-600 hover:text-gray-900 hover:bg-white transition-all duration-300"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Imagen destacada -->
            <div class="w-full h-72 relative">
                <img 
                    :src="productoActivo?.image" 
                    :alt="productoActivo?.name" 
                    class="w-full h-full object-cover" 
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <h2 
                    class="absolute bottom-4 left-6 text-3xl font-bold text-white" 
                    x-text="productoActivo?.name"
                ></h2>
            </div>

            <!-- Información del producto -->
            <div class="p-6">
                <p 
                    class="text-base text-gray-700 mb-6 leading-relaxed" 
                    x-text="productoActivo?.description"
                ></p>
                
                <div class="flex items-center justify-between mb-6">
                    <span 
                        class="text-2xl font-bold text-blue-600" 
                        x-text="productoActivo?.price"
                    ></span>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-center">
                    <!-- Botón para usuarios -->
                    <template x-if="productoActivo?.role === 'user'">
                        <form :action="productoActivo?.addToCartUrl" method="POST" class="w-full">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-xl transition-colors duration-300 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Agregar al carrito
                            </button>
                        </form>
                    </template>

                    <!-- Botón para administradores -->
                    <template x-if="productoActivo?.role === 'admin'">
                        <form :action="productoActivo?.deleteUrl" method="POST" class="w-full">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-xl transition-colors duration-300 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Eliminar producto
                            </button>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>