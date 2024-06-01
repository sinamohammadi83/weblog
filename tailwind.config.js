/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')
module.exports = {
  content: ["./**/*{.html,.php}"],
  theme: {
    extend: {
      fontFamily : {
        sans : ['vazir', ...defaultTheme.fontFamily.sans]
      }
    },
  },
  plugins: [],
}