<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 * @subpackage Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 * @subpackage Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications/admin
 * @author     Multidots <info@multidots.com>
 */
class Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

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
        if (isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == 'woo_notifier')) {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-notifier-lite-send-automated-web-push-desktop-notifications-admin.css', array('wp-jquery-ui-dialog'), $this->version, 'all');
            wp_enqueue_style('wp-pointer');
            wp_enqueue_style('woo-notifier-pro-webpush', plugin_dir_url(__FILE__) . 'css/woo-notifier-free-webpush-style.css', array(), $this->version);
            wp_enqueue_style('woo-notifier-pro-main-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version);
            wp_enqueue_style('woo-notifier-pro-media', plugin_dir_url(__FILE__) . 'css/media.css', array(), $this->version);
            wp_enqueue_style('woo-notifier-pro-webkit', plugin_dir_url(__FILE__) . 'css/webkit.css', array(), $this->version);
	        wp_dequeue_style('select2');
        }
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
         * defined in Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        //Fcm Web Code and Js Add Dynamically
        $wpn_web_code = stripslashes(get_option('woo_web_code'));
        if (!empty($wpn_web_code)) {
            echo $wpn_web_code;
            wp_register_script('woo-notifier-push', WPN_FREE_PLUGIN_URL . '/public/js/woo-notifier-free-push.js', array('jquery'), '1.0', true);
        }
        //Fcm Web Code and Js Add Dynamically
        if (isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == 'woo_notifier')) {
            wp_enqueue_script('wp-pointer');
            wp_enqueue_script('woo-notifier-free-admin-push', plugin_dir_url(__FILE__) . 'js/woo-notifier-free-admin-wpn-custom.js', array('jquery'), '1.0', true);
            wp_enqueue_script('jquery-ui');
            wp_enqueue_script('jquery-ui-dialog');
	        wp_dequeue_script( 'select2' );
            wp_enqueue_media();
        }
        /**
         * Create array for use siterul & ajaxurl.
         */
        $data = array(
            'sw_path' => get_option('siteurl') . '/firebase-messaging-sw.js',
            'reg_url' => get_option('siteurl') . '/?regId=',
            'ajaxurl' => admin_url('admin-ajax.php'),
        );

        wp_localize_script('woo-notifier-push', 'pn_vars', $data);
        wp_enqueue_script('woo-notifier-push');
	    wp_dequeue_script( 'selectWoo' );
    }

    public function dot_store_menu_woo_notifier()
    {
        global $GLOBALS;
        add_menu_page(
            'DotStore Plugins', 'DotStore Plugins', 'null', 'dots_store', array($this, 'dot_store_menu_extra_flate_shipping_method_page'), plugin_dir_url(__FILE__) . 'images/menu-icon.png', 25
        );
        add_submenu_page("dots_store", "Woocommerce Notifier Lite", "Woocommerce Notifier Lite", "manage_options", "woo_notifier", array($this, "wc_notifier_options_page"));
    }

    public function wc_notifier_options_page()
    {
        require_once('partials/header/plugin-header.php');
        echo do_action('wpn_notice_show');

        global $wpdb;

//         start here custom menu code

        $data_tab = !empty($_GET['tab']) ? $_GET['tab'] : '';
        $active_tab = "new-notification";
        if (!empty($_GET["tab"])) {

            if ($_GET["tab"] == "new-notification") {
                self::wpn_free_new_notification_page();
            }
            if ($_GET['tab'] === 'free-settings') {
                self::wpn_free_option_page();
            }
            if ($_GET['tab'] === 'subscribers-settings') {
                self::wpn_free_subscribers_page();
            }
            if ($_GET['tab'] === 'notifications-history') {
                self::wpn_free_notification_history_page();
            }
            if ($_GET['tab'] === 'general-settings') {
                self::wpn_free_general_page();
            }
            if ($data_tab === 'wc_lite_woonotifier_premium_method') {
                self::wpn_free_premimum_html_method();
            }
            if ($_GET['tab'] === 'get-started-dots-about-plugin-settings') {
                self::wpn_free_get_started_dots_about_plugin_settings();
            }
            if ($_GET['tab'] === 'dots-about-plugin-introduction-woo-notifier') {
                self::wpn_free_introduction_plugin_settings();
            }
        } else {
            self::wpn_free_new_notification_page();
        }
        require_once('partials/header/plugin-sidebar.php');
    }

    /**
     * Register Free plugin
     *
     */
    public function wpn_free_premimum_html_method()
    {
        ?>
        <div id="main-tab">
            <div class="wrapper">
                <div class="tab-dot">
                    <div class="wpn-main-table res-cl">
                        <h2>Free vs Premium </h2>

                        <table class="wpn-table-outer premium-free-table" align="center">
                            <thead>
                            <tr class="blue">
                                <th>KEY FEATURES LIST</th>
                                <th>FREE</th>
                                <th>PREMIUM</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="dark">
                                <td class="pad">Send Notification When</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="sub-item-left"><i class="sub-bullet"></i>A New Page published</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                            </tr>
                            <tr class="dark">
                                <td class="sub-item-left"><i class="sub-bullet"></i>A New Blog Post is published</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="sub-item-left"><i class="sub-bullet"></i>A New Product is published</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                            </tr>
                            <tr class="dark">
                                <td class="sub-item-left"><i class="sub-bullet"></i>Price of a product is dropped</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/trash.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="sub-item-left"><i class="sub-bullet"></i>A Product is back in stock</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/trash.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>

                            </tr>
                            <tr class="dark">
                                <td class="sub-item-left"><i class="sub-bullet"></i>A New Coupon is published</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/trash.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>

                            </tr>
                            <tr>
                                <td class="sub-item-left"><i class="sub-bullet"></i>A New Custom Post is published</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/trash.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>

                            </tr>
                            <tr class="dark">
                                <td class="pad">Turn off/on notifications
                                    (General and for specific products/coupons as well)
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>

                            </tr>
                            <tr>
                                <td class="pad">Registered Customers can Turn off/on any type notifications for their
                                    device
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/trash.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>

                            </tr>
                            <tr>
                                <td class="pad">Set Custom text for each type of the notification.</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/trash.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>

                            </tr>
                            <tr class="dark">
                                <td class="pad">Send New Notification with title, message and URL</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="pad">View Subscribers</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                            </tr>
                            <tr class="dark">
                                <td class="pad">View Notification History</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>
                            </tr>

                            <tr>
                                <td class="pad">Analytics</td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/trash.png'); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/check-mark.png'); ?>">
                                </td>

                            </tr>


                            <tr class="dark radius-s">
                                <td class="pad"></td>
                                <td class="green"><i><img
                                                src="<?php echo site_url('wp-content/plugins/woo-notifier-lite-send-automated-web-push-desktop-notifications/admin/images/download.png'); ?>"></i>
                                    DOWNLOAD
                                </td>
                                <td class="green red"><a
                                            href="https://store.multidots.com/woocommerce-notifier-send-web-push-notifications/"
                                            target="_blank">UPGRADE TO <br> PREMIUM VERSION</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Write File generic function.
     * @param  String $form_url URL of the form to return if no permissions
     * @param  String $file_content Content of the file to be writen
     * @param  String $filename Name of the new file
     * @return void
     */
    public static function wpn_free_write_file($form_url, $file_content, $filename)
    {
        global $wp_filesystem;

        $method = '';
        $context = ABSPATH;

        if (!self::wpn_init_filesystem($form_url, $method, ABSPATH)) {
            return false;
        }

        $target_dir = $wp_filesystem->find_folder($context);
        $target_file = trailingslashit($target_dir) . $filename;

        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $full_file_path = get_home_path() . 'wp-content/uploads/firebase-messaging-sw.js';

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
    public static function wpn_init_filesystem($form_url, $method, $context, $fields = null)
    {
        global $wp_filesystem;
        include_once ABSPATH . 'wp-admin/includes/file.php';
        if (false === ($creds = request_filesystem_credentials($form_url, $method, false, $context, $fields))) {

            return false;
        }

        if (!WP_Filesystem($creds)) {

            request_filesystem_credentials($form_url, $method, true, $context);
            return false;
        }

        return true; //filesystem object successfully initiated
    }

    /**
     * Generate General Tab Call Back Functions
     * @return  void
     */
    public function wpn_free_general_page($current = 'first')
    {
        echo "<div class='wpn-main-table res-cl'>";
        echo "<h2> Firebase Cloud Messaging (FCM) Configuration</h2>";
        echo "<div class='set'>";
        ?>
        <b>Notice: DO NOT CHANGE these settings once you have saved it and users have subscribed to notifications of
            your website. If you change the Firebase settings after some users have subscribed to notifications, all
            users will be lost.</b>
        <?php
        echo "<div class='woo-notifier' >Configure Firebase to send push notifications to your website visitors, which are using the following web browsers:</div>";
        ?>
        <ul class="woo-class">
            <li>Chrome Desktop and Mobile (version 50+)</li>
            <li>Firefox Desktop and Mobile (version 44+)</li>
            <li>Opera on Mobile (version 37+)</li>
        </ul>
        <div class='woo-notifier'>
            <p>Create a Firebase project in the Firebase <a href='https://console.firebase.google.com/' target='_blank'>console</a>,
                if you don't already have one.</p>
            <p>Click "Add Firebase to your web app".</p>
            <p>Note the initialization code snippet, and paste it in Firebase Script text-box.</p>
            <p>Go to Project Settings &#x2192; Cloud Messaging.</p>
            <p>Copy Server Key and Sender ID and paste it in corresponding text-boxes below.</p>
        </div>
        <?php
        echo "</div>";
        if (isset($_POST['woo_push_project_number']) && !empty(sanitize_text_field ( $_POST['woo_push_project_number']) )) {
            update_option('woo_push_project_number', sanitize_text_field($_POST['woo_push_project_number']));
            $form_url = 'admin.php?page=woo_notifier&tab=general-settings';
            $senderid = '103953800507';
            $projectnumber = sanitize_text_field( $_POST['woo_push_project_number'] );
            $manifest_file = '{"gcm_sender_id": "' . $senderid . '"}';
            $this->wpn_free_write_file($form_url, $manifest_file, 'manifest.json');

//js file write for fire base Start
            $msg = "// [START initialize_firebase_in_sw]
// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here, other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/3.5.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.5.0/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
  'messagingSenderId': '$projectnumber'
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
// [END initialize_firebase_in_sw]

// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START background_handler]
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Messagess Title';
  const notificationOptions = {
    body: 'Background Messsssagesss body.',
    icon: '/firebase-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});// [END background_handler]
";

            $this->wpn_free_write_file($form_url, $msg, 'firebase-messaging-sw.js');
            $firebase_filepath = get_home_path() . 'firebase-messaging-sw.js';
            chmod($firebase_filepath, 0777);
//js file write for fire base End
        }
        if (isset($_POST['save']) && !empty($_POST['save'])) {
	        $nonce = $_REQUEST['_wpnonce'];
	        if ( ! wp_verify_nonce( $nonce, 'notify-settings' ) ) {
		        exit;
	        }
            $wpn_project_number = sanitize_text_field( $_POST['woo_push_project_number'] );
            $wpn_push_api_key = sanitize_text_field ( $_POST['woo_push_api_key'] );
            $wpn_web_code = stripslashes($_POST['woo_web_code']);
            update_option('woo_push_project_number', $wpn_project_number);
            update_option('woo_push_api_key', $wpn_push_api_key);
            update_option('woo_web_code', $wpn_web_code);
        }
//Gerneral Setting Fileds Get
        $wpn_project_number = get_option('woo_push_project_number');
        $wpn_push_api_key = get_option('woo_push_api_key');
        $wpn_web_code = stripslashes(get_option('woo_web_code'));
        ?>


        <form method="POST">
            <?php wp_nonce_field( 'notify-settings' ); ?>
            <table class="wpn-table-outer">
                <tbody>
                <tr>
                    <td class="ur-1">Firebase Script<span class="woocommerce-help-tip"></span></td>
                    <td class="ur-2">
                            <textarea name="woo_web_code" rows="10" cols="80"><?php
                                if (!empty($wpn_web_code)) {
                                    echo $wpn_web_code;
                                }
                                ?> </textarea>
                    </td>
                    </td>
                </tr>

                <tr>
                    <td class="ur-1">Server Key<span class="woocommerce-help-tip"></span></td>
                    <td class="ur-2">
                        <label class="dis">
                            <input name="woo_push_api_key" id="woo_push_api_key" value="<?php
                            if (!empty($wpn_push_api_key)) {
                                echo $wpn_push_api_key;
                            }
                            ?>" type="text" style="" class="wc-enhanced-select" placeholder="">
                    </td>
                    </label>
                    </td>
                </tr>
                <tr>
                    <td class="ur-1">Sender ID</td>
                    <td class="ur-2">
                        <label class="dis">
                            <input name="woo_push_project_number" id="woo_push_project_number" value="<?php
                            if (!empty($wpn_project_number)) {
                                echo $wpn_project_number;
                            }
                            ?>" type="text" style="" class="wc-enhanced-select" placeholder="">
                        </label>

                    </td>
                </tr>

                <tr>
                    <td class="ur-1"></td>
                    <td class="ur-2">
                        <input type="submit" class="button-primary woocommerce-save-button" name="save"
                               value="save changes">

                    </td>
                </tr>

                </tbody>
            </table>
            </table>
        </form>
        </div><!-- 	wpn-tab-content !-->
        <?php
    }

    /**
     * Option Page Call Back Functions
     * @return  void
     */
    public function wpn_free_option_page($current = 'first')
    {
        $options = get_option('wpn_option');
        if (isset($_POST['save']) && !empty($_POST['save'])) {
            $nonce = $_REQUEST['_wpnonce'];
            if ( ! wp_verify_nonce( $nonce, 'notification_options' ) ) {
                exit;
            }
            $wpn_new_product_notify = (isset($_POST['wpn_new_product_notify'])) ? 1 : 0;
            $wpn_new_page_notify = (isset($_POST['wpn_new_page_notify'])) ? 1 : 0;
            $wpn_new_post_notify = (isset($_POST['wpn_new_post_notify'])) ? 1 : 0;
            update_option('wpn_new_product_notify', $wpn_new_product_notify);
            update_option('wpn_new_post_notify', $wpn_new_post_notify);
            update_option('wpn_new_page_notify', $wpn_new_page_notify);
        }
        ?>
        <div class="wpn-main-table res-cl">
            <h2>Notification Options</h2>
            <form method="POST">
                <?php wp_nonce_field( 'notification_options' ); ?>
                <table class="wpn-table-outer">
                    <tbody>
                    <tr>
                        <td class="ur-1">Page, Post, Product Notification Options</td>
                        <td class="forminp">
                            <p>
                                <input name="wpn_new_product_notify" id="woopush_new_product_notify" type="checkbox"
                                       value="1" <?php checked(get_option('wpn_new_product_notify', 1, true)); ?> >
                                <label>A new product is published</label>
                            </p>
                            <p>
                                <input name="wpn_new_post_notify" id="woopush_new_post_notify" type="checkbox"
                                       value="1" <?php checked(get_option('wpn_new_post_notify', 1, true)); ?> >
                                <label>A new blog post is published</label></p>
                            <p>
                                <input name="wpn_new_page_notify" id="woopush_new_page_notify" type="checkbox"
                                       value="1" <?php
                                checked(get_option('wpn_new_page_notify', 1, true));;
                                ?> >
                                <label> A new page is published</label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="ur-1"></td>
                        <td class="ur-2">
                            <input name="save" class="button-primary woocommerce-save-button" type="submit"
                                   value="Save changes">
                        </td>
                    </tr>
                    </tbody>
                </table>

            </form>

        </div> <!-- wpn-tab-content!-->
        <?php
    }

    /**
     * New Notification Page Call Back Functions
     * @return  void
     */
    public function wpn_free_new_notification_page($current = 'first')
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/views/wpn-new-notification.php';
        echo '</div>'; //wpn-tab-content!
    }

    /**
     * Subscribers Page Call Back Functions
     * @return  void
     */
    public function wpn_free_subscribers_page($current = 'first')
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/views/wpn-subscribers.php';
        echo '</div>';
    }

    /**
     * Notification History Page Call Back Functions
     * @return  void
     */
    public function wpn_free_notification_history_page($current = 'first')
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/views/wpn-notifications-history.php';
        echo '</div>';
    }

    /* 	
      public function  wpn_pull_notifications(){
      $respose = array();
      $respose['notifications'][] = array(
      'url' => 'http://yahoo.com',
      'title' => 'Hellossssssssss Firefox',
      'body' => 'Test description',
      'icon' =>'',
      );
      $respose['to'] = 'cIuhyu2htkU:APA91bEjwbn62dxPT9CUPAvlJwXcSPl1mhPcLietXyTUSOW-L7rMvM_oXoJ_hY_ltjduVz_unVuHzbN2THIgXdhy1BKU0UcMkA6vhZNfy0m8ARCDmmdAPg9vW5GMbLmEHivtg24CG_tl';
      header('Authorization:key=AIzaSyAhe6Uvj1rFP5caisbk9tPOoN');
      header('Content-Type: application/json');
      echo json_encode($respose);
      ?>

      <?php

      } */

    /**
     * Get all notifications for the provided subscriber ID
     * @return void
     */
    public function wpn_free_pull_notifications()
    {
        if (isset($_GET['subId']) && !empty($_GET['subId'])) {

            global $wpdb;
            $endpoint = explode('/', sanitize_text_field(rawurldecode($_GET["subId"])));
            $subscriber_id = end($endpoint);
            $push_subscribers_table = $wpdb->prefix . 'woopush_subscribers';
            $push_notifications_table = $wpdb->prefix . 'woopush_notifications';

            $subscriber = $wpdb->get_row($wpdb->prepare('SELECT notifications FROM ' . $push_subscribers_table . ' WHERE gcm_regid = %s', $subscriber_id));
            $notifications_ids_array = json_decode($subscriber->notifications);
            $notifications_ids = implode(',', $notifications_ids_array);

            $notifications = $wpdb->get_results('SELECT id, notification FROM ' . $push_notifications_table . ' WHERE id IN (' . $notifications_ids . ')');

//update Hits
            $wpdb->query('UPDATE ' . $push_notifications_table . ' SET hits = hits + 1 WHERE id IN (' . $notifications_ids . ')');

            $respose = array();
            foreach ($notifications as $notification) {
                $notification_data = json_decode($notification->notification);
                $respose['notifications'][] = array(
                    'url' => $notification_data->url,
                    'title' => $notification_data->title,
                    'body' => $notification_data->message,
                    'icon' => $notification_data->icon,
                    'tag' => md5(rand(4, 7)),
                );
                $respose['to'] = $subscriber_id;
            }
            $result = $wpdb->update(
                $push_subscribers_table, array(
                'notifications' => null,
            ), array(
                    'gcm_regid' => $subscriber_id,
                )
            );
            header('Content-Type: application/json');
            header('Authorization:key=AIzaSyAhe6Uvj1rFP5caisbk9tPOoN-XZhmHcY4');
            echo json_encode($respose);
            exit;
        }
    }

    /**
     * Send Notification when a new post/page/product is created
     * @return void
     */
    public function wpn_free_on_poststatus_change($new_status, $old_status, $post)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

