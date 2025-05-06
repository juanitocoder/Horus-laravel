@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold mb-8 text-white justify-center flex">Gestión de Comentarios</h1>

    @if(session('success'))
        <div class="bg-green-600 text-white p-3 mb-4 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filtro --}}
    <form method="GET" action="{{ route('admin.comentarios') }}" class="mb-6">
        <label for="categoria" class="text-white mr-2">Filtrar por catálogo:</label>
        <select name="categoria" id="categoria" class="px-3 py-2 rounded bg-[#2a2c42] text-white border border-[#3d3f56]">
            <option value="">Todas</option>
            <option value="Hombres" {{ request('categoria') == 'Hombres' ? 'selected' : '' }}>Hombres</option>
            <option value="Mujeres" {{ request('categoria') == 'Mujeres' ? 'selected' : '' }}>Mujeres</option>
            <option value="Parejas" {{ request('categoria') == 'Parejas' ? 'selected' : '' }}>Parejas</option>
            <option value="Promociones" {{ request('categoria') == 'Promociones' ? 'selected' : '' }}>Promociones</option>
        </select>
        <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Filtrar</button>
    </form>

    {{-- Tabla --}}
    <div class="overflow-x-auto rounded shadow border border-[#3d3f56]">
        <table class="min-w-full text-left text-sm text-white bg-[#2a2c42]">
            <thead class="bg-gradient-to-r from-[#2d304d] to-[#252746] text-white uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Usuario</th>
                    <th class="px-4 py-3">Producto</th>
                    <th class="px-4 py-3">Contenido</th>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comentarios as $comentario)
                <tr class="border-t border-[#3d3f56]">
                    <td class="px-4 py-2">{{ $comentario->id }}</td>
                    <td class="px-4 py-2">{{ $comentario->user->name }}</td>
                    <td class="px-4 py-2">{{ $comentario->product->name }}</td>
                    <td class="px-4 py-2">{{ $comentario->content }}</td>
                    <td class="px-4 py-2">{{ $comentario->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2">
                        <form id="form-eliminar-{{ $comentario->id }}" action="{{ route('admin.comentarios.eliminar', $comentario->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="eliminarComentario({{ $comentario->id }})" class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $comentarios->links('pagination::simple-default') }}
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function eliminarComentario(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Este comentario se eliminará permanentemente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-eliminar-' + id).submit();
                }
            });
        }
    </script>
</div>
@endsection


