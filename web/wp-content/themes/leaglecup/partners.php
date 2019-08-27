<?php
/**
 * Partners
 *
 * @package LeagleCup
 * @file    partners.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

// Grab context.
$context = Timber::context();

// Get terms.
$context['terms'] = get_transient( 'leaglecup_partners' );

Timber::render( 'common/partners.html.twig', $context );
