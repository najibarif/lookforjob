import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
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
                    primary: '#10b981',
                    'primary-hover': '#34d399',
                    'primary-focus': '#059669',
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
            },
            animation: {
                'fade-up': 'fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'float': 'float 6s ease-in-out infinite',
                'pulse-glow': 'pulseGlow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                fadeUp: {
                    '0%': { opacity: 0, transform: 'translateY(20px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                pulseGlow: {
                    '0%, 100%': { opacity: 1 },
                    '50%': { opacity: .5 },
                }
            }
        },
    },

    plugins: [forms, typography],
};
