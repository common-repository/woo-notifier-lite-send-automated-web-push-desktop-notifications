<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 * @subpackage Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 * @subpackage Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications/includes
 * @author     Multidots <info@multidots.com>
 */
class Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woo-notifier-lite-send-automated-web-push-desktop-notifications',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
