/**
 * Navigation next
 *
 * @param	obj 	slider Flickity instance
 * @access	static
 * @author	Jérémy Levron <jeremylevron@19h47.fr>
 * @return	method 	Flickity next method
 */
export function next(slider) {
	return slider.next();
}

/**
 * Navigation previous
 *
 * @param	obj 	slider Flickity instance
 * @access	static
 * @author	Jérémy Levron <jeremylevron@19h47.fr>
 * @return	method 	Flickity previous method
 */
export function previous(slider) {
	return slider.previous();
}

/**
 * Select
 *
 * @param obj slider     Flickity instance
 * @param str value      Zero-based index OR selector string of the cell to
 *                       select.
 * @param bool isWrapped Optional. If true, the last slide will be
 *                       selected if at the first slide.
 * @param bool isInstant If true, immediately view the selected slide without
 *                       animation.
 */
export function select(slider, value, isWrapped = false, isInstant = false) {
	return slider.selectCell(value, isWrapped, isInstant);
}

/**
 * Options object
 *
 * Default options, use a Object.asign to merge with other option
 */
export const options = {
	contain: true,
	groupCells: 1,
	pageDots: false,
	prevNextButtons: false,
	cellSelector: '.js-item',
};
