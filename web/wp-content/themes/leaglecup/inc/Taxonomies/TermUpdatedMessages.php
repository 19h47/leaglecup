<?php // phpcs:ignore
/**
 * Class TermUpdatedMessages
 *
 * PHP version 7.3.8
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @package leaglecup
 */

namespace LeagleCup\Taxonomies;

/**
 * Department
 */
class TermUpdatedMessages {

	/**
	 * Construct function
	 *
	 * @param string $theme_version The theme version.
	 * @access public
	 * @return void
	 */
	public function __construct( string $theme_version ) {
		add_filter( 'term_updated_messages', array( $this, 'updated_messages' ), 10, 1 );
	}


	/**
	 * Agency service updated messages
	 *
	 * @param array $messages The messages to be displayed.
	 * @access public
	 * @return $messages
	 */
	public function updated_messages( array $messages ) : array {

		$messages['partner_category'] = array(
			1 => __( 'Category added.', 'leaglecup' ),
			2 => __( 'Category deleted.', 'leaglecup' ),
			3 => __( 'Category updated.', 'leaglecup' ),
			4 => __( 'Category not added.', 'leaglecup' ),
			5 => __( 'Category not updated.', 'leaglecup' ),
			6 => __( 'Category deleted.', 'leaglecup' ),
		);

		return $messages;
	}
}
