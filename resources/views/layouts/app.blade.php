<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Pulseras Horus')</title>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://checkout.epayco.co/checkout.js"></script>
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
            @yield('pago')
            @yield('hombres')
            @yield('mujeres')
            @yield('parejas')
            @yield('crear')
            @yield('scripts')
            @yield('promo')
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
                        import('/js/alerts/toast.js').then(module => {
                            const { showToast } = module;
                            showToast('warning', "Debes iniciar sesión para calificar este producto.");
                        });
                        return;
                    }
                }

                const data = await response.json();
                console.log("Rating enviado correctamente:", data);
                import('/js/alerts/toast.js').then(module => {
                    const { showToast } = module;
                    showToast('success', "Calificación enviada correctamente.");
                });
            })
            .catch(error => {
                console.error("Error al enviar calificación:", error);
                import('/js/alerts/toast.js').then(module => {
                    const { showToast } = module;
                    showToast('error', "Error al enviar calificación.");
                });
            });
        }
</script>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>


<script>
AOS.init();
</script>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-data="{ open: false }" class="fixed bottom-5 right-5 z-50 text-white x-cloak" x-cloak>
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
<script src="{{ asset('js/alerts/toast.js') }}" type="module"></script>
 @include('components.loader')


    <!-- Scripts -->
    <script>
        function showLoader() {
            document.getElementById('loader').classList.remove('hidden');
        }

        function hideLoader() {
            document.getElementById('loader').classList.add('hidden');
        }
    </script>

    <script>
document.addEventListener('DOMContentLoaded', function() {

    const setupModernSearch = (idPrefix) => {
        const searchInput = document.getElementById(`${idPrefix}SearchInput`);
        const searchResults = document.getElementById(`${idPrefix}SearchResults`);
        const searchWrapper = document.querySelector(`.${idPrefix}-search-wrapper`);
        const inputWrapper = document.querySelector(`.${idPrefix}-search-input-wrapper`);
        const searchIcon = document.querySelector(`.${idPrefix}-search-icon`);
        const dropdownContent = searchResults.querySelector(`.${idPrefix}-search-dropdown-content`);

        if (!searchInput) return;

        let searchTimeout;

        function apiCall(query) {
           return fetch(`{{ route('products.search.ajax') }}?search=${encodeURIComponent(query)}`, {
               method: 'GET',
               headers: {
                   'X-Requested-With': 'XMLHttpRequest',
                   'Accept': 'application/json',
               }
           }).then(response => response.json());
        }

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            clearTimeout(searchTimeout);
            if (query.length < 2) {
                hideResults();
                return;
            }
            inputWrapper.classList.add('animate-pulse');
            searchTimeout = setTimeout(() => {
                apiCall(query)
                .then(data => {
                    displayResults(data.products);
                    inputWrapper.classList.remove('animate-pulse');
                })
                .catch(error => {
                    console.error('Error en la búsqueda AJAX:', error);
                    inputWrapper.classList.remove('animate-pulse');
                });
            }, 300);
        });

        function displayResults(products) {
            if (!products || products.length === 0) {
                dropdownContent.innerHTML = `
                    <div class="p-6 text-center text-gray-500">
                        <div class="text-xl mb-2">🤷‍♂️</div>
                        <div>No se encontraron productos</div>
                    </div>`;
            } else {
                dropdownContent.innerHTML = products.map((product) => `
                    <div class="search-result-item p-4 border-b border-gray-100 last:border-b-0 cursor-pointer transition-colors duration-200 hover:bg-indigo-50" onclick="navigateToProduct(${product.id})">
                        <div class="flex items-center space-x-4">
                            ${product.image ?
                                `<img src="/storage/${product.image}" alt="${product.name}" class="w-12 h-12 object-cover rounded-lg flex-shrink-0">` :
                                `<div class="w-12 h-12 bg-gray-200 rounded-lg flex-shrink-0 flex items-center justify-center"><svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 14m6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>`
                            }
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-800 truncate">${product.name}</div>
                                ${product.description ? `<div class="text-sm text-gray-600 truncate">${product.description}</div>` : ''}
                                <div class="text-sm font-bold text-indigo-600 mt-1">$${parseFloat(product.price).toLocaleString()}</div>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
            showResults();
        }

        function showResults() {
            searchResults.classList.remove('opacity-0', 'invisible', 'pointer-events-none');
        }

        function hideResults() {
            searchResults.classList.add('opacity-0', 'invisible', 'pointer-events-none');
        }

        window.navigateToProduct = function(productId) {
            hideResults();
            if(typeof showLoader === 'function') {
                showLoader();
            }
            window.location.href = `/products/${productId}`;
        };

        document.addEventListener('click', function(event) {
            if (searchWrapper && !searchWrapper.contains(event.target)) {
                hideResults();
            }
        });
    }

    setupModernSearch('modern');
    setupModernSearch('modern-mobile');
});
</script>
</body>
</html>
