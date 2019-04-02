<?php
/**
 * Plugin Name: Member posts
 * Plugin URI: https://wwww.github.com/leaglecup
 * Description: Gutenberg block for displaying Member posts
 * Version: 1.0.0
 * Author: Jérémy Levron
 * Author URI: http://wwww.19h47.fr
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages
 * Text Domain: member-posts
 *
 * @package LeagleCup
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * LIENS FICHIER PHP
 */
// Fichier de functions pour ACF.
require_once get_template_directory() . '/inc/block/member/functions.php';
