import GuidGuidBangBang from 'Common/GuidGuidBangBang';
import Command from 'Blocks/Command';
import Form from 'Blocks/Form';

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
})();
