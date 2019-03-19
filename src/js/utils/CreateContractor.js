/**
 * Create contractor
 *
 * @param obj param
 * @param str host
 * @param int number
 * @see https://www.sellandsign.com/fr/api-definition-de-signataires/
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class CreateContractor {
	constructor(param, host, number) {
		const params = Object.assign({
			action: 'getOrCreateContractor',
		},
		param,
		{
			customer_number: number,
			id: -1,
			civility: 'MONSIEUR', // MADAME, MADEMOISELLE
			firstname: 'Jérémy',
			lastname: 'Levron',
			email: 'jeremylevron@19h47.fr',
			address_1: '1 impasse Joseph Peignon',
			postal_code: '44000',
			city: 'Nantes',
			country: 'FR',
			cell_phone: '0609187529',
			phone: '',
			address_2: '',
			company_name: '19h47',
			is_default: true,
			job_title: 'Front developper',
			registration_number: '',
			birthdate: '',
			birthplace: '',
			category: '',
		});

		this.url = new URL(`${host}/calinda/hub/selling/model/contractor/create`);

		Object.keys(params).forEach(key => this.url.searchParams.append(key, params[key]));
	}

	async init() {
		const response = await fetch(this.url);

		return response.json();
	}
}
