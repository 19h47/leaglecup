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
						array(
							'key'        => 'field_' . $this->key . '_fields',
							'label'      => __( 'Fields', 'leaglecup' ),
							'name'       => 'fields',
							'type'       => 'group',
							'sub_fields' => array(
								array(
									'key'        => 'field_' . $this->key . '_fields_company_name',
									'name'       => 'company_name',
									'label'      => __( 'Company Name', 'leaglecup' ),
									'type'       => 'group',
									'sub_fields' => array(
										array(
											'key'         => 'field_' . $this->key . '_fields_company_name_label',
											'name'        => 'label',
											'label'       => __( 'Label', 'leaglecup' ),
											'type'        => 'text',
											'placeholder' => __( 'Label', 'leaglecup' ),
											'default_value' => __( 'Social Reason', 'leaglecup' ),
										),
										array(
											'key'         => 'field_' . $this->key . '_fields_company_name_placeholder',
											'name'        => 'placeholder',
											'label'       => __( 'Placeholder', 'leaglecup' ),
											'type'        => 'text',
											'placeholder' => __( 'e.g. Company Name', 'leaglecup' ),
											'default_value' => __( 'e.g. Vandelay Industries', 'leaglecup' ),
										),
										array(
											'key'   => 'field_' . $this->key . '_fields_company_name_required',
											'name'  => 'required',
											'label' => __( 'Required', 'leaglecup' ),
											'type'  => 'true_false',
											'default_value' => false,
										),
									),
								),
								array(
									'key'        => 'field_' . $this->key . '_fields_job_title',
									'name'       => 'job_title',
									'label'      => __( 'Job Title', 'leaglecup' ),
									'type'       => 'group',
									'sub_fields' => array(
										array(
											'key'         => 'field_' . $this->key . '_fields_job_title_label',
											'name'        => 'label',
											'label'       => __( 'Label', 'leaglecup' ),
											'type'        => 'text',
											'placeholder' => __( 'Label', 'leaglecup' ),
											'default_value' => __( 'Profession', 'leaglecup' ),
										),
										array(
											'key'         => 'field_' . $this->key . '_fields_job_title_placeholder',
											'name'        => 'placeholder',
											'label'       => __( 'Placeholder', 'leaglecup' ),
											'type'        => 'text',
											'placeholder' => __( 'Placeholder', 'leaglecup' ),
											'default_value' => __( 'e.g. Lawyer / Accountant / Notary', 'leaglecup' ),
										),
										array(
											'key'   => 'field_' . $this->key . '_fields_job_title_required',
											'name'  => 'required',
											'label' => __( 'Required', 'leaglecup' ),
											'type'  => 'true_false',
											'default_value' => false,
										),
									),
								),
							),
						),
					),
					'location' => $location,
				)
			);
		}
	}
}
