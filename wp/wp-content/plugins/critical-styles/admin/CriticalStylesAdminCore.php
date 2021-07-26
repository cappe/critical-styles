<?php

class Critical_Styles_Admin_Core {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since    1.0.0
	 * @access    private
	 * @var    string $option_name Option name of this plugin
	 */
	private $option_name = 'critical_styles';

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	public function admin_init() {
		$this->register_settings();
//		$this->validate_api_key();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Critical_Styles_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Critical_Styles_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/critical-styles-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Critical_Styles_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Critical_Styles_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/critical-styles-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu.
	 * Copied from https://www.sitepoint.com/wordpress-plugin-boilerplate-part-2-developing-a-plugin/
	 *
	 * @since  1.0.0
	 */
	public function admin_menu() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Critical Styles Settings', 'critical-styles' ),
			__( 'Critical Styles', 'critical-styles' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Render the options page for plugin
	 * Copied from https://www.sitepoint.com/wordpress-plugin-boilerplate-part-2-developing-a-plugin/
	 *
	 * @since  1.0.0
	 */
	public function render_settings_page() {
		include_once 'partials/critical-styles-admin-display.php';
//		if ($this->valid_api_key) {
//		} else {
//			include_once 'partials/critical-styles-subscribe.php';
//		}
	}

	public function register_settings() {
		// Add a General section
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'critical-styles' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_api_key',
			__( 'Your API key', 'critical-styles' ),
			array( $this, $this->option_name . '_api_key_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_key' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_api_key' );
	}

	public function critical_styles_api_key_cb() {
		$option = $this->option_name . '_api_key';
		$apiKey = get_option( $option );
		?>

		<textarea
			type="text"
			id="<?= $option ?>"
			name="<?= $option ?>"
			placeholder="<?= __( 'Enter your API key here', 'critical-styles' ) ?>"
			style="width: 80%;"
			rows="3"
		><?= $apiKey ?></textarea>

		<?php
	}
}
