<?php
/**
 * Functions
 *
 * @package LeagleCup
 */

/**
 * ACF block Gutenberg Member posts
 *
 * @see https://www.advancedcustomfields.com/resources/acf_register_block/
 * @return bool | acf_register_block
 */
function acf_block_gutenberg_member_posts() {
	if ( ! function_exists( 'acf_register_block' ) ) {
		return false;
	}

	$settings = array(
		'name'            => 'member-posts',
		'title'           => __( 'Les membres' ),
		'render_callback' => 'acf_block_gutenberg_member_posts_callback',
		'category'        => 'widgets',
		'icon'            => 'groups',
		'post_types'      => array( 'page' ),
		'keywords'        => array( 'member' ),
		'mode'            => 'edit',
	);

	return acf_register_block( $settings );
}
add_action( 'acf/init', 'acf_block_gutenberg_member_posts' );

/**
 * This is the callback that displays the member block.
 *
 * @param arr  $block The block settings and attributes.
 * @param str  $content The block content (empty string).
 * @param bool $is_preview True during AJAX preview.
 * @return void
 */
function acf_block_gutenberg_member_posts_callback( $block, $content = '', $is_preview = false ) {
	$context            = Timber::get_context();
	$context['members'] = get_field( 'members' );

	if ( ! empty( $context['members'] ) ) {
		Timber::render( 'blocks/members.html.twig', $context );
	}
}
