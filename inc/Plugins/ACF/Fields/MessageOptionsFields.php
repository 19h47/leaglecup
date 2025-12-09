<?php // phpcs:ignore
/**
 * Registration Form Template ACF Fields
 *
 * @package LeagleCup
 * @subpackage LeagleCup/Plugins/ACF
 */

namespace LeagleCup\Plugins\ACF\Fields;

use WP_Post;

/**
 * Rule Match
 */
class MessageOptionsFields {
	/**
	 * Key
	 *
	 * @var string
	 */
	private $key = 'message_options';

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'init', array( $this, 'fields' ) );
	}

		/**
		 * Registers the field group.
		 *
		 * @return void
		 */
	public function fields() {
		$location = array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'message-settings',
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $this->key,
					'title'    => __( 'Message Options Fields', 'leagle' ),
					'fields'   => array(
						array(
							'key'           => 'field_' . $this->key,
							'label'         => __( 'Partners', 'leaglecup' ),
							'name'          => 'partners',
							'type'          => 'gallery',
							'return_format' => 'url',
							'library'       => 'all',
							'insert'        => 'append',
							'preview_size'  => 'medium',
						),
					),
					'location' => $location,
				)
			);

		}
	}
}
