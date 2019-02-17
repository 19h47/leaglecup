<?php

/*
 * Template Name: Prices
 *
 * @package  	LeagleCup
 * @file 		prices.php
 * @author   	Jérémy Levron <levronjeremy@19h47.fr> (http://19h47.fr)
 */
if ( ! class_exists( 'Timber' ) ) {
	echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
}

$context = Timber::get_context();
$post = new TimberPost();

$context['post'] = $post;
$context['node_type'] = 'prices';
$context['body_class'] = 'Prices';

$templates = array( 'pages/prices.html.twig' );

Timber::render( $templates, $context );
