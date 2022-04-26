import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import ScrollSmoother from 'gsap/ScrollSmoother';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

const initPageTitle = () => {
	const smoother = ScrollSmoother.create({
		wrapper: '#smooth-wrapper-title',
		content: '#smooth-content-title',
		smooth: 1,
		normalizeScroll: true,
		ignoreMobileResize: true,
		effects: true,
		preventDefault: true,
	});
};

export default initPageTitle;
