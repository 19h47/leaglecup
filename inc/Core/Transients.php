<?php // phpcs:ignore
/**
 * Class Transients
 *
 * @package LeagleCup
 * @subpackage LeagleCup/Core
 */

namespace LeagleCup\Core;

use Timber\{ Timber };

/**
 * Transients class
 */
class Transients {

	/**
	 * Posts
	 *
	 * @return array $transient
	 */
	public static function posts() : array {
		$transient = get_transient( 'leaglecup_posts' );

		if ( $transient ) {
			return $transient;
		}

		$posts = Timber::get_posts(
			array(
				'post_type'      => 'post',
				'posts_per_page' => -1,
				'no_found_rows'  => true,
			),
		);

		set_transient( 'leaglecup_posts', $posts );

		return $posts;
	}


	/**
	 * Partners
	 *
	 * @return array $transient
	 */
	public static function partners() : array {
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

		return $partners;
	}
}
