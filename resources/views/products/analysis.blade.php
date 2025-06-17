@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-3xl text-white font-bold mb-8 text-center">Análisis de Productos con Mejor Rating</h1>

    @if($productos->count())
        @php
            $topProducto = $productos->first();
        @endphp

        <!-- Productos con mayor rating -->
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-5xl mx-auto mb-12">
            <h2 class="text-2xl font-bold text-center mb-6">Top 5 Productos con Mejor Valoración</h2>

            <div class="space-y-8">
                @foreach($productos as $producto)
                    <div class="flex flex-col md:flex-row items-center gap-6 border-b pb-6 hover:bg-gray-50 transition-colors duration-200">
                        <img src="{{ asset('storage/' . $producto->image) }}" alt="{{ $producto->name }}" class="w-32 h-32 object-cover rounded-md shadow-md">
                        <div class="text-center md:text-left md:flex-1">
                            <h3 class="text-xl font-semibold">{{ $producto->name }}</h3>
                            <p class="text-gray-600 mt-1">Categoría: <span class="font-medium">{{ $producto->category->name ?? 'Sin categoría' }}</span></p>
                            <div class="flex items-center justify-center md:justify-start mt-2">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($producto->ratings_avg_rating))
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="ml-2 font-bold text-lg">{{ number_format($producto->ratings_avg_rating, 2) }}</span>
                                </div>
                                <span class="text-sm text-gray-500 ml-3">({{ $producto->ratings_count }} valoraciones)</span>
                            </div>
                            <p class="text-gray-800 font-bold mt-2">Precio: COP {{ number_format($producto->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Panel de Gráficas Mejorado -->
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-7xl mx-auto mb-12">
            <h2 class="text-2xl font-bold text-center mb-6">Análisis Visual de Productos</h2>
            
            <!-- Tabs para seleccionar diferentes visualizaciones -->
            <div class="mb-6 flex justify-center">
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <button type="button" class="tab-button active px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 border border-blue-200 rounded-l-lg hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200" data-tab="ratingsChart">
                        Valoraciones
                    </button>
                    <button type="button" class="tab-button px-4 py-2 text-sm font-medium text-blue-700 bg-white border border-blue-200 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200" data-tab="categoriesChart">
                        Categorías Visitadas
                    </button>
                    <button type="button" class="tab-button px-4 py-2 text-sm font-medium text-blue-700 bg-white border border-blue-200 rounded-r-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200" data-tab="salesChart">
                        Productos Más Comprados
                    </button>
                </div>
            </div>
            
            <!-- Contenedor de gráficos -->
            <!-- Gráfico de Valoraciones -->
            <div class="tab-content active" id="ratingsChart">
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div class="md:w-1/2">
                        <h3 class="text-lg font-semibold mb-3 text-center">Promedio de Valoración</h3>
                        <div class="relative h-80 w-full">
                            <canvas id="ratingChart"></canvas>
                        </div>
                    </div>
                    <div class="md:w-1/2">
                        <h3 class="text-lg font-semibold mb-3 text-center">Cantidad de Valoraciones</h3>
                        <div class="relative h-80 w-full">
                            <canvas id="countChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gráfico de Categorías Más Visitadas -->
            <div class="tab-content hidden" id="categoriesChart">
                <div class="flex flex-col lg:flex-row justify-between gap-6">
                    <div class="lg:w-1/2">
                        <h3 class="text-lg font-semibold mb-3 text-center">Categorías Más Populares (Por Ventas)</h3>
                        <div class="relative h-80 w-full">
                            <canvas id="categoriesVisitedChart"></canvas>
                        </div>
                    </div>
                    <div class="lg:w-1/2">
                        <h3 class="text-lg font-semibold mb-3 text-center">Distribución de Ventas por Categoría</h3>
                        <div class="relative h-80 w-full">
                            <canvas id="categoriesPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gráfico de Productos Más Comprados -->
            <div class="tab-content hidden" id="salesChart">
                <div class="flex flex-col lg:flex-row justify-between gap-6">
                    <div class="lg:w-1/2">
                        <h3 class="text-lg font-semibold mb-3 text-center">Productos Más Comprados</h3>
                        <div class="relative h-80 w-full">
                            <canvas id="salesProductsChart"></canvas>
                        </div>
                    </div>
                    <div class="lg:w-1/2">
                        <h3 class="text-lg font-semibold mb-3 text-center">Ingresos por Producto</h3>
                        <div class="relative h-80 w-full">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-white text-lg">No hay productos con valoraciones aún.</p>
    @endif
</div>

<style>
.tab-content {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.tab-button {
    cursor: pointer;
    user-select: none;
}

.tab-button:hover {
    transform: translateY(-1px);
}

.tab-button.active {
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Paleta de colores predefinida
    const colorPalette = [
        { background: 'rgba(54, 162, 235, 0.7)', border: 'rgba(54, 162, 235, 1)' },
        { background: 'rgba(255, 99, 132, 0.7)', border: 'rgba(255, 99, 132, 1)' },
        { background: 'rgba(75, 192, 192, 0.7)', border: 'rgba(75, 192, 192, 1)' },
        { background: 'rgba(255, 159, 64, 0.7)', border: 'rgba(255, 159, 64, 1)' },
        { background: 'rgba(153, 102, 255, 0.7)', border: 'rgba(153, 102, 255, 1)' },
        { background: 'rgba(255, 205, 86, 0.7)', border: 'rgba(255, 205, 86, 1)' },
        { background: 'rgba(201, 203, 207, 0.7)', border: 'rgba(201, 203, 207, 1)' },
        { background: 'rgba(255, 159, 132, 0.7)', border: 'rgba(255, 159, 132, 1)' },
        { background: 'rgba(132, 255, 159, 0.7)', border: 'rgba(132, 255, 159, 1)' },
        { background: 'rgba(159, 132, 255, 0.7)', border: 'rgba(159, 132, 255, 1)' }
    ];

    // Datos de los productos
    const productos = @json($productos);
    const nombres = productos.map(p => p.name);
    const promedios = productos.map(p => parseFloat(p.ratings_avg_rating).toFixed(2));
    const cantidades = productos.map(p => p.ratings_count);

    // Datos reales para categorías más populares
    const categorias = @json($categoriasPopulares);

    // Datos reales para productos más comprados
    const productosComprados = @json($productosComprados);
    
    // Datos adicionales para productos que generan más ingresos
    const productosIngresos = @json($productosIngresos);
    
    // Estadísticas generales
    const estadisticas = @json($estadisticas);

    // Asignar colores
    const backgroundColors = productos.map((_, index) => colorPalette[index % colorPalette.length].background);
    const borderColors = productos.map((_, index) => colorPalette[index % colorPalette.length].border);

    // Opciones comunes para las gráficas
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 15,
                    padding: 15,
                    font: {
                        size: 12
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                padding: 12,
                cornerRadius: 6,
                displayColors: true
            }
        }
    };

    // Función para mostrar/ocultar tabs
    function showTab(tabId) {
        // Ocultar todos los contenidos
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
            content.classList.remove('active');
        });
        
        // Mostrar el tab seleccionado
        const targetTab = document.getElementById(tabId);
        if (targetTab) {
            targetTab.classList.remove('hidden');
            targetTab.classList.add('active');
        }
        
        // Actualizar botones
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'bg-blue-100');
            btn.classList.add('bg-white');
        });
        
        // Activar el botón correspondiente
        const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
        if (activeButton) {
            activeButton.classList.add('active', 'bg-blue-100');
            activeButton.classList.remove('bg-white');
        }
    }

    // Event listeners para las tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const tabId = this.getAttribute('data-tab');
            showTab(tabId);
        });
    });

    // Gráfica de barras para ratings promedio
    const ctxRating = document.getElementById('ratingChart').getContext('2d');
    new Chart(ctxRating, {
        type: 'bar',
        data: {
            labels: nombres,
            datasets: [{
                label: 'Promedio de Rating',
                data: promedios,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Calificación (0-5)',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: {
                ...commonOptions.plugins,
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    callbacks: {
                        label: function(context) {
                            return `Rating: ${context.raw}/5`;
                        }
                    }
                }
            }
        }
    });

    // Gráfica de barras para cantidad de valoraciones
    const ctxCount = document.getElementById('countChart').getContext('2d');
    new Chart(ctxCount, {
        type: 'bar',
        data: {
            labels: nombres,
            datasets: [{
                label: 'Cantidad de Valoraciones',
                data: cantidades,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'Número de valoraciones',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });

    // Gráfico de barras para categorías más visitadas
    const ctxCategoriesVisited = document.getElementById('categoriesVisitedChart').getContext('2d');
    const categoriesColors = categorias.map((_, index) => colorPalette[index % colorPalette.length]);
    
    new Chart(ctxCategoriesVisited, {
        type: 'bar',
        data: {
            labels: categorias.map(c => c.name),
            datasets: [{
                label: 'Productos Vendidos',
                data: categorias.map(c => c.visits),
                backgroundColor: categoriesColors.map(c => c.background),
                borderColor: categoriesColors.map(c => c.border),
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Productos vendidos',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: {
                ...commonOptions.plugins,
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    callbacks: {
                        label: function(context) {
                            return `Productos vendidos: ${context.raw.toLocaleString()}`;
                        }
                    }
                }
            }
        }
    });

    // Gráfico de pie para distribución de visitas por categoría
    const ctxCategoriesPie = document.getElementById('categoriesPieChart').getContext('2d');
    new Chart(ctxCategoriesPie, {
        type: 'pie',
        data: {
            labels: categorias.map(c => c.name),
            datasets: [{
                data: categorias.map(c => c.visits),
                backgroundColor: categoriesColors.map(c => c.background),
                borderColor: categoriesColors.map(c => c.border),
                borderWidth: 2
            }]
        },
        options: {
            ...commonOptions,
            plugins: {
                ...commonOptions.plugins,
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.raw / total) * 100).toFixed(1);
                            return `${context.label}: ${context.raw.toLocaleString()} productos (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Gráfico de barras para productos más comprados
    const ctxSales = document.getElementById('salesProductsChart').getContext('2d');
    const salesColors = productosComprados.map((_, index) => colorPalette[index % colorPalette.length]);
    
    new Chart(ctxSales, {
        type: 'bar',
        data: {
            labels: productosComprados.map(p => p.name),
            datasets: [{
                label: 'Unidades Vendidas',
                data: productosComprados.map(p => p.sales),
                backgroundColor: salesColors.map(c => c.background),
                borderColor: salesColors.map(c => c.border),
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Unidades vendidas',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: {
                ...commonOptions.plugins,
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    callbacks: {
                        label: function(context) {
                            return `Vendidas: ${context.raw} unidades`;
                        }
                    }
                }
            }
        }
    });

    // Gráfico de barras para ingresos por producto
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: productosComprados.map(p => p.name),
            datasets: [{
                label: 'Ingresos (COP)',
                data: productosComprados.map(p => p.revenue),
                backgroundColor: salesColors.map(c => c.background),
                borderColor: salesColors.map(c => c.border),
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Ingresos (COP)',
                        font: {
                            weight: 'bold'
                        }
                    },
                    ticks: {
                        callback: function(value) {
                            return 'COP ' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: {
                ...commonOptions.plugins,
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    callbacks: {
                        label: function(context) {
                            return `Ingresos: COP ${context.raw.toLocaleString()}`;
                        }
                    }
                }
            }
        }
    });

    // Inicializar la primera tab como activa
    showTab('ratingsChart');
});
</script>
@endsection