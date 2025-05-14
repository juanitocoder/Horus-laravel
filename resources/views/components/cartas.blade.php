<div 
    x-data="{
        showModal: false,
        productoActivo: null,
        comentario: '',
        editandoComentarioId: null,
        comentarioEditado: '',
        auth: {{ auth()->check() ? 'true' : 'false' }},
        userId: {{ auth()->check() ? auth()->id() : 'null' }},
        // Nuevo sistema de alertas
        alert: {
            show: false,
            message: '',
            type: 'success', // 'success', 'error', 'info'
            timeout: null
        },
        
        // Muestra una alerta dentro del modal
        showAlert(message, type = 'success') {
            this.alert.show = true;
            this.alert.message = message;
            this.alert.type = type;
            
            // Limpia cualquier timeout existente
            if (this.alert.timeout) {
                clearTimeout(this.alert.timeout);
            }
            
            // Auto-ocultar después de 3 segundos
            this.alert.timeout = setTimeout(() => {
                this.alert.show = false;
            }, 3000);
        },

        abrirModal(producto) {
            this.productoActivo = { ...producto, comentarios: [] };
            this.showModal = true;
            document.body.style.overflow = 'hidden';
            this.alert.show = false; // Reinicia cualquier alerta al abrir el modal

            fetch(`/comentarios/producto/${producto.id}`)
                .then(response => response.json())
                .then(data => {
                    this.productoActivo.comentarios = data;
                });
        },
        yaComento() {
        return this.productoActivo?.comentarios?.some(c => c.user_id === this.userId);
        },
        cerrarModal() {
            this.showModal = false;
            this.productoActivo = null;
            this.editandoComentarioId = null;
            this.comentarioEditado = '';
            document.body.style.overflow = '';
            this.alert.show = false; // Limpia cualquier alerta al cerrar
        },
        enviarComentario() {
            if (!this.auth) {
                this.showAlert('Debes iniciar sesión para comentar.', 'error');
                return;
            }

            if (!this.comentario.trim()) {
                this.showAlert('El comentario no puede estar vacío', 'error');
                return;
            }

            fetch(`/productos/${this.productoActivo.id}/comentarios`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content: this.comentario })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(error => { throw new Error(error.message) });
                }
                return response.json();
            })
            .then(data => {
                this.productoActivo.comentarios.push(data);
                this.comentario = '';
                this.showAlert('Comentario enviado exitosamente.', 'success');
            })
            .catch(error => {
                this.showAlert(error.message || 'Error al enviar el comentario', 'error');
            });
        },
        iniciarEdicion(comentario) {
            this.editandoComentarioId = comentario.id;
            this.comentarioEditado = comentario.content;
        },
        cancelarEdicion() {
            this.editandoComentarioId = null;
            this.comentarioEditado = '';
        },
        actualizarComentario(id) {
            if (!this.comentarioEditado.trim()) {
                this.showAlert('El comentario no puede estar vacío', 'error');
                return;
            }

            fetch(`/comentarios/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content: this.comentarioEditado })
            })
            .then(response => {
                if (!response.ok) throw new Error('Error al actualizar el comentario');
                return response.json();
            })
            .then(data => {
                const index = this.productoActivo.comentarios.findIndex(c => c.id === id);
                if (index !== -1) this.productoActivo.comentarios[index] = data;
                this.cancelarEdicion();
                this.showAlert('Comentario actualizado correctamente.', 'success');
            })
            .catch(error => {
                console.error(error);
                this.showAlert('Error al actualizar el comentario', 'error');
            });
        },
        eliminarComentario(id) {
            if (!confirm('¿Estás seguro de que deseas eliminar este comentario?')) return;

            fetch(`/comentarios/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Error al eliminar el comentario');
                this.productoActivo.comentarios = this.productoActivo.comentarios.filter(c => c.id !== id);
                this.showAlert('Comentario eliminado correctamente.', 'success');
            })
            .catch(error => {
                console.error(error);
                this.showAlert('Error al eliminar el comentario', 'error');
            });
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
    
            $precio = $producto->price;
            $precioConDescuento = $producto->promotion_type === '15_descuento'
                ? round($precio * 0.85)
                : $precio;
        @endphp
    
        <div class="group relative overflow-hidden rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1">
            
            <!-- Imagen destacada con overlay al hacer hover -->
            <div class="relative h-72 overflow-hidden rounded-t-2xl">
                <img 
                    src="{{ asset('storage/'.$producto->image) }}" 
                    alt="{{ $producto->name }}" 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                />
    
                <!-- Overlay hover -->
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
    
            <!-- Información del producto -->
            <div class="p-5 bg-white">
                {{-- Calcula la clase de color para el título --}}
                    @php
                        switch($producto->promotion_type) {
                            case '15_descuento':
                                $titleColor = 'text-red-600';
                                break;
                            case '2x1':
                                $titleColor = 'text-green-600';
                                break;
                            case 'Madre':
                                $titleColor = 'text-pink-600';
                                break;
                            default:
                                $titleColor = 'text-gray-900';
                        }
                    @endphp
               {{-- Título con color dinámico --}}
                    <h5 class="text-xl font-bold tracking-tight mb-2 {{ $titleColor }}">
                        {{ $producto->name }}
                    </h5>

    
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
                            <span class="text-sm text-green-700 font-semibold">
                                Llévate 2 por el precio de 1
                            </span>
                        </div>
                    @elseif ($producto->promotion_type === 'Madre')
                        <div class="flex flex-col">
                            {{-- Precio normal en rosa --}}
                            <span class="text-2xl font-bold text-pink-600">
                                COP {{ number_format($precio, 0, ',', '.') }}
                            </span>
                            {{-- Etiqueta especial --}}
                            <span class="text-sm text-pink-500 font-semibold">
                                Edición especial Día de la Madre 💐
                            </span>
                        </div>
                    @else
                        <span class="text-2xl font-bold text-gray-900">
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
                            <path d="M10 5a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 
                            0v-3H6a1 1 0 010-2h3V6a1 1 0 011-1z" />
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
    class="bg-white rounded-3xl shadow-2xl w-full max-w-md max-h-[80vh] overflow-y-auto p-4 relative"
        >
            <!-- Sistema de alertas en el modal -->
            <div 
                x-show="alert.show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-4"
                :class="{
                    'bg-green-100 border-green-500 text-green-700': alert.type === 'success',
                    'bg-red-100 border-red-500 text-red-700': alert.type === 'error',
                    'bg-blue-100 border-blue-500 text-blue-700': alert.type === 'info'
                }"
                class="absolute top-4 left-1/2 transform -translate-x-1/2 z-50 px-4 py-3 rounded border-l-4 shadow-md w-5/6 flex items-center"
            >
                <!-- Icono según el tipo de alerta -->
                <div class="mr-3">
                    <template x-if="alert.type === 'success'">
                        <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </template>
                    <template x-if="alert.type === 'error'">
                        <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </template>
                    <template x-if="alert.type === 'info'">
                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                </div>
                <div x-text="alert.message"></div>
                <!-- Botón de cerrar alerta -->
                <button 
                    @click="alert.show = false"
                    class="ml-auto"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

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
            <div class="p-6 space-y-4 text-center">

                <!-- Descripción -->
                <p class="text-gray-700 text-sm max-w-xl mx-auto" x-text="productoActivo?.description"></p>

                <!-- Precio -->
                <div class="text-xl font-bold text-black" x-text="productoActivo?.price"></div>

                <!-- Botón agregar al carrito -->

                @guest
                    <button
                    @if(session('alert'))
                        <x-alert type="success" :message="session('alert')" />
                   
                        class="mt-2 px-6 py-2 bg-blue-800 hover:bg-blue-900 text-white rounded-full font-semibold shadow-md transition">
                        🛒 Agregar al carrito
                    </button>
                    @endif
                @endguest
                <template x-if="productoActivo?.role === 'user'|| productoActivo?.role === 'admin' || productoActivo?.role === 'superadmin'">
                    <form :action="productoActivo?.addToCartUrl" method="POST" class="flex justify-center">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button
                            class="mt-2 px-6 py-2 bg-blue-800 hover:bg-blue-900 text-white rounded-full font-semibold shadow-md transition"
                        >
                            🛒 Agregar al carrito
                        </button>
                    </form>
                </template>
            </div>

            <!-- Comentarios -->
            <div class="px-6 pt-4 pb-4">
                <div class="flex flex-col md:flex-row gap-6">
                    <template x-if="!yaComento()">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Deja un comentario</h3>
                            <textarea
                                x-model="comentario"
                                placeholder="Escribe tu comentario aquí..."
                                class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none min-h-[100px]"
                            ></textarea>
                            <button
                                @click="enviarComentario"
                                class="mt-3 px-5 py-2 bg-blue-800 hover:bg-blue-900 text-white font-semibold rounded-lg shadow-md transition"
                            >
                                Enviar Comentario
                            </button>
                        </div>
                    </template>

                    <!-- Lista de Comentarios -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Comentarios</h3>
                        <template x-if="productoActivo?.comentarios?.length">
                            <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                                <template x-for="comentario in productoActivo.comentarios" :key="comentario.id">
                                    <div class="bg-blue-100 border-l-4 border-yellow-400 p-3 rounded-lg shadow-sm relative">
                                        <template x-if="editandoComentarioId === comentario.id">
                                            <div>
                                                <textarea x-model="comentarioEditado" class="w-full p-2 border rounded"></textarea>
                                                <div class="mt-2 flex gap-2">
                                                    <button @click="actualizarComentario(comentario.id)" class="bg-green-600 text-white px-3 py-1 rounded">Guardar</button>
                                                    <button @click="cancelarEdicion" class="bg-gray-400 text-white px-3 py-1 rounded">Cancelar</button>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="editandoComentarioId !== comentario.id">
                                            <div>
                                                <p class="text-gray-700 text-sm" x-text="comentario.content"></p>
                                                <div class="text-xs text-gray-600 mb-2" x-text="'Por: ' + (comentario.user?.name || 'Anónimo')"></div>
                                
                                                <!-- Botones editar/borrar -->
                                                <template x-if="comentario.user_id === userId">
                                                    <div class="pt-2 border-t border-blue-200 flex justify-end gap-6">
                                                        <button @click="iniciarEdicion(comentario)" class="text-blue-600 hover:underline text-sm">Editar</button>
                                                        <button @click="eliminarComentario(comentario.id)" class="text-red-600 hover:underline text-sm">Eliminar</button>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>  
                            </div>
                        </template>
                        <template x-if="!productoActivo?.comentarios?.length">
                            <div class="text-gray-500 text-center py-4">
                                No hay comentarios aún. ¡Sé el primero en comentar!
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            
            <!-- Botones para administradores -->
            <div class="px-6 pb-6 mt-2">
                <template x-if="productoActivo?.role === 'admin'|| productoActivo?.role === 'superadmin'">
                    <div class="flex gap-2 w-full">
                        <!-- Botón Editar -->
                        <a :href="'/admin/product/' + productoActivo?.id + '/edit'" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-xl transition-colors duration-300 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                        
                        <!-- Botón Eliminar -->
                        <form :action="productoActivo?.deleteUrl" method="POST" class="w-1/2">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-xl transition-colors duration-300 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
