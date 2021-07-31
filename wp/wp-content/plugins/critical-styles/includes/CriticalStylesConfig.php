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
	 * The unique prefix of this plugin.
	 *
	 * @var string
	 */
	private string $plugin_prefix;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_version The current version of the plugin.
	 */
	private string $plugin_version;

	private Critical_Styles_User $user;

	public function __construct() {
		if ( defined( 'CRITICAL_STYLES_VERSION' ) ) {
			$this->plugin_version = CRITICAL_STYLES_VERSION;
		} else {
			$this->plugin_version = '1.0.0';
		}
		$this->plugin_name = 'critical-styles';
		$this->plugin_prefix = 'critical_styles';
	}

	public function plugin_name(): string {
		return $this->plugin_name;
	}

	public function plugin_version(): string {
		return $this->plugin_version;
	}

	public function plugin_prefix(): string {
		return $this->plugin_prefix;
	}

	public function api_token(): string {
		return get_option( $this->plugin_prefix() . '_api_token' );
	}

	/**
	 * Returns the user.
	 *
	 * User is loaded from the API if it doesn't exist yet.
	 *
	 * @return Critical_Styles_User
	 */
	public function get_user(): Critical_Styles_User {
		if ( ! isset($this->user) ) {
			$this->user = Critical_Styles_User::load_user( $this->api_token() );
		}

		return $this->user;
	}
}
