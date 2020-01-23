<?php
/**
 * Contact
 *
 * PHP version 7.2.10
 *
 * @category Contact
 * @package  LeagleCup
 * @author   Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/19h47/leaglecup
 */

/**
 * Contact
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function leaglecup_customize_contact( $wp_customize ) {

	// Add contact section.
	$wp_customize->add_section(
		'contact',
		array(
			'title'       => __( 'Coordonnées' ),
			'description' => __( 'Réglages des coordonnées' ),
		)
	);

	// Facebook.
	$wp_customize->add_setting(
		'facebook',
		array(
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'facebook',
		array(
			'label'       => __( 'Facebook' ),
			'description' => __( 'Indiquer l\'URL du compte Facebook' ),
			'section'     => 'contact',
			'settings'    => 'facebook',
		)
	);

	// LinkedIn.
	$wp_customize->add_setting(
		'linkedin',
		array(
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'linkedin',
		array(
			'label'       => __( 'LinkedIn' ),
			'description' => __( 'Indiquer l\'URL du compte LinkedIn' ),
			'section'     => 'contact',
			'settings'    => 'linkedin',
		)
	);


	// Email.
	$wp_customize->add_setting(
		'email',
		array(
			'type'      => 'option',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'email',
		array(
			'label'       => __( 'Email' ),
			'description' => __( 'Indiquer l\'adresse mail du site' ),
			'section'     => 'contact',
			'settings'    => 'email',
		)
	);
}
