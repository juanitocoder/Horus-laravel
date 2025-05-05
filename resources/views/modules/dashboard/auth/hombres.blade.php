@extends('layouts.app')

@section('hombres')

<h2 class="relative text-3xl font-extrabold text-center mb-8 text-white font-cinzel">
    Catálogo Hombres
</h2>



<x-botones_catalogo />
<x-cartas :productos="$productos" />




@endsection