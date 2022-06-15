import Guid from 'common/Guid';
import RegistrationForm from 'blocks/RegistrationForm';
import FormBlock from 'blocks/FormBlock';
import Carousel from 'blocks/Carousel';

console.log('totot');

(() => {
	if ('production' !== process.env.NODE_ENV) {
		const guid = new Guid();

		guid.init();
	}

	console.log('%c🔥 ines a (http://inesa.fr) & 19h47 (https://19h47.fr) 🔥', 'padding:0.5em 1em;');

	//
	const registrationForm = new RegistrationForm('.js-registration');
	registrationForm.init();

	//
	const form = new FormBlock('.js-form');
	form.init();

	//
	const carousels = [...document.querySelectorAll('.js-carousel')];
	carousels.map(item => new Carousel(item).init());
})();
