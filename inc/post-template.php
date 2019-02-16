<?php

// Apply filter
add_filter( 'body_class', 'custom_body_class' );

function custom_body_class( $classes ) {

	// Home
	if ( is_front_page() ) {
		$classes[] = 'Front-page';
	}

	return $classes;
}
