<?php // phpcs:ignore
/**
 * Class Mail
 *
 * A simple class for creating and sending Emails using WordPress and Timber
 *
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @package LeagleCup
 */

namespace LeagleCup\Core;

use Timber\{ Timber };

/**
 * Mail class
 */
class Mail {

	/**
	 * To
	 *
	 * @var array
	 */
	private $to = array();

	/**
	 * Cc
	 *
	 * @var array
	 */
	private $cc = array();

	/**
	 * Subject
	 *
	 * @var string
	 */
	private $subject = '';


	/**
	 * Headers
	 *
	 * @var array
	 */
	private $headers = array( 'Content-type: text/html;charset=utf-8' );


	/**
	 * Attachments
	 *
	 * @var array
	 */
	private $attachments = array();


	/**
	 * Message
	 *
	 * @var string
	 */
	private $message = '';


	/**
	 * Init
	 *
	 * @return object
	 */
	public static function init() : object {
		return new self();
	}


	/**
	 * Set recipients
	 *
	 * @param  array|string $to Email address to send message.
	 *
	 * @return object $this
	 */
	public function to( $to ) : object {
		if ( is_array( $to ) ) {
			$this->to = $to;
		} else {
			$this->to = array( $to );
		}

		return $this;
	}


	/**
	 * Set Cc recipients
	 *
	 * @param string $cc Carbon Copy.
	 *
	 * @return object $this
	 */
	public function cc( $cc ) : object {
		$this->cc = array( $cc );

		return $this;
	}


	/**
	 * Subject
	 *
	 * @param string $subject Subject.
	 *
	 * @return object $this
	 */
	public function subject( string $subject ) : object {
		$this->subject = $subject;

		return $this;
	}


	/**
	 * Message
	 *
	 * @param string $path Path of template.
	 * @param array  $data Array of data.
	 *
	 * @return object
	 */
	public function message( string $path, array $data = array() ) : object {
		$this->message = Timber::compile( $path, $data );

		return $this;
	}


	/**
	 * Set the email's headers
	 *
	 * @param array $headers Headers.
	 *
	 * @return object $this
	 */
	public function headers( array $headers ) : object {
		foreach ( $headers as $header ) {
			$this->headers[] = $header;
		}

		return $this;
	}


	/**
	 * Attachments
	 *
	 * @param array $paths Array of files path.
	 *
	 * @return object $this
	 */
	public function attachments( array $paths ) : object {
		$this->attachments = $paths;

		return $this;
	}


	/**
	 * Sends a rendered email using
	 * WordPress's wp_mail() function
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_mail/
	 *
	 * @return bool
	 */
	public function send() : bool {
		return wp_mail(
			$this->to,
			$this->subject,
			$this->message,
			$this->headers,
			$this->attachments
		);
	}
}
