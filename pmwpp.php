<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://pitchandmatch.com/
 * @since             1.0.0
 * @package           Pmwpp
 *
 * @wordpress-plugin
 * Plugin Name:       Pitch and Match Widgets
 * Plugin URI:        https://pitchandmatch.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Pitch and Match
 * Author URI:        https://pitchandmatch.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pmwpp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pmwpp-activator.php
 */
function activate_pmwpp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pmwpp-activator.php';
	Pmwpp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pmwpp-deactivator.php
 */
function deactivate_pmwpp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pmwpp-deactivator.php';
	Pmwpp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pmwpp' );
register_deactivation_hook( __FILE__, 'deactivate_pmwpp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pmwpp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pmwpp() {

	$plugin = new Pmwpp();
	$plugin->run();

}
run_pmwpp();
