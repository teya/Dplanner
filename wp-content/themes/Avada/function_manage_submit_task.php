<?php
/* ==================================== CRON SCHEDULES ==================================== */		
add_filter( 'cron_schedules', 'custom_cron_schedules');		
date_default_timezone_set('Asia/Manila');
function custom_cron_schedules(){
	/* Defaults:  hourly, twicedaily, daily */
	
	return array(
	'per_minute' => array(
	'interval' => 60,
	'display' => 'Every Minute'
	),	
	'twice_hourly' => array(
	'interval' => 1800,
	'display' => 'Twice per Hour'
	),	
	'weekly' => array(
	'interval' => 604800,
	'display' => 'Once a Week'
	),	
	'twice_weekly' => array(
	'interval' => 302400,
	'display' => 'Twice a Week'
	),	
	'monthly' => array(
	'interval' => 2628002,
	'display' => 'Once a Month'
	),	
	'twice_monthly' => array(
	'interval' => 1314001,
	'display' => 'Twice a Month'
	),	
	'yearly' => array(
	'interval' => 31536000,
	'display' => 'Once a Year'
	),	
	'twice_yearly' => array(
	'interval' => 15768012,
	'display' => 'Twice a Year'
	),	
	'four_yearly' => array(
	'interval' => 15768012,
	'display' => 'Four Times a Year'
	),	
	'six_yearly' => array(
	'interval' => 5256004,
	'display' => 'Six Times a Year'
	),
	);
}
/* ==================================== CRON SCHEDULES ==================================== */

