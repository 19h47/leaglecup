<?php // phpcs:ignore
/**
 * Contact
 *
 * @category Customizer
 * @package  LeagleCup
 * @author   Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace LeagleCup\Api\Customizer;

use WP_Customize_Manager;

/**
 * Contact
 */
class Contact {


	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'customize_register', array( $this, 'register' ), 10, 1 );
	}


	/**
	 * Register
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	public function register( WP_Customize_Manager $wp_customize ) {

		// Add contact section.
		$wp_customize->add_section(
			'contact',
			array(
				'title'       => __( 'Contact information', 'leaglecup' ),
				'description' => __( 'Contact settings', 'leaglecup' ),
			)
		);

		// Facebook.
		$wp_customize->add_setting(
			'facebook',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'facebook',
			array(
				'label'       => __( 'Facebook', 'leaglecup' ),
				'description' => __( 'Indiquer l\'URL du compte Facebook' ),
				'section'     => 'contact',
				'settings'    => 'facebook',
			)
		);

		// LinkedIn.
		$wp_customize->add_setting(
			'linkedin',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'linkedin',
			array(
				'label'       => __( 'LinkedIn', 'leaglecup' ),
				'description' => __( 'Indiquer l\'URL du compte LinkedIn' ),
				'section'     => 'contact',
				'settings'    => 'linkedin',
			)
		);

		// Public email.
		$wp_customize->add_setting(
			'public_email',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'public_email',
			array(
				'label'       => __( 'Public email', 'leaglecup' ),
				'description' => __( 'Indiquer l\'adresse mail du site' ),
				'section'     => 'contact',
				'settings'    => 'public_email',
			)
		);

		// Email addresses.
		$wp_customize->add_setting(
			'email_addresses',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'email_addresses',
			array(
				'label'       => __( 'Email addresses', 'leaglecup' ),
				'description' => __( 'Separate email addresses with commas', 'leaglecup' ),
				'section'     => 'contact',
				'settings'    => 'email_addresses',
			)
		);
	}
}
