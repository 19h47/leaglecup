import Checkbox from '@19h47/checkbox';
import RadioGroup from '@19h47/radiogroup';
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
		const radios = [...this.$form.querySelectorAll('.js-radiogroup')];
		radios.map(input => {
			return new RadioGroup(input).init();
		});

		// Counter
		const counter = new Counter(this.$form);
		counter.init();

		return true;
	}
}
