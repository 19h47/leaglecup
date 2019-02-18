<?php
/**
 * Prices
 *
 * @package LeagleCup
 * @file    prices.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

// Grab context.
$context = Timber::get_context();

// Get terms.
$context['prices'] = Timber::get_posts(
	array(
		'post_type'      => 'price',
		'posts_per_page' => -1,
	)
);

Timber::render( 'common/prices.html.twig', $context );
