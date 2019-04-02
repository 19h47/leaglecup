import Checkbox from '@19h47/checkbox';
import Radios from 'Utils/Radios';
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
		const inputCheckboxes = this.$form.querySelectorAll('.js-checkbox');

		for (let i = 0; i < inputCheckboxes.length; i += 1) {
			const checkbox = new Checkbox(inputCheckboxes[i]);
			checkbox.init();
		}

		// Radios
		const inputRadios = this.$form.querySelectorAll('.js-radios');

		for (let i = 0; i < inputRadios.length; i += 1) {
			const radios = new Radios(inputRadios[i]);
			radios.init();
		}

		// Counter
		const counter = new Counter(this.$form);

		counter.init();

		return true;
	}
}
