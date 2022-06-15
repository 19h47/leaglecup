<?php // phpcs:ignore
/**
 * Recaptcha
 *
 * @category Customizer
 * @package  LeagleCup
 * @author   Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace LeagleCup\Api\Customizer;

use WP_Customize_Manager;

/**
 * Recaptcha
 */
class Recaptcha {

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
		// Add feed section.
		$wp_customize->add_section(
			'recaptcha',
			array(
				'title'       => __( 'reCAPTCHA', 'leaglecup' ),
				'description' => __( 'reCAPTCHA Settings', 'leaglecup' ),
			)
		);

		$wp_customize->add_setting(
			'recaptcha_site_key',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'recaptcha_site_key',
			array(
				'label'    => __( 'Site key', 'leaglecup' ),
				'section'  => 'recaptcha',
				'settings' => 'recaptcha_site_key',
			)
		);

		$wp_customize->add_setting(
			'recaptcha_secret_key',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'recaptcha_secret_key',
			array(
				'label'    => __( 'Secret key', 'leaglecup' ),
				'section'  => 'recaptcha',
				'settings' => 'recaptcha_secret_key',
			)
		);

	}
}
