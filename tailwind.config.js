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
          950: '#08141b',
          900: '#0d1f29',
          800: '#132b38',
          700: '#1b3b4c',
        },
        // Turquoise de la façade de l'ESTM : accent principal
        lagoon: {
          200: '#b5e4e0',
          300: '#8fd6d0',
          400: '#5cbfb8',
          500: '#36a39f',
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
          'primary': '#5cbfb8',
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
