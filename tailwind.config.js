/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  theme: {
    fontFamily: {
      'sans': ['Inter', 'system-ui', 'sans-serif'],
      'impact': ['Impact', 'sans-serif'],
      'inter': ['Inter', 'sans-serif'],
    },
    extend: {
    },
  },
  plugins: [],
} 