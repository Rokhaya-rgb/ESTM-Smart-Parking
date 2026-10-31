/** @type {import('tailwindcss').Config} */

// Couleurs pilotées par les variables CSS de resources/css/app.css :
// le thème (clair ou sombre) est choisi par l'attribut data-theme de <html>.
const themed = (name) => `rgb(var(--${name}) / <alpha-value>)`;

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
        // Texte fort et filets : blanc en sombre, bleu nuit en clair
        fg: themed('fg'),
        // Fonds de page
        page: themed('page'),
        'page-alt': themed('page-alt'),
        // Bleu nuit fixe : texte sur les boutons azur
        ink: {
          950: '#070f1d',
          900: '#0c1a2e',
          800: '#12253f',
          700: '#1b3556',
        },
        // Bleu de la façade de l'ESTM : accent principal
        azure: {
          200: themed('azure-200'),
          300: themed('azure-300'),
          400: '#5f98ee',
          500: '#3b78d8',
        },
        // Texte : crème en sombre, bleu ardoise en clair
        sand: {
          50: themed('sand-50'),
          100: themed('sand-100'),
          300: themed('sand-300'),
          500: themed('sand-500'),
        },
        'parking': {
          'free': themed('free'),         // Places libres
          'occupied': themed('occupied'), // Places occupées
          'primary': '#5f98ee',
          'warning': themed('warning'),
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
