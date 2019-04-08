import {
	TOKEN,
	HOST,
} from 'Utils/environment';

/**
 * Create contractor
 *
 * @param obj data
 * @param int number
 * @see https://www.sellandsign.com/fr/api-definition-de-signataires/
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class CreateContractor {
	constructor(data, number) {
		this.body = {
			customer_number: number,
			id: -1,
			civility: data.civility,
			firstname: data.firstname,
			lastname: data.lastname,
			email: data.email,
			address_1: data.address_1,
			postal_code: data.postal_code,
			city: data.city,
			country: data.country,
			cell_phone: data.cell_phone,
			// phone: data.phone,
			// address_2: data.address_2,
			company_name: data.company_name,
			is_default: true,
			job_title: data.job_title,
			// registration_number: data.registration_number,
			// birthdate: data.birthdate,
			// birthplace: data.birthplace,
			// category: '',
		};

		this.url = `${HOST}/calinda/hub/selling/model/contractor/create?action=getOrCreateContractor`;
	}

	async init() {
		const response = await fetch(`https://cors-anywhere.herokuapp.com/${this.url}`, {
			method: 'POST',
			headers: {
				j_token: TOKEN,
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(this.body),
		});

		return response.json();
	}
}
