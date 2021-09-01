module.exports = {
    // mode: 'jit',
    purge: {
        content: [
            // './src/**/*.php',
            // './template-parts/**/*.php',
            './elementor/*.php',
            './elementor/**/*.php',
            './*.php',
            './includes/**/*.php',
            './includes/*.php',
            './src/**/*.js',
        ],
        safelist: [

        ]
    },
    darkMode: false, //you can set it to media(uses prefers-color-scheme) or class(better for toggling modes via a button)
    theme: {
        fontFamily: {
            'termina': ['Termina'],
            DEFAULT: ["itc-avant-garde-gothic-pro", "sans-serif"]
        },
        extend: {
            colors: {
                primary: {
                    dark: '#9c136c',
                    DEFAULT: 'var(--e-global-color-primary, #AD1578)'
                }
            }
        },
    },
    variants: {},
    plugins: [],
}
