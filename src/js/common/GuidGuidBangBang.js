/**
 * @file    common/GuidGuidBangBang.js
 * @type    class
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (htpp://19h47.fr)
 */
export default class GuidGuidBangBang {
	constructor() {
		this.$cont = null;
		this.class = 'd-none';

		document.body.appendChild(GuidGuidBangBang.render(12));
	}

	init() {
		return this.initEvents();
	}

	initEvents() {
		document.addEventListener('keydown', (e) => {
			this.$cont = document.querySelector('.js-guid');
			if ((e.metaKey || e.ctrlKey) && 186 === e.keyCode) {
				this.toggle();
			}
		});
	}

	toggle() {
		if (this.$cont.classList.contains(this.class)) {
			return this.hide();
		}
		return this.show();
	}

	hide() {
		return this.$cont.classList.remove(this.class);
	}

	show() {
		return this.$cont.classList.add(this.class);
	}

	/**
	 * Render
	 *
	 * @param  int columns Column number.
	 * @return div
	 */
	static render(columns) {
		const div = document.createElement('div');
		const column = index => `
			<div class="col-1 text-align-center h-100">
				<div class="Guid__column text-align-xs-center">${index}</div>
			</div>
		`;
		let inner = '';

		div.className = 'Guid js-guid d-none';

		for (let i = 1; i <= columns; i += 1) {
			inner += column(i);
		}
		div.innerHTML = `<div class="Site-container h-100"><div class="row h-100">${inner}</div></div>`;
		return div;
	}
}
