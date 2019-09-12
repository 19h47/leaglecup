import Checkbox from '@19h47/checkbox';
import Radios from '@19h47/radios';
import Counter from 'Utils/Counter';

export default class Form {
	constructor(element) {
		this.$form = document.querySelector(element);
	}

	init() {
		if (null === this.$form) {
			return false;
		}

		// Checkboxes
		const checkboxes = [...this.$form.querySelectorAll('.js-checkbox')];
		checkboxes.map(input => new Checkbox(input).init());

		// Radios
		const radios = [...this.$form.querySelectorAll('.js-radios')];
		radios.map(input => new Radios(input).init());

		// Counter
		const counter = new Counter(this.$form);
		counter.init();

		return true;
	}
}
