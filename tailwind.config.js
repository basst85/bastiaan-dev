import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
         './storage/framework/views/*.php',
         './resources/**/*.blade.php',
         './resources/**/*.js',
         './resources/**/*.vue',
         "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Geist Sans', ...defaultTheme.fontFamily.sans],
                mono: ['Geist Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                // Single desaturated accent (warm terracotta/amber) — replaces the
                // teal/indigo gradient + scattered blue/red/yellow UI accents.
                accent: {
                    50: '#fbf3ec',
                    100: '#f5e2d0',
                    200: '#eac7a5',
                    300: '#dea877',
                    400: '#d18f5c',
                    500: '#c17a45',
                    600: '#a2632f',
                    700: '#7e4d26',
                    800: '#5c3a1f',
                    900: '#402919',
                    950: '#241609',
                },
            },
            boxShadow: {
                // Tinted shadow instead of generic black, matching the warm dark background.
                card: '0 8px 30px -12px rgb(28 25 23 / 0.6)',
                'accent-glow': '0 0 0 1px rgb(193 122 69 / 0.15), 0 8px 30px -8px rgb(193 122 69 / 0.25)',
            },
        },
    },
    variants: {
        fill: ['hover', 'focus']
    },
    daisyui: {
        themes: [
            {
                bastiaandev: {
                    primary: '#c17a45',
                    'primary-content': '#241609',
                    secondary: '#8a8078',
                    'secondary-content': '#1c1917',
                    accent: '#c17a45',
                    'accent-content': '#241609',
                    neutral: '#292524',
                    'neutral-content': '#e7e5e4',
                    'base-100': '#1c1917',
                    'base-200': '#221f1d',
                    'base-300': '#3a3532',
                    'base-content': '#e7e5e4',
                    info: '#7d9ab0',
                    success: '#7a9b76',
                    warning: '#c9a227',
                    error: '#c1574a',
                },
            },
        ],
        darkTheme: 'bastiaandev',
    },
    plugins: [
        require("daisyui"),
        require("tailwindcss-motion")
    ],
};
