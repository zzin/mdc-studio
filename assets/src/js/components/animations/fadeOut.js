import gsap from 'gsap';

const fadeOut = (container) => {
	console.log('fadeOut');
	const loading = document.querySelector('.loading--wrap');
	const loadingTitle = document.querySelector('.loading--title');
	const tl = gsap.timeline();
	tl.set(loading, { top: '105%' })
		.set(loadingTitle, { autoAlpha: 0, y: '100%' })
		// .to(loadingTitle, { autoAlpha: 1, y: 0, duration: 0.5 })
		.to(loading, {
			top: '0',
			duration: 1,
			delay: 0.25,
			ease: 'Power4.easeOut',
		});
	// return gsap.to(container, { autoAlpha: 0 });
	return tl;
};

export default fadeOut;
