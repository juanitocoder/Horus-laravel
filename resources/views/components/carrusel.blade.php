<div
    x-data="{
        active: 0,
        promos: [
            {
                title: '¡Promoción 2x1 en pulseras!',
                link: '/catalogo#promocion-2x1',
                items: [
                    { img: '{{ asset('images/Promos/Promo4.jpg') }}', text: '🎉 ¡Promoción 2x1 en pulseras!' },
                    { img: '{{ asset('images/Promos/Promo2.jpg') }}', text: '🎉 ¡Compra 3 lleva 4!' },
                    { img: '{{ asset('images/Promos/Promo3.jpg') }}', text: '🎉 ¡Pulseras edición limitada!' }
                ]
            },
            {
                title: 'Día de la Madre',
                link: '/ver-video',
                items: [
                    { img: '{{ asset('images/Promos/DiaMadre1.jpg') }}', text: '💖 Celebra con algo especial' },
                    { img: '{{ asset('images/Promos/DiaMadre2.jpg') }}', text: '💐 Pulseras para mamá' },
                    { img: '{{ asset('images/Promos/DiaMadre3.jpg') }}', text: '💐 Promoción especial' }
                ]
            },
            {
                title: 'Nueva Colección',
                link: '/coleccion',
                items: [
                    { img: '{{ asset('images/Promos/Nuevo1.jpg') }}', text: '🛍 Lo nuevo' },
                    { img: '{{ asset('images/Promos/Nuevo2.jpg') }}', text: '🛍 Diseño exclusivo' },
                    { img: '{{ asset('images/Promos/Nuevo3.jpg') }}', text: '🛍 Limited Edition' }
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
    class="font-['Montserrat'] rounded-xl px-4 py-12 text-white relative text-center max-w-[95%] mx-auto mt-8 overflow-hidden"
>
    <!-- Importación de bibliotecas -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <!-- Indicador de diapositivas -->
    <div class="absolute bottom-2 left-0 right-0 flex justify-center space-x-2 z-10 animate__animated animate__fadeInUp animate__delay-1s">
        <template x-for="(_, index) in promos" :key="index">
            <button 
                @click="active = index" 
                :class="{'bg-white': active === index, 'bg-white/30': active !== index}"
                class="w-2 h-2 rounded-full transition-all duration-300"
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

    <!-- Título animado -->
    <h2 
        class="text-3xl md:text-4xl font-extrabold mb-8 text-transparent bg-clip-text bg-gradient-to-r from-pink-300 to-blue-300 tracking-tight animate__animated" 
        x-text="promos[active].title"
        :class="'animate__' + ['bounceIn', 'fadeInDown', 'zoomIn'][active % 3]"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 transform -translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
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
                        <div class="relative overflow-hidden w-full h-80 md:h-96"
                             x-data="{ hover: false }"
                             @mouseenter="hover = true" 
                             @mouseleave="hover = false">
                            <img 
                                :src="item.img" 
                                alt="Promoción"
                                class="w-full h-full object-cover shadow-xl border-2 border-purple-300 transition-all duration-700"
                                :class="hover ? 'scale-110 brightness-110' : ''"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/70 to-transparent transition-opacity duration-500"
                                 :class="hover ? 'opacity-30' : 'opacity-70'"></div>
                            
                            <!-- Animación de brillo que recorre la imagen -->
                            <div 
                                class="absolute inset-0 opacity-0"
                                :class="hover ? 'animate-shimmer' : ''"
                                style="background: linear-gradient(to right, transparent 0%, rgba(255,255,255,0.2) 50%, transparent 100%); background-size: 200% 100%;"
                            ></div>
                        </div>
                    </template>
                    <div 
                        class="bg-white text-purple-900 -mt-8 relative z-10 rounded-xl px-4 py-3 w-4/5 mx-auto shadow-lg border border-purple-200 transition-all duration-500 animate__animated"
                        :class="idx === 0 ? 'animate__bounceIn' : idx === 1 ? 'animate__flipInX' : 'animate__zoomIn'"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true" 
                        @mouseleave="hover = false"
                        :class="hover ? 'transform -translate-y-2 shadow-2xl bg-purple-50' : ''"
                    >
                        <p class="text-base font-bold uppercase tracking-wide" x-text="item.text"></p>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Botón mejorado -->
    <div class="mt-8 flex justify-center" data-aos="zoom-in" data-aos-delay="300">
        <a :href="promos[active].link"
            class="inline-block rounded-full bg-gradient-to-r from-violet-600 to-indigo-600 px-8 py-3 text-white font-bold shadow-lg hover:from-violet-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl animate__animated animate__pulse animate__infinite animate__slower">
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
    </style>
</div>