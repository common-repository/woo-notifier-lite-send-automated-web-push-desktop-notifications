<?php
global $wpdb;
$push_subscribers_table = $wpdb->prefix . 'woopush_subscribers';
$pagenum = isset($_GET['pagenum']) ? absint($_GET['pagenum']) : 1;

if (isset($_GET['delete_subscriber']) && !empty($_GET['delete_subscriber'])) {
    $delete_subscriber = $wpdb->query('DELETE FROM ' . $push_subscribers_table . ' where id=' . $_GET['delete_subscriber']);
}
$limit = 10;
$offset = ($pagenum - 1) * $limit;
$total = $wpdb->get_var('SELECT COUNT(`id`) FROM ' . $push_subscribers_table);
$num_of_pages = ceil($total / $limit);
$subscribers = $wpdb->get_results('SELECT * FROM ' . $push_subscribers_table . ' ORDER BY  `created_at` DESC LIMIT ' . $offset . ', ' . $limit);
$page_links = paginate_links(array(
    'base' => add_query_arg('pagenum', '%#%'),
    'format' => '',
    'prev_text' => '&laquo;',
    'next_text' => '&raquo;',
    'total' => $num_of_pages,
    'current' => $pagenum,
        ));
?>
<div class="wpn-wrap">
    <?php $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $query = parse_url($url, PHP_URL_QUERY);
    ?>
    <div class="wpn-main-table res-cl">
        <h2>Subscribers (<?php echo $total; ?>)</h2>
        <table class="widefat wpn-table-outer">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Ip</th>  
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>User Ip</th>   
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                if (!empty($subscribers)) {
                    $count = $offset;
                    foreach ($subscribers as $subscriber) {
                        $count++;
                        $user_info = get_userdata($subscriber->user_id);
                        ?>
                        <tr>
                            <th><?php echo $count; ?></th>
                            <th class="regID"><?php echo!empty($subscriber->user_ip_address) ? $subscriber->user_ip_address : 'NA'; ?></th>
                            <th><?php echo $subscriber->created_at; ?></th>       
                            <?php
                            if ($query) {
                                if (isset($subscriber->id) && !empty($subscriber->id)) {
                                    $delete_url = '';
                                    $delete_url = $url;
                                    if (isset($_GET['delete_subscriber'])) {
                                        $delete_url = str_replace('&delete_subscriber=' . $_GET['delete_subscriber'] . '', '', $delete_url);
                                    }
                                    $delete_url .= '&delete_subscriber=' . $subscriber->id;
                                }
                            } else {
                                if (isset($subscriber->id) && !empty($subscriber->id)) {
                                    $delete_url = '';
                                    $delete_url = $url;
                                    if (isset($_GET['delete_subscriber'])) {
                                        $delete_url = str_replace('&delete_subscriber=' . $_GET['delete_subscriber'] . '', '', $delete_url);
                                    }
                                    $delete_url .= '?delete_subscriber=' . $subscriber->idd;
                                }
                            }
                            ?>
                            <th><a href="<?php echo $delete_url; ?>" class="subscribers_row_delete">Delete</a></th>       
                        </tr><?php }
        } else {
                        ?>
                    <tr><th><?php echo 'No subscribers found.'; ?></th></tr>
<?php } ?>
            </tbody>
        </table>

<?php
if ($page_links) {
    echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
}
?>
    </div>
