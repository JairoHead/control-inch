@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-2 py-2 text-sm font-medium text-white bg-blue-600 dark:bg-blue-700 rounded-md group transition duration-150 ease-in-out'
            : 'flex items-center px-2 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md group transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{-- Puedes añadir un slot para íconos aquí si quieres --}}
    {{-- <span class="mr-3">Icono</span> --}}
    {{ $slot }}
</a>