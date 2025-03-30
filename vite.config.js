import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import legacy from '@vitejs/plugin-legacy';
import path from 'node:path';

export default defineConfig({
    plugins: [
        legacy({
            targets: ['defaults', 'not IE 11', 'last 5 versions', 'Firefox ESR', 'not dead'],
            additionalLegacyPolyfills: ['regenerator-runtime/runtime'],
        }),
        laravel({
            input: [
                'resources/sass/app.scss', 'resources/js/app.js',
            ],
            output: ['build'],
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
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, 'resources'),
            '~': path.resolve(__dirname, 'resources/js'),
        },
    },
});
