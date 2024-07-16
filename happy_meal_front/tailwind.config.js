/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./src/**/*.{html,ts}'],
  theme: {
    extend: {
      colors: {
        primary: '#FA7070',
        secondary: '#FEFDED',
        accent: '#C6EBC5',
        muted: '#A1C398',
        success: '#34C759',
        warning: '#FFC107',
        danger: '#FF4136',
        info: '#3F51B5',
        light: '#F7F7F7',
        dark: '#333333',
      },
    },
  },
  variants: {},
  plugins: [],
};
