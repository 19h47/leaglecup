// import { name, version, repository } from '@/../package.json';
import GuidGuidBangBang from 'Common/GuidGuidBangBang';
import animateScrollTo from 'animated-scroll-to';

// console.log(`%c${name}@${version} – ${repository.url}`, 'color: #6a6a6a');

(() => {
	if (process.env.NODE_ENV !== 'production') {
		const guid = new GuidGuidBangBang();

		guid.init();
	}

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
