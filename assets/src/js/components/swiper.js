import Swiper, { Navigation, Pagination, Autoplay } from 'swiper';
Swiper.use([Navigation, Pagination, Autoplay]);

const initSwiper = () => {
	const swiperHorizontal = document.querySelectorAll(
		'[data-component="swiper-horizontal"]'
	);
	if (swiperHorizontal.length > 0) {
		Array.from(swiperHorizontal).forEach((el) => {
			const swiper = new Swiper(el, {
				slidesPerView: 'auto',
				loop: true,
				speed: 1000,
				autoplay: {
					delay: 4000,
					disableOnInteraction: false,
				},
			});
		});
	}
};
export default initSwiper;
