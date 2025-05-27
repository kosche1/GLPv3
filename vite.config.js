import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import vue from '@vitejs/plugin-vue'
import path from 'path'
export default defineConfig({
    resolve: {
        alias: {
            "@mingle": path.resolve(__dirname, "vendor/ijpatricio/mingle/resources/js"),
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js", "resources/js/realtime.js", "resources/js/AiWidget/index.js", "resources/js/components/InvestSmart/index.js", "resources/js/chemistry-lab-app.js"],
            refresh: [`resources/views/**/*`],
        }),
        tailwindcss(),
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
        cors: true,
    },
});
