const wpConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

/**
 * WordPress dependencies
 */
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');

 wpConfig.module.rules.push(  {
    test: /\.(otf|jpg|jpeg|png)$/,
    loader: 'file-loader',
    options: {
        name: '[name].[ext]',
    },
});

wpConfig.plugins = [
    ...wpConfig.plugins,
    new DependencyExtractionWebpackPlugin({
        injectPolyfill: false,
        requestToExternal: (request) => {
            switch (request) {
                case 'popper.js':
                    return 'Popper';
                    break;
                case 'elementor-frontend':
                    return 'elementor-frontend'
            }

        },
        /**
         * Il valore restituito è il nome handle dello script da aggiungere alle dipendenze.
         * @param request
         */
        requestToHandle: (request) => {
            switch (request) {
                case 'popper.js':
                    return 'popper';
                    break;
                case 'elementor-frontend':
                    return 'elementor-frontend'
            }
        },
    }),
].filter(Boolean);

module.exports = {
    ...wpConfig,
    // entry: {
    //     frontend: [
    //         path.resolve( __dirname, 'src/index.js' ),
    //         path.resolve( __dirname, 'scss/style.scss' ),
    //     ],
    //     editor: [
    //         path.resolve( __dirname, 'blocks/blocks.js' ),
    //     ],
    // },
    // output: {
    //     filename: '[name].js',
    //     path: path.resolve( process.cwd(), 'build' ),
    // },
    optimization: {
        ...wpConfig.optimization,
        minimizer: [
            ...wpConfig.optimization.minimizer,
            new CssMinimizerPlugin()
        ]
    }
};
