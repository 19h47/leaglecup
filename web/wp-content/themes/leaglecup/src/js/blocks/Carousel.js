import Flickity from 'flickity';
import { next, previous } from 'Utils/flickity.utilities';

/**
 * Carousel
 *
 * @param obj element DOM object.
 */
export default class Carousel {
	constructor(element) {
		this.rootElement = element;
	}

	init() {
		if (null === this.rootElement) {
			return false;
		}

		this.$container = this.rootElement.querySelector('.js-container');

		const $next = this.rootElement.querySelector('.js-next');
		const $previous = this.rootElement.querySelector('.js-previous');
		const dots = this.rootElement.querySelectorAll('.js-dots');

		const options = {
			autoPlay: 3000,
			pageDots: false,
			prevNextButtons: false,
			cellSelector: '.js-cell',
		};
		const carousel = new Flickity(this.$container, options); // eslint-disable-line

		$next.addEventListener('click', () => {
			next(carousel);
		});

		$previous.addEventListener('click', () => {
			previous(carousel);
		});

		carousel.on('change', () => {
			$next.classList.add('is-active');
			$previous.classList.add('is-active');

			if (carousel.slides.length === carousel.selectedIndex + 1) {
				$next.classList.remove('is-active');
			}
			if (1 === carousel.selectedIndex + 1) {
				$previous.classList.remove('is-active');
			}
		});

		// update selected cellButtons
		carousel.on('select', () => {
			for (let i = 0; i < dots.length; i += 1) {
				dots[i].classList.remove('is-selected');
				if (i === carousel.selectedIndex) {
					dots[i].classList.add('is-selected');
				}
			}
		});

		// select cell on button click
		for (let i = 0; i < dots.length; i += 1) {
			dots[i].addEventListener('click', () => {
				carousel.select(i);
			});
		}

		return true;
	}
}
