const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const WebpackManifestPlugin = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const WebpackNotifier = require('webpack-notifier');


const production = process.env.NODE_ENV === 'production';
const path = require('path');

module.exports = {
	watch: production ? false : true,
	entry: {
		dist: path.resolve(__dirname, 'src/index.js'),
	},
	output: {
		filename: production ? 'js/main.[chunkhash:8].js' : 'js/main.js',
	},
	devServer: {
		contentBase: path.resolve(__dirname, 'dist'),
		compress: true,
		port: 9000,
		inline: true,
	},
	resolve: {
		alias: {
			'@': path.resolve(__dirname),
			Blocks: path.resolve(__dirname, 'src/js/blocks'),
			Common: path.resolve(__dirname, 'src/js/common'),
			Datas: path.resolve(__dirname, 'src/js/datas'),
			Pages: path.resolve(__dirname, 'src/js/pages'),
			Transitions: path.resolve(__dirname, 'src/js/transitions'),
			Utils: path.resolve(__dirname, 'src/js/utils'),
			png: path.resolve(__dirname, 'src/img/png'),
			jpg: path.resolve(__dirname, 'src/img/jpg'),
			svg: path.resolve(__dirname, 'src/img/svg'),
			pdf: path.resolve(__dirname, 'src/pdf'),
			videos: path.resolve(__dirname, 'src/videos'),
			icons: path.resolve(__dirname, 'src/icons'),
			js: path.resolve(__dirname, 'src/js'),
			stylesheets: path.resolve(__dirname, 'src/stylesheets'),
		}
	},
	module: {
		rules: [
		{
			test: /\.scss$/,
			exclude: /node_modules/,
			use: [
				MiniCssExtractPlugin.loader,
				{
					loader: 'css-loader',
					options: {
						sourceMap: production ? false : true
					}
				},
				{
					loader: 'postcss-loader',
					options: {
						sourceMap: production ? false : true
					}
				},
				{
					loader: 'sass-loader',
					options: {
						sourceMap: production ? false : true
					}
				}
			]
		},
		{
			test: /\.(gif|png|jpe?g)$/i,
			use: [{
				loader: 'file-loader',
				options: {
					outputPath: 'img/',
					name: '[ext]/[hash].[ext]'
				}
			},
			{
				loader: 'image-webpack-loader',
				options: {
					mozjpeg: {
						progressive: true,
						quality: 65
					},
					optipng: {
						enabled: false
					},
					pngquant: {
						quality: '65-90',
						speed: 4
					},
					gifsicle: {
						interlaced: false
					}
				}
			}]
		},
		{
			test: /\.svg$/,
			exclude: [/fonts/, /icons/],
			use: [{
				loader: 'file-loader',
				options: {
					outputPath: 'img/svg'
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
		}]
	},
	plugins: [
		new CleanWebpackPlugin(
			['dist'],
			{
				exclude: ['.git']
			}
		),
		new CopyWebpackPlugin([
			{
				from: 'src/favicons',
				to: 'favicons'
			},
			{
				from: 'src/pdf',
				to: 'pdf'
			}
		]),
		new HtmlWebpackPlugin({
			filename: path.resolve(__dirname, 'dist/index.html' ),
			template: path.resolve(__dirname, 'index.html' ),
			inject: true,
			minify: {
				collapseWhitespace: true,
				preserveLineBreaks: false
			}
		}),
		new WebpackManifestPlugin({
			writeToFileEmit: true
		}),
		new MiniCssExtractPlugin({
			filename: production ? 'css/main.[chunkhash:8].css' : 'css/main.css',
		}),
		new StyleLintPlugin(),
		new WebpackNotifier()
	],
	devtool: production ? false : 'source-map',
};
