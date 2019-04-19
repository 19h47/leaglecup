<?php
/**
 * Send command
 *
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @package LeagleCup
 */

use GuzzleHttp\Client;


/**
 * Class Send Command
 *
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
class SendCommand {

	/**
	 * The version of the theme.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this theme.
	 */
	private $theme_version;


	/**
	 * Config
	 *
	 * @access private
	 * @var array
	 */
	private $config;


	/**
	 * The file name
	 *
	 * @access private
	 * @var    string
	 */
	private $filename;


	/**
	 * Data
	 *
	 * @access private
	 * @var    array
	 */
	private $data;


	/**
	 * Constructor
	 *
	 * @param str $theme_version The theme version.
	 */
	public function __construct( $theme_version ) {
		$this->theme_version = $theme_version;
		$this->config        = include_once get_template_directory() . '/inc/config.php';

		add_action( 'wp_ajax_nopriv_send_command', array( $this, 'ajax' ) );
		add_action( 'wp_ajax_send_command', array( $this, 'ajax' ) );
	}


	/**
	 * Ajax
	 *
	 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
	 * @access public
	 */
	public function ajax() {
		// Check for referer call.
		check_ajax_referer( 'security', 'nonce' );
		
		// @TODO Test $_POST.
		$this->data = $_POST;
		$this->set_filename();
		$this->create_contract()->request();
	}

	/**
	 * Request
	 *
	 * @access public
	 */
	public function request() {
		$client = new Client(
			array(
				// You can set any number of default request options.
				'timeout' => 30.0,
			)
		);

		$response = $client->request(
			'POST',
			$this->config['HOST'] . '/calinda/hub/selling/do?m=sendCommandPacket',
			array(
				'headers'   => array(
					'j_token' => $this->config['TOKEN'],
				),
				'multipart' => array(
					array(
						'name'     => $this->get_filename() . '.json',
						'contents' => fopen( get_template_directory() . '/inc/form-data/' . $this->get_filename() . '.json', 'r' ),
						'filename' => $this->get_filename() . '.json',
						'headers'  => array(
							'Content-type' => 'application/json',
						),
					),
					array(
						'name'     => 'Bon_de_commande.pdf',
						'contents' => fopen( get_template_directory() . '/inc/Bon_de_commande.pdf', 'r' ),
						'filename' => 'Bon_de_commande.pdf',
						'headers'  => array(
							'Content-type' => 'application/pdf',
						),
					),
				),
			)
		);

		var_dump( $response->getBody()->getContents() );

		// That's all folks!
		wp_die();
	}


	/**
	 * Set filename
	 *
	 * @access public
	 */
	public function set_filename() {
		$this->filename = sanitize_title( $this->data['lastname'] . '-' . $this->data['firstname'] . '-' . $this->data['company_name'] . '-' . current_time( 'timestamp' ) );
	}

	/**
	 * Get filename
	 *
	 * @access public
	 */
	public function get_filename() {
		return $this->filename;
	}


	/**
	 * Save data
	 *
	 * @access public
	 */
	public function create_contract() {
		$array = array();

		$customer = array(
			'customer' => array(
				'number'        => $this->filename,
				'mode'          => 3,
				'contractor_id' => -1,
				'vendor'        => $this->config['VENDOR_EMAIL'],
				'fields'        => array(
					array(
						'key'   => 'firstname',
						'value' => $this->data['firstname'],
					),
					array(
						'key'   => 'lastname',
						'value' => $this->data['lastname'],
					),
					array(
						'key'   => 'civility',
						'value' => $this->data['civility'],
					),
					array(
						'key'   => 'email',
						'value' => $this->data['email'],
					),
					array(
						'key'   => 'cell_phone',
						'value' => $this->data['cell_phone'],
					),
					array(
						'key'   => 'adresse1',
						'value' => $this->data['address_1'],
					),
					array(
						'key'   => 'postal_code',
						'value' => $this->data['postal_code'],
					),
					array(
						'key'   => 'city',
						'value' => $this->data['city'],
					),
					array(
						'key'   => 'company_name',
						'value' => $this->data['company_name'],
					),
				),
			),
		);

		$contractors = array(
			'contractors' => array(),
		);

		$contract = array(
			'contract' => array(
				'contract_definition_id' => $this->config['CONTRACT_DEFINITION_ID'],
				'pdf_file_path'          => 'Bon_de_commande.pdf',
				'contract_id'            => -1,
				'message_title'          => 'Votre bon de commande pour signature',
				'message_body'           => 'Vous êtes signataire du bon de commande ci-joint pour la LEAGLE CUP. Merci de bien vouloir le signer électroniquement en cliquant sur le lien ci-dessous.<br>Cordialement',
			),
		);

		$contract_properties = array(
			'contract_properties' => array(
				array(
					'key'   => 'ffg_index',
					'value' => $this->data['ffg_index'],
				),
				array(
					'key'   => 'license_number',
					'value' => $this->data['license_number'],
				),
				array(
					'key'   => 't_shirt_size',
					'value' => $this->data['t_shirt_size'],
				),
				array(
					'key'   => 'option_1',
					'value' => 'true' === $this->data['option_1'] ? '50 €' : '0 €',
				),
				array(
					'key'   => 'option_2',
					'value' => 'true' === $this->data['option_2'] ? '50 €' : '0 €',
				),
				array(
					'key'   => 'total',
					'value' => $this->data['total'] . ' €',
				),
				array(
					'key'   => 'scramble',
					'value' => $this->data['scramble'],
				),
				array(
					'key'   => 'scramble_lastname_second_player',
					'value' => $this->data['scramble_lastname_second_player'],
				),
				array(
					'key'   => 'scramble_firstname_second_player',
					'value' => $this->data['scramble_firstname_second_player'],
				),
				array(
					'key'   => 'scramble_license_number_second_player',
					'value' => $this->data['scramble_license_number_second_player'] ? 'Numéro de licence du deuxième joueur: ' . $this->data['scramble_license_number_second_player'] : '',
				),
			),
		);

		$files = array(
			'files' => array(),
		);

		$options = array(
			'options' => array(),
		);

		$to_sign = array(
			'to_sign' => 1,
		);

		// Merge!
		$array = array_merge(
			$array,
			$customer,
			$contractors,
			$contract,
			$contract_properties,
			$files,
			$options,
			$to_sign
		);

		file_put_contents(
			get_template_directory() . '/inc/form-data/' . $this->get_filename() . '.json',
			wp_json_encode( $array )
		);

		return $this;
	}
}
