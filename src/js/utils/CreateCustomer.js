/**
 * Create customer
 *
 * @param obj param
 * @param str host
 * @param int number
 * @see https://www.sellandsign.com/fr/api-creation-client-signataire/
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class CreateCustomer {
	constructor( param, host, number ) {
		const params = Object.assign({
			action: 'selectOrCreateCustomer'
		},
		param,
		{
			address_1: '1 impasse Joseph Peignon',
			address_2: '',
			birthdate: '',
			birthplace: '',
			cell_phone: '0609187529',
			city: 'Nantes',
			civility: 'MONSIEUR', // MADAME, MADEMOISELLE
			country: 'FR',
			company_name: '19h47',
			customer_code: '1234',
			email: 'jeremylevron@19h47.fr',
			firstname: 'Jérémy',
			job_title: '',
			lastname: 'Levron',
			number,
			phone: '',
			postal_code: '44000',
			registration_number: ''
		});

		this.url = new URL( `${host}/calinda/hub/selling/model/customer/update` );

		Object.keys( params ).forEach( key => this.url.searchParams.append( key, params[key]) );
	}

	async init() {
		const response = await fetch( this.url );

		return response.json();
	}
}
