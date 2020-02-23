import 'core-js/stable';
import 'regenerator-runtime/runtime';

import GuidGuidBangBang from 'Common/GuidGuidBangBang';
import Command from 'Blocks/Command';
import Form from 'Blocks/Form';
import Carousel from 'Blocks/Carousel';

(() => {
	if ('production' !== process.env.NODE_ENV) {
		const guid = new GuidGuidBangBang();

		guid.init();
	}

	//
	const command = new Command('.js-electronic-signature');
	command.init();

	//
	const form = new Form('.js-form');
	form.init();

	//
	const carousels = [...document.querySelectorAll('.js-carousel')];
	carousels.map(item => new Carousel(item).init());
})();
