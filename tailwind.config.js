module.exports = {
	content: [
		'./*.{php,scss,js}',
		'./assets/**/*.{php,scss,js}',
		'./inc/**/*.{php,scss,js}',
		'./template-parts/**/*.{php,scss,js}',
	],
	theme: {
		fontFamily: {
			sans: ['campton', 'NotoSansKR', 'sans-serif', 'ui-sans-serif'],
		},
		extend: {
			colors: {
				primary: '#897465',
				secondary: '#1c1c1b',
				gray: '#e9e9e9',
			},
		},
	},
	plugins: [
		require('@tailwindcss/aspect-ratio'),
		require('@tailwindcss/forms'),
	],
};
