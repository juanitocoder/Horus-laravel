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
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-5xl mx-auto mb-12">
            <h2 class="text-2xl font-bold text-center mb-6">Análisis Visual de Valoraciones</h2>
            
            <!-- Tabs para seleccionar diferentes visualizaciones -->
            <div class="mb-6 flex justify-center">
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <button type="button" class="tab-button active px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 border border-blue-200 rounded-l-lg hover:bg-blue-200" data-tab="barCharts">
                        Gráficos de Barras
                    </button>
                    <button type="button" class="tab-button px-4 py-2 text-sm font-medium text-blue-700 bg-white border border-blue-200 hover:bg-blue-100" data-tab="radarChart">
                        Gráfico Radar
                    </button>
                    <button type="button" class="tab-button px-4 py-2 text-sm font-medium text-blue-700 bg-white border border-blue-200 rounded-r-lg hover:bg-blue-100" data-tab="polarChart">
                        Gráfico Polar
                    </button>
                </div>
            </div>
            
            <!-- Contenedor de gráficos -->
            <div class="tab-content" id="barCharts" style="display: block;">
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
            
            <div class="tab-content" id="radarChart" style="display: none;">
                <div class="flex justify-center">
                    <div class="w-full max-w-2xl">
                        <h3 class="text-lg font-semibold mb-3 text-center">Comparación de Productos</h3>
                        <div class="relative h-96 w-full">
                            <canvas id="productRadarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tab-content" id="polarChart" style="display: none;">
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div class="md:w-1/2">
                        <h3 class="text-lg font-semibold mb-3 text-center">Distribución de Ratings</h3>
                        <div class="relative h-80 w-full">
                            <canvas id="ratingPolarChart"></canvas>
                        </div>
                    </div>
                    <div class="md:w-1/2">
                        <h3 class="text-lg font-semibold mb-3 text-center">Distribución de Valoraciones</h3>
                        <div class="relative h-80 w-full">
                            <canvas id="countPolarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-white text-lg">No hay productos con valoraciones aún.</p>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Paleta de colores predefinida (más armoniosa)
    const colorPalette = [
        { background: 'rgba(54, 162, 235, 0.7)', border: 'rgba(54, 162, 235, 1)' },
        { background: 'rgba(255, 99, 132, 0.7)', border: 'rgba(255, 99, 132, 1)' },
        { background: 'rgba(75, 192, 192, 0.7)', border: 'rgba(75, 192, 192, 1)' },
        { background: 'rgba(255, 159, 64, 0.7)', border: 'rgba(255, 159, 64, 1)' },
        { background: 'rgba(153, 102, 255, 0.7)', border: 'rgba(153, 102, 255, 1)' },
        { background: 'rgba(255, 205, 86, 0.7)', border: 'rgba(255, 205, 86, 1)' },
        { background: 'rgba(201, 203, 207, 0.7)', border: 'rgba(201, 203, 207, 1)' }
    ];

    // Datos de los productos
    const productos = @json($productos);
    const nombres = productos.map(p => p.name);
    const promedios = productos.map(p => parseFloat(p.ratings_avg_rating).toFixed(2));
    const cantidades = productos.map(p => p.ratings_count);

    // Asignar colores a productos
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

    // Gráfico Radar
    const ctxRadar = document.getElementById('productRadarChart').getContext('2d');
    new Chart(ctxRadar, {
        type: 'radar',
        data: {
            labels: ["Valoración", "Popularidad", "Precio Relativo"],
            datasets: productos.map((producto, index) => {
                // Normalizamos los datos para el radar
                const maxPrice = Math.max(...productos.map(p => p.price));
                const maxRating = 5; 
                const maxReviews = Math.max(...cantidades);
                
                // Calculamos valores normalizados en escala 0-100
                const ratingNorm = (producto.ratings_avg_rating / maxRating) * 100;
                const popularityNorm = (producto.ratings_count / maxReviews) * 100;
                // Invertimos el precio para que menos precio = mejor valor
                const priceNorm = 100 - ((producto.price / maxPrice) * 100);
                
                return {
                    label: producto.name,
                    data: [ratingNorm, popularityNorm, priceNorm],
                    backgroundColor: colorPalette[index % colorPalette.length].background,
                    borderColor: colorPalette[index % colorPalette.length].border,
                    borderWidth: 1,
                    pointBackgroundColor: colorPalette[index % colorPalette.length].border,
                    pointRadius: 4
                };
            })
        },
        options: {
            ...commonOptions,
            scales: {
                r: {
                    angleLines: {
                        display: true
                    },
                    suggestedMin: 0,
                    suggestedMax: 100,
                    ticks: {
                        display: false
                    }
                }
            },
            plugins: {
                ...commonOptions.plugins,
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    callbacks: {
                        label: function(context) {
                            const labels = ["Rating", "Popularidad", "Precio-Calidad"];
                            const dataIndex = context.dataIndex;
                            const producto = productos[context.datasetIndex];
                            
                            if (dataIndex === 0) {
                                return `${context.dataset.label}: ${producto.ratings_avg_rating}/5`;
                            } else if (dataIndex === 1) {
                                return `${context.dataset.label}: ${producto.ratings_count} valoraciones`;
                            } else if (dataIndex === 2) {
                                return `${context.dataset.label}: COP ${producto.price.toLocaleString()}`;
                            }
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });

    // Gráfico Polar de Ratings
    const ctxPolarRating = document.getElementById('ratingPolarChart').getContext('2d');
    new Chart(ctxPolarRating, {
        type: 'polarArea',
        data: {
            labels: nombres,
            datasets: [{
                label: 'Promedio de Rating',
                data: promedios,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                r: {
                    ticks: {
                        backdropColor: 'rgba(255, 255, 255, 0.8)'
                    }
                }
            }
        }
    });

    // Gráfico Polar de Conteo
    const ctxPolarCount = document.getElementById('countPolarChart').getContext('2d');
    new Chart(ctxPolarCount, {
        type: 'polarArea',
        data: {
            labels: nombres,
            datasets: [{
                label: 'Cantidad de Valoraciones',
                data: cantidades,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                r: {
                    ticks: {
                        backdropColor: 'rgba(255, 255, 255, 0.8)'
                    }
                }
            }
        }
    });

    // Funcionalidad para las tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            // Ocultar todos los contenidos de tabs
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });
            
            // Desactivar todos los botones
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('bg-blue-100');
                btn.classList.add('bg-white');
            });
            
            // Mostrar el contenido seleccionado
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).style.display = 'block';
            
            // Activar el botón seleccionado
            this.classList.add('active');
            this.classList.add('bg-blue-100');
            this.classList.remove('bg-white');
        });
    });
});
</script>
@endsection