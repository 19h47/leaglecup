<?php
/**
 * Get partners
 *
 * @package LeagleCup
 */

/**
 * Get partners
 *
 * Get the partners
 *
 * @return $transient
 */
function get_partners() {
	$transient = get_transient( 'leaglecup_partners' );

	if ( $transient ) {
		return $transient;
	}

	$partners = Timber::get_terms(
		array(
			'taxonomy'   => 'partner_category',
			'hide_empty' => true,
			'meta_key'   => 'partner_category_order', // phpcs:ignore
			'orderby'    => 'meta_value_num',
			'order'      => 'ASC',
		)
	);

	set_transient( 'leaglecup_partners', $partners, DAY_IN_SECONDS );

	return $transient;
}
