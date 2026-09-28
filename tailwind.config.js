/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.html"], // Pastikan ini mengarah ke file HTML Anda
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        serif: ['Playfair Display', 'serif'],
      },
      colors: {
        purple: {
          950: '#1a0b2e',
          900: '#2b144a',
          800: '#3a1d60',
        },
        gold: {
          300: '#fbe29f',
          400: '#e5c06b',
          500: '#d4af37',
          600: '#aa8c2c',
        }
      }
    }
  },
  plugins: [],
}