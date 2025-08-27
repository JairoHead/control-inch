<x-guest-layout>
    {{-- Contenedor principal a pantalla completa --}}
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-4">
        
        {{-- Tarjeta principal con dos columnas en pantallas medianas o más grandes --}}
        <div class="w-full max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row">
            
            {{-- Columna Izquierda: Imagen (Visible en md y superior) --}}
            <div class="hidden md:block md:w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('images/principal.jpg') }}');">
                {{-- Este div estará vacío, solo mostrará la imagen de fondo --}}
            </div>

            {{-- Columna Derecha: Formulario --}}
            <div class="w-full md:w-1/2 p-8 sm:p-12">
                
                {{-- Logo y Título --}}
                <div class="flex flex-col items-center mb-6">
                    <a href="/">
                        <img src="{{ asset('images/logo2.png') }}" alt="Logo de Control Inch" class="h-16 mb-2">
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-200">
                        Bienvenido de Nuevo
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Ingresa a tu cuenta para continuar
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" value="Correo Electrónico" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" value="Contraseña" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Recuérdame</span>
                        </label>
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center text-base py-3">
                            Iniciar Sesión
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

{{-- ELIMINAMOS EL CÓDIGO DEL LAYOUT DE INVITADO --}}
{{-- Busca el archivo `resources/views/layouts/guest.blade.php` --}}
{{-- Y elimina o comenta la sección del logo de Laravel que está ahí dentro --}}
{{-- 
    <div>
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </div>
--}}