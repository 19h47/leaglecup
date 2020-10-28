<?php // phpcs:ignore
/**
 * Class Partner Category
 *
 * PHP version 7
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @package LeagleCup
 */

namespace LeagleCup\Core;

/**
 * Partner category tag class
 */
class PartnerCategory {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ) );

		add_action( 'manage_edit-partner_category_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_partner_category_custom_column', array( $this, 'render_custom_columns' ), 10, 3 );

		add_action( 'edited_partner_category', array( $this, 'edited' ), 10, 2 );
	}


	/**
	 * Register Custom Taxonomy
	 *
	 * @return void
	 */
	public function register() {

		$labels = array(
			'name'                       => _x( 'Categories', 'partner category general name', 'leaglecup' ),
			'singular_name'              => _x( 'Category', 'partner category Singular name', 'leaglecup' ),
			'search_items'               => __( 'Search Categories', 'leaglecup' ),
			'all_items'                  => __( 'All Categories', 'leaglecup' ),
			'popular_items'              => __( 'Popular Categories', 'leaglecup' ),
			'parent_item'                => __( 'Parent Category', 'leaglecup' ),
			'parent_item_colon'          => __( 'Parent Category :', 'leaglecup' ),
			'edit_item'                  => __( 'Edit Category', 'leaglecup' ),
			'view_item'                  => __( 'View Category', 'leaglecup' ),
			'update_item'                => __( 'Update Category', 'leaglecup' ),
			'add_new_item'               => __( 'Add New Category', 'leaglecup' ),
			'new_item_name'              => __( 'New Category Name', 'leaglecup' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'leaglecup' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'leaglecup' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories', 'leaglecup' ),
			'not_found'                  => __( 'No categories found.', 'leaglecup' ),
			'no_terms'                   => __( 'No categories', 'leaglecup' ),
			'items_list'                 => __( 'Categories list navigation', 'leaglecup' ),
			'items_list_navigation'      => __( 'Categories list', 'leaglecup' ),
			/* translators: City heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'partner category', 'leaglecup' ),
			'back_to_items'              => __( '&larr; Back to Categories', 'leaglecup' ),
		);

		$args = array(
			'labels'             => $labels,
			'hierarchical'       => false,
			'meta_box_cb'        => false,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_tagcloud'      => true,
			'show_in_quick_edit' => false,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
		);
		register_taxonomy( 'partner_category', array( 'partner' ), $args );
	}


	/**
	 * Add custom columns
	 *
	 * @param arr $columns The columns.
	 */
	public function add_custom_columns( $columns ) {

		$new_columns = array();

		foreach ( $columns as $key => $value ) {
			if ( 'posts' === $key ) {
				$new_columns['order'] = __( 'Order', 'leaglecup' );
			}
			$new_columns[ $key ] = $value;
		}

		return $new_columns;
	}


	/**
	 * Render custom columns
	 *
	 * @param str $content The content.
	 * @param str $column_name The column name.
	 * @param int $term_id The term ID.
	 */
	public function render_custom_columns( $content, $column_name, $term_id ) {

		switch ( $column_name ) {

			case 'order':
				$order = get_field( 'partner_category_order', 'partner_category_' . $term_id );
				$html  = '';

				if ( null !== $order ) {
					$html = (int) $order;
				} else {
					$html = '—';
				}

				return $html;
		}
	}


	/**
	 * Edited
	 *
	 * Fires once a partner category has been edited.
	 *
	 * @param int $term_id Term ID.
	 * @param int $tt_id Term taxonomy ID.
	 * @link https://developer.wordpress.org/reference/hooks/save_post_post-post_type/
	 * @access public
	 */
	public function edited( int $term_id, int $tt_id ) {
		delete_transient( 'leaglecup_partners' );
	}
}
