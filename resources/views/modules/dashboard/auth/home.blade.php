@extends('layouts.app')

@section('title', 'Laravel11 | Home')

@section('content')
<div class="min-h-screen">
    <div class="container px-4 lg:px-8 mx-auto pt-16 lg:pt-24">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-20">
            <!-- Sección de contenido principal -->
            <div class="w-full lg:w-1/2 text-center lg:text-left space-y-8">
                <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold text-[#f5e7d5] leading-tight tracking-tight">
                    Conecta emociones, <br class="hidden sm:block"> lleva un diseño único.
                </h1>
                <p class="text-lg lg:text-xl text-gray-300 max-w-2xl mx-auto lg:mx-0">
                    Distinción en cada detalle, elegancia en cada pulsera.
                </p>
                
                
                <!-- Categorías de productos -->
                <div class="grid grid-cols-3 gap-4 sm:gap-4 max-w-2xl mx-auto lg:mx-0 mt-12 perspective">
                <a href="/mujeres"
                data-aos="zoom-in"
                data-aos-delay="300"
                class="flex-shrink-0 group bg-[#2b2d42]/80 p-3 rounded-xl shadow-lg backdrop-blur-sm hover:shadow-xl transition-all duration-300 hover:scale-105 border border-white/10">
                    <div class="aspect-square relative overflow-hidden rounded-lg mb-3">
                        <img src="{{ asset('images/mujer.png') }}" alt="Pulsera Mujer"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <p class="text-white text-center font-medium group-hover:text-[#cfbea7] transition-colors">Mujer</p>
                </a>

                <a href="/parejas"
                data-aos="zoom-in"
                data-aos-delay="300"
                class="group bg-[#2b2d42]/80 p-6 rounded-xl shadow-lg transition-all duration-300 hover:scale-110 hover:shadow-2xl transform scale-105 flex-shrink-0 backdrop-blur-sm border border-white/10">
                    <div class="aspect-square relative overflow-hidden rounded-lg mb-4">
                        <img src="{{ asset('images/pareja.png') }}" alt="Pulsera Pareja"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <p class="text-white text-center font-medium group-hover:text-[#cfbea7] transition-colors text-lg">Pareja</p>
                </a>

                <a href="/hombres"
                data-aos="zoom-in"
                data-aos-delay="300"
                class="flex-shrink-0 group bg-[#2b2d42]/80 p-3 rounded-xl shadow-lg backdrop-blur-sm hover:shadow-xl transition-all duration-300 hover:scale-105 border border-white/10">
                    <div class="aspect-square relative overflow-hidden rounded-lg mb-3">
                        <img src="{{ asset('images/hombre.png') }}" alt="Pulsera Hombre"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <p class="text-white text-center font-medium group-hover:text-[#cfbea7] transition-colors">Hombre</p>
                </a>
            </div>

                
            </div>

            <!-- Sección de imagen decorativa -->
            <div class="relative w-full max-w-2xl mx-auto overflow-hidden">
                <img src="{{ asset('images/mano.png') }}" alt="Pulsera" class="hidden sm:block m:block w-full h-auto animate-float">
                <div class="absolute inset-0 bg-gradient-to-r from-[#212235] via-[#212235]/70   to-transparent pointer-events-none"></div>
            </div>
        </div>
    </div>

    
    <!-- Sección Nosotros -->
    <div class="container mx-auto px-4 lg:px-8 py-16 lg:py-24">
        <x-nosotros></x-nosotros>
    </div>
</div>
@endsection