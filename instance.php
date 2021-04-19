<?php
/**
 * Instantiates the Foo Bar plugin
 *
 * @package FooBar
 */

namespace FooBar;

/**
 * Include composer autoload.php.
 *
 * @return bool
 */
function autoload() {

	$autoloader = __DIR__ . '/php/vendor/autoload.php';

	// If built vendor is not yet available use a root fallback.
	if ( ! file_exists( $autoloader ) ) {
		$autoloader = __DIR__ . '/vendor/autoload.php';
	}

	if ( file_exists( $autoloader ) ) {
		require $autoloader;
	}

	$autoloader_dependencies = __DIR__ . '/dependencies/vendor/autoload.php';

	if ( file_exists( $autoloader_dependencies ) ) {
		require $autoloader_dependencies;
	}

	return class_exists( Plugin::class );
}

if ( ! autoload() ) {
	return;
}

global $foo_bar_plugin;

$foo_bar_plugin = new Plugin();

/**
 * Foo Bar Plugin Instance
 *
 * @return Plugin
 */
function get_plugin_instance() {
	global $foo_bar_plugin;
	return $foo_bar_plugin;
}
