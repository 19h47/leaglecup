module.exports = {
	root: true,
	env: {
		node: true,
		browser: true,
	},
	extends: [
		'standard',
		'airbnb-base',
		'wordpress'
	],
	rules: {
		'no-console': 'off',
		'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
		'no-tabs': 0,
		'indent': ['error', 'tab'],
		'no-param-reassign': ['error', {
			props: true,
			ignorePropertyModificationsFor: ['state']
		}],
		camelcase: ['error', {properties: 'never'}]
	},
	parserOptions: {
		parser: 'babel-eslint',
	},
	settings: {
		'import/resolver': {
			'webpack': {
				'config': 'config/webpack.common.js'
			},
		}
	},
};
