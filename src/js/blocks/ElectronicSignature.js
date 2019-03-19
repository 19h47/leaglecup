import CreateCustomer from 'Utils/CreateCustomer';
import CreateContract from 'Utils/CreateContract';
import CreateContractor from 'Utils/CreateContractor';
import config from 'js/config';

export default class ElectronicSignature {
	constructor(element) {
		this.$form = document.querySelector(element);
	}

	init() {
		if (this.$form === null) return false;

		this.HOST = 'https://cloud.sellandsign.com';
		this.contract_definition_id = 8985;
		this.customer_number = 123;
		this.param = { j_token: config.TOKEN };

		this.$submit = this.$form.querySelector('.js-submit');

		this.initEvents();

		return true;
	}

	initEvents() {
		this.$form.addEventListener('submit', (event) => {
			event.preventDefault();

			this.connect();
		});
	}

	connect() {
		const customer = new CreateCustomer(this.param, this.HOST, this.customer_number);
		const contractor = new CreateContractor(this.param, this.HOST, this.customer_number);
		const contract = new CreateContract(
			this.param,
			this.HOST,
			this.customer_number,
			this.contract_definition_id,
		);

		customer.init().then(() => {
			contractor.init();
			contract.init();
		});
	}
}
