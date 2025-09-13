import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',

        // // Path standar untuk semua file Blade & JS di folder resources
        // './resources/**/*.blade.php',
        // './resources/**/*.js',
        //
        // // Path spesifik yang dibutuhkan oleh Jetstream & paginasi Laravel
        // './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        // './vendor/laravel/jetstream/**/*.blade.php',
        // './storage/framework/views/*.php',
        //
        // // Path spesifik untuk Filament (agar style Filament tidak rusak)
        // './app/Filament/**/*.php',
        // './resources/views/filament/**/*.blade.php',
        // './vendor/filament/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
