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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                linear: {
                    primary: '#5e6ad2',
                    'primary-hover': '#828fff',
                    'primary-focus': '#5e69d1',
                    ink: '#f7f8f8',
                    'ink-muted': '#d0d6e0',
                    'ink-subtle': '#8a8f98',
                    'ink-tertiary': '#62666d',
                    canvas: '#010102',
                    'surface-1': '#0f1011',
                    'surface-2': '#141516',
                    'surface-3': '#18191a',
                    'surface-4': '#191a1b',
                    hairline: '#23252a',
                    'hairline-strong': '#34343a',
                    'hairline-tertiary': '#3e3e44',
                }
            }
        },
    },

    plugins: [forms, typography],
};
