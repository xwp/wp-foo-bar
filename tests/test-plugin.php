<?php

namespace FooBar;

class Test_Plugin extends \WP_UnitTestCase {

	/**
	 * @see Plugin::__construct()
	 */
	function test_construct() {
		$plugin = new Plugin();
		$this->assertInternalType( 'array', $plugin->config );
	}
	
	/**
	 * @see Plugin::init()
	 */
	function test_init() {
		// @todo Add test for config filter
	}
	
	/* ... */
}
