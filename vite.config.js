import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/skeleton.css',
                'resources/js/app.jsx',
                'resources/js/skeleton-loader.js'
            ],
            refresh: true,
        }),
        react({
            jsxRuntime: 'automatic',
            include: "**/*.{jsx,tsx}",
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        },
        proxy: {
            '/api': {
                target: 'http://localhost:8003',
                changeOrigin: true,
                secure: false,
            },
        },
    },
});
