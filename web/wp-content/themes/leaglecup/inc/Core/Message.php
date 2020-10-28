<?php // phpcs:ignore
/**
 * Message
 *
 * @package LeagleCup
 */

namespace LeagleCup\Core;

/**
 * Message
 */
class Message {

	/**
	 * Run function
	 *
	 * @access public
	 * @return void
	 */
	public function run() {
		add_action( 'init', array( $this, 'register_post_type' ), 10, 0 );
		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ), 10, 1 );
	}


	/**
	 * Contact updated messages function
	 *
	 * @param array $messages Post updated messages. For defaults see $messages declarations above.
	 * @return array $message
	 * @access public
	 */
	public function updated_messages( array $messages ) : array {
		global $post;

		$post_ID     = isset( $post_ID ) ? (int) $post_ID : 0;
		$preview_url = get_preview_post_link( $post );

		/* translators: Publish box date format, see https://secure.php.net/date */
		$scheduled_date = date_i18n( __( 'M j, Y @ H:i' ), strtotime( $post->post_date ) );

		$view_link_html = sprintf(
			' <a href="%1$s">%2$s</a>',
			esc_url( get_permalink( $post_ID ) ),
			__( 'View Message', 'leaglecup' )
		);

		$scheduled_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( get_permalink( $post_ID ) ),
			__( 'Preview Message', 'leaglecup' )
		);

		$preview_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( $preview_url ),
			__( 'Preview Message', 'leaglecup' )
		);

		$messages['message'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Message updated.', 'leaglecup' ) . $view_link_html,
			2  => __( 'Custom field updated.', 'leaglecup' ),
			3  => __( 'Custom field deleted.', 'leaglecup' ),
			4  => __( 'Message updated.', 'leaglecup' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Message restored to revision from %s.', 'leaglecup' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore
			6  => __( 'Message published.', 'leaglecup' ) . $view_link_html,
			7  => __( 'Message saved.', 'leaglecup' ),
			8  => __( 'Message submitted.', 'leaglecup' ) . $preview_link_html,
			9  => sprintf( __( 'Message scheduled for: %s.', 'leaglecup' ), '<strong>' . $scheduled_date . '</strong>' ) . $scheduled_link_html, // phpcs:ignore
			10 => __( 'Message draft updated.', 'leaglecup' ) . $preview_link_html,
		);

		return $messages;
	}


	/**
	 * Register Custom Post Type
	 *
	 * @return void
	 * @access public
	 */
	public function register_post_type() : void {
		$labels = array(
			'name'                     => _x( 'Messages', 'message general name', 'leaglecup' ),
			'singular_name'            => _x( 'Message', 'message singular name', 'leaglecup' ),
			'add_new'                  => _x( 'Add New', 'message', 'leaglecup' ),
			'add_new_item'             => __( 'Add New Messages', 'leaglecup' ),
			'edit_item'                => __( 'Edit Message', 'leaglecup' ),
			'new_item'                 => __( 'New Message', 'leaglecup' ),
			'view_item'                => __( 'View Message', 'leaglecup' ),
			'view_items'               => __( 'View Messages', 'leaglecup' ),
			'search_items'             => __( 'Search Messages', 'leaglecup' ),
			'not_found'                => __( 'No messages found.', 'leaglecup' ),
			'not_found_in_trash'       => __( 'No messages found in Trash.', 'leaglecup' ),
			'parent_item_colon'        => __( 'Parent Message:', 'leaglecup' ),
			'all_items'                => __( 'All messages', 'leaglecup' ),
			'archives'                 => __( 'Message Archives', 'leaglecup' ),
			'attributes'               => __( 'Message Attributes', 'leaglecup' ),
			'insert_into_item'         => __( 'Insert into message', 'leaglecup' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this message', 'leaglecup' ),
			'featured_image'           => _x( 'Featured Image', 'message', 'leaglecup' ),
			'set_featured_image'       => _x( 'Set featured image', 'message', 'leaglecup' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'message', 'leaglecup' ),
			'use_featured_image'       => _x( 'Use as featured image', 'message', 'leaglecup' ),
			'filter_items_list'        => __( 'Filter messages list', 'leaglecup' ),
			'items_list_navigation'    => __( 'Messages list navigation', 'leaglecup' ),
			'items_list'               => __( 'Messages list', 'leaglecup' ),
			'item_published'           => __( 'Message published.', 'leaglecup' ),
			'item_published_privately' => __( 'Message published privately.', 'leaglecup' ),
			'item_reverted_to_draft'   => __( 'Message reverted to draft.', 'leaglecup' ),
			'item_scheduled'           => __( 'Message scheduled.', 'leaglecup' ),
			'item_updated'             => __( 'Message updated.', 'leaglecup' ),
		);

		$args = array(
			'label'               => __( 'Message', 'leaglecup' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'custom-fields' ),
			'taxonomies'          => array(),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-email',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_in_rest'        => true,
		);
		register_post_type( 'message', $args );
	}
}
