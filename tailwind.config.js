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
                '320': '320px',
                '60': '60px',
            },
            height: {
                '280': '280px',
                '180': '180px',
                '40': '40px',
                '60': '60px',
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
