<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/kasperi-keski-loppi-637935142
 * @since      1.0.0
 *
 * @package    Critical_Styles
 * @subpackage Critical_Styles/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Critical_Styles
 * @subpackage Critical_Styles/admin
 * @author     Kasperi Keski-Loppi <kasperi.keski.loppi@gmail.com>
 */
class Critical_Styles_Admin {

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

	private $valid_api_key;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	public function admin_init() {
		$this->register_settings();
		$this->validate_api_key();
	}

	public function validate_api_key() {
		$api_key = get_option( $this->option_name . '_api_key' );
		$this->valid_api_key = Critical_Styles_Ajax::validate_api_key( $api_key );
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
	public function add_as_settings_subpage() {

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
		if ($this->valid_api_key) {
			include_once 'partials/critical-styles-admin-display.php';
		} else {
			include_once 'partials/critical-styles-subscribe.php';
		}

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

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function critical_styles_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'critical-styles' ) . '</p>';
	}

	/**
	 * Render the radio input field for position option
	 *
	 * @since  1.0.0
	 */
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

	/**
	 * Render the treshold day input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function critical_styles_day_cb() {
		$day = get_option( $this->option_name . '_day' );
		echo '<input type="text" name="' . $this->option_name . '_day' . '" id="' . $this->option_name . '_day' . '" value="' . $day . '"> ' . __( 'days', 'critical-styles' );
	}
}
