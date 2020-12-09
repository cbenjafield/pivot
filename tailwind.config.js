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
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
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
