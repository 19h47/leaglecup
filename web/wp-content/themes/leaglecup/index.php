<?php
/**
 * Index
 *
 * @package LeagleCup
 * @file    index.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

use Timber\Timber;

if ( ! class_exists( 'Timber' ) ) {
	echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
}

$context = Timber::context();

$context['post']       = new TimberPost();
$context['node_type']  = 'default-page';
$context['body_class'] = 'index';

$templates = array( 'index.html.twig' );

Timber::render( $templates, $context );