/* ==================================== END SCHEDULE CRON ==================================== */
function schedule_cron($submit_schedule_each, $timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	switch($submit_schedule_each){
		case 'Per Minute':
			cron_per_minute($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'		=> 'cron_per_minute_action_'.$submit_id,
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Once per Hour':
			cron_hourly($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_hourly_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Twice per Hour':
			cron_twice_per_hour($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_twice_per_hour_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Once a Day':
			cron_once_a_day($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_once_a_day_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Twice a Day':
			cron_twice_a_day($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_twice_a_day_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Once a Week':
			cron_once_a_week($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_once_a_week_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Twice a Week':
			cron_twice_a_week($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_twice_a_week_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Once a Month':
			cron_monthly($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_monthly_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Twice a Month':
			cron_twice_a_month($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_twice_a_month_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Once a Year':
			cron_yearly($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_yearly_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Twice a Year':
			cron_twice_a_year($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_twice_a_year_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Four Times a Year':
			cron_four_per_year($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_four_per_year_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;
		case 'Six Times a Year':
			cron_six_a_year($timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			$wpdb->update( $table_name , array( 
			'submit_cron_label'	=> 'cron_six_per_year_action_'.$submit_id
			),
			array( 'ID' => $submit_id ),
			array( '%s', '%s' ));
		break;				
	}
}
/* ==================================== END SCHEDULE CRON ==================================== */

/* ==================================== CRON FUNCTIONS ==================================== */
/* PER MINUTE */
add_action('schedule_per_minute', 'cron_per_minute_action');

function cron_per_minute($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'per_minute', 'schedule_per_minute', $args);
}

function cron_per_minute_action($submit_id) {
	kanban_submit_scheduled_task('cron_per_minute_action_'.$submit_id);
}

/* HOURLY */
add_action('schedule_hourly', 'cron_hourly_action');

function cron_hourly($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'hourly', 'schedule_hourly', $args);
}

function cron_hourly_action($submit_id) {
	kanban_submit_scheduled_task('cron_hourly_action_'.$submit_id);
}

/* TWICE PER HOUR */
add_action('schedule_twice_per_hour', 'cron_twice_per_hour_action');

function cron_twice_per_hour($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'twice_hourly', 'schedule_twice_per_hour', $args);
}

function cron_twice_per_hour_action($submit_id) {
	kanban_submit_scheduled_task('cron_twice_per_hour_action_'.$submit_id);
}

/* ONCE A DAY */
add_action('schedule_once_a_day', 'cron_once_a_day_action');

function cron_once_a_day($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'daily', 'schedule_once_a_day', $args);
}

function cron_once_a_day_action($submit_id) {
	kanban_submit_scheduled_task('cron_once_a_day_action_'.$submit_id);
}

/* TWICE A DAY */
add_action('schedule_twice_a_day', 'cron_twice_a_day_action');

function cron_twice_a_day($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'twicedaily', 'schedule_twice_a_day', $args);
}

function cron_twice_a_day_action($submit_id) {
	kanban_submit_scheduled_task('cron_twice_a_day_action_'.$submit_id);
}

/* ONCE A WEEK */
add_action('schedule_once_a_week', 'cron_schedule_once_a_week_action');

function cron_once_a_week($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'weekly', 'schedule_once_a_week', $args);
}

function cron_schedule_once_a_week_action($submit_id) {
	kanban_submit_scheduled_task('cron_once_a_week_action_'.$submit_id);
}

/* TWICE A WEEK */
add_action('schedule_twice_a_week', 'cron_schedule_twice_a_week');

function cron_twice_a_week($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'twice_weekly', 'schedule_twice_a_week', $args);
}

function cron_schedule_twice_a_week($submit_id) {
	kanban_submit_scheduled_task('cron_twice_a_week_action_'.$submit_id);
}

/* MONTHLY */
add_action('schedule_monthly', 'cron_schedule_monthly');

function cron_monthly($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'monthly', 'schedule_monthly', $args);
}

function cron_schedule_monthly($submit_id) {
	kanban_submit_scheduled_task('cron_monthly_action_'.$submit_id);
}		

/* TWICE A MONTH */
add_action('schedule_twice_a_month', 'cron_schedule_twice_a_month');

function cron_twice_a_month($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'twice_monthly', 'schedule_twice_a_month', $args);
}

function cron_schedule_twice_a_month($submit_id) {
	kanban_submit_scheduled_task('cron_twice_a_month_action_'.$submit_id);
}

/* YEARLY */
add_action('schedule_yearly', 'cron_schedule_yearly');

function cron_yearly($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'yearly', 'schedule_yearly', $args);
}

function cron_schedule_yearly($submit_id) {
	kanban_submit_scheduled_task('cron_yearly_action_'.$submit_id);
}
		
/* TWICE A YEAR */
add_action('schedule_twice_a_year', 'cron_schedule_twice_a_year');

function cron_twice_a_year($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'twice_yearly', 'schedule_twice_a_year', $args);
}

function cron_schedule_twice_a_year($submit_id) {
	kanban_submit_scheduled_task('cron_twice_a_year_action_'.$submit_id);
}

/* FOUR PER YEAR */
add_action('schedule_four_per_year', 'cron_schedule_four_per_year');

function cron_four_per_year($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'four_yearly', 'schedule_four_per_year', $args);
}

function cron_schedule_four_per_year($submit_id) {
	kanban_submit_scheduled_task('cron_four_per_year_action_'.$submit_id);
}

/* SIX PER YEAR */
add_action('schedule_six_per_year', 'cron_schedule_six_per_year');

function cron_six_a_year($time, $submit_id, $task_name, $task_description, $task_label, $task_unique_id) {
	$args = array(
		'submit_id' 		=> $submit_id,
		'task_name' 		=> $task_name,
		'task_description'	=> $task_description,
		'task_label'		=> $task_label,
		'task_unique_id'	=> $task_unique_id
	);
	wp_schedule_event($time, 'six_yearly', 'schedule_six_per_year', $args);
}

function cron_schedule_six_per_year($submit_id) {
	kanban_submit_scheduled_task('cron_six_per_year_action_'.$submit_id);
}
/* ==================================== END CRON FUNCTIONS ==================================== */

/* ==================================== SUBMIT SCHEDULE TASK ==================================== */
function submit_scheduled_task($submit_schedule_task_data){
	global $wpdb;
	
	$table_name = $wpdb->prefix . "custom_submit_task";
	$table_name_checklist_task = $wpdb->prefix . "custom_checklist_task";
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template";
	$submit_form_data = array();
	parse_str($submit_schedule_task_data, $submit_form_data);	
	$submit_label_multiple			= $submit_form_data['submit_label'];
		
	foreach($submit_label_multiple as $submit_label){
		$submit_cron_unique_id 			= uniqid();
		$submit_task_name				= (isset($submit_form_data['submit_task_name']) ? $submit_form_data['submit_task_name'] : '');
		$submit_task_name_suffix 		= (isset($submit_form_data['submit_task_name_suffix']) ? $submit_form_data['submit_task_name_suffix'] : '');
		$submit_task_name_suffix_time 	= (isset($submit_form_data['submit_task_name_suffix_time']) ? $submit_form_data['submit_task_name_suffix_time'] : '');
		$submit_description 			= (isset($submit_form_data['submit_description']) ? $submit_form_data['submit_description'] : '');
		$submit_color 					= (isset($submit_form_data['submit_color']) ? $submit_form_data['submit_color'] : '');
		$submit_project_name 			= (isset($submit_form_data['submit_project_name']) ? $submit_form_data['submit_project_name'] : '');
		$submit_responsible_person 		= (isset($submit_form_data['submit_responsible_person']) ? $submit_form_data['submit_responsible_person'] : '');
		$submit_collaborators_array		= (isset($submit_form_data['submit_collaborators']) ? $submit_form_data['submit_collaborators'] : '');
		$submit_collaborators 			= serialize($submit_collaborators_array);
		$submit_time_spent_hour 		= (isset($submit_form_data['submit_time_spent_hour']) ? $submit_form_data['submit_time_spent_hour'] : '');
		$submit_time_spent_minute 		= (isset($submit_form_data['submit_time_spent_minute']) ? $submit_form_data['submit_time_spent_minute'] : '');
		$submit_time_estimate_hour 		= (isset($submit_form_data['submit_time_estimate_hour']) ? $submit_form_data['submit_time_estimate_hour'] : '');
		$submit_time_estimate_minute 	= (isset($submit_form_data['submit_time_estimate_minute']) ? $submit_form_data['submit_time_estimate_minute'] : '');
		$submit_subtask_array			= (isset($submit_form_data['submit_subtask']) ? $submit_form_data['submit_subtask'] : '');
		$submit_subtask					= serialize($submit_subtask_array);
		$submit_department 				= (isset($submit_form_data['submit_department']) ? $submit_form_data['submit_department'] : '');
		$submit_department_name 		= (isset($submit_form_data['submit_department_name']) ? $submit_form_data['submit_department_name'] : '');
		$submit_column 					= (isset($submit_form_data['submit_column']) ? $submit_form_data['submit_column'] : '');
		$submit_column_name 			= (isset($submit_form_data['submit_column_name']) ? $submit_form_data['submit_column_name'] : '');
		$submit_checklist 				= (isset($submit_form_data['submit_checklist']) ? $submit_form_data['submit_checklist'] : '');
		
		if($submit_checklist == 1){
			$submit_checklist_template 	= $submit_form_data['submit_checklist_template'];
		}else{
			$submit_checklist_template	= "";
		}
		if($submit_form_data['add_checklist_template_input'] != null){
			$add_checklist_template_input = $submit_form_data['add_checklist_template_input'];
		}else{
			$add_checklist_template_input = "";
		}
		$submit_schedule_each 			= (isset($submit_form_data['submit_schedule_each']) ? $submit_form_data['submit_schedule_each'] : '');
		$submit_setlocale 				= (isset($submit_form_data['submit_setlocale']) ? $submit_form_data['submit_setlocale'] : '');
		$submit_starting_date 			= (isset($submit_form_data['submit_starting_date']) ? $submit_form_data['submit_starting_date'] : '');
		$submit_hour 					= (isset($submit_form_data['submit_hour']) ? $submit_form_data['submit_hour'] : '');
		$submit_minute 					= (isset($submit_form_data['submit_minute']) ? $submit_form_data['submit_minute'] : '');
		$submit_end_date 				= (isset($submit_form_data['submit_end_date']) ? $submit_form_data['submit_end_date'] : '');
		$submit_end_hour 				= (isset($submit_form_data['submit_end_hour']) ? $submit_form_data['submit_end_hour'] : '');
		$submit_end_minute 				= (isset($submit_form_data['submit_end_minute']) ? $submit_form_data['submit_end_minute'] : '');
						
		$insert = $wpdb->insert( $table_name , array( 
			'submit_task_name'				=> $submit_task_name,
			'submit_task_name_suffix'		=> $submit_task_name_suffix,
			'submit_task_name_suffix_time'	=> $submit_task_name_suffix_time,
			'submit_description'			=> $submit_description,
			'submit_label'					=> $submit_label,
			'submit_responsible_person'		=> $submit_responsible_person,
			'submit_collaborators'			=> $submit_collaborators,
			'submit_color'					=> $submit_color,
			'submit_project_name'			=> $submit_project_name,
			'submit_time_spent_hour'		=> $submit_time_spent_hour,
			'submit_time_spent_minute'		=> $submit_time_spent_minute,
			'submit_time_estimate_hour'		=> $submit_time_estimate_hour,
			'submit_time_estimate_minute'	=> $submit_time_estimate_minute,
			'submit_subtask'				=> $submit_subtask,
			'submit_department'				=> $submit_department,
			'submit_department_name'		=> $submit_department_name,
			'submit_column'					=> $submit_column,
			'submit_column_name'			=> $submit_column_name,
			'submit_checklist_template'		=> $submit_checklist_template,
			'submit_schedule_each'			=> $submit_schedule_each,
			'submit_starting_date'			=> $submit_starting_date,	
			'submit_hour'					=> $submit_hour,
			'submit_minute'					=> $submit_minute,
			'submit_end_date'				=> $submit_end_date,
			'submit_end_hour'				=> $submit_end_hour,
			'submit_end_minute'				=> $submit_end_minute,
			'submit_cron_unique_id'			=> $submit_cron_unique_id,
			'submit_cron_status'			=> 'ongoing'
			
		), array( '%s', '%s' ));
		global $submit_id;
		$submit_id = $wpdb->insert_id;
		$today = date('m/d/Y');
		if($submit_checklist == 1){
			if($add_checklist_template_input == null){				
				$insert = $wpdb->insert( $table_name_checklist_task , array( 
					'task_checklist_template'		=> $submit_checklist_template,
					'task_checklist_project_name'	=> $submit_project_name,
					'task_checklist_client_name'	=> $submit_label,
					'task_checklist_person_name'	=> $submit_responsible_person,
					'task_checklist_date_created'	=> $today,
					'task_checklist_date_scheduled'	=> $submit_starting_date,
					'task_checklist_status'			=> 'Ongoing'
				), array( '%s', '%s' ));
			}else{
				$checklist_template_items = $wpdb->get_row("SELECT checklist_items FROM {$table_name_checklist_template} WHERE checklist_template='$submit_checklist_template'");
				$insert_template = $wpdb->insert( $table_name_checklist_template , array( 
				'checklist_template'		=> $add_checklist_template_input,
				'checklist_items'			=> $checklist_template_items->checklist_items
				), array( '%s', '%s' ));
				
				$insert = $wpdb->insert( $table_name_checklist_task , array( 
				'task_checklist_template'		=> $add_checklist_template_input,
				'task_checklist_project_name'	=> $submit_project_name,
				'task_checklist_client_name'	=> $submit_label,
				'task_checklist_person_name'	=> $submit_responsible_person,
				'task_checklist_date_created'	=> $today,
				'task_checklist_date_scheduled'	=> "Submitted",
				'task_checklist_status'			=> 'Ongoing'
				), array( '%s', '%s' ));
			}
		}
		
		date_default_timezone_set('Asia/Manila');		
		$date_format = date("n/j/Y" , strtotime($submit_starting_date));
		$date_array = explode("/", $date_format);
		$month	= $date_array['0'];
		$day 	= $date_array['1'];
		$year	= $date_array['2'];
		
		$cron_hook = $submit_task_name ."-". $submit_starting_date ."-". $submit_hour .":". $submit_minute;
		$function_name = $cron_hook ."_function_name";
		$cron_hook_function_name = str_replace(' ', '_', $function_name);
		
		if($month != null && $day != null && $year != null){
			if($submit_hour != null && $submit_minute != null){
				$timestamp = mktime($submit_hour, $submit_minute, '0', $month, $day , $year);	
			}else{
				$timestamp = mktime('0', '1', '0', $month, $day , $year);
			}
			schedule_cron($submit_schedule_each, $timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
		}
		$schedule_today = $submit_form_data['schedule_today'];
		if($schedule_today == 1){
			$seconds = 50000;
			set_time_limit($seconds);
			$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
			$url="https://kanbanflow.com/api/v1/board?" . $token;
			$result = file_get_contents($url);
			$result_array = json_decode($result, true);
			
			
			$url_users = "https://kanbanflow.com/api/v1/users" . "?&" . $token;
			$result_users = file_get_contents($url_users);
			$result_users_array = json_decode($result_users, true);	
			
			foreach($result_users_array as $result_users){
				if($result_users['fullName'] == $submit_responsible_person){
					$responsible_id = $result_users['_id'];
				}
			}
			
			$time_seconds_spent = (3600 * $submit_time_spent_hour) + (60 * $submit_time_spent_minute);
			$time_seconds_estimate = (3600 * $submit_time_estimate_hour) + (60 * $submit_time_estimate_minute);
			
			$submit_color_lowercase = strtolower($submit_color);
			
			$data = json_encode(array(
			'name' 					=> $submit_task_name ." - ". $submit_task_name_suffix,
			'description'			=> $submit_description,
			'responsibleUserId'		=> $responsible_id,
			'color'					=> $submit_color_lowercase,
			'columnId' 				=> $submit_column,
			'swimlaneId' 			=> $submit_department,
			'totalSecondsSpent' 	=> $time_seconds_spent,
			'totalSecondsEstimate'	=> $time_seconds_estimate		
			));
			
			$submit_token = base64_encode("apiToken:e1f2928c903625d1b6b2e7b00ec12031");
			
			$headers = array(
			"Authorization: Basic " . $submit_token,
			"Content-type: application/json"
			);
			
			$url = "https://kanbanflow.com/api/v1/tasks";	
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$response = curl_exec($curl);	
			$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);
			
			$task_id_array = json_decode($response);
			$task_id = $task_id_array->taskId;
			
			$data_label = json_encode(array(
			'name'			=> $submit_label,
			'columnId' 		=> $submit_column,
			'swimlaneId' 	=> $submit_department
			));
			
			$url_label = "https://kanbanflow.com/api/v1/tasks/$task_id/labels";
			$curl_label = curl_init();
			curl_setopt($curl_label, CURLOPT_URL, $url_label);
			curl_setopt($curl_label, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl_label, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_label, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl_label, CURLOPT_POST, true);
			curl_setopt($curl_label, CURLOPT_POSTFIELDS, $data_label);
			$response_label = curl_exec($curl_label);	
			$status_label = curl_getinfo($curl_label, CURLINFO_HTTP_CODE);
			curl_close($curl_label);
			
			if ($submit_collaborators != "N;"){	
				$unserialize_collaborators = unserialize($submit_collaborators);
				foreach($result_users_array as $result_users){
					foreach($unserialize_collaborators as $unserialize_collaborator){			
						if($result_users['fullName'] == $unserialize_collaborator){
							$collaborator_id = $result_users['_id'];
							$data_collaborator = json_encode(array(
							'userId'		=> $collaborator_id,
							'columnId' 		=> $submit_column,
							'swimlaneId' 	=> $submit_department
							));
							
							$url_collaborator = "https://kanbanflow.com/api/v1/tasks/$task_id/collaborators";
							$curl_collaborator = curl_init();
							curl_setopt($curl_collaborator, CURLOPT_URL, $url_collaborator);
							curl_setopt($curl_collaborator, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($curl_collaborator, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($curl_collaborator, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($curl_collaborator, CURLOPT_POST, true);
							curl_setopt($curl_collaborator, CURLOPT_POSTFIELDS, $data_collaborator);
							$response_collaborator = curl_exec($curl_collaborator);	
							$status_collaborator = curl_getinfo($curl_collaborator, CURLINFO_HTTP_CODE);
							curl_close($curl_collaborator);
						}
					}
				}
			}
			
			if ($submit_subtask != "N;"){
				$unserialize_subtasks = unserialize($submit_subtask);
				foreach($unserialize_subtasks as $unserialize_subtask){
					$data_subtask = json_encode(array(
					"name" => $unserialize_subtask
					));
					
					$url_subtask = "https://kanbanflow.com/api/v1/tasks/$task_id/subtasks";
					$curl_subtask = curl_init();
					curl_setopt($curl_subtask, CURLOPT_URL, $url_subtask);
					curl_setopt($curl_subtask, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl_subtask, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl_subtask, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($curl_subtask, CURLOPT_POST, true);
					curl_setopt($curl_subtask, CURLOPT_POSTFIELDS, $data_subtask);
					$response = curl_exec($curl_subtask);	
					$status = curl_getinfo($curl_subtask, CURLINFO_HTTP_CODE);
					curl_close($curl_subtask);
				}
			}
		}
		
		$submit_form_data['id'][] = $submit_id;
		$submit_form_data['label_id'][] = $submit_label."_".$submit_id;
	}
		return $submit_form_data;	
}
function check_project_exist($check_details){
	global $wpdb;
	$table_name_project = $wpdb->prefix . "custom_project";
	
	$response_array = array();
	
	$check_details_explode = explode('_', $check_details);
	$project_name = $check_details_explode[0];
	$client_name = $check_details_explode[1];	
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project} WHERE project_name = '$project_name' AND project_client ='$client_name'");	
	if($projects != null){
		$response = '1';
	}else{
		$response = '0';
	}
	$response_array['response'] = $response;
	$response_array['client_name'] = $client_name;
	$response_array['project_name'] = $project_name;
	return $response_array;
}

/* ==================================== END SUBMIT SCHEDULE TASK ==================================== */

/* ==================================== END START SUBMIT ==================================== */
function submit_task_cron_start($start_cron_id){ 

	$seconds = 50000;
	set_time_limit($seconds);
	$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
	$url="https://kanbanflow.com/api/v1/board?" . $token;
	$result = file_get_contents($url);
	$result_array = json_decode($result, true);
	
	$submit_schedule_each_options = array(
		'Per Minute', 
		'Once per Hour', 
		'Twice per Hour',
		'Once a Day',
		'Twice a Day',
		'Once a Week', 
		'Twice a Week', 
		'Once a Month', 
		'Twice a Month', 
		'Once a Year',
		'Twice a Year',
		'Four Times a Year',
		'Six Times a Year'
	); 
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	$start_edit = $wpdb->get_row("SELECT * FROM $table_name WHERE id=$start_cron_id");
	$table_name_task = $wpdb->prefix . "custom_task";
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
	$table_name_color = $wpdb->prefix . "custom_project_color";
	$colors = $wpdb->get_results("SELECT * FROM {$table_name_color}");
	$table_name_person = $wpdb->prefix . "custom_person";
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$table_name_label = $wpdb->prefix . "custom_client";
	$labels = $wpdb->get_results("SELECT * FROM {$table_name_label}");
	
	
	$submit_task_name = (isset($start_edit->submit_task_name)) ? $start_edit->submit_task_name : " ";
	$submit_task_name_suffix = (isset($start_edit->submit_task_name_suffix)) ? $start_edit->submit_task_name_suffix : " ";
	$submit_description = (isset($start_edit->submit_description)) ? $start_edit->submit_description : " ";
	$submit_time_estimate_hour = (isset($start_edit->submit_time_estimate_hour)) ? $start_edit->submit_time_estimate_hour : " ";
	$submit_time_estimate_minute = (isset($start_edit->submit_time_estimate_minute)) ? $start_edit->submit_time_estimate_minute : " ";
	$submit_color = (isset($start_edit->submit_color)) ? $start_edit->submit_color : " ";
	$submit_project_name = (isset($start_edit->submit_project_name)) ? $start_edit->submit_project_name : " ";
	$submit_responsible_person = (isset($start_edit->submit_responsible_person)) ? $start_edit->submit_responsible_person : " ";
	$submit_label = (isset($start_edit->submit_label)) ? $start_edit->submit_label : " ";
	$submit_department = (isset($start_edit->submit_department)) ? $start_edit->submit_department : " ";
	$submit_department_name = (isset($start_edit->submit_department_name)) ? $start_edit->submit_department_name : " ";
	$submit_column = (isset($start_edit->submit_column)) ? $start_edit->submit_column : " ";
	$submit_column_name = (isset($start_edit->submit_column_name)) ? $start_edit->submit_column_name : " ";
	$submit_schedule_each = (isset($start_edit->submit_schedule_each)) ? $start_edit->submit_schedule_each : " ";
	$submit_starting_date = (isset($start_edit->submit_starting_date)) ? $start_edit->submit_starting_date : " ";
	
	foreach($tasks as $task){
		if($start_edit->submit_task_name != $task->task_name){
			$task_option .= '<option value="'. $task->task_name. '">' . $task->task_name . '</option>';
		}
	}
	foreach($colors as $color){
		if($start_edit->submit_project_name != $color->project_category){
			$submit_color_option .= '<option value="' . $color->project_color . '">'. $color->project_category.  '</option>';
		}
	}
	
	foreach($persons as $person){
		$person_full_name = $person->person_first_name ." ".  $person->person_last_name;
		if($start_edit->submit_responsible_person != $person_full_name){			
			$submit_responsible_person_option .= '<option value="'.$person_full_name.'">' .$person_full_name.'</option>';
		}
	}
	
	foreach($labels as $label){
		if($start_edit->submit_label != $label->client_name){
		$submit_label_option .= '<option value="'.$label->client_name.'">'.$label->client_name.'</option>';
		}
	}
	
	$unserialize_collaborator = unserialize($start_edit->submit_collaborators);
	if($unserialize_collaborator != null){
		foreach($persons as $person){
			$names = $person->person_first_name ." ".  $person->person_last_name; 
			if($start_edit->submit_collaborators != $names){
				$option = in_array($names, $unserialize_collaborator) ? "selected" : "";
				$submit_collaborators_option .= '<option '.$option.'>' .$names.'</option>';
			}
		}
	}else{
		foreach($persons as $person){
			$names = $person->person_first_name ." ".  $person->person_last_name;
			if(isset($names)){
				$option = ($start_edit->submit_collaborators == $names ) ? "selected" : "";
				$submit_collaborators_option .= '<option '.$option.'>'. $names .'</option>';
			}
		}
	}
			
	foreach($result_array['swimlanes'] as $swimlane){
		if($start_edit->submit_department_name != $swimlane['name']){
			$submit_department_name_option .= '<option value="'.$swimlane['uniqueId'].'">'.$swimlane['name'].'</option>';
		}
	}
	
	foreach($result_array['columns'] as $swimlane_columns){
		if($start_edit->submit_column_name != $swimlane_columns['name']){
			$submit_column_name_option .= '<option value="'. $swimlane_columns['uniqueId'] .'">'. $swimlane_columns['name'].'</option>';
		}
	}
	
	foreach($submit_schedule_each_options as $submit_schedule_each_option){
		if($start_edit->submit_schedule_each != $submit_schedule_each_option){
			$submit_schedule_each_select .= '<option value="'.$submit_schedule_each_option.'">'. $submit_schedule_each_option .'</option>';
		}
	}
	if($start_edit->submit_subtask != 'N;'){
		$submit_tasks = unserialize($start_edit->submit_subtask);
		$counter = 1;
		if($submit_tasks != null){
			foreach($submit_tasks as $submit_subtask){
				$submit_subtask_list .= '<li class="subtask_list" id="subtask_'.$counter.'">';
				$submit_subtask_list .= '<input type="hidden" name="submit_subtask[]" value="'.$submit_subtask.'"/><p>'.$submit_subtask.'</p>';		
				$submit_subtask_list .= '<div id="subtask_delete_'.$counter.'" class="confirm subtask_delete button_2 subtask_action_button">D</div>';
				$submit_subtask_list .= '<div id="subtask_edit_'.$counter.'" class="subtask_edit button_2 subtask_action_button">E</div>';
				$submit_subtask_list .=	'</li>';
				$submit_subtask_list .= '<div class="edit_div" id="edit_div_'.$counter.'" style="display:none;">';
				$submit_subtask_list .= '<input type="text"  id="subtask_edit_area_'.$counter.'" class="subtask_edit_area" />';
				$submit_subtask_list .= '<div id="check_edit_'.$counter.'" class="check_edit"></div>';
				$submit_subtask_list .= '</div>';
			$counter++;
			}
		}
	}
	
	$html = '
	<div class="tab-holder">
	<div class="tab-hold tabs-wrapper">
	<div class="full_width">
	<ul id="tabs" class="tabset tabs">
	<li class="tabs_li tab_general active">General</li>
	<li class="tabs_li tab_subtask">Subtask</li>
	</ul>
	</div>
	<div class="tab-box tabs-container">
	<form action="" method="post" name="submit_start_task_form" id="submit_start_task_form">
	<div class="submit_inputs">
	<div id="general" class="tab tab_content">
	<div class="submit_section">
	<div class="submit_left">
	<select class="submit_task_name" name="submit_task_name">
	<option value="'.$submit_task_name.'">'.$submit_task_name.'</option>	
	'.$task_option.'
	</select>
	</div>
	<div class="submit_right">
	<input value="'.$submit_task_name_suffix.'" type="submit_task_name_suffix" class="submit_task_name_suffix" name="submit_task_name_suffix" placeholder="Task Suffix"/>
	<input type="hidden" class="submit_task_name_suffix_time" name="submit_task_name_suffix_time" />
	</div>
	</div>
	<div class="submit_section">
	<div class="submit_left">
	<textarea class="submit_description" name="submit_description" placeholder="Descriptions">'.$submit_description.'</textarea>
	</div>
	<div class="estimated_time submit_right">
	<p class="label">Time Estimate:</p>
	<input value="'.$submit_time_estimate_hour.'" type="text" class="submit_time_estimate_hour time" name="submit_time_estimate_hour" placeholder="Hour"/>
	<input value="'.$submit_time_estimate_minute.'" type="text" class="submit_time_estimate_minute time" name="submit_time_estimate_minute" placeholder="Minute" />
	</div>
	</div>
	<div class="submit_section">
	<div class="submit_left">				
	<select class="submit_color" name="submit_color">
	<option value="'.$submit_color.'">'.$submit_project_name.'</option>
	'.$submit_color_option.'
	</select>
	<input type="hidden" name="submit_project_name" id="submit_project_name" value="'.$submit_project_name.'">		
	</div>
	<div class="submit_right">
	<select class="submit_responsible_person" name="submit_responsible_person">
	<option value="'.$submit_responsible_person.'">'.$submit_responsible_person.'</option>
	'.$submit_responsible_person_option.'
	</select>				
	</div>			
	</div>
	<div class="submit_section">
	<div class="submit_left">
	<select class="submit_label" name="submit_label">
	<option value="'.$submit_label.'">'.$submit_label.'</option>
	'.$submit_label_option.'
	</select>
	</div>
	<div class="submit_right">
	<select class="submit_collaborators" name="submit_collaborators[]" multiple="multiple">
	'.$submit_collaborators_option.'
	</select>
	</div>			
	</div>
	<div class="submit_section">
	<div class="submit_left">
	<select class="submit_department required" name="submit_department" required>
	<option value='.$submit_department.'>'.$submit_department_name.'</option>
	'.$submit_department_name_option.'
	</select>
	<input type="hidden" name="submit_department_name" class="submit_department_name" id="submit_department_name" value="'.$submit_department_name.'">
	</div>
	<div class="submit_right">
	<select class="submit_column required" name="submit_column" required>
	<option value='.$submit_column.'>'.$submit_column_name.'</option>
	'.$submit_column_name_option.'
	</select>
	<input type="hidden" name="submit_column_name" class="submit_column_name" id="submit_column_name" value="'.$submit_column_name.'">
	</div>
	</div>
	<div class="submit_section">
	<h3>Cron Settings</h3>
	<div class="submit_left">
	<select class="submit_schedule_each required" name="submit_schedule_each">
	<option value="'.$submit_schedule_each.'">'.$submit_schedule_each.'</option>
	'.$submit_schedule_each_select.'
	</select>
	</div>
	<div class="submit_right">
	<div class="submit_date">
	<input value="'.$submit_starting_date.'" type="text" class="submit_starting_date " name="submit_starting_date" placeholder="Starting Date" />
	</div>
	</div>
	</div>						
	</div>
	<div id="subtask" class="tab tab_content" style="display: none;">
	<div class="subtask_container">'.$submit_subtask_list.'</div>
	
	<div class="submit_task_input">
	<input type="text" class="sub_task" name="sub_task" />
	<div class="button_2 add_subtask_button">Add Subtask</div>
	</div>
	</div>
	</div>
	<div class="submit_task_buttons">
	<div class="button_1 submit_button schedule_task">Start Task</div>
	<div class="submit_now button_1 submit_button">Submit Now</div>
	<div style="display: none;" class="schedule_task_loader"></div>
	</div>
	<input type="hidden" name="submit_subtask_counter" value="'.$counter.'"/>
	<input type="hidden" name="submit_start_id" value="'.$start_cron_id.'"/>
	</form>
	</div>
	</div>
	</div>
	';
	return $html;
}
function submit_start_scheduled_task($submit_start_schedule_task_data){
	global $wpdb;
	
	$table_name = $wpdb->prefix . "custom_submit_task";
	$submit_form_data = array();
	parse_str($submit_start_schedule_task_data, $submit_form_data);
	
	global $submit_id;
	$submit_cron_unique_id 			= uniqid();
	$submit_id 						= (isset($submit_form_data['submit_start_id']) ? $submit_form_data['submit_start_id'] : '');
	$submit_label					= (isset($submit_form_data['submit_label']) ? $submit_form_data['submit_label'] : '');
	$submit_task_name				= (isset($submit_form_data['submit_task_name']) ? $submit_form_data['submit_task_name'] : '');
	$submit_task_name_suffix 		= (isset($submit_form_data['submit_task_name_suffix']) ? $submit_form_data['submit_task_name_suffix'] : '');
	$submit_task_name_suffix_time	= (isset($submit_form_data['submit_task_name_suffix_time']) ? $submit_form_data['submit_task_name_suffix_time'] : '');
	$submit_description 			= (isset($submit_form_data['submit_description']) ? $submit_form_data['submit_description'] : '');
	$submit_color 					= (isset($submit_form_data['submit_color']) ? $submit_form_data['submit_color'] : '');
	$submit_project_name 			= (isset($submit_form_data['submit_project_name']) ? $submit_form_data['submit_project_name'] : '');
	$submit_responsible_person 		= (isset($submit_form_data['submit_responsible_person']) ? $submit_form_data['submit_responsible_person'] : '');
	$submit_collaborators_array		= (isset($submit_form_data['submit_collaborators']) ? $submit_form_data['submit_collaborators'] : '');
	$submit_collaborators 			= serialize($submit_collaborators_array);
	$submit_time_spent_hour 		= (isset($submit_form_data['submit_time_spent_hour']) ? $submit_form_data['submit_time_spent_hour'] : '');
	$submit_time_spent_minute 		= (isset($submit_form_data['submit_time_spent_minute']) ? $submit_form_data['submit_time_spent_minute'] : '');
	$submit_time_estimate_hour 		= (isset($submit_form_data['submit_time_estimate_hour']) ? $submit_form_data['submit_time_estimate_hour'] : '');
	$submit_time_estimate_minute 	= (isset($submit_form_data['submit_time_estimate_minute']) ? $submit_form_data['submit_time_estimate_minute'] : '');
	$submit_subtask_array			= (isset($submit_form_data['submit_subtask']) ? $submit_form_data['submit_subtask'] : '');
	$submit_subtask					=  serialize($submit_subtask_array);
	$submit_department 				= (isset($submit_form_data['submit_department']) ? $submit_form_data['submit_department'] : '');
	$submit_department_name 		= (isset($submit_form_data['submit_department_name']) ? $submit_form_data['submit_department_name'] : '');
	$submit_column 					= (isset($submit_form_data['submit_column']) ? $submit_form_data['submit_column'] : '');
	$submit_column_name 			= (isset($submit_form_data['submit_column_name']) ? $submit_form_data['submit_column_name'] : '');
	$submit_schedule_each 			= (isset($submit_form_data['submit_schedule_each']) ? $submit_form_data['submit_schedule_each'] : '');
	$submit_setlocale 				= (isset($submit_form_data['submit_setlocale']) ? $submit_form_data['submit_setlocale'] : '');
	$submit_starting_date 			= (isset($submit_form_data['submit_starting_date']) ? $submit_form_data['submit_starting_date'] : '');
	$submit_hour 					= (isset($submit_form_data['submit_hour']) ? $submit_form_data['submit_hour'] : '');
	$submit_minute 					= (isset($submit_form_data['submit_minute']) ? $submit_form_data['submit_minute'] : '');
	$submit_end_date 				= (isset($submit_form_data['submit_end_date']) ? $submit_form_data['submit_end_date'] : '');
	$submit_end_hour 				= (isset($submit_form_data['submit_end_hour']) ? $submit_form_data['submit_end_hour'] : '');
	$submit_end_minute 				= (isset($submit_form_data['submit_end_minute']) ? $submit_form_data['submit_end_minute'] : '');
	
	$update = $wpdb->update( $table_name , array( 
	'submit_task_name'				=> $submit_task_name,
	'submit_task_name_suffix'		=> $submit_task_name_suffix,
	'submit_task_name_suffix_time'	=> $submit_task_name_suffix_time,
	'submit_description'			=> $submit_description,
	'submit_label'					=> $submit_label,
	'submit_responsible_person'		=> $submit_responsible_person,
	'submit_collaborators'			=> $submit_collaborators,
	'submit_color'					=> $submit_color,
	'submit_project_name'			=> $submit_project_name,
	'submit_time_spent_hour'		=> $submit_time_spent_hour,
	'submit_time_spent_minute'		=> $submit_time_spent_minute,
	'submit_time_estimate_hour'		=> $submit_time_estimate_hour,
	'submit_time_estimate_minute'	=> $submit_time_estimate_minute,
	'submit_subtask'				=> $submit_subtask,
	'submit_department'				=> $submit_department,
	'submit_department_name'		=> $submit_department_name,
	'submit_column'					=> $submit_column,
	'submit_column_name'			=> $submit_column_name,
	'submit_schedule_each'			=> $submit_schedule_each,
	'submit_starting_date'			=> $submit_starting_date,	
	'submit_hour'					=> $submit_hour,
	'submit_minute'					=> $submit_minute,
	'submit_end_date'				=> $submit_end_date,
	'submit_end_hour'				=> $submit_end_hour,
	'submit_end_minute'				=> $submit_end_minute,
	'submit_cron_unique_id'			=> $submit_cron_unique_id,
	'submit_cron_status'			=> 'ongoing',
	),
	array( 'ID' => $submit_id ),
	array( '%s', '%s' ));
	
	
	date_default_timezone_set('Asia/Manila');
	$date_format = date("n/j/Y" , strtotime($submit_starting_date));
	$date_array = explode("/", $date_format);
	$month	= $date_array['0'];
	$day 	= $date_array['1'];
	$year	= $date_array['2'];
	
	$cron_hook = $submit_task_name ."-". $submit_starting_date ."-". $submit_hour .":". $submit_minute;
	$function_name = $cron_hook ."_function_name";
	$cron_hook_function_name = str_replace(' ', '_', $function_name);
	
	if($month != null && $day != null && $year != null){
		if($submit_hour != null && $submit_minute != null){
			$timestamp = mktime($submit_hour, $submit_minute, '0', $month, $day , $year);
		}else{
			$timestamp = mktime('0', '1', '0', $month, $day , $year);	
		}		
		schedule_cron($submit_schedule_each, $timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);		
	}
	return $submit_form_data;
}
/* ==================================== END START SUBMIT ==================================== */

/* ==================================== KANBAN MANUAL SCHEDULE ==================================== */
function kanban_submit_scheduled_task($schedule) { 
	global $wpdb;
	$today = date('m/d/Y');
	
	$seconds = 50000;
	set_time_limit($seconds);
	$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
	$url="https://kanbanflow.com/api/v1/board?" . $token;
	$result = file_get_contents($url);
	$result_array = json_decode($result, true);
	
	$url_users = "https://kanbanflow.com/api/v1/users" . "?&" . $token;
	$result_users = file_get_contents($url_users);
	$result_users_array = json_decode($result_users, true);		
	
	$submitted_tasks = $wpdb->get_results("SELECT * FROM wp_custom_submit_task WHERE submit_cron_label ='$schedule'");
	
	foreach($submitted_tasks as $submitted_task){
		foreach($result_users_array as $result_users){
			if($result_users['fullName'] == $submitted_task->submit_responsible_person){
				$responsible_id = $result_users['_id'];			
			}
		}
		
		foreach($result_users_array as $result_users){
			if($result_users['fullName'] == $submitted_task->submit_collaborators){
				$collaborator_id = $result_users['_id'];			
			}
		}
		
		$time_seconds_spent = (3600 * $submitted_task->submit_time_spent_hour) + (60 * $submitted_task->submit_time_spent_minute);
		$time_seconds_estimate = (3600 * $submitted_task->submit_time_estimate_hour) + (60 * $submitted_task->submit_time_estimate_minute);
		
		$submit_color_lowercase = strtolower($submitted_task->submit_color);
		
		$data = json_encode(array(
		'name' 					=> $submitted_task->submit_task_name ." - ". $submitted_task->submit_task_name_suffix,
		'description'			=> $submitted_task->submit_description,
		'responsibleUserId'		=> $responsible_id,
		'color'					=> $submit_color_lowercase,
		'columnId' 				=> $submitted_task->submit_column,
		'swimlaneId' 			=> $submitted_task->submit_department,
		'totalSecondsSpent' 	=> $time_seconds_spent,
		'totalSecondsEstimate'	=> $time_seconds_estimate		
		));	
		$submit_token = base64_encode("apiToken:e1f2928c903625d1b6b2e7b00ec12031");
		
		$headers = array(
		"Authorization: Basic " . $submit_token,
		"Content-type: application/json"
		);
		
		$url = "https://kanbanflow.com/api/v1/tasks";	
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($curl);	
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		
		$task_id_array = json_decode($response);
		$task_id = $task_id_array->taskId;
		
		$data_label = json_encode(array(
			'name'			=> $submitted_task->submit_label,
			'columnId' 		=> $submitted_task->submit_column,
			'swimlaneId' 	=> $submitted_task->submit_department
		));
		
		$url_label = "https://kanbanflow.com/api/v1/tasks/$task_id/labels";
		$curl_label = curl_init();
		curl_setopt($curl_label, CURLOPT_URL, $url_label);
		curl_setopt($curl_label, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_label, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_label, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl_label, CURLOPT_POST, true);
		curl_setopt($curl_label, CURLOPT_POSTFIELDS, $data_label);
		$response_label = curl_exec($curl_label);	
		$status_label = curl_getinfo($curl_label, CURLINFO_HTTP_CODE);
		curl_close($curl_label);
		
		if ($submitted_task->submit_collaborators != "N;"){
			$unserialize_collaborators = unserialize($submitted_task->submit_collaborators);	
			foreach($result_users_array as $result_users){
				foreach($unserialize_collaborators as $unserialize_collaborator){
					if($result_users['fullName'] == $unserialize_collaborator){
						$collaborator_id = $result_users['_id'];
						
						$data_collaborator = json_encode(array(
						'userId'		=> $collaborator_id,
						'columnId' 		=> $submitted_task->submit_column,
						'swimlaneId' 	=> $submitted_task->submit_department
						));
						
						$url_collaborator = "https://kanbanflow.com/api/v1/tasks/$task_id/collaborators";
						$curl_collaborator = curl_init();
						curl_setopt($curl_collaborator, CURLOPT_URL, $url_collaborator);
						curl_setopt($curl_collaborator, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($curl_collaborator, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($curl_collaborator, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($curl_collaborator, CURLOPT_POST, true);
						curl_setopt($curl_collaborator, CURLOPT_POSTFIELDS, $data_collaborator);
						$response_collaborator = curl_exec($curl_collaborator);	
						$status_collaborator = curl_getinfo($curl_collaborator, CURLINFO_HTTP_CODE);
						curl_close($curl_collaborator);	
					}
				}
			}
		}
		
		if ($submitted_task->submit_subtask != ""){
			$unserialize_subtasks = unserialize($submitted_task->submit_subtask);
			foreach($unserialize_subtasks as $unserialize_subtask){
				$data_subtask = json_encode(array(
					"name" => $unserialize_subtask
				));
				
				$url_subtask = "https://kanbanflow.com/api/v1/tasks/$task_id/subtasks";
				$curl_subtask = curl_init();
				curl_setopt($curl_subtask, CURLOPT_URL, $url_subtask);
				curl_setopt($curl_subtask, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl_subtask, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl_subtask, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($curl_subtask, CURLOPT_POST, true);
				curl_setopt($curl_subtask, CURLOPT_POSTFIELDS, $data_subtask);
				$response = curl_exec($curl_subtask);	
				$status = curl_getinfo($curl_subtask, CURLINFO_HTTP_CODE);
				curl_close($curl_subtask);
			}
		}
	}
}
/* ==================================== END KANBAN MANUAL SCHEDULE ==================================== */

/* ==================================== SUBMIT NOW TASK ==================================== */
function submit_now_tasks($submit_now_task_data){
	$submit_form_data = array();
	parse_str($submit_now_task_data, $submit_form_data);	
	
	$submit_label_multiple		= $submit_form_data['submit_label'];
	foreach($submit_label_multiple as $submit_label){
		$submit_task_name				= (isset($submit_form_data['submit_task_name']) ? $submit_form_data['submit_task_name'] : '');
		$submit_task_name_suffix		= (isset($submit_form_data['submit_task_name_suffix']) ? $submit_form_data['submit_task_name_suffix'] : '');
		$submit_task_name_suffix_time	= (isset($submit_form_data['submit_task_name_suffix_time']) ? $submit_form_data['submit_task_name_suffix_time'] : '');
		$submit_description				= (isset($submit_form_data['submit_description']) ? $submit_form_data['submit_description'] : '');
		$submit_responsible_person		= (isset($submit_form_data['submit_responsible_person']) ? $submit_form_data['submit_responsible_person'] : '');
		$submit_collaborators_array		= (isset($submit_form_data['submit_collaborators']) ? $submit_form_data['submit_collaborators'] : '');
		$submit_collaborators 			= serialize($submit_collaborators_array);
		$submit_color					= (isset($submit_form_data['submit_color']) ? $submit_form_data['submit_color'] : '');
		$submit_project_name			= (isset($submit_form_data['submit_project_name']) ? $submit_form_data['submit_project_name'] : '');
		$submit_time_spent_hour			= (isset($submit_form_data['submit_time_spent_hour']) ? $submit_form_data['submit_time_spent_hour'] : '');
		$submit_time_spent_minute		= (isset($submit_form_data['submit_time_spent_minute']) ? $submit_form_data['submit_time_spent_minute'] : '');
		$submit_time_estimate_hour		= (isset($submit_form_data['submit_time_estimate_hour']) ? $submit_form_data['submit_time_estimate_hour'] : '');
		$submit_time_estimate_minute	= (isset($submit_form_data['submit_time_estimate_minute']) ? $submit_form_data['submit_time_estimate_minute'] : '');
		$submit_subtask_array			= (isset($submit_form_data['submit_subtask']) ? $submit_form_data['submit_subtask'] : '');
		$submit_subtask					=  serialize($submit_subtask_array);
		$submit_department				= (isset($submit_form_data['submit_department']) ? $submit_form_data['submit_department'] : '');
		$submit_department_name			= (isset($submit_form_data['submit_department_name']) ? $submit_form_data['submit_department_name'] : '');
		$submit_column					= (isset($submit_form_data['submit_column']) ? $submit_form_data['submit_column'] : '');
		$submit_column_name				= (isset($submit_form_data['submit_column_name']) ? $submit_form_data['submit_column_name'] : '');
		$submit_checklist 				= (isset($submit_form_data['submit_checklist']) ? $submit_form_data['submit_checklist'] : '');
		
		if($submit_checklist == 1){
			$submit_checklist_template 	= (isset($submit_form_data['submit_checklist_template']) ? $submit_form_data['submit_checklist_template'] : ''); $submit_form_data['submit_checklist_template'];
			}else{
			$submit_checklist_template	= "";
		}
		
		if($submit_form_data['add_checklist_template_input'] != null){
			$add_checklist_template_input = $submit_form_data['add_checklist_template_input'];
		}else{
			$add_checklist_template_input = "";
		}		
		
		$submit_schedule_each			= "Submitted";
		$submit_starting_date			= (isset($submit_form_data['submit_starting_date']) ? $submit_form_data['submit_starting_date'] : '');
		$submit_hour					= (isset($submit_form_data['submit_hour']) ? $submit_form_data['submit_hour'] : '');
		$submit_minute					= (isset($submit_form_data['submit_minute']) ? $submit_form_data['submit_minute'] : '');
		$submit_end_date				= (isset($submit_form_data['submit_end_date']) ? $submit_form_data['submit_end_date'] : '');
		$submit_end_hour				= (isset($submit_form_data['submit_end_hour']) ? $submit_form_data['submit_end_hour'] : '');
		$submit_end_minute				= (isset($submit_form_data['submit_end_minute']) ? $submit_form_data['submit_end_minute'] : '');
		
		$seconds = 50000;
		set_time_limit($seconds);
		$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
		$url="https://kanbanflow.com/api/v1/board?" . $token;
		$result = file_get_contents($url);
		$result_array = json_decode($result, true);
		
		
		$url_users = "https://kanbanflow.com/api/v1/users" . "?&" . $token;
		$result_users = file_get_contents($url_users);
		$result_users_array = json_decode($result_users, true);	
		
		foreach($result_users_array as $result_users){
			if($result_users['fullName'] == $submit_responsible_person){
				$responsible_id = $result_users['_id'];
			}
		}
		
		$time_seconds_spent = (3600 * $submit_time_spent_hour) + (60 * $submit_time_spent_minute);
		$time_seconds_estimate = (3600 * $submit_time_estimate_hour) + (60 * $submit_time_estimate_minute);
		
		$submit_color_lowercase = strtolower($submit_color);
		
		$data = json_encode(array(
			'name' 					=> $submit_task_name ." - ". $submit_task_name_suffix,
			'description'			=> $submit_description,
			'responsibleUserId'		=> $responsible_id,
			'color'					=> $submit_color_lowercase,
			'columnId' 				=> $submit_column,
			'swimlaneId' 			=> $submit_department,
			'totalSecondsSpent' 	=> $time_seconds_spent,
			'totalSecondsEstimate'	=> $time_seconds_estimate		
		));
		
		$submit_token = base64_encode("apiToken:e1f2928c903625d1b6b2e7b00ec12031");
		
		$headers = array(
		"Authorization: Basic " . $submit_token,
		"Content-type: application/json"
		);
		
		$url = "https://kanbanflow.com/api/v1/tasks";	
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($curl);	
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		
		$task_id_array = json_decode($response);
		$task_id = $task_id_array->taskId;
		
		$data_label = json_encode(array(
			'name'			=> $submit_label,
			'columnId' 		=> $submit_column,
			'swimlaneId' 	=> $submit_department
		));
		
		$url_label = "https://kanbanflow.com/api/v1/tasks/$task_id/labels";
		$curl_label = curl_init();
		curl_setopt($curl_label, CURLOPT_URL, $url_label);
		curl_setopt($curl_label, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_label, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_label, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl_label, CURLOPT_POST, true);
		curl_setopt($curl_label, CURLOPT_POSTFIELDS, $data_label);
		$response_label = curl_exec($curl_label);	
		$status_label = curl_getinfo($curl_label, CURLINFO_HTTP_CODE);
		curl_close($curl_label);
		
		if ($submit_collaborators != "N;"){	
			$unserialize_collaborators = unserialize($submit_collaborators);
			if($unserialize_collaborators != null){
				foreach($result_users_array as $result_users){
					foreach($unserialize_collaborators as $unserialize_collaborator){			
						if($result_users['fullName'] == $unserialize_collaborator){
							$collaborator_id = $result_users['_id'];
							$data_collaborator = json_encode(array(
							'userId'		=> $collaborator_id,
							'columnId' 		=> $submit_column,
							'swimlaneId' 	=> $submit_department
							));
							
							$url_collaborator = "https://kanbanflow.com/api/v1/tasks/$task_id/collaborators";
							$curl_collaborator = curl_init();
							curl_setopt($curl_collaborator, CURLOPT_URL, $url_collaborator);
							curl_setopt($curl_collaborator, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($curl_collaborator, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($curl_collaborator, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($curl_collaborator, CURLOPT_POST, true);
							curl_setopt($curl_collaborator, CURLOPT_POSTFIELDS, $data_collaborator);
							$response_collaborator = curl_exec($curl_collaborator);	
							$status_collaborator = curl_getinfo($curl_collaborator, CURLINFO_HTTP_CODE);
							curl_close($curl_collaborator);
						}
					}
				}
			}
		}
		
		if ($submit_subtask != ""){
			$unserialize_subtasks = unserialize($submit_subtask);
			if($unserialize_subtasks != null){
				foreach($unserialize_subtasks as $unserialize_subtask){
					$data_subtask = json_encode(array(
					"name" => $unserialize_subtask
					));
					
					$url_subtask = "https://kanbanflow.com/api/v1/tasks/$task_id/subtasks";
					$curl_subtask = curl_init();
					curl_setopt($curl_subtask, CURLOPT_URL, $url_subtask);
					curl_setopt($curl_subtask, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl_subtask, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl_subtask, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($curl_subtask, CURLOPT_POST, true);
					curl_setopt($curl_subtask, CURLOPT_POSTFIELDS, $data_subtask);
					$response = curl_exec($curl_subtask);	
					$status = curl_getinfo($curl_subtask, CURLINFO_HTTP_CODE);
					curl_close($curl_subtask);
				}
			}
		}
		
		global $wpdb;
		$table_name = $wpdb->prefix . "custom_submit_task";
		$table_name_checklist_task = $wpdb->prefix . "custom_checklist_task";
		$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template";
		
		$insert = $wpdb->insert( $table_name , array( 
			'submit_task_name'				=> $submit_task_name,
			'submit_task_name_suffix'		=> $submit_task_name_suffix,
			'submit_task_name_suffix_time'	=> $submit_task_name_suffix_time,
			'submit_description'			=> $submit_description,
			'submit_label'					=> $submit_label,
			'submit_responsible_person'		=> $submit_responsible_person,
			'submit_collaborators'			=> $submit_collaborators,
			'submit_color'					=> $submit_color,
			'submit_project_name'			=> $submit_project_name,
			'submit_time_spent_hour'		=> $submit_time_spent_hour,
			'submit_time_spent_minute'		=> $submit_time_spent_minute,
			'submit_time_estimate_hour'		=> $submit_time_estimate_hour,
			'submit_time_estimate_minute'	=> $submit_time_estimate_minute,
			'submit_subtask'				=> $submit_subtask,
			'submit_department'				=> $submit_department,
			'submit_department_name'		=> $submit_department_name,
			'submit_column'					=> $submit_column,
			'submit_column_name'			=> $submit_column_name,
			'submit_checklist_template'		=> $submit_checklist_template,
			'submit_schedule_each'			=> $submit_schedule_each,
			'submit_starting_date'			=> $submit_starting_date,
			'submit_hour'					=> $submit_hour,
			'submit_minute'					=> $submit_minute,
			'submit_end_date'				=> $submit_end_date,
			'submit_end_hour'				=> $submit_end_hour,
			'submit_end_minute'				=> $submit_end_minute
		), array( '%s', '%s' ));
		$submit_id = $wpdb->insert_id;
		$today = date('m/d/Y');
		if($submit_checklist == 1){
			if($add_checklist_template_input == null){				
				$insert = $wpdb->insert( $table_name_checklist_task , array( 
					'task_checklist_template'		=> $submit_checklist_template,
					'task_checklist_project_name'	=> $submit_project_name,
					'task_checklist_client_name'	=> $submit_label,
					'task_checklist_person_name'	=> $submit_responsible_person,
					'task_checklist_date_created'	=> $today,
					'task_checklist_date_scheduled'	=> "Submitted",
					'task_checklist_status'			=> 'Ongoing'
				), array( '%s', '%s' ));
			}else{			
				$checklist_template_items = $wpdb->get_row("SELECT checklist_items FROM {$table_name_checklist_template} WHERE checklist_template='$submit_checklist_template'");
				$insert_template = $wpdb->insert( $table_name_checklist_template , array( 
					'checklist_template'		=> $add_checklist_template_input,
					'checklist_items'			=> $checklist_template_items->checklist_items
				), array( '%s', '%s' ));
				
				$insert = $wpdb->insert( $table_name_checklist_task , array( 
					'task_checklist_template'		=> $add_checklist_template_input,
					'task_checklist_project_name'	=> $submit_project_name,
					'task_checklist_client_name'	=> $submit_label,
					'task_checklist_person_name'	=> $submit_responsible_person,
					'task_checklist_date_created'	=> $today,
					'task_checklist_date_scheduled'	=> "Submitted",
					'task_checklist_status'			=> 'Ongoing'
				), array( '%s', '%s' ));
				// $wpdb->show_errors();
				// $wpdb->print_error();
			}
		}	

		
		$submit_form_data['id'][] = $submit_id;
		$submit_form_data['label_id'][] = $submit_label."_".$submit_id;
	}
	return $submit_form_data;
}

/* ==================================== END SUBMIT NOW TASK ==================================== */

/* ==================================== SUBTASK FORM ==================================== */
function submit_sub_task_form(){ 
	$seconds = 50000;
	set_time_limit($seconds);
	$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
	$url="https://kanbanflow.com/api/v1/board?" . $token;	
	$result = file_get_contents($url);	
	$result_array = json_decode($result, true);	
	foreach($result_array['columns'] as $column){
		$get_task_by_column = "https://kanbanflow.com/api/v1/tasks?" . $token . "&columnId=" . $column['uniqueId'];
		$column_content = @file_get_contents($get_task_by_column);
		$tasks = json_decode($column_content, true);
		foreach($tasks as $task){
			if($task['swimlaneName'] == 'Website Dev'){
				foreach($task['tasks'] as $websitedev_task){		
					$task_option .= '<option value="'. $websitedev_task['_id'].'">'.$websitedev_task['name'].'</option>';
				}
			}
		}
	}
	$html = '
	<form id="submit_subtask_form">
	<div class="submit_task_input">
	<label class="modal_label">Task Name:</label>
	<select name="task_id" id="submit_subtask_task_id">
	<option></option>
	'.$task_option.'
	</select>
	<input type="hidden" name="task_name_hidden" value="">
	</div>
	<div class="submit_task_input">
	<label class="modal_label">Subtask:</label>
	<textarea class="sub_task" name="sub_task"></textarea>
	</div>
	<div id="subtask_submit" class="button_1 submit_button">Submit Subtask</div>
	<div style="display: none" class="loader"></div>
	</form>
	';
	return $html;
}
/* ==================================== END SUBTASK FORM ==================================== */

/* ==================================== SUBMIT SUBTASK ==================================== */
function submit_task_api($submit_subtask_form_data){
	$form_array = array();
	parse_str($submit_subtask_form_data, $form_array);
	
	$task_id = $form_array['task_id'];
	$sub_task = $form_array['sub_task'];
	
	$data = json_encode(array(
		"name" => $sub_task
	));
	
	$submit_token = base64_encode("apiToken:e1f2928c903625d1b6b2e7b00ec12031");
	
	$headers = array(
	"Authorization: Basic " . $submit_token,
	"Content-type: application/json"
	);
	
	$url = 'https://kanbanflow.com/api/v1/tasks/'. $task_id .'/subtasks';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	$response = curl_exec($curl);	
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	
	return $form_array;
}
/* ==================================== END SUBMIT SUBTASK ==================================== */

/* ==================================== DELETE SUBMIT ==================================== */
function _unschedule_event( $timestamp, $hook, $key ) {
	$crons = _get_cron_array();
	unset( $crons[$timestamp][$hook][$key] );
	if ( empty($crons[$timestamp][$hook]) )
	unset( $crons[$timestamp][$hook] );
	if ( empty($crons[$timestamp]) )
	unset( $crons[$timestamp] );
	_set_cron_array( $crons );
	return $crons;
}

function submit_task_cron_delete($delete_cron_id){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	$wpdb->query( "DELETE FROM {$table_name} WHERE ID = '$delete_cron_id'" );
	
	$timeslots = $crons == '' ? _get_cron_array() : $crons;
	foreach ( $timeslots as $time => $tasks ) {
		foreach ($tasks as $procname => $task) {
			foreach ($task as $key => $args) {
				$cron_submit_id = $args['args']['submit_id'];
				if($cron_submit_id == $delete_cron_id){
					$submit_cron_time		= $time;
					$submit_cron_schedule	= $procname;
					$submit_cron_key		= $key;										
				}
			}
		}
	}
	$crons = _unschedule_event($submit_cron_time, $submit_cron_schedule, $submit_cron_key);
	return $delete_cron_id;
}
/* ==================================== END DELETE SUBMIT ==================================== */

/* ==================================== END PAUSE SUBMIT ==================================== */
function submit_task_cron_pause($pause_cron_id){
	global $wpdb;
	
	$table_name = $wpdb->prefix . "custom_submit_task";
	$submitted_paused_tasks = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID='$pause_cron_id'");
	
	$wpdb->update( $table_name , array( 
		'submit_cron_status' => 'paused'
	),
	array( 'ID' => $pause_cron_id ),
	array( '%s', '%s' ));
	
	$timeslots = $crons == '' ? _get_cron_array() : $crons;
	foreach ( $timeslots as $time => $tasks ) {
		foreach ($tasks as $procname => $task) {
			foreach ($task as $key => $args) {
				$cron_submit_id = $args['args']['submit_id'];
				if($cron_submit_id == $pause_cron_id){
					$submit_cron_time		= $time;
					$submit_cron_schedule	= $procname;
					$submit_cron_key		= $key;										
				}
			}
		}
	}
	$crons = _unschedule_event($submit_cron_time, $submit_cron_schedule, $submit_cron_key);
	
	$submit_id = $submitted_paused_tasks->ID;
	$submit_task_name = $submitted_paused_tasks->submit_task_name;
	$submit_task_name_suffix = $submitted_paused_tasks->submit_task_name_suffix;
	$submit_label = $submitted_paused_tasks->submit_label;
	$submit_responsible_person = $submitted_paused_tasks->submit_responsible_person;
	$submit_schedule_each = $submitted_paused_tasks->submit_schedule_each;
	$submit_time_estimate_hour = $submitted_paused_tasks->submit_time_estimate_hour;
	$submit_time_estimate_minute = $submitted_paused_tasks->submit_time_estimate_minute;
	$submit_cron_status = $submitted_paused_tasks->submit_cron_status;
	
	$arr1 = array('submit_id' => $submit_id);
	$arr2 = array('submit_task_name' => $submit_task_name);
	$arr3 = array('submit_task_name_suffix' => $submit_task_name_suffix);
	$arr4 = array('submit_label' => $submit_label);
	$arr5 = array('submit_responsible_person' => $submit_responsible_person);
	$arr6 = array('submit_schedule_each' => $submit_schedule_each);
	$arr7 = array('submit_time_estimate_hour' => $submit_time_estimate_hour);
	$arr8 = array('submit_time_estimate_minute' => $submit_time_estimate_minute);
	$arr9 = array('submit_cron_status' => $submit_cron_status);
	$arr10 = $arr1 + $arr2 + $arr3 + $arr4 + $arr5 + $arr6 + $arr7 + $arr8 + $arr9;
	$paused_task_data = json_encode($arr10);
	
	return $paused_task_data;	
}
/* ==================================== END PAUSE SUBMIT ==================================== */

/* ==================================== EDIT SUBMIT ==================================== */
function submit_task_cron_edit($edit_cron_id){ 
	
	$seconds = 50000;
	set_time_limit($seconds);
	$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
	$url="https://kanbanflow.com/api/v1/board?" . $token;
	$result = file_get_contents($url);
	$result_array = json_decode($result, true);
	
	$submit_schedule_each_options = array(
		'Per Minute', 
		'Once per Hour', 
		'Twice per Hour',
		'Once a Day',
		'Twice a Day',
		'Once a Week', 
		'Twice a Week', 
		'Once a Month', 
		'Twice a Month', 
		'Once a Year',
		'Twice a Year',
		'Four Times a Year',
		'Six Times a Year'
	); 
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	$edit_cron = $wpdb->get_row("SELECT * FROM $table_name WHERE id=$edit_cron_id");
	$table_name_task = $wpdb->prefix . "custom_task";
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
	$table_name_color = $wpdb->prefix . "custom_project_color";
	$colors = $wpdb->get_results("SELECT * FROM {$table_name_color}");
	$table_name_person = $wpdb->prefix . "custom_person";
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$table_name_label = $wpdb->prefix . "custom_client";
	$labels = $wpdb->get_results("SELECT * FROM {$table_name_label}");
	
	
	$submit_task_name = (isset($edit_cron->submit_task_name)) ? $edit_cron->submit_task_name : " ";
	$submit_task_name_suffix = (isset($edit_cron->submit_task_name_suffix)) ? $edit_cron->submit_task_name_suffix : " ";
	$submit_description = (isset($edit_cron->submit_description)) ? $edit_cron->submit_description : " ";
	$submit_time_estimate_hour = (isset($edit_cron->submit_time_estimate_hour)) ? $edit_cron->submit_time_estimate_hour : " ";
	$submit_time_estimate_minute = (isset($edit_cron->submit_time_estimate_minute)) ? $edit_cron->submit_time_estimate_minute : " ";
	$submit_color = (isset($edit_cron->submit_color)) ? $edit_cron->submit_color : " ";
	$submit_project_name = (isset($edit_cron->submit_project_name)) ? $edit_cron->submit_project_name : " ";
	$submit_responsible_person = (isset($edit_cron->submit_responsible_person)) ? $edit_cron->submit_responsible_person : " ";
	$submit_label = (isset($edit_cron->submit_label)) ? $edit_cron->submit_label : " ";
	$submit_department = (isset($edit_cron->submit_department)) ? $edit_cron->submit_department : " ";
	$submit_department_name = (isset($edit_cron->submit_department_name)) ? $edit_cron->submit_department_name : " ";
	$submit_column = (isset($edit_cron->submit_column)) ? $edit_cron->submit_column : " ";
	$submit_column_name = (isset($edit_cron->submit_column_name)) ? $edit_cron->submit_column_name : " ";
	$submit_schedule_each = (isset($edit_cron->submit_schedule_each)) ? $edit_cron->submit_schedule_each : " ";
	$submit_starting_date = (isset($edit_cron->submit_starting_date)) ? $edit_cron->submit_starting_date : " ";
	
	foreach($tasks as $task){
		if($edit_cron->submit_task_name != $task->task_name){
			$task_option .= '<option value="'. $task->task_name. '">' . $task->task_name . '</option>';
		}
	}
	foreach($colors as $color){
		if($edit_cron->submit_project_name != $color->project_category){
			$submit_color_option .= '<option value="' . $color->project_color . '">'. $color->project_category.  '</option>';
		}
	}
	
	foreach($persons as $person){
		$person_full_name = $person->person_first_name ." ".  $person->person_last_name;
		if($edit_cron->submit_responsible_person != $person_full_name){			
			$submit_responsible_person_option .= '<option value="'.$person_full_name.'">' .$person_full_name.'</option>';
		}
	}
	
	foreach($labels as $label){
		if($edit_cron->submit_label != $label->client_name){
			$submit_label_option .= '<option value="'.$label->client_name.'">'.$label->client_name.'</option>';
		}
	}
	
	$unserialize_collaborator = unserialize($edit_cron->submit_collaborators);
	if($unserialize_collaborator != null){
		foreach($persons as $person){
			$names = $person->person_first_name ." ".  $person->person_last_name; 
			if($edit_cron->submit_collaborators != $names){
				$option = in_array($names, $unserialize_collaborator) ? "selected" : "";
				$submit_collaborators_option .= '<option '.$option.'>' .$names.'</option>';
			}
		}
		}else{
		foreach($persons as $person){
			$names = $person->person_first_name ." ".  $person->person_last_name;
			if(isset($names)){
				$option = ($edit_cron->submit_collaborators == $names ) ? "selected" : "";
				$submit_collaborators_option .= '<option '.$option.'>'. $names .'</option>';
			}
		}
	}
	
	foreach($result_array['swimlanes'] as $swimlane){
		if($edit_cron->submit_department_name != $swimlane['name']){
			$submit_department_name_option .= '<option value="'.$swimlane['uniqueId'].'">'.$swimlane['name'].'</option>';
		}
	}
	
	foreach($result_array['columns'] as $swimlane_columns){
		if($edit_cron->submit_column_name != $swimlane_columns['name']){
			$submit_column_name_option .= '<option value="'. $swimlane_columns['uniqueId'] .'">'. $swimlane_columns['name'].'</option>';
		}
	}
	
	foreach($submit_schedule_each_options as $submit_schedule_each_option){
		if($edit_cron->submit_schedule_each != $submit_schedule_each_option){
			$submit_schedule_each_select .= '<option value="'.$submit_schedule_each_option.'">'. $submit_schedule_each_option .'</option>';
		}
	}
	if($edit_cron->submit_subtask != 'N;' && $edit_cron->submit_subtask != null){
		$submit_tasks = unserialize($edit_cron->submit_subtask);
		$counter = 1;
		if($submit_tasks != null){
			foreach($submit_tasks as $submit_subtask){
				$submit_subtask_list .= '<li class="subtask_list" id="subtask_'.$counter.'">';
				$submit_subtask_list .= '<input type="hidden" name="submit_subtask[]" value="'.$submit_subtask.'"/><p>'.$submit_subtask.'</p>';		
				$submit_subtask_list .= '<div id="subtask_delete_'.$counter.'" class="confirm subtask_delete button_2 subtask_action_button">D</div>';
				$submit_subtask_list .= '<div id="subtask_edit_'.$counter.'" class="subtask_edit button_2 subtask_action_button">E</div>';
				$submit_subtask_list .=	'</li>';
				$submit_subtask_list .= '<div class="edit_div" id="edit_div_'.$counter.'" style="display:none;">';
				$submit_subtask_list .= '<input type="text"  id="subtask_edit_area_'.$counter.'" class="subtask_edit_area" />';
				$submit_subtask_list .= '<div id="check_edit_'.$counter.'" class="check_edit"></div>';
				$submit_subtask_list .= '</div>';
				$counter++;
			}
		}
	}
	
	$html = '
	<div class="tab-holder">
	<div class="tab-hold tabs-wrapper">
	<div class="full_width">
	<ul id="tabs" class="tabset tabs">
	<li class="tabs_li tab_general active">General</li>
	<li class="tabs_li tab_subtask">Subtask</li>
	</ul>
	</div>
	<div class="tab-box tabs-container">
	<form action="" method="post" name="submit_edit_task_form" id="submit_edit_task_form">
	<div class="submit_inputs">
	<div id="general" class="tab tab_content">
	<div class="submit_section">
	<div class="submit_left">
	<select class="submit_task_name" name="submit_task_name">
	<option value="'.$submit_task_name.'">'.$submit_task_name.'</option>	
	'.$task_option.'
	</select>
	</div>
	<div class="submit_right">
	<input value="'.$submit_task_name_suffix.'" type="submit_task_name_suffix" class="submit_task_name_suffix" name="submit_task_name_suffix" placeholder="Task Suffix"/>
	<input type="hidden" class="submit_task_name_suffix_time" name="submit_task_name_suffix_time" />
	</div>
	</div>
	<div class="submit_section">
	<div class="submit_left">
	<textarea class="submit_description" name="submit_description" placeholder="Descriptions">'.$submit_description.'</textarea>
	</div>
	<div class="estimated_time submit_right">
	<p class="label">Time Estimate:</p>
	<input value="'.$submit_time_estimate_hour.'" type="text" class="submit_time_estimate_hour time" name="submit_time_estimate_hour" placeholder="Hour"/>
	<input value="'.$submit_time_estimate_minute.'" type="text" class="submit_time_estimate_minute time" name="submit_time_estimate_minute" placeholder="Minute" />
	</div>
	</div>
	<div class="submit_section">
	<div class="submit_left">				
	<select class="submit_color" name="submit_color">
	<option value="'.$submit_color.'">'.$submit_project_name.'</option>
	'.$submit_color_option.'
	</select>
	<input type="hidden" name="submit_project_name" id="submit_project_name" value="'.$submit_project_name.'">		
	</div>
	<div class="submit_right">
	<select class="submit_responsible_person" name="submit_responsible_person">
	<option value="'.$submit_responsible_person.'">'.$submit_responsible_person.'</option>
	'.$submit_responsible_person_option.'
	</select>				
	</div>			
	</div>
	<div class="submit_section">
	<div class="submit_left">
	<select class="submit_label" name="submit_label">
	<option value="'.$submit_label.'">'.$submit_label.'</option>
	'.$submit_label_option.'
	</select>
	</div>
	<div class="submit_right">
	<select class="submit_collaborators" name="submit_collaborators[]" multiple="multiple">
	'.$submit_collaborators_option.'
	</select>
	</div>			
	</div>
	<div class="submit_section">
	<div class="submit_left">
	<select class="submit_department required" name="submit_department" required>
	<option value='.$submit_department.'>'.$submit_department_name.'</option>
	'.$submit_department_name_option.'
	</select>
	<input type="hidden" name="submit_department_name" class="submit_department_name" id="submit_department_name" value="'.$submit_department_name.'">
	</div>
	<div class="submit_right">
	<select class="submit_column required" name="submit_column" required>
	<option value='.$submit_column.'>'.$submit_column_name.'</option>
	'.$submit_column_name_option.'
	</select>
	<input type="hidden" name="submit_column_name" class="submit_column_name" id="submit_column_name" value="'.$submit_column_name.'">
	</div>
	</div>
	<div class="submit_section">
	<h3>Cron Settings</h3>
	<div class="submit_left">
	<select class="submit_schedule_each required" name="submit_schedule_each">
	<option value="'.$submit_schedule_each.'">'.$submit_schedule_each.'</option>
	'.$submit_schedule_each_select.'
	</select>
	</div>
	<div class="submit_right">
	<div class="submit_date">
	<input value="'.$submit_starting_date.'" type="text" class="submit_starting_date " name="submit_starting_date" placeholder="Starting Date" />
	</div>
	</div>
	</div>						
	</div>
	<div id="subtask" class="tab tab_content" style="display: none;">
	<div class="subtask_container">'.$submit_subtask_list.'</div>
	
	<div class="submit_task_input">
	<input type="text" class="sub_task" name="sub_task" />
	<div class="button_2 add_subtask_button">Add Subtask</div>
	</div>
	</div>
	</div>
	<div class="submit_task_buttons">
	<div class="button_1 submit_button schedule_task">Update Task</div>
	<div class="submit_now button_1 submit_button">Submit Now</div>
	<div style="display: none;" class="schedule_task_loader"></div>
	</div>
	<input type="hidden" name="submit_subtask_counter" value="'.$counter.'"/>
	<input type="hidden" name="submit_edit_id" value="'.$edit_cron_id.'"/>
	</form>
	</div>
	</div>
	</div>
	';
	return $html;
}
function submit_edit_scheduled_task($submit_edit_schedule_task_data){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	$submit_form_data = array();
	parse_str($submit_edit_schedule_task_data, $submit_form_data);
	global $submit_id;
	$submit_id 	= $submit_form_data['submit_edit_id'];
	
	$timeslots = $crons == '' ? _get_cron_array() : $crons;
	foreach ( $timeslots as $time => $tasks ) {
		foreach ($tasks as $procname => $task) {
			foreach ($task as $key => $args) {
				$cron_submit_id = $args['args']['submit_id'];
				if($cron_submit_id == $submit_id){
					$submit_cron_time		= $time;
					$submit_cron_schedule	= $procname;
					$submit_cron_key		= $key;
				}
			}
		}
	}
	$crons = _unschedule_event($submit_cron_time, $submit_cron_schedule, $submit_cron_key);
	$submit_cron_unique_id 			= uniqid();
	$submit_label					= (isset($submit_form_data['submit_label']) ? $submit_form_data['submit_label'] : '');
	$submit_task_name				= (isset($submit_form_data['submit_task_name']) ? $submit_form_data['submit_task_name'] : '');
	$submit_task_name_suffix 		= (isset($submit_form_data['submit_task_name_suffix']) ? $submit_form_data['submit_task_name_suffix'] : '');
	$submit_task_name_suffix_time	= (isset($submit_form_data['submit_task_name_suffix_time']) ? $submit_form_data['submit_task_name_suffix_time'] : '');
	$submit_description 			= (isset($submit_form_data['submit_description']) ? $submit_form_data['submit_description'] : '');
	$submit_color 					= (isset($submit_form_data['submit_color']) ? $submit_form_data['submit_color'] : '');
	$submit_project_name 			= (isset($submit_form_data['submit_project_name']) ? $submit_form_data['submit_project_name'] : '');
	$submit_responsible_person 		= (isset($submit_form_data['submit_responsible_person']) ? $submit_form_data['submit_responsible_person'] : '');
	$submit_collaborators_array		= (isset($submit_form_data['submit_collaborators']) ? $submit_form_data['submit_collaborators'] : '');
	$submit_collaborators 			= serialize($submit_collaborators_array);
	$submit_time_spent_hour 		= (isset($submit_form_data['submit_time_spent_hour']) ? $submit_form_data['submit_time_spent_hour'] : '');
	$submit_time_spent_minute 		= (isset($submit_form_data['submit_time_spent_minute']) ? $submit_form_data['submit_time_spent_minute'] : '');
	$submit_time_estimate_hour 		= (isset($submit_form_data['submit_time_estimate_hour']) ? $submit_form_data['submit_time_estimate_hour'] : '');
	$submit_time_estimate_minute 	= (isset($submit_form_data['submit_time_estimate_minute']) ? $submit_form_data['submit_time_estimate_minute'] : '');
	$submit_subtask_array			= (isset($submit_form_data['submit_subtask']) ? $submit_form_data['submit_subtask'] : '');
	$submit_subtask					=  serialize($submit_subtask_array);
	$submit_department 				= (isset($submit_form_data['submit_department']) ? $submit_form_data['submit_department'] : '');
	$submit_department_name 		= (isset($submit_form_data['submit_department_name']) ? $submit_form_data['submit_department_name'] : '');
	$submit_column 					= (isset($submit_form_data['submit_column']) ? $submit_form_data['submit_column'] : '');
	$submit_column_name 			= (isset($submit_form_data['submit_column_name']) ? $submit_form_data['submit_column_name'] : '');
	$submit_schedule_each 			= (isset($submit_form_data['submit_schedule_each']) ? $submit_form_data['submit_schedule_each'] : '');
	$submit_setlocale 				= (isset($submit_form_data['submit_setlocale']) ? $submit_form_data['submit_setlocale'] : '');
	$submit_starting_date 			= (isset($submit_form_data['submit_starting_date']) ? $submit_form_data['submit_starting_date'] : '');
	$submit_hour 					= (isset($submit_form_data['submit_hour']) ? $submit_form_data['submit_hour'] : '');
	$submit_minute 					= (isset($submit_form_data['submit_minute']) ? $submit_form_data['submit_minute'] : '');
	$submit_end_date 				= (isset($submit_form_data['submit_end_date']) ? $submit_form_data['submit_end_date'] : '');
	$submit_end_hour 				= (isset($submit_form_data['submit_end_hour']) ? $submit_form_data['submit_end_hour'] : '');
	$submit_end_minute 				= (isset($submit_form_data['submit_end_minute']) ? $submit_form_data['submit_end_minute'] : '');
	
	$update = $wpdb->update( $table_name , array( 
	'submit_task_name'				=> $submit_task_name,
	'submit_task_name_suffix'		=> $submit_task_name_suffix,
	'submit_task_name_suffix_time'	=> $submit_task_name_suffix_time,
	'submit_description'			=> $submit_description,
	'submit_label'					=> $submit_label,
	'submit_responsible_person'		=> $submit_responsible_person,
	'submit_collaborators'			=> $submit_collaborators,
	'submit_color'					=> $submit_color,
	'submit_project_name'			=> $submit_project_name,
	'submit_time_spent_hour'		=> $submit_time_spent_hour,
	'submit_time_spent_minute'		=> $submit_time_spent_minute,
	'submit_time_estimate_hour'		=> $submit_time_estimate_hour,
	'submit_time_estimate_minute'	=> $submit_time_estimate_minute,
	'submit_subtask'				=> $submit_subtask,
	'submit_department'				=> $submit_department,
	'submit_department_name'		=> $submit_department_name,
	'submit_column'					=> $submit_column,
	'submit_column_name'			=> $submit_column_name,
	'submit_schedule_each'			=> $submit_schedule_each,
	'submit_starting_date'			=> $submit_starting_date,	
	'submit_hour'					=> $submit_hour,
	'submit_minute'					=> $submit_minute,
	'submit_end_date'				=> $submit_end_date,
	'submit_end_hour'				=> $submit_end_hour,
	'submit_end_minute'				=> $submit_end_minute,
	'submit_cron_unique_id'			=> $submit_cron_unique_id,
	'submit_cron_status'			=> 'ongoing',
	),
	array( 'ID' => $submit_id ),
	array( '%s', '%s' ));
	
	
	date_default_timezone_set('Asia/Manila');
	$date_format = date("n/j/Y" , strtotime($submit_starting_date));
	$date_array = explode("/", $date_format);
	$month	= $date_array['0'];
	$day 	= $date_array['1'];
	$year	= $date_array['2'];
	
	$cron_hook = $submit_task_name ."-". $submit_starting_date ."-". $submit_hour .":". $submit_minute;
	$function_name = $cron_hook ."_function_name";
	$cron_hook_function_name = str_replace(' ', '_', $function_name);
	
	if($month != null && $day != null && $year != null){
		if($submit_hour != null && $submit_minute != null){
			$timestamp = mktime($submit_hour, $submit_minute, '0', $month, $day , $year);
		}else{
			$timestamp = mktime('0', '1', '0', $month, $day , $year);
		}			
		
		schedule_cron($submit_schedule_each, $timestamp, $submit_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
	}
	return $submit_form_data;
}
/* ==================================== END EDIT SUBMIT ==================================== */

/* ==================================== BULK DELETE SUBMIT TASK ==================================== */
// function submit_task_bulk_delete($submit_ids){	
	// global $wpdb;	
	// $table_name_submit = $wpdb->prefix . "custom_submit_task";
	
	// foreach($submit_ids as $submit_id){
		// $delete = $wpdb->query( "DELETE FROM {$table_name_submit} WHERE ID = '$submit_id'" );
		
		// $timeslots = $crons == '' ? _get_cron_array() : $crons;
		// foreach ( $timeslots as $time => $tasks ) {
			// foreach ($tasks as $procname => $task) {
				// foreach ($task as $key => $args) {
					// $cron_submit_id = $args['args']['submit_id'];
					// if($cron_submit_id == $submit_id){
						// $submit_cron_time		= $time;
						// $submit_cron_schedule	= $procname;
						// $submit_cron_key		= $key;
						// $crons = _unschedule_event($submit_cron_time, $submit_cron_schedule, $submit_cron_key);
					// }
				// }
			// }
		// }		
	// }
	
	// return $submit_ids;
// }
/* ==================================== END BULK DELETE SUBMIT TASK ==================================== */

/* ==================================== BULK DELETE PAUSE SUBMIT TASK ==================================== */
// function submit_pause_task_bulk_delete($paused_submit_ids){	
	// global $wpdb;	
	// $table_name_submit = $wpdb->prefix . "custom_submit_task";
	
	// foreach($paused_submit_ids as $paused_submit_id){
		// $delete = $wpdb->query( "DELETE FROM {$table_name_submit} WHERE ID = '$paused_submit_id'" );
		
		// $timeslots = $crons == '' ? _get_cron_array() : $crons;
		// foreach ( $timeslots as $time => $tasks ) {
			// foreach ($tasks as $procname => $task) {
				// foreach ($task as $key => $args) {
					// $cron_submit_id = $args['args']['submit_id'];
					// if($cron_submit_id == $paused_submit_id){
						// $submit_cron_time		= $time;
						// $submit_cron_schedule	= $procname;
						// $submit_cron_key		= $key;										
					// }
				// }
			// }
		// }
		// $crons = _unschedule_event($submit_cron_time, $submit_cron_schedule, $submit_cron_key);
	// }
	
	// return $paused_submit_ids;
// }
/* ==================================== END BULK DELETE PAUSE SUBMIT TASK ==================================== */

/* ==================================== BULK ACTIONS ==================================== */
// function submit_bulk_actions($submit_bulk_details){
	// global $wpdb;	
	// $table_name_submit = $wpdb->prefix . "custom_submit_task";
	
	// foreach($submit_bulk_details['submit_ids'] as $submit_ids){
		// if($submit_bulk_details['bulk_action_type'] == "Delete"){
			// $delete = $wpdb->query( "DELETE FROM {$table_name_submit} WHERE ID = '$submit_id'" );
			// $timeslots = $crons == '' ? _get_cron_array() : $crons;
			// foreach ( $timeslots as $time => $tasks ) {
				// foreach ($tasks as $procname => $task) {
					// foreach ($task as $key => $args) {
						// $cron_submit_id = $args['args']['submit_id'];
						// if($cron_submit_id == $submit_id){
							// $submit_cron_time		= $time;
							// $submit_cron_schedule	= $procname;
							// $submit_cron_key		= $key;
							// $crons = _unschedule_event($submit_cron_time, $submit_cron_schedule, $submit_cron_key);
						// }
					// }
				// }
			// }
		// }
		// if($submit_bulk_details['bulk_action_type'] == "Edit Schedule"){
			
		// }
	// }
	
	// return $submit_bulk_details;
// }
function dialog_bulk_actions($dialog_bulk_actions_details){
	global $wpdb;	
	$table_name = $wpdb->prefix . "custom_submit_task";
	
	$bulk_action_type = $dialog_bulk_actions_details['bulk_action_type'];
	$html = '<div class="detail_list">';
	$html .= '<form id="apply_bulk_action_form">';
	$html .= "<input name='bulk_action_type' class='bulk_action_type' type='hidden' value='".$bulk_action_type."' />";
	if($dialog_bulk_actions_details['bulk_action_ids'] != null){
		$bulk_action_ids = implode(",", $dialog_bulk_actions_details['bulk_action_ids']);
		$html .= "<input name='bulk_action_ids' class='bulk_action_ids' type='hidden' value='".$bulk_action_ids."' />";
		$html .= '<ul>';
		foreach($dialog_bulk_actions_details['bulk_action_ids'] as $bulk_action_ids){
			$submit_bulk_detail = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = $bulk_action_ids");
			$submit_label = $submit_bulk_detail->submit_label;
			$submit_task_name = $submit_bulk_detail->submit_task_name ." - ". $submit_bulk_detail->submit_task_name_suffix;
			$html .= '<li><span class="task_client">'. $submit_label .': </span>'.$submit_task_name.'</li>';			
		}		
		$html .= "</ul>";
		if($bulk_action_type == 'Edit Schedule'){
			$submit_schedule_each_options = array(
				'Per Minute', 
				'Once per Hour', 
				'Twice per Hour',
				'Once a Day',
				'Twice a Day',
				'Once a Week', 
				'Twice a Week', 
				'Once a Month', 
				'Twice a Month', 
				'Once a Year',
				'Twice a Year',
				'Four Times a Year',
				'Six Times a Year'
			);
			
			foreach($submit_schedule_each_options as $submit_schedule_each_option){
				$submit_schedule_each_select .= '<option value="'.$submit_schedule_each_option.'">'. $submit_schedule_each_option .'</option>';
			}
			$html .= '<div class="edit_options">';
			$html .= '<select class="submit_schedule_each required" name="submit_schedule_each">';
			$html .= $submit_schedule_each_select;
			$html .= '</select>';											
			$html .= '<input type="text" class="submit_starting_date" name="submit_starting_date" placeholder="Starting Date" />';
			// $html .= '<input type="text" class="submit_hour " name="submit_hour" title="Enter 24 hour format" placeholder="Hour" />';					
			// $html .= '<input type="text" class="submit_minute " name="submit_minute" placeholder="Minute" />';	
			$html .= '</div>';
		}
	}else{
		$html .= "<p>No items selected.</p>";
	}
	$html .= "</form>";
	$html .= "</div>";
	return $html;
}

function apply_bulk_actions($apply_bulk_action_form){
	global $wpdb;	
	$table_name = $wpdb->prefix . "custom_submit_task";
	
	$bulk_action_form_data = array();
	parse_str($apply_bulk_action_form, $bulk_action_form_data);
	$bulk_action_ids = explode(',' , $bulk_action_form_data['bulk_action_ids']);
	$bulk_action_type = $bulk_action_form_data['bulk_action_type'];
	$submit_schedule_each = $bulk_action_form_data['submit_schedule_each'];
	$submit_starting_date = $bulk_action_form_data['submit_starting_date'];
	$submit_hour = $bulk_action_form_data['submit_hour'];
	$submit_minute = $bulk_action_form_data['submit_minute'];
	
	foreach($bulk_action_ids as $bulk_action_id){
		$submit_bulk_detail = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = $bulk_action_id");
		$submit_task_name 				= $submit_bulk_detail->submit_task_name;
		$submit_task_name_suffix 		= $submit_bulk_detail->submit_task_name_suffix;
		$submit_description 			= $submit_bulk_detail->submit_description;
		$submit_label					= $submit_bulk_detail->submit_label;
		$submit_responsible_person 		= $submit_bulk_detail->submit_responsible_person;
		$submit_schedule_each 			= $submit_bulk_detail->submit_schedule_each;
		$submit_time_estimate_hour 		= $submit_bulk_detail->submit_time_estimate_hour;
		$submit_time_estimate_minute 	= $submit_bulk_detail->submit_time_estimate_minute;
		$submit_cron_unique_id 			= $submit_bulk_detail->submit_cron_unique_id;
		if($bulk_action_type == 'Edit Schedule'){
			$timeslots = $crons == '' ? _get_cron_array() : $crons;
			foreach ( $timeslots as $time => $tasks ) {
				foreach ($tasks as $procname => $task) {
					foreach ($task as $key => $args) {
						$cron_submit_id = $args['args']['submit_id'];
						if($cron_submit_id == $bulk_action_id){							
							$submit_cron_time		= $time;
							$submit_cron_schedule	= $procname;
							$submit_cron_key		= $key;
						}
					}
				}
			}
			$crons = _unschedule_event($submit_cron_time, $submit_cron_schedule, $submit_cron_key);
			
			date_default_timezone_set('Asia/Manila');
			$date_format = date("n/j/Y" , strtotime($submit_starting_date));
			$date_array = explode("/", $date_format);
			$month	= $date_array['0'];
			$day 	= $date_array['1'];
			$year	= $date_array['2'];
			
			$cron_hook = $submit_task_name ."-". $submit_starting_date ."-". $submit_hour .":". $submit_minute;
			$function_name = $cron_hook ."_function_name";
			$cron_hook_function_name = str_replace(' ', '_', $function_name);
			
			if($month != null && $day != null && $year != null){
				if($submit_hour != null && $submit_minute != null){
					$timestamp = mktime($submit_hour, $submit_minute, '0', $month, $day , $year);
				}else{
					$timestamp = mktime('0', '1', '0', $month, $day , $year);
				}				
				schedule_cron($submit_schedule_each, $timestamp, $bulk_action_id, $submit_task_name, $submit_description, $submit_label, $submit_cron_unique_id);
			}		
			
			$update = $wpdb->update( $table_name , array(			
				'submit_schedule_each'			=> $submit_schedule_each,
				'submit_starting_date'			=> $submit_starting_date
			),
			array( 'ID' => $bulk_action_id ),
			array( '%s', '%s' ));
		}elseif($bulk_action_type == 'Delete'){
			submit_task_cron_delete($bulk_action_id);			
		}elseif($bulk_action_type == 'Pause'){
			submit_task_cron_pause($bulk_action_id);
		}
	}
		
	$bulk_action_form_data['submit_task_name'] = $submit_task_name;
	$bulk_action_form_data['submit_task_name_suffix'] = $submit_task_name_suffix;
	$bulk_action_form_data['submit_description'] = $submit_description;
	$bulk_action_form_data['submit_label'] = $submit_label;
	$bulk_action_form_data['submit_responsible_person'] = $submit_responsible_person;
	$bulk_action_form_data['submit_time_estimate_hour'] = $submit_time_estimate_hour;
	$bulk_action_form_data['submit_time_estimate_minute'] = $submit_time_estimate_minute;
	$bulk_action_form_data['submit_time_estimate_minute'] = $submit_time_estimate_minute;
	$bulk_action_form_data['submit_schedule_each'] = $submit_schedule_each;
	return $bulk_action_form_data;
}
/* ==================================== END BULK ACTIONS ==================================== */

/* ==================================== SORTING SUBMIT ==================================== */
/* SORT DATE ASC */
function sort_asc_submit_task_date($asc_date_array){	
	$mktime_array = array();
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	foreach($asc_date_array as $key => $date_id){		
		$date_id_explode = explode("_", $date_id);
		$id = $date_id_explode[1];
		
		$explode_date_time = explode(" ", $date_id_explode[0]);
		
		$date = $explode_date_time[0];
		$time = $explode_date_time[1];
		
		$ymd = explode("/", $date);		
		$year = $ymd[0];
		$month = $ymd[1];
		$day = $ymd[2];
		
		$hms = explode(":", $time);
		$hour = $hms[0];
		$minute = $hms[1];
		$second = $hms[2];
		if($time != null){
		$timestamp = mktime($hour, $minute, $second, $month, $day , $year);
		}
		$mktime_id_array[$key] = $timestamp ."_". $id;
	}
	
	foreach($mktime_id_array as $key => $mktime_id){
		$mktime_id_explode = explode("_", $mktime_id);
		$mktime = $mktime_id_explode[0];
		$task_id = $mktime_id_explode[1];		
		$mktime_array[$task_id] = $mktime;
	}
	
	asort($mktime_array, SORT_NUMERIC);
	$counter = 0;
	foreach($mktime_array as $key => $mktime){
		$sorted_date =  date('Y/m/d H:i:s',$mktime);
		
		$sort_tasks = $wpdb->get_results("SELECT * FROM {$table_name} WHERE ID='$key'");
		$id = $sort_tasks[0]->ID;
		$submit_task_name_suffix = $sort_tasks[0]->submit_task_name_suffix;
		if($submit_task_name_suffix != null){
			$submit_task_name = $sort_tasks[0]->submit_task_name ." - ". $submit_task_name_suffix; 
		}else{
			$submit_task_name = $sort_tasks[0]->submit_task_name;
		}
		$submit_label = ($sort_tasks[0]->submit_label != "") ? $sort_tasks[0]->submit_label : "--"; 
		$submit_responsible_person = ($sort_tasks[0]->submit_responsible_person != "") ? $sort_tasks[0]->submit_responsible_person : "--"; 
		$submit_schedule_each = ($sort_tasks[0]->submit_schedule_each != "") ? $sort_tasks[0]->submit_schedule_each : "--"; 
		$submit_time_estimate_hour = ($sort_tasks[0]->submit_time_estimate_hour != "") ? $sort_tasks[0]->submit_time_estimate_hour : "0"; 
		$submit_time_estimate_minute = ($sort_tasks[0]->submit_time_estimate_minute != "") ? $sort_tasks[0]->submit_time_estimate_minute : "0";
		$submit_hour = (($submit_time_estimate_hour != null) ? $submit_time_estimate_hour ." h " : " 0 h ") . "" . (($submit_time_estimate_minute != null) ? $submit_time_estimate_minute ." m " : " 0 m ");
		$submit_cron_status = ($sort_tasks[0]->submit_cron_status != "") ? $sort_tasks[0]->submit_cron_status : "--";
		$submit_description = ($sort_tasks[0]->submit_description != "") ? $sort_tasks[0]->submit_description : "--";
		
		$sorted[$counter] = $sorted_date ."_". $id ."_". $submit_task_name ."_". $submit_label ."_". $submit_responsible_person ."_". $submit_schedule_each ."_". $submit_hour ."_". $submit_cron_status ."_". $submit_description ;
		$counter++;
	}
	return $sorted;
}
/* SORT DATE DESC */
function sort_desc_submit_task_date($desc_date_array){	
	$mktime_array = array();
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	foreach($desc_date_array as $key => $date_id){		
		$date_id_explode = explode("_", $date_id);
		$id = $date_id_explode[1];
		
		$explode_date_time = explode(" ", $date_id_explode[0]);
		
		$date = $explode_date_time[0];
		$time = $explode_date_time[1];
		
		$ymd = explode("/", $date);		
		$year = $ymd[0];
		$month = $ymd[1];
		$day = $ymd[2];
		
		$hms = explode(":", $time);
		$hour = $hms[0];
		$minute = $hms[1];
		$second = $hms[2];
		
		$timestamp = mktime($hour, $minute, $second, $month, $day , $year);
		
		$mktime_id_array[$key] = $timestamp ."_". $id;
	}
	
	foreach($mktime_id_array as $key => $mktime_id){
		$mktime_id_explode = explode("_", $mktime_id);
		$mktime = $mktime_id_explode[0];
		$task_id = $mktime_id_explode[1];
		$mktime_array[$task_id] = $mktime;
	}
		
	arsort($mktime_array, SORT_NUMERIC);
	$counter = 0;
	foreach($mktime_array as $key => $mktime){
		$sorted_date =  date('Y/m/d H:i:s',$mktime);
		
		$sort_tasks = $wpdb->get_results("SELECT * FROM {$table_name} WHERE ID='$key'");
		$id = $sort_tasks[0]->ID;		
		$submit_task_name_suffix = $sort_tasks[0]->submit_task_name_suffix;
		if($submit_task_name_suffix != null){
			$submit_task_name = $sort_tasks[0]->submit_task_name ." - ". $submit_task_name_suffix; 
		}else{
			$submit_task_name = $sort_tasks[0]->submit_task_name;
		}
		$submit_label = ($sort_tasks[0]->submit_label != "") ? $sort_tasks[0]->submit_label : "--"; 
		$submit_responsible_person = ($sort_tasks[0]->submit_responsible_person != "") ? $sort_tasks[0]->submit_responsible_person : "--"; 
		$submit_schedule_each = ($sort_tasks[0]->submit_schedule_each != "") ? $sort_tasks[0]->submit_schedule_each : "--"; 
		$submit_time_estimate_hour = ($sort_tasks[0]->submit_time_estimate_hour != "") ? $sort_tasks[0]->submit_time_estimate_hour : "0"; 
		$submit_time_estimate_minute = ($sort_tasks[0]->submit_time_estimate_minute != "") ? $sort_tasks[0]->submit_time_estimate_minute : "0";
		$submit_hour = (($submit_time_estimate_hour != null) ? $submit_time_estimate_hour ." h " : " 0 h ") . "" . (($submit_time_estimate_minute != null) ? $submit_time_estimate_minute ." m " : " 0 m ");
		$submit_cron_status = ($sort_tasks[0]->submit_cron_status != "") ? $sort_tasks[0]->submit_cron_status : "--";
		$submit_description = ($sort_tasks[0]->submit_description != "") ? $sort_tasks[0]->submit_description : "--";
		
		$sorted[$counter] = $sorted_date ."_". $id ."_". $submit_task_name ."_". $submit_label ."_". $submit_responsible_person ."_". $submit_schedule_each ."_". $submit_hour ."_". $submit_cron_status ."_". $submit_description ;
		$counter++;
	}
	return $sorted;
}
/* SORT CLIENT AND DATE ASC */
function sort_asc_client_task_date($asc_client_array){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	$client_id_name_date_array = array();
	foreach($asc_client_array as $name_date_id_array){
		$name_date_id = explode("_", $name_date_id_array);
		$client_name = $name_date_id[0];
		$task_date_time = $name_date_id[1];
		$task_id = $name_date_id[2];		
		$client_id_name_date_array[] = $client_name ."_". $task_date_time ."_". $task_id;
		
	}
	sort($client_id_name_date_array, SORT_NATURAL | SORT_FLAG_CASE);
	$array_split = array();
	foreach ($client_id_name_date_array as $client_id_name_date) {
		$client_id_name_date_explode = explode("_", $client_id_name_date);
		$client_name = $client_id_name_date_explode[0];
		$array_split[$client_name][] = $client_id_name_date;
	}
	$sorted = array();
	foreach($array_split as $client_name => $name_date_id){
		$mktime_id_array_name = array();
		$mktime_id_array = array();
		$mktime_id_array_id = array();		
		foreach($name_date_id as $key => $name_date_id_array){			
			$name_date_id_explode = explode("_", $name_date_id_array);
			$client_name = $name_date_id_explode[0];
			$date_time_array = $name_date_id_explode[1];
			$task_id = $name_date_id_explode[2];
			
			$explode_date_time = explode(" ", $date_time_array);
			
			$date = $explode_date_time[0];
			$time = $explode_date_time[1];
			
			$ymd = explode("/", $date);		
			$year = $ymd[0];
			$month = $ymd[1];
			$day = $ymd[2];
			
			$hms = explode(":", $time);
			$hour = $hms[0];
			$minute = $hms[1];
			$second = $hms[2];
			if($time != null){
			$timestamp = mktime($hour, $minute, $second, $month, $day , $year);	
			}
			$mktime_id_array_name[$key] = $client_name;	
			$mktime_id_array[$key] = $timestamp;						
			$mktime_id_array_id[$key] = $task_id;							
		}
		
		rsort($mktime_id_array, SORT_NUMERIC);
		
		$combined = array_map(function($a, $b, $c) { return $a . '_' . $b . '_'. $c; }, $mktime_id_array_name, $mktime_id_array, $mktime_id_array_id);
		
		foreach($combined as $sort_details){
			$explode_sort_details = explode("_", $sort_details);
			$data_time = $explode_sort_details[1];			
			$data_id = $explode_sort_details[2];
			$sort_tasks = $wpdb->get_results("SELECT * FROM {$table_name} WHERE ID='$data_id'");
			$id = $sort_tasks[0]->ID;		
			$submit_task_name_suffix = $sort_tasks[0]->submit_task_name_suffix;
			if($submit_task_name_suffix != null){
				$submit_task_name = $sort_tasks[0]->submit_task_name ." - ". $submit_task_name_suffix; 
				}else{
				$submit_task_name = $sort_tasks[0]->submit_task_name;
			}
			$sorted_date =  $sort_tasks[0]->submit_next_schedule;
			$submit_label = ($sort_tasks[0]->submit_label != "") ? $sort_tasks[0]->submit_label : "--"; 
			$submit_responsible_person = ($sort_tasks[0]->submit_responsible_person != "") ? $sort_tasks[0]->submit_responsible_person : "--"; 
			$submit_schedule_each = ($sort_tasks[0]->submit_schedule_each != "") ? $sort_tasks[0]->submit_schedule_each : "--"; 
			$submit_time_estimate_hour = ($sort_tasks[0]->submit_time_estimate_hour != "") ? $sort_tasks[0]->submit_time_estimate_hour : "0"; 
			$submit_time_estimate_minute = ($sort_tasks[0]->submit_time_estimate_minute != "") ? $sort_tasks[0]->submit_time_estimate_minute : "0";
			$submit_hour = (($submit_time_estimate_hour != null) ? $submit_time_estimate_hour ." h " : " 0 h ") . "" . (($submit_time_estimate_minute != null) ? $submit_time_estimate_minute ." m " : " 0 m ");
			$submit_cron_status = ($sort_tasks[0]->submit_cron_status != "") ? $sort_tasks[0]->submit_cron_status : "--";
			$submit_description = ($sort_tasks[0]->submit_description != "") ? $sort_tasks[0]->submit_description : "--";
			$sorted[] = $sorted_date ."_". $id ."_". $submit_task_name ."_". $submit_label ."_". $submit_responsible_person ."_". $submit_schedule_each ."_". $submit_hour ."_". $submit_cron_status ."_". $submit_description ;
		}
		
	}
	
	return $sorted;
}
/* SORT CLIENT AND DATE DESC */
function sort_desc_client_task_date($desc_client_array){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	$client_id_name_date_array = array();
	foreach($desc_client_array as $name_date_id_array){
		$name_date_id = explode("_", $name_date_id_array);
		$client_name = $name_date_id[0];
		$task_date_time = $name_date_id[1];
		$task_id = $name_date_id[2];		
		$client_id_name_date_array[] = $client_name ."_". $task_date_time ."_". $task_id;
		
	}
	rsort($client_id_name_date_array, SORT_NATURAL | SORT_FLAG_CASE);
	
	$array_split = array();
	foreach ($client_id_name_date_array as $client_id_name_date) {
		$client_id_name_date_explode = explode("_", $client_id_name_date);
		$client_name = $client_id_name_date_explode[0];
		$array_split[$client_name][] = $client_id_name_date;
	}
	$sorted = array();
	foreach($array_split as $client_name => $name_date_id){
		$mktime_id_array_name = array();
		$mktime_id_array = array();
		$mktime_id_array_id = array();		
		foreach($name_date_id as $key => $name_date_id_array){			
			$name_date_id_explode = explode("_", $name_date_id_array);
			$client_name = $name_date_id_explode[0];
			$date_time_array = $name_date_id_explode[1];
			$task_id = $name_date_id_explode[2];
			
			$explode_date_time = explode(" ", $date_time_array);
			
			$date = $explode_date_time[0];
			$time = $explode_date_time[1];
			
			$ymd = explode("/", $date);		
			$year = $ymd[0];
			$month = $ymd[1];
			$day = $ymd[2];
			
			$hms = explode(":", $time);
			$hour = $hms[0];
			$minute = $hms[1];
			$second = $hms[2];
			
			$timestamp = mktime($hour, $minute, $second, $month, $day , $year);	
			
			$mktime_id_array_name[$key] = $client_name;	
			$mktime_id_array[$key] = $timestamp;						
			$mktime_id_array_id[$key] = $task_id;							
		}
		
		rsort($mktime_id_array, SORT_NUMERIC);
		
		$combined = array_map(function($a, $b, $c) { return $a . '_' . $b . '_'. $c; }, $mktime_id_array_name, $mktime_id_array, $mktime_id_array_id);
		
		foreach($combined as $sort_details){
			
			$explode_sort_details = explode("_", $sort_details);
			$data_time = $explode_sort_details[1];			
			$data_id = $explode_sort_details[2];
			$sort_tasks = $wpdb->get_results("SELECT * FROM {$table_name} WHERE ID='$data_id'");
			$id = $sort_tasks[0]->ID;		
			$submit_task_name_suffix = $sort_tasks[0]->submit_task_name_suffix;
			if($submit_task_name_suffix != null){
				$submit_task_name = $sort_tasks[0]->submit_task_name ." - ". $submit_task_name_suffix; 
				}else{
				$submit_task_name = $sort_tasks[0]->submit_task_name;
			}
			$sorted_date =  $sort_tasks[0]->submit_next_schedule;
			$submit_label = ($sort_tasks[0]->submit_label != "") ? $sort_tasks[0]->submit_label : "--"; 
			$submit_responsible_person = ($sort_tasks[0]->submit_responsible_person != "") ? $sort_tasks[0]->submit_responsible_person : "--"; 
			$submit_schedule_each = ($sort_tasks[0]->submit_schedule_each != "") ? $sort_tasks[0]->submit_schedule_each : "--"; 
			$submit_time_estimate_hour = ($sort_tasks[0]->submit_time_estimate_hour != "") ? $sort_tasks[0]->submit_time_estimate_hour : "0"; 
			$submit_time_estimate_minute = ($sort_tasks[0]->submit_time_estimate_minute != "") ? $sort_tasks[0]->submit_time_estimate_minute : "0";
			$submit_hour = (($submit_time_estimate_hour != null) ? $submit_time_estimate_hour ." h " : " 0 h ") . "" . (($submit_time_estimate_minute != null) ? $submit_time_estimate_minute ." m " : " 0 m ");
			$submit_cron_status = ($sort_tasks[0]->submit_cron_status != "") ? $sort_tasks[0]->submit_cron_status : "--";
			$submit_description = ($sort_tasks[0]->submit_description != "") ? $sort_tasks[0]->submit_description : "--";
			$sorted[] = $sorted_date ."_". $id ."_". $submit_task_name ."_". $submit_label ."_". $submit_responsible_person ."_". $submit_schedule_each ."_". $submit_hour ."_". $submit_cron_status ."_". $submit_description ;
		}
		
	}
	
	return $sorted;
}
/* SORT TASK AND DATE ASC */
function sort_asc_task_date($asc_task_array){
global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	$task_id_name_date_array = array();
	foreach($asc_task_array as $name_date_id_array){
		$name_date_id = explode("_", $name_date_id_array);
		$task_name = $name_date_id[0];
		$task_date_time = $name_date_id[1];
		$task_id = $name_date_id[2];		
		$task_id_name_date_array[] = $task_name ."_". $task_date_time ."_". $task_id;
		
	}
	sort($task_id_name_date_array, SORT_NATURAL | SORT_FLAG_CASE);
	$array_split = array();
	foreach ($task_id_name_date_array as $task_id_name_date) {
		$client_id_name_date_explode = explode("_", $task_id_name_date);
		$task_name = $client_id_name_date_explode[0];
		$array_split[$task_name][] = $task_id_name_date;
	}
	$sorted = array();
	foreach($array_split as $task_name => $name_date_id){
		$mktime_id_array_name = array();
		$mktime_id_array = array();
		$mktime_id_array_id = array();		
		foreach($name_date_id as $key => $name_date_id_array){			
			$name_date_id_explode = explode("_", $name_date_id_array);
			$task_name = $name_date_id_explode[0];
			$date_time_array = $name_date_id_explode[1];
			$task_id = $name_date_id_explode[2];
			
			$explode_date_time = explode(" ", $date_time_array);
			
			$date = $explode_date_time[0];
			$time = $explode_date_time[1];
			
			$ymd = explode("/", $date);		
			$year = $ymd[0];
			$month = $ymd[1];
			$day = $ymd[2];
			
			$hms = explode(":", $time);
			$hour = $hms[0];
			$minute = $hms[1];
			$second = $hms[2];
			if($time != null){
			$timestamp = mktime($hour, $minute, $second, $month, $day , $year);	
			}
			$mktime_id_array_name[$key] = $task_name;	
			$mktime_id_array[$key] = $timestamp;						
			$mktime_id_array_id[$key] = $task_id;							
		}
		
		rsort($mktime_id_array, SORT_NUMERIC);
		
		$combined = array_map(function($a, $b, $c) { return $a . '_' . $b . '_'. $c; }, $mktime_id_array_name, $mktime_id_array, $mktime_id_array_id);
		
		foreach($combined as $sort_details){
			$explode_sort_details = explode("_", $sort_details);
			$data_time = $explode_sort_details[1];			
			$data_id = $explode_sort_details[2];
			$sort_tasks = $wpdb->get_results("SELECT * FROM {$table_name} WHERE ID='$data_id'");
			$id = $sort_tasks[0]->ID;		
			$submit_task_name_suffix = $sort_tasks[0]->submit_task_name_suffix;
			if($submit_task_name_suffix != null){
				$submit_task_name = $sort_tasks[0]->submit_task_name ." - ". $submit_task_name_suffix; 
				}else{
				$submit_task_name = $sort_tasks[0]->submit_task_name;
			}
			$sorted_date =  $sort_tasks[0]->submit_next_schedule;
			$submit_label = ($sort_tasks[0]->submit_label != "") ? $sort_tasks[0]->submit_label : "--"; 
			$submit_responsible_person = ($sort_tasks[0]->submit_responsible_person != "") ? $sort_tasks[0]->submit_responsible_person : "--"; 
			$submit_schedule_each = ($sort_tasks[0]->submit_schedule_each != "") ? $sort_tasks[0]->submit_schedule_each : "--"; 
			$submit_time_estimate_hour = ($sort_tasks[0]->submit_time_estimate_hour != "") ? $sort_tasks[0]->submit_time_estimate_hour : "0"; 
			$submit_time_estimate_minute = ($sort_tasks[0]->submit_time_estimate_minute != "") ? $sort_tasks[0]->submit_time_estimate_minute : "0";
			$submit_hour = (($submit_time_estimate_hour != null) ? $submit_time_estimate_hour ." h " : " 0 h ") . "" . (($submit_time_estimate_minute != null) ? $submit_time_estimate_minute ." m " : " 0 m ");
			$submit_cron_status = ($sort_tasks[0]->submit_cron_status != "") ? $sort_tasks[0]->submit_cron_status : "--";
			$submit_description = ($sort_tasks[0]->submit_description != "") ? $sort_tasks[0]->submit_description : "--";
			$sorted[] = $sorted_date ."_". $id ."_". $submit_task_name ."_". $submit_label ."_". $submit_responsible_person ."_". $submit_schedule_each ."_". $submit_hour ."_". $submit_cron_status ."_". $submit_description ;
		}
		
	}
	
	return $sorted;
}
/* SORT TASK AND DATE ASC */
function sort_desc_task_date($desc_task_array){
global $wpdb;
	$table_name = $wpdb->prefix . "custom_submit_task";
	$task_id_name_date_array = array();
	foreach($desc_task_array as $name_date_id_array){
		$name_date_id = explode("_", $name_date_id_array);
		$task_name = $name_date_id[0];
		$task_date_time = $name_date_id[1];
		$task_id = $name_date_id[2];		
		$task_id_name_date_array[] = $task_name ."_". $task_date_time ."_". $task_id;
		
	}
	rsort($task_id_name_date_array, SORT_NATURAL | SORT_FLAG_CASE);
	
	$array_split = array();
	foreach ($task_id_name_date_array as $task_id_name_date) {
		$client_id_name_date_explode = explode("_", $task_id_name_date);
		$task_name = $client_id_name_date_explode[0];
		$array_split[$task_name][] = $task_id_name_date;
	}
	$sorted = array();
	foreach($array_split as $task_name => $name_date_id){
		$mktime_id_array_name = array();
		$mktime_id_array = array();
		$mktime_id_array_id = array();		
		foreach($name_date_id as $key => $name_date_id_array){			
			$name_date_id_explode = explode("_", $name_date_id_array);
			$task_name = $name_date_id_explode[0];
			$date_time_array = $name_date_id_explode[1];
			$task_id = $name_date_id_explode[2];
			
			$explode_date_time = explode(" ", $date_time_array);
			
			$date = $explode_date_time[0];
			$time = $explode_date_time[1];
			
			$ymd = explode("/", $date);		
			$year = $ymd[0];
			$month = $ymd[1];
			$day = $ymd[2];
			
			$hms = explode(":", $time);
			$hour = $hms[0];
			$minute = $hms[1];
			$second = $hms[2];
			
			$timestamp = mktime($hour, $minute, $second, $month, $day , $year);	
			
			$mktime_id_array_name[$key] = $task_name;	
			$mktime_id_array[$key] = $timestamp;						
			$mktime_id_array_id[$key] = $task_id;							
		}
		
		rsort($mktime_id_array, SORT_NUMERIC);
		
		$combined = array_map(function($a, $b, $c) { return $a . '_' . $b . '_'. $c; }, $mktime_id_array_name, $mktime_id_array, $mktime_id_array_id);
		
		foreach($combined as $sort_details){
			
			$explode_sort_details = explode("_", $sort_details);
			$data_time = $explode_sort_details[1];			
			$data_id = $explode_sort_details[2];
			$sort_tasks = $wpdb->get_results("SELECT * FROM {$table_name} WHERE ID='$data_id'");
			$id = $sort_tasks[0]->ID;		
			$submit_task_name_suffix = $sort_tasks[0]->submit_task_name_suffix;
			if($submit_task_name_suffix != null){
				$submit_task_name = $sort_tasks[0]->submit_task_name ." - ". $submit_task_name_suffix; 
				}else{
				$submit_task_name = $sort_tasks[0]->submit_task_name;
			}
			$sorted_date =  $sort_tasks[0]->submit_next_schedule;
			$submit_label = ($sort_tasks[0]->submit_label != "") ? $sort_tasks[0]->submit_label : "--"; 
			$submit_responsible_person = ($sort_tasks[0]->submit_responsible_person != "") ? $sort_tasks[0]->submit_responsible_person : "--"; 
			$submit_schedule_each = ($sort_tasks[0]->submit_schedule_each != "") ? $sort_tasks[0]->submit_schedule_each : "--"; 
			$submit_time_estimate_hour = ($sort_tasks[0]->submit_time_estimate_hour != "") ? $sort_tasks[0]->submit_time_estimate_hour : "0"; 
			$submit_time_estimate_minute = ($sort_tasks[0]->submit_time_estimate_minute != "") ? $sort_tasks[0]->submit_time_estimate_minute : "0";
			$submit_hour = (($submit_time_estimate_hour != null) ? $submit_time_estimate_hour ." h " : " 0 h ") . "" . (($submit_time_estimate_minute != null) ? $submit_time_estimate_minute ." m " : " 0 m ");
			$submit_cron_status = ($sort_tasks[0]->submit_cron_status != "") ? $sort_tasks[0]->submit_cron_status : "--";
			$submit_description = ($sort_tasks[0]->submit_description != "") ? $sort_tasks[0]->submit_description : "--";
			$sorted[] = $sorted_date ."_". $id ."_". $submit_task_name ."_". $submit_label ."_". $submit_responsible_person ."_". $submit_schedule_each ."_". $submit_hour ."_". $submit_cron_status ."_". $submit_description ;
		}
		
	}
	
	return $sorted;
}
/* ==================================== END SORTING SUBMIT ==================================== */
?>