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
      colors: {
        'parking': {
          'free': '#10b981',      // Vert pour places libres
          'occupied': '#ef4444',   // Rouge pour places occupées
          'primary': '#3b82f6',    // Bleu pour éléments principaux
          'warning': '#f59e0b',    // Orange pour alertes
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
