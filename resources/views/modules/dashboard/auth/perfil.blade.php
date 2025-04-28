@extends('layouts.app')
@section('content')

<div class="container mx-auto mt-10 max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-white">Editar Perfil</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('perfil.actualizar') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="text-white" >Nombre</label> 
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label for="email" class="text-white" >Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label for="password" class="text-white" >Nueva contraseña</label>
            <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded px-3 py-2">
            <small class="text-gray-500">Déjalo vacío si no deseas cambiarla</small>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Actualizar</button>
    </form>
</div>
@endsection