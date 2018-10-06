<?php
/**
 * Loads the wp-tests-config.php file.
 *
 * @package FooBar
 */

$config = getenv( 'WP_TESTS_CONFIG' );

/**
 * Supports loading the wp-tests-config.php from a non VVV custom directory.
 */
if ( file_exists( $config ) ) {
	include_once $config;
	return;
}

// VVV Paths.
$autoload_path   = dirname( __FILE__ );
$wp_tests_config = substr( $autoload_path, 0, strpos( $autoload_path, 'public_html' ) + 11 ) . '/wp-tests-config.php';

/**
 * Supports loading the wp-tests-config.php from the `public_html` root directory of both the
 * `wordpress-default` and `wordpress-develop` sites, and any other custom site in the www directory.
 */
if ( file_exists( $wp_tests_config ) ) {
	include_once $wp_tests_config;
}
