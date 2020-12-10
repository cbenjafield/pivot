const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  purge: false,
  theme: {
    container: {
      center: true,
      padding: '1rem'
    },
    extend: {
      fontFamily: {
        sans: ['Manrope', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        'true-dark-gray': '#252525',
        'true-gray': '#474747'
      }
    }
  },
  variants: {
    borderWidth: ['responsive', 'first', 'hover', 'focus', 'last'],
    margin: ['responsive', 'first', 'hover', 'focus', 'last'],
  },
  plugins: [
    require('@tailwindcss/ui'),
  ],
}
