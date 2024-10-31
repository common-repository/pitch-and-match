<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://pitchandmatch.com/
 * @since      1.0.0
 *
 * @package    Pmwpp
 * @subpackage Pmwpp/includes
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
 * @package    Pmwpp
 * @subpackage Pmwpp/includes
 * @author     Pitch and Match <contact@pitchandmatch.com>
 */
class Pmwpp {

    const OPTION_APIKEY = 'pmwpp_apikey';

    const OPTION_EVENTID = 'pmwpp_eventid';

    /**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Pmwpp_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

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

		$this->plugin_name = 'pmwpp';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Pmwpp_Loader. Orchestrates the hooks of the plugin.
	 * - Pmwpp_i18n. Defines internationalization functionality.
	 * - Pmwpp_Admin. Defines all hooks for the admin area.
	 * - Pmwpp_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pmwpp-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pmwpp-i18n.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pmwpp-api.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pmwpp-integration.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pmwpp-settings.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pmwpp-list-entities.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pmwpp-call-to-action.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pmwpp-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pmwpp-public.php';

		$this->loader = new Pmwpp_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Pmwpp_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Pmwpp_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Pmwpp_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		$this->loader->add_action('admin_init', $plugin_admin, 'options_update');

        $this->loader->add_action( 'widgets_init', $plugin_admin, 'PmwppListEntities');
        $this->loader->add_action( 'widgets_init', $plugin_admin, 'PmwppCallToAction');

        $this->loader->add_action( 'wp_ajax_pmwpp_show_settings', $plugin_admin, 'show_settings_ajax_callback' );
        $this->loader->add_action( 'wp_ajax_nopriv_pmwpp_show_settings', $plugin_admin, 'show_settings_ajax_callback' );
        $this->loader->add_action( 'wp_ajax_pmwpp_list_entities', $plugin_admin, 'list_entities_ajax_callback' );
        $this->loader->add_action( 'wp_ajax_nopriv_pmwpp_list_entities', $plugin_admin, 'list_entities_ajax_callback' );
    }

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Pmwpp_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
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
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Pmwpp_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
