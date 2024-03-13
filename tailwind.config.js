import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['RobotoCondensed', 'sans-serif'],
                serif: ['Mulish', 'serif'],
                display: ['Mulish', 'serif']
            },
        },
    },

    plugins: [
        require('flowbite/plugin'),
        forms,
    ],
};
