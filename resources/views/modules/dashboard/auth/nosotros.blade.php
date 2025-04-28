@extends('layouts.app')


@section('title', 'Nosotros - Horus Manillas')
@section('content')

    <!-- Contenido de la página -->
<div class="bg-[#1c1d2e] text-white min-h-screen">

    <!-- Hero Banner -->
    <section class="relative bg-cover bg-center h-96" style="background-image: url('{{ asset('images/manillas-banner.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
            <div class="text-center px-6">
                <h1 class="text-5xl font-bold text-yellow-400">Nosotros</h1>
                <p class="text-gray-300 mt-4 text-xl">Historias que se llevan en la muñeca</p>
            </div>
        </div>
    </section>

    <!-- Historia -->
    <section class="px-6 md:px-20 py-16 max-w-7xl mx-auto">
        <h2 class="text-3xl font-semibold text-yellow-400 mb-6 text-center">Nuestra Historia</h2>
        <div class="flex flex-col md:flex-row items-center md:gap-10 gap-6 max-w-4xl mx-auto">
            <x-heroicon-o-sparkles class="w-12 h-12 text-yellow-400" />
            <p class="text-gray-300 text-lg text-center md:text-left leading-relaxed">
                Horus nació del deseo de crear más que accesorios: buscamos transmitir energía, conexión y estilo a través de pulseras únicas. Desde nuestros primeros diseños hechos a mano, hemos crecido gracias a una comunidad que cree en la autenticidad, la calidad y el valor de lo hecho con intención.
            </p>
        </div>
    </section>

    <!-- Misión y Visión -->
    <section class="bg-[#2a2b3d] py-16">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12">

            <!-- Misión -->
            <div class="bg-[#1c1d2e] border border-yellow-400/30 rounded-2xl p-8 shadow-lg">
                <div class="flex items-center gap-4 mb-4">
                    <x-heroicon-o-light-bulb class="w-8 h-8 text-yellow-400" />
                    <h3 class="text-2xl font-bold text-yellow-400">Nuestra Misión</h3>
                </div>
                <p class="text-gray-300 leading-relaxed">
                    Empoderar a las personas a través de manillas con significado. Diseñamos piezas únicas que conectan con tus valores, estilo y energía. Cada una refleja una intención, un propósito y una historia.
                </p>
            </div>

            <!-- Visión -->
            <div class="bg-[#1c1d2e] border border-yellow-400/30 rounded-2xl p-8 shadow-lg">
                <div class="flex items-center gap-4 mb-4">
                    <x-heroicon-o-eye class="w-8 h-8 text-yellow-400" />
                    <h3 class="text-2xl font-bold text-yellow-400">Nuestra Visión</h3>
                </div>
                <p class="text-gray-300 leading-relaxed">
                    Convertirnos en la marca líder en joyería artesanal emocional, reconocida por su innovación, impacto social y diseño consciente en Latinoamérica.
                </p>
            </div>

        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 text-center">
        <x-heroicon-o-gift class="w-12 h-12 text-yellow-400 mx-auto mb-4" />
        <h4 class="text-3xl font-semibold text-yellow-400 mb-4">Descubre tu próxima manilla favorita</h4>
        <p class="text-gray-300 text-lg mb-8">Diseñada para ti, con energía y propósito.</p>
        <a href="/hombres" class="bg-yellow-400 text-black font-semibold px-8 py-3 rounded-full hover:bg-yellow-300 transition">
            Ver Catálogo
        </a>
    </section>

</div>
@endsection