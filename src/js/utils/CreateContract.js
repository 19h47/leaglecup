/**
 * Create contract
 *
 * Create a contract for a given customer, at a specified date (in milliseconds).
 *
 * @param obj param
 * @param str host
 * @param int number
 * @param int contract_definition_id
 * @param str vendor_email
 * @see https://www.sellandsign.com/fr/api-creation-contrat-a-faire-signer/
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class CreateContract {
	// eslint-disable-next-line
	constructor(param, host, number, contract_definition_id, vendor_email) {
		const params = Object.assign({
			action: 'createContract',
		},
		param,
		{
			date: new Date().getTime(),
			vendor_email,
			customer_number: number,
			contract_definition_id,
			closed: false,
			message_title: '',
			message_body: '',
			filename: '',
			keep_on_move: false,
			transaction_id: '',
			customer_entity_id: -1,
		});

		this.url = new URL(`${host}/calinda/hub/selling/model/contract/create`);

		Object.keys(params).forEach(key => this.url.searchParams.append(key, params[key]));
	}

	async init() {
		const response = await fetch(this.url);

		return response.json();
	}
}
