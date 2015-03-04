<?php

namespace FooBar;

/**
 * Main plugin bootstrap file.
 */
class Plugin extends Plugin_Base {

	/**
	 * @param array $config
	 */
	public function __construct( $config = array() ) {

		$default_config = array(
			// ...
		);

		$this->config = array_merge( $default_config, $config );

		add_action( 'after_setup_theme', array( $this, 'init' ) );

		parent::__construct(); // autoload classes and set $slug, $dir_path, and $dir_url vars
	}

	/**
	 * @action after_setup_theme
	 */
	function init() {
		$this->config = \apply_filters( 'foo_bar_plugin_config', $this->config, $this );
	}
}
