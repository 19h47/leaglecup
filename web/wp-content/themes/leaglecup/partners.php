<?php
/**
 * Partners
 *
 * @package LeagleCup
 * @file    partners.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

 use LeagleCup\Core\{ Transients };

// Grab context.
$context = Timber::context();

// Get terms.
$context['terms'] = Transients::partners();

Timber::render( 'common/partners.html.twig', $context );
