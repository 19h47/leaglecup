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
class RegistrationFormTemplate {
	/**
	 * Key
	 *
	 * @var string
	 */
	private $key = 'registration_form';

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
					'value'    => 'page-templates/registration-form.php',
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $this->key,
					'title'    => __( 'Registration Form Page Options', 'leaglecup' ),
					'fields'   => array(
						array(
							'key'           => 'field_' . $this->key . '_price',
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
									'key'        => 'field_' . $this->key . '_fields_civility',
									'name'       => 'civility',
									'label'      => __( 'Civility', 'leaglecup' ),
									'type'       => 'group',
									'sub_fields' => array(
										array(
											'key'         => 'field_' . $this->key . '_fields_civility_label',
											'name'        => 'label',
											'label'       => __( 'Label', 'leaglecup' ),
											'type'        => 'text',
											'placeholder' => __( 'Label', 'leaglecup' ),
											'default_value' => __( 'Civility', 'leaglecup' ),
										),
										array(
											'key'         => 'field_' . $this->key . '_fields_civility_choices',
											'label'       => __( 'Choices', 'leaglecup' ),
											'name'        => 'choices',
											'type'        => 'select',
											'choices'     => array(
												'MONSIEUR' => __( 'Sir', 'leaglecup' ),
												'MADAME'   => __( 'Madam', 'leaglecup' ),
												'MADEMOISELLE' => __( 'Miss', 'leaglecup' ),
											),
											'default_value' => array( 'MONSIEUR', 'MADAME', 'MADEMOISELLE' ),
											'multiple'    => true,
											'return_format' => 'array',
											'placeholder' => __( 'Civility', 'leaglecup' ),

										),
										array(
											'key'   => 'field_' . $this->key . '_fields_civility_required',
											'name'  => 'required',
											'label' => __( 'Required', 'leaglecup' ),
											'type'  => 'true_false',
											'default_value' => false,
										),
									),
								),
								array(
									'key'        => 'field_' . $this->key . '_fields_first_name',
									'name'       => 'first_name',
									'label'      => __( 'First Name', 'leaglecup' ),
									'type'       => 'group',
									'sub_fields' => array(
										array(
											'key'         => 'field_' . $this->key . '_fields_first_name_label',
											'name'        => 'label',
											'label'       => __( 'Label', 'leaglecup' ),
											'type'        => 'text',
											'placeholder' => __( 'Label', 'leaglecup' ),
											'default_value' => __( 'First name', 'leaglecup' ),
										),
										array(
											'key'         => 'field_' . $this->key . '_fields_first_name_placeholder',
											'name'        => 'placeholder',
											'label'       => __( 'Placeholder', 'leaglecup' ),
											'type'        => 'text',
											'placeholder' => __( 'First name', 'leaglecup' ),
											'default_value' => __( 'e.g. Art', 'leaglecup' ),
										),
										array(
											'key'   => 'field_' . $this->key . '_fields_first_name_required',
											'name'  => 'required',
											'label' => __( 'Required', 'leaglecup' ),
											'type'  => 'true_false',
											'default_value' => false,
										),
									),
									'wrapper'    => array(
										'width' => 50,
									),
								),
								array(
									'key'        => 'field_' . $this->key . '_fields_last_name',
									'name'       => 'last_name',
									'label'      => __( 'Last Name', 'leaglecup' ),
									'type'       => 'group',
									'sub_fields' => array(
										array(
											'key'         => 'field_' . $this->key . '_fields_last_name_label',
											'name'        => 'label',
											'label'       => __( 'Label', 'leaglecup' ),
											'type'        => 'text',
											'placeholder' => __( 'Label', 'leaglecup' ),
											'default_value' => __( 'Last name', 'leaglecup' ),
										),
										array(
											'key'         => 'field_' . $this->key . '_fields_last_name_placeholder',
											'name'        => 'placeholder',
											'label'       => __( 'Placeholder', 'leaglecup' ),
											'type'        => 'text',
											'placeholder' => __( 'Last name', 'leaglecup' ),
											'default_value' => __( 'e.g. Vandelay', 'leaglecup' ),
										),
										array(
											'key'   => 'field_' . $this->key . '_fields_last_name_required',
											'name'  => 'required',
											'label' => __( 'Required', 'leaglecup' ),
											'type'  => 'true_false',
											'default_value' => false,
										),
									),
									'wrapper'    => array(
										'width' => 50,
									),
								),
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
				),
			);
		}
	}
}
