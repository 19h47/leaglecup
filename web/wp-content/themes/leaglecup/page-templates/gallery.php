<?php
/**
 * Template Name: Gallery
 *
 * @package LeagleCup
 * @file    page-templates/gallery.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */

use Timber\{ Timber, Post };

$context = Timber::context();

$context['post']       = new Post();
$context['node_type']  = 'default-page';
$context['body_class'] = 'Gallery-page';

$templates = array( 'index.html.twig' );

Timber::render( $templates, $context );
