<?php
/**
 * ACF
 *
 * PHP version 7.2.10
 *
 * @category ACF
 * @package  LeagleCup
 * @author   Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/19h47/leaglecup
 */

/* Show field set on password protected pages */
add_filter( 'acf/location/rule_types', 'acf_location_rules_types' );

/**
 * Location rules types
 *
 * @param arr $choices The choices.
 * @return $choices
 */
function acf_location_rules_types( $choices ) {

	$choices['Page']['visibility'] = __( 'Post Visibility' );

	return $choices;

}

add_filter( 'acf/location/rule_values/visibility', 'acf_location_rules_values_visibility' );

/**
 * Location rules values visibility
 *
 * @param  arr $choices The choices.
 * @return $coices
 */
function acf_location_rules_values_visibility( $choices ) {

	$choices['password'] = __( 'Password Protected' );

	return $choices;
}

add_filter( 'acf/location/rule_match/visibility', 'acf_location_rules_match_visibility', 10, 3 );

/**
 * Location rules match visibility
 *
 * @param  [type] $match   Match.
 * @param  [type] $rule    Rule.
 * @param  arr    $options Array of options.
 * @return $match
 */
function acf_location_rules_match_visibility( $match, $rule, $options ) {
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
