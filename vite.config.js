import { defineConfig } from "vite";
import { resolve } from "path";

export default defineConfig({
  css: {
    preprocessorOptions: {
      scss: {
        api: "modern-compiler",
      },
    },
  },
  build: {
    outDir: "public",
    emptyOutDir: false,
    rollupOptions: {
      input: resolve(__dirname, "src/main.scss"),
      output: {
        assetFileNames: "main.css",
      },
    },
  },
});
