import 'core-js/stable';
import 'regenerator-runtime/runtime';

import Guid from 'Common/Guid';
import Command from 'Blocks/Command';
import Form from 'Blocks/Form';
import Carousel from 'Blocks/Carousel';

(() => {
	if ('production' !== process.env.NODE_ENV) {
		const guid = new Guid();

		guid.init();
	}

	//
	const command = new Command('.js-command');
	command.init();

	//
	const form = new Form('.js-form');
	form.init();

	//
	const carousels = [...document.querySelectorAll('.js-carousel')];
	carousels.map(item => new Carousel(item).init());
})();
