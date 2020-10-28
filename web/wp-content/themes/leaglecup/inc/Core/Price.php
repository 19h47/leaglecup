<?php // phpcs:ignore
/**
 * Class Price
 *
 * PHP version 7.2.10
 *
 * @category Price
 * @package  LeagleCup
 * @author   Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/19h47/leaglecup
 */

namespace LeagleCup\Core;

/**
 * Price class
 *
 * @file   inc/post-types/Price.php
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */
class Price {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ), 10, 0 );
	}


	/**
	 * Register Custom Post Type
	 *
	 * @access public
	 */
	public function register() {
		$labels = array(
			'name'                     => _x( 'Prices', 'price type generale name', 'leaglecup' ),
			'singular_name'            => _x( 'Price', 'price type singular name', 'leaglecup' ),
			'add_new'                  => _x( 'Add New', 'price type', 'leaglecup' ),
			'add_new_item'             => __( 'Add New Price', 'leaglecup' ),
			'edit_item'                => __( 'Edit Price', 'leaglecup' ),
			'new_item'                 => __( 'New Price', 'leaglecup' ),
			'view_item'                => __( 'View Price', 'leaglecup' ),
			'view_items'               => __( 'View Prices', 'leaglecup' ),
			'search_items'             => __( 'Search Prices', 'leaglecup' ),
			'not_found'                => __( 'No prices found.', 'leaglecup' ),
			'not_found_in_trash'       => __( 'No prices found in Trash.', 'leaglecup' ),
			'parent_item_colon'        => __( 'Parent Price :', 'leaglecup' ),
			'all_items'                => __( 'All Prices', 'leaglecup' ),
			'archives'                 => __( 'Price Archives', 'leaglecup' ),
			'attributes'               => __( 'Price Attributes', 'leaglecup' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this price', 'leaglecup' ),
			'insert_into_item'         => __( 'Insert into price', 'leaglecup' ),
			'featured_image'           => _x( 'Featured Image', 'price', 'leaglecup' ),
			'set_featured_image'       => _x( 'Set featured image', 'price', 'leaglecup' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'price', 'leaglecup' ),
			'use_featured_image'       => _x( 'Use as featured image', 'price', 'leaglecup' ),
			'items_list_navigation'    => __( 'Prices list navigation', 'leaglecup' ),
			'items_list'               => __( 'Prices list', 'leaglecup' ),
			'item_published'           => __( 'Price published.', 'leaglecup' ),
			'item_published_privately' => __( 'Price published privately.', 'leaglecup' ),
			'item_reverted_to_draft'   => __( 'Price reverted to draft.', 'leaglecup' ),
			'item_scheduled'           => __( 'Price scheduled.', 'leaglecup' ),
			'item_updated'             => __( 'Price updated.', 'leaglecup' ),
		);

		$rewrite = array(
			'slug'       => _x( 'price', 'price slug', 'leaglecup' ),
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'tarif',
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail' ),
			'taxonomies'          => array(),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'rest_base'           => 'prices',
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-star-filled',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'price', $args );
	}
}
