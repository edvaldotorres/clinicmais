import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: '0.0.0.0', // Permite que o Vite seja acessível externamente no Docker
        port: 5173, // Porta do Vite
        hmr: {
            host: 'localhost', // Configura o HMR para funcionar com localhost
            protocol: 'ws', // Utiliza WebSockets para o HMR
        },
    },
});
