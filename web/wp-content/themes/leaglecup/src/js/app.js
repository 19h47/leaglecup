import GuidGuidBangBang from 'Common/GuidGuidBangBang';
import ElectronicSignature from 'Blocks/ElectronicSignature';
import Form from 'Blocks/Form';
import animateScrollTo from 'animated-scroll-to';

(() => {
	if ('production' !== process.env.NODE_ENV) {
		const guid = new GuidGuidBangBang();

		guid.init();
	}

	//
	const electronicSignature = new ElectronicSignature('.js-electronic-signature');
	electronicSignature.init();

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
