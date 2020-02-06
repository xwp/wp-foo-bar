<?php
/**
 * Bootstraps the Foo Bar plugin.
 *
 * @package FooBar
 */

namespace FooBar;

/**
 * Main plugin bootstrap file.
 */
class Plugin extends Plugin_Base {

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
	}

	/**
	 * Load Gutenberg assets.
	 *
	 * @action enqueue_block_editor_assets
	 */
	public function enqueue_editor_assets() {
		wp_enqueue_script(
			'wp-foo-bar-js',
			$this->plugin->asset_url( 'js/dist/editor.js' ),
			[
				'lodash',
				'react',
				'wp-block-editor',
			],
			$this->plugin->asset_version(),
			false
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
