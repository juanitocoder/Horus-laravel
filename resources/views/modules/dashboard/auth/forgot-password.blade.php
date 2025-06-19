@extends('layouts.login-register')

@section('olvido')
    <form method="POST" action="{{ route('password.email') }}" class="bg-gradient-to-b from-[#1C2B39] to-[#253545] p-8 rounded-xl shadow-lg w-full max-w-md flex flex-col items-center">
        @csrf

        {{-- Mensajes de estado --}}
        @if (session('status'))
            <div class="w-full mb-4 bg-green-100 text-green-700 border border-green-300 px-4 py-3 rounded-lg text-sm">
                {!! session('status') !!}
            </div>
        @endif

        @if ($errors->any())
            <x-alert type="error" :message="$errors->first()" />
        @endif

        {{-- Encabezado --}}
        <div class="w-full text-center mb-6">
            <img src="{{ asset('images/Logo.png') }}" alt="Horus Logo" class="h-10 w-auto mx-auto mb-4">
            <h2 class="text-xl font-semibold text-white mb-2">Recuperar Contraseña</h2>
            <p class="text-gray-300 text-sm">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña</p>
        </div>

        {{-- Correo electrónico --}}
        <div class="w-full mb-6">
            <label for="email" class="block mb-2 text-left text-blue-300 text-sm">Correo electrónico</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email" required autofocus placeholder="correo@ejemplo.com"
                       class="w-full p-3 pl-10 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Botón de envío --}}
        <div class="w-full flex justify-center mt-2">
            <button type="submit" class="group relative w-full flex justify-center py-3 px-5 border border-transparent rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                Enviar enlace de recuperación
            </button>
        </div>

        {{-- Enlace para volver al login --}}
        <div class="w-full text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-blue-400 hover:text-blue-300 transition" onclick="event.preventDefault(); showLoader(); window.location.href=this.href;">
                ← Volver al inicio de sesión
            </a>
        </div>
    </form>
@endsection
