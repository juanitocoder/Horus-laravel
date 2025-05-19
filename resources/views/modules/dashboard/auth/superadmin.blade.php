@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Gestión de Roles de Usuarios</h1>
    </div>
    
    @if(session('success'))
        <div class="bg-indigo-900 border-l-4 border-yellow-500 text-white p-4 mb-6 rounded shadow-md" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    <div class="bg-gray-900 overflow-hidden shadow-lg border border-gray-800 rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-800">
                <thead class="bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Rol actual
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Cambiar Rol
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-900 divide-y divide-gray-800">
                    @foreach($usuarios as $usuario)
                        <tr class="hover:bg-gray-800 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                {{ $usuario->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $usuario->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($usuario->role->name === 'admin')
                                    <div class="bg-red-600 text-white px-2 py-1 rounded text-xs font-bold justify-center flex">ADMIN</div>
                                @elseif($usuario->role->name === 'superadmin')
                                    <div class="bg-green-700 text-white px-2 py-1 rounded text-xs font-bold justify-center flex">SUPERADMIN</div>
                                @else
                                    <div class="bg-blue-700 text-white px-2 py-1 rounded text-xs font-bold justify-center flex">USUARIO</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <form action="{{ route('usuarios.cambiar-rol', $usuario->id) }}" method="POST">
                                    @csrf
                                    <select 
                                        name="role_id" 
                                        onchange="this.form.submit()" 
                                        class="block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50 text-sm"
                                    >
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol->id }}" {{ $usuario->role_id == $rol->id ? 'selected' : '' }}>
                                                {{ $rol->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection