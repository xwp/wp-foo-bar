<?php
/**
 * Tests for Plugin_Base.
 *
 * @package FooBar
 */

namespace FooBar;

/**
 * Tests for Plugin_Base.
 *
 * @package FooBar
 */
class Test_Plugin_Base extends \WP_UnitTestCase {

	/**
	 * Plugin instance.
	 *
	 * @var Plugin
	 */
	public $plugin;

	/**
	 * Setup.
	 *
	 * @inheritdoc
	 */
	public function setUp() {
		parent::setUp();
		$this->plugin = get_plugin_instance();
	}

	/**
	 * Test locate_plugin.
	 *
	 * @see Plugin_Base::locate_plugin()
	 */
	public function test_locate_plugin() {
		$location = $this->plugin->locate_plugin();
		$this->assertEquals( 'foo-bar', $location['dir_basename'] );
		$this->assertContains( 'plugins/foo-bar', $location['dir_path'] );
		$this->assertContains( 'plugins/foo-bar', $location['dir_url'] );
	}

	/**
	 * Test relative_path.
	 *
	 * @see Plugin_Base::relative_path()
	 */
	public function test_relative_path() {
		$this->assertEquals( 'plugins/foo-bar', $this->plugin->relative_path( '/srv/www/wordpress-develop/src/wp-content/plugins/foo-bar', 'wp-content', '/' ) );
		$this->assertEquals( 'themes/twentysixteen/plugins/foo-bar', $this->plugin->relative_path( '/srv/www/wordpress-develop/src/wp-content/themes/twentysixteen/plugins/foo-bar', 'wp-content', '/' ) );
	}

	/**
	 * Tests for trigger_warning().
	 *
	 * @see Plugin_Base::trigger_warning()
	 */
	public function test_trigger_warning() {
		$obj = $this;
		set_error_handler( function ( $errno, $errstr ) use ( $obj ) {
			$obj->assertEquals( 'FooBar\Plugin: Param is 0!', $errstr );
			$obj->assertEquals( \E_USER_WARNING, $errno );
		} );
		$this->plugin->trigger_warning( 'Param is 0!', \E_USER_WARNING );
		restore_error_handler();
	}

	/**
	 * Test is_wpcom_vip_prod().
	 *
	 * @see Plugin_Base::is_wpcom_vip_prod()
	 */
	public function test_is_wpcom_vip_prod() {
		if ( ! defined( 'WPCOM_IS_VIP_ENV' ) ) {
			$this->assertFalse( $this->plugin->is_wpcom_vip_prod() );
			define( 'WPCOM_IS_VIP_ENV', true );
		}
		$this->assertEquals( WPCOM_IS_VIP_ENV, $this->plugin->is_wpcom_vip_prod() );
	}
}
