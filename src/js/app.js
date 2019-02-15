import { name, version, repository } from '@/../package.json';
import Guid from 'Common/Guid';

console.log(`%c${name}@${version} – ${repository.url}`, 'color: #6a6a6a');

(() => {
	const guid = new Guid();

	guid.init();
})();
