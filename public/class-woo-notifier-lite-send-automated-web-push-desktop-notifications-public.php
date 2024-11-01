<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 * @subpackage Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 * @subpackage Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications/public
 * @author     Multidots <info@multidots.com>
 */
class Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Public {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-notifier-lite-send-automated-web-push-desktop-notifications-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		 $wpn_web_code = stripslashes(get_option('woo_web_code'));
		 if(!empty($wpn_web_code)){
		     echo  $wpn_web_code;
             wp_register_script('woo-notifier-push', WPN_FREE_PLUGIN_URL . '/public/js/woo-notifier-free-push.js', array('jquery'), '1.0', true);
         }
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-notifier-lite-send-automated-web-push-desktop-notifications-public.js', array( 'jquery' ), $this->version, false );

		$data = array(
		'sw_path' => get_option('siteurl') . '/firebase-messaging-sw.js',
		'reg_url' => get_option('siteurl') . '/?regId=',
		'ajaxurl' => admin_url('admin-ajax.php'),
		);

		wp_localize_script('woo-notifier-push', 'pn_vars', $data);
		wp_enqueue_script('woo-notifier-push');
	}
	
	/**
	* BN code added
	*/
    function paypal_bn_code_filter_wpnf($paypal_args) {
        $paypal_args['bn'] = 'Multidots_SP';
        return $paypal_args;
    }

}
