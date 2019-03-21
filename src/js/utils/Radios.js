/**
 * Class Radios
 *
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class Radios {
	constructor(element) {
		this.$element = element;
	}

	init() {
		if (null === this.$element) return false;

		this.elements = this.$element.querySelectorAll('.js-radio');

		this.initEvents();

		return true;
	}

	initEvents() {
		for (let i = 0; i < this.elements.length; i += 1) {
			const input = this.elements[i].querySelector('input');

			this.elements[i].addEventListener('click', () => {
				this.deactivateAll();
				Radios.toggle(this.elements[i], input, this.elements[i].classList.contains('is-active'));
			});

			if (input.checked) {
				Radios.activate(this.elements[i], input, false);
			}
		}
	}


	static toggle(element, input, active) {
		if (active) {
			return this.deactivate(element, input, active);
		}

		return this.activate(element, input, active);
	}


	/**
	 * Checkbox.activate
	 *
	 * @return	bool
	 */
	static activate(element, input, active) {
		if (active) return false;

		const conditionClass = element.getAttribute('data-condition-class');
		const conditionalEls = document.querySelectorAll(`.${conditionClass}`) || [];
		const radio = input;

		element.classList.add('is-active');

		for (let i = 0; i < conditionalEls.length; i += 1) {
			conditionalEls[i].classList.remove('is-off');
		}

		radio.setAttribute('checked', true);

		return true;
	}


	/**
	 * Checkbox.deactivate
	 *
	 * @return	bool
	 */
	static deactivate(element, input, active) {
		if (!active) return false;

		const conditionClass = element.getAttribute('data-condition-class');
		const conditionalEls = document.querySelectorAll(`.${conditionClass}`) || [];
		const radio = input;

		element.classList.remove('is-active');

		for (let i = 0; i < conditionalEls.length; i += 1) {
			conditionalEls[i].classList.add('is-off');
		}

		radio.removeAttribute('checked');

		return true;
	}

	deactivateAll() {
		for (let i = 0; i < this.elements.length; i += 1) {
			const input = this.elements[i].querySelector('input');

			Radios.deactivate(this.elements[i], input, true);
		}
	}
}
