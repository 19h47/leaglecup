import Bouncer from 'formbouncerjs';


const remove = target => target.classList.remove('Form--loading');

/**
 * Command
 *
 * @param obj element DOM object.
 */
export default class Command {
	constructor(element) {
		// eslint-disable-next-line
		const bouncer = new Bouncer(element, {
			errorClass: 'Form__error-message',
			messages: {
				missingValue: {
					default: 'Veuillez remplir ce champ s\'il vous plaît.',
				},
				patternMismatch: {
					email: 'Veuillez entrer une adresse email valide.',
					default: 'Veuillez correspondre au format attendu.',
				},
			},
			disableSubmit: true,
		});

		this.url = `${window.wp.ajax_url}?action=send_command&nonce=${window.wp.nonce}`;
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

			fetch(this.url, {
				method: 'POST',
				body: form,
			})
				.then(() => {
					remove(this.$form);
					this.$form.classList.add('Form--success');
				})
				.catch(error => {
					console.log(error.message);
					remove(this.$form);
					this.$form.classList.add('Form--error');
				});
		});
	}
}
