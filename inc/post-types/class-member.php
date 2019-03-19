<?php
/**
 * Class Member
 *
 * PHP version 7
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @package LeagleCup
 */

/**
 * Member class
 *
 * @file   inc/post-types/class-partner.php
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
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
	 * @param str $theme_version The theme version.
	 * @access public
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
	 * "At a glance" items (dashboard widget): add the testimony.
	 *
	 * @param arr $items Items.
	 */
	public function at_a_glance( $items ) {
		$post_type   = 'member';
		$post_status = 'publish';
		$object      = get_post_type_object( $post_type );

		$num_posts = wp_count_posts( $post_type );
		if ( ! $num_posts || ! isset( $num_posts->{ $post_status } ) || 0 === (int) $num_posts->{ $post_status } ) {
			return $items;
		}

		$text = sprintf(
			_n( '%1$s %4$s%2$s', '%1$s %4$s%3$s', $num_posts->{ $post_status } ),
			number_format_i18n( $num_posts->{ $post_status } ),
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


	/**
	 * CSS
	 */
	public function css() {
		?>
		<style>
			#dashboard_right_now .member-count:before { content: "\f307"; }
		</style>
		<?php
	}
}
