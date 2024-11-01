<?php
global $wpdb;
$push_notifications_table = $wpdb->prefix . 'woopush_notifications';

if (isset($_GET['delete_notification']) && !empty($_GET['delete_notification'])) {
    $delete_notification = $wpdb->query('DELETE FROM ' . $push_notifications_table . ' where id=' . $_GET['delete_notification']);
}
$pagenum = isset($_GET['pagenum']) ? absint($_GET['pagenum']) : 1;
$counter = '';
$limit = 10;
$offset = ($pagenum - 1) * $limit;
$total = $wpdb->get_var('SELECT COUNT(`id`) FROM ' . $push_notifications_table);

$num_of_pages = ceil($total / $limit);

$notifications = $wpdb->get_results('SELECT * FROM ' . $push_notifications_table . ' ORDER BY  `created_at` DESC LIMIT ' . $offset . ', ' . $limit);

$page_links = paginate_links(array(
    'base' => add_query_arg('pagenum', '%#%'),
    'format' => '',
    'prev_text' => '&laquo;',
    'next_text' => '&raquo;',
    'total' => $num_of_pages,
    'current' => $pagenum,
        ));

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$query = parse_url($url, PHP_URL_QUERY);
?>
<div class="wpn-wrap">
    <div class="wpn-main-table res-cl">
        <h2>Notifications (<?php echo $total; ?>)</h2>
        <div id='error-message' class='error' style="display:none"></div>
        <div class="wpn-resend-message-outer"></div>
        <table class="widefat wpn-table-outer">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Notification Preview</th>       
                    <th>Sent Date</th>
                    <th colspan="2">Delete</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Notification Preview</th>       
                    <th>Sent Date</th>
                    <th colspan="2">Delete</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                if (!empty($notifications)) {
                    $count = $offset;
                    $notificationDetails = '';
                    $notificationDetails = '';
                    $notificationIcon = '';
                    $notificationTitle = '';
                    $notificationMessage = '';
                    $notificationUrl = '';
                    foreach ($notifications as $notification) {
                        $count++;
                        $notificationDetails = json_decode($notification->notification);
                        if (!empty($notificationDetails) && $notificationDetails != '') {
                            $notificationIcon = $notificationDetails->icon;
                            $notificationTitle = $notificationDetails->title;
                            $notificationMessage = $notificationDetails->message;
                            $notificationUrl = $notificationDetails->url;
                        }
                        ?>
                        <tr>
                            <th><?php echo $count; ?></th>
                            <th class="lite-class"><div class="notification_history_preview">
                        <div class="notification_history_block">
                            <div class="wpn_img_block">
                                <img src="<?php echo $notificationIcon; ?>" alt="notification icon">
                            </div>
                            <div class="wpn_text_block">
                                <span class="wpn_title_append"><?php echo $notificationTitle; ?></span>
                                <div class="wpn_message_append"><?php echo $notificationMessage; ?></div>
                                <span class="wpn_url_append"><?php echo $notificationUrl; ?></span>
                            </div><!-- .n_text_block -->

                        </div><!-- .n_notification_block -->
                    </div></th><!-- .n_notification_preview -->       
                    <th><?php echo $notification->created_at; ?></th>
                    <?php
                    if ($query) {
                        if (isset($notification->id) && !empty($notification->id)) {
                            $delete_url = '';
                            $delete_url = $url;
                            if (isset($_GET['delete_notification']) && !empty($_GET['delete_notification'])) {
                                $delete_url = str_replace('&delete_notification=' . $_GET['delete_notification'] . '', '', $delete_url);
                            }
                            $delete_url .= '&delete_notification=' . $notification->id;
                        }
                    } else {
                        if (isset($notification->id) && !empty($notification->id)) {
                            $delete_url = '';
                            $delete_url = $url;
                            $delete_url = str_replace('&delete_notification=' . $_GET['delete_notification'] . '', '', $delete_url);
                            $delete_url .= '?delete_notification=' . $notification->id;
                        }
                    }
                    ?>
                    <th><a href="<?php echo $delete_url; ?>" class="notification_row_delete">Delete</a></th>   
                    <th><?php echo $counter; ?></th>   
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><th><?php echo 'No notifications found.'; ?></th></tr>
            <?php } ?>
            </tbody>
        </table>
        <?php
        if ($page_links) {
            echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
        }
        ?>
    </div>


    <!-- end here !-->	