// Don't save revisions and autosaves
        if (wp_is_post_revision($post->ID) || wp_is_post_autosave($post->ID)) {
            return;
        }

// Check user permission
        if (!current_user_can('edit_post', $post->ID)) {
            return;
        }

        /* defult Icon Set */
        $default_icon = WPN_FREE_PLUGIN_URL . 'admin/images/woo-notifier-free-plugin.png';
        $icon = apply_filters('wpn_default_icon', $default_icon);

// Post Type Featured Image Set as a Icon
        $posttype_icon = wp_get_attachment_url(get_post_thumbnail_id($post->ID));

//if featured image not there then defult icon is set conditions
        $posticon = !empty($posttype_icon) ? $posttype_icon : $icon;

        /* Setting Label Defin */
        $wpn_new_product_notify = 'wpn_new_product_notify';
        $wpn_new_post_notify = 'wpn_new_post_notify';
        $wpn_new_page_notify = 'wpn_new_page_notify';

        $wpn_new_post_notify = get_option('wpn_new_post_notify');
        if ($wpn_new_post_notify == 'no') {
            $wpn_new_post_notify = false;
        }
        $wpn_new_page_notify = get_option('wpn_new_page_notify');
        if ($wpn_new_page_notify == 'no') {
            $wpn_new_page_notify = false;
        }
        $wpn_new_product_notify = get_option('wpn_new_product_notify');
        if ($wpn_new_product_notify == 'no') {
            $wpn_new_product_notify = false;
        }

        $disallow_notify = isset($_POST['woopush_disallow_notify']) ? true : false;

