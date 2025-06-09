@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header mejorado -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Crear Nueva Promoción</h2>
                <p class="text-slate-400">Configura los detalles de tu promoción especial</p>
            </div>
            <a href="{{ route('promotions.index') }}" 
               class="flex items-center gap-2 bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition-all duration-200 hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>

        <!-- Errores mejorados -->
        @if($errors->any())
            <div class="bg-red-900/50 border border-red-500 text-red-200 px-6 py-4 rounded-xl mb-6 backdrop-blur-sm">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h4 class="font-semibold">Por favor corrige los siguientes errores:</h4>
                </div>
                <ul class="list-disc ml-7 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario mejorado -->
        <form action="{{ route('promotions.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Card principal con glass effect -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 shadow-2xl">
                
                <!-- Información básica -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Información Básica
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-slate-200 font-medium">Nombre de la Promoción</label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Ej: Descuento Navideño"
                                   class="w-full bg-slate-800/50 border border-slate-600 text-white placeholder-slate-400 p-4 rounded-xl focus:border-indigo-500 focus:bg-slate-800/70 focus:outline-none transition-all duration-200" 
                                   required>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-slate-200 font-medium">Identificador Único</label>
                            <input type="text" 
                                   name="type" 
                                   value="{{ old('type') }}"
                                   placeholder="Ej: navidad_2025"
                                   class="w-full bg-slate-800/50 border border-slate-600 text-white placeholder-slate-400 p-4 rounded-xl focus:border-indigo-500 focus:bg-slate-800/70 focus:outline-none transition-all duration-200" 
                                   required>
                            <small class="text-slate-400 text-sm">Solo letras, números y guiones bajos</small>
                        </div>
                    </div>
                </div>

                <!-- Configuración de descuentos -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        Configuración de Descuentos
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-slate-200 font-medium">Porcentaje de Descuento (%)</label>
                            <div class="relative">
                                <input type="number" 
                                       name="discount_percentage" 
                                       value="{{ old('discount_percentage') }}"
                                       min="0" 
                                       max="100"
                                       placeholder="15"
                                       class="w-full bg-slate-800/50 border border-slate-600 text-white placeholder-slate-400 p-4 pr-12 rounded-xl focus:border-green-500 focus:bg-slate-800/70 focus:outline-none transition-all duration-200">
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 font-medium">%</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-slate-200 font-medium">Valor Fijo (opcional)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 font-medium">$</span>
                                <input type="number" 
                                       name="value" 
                                       value="{{ old('value') }}"
                                       step="0.01"
                                       min="0"
                                       placeholder="50000"
                                       class="w-full bg-slate-800/50 border border-slate-600 text-white placeholder-slate-400 p-4 pl-12 rounded-xl focus:border-green-500 focus:bg-slate-800/70 focus:outline-none transition-all duration-200">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personalización visual -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-rose-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4 4 4 0 004-4V5z"></path>
                            </svg>
                        </div>
                        Personalización Visual
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-slate-200 font-medium">Color del Título</label>
                            <select name="title_color" class="w-full bg-slate-800/50 border border-slate-600 text-white p-4 rounded-xl focus:border-pink-500 focus:bg-slate-800/70 focus:outline-none transition-all duration-200" required>
                                <option value="text-gray-900" {{ old('title_color') == 'text-gray-900' ? 'selected' : '' }} class="bg-slate-800">Negro</option>
                                <option value="text-red-600" {{ old('title_color') == 'text-red-600' ? 'selected' : '' }} class="bg-slate-800">Rojo</option>
                                <option value="text-green-600" {{ old('title_color') == 'text-green-600' ? 'selected' : '' }} class="bg-slate-800">Verde</option>
                                <option value="text-blue-600" {{ old('title_color') == 'text-blue-600' ? 'selected' : '' }} class="bg-slate-800">Azul</option>
                                <option value="text-pink-600" {{ old('title_color') == 'text-pink-600' ? 'selected' : '' }} class="bg-slate-800">Rosa</option>
                                <option value="text-purple-600" {{ old('title_color') == 'text-purple-600' ? 'selected' : '' }} class="bg-slate-800">Morado</option>
                                <option value="text-yellow-600" {{ old('title_color') == 'text-yellow-600' ? 'selected' : '' }} class="bg-slate-800">Amarillo</option>
                                <option value="text-orange-600" {{ old('title_color') == 'text-orange-600' ? 'selected' : '' }} class="bg-slate-800">Naranja</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-slate-200 font-medium">Color del Precio</label>
                            <select name="price_color" class="w-full bg-slate-800/50 border border-slate-600 text-white p-4 rounded-xl focus:border-pink-500 focus:bg-slate-800/70 focus:outline-none transition-all duration-200" required>
                                <option value="text-gray-900" {{ old('price_color') == 'text-gray-900' ? 'selected' : '' }} class="bg-slate-800">Negro</option>
                                <option value="text-red-600" {{ old('price_color') == 'text-red-600' ? 'selected' : '' }} class="bg-slate-800">Rojo</option>
                                <option value="text-green-600" {{ old('price_color') == 'text-green-600' ? 'selected' : '' }} class="bg-slate-800">Verde</option>
                                <option value="text-blue-600" {{ old('price_color') == 'text-blue-600' ? 'selected' : '' }} class="bg-slate-800">Azul</option>
                                <option value="text-pink-600" {{ old('price_color') == 'text-pink-600' ? 'selected' : '' }} class="bg-slate-800">Rosa</option>
                                <option value="text-purple-600" {{ old('price_color') == 'text-purple-600' ? 'selected' : '' }} class="bg-slate-800">Morado</option>
                                <option value="text-yellow-600" {{ old('price_color') == 'text-yellow-600' ? 'selected' : '' }} class="bg-slate-800">Amarillo</option>
                                <option value="text-orange-600" {{ old('price_color') == 'text-orange-600' ? 'selected' : '' }} class="bg-slate-800">Naranja</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        Texto Descriptivo
                    </h3>
                    
                    <div class="space-y-2">
                        <textarea name="description_text" 
                                  rows="4"
                                  placeholder="Ej: Llévate 2 por el precio de 1, Edición especial Navidad 🎄"
                                  class="w-full bg-slate-800/50 border border-slate-600 text-white placeholder-slate-400 p-4 rounded-xl focus:border-blue-500 focus:bg-slate-800/70 focus:outline-none transition-all duration-200 resize-none">{{ old('description_text') }}</textarea>
                    </div>
                </div>

                <!-- Estado de la promoción -->
                <div class="mb-8">
                    <div class="flex items-center gap-4 p-4 bg-slate-800/30 rounded-xl border border-slate-600">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}
                               id="is_active"
                               class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-slate-600 rounded bg-slate-700">
                        <label for="is_active" class="text-slate-200 font-medium cursor-pointer">
                            Promoción activa
                        </label>
                        <div class="ml-auto">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-900/50 text-green-200 border border-green-600">
                                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                Disponible para usar
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Botones de acción -->
            <div class="flex gap-4 justify-end">
                <a href="{{ route('promotions.index') }}" 
                   class="bg-slate-600 hover:bg-slate-500 text-white px-8 py-4 rounded-xl transition-all duration-200 hover:scale-105 flex items-center gap-2 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-xl flex items-center gap-2 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Crear Promoción
                </button>
            </div>
        </form>
    </div>
</div>
@endsection