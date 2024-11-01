<?php

/**
 * Fired during plugin activation
 *
 * @link       http://multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 * @subpackage Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 * @subpackage Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications/includes
 * @author     Multidots <info@multidots.com>
 */
class Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
public static function activate() {
      if( !in_array( 'woocommerce/woocommerce.php',apply_filters('active_plugins',get_option('active_plugins'))) && !is_plugin_active_for_network( 'woocommerce/woocommerce.php' )   ) { 
	    wp_die( "<strong>WooCommerce Notifier Free</strong> Plugin requires <strong>WooCommerce</strong> <a href='".get_admin_url(null, 'plugins.php')."'>Plugins page</a>." );
	 } elseif ( defined( 'WOOCOMMERCE_VERSION' ) && version_compare( WOOCOMMERCE_VERSION, '2.4.0', '<' ) ){
	      wp_die( "<strong>WooCommerce Notifier Free/strong> Plugin requires <strong>WooCommerce</strong> version greater then or equal to 2.4.0" );
		} else {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		global $wpdb;
		set_transient( '_welcome_screen_wpn_free_activation_redirect_data', true, 30 );
		global $push_subscribers_table;
		global $push_notifications_table;
		$push_subscribers_table = $wpdb->prefix . 'woopush_subscribers';
			if ($wpdb->get_var("SHOW TABLES LIKE '$push_subscribers_table'") != $push_subscribers_table) {
					$sql = "CREATE TABLE " . $push_subscribers_table . " (
							    `id` int(11) NOT NULL AUTO_INCREMENT,
							    `user_id` bigint(20),
							    `gcm_regid` text,
							    `notifications` text,
							    `user_country` varchar(150),
							    `user_country_name` varchar(150),
							    `user_ip_address` varchar(15),
								`page` int(2) DEFAULT 0,
								`post` int(2) DEFAULT 0,
								`product` int(2) DEFAULT 0,
								`coupon` int(2) DEFAULT 0,
								`instock` int(2) DEFAULT 0,
								`pricedrop` int(2) DEFAULT 0,
								`allpost` int(2) DEFAULT 0,
								`user_agent` longtext,
							    `user_staus` int(2),
							    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
							    PRIMARY KEY (`id`));";
            		dbDelta($sql);
        		}
			$push_notifications_table = $wpdb->prefix . 'woopush_notifications';
			if ($wpdb->get_var("SHOW TABLES LIKE '$push_notifications_table'") != $push_notifications_table) {
					
					$sql = "CREATE TABLE " . $push_notifications_table . " (
					        `id` int(11) NOT NULL AUTO_INCREMENT,
					        `notification` text,
					        `type` varchar(150),
					        `success` int(11) DEFAULT 0,
					        `failure` int(11) DEFAULT 0,
					        `hits` int(11) DEFAULT 0,
					        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					        PRIMARY KEY (`id`));";
					 dbDelta($sql);
				}
					update_option('wpn_new_product_notify', '1');
					update_option('wpn_new_post_notify', '1');
					update_option('woopush_new_page_notify', '1'); 
					self::wpn_free_write_service_worker();
             }
        }
        
	    /**
	     * ServiceWorker (sw.js) creation
	     * @return void
	     */
		public static function wpn_free_write_service_worker(){
			global $tmp_sw;
			$tmp_sw = file_get_contents(WPN_FREE_PLUGIN_URL . 'admin/js/tmp/sw.js.tmp');
			$tmp_sw = str_replace('DEXIE_PATH', WPN_FREE_PLUGIN_URL. 'admin/js/library/Dexie.min.js', $tmp_sw);
			$tmp_sw = str_replace('SUB_PATH', get_option('siteurl'). '/?subId=', $tmp_sw);
			$tmp_sw = str_replace("ICON_PATH", WPN_FREE_PLUGIN_URL. 'admin/images/woo-notifier-free-plugin.png', $tmp_sw);
			$tmp_sw = str_replace('DEBUG_VAR', true, $tmp_sw);
			$form_url = 'admin.php?page=woo-push';
			self::wpn_free_write_file($form_url, $tmp_sw, 'firebase-messaging-sw.js');
		}
		/**
        * Write File generic function.
        * @param  String $form_url     URL of the form to return if no permissions
        * @param  String $file_content Content of the file to be writen
        * @param  String $filename     Name of the new file
        * @return void
        */
		public static function wpn_free_write_file($form_url, $file_content, $filename){
			global $wp_filesystem;

			$method = '';
			$context = ABSPATH;
	
			if (!self::wpn_init_filesystem($form_url, $method, ABSPATH)) {
				return false;
			}
	
			$target_dir = $wp_filesystem->find_folder($context);
			$target_file = trailingslashit($target_dir) . $filename;
	
			require_once( ABSPATH .'wp-admin/includes/file.php' );
			$full_file_path = get_home_path().'wp-content/uploads/firebase-messaging-sw.js';
	
			if (!$wp_filesystem->put_contents($target_file, $file_content, FS_CHMOD_FILE)) {
				return new WP_Error('writing_error', 'Error when writing file');
			}
			return $file_content;
		}
		/**
        * Initialization of the FileSystem class
        * @param  String $form_url
        * @param  String $method
        * @param  String $context
        * @param  String $fields
        * @return void
        */
		public static function wpn_init_filesystem($form_url, $method, $context, $fields = null){
			global $wp_filesystem;
			include_once ABSPATH . 'wp-admin/includes/file.php';
			if (false === ($creds = request_filesystem_credentials($form_url, $method, false, $context, $fields))) {
				return false;
			}
			if ( ! WP_Filesystem($creds)) {	
				request_filesystem_credentials($form_url, $method,true, $context,$fields);
				return false;
			}
			return true; //filesystem object successfully initiated
		}


}
