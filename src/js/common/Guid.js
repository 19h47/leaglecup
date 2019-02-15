/**
 * @file    common/guid.js
 * @type    class
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (htpp://19h47.fr)
 */
export default class Guid {
	constructor() {
		this.$cont = null;
		this.class = 'd-none';
	}

	init() {
		// if (this.$cont === null || this.$cont === undefined) {
		// 	return false;
		// }
		return this.initEvents();
	}

	initEvents() {
		// show/hide guides with CMD+;
		document.addEventListener('keydown', (e) => {
			this.$cont = document.querySelector('.js-guid');
			if ((e.metaKey || e.ctrlKey) && e.keyCode === 186) {
				this.toggle();
			}
		});
	}

	toggle() {
		// console.info('Guid.toggle');

		if (this.$cont.classList.contains(this.class)) {
			return this.hide();
		}
		return this.show();
	}

	hide() {
		this.$cont.classList.remove(this.class);
	}

	show() {
		this.$cont.classList.add(this.class);
	}
}
