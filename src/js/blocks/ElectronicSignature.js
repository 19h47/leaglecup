import CreateCustomer from 'Utils/CreateCustomer';
import CreateContract from 'Utils/CreateContract';
import CreateContractor from 'Utils/CreateContractor';

import Bouncer from 'formbouncerjs';

import config from 'js/config';

const CreateCustomerProperty = import('Utils/CreateCustomerProperty'/* webpackChunkName: "create-customer-property" */);

export default class ElectronicSignature {
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

		this.$form = document.querySelector(element);
	}

	init() {
		if (null === this.$form) {
			return false;
		}

		this.$elements = this.$form.querySelectorAll('input,select,textarea');
		this.data = {};
		this.properties = {
			licence_number: '',
			ffg_index: '',
			t_shirt_size: '',
			medical_certificate: '',
			scramble: '', // scramble_alone || scramble_team
			scramble_team_gender: '',
			scramble_team_name: '',
			option_1: '',
			option_2: '',
		};

		this.customer_number = new Date().getTime();
		this.number = new Date().getTime();

		this.param = { j_token: config.TOKEN };

		this.initEvents();

		return true;
	}

	initEvents() {
		document.addEventListener('bouncerFormValid', (event) => {
			this.dataForm = new FormData(event.target).entries();
			this.$form.classList.add('Form--loading');

			// eslint-disable-next-line
			for (const pair of this.dataForm) {
				// eslint-disable-next-line
				this.data[pair[0]] = pair[1];
			}

			this.properties = {
				licence_number: this.data.licence_number,
				ffg_index: this.data.ffg_index,
				t_shirt_size: this.data.t_shirt_size,
				medical_certificate: this.data.medical_certificate || false,
				scramble: this.data.scramble,
				scramble_team_gender: this.data.scramble_team_gender,
				scramble_team_name: this.data.scramble_team_name || false,
				option_1: this.data.option_1 || false,
				option_2: this.data.option_2 || false,
			};

			this.connect();
		});
	}

	connect() {
		const customer = new CreateCustomer(
			this.data,
			this.param,
			config.HOST,
			this.customer_number,
			this.number,
		);
		const contractor = new CreateContractor(
			this.data,
			this.param,
			config.HOST,
			this.number,
		);
		const contract = new CreateContract(
			this.param,
			config.HOST,
			this.number,
			config.CONTRACT_DEFINITION_ID,
			config.VENDOR_EMAIL,
		);

		customer.init()
			.then(() => {
				contractor.init();
				contract.init();

				// eslint-disable-next-line
				for (let [key, value] of Object.entries(this.properties)) {
					const property = new CreateCustomerProperty(
						this.customer_number,
						key,
						value,
					);
					property.init();
				}

				return true;
			})
			.then(() => {
				this.$form.classList.remove('Form--loading');
				this.$form.classList.add('Form--success');
			})
			.catch((error) => {
				console.log(error);
				this.$form.classList.remove('Form--loading');
				this.$form.classList.add('Form--error');
			});
	}
}
