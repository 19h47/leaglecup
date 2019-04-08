import Scroll from 'Utils/Scroll';
import { $body } from 'Utils/environment';

/**
 * @file    js/common/Menu.js
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class Menu {
	constructor() {
		// console.info('Menu.constructor');

		this.buttons = document.querySelectorAll('.js-menu-button');
		this.isOpen = $body.classList.contains('menu--is-open');

		this.$cont = null;

		// Scroll
		this.disableScroll = Scroll.disableScroll;
		this.enableScroll = Scroll.enableScroll;
	}


	init() {
		this.$cont = document.querySelector('.js-menu');
		this.buttons = document.querySelectorAll('.js-menu-button');

		return this.initEvents();
	}


	/**
	 * Menu.initEvents
	 */
	initEvents() {
		// console.info('Menu.setupEvents');

		// On click
		[...this.buttons].forEach((button) => {
			button.addEventListener('click', () => this.toggle());
		});

		// On esc key
		document.onkeydown = (event) => {
			if (event.keyCode === 27) {
				this.close();
			}
		};
	}


	/**
	 * Menu.toggle
	 */
	toggle() {
		// console.info('Menu.toggle');
		if (this.isOpen) return this.close();

		return this.open();
	}


	/**
	 * Menu.open
	 */
	open() {
		// console.info('Menu.open');
		if (this.isOpen) return false;

		this.isOpen = true;

		$body.classList.add('menu--is-open');

		// When menu is open, disableScroll
		this.disableScroll();

		return true;
	}


	/**
	 * Menu.close
	 */
	close() {
		// console.info('Menu.close');
		if (!this.isOpen) return false;

		this.isOpen = false;

		$body.classList.remove('menu--is-open');

		// When menu is closed, enableScroll
		this.enableScroll();

		return true;
	}
}
