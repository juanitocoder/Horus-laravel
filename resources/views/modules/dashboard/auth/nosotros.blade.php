@extends('layouts.app')

@section('title', 'Nosotros - Horus Manillas')
@section('content')

<!-- Contenido de la página -->
<div class="bg-gradient-to-b from-[#2b2d42] to-[#1a1b2e] text-white min-h-screen">

    <!-- Hero Banner -->
    <!-- Hero Banner -->
<section 
class="relative bg-cover bg-center h-96 overflow-hidden"
style="
    background-image: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)), url('{{ asset('images/nosotros2.jpg') }}');
    -webkit-mask-image: linear-gradient(to bottom, black 80%, transparent 100%);
    mask-image: linear-gradient(to bottom, black 80%, transparent 100%);
"
>
<div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center z-20">
    <div class="text-center px-6">
        <h1 class="text-3xl font-bold text-yellow-400">Porque te da el brillo y el estilo que necesitas</h1>
    </div>
</div>
</section>

    <!-- Historia -->
    <section class="px-6 md:px-20 py-16 max-w-7xl mx-auto">
        <h2 class="text-3xl font-semibold text-yellow-400 mb-6 text-center">Nosotros</h2>
        <div class="flex flex-col md:flex-row items-center md:gap-10 gap-6 max-w-4xl mx-auto">
            <x-heroicon-o-sparkles class="w-12 h-12 text-yellow-400" />
            <p class="text-gray-300 text-lg text-center md:text-left leading-relaxed">
                En nuestra tienda, las pulseras Horus no son solo un accesorio, ¡son una conexión con tu energía interior! Diseñadas con símbolos poderosos y materiales de alta calidad, cada pulsera representa protección, sabiduría y equilibrio. Con un estilo único y moderno, nuestras pulseras son el complemento perfecto para cualquier ocasión. ¡Lleva contigo la energía de Horus y marca la diferencia!
            </p>
        </div>
    </section>

    <!-- Misión y Visión -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12">

            <!-- Misión -->
            <div class="bg-[#1c1d2e] border border-yellow-400/30 rounded-2xl p-8 shadow-lg">
                <div class="flex items-center gap-4 mb-4">
                    <x-heroicon-o-light-bulb class="w-8 h-8 text-yellow-400" />
                    <h3 class="text-2xl font-bold text-yellow-400">Nuestra Misión</h3>
                </div>
                <p class="text-gray-300 leading-relaxed">
                    Brindar a nuestros clientes pulseras de alta calidad con diseños únicos y personalizados, a través de una plataforma web que facilite la compra, comunicación y acceso a promociones exclusivas.
                </p>
            </div>

            <!-- Visión -->
            <div class="bg-[#1c1d2e] border border-yellow-400/30 rounded-2xl p-8 shadow-lg">
                <div class="flex items-center gap-4 mb-4">
                    <x-heroicon-o-eye class="w-8 h-8 text-yellow-400" />
                    <h3 class="text-2xl font-bold text-yellow-400">Nuestra Visión</h3>
                </div>
                <p class="text-gray-300 leading-relaxed">
                    Ser una marca reconocida a nivel nacional e internacional por conectar a las personas con su esencia interior a través de pulseras únicas, artesanales y cargadas de significado. Queremos inspirar confianza, protección y estilo, llevando un mensaje positivo en cada pieza que creamos.
                </p>
            </div>

        </div>
    </section>

    <!-- Call to Action -->
    <!-- Call to Action -->
<section 
class="py-20 text-center relative bg-cover bg-center"
style="
    background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('{{ asset('images/nosotros3.jpg') }}');
    -webkit-mask-image: linear-gradient(to bottom, black 70%, transparent 100%);
    mask-image: linear-gradient(to bottom, black 70%, transparent 100%);
"
>
<div class="relative z-10">
    <x-heroicon-o-gift class="w-12 h-12 text-yellow-400 mx-auto mb-4" />
    <h4 class="text-3xl font-semibold text-yellow-400 mb-4">Descubre tu próxima manilla favorita</h4>
    <p class="text-gray-300 text-lg mb-8">Diseñada para ti, con energía y propósito.</p>
    <a href="/hombres" class="bg-yellow-400 text-black font-semibold px-8 py-3 rounded-full hover:bg-yellow-300 transition">
        Ver Catálogo
    </a>
</div>
</section>


</div>
@endsection

