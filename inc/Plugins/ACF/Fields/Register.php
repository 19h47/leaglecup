<?php // phpcs:ignore
/**
 * Register ACF Fields
 *
 * @package LeagleCup
 * @subpackage LeagleCup/Plugins/ACF
 */

namespace LeagleCup\Plugins\ACF\Fields;

use WP_Post;

/**
 * Rule Match
 */
class Register {
	/**
	 * Key
	 *
	 * @var string
	 */
	private $key = 'register';

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
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'page-templates/register.php',
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'      => 'group_5fc381767be0a',
					'title'    => __( 'Register Template Options', 'leaglecup' ),
					'fields'   => array(
						array(
							'key'           => 'field_5fc38181531de',
							'label'         => __( 'Price', 'leaglecup' ),
							'name'          => 'price',
							'type'          => 'relationship',
							'post_type'     => array( 'price' ),
							'taxonomy'      => '',
							'filters'       => '',
							'max'           => 1,
							'return_format' => 'id',
						),
					),
					'location' => $location,
				)
			);
		}
	}
}
