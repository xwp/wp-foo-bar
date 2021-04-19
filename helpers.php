<?php

namespace FooBar;

/**
 * Gets recursively the required vendors from composer.json.
 *
 * @param string $path_to_composer_json The path to an initial `composer.json`.
 *
 * @internal
 * @return string[] The collection of vendors from `required` section from.
 */
function get_required_dependencies( $path_to_composer_json ) {
	if ( ! is_readable( $path_to_composer_json ) ) {
		return [];
	}

	$content = file_get_contents( $path_to_composer_json );

	if ( false === $content ) {
		return [];
	}

	$composer = (array) json_decode( $content, true );

	$required = array_filter(
		array_map(
			static function ( $vendor ) {
				return "vendor/{$vendor}";
			},
			array_keys( $composer['require'] ?? [] )
		),
		'is_readable'
	);

	// Flatten tree of required vendors.
	return array_reduce(
		$required,
		static function ( $required, $vendor_path ) {
			return array_merge(
				$required,
				[ $vendor_path ],
				get_required_dependencies( "$vendor_path/composer.json" )
			);
		},
		[]
	);
}
