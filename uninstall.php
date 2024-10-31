<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://pitchandmatch.com/
 * @since      1.0.0
 *
 * @package    Pamwpp
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

require plugin_dir_path( __FILE__ ) . 'includes/class-pmwpp.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-pmwpp-call-to-action.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-pmwpp-list-entities.php';

$listEntities = new PmwppListEntities();
$listEntities->save_site_settings( array() );

$callToAction = new PmwppCallToAction();
$callToAction->save_site_settings( array() );

$plugin = new Pmwpp();
delete_site_option( $plugin->get_plugin_name() );