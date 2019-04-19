import GuidGuidBangBang from 'Common/GuidGuidBangBang';
import Command from 'Blocks/Command';
import Form from 'Blocks/Form';
import animateScrollTo from 'animated-scroll-to';

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

	// Scroll to button
	const buttons = document.querySelectorAll('.js-scroll-to');

	for (let i = 0; i < buttons.length; i += 1) {
		const target = buttons[i].getAttribute('data-target');
		const $el = document.getElementById(target);

		buttons[i].addEventListener('click', () => {
			animateScrollTo($el);
		});
	}
})();