//Post Stuffs
        if ($post->post_type == 'post') {
            $msg = preg_replace('/&#?[a-z0-9]{2,8};/i', ' ', wp_strip_all_tags(strip_shortcodes($post->post_content)));
//New Post Notification
            if ((($old_status != $new_status && $new_status == 'publish') || ($old_status == 'future' && $new_status == 'publish')) && $wpn_new_post_notify && !$disallow_notify) {
                $data = array(
                    'title' => mb_substr(wp_strip_all_tags(strip_shortcodes($post->post_title)), 0, 50),
                    'message' => mb_substr(preg_replace('/\s\s+/', ' ', $msg), 0, 120),
                    'url' => get_permalink($post->ID),
                    'icon' => $posticon,
                );
                $this->wpn_free_notify($data);
            }
        }

//Page Stuffs
        if ($post->post_type == 'page') {
            $msg = preg_replace('/&#?[a-z0-9]{2,8};/i', ' ', wp_strip_all_tags(strip_shortcodes($post->post_content)));
//New Page Notification
            if ((($old_status != $new_status && $new_status == 'publish') || ($old_status == 'future' && $new_status == 'publish')) && $wpn_new_page_notify && !$disallow_notify) {
                $data = array(
                    'title' => mb_substr(wp_strip_all_tags(strip_shortcodes($post->post_title)), 0, 50),
                    'message' => mb_substr(preg_replace('/\s\s+/', ' ', $msg), 0, 120),
                    'url' => get_permalink($post->ID),
                    'icon' => $posticon,
                );

                $this->wpn_free_notify($data);
            }
        }

//Product Stuffs
        if ($post->post_type == 'product' && $new_status == 'publish') {
            $msg = preg_replace('/&#?[a-z0-9]{2,8};/i', ' ', wp_strip_all_tags(strip_shortcodes($post->post_content)));
//New Product Notification
            if ((($old_status != $new_status && $new_status == 'publish') || ($old_status == 'future' && $new_status == 'publish')) && $wpn_new_product_notify && !$disallow_notify) {
                $data = array(
                    'title' => mb_substr(wp_strip_all_tags(strip_shortcodes($post->post_title)), 0, 50),
                    'message' => mb_substr(preg_replace('/\s\s+/', ' ', $msg), 0, 120),
                    'url' => get_permalink($post->ID),
                    'icon' => $posticon,
                );
                $this->wpn_free_notify($data);
            }
        }
    }

    /**
     * Get user IDs for Spacific User
     * @return Array $clients Array of the client ids
     */
    private function wpn_free_get_user_clientids()
    {
        global $wpdb;
        $subscribers_table = $wpdb->prefix . 'woopush_subscribers';
        $clients = array();
        $sql = "SELECT gcm_regid FROM $subscribers_table";
        $res = $wpdb->get_results($sql);
        if ($res != false) {
            foreach ($res as $row) {
                array_push($clients, $row->gcm_regid);
            }
        }
        return $clients;
    }

    /**
     * Register a new subcriber if it's not in the list
     * @return void
     */
    public function wpn_free_register_device()
    {
        if (isset($_POST["regId"]) && !empty($_POST['regId'])) {
            global $wpdb;
            $useragent = $_SERVER ['HTTP_USER_AGENT'];
//Variable declartion
            $user_ip_address = $_SERVER["REMOTE_ADDR"];
            $return_data = array('country' => '', 'country_name' => '');
            $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $user_ip_address));
            if ($ip_data && $ip_data->geoplugin_countryCode != null && $ip_data->geoplugin_countryName != null) {
                $return_data['country'] = $ip_data->geoplugin_countryCode;
                $return_data['country_name'] = $ip_data->geoplugin_countryName;
            }
            $country_name = !empty($return_data['country']) ? $return_data['country'] : '';
            $user_country_name = !empty($return_data['country_name']) ? $return_data['country_name'] : '';
            $endpoint = explode('/', sanitize_text_field(rawurldecode($_POST["regId"])));
            $regId = end($endpoint);
            $time = date("Y-m-d H:i:s");
            $subscribers_table = $wpdb->prefix . 'woopush_subscribers';
            $sql = "SELECT gcm_regid FROM $subscribers_table WHERE gcm_regid='$regId'";
            $result = $wpdb->get_results($sql);
            $userid = '';
            if (!get_current_user_id()) {
                $userid = 0;
            } else {
                $userid = get_current_user_id();
            }

            //Insert subscriber
            if ($result) {

                if (get_current_user_id()) {

                    $delete_sql = "DELETE FROM $subscribers_table WHERE gcm_regid='$regId' and user_id='0'";
                    $rez = $wpdb->query($delete_sql);
                    $userid = get_current_user_id();
                    $user_sql = "SELECT gcm_regid FROM $subscribers_table WHERE gcm_regid='$regId' and user_id='$userid'";
                    $userresult = $wpdb->get_results($user_sql);
                    if (!$userresult) {

                        $sql = "INSERT INTO $subscribers_table (user_id,gcm_regid,user_country,user_country_name,user_ip_address, created_at,page,post,product,coupon,instock,pricedrop,allpost,user_agent,user_staus) VALUES ('$userid','$regId','$country_name','$user_country_name','$user_ip_address', '$time','1','1','1','1','1','1','1','$useragent','1')";
                        $q = $wpdb->query($sql);
                        if ($q) {
                            echo "Device registered!";
                        } else {
                            echo "ERROR";
                        }
                    } else {
                        echo 'You\'re already registered';
                    }
                } else {
                    echo 'You\'re already registered';
                }
            } else {

                $sql = "INSERT INTO $subscribers_table (user_id,gcm_regid,user_country,user_country_name,user_ip_address, created_at,page,post,product,coupon,instock,pricedrop,allpost,user_agent,user_staus) VALUES ('$userid','$regId','$country_name','$user_country_name','$user_ip_address', '$time','1','1','1','1','1','1','1','$useragent','1')";
                $q = $wpdb->query($sql);
                if ($q) {
                    echo "Device registered!";
                } else {
                    echo "ERROR";
                }
            }
        }
        wp_die();
    }

    /**
     * Manifest link in header
     */
    public function wpn_free_manifest_file()
    {
        echo '<link rel="manifest" href="' . site_url() . '/manifest.json">';
    }

    /**
     * Push Notification For New notfication in Setting Filed
     * @return void
     */
    public function wpn_free_push_notfication()
    {
        $notification_url = (!empty($_POST['wpn_url'])) ? $_POST['wpn_url'] : site_url();
        $data = array(
            'title' => sanitize_text_field($_POST['wpn_title']),
            'message' => sanitize_text_field($_POST['wpn_message']),
            'url' => $notification_url,
            'icon' => sanitize_text_field($_POST['wpn_image_url'])
        );

        $result = $this->wpn_free_notify($data);
        $answer = json_decode($result);
        if ($answer) {
            wp_send_json($answer);
        } else {
            echo $result;
        }
        wp_die();
    }

    /**
     * The function to add Metabox in posts, page, product and coupon
     */
    public function wpn_free_addMetaBox()
    {
        $screens = array('post', 'page', 'product');

        foreach ($screens as $screen) {
            add_meta_box(
                'woo_push', 'WooNotifier Notifications', array(&$this, 'wpn_free_metaboxCallback'), $screen, 'side', 'high'
            );
        }
    }

    /**
     * The meta box callback function
     * @return void
     */
    public function wpn_free_metaboxCallback()
    {
        echo '<input type="checkbox" id="woopush_disallow_notify" name="woopush_disallow_notify" value="true"> Don\'t send push notification ';
    }

    /**
     * Send the push message to GCM
     * @param  Array $data Notification data
     * @return void
     */
    public function wpn_free_notify($data)
    {
        $this->wpn_free_put_notification_on_queue($data);
        $apiKey = get_option('woo_push_api_key');
        $url = 'https://fcm.googleapis.com/fcm/send';
        $ids = $this->wpn_free_get_clientids();
        $headers = array(
            'Authorization: key=' . $apiKey . '',
            'Content-Type: application/json'
        );
        if (empty($ids)) {
            return 'No subscribers on your site yet!';
        }
        if (count($ids) >= 1000) {
            //$newId = array_chunk($ids, 1000);
			$newId = array_slice($ids, 0, 1000);//send latest 1000 subscriber notification only
            foreach ($newId as $inner_id) {
                $fields = array(
                    'to' => $inner_id,
                    'notification' => array(
                        "title" => $data['title'],
                        "body" => $data['message'],
                        "click_action" => $data['url'],
                        "icon" => $data['icon'],
                    )
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
            }
        } else {
            foreach ($ids as $id) {
                $fields = array(
                    'to' => $id,
                    'notification' => array(
                        "title" => $data['title'],
                        "body" => $data['message'],
                        "click_action" => $data['url'],
                        "icon" => $data['icon'],
                    )
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
            }
        }

        $answer = json_decode($result);
        curl_close($ch);

        if ($answer) {
            $this->wpn_free_clean_clientids($answer);
        }

        return $result;
    }

    /**
     * Get user IDs
     * @return Array $clients Array of the client ids
     */
    private function wpn_free_get_clientids()
    {
        global $wpdb;
        $subscribers_table = $wpdb->prefix . 'woopush_subscribers';
        $clients = array();
        $sql = "SELECT gcm_regid FROM $subscribers_table";
        $res = $wpdb->get_results($sql);
        if ($res != false) {
            foreach ($res as $row) {
                array_push($clients, $row->gcm_regid);
            }
        }
        return $clients;
    }

    /**
     * Clean all IDs with error
     * @param  Object $answer
     * @return void
     */
    public function wpn_free_clean_clientids($answer)
    {
        $allIds = $this->wpn_free_get_user_clientids();
        $resId = array();
        $errId = array();
        $err = array();
        $can = array();

        global $wpdb;
        $push_subscribers_table = $wpdb->prefix . 'woopush_subscribers';

        foreach ($answer->results as $index => $element) {
            if (isset($element->registration_id)) {
                $resId[] = $index;
            }
        }

        foreach ($answer->results as $index => $element) {
            if (isset($element->error)) {
                $errId[] = $index;
            }
        }

        for ($i = 0; $i < count($allIds); $i++) {
            if (isset($resId[$i]) && isset($allIds[$resId[$i]])) {
                array_push($can, $allIds[$resId[$i]]);
            }
        }

        for ($i = 0; $i < count($allIds); $i++) {
            if (isset($errId[$i]) && isset($allIds[$errId[$i]])) {
                array_push($err, $allIds[$errId[$i]]);
            }
        }

        if ($err != null) {
            for ($i = 0; $i < count($err); $i++) {
                $s = $wpdb->query($wpdb->prepare("DELETE FROM $push_subscribers_table WHERE gcm_regid=%s", $err[$i]));
            }
        }
        if ($can != null) {
            for ($i = 0; $i < count($can); $i++) {
                $r = $wpdb->query($wpdb->prepare("DELETE FROM $push_subscribers_table WHERE gcm_regid=%s", $can[$i]));
            }
        }
    }

    /**
     * Add each notifications on the queue to all users
     * @param  Array $data Notification data array
     * @return void
     */
    private function wpn_free_put_notification_on_queue($data)
    {
        global $wpdb, $post;

        $post_type = (!empty($post->post_type)) ? $post->post_type : 'new';
        $notifications_table_name = $wpdb->prefix . 'woopush_notifications';
        $push_subscribers_table = $wpdb->prefix . 'woopush_subscribers';
        $time = date("Y-m-d H:i:s");
        $wpdb->insert($notifications_table_name, array(
                'notification' => json_encode($data),
                'type' => $post_type,
                'created_at' => $time,
            )
        );
        $notification_id = $wpdb->insert_id;

        $subscribers = $wpdb->get_results('SELECT id,notifications FROM ' . $push_subscribers_table);

        foreach ($subscribers as $subscriber) {
            $existing_notifications = is_array(json_decode($subscriber->notifications)) ? json_decode($subscriber->notifications) : array();
            $existing_notifications[] = $notification_id;
            $result = $wpdb->update(
                $push_subscribers_table, array(
                'notifications' => json_encode($existing_notifications),
            ), array(
                    'id' => $subscriber->id,
                )
            );
        }
    }

    /**
     * Started Html dots
     * @return void
     */
    public function wpn_free_get_started_dots_about_plugin_settings()
    {?>
        <div class="wpn-main-table res-cl">
            <h2>Thank you for installing WooNotifier.</h2>
            <table class="wpn-table-outer getting-strat">
                <tbody>
                <tr>
                    <td>
                        <p>
                            <strong>
                                Before You Start : </strong>Make sure you have SSL Certificate installed and active on
                            your domain (If you don't have it installed yet, you can get it from your host)
                        </p>
                        <p><strong>Here is a quick guide to begin sending notifications:</strong></p>
                        <p>
                            <strong>Step 1 :</strong> Sign into your Google Account or create one if you don't have one.
                        </p>
                        <p>
                            <strong>Step 2 :</strong> Go to Firebase console: https://console.firebase.google.com/
                            <span class="gettingstarted">
                                    <img style="border-bottom: 2px solid #E9E9E9;margin-top: 3%;"
                                         src="<?php echo WPN_FREE_PLUGIN_URL ?>admin/images/screenshot.187.png">
                                </span>
                        </p>
                        <p>
                            <strong>Step 3 :</strong> Click on Create New Project to create a Firebase projectect'
                        </p>
                        <p>
                            <strong>Step 4 :</strong> Enter project name, select country and click on 'Create Project'
                            <span class="gettingstarted">
                                    <img style="border-bottom: 2px solid #E9E9E9;margin-top: 3%;"
                                         src="<?php echo WPN_FREE_PLUGIN_URL ?>admin/images/screenshot.188.png">
                                </span>
                        </p>

                        <p>
                            <strong>Step 5 :</strong> Click Add Firebase to your web app
                            <span class="gettingstarted">
                                    <img style="border-bottom: 2px solid #E9E9E9;margin-top: 3%;"
                                         src="<?php echo WPN_FREE_PLUGIN_URL ?>admin/images/screenshot.189.png">
                                </span>
                        </p>
                        <p>
                            <strong>Step 6 :</strong> Click 'COPY' button to copy the code snippet and paste it in the
                            WooCommerce Notifier Settings tab: Firebase script textbox.
                            <span class="gettingstarted">
                                    <img style="border-bottom: 2px solid #E9E9E9;margin-top: 3%;"
                                         src="<?php echo WPN_FREE_PLUGIN_URL ?>admin/images/screenshot.190.png">
                                </span>
                        </p>
                        <p>
                            <strong>Step 7 :</strong> Click gear icon in 'Overview', and click 'Project Settings'.
                            <span class="gettingstarted">
                                    <img style="border-bottom: 2px solid #E9E9E9;margin-top: 3%;"
                                         src="<?php echo WPN_FREE_PLUGIN_URL ?>admin/images/screenshot.191.png">
                                </span>
                        </p>
                        <p>
                            <strong>Step 8 :</strong> Click "CLOUD MESSAGING".
                            <span class="gettingstarted">
                                    <img style="border-bottom: 2px solid #E9E9E9;margin-top: 3%;"
                                         src="<?php echo WPN_FREE_PLUGIN_URL ?>admin/images/screenshot.192.png">
                                </span>
                        </p>
                        <p>
                            <strong>Step 9 :</strong> Copy 'Server Key' and 'Sender ID' and paste them into WooCommerce
                            Notifier Settings tab: Server Key and Sender ID text boxes respectively.</br>
                            <span class="gettingstarted">
                                    <img style="border-bottom: 2px solid #E9E9E9;margin-top: 3%;"
                                         src="<?php echo WPN_FREE_PLUGIN_URL ?>admin/images/screenshot.193.png">
                                </span>
                        </p>
                    </td><!--getting stated !-->
                </tr>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Introduction Tab Started
     * @return  void
     *
     */
    public function wpn_free_introduction_plugin_settings()
    {

        $plugin_name = WPN_FREE_PLUGIN_NAME;
        $plugin_version = WPN_FREE_PLUGIN_VERSION;
        ?>
        <form id="wpn_plugin_form_id">
            <div class="wpn-under-table third-tab">
                <div class="set">
                    <h2><?php echo __("Introduction", "WPN_FREE_PLUGIN_TEXT_DOMAIN"); ?></h2>
                </div>
                <?php $siteTabPath = 'wp-admin/admin.php?page=woo_notifier&tab='; ?>
                <table class="wpn-table-outer">
                    <tbody>
                    <tr>
                        <td class="fr-1">Product Type</td>
                        <td class="fr-2">WordPress Plugin</td>
                    </tr>
                    <tr>
                        <td class="fr-1">Product Name</td>
                        <td class="fr-2"><?php echo $plugin_name; ?></td>
                    </tr>
                    <tr>
                        <td class="fr-1">Installed Version</td>
                        <td class="fr-2"><?php echo $plugin_version; ?></td>
                    </tr>
                    <tr>
                        <td class="fr-1">License & Terms of use</td>
                        <td class="fr-2"><a target="_blank" href="https://store.multidots.com/terms-conditions/">Click
                                here</a> to view license and terms of use.
                        </td>
                    </tr>
                    <tr>
                        <td class="fr-1">Help & Support</td>
                        <td class="fr-2 wpn-information">
                            <li><a target="_blank"
                                   href="<?php echo site_url($siteTabPath . 'get-started-dots-about-plugin-settings'); ?>">
                                    Quick Start Guide</a></li>
                            <li><a target="_blank" href="https://store.multidots.com/docs/plugin/woonotifier/">Documentation</a>
                            </li>
                            <li><a target="_blank" href="https://store.multidots.com/dotstore-support-panel/"> Support
                                    Fourm</a></li>
                        </td>
                    </tr>
                    <tr>
                        <td class="fr-1">Localization</td>
                        <td class="fr-2">English</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </form>


        <?php
    }

    /**
     * Https requirement Notice
     * @return void
     */
    public function wpn_free_site_config_notice()
    {
        ?>
        <div class="notice notice-error is-dismissible">
            <p>Your Site URL should be set to HTTPS for WooNotifier Notifications Plugin to work.</p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span>
            </button>
        </div>
        <?php
    }

    /** WELCOME SCREE CODE
     * @return void
     * Subscriber Yes Button Ajax Action hook
     * */

// Function for welocme screen page
    public function welcome_wpn_free_do_activation_redirect()
    {

        if (!get_transient('_welcome_screen_wpn_free_activation_redirect_data')) {
            return;
        }

// Delete the redirect transient
        delete_transient('_welcome_screen_wpn_free_activation_redirect_data');

// if activating from network, or bulk
        if (is_network_admin() || isset($_GET['activate-multi'])) {
            return;
        }
// Redirect to extra cost welcome  page
        wp_safe_redirect(add_query_arg(array('page' => 'woo_notifier&tab=get-started-dots-about-plugin-settings'), admin_url('admin.php')));
    }

    public function welcome_pages_screen_wpn_free()
    {
        add_dashboard_page(
            'Woocommerce-Notifier-Free-Dashboard', 'Woocommerce Notifier Free Dashboard', 'read', 'wp-notifier-free-about', array(&$this, 'welcome_screen_content_wpn_free')
        );
    }

    public function welcome_screen_content_wpn_free()
    {
        ?>
        <div class="wrap about-wrap">
            <h1 style="font-size: 2.1em;"><?php printf(__('Welcome to Woocommerce Notifier', 'woo-notifier-lite-send-automated-web-push-desktop-notifications')); ?></h1>
            <div class="about-text woocommerce-about-text">
                <?php
                $message = '';
                printf(__('%s  This Plugin Send Notifications When User Create Post,page Or Product.', 'woo-notifier-lite-send-automated-web-push-desktop-notifications'), $message, $this->version);
                ?>
                <img class="version_logo_img"
                     src="<?php echo plugin_dir_url(__FILE__) . 'images/woo-notifier-lite-send-automated-web-push-desktop-notifications.png'; ?>">
            </div>
            <?php
            $setting_tabs_wc = apply_filters('wp_email_base_logo_fields_setting_tab', array("about" => "Overview", "other_plugins" => "Checkout our other plugins"));
            $current_tab_wc = (isset($_GET['tab'])) ? $_GET['tab'] : 'general';
            $aboutpage = isset($_GET['page'])
            ?>
            <h2 id="wp-email-base-logo-wrapper" class="nav-tab-wrapper">
                <?php
                foreach ($setting_tabs_wc as $name => $label)
                    echo '<a  href="' . home_url('wp-admin/index.php?page=wp-notifier-free-about&tab=' . $name) . '" class="nav-tab ' . ($current_tab_wc == $name ? 'nav-tab-active' : '') . '">' . $label . '</a>';
                ?>
            </h2>

            <?php
            foreach ($setting_tabs_wc as $setting_tabkey_wc => $setting_tabvalue) {
                switch ($setting_tabkey_wc) {
                    case $current_tab_wc:
                        do_action('wpn_free_change_' . $current_tab_wc);
                        break;
                }
            }
            ?>
            <hr/>
            <div class="return-to-dashboard">
                <a href="<?php echo home_url('/wp-admin/admin.php?page=wpn_free_newnotification'); ?>"><?php _e('Go to Woocommerce Notifier Plugin', 'woo-notifier-lite-send-automated-web-push-desktop-notifications'); ?></a>
            </div>
        </div> <!-- wrap about-wrap !-->
        <?php
    }

    /**
     * Remove the Extra flate rate menu in dashboard
     *
     */
    public function welcome_screen_wpn_free_remove_menus()
    {
        remove_submenu_page('index.php', 'wp-notifier-free-about');
    }

   
    public function custom_wpnf_pointers_footer()
    {
        $admin_pointers = custom_wpnf_pointers_admin_pointers();
        ?>
        <script type="text/javascript">
            /* <![CDATA[ */
            (function ($) {
                <?php
                foreach ($admin_pointers as $pointer => $array) {
                if ($array['active']) {
                ?>
                $('<?php echo $array['anchor_id']; ?>').pointer({
                    content: '<?php echo $array['content']; ?>',
                    position: {
                        edge: '<?php echo $array['edge']; ?>',
                        align: '<?php echo $array['align']; ?>'
                    },
                    close: function () {
                        $.post(ajaxurl, {
                            pointer: '<?php echo $pointer; ?>',
                            action: 'dismiss-wp-pointer'
                        });
                    }
                }).pointer('open');
                <?php
                }
                }
                ?>
            })(jQuery);
            /* ]]> */
        </script>
        <?php
    }

    function wpnf_admin_footer_review()
    {
        echo 'If you like <strong>WooCommerce Blocker – Prevent fake orders and Blacklist fraud customers</strong> plugin, please leave us ★★★★★ ratings on <a href="https://wordpress.org/support/plugin/woo-notifier-lite-send-automated-web-push-desktop-notifications/reviews/#new-post" target="_blank">WordPress</a>.';
    }

}

function custom_wpnf_pointers_admin_pointers()
{
    $dismissed = explode(',', (string)get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
    $version = '1_0'; // replace all periods in 1.0 with an underscore
    $prefix = 'custom_wpnf_pointers' . $version . '_';

    $new_pointer_content = '<h3>' . __('Welcome to Woocommerce Notifier') . '</h3>';
    $new_pointer_content .= '<p>' . __('Woocommerce Notifier plugin is easy to use. This Plugin Send Notifications When User Create Post,page Or Product.') . '</p>';

    return array(
        $prefix . 'assb_notice_view' => array(
            'content' => $new_pointer_content,
            'anchor_id' => '#adminmenu',
            'edge' => 'left',
            'align' => 'left',
            'active' => (!in_array($prefix . 'assb_notice_view', $dismissed))
        )
    );
}
