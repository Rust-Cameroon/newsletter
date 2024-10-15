/** @type {import('tailwindcss').Config} */
export default {
  content: ["./src/*.{html,js,ts,tsx}"],
  daisyui: {
    themes: ["light", "dark", "cupcake"],
  },
  plugins: [
    require('daisyui'),
  ],
}

