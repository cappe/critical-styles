<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.linkedin.com/in/kasperi-keski-loppi-637935142
 * @since      1.0.0
 *
 * @package    Critical_Styles
 * @subpackage Critical_Styles/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Critical_Styles
 * @subpackage Critical_Styles/includes
 * @author     Kasperi Keski-Loppi <kasperi.keski.loppi@gmail.com>
 */
class Critical_Styles_Core {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Critical_Styles_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected Critical_Styles_Loader $loader;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->load_dependencies();

		if ( is_admin() ) {
			$this->define_admin_hooks();
		} else {
			$this->define_public_hooks();
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * Includes (common/shared files)
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/CriticalStylesConfig.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/CriticalStylesLoader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/CriticalStylesHttpRequest.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/CriticalStylesGetRequest.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/CriticalStylesPostRequest.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/CriticalStylesApiHandler.php';

		/**
		 * Admin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/traits/CriticalStylesOwnerTrait.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/traits/CriticalStylesIndexTrait.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/traits/CriticalStylesCreateTrait.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CriticalStylesAdminCore.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CriticalStylesViewable.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CriticalStylesViewRenderer.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CriticalStylesBaseTab.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CriticalStylesAccountTab.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CriticalStylesYourPagesTab.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CriticalStylesUser.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CriticalStylesDomain.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CriticalStylesWebpage.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CriticalStylesWebpageCollection.php';

		/**
		 * Public
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/CriticalStylesPublicCore.php';

		$this->loader = new Critical_Styles_Loader();
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Critical_Styles_Admin_Core();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
//		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_init' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Critical_Styles_Public_Core();

		$this->loader->add_filter( 'style_loader_tag', $plugin_public, 'style_loader_tag', 10, 4 );
		$this->loader->add_action( 'wp_head', $plugin_public, 'wp_head' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Critical_Styles_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader(): Critical_Styles_Loader {
		return $this->loader;
	}
}
