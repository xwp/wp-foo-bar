<?php
/**
 * Instantiates the Foo Bar plugin
 *
 * @package FooBar
 */

namespace FooBar;

global $foo_bar_plugin;

require_once __DIR__ . '/php/class-plugin-base.php';
require_once __DIR__ . '/php/class-plugin.php';

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
