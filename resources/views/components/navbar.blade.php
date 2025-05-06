<nav class="bg-[#212235] text-white " x-data="{ mobileOpen: false }">
    <div class="relative flex items-center justify-between container mx-auto px-4 py-3">
        
        <!-- Mobile hamburger button -->
        <button 
            @click="mobileOpen = true"
            class="lg:hidden text-white focus:outline-none">
            @guest
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            @endguest
            @auth
                <div class="flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
            @endauth
        </button>

        <!-- Logo -->
        <div class="flex-1 flex justify-center lg:justify-start">
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/Logo.png') }}" alt="Horus Logo" class="h-12 w-auto">
            </a>
        </div>

        <!-- Desktop menu -->
        <div class="hidden lg:flex items-center space-x-6">
            
            <!-- INICIO -->
            <a href="/" class="flex items-center hover:text-yellow-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Inicio</span>
            </a>

            <!-- NOSOTROS -->
            <a href="/nosotros" class="flex items-center hover:text-yellow-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Nosotros</span>
            </a>

            <a href="/carrito" class="relative flex items-center hover:text-yellow-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Carrito</span>
                @if ($cartItemCount > 0)
                    <span class="absolute -top-3 -right-2 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                        {{ $cartItemCount }}
                    </span>
                @endif
            </a>

            @auth
                <!-- Admin Controls -->
                @if(Auth::user()->role->name === 'admin')
                    <div class="flex items-center space-x-2">
                        <a href="/admin/graficas" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Gráficas
                        </a>
                        <a href="/crear" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500 transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Nuevo Producto
                        </a>
                        <a href="{{ route('admin.comentarios') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500 transition flex items-center">Gestionar Comentarios</a>
                    </div>
                @endif

                <!-- User Profile -->
                <div class="relative" x-data="{ open: false }">
                    <div @click="open = !open" class="cursor-pointer flex items-center space-x-2 px-3 py-2 rounded-lg" :class="{'bg-gray-800': open}">
                        @if(Auth::user()->role->name === 'admin')
                            <div class="bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">ADMIN</div>
                        @else
                            <div class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold">USUARIO</div>
                        @endif
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="ml-1 font-medium">{{ explode(' ', Auth::user()->name)[0] }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <div x-show="open" x-cloak @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white text-black rounded-lg shadow-xl z-50 overflow-hidden">
                        <div class="py-2">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('perfil.editar') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Perfil de usuario
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-left hover:bg-gray-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            @guest
                <div class="flex items-center space-x-3">
                    <a href="/login" class="bg-yellow-500 text-black font-medium px-4 py-2 rounded-lg hover:bg-yellow-400 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Inicia sesión
                    </a>
                    <a href="/registro" class="bg-gray-700 text-white font-medium px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Registrate
                    </a>
                </div>
            @endguest
        </div>
    </div>

    <!-- Mobile sidebar -->
    <div 
        x-cloak
        class="fixed inset-0 z-50 lg:hidden" 
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-70" @click="mobileOpen = false"></div>
        
        <!-- Sidebar -->
        <div 
            class="absolute left-0 top-0 w-72 h-full bg-gray-900 text-white shadow-xl overflow-y-auto"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full">
            
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between p-4 border-b border-gray-700">
                    <a href="/">
                        <img src="{{ asset('images/Logo.png') }}" alt="Horus Logo" class="h-10 w-auto">
                    </a>
                    <button class="text-gray-400 hover:text-white" @click="mobileOpen = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="p-4 flex-1">
                    @auth
                        <div class="mb-6 p-3 bg-gray-800 rounded-lg">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="p-2 bg-gray-700 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            
                            @if(Auth::user()->role->name === 'admin')
                                <div class="bg-red-500 text-center py-1 px-2 rounded font-bold text-sm mb-2">ADMIN</div>
                            @else
                                <div class="bg-blue-500 text-center py-1 px-2 rounded font-bold text-sm mb-2">USUARIO</div>
                            @endif
                        </div>
                        
                        @if(Auth::user()->role->name === 'admin')
                            <div class="mb-6 space-y-2">
                                <h3 class="text-xs uppercase text-gray-500 font-semibold">Panel de administración</h3>
                                <a href="/admin/graficas" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <span>Ver Gráficas</span>
                                </a>
                                <a href="/crear" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Agregar producto</span>
                                </a>
                                <a href="{{ route('admin.comentarios') }}" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2h2M15 3h-6a2 2 0 00-2 2v4h10V5a2 2 0 00-2-2z" />
                                    </svg>
                                    <span>Gestionar Comentarios</span>
                                </a>
                                
                            </div>
                        @endif
                    @endauth
                    
                    <!-- Navigation links -->
                    <div class="space-y-1">
                        <h3 class="text-xs uppercase text-gray-500 font-semibold mt-4 mb-2">Navegación</h3>
                        
                        <!-- INICIO -->
                        <a href="/" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Inicio</span>
                        </a>
                        
                        <!-- NOSOTROS -->
                        <a href="/nosotros" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Nosotros</span>
                        </a>
                        
                        <a href="/carrito" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Carrito</span>
                            @if ($cartItemCount > 0)
                                <span class="bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full ml-">
                                    {{ $cartItemCount }}
                                </span>
                            @endif
                        </a>
                    </div>
                    
                    @auth
                        <div class="mt-6 pt-6 border-t border-gray-700">
                            <a href="{{ route('perfil.editar') }}" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-800 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linej   oin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Perfil de usuario</span>
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Cerrar sesión</span>
                                </button>
                            </form>
                        </div>
                    @endauth
                    
                    @guest
                        <div class="mt-6 space-y-3">
                            <a href="/login" class="w-full  bg-yellow-500 text-black font-medium px-4 py-2 rounded-lg hover:bg-yellow-400 transition text-center flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Inicia sesión
                            </a>
                            <a href="/registro" class="w-full  bg-gray-700 text-white font-medium px-4 py-2 rounded-lg hover:bg-gray-600 transition text-center flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Registrate
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
   </div>
</nav>