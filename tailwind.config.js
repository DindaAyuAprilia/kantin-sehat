import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbitePlugin from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'theme-primary': '#007022',
                'theme-secondary': '#54D17A',
                'theme-light': '#D7FFEA',
                'theme-dark': '#009022',
                'theme-surface': '#EBFFF3',  // latar konten seperti form, tabel
                'theme-white': '#FFFFFF',   // latar utama
                'theme-black': '#000000',   // teks utama
            },
        },
    },

    plugins: [forms, flowbitePlugin],
};
