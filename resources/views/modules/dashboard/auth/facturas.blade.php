@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-[#2b2d42] to-[#1a1b2e] flex items-center justify-center py-10">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-3xl">
        <h2 class="text-2xl font-bold text-blue-700 mb-4">Factura de Compra!</h2>

        <p class="text-gray-700"><span class="font-semibold">Usuario:</span> {{ $factura->user->name }}</p>
        <p class="text-gray-700 mb-6"><span class="font-semibold">Total:</span> ${{ number_format($factura->total, 2, ',', '.') }}</p>

        <h3 class="text-xl font-semibold text-blue-600 mb-3">Detalles</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-md">
                <thead>
                    <tr class="bg-blue-500 text-white text-left">
                        <th class="py-3 px-4">Producto</th>
                        <th class="py-3 px-4">Cantidad</th>
                        <th class="py-3 px-4">Precio Unitario</th>
                        <th class="py-3 px-4">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->detalles as $detalle)
                        <tr class="border-t border-gray-200 hover:bg-blue-50">
                            <td class="py-2 px-4">{{ $detalle->product->name }}</td>
                            <td class="py-2 px-4">{{ $detalle->cantidad }}</td>
                            <td class="py-2 px-4">${{ number_format($detalle->precio_unitario, 2, ',', '.') }}</td>
                            <td class="py-2 px-4">${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>




            <a href="{{ route('factura.pdf', $factura->id) }}"
class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mt-4">
Descargar PDF
</a>

        </div>
    </div>
</div>
@endsection
