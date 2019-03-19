import CreateCustomer from 'Utils/CreateCustomer';
import CreateContract from 'Utils/CreateContract';
import CreateContractor from 'Utils/CreateContractor';

import Bouncer from 'formbouncerjs';

import config from 'js/config';

export default class ElectronicSignature {
	constructor(element) {
		// eslint-disable-next-line
		const bouncer = new Bouncer(element, {
			messages: {
				missingValue: {
					default: 'Veuillez remplir ce champ s\'il vous plaît.',
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

		this.customer_number = 123;
		this.param = { j_token: config.TOKEN };

		this.initEvents();

		return true;
	}

	initEvents() {
		document.addEventListener('bouncerFormValid', (event) => {
			this.dataForm = new FormData(event.target).entries();

			// eslint-disable-next-line
			for (const pair of this.dataForm) {
				// eslint-disable-next-line
				this.data[pair[0]] = pair[1];
			}
			this.connect();
		});
	}

	connect() {
		console.log(this.data);
		const customer = new CreateCustomer(
			this.data,
			this.param,
			config.HOST,
			this.customer_number,
		);
		const contractor = new CreateContractor(
			this.data,
			this.param,
			config.HOST,
			this.customer_number,
		);
		const contract = new CreateContract(
			this.param,
			config.HOST,
			this.customer_number,
			config.CONTRACT_DEFINITION_ID,
			config.VENDOR_EMAIL,
		);

		customer.init().then(() => {
			contractor.init();
			contract.init();
		});
	}
}
