<?php // phpcs:ignore
/**
 * Register
 *
 * @package LeagleCup
 * @subpackage LeagleCup/Plugins/Register
 */

namespace LeagleCup\Plugins;

use Timber\{ Timber, Post };
use LeagleCup\Core\{ Mail };
use WP_Post;

/**
 * Register
 */
class Register {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'wp_ajax_nopriv_register', array( $this, 'register' ) );
		add_action( 'wp_ajax_register', array( $this, 'register' ) );
	}


	/**
	 * Register
	 */
	public function register() {
		$data = array(
			'firstname'           => $_POST['firstname'],
			'lastname'            => $_POST['lastname'],
			'medical_certificate' => $_POST['medical_certificate'],
			'team'                => $_POST['team'],
			'civility'            => $_POST['civility'],
			'company_name'        => $_POST['company_name'],
			'job_title'           => $_POST['job_title'],
			'email'               => $_POST['email'],
			'cell_phone'          => $_POST['cell_phone'],
			'address'             => $_POST['address'],
			'city'                => $_POST['city'],
			'postal_code'         => $_POST['postal_code'],
			'license_number'      => $_POST['license_number'],
			'ffg_index'           => $_POST['ffg_index'],
			't_shirt_size'        => $_POST['t_shirt_size'],
			'options'             => $_POST['options'],
			'total'               => $_POST['total'],
			'title'               => $_POST['title'],
			'price'               => $_POST['price'],
		);

		$new_post = $this->save_post( $data );

		$this->send_mail( $new_post );

		wp_send_json_success();
	}

	/**
	 * Save post
	 *
	 * @param array $data Data.
	 */
	public function save_post( array $data ) {
		$new_post = array(
			'post_title'  => $data['firstname'] . ' ' . $data['lastname'],
			'post_status' => 'publish',
			'post_type'   => 'message',
		);

		$pid = wp_insert_post( $new_post );

		add_post_meta( $pid, 'civility', $data['civility'], true );

		add_post_meta( $pid, 'firstname', $data['firstname'], true );
		add_post_meta( $pid, 'lastname', $data['lastname'], true );

		add_post_meta( $pid, 'company_name', $data['company_name'], true );
		add_post_meta( $pid, 'job_title', $data['job_title'], true );

		add_post_meta( $pid, 'email', $data['email'], true );
		add_post_meta( $pid, 'cell_phone', $data['cell_phone'], true );

		add_post_meta( $pid, 'address', $data['address'], true );
		add_post_meta( $pid, 'city', $data['city'], true );
		add_post_meta( $pid, 'postal_code', $data['postal_code'], true );

		add_post_meta( $pid, 'license_number', $data['license_number'], true );
		add_post_meta( $pid, 'ffg_index', $data['ffg_index'], true );

		add_post_meta( $pid, 't_shirt_size', $data['t_shirt_size'], true );

		add_post_meta( $pid, 'title', $data['title'], true );
		add_post_meta( $pid, 'price', $data['price'], true );

		foreach ( $data['options'] as $key => $value ) {
			add_post_meta( $pid, 'options_' . $key, $value, true );
		}

		add_post_meta( $pid, 'total', $data['total'], true );

		foreach ( $data['team'] as $key => $value ) {
			add_post_meta( $pid, 'team_' . $key, $value, true );
		}

		add_post_meta( $pid, 'medical_certificate', $data['medical_certificate'], true );

		return $pid;
	}


	/**
	 * Send mail
	 *
	 * @param int $id Post id.
	 */
	public function send_mail( int $id ) {
		$email_adresses = explode( ', ', get_option( 'email_addresses' ) );
		$email          = get_option( 'public_email' ) ? get_option( 'public_email' ) : get_option( 'admin_email' );

		// Mail.
		$to[] = get_post_meta( $id, 'email', true );

		$headers[] = 'From: LEAGLE CUP <' . $email . '>';
		$headers[] = 'Bcc: ' . $email;

		$context = Timber::get_context();

		$context['post'] = new Post( $id );

		foreach ( $email_adresses as $email_adress ) {
			$headers[] = 'Bcc: ' . $email_adress;
		}

		Mail::init()
			->to( $to )
			->subject( __( 'Votre inscription à la Leagle Cup', 'leaglecup' ) )
			->message( 'partials/message.html.twig', $context )
			->headers( $headers )
			->send();
	}
}
