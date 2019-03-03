<?php
/**
 * Class Leagle Cup
 *
 * PHP version 7
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @package LeagleCup
 */

/**
 * Autoload
 */
require_once get_template_directory() . '/vendor/autoload.php';


/**
 * Timber
 *
 * Instanciate Timber
 *
 * @see https://github.com/timber/timber
 */
use Timber\Timber as Timber;
use \Twig_SimpleFunction as Twig_SimpleFunction;


/**
 * Dirname
 *
 * Tell Timber where are views
 */
Timber::$dirname = array( 'views' );


/**
 * LeagleCup
 */
class LeagleCup extends Timber {

	/**
	 * The name of the theme
	 *
	 * @access private
	 * @var    str
	 */
	private $theme_name;


	/**
	 * The version of this theme
	 *
	 * @access private
	 * @var    str
	 */
	private $theme_version;


	/**
	 * Manifest
	 *
	 * @access private
	 * @var    arr
	 */
	private $theme_manifest;


	/**
	 * Construct
	 *
	 * Initialize the class and set its properties.
	 *
	 * @access public
	 * @param  str $theme_name    The theme name.
	 * @param  str $theme_version The theme version.
	 */
	public function __construct( $theme_name, $theme_version ) {
		$this->theme_name    = $theme_name;
		$this->theme_version = $theme_version;

		$this->setup();
		$this->load_dependencies();

		$this->theme_manifest = get_theme_manifest();

		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );

