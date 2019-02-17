<?php

/**
 * LEAGLE CUP functions and definitions
 *
 * @see https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package     LeagleCup
 * @since       1.0.0
 *
 * Functions'prefix is lglcp_
 */


/**
 * Autoload
 */
require_once( __DIR__ . '/vendor/autoload.php' );


/**
 * Timber
 *
 * Instanciate Timber
 *
 * @see         https://github.com/timber/timber
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
 * class LeagleCup
 */
class LeagleCup extends Timber {

	/**
	 * The name of the theme
	 *
	 * @access private
	 */
	private $theme_name;


	/**
	 * The version of this theme
	 *
	 * @access private
	 */
	private $theme_version;


	/**
	 * Manifest
	 *
	 * @access private
	 */
	private $theme_manifest;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @param  $theme_name
	 * @param  $theme_version
	 * @access public
	 */
	public function __construct( $theme_name, $theme_version ) {

		$this->theme_name = $theme_name;
		$this->theme_version = $theme_version;
		$this->theme_manifest = json_decode(
			file_get_contents( __DIR__ . '/dist/manifest.json' ),
			true
		);

		$this->setup();
		$this->load_dependencies();

		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );

		parent::__construct();
	}


	/**
	 * Load dependencies description
	 *
	 * @access private
	 */
	private function load_dependencies() {
		require_once get_template_directory() . '/inc/utilities.php';
		require_once get_template_directory() . '/inc/reset.php';
		require_once get_template_directory() . '/inc/post-template.php';

		require_once get_template_directory() . '/inc/Admin.php';

		// require_once get_template_directory() . '/inc/acf.php';

		require_once get_template_directory() . '/inc/customizer/contact.php';

		require_once get_template_directory() . '/inc/post-types/Partner.php';

		require_once get_template_directory() . '/inc/taxonomies/PartnerCategory.php';

		new Partner( $this->get_theme_name(), $this->get_theme_version() );

		new PartnerCategory( $this->get_theme_name(), $this->get_theme_version() );

		new Admin( $this->get_theme_name(), $this->get_theme_version() );

		// Customizer
		add_action( 'customize_register', 'lgcp_customize_contact' );
	}


	/**
	 * Add to Twig
	 */
	public function add_to_twig( $twig ) {

		// Polylang
		if ( function_exists( 'pll__' ) ) {
			$twig->addFunction( new Twig_Function( 'pll__', function( $string ) {
				return pll__( $string );
			} ) );
		}

		if ( function_exists( 'pll_e' ) ) {
			$twig->addFunction( new Twig_Function( 'pll_e', function( $string ) {
				return pll_e( $string );
			} ) );
		}

		if ( function_exists( 'pll_the_languages' ) ) {
			$twig->addFunction( new Twig_Function( 'pll_the_languages', function( $args = '' ) {
				return pll_the_languages( $args );
			} ) );
		}


		if ( function_exists( 'post_class' ) ) {
			$twig->addFunction( new Twig_SimpleFunction( 'post_class', function( $class = '', $post_id = null ) {
				return post_class( $class, $post_id );
			} ) );
		}


		if ( function_exists( 'body_class' ) ) {
			$twig->addFunction( new Twig_SimpleFunction( 'body_class', function( $args = '' ) {
				return body_class( $args );
			} ) );
		}


		if ( function_exists( 'html_class' ) ) {
			$twig->addFunction( new Twig_SimpleFunction( 'html_class', function( $args = '' ) {
				return html_class( $args );
			} ) );
		}


		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$twig->addFunction( new Twig_SimpleFunction( 'yoast_breadcrumb', function() {
				return yoast_breadcrumb();
			} ) );
		}


		if ( function_exists( 'get_body_class' ) ) {
			$twig->addFunction( new Twig_SimpleFunction( 'get_body_class', function() {
				return get_body_class();
			} ) );
		}

		if ( function_exists ( 'do_shortcode' ) ) {
			$twig->addFunction( new Twig_SimpleFunction( 'do_shortcode', function( $id ) {
				return do_shortcode( "[contact-form-7 id=\"{$id}\"]" );
			} ) );
		}

		if ( function_exists( 'wp_get_document_title' ) ) {
			$twig->addFunction( new Twig_SimpleFunction( 'wp_get_document_title', function() {
				return wp_get_document_title();
			} ) );
		}

		$twig->addFunction(
			new Twig_SimpleFunction(
				'get_theme_manifest',
				function() {
					return $this->theme_manifest;
				}
			)
		);


		return $twig;
	}


	/**
	 * Add to context
	 *
	 * @return  $context
	 * @access  public
	 */
	public function add_to_context( $context ) {
		global $wp;

		// Menus
		$menus = get_registered_nav_menus();
		foreach ( $menus as $menu => $value ) {
			$context['menu'][$menu] = new TimberMenu( $value );
		}

		// Share and Socials links
		$socials = array(
			array(
				'title'     => 'Facebook',
				'slug'      => 'facebook',
				'name'      => __( 'Partager sur Facebook' ),
				'url'       => 'https://www.facebook.com/sharer.php?u=',
				'link'      => get_option( 'facebook' )
			),
			array(
				'title'     => 'LinkedIn',
				'slug'      => 'linkedin',
				'name'      => __( 'Partager sur LinkedIn' ),
				'url'       => 'https://www.linkedin.com/shareArticle?mini=true&url=',
				'link'      => get_option( 'linkedin' )
			)
		);

		foreach ( $socials as $social ) {
			// Link
			if ( ! empty( $social['link'] ) ) {
				$context['contact']['socials'][$social['slug']] = $social;
			}

			// Shares
			if ( ! empty( $social['url'] ) ) {
				$context['contact']['shares'][$social['slug']] = $social;
			}
		}

		$context['partners'] = Timber::get_sidebar( 'partners.php' );

		$context['current_url'] = home_url( add_query_arg( array(), $wp->request ) );
		$context['manifest'] = $this->theme_manifest;


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


		// Register nav menus
		register_nav_menus(
			array(
				'main'          => __( 'Main' ),
			)
		);


		/**
		 * Add excerpt on page
		 *
		 * @see  https://codex.wordpress.org/Function_Reference/add_post_type_support
		 */
		add_post_type_support( 'page', 'excerpt' );


		add_action( 'wp_head', array( $this, 'javascript_detection' ), 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Add favicons
		add_action( 'wp_head', array( $this, 'favicons' ) );
	}


	/**
	 * Enqueue styles.
	 *
	 * @access public
	 */
	public function enqueue_style() {
		// Add custom fonts, used in the main stylesheet.
		$webfonts = array();
		foreach ( $this->webfonts() as $name => $url ) {
			wp_register_style( 'font-' . $name, $url, array(), null );
			$webfonts[] = 'font-' . $name;
		}

		/**
		 * Theme stylesheet
		 */
		wp_register_style(
			$this->theme_name . '-global',
			get_template_directory_uri() . '/dist/' . $this->theme_manifest['main.css'],
			$webfonts,
			null
		);

		wp_enqueue_style( $this->theme_name . '-global' );
	}


	/**
	 * List webfonts used by the theme.
	 *
	 * @return array
	 * @access public
	 */
	public function webfonts() {
		return array();
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
			null,
			true
		);

		wp_enqueue_script( $this->theme_name . '-main' );
	}


	/**
	 * Handles JavaScript detection.
	 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
	 *
	 * @access public
	 */
	public function javascript_detection() {
	?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/feature.js/1.0.1/feature.min.js"></script>
		<script>
			document.documentElement.className = document.documentElement.className.replace('no-js', 'js');

			if (feature.touch && !navigator.userAgent.match(/Trident\/(6|7)\./)) {
				document.documentElement.className = document.documentElement.className.replace('no-touch', 'touch');
			}
		</script>
	<?php
	}


	/**
	 * Add all favicon metas in <head>
	 *
	 * @see  http://realfavicongenerator.net/
	 */
	function favicons() {
		?>
		<!-- Favicons -->
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() ?>/dist/favicons/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri() ?>/dist/favicons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri() ?>/dist/favicons/favicon-16x16.png">
		<link rel="manifest" href="<?php echo get_template_directory_uri() ?>/dist/favicons/site.webmanifest">
		<link rel="mask-icon" href="<?php echo get_template_directory_uri() ?>/dist/favicons/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="theme-color" content="#ffffff">
		<!-- / Favicons -->
		<?php
	}



	/**
	 * Retrieve the version number of the theme.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_theme_version() {
		return $this->theme_version;
	}


	/**
	 * The name of the theme used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_theme_name() {
		return $this->theme_name;
	}
}


/**
 * Begins execution of the theme.
 */
$theme = new LeagleCup( 'rbxhrns', '1.0.0' );
