import gsap from 'gsap';
import imagesLoaded from 'imagesloaded';

const fadeIn = (container) => {
	console.log('fadeIn');
	const loading = document.querySelector('.loading--wrap');
	const loadingTitle = document.querySelector('.loading--title');
	const bgColor = document.body.getAttribute('data-bg');
	const getTheTitle = document.body.getAttribute('data-title');
	loadingTitle.innerHTML = getTheTitle;
	const tl = gsap.timeline();
	tl.set(loadingTitle, { yPercent: 20 })
		.to(loading, {
			delay: 0.25,
			backgroundColor: bgColor,
			duration: 0.75,
			ease: 'none',
		})
		.to(
			loadingTitle,
			{ autoAlpha: 1, yPercent: 0, duration: 0.25, ease: 'Power3.easeOut' },
			'<'
		)
		.to(loadingTitle, {
			autoAlpha: 0,
			yPercent: -100,
			duration: 0.25,
			delay: 0.5,
		})
		.to(
			loading,
			{
				top: '-105%',
				duration: 1,
				ease: 'Power3.easeIn',
			},
			'<'
		);
	// return gsap.from(container, { autoAlpha: 0 });
	return tl;
};

export default fadeIn;
