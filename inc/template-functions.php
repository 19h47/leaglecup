<?php
/**
 * Additional features to allow styling of the templates
 *
 * PHP version 7.2.10
 *
 * @package  LeagleCup
 * @since    1.0.0
 * @license
 */

add_filter( 'body_class', 'custom_body_class' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param  array $classes Classes for the body element.
 * @return array
 */
function custom_body_class( $classes ) {

	// Home.
	if ( is_front_page() ) {
		$classes[] = 'Front-page';
	}

	if ( ! is_front_page() ) {
		$classes[] = 'Page';
	}

	return $classes;
}
