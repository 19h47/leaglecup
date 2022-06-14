<?php // phpcs:ignore
/**
 * Rule Types
 *
 * @package LeagleCup
 * @subpackage LeagleCup/Plugins/ACF
 */

namespace LeagleCup\Plugins\ACF;

use WP_Post;

/**
 * Rule Types
 */
class RuleTypes {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		// Show field set on password protected pages.
		add_filter( 'acf/location/rule_types', array( $this, 'rules_types' ) );
	}


	/**
	 * Location rules types
	 *
	 * @param arr $choices The choices.
	 * @return $choices
	 */
	public function rules_types( $choices ) {

		$choices['Page']['visibility'] = __( 'Page Visibility', 'leaglecup' );

		return $choices;

	}
}
