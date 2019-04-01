<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  LeagleCup
 * @since    Timber 0.1
 * @file    index.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
$context = Timber::context();

$context['node_type']  = 'default-page';
$context['body_class'] = '404';

Timber::render( 'pages/404.html.twig', $context );
