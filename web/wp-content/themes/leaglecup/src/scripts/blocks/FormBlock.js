/* global grecaptcha, leaglecup */
import Checkbox from '@19h47/checkbox';
import RadioGroup from '@19h47/radiogroup';
import Counter from 'utils/Counter';

export default class FormBlock {
	constructor(element) {
		this.$form = document.querySelector(element);
	}

	init() {
		if (null === this.$form) {
			return false;
		}

		grecaptcha.ready(() => {
			grecaptcha
				.execute(leaglecup.recaptcha_site_key, { action: 'validate_captcha' })
				.then(token => {
					this.$form.querySelector('#g-recaptcha-response').value = token;
				});
		});

		const $submit = this.$form.querySelector('.js-submit');
		const teams = [...document.querySelectorAll('.js-team')];

		// Checkboxes
		const checkboxes = [...this.$form.querySelectorAll('.js-checkbox')];
		checkboxes.forEach(input => {
			const checkbox = new Checkbox(input);

			checkbox.init();
			checkbox.$input.addEventListener('activate', ({ target }) => {
				if ('medical_certificate' === target.value) {
					$submit.classList.remove('is-off');
				}
			});

			checkbox.$input.addEventListener('deactivate', ({ target }) => {
				if ('medical_certificate' === target.value) {
					$submit.classList.add('is-off');
				}
			});
		});

		// Radios
		const radios = [...this.$form.querySelectorAll('.js-radiogroup')];
		radios.forEach(input => {
			const radiogroup = new RadioGroup(input);

			radiogroup.init();

			radiogroup.radios.forEach(radio => {
				radio.on('Radio.activate', ({ element, value }) => {
					const $input = element.querySelector('input[type="radio"');

					if ('team[double]' === $input.name && 'true' === value) {
						teams.forEach($team => $team.classList.remove('is-off'));
					}
				});

				radio.on('Radio.deactivate', ({ element, value }) => {
					const $input = element.querySelector('input[type="radio"');

					if ('team[double]' === $input.name && 'true' === value) {
						teams.forEach($team => $team.classList.add('is-off'));
					}
				});
			});
		});

		// Counter
		const counter = new Counter(this.$form);
		counter.init();

		return true;
	}
}
