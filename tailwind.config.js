module.exports = {
    // important: true,
    mode: 'jit',
    purge: {
        content: [
            // './src/**/*.php',
            // './template-parts/**/*.php',
            './elementor/*.php',
            './elementor/**/*.php',
            './single.php',
            './index.php',
            './single.php',
            './page.php',
            './header.php',
            './footer.php',
            './functions.php',
            './includes/**/*.php',
            './includes/*.php',
            './src/*.js',
        ],
        safelist: [
            "text-primary",
            "!text-primary",
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
            },
            height: {
                144 : '36rem'
            }
        },
    },
    variants: {},
    plugins: [],
}
