<?php
/**
 * Utilities
 *
 * PHP version 7.2.10
 *
 * @category Utilities
 * @package  lglcp
 * @author   Jérémy Levron <jeremylevron@19h47.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://19h47.fr
 */

if ( ! function_exists( 'get_html_class' ) ) :

	/**
	 * Retrieve the classes for the html element as an array.
	 *
	 * @param  string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_html_class( $class = '' ) {
		$classes = array();
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );
		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}
		$classes = array_map( 'esc_attr', $classes );
		/**
		 * Filter the list of CSS html classes for the current post or page.
		 *
		 * @param array  $classes An array of html classes.
		 * @param string $class   A comma-separated list of additional classes added to the html.
		 */
		$classes = apply_filters( 'html_class', $classes, $class );

		return array_unique( $classes );
	}
endif;


if ( ! function_exists( 'html_class' ) ) :

	/**
	 * Display the classes for the html element.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function html_class( $class = '' ) {
		// Separates classes with a single space, collates classes for html element.
		return 'class="' . join( ' ', get_html_class( $class ) ) . '"';
	}
endif;

if ( ! function_exists( 'get_theme_manifest' ) ) :

	/**
	 * Get theme manifest
	 *
	 * @return arr
	 */
	function get_theme_manifest() {
		$request = wp_remote_get( get_template_directory_uri() . '/dist/manifest.json' );

		return json_decode( wp_remote_retrieve_body( $request ), true );
	}

endif;
