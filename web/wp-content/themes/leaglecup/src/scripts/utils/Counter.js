import subtract from '@19h47/subtract';
import sum from '@19h47/sum';

/**
 * Class Counter
 *
 * @param obj element DOM element.
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class Counter {
	constructor(element) {
		this.$element = element;
	}

	init() {
		if (null === this.$element) return false;

		this.$total = this.$element.querySelector('.js-total');
		this.$input = this.$element.querySelector('.js-total-input');

		this.checkboxes = this.$element.querySelectorAll('.js-calc');

		console.log(this.$total);

		this.initEvents();

		return true;
	}

	initEvents() {
		this.checkboxes.forEach($checkbox => {
			$checkbox.addEventListener('change', event => this.change(event));
		});
	}

	change({ target }) {
		console.info('Counter.change');

		const number = parseInt(target.getAttribute('data-number'), 10);
		const total = parseInt(this.$total.innerHTML, 10);

		this.calc(target.checked, number, total);
	}

	calc(checked, number, total) {
		if (checked) {
			return this.render(sum(number, total));
		}

		return this.render(subtract(total, number));
	}

	/**
	 * Render
	 *
	 */
	render(number) {
		this.$total.innerHTML = number;

		// Input
		this.$input.value = number;
		this.$input.setAttribute('value', number);
	}
}
