<?php

/* Show field set on password protected pages */
add_filter('acf/location/rule_types', 'acf_location_rules_types');

function acf_location_rules_types( $choices ) {

  $choices['Page']['visibility'] = __( 'Post Visibility' );

  return $choices;

}

add_filter('acf/location/rule_values/visibility', 'acf_location_rules_values_visibility');

function acf_location_rules_values_visibility( $choices ) {

	//var_dump($choices);
	$choices['password'] = __( 'Password Protected' );

  	return $choices;
}

add_filter('acf/location/rule_match/visibility', 'acf_location_rules_match_visibility', 10, 3);

function acf_location_rules_match_visibility( $match, $rule, $options ) {
	$post = get_post( $options['post_id'] );
	$post_password = $post->post_password;

	if ( isset( $post_password ) ) {
    	if ( !empty( $post_password ) ) {
      		$match = true;
    	}
  	} else {
    	$match = false;
  	}

  	return $match;
}
