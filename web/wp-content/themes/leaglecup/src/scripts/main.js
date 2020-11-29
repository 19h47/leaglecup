import Guid from 'common/Guid';
import Register from 'blocks/Register';
import FormBlock from 'blocks/FormBlock';
import Carousel from 'blocks/Carousel';

(() => {
	if ('production' !== process.env.NODE_ENV) {
		const guid = new Guid();

		guid.init();
	}

	console.log('%c🔥 ines a (http://inesa.fr) & 19h47 (https://19h47.fr) 🔥', 'padding:0.5em 1em;');

	//
	const register = new Register('.js-register');
	register.init();

	//
	const form = new FormBlock('.js-form');
	form.init();

	//
	const carousels = [...document.querySelectorAll('.js-carousel')];
	carousels.map(item => new Carousel(item).init());
})();
