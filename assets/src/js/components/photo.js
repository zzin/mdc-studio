import gsap from 'gsap';

const initPhoto = () => {
	const photoWraps = document.querySelectorAll('.photo--wrap');
	if (photoWraps.length > 0) {
		Array.from(photoWraps).forEach((el) => {
			const img = el.querySelector('.photo--wrap-img');
			const title = el.querySelector('.photo--wrap-title');
			const h3 = el.querySelector('.h3');
			const tl = gsap.timeline({ paused: true, duration: 0.4 });
			tl.to(img, { scale: 1.4, ease: 'Power3.easeInOut' }, 0)
				.to(title, { autoAlpha: 1 }, '<50%')
				.to(
					h3,
					{ autoAlpha: 1, scale: 1, duration: 0.2, ease: 'Power1.easeOut' },
					'<'
				);
			el.addEventListener('mouseover', () => {
				tl.play();
			});
			el.addEventListener('mouseout', () => {
				tl.reverse();
			});
		});
	}
};

export default initPhoto;
