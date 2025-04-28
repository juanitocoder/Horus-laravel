@extends('layouts.app')

@section('hombres')

<h2 class="relative text-3xl font-extrabold text-center mb-8">
  <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-blue-600">Catálogo Hombres</span>
  <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full"></div>
  <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-blue-300 rounded-full opacity-50 animate-pulse"></div>
</h2>

<x-botones_catalogo />
<x-cartas :productos="$productos" />




@endsection