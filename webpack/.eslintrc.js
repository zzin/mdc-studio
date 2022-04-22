/**
 * Eslint config file
 * as configured in package.json under eslintConfig.extends
 *
 * @docs BabelJS: https://babeljs.io/
 * @docs Webpack babel-loader: https://webpack.js.org/loaders/babel-loader/
 * @docs @wordpress/eslint-plugin : https://www.npmjs.com/package/@wordpress/eslint-plugin
 * @since 1.0.0
 */
module.exports = {
	parser: '@babel/eslint-parser',
	parserOptions: {
		requireConfigFile: false,
	},
	env: {
		es6: true,
		browser: true,
		node: true,
		jquery: true,
		amd: true,
	},
	extends: [
		'eslint:recommended',
		'plugin:@wordpress/eslint-plugin/recommended',
	],
	rules: {
		'no-console': 'off',
		'no-alert': 'off',
		'no-unused-vars': 'off',
		'prettier/prettier': 0,
	},
	globals: {
		wp: true,
		jQuery: true,
	},
	ignorePatterns: [
		'tests/**/*.js',
		'temp.js',
		'/vendor/**/**/*.js',
		'/node_modules/**/**/*.js',
	],
};
