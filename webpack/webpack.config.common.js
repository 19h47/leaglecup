/**
 * Common
 *
 * @file webpack.config.common.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */

// Plugins
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const WebpackNotifierPlugin = require('webpack-notifier');
const ESLintPlugin = require('eslint-webpack-plugin');

const resolve = require('./webpack.utils');

// Manifest plugin
const manifestPlugin = new WebpackManifestPlugin({
	publicPath: 'dist/',
});

module.exports = {
	output: {
		path: resolve('/dist'),
	},
	externals: {
		jquery: 'jQuery',
		$: 'jQuery',
	},
	optimization: {
		splitChunks: {
			// include all types of chunks
			chunks: 'all',
			name: 'vendors',
		},
	},
	resolve: {
		alias: {
			'@': resolve('src'),

			// scripts
			scripts: resolve('src/scripts'),
			abstracts: resolve('src/scripts/abstracts'),
			common: resolve('src/scripts/common'),
			modules: resolve('src/scripts/modules'),
			pages: resolve('src/scripts/pages'),
			transitions: resolve('src/scripts/transitions'),
			factories: resolve('src/scripts/factories'),
			services: resolve('src/scripts/services'),
			utils: resolve('src/scripts/utils'),
			blocks: resolve('src/scripts/blocks'),
			polyfills: resolve('src/scripts/polyfills'),
			vendors: resolve('src/scripts/vendors'),
			videos: resolve('src/videos'),

			// stylesheets
			stylesheets: resolve('src/stylesheets'),

			// img
			jpg: resolve('src/img/jpg'),
			png: resolve('src/img/png'),
			gif: resolve('src/img/gif'),
			svg: resolve('src/img/svg'),
			icons: resolve('src/icons'),
		},
	},

	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				loader: 'babel-loader',
			},
			{
				test: /\.(woff2?|eot|ttf|otf|woff|svg)?$/,
				exclude: [/img/, /icons/],
				type: 'asset/resource',
				generator: {
					filename: 'fonts/[hash][ext][query]',
				},
			},
			{
				test: /\.svg$/,
				exclude: [/img/, /fonts/],
				use: [
					{
						loader: 'svg-sprite-loader',
						options: {
							spriteFilename: 'icons.svg',
							extract: true,
						},
					},
					'svg-transform-loader',
					'svgo-loader',
				],
			},
			{
				test: /\.svg$/,
				exclude: [/fonts/, /icons/],
				type: 'asset/resource',
				generator: {
					filename: 'img/svg/[name][ext]',
				},
				use: 'svgo-loader',
			},
			{
				test: /\.(mp4|webm|ogg|mp3|wav|flac|aac|ogv)(\?.*)?$/,
				use: [
					{
						loader: 'url-loader',
						options: {
							limit: 100000,
							name: '[name].[ext]',
							publicPath: resolve('src/videos'),
							outputPath: 'videos/',
						},
					},
				],
			},
			{
				test: /\.(png)$/i,
				type: 'asset/resource',
				generator: {
					filename: 'img/png/[name][ext]',
				},
			},
		],
	},
	plugins: [
		manifestPlugin,
		new SpriteLoaderPlugin({ plainSprite: true }),
		new WebpackNotifierPlugin({
			title: 'Webpack',
			excludeWarnings: true,
			alwaysNotify: true,
		}),
		new ESLintPlugin(),
	],
};
