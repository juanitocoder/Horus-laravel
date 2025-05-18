<div
    x-data="{
        active: 0,
        promos: [
            {
                title: '¡Promoción 2x1 en pulseras!',
                link: '/catalogo#promocion-2x1',
                items: [
                    { img: '{{ asset('images/Promos/Promo4.jpg') }}', badge: '2x1' },
                    { img: '{{ asset('images/Promos/Promo2.jpg') }}', badge: '2x1' },
                    { img: '{{ asset('images/Promos/Promo3.jpg') }}', badge: '2x1' }
                ]
            },
            {
                title: 'Día de la Madre',
                link: '/mamá',
                items: [
                    { img: '{{ asset('images/Promos/Madre1.jpg') }}', badge: 'MAMÁ' },
                    { img: '{{ asset('images/Promos/Madre2.jpg') }}', badge: '-20%' },
                    { img: '{{ asset('images/Promos/Madre3.jpg') }}', badge: 'REGALO' }
                ]
            },
            {
                title: '15% Descuento',
                link: '/coleccion',
                items: [
                    { img: '{{ asset('images/Promos/Descuento1.jpg') }}', badge: 'NUEVO' },
                    { img: '{{ asset('images/Promos/Descuento2.jpg') }}', badge: 'EXCLUSIVO' },
                    { img: '{{ asset('images/Promos/Descuento3.jpg') }}', badge: 'LIMITED' }
                ]
            }
        ],
        next() {
            this.active = (this.active + 1) % this.promos.length;
        },
        prev() {
            this.active = (this.active - 1 + this.promos.length) % this.promos.length;
        },
        initAOS() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: false
                });
            }
        }
    }"
    x-init="
        setInterval(() => { active = (active + 1) % promos.length }, 7000);
        $nextTick(() => initAOS());
    "
    class="font-['Poppins'] rounded-xl px-4 py-12 text-white relative text-center max-w-[95%] mx-auto mt-8 overflow-hidden"
>
    <!-- Importación de bibliotecas -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <!-- Importación de fuentes más llamativas -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Righteous&display=swap" rel="stylesheet">

    <!-- Indicador de diapositivas -->
    <div class="absolute bottom-2 left-0 right-0 flex justify-center space-x-2 z-10 animate__animated animate__fadeInUp animate__delay-1s">
        <template x-for="(_, index) in promos" :key="index">
            <button 
                @click="active = index" 
                :class="{'bg-white': active === index, 'bg-white/30': active !== index}"
                class="w-3 h-3 rounded-full transition-all duration-300"
            ></button>
        </template>
    </div>

    <!-- Flechas de navegación -->
    <button @click="prev"
        class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/30 text-white p-2 rounded-full backdrop-blur-sm z-10 transition duration-300 transform hover:scale-110 animate__animated animate__fadeInLeft">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <button @click="next"
        class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/30 text-white p-2 rounded-full backdrop-blur-sm z-10 transition duration-300 transform hover:scale-110 animate__animated animate__fadeInRight">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <!-- Título animado con tipografía más llamativa -->
    <h2 
    class="font-sans text-4xl md:text-5xl lg:text-6xl font-extrabold mb-8 text-transparent bg-clip-text bg-gradient-to-r from-pink-300 via-purple-300 to-blue-300 uppercase tracking-widest drop-shadow-2xl animate__animated" 
    x-text="promos[active].title"
    :class="'animate__' + ['rubberBand', 'tada', 'pulse'][active % 3]"
    x-transition:enter="transition transform ease-out duration-500"
    x-transition:enter-start="opacity-0 scale-90"
    x-transition:enter-end="opacity-100 scale-100"
></h2>



    <!-- Carrusel con animación mejorada -->
    <div 
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 transform translate-x-12"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform -translate-x-12"
        class="relative animate__animated animate__fadeIn">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10 px-4">
            <template x-for="(item, idx) in promos[active].items" :key="idx">
                <div class="flex flex-col items-center" 
                     data-aos="fade-up" 
                     :data-aos-delay="idx * 100">
                    <template x-if="item.img">
                        <div class="relative overflow-hidden w-full h-80 md:h-96 rounded-xl"
                             x-data="{ hover: false }"
                             @mouseenter="hover = true" 
                             @mouseleave="hover = false">
                            <img 
                                :src="item.img" 
                                alt="Promoción"
                                class="w-full h-full object-cover shadow-xl border-2 border-purple-300 transition-all duration-700 rounded-xl"
                                :class="hover ? 'scale-110 brightness-110' : ''"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/70 to-transparent transition-opacity duration-500 rounded-xl"
                                 :class="hover ? 'opacity-30' : 'opacity-70'"></div>
                            
                            <!-- Etiqueta promocional -->
                            <div class="absolute top-0 right-0 mt-4 mr-4 z-20" x-show="item.badge">
                                <div 
                                    class="font-['Righteous'] bg-[#cfbea7] text-[#2b2d42] px-3 py-1 rounded-lg transform rotate-3 shadow-lg animate__animated animate__fadeInRight animate__delay-1s"
                                >
                                    <span 
                                        class="text-lg md:text-xl font-bold tracking-wider" 
                                        x-text="item.badge"
                                    ></span>
                                </div>
                            </div>
                            
                            <!-- Animación de brillo que recorre la imagen -->
                            <div 
                                class="absolute inset-0 opacity-0 rounded-xl"
                                :class="hover ? 'animate-shimmer' : ''"
                                style="background: linear-gradient(to right, transparent 0%, rgba(255,255,255,0.2) 50%, transparent 100%); background-size: 200% 100%;"
                            ></div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <!-- Botón mejorado -->
    <div class="mt-10 flex justify-center" data-aos="zoom-in" data-aos-delay="300">
        <a  href="/promo"
            class="inline-block rounded-full bg-gradient-to-r from-violet-600 to-indigo-600 px-10 py-4 text-white font-['Righteous'] text-lg shadow-lg hover:from-violet-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl animate__animated animate__pulse animate__infinite animate__slower">
            ¡Comprar ahora!
        </a>
    </div>

    <style>
    @keyframes shimmer {
        0% { opacity: 0; transform: translateX(-100%); }
        20% { opacity: 0.3; }
        80% { opacity: 0.3; }
        100% { opacity: 0; transform: translateX(100%); }
    }
    .animate-shimmer {
        animation: shimmer 2s infinite;
    }

    /* Efectos de animación personalizados */
    @keyframes floatAnimation {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .float {
        animation: floatAnimation 3s ease-in-out infinite;
    }
    
    /* Animación para las etiquetas */
    @keyframes pulseGlow {
        0% { box-shadow: 0 0 5px rgba(255,255,255,0.5); }
        50% { box-shadow: 0 0 15px rgba(255,255,255,0.8); }
        100% { box-shadow: 0 0 5px rgba(255,255,255,0.5); }
    }
    .pulse-glow {
        animation: pulseGlow 2s infinite;
    }
    </style>
</div>