import {
	HOST,
	TOKEN,
} from 'Utils/environment';

/**
 * Create customer
 *
 * @param obj data
 * @param int customer_code
 * @param int number
 * @see https://www.sellandsign.com/fr/api-creation-client-signataire/
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class CreateCustomer {
	// eslint-disable-next-line
	constructor(data, customer_code, number) {
		this.body = {
			address_1: data.address_1,
			// address_2: data.address_2,
			// birthdate: data.birthdate,
			// birthplace: data.birthplace,
			cell_phone: data.cell_phone,
			city: data.city,
			civility: data.civility,
			country: data.country,
			company_name: data.company_name,
			customer_code,
			email: data.email,
			firstname: data.firstname,
			job_title: data.job_title,
			lastname: data.lastname,
			number,
			// phone: data.phone,
			postal_code: data.postal_code,
			// registration_number: data.registration_number,
		};

		this.url = `${HOST}/calinda/hub/selling/model/customer/update?action=selectOrCreateCustomer`;
	}

	async init() {
		const response = await fetch(`https://cors-anywhere.herokuapp.com/${this.url}`, {
			method: 'POST',
			mode: 'cors',
			headers: {
				j_token: TOKEN,
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(this.body),
		});

		return response.json();
	}
}
