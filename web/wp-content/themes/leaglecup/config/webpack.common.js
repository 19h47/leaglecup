/**
 *
 * @file   webpack.common.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

// Node modules
const path = require('path');

// Plugins
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const WebpackNotifierPlugin = require('webpack-notifier');

/**
 * Resolve
 *
 * @param {str} dir Dir.
 * @return {str} Dir.
 */
function resolve(dir) {
	return path.join(__dirname, '..', dir)
}

// Manifest plugin
const manifestPlugin = new ManifestPlugin({
	publicPath: 'dist/'
});

module.exports = {
	devServer: {
		contentBase: resolve('dist'),
		compress: true,
		port: 9000,
		inline: true,
	},
	externals: {
		'jquery': 'jQuery',
		'jQuery': 'jQuery',
		'$': 'jQuery',
	},
	resolve: {
		alias: {
			'@': resolve('src'),

			// js
			js: resolve('src/js'),
			Blocks: resolve('src/js/blocks'),
			Common: resolve('src/js/common'),
			Pages: resolve('src/js/pages'),
			Transitions: resolve('src/js/transitions'),
			Components: resolve('src/js/components'),
			Utils: resolve('src/js/utils'),
			Services: resolve('src/js/services'),
			Factories: resolve('src/js/factories'),
			Router: resolve('src/js/router'),
			Api: resolve('src/js/api'),
			Store: resolve('src/js/store'),
			Vendors: resolve('src/js/vendors'),

			// img
			img: resolve('src/img'),
			png: resolve('src/img/png'),
			jpg: resolve('src/img/jpg'),
			svg: resolve('src/img/svg'),

			// videos
			videos: resolve('src/videos'),

			// icons
			icons: resolve('src/icons'),

			// fonts
			fonts: resolve('src/fonts'),

			// stylesheets
			stylesheets: resolve('src/stylesheets')
		}
	},
	module: {
		rules: [{
			enforce: 'pre',
			test: /\.js$/,
			exclude: [/node_modules/, /vendors/],
			loader: 'eslint-loader'
		},
		{
			test: /\.js$/,
			exclude: /node_modules/,
			loader: 'babel-loader'
		},
		{
			test: /\.(woff2?|eot|ttf|otf|woff|svg)?$/,
			exclude: [/img/, /icons/],
			use: [{
				loader: 'file-loader',
				options: {
					name: '[name].[ext]',
					outputPath: 'fonts/',
					publicPath: '../fonts/',
				},

			}]
		},
		{
			test: /\.svg$/,
			exclude: [/img/, /fonts/],
			use: [{
				loader: 'svg-sprite-loader',
				options: {
					spriteFilename: 'icons.svg',
					extract: true
				}
			},
			'svg-transform-loader',
			'svgo-loader'
			]
		},
		{
			test: /\.svg$/,
			exclude: [/fonts/, /icons/],
			use: [{
				loader: 'file-loader',
				options: {
					outputPath: 'img/svg',
					name: '[name].[ext]',
				}
			},
			{
				loader: 'svgo-loader',
				options: {
					plugins: [{
						removeTitle: true
					},
					{
						convertColors: {
							shorthex: false
						}
					},
					{
						convertPathData: false
					}]
				}
			}]
		},
		{
			test: /\.(mp4|webm|ogg|mp3|wav|flac|aac|ogv)(\?.*)?$/,
			use: [{
				loader: 'url-loader',
				options: {
					limit: 100000,
					name: '[name].[ext]',
					publicPath: resolve('src/videos'),
					outputPath: 'videos/',
				}
			}]
		},
		{
			test: /\.(gif|png|jpe?g)$/i,
			exclude: [/animations/],
			use: [{
				loader: 'file-loader',
				options: {
					outputPath: 'img/',
					name: '[ext]/[name].[ext]',
					// publicPath: '../img/',
				},
			},
			{
				loader: 'image-webpack-loader',
				options: {
					mozjpeg: {
						progressive: true,
						quality: [65]
					},
					optipng: {
						enabled: false
					},
					pngquant: {
						quality: [0.65, 0.9],
						speed: 4
					},
					gifsicle: {
						interlaced: false
					}
				}
			}]
		}]
	},
	plugins: [
        new CleanWebpackPlugin(),
		manifestPlugin,
		new SpriteLoaderPlugin({ plainSprite: true }),
		new WebpackNotifierPlugin({
            title: 'Webpack',
            excludeWarnings: true,
            alwaysNotify: true
        }),
	],
};
