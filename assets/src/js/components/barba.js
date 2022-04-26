import barba from '@barba/core';
import barbaPrefetch from '@barba/prefetch';
import { fadeIn, fadeOut } from './animations';

import initSwiper from './swiper';
import initPhoto from './photo';
import initPageTitle from './pageTitle';

const body = document.body;
barba.use(barbaPrefetch);

const bodyDomClass = (data) => {
	const parser = new DOMParser();
	const htmlDoc = parser.parseFromString(
		data.next.html.replace(
			/(<\/?)body( .+?)?>/gi,
			'$1notbody$2>',
			data.next.html
		),
		'text/html'
	);
	const bodyClasses = htmlDoc.querySelector('notbody').getAttribute('class');
	const bodyColor = htmlDoc.querySelector('notbody').getAttribute('data-bg');
	const getTheTitle = htmlDoc
		.querySelector('notbody')
		.getAttribute('data-title');
	body.setAttribute('data-bg', bodyColor);
	body.setAttribute('class', bodyClasses);
	body.setAttribute('data-title', getTheTitle);
	const navigation = data.next.html.match(
		/<nav\sid="site-navigation"[^>]*>[.|\n]*((.|\n)*)[.|\n]*<\/nav>/
	)[1];
	const siteNavigation = document.getElementById('site-navigation');
	siteNavigation.innerHTML = navigation;
	initCursor();
};

const initCursor = () => {
	const links = document.querySelectorAll(
		'.link-home, .site-logo, .menu-link, .custom-link, .btn-default, .menu-toggle, .swiper-pagination-bullet, .swiper-button-next, .swiper-button-prev, .grid-item, .form-control, .custom-label, .selectric-wrapper, .form-file, label, .button, .modal-backdrop, .close'
	);
	// console.log(links);
	const cbk = (e) => {
		// console.log(e.currentTarget.href, window.location.href);
		if (e.currentTarget.href === window.location.href) {
			e.preventDefault();
			e.stopPropagation();
		}
		if (e.target.className === 'link-span') {
			const toggleButton = document.querySelector('.menu-toggle');
			if (toggleButton.getAttribute('aria-expanded') === 'true') {
				toggleButton.click();
			}
		}
	};
	Array.from(links).forEach((el) => {
		el.addEventListener('click', cbk);
	});
	initSwiper();
	initPhoto();
	initPageTitle();
};

barba.hooks.enter((data) => {
	console.log('hooks enter');
	window.scrollTo(0, 0);
});

barba.hooks.beforeEnter((data) => {
	console.log('hook beforeEnter');
	bodyDomClass(data);
});
// barba.hooks.after((data) => {
// 	console.log('hook after');
// 	bodyDomClass(data);
// });

barba.init({
	transitions: [
		{
			name: 'general-transition',
			once({ next }) {
				console.log('once');
				fadeIn(next.container);
				initCursor();
			},
			leave: ({ current }) => fadeOut(current.container),
			enter: ({ next }) => {
				fadeIn(next.container);
			},
		},
	],
});
