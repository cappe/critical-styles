<?php

class Critical_Styles_Admin_Core {
	private Critical_Styles_Base_Tab $tab_component;

	public function __construct() {
		$this->set_tab_component();
	}

	public function admin_init() {
		$this->tab_component->admin_init();
	}

	public function set_tab_component() {
		$tab_component = null;

		switch ( $this->current_tab() ) :
			case 'account':
				$tab_component = Critical_Styles_Account_Tab::build();
				break;
			case 'your-pages':
			default:
				$tab_component = Critical_Styles_Your_Pages_Tab::build();
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
			__( 'Critical Styles Settings', Critical_Styles_Config::get()->plugin_name() ),
			__( 'Critical Styles', Critical_Styles_Config::get()->plugin_name() ),
			'manage_options',
			Critical_Styles_Config::get()->plugin_name(),
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
		$plugin_name = Critical_Styles_Config::get()->plugin_name();
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
		wp_enqueue_style( Critical_Styles_Config::get()->plugin_name(), plugin_dir_url( __FILE__ ) . 'css/styles.css', array(), Critical_Styles_Config::get()->plugin_version(), 'all' );
	}
//
//	/**
//	 * Register the JavaScript for the admin area.
//	 *
//	 * @since    1.0.0
//	 */
//	public function enqueue_scripts() {
//		wp_enqueue_script( Critical_Styles_Config::get()->plugin_name(), plugin_dir_url( __FILE__ ) . 'js/critical-styles-admin.js', array( 'jquery' ), Critical_Styles_Config::get()->plugin_version(), false );
//	}
}
