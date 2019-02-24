// import { name, version, repository } from '@/../package.json';
import GuidGuidBangBang from 'Common/GuidGuidBangBang';

// console.log(`%c${name}@${version} – ${repository.url}`, 'color: #6a6a6a');

(() => {
	if (process.env.NODE_ENV !== 'production') {
		const guid = new GuidGuidBangBang();

		guid.init();
	}
})();
