/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Livewire/**/*.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        display: ['Fraunces', 'ui-serif', 'Georgia', 'serif'],
      },
      colors: {
        // Bleu nuit : fond et surfaces
        ink: {
          950: '#070f1d',
          900: '#0c1a2e',
          800: '#12253f',
          700: '#1b3556',
        },
        // Bleu de la façade de l'ESTM : accent principal
        azure: {
          200: '#c3d9fb',
          300: '#94bcf6',
          400: '#5f98ee',
          500: '#3b78d8',
        },
        // Crème chaude : texte et filets
        sand: {
          50: '#f7f3ec',
          100: '#ece5d8',
          300: '#c9bfae',
          500: '#8f8778',
        },
        'parking': {
          'free': '#5fc9a0',       // Places libres
          'occupied': '#e07a6f',   // Places occupées
          'primary': '#5f98ee',
          'warning': '#e3b25c',
        }
      },
      animation: {
        'pulse-slow': 'pulse 3s infinite',
        'bounce-subtle': 'bounce 2s infinite',
      }
    },
  },
  plugins: [],
}
