<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Sena-Laravel')</title>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen bg-[#212235]">
    <div x-data="carritoApp()" x-init="cargarDesdeLocalStorage()" class="flex flex-col flex-grow relative">
        @if(session('alert'))
            <x-alert type="success" :message="session('alert')" />
        @endif

        <header>
            <x-navbar />
        </header>

        <!-- Contenido principal -->
        <main class="flex-grow">
            @yield('content')
            @yield('hombres')
            @yield('mujeres')
            @yield('parejas')
            @yield('crear')
            @yield('scripts')
        </main>
        
        <!-- Footer -->
        <footer>
            <x-footer />
        </footer>
    </div>

    <script>
        function submitRating(productId, ratingValue) {
            fetch('/ratings', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    product_id: productId,
                    rating: ratingValue
                })
            })
            .then(async (response) => {
                const contentType = response.headers.get("content-type");

                // Si no es JSON, es probablemente un HTML de redirección
                if (!contentType || !contentType.includes("application/json")) {
                    const text = await response.text();
                    if (text.startsWith('<!DOCTYPE html>')) {
                        alert("Debes iniciar sesión para calificar este producto.");
                        return;
                    }
                }

                const data = await response.json();
                console.log("Rating enviado correctamente:", data);
                // Mostrar mensaje de éxito (puedes usar tu componente de alerta)
            })
            .catch(error => {
                console.error("Error al enviar calificación:", error);
            });
        }
</script>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>


<script>
AOS.init();
</script>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-data="{ open: false }" class="fixed bottom-5 right-5 z-50 text-white">
    <!-- Botón de WhatsApp (icono SVG incluido) -->
    <button @click="open = !open"
        class="bg-green-500 p-3 rounded-full shadow-lg hover:scale-110 transition flex items-center justify-center w-14 h-14">
        <!-- Ícono WhatsApp SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" width="24" height="24">
            <path
                d="M20.52 3.48A11.94 11.94 0 0012 0C5.37 0 0 5.37 0 12a11.94 11.94 0 001.66 6.01L0 24l6.26-1.64A11.94 11.94 0 0012 24c6.63 0 12-5.37 12-12 0-3.18-1.23-6.17-3.48-8.52zM12 22c-1.77 0-3.5-.45-5.02-1.29l-.36-.2-3.71.97.99-3.63-.23-.38A9.92 9.92 0 012 12C2 6.49 6.49 2 12 2s10 4.49 10 10-4.49 10-10 10zm5.02-7.38c-.27-.14-1.6-.79-1.84-.88-.25-.1-.43-.14-.6.14-.18.27-.7.88-.86 1.06-.16.18-.32.2-.6.07-.27-.14-1.14-.42-2.18-1.34-.81-.73-1.36-1.63-1.53-1.9-.16-.27-.02-.42.12-.56.12-.12.27-.3.4-.45.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.14-.6-1.45-.83-2-.22-.52-.45-.45-.6-.45h-.52c-.18 0-.45.07-.68.34-.23.27-.9.88-.9 2.14 0 1.26.92 2.48 1.04 2.65.12.18 1.81 2.77 4.4 3.89.62.27 1.1.43 1.48.55.62.2 1.17.17 1.61.1.49-.07 1.6-.65 1.83-1.27.23-.63.23-1.17.16-1.28-.07-.12-.25-.18-.52-.3z" />
        </svg>
    </button>

    <!-- Caja desplegable -->
    <div x-show="open" x-transition 
        class="mt-2 bg-white text-gray-800 rounded-xl shadow-lg p-4 w-64"
        @click.outside="open = false">
        <p class="font-semibold text-sm">¿Estás interesado en nuestro catálogo?</p>
        <p class="text-xs mb-3">Haz clic en el botón de abajo para chatear con nosotros por WhatsApp.</p>
        <a href="https://wa.me/573023851370?text=Hola,%20estoy%20interesado%20en%20tu%20catalogo."
        class="bg-green-500 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-green-600 transition block text-center"
        target="_blank">
            Ir a WhatsApp
        </a>
   </div>
</div>






</body>
</html>
