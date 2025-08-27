<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CONTROL INCH') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ========================================== --}}
    {{-- INICIO: AÑADIR ESTILOS DE LIVEWIRE        --}}
    {{-- ========================================== --}}
    @livewireStyles
    {{-- ========================================== --}}
    {{-- FIN: AÑADIR ESTILOS DE LIVEWIRE          --}}
    {{-- ========================================== --}}

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

</head>
<body class="font-sans antialiased">
    {{-- Contenedor principal con estado Alpine para el sidebar --}}
    {{-- Cambié tus colores de prueba bg-red/green a los originales --}}
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <!-- Encabezado Azul Noche (Fijo) -->
        <header class="fixed top-0 left-0 right-0 z-40 bg-blue-900 dark:bg-blue-950 text-white shadow-md h-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
                <div class="flex justify-between items-center h-full">
                    <!-- Izquierda: Botón Hamburguesa -->
                    <div class="flex items-center">
                         <button @click="sidebarOpen = !sidebarOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:text-white hover:bg-blue-800 focus:outline-none focus:bg-blue-800 focus:text-white transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': sidebarOpen, 'inline-flex': ! sidebarOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Centro: Logo y Nombre -->
                    <div class="flex-1 flex justify-center items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                            <x-application-logo class="block h-9 w-auto fill-current text-white" />
                            <span class="font-semibold text-lg tracking-wider">CONTROL INCH</span>
                        </a>
                    </div>
                    <!-- Derecha: Menú Usuario -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @include('layouts.partials.user-dropdown')
                    </div>
                     <div class="flex items-center sm:hidden">
                         @auth
                         @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenedor principal (Sidebar + Contenido) -->
        <div class="flex pt-16">
            <!-- Sidebar -->
            <aside class="fixed top-16 left-0 bottom-0 z-30 w-64 bg-white dark:bg-gray-800 shadow-md transform transition-transform duration-300 ease-in-out"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   @click.away="if (window.innerWidth < 640) sidebarOpen = false">
                 <div class="p-4 space-y-2 mt-4">
                    <h3 class="px-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Menú</h3>
                    <x-side-nav-link :href="route('ordenes.index')" :active="request()->routeIs('ordenes.*')"> {{ __('Órdenes') }} </x-side-nav-link>
                    <x-side-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')"> {{ __('Clientes') }} </x-side-nav-link>
                    <x-side-nav-link :href="route('inspectores.index')" :active="request()->routeIs('inspectores.*')"> {{ __('Inspectores') }} </x-side-nav-link>
                    <x-side-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')"> {{ __('Reportes') }} </x-side-nav-link>

                </div>
                {{-- ========================================================= --}}
                {{-- ========= INICIO: SECCIÓN DE ADMINISTRACIÓN ============= --}}
                {{-- ========================================================= --}}
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <div class="p-4 space-y-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="px-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Administración
                        </h3>
                        <x-side-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Usuarios') }}
                        </x-side-nav-link>
                    </div>
                @endif
                {{-- ======================================================= --}}
                {{-- =========== FIN: SECCIÓN DE ADMINISTRACIÓN ============ --}}
                {{-- ======================================================= --}}
            </aside>

             <!-- Overlay -->
            <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity duration-300 ease-in-out sm:hidden" @click="sidebarOpen = false" x-cloak></div>

            <!-- Contenido Principal -->
            <main class="flex-1 transition-all duration-300 ease-in-out overflow-y-auto"
                  :class="{ 'ml-0 sm:ml-64': sidebarOpen, 'ml-0': !sidebarOpen }">

                 {{-- Header secundario eliminado previamente --}}

                {{-- Contenedor del Yield con padding y SIN max-width --}}
                {{-- Ajustaste los paddings en tu último mensaje, los mantengo --}}
                <div class="py-2 px-6 sm:px-6 lg:px-2"> {{-- O usa py-8 px-4 sm:px-6 lg:px-8 si prefieres más padding --}}
                     @yield('content')
                </div>

            </main>
        </div> {{-- Fin flex pt-16 --}}

    </div> {{-- Fin x-data --}}

    @stack('scripts') {{-- Mantener por si otras vistas lo usan --}}

    {{-- ========================================== --}}
    {{-- INICIO: AÑADIR SCRIPTS DE LIVEWIRE        --}}
    {{-- ========================================== --}}
    @livewireScripts
    {{-- ========================================== --}}
    {{-- FIN: AÑADIR SCRIPTS DE LIVEWIRE          --}}
    {{-- ========================================== --}}
</body>
</html>