<?php
/**
 * Test_Foo_Bar
 *
 * @package FooBar
 */

namespace FooBar;

/**
 * Class Test_Foo_Bar
 *
 * @package FooBar
 */
class Test_Foo_Bar extends \WP_UnitTestCase {

	/**
	 * Test _foo_bar_php_version_error().
	 *
	 * @see _foo_bar_php_version_error()
	 */
	public function test_foo_bar_php_version_error() {
		ob_start();
		_foo_bar_php_version_error();
		$buffer = ob_get_clean();
		$this->assertContains( '<div class="error">', $buffer );
	}

	/**
	 * Test _foo_bar_php_version_text().
	 *
	 * @see _foo_bar_php_version_text()
	 */
	public function test_foo_bar_php_version_text() {
		$this->assertContains( 'Foo Bar plugin error:', _foo_bar_php_version_text() );
	}
}
