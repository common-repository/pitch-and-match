<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://pitchandmatch.com/
 * @since      1.0.0
 *
 * @package    Pmwpp
 * @subpackage Pmwpp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pmwpp
 * @subpackage Pmwpp/admin
 * @author     Pitch and Match <contact@pitchandmatch.com>
 */
class Pmwpp_Admin {

    /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $ws;

	private $eventId;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
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
		 * defined in Pmwpp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pmwpp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'dist/css/pmwpp-admin.css', array(),
            $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pmwpp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pmwpp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'dist/js/pmwpp-admin.js', array('jquery'),
            $this->version, false);
	}

	/**
	 *
	 * admin/class-wp-cbf-admin.php - Don't add this
	 *
	 **/

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

		/*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
		add_options_page(
		    esc_html__('Pitch and Match', $this->plugin_name ),
            esc_html__('Pitch and Match', $this->plugin_name ),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
		/*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . esc_html__('Settings', $this->plugin_name) . '</a>',
		);
		return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {

	    $view = new PmwppSettings( $this->plugin_name );
        $view->display();
	}

	public function validate($input) {

		return array();
	}

	public function options_update() {
		register_setting($this->plugin_name, $this->plugin_name);
	}

    public function getPluginName() {
        return $this->plugin_name;
    }

    public function PmwppListEntities() {
        register_widget( 'PmwppListEntities' );
    }

    public function PmwppCallToAction() {
        register_widget( 'PmwppCallToAction' );
    }

    public function show_settings_ajax_callback() {

        $view = new PmwppSettings( $this->plugin_name );
        $view->display();
        die();
    }

    public function list_entities_ajax_callback() {

	    if (
            isset($_GET['data']) &&
            isset($_GET['data']['widget'])
        ) {
	        $instanceId = $_GET['data']['widget'];

            $view = new PmwppListEntities();
            $listEntitiesTypeInstances = $view->get_settings();
            $thisInstance = $listEntitiesTypeInstances[ $instanceId ];
            $view->display($thisInstance);
        }
        else {
            echo "<h3>" . esc_html__('Wrong widget ID!', $this->plugin_name ) . "</h3>";
        }

        die();
    }

}
