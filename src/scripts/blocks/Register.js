/* global leaglecup */
import Bouncer from 'formbouncerjs';

const remove = target => target.classList.remove('Form--loading');

/**
 * Command
 *
 * @param {Object} element DOM object.
 */
export default class Register {
	constructor(element) {
		// eslint-disable-next-line
		const bouncer = new Bouncer(element, {
			errorClass: 'Form__error-message',
			messages: {
				missingValue: {
					default: "Veuillez remplir ce champ s'il vous plaît.",
				},
				patternMismatch: {
					email: 'Veuillez entrer une adresse email valide.',
					default: 'Veuillez correspondre au format attendu.',
				},
			},
			disableSubmit: true,
		});

		this.url = `${leaglecup.ajax_url}?action=register&nonce=${leaglecup.nonce}`;
		this.$form = document.querySelector(element);
	}

	init() {
		if (null === this.$form) {
			return false;
		}

		this.initEvents();

		return true;
	}

	initEvents() {
		document.addEventListener('bouncerFormValid', () => {
			const form = new FormData(this.$form);

			this.$form.classList.add('Form--loading');
			this.$form.classList.remove('Form--error');
			this.$form.classList.remove('Form--success');

			fetch(this.url, {
				method: 'POST',
				body: form,
			})
				.then(response => response.json())
				.then(response => {
					if (false === response.success) {
						remove(this.$form);
						this.$form.classList.add('Form--error');
					} else {
						remove(this.$form);
						this.$form.classList.add('Form--success');
					}
				})
				.catch(error => {
					console.error(error);
					remove(this.$form);
					this.$form.classList.add('Form--error');
				});
		});
	}
}
