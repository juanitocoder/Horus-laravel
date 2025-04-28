@extends('layouts.login-register')

@section('olvido')
<div class="min-h-screen flex items-center justify-center ">
    <div class="w-full max-w-md bg-[#232334] p-8 rounded-lg shadow-lg text-white">
        <div class="text-center mb-6">
            <img src="{{ asset('images/Logo.png') }}" class="w-44 mx-auto" alt="Logo Horus">
        </div>

        <h2 class="text-2xl font-semibold mb-6 text-center">Restablecer contraseña</h2>

        @if (session('status'))
            <x-alert type="success" :message="session('status')" />
        @endif

        @if ($errors->any())
            <x-alert type="error" :message="$errors->first()" />
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ request()->route('token') }}">
            <input type="hidden" name="email" value="{{ request()->get('email') }}">

            <div>
                <label for="password" class="block text-sm mb-1">Nueva contraseña</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-[#2c2c3d] text-white placeholder-gray-400"
                    placeholder="********">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm mb-1">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-[#2c2c3d] text-white placeholder-gray-400"
                    placeholder="********">
            </div>

            <div>
                <button type="submit"
                    class="w-full py-2 bg-yellow-500 text-white font-semibold rounded hover:bg-yellow-600 transition">
                    Restablecer contraseña
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-yellow-400 hover:underline">Volver al inicio de sesión</a>
        </div>
    </div>
</div>
@endsection