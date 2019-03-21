/**
 *
 * @file   webpack.production.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

 const glob = require('glob');
 const path = require('path');

const merge = require('webpack-merge');
const common = require('./webpack.common.js');

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const PurgecssPlugin = require('purgecss-webpack-plugin');
const CompressionPlugin = require('compression-webpack-plugin');

module.exports = merge(
    common,
    {
        output: {
            filename: 'js/[name].js'
        },
        mode: 'production',
        devtool: false,
        watch: false,
        module: {
            rules: [{
                test: /\.scss$/,
                exclude: /node_modules/,
                use: [{
                    loader: MiniCssExtractPlugin.loader,
                    options: {
                        publicPath: '../',
                    },
                },
                {
                    loader: 'css-loader',
                    options: {
                        sourceMap: false,
                    },
                },
                {
                    loader: 'postcss-loader',
                    options: {
                        sourceMap: false,
                    },
                },
                {
                    loader: 'sass-loader',
                    options: {
                        sourceMap: false,
                    },
                }]
            }],
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: 'css/main.css'
            }),
			new PurgecssPlugin({
      			paths: glob.sync(path.join(__dirname, '..', 'views/**/*.html.twig')),
				whitelist: ['is-invalid', 'is-hidden', 'is-current', 'is-in-viewport', 'Front-page', 'Site-header', 'Page'],
				whitelistPatternsChildren: [/^flickity-/, /^wp-block-/, /^Partners-block/, /^Event-block/, /^Form/]
    		}),
			new CompressionPlugin()
        ]
    },
);
