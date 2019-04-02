<?php
/**
 * Class Price
 *
 * PHP version 7.2.10
 *
 * @category Price
 * @package  LeagleCup
 * @author   Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/19h47/leaglecup
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
			'name'                  => _x( 'Tarifs', 'Personne pluriel', 'leaglecup' ),
			'singular_name'         => _x( 'Tarif', 'Personne singulier', 'leaglecup' ),
			'menu_name'             => __( 'Tarifs', 'leaglecup' ),
			'name_admin_bar'        => __( 'Tarif', 'leaglecup' ),
			'parent_item_colon'     => __( 'Tarifs Parents :', 'leaglecup' ),
			'all_items'             => __( 'Tous les tarifs', 'leaglecup' ),
			'add_new_item'          => __( 'Ajouter un tarif', 'leaglecup' ),
			'add_new'               => __( 'Ajouter', 'leaglecup' ),
			'new_item'              => __( 'Nouveau tarif', 'leaglecup' ),
			'edit_item'             => __( 'Modifier le tarif', 'leaglecup' ),
			'update_item'           => __( 'Mettre à jour le tarif', 'leaglecup' ),
			'view_item'             => __( 'Voir le tarif', 'leaglecup' ),
			'view_items'            => __( 'Voir les tarifs', 'leaglecup' ),
			'search_items'          => __( 'Chercher parmi les tarifs', 'leaglecup' ),
			'not_found'             => __( 'Aucun tarif n\'a été trouvé.', 'leaglecup' ),
			'not_found_in_trash'    => __( 'Aucun tarif n\'a été trouvé dans la corbeille.', 'leaglecup' ),
			'featured_image'        => __( 'Image à la une', 'leaglecup' ),
			'set_featured_image'    => __( 'Mettre une image à la une', 'leaglecup' ),
			'remove_featured_image' => __( 'Retirer l\'image mise à la une', 'leaglecup' ),
			'use_featured_image'    => __( 'Mettre une image à la une', 'leaglecup' ),
			'insert_into_item'      => __( 'Insérer dans le tarif', 'leaglecup' ),
			'uploaded_to_this_item' => __( 'Téléversé sur ce tarif', 'leaglecup' ),
			'items_list'            => __( 'Liste des tarifs', 'leaglecup' ),
			'items_list_navigation' => __( 'Navigation de la liste des tarifs', 'leaglecup' ),
			'filter_items_list'     => __( 'Filtrer la liste des tarifs', 'leaglecup' ),
		);

		$rewrite = array(
			'slug'       => __( 'price', 'leaglecup' ),
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'tarif',
			'description'         => __( 'Les tarifs', 'leaglecup' ),
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
