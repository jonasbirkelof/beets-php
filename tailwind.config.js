const colors = require('tailwindcss/colors');

module.exports = {
  content: [
    './public/index.php',
    './public/views/**/*.php',
    './resources/**/*.html',
    './resources/**/*.php',
    './resources/js/**/*.js'
  ],
  theme: {
    extend: {
      colors: {
        teal:colors.teal,
      },
    },
    container: {
      screens: {
        sm: '640px',
        md: '768px',
        lg: '1024px',
        xl: '1280px',
      },
      // center: true, // Default centered (no user for mx-auto)
      // padding: '1rem', // Default horizontal padding
    },
  },
  plugins: [],
}