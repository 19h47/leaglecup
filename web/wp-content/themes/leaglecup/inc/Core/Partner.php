<?php // phpcs:ignore
/**
 * Class Partner
 *
 * PHP version 7
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @package LeagleCup
 */

namespace LeagleCup\Core;

use WP_Post;

/**
 * Partner class
 *
 * @file   inc/post-types/class-partner.php
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */
class Partner {


	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ), 10, 0 );
		add_action( 'admin_head', array( $this, 'css' ) );

		add_filter( 'manage_partner_posts_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_partner_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );

		add_action( 'save_post_partner', array( $this, 'save' ), 10, 3 );
	}


	/**
	 * Save
	 *
	 * Fires once a partner has been saved.
	 *
	 * @param int     $post_id The post ID.
	 * @param WP_Post $post The post object.
	 * @param bool    $update Whether this is an existing post being updated or not.
	 * @link https://developer.wordpress.org/reference/hooks/save_post_post-post_type/
	 * @access public
	 */
	public function save( int $post_id, WP_Post $post, bool $update ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		delete_transient( 'leaglecup_partners' );
	}


	/**
	 * Register Custom Post Type
	 *
	 * @access public
	 * @return void
	 */
	public function register() : void {
		$labels = array(
			'name'                     => _x( 'Partners', 'partner type generale name', 'leaglecup' ),
			'singular_name'            => _x( 'Partner', 'partner type singular name', 'leaglecup' ),
			'add_new'                  => _x( 'Add New', 'partner type', 'leaglecup' ),
			'add_new_item'             => __( 'Add New Partner', 'leaglecup' ),
			'edit_item'                => __( 'Edit Partner', 'leaglecup' ),
			'new_item'                 => __( 'New Partner', 'leaglecup' ),
			'view_items'               => __( 'View Partners', 'leaglecup' ),
			'view_item'                => __( 'View Partner', 'leaglecup' ),
			'search_items'             => __( 'Search Partners', 'leaglecup' ),
			'not_found'                => __( 'No partners found.', 'leaglecup' ),
			'not_found_in_trash'       => __( 'No partners found in Trash.', 'leaglecup' ),
			'parent_item_colon'        => __( 'Parent Partner:', 'leaglecup' ),
			'all_items'                => __( 'All Partners', 'leaglecup' ),
			'archives'                 => __( 'Partner Archives', 'leaglecup' ),
			'attributes'               => __( 'Partner Attributes', 'leaglecup' ),
			'insert_into_item'         => __( 'Insert into partner', 'leaglecup' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this partner', 'leaglecup' ),
			'featured_image'           => _x( 'Featured Image', 'partner', 'leaglecup' ),
			'set_featured_image'       => _x( 'Set featured image', 'partner', 'leaglecup' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'partner', 'leaglecup' ),
			'use_featured_image'       => _x( 'Use as featured image', 'partner', 'leaglecup' ),
			'items_list_navigation'    => __( 'Partners list navigation', 'leaglecup' ),
			'items_list'               => __( 'Partners list', 'leaglecup' ),
			'item_published'           => __( 'Partner published.', 'leaglecup' ),
			'item_published_privately' => __( 'Partner published privately.', 'leaglecup' ),
			'item_reverted_to_draft'   => __( 'Partner reverted to draft.', 'leaglecup' ),
			'item_scheduled'           => __( 'Partner scheduled.', 'leaglecup' ),
			'item_updated'             => __( 'Partner updated.', 'leaglecup' ),
		);

		$rewrite = array(
			'slug'       => _x( 'partner', 'partner slug', 'leaglecup' ),
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'partenaire',
			'description'         => __( 'Partners', 'leaglecup' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail', 'editor' ),
			'taxonomies'          => array( 'partner_category' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'rest_base'           => 'partners',
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-universal-access',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => false,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'partner', $args );
	}


	/**
	 * CSS
	 *
	 * @access public
	 */
	public function css() {
		global $typenow;

		if ( 'partner' !== $typenow ) {
			return false;
		}

		?>
		<style>
			.fixed .column-thumbnail {
				vertical-align: top;
				width: 80px;
			}

			.column-thumbnail a {
				display: block;
			}
			.column-thumbnail a img {
				display: inline-block;
				vertical-align: middle;
				width: 80px;
				height: 80px;
				object-fit: contain;
				object-position: center;
			}
		</style>
		<?php

		return true;
	}


	/**
	 * Add custom columns
	 *
	 * @param array $columns Array of columns.
	 * @link https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/
	 * @access public
	 */
	public function add_custom_columns( array $columns ) {

		$new_columns = array();

		foreach ( $columns as $key => $value ) {
			if ( 'title' === $key ) {
				$new_columns['thumbnail'] = __( 'Thumbnail', 'leaglecup' );
			}

			$new_columns[ $key ] = $value;
		}
		return $new_columns;
	}


	/**
	 * Render custom columns
	 *
	 * @param string $column_name The column name.
	 * @param int    $post_id The ID of the post.
	 * @link https://developer.wordpress.org/reference/hooks/manage_post-post_type_posts_custom_column/
	 * @access public
	 */
	public function render_custom_columns( string $column_name, int $post_id ) {
		switch ( $column_name ) {
			case 'thumbnail':
				if ( get_the_post_thumbnail( $post_id ) ) {
					echo '<a href="' . esc_html( get_edit_post_link( $post_id ) ) . '">';
					the_post_thumbnail( 'full' );
					echo '</a>';
				} else {
					echo '—';
				}

				break;
		}
	}
}
