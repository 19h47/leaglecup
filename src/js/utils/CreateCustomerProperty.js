import config from 'js/config';

/**
 * Create customer property
 *
 * @param int customer_number
 * @param str key
 * @param     value
 */
export default class CreateCustomerProperty {
	// eslint-disable-next-line
	constructor(customer_number, key, value) {
		const params = {
			action: 'getOrCreateCustomerProperty',
			customer_number,
			key,
			value,
			id: -1,
		};

		this.url = new URL(`${config.HOST}/calinda/hub/selling/model/customerproperty/update`);

		Object.keys(params).forEach(k => this.url.searchParams.append(k, params[k]));
	}

	async init() {
		const response = await fetch(this.url);

		return response.json();
	}
}
