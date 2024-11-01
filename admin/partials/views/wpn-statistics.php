<?php  
global $wpdb;
$push_subscribers_table = $wpdb->prefix . 'woopush_subscribers';

$subscribers_results = $wpdb->get_results('SELECT count(id) as id, DATE_FORMAT(created_at, "%d/%m/%y") as created_at FROM ' . $push_subscribers_table.' Group by DATE_FORMAT(created_at, "%d/%m/%y")');

$user_ip_query = $wpdb->get_results('SELECT count(id) AS id, user_country_name, user_country FROM '.$push_subscribers_table.' GROUP BY user_country_name'); ?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);

function drawChart() {
	<?php if(!empty($subscribers_results)){ ?>
	var data = google.visualization.arrayToDataTable([ ['Date', 'Visits'],

	<?php foreach ($subscribers_results as $subscribers_result) {
		echo "['".$subscribers_result->created_at."',".$subscribers_result->id."],"; }  ?> ]); <?php } ?>
		var options = {
			title: 'Date wise visits',
			vAxis: {
				gridlines: {id: '0'},
				minValue: 0,
				ticks: [0, 5, 10, 15, 20] }
		};
		var chart = new google.visualization.LineChart(document.getElementById("chart_div"));
		chart.draw(data, options);
}
</script>
<?php if(!empty($subscribers_results)){ ?>
<h3>Subscriber User Chart</h3>
<div id="chart_div"  height: 500px;"></div>
<?php }else{  echo "<strong> Record not found</strong><br>"; } ?>

<script type="text/javascript">
google.load("visualization", "1", {packages:["geochart"]});
google.setOnLoadCallback(drawRegionsMap);

function drawRegionsMap() {
	var data = google.visualization.arrayToDataTable([['Country', 'Visits'],
	<?php foreach ($user_ip_query as $user_ip_querys) {
		echo "['".$user_ip_querys->user_country_name."',".$user_ip_querys->id."],";
	} ?> ]);
	var options = {
	};
	var chart = new google.visualization.GeoChart(document.getElementById('geochart'));
	chart.draw(data, options);
}
 </script>
 <?php if(!empty($user_ip_query)){ ?>
 <h3>User Country visitor Chart</h3>
 <div id="geochart" style="height: 500px;"></div>
 <?php } 
 $count = 1;
 foreach ($user_ip_query as $user_ip_querys) {
 	if ($count%5 == 1){
 		echo '<div class="five_col_country_list">';
 	}
 	echo '<div class="all_country_list">';
 	$country_code = strtolower($user_ip_querys->user_country);
 	$Flagname = WOO_PUSH_PLUGIN_URL . 'assets/images/flags/'. substr($country_code, 0, 2).".gif";
 	$no_flag_country = WOO_PUSH_PLUGIN_URL . 'assets/images/flags/noflag.png';
 	if($img = @GetimageSize($Flagname)){
 		echo '<img src="'.$Flagname.'" alt="Icon represents '.substr($country_code, 0, 2).'" width="16" height="11" />';
 	} else {
 		echo '<img src="'.$no_flag_country.'" alt="No country" width="16" height="11" />';
 	}
 	echo '<span class="user_country">'. $user_ip_querys->user_country_name. '</span>';
 	echo '<span class="user_country">' .$user_ip_querys->id .'</span>';
 	echo '</div>';
 	if ($count%5 == 0){
 		echo "</div>";
 	}
 	$count++;
 } 
 ?>
 