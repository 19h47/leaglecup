<?php // phpcs:ignore
/**
 * Class Admin
 *
 * PHP version 7
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @package LeagleCup
 */

namespace LeagleCup\Setup;

/**
 * Admin class
 */
class Admin {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_filter( 'admin_footer_text', array( $this, 'set_admin_footer_text' ) );
	}


	/**
	 * Set admin footer text
	 *
	 * @link   https://developer.wordpress.org/reference/hooks/admin_footer_text/
	 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
	 * @access public
	 * @return string
	 */
	public function set_admin_footer_text() {
		return 'Thank you for creating with <a href="http://www.inesa.fr/" target="_blank">ines a</a> and <a href="http://www.19h47.fr/" target="_blank">19h47</a>. 🔥';
	}
}
