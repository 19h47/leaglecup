<?php
/**
 * Index
 *
 * @package LeagleCup
 * @file    index.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */

use Timber\{ Timber, Post };

$context = Timber::context();

$context['post']       = new Post();
$context['node_type']  = 'default-page';
$context['body_class'] = 'index';

$templates = array( 'index.html.twig' );

Timber::render( $templates, $context );
