import config from 'js/config';

export default class AddContractor {
	constructor() {
		const params = {
			action: addContractorTo
		}

		this.url = new URL(`${config.HOST}/calinda/hub/selling/model/contractorsforcontract/insert`);

		Object.keys(params).forEach(k => this.url.searchParams.append(k, params[k]));
	}

	async init() {
		const response = await fetch(this.url);

		return response.json();
	}
}
