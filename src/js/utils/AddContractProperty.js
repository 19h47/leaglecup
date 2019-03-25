import config from 'js/config';

/**
 * Add Contract Property
 *
 * @param str key
 * @param     value
 */
export default class addContractProperty {
	// eslint-disable-next-line
	constructor(key, value, contract_id) {
		const params = {
			action: 'addContractProperty',
			j_token: config.TOKEN,
			contract_id,
			key,
			value,
			to_fill_by_user: true,
		};

		this.url = new URL(`${config.HOST}/calinda/hub/selling/model/contractproperty/insert`);

		Object.keys(params).forEach(k => this.url.searchParams.append(k, params[k]));
	}

	async init() {
		const response = await fetch(this.url);

		return response.json();
	}
}
