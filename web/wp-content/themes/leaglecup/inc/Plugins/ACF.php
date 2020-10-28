<?php // phpcs:ignore
/**
 * ACF
 *
 * @package LeagleCup
 * @subpackage LeagleCup/Plugins/ACF
 */

namespace LeagleCup\Plugins;

use WP_Post;

/**
 * WordPress
 */
class ACF {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		// Show field set on password protected pages.
		add_filter( 'acf/location/rule_types', array( $this, 'rules_types' ) );
		add_filter( 'acf/location/rule_values/visibility', array( $this, 'rules_values_visibility' ) );
		add_filter( 'acf/location/rule_match/visibility', array( $this, 'rules_match_visibility' ), 10, 3 );
	}



	/**
	 * Location rules types
	 *
	 * @param arr $choices The choices.
	 * @return $choices
	 */
	public function rules_types( $choices ) {

		$choices['Page']['visibility'] = __( 'Post Visibility' );

		return $choices;

	}



	/**
	 * Location rules values visibility
	 *
	 * @param  arr $choices The choices.
	 * @return $coices
	 */
	public function rules_values_visibility( $choices ) {

		$choices['password'] = __( 'Password Protected' );

		return $choices;
	}


	/**
	 * Location rules match visibility
	 *
	 * @param  [type] $match   Match.
	 * @param  [type] $rule    Rule.
	 * @param  arr    $options Array of options.
	 *
	 * @return $match
	 */
	public function rules_match_visibility( $match, $rule, $options ) {
		$post          = get_post( $options['post_id'] );
		$post_password = $post->post_password;

		if ( isset( $post_password ) ) {
			if ( ! empty( $post_password ) ) {
				$match = true;
			}
		} else {
			$match = false;
		}

		return $match;
	}
}


