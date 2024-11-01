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
 * @link       http://multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

wpn_free_db_remove();
wpn_free_options_remove();

function wpn_free_options_remove(){
    delete_option('woo_push_project_number');
    delete_option('woo_push_api_key');
    delete_option('woo_push_icon');
}

function wpn_free_db_remove(){
    global $wpdb;
    $tables = array('woopush_subscribers', 'woopush_notifications');

    foreach ($tables as $table) {
        $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . $table);
    }
}