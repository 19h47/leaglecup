/**
 * Production
 *
 * The CLI builds here.
 */

'use strict';

process.env.BABEL_ENV = 'production';
process.env.NODE_ENV = 'production';

const ora = require('ora');
const chalk = require('chalk');
const webpack = require('webpack');
const config = require('../config/webpack.production');
const clear = require('clear');
const webpackFormatMessages = require('webpack-format-messages');

clear();

// Init the spinner.
const spinner = new ora({ text: '' });

/**
 * Build function
 *
 * Create the production build and print the deployment instructions.
 *
 * @param {json} config config
 */
async function build(config) {
	// Compiler Instance.
	const compiler = await webpack(config);

	// Run the compiler.
	compiler.run((err, stats) => {
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
			// Formatted errors.
			clear();
			console.log(`\n❌ ${chalk.black.bgRed(' Failed to compile build. ')}\n`);
			console.log(`\n👉 ${messages.errors.join('\n\n')}`);

			// Don't go beyond this point at this time.
			return false;
		}

		// Start the build.
		console.log(`\n ${chalk.dim('Let\'s build and compile the files...')}`);
		console.log(`\n✅ ${chalk.black.bgGreen(' Built successfully! ')}\n`);

		return true;
	} );
}

build(config);
