<!-- components/loader.blade.php -->

<style>
    /* Colores personalizados que coinciden con tu página */
    :root {
        --horus-navy: #2D3748;
        --horus-dark: #1A202C;
        --horus-gold: #F6E05E;
        --horus-light-gold: #FAF089;
        --horus-blue: #4299E1;
        --horus-light-blue: #63B3ED;
    }

    /* Animaciones suaves y elegantes */
    @keyframes elegant-pulse {
        0%, 100% {
            transform: scale(0.9);
            opacity: 0.6;
        }
        50% {
            transform: scale(1.1);
            opacity: 1;
        }
    }

    @keyframes luxury-bounce {
        0%, 100% {
            transform: translateY(0) scale(1);
            opacity: 0.8;
        }
        50% {
            transform: translateY(-16px) scale(1.05);
            opacity: 1;
        }
    }

    @keyframes royal-wave {
        0%, 40%, 100% {
            transform: scaleY(0.4);
            opacity: 0.6;
        }
        20% {
            transform: scaleY(1);
            opacity: 1;
        }
    }

    @keyframes horus-spin {
        0% {
            transform: rotate(0deg);
            border-color: var(--horus-gold) transparent var(--horus-blue) transparent;
        }
        25% {
            border-color: var(--horus-blue) var(--horus-gold) transparent transparent;
        }
        50% {
            transform: rotate(180deg);
            border-color: transparent var(--horus-blue) var(--horus-gold) transparent;
        }
        75% {
            border-color: transparent transparent var(--horus-blue) var(--horus-gold);
        }
        100% {
            transform: rotate(360deg);
            border-color: var(--horus-gold) transparent var(--horus-blue) transparent;
        }
    }

    /* Efecto glassmorphism con los colores de tu página */
    .horus-glass-bg {
        backdrop-filter: blur(12px);
        background: rgba(45, 55, 72, 0.85);
        border: 1px solid rgba(246, 224, 94, 0.2);
    }

    /* Gradientes que coinciden con tu paleta */
    .horus-gradient {
        background: linear-gradient(135deg, var(--horus-gold) 0%, var(--horus-light-gold) 50%, var(--horus-blue) 100%);
    }

    .horus-blue-gradient {
        background: linear-gradient(135deg, var(--horus-blue) 0%, var(--horus-light-blue) 100%);
    }

    .horus-gold-gradient {
        background: linear-gradient(135deg, var(--horus-gold) 0%, var(--horus-light-gold) 100%);
    }

    /* Aplicar animaciones */
    .elegant-pulse {
        animation: elegant-pulse 1.8s ease-in-out infinite;
    }

    .elegant-pulse:nth-child(2) {
        animation-delay: -0.6s;
    }

    .elegant-pulse:nth-child(3) {
        animation-delay: -1.2s;
    }

    .luxury-bounce {
        animation: luxury-bounce 1.4s ease-in-out infinite;
    }

    .luxury-bounce:nth-child(2) {
        animation-delay: -0.47s;
    }

    .luxury-bounce:nth-child(3) {
        animation-delay: -0.94s;
    }

    .royal-wave {
        animation: royal-wave 1.2s ease-in-out infinite;
    }

    .royal-wave:nth-child(2) { animation-delay: -1s; }
    .royal-wave:nth-child(3) { animation-delay: -0.8s; }
    .royal-wave:nth-child(4) { animation-delay: -0.6s; }
    .royal-wave:nth-child(5) { animation-delay: -0.4s; }

    .horus-spinner {
        animation: horus-spin 2s linear infinite;
    }

    /* Transiciones suaves */
    .horus-smooth-transition {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Efecto de brillo dorado */
    .horus-golden-glow {
        box-shadow: 0 0 20px rgba(246, 224, 94, 0.5);
    }

    .horus-blue-glow {
        box-shadow: 0 0 20px rgba(66, 153, 225, 0.4);
    }

    /* Animación de texto */
    @keyframes horus-text-glow {
        0%, 100% {
            text-shadow: 0 0 5px rgba(246, 224, 94, 0.5);
        }
        50% {
            text-shadow: 0 0 15px rgba(246, 224, 94, 0.8);
        }
    }

    .horus-text-glow {
        animation: horus-text-glow 2s ease-in-out infinite;
    }

    /* Loader oculto por defecto */
    #loader {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    #loader:not(.hidden) {
        opacity: 1;
        visibility: visible;
    }
</style>

