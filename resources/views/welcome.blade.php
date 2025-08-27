<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control Inch - Gestión de Inspecciones Eléctricas</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts y Estilos de Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-overlay::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(1, 22, 56, 0.6); /* Azul oscuro semitransparente */
            z-index: 1;
        }
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="antialiased font-sans bg-gray-100 dark:bg-gray-900">
    {{-- Contenedor principal con Alpine.js para el header dinámico --}}
    <div x-data="{ atTop: true }" @scroll.window="atTop = (window.pageYOffset > 50) ? false : true" class="relative w-full">

        {{-- Barra de Navegación Superior --}}
        <header 
            :class="{ 'bg-blue-900 shadow-lg': !atTop, 'bg-transparent': atTop }"
            class="fixed top-0 left-0 right-0 z-30 p-4 transition-all duration-300 ease-in-out">
            <div class="container mx-auto flex justify-between items-center">
                <a href="/" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo1.png') }}" alt="Logo de Control Inch" class="h-12 transition-all duration-300">
                    <span class="text-white text-2xl font-bold">CONTROL INCH</span>
                </a>
                <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                    Iniciar Sesión
                </a>
            </div>
        </header>

        {{-- SECCIÓN 1: HÉROE (Pantalla Completa) --}}
        <section class="relative h-screen flex items-center justify-center text-center bg-cover bg-center hero-overlay" style="background-image: url('{{ asset('images/principal.jpg') }}');">
            <div class="relative z-10 p-4 text-white">
                <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-4 text-shadow">
                    Precisión y Control en Cada Inspección
                </h1>
                <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-2xl mx-auto text-shadow">
                    Digitalizamos y optimizamos el flujo de trabajo para inspecciones eléctricas, desde la planificación en oficina hasta el reporte final en campo.
                </p>
                <a href="{{ route('login') }}" class="px-8 py-4 text-lg font-bold text-white bg-yellow-500 rounded-md hover:bg-yellow-600 transition shadow-lg">
                    Acceder al Panel
                </a>
            </div>
        </section>

        {{-- SECCIÓN 2: CARACTERÍSTICAS --}}
        <section class="py-16 bg-white dark:bg-gray-800">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Una Herramienta Integral</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Todo lo que necesitas en una sola plataforma.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- Característica 1 --}}
                    <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="text-yellow-500 mb-4">
                            <svg class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">Gestión de Órdenes</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Crea y sigue el progreso de cada inspección a través de etapas claras y definidas: antes, durante y después.
                        </p>
                    </div>
                    {{-- Característica 2 --}}
                    <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="text-yellow-500 mb-4">
                            <svg class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">Evidencia en Campo</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Integra geolocalización precisa y captura fotográfica directamente desde el móvil para reportes irrefutables.
                        </p>
                    </div>
                    {{-- Característica 3 --}}
                    <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="text-yellow-500 mb-4">
                            <svg class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">Reportes Automatizados</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Genera documentos profesionales en formato Word al instante, utilizando plantillas personalizadas y los datos recopilados.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECCIÓN 4: FOOTER --}}
        <footer class="py-8 bg-gray-800 dark:bg-black text-center text-gray-400">
            <p>&copy; {{ date('Y') }} CONTROL INCH. Todos los derechos reservados.</p>
        </footer>

    </div>

    {{-- Script para el header dinámico (Alpine.js). No se necesita el del carrusel --}}
    {{-- El componente x-data se inicializa directamente en el HTML, por lo que no se necesita un script <script> aquí --}}

</body>
</html>