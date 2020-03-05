<?php
/**
 * Link
 *
 * PHP version 7.2.10
 *
 * @category Link
 * @package  LeagleCup
 * @author   Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/19h47/leaglecup
 */

/**
 * Link
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function leaglecup_customize_link( $wp_customize ) {

	/**
	 * Add contact section
	 */
	$wp_customize->add_section(
		'link',
		array(
			'capability'  => 'edit_theme_options',
			'description' => __( 'Pages Settings', 'leaglecup' ),
			'title'       => __( 'Pages Links', 'leaglecup' ),
		)
	);

	// Legal mentions.
	$wp_customize->add_setting(
		'legal_mentions',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'legal_mentions',
		array(
			'description' => __( 'Indicate the Legal Notice page', 'leaglecup' ),
			'label'       => __( 'Legal Notice', 'leaglecup' ),
			'section'     => 'link',
			'type'        => 'dropdown-pages',
		)
	);
}