<!-- Loader Principal -->
<div id="loader" class="fixed inset-0 horus-glass-bg flex items-center justify-center z-50 hidden horus-smooth-transition">
    <div class="text-center">
        <!-- Elegant Pulse Loader (por defecto) -->
        <div id="elegant-loader" class="flex space-x-4 mb-6">
            <div class="w-5 h-5 horus-gold-gradient rounded-full elegant-pulse horus-golden-glow"></div>
            <div class="w-5 h-5 horus-blue-gradient rounded-full elegant-pulse horus-blue-glow"></div>
            <div class="w-5 h-5 horus-gradient rounded-full elegant-pulse"></div>
        </div>
        
        <!-- Luxury Bounce Loader -->
        <div id="luxury-loader" class="flex space-x-3 mb-6 hidden">
            <div class="w-6 h-6 horus-gold-gradient rounded-full luxury-bounce horus-golden-glow shadow-xl"></div>
            <div class="w-6 h-6 horus-blue-gradient rounded-full luxury-bounce horus-blue-glow shadow-xl"></div>
            <div class="w-6 h-6 horus-gradient rounded-full luxury-bounce shadow-xl"></div>
        </div>

        <!-- Royal Wave Loader -->
        <div id="royal-loader" class="flex space-x-1 items-end mb-6 hidden">
            <div class="w-3 h-8 horus-gold-gradient rounded-full royal-wave horus-golden-glow"></div>
            <div class="w-3 h-12 horus-blue-gradient rounded-full royal-wave horus-blue-glow"></div>
            <div class="w-3 h-6 horus-gradient rounded-full royal-wave"></div>
            <div class="w-3 h-10 horus-blue-gradient rounded-full royal-wave horus-blue-glow"></div>
            <div class="w-3 h-14 horus-gold-gradient rounded-full royal-wave horus-golden-glow"></div>
        </div>

        <!-- Horus Spinner -->
        <div id="spinner-loader" class="mb-6 hidden">
            <div class="relative">
                <!-- Anillo exterior -->
                <div class="w-20 h-20 border-4 rounded-full horus-spinner horus-golden-glow" 
                     style="border-color: var(--horus-gold) transparent var(--horus-blue) transparent;"></div>
                <!-- Anillo interior -->
                <div class="absolute top-2 left-2 w-16 h-16 border-4 rounded-full horus-spinner horus-blue-glow" 
                     style="border-color: transparent var(--horus-blue) transparent var(--horus-gold); animation-duration: 1.5s; animation-direction: reverse;"></div>
                <!-- Centro dorado -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-6 h-6 horus-gold-gradient rounded-full animate-pulse horus-golden-glow"></div>
            </div>
        </div>

        <!-- Texto elegante -->
        <p class="text-yellow-200 font-light text-lg horus-text-glow">
            Cargando<span class="animate-pulse">...</span>
        </p>
    </div>
</div>

<script>
    // Variables globales para el loader
    window.HorusLoader = {
        currentType: 'elegant',
        isVisible: false,
        
        // Mostrar loader con tipo específico
        show: function(type = 'elegant') {
            const loader = document.getElementById('loader');
            
            // Ocultar todos los tipos
            document.getElementById('elegant-loader')?.classList.add('hidden');
            document.getElementById('luxury-loader')?.classList.add('hidden');
            document.getElementById('royal-loader')?.classList.add('hidden');
            document.getElementById('spinner-loader')?.classList.add('hidden');
            
            // Mostrar el tipo seleccionado
            const targetLoader = document.getElementById(type + '-loader');
            if (targetLoader) {
                targetLoader.classList.remove('hidden');
                this.currentType = type;
            } else {
                // Fallback al elegant si no existe el tipo
                document.getElementById('elegant-loader')?.classList.remove('hidden');
                this.currentType = 'elegant';
            }
            
            loader?.classList.remove('hidden');
            this.isVisible = true;
            
            // Prevenir scroll del body
            document.body.style.overflow = 'hidden';
        },
        
        // Ocultar loader
        hide: function() {
            const loader = document.getElementById('loader');
            loader?.classList.add('hidden');
            this.isVisible = false;
            
            // Restaurar scroll del body
            document.body.style.overflow = '';
        },
        
        // Toggle loader
        toggle: function(type = 'elegant') {
            if (this.isVisible) {
                this.hide();
            } else {
                this.show(type);
            }
        },
        
        // Cambiar tipo de loader sin ocultar
        changeType: function(type) {
            if (this.isVisible) {
                this.show(type);
            }
        }
    };

    // Funciones globales para mantener compatibilidad
    function showLoader(type = 'elegant') {
        window.HorusLoader.show(type);
    }

    function hideLoader() {
        window.HorusLoader.hide();
    }

    // Función para operaciones asíncronas
    async function withHorusLoader(asyncFunction, loaderType = 'elegant') {
        showLoader(loaderType);
        try {
            const result = await asyncFunction();
            return result;
        } catch (error) {
            console.error('Error en operación con loader:', error);
            throw error;
        } finally {
            // Pequeño delay para suavidad visual
            setTimeout(hideLoader, 300);
        }
    }

    // Auto-ocultar si se hace clic fuera (opcional)
    document.addEventListener('click', function(e) {
        const loader = document.getElementById('loader');
        if (e.target === loader && window.HorusLoader.isVisible) {
            // Descomentar la siguiente línea si quieres que se oculte al hacer clic fuera
            // hideLoader();
        }
    });

    // Manejo de tecla ESC para ocultar loader
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && window.HorusLoader.isVisible) {
            hideLoader();
        }
    });
</script>

