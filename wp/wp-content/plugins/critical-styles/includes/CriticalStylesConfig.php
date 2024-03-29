<?php

class Critical_Styles_Config {

	/**
	 * The unique instance of the plugin.
	 *
	 * @var Critical_Styles_Config
	 */
	private static Critical_Styles_Config $instance;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	private string $plugin_name = 'critical-styles';

	/**
	 * The unique prefix of this plugin.
	 *
	 * @var string
	 */
	private string $plugin_prefix = 'critical_styles';

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
	}

	// TODO: Make config object singleton throughout the whole plugin.

	/**
	 * Gets an instance of our plugin.
	 *
	 * @return Critical_Styles_Config
	 */
	public static function get(): Critical_Styles_Config {
		if ( !isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
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

	public function current_domain(): ?Critical_Styles_Domain {
		$current_url = preg_replace('#^https?://#i', '', site_url());

		foreach ( $this->user->get_domains() as $domain ) {
			if ( $domain->url == $current_url ) {
				return $domain;
			}
		}

		return null;
	}

	public function cacheDir(): string {
		$dir = WP_CONTENT_DIR . '/cache/critical-styles';

		if ( ! file_exists( $dir ) ) {
			@mkdir( $dir, 0755, true );
		}

		// TODO: Handle this case somehow
//		if ( ! is_writable( $dir ) ) {
//			return false;
//		}

		return $dir;
	}
}
