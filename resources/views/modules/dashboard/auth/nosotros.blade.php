@extends('layouts.app')

@section('title', 'Nosotros - Horus Manillas')
@section('content')

<script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2b2d42',
                        secondary: '#1a1b2e',
                        accent: '#fbbf24'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-in-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease-out;
        }

        .slide-in-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .slide-in-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s ease-out;
        }

        .slide-in-right.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .hero-bg {
            background: linear-gradient(135deg, #2b2d42 0%, #1a1b2e 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 2px,
                rgba(251, 191, 36, 0.03) 2px,
                rgba(251, 191, 36, 0.03) 4px
            );
            animation: shimmer 20s linear infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100px) translateY(-100px); }
            100% { transform: translateX(100px) translateY(100px); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .glow-card {
            background: linear-gradient(145deg, rgba(28, 29, 46, 0.8), rgba(28, 29, 46, 0.4));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(251, 191, 36, 0.2);
            position: relative;
            overflow: hidden;
        }

        .glow-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(251, 191, 36, 0.1), transparent);
            transition: left 0.8s ease;
        }

        .glow-card:hover::before {
            left: 100%;
        }

        .glow-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(251, 191, 36, 0.1);
        }

        .text-gradient {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from { box-shadow: 0 0 20px rgba(251, 191, 36, 0.3); }
            to { box-shadow: 0 0 30px rgba(251, 191, 36, 0.5); }
        }

        .sparkle {
            position: relative;
        }

        .sparkle::after {
            content: '✨';
            position: absolute;
            top: -10px;
            right: -10px;
            animation: sparkle 2s linear infinite;
        }

        @keyframes sparkle {
            0%, 100% { opacity: 1; transform: scale(1) rotate(0deg); }
            50% { opacity: 0.5; transform: scale(1.2) rotate(180deg); }
        }

        .gradient-border {
            position: relative;
            background: linear-gradient(145deg, rgba(28, 29, 46, 0.9), rgba(28, 29, 46, 0.7));
            border-radius: 1rem;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 2px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b, #fbbf24);
            border-radius: inherit;
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: xor;
            -webkit-mask-composite: xor;
        }

        .cta-button {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(251, 191, 36, 0.3);
        }
    </style>
