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
		this.body = {
			contract_id,
			key,
			value,
			to_fill_by_user: true,
		};

		this.url = `${config.HOST}/calinda/hub/selling/model/contractproperty/insert?action=addContractProperty`;
	}

	async init() {
		const response = await fetch(`https://cors-anywhere.herokuapp.com/${this.url}`, {
			method: 'POST',
			headers: {
				j_token: config.TOKEN,
				'Content-Type': 'application/json;charset=utf-8',
			},
			body: JSON.stringify(this.body),
		});

		return response.json();
	}
}
