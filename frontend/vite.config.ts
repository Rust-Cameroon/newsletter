import { defineConfig } from "vite";
import { createProductionServerPlugin } from "vite-create-production-server-plugin";

export default defineConfig({
  base: "/",
  build: {
    outDir: "dist",
  },
  plugins: [
    createProductionServerPlugin({
      port: 3000, // Optional, default is 8080
      entryPoint: "index.html", // Optional, default is "index.html"
      buildDirectory: "dist", // Optional, default is "dist"
    }),
  ],
});