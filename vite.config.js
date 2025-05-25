import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                    'resources/css/components/index.css', 
                    'resources/js/components/components.js',
                    'resources/js/app.js',
                    'resources/css/errors.css',
                    'resources/js/components/calendar.js',
                ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
