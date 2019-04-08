import { TOKEN, HOST } from 'Utils/environment';

/**
 * Add Contract Property
 *
 * @param str key
 * @param     value
 * @param     contract_id
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

		this.url = `${HOST}/calinda/hub/selling/model/contractproperty/insert?action=addContractProperty`;
	}

	async init() {
		const response = await fetch(`https://cors-anywhere.herokuapp.com/${this.url}`, {
			method: 'POST',
			headers: {
				j_token: TOKEN,
				'Content-Type': 'application/json;charset=utf-8',
			},
			body: JSON.stringify(this.body),
		});

		return response.json();
	}
}
