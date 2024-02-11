import vue from '@vitejs/plugin-vue'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/style.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
