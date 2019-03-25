import CreateCustomer from 'Utils/CreateCustomer';
import CreateContract from 'Utils/CreateContract';
import CreateContractor from 'Utils/CreateContractor';
import AddContractProperty from 'Utils/AddContractProperty';

import Bouncer from 'formbouncerjs';

import config from 'js/config';


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
			license_number: '', // string
			ffg_index: '', // string
			t_shirt_size: 'S', // string: 'S' || 'M' || 'L' || 'XL'
			medical_certificate: false, // boolean: true || false
			scramble: '', // string: 'Je viens seul' || 'Je constitue une équipe'
			scramble_lastname_second_player: '', // string
			scramble_firstname_second_player: '', // string
			scramble_license_number_second_player: '', // string
			option_1: false, // boolean: true || false
			option_2: false, // boolean: true || false
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
				license_number: this.data.license_number,
				ffg_index: this.data.ffg_index,
				t_shirt_size: this.data.t_shirt_size,
				medical_certificate: this.data.medical_certificate || false,
				scramble: this.data.scramble,
				scramble_lastname_second_player: this.data.scramble_lastname_second_player,
				scramble_firstname_second_player: this.data.scramble_firstname_second_player,
				scramble_license_number_second_player: this.data.scramble_license_number_second_player,
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
				contract.init().then((data) => {
					// eslint-disable-next-line
					for (let [key, value] of Object.entries(this.properties)) {
						const property = new AddContractProperty(
							key,
							value,
							data.id,
						);
						property.init();
					}
				});

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