		parent::__construct();
	}


	/**
	 * Load dependencies description
	 *
	 * @access private
	 * @name   load_dependencies
	 */
	private function load_dependencies() {
		include_once get_template_directory() . '/inc/utilities.php';
		include_once get_template_directory() . '/inc/reset.php';
		include_once get_template_directory() . '/inc/template-functions.php';

		include_once get_template_directory() . '/inc/class-admin.php';

		include_once get_template_directory() . '/inc/customizer/contact.php';
		include_once get_template_directory() . '/inc/customizer/link.php';

		include_once get_template_directory() . '/inc/post-types/class-partner.php';
		include_once get_template_directory() . '/inc/post-types/class-price.php';
		include_once get_template_directory() . '/inc/post-types/class-member.php';

		include_once get_template_directory() . '/inc/taxonomies/class-partnercategory.php';

		include_once get_template_directory() . '/inc/block/member/index.php';

		new Partner( $this->get_theme_version() );
		new Price( $this->get_theme_version() );
		new Member( $this->get_theme_version() );

		new PartnerCategory( $this->get_theme_version() );

		new Admin( $this->get_theme_name(), $this->get_theme_version() );

		add_action( 'customize_register', 'leaglecup_customize_contact' );
		add_action( 'customize_register', 'leaglecup_customize_link' );
	}


	/**
	 * Add to Twig
	 *
	 * @param obj $twig Twig environment.
	 * @access public
	 */
	public function add_to_twig( $twig ) {

		if ( function_exists( 'pll__' ) ) {
			$twig->addFunction(
				new Twig_Function(
					'pll__',
					function ( $string ) {
						return pll__( $string );
					}
				)
			);
		}

		if ( function_exists( 'pll_e' ) ) {
			$twig->addFunction(
				new Twig_Function(
					'pll_e',
					function ( $string ) {
						return pll_e( $string );
					}
				)
			);
		}

		if ( function_exists( 'pll_the_languages' ) ) {
			$twig->addFunction(
				new Twig_Function(
					'pll_the_languages',
					function ( $args = '' ) {
						return pll_the_languages( $args );
					}
				)
			);
		}

		if ( function_exists( 'post_class' ) ) {
			$twig->addFunction(
				new Twig_SimpleFunction(
					'post_class',
					function ( $class = '', $post_id = null ) {
						return post_class( $class, $post_id );
					}
				)
			);
		}

		if ( function_exists( 'body_class' ) ) {
			$twig->addFunction(
				new Twig_SimpleFunction(
					'body_class',
					function ( $args = '' ) {
						return body_class( $args );
					}
				)
			);
		}

		if ( function_exists( 'html_class' ) ) {
			$twig->addFunction(
				new Twig_SimpleFunction(
					'html_class',
					function ( $args = '' ) {
						return html_class( $args );
					}
				)
			);
		}

		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$twig->addFunction(
				new Twig_SimpleFunction(
					'yoast_breadcrumb',
					function () {
						return yoast_breadcrumb();
					}
				)
			);
		}

		if ( function_exists( 'get_body_class' ) ) {
			$twig->addFunction(
				new Twig_SimpleFunction(
					'get_body_class',
					function () {
						return get_body_class();
					}
				)
			);
		}

		if ( function_exists( 'do_shortcode' ) ) {
			$twig->addFunction(
				new Twig_SimpleFunction(
					'do_shortcode',
					function ( $id ) {
						return do_shortcode( "[contact-form-7 id=\"{$id}\"]" );
					}
				)
			);
		}

		if ( function_exists( 'wp_get_document_title' ) ) {
			$twig->addFunction(
				new Twig_SimpleFunction(
					'wp_get_document_title',
					function () {
						return wp_get_document_title();
					}
				)
			);
		}

		$twig->addFunction(
			new Twig_SimpleFunction(
				'get_theme_manifest',
				function () {
					return $this->theme_manifest;
				}
			)
		);

		return $twig;
	}


	/**
	 * Add to context
	 *
	 * @param  obj $context Context.
	 * @return $context
	 * @access public
	 */
	public function add_to_context( $context ) {
		global $wp;

		// Menus.
		$menus = get_registered_nav_menus();
		foreach ( $menus as $menu => $value ) {
			$context['menu'][ $menu ] = new TimberMenu( $value );
		}

		// Share and Socials links.
		$socials = array(
			array(
				'title' => 'Facebook',
				'slug'  => 'facebook',
				'name'  => __( 'Partager sur Facebook' ),
				'url'   => 'https://www.facebook.com/sharer.php?u=',
				'link'  => get_option( 'facebook' ),
			),
			array(
				'title' => 'LinkedIn',
				'slug'  => 'linkedin',
				'name'  => __( 'Partager sur LinkedIn' ),
				'url'   => 'https://www.linkedin.com/shareArticle?mini=true&url=',
				'link'  => get_option( 'linkedin' ),
			),
		);

		foreach ( $socials as $social ) {
			// Link.
			if ( ! empty( $social['link'] ) ) {
				$context['contact']['socials'][ $social['slug'] ] = $social;
			}

			// Shares.
			if ( ! empty( $social['url'] ) ) {
				$context['contact']['shares'][ $social['slug'] ] = $social;
			}
		}

		$context['permalinks']['legal_mentions'] = get_permalink( get_theme_mod( 'legal_mentions' ) );

		$context['partners'] = Timber::get_sidebar( 'partners.php' );
		$context['prices']   = Timber::get_sidebar( 'prices.php' );

		$context['current_url'] = home_url( add_query_arg( array(), $wp->request ) );
		$context['manifest']    = $this->theme_manifest;

		return $context;
	}


	/**
	 * Setup
	 *
	 * @access public
	 */
	public function setup() {
		/*
		* Let WordPress manage the document title.
		*/
		add_theme_support( 'title-tag' );

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @see https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Register nav menus.
		register_nav_menus(
			array(
				'main' => __( 'Main' ),
			)
		);

		add_post_type_support( 'page', 'excerpt' );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}





	/**
	 * Enqueue styles.
	 *
	 * @access public
	 */
	public function enqueue_style() {
		wp_dequeue_style( 'wp-block-library' );

		// Theme stylesheet.
		wp_register_style(
			$this->theme_name . '-global',
			get_template_directory_uri() . '/dist/' . $this->theme_manifest['main.css'],
			array(),
			'1.0.0'
		);

		wp_enqueue_style( $this->theme_name . '-global' );
	}


	/**
	 * Enqueue scripts
	 *
	 * @access public
	 */
	public function enqueue_scripts() {

		wp_deregister_script( 'wp-embed' );
		wp_deregister_script( 'jquery' );

		wp_register_script(
			$this->theme_name . '-main',
			get_template_directory_uri() . '/dist/' . $this->theme_manifest['main.js'],
			array(),
			'1.0.0',
			true
		);

		wp_enqueue_script(
			'feature',
			'//cdnjs.cloudflare.com/ajax/libs/feature.js/1.0.1/feature.min.js',
			array(),
			'1.0.0',
			false
		);
		wp_add_inline_script(
			'feature',
			'document.documentElement.className=document.documentElement.className.replace("no-js","js"),feature.touch&&!navigator.userAgent.match(/Trident\/(6|7)\./)&&(document.documentElement.className=document.documentElement.className.replace("no-touch","touch"));'
		);

		wp_enqueue_script( $this->theme_name . '-main' );
	}

	/**
	 * Defer script
	 *
	 * @access public
	 * @param  str $tag    Tag.
	 * @param  str $handle Handle.
	 * @param  str $src    Src.
	 * @return str
	 */
	public function defer_scripts( $tag, $handle, $src ) {
		if ( 'feature' !== $handle ) {
			return $tag;
		}

		return str_replace( ' src', ' defer="defer" src', $tag );
	}


	/**
	 * Retrieve the version number of the theme.
	 *
	 * @since  1.0.0
	 * @return string    The version number of the plugin.
	 */
	public function get_theme_version() {
		return $this->theme_version;
	}


	/**
	 * The name of the theme used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  1.0.0
	 * @return string    The name of the plugin.
	 */
	public function get_theme_name() {
		return $this->theme_name;
	}
}

new LeagleCup( 'lglcup', '1.0.0' );
