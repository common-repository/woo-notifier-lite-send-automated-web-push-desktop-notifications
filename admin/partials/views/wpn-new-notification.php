<?php
$notificationTitle = '';
$notificationMessage = '';
$notificationUrl = '';
$notificationIcon = '';
$apiKey = get_option('woo_push_api_key');
$url = 'https://fcm.googleapis.com/fcm/send';
$ids = $this->wpn_free_get_clientids();

if (isset($_GET['notification_title']) && !empty($_GET['notification_title'])) {
    $notificationTitle = $_GET['notification_title'];
}
if (isset($_GET['notification_message']) && !empty($_GET['notification_message'])) {
    $notificationMessage = $_GET['notification_message'];
}
if (isset($_GET['notification_url']) && !empty($_GET['notification_url'])) {
    $notificationUrl = $_GET['notification_url'];
}
if (isset($_GET['notification_icon']) && !empty($_GET['notification_icon'])) {
    $notificationIcon = $_GET['notification_icon'];
}
?>
<style type="text/css">
    .wpn-main-table table.wpn-table-outer tr td {
        font-size: 13px;
        color: #333;
        padding: 20px;
        border-right: 1px solid #ddd;
        line-height: 20px;
        border: 0px; 
    }
</style>
<div class="updated notice is-dismissible" id="wpn-send-message" style="display:none"></div>
<div id='error-message' style="display:none" class=" notice notice-error is-dismissible" >
    <p><span class="wpn-error-message"> Before sending notification you need to set the FCM Server Key,Sender ID and Firebase Script you will get it on this  </span> 
        <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=woo_notifier&tab=general-settings" >General	</a> link</p>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
</div>

<?php
$apiKey = get_option('woo_push_api_key');
$project_number = get_option('woo_push_project_number');
$wpn_web_code = trim(get_option('woo_web_code'));

if (!empty($wpn_web_code)) {
    $wpn_apiKey = (!empty($apiKey)) ? $apiKey : 'nothing';
    $wpn_project_number = (!empty($project_number)) ? $project_number : 'nothing';
} else {
    $wpn_apiKey = 'nothing';
    $wpn_project_number = 'nothing';
}
?>

<input type="hidden" name="notification-api-key" class="notification-api-key" value="<?php echo $wpn_apiKey; ?>">
<input type="hidden" name="notification-project-number" class="notification-project-number" value="<?php echo $wpn_project_number; ?>">
<div class="wpn-main-table  new-notification res-cl">
    <h2>Create New Notification </h2>
    <table class="wpn-table-outer" enctype="multipart/form-data">
        <tbody>
            <tr class="n_inner_form">
                <td class="widht-log" style="width:50%">
                    <table border="0">
                        <tr valign="top">
                            <td scope="row" colspan="2">Title<span class="require-filed">*</span>
                                <input  maxlength="50" type="text" id="wpn_title" name="wpn_title" target="wpn_title_append" placaholder="Notification Title" value="<?php echo $notificationTitle; ?>"></td>
                        </tr>
                        <tr valign="top">
                            <td scope="row" colspan="2">Message<span class="require-filed">*</span>

                                <textarea  maxlength="200" cols="35" rows="3" id="wpn_message" name="wpn_message" target="wpn_message_append" placaholder="Notification Message"><?php echo $notificationMessage; ?></textarea></td>

                        </tr>
                        <tr valign="top">
                            <td scope="row" colspan="2">URL
                                <input type="text" id="wpn_url" name="wpn_url" target="wpn_url_append" placaholder="example.com" value="<?php echo $notificationUrl; ?>"><span class="example-filed">ex : https://example.com</span>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td scope="row" class="non">Image</td>
                            <td>					        
                                <label class="n_web_push_form">	
                                    <span class="n_file_label">Browse a File</span>
                                </label>
                                <span class="wpn_error_message" style="color:red"></span>					        	
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>
                                <input type="submit" class="button button-primary" id="wpn_push_notification" value="Send Push Notification" name="wpn_push">
                            </th>
                        </tr>
                    </table>
                </td>
                <td>
                    <div class="n_notification_preview">
                        <h4>Notification Preview</h4>
                        <div class="n_notification_block">
                            <div class="n_img_block">
                                <?php if (empty($notificationIcon)) { ?>
                                    <img src="<?php echo WPN_FREE_PLUGIN_URL . 'admin/images/woo-notifier-free-plugin.png'; ?>" alt="notification preview">
                                <?php } else { ?>
                                    <img src="<?php echo $notificationIcon; ?>" alt="notification preview">
                                <?php } ?>
                            </div><!-- .n_img_block -->
                            <div class="n_text_block">
                                <?php if (empty($notificationTitle)) { ?>
                                    <span class="wpn_title_append">Notification Title</span>
                                <?php } else { ?>
                                    <span class="wpn_title_append"><?php echo $notificationTitle; ?></span>
                                <?php } ?>
                                <?php if (empty($notificationMessage)) { ?>
                                    <div class="wpn_message_append">Notification Message</div>
                                <?php } else { ?>
                                    <div class="wpn_message_append"><?php echo $notificationMessage; ?></div>
                                <?php } ?>
                                <?php if (empty($notificationUrl)) { ?>
                                    <span class="wpn_url_append">example.com</span>
                                <?php } else { ?>
                                    <span class="wpn_url_append"><?php echo $notificationUrl; ?></span>
                                <?php } ?>		  
                            </div><!-- .n_text_block -->

                        </div><!-- .n_notification_block -->
                    </div><!-- .n_notification_preview -->
                    <div class="wpn_default_icon" style="display: none;"><?php echo WPN_FREE_PLUGIN_URL . 'admin/images/woo-notifier-free-plugin.png'; ?></div>
                </td>
            </tr>
            </div>
        </tbody>
    </table>

