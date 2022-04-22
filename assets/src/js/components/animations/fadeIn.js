import gsap from 'gsap';
import imagesLoaded from 'imagesloaded';

const fadeIn = (container) => {
	console.log('fadeIn');
	const loading = document.querySelector('.loading');
	const bgColor = document.body.getAttribute('data-bg');
	// console.log(bgColor);
	const tl = gsap.timeline();
	tl.to(loading, {
		delay: 0.25,
		backgroundColor: bgColor,
		duration: 0.75,
		ease: 'none',
	}).to(
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
