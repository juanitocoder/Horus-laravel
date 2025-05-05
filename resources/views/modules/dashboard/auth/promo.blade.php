@extends('layouts.app')

@section('promo')

<div>


</div>
<h2 class="relative text-3xl font-extrabold text-center mb-8 text-white font-cinzel">
  Promociones
</h2>


<x-cartas :productos="$productos"/>

@endsection