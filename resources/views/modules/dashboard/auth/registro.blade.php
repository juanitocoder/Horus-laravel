@extends('layouts.login-register')

@section('title', 'Registro')

@section('register')
    <div class="relative bg-gradient-to-b from-[#1C2B39] to-[#253545] p-8 rounded-xl shadow-lg w-full max-w-md">
        <!-- Encabezado -->
        <div class="w-full text-center mb-6">
            <img src="{{ asset('images/Logo.png') }}" alt="Horus Logo" class="h-10 w-auto mx-auto">
            <div class="mt-2 flex justify-center">
                <!-- Selector de tipo de cuenta con animación -->
                <div class="bg-gray-800   rounded-lg inline-flex relative">
                    <button type="button" id="btn-usuario" 
                            class="toggle-btn px-4 py-2 text-sm rounded-md transition-all duration-300 focus:outline-none active-type">
                        Usuario
                    </button>
                    <button type="button" id="btn-admin" 
                            class="toggle-btn px-4 py-2 text-sm rounded-md transition-all duration-300 focus:outline-none">
                        Administrador
                    </button>
                    <div id="slide-indicator" class="absolute h-1 rounded-full transition-all duration-300 ease-in-out bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                </div>
            </div>
        </div>

        <!-- Formulario para Usuario (visible por defecto) -->
        <form id="form-usuario" action="{{ route('registrar') }}" method="POST" class="form-container transition-all duration-300 flex flex-col items-center">
            @csrf
            @method('POST')
            
            <input type="hidden" name="user_type" value="usuario">
            
            {{-- Nombre --}}
            <div class="w-full mb-4">
                <label for="user_name" class="block mb-2 text-left text-blue-300 text-sm">Nombre</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input id="user_name" type="text" name="name" required placeholder="Ingresa tu nombre" 
                           class="w-full p-3 pl-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- Correo electrónico --}}
            <div class="w-full mb-4">
                <label for="user_email" class="block mb-2 text-left text-blue-300 text-sm">Correo electrónico</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input id="user_email" type="email" name="email" required placeholder="correo@ejemplo.com" 
                           class="w-full p-3 pl-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- Contraseña --}}
            <div class="w-full mb-4">
                <label for="user_password" class="block mb-2 text-left text-blue-300 text-sm">Contraseña</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="user_password" type="password" name="password" required placeholder="Mínimo 6 caracteres"
                           class="w-full p-3 pl-10 pr-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" onclick="togglePasswordVisibility('user_password', 'user-password-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200">
                        <span id="user-password-icon"><x-heroicon-o-eye class="w-5 h-5" /></span>
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-400">La contraseña debe tener al menos 6 caracteres</p>
            </div>

            {{-- Confirmar contraseña --}}
            <div class="w-full mb-4">
                <label for="user_password_confirmation" class="block mb-2 text-left text-blue-300 text-sm">Confirmar contraseña</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <input id="user_password_confirmation" type="password" name="password_confirmation" required placeholder="Repite tu contraseña"
                           class="w-full p-3 pl-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- Botón --}}
            <div class="w-full flex justify-center mt-5">
                <button type="submit" class="group relative w-full flex justify-center py-3 px-5 border border-transparent rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-300 group-hover:text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </span>
                    Registrarse como Usuario
                </button>
            </div>
        </form>

        <!-- Formulario para Administrador (oculto por defecto) -->
        <form id="form-admin" action="{{ route('registrar') }}" method="POST" class="form-container hidden transition-all duration-300 flex-col items-center">
            @csrf
            @method('POST')
            
            <input type="hidden" name="user_type" value="admin">
            
            {{-- Nombre --}}
            <div class="w-full mb-4">
                <label for="admin_name" class="block mb-2 text-left text-blue-300 text-sm">Nombre</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input id="admin_name" type="text" name="name" required placeholder="Ingresa tu nombre" 
                           class="w-full p-3 pl-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- Correo electrónico --}}
            <div class="w-full mb-4">
                <label for="admin_email" class="block mb-2 text-left text-blue-300 text-sm">Correo electrónico</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input id="admin_email" type="email" name="email" required placeholder="correo@ejemplo.com" 
                           class="w-full p-3 pl-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- Código de administrador --}}
            <div class="w-full mb-4">
                <label for="admin_code" class="block mb-2 text-left text-blue-300 text-sm">Código de administrador</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="admin_code" type="text" name="admin_code" required placeholder="Ingresa el código de administrador" 
                           class="w-full p-3 pl-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <p class="mt-1 text-xs text-gray-400">Este código es necesario para registrarse como administrador</p>
            </div>

            {{-- Contraseña --}}
            <div class="w-full mb-4">
                <label for="admin_password" class="block mb-2 text-left text-blue-300 text-sm">Contraseña</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="admin_password" type="password" name="password" required placeholder="Mínimo 6 caracteres"
                           class="w-full p-3 pl-10 pr-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" onclick="togglePasswordVisibility('admin_password', 'admin-password-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200">
                        <span id="admin-password-icon"><x-heroicon-o-eye class="w-5 h-5" /></span>
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-400">La contraseña debe tener al menos 6 caracteres</p>
            </div>

            {{-- Confirmar contraseña --}}
            <div class="w-full mb-4">
                <label for="admin_password_confirmation" class="block mb-2 text-left text-blue-300 text-sm">Confirmar contraseña</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <input id="admin_password_confirmation" type="password" name="password_confirmation" required placeholder="Repite tu contraseña"
                           class="w-full p-3 pl-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- Botón --}}
            <div class="w-full flex justify-center mt-5">
                <button type="submit" class="group relative w-full flex justify-center py-3 px-5 border border-transparent rounded-lg text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </span>
                    Registrarse como Administrador
                </button>
            </div>
        </form>

        {{-- Enlace para iniciar sesión (compartido entre ambos formularios) --}}
        <div class="w-full text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-blue-400 hover:text-blue-300 transition">
                ¿Ya tienes una cuenta? Inicia sesión
            </a>
        </div>

        {{-- Mostrar errores si hay error--}}
        @if ($errors->any())
            <div class="w-full mt-4">
                <x-alert type="error" :message="implode(', ', $errors->all())" />
            </div>
        @endif
    </div>

    {{-- Estilos para la animación --}}
    <style>
        .active-type {
            font-weight: 500;
            color: white;
            z-index: 10;
        }
        .inactive-type {
            color: #9ca3af;
            z-index: 10;
        }
        #slide-indicator {
            position: absolute;
            bottom: 0;
            left: 4px;
            width: calc(50% - 8px);
            transition: transform 0.3s ease;
        }
        .form-container {
            opacity: 1; 
            transform: translateY(0);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .form-hide {
            opacity: 0;
            transform: translateY(10px);
        }
        .form-show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    {{-- JS para cambio de formulario con animación y mostrar/ocultar contraseña --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnUsuario = document.getElementById('btn-usuario');
            const btnAdmin = document.getElementById('btn-admin');
            const formUsuario = document.getElementById('form-usuario');
            const formAdmin = document.getElementById('form-admin');
            const slideIndicator = document.getElementById('slide-indicator');
            
            // Funciones para cambiar entre formularios
            btnUsuario.addEventListener('click', function() {
                // Animación de slide
                slideIndicator.style.transform = 'translateX(0)';
                
                // Actualiza clases activas
                btnUsuario.classList.add('active-type');
                btnUsuario.classList.remove('inactive-type');
                btnAdmin.classList.add('inactive-type');
                btnAdmin.classList.remove('active-type');
                
                // Animación de formularios
                formUsuario.classList.add('form-hide');
                formAdmin.classList.add('form-hide');
                
                setTimeout(() => {
                    formUsuario.classList.remove('hidden');
                    formAdmin.classList.add('hidden');
                    
                    setTimeout(() => {
                        formUsuario.classList.remove('form-hide');
                        formUsuario.classList.add('form-show');
                    }, 50);
                }, 300);
            });
            
            btnAdmin.addEventListener('click', function() {
                // Animación de slide
                slideIndicator.style.transform = 'translateX(100%)';
                
                // Actualiza clases activas
                btnAdmin.classList.add('active-type');
                btnAdmin.classList.remove('inactive-type');
                btnUsuario.classList.add('inactive-type');
                btnUsuario.classList.remove('active-type');
                
                // Animación de formularios
                formUsuario.classList.add('form-hide');
                formAdmin.classList.add('form-hide');
                
                setTimeout(() => {
                    formAdmin.classList.remove('hidden');
                    formUsuario.classList.add('hidden');
                    
                    setTimeout(() => {
                        formAdmin.classList.remove('form-hide');
                        formAdmin.classList.add('form-show');
                    }, 50);
                }, 300);
            });
            
            // Inicialización
            btnUsuario.classList.add('active-type');
            btnAdmin.classList.add('inactive-type');
        });
        
        // Función para mostrar/ocultar contraseñas
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            icon.innerHTML = isPassword
                ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>`;
        }
    </script>
@endsection