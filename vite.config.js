import {defineConfig} from 'vite'
import {viteStaticCopy} from 'vite-plugin-static-copy'
import vue from '@vitejs/plugin-vue'
import react from '@vitejs/plugin-react'
import liveReload from 'vite-plugin-live-reload';

import path from "path";
import AutoImport from 'unplugin-auto-import/vite'

import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'

//Important: Key must be output filepath without extension, and value will be the file source
const inputs = {
    'admin/app': 'resources/admin/app.js',
    'admin/admin': 'resources/scss/admin/admin.scss'
}

export default defineConfig({
    plugins:
        [
            vue(),
            react(),
            liveReload([
                `${__dirname}/**/*\.php`
            ]),
            viteStaticCopy({
                targets: [
                    {src: 'resources/images', dest: ''},
                    // {src: 'resources/libs', dest: ''}
                ]
            }),
            AutoImport({
                resolvers: [ElementPlusResolver()],
            }),
            Components({
                resolvers: [ElementPlusResolver()],
                directives: false
            }),
        ],

    build: {
        manifest: true,
        outDir: 'assets',
        assetsDir: '.',
        // publicDir: 'assets',
        //root: '/',
        emptyOutDir: true, // delete the contents of the output directory before each build

        // https://rollupjs.org/guide/en/#big-list-of-options
        rollupOptions: {
            input: inputs,
            output: {
                chunkFileNames: '[name].js',
                entryFileNames: '[name].js'
            },
        },
    },

    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, 'resources/admin'),
        },
    },

    server: {
        port: 9999,
        strictPort: true,
        hmr: {
            port: 9999,
            host: 'localhost',
            protocol: 'ws',
        }
    },
    esbuild: {
        loader: "jsx",
    },
})
