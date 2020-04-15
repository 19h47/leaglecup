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

		this.initEvents();

		return true;
	}

	initEvents() {
		for (let i = 0; i < this.checkboxes.length; i += 1) {
			this.checkboxes[i].addEventListener('change', event => this.change(event));
			this.checkboxes[i].addEventListener('input', event => this.change(event));
		}
	}

	change(event) {
		console.info('Counter.change');
		const { target } = event;
		const number = parseInt(target.getAttribute('data-number'), 10);
		const total = parseInt(this.$total.innerHTML, 10);

		this.calc(target.checked, number, total);
	}

	calc(checked, number, total) {
		if (checked) {
			return this.sum(number, total);
		}

		return this.subtract(number, total);
	}

	/**
	 * Sum
	 *
	 * @param  {int} number
	 * @param  {int} total
	 *
	 * @return this.render
	 */
	sum(number, total) {
		const current = total + number;

		return this.render(current);
	}

	/**
	 * Subtract
	 *
	 */
	subtract(number, total) {
		console.info('Counter.substract');
		const current = total - number;

		return this.render(current);
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
