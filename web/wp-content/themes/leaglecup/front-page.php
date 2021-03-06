<?php
/**
 * Front page
 *
 * PHP version 7.2.10
 *
 * @package LeagleCup
 * @file    front-page.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

use Timber\{ Timber, Post };

if ( ! class_exists( 'Timber' ) ) {
	echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
}

$context = Timber::context();

$context['post']       = new Post();
$context['node_type']  = 'default-page';
$context['body_class'] = 'index';

$templates = array( 'pages/front-page.html.twig' );

Timber::render( $templates, $context );
