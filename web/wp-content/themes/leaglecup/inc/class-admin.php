<?php
/**
 * Class Admin
 *
 * PHP version 7
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @package LeagleCup
 */

/**
 * Admin class
 */
class Admin {

	/**
	 * The unique identifier of this theme.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string
	 * @param str $thme_name    The string used to uniquely identify this theme.
	 */
	protected $theme_name;


	/**
	 * The version of the theme.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string
	 * @param str $version    The current version of this theme.
	 */
	private $theme_version;


	/**
	 * Construct function
	 *
	 * @access public
	 * @param str $theme_name The theme name.
	 * @param str $theme_version The theme version.
	 */
	public function __construct( $theme_name, $theme_version ) {
		add_filter( 'admin_footer_text', array( $this, 'set_admin_footer_text' ) );
	}


	/**
	 * Set admin footer text
	 *
	 * @link   https://developer.wordpress.org/reference/hooks/admin_footer_text/
	 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
	 * @access public
	 * @return str
	 */
	public function set_admin_footer_text() {
		return 'Thank you for creating with <a href="http://www.inesa.fr/" target="_blank">ines a</a> and <a href="http://www.19h47.fr/" target="_blank">19h47</a>. 🔥';
	}
}
