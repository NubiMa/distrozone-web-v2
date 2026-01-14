import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // DistroZone Design System
                primary: '#0F0F0F',           // Base Black
                accent: '#FF6B00',            // Street Orange
                'bg-secondary': '#F5F5F5',   // Background Secondary
                'text-secondary': '#9CA3AF', // Text Secondary
                border: '#E5E7EB',            // Border / Divider
                
                // Extended grays for fine control
                gray: {
                    50: '#F5F5F5',
                    100: '#E5E7EB',
                    400: '#9CA3AF',
                    600: '#6B7280',
                    800: '#111111',
                    900: '#0F0F0F',
                },
            },
            spacing: {
                // Custom spacing for streetwear aesthetic
                'street': '3rem',    // Large white space
                'section': '4rem',   // Section spacing
            },
            boxShadow: {
                // Subtle shadows for depth
                'sm': '0 1px 2px rgba(15, 15, 15, 0.04)',
                'md': '0 2px 8px rgba(15, 15, 15, 0.06)',
                'card': '0 2px 4px rgba(15, 15, 15, 0.08)',
            },
            borderRadius: {
                // Slightly rounded for modern feel
                'DEFAULT': '0.25rem',
                'lg': '0.5rem',
                'full': '9999px',
            },
            transitionDuration: {
                'fast': '150ms',
                'base': '250ms',
            },
        },
    },
    plugins: [],
};