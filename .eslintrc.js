module.exports = {
	root: true,
	env: {
		node: true,
		browser: true,
	},
	extends: [
		'standard',
		'airbnb-base',
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
		'yoda': [2, 'always'],
		"import/no-named-as-default": 0
	},
	parser: 'babel-eslint',
	parserOptions: {
  		sourceType: 'module',
  		allowImportExportEverywhere: true
	},
	settings: {
		'import/resolver': {
			'webpack': {
				'config': 'config/webpack.common.js'
			},
		}
	},
};
