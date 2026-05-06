import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue', // Kalau pakai Vue
        './resources/js/**/*.jsx', // Kalau pakai React
        // 👇 TAMBAHKAN BARIS INI (Wajib buat Flowbite)
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        // 👇 TAMBAHKAN PLUGIN INI (Wajib buat Flowbite)
        require('flowbite/plugin')
    ],
};