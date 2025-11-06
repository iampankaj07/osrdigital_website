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
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['react', 'react-dom'],
                    router: ['react-router-dom'],
                    icons: ['@fortawesome/react-fontawesome', '@fortawesome/free-solid-svg-icons', '@fortawesome/free-brands-svg-icons']
                }
            }
        },
        chunkSizeWarningLimit: 1000,
        minify: 'esbuild',
        // Ensure assets are built for production
        assetsDir: 'assets',
        sourcemap: false,
        // Optimize output
        cssCodeSplit: true,
        // Report compressed size
        reportCompressedSize: false,
    },
    server: {
        middlewareMode: false,
        // Use IPv4 instead of IPv6 to avoid CSP issues
        host: '127.0.0.1',
        // Support both HTTP and HTTPS
        https: process.env.NODE_ENV === 'production' ? false : undefined,
    },
    // Base URL for production builds
    base: process.env.NODE_ENV === 'production' ? '/' : '/',
});
