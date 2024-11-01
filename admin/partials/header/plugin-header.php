<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
$plugin_name = WPN_FREE_PLUGIN_NAME;
$plugin_version = WPN_FREE_PLUGIN_VERSION;
?>
<div id="dotsstoremain">
    <div class="all-pad">
        <header class="dots-header">
            <div class="dots-logo-main">
                <img  src="<?php echo WPN_FREE_PLUGIN_URL . '/admin/images/Woo-Notifier-icon.png'; ?>">
            </div>
            <div class="dots-header-right">
                <div class="logo-detail">
                    <strong><?php _e($plugin_name, WPN_FREE_PLUGIN_TEXT_DOMAIN); ?> </strong>
                    <span>Free Version <?php echo $plugin_version; ?> </span>
                </div>
                <div class="button-dots">
                     <span class=""><a  target = "_blank" href="https://store.multidots.com/woocommerce-notifier-send-web-push-notifications/" > 
                            <img src="<?php echo WPN_FREE_PLUGIN_URL . 'admin/images/upgrade_new.png'; ?>"></a>
                    </span>
                    <span class="support_dotstore_image"><a  target = "_blank" href="https://store.multidots.com/dotstore-support-panel/" > 
                            <img src="<?php echo WPN_FREE_PLUGIN_URL . '/admin/images/support_new.png'; ?>"></a>
                    </span>
                </div>
            </div>

            <?php
            $wpn_woo_notifier_enable = '';
            $wpn_premium_version = '';
            $wpn_free_newnotification = '';
            $wpn_free_options = '';
            $wpn_free_subscribers = '';
            $wpn_free_notifications_history = '';
            $wpn_free_general = '';
            $dotstore_setting_menu_enable = '';
            $dotpremium_setting_menu_enable = '';
            $dots_about_plugin_introduction = '';

            if (!empty($_GET['page']) && $_GET['page'] == 'woo_notifier' && empty($_GET['tab'])) {
                $wpn_free_newnotification = "active";
            }
            if (!empty($_GET['tab']) && $_GET['tab'] == 'new-notification') {
                $wpn_free_newnotification = "active";
            }
            if (!empty($_GET['tab']) && $_GET['tab'] == 'free-settings') {
                $wpn_free_options = "active";
            }
            if (!empty($_GET['tab']) && $_GET['tab'] == 'dots-about-plugin-introduction-woo-notifier') {
                $dots_about_plugin_introduction = "acitve";
            }
            if (!empty($_GET['tab']) && $_GET['tab'] == 'subscribers-settings') {
                $wpn_free_subscribers = "active";
            }
            if (!empty($_GET['tab']) && $_GET['tab'] == 'notifications-history') {
                $wpn_free_notifications_history = "active";
            }
            if (!empty($_GET['tab']) && $_GET['tab'] == 'general-settings') {
                $wpn_free_general = "active";
            }
            if (!empty($_GET['tab']) && $_GET['tab'] == 'dots-about-plugin-settings') {
                $about_plugin_setting_menu_enable = "active";
            }
            if (!empty($_GET['tab']) && $_GET['tab'] == 'dots-store-plugin-settings') {
                $dotstore_setting_menu_enable = "active";
            }
            if (!empty($_GET['tab']) && $_GET['tab'] == 'dots-premium-plugin-settings') {
                $dotpremium_setting_menu_enable = "active";
            }
            if (!empty($_GET['tab']) && $_GET['tab'] == 'get-started-dots-about-plugin-settings') {
                $dotpremium_setting_menu_enable = "active";
            }

            if (!empty($_GET['tab']) && $_GET['tab'] == 'dots-contact-supports-store-plugin-settings') {
                $dotstore_setting_menu_enable = "active";
            }

            if (!empty($_GET['tab']) && $_GET['tab'] == 'wc_lite_woonotifier_premium_method') {
                $wpn_premium_version = "active";
            }

            $siteTabPath = 'wp-admin/admin.php?page=woo_notifier&tab=';
            ?>

            <div class="dots-menu-main">
                <nav>
                    <ul>
                        <li>
                            <a class="dotstore_plugin <?php echo $wpn_free_newnotification; ?>"  href="<?php echo site_url($siteTabPath . 'new-notification'); ?>">New Notification </a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo $wpn_free_options; ?>" href="<?php echo site_url($siteTabPath . 'free-settings'); ?>">Options </a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo $wpn_free_subscribers; ?>"  href="<?php echo site_url($siteTabPath . 'subscribers-settings'); ?>">Subscribers</a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo $wpn_free_notifications_history; ?>"  href="<?php echo site_url($siteTabPath . 'notifications-history'); ?>">Notification History</a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo $wpn_free_general; ?>"  href="<?php echo site_url($siteTabPath . 'general-settings'); ?>">Settings</a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo $wpn_premium_version; ?>"  href="<?php echo site_url($siteTabPath . 'wc_lite_woonotifier_premium_method'); ?>">Premium Version</a></li>
                        <li>
                            <a class="dotstore_plugin <?php echo $dotpremium_setting_menu_enable; ?>"  href="<?php echo site_url($siteTabPath . 'get-started-dots-about-plugin-settings'); ?>">About Plugin</a>
                            <ul class="sub-menu">
                                <li><a  class="dotstore_plugin <?php echo $dotpremium_setting_menu_enable; ?>" href="<?php echo site_url($siteTabPath . 'get-started-dots-about-plugin-settings'); ?>">Getting Started</a></li>
                                <li><a class="dotstore_plugin <?php echo $dots_about_plugin_introduction; ?>" href="<?php echo site_url($siteTabPath . 'dots-about-plugin-introduction-woo-notifier'); ?>">Quick Info</a></li>
                                <li><a  target="_blank" href="https://store.multidots.com/suggest-a-feature/">Suggest A Feature</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dotstore_plugin " href="javascript:void(0)">Dotstore</a>
                            <ul class="sub-menu">

                                <li><a target="_blank" href="https://store.multidots.com/woocommerce-plugins/">WooCommerce Plugins</a></li>
                                <li><a target="_blank" href="https://store.multidots.com/wordpress-plugins/">Wordpress Plugins</a></li><br>
                                <li><a target="_blank" href="https://store.multidots.com/free-wordpress-plugins/">Free Plugins</a></li>
                                <li><a target="_blank" href="https://store.multidots.com/themes/">Free Themes</a></li>
                                <li><a target="_blank" href="https://store.multidots.com/dotstore-support-panel/">Contact Support</a></li>
                            </ul>
                        </li>
                    </ul>

                    </li>

                    </ul>
                </nav>
            </div>
        </header>