/**
 * Development
 *
 * The CLI starts here.
 *
 */
'use strict';

process.env.BABEL_ENV = 'development';
process.env.NODE_ENV = 'development';

const ora = require('ora');
const chalk = require('chalk');
const webpack = require('webpack');
const config = require('../config/webpack.development');
const clear = require('clear');
const webpackFormatMessages = require('webpack-format-messages');

clear();

// Init the spinner.
const spinner = new ora({ text: '' });

// Create the production build and print the deployment instructions.
async function build(config) {
	// Compiler Instance.
	const compiler = await webpack(config);

	// Run the compiler.
	compiler.watch({}, (err, stats) => {
		clear();

		if (err) {
			return console.log(err);
		}

		// Get the messages formatted.
		const messages = webpackFormatMessages(stats);

		// If there are errors just show the errors.
		if (messages.errors.length) {
			// Only keep the first error. Others are often indicative
			// of the same problem, but confuse the reader with noise.
			if (messages.errors.length > 1) {
				messages.errors.length = 1;
			}

			// Clear success messages.
			clear();

			// Formatted errors.
			console.log(`\n❌ ${chalk.black.bgRed(' Failed to compile. ')}\n`);
			const errors = console.log('\n👉 ', messages.errors.join('\n\n'));
			console.log('\n');
			spinner.start(chalk.dim('Watching for changes... let\'s fix this... (Press CTRL + C to stop).'));

			return errors;
		}

		// Start the build.
		console.log(`\n${chalk.dim('Let\'s build and compile the files...')}`);
		console.log(`\n✅ ${chalk.black.bgGreen(' Compiled successfully! ')}\n`);
		console.log(
			chalk.dim('\tNote that the development build is not optimized.\n'),
			chalk.dim('\tTo create a production build, use'),
			chalk.green('npm'),
			chalk.white('run prod\n'),
		);

		return spinner.start(`${chalk.dim('Watching for changes... (Press CTRL + C to stop).')}`);
	});
}

build(config);
