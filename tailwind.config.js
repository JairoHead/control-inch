import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',

         // --- AÑADE ESTAS LÍNEAS ---
         "./app/Livewire/**/*.php", // Para clases de componentes Livewire (si usas atributos PHP 8)
         "./resources/views/livewire/**/*.blade.php", // ¡IMPORTANTE! Para vistas Livewire
         "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php", // Para paginación Laravel
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
