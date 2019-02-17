<?php

/**
 * Partners
 *
 * @package     LeagleCup
 * @file 		partners.php
 * @author      Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

// Grab context
$context = Timber::get_context();

// Get terms
$context['terms'] = Timber::get_terms(
    array(
        'taxonomy'      => 'partner_category',
        'hide_empty'    => true,
        'meta_key'      => 'partner_category_order',
        'orderby'       => 'meta_value_num',
        'order'         => 'ASC',
    )
);

Timber::render( 'common/partners.html.twig', $context );
