const presets = [
	[
		'@babel/preset-env',
		{
			targets: '>0.25%',
		},
	],
];

const plugins = [
	'@babel/plugin-syntax-dynamic-import',
	'@babel/plugin-transform-runtime',
	'@babel/plugin-transform-parameters',
];

module.exports = { presets, plugins };
