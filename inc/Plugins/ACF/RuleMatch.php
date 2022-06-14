<?php // phpcs:ignore
/**
 * Rule Match
 *
 * @package LeagleCup
 * @subpackage LeagleCup/Plugins/ACF
 */

namespace LeagleCup\Plugins\ACF;

use WP_Post;

/**
 * Rule Match
 */
class RuleMatch {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_filter( 'acf/location/rule_match/visibility', array( $this, 'rules_match_visibility' ), 10, 3 );
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
