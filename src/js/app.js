import GuidGuidBangBang from 'Common/GuidGuidBangBang';
import ElectronicSignature from 'Blocks/ElectronicSignature';
import animateScrollTo from 'animated-scroll-to';

(() => {
	if (process.env.NODE_ENV !== 'production') {
		const guid = new GuidGuidBangBang();

		guid.init();
	}

	//
	const electronicSignature = new ElectronicSignature('.js-electronic-signature');
	electronicSignature.init();

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
