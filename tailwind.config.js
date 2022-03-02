module.exports = {
  content: [
    "./resources/views/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    minHeight: {
        '1080px': '1080px'
    },
    extend: {
        width: {
            '70px': '70px',
            '650px': '650px',
            '750px': '750px',
        }
    },
  },
  plugins: [],
}
