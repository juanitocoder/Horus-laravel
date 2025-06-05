@extends('layouts.app')

@section('title', 'Resultado del Pago')

@section('pago')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div id="payment-result">
            <!-- Estado de carga inicial -->
            <div id="loading-state" class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Verificando tu pago...</h2>
                <p class="text-gray-600">Por favor espera mientras confirmamos tu transacción.</p>
                <div class="mt-6">
                    <div class="flex items-center justify-center space-x-2">
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes bounceIn {
        0% {
            transform: scale(0.3);
            opacity: 0;
        }
        50% {
            transform: scale(1.05);
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    .slide-in {
        animation: slideIn 0.5s ease-out;
    }
    
    .bounce-in {
        animation: bounceIn 0.6s ease-out;
    }
    
    .success-checkmark {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #10b981;
        stroke-miterlimit: 10;
        margin: 0 auto 20px auto;
        box-shadow: inset 0px 0px 0px #10b981;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }
    
    .success-checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #10b981;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    
    .success-checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }
    
    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }
    
    @keyframes scale {
        0%, 100% {
            transform: none;
        }
        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }
    
    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 30px #10b981;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const refPayco = '{{ $ref_payco }}';
    const resultDiv = document.getElementById('payment-result');
    
    // Función para verificar el estado del pago
    function checkPaymentStatus() {
        fetch('/check-payment-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                ref_payco: refPayco
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.payment_status === 'Aceptada') {
                    clearCart();
                } else if (data.payment_status === 'Rechazada') {
                    showError('Tu pago fue rechazado', 'Por favor intenta nuevamente o contacta a soporte.');
                } else if (data.payment_status === 'Pendiente') {
                    showPending('Tu pago está pendiente', 'Te notificaremos cuando se confirme el pago.');
                } else {
                    showError('Estado desconocido', 'Estado de pago: ' + data.payment_status);
                }
            } else {
                showError('Error de verificación', 'No se pudo verificar el estado del pago.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error de conexión', 'Por favor verifica tu conexión e intenta nuevamente.');
        });
    }

    // Función para limpiar el carrito después del pago exitoso
    function clearCart() {
        fetch('/clear-cart-after-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                ref_payco: refPayco
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess('¡Pago exitoso!', 'Tu pedido ha sido procesado correctamente y tu carrito ha sido limpiado.');
                updateCartCounter();
                
                setTimeout(() => {
                    window.location.href = '/home';
                }, 4000);
            } else {
                showSuccess('¡Pago exitoso!', 'Tu pedido ha sido procesado correctamente.');
                console.warn('No se pudo limpiar el carrito automáticamente');
            }
        })
        .catch(error => {
            console.error('Error al limpiar carrito:', error);
            showSuccess('¡Pago exitoso!', 'Tu pedido ha sido procesado correctamente.');
        });
    }

    // Función para mostrar éxito
    function showSuccess(title, message) {
        resultDiv.innerHTML = `
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center slide-in">
                <svg class="success-checkmark bounce-in" viewBox="0 0 52 52">
                    <circle class="success-checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="success-checkmark__check" fill="none" d="m14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
                <h2 class="text-3xl font-bold text-green-600 mb-3">${title}</h2>
                <p class="text-gray-700 mb-6 text-lg">${message}</p>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-green-800 text-sm">✓ Gracias por tu compra</p>
                    <p class="text-green-800 text-sm">✓ Recibirás un email de confirmación</p>
                    <p class="text-green-800 text-sm">✓ Redirigiendo en unos segundos...</p>
                </div>
                <div class="flex justify-center space-x-4">
                    <a href="/home" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Ir al inicio
                    </a>
                </div>
            </div>
        `;
    }

    // Función para mostrar error
    function showError(title, message) {
        resultDiv.innerHTML = `
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center slide-in">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6 bounce-in">
                    <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-red-600 mb-3">${title}</h2>
                <p class="text-gray-700 mb-6 text-lg">${message}</p>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-red-800 text-sm">💡 Verifica que tu tarjeta tenga fondos suficientes</p>
                    <p class="text-red-800 text-sm">💡 Contacta a tu banco si el problema persiste</p>
                </div>
                <div class="flex justify-center space-x-4">
                    <a href="/carrito" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8.5"></path>
                        </svg>
                        Volver al carrito
                    </a>
                    <a href="/home" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                        Ir al inicio
                    </a>
                </div>
            </div>
        `;
    }

    // Función para mostrar pendiente
    function showPending(title, message) {
        resultDiv.innerHTML = `
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center slide-in">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-yellow-100 mb-6 bounce-in">
                    <svg class="h-10 w-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-yellow-600 mb-3">${title}</h2>
                <p class="text-gray-700 mb-6 text-lg">${message}</p>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <p class="text-yellow-800 text-sm">⏳ El procesamiento puede tomar unos minutos</p>
                    <p class="text-yellow-800 text-sm">📧 Te enviaremos un email cuando se confirme</p>
                </div>
                <div class="flex justify-center space-x-4">
                    <a href="/home" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                        Ir al inicio
                    </a>
                </div>
            </div>
        `;
    }

    // Función para actualizar contador del carrito
    function updateCartCounter() {
        const cartCounter = document.querySelector('.cart-counter');
        if (cartCounter) {
            cartCounter.textContent = '0';
        }
        window.dispatchEvent(new CustomEvent('cartCleared'));
    }

    // Iniciar verificación del pago
    checkPaymentStatus();
});
</script>
@endsection