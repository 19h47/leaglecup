/**
 * Create customer
 *
 * @param obj data
 * @param obj param
 * @param str host
 * @param int customer_code
 * @see https://www.sellandsign.com/fr/api-creation-client-signataire/
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class CreateCustomer {
	// eslint-disable-next-line
	constructor(data, param, host, customer_code, number) {
		const params = Object.assign({
			action: 'selectOrCreateCustomer',
		},
		param,
		{
			address_1: data.address_1,
			address_2: data.address_2,
			birthdate: data.birthdate,
			birthplace: data.birthplace,
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
			phone: data.phone,
			postal_code: data.postal_code,
			registration_number: data.registration_number,
		});

		this.url = new URL(`${host}/calinda/hub/selling/model/customer/update`);

		Object.keys(params).forEach(key => this.url.searchParams.append(key, params[key]));
	}

	async init() {
		const response = await fetch(this.url);

		return response.json();
	}
}
