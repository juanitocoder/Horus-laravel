@extends('layouts.app')

@section('title', 'Laravel11 | Home')

@section('content')
<div class="bg-[#212235] min-h-screen">
   <!-- Sección de Inicio -->
    <div class="container mx-auto lg:px-8 py-2 lg:py-3">
        <x-inicio></x-inicio>
    </div>

    <!-- Sección de Carrusel -->
    <div class="container mx-auto lg:px-8 py-2 lg:py-3">
        <x-carrusel></x-carrusel>
    </div> 
   

    
 
    <!-- Sección Nosotros -->
    <div class="container mx-auto lg:px-8 py-2 lg:py-3">
        <x-nosotros></x-nosotros>
    </div>


    
</div>
@endsection