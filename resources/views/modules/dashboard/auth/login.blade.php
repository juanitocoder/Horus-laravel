@extends('layouts.login-register')

@section('title', 'Iniciar Sesión')

@section('login')
    <form action="{{ route('logear') }}" method="POST" class="bg-gradient-to-b from-[#1C2B39] to-[#253545] p-8 rounded-xl shadow-lg w-full max-w-md flex flex-col items-center">
        @csrf
        @method('POST')

        {{-- Mensajes de sesión --}}
        @if(session('alert'))
            <x-alert type="success" :message="session('alert')" />
        @endif

        @if(session('error'))
            <x-alert type="error" :message="session('error')" />
        @endif

        {{-- Encabezado --}}
        <div class="w-full text-center mb-6">
            <img src="{{ asset('images/Logo.png') }}" alt="Horus Logo" class="h-10 w-auto mx-auto mb-2">
            
        </div>

        {{-- Correo electrónico --}}
        <div class="w-full mb-4">
            <label for="email" class="block mb-2 text-left text-blue-300 text-sm">Correo electrónico</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email" required placeholder="correo@ejemplo.com"
                       class="w-full p-3 pl-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Contraseña --}}
        <div class="w-full mb-4">
            <label for="password" class="block mb-2 text-left text-blue-300 text-sm">Contraseña</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" type="password" name="password" required placeholder="Ingresa tu contraseña"
                       class="w-full p-3 pl-10 pr-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200">
                    <span id="password-icon"><x-heroicon-o-eye class="w-5 h-5" /></span>
                </button>
            </div>
        </div>

        {{-- Enlace para recuperar contraseña --}}
        <div class="w-full flex items-center justify-between mb-4">
            <div></div>
            <a href="{{ route('password.request') }}" class="text-sm text-blue-400 hover:text-blue-300 transition">¿Olvidaste tu contraseña?</a>
        </div>

        {{-- Botón de inicio de sesión --}}
        <div class="w-full flex justify-center mt-5">
            <button type="submit" class="group relative w-full flex justify-center py-3 px-5 border border-transparent rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                </span>
                Iniciar Sesión
            </button>
        </div>

        {{-- Enlace para registrarse --}}
        <div class="w-full text-center mt-4">
            <a href="/registro" class="text-sm text-blue-400 hover:text-blue-300 transition">¿No tienes cuenta? Regístrate</a>
        </div>
    </form>

    {{-- JS para mostrar/ocultar contraseña --}}
    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('password');
            const icon = document.getElementById('password-icon');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            icon.innerHTML = isPassword
                ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                    </svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>`;
        }
    </script>
@endsection
