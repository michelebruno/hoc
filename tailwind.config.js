module.exports = {
    // mode: 'jit',
    purge: {
        content: [
            './src/**/*.php',
            './template-parts/**/*.php',
            './*.php',
            './inc/**/*.php',
            './inc/*.php',
            './src/**/*.js',
        ],
    },
    darkMode: false, //you can set it to media(uses prefers-color-scheme) or class(better for toggling modes via a button)
    theme: {
        extend: {
            colors: {
                primary: {
                    dark : '#9c136c',
                    DEFAULT: 'var(--e-global-color-primary, #AD1578)'
                }
            }
        },
    },
    variants: {},
    plugins: [],
}
