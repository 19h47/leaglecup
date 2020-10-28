<?php
/**
 * Functions
 *
 * @package LeagleCup
 */

namespace LeagleCup\Block;

use Timber;

/**
 * Member
 */
class Member {


	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'acf/init', array( $this, 'acf_block_gutenberg_member_posts' ) );
	}


	/**
	 * ACF block Gutenberg Member posts
	 *
	 * @see https://www.advancedcustomfields.com/resources/acf_register_block/
	 * @return bool | acf_register_block
	 */
	public function acf_block_gutenberg_member_posts() {
		if ( ! function_exists( 'acf_register_block' ) ) {
			return false;
		}

		$settings = array(
			'name'            => 'member-posts',
			'title'           => __( 'Members', 'leaglecup' ),
			'render_callback' => array( $this, 'acf_block_gutenberg_member_posts_callback' ),
			'category'        => 'widgets',
			'icon'            => 'groups',
			'post_types'      => array( 'page' ),
			'keywords'        => array( 'member' ),
			'mode'            => 'edit',
		);

		return acf_register_block( $settings );
	}


	/**
	 * This is the callback that displays the member block.
	 *
	 * @param arr  $block The block settings and attributes.
	 * @param str  $content The block content (empty string).
	 * @param bool $is_preview True during AJAX preview.
	 * @return void
	 */
	public function acf_block_gutenberg_member_posts_callback( $block, $content = '', $is_preview = false ) {
		$context            = Timber::context();
		$context['members'] = get_field( 'members' );

		if ( ! empty( $context['members'] ) ) {
			Timber::render( 'blocks/members.html.twig', $context );
		}
	}
}


