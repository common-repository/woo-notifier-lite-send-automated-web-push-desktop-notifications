<?php

/**
 * The plugin bootstrap file
 *
 * Plugin Name:       Woocommerce Notifier Lite- Send automated web push desktop notifications
 * Plugin URI:        https://store.multidots.com
 * Description:       Send automated web push notifications about new product launches, price-drops, coupons, new blog posts and much more.
 * Version:           1.5.5
 * Author:            Multidots
 * Author URI:        https://store.multidots.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-notifier-lite-send-automated-web-push-desktop-notifications
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Define Plugin URL Define
 */
if (!defined('WPN_FREE_PLUGIN_URL')) {
    define('WPN_FREE_PLUGIN_URL', plugin_dir_url(__FILE__));
}

//Define Plugin Text Domain
define('WPN_FREE_PLUGIN_TEXT_DOMAIN', 'woo-notifier-lite-send-automated-web-push-desktop-notifications');

//Plugin Slug
define('WPN_FREE_PLUGIN_SLUG', 'woo-notifier-lite-send-automated-web-push-desktop-notifications');

//Plugin Name
define('WPN_FREE_PLUGIN_NAME', 'Woocommerce Notifier Lite');

//Plugin Version
define('WPN_FREE_PLUGIN_VERSION', '1.5.5');

if (!defined('WPN_PLUGIN_BASENAME')) {
    define('WPN_PLUGIN_BASENAME', plugin_basename(__FILE__));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-notifier-lite-send-automated-web-push-desktop-notifications-activator.php
 */
function activate_woo_notifier_lite_send_automated_web_push_desktop_notifications() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woo-notifier-lite-send-automated-web-push-desktop-notifications-activator.php';
    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-notifier-lite-send-automated-web-push-desktop-notifications-deactivator.php
 */
function deactivate_woo_notifier_lite_send_automated_web_push_desktop_notifications() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woo-notifier-lite-send-automated-web-push-desktop-notifications-deactivator.php';
    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_woo_notifier_lite_send_automated_web_push_desktop_notifications');
register_deactivation_hook(__FILE__, 'deactivate_woo_notifier_lite_send_automated_web_push_desktop_notifications');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-woo-notifier-lite-send-automated-web-push-desktop-notifications.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_notifier_lite_send_automated_web_push_desktop_notifications() {

    $plugin = new Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications();
    $plugin->run();
}

run_woo_notifier_lite_send_automated_web_push_desktop_notifications();
