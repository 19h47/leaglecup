<?php

/**
 * Additional features to allow styling of the templates
 *
 * @package LeagleCup
 * @since 1.0.0
 */


add_filter( 'body_class', 'custom_body_class' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function custom_body_class( $classes ) {

	// Home
	if ( is_front_page() ) {
		$classes[] = 'Front-page';
	}

	return $classes;
}
