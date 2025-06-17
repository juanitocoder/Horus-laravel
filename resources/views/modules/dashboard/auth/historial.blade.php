@extends('layouts.app')

@section('title', 'Historial de Compras')

@section('content')
<div class="min-h-screen  py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Historial de Compras</h1>
                    <p class="text-gray-400">Revisa todas tus órdenes y compras anteriores</p>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <div class="bg-gray-800 border border-gray-700 px-4 py-2 rounded-lg shadow-sm">
                        <span class="text-sm text-gray-400">Total de órdenes</span>
                        <div class="text-2xl font-bold text-yellow-400">{{ $ordenes->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($ordenes->isEmpty())
            <!-- Estado vacío -->
            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-xl p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-700 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-white mb-2">No hay compras todavía</h3>
                <p class="text-gray-400 mb-6">Cuando realices tu primera compra, aparecerá aquí tu historial.</p>
                <a href="{{ route('productos.index') }}" class="inline-flex items-center px-6 py-3 bg-yellow-500 text-gray-900 font-medium rounded-lg hover:bg-yellow-400 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Explorar Productos
                </a>
            </div>
        @else
            <!-- Lista de órdenes -->
            <div class="space-y-6">
                @foreach($ordenes as $orden)
                    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-lg hover:shadow-xl hover:border-gray-600 transition-all duration-300 overflow-hidden">
                        <!-- Header de la orden -->
                        <div class="bg-gray-750 px-6 py-4 border-b border-gray-700">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-white">Orden #{{ $orden->id }}</h2>
                                        <p class="text-sm text-gray-400">{{ $orden->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 md:mt-0">
                                    @php
                                        $statusConfig = [
                                            'completada' => ['bg' => 'bg-yellow-500', 'text' => 'text-gray-900', 'dot' => 'bg-yellow-300'],
                                            'aceptada' => ['bg' => 'bg-yellow-500', 'text' => 'text-gray-900', 'dot' => 'bg-yellow-300'],
                                            'pendiente' => ['bg' => 'bg-orange-500', 'text' => 'text-white', 'dot' => 'bg-orange-300'],
                                            'rechazada' => ['bg' => 'bg-red-500', 'text' => 'text-white', 'dot' => 'bg-red-300'],
                                            'cancelada' => ['bg' => 'bg-gray-600', 'text' => 'text-white', 'dot' => 'bg-gray-400']
                                        ];
                                        $config = $statusConfig[$orden->status] ?? $statusConfig['pendiente'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                        <span class="w-2 h-2 {{ $config['dot'] }} rounded-full mr-2"></span>
                                        {{ ucfirst($orden->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido de la orden -->
                        <div class="p-6">
                            <!-- Items de la orden -->
                            <div class="space-y-3 mb-6">
                                @foreach($orden->items as $item)
                                    <div class="flex items-center justify-between p-4 bg-gray-750 border border-gray-700 rounded-xl hover:bg-gray-700 transition-colors">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-white">{{ $item->product->nombre }}</h4>
                                                <p class="text-sm text-gray-400">Cantidad: {{ $item->cantidad }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-white">${{ number_format($item->precio_unitario * $item->cantidad, 0, ',', '.') }}</div>
                                            <div class="text-sm text-gray-400">${{ number_format($item->precio_unitario, 0, ',', '.') }} c/u</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Total y acciones -->
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between pt-4 border-t border-gray-700">
                                <div class="mb-4 md:mb-0">
                                    <div class="text-2xl font-bold text-white">
                                        Total: ${{ number_format($orden->total, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-400">
                                        {{ $orden->items->count() }} {{ $orden->items->count() == 1 ? 'artículo' : 'artículos' }}
                                    </div>
                                </div>
                                <div class="flex space-x-3">
                                    <button class="inline-flex items-center px-4 py-2 bg-gray-700 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-600 hover:text-white transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Descargar Factura
                                    </button>
                                    @if($orden->status === 'completada')
                                        <button class="inline-flex items-center px-4 py-2 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-400 transition-colors font-medium">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Volver a Comprar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación (si existe) -->
            @if(method_exists($ordenes, 'links'))
                <div class="mt-8">
                    <div class="flex justify-center">
                        <div class="bg-gray-800 border border-gray-700 rounded-lg p-4">
                            {{ $ordenes->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Estilos adicionales para el tema oscuro -->
<style>
    .bg-gray-750 {
        background-color: #374151;
    }
    
    .hover\:shadow-xl:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
    }
    
    /* Personalización de la paginación para tema oscuro */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }
    
    .pagination a,
    .pagination span {
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        border-radius: 0.375rem;
        color: #9CA3AF;
        background-color: #374151;
        border: 1px solid #4B5563;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .pagination a:hover {
        background-color: #4B5563;
        color: #F3F4F6;
        border-color: #6B7280;
    }
    
    .pagination .active span {
        background-color: #EAB308;
        color: #1F2937;
        border-color: #EAB308;
        font-weight: 600;
    }
    
    .pagination .disabled span {
        background-color: #1F2937;
        color: #6B7280;
        border-color: #374151;
        cursor: not-allowed;
    }
</style>
@endsection
