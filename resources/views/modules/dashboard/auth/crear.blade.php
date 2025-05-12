@extends('layouts.app')

@section('title', 'Agregar Producto')

@section('content')
<div class="min-h-screen py-12 px-4">
    <div class="max-w-xl mx-auto">
        <!-- Alerta de éxito -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md animate-fade-in-down" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Tarjeta de formulario -->
        <div class="bg-gradient-to-b from-[#2b2d42] to-[#1a1b2e] rounded-2xl shadow-xl border border-white/10 overflow-hidden">
            <!-- Cabecera -->
            <div class="bg-[#cfbea7]/10 p-6 border-b border-white/10">
                <h2 class="text-2xl font-bold text-[#f5e7d5] text-center">Agregar Nuevo Producto</h2>
            </div>
            
            <!-- Formulario -->
            <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data" class="space-y-6 p-8">
                @csrf
                
                <!-- Campo de nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-[#f5e7d5] mb-1">Nombre del producto</label>
                    <input type="text" name="name" id="name" 
                        class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#cfbea7] focus:border-transparent transition duration-200"
                        placeholder="Ingresa el nombre del producto" 
                        required>
                    @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Campo de descripción -->
                <div>
                    <label for="description" class="block text-sm font-medium text-[#f5e7d5] mb-1">Descripción</label>
                    <textarea name="description" id="description" rows="4" 
                        class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#cfbea7] focus:border-transparent transition duration-200"
                        placeholder="Describe tu producto..."></textarea>
                    @error('description')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Fila de campos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Campo de precio -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-[#f5e7d5] mb-1">Precio</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-400">$</span>
                            </div>
                            <input type="number" name="price" id="price" step="0.01" 
                                class="w-full bg-white/10 border border-white/20 rounded-xl pl-8 pr-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#cfbea7] focus:border-transparent transition duration-200"
                                placeholder="0.00" 
                                required>
                        </div>
                        @error('price')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Campo de categoría -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-[#f5e7d5] mb-1">Categoría</label>
                        <select name="category_id" id="category_id" 
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-blue-600 placeholder-gray-800 focus:outline-none focus:ring-2 focus:ring-[#cfbea7] focus:border-transparent transition duration-200"
                            required>
                            <option value="" disabled selected>Seleccionar categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                            @endforeach
                        </select>
                        <!-- Campo de tipo de promoción (visible solo si se selecciona Promociones) -->
                            <div id="promotionTypeField" class="hidden">
                                <label for="promotion_type" class="block text-sm font-medium text-[#f5e7d5] mb-1">Tipo de Promoción</label>
                                <select name="promotion_type" id="promotion_type"
                                    class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-blue-600 placeholder-gray-800 focus:outline-none focus:ring-2 focus:ring-[#cfbea7] focus:border-transparent transition duration-200">
                                    <option value="" disabled selected>Selecciona tipo de promoción</option>
                                    <option value="15_descuento">15% Descuento</option>
                                    <option value="2x1">2x1</option>
                                    <option value="Madre">Dia de la madre</option>
                                </select>
                            </div>
                        @error('category_id')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Campo de imagen -->
                <div>
                    <label for="image" class="block text-sm font-medium text-[#f5e7d5] mb-1">Imagen del producto</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-white/20 rounded-xl bg-white/5 hover:bg-white/10 transition duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-400">
                                <label for="image" class="relative cursor-pointer rounded-md font-medium text-[#cfbea7] hover:text-[#e5d6c4] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#cfbea7]">
                                    <span>Subir una imagen</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">o arrastrar y soltar</p>
                            </div>
                            <p class="text-xs text-gray-400">
                                PNG, JPG, GIF hasta 2MB
                            </p>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Botones -->
                <div class="flex justify-end space-x-3 mt-8">
                    <a href="" 
                        class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl font-medium transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit" 
                        class="px-5 py-2.5 bg-[#cfbea7] hover:bg-[#e5d6c4] text-[#2b2d42] rounded-xl font-medium shadow-md hover:shadow-lg transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Agregar Producto
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Nota inferior -->
        <div class="mt-6 text-center text-gray-400 text-sm">
            <p>Los productos nuevos estarán disponibles para su visualización inmediatamente después de ser agregados.</p>
        </div>
    </div>
    <script>
document.getElementById('category_id').addEventListener('change', function () {
    const selectedValue = this.value;
    const promotionField = document.getElementById('promotionTypeField');

    // Mostrar si es la categoría de promociones (id = 4)
    promotionField.classList.toggle('hidden', selectedValue != 4);
});
</script>
</div>
@endsection