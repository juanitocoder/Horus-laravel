

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-8 text-center text-white">Tu Carrito</h1>

    @php
    $total = 0;
    foreach ($cart->items as $item) {
        $total += $item->product->price * $item->quantity;
    }
    @endphp

    @if ($cart && $cart->items->count() > 0)
        <div class="grid gap-6">
            @foreach ($cart->items as $item)
                <div class="bg-white shadow-md rounded-2xl p-4 flex flex-col sm:flex-row items-center sm:items-start gap-4">
                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                        alt="{{ $item->product->name }}" 
                        class="w-24 h-24 rounded-xl object-cover border shadow">

                    <div class="flex-1 w-full">
                        <p class="text-lg font-semibold">{{ $item->product->name }}</p>
                        <p class="text-gray-600 mb-2">${{ number_format($item->product->price, 0, ',', '.') }} COP </p>

                        <div class="flex items-center gap-2">
                            <!-- Disminuir cantidad -->
                            <form method="POST" action="{{ route('cart.decrease', $item) }}">
                                @csrf
                                <button class="bg-red-500 text-white px-3 py-1 rounded-full text-sm hover:bg-red-600"><x-heroicon-o-minus class="w-6 h-6" /></button>
                            </form>

                            <!-- Cantidad -->
                            <span class="text-md font-medium px-2">{{ $item->quantity }}</span>

                            <!-- Aumentar cantidad -->
                            <form method="POST" action="{{ route('cart.increase', $item) }}">
                                @csrf
                                <button class="bg-green-500 text-white px-3 py-1 rounded-full text-sm hover:bg-green-600"><x-heroicon-o-plus class="w-6 h-6" /></button>
                            </form>
                        </div>
                    </div>

                    <!-- Eliminar -->
                    <form method="POST" action="{{ route('cart.remove', $item) }}" class="ml-auto">
                        @csrf
                        <button class="text-red-600 text-sm hover:underline">Eliminar</button>
                    </form>
                </div>
            @endforeach
        </div>
        <!-- Total -->
        <div class="mt-6 text-right">
            <p class="text-lg font-semibold text-white">
                Total: <span class="text-blue-600">${{ number_format($total,  0, ',', '.') }} COP </span>
            </p>
        </div>



        <!-- INICIO Y FINALIZAR COMPRA -->
        <div class="flex justify-end items-center space-x-4 mt-4">
        <a href="/hombres" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-500 transition">
            Agregar mas productos!
        </a>
        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium text-sm">
            Finalizar Compra
        </a>
    </div>
    @else
    <div>
        
        <p class="text-white text-lg text-center">Tu carrito está vacío | Agrega un producto.</p>
        <p class="text-white text-lg text-center justify-center flex"><x-heroicon-o-shopping-bag class="w-20 h-20" /></p>
        
    </div>
    @endif
</div>
@endsection