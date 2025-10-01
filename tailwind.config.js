/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Filament/**/*.php',
        './vendor/filament/**/*.blade.php',
    ],
    
    darkMode: 'class',
    
    theme: {
        extend: {
            colors: {
                // Colores personalizados de Filament si los usas
            },
        },
    },
    
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
