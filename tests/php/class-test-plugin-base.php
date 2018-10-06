<?php
/**
 * Tests for Plugin_Base.
 *
 * @package FooBar
 */

namespace FooBar;

/**
 * Tests for Plugin_Base.
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
		// phpcs:disable
		set_error_handler(
			function( $errno, $errstr ) use ( $obj ) {
				$obj->assertEquals( 'FooBar\Plugin: Param is 0!', $errstr );
				$obj->assertEquals( \E_USER_WARNING, $errno );
			}
		);
		// phpcs:enable
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

	/**
	 * Test add_doc_hooks().
	 *
	 * @see Plugin_Base::add_doc_hooks()
	 */
	public function test_add_doc_hooks() {
		$object = new Test_Doc_Hooks();

		$this->assertEquals( 10, has_action( 'init', array( $object, 'init_action' ) ) );
		$this->assertEquals( 10, has_action( 'the_content', array( $object, 'the_content_filter' ) ) );
		$object->remove_doc_hooks( $object );
	}

	/**
	 * Test add_doc_hooks().
	 *
	 * @see Plugin_Base::add_doc_hooks()
	 */
	public function test_add_doc_hooks_error() {
		$mock = $this->getMockBuilder( 'FooBar\Plugin' )
			->setMethods( array( 'is_wpcom_vip_prod' ) )
			->getMock();

		$mock->method( 'is_wpcom_vip_prod' )
			->willReturn( false );

		$this->assertFalse( $mock->is_wpcom_vip_prod() );

		$obj = $this;
		// phpcs:disable
		set_error_handler(
			function( $errno, $errstr ) use ( $obj, $mock ) {
				$obj->assertEquals( sprintf( 'The add_doc_hooks method was already called on %s. Note that the Plugin_Base constructor automatically calls this method.', get_class( $mock ) ), $errstr );
				$obj->assertEquals( \E_USER_NOTICE, $errno );
			}
		);
		// phpcs:enable
		$mock->add_doc_hooks();
		restore_error_handler();

		$mock->remove_doc_hooks();
	}

	/**
	 * Test remove_doc_hooks().
	 *
	 * @see Plugin_Base::remove_doc_hooks()
	 */
	public function test_remove_doc_hooks() {
		$object = new Test_Doc_Hooks();
		$this->assertEquals( 10, has_action( 'init', array( $object, 'init_action' ) ) );
		$this->assertEquals( 10, has_action( 'the_content', array( $object, 'the_content_filter' ) ) );

		$object->remove_doc_hooks( $object );
		$this->assertFalse( has_action( 'init', array( $object, 'init_action' ) ) );
		$this->assertFalse( has_action( 'the_content', array( $object, 'the_content_filter' ) ) );
	}

	/**
	 * Test __destruct().
	 *
	 * @see Plugin_Base::__destruct()
	 */
	public function test___destruct() {
		$object = new Test_Doc_Hooks();
		$this->assertEquals( 10, has_action( 'init', array( $object, 'init_action' ) ) );
		$this->assertEquals( 10, has_action( 'the_content', array( $object, 'the_content_filter' ) ) );

		$object->__destruct( $object );
		$this->assertFalse( has_action( 'init', array( $object, 'init_action' ) ) );
		$this->assertFalse( has_action( 'the_content', array( $object, 'the_content_filter' ) ) );
	}
}

// phpcs:disable
/**
 * Test_Doc_Hooks class.
 */
class Test_Doc_Hooks extends Plugin {

	/**
	 * Load this on the init action hook.
	 *
	 * @action init
	 */
	public function init_action() {}

	/**
	 * Load this on the the_content filter hook.
	 *
	 * @filter the_content
	 *
	 * @param string $content The content.
	 * @return string
	 */
	public function the_content_filter( $content ) {
		return $content;
	}
}
// phpcs:enable
