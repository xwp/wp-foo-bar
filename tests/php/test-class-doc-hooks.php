<?php
/**
 * Test_Doc_hooks class.
 *
 * @package FooBar
 */

namespace FooBar;

/**
 * Test_Doc_hooks class.
 */
class Test_Doc_Hooks {

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
