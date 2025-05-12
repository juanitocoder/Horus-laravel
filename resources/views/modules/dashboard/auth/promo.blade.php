@extends('layouts.app')

@section('promo')
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-extrabold text-center mb-8 text-white font-cinzel">
      Promociones
    </h2>

    @foreach ($promociones as $tipo => $coleccion)
      <div class="mb-12">
        <h3 class="text-2xl font-bold text-white mb-4">
          ¡Especial {{ Str::title(str_replace('_', ' ', $tipo)) }}!
        </h3>

        <div class="">
          {{-- Aquí solo pasas la subcolección que corresponde a este tipo --}}
          <x-cartas :productos="$coleccion"/>
        </div>
      </div>
    @endforeach
  </div>
@endsection