<?php
/**
 * Bootstraps the Foo Bar plugin.
 *
 * @package FooBar
 */

namespace FooBar;

use FooBar\BazBar\Sample;

/**
 * Main plugin bootstrap file.
 */
class Plugin extends Plugin_Base {

	/**
	 * Sample class.
	 *
	 * @var Sample
	 */
	public $sample;

	/**
	 * Initiate the plugin resources.
	 *
	 * Priority is 9 because WP_Customize_Widgets::register_settings() happens at
	 * after_setup_theme priority 10. This is especially important for plugins
	 * that extend the Customizer to ensure resources are available in time.
	 *
	 * @action after_setup_theme, 9
	 */
	public function init() {
		$this->config = apply_filters( 'foo_bar_plugin_config', $this->config, $this );

		$this->sample = new Sample( $this );
		$this->sample->init();
	}

	/**
	 * Load Gutenberg assets.
	 *
	 * @action enqueue_block_editor_assets
	 */
	public function enqueue_block_editor_assets() {
		wp_enqueue_script(
			'wp-foo-bar-block-editor-js',
			$this->asset_url( 'assets/js/block-editor.js' ),
			[
				'lodash',
				'react',
				'wp-block-editor',
			],
			$this->asset_version(),
			false
		);

		wp_enqueue_style(
			'wp-foo-bar-block-editor-css',
			$this->asset_url( 'assets/css/block-editor-compiled.css' ),
			[],
			$this->asset_version()
		);
	}

	/**
	 * Enqueue front-end styles and scripts.
	 *
	 * @action wp_enqueue_scripts
	 */
	public function enqueue_front_end_assets() {
		wp_enqueue_script(
			'wp-foo-bar-front-end-js',
			$this->asset_url( 'assets/js/front-end.js' ),
			[],
			$this->asset_version(),
			true
		);

		wp_enqueue_style(
			'wp-foo-bar-front-end-css',
			$this->asset_url( 'assets/css/front-end-compiled.css' ),
			[],
			$this->asset_version()
		);
	}

	/**
	 * Register Customizer scripts.
	 *
	 * @action wp_default_scripts, 11
	 *
	 * @param \WP_Scripts $wp_scripts Instance of \WP_Scripts.
	 */
	public function register_scripts( \WP_Scripts $wp_scripts ) {}

	/**
	 * Register Customizer styles.
	 *
	 * @action wp_default_styles, 11
	 *
	 * @param \WP_Styles $wp_styles Instance of \WP_Styles.
	 */
	public function register_styles( \WP_Styles $wp_styles ) {}
}
