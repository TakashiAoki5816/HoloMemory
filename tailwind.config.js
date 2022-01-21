module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            width: {
                '60': '60px',
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
