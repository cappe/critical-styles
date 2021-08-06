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

	private Critical_Styles_Base_Tab $tab_component;

	public function __construct( Critical_Styles_Config $config ) {
		$this->config = $config;
		$this->set_tab_component();
	}

	public function admin_init() {
		$this->tab_component->admin_init();
	}

	public function set_tab_component() {
		$tab_component = null;

		switch ( $this->current_tab() ) :
			case 'account':
				$tab_component = Critical_Styles_Account_Tab::build( $this->config );
				break;
			case 'your-pages':
			default:
				$tab_component = Critical_Styles_Your_Pages_Tab::build( $this->config );
				break;
		endswitch;

		$this->tab_component = $tab_component;
	}

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
			__( 'Critical Styles Settings', $this->config->plugin_name() ),
			__( 'Critical Styles', $this->config->plugin_name() ),
			'manage_options',
			$this->config->plugin_name(),
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
		$plugin_name = $this->config->plugin_name();
		$current_tab = $this->current_tab();
		$tab_content = Critical_Styles_View_Renderer::render( $this->tab_component );

		include_once 'views/critical-styles-admin-layout.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->config->plugin_name(), plugin_dir_url( __FILE__ ) . 'css/styles.css', array(), $this->config->plugin_version(), 'all' );
	}
//
//	/**
//	 * Register the JavaScript for the admin area.
//	 *
//	 * @since    1.0.0
//	 */
//	public function enqueue_scripts() {
//		wp_enqueue_script( $this->config->plugin_name(), plugin_dir_url( __FILE__ ) . 'js/critical-styles-admin.js', array( 'jquery' ), $this->config->plugin_version(), false );
//	}
}
