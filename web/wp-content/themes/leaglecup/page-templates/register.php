<?php
/**
 * Template Name: Register
 *
 * @package LeagleCup
 * @file    page-templates/register.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

if ( ! class_exists( 'Timber' ) ) {
	echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
}

$context = Timber::get_context();

$context['post']       = new TimberPost();
$context['node_type']  = 'default-page';
$context['body_class'] = 'Register-page';

$templates = array( 'pages/register-page.html.twig' );

Timber::render( $templates, $context );
