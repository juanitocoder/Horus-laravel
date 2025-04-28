@props(['type' => 'success', 'message' => ''])

@php
    $icons = [
        'success' => [
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>',
            'border' => 'border-green-600',
            'iconBg' => 'bg-green-600',
            'titleColor' => 'text-green-800',
            'bg' => 'bg-green-100',
            'title' => 'Éxito'
        ],
        'error' => [
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>',
            'border' => 'border-red-600',
            'iconBg' => 'bg-red-600',
            'titleColor' => 'text-red-800',
            'bg' => 'bg-red-100',
            'title' => 'Error'
        ],
        'warning' => [
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" /></svg>',
            'border' => 'border-yellow-600',
            'iconBg' => 'bg-yellow-600',
            'titleColor' => 'text-yellow-800',
            'bg' => 'bg-yellow-100',
            'title' => 'Advertencia'
        ],
        'info' => [
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" /></svg>',
            'border' => 'border-blue-600',
            'iconBg' => 'bg-blue-600',
            'titleColor' => 'text-blue-800',
            'bg' => 'bg-blue-100',
            'title' => 'Información'
        ],
    ];

    $icon = $icons[$type] ?? $icons['success'];
@endphp

<div class="fixed right-4 z-50 w-full max-w-sm sm:right-4 sm:w-80 transition-all duration-500 ease-out transform opacity-0 translate-y-5" id="toastAlert" style="top: 70px;">
    <div class="flex items-center {{ $icon['bg'] }} border-l-4 {{ $icon['border'] }} p-4 rounded-lg shadow-lg text-black space-x-4 font-cinzel">
        <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $icon['iconBg'] }}">
            {!! $icon['svg'] !!}
        </div>
        <div>
            <p class="font-bold {{ $icon['titleColor'] }}">{{ $icon['title'] }}</p>
            <p class="text-sm mt-1 {{ $icon['titleColor'] }}">{{ $message }}</p>
        </div>
    </div>
</div>

<script>
    // Animación de entrada
    setTimeout(() => {
        const alert = document.getElementById('toastAlert');
        if (alert) {
            alert.classList.remove('opacity-0', 'translate-y-5');
            alert.classList.add('opacity-100', 'translate-y-0');
        }
    }, 100);

    // Animación de salida
    setTimeout(() => {
        const alert = document.getElementById('toastAlert');
        if (alert) {
            alert.classList.remove('opacity-100', 'translate-y-0');
            alert.classList.add('opacity-0', 'translate-y-5');
            setTimeout(() => alert.remove(), 700);
        }
    }, 4000);
</script>