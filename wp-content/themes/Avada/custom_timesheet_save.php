<?php /* Template name: Timesheet Save */ ?>
<?php header("Location: /timesheet/"); ?>
<?php
$date_now_week = date('Y/m/d');
$duedt = explode("/", $date_now_week);
$date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
$week_number  = (int)date('W', $date);
	
$date_now = date('d/m/Y');
$day_now = date('l');
$display_date_now = date('l d M');
$num_date = date('d');
global $wpdb;			
$table_name = $wpdb->prefix . "custom_timesheet";
$user_id = get_current_user_id();
$user_data = get_userdata($user_id);
$user_name = $user_data->display_name;
?>
<?php 	
if(isset($_POST['save'])):
	global $wpdb;
	$date_now = $_POST['date_now'];
	$day_now = $_POST['day_now'];
	$week_number = $_POST['week_number'];
	$task_name_array = $_POST['task_name'];	
	$task_hour = $_POST['task_hour'];
	$task_label = $_POST['task_label'];
	$task_person = $_POST['task_person'];	
	$user_id = $_POST['user_id'];	
	
	foreach ( $task_name_array as $key => $task_name):		
	$insert = $wpdb->insert( $table_name , array( 
	'date_now' => $date_now,
	'day_now' => $day_now,
	'week_number' => $week_number,
	'task_name' => $task_name,
	'task_hour' => $task_hour[$key],
	'task_label' => $task_label[$key],	
	'task_person' => $task_person[$key],
	'user_id' => $user_id[$key],
	'status' => 1
	),	
	array( '%s', '%s' ));
	endforeach;
	if($insert == 1):
		echo "<p class='message'>";
		echo "Task saved";
	else:
		echo "Save failed";
		echo "</p>";
	endif;	
endif;
?>