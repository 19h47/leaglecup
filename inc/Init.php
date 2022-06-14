<?php // phpcs:ignore
/**
 * Bootstraps WordPress theme related functions, most importantly enqueuing javascript and styles.
 *
 * @package LeagleCup
 * @subpackage LeagleCup/Init
 */

namespace LeagleCup;

use LeagleCup\{ Core, Setup, Plugins, Custom, Api, Block };

/**
 * Init
 */
class Init {

	/**
	 * Store all the classes inside an array
	 *
	 * @return array Full list of classes
	 */
	public static function get_services() : array {
		return array(
			Setup\Theme::class,
			Setup\Enqueue::class,
			Setup\WordPress::class,
			Setup\Menus::class,
			Setup\Supports::class,
			Setup\Textdomain::class,
			Setup\TermUpdatedMessages::class,
			Api\Customizer\Contact::class,
			Api\Customizer\Link::class,
			Api\Customizer\Recaptcha::class,
			Custom\Extras::class,
			Plugins\Register::class,
			Plugins\ACF\RuleMatch::class,
			Plugins\ACF\RuleTypes::class,
			Plugins\ACF\RuleValues::class,
			Plugins\ACF\Fields\Register::class,
			Plugins\TinyMCE::class,
			Block\Member::class,
			Core\Member::class,
			Core\Partner::class,
			Core\PartnerCategory::class,
			Core\Price::class,
			Core\Message::class,
		);
	}


	/**
	 * Loop through the classes, initialize them, and call the run() method if it exists
	 *
	 * @return void
	 */
	public static function run_services() : void {
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'run' ) ) {
				$service->run();
			}
		}
	}


	/**
	 * Initialize the class
	 *
	 * @param  string $class class name from the services array.
	 * @return object
	 */
	private static function instantiate( string $class ) : object {
		return new $class();
	}
}
