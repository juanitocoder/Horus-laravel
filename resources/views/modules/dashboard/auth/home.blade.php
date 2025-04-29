@extends('layouts.app')

@section('title', 'Laravel11 | Home')

@section('content')
<style>
        body {
            background-color: #212235;
            color: #f5e7d5;
            font-family: 'Poppins', sans-serif;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #212235 0%, #2b2d42 100%);
        }
        
        .card-hover {
            transition: all 0.5s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }
        
        .card-image {
            transition: all 0.7s ease;
        }
        
        .card-hover:hover .card-image {
            transform: scale(1.12);
        }
        
        .main-image {
            animation: float 6s ease-in-out infinite;
            filter: drop-shadow(0px 10px 15px rgba(207, 190, 167, 0.2));
        }
        
        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }
            25% {
                transform: translateY(-10px) rotate(1deg);
            }
            50% {
                transform: translateY(0px) rotate(0deg);
            }
            75% {
                transform: translateY(10px) rotate(-1deg);
            }
            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }
        
        .glow {
            animation: glow 3s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            from {
                text-shadow: 0 0 5px #cfbea7, 0 0 10px #cfbea7;
            }
            to {
                text-shadow: 0 0 10px #cfbea7, 0 0 20px #cfbea7;
            }
        }
        
        .card-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }
        
        .card-hover:hover .card-shine {
            left: 100%;
            transition: 0.5s;
            transition-delay: 0.25s;
        }
        
        .perspective {
            perspective: 1000px;
        }
        
        .category-card {
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }
        
        .category-card:hover {
            transform: rotateY(10deg) rotateX(5deg);
        }
        
        .title-word {
            display: inline-block;
            animation: fadeIn 1.5s forwards;
            opacity: 0;
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
<div class=" overflow-hidden">
        <div class="container px-4 lg:px-8 mx-auto pt-16 lg:pt-24">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-20">
                <!-- Main content section -->
                <div class="w-full lg:w-1/2 text-center lg:text-left space-y-8" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold text-[#f5e7d5] leading-tight tracking-tight">
                        <span class="title-word" style="animation-delay: 0.1s;">Conecta</span>
                        <span class="title-word" style="animation-delay: 0.3s;">emociones,</span><br class="hidden sm:block">
                        <span class="title-word" style="animation-delay: 0.5s;">lleva</span>
                        <span class="title-word glow" style="animation-delay: 0.7s;">un</span>
                        <span class="title-word" style="animation-delay: 0.9s;">diseño</span>
                        <span class="title-word" style="animation-delay: 1.1s;">único.</span>
                    </h1>
                    
                    <p class="text-lg lg:text-xl text-gray-300 max-w-2xl mx-auto lg:mx-0 animate__animated animate__fadeIn animate__delay-1s">
                        Distinción en cada detalle, elegancia en cada pulsera.
                    </p>
                    
                    
                    
                    <!-- Product categories -->
                    <div class="grid grid-cols-3 gap-4 sm:gap-6 max-w-2xl mx-auto lg:mx-0 mt-12 perspective">
                        <a href="/mujeres" 
                           class="category-card flex-shrink-0 group bg-[#2b2d42]/80 p-3 rounded-xl shadow-lg backdrop-blur-sm border border-white/10 card-hover"
                           data-aos="zoom-in" data-aos-delay="300">
                            <div class="aspect-square relative overflow-hidden rounded-lg mb-3">
                                <div class="card-shine"></div>
                                <img src="{{ asset('images/mujer.png') }}" alt="Pulsera Mujer" 
                                     class="card-image w-full h-full object-cover">
                            </div>
                            <p class="text-white text-center font-medium group-hover:text-[#cfbea7] transition-colors">Mujer</p>
                        </a>
                        
                        <a href="/parejas" 
                           class="category-card group bg-[#2b2d42]/80 p-3 rounded-xl shadow-lg backdrop-blur-sm border border-white/10 transform scale-105 flex-shrink-0 card-hover"
                           data-aos="zoom-in" data-aos-delay="500">
                            <div class="aspect-square relative overflow-hidden rounded-lg mb-3">
                                <div class="card-shine"></div>
                                <img src="{{ asset('images/pareja.png') }}" alt="Pulsera Pareja" 
                                     class="card-image w-full h-full object-cover">
                            </div>
                            <p class="text-white text-center font-medium group-hover:text-[#cfbea7] transition-colors text-lg">Pareja</p>
                        </a>
                        
                        <a href="/hombres" 
                           class="category-card flex-shrink-0 group bg-[#2b2d42]/80 p-3 rounded-xl shadow-lg backdrop-blur-sm border border-white/10 card-hover"
                           data-aos="zoom-in" data-aos-delay="700">
                            <div class="aspect-square relative overflow-hidden rounded-lg mb-3">
                                <div class="card-shine"></div>
                                <img src="{{ asset('images/hombre.png') }}" alt="Pulsera Hombre" 
                                     class="card-image w-full h-full object-cover">
                            </div>
                            <p class="text-white text-center font-medium group-hover:text-[#cfbea7] transition-colors">Hombre</p>
                        </a>
                    </div>
                </div>
                
                <!-- Decorative image section -->
                <div class="relative w-full max-w-2xl mx-auto overflow-hidden" data-aos="fade-left" data-aos-duration="1000">
                    <img src="{{ asset('images/mano.png') }}" alt="Pulsera mano" class="hidden sm:block w-full h-auto main-image">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#212235] via-[#212235]/70 to-transparent pointer-events-none"></div>
                    
                </div>
            </div>
        </div>
    </div>

    

    
    <!-- Sección Nosotros -->
    <div class="container mx-auto px-4 lg:px-8 py-16 lg:py-24">
        <x-nosotros></x-nosotros>
    </div>
</div>
@endsection