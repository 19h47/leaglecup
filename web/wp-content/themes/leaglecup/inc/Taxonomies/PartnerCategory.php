<?php
/**
 * Class Partner Category
 *
 * PHP version 7
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @package LeagleCup
 */

namespace LeagleCup\Taxonomies;

/**
 * Partner category tag class
 */
class PartnerCategory {

	/**
	 * The version of the theme.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this theme.
	 */
	private $theme_version;


	/**
	 * Construct function
	 *
	 * @param str $theme_version The theme version.
	 * @access public
	 */
	public function __construct( $theme_version ) {
		$this->theme_version = $theme_version;

		add_action( 'init', array( $this, 'register_taxonomy' ) );

		add_action( 'manage_edit-partner_category_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_partner_category_custom_column', array( $this, 'render_custom_columns' ), 10, 3 );

		add_action( 'edited_partner_category', array( $this, 'edited' ), 10, 2 );
	}


	/**
	 * Register Custom Taxonomy
	 *
	 * @return void
	 */
	public function register_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Categories', 'Partner category General Name', 'leaglecup' ),
			'singular_name'              => _x( 'Category', 'Partner category Singular Name', 'leaglecup' ),
			'menu_name'                  => __( 'Categories', 'leaglecup' ),
			'all_items'                  => __( 'Toutes les catégories', 'leaglecup' ),
			'parent_item'                => __( 'Catégorie parente', 'leaglecup' ),
			'parent_item_colon'          => __( 'Catégorie parente :', 'leaglecup' ),
			'new_item_name'              => __( 'Nom de la nouvelle catégorie', 'leaglecup' ),
			'add_new_item'               => __( 'Ajouter une nouvelle catégorie', 'leaglecup' ),
			'edit_item'                  => __( 'Éditer la catégorie', 'leaglecup' ),
			'update_item'                => __( 'Mettre à jour la catégorie', 'leaglecup' ),
			'view_item'                  => __( 'Voir la catégorie', 'leaglecup' ),
			'separate_items_with_commas' => __( 'Séparer les catégories par des virgules', 'leaglecup' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer une catégorie', 'leaglecup' ),
			'choose_from_most_used'      => __( 'Choisir parmi les catégories les plus utilisées', 'leaglecup' ),
			'popular_items'              => __( 'Catégorie populaire', 'leaglecup' ),
			'search_items'               => __( 'Catégories recherchées', 'leaglecup' ),
			'not_found'                  => __( 'Aucune catégorie n\'a été trouvée', 'leaglecup' ),
			'no_terms'                   => __( 'Pas de catégorie', 'leaglecup' ),
			'items_list'                 => __( 'Liste des catégories', 'leaglecup' ),
			'items_list_navigation'      => __( 'Liste de navigation des catégories', 'leaglecup' ),
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
				$new_columns['order'] = __( 'Ordre' );
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
