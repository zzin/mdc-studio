module.exports = {
	content: [
		'./*.{php,scss,js}',
		'./assets/**/*.{php,scss,js}',
		'./inc/**/*.{php,scss,js}',
		'./template-parts/**/*.{php,scss,js}',
	],
	theme: {
		fontFamily: {
			sans: ['roboto', 'NotoSansKR', 'sans-serif', 'ui-sans-serif'],
		},
		extend: {
			colors: {
				primary: '#897465',
				secondary: '#a08779',
			},
		},
	},
	plugins: [require('@tailwindcss/aspect-ratio')],
};
