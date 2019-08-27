<?php
/**
 * Class Partner
 *
 * PHP version 7
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @package LeagleCup
 */

/**
 * Partner class
 *
 * @file   inc/post-types/class-partner.php
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
class Partner {

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
	 */
	public function register_post_type() {
		$labels = array(
			'name'                  => _x( 'Partenaires', 'Personne pluriel', 'leaglecup' ),
			'singular_name'         => _x( 'Partenaire', 'Personne singulier', 'leaglecup' ),
			'menu_name'             => __( 'Partenaires', 'leaglecup' ),
			'name_admin_bar'        => __( 'Partenaire', 'leaglecup' ),
			'parent_item_colon'     => __( 'Partenaires Parents :', 'leaglecup' ),
			'all_items'             => __( 'Tous les partenaires', 'leaglecup' ),
			'add_new_item'          => __( 'Ajouter un partenaire', 'leaglecup' ),
			'add_new'               => __( 'Ajouter', 'leaglecup' ),
			'new_item'              => __( 'Nouveau partenaire', 'leaglecup' ),
			'edit_item'             => __( 'Modifier le partenaire', 'leaglecup' ),
			'update_item'           => __( 'Mettre à jour le partenaire', 'leaglecup' ),
			'view_item'             => __( 'Voir le partenaire', 'leaglecup' ),
			'view_items'            => __( 'Voir les partenaires', 'leaglecup' ),
			'search_items'          => __( 'Chercher parmi les partenaires', 'leaglecup' ),
			'not_found'             => __( 'Aucun partenaire n\'a été trouvé.', 'leaglecup' ),
			'not_found_in_trash'    => __( 'Aucun partenaire n\'a été trouvé dans la corbeille.', 'leaglecup' ),
			'featured_image'        => __( 'Image à la une', 'leaglecup' ),
			'set_featured_image'    => __( 'Mettre une image à la une', 'leaglecup' ),
			'remove_featured_image' => __( 'Retirer l\'image mise à la une', 'leaglecup' ),
			'use_featured_image'    => __( 'Mettre une image à la une', 'leaglecup' ),
			'insert_into_item'      => __( 'Insérer dans le partenaire', 'leaglecup' ),
			'uploaded_to_this_item' => __( 'Téléversé sur ce partenaire', 'leaglecup' ),
			'items_list'            => __( 'Liste des partenaires', 'leaglecup' ),
			'items_list_navigation' => __( 'Navigation de la liste des partenaires', 'leaglecup' ),
			'filter_items_list'     => __( 'Filtrer la liste des partenaires', 'leaglecup' ),
		);

		$rewrite = array(
			'slug'       => __( 'partner', 'leaglecup' ),
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'partenaire',
			'description'         => __( 'Les partenaires', 'leaglecup' ),
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
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'partner', $args );
	}


	/**
	 * CSS
	 */
	public function css() {
		global $typenow; ?>

		<style>
			#dashboard_right_now .partner-count:before { content: "\f483"; }
		</style>

		<?php

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
	 * @param arr $columns Array of columns.
	 */
	public function add_custom_columns( $columns ) {

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
	 * @param str $column_name The column name.
	 * @param int $post_id The ID of the post.
	 */
	public function render_custom_columns( $column_name, $post_id ) {
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

	/**
	 * "At a glance" items (dashboard widget): add the testimony.
	 *
	 * @param arr $items Items.
	 */
	public function at_a_glance( $items ) {
		$post_type   = 'partner';
		$post_status = 'publish';
		$object      = get_post_type_object( $post_type );

		$num_posts = wp_count_posts( $post_type );
		if ( ! $num_posts || ! isset( $num_posts->{ $post_status } ) || 0 === (int) $num_posts->{ $post_status } ) {
			return $items;
		}

		$text = sprintf(
			_n( '%1$s %4$s%2$s', '%1$s %4$s%3$s', $num_posts->{ $post_status } ), // phpcs:ignore
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
}
