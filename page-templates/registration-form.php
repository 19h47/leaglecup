<?php
/**
 * Template Name: Registration Form
 *
 * @package LeagleCup
 * @file    page-templates/registration.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

use Timber\{ Post, Helper };

$context = Timber::get_context();

$context['post']       = new Post();
$context['node_type']  = 'default-page';
$context['body_class'] = 'Registration-form-page';
$context['nonce']      = Helper::ob_function( 'wp_nonce_field', array( 'registration-form', 'registration-form-verification' ) );

$context['price'] = Timber::get_post( get_field( 'price', $context['post']->id ) );

$templates = array( 'pages/registration-form-page.html.twig' );

Timber::render( $templates, $context );
