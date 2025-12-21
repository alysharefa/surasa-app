import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Spline Sans', ...defaultTheme.fontFamily.sans],
                serif: ['DM Serif Display', ...defaultTheme.fontFamily.serif],
                display: ['Spline Sans', "sans-serif"],
            },
            colors: {
                "primary": "#FFC107",
                "primary-dark": "#FFA000",
                "background-light": "#f8f8f5",
                "background-dark": "#23220f",
                "surface-light": "#ffffff",
                "surface-dark": "#2c2c1f",
                "text-main-light": "#1c1c0d",
                "text-main-dark": "#fcfcf8",
                "text-sec-light": "#4a4a38",
                "text-sec-dark": "#c2c2b0",
                "border-light": "#e9e8ce",
                "border-dark": "#3e3e2a",
            },
            borderRadius: {
                "DEFAULT": "0.5rem",
                "md": "0.75rem",
                "lg": "1rem",
                "xl": "1.5rem",
                "2xl": "2rem",
                "3xl": "3rem",
                "full": "9999px"
            },
        },
    },
    plugins: [forms],
};