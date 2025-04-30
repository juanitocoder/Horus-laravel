@extends('layouts.app')

@section('content')
<div class="bg-[#212235] min-h-screen py-10">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Cabecera con título y breadcrumbs -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-white">Editar Producto</h1>
                    <a href="{{ URL::previous() }}" class="flex items-center text-indigo-400 hover:text-indigo-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L4.414 9H17a1 1 0 110 2H4.414l5.293 5.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Volver
                    </a>
                </div>
            </div>
            
            <!-- Notificación de éxito -->
            @if(session('success'))
                <div class="bg-emerald-900 border-l-4 border-emerald-500 rounded-lg shadow-md p-5 mb-8 flex items-start" role="alert">
                    <div class="bg-emerald-800 rounded-full p-2 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-emerald-300">¡Operación exitosa!</h3>
                        <p class="text-emerald-400">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Tarjeta principal del formulario -->
            <div class="bg-[#2a2c42] rounded-2xl shadow-lg overflow-hidden border border-[#3d3f56]">
                <div class="flex flex-col lg:flex-row">
                    <!-- Vista previa del producto -->
                    <div class="lg:w-2/5 bg-gradient-to-br from-[#2d304d] to-[#252746] p-8 flex flex-col">
                        <h2 class="text-xl font-semibold text-gray-200 mb-4">Vista previa</h2>
                        
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            @if($product->image)
                                <div class="mb-6 relative group">
                                    <div class="rounded-xl overflow-hidden shadow-md border border-[#3d3f56] bg-[#323450] p-2 transition-all duration-300 hover:shadow-lg">
                                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-lg">
                                    </div>
                                </div>
                            @else
                                <div class="w-full h-64 bg-[#323450] rounded-lg flex items-center justify-center mb-6 border border-[#3d3f56]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            
                            <h3 class="text-xl font-bold text-gray-200">{{ $product->name }}</h3>
                            <p class="text-indigo-400 font-semibold mt-2">COP {{ number_format($product->price, 0, ',', '.') }}</p>
                            
                            @if($product->category)
                                <span class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-900 text-indigo-300">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Formulario de edición -->
                    <div class="lg:w-3/5 p-8 bg-[#262840] border-l border-[#3d3f56]">
                        <h2 class="text-xl font-semibold text-gray-200 mb-6">Información del producto</h2>
                        
                        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-6">
                                <!-- Nombre del producto -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Nombre del producto</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                                           class="block w-full px-4 py-3 rounded-lg border border-[#3d3f56] shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-[#2a2c42] text-gray-200 @error('name')  @enderror" 
                                           placeholder="Nombre del producto">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Descripción -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Descripción</label>
                                    <textarea name="description" id="description" rows="4" 
                                              class="block w-full px-4 py-3 rounded-lg border border-[#3d3f56] shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-[#2a2c42] text-gray-200 @error('description')  @enderror"
                                              placeholder="Describe tu producto...">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Precio y Categoría en flex -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Precio -->
                                    <div>
                                        <label for="price" class="block text-sm font-medium text-gray-300 mb-1">Precio (COP)</label>
                                        <div class="relative rounded-lg shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-400 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" 
                                                   class="block w-full pl-10 pr-4 py-3 rounded-lg border border-[#3d3f56] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-[#2a2c42] text-gray-200 @error('price')  @enderror"
                                                   placeholder="0.00">
                                        </div>
                                        @error('price')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Categoría -->
                                    <div>
                                        <label for="category_id" class="block text-sm font-medium text-gray-300 mb-1">Categoría</label>
                                        <select name="category_id" id="category_id" 
                                                class="block w-full px-4 py-3 rounded-lg border border-[#3d3f56] shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-[#2a2c42] text-gray-200 @error('category_id')  @enderror">
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}" {{ old('category_id', $product->category_id) == $categoria->id ? 'selected' : '' }}>
                                                    {{ $categoria->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Imagen -->
                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-300 mb-1">Imagen del producto</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-[#3d3f56] border-dashed rounded-lg hover:bg-[#323450] transition-colors">
                                        <div class="space-y-1 text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div class="flex text-sm text-gray-400">
                                                <label for="image" class="relative cursor-pointer rounded-md font-medium text-indigo-400 hover:text-indigo-300 focus-within:outline-none">
                                                    <span>Subir imagen</span>
                                                    <input id="image" name="image" type="file" class="sr-only">
                                                </label>
                                                <p class="pl-1">o arrastrar y soltar</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, JPEG hasta 2MB</p>
                                            @if($product->image)
                                                <p class="text-xs text-indigo-400 font-medium">Imagen actual: {{ basename($product->image) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @error('image')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-400">Deja este campo vacío si no quieres cambiar la imagen actual.</p>
                                </div>
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="sm:flex-shrink-0">
                                    <button type="submit" class="w-full sm:w-auto flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Guardar cambios
                                    </button>
                                </div>
                                <div class="mt-3 sm:mt-0">
                                    <a href="{{ URL::previous() }}" class="w-full sm:w-auto flex justify-center items-center px-6 py-3 border border-[#3d3f56] rounded-lg shadow-sm text-base font-medium text-gray-300 bg-[#2a2c42] hover:bg-[#323450] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Vista previa de la imagen al seleccionarla
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const previewImg = document.querySelector('.rounded-lg.object-cover');
                if (previewImg) {
                    previewImg.src = event.target.result;
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection