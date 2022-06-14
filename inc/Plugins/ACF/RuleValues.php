<?php // phpcs:ignore
/**
 * Rule Values
 *
 * @package LeagleCup
 * @subpackage LeagleCup/Plugins/ACF
 */

namespace LeagleCup\Plugins\ACF;

use WP_Post;

/**
 * Rule Values
 */
class RuleValues {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_filter( 'acf/location/rule_values/visibility', array( $this, 'rules_values_visibility' ) );
	}


	/**
	 * Location rules values visibility
	 *
	 * @param  arr $choices The choices.
	 * @return $coices
	 */
	public function rules_values_visibility( $choices ) {
		$choices['password'] = __( 'Password Protected', 'leaglecup' );

		return $choices;
	}
}
