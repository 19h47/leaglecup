/**
 * Class Counter
 *
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class Counter {
	constructor(element) {
		this.$element = element;
	}

	init() {
		if (null === this.$element) return false;

		this.$total = this.$element.querySelector('.js-total');
		this.checkboxes = this.$element.querySelectorAll('.js-calc');

		this.initEvents();

		return true;
	}

	initEvents() {
		for (let i = 0; i < this.checkboxes.length; i += 1) {
			this.checkboxes[i].addEventListener('change', (event) => {
				const number = parseInt(event.target.getAttribute('data-number'), 10);
				const total = parseInt(this.$total.innerHTML, 10);

				Counter.calc(event.target.checked, number, total, this.$total);
			});
		}
	}

	static calc(checked, number, total, container) {
		if (!checked) {
			return Counter.sum(number, total, container);
		}

		return Counter.subtract(number, total, container);
	}

	static sum(number, total, container) {
		const current = total + number;

		return Counter.render(current, container);
	}

	static subtract(number, total, container) {
		const current = total - number;

		return Counter.render(current, container);
	}

	static render(number, container) {
		// eslint-disable-next-line
		container.innerHTML = number;
	}
}
