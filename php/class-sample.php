<?php
/**
 * Sample class.
 *
 * @package FooBar
 */

namespace FooBar;

use FooBar\BarBaz\Sample as SubSample;

/**
 * Sample class.
 */
class Sample {

	/**
	 * Plugin class.
	 *
	 * @var Plugin
	 */
	public $plugin;

	/**
	 * Sample class from a sub-namespace
	 *
	 * @var SubSample
	 */
	public $sub_sample;

	/**
	 * Constructor.
	 *
	 * @access public
	 *
	 * @param Plugin    $plugin     Plugin instance.
	 * @param SubSample $sub_sample SubSample instance.
	 */
	public function __construct( Plugin $plugin, SubSample $sub_sample ) {
		$this->plugin     = $plugin;
		$this->sub_sample = $sub_sample;
	}

	/**
	 * Initiate the class.
	 *
	 * @access public
	 */
	public function init() {
		$this->plugin->add_doc_hooks( $this );
	}

	/**
	 * Demonstrate doc hooks.
	 *
	 * @filter body_class, 99, 1
	 *
	 * @param array $classes Body classes.
	 *
	 * @return array
	 */
	public function body_class( $classes ) {
		return array_merge( $classes, [ 'custom-class-name' ] );
	}
}
