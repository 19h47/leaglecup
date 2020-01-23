<?php // phpcs:ignore
/**
 * Class Member
 *
 * PHP version 7
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @package LeagleCup
 */

namespace LeagleCup\PostTypes;

/**
 * Member class
 *
 * @file   inc/post-types/class-partner.php
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */
class Member {

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
	 * @param string $theme_version The theme version.
	 * @access public
	 */
	public function __construct( string $theme_version ) {
		$this->theme_version = $theme_version;

		$this->register_post_type();

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'admin_head', array( $this, 'css' ) );

		add_filter( 'manage_member_posts_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_member_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );
	}


	/**
	 * Register Custom Post Type
	 *
	 * @access public
	 */
	public function register_post_type() {
		$labels = array(
			'name'                  => _x( 'Membres', 'Personne pluriel', 'leaglecup' ),
			'singular_name'         => _x( 'Membre', 'Personne singulier', 'leaglecup' ),
			'menu_name'             => __( 'Membres', 'leaglecup' ),
			'name_admin_bar'        => __( 'Membre', 'leaglecup' ),
			'parent_item_colon'     => __( 'Membres Parents :', 'leaglecup' ),
			'all_items'             => __( 'Touts les membres', 'leaglecup' ),
			'add_new_item'          => __( 'Ajouter un membre', 'leaglecup' ),
			'add_new'               => __( 'Ajouter', 'leaglecup' ),
			'new_item'              => __( 'Nouveau membre', 'leaglecup' ),
			'edit_item'             => __( 'Modifier le membre', 'leaglecup' ),
			'update_item'           => __( 'Mettre à jour le membre', 'leaglecup' ),
			'view_item'             => __( 'Voir le membre', 'leaglecup' ),
			'view_items'            => __( 'Voir les membres', 'leaglecup' ),
			'search_items'          => __( 'Chercher parmi les membres', 'leaglecup' ),
			'not_found'             => __( 'Aucun membre n\'a été trouvé.', 'leaglecup' ),
			'not_found_in_trash'    => __( 'Aucun membre n\'a été trouvé dans la corbeille.', 'leaglecup' ),
			'featured_image'        => __( 'Image à la une', 'leaglecup' ),
			'set_featured_image'    => __( 'Mettre une image à la une', 'leaglecup' ),
			'remove_featured_image' => __( 'Retirer l\'image mise à la une', 'leaglecup' ),
			'use_featured_image'    => __( 'Mettre une image à la une', 'leaglecup' ),
			'insert_into_item'      => __( 'Insérer dans le membre', 'leaglecup' ),
			'uploaded_to_this_item' => __( 'Téléversé sur ce membre', 'leaglecup' ),
			'items_list'            => __( 'Liste des membres', 'leaglecup' ),
			'items_list_navigation' => __( 'Navigation de la liste des membres', 'leaglecup' ),
			'filter_items_list'     => __( 'Filtrer la liste des membres', 'leaglecup' ),
		);

		$rewrite = array(
			'slug'       => __( 'member', 'leaglecup' ),
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'membre',
			'description'         => __( 'Les membres', 'leaglecup' ),
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
			'rest_base'           => 'members',
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-groups',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'member', $args );
	}


	/**
	 * Add custom columns
	 *
	 * @param array $columns Array of columns.
	 * @link https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/
	 */
	public function add_custom_columns( array $columns ) {

		$new_columns = array();

		foreach ( $columns as $key => $value ) {
			if ( 'title' === $key ) {
				$new_columns['thumbnail'] = __( 'Thumbnail' );
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
	 */
	public function render_custom_columns( string $column_name, int $post_id ) {
		switch ( $column_name ) {
			case 'thumbnail':
				if ( get_the_post_thumbnail( $post_id ) ) {
					echo '<a href="' . esc_attr( get_edit_post_link( $post_id ) ) . '">';
					the_post_thumbnail( 'full' );
					echo '</a>';
				} else {
					echo '—';
				}

				break;
		}
	}


	/**
	 * CSS
	 *
	 * @access public
	 */
	public function css() {
		global $typenow;

		if ( 'member' !== $typenow ) {
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
				object-fit: cover;
				object-position: center;
			}
		</style>
		<?php

		return true;
	}
}
