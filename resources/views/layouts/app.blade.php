<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CONTROL INCH') }}</title>
    <!-- Favicon logo-->
    <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}">
    
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Fonts - CORREGIDO para evitar errores CORS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
</head>
<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="min-h-screen bg-gray-100 dark:bg-gray-900">

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
                        <img src="{{ asset('images/logo1.png') }}" alt="Logo de Control Inch" class="block h-9 w-auto">
                            <span class="font-semibold text-lg tracking-wider">CONTROL INCH</span>
                        </a>
                    </div>
                    <!-- Derecha: Menú Usuario -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @include('layouts.partials.user-dropdown')
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenedor principal (Sidebar + Contenido) -->
        <div class="flex pt-16">
            <!-- Sidebar -->
            {{-- CAMBIO CLAVE 1: Añadimos @click.away para el cierre --}}
            <aside 
                x-show="sidebarOpen" 
                @click.away="sidebarOpen = false"
                x-transition:enter="transition ease-in-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="fixed top-0 left-0 h-full z-30 w-64 bg-white dark:bg-gray-800 shadow-md"
                x-cloak
            >
                <div class="pt-16 h-full overflow-y-auto"> {{-- Añadido pt-16 para que el contenido no quede debajo del header --}}
                    <div class="p-4 space-y-2 mt-4">
                        <h3 class="px-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Menú</h3>
                        <x-side-nav-link :href="route('ordenes.index')" :active="request()->routeIs('ordenes.*')"> {{ __('Órdenes') }} </x-side-nav-link>
                        <x-side-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')"> {{ __('Clientes') }} </x-side-nav-link>
                        <x-side-nav-link :href="route('inspectores.index')" :active="request()->routeIs('inspectores.*')"> {{ __('Inspectores') }} </x-side-nav-link>
                        <x-side-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')"> {{ __('Reportes') }} </x-side-nav-link>
                    </div>

                    <!-- Administración -->
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <div class="p-4 space-y-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="px-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Administración</h3>
                            <x-side-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">{{ __('Usuarios') }}</x-side-nav-link>
                        </div>
                    @endif
                </div>
            </aside>

            <!-- Contenido Principal -->
            {{-- CAMBIO CLAVE 2: La transición ahora se aplica aquí --}}
            <main class="flex-1 w-full transition-all duration-300 ease-in-out">
                <div class="py-2 px-6 sm:px-6 lg:px-2">
                     @yield('content')
                </div>
            </main>
        </div>

    </div>

    @stack('scripts')
    @livewireScripts
</body>
</html>