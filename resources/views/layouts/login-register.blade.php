<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Sena-Laravel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            /* Fondo más sutil y elegante para joyería */
            background: linear-gradient(135deg, 
                #0f172a 0%, 
                #1e293b 30%, 
                #374151 60%, 
                #1f2937 100%
            );
            position: relative;
            overflow-x: hidden;
        }

        /* Pulseras y anillos flotantes */
        .bracelet {
            position: absolute;
            border: 2px solid;
            border-radius: 50%;
            animation: rotate 30s infinite linear;
            opacity: 0.15;
        }

        .bracelet-gold {
            border-color: #d4af37;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }

        .bracelet-silver {
            border-color: #c0c0c0;
            box-shadow: 0 0 20px rgba(192, 192, 192, 0.3);
        }

        .bracelet-rose {
            border-color: #e8b4b8;
            box-shadow: 0 0 20px rgba(232, 180, 184, 0.3);
        }

        .bracelet1 { 
            width: 120px; height: 120px; 
            top: 15%; left: 8%; 
            animation-delay: -5s; 
        }
        .bracelet2 { 
            width: 80px; height: 80px; 
            top: 25%; right: 12%; 
            animation-delay: -15s; 
        }
        .bracelet3 { 
            width: 100px; height: 100px; 
            bottom: 25%; left: 15%; 
            animation-delay: -25s; 
        }
        .bracelet4 { 
            width: 60px; height: 60px; 
            bottom: 35%; right: 20%; 
            animation-delay: -10s; 
        }
        .bracelet5 { 
            width: 140px; height: 140px; 
            top: 60%; right: 8%; 
            animation-delay: -20s; 
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Gemas y diamantes */
        .gem {
            position: absolute;
            width: 8px;
            height: 8px;
            background: linear-gradient(45deg, transparent, #fff, transparent);
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            animation: sparkle 4s infinite ease-in-out;
        }

        .gem-diamond { 
            background: linear-gradient(45deg, transparent, #e5e7eb, transparent);
            filter: drop-shadow(0 0 3px rgba(229, 231, 235, 0.8));
        }
        .gem-ruby { 
            background: linear-gradient(45deg, transparent, #dc2626, transparent);
            filter: drop-shadow(0 0 3px rgba(220, 38, 38, 0.8));
        }
        .gem-emerald { 
            background: linear-gradient(45deg, transparent, #059669, transparent);
            filter: drop-shadow(0 0 3px rgba(5, 150, 105, 0.8));
        }
        .gem-sapphire { 
            background: linear-gradient(45deg, transparent, #2563eb, transparent);
            filter: drop-shadow(0 0 3px rgba(37, 99, 235, 0.8));
        }

        .gem1 { top: 20%; left: 25%; animation-delay: -1s; }
        .gem2 { top: 40%; right: 30%; animation-delay: -2.5s; }
        .gem3 { bottom: 45%; left: 35%; animation-delay: -0.8s; }
        .gem4 { top: 70%; right: 25%; animation-delay: -1.8s; }
        .gem5 { bottom: 30%; right: 40%; animation-delay: -3s; }
        .gem6 { top: 50%; left: 60%; animation-delay: -1.2s; }
        .gem7 { top: 80%; left: 30%; animation-delay: -2.2s; }
        .gem8 { bottom: 60%; right: 50%; animation-delay: -0.5s; }

        @keyframes sparkle {
            0%, 100% { opacity: 0; transform: scale(0) rotate(0deg); }
            50% { opacity: 1; transform: scale(1) rotate(180deg); }
        }

        /* Cadenas curvas decorativas */
        .chain {
            position: absolute;
            width: 200px;
            height: 2px;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(212, 175, 55, 0.3), 
                rgba(192, 192, 192, 0.3), 
                rgba(232, 180, 184, 0.3), 
                transparent
            );
            border-radius: 1px;
            animation: sway 20s infinite ease-in-out;
        }

        .chain1 {
            top: 30%;
            left: -50px;
            transform: rotate(25deg);
            animation-delay: -3s;
        }

        .chain2 {
            bottom: 40%;
            right: -50px;
            transform: rotate(-25deg);
            animation-delay: -8s;
        }

        .chain3 {
            top: 60%;
            left: 20%;
            transform: rotate(45deg);
            animation-delay: -12s;
        }

        @keyframes sway {
            0%, 100% { transform: rotate(25deg) translateY(0px); }
            50% { transform: rotate(35deg) translateY(-10px); }
        }

        /* Patrones sutiles de joyería */
        .jewelry-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(212, 175, 55, 0.03) 2px, transparent 2px),
                radial-gradient(circle at 75% 75%, rgba(192, 192, 192, 0.03) 2px, transparent 2px),
                radial-gradient(circle at 50% 50%, rgba(232, 180, 184, 0.03) 2px, transparent 2px);
            background-size: 60px 60px, 80px 80px, 100px 100px;
            pointer-events: none;
            z-index: 1;
            animation: patternMove 40s linear infinite;
        }

        @keyframes patternMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(30px, 30px); }
        }

        /* Contenedor principal */
        .main-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Efecto de resplandor elegante para formularios */
        .form-wrapper {
            position: relative;
        }

        .form-wrapper::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, 
                rgba(212, 175, 55, 0.2), 
                rgba(192, 192, 192, 0.2), 
                rgba(232, 180, 184, 0.2)
            );
            border-radius: 14px;
            z-index: -1;
            animation: elegantGlow 3s ease-in-out infinite alternate;
        }

        @keyframes elegantGlow {
            from { opacity: 0.3; }
            to { opacity: 0.7; }
        }

        /* Texto decorativo sutil */
        .brand-text {
            position: absolute;
            font-size: 120px;
            font-weight: 100;
            color: rgba(255, 255, 255, 0.02);
            pointer-events: none;
            user-select: none;
            z-index: 2;
        }

        .brand-text-1 {
            top: 10%;
            left: 5%;
            transform: rotate(-15deg);
        }

        .brand-text-2 {
            bottom: 10%;
            right: 5%;
            transform: rotate(15deg);
        }
    </style>
