<?php // phpcs:ignore
/**
 * LEAGLE CUP functions and definitions
 *
 * PHP version 7.2.10
 *
 * @package LeagleCup
 * @since   1.0.0
 * @link    https://github.com/19h47/leaglecup
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @see     https://developer.wordpress.org/themes/basics/theme-functions/
 */

require_once get_template_directory() . '/vendor/autoload.php';

use LeagleCup\App as App;

new App( 'leaglecup', wp_get_theme()->Version ); // phpcs:ignore
