
<section class="container py-16 mx-auto" id="nosotros">
    <!-- Importamos las librerías de animaciones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                once: false,
                mirror: true,
                offset: 100
            });
        });
    </script>
    
    <div class="max-w-6xl mx-auto px-4">
        <!-- Título principal con animación -->
        <h2 class="relative text-4xl font-extrabold text-center mb-16 animate__animated animate__fadeInDown">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-amber-500 to-yellow-600">NUESTRA HISTORIA</span>
            <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-amber-500 to-yellow-600 rounded-full"></div>
            <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 w-20 h-1 bg-amber-300 rounded-full opacity-50 animate-pulse"></div>
        </h2>
        
        <!-- Sección Principal con mejor diseño de grid -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            <!-- Columna Izquierda (completamente rediseñada) -->
            <div class="md:col-span-5 flex flex-col" data-aos="fade-right" data-aos-delay="100">
                <!-- Tarjeta superior con el nombre y logo -->
                <div class="bg-gradient-to-br from-gray-900 to-black rounded-2xl shadow-xl overflow-hidden mb-6 transform transition hover:shadow-2xl hover:shadow-amber-500/20 duration-300 animate__animated animate__fadeIn animate__delay-1s">
                    <div class="relative">
                        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-40 h-40 bg-amber-500 rounded-full opacity-20 blur-2xl"></div>
                        <div class="p-8 relative">
                            <h2 class="text-4xl font-bold text-white mb-3 animate__animated animate__fadeInLeft animate__delay-2s">
                                <span class="bg-clip-text text-transparent bg-gradient-to-r from-amber-400 to-yellow-300">HORUS</span>
                            </h2>
                            <div class="h-0.5 w-16 bg-amber-500 mb-4"></div>
                            <p class="text-gray-300 text-lg">Pulseras artesanales hechas con amor y dedicación para quienes aprecian lo único.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Video en tarjeta separada y mejorada -->
                <div class="bg-gradient-to-br from-gray-900 to-black rounded-2xl shadow-xl overflow-hidden flex-grow transform transition hover:shadow-2xl hover:shadow-amber-500/20 duration-500 hover:-translate-y-2" data-aos="zoom-in" data-aos-delay="300">
                    <div class="p-5">
                        <h3 class="text-lg font-medium text-amber-400 mb-3 animate__animated animate__pulse animate__infinite animate__slow">Descubre nuestro proceso</h3>
                        
                        <!-- Video mejorado sin controles, auto reproducción y muted -->
                        <div class="rounded-xl overflow-hidden relative group">
                            <!-- Overlay con efecto de gradiente animado -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-100 z-10"></div>
                            
                            <!-- Borde animado -->
                            <div class="absolute inset-0 border-2 border-amber-500 opacity-0 group-hover:opacity-100 rounded-xl transition duration-300 z-20 transform scale-[0.98] group-hover:scale-100 animate__animated animate__pulse animate__infinite animate__slow"></div>
                            
                            <!-- Video autoreproducción y muted -->
                            <div class="w-full h-64 md:h-96 rounded-xl relative z-0 overflow-hidden">
                                <iframe 
                                    class="w-full h-full rounded-xl"
                                    src="https://www.youtube.com/embed/1MiRcgNHM1c?autoplay=1&mute=1&loop=1&playlist=1MiRcgNHM1c&controls=0&showinfo=0&rel=0"
                                    title="Pulsera Fácil y Rápida - Tutorial"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            
                            <!-- Efectos decorativos flotantes -->
                            <div class="absolute top-4 left-4 w-12 h-12 rounded-full bg-amber-500/20 animate__animated animate__pulse animate__infinite z-30"></div>
                            <div class="absolute bottom-4 right-4 w-12 h-12 rounded-full bg-amber-500/20 animate__animated animate__pulse animate__infinite animate__delay-1s z-30"></div>
                            
                            <!-- Texto superpuesto animado -->
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-black/60 backdrop-blur-sm transform translate-y-full group-hover:translate-y-0 transition-transform duration-500 z-40">
                                <p class="text-amber-300 text-sm font-medium">Descubre el arte detrás de cada pulsera Horus</p>
                            </div>
                        </div>
                        
                        <!-- Testimonios debajo del video con animación -->
                        <div class="mt-4 bg-gray-800/50 p-4 rounded-lg transform transition hover:bg-gray-800/80 duration-300" data-aos="fade-up" data-aos-delay="500">
                            <div class="flex items-center mb-2">
                                <div class="flex animate__animated animate__bounceIn animate__delay-3s">
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-400 text-sm ml-2">+500 clientes satisfechos</p>
                            </div>
                            <p class="text-gray-300 text-sm italic">"Las pulseras de Horus son increíbles. La calidad y los detalles son excepcionales"</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Columna Derecha (mejorada con animaciones) -->
            <div class="md:col-span-7 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white p-8 rounded-2xl shadow-xl border border-gray-700 flex flex-col justify-between transform transition hover:shadow-2xl hover:shadow-amber-500/20 duration-300" data-aos="fade-left" data-aos-delay="200">
                <div>
                    <h2 class="text-4xl font-bold text-center mb-10 animate__animated animate__fadeInDown animate__delay-1s">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-amber-400 to-yellow-300">NOSOTROS</span>
                        <div class="mt-3 h-1 w-20 bg-amber-400 mx-auto rounded-full"></div>
                    </h2>
                    
                    <div class="space-y-10 mt-8">
                        <!-- Calidad Garantizada -->
                        <div class="flex items-start space-x-6 group" data-aos="fade-up" data-aos-delay="300">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center bg-gray-700 group-hover:bg-amber-600 transition-colors duration-300 animate__animated animate__pulse animate__infinite animate__slow">
                                <svg class="w-8 h-8 text-amber-400 group-hover:text-white transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-amber-300 group-hover:text-amber-400 transition-colors duration-300">Calidad Garantizada</h3>
                                <p class="text-gray-300 mt-2 leading-relaxed">Nuestras pulseras pasan por un riguroso control de calidad para asegurar que cada pieza cumpla con nuestros altos estándares. Utilizamos materiales duraderos seleccionados cuidadosamente.</p>
                            </div>
                        </div>
                        
                        <!-- Envíos Nacionales -->
                        <div class="flex items-start space-x-6 group" data-aos="fade-up" data-aos-delay="500">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center bg-gray-700 group-hover:bg-amber-600 transition-colors duration-300 animate__animated animate__pulse animate__infinite animate__slow">
                                <svg class="w-8 h-8 text-amber-400 group-hover:text-white transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-amber-300 group-hover:text-amber-400 transition-colors duration-300">Envíos a Todo el País</h3>
                                <p class="text-gray-300 mt-2 leading-relaxed">Ofrecemos envíos nacionales para que puedas recibir tus pulseras Horus sin importar en qué parte del país te encuentres. Seguimiento disponible para cada pedido.</p>
                            </div>
                        </div>
                        
                        <!-- Diseños Exclusivos -->
                        <div class="flex items-start space-x-6 group" data-aos="fade-up" data-aos-delay="700">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center bg-gray-700 group-hover:bg-amber-600 transition-colors duration-300 animate__animated animate__pulse animate__infinite animate__slow">
                                <svg class="w-8 h-8 text-amber-400 group-hover:text-white transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-amber-300 group-hover:text-amber-400 transition-colors duration-300">Diseños Exclusivos</h3>
                                <p class="text-gray-300 mt-2 leading-relaxed">Cada pulsera Horus es única, con diseños contemporáneos que se adaptan a diferentes estilos para hombres, mujeres y parejas que buscan destacar.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- CTA Animado -->
                <div class="mt-12 text-center" data-aos="zoom-in" data-aos-delay="900">
                    <div class="inline-block bg-gradient-to-r from-amber-500 to-yellow-500 p-px rounded-lg shadow-lg transform hover:scale-110 transition duration-500 animate__animated animate__pulse animate__infinite animate__slow">
                        <a href="/nosotros" class="block bg-gray-800 text-amber-300 hover:text-white px-8 py-4 rounded-lg font-semibold transition duration-300">
                            Descubre más sobre nosotros
                            <svg class="inline-block w-5 h-5 ml-2 animate__animated animate__fadeInLeft animate__infinite animate__slow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>