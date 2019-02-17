// import { name, version, repository } from '@/../package.json';
import GuidGuidBangBang from 'Common/GuidGuidBangBang';

// console.log(`%c${name}@${version} – ${repository.url}`, 'color: #6a6a6a');

(() => {
	const guid = new GuidGuidBangBang();

	guid.init();
})();
