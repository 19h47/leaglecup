<?php // phpcs:ignore
/**
 * Init
 *
 * @package WordPress
 * @subpackage LeagleCup/Plugins/ACF
 */

namespace LeagleCup\Plugins\ACF;

/**
 * Init
 */
class Init {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'acf/init', array( $this, 'add_options_theme' ) );
	}

	/**
	 * Add options pages
	 */
	public function add_options_theme() {
		$parent = acf_add_options_sub_page(
			array(
				'page_title'  => __( 'Message Settings', 'leaglecup' ),
				'menu_title'  => __( 'Settings', 'leaglecup' ),
				'menu_slug'   => 'message-settings',
				'parent_slug' => 'edit.php?post_type=message',
			)
		);
	}
}
