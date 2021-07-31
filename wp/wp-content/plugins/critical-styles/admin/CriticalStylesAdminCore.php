<?php

class Critical_Styles_Admin_Core {
	/**
	 * Config
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Critical_Styles_Config $config The current version of this plugin.
	 */
	private Critical_Styles_Config $config;

	public function __construct( Critical_Styles_Config $config ) {
		$this->config = $config;
	}

	public function admin_init() {}

	public function current_tab(): ?string {
		return isset( $_GET['tab'] ) ? $_GET['tab'] : null;
	}

	/**
	 * Add an options page under the Settings submenu.
	 *
	 * @since  1.0.0
	 */
	public function admin_menu() {
		add_options_page(
			__( 'Critical Styles Settings', $this->config->get_plugin_name() ),
			__( 'Critical Styles', $this->config->get_plugin_name() ),
			'manage_options',
			$this->config->get_plugin_name(),
			array( $this, 'admin_layout_view' )
		);
	}

	/**
	 * Render the admin layout for plugin.
	 *
	 * Defines all the required view variables.
	 *
	 * @since  1.0.0
	 */
	public function admin_layout_view() {
		$plugin_name = $this->config->get_plugin_name();
		$current_tab = $this->current_tab();
		$tab_component = null;

		switch ( $current_tab ) :
			case 'account':
				$tab_component = Critical_Styles_Account_Tab::build();
				break;
			case 'your-pages':
			default:
				$tab_component = Critical_Styles_Your_Pages_Tab::build();
				break;
		endswitch;

		$html = Critical_Styles_View_Renderer::render($tab_component);

		include_once 'views/critical-styles-admin-layout.php';
	}

//	/**
//	 * Register the stylesheets for the admin area.
//	 *
//	 * @since    1.0.0
//	 */
//	public function enqueue_styles() {
//		wp_enqueue_style( $this->config->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'css/critical-styles-admin.css', array(), $this->config->get_plugin_version(), 'all' );
//	}
//
//	/**
//	 * Register the JavaScript for the admin area.
//	 *
//	 * @since    1.0.0
//	 */
//	public function enqueue_scripts() {
//		wp_enqueue_script( $this->config->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'js/critical-styles-admin.js', array( 'jquery' ), $this->config->get_plugin_version(), false );
//	}
}
