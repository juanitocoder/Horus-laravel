@extends('layouts.login-register')

@section('olvido')

        <div class="w-full max-w-md bg-[#1C2B39] p-12 rounded-lg shadow-lg  flex  flex-col  justify-center  items-center">
            <div class="text-center mb-6">
                <img src="{{ asset('images/Logo.png') }}" class="w-44 mx-auto" alt="Logo Horus">
            </div>

            @if (session('status'))
            <div class="bg-green-100 text-green-700 border border-green-300 px-2 py-2 rounded mb-2 text-sm">
                {!! session('status') !!}
            </div>
        @endif

            @if ($errors->any())
                <x-alert type="error" :message="$errors->first()" />
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-white mb-4">Correo electrónico</label>
                    <input id="email" type="email" name="email" required autofocus
                        class="w-full px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-[#2c2c3d] text-white placeholder-gray-400"
                        placeholder="ejemplo@correo.com">
                </div>

                <div>
                    <button type="submit"
                        class="w-full py-2 bg-yellow-500 text-white font-semibold rounded hover:bg-yellow-600 transition">
                        Enviar enlace
                    </button>
                </div>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm text-yellow-400 hover:underline">Volver al inicio de sesión</a>
            </div>
        </div>
   

@endsection
