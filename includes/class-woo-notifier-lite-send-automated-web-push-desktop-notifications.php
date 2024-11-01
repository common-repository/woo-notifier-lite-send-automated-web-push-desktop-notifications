<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 * @subpackage Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications/includes
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
 * @package    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications
 * @subpackage Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications/includes
 * @author     Multidots <info@multidots.com>
 */
class Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Loader    $loader    Maintains and registers all hooks for the plugin.
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

        $this->plugin_name = 'woo-notifier-lite-send-automated-web-push-desktop-notifications';
        $this->version = '1.0.2';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $prefix = is_network_admin() ? 'network_admin_' : '';
        add_filter("{$prefix}plugin_action_links_" . WPN_PLUGIN_BASENAME, array($this, 'wpn_free_plugin_action_links'), 10, 4);

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Loader. Orchestrates the hooks of the plugin.
     * - Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_i18n. Defines internationalization functionality.
     * - Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Admin. Defines all hooks for the admin area.
     * - Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woo-notifier-lite-send-automated-web-push-desktop-notifications-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woo-notifier-lite-send-automated-web-push-desktop-notifications-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-woo-notifier-lite-send-automated-web-push-desktop-notifications-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-woo-notifier-lite-send-automated-web-push-desktop-notifications-public.php';

        $this->loader = new Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Admin($this->get_plugin_name(), $this->get_version());

        //Welecome screen and Subscriber hook
        $this->loader->add_action('admin_init', $plugin_admin, 'welcome_wpn_free_do_activation_redirect');
        $this->loader->add_action('admin_menu', $plugin_admin, 'welcome_pages_screen_wpn_free');
        $this->loader->add_action('admin_menu', $plugin_admin, 'welcome_screen_wpn_free_remove_menus', 999);
        $this->loader->add_action('wpn_free_change_about', $plugin_admin, 'wpn_free_change_about');

        /*         * Custom pointer hook* */
        $this->loader->add_action('admin_print_footer_scripts', $plugin_admin, 'custom_wpnf_pointers_footer');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        // For the Add action for use Pull Notificationsr.
        $this->loader->add_action('init', $plugin_admin, 'wpn_free_pull_notifications');
        //$this->loader->add_action('init', $plugin_admin, 'wpn_pull_notifications');
        // For the Add action for use Poststatus Change.
        $this->loader->add_action('transition_post_status', $plugin_admin, 'wpn_free_on_poststatus_change', 10, 3);
        // For the Add action for use Pre Post Update.
        //$this->loader->add_action('pre_post_update', $plugin_admin, 'wpn_free_pre_post_update', 1, 2);
        // For the Add action for use Ajax Register Device.
        $this->loader->add_action('wp_ajax_nopriv_wpn_register_device', $plugin_admin, 'wpn_free_register_device');
        $this->loader->add_action('wp_ajax_wpn_register_device', $plugin_admin, 'wpn_free_register_device');
        // For the Add action for use about header call file.
        $this->loader->add_action('wp_head', $plugin_admin, 'wpn_free_manifest_file');
        // For the Add action for use Add MetaBox.
        $this->loader->add_action('add_meta_boxes', $plugin_admin, 'wpn_free_addMetaBox');
        //Push And Resend Notification Action
        $this->loader->add_action('wp_ajax_push_notfication', $plugin_admin, 'wpn_free_push_notfication');
        $this->loader->add_action('wp_ajax_resend_notification', $plugin_admin, 'wpn_free_resend_notification');
        //if Codition Check for SSL Url Notice.
        if (!$this->wpn_free_check_ssl()) {
            $this->loader->add_action('wpn_notice_show', $plugin_admin, 'wpn_free_site_config_notice');
        }
        //$this->loader->add_action("admin_menu" , $plugin_admin , "add_new_menu_items_woo_notifier");
        // custom menu for dotstore
        if (empty($GLOBALS['admin_page_hooks']['dots_store'])) {
            $this->loader->add_action('admin_menu', $plugin_admin, 'dot_store_menu_woo_notifier');
        }
        if (!empty($_GET['page']) && (($_GET['page'] == 'woo_notifier'))) {
            $this->loader->add_filter('admin_footer_text', $plugin_admin, 'wpnf_admin_footer_review');
        }
    }

    /**
     * Check if Site url is set to HTTPS
     * @return void
     */
    public function wpn_free_check_ssl() {
        return strpos(get_option('siteurl'), 'https://') !== false;
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && !is_plugin_active_for_network('woocommerce/woocommerce.php')) {
            $this->loader->add_filter('woocommerce_paypal_args', $plugin_public, 'paypal_bn_code_filter_wpnf', 99, 1);
        }
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
     * @return    Woo_Notifier_Lite_Send_Automated_Web_Push_Desktop_Notifications_Loader    Orchestrates the hooks of the plugin.
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

    /**
     * Return the plugin action links.  This will only be called if the plugin
     * is active.
     *
     * @since 1.0.0
     * @param array $actions associative array of action names to anchor tags
     * @return array associative array of plugin action links
     */
    public function wpn_free_plugin_action_links($actions, $plugin_file, $plugin_data, $context)
    {
        $custom_actions = array(
            'configure' => sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=woo_notifier&tab=general-settings'), __('Settings', $this->plugin_name)),
            'Premium' => sprintf('<a href="%s" target="_blank" style="color: rgba(10, 154, 62, 1); font-weight: bold; font-size: 13px;">%s</a>', 'https://store.multidots.com/woocommerce-notifier-send-web-push-notifications/', __('Upgrade To Pro', $this->plugin_name)),

        );

        // add the links to the front of the actions list
        return array_merge($custom_actions, $actions);
    }
}
