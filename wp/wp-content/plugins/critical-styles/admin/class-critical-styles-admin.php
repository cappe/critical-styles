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
	public function add_options_page() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Critical Styles Settings', 'critical-styles' ),
			__( 'Critical Styles', 'critical-styles' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Render the options page for plugin
	 * Copied from https://www.sitepoint.com/wordpress-plugin-boilerplate-part-2-developing-a-plugin/
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/critical-styles-admin-display.php';
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
			$this->option_name . '_position',
			__( 'Text position', 'critical-styles' ),
			array( $this, $this->option_name . '_position_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_position' )
		);

		add_settings_field(
			$this->option_name . '_day',
			__( 'Post is outdated after', 'critical-styles' ),
			array( $this, $this->option_name . '_day_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_day' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_position', array( $this, $this->option_name . '_sanitize_position' ) );
		register_setting( $this->plugin_name, $this->option_name . '_day', 'intval' );
	}

	/**
	 * Sanitize the text position value before being saved to database
	 *
	 * @param  string $position $_POST value
	 * @since  1.0.0
	 * @return string           Sanitized value
	 */
	public function critical_styles_sanitize_position( $position ) {
		if ( in_array( $position, array( 'before', 'after' ), true ) ) {
			return $position;
		}
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
	public function critical_styles_position_cb() {
		$position = get_option( $this->option_name . '_position' );
		?>
		<fieldset>
			<label>
				<input type="radio" name="<?php echo $this->option_name . '_position' ?>" id="<?php echo $this->option_name . '_position' ?>" value="before" <?php checked( $position, 'before' ); ?>>
				<?php _e( 'Before the content', 'critical-styles' ); ?>
			</label>
			<br>
			<label>
				<input type="radio" name="<?php echo $this->option_name . '_position' ?>" value="after" <?php checked( $position, 'after' ); ?>>
				<?php _e( 'After the content', 'critical-styles' ); ?>
			</label>
		</fieldset>
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
