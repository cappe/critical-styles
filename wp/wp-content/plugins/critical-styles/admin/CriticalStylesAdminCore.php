<?php

class Critical_Styles_Admin_Core {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private string $version;

	/**
	 * Settings for this plugin.
	 *
	 * @var Critical_Styles_Config
	 */
	private Critical_Styles_Config $config;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->config      = new Critical_Styles_Config();
	}

	public function admin_init() {
		$this->register_settings();
//		$this->validate_api_token();
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
			__( 'Critical Styles Settings', Critical_Styles_Constants::NAMESPACE() ),
			__( 'Critical Styles', Critical_Styles_Constants::NAMESPACE() ),
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
//		if ($this->valid_api_token) {
//		} else {
//			include_once 'partials/critical-styles-subscribe.php';
//		}
	}

	public function register_settings() {
		$this->prepare_account_details_section();
		$this->prepare_domains_section();
		$this->prepare_billing_section();
	}

	/**
	 * Prepares billing section.
	 */
	public function prepare_billing_section() {
		$section_id = Critical_Styles_Constants::PLUGIN_PREFIX() . '_billing_section';

		add_settings_section(
			$section_id,
			__( 'Billing', Critical_Styles_Constants::NAMESPACE() ),
			array( $this, Critical_Styles_Constants::PLUGIN_PREFIX() . '_billing_header_cb' ),
			$this->plugin_name
		);
	}

	public function critical_styles_billing_header_cb() {
		echo '<p>' . __('Billing (WIP)', Critical_Styles_Constants::NAMESPACE()) . '</p>';
		echo '<p>' . __('Receipts (WIP)', Critical_Styles_Constants::NAMESPACE()) . '</p>';
	}

	/**
	 * Prepares section that contains user's domains.
	 */
	public function prepare_domains_section() {
		$section_id = Critical_Styles_Constants::PLUGIN_PREFIX() . '_domains_section';

		add_settings_section(
			$section_id,
			__( 'Active Domains', Critical_Styles_Constants::NAMESPACE() ),
			array( $this, Critical_Styles_Constants::PLUGIN_PREFIX() . '_domains_header_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			Critical_Styles_Constants::PLUGIN_PREFIX() . '_domains',
			__( 'Domains', Critical_Styles_Constants::NAMESPACE() ),
			array( $this, Critical_Styles_Constants::PLUGIN_PREFIX() . '_domains_cb' ),
			$this->plugin_name,
			$section_id,
		);
	}

	public function critical_styles_domains_header_cb() {
		echo '<p>' . __('Your active domains that are billed monthly', Critical_Styles_Constants::NAMESPACE()) . '</p>';
	}

	public function critical_styles_domains_cb() {
		$domains = $this->config->user->active_domains();
		?>

		<div class="d-flex flex-col">
			<?php foreach ($domains as $domain): ?>
				<div style="margin-top: 4px;">
					<?= $domain->url; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<?php
	}

	/**
	 * Prepares account details section that contains general details of the user's account.
	 */
	public function prepare_account_details_section() {
		$section_id = Critical_Styles_Constants::PLUGIN_PREFIX() . '_account_details';

		add_settings_section(
			$section_id,
			__( 'Account Details', Critical_Styles_Constants::NAMESPACE() ),
			null,
			$this->plugin_name
		);

		add_settings_field(
			Critical_Styles_Constants::PLUGIN_PREFIX() . '_account_details',
			__( 'Email', Critical_Styles_Constants::NAMESPACE() ),
			array( $this, Critical_Styles_Constants::PLUGIN_PREFIX() . '_account_email_cb' ),
			$this->plugin_name,
			$section_id,
		);

		add_settings_field(
			Critical_Styles_Constants::API_TOKEN_OPTION_NAME(),
			__( 'Your API key', Critical_Styles_Constants::NAMESPACE() ),
			array( $this, Critical_Styles_Constants::PLUGIN_PREFIX() . '_api_token_cb' ),
			$this->plugin_name,
			$section_id,
			array( 'label_for' => Critical_Styles_Constants::API_TOKEN_OPTION_NAME() )
		);

		register_setting( $this->plugin_name, Critical_Styles_Constants::API_TOKEN_OPTION_NAME() );
	}

	public function critical_styles_account_email_cb() {
		echo $this->config->user->email;
	}

	public function critical_styles_api_token_cb() {
		$option    = Critical_Styles_Constants::API_TOKEN_OPTION_NAME();
		$api_token = Critical_Styles_Config::api_token();
		?>

		<textarea
			type="text"
			id="<?= $option ?>"
			name="<?= $option ?>"
			placeholder="<?= __( 'Enter your API key here', Critical_Styles_Constants::NAMESPACE() ) ?>"
			style="width: 80%;"
			rows="3"
		><?= $api_token ?></textarea>

<!--		<div>-->
<!--			--><?php
//			var_dump($this->config->user->active_domains());
//			?>
<!--		</div>-->

		<?php
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function critical_styles_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', Critical_Styles_Constants::NAMESPACE() ) . '</p>';
	}
}
