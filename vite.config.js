import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import { defineConfig } from 'vite';

export default defineConfig({
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
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],

    server: {
        host: '127.0.0.1',
        port: 5173,

        hmr: {
            host: '127.0.0.1',
            protocol: 'ws',
        },

        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});