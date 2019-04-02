import config from 'js/config';

/**
 * Create contract
 *
 * Create a contract for a given customer, at a specified date (in milliseconds).
 *
 * @param obj param
 * @param int number
 * @see https://www.sellandsign.com/fr/api-creation-contrat-a-faire-signer/
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class CreateContract {
	constructor(param, number) {
		this.body = {
			date: new Date().getTime(),
			vendor_email: config.VENDOR_EMAIL,
			customer_number: number,
			contract_definition_id: config.CONTRACT_DEFINITION_ID,
			closed: false,
			message_title: '',
			message_body: '',
			filename: '',
			keep_on_move: false,
			transaction_id: '',
			customer_entity_id: -1,
		};

		this.url = `${config.HOST}/calinda/hub/selling/model/contract/create?action=createContract`;
	}

	async init() {
		const response = await fetch(`https://cors-anywhere.herokuapp.com/${this.url}`, {
			method: 'POST',
			headers: {
				j_token: config.TOKEN,
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(this.body),
		});

		return response.json();
	}
}
