<?php

namespace FooBar;

class Test_Plugin_Base extends \WP_UnitTestCase {

	/**
	 * @var Plugin
	 */
	public $plugin;

	function setUp() {
		parent::setUp();
		$this->plugin = get_plugin_instance();
	}

	/**
	 * @see Plugin_Base::locate_plugin()
	 */
	function test_locate_plugin() {
		$location = $this->plugin->locate_plugin();
		$this->assertEquals( 'foo-bar', $location['dir_basename'] );
		$this->assertContains( 'plugins/foo-bar', $location['dir_path'] );
		$this->assertContains( 'plugins/foo-bar', $location['dir_url'] );
	}

	/**
	 * @see Plugin_Base::trigger_warning()
	 */
	function test_trigger_warning() {
		$obj = $this;
		set_error_handler( function ( $errno, $errstr ) use( $obj ) {
			$obj->assertEquals( 'FooBar\Plugin: Param is 0!', $errstr );
			$obj->assertEquals( \E_USER_WARNING, $errno );
    } );
		$this->plugin->trigger_warning( 'Param is 0!', \E_USER_WARNING );
		restore_error_handler();
	}

	/**
	 * @see Plugin_Base::is_wpcom_vip_prod()
	 */
	function test_is_wpcom_vip_prod() {
		$this->assertFalse( $this->plugin->is_wpcom_vip_prod() );
	}

	/**
	 * @see Plugin_Base::is_wpcom_vip_prod()
	 */
	function test_is_wpcom_vip_prod_true() {
		define( 'WPCOM_IS_VIP_ENV', true );
		$this->assertTrue( $this->plugin->is_wpcom_vip_prod() );
	}
}
