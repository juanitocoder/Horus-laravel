@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-2xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-semibold text-white">Mi Perfil</h2>
            <p class="text-gray-400 mt-2">Actualiza tu información personal</p>
        </div>
        
        <!-- Alertas -->
        @if (session('success'))
            <div class="mb-6 bg-green-900 bg-opacity-50 border-l-4 border-green-500 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-400">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-900 bg-opacity-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <ul class="list-disc pl-5 text-sm text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulario -->
        <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700">
            <form action="{{ route('perfil.actualizar') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Información Personal -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-200 border-b border-gray-700 pb-2">Información Personal</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300">Nombre</label>
                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" 
                                    class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                                    required>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300">Correo electrónico</label>
                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" 
                                    class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                                    required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Seguridad -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-200 border-b border-gray-700 pb-2">Seguridad</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-300">Nueva contraseña</label>
                                <input type="password" name="password" id="password" 
                                    class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                                <p class="mt-1 text-xs text-gray-400">Deja este campo vacío si no deseas cambiar tu contraseña</p>
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirmar contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Botones -->
                <div class="mt-8 flex items-center justify-end space-x-4">
                    <a href="" class="text-sm font-medium text-gray-400 hover:text-gray-200 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-blue-500 transition-colors">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection