<?php
/**
 * Class Price
 *
 * PHP version 7.2.10
 *
 * @category Price
 * @package  lglcp
 * @author   Jérémy Levron <jeremylevron@19h47.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://19h47.fr
 */

/**
 * Price class
 *
 * @file   inc/post-types/Price.php
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
class Price {

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
	 * @access public
	 * @param str $theme_version Theme version.
	 */
	public function __construct( $theme_version ) {
		$this->theme_version = $theme_version;

		$this->register_post_type();

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'admin_head', array( $this, 'css' ) );

		add_filter( 'dashboard_glance_items', array( $this, 'at_a_glance' ) );
	}


	/**
	 * Register Custom Post Type
	 */
	public function register_post_type() {
		$labels = array(
			'name'                  => _x( 'Tarifs', 'Personne pluriel', 'lglcp' ),
			'singular_name'         => _x( 'Tarif', 'Personne singulier', 'lglcp' ),
			'menu_name'             => __( 'Tarifs', 'lglcp' ),
			'name_admin_bar'        => __( 'Tarif', 'lglcp' ),
			'parent_item_colon'     => __( 'Tarifs Parents :', 'lglcp' ),
			'all_items'             => __( 'Tous les tarifs', 'lglcp' ),
			'add_new_item'          => __( 'Ajouter un tarif', 'lglcp' ),
			'add_new'               => __( 'Ajouter', 'lglcp' ),
			'new_item'              => __( 'Nouveau tarif', 'lglcp' ),
			'edit_item'             => __( 'Modifier le tarif', 'lglcp' ),
			'update_item'           => __( 'Mettre à jour le tarif', 'lglcp' ),
			'view_item'             => __( 'Voir le tarif', 'lglcp' ),
			'view_items'            => __( 'Voir les tarifs', 'lglcp' ),
			'search_items'          => __( 'Chercher parmi les tarifs', 'lglcp' ),
			'not_found'             => __( 'Aucun tarif n\'a été trouvé.', 'lglcp' ),
			'not_found_in_trash'    => __( 'Aucun tarif n\'a été trouvé dans la corbeille.', 'lglcp' ),
			'featured_image'        => __( 'Image à la une', 'lglcp' ),
			'set_featured_image'    => __( 'Mettre une image à la une', 'lglcp' ),
			'remove_featured_image' => __( 'Retirer l\'image mise à la une', 'lglcp' ),
			'use_featured_image'    => __( 'Mettre une image à la une', 'lglcp' ),
			'insert_into_item'      => __( 'Insérer dans le tarif', 'lglcp' ),
			'uploaded_to_this_item' => __( 'Téléversé sur ce tarif', 'lglcp' ),
			'items_list'            => __( 'Liste des tarifs', 'lglcp' ),
			'items_list_navigation' => __( 'Navigation de la liste des tarifs', 'lglcp' ),
			'filter_items_list'     => __( 'Filtrer la liste des tarifs', 'lglcp' ),
		);

		$rewrite = array(
			'slug'       => __( 'price', 'lglcp' ),
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'tarif',
			'description'         => __( 'Les tarifs', 'lglcp' ),
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


	/**
	 * CSS
	 */
	public function css() {
		?>
		<style>
			#dashboard_right_now .price-count:before { content: "\f155"; }
		</style>
		<?php
	}

	/**
	 * "At a glance" items (dashboard widget): add the testimony.
	 *
	 * @param arr $items Array to items.
	 */
	public function at_a_glance( $items ) {
		$post_type   = 'price';
		$post_status = 'publish';
		$object      = get_post_type_object( $post_type );

		$num_posts = wp_count_posts( $post_type );
		if ( ! $num_posts || ! isset( $num_posts->{ $post_status } ) || 0 === (int) $num_posts->{ $post_status } ) {
			return $items;
		}

		$text = sprintf(
			_n( '%1$s %4$s%2$s', '%1$s %4$s%3$s', $num_posts->{$post_status} ),
			number_format_i18n( $num_posts->{$post_status} ),
			strtolower( $object->labels->singular_name ),
			strtolower( $object->labels->name ),
			'pending' === $post_status ? 'Pending ' : ''
		);

		if ( current_user_can( $object->cap->edit_posts ) ) {
			$items[] = sprintf(
				'<a class="%1$s-count" href="edit.php?post_status=%2$s&post_type=%1$s">%3$s</a>',
				$post_type,
				$post_status,
				$text
			);
		} else {
			$items[] = sprintf( '<span class="%1$s-count">%s</span>', $text );
		}

		return $items;
	}
}
