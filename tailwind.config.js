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
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'brutal': '4px 4px 0px 0px rgba(0,0,0,1)',
                'brutal-lg': '8px 8px 0px 0px rgba(0,0,0,1)',
            },
            colors: {
                brutal: {
                    yellow: '#F4E869',
                    pink: '#FF74B1',
                    blue: '#4D96FF',
                    green: '#54BAB9',
                    bg: '#FFF8E1'
                }
            }
        },
    },

    plugins: [forms, typography],
};
