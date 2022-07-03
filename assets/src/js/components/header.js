import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);

const initHeader = () => {
	// console.log('init Header');
	// const postThumbnails = document.querySelectorAll(
	// 	'.portfolio .post-thumbnail'
	// );

	// if (postThumbnails.length > 0) {
	// 	Array.from(postThumbnails).forEach((el) => {
	// 		const tl = gsap
	// 			.timeline({
	// 				scrollTrigger: {
	// 					trigger: el,
	// 					scrub: 1.5,
	// 					// markers: true,
	// 					start: 'bottom+10 top',
	// 					duration: '100%',
	// 				},
	// 			})
	// 			.to(el, { scale: 1.25, transformOrigin: 'bottom center' });
	// 	});
	// }
	gsap.utils.toArray('.portfolio .post-thumbnail').forEach((el, i) => {
		const tl = gsap
			.timeline({
				scrollTrigger: {
					trigger: el,
					scrub: 1.5,
					start: 'bottom+10 top',
					duration: '100%',
				},
			})
			.to(el, { scale: 1.25, transformOrigin: 'bottom center' });
	});
};

export default initHeader;