</head>
<body class="bg-gradient-to-b from-primary to-secondary text-white min-h-screen">

    <!-- Hero Banner Mejorado -->
    <section class="relative bg-cover bg-center h-[500px] overflow-hidden" 
             style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('images/nosotros2.jpg');">
        
        <div class="absolute inset-0 hero-bg opacity-30"></div>
        
        <!-- Elementos decorativos flotantes -->
        <div class="absolute top-20 left-20 w-4 h-4 bg-accent rounded-full floating opacity-60"></div>
        <div class="absolute top-40 right-32 w-3 h-3 bg-accent rounded-full floating opacity-80" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-32 left-1/4 w-2 h-2 bg-accent rounded-full floating opacity-70" style="animation-delay: -4s;"></div>
        
        <div class="absolute inset-0 flex items-center justify-center z-20">
            <div class="text-center px-6 max-w-4xl mx-auto">
                <div class="sparkle inline-block mb-6">
                    <svg class="w-16 h-16 text-accent floating" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8L12 2z"/>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-gradient mb-6 fade-in">
                    Porque te da el brillo y el estilo que necesitas
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-accent to-yellow-300 mx-auto rounded-full fade-in" style="animation-delay: 0.3s;"></div>
            </div>
        </div>
        
        <!-- Efecto de máscara degradado -->
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-secondary opacity-60"></div>
    </section>

    <!-- Historia Mejorada -->
    <section class="px-6 md:px-20 py-20 max-w-7xl mx-auto">
        <h2 class="text-4xl md:text-5xl font-bold text-gradient mb-12 text-center fade-in">Nosotros</h2>
        
        <div class="flex flex-col lg:flex-row items-center gap-12 max-w-6xl mx-auto">
            
            
            <div class="flex-1 slide-in-right">
                <div class="gradient-border p-8">
                    <p class="text-gray-300 text-lg md:text-xl leading-relaxed text-center lg:text-left">
                        En nuestra tienda, las pulseras Horus no son solo un accesorio, 
                        <span class="text-accent font-semibold">¡son una conexión con tu energía interior!</span> 
                        Diseñadas con símbolos poderosos y materiales de alta calidad, cada pulsera representa 
                        <span class="text-gradient font-semibold">protección, sabiduría y equilibrio.</span> 
                        Con un estilo único y moderno, nuestras pulseras son el complemento perfecto para cualquier ocasión. 
                        <span class="text-accent font-semibold">¡Lleva contigo la energía de Horus y marca la diferencia!</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Misión y Visión Mejorada -->
    <section class="py-20 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 fade-in">
                <h3 class="text-3xl md:text-4xl font-bold text-gradient mb-4">Nuestros Pilares</h3>
                <div class="w-32 h-1 bg-gradient-to-r from-accent to-yellow-300 mx-auto rounded-full"></div>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Misión -->
                <div class="glow-card rounded-2xl p-8 transition-all duration-500 slide-in-left">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-accent to-yellow-300 rounded-full flex items-center justify-center floating">
                            <svg class="w-8 h-8 text-black" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9M10,16V19.08L13.08,16H20V4H4V16H10Z"/>
                            </svg>
                        </div>
                        <h4 class="text-2xl md:text-3xl font-bold text-gradient">Nuestra Misión</h4>
                    </div>
                    <p class="text-gray-300 text-lg leading-relaxed">
                        Brindar a nuestros clientes pulseras de <span class="text-accent font-semibold">alta calidad</span> 
                        con diseños únicos y personalizados, a través de una plataforma web que facilite la compra, 
                        comunicación y acceso a <span class="text-gradient font-semibold">promociones exclusivas.</span>
                    </p>
                </div>

                <!-- Visión -->
                <div class="glow-card rounded-2xl p-8 transition-all duration-500 slide-in-right">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-accent to-yellow-300 rounded-full flex items-center justify-center floating" style="animation-delay: -3s;">
                            <svg class="w-8 h-8 text-black" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                            </svg>
                        </div>
                        <h4 class="text-2xl md:text-3xl font-bold text-gradient">Nuestra Visión</h4>
                    </div>
                    <p class="text-gray-300 text-lg leading-relaxed">
                        Ser una marca <span class="text-accent font-semibold">reconocida a nivel nacional e internacional</span> 
                        por conectar a las personas con su esencia interior a través de pulseras únicas, artesanales y 
                        cargadas de significado. Queremos inspirar <span class="text-gradient font-semibold">confianza, 
                        protección y estilo,</span> llevando un mensaje positivo en cada pieza que creamos.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Mejorado -->
    <section class="py-24 text-center relative overflow-hidden bg-cover bg-center"
             style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('images/nosotros3.jpg');">
        
        <!-- Elementos decorativos -->
        <div class="absolute top-10 left-10 w-6 h-6 border-2 border-accent rounded-full floating opacity-50"></div>
        <div class="absolute top-20 right-20 w-4 h-4 bg-accent rounded-full floating opacity-60" style="animation-delay: -1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-8 h-8 border border-accent rounded-full floating opacity-40" style="animation-delay: -3s;"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-6">
            <div class="mb-8 fade-in">
                <div class="w-20 h-20 bg-gradient-to-br from-accent to-yellow-300 rounded-full flex items-center justify-center mx-auto mb-6 pulse-glow floating">
                    <svg class="w-10 h-10 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5,8.5L11,5L17,8.5V15.5L11,19L5,15.5V8.5M12,2L20,6.5V17.5L12,22L4,17.5V6.5L12,2M11,7.5V16.5L18,12.5V9.5L11,7.5Z"/>
                    </svg>
                </div>
            </div>
            
            <h4 class="text-3xl md:text-5xl font-bold text-gradient mb-6 fade-in">
                Descubre tu próxima manilla favorita
            </h4>
            
            <p class="text-gray-300 text-xl md:text-2xl mb-10 fade-in" style="animation-delay: 0.3s;">
                Diseñada para ti, con <span class="text-accent font-semibold">energía y propósito.</span>
            </p>
            
            <div class="fade-in" style="animation-delay: 0.6s;">
                <a href="/hombres" class="cta-button inline-block text-black font-bold px-10 py-4 rounded-full text-lg transition-all duration-300 hover:scale-105">
                    Ver Catálogo ✨
                </a>
            </div>
        </div>
        
        <!-- Efecto de máscara degradado -->
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-secondary opacity-40"></div>
    </section>

    <script>
        // Intersection Observer para animaciones
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observar todos los elementos con clases de animación
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right');
            animatedElements.forEach(el => observer.observe(el));
        });

        // Efecto de parallax suave en el scroll
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroElements = document.querySelectorAll('.floating');
            
            heroElements.forEach((element, index) => {
                const speed = 0.5 + (index * 0.1);
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });
    </script>
</body>
@endsection

