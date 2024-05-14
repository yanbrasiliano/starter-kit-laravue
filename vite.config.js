import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar } from '@quasar/vite-plugin';
import eslintPlugin from 'vite-plugin-eslint';
import { fileURLToPath, URL } from 'url';

export default defineConfig({
  server: {
    hmr: {
      host: 'localhost',
    },
    host: '0.0.0.0',
    port: 3000,
    open: false,
  },
  resolve: {
    alias: [
      {
        find: '@',
        replacement: fileURLToPath(new URL('./resources/js', import.meta.url)),
      },
      {
        find: '@css',
        replacement: fileURLToPath(new URL('./resources/css', import.meta.url)),
      },
      {
        find: '@components',
        replacement: fileURLToPath(new URL('./resources/js/components', import.meta.url)),
      },
      {
        find: '@composables',
        replacement: fileURLToPath(
          new URL('./resources/js/composables', import.meta.url),
        ),
      },
      {
        find: '@utils',
        replacement: fileURLToPath(new URL('./resources/js/utils', import.meta.url)),
      },
      {
        find: '@routes',
        replacement: fileURLToPath(new URL('./resources/js/router', import.meta.url)),
      },
      {
        find: '@pages',
        replacement: fileURLToPath(new URL('./resources/js/pages', import.meta.url)),
      },
      {
        find: '@layouts',
        replacement: fileURLToPath(new URL('./resources/js/layouts', import.meta.url)),
      },
      {
        find: '@assets',
        replacement: fileURLToPath(new URL('./resources/js/assets', import.meta.url)),
      },
    ],
  },
  plugins: [
    eslintPlugin(),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    quasar({
      sassVariables: 'resources/css/quasar-variables.sass',
    }),
    laravel({
      input: ['resources/css/app.sass', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
});
