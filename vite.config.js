import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: 'localhost',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
            protocol: 'ws',
            clientPort: 5173,
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/superadmin.js',
                'resources/js/surveyor/form.js',
                'resources/js/surveyor/offline-db.js',
                'resources/js/surveyor/location-prefetch.js',
                'resources/js/surveyor/surveyor.js',
            ],
            refresh: true,
        }),
    ],
});
