<?php

class Test_Foo_Bar extends WP_UnitTestCase {

	/**
	 * @see foo_bar_php_version_error()
	 */
	function test_foo_bar_php_version_error() {
		ob_start();
		foo_bar_php_version_error();
		$buffer = ob_get_clean();
		$this->assertContains( '<div class="error">', $buffer );
	}

	/**
	 * @see foo_bar_php_version_text()
	 */
	function test_foo_bar_php_version_text() {
		$this->assertContains( 'Foo Bar plugin error:', foo_bar_php_version_text() );
	}
}
