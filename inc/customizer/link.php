<?php

/**
 * Link
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function lgcp_customize_link( $wp_customize ) {

	/**
	 * Add contact section
	 */
	$wp_customize->add_section(
		'link',
		array(
			'capability'	 => 'edit_theme_options',
			'description'	 => __( 'Réglages des pages' ),
			'title' 		 => __( 'Liens des pages' )
		)
	);


	/**
	 * Legal mentions
	 */
	$wp_customize->add_setting(
		'legal_mentions',
		array(
			'default'			=> '',
			'sanitize_callback' => 'absint'
		)
	);

	$wp_customize->add_control(
		'legal_mentions',
		array(
			'description'   => __( 'Indiquer la page Mentions légales' ),
			'label'         => __( 'Mentions légales' ),
			'section'       => 'link',
			'type'          => 'dropdown-pages'
	   )
	);
}
