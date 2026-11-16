<?php
/**
 * Utilities
 *
 * PHP version 7.2.10
 *
 * @category Utilities
 * @package  LeagleCup
 * @author   Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://19h47.fr
 */

/**
 * Get theme manifest
 *
 * @return bool|array
 */
function get_theme_manifest() {
	$file = get_template_directory() . '/dist/manifest.json';

	return json_decode( file_get_contents( $file ), true ); // phpcs:ignore
}


/**
 * Retrieve the name of the theme.
 *
 * @since  1.0.0
 * @return string The name of the theme.
 */
function get_theme_name() : string {
	return wp_get_theme()->Name;
}


/**
 * Retrieve the text domain.
 *
 * @since  1.0.0
 * @return string The text domain.
 */
function get_theme_text_domain() : string {
	return wp_get_theme()->get( 'TextDomain' );
}
