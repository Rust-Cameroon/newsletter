import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  daisyui: {
    themes: ["light", "dark", "lofi", "retro", "coffee"],
    colors: {
      customPink: '#AB5582',
    },
  },
  theme: {
    extend: {
      colors: {
        customPink: {
          300: '#D58BA6', // Lighter shade
          500: '#AB5582', // Original color
          700: '#81325E', // Darker shade
          900: '#5A1C3E', // Darkest shade
        },
        accentcolor: '#8F8012',
      },
    },
  },
  plugins: [
    daisyui,
  ],
}