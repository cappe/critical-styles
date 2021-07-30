<?php

class Critical_Styles_Config {
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	private string $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_version The current version of the plugin.
	 */
	private string $plugin_version;

	public function __construct() {
		if ( defined( 'CRITICAL_STYLES_VERSION' ) ) {
			$this->plugin_version = CRITICAL_STYLES_VERSION;
		} else {
			$this->plugin_version = '1.0.0';
		}
		$this->plugin_name = 'critical-styles';
	}

	public function get_plugin_name(): string {
		return $this->plugin_name;
	}

	public function get_plugin_version(): string {
		return $this->plugin_version;
	}
}
