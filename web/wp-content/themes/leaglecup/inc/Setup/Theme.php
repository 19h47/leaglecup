<?php // phpcs:ignore
/**
 * Bootstraps WordPress theme related functions, most importantly enqueuing javascript and styles.
 *
 * @package LeagleCup
 * @subpackage LeagleCup/Setup/Theme
 */

namespace LeagleCup\Setup;

use Timber\{ Timber, Menu };
use Twig\{ TwigFunction };
use Set_Glance_Items;

$timber = new Timber();

Timber::$dirname = array( 'views', 'templates', 'dist' );

/**
 * Theme
 */
class Theme {

	/**
	 * The manifest of this theme
	 *
	 * @access private
	 * @var    array
	 */
	private $theme_manifest;


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function run() : void {
		$this->theme_manifest = get_theme_manifest();

		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber_context', array( $this, 'add_socials_to_context' ) );
		add_filter( 'timber/context', array( $this, 'add_to_theme' ) );
		add_filter( 'timber_context', array( $this, 'add_menus_to_context' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );

		if ( class_exists( 'Set_Glance_Items' ) ) {
			new Set_Glance_Items(
				array(),
				array(
					array(
						'name' => 'member',
						'code' => '\f307',
					),
					array(
						'name' => 'partner',
						'code' => '\f483',
					),
					array(
						'name' => 'price',
						'code' => '\f155',
					),
				)
			);
		}
	}


	/**
	 * Add to Twig
	 *
	 * @param object $twig Twig environment.
	 * @return object $twig
	 * @access public
	 */
	public function add_to_twig( object $twig ) : object {
		if ( function_exists( 'pll__' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'pll__',
					function ( $string ) {
						return pll__( $string );
					}
				)
			);
		}

		if ( function_exists( 'pll_e' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'pll_e',
					function ( $string ) {
						return pll_e( $string );
					}
				)
			);
		}

		if ( function_exists( 'pll_the_languages' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'pll_the_languages',
					function ( $args = '' ) {
						return pll_the_languages( $args );
					}
				)
			);
		}

		if ( function_exists( 'post_class' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'post_class',
					function ( $class = '', $post_id = null ) {
						return post_class( $class, $post_id );
					}
				)
			);
		}

		if ( function_exists( 'body_class' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'body_class',
					function ( $args = '' ) {
						return body_class( $args );
					}
				)
			);
		}

		if ( function_exists( 'html_class' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'html_class',
					function ( $args = '' ) {
						return html_class( $args );
					}
				)
			);
		}

		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'yoast_breadcrumb',
					function () {
						return yoast_breadcrumb();
					}
				)
			);
		}

		if ( function_exists( 'get_body_class' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'get_body_class',
					function () {
						return get_body_class();
					}
				)
			);
		}

		if ( function_exists( 'do_shortcode' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'do_shortcode',
					function ( $id ) {
						return do_shortcode( "[contact-form-7 id=\"{$id}\"]" );
					}
				)
			);
		}

		if ( function_exists( 'wp_get_document_title' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'wp_get_document_title',
					function () {
						return wp_get_document_title();
					}
				)
			);
		}

		return $twig;
	}


	/**
	 * Add to theme
	 *
	 * @param array $context Timber context.
	 */
	public function add_to_theme( array $context ) : array {
		$context['theme']->manifest = get_theme_manifest();

		return $context;
	}


	/**
	 * Add socials to context
	 *
	 * @param array $context Timber context.
	 * @return array
	 */
	public function add_socials_to_context( array $context ) : array {
		// Share and Socials links.
		$socials = array(
			array(
				'title' => 'Facebook',
				'slug'  => 'facebook',
				'name'  => __( 'Share on Facebook', 'leaglecup' ),
				'url'   => 'https://www.facebook.com/sharer.php?u=',
				'link'  => get_option( 'facebook' ),
			),
			array(
				'title' => 'LinkedIn',
				'slug'  => 'linkedin',
				'name'  => __( 'Share on LinkedIn', 'leaglecup' ),
				'url'   => 'https://www.linkedin.com/shareArticle?mini=true&url=',
				'link'  => get_option( 'linkedin' ),
			),
			array(
				'title' => 'Contactez-nous',
				'slug'  => 'email',
				'name'  => __( 'Contact Us', 'leaglecup' ),
				'link'  => 'mailto:' . get_option( 'public_email' ),
			),
		);

		foreach ( $socials as $social ) {
			if ( ! empty( $social['url'] ) ) {
				$context['socials'][ $social['slug'] ] = $social;
			}
			$context['shares'][ $social['slug'] ] = $social;
		}

		return $context;
	}


	/**
	 * Add menus to context
	 *
	 * @param array $context Timber context.
	 * @return array
	 * @since  1.0.0
	 */
	public function add_menus_to_context( array $context ) : array {
		$menus = get_registered_nav_menus();

		foreach ( $menus as $menu => $value ) {
			$context['menus'][ $menu ] = new Menu( $menu );
		}

		return $context;
	}


	/**
	 * Add to context
	 *
	 * @param array $context Timber context.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function add_to_context( array $context ) : array {
		global $wp;

		$context['permalinks']['legal_mentions'] = get_permalink( get_theme_mod( 'legal_mentions' ) );

		$context['partners'] = Timber::get_sidebar( 'partners.php' );
		$context['prices']   = Timber::get_sidebar( 'prices.php' );

		$context['current_url'] = home_url( add_query_arg( array(), $wp->request ) );

		$context['phone_number']    = get_option( 'phone_number' );
		$context['address']         = get_option( 'address' );
		$context['email_addresses'] = get_option( 'email_addresses' );

		$context['recaptcha'] = array(
			'site_key'   => get_option( 'recaptcha_site_key' ),
			'secret_key' => get_option( 'recaptcha_secret_key' ),
		);

		return $context;
	}
}
