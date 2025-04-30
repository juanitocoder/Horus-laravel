@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-4xl font-bold mb-6 text-center text-white font-cinzel">Tu Carrito de Compras</h1>
    
    @php
    $total = 0;
    foreach ($cart->items as $item) {
        $total += $item->product->price * $item->quantity;
    }
    @endphp
    
    @if ($cart && $cart->items->count() > 0)
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-gray-700">
            <div class="grid gap-6">
                @foreach ($cart->items as $item)
                    <div class="bg-white/10 backdrop-blur-sm shadow-xl rounded-2xl p-5 flex flex-col sm:flex-row items-center sm:items-start gap-6 border border-gray-700 transition-all hover:border-blue-500">
                        <div class="relative w-28 h-28">
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                alt="{{ $item->product->name }}"
                                class="w-28 h-28 rounded-xl object-cover shadow-lg border border-gray-300">
                            <div class="absolute -top-3 -right-3 bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg">
                                {{ $item->quantity }}
                            </div>
                        </div>
                        
                        <div class="flex-1 w-full">
                            <p class="text-xl font-semibold text-white">{{ $item->product->name }}</p>
                            <p class="text-blue-400 font-semibold mb-4">${{ number_format($item->product->price, 0, ',', '.') }} COP</p>
                            
                            <div class="flex items-center gap-3 bg-gray-800/50 p-2 rounded-xl w-fit">
                                <!-- Disminuir cantidad -->
                                <form method="POST" action="{{ route('cart.decrease', $item) }}">
                                    @csrf
                                    <button class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-md transition-all">
                                        <x-heroicon-o-minus class="w-5 h-5" />
                                    </button>
                                </form>
                                
                                <!-- Cantidad -->
                                <span class="text-lg font-medium px-3 text-white">{{ $item->quantity }}</span>
                                
                                <!-- Aumentar cantidad -->
                                <form method="POST" action="{{ route('cart.increase', $item) }}">
                                    @csrf
                                    <button class="bg-green-500 hover:bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-md transition-all">
                                        <x-heroicon-o-plus class="w-5 h-5" />
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Precio total del ítem -->
                        <div class="text-right hidden sm:block">
                            <p class="text-gray-400 text-sm">Subtotal</p>
                            <p class="text-xl font-bold text-white">${{ number_format($item->product->price * $item->quantity, 0, ',', '.') }} COP</p>
                        </div>
                        
                        <!-- Eliminar -->
                        <form method="POST" action="{{ route('cart.remove', $item) }}" class="ml-auto">
                            @csrf
                            <button class="text-red-400 hover:text-red-600 transition-colors flex items-center gap-1">
                                <x-heroicon-o-trash class="w-5 h-5" />
                                <span class="font-medium">Eliminar</span>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            
            <!-- Resumen y Total -->
            <div class="mt-8 bg-blue-900/30 rounded-2xl p-6 border border-blue-800/50 shadow-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-white">Resumen del Pedido</h3>
                        <p class="text-gray-300">{{ $cart->items->count() }} {{ $cart->items->count() == 1 ? 'producto' : 'productos' }} en tu carrito</p>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-gray-300 text-sm">Total a pagar</p>
                        <p class="text-3xl font-bold text-white">${{ number_format($total, 0, ',', '.') }} <span class="text-blue-300 text-lg">COP</span></p>
                    </div>
                </div>
                
                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
                    <a href="/hombres" class="group bg-gray-700 hover:bg-gray-600 text-white font-medium px-6 py-3 rounded-xl transition-all flex items-center gap-2 w-full sm:w-auto justify-center">
                        <x-heroicon-o-arrow-left class="w-5 h-5 group-hover:-translate-x-1 transition-transform" />
                        <span>Seguir comprando</span>
                    </a>
                    
                    <a href="#" class="group bg-blue-600 hover:bg-blue-500 text-white font-semibold px-8 py-3 rounded-xl transition-all flex items-center gap-2 w-full sm:w-auto justify-center shadow-lg">
                        <span>Finalizar Compra</span>
                        <x-heroicon-o-shopping-cart class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-3xl p-10 text-center shadow-lg border border-gray-700">
            <div class="flex flex-col items-center gap-4">
                <div class="bg-blue-900/40 p-6 rounded-full">
                    <x-heroicon-o-shopping-bag class="w-20 h-20 text-blue-300" />
                </div>
                <h2 class="text-2xl font-bold text-white">Tu carrito está vacío</h2>
                <p class="text-gray-300 mb-6">Agrega productos para comenzar a comprar</p>
                <a href="/hombres" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-8 py-3 rounded-xl transition-all flex items-center gap-2 shadow-lg">
                    <x-heroicon-o-shopping-cart class="w-5 h-5" />
                    <span>Explorar productos</span>
                </a>
            </div>
        </div>
    @endif
</div>

<script>
    function showCartNotification(message, type = 'success') {
        // Utiliza la función showToast para mostrar notificaciones
        if (typeof showToast === 'function') {
            showToast(type, message);
        }
    }
</script>
@endsection