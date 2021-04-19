<?php

use Isolated\Symfony\Component\Finder\Finder;

$required = FooBar\get_required_dependencies( 'composer.json' );

$wp_globals_patcher = XWP\PhpScoper\WordPress\Patcher::create()->finders(
	[
		// Scanning the WordPress Core for global tokens.
		// @see https://github.com/humbug/php-scoper/issues/303
		// @see https://github.com/php-stubs/woocommerce-stubs
		// @see https://github.com/php-stubs/wordpress-stubs
		// @see https://github.com/php-stubs/acf-pro-stubs
		// @see https://github.com/php-stubs/wp-cli-stubs
		Finder::create()->files()->in(
			[
				'../../../wp-admin',
				'../../../wp-includes',
			]
		),
	]
);

// In case if stubs were generated already, we can get a boost in scope performance.
// NOTE: If stubs were provided the patcher won't search for files that were mention in finders.
if ( file_exists( 'php-scope-stubs.json' ) ) {
	$stubs_content = file_get_contents( 'php-scope-stubs.json' );

	if ( false !== $stubs_content ) {
		$wp_globals_patcher->useParsedStubs( (array) json_decode( $stubs_content, true ) );
	}
}

return [
	// See: https://github.com/humbug/php-scoper#prefix
	'prefix'                     => 'FooBar\\Dependencies',

	// See: https://github.com/humbug/php-scoper#patchers.
	'patchers'                   => [
		// This patcher removes globally available WordPress classes and functions from the codebase scope.
		// e.g. "Plugin::register_scripts( FooBar\WP_Scripts $wp_scripts )" -> Plugin::register_scripts( \WP_Scripts $wp_scripts )
		$wp_globals_patcher,
	],

	// See: https://github.com/humbug/php-scoper#finders-and-paths.
	'finders' => array_merge( [
		// You can add more finders e.g. those that outside the vendor folder.
	], array_map( function ( $vendor ) {
		// Third Party vendors
		return Finder::create()
		             ->files()
		             ->ignoreVCS( true )
		             ->ignoreDotFiles( true )
		             ->notName( '/LICENSE|.*\\.md|.*\\.dist|Makefile|composer\\.json|composer\\.lock/' )
		             ->exclude( [
			             'doc',
			             'test',
			             'test_old',
			             'tests',
			             'Tests',
			             'bin',
			             'vendor-bin',
		             ] )
		             ->name( '*.php' )
		             ->in( [ $vendor ] );
	}, $required ) ),

	// See https://github.com/humbug/php-scoper#whitelist.
	'whitelist'                  => [],

	// See https://github.com/humbug/php-scoper#constants--classes--functions-from-the-global-namespace.
	'whitelist-global-constants' => true,
	'whitelist-global-functions' => false,
	'whitelist-global-classes'   => false,
];
