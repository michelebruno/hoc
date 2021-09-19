module.exports = {
    // important: true,
    mode: 'jit',
    purge: {
        content: [
            // './src/**/*.php',
            './template-parts/**/*.php',
            './elementor/**.php',
            './elementor/**/*.php',
            './single.php',
            './index.php',
            './singular.php',
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
            container: {
                center: true,
            },
            colors: {
                primary: {
                    dark: '#9c136c',
                    DEFAULT: 'var(--e-global-color-primary, #AD1578)'
                },
                dark: 'var(--e-global-color-text, #341129)'
            },
            height: {
                144: '36rem'
            }
        },
    },
    variants: {},
    plugins: [],
}