</head>
<body class="text-white">
    
    <!-- Patrón de joyería de fondo -->
    <div class="jewelry-pattern"></div>
    
    <!-- Texto de marca sutil -->
    <div class="brand-text brand-text-1">PuULSERAS</div>
    <div class="brand-text brand-text-2">Horus</div>
    
    <!-- Pulseras flotantes -->
    <div class="bracelet bracelet1 bracelet-gold"></div>
    <div class="bracelet bracelet2 bracelet-silver"></div>
    <div class="bracelet bracelet3 bracelet-rose"></div>
    <div class="bracelet bracelet4 bracelet-gold"></div>
    <div class="bracelet bracelet5 bracelet-silver"></div>
    
    <!-- Gemas brillantes -->
    <div class="gem gem1 gem-diamond"></div>
    <div class="gem gem2 gem-ruby"></div>
    <div class="gem gem3 gem-emerald"></div>
    <div class="gem gem4 gem-sapphire"></div>
    <div class="gem gem5 gem-diamond"></div>
    <div class="gem gem6 gem-ruby"></div>
    <div class="gem gem7 gem-emerald"></div>
    <div class="gem gem8 gem-sapphire"></div>
    
    <!-- Cadenas decorativas -->
    <div class="chain chain1"></div>
    <div class="chain chain2"></div>
    <div class="chain chain3"></div>

    <!-- Contenedor principal -->
    <div class="main-container">
        <div class="form-wrapper">
            @yield('login')
            @yield('register')
            @yield('olvido')
        </div>
    </div>

    

    
<script src="{{ asset('js/alerts/toast.js') }}" type="module"></script>
 @include('components.loader')

    @yield('content')

    <!-- Scripts -->
    <script>
        function showLoader() {
            document.getElementById('loader').classList.remove('hidden');
        }

        function hideLoader() {
            document.getElementById('loader').classList.add('hidden');
        }
    </script>
</body>
</html>