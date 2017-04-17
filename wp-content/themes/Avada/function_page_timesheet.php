<?php

/* ==================================== TIMESHEET IMPORT TASK ==================================== */

function import_task_kanban($date_hour_day_week){

	$date_hour_day_week_explode = explode("_",$date_hour_day_week);

	$import_date = $date_hour_day_week_explode[0];

	$import_total_hour = $date_hour_day_week_explode[1];

	$import_day = $date_hour_day_week_explode[2];

	$import_week = $date_hour_day_week_explode[3];

	$import_date_explode = explode("/",$import_date);

	$day = $import_date_explode[0];

	$month = $import_date_explode[1];

	$year = $import_date_explode[2];

	$format_import_date = $year."-".$month."-".$day;

	global $wpdb;

	$seconds = 0;

	set_time_limit($seconds);

	$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";

	$counter = 1;

	$task_counter = 1;

	$curr_task = "";

	$cur_user = "";

	$tasks = array();

	$total_hour_decimal = "";	

	

	$current_user = wp_get_current_user();	

	$user_id = get_current_user_id();

	$current_user_fullname = $current_user->data->display_name;

	

	$table_name_person = $wpdb->prefix . "custom_person";

	$person_detail = $wpdb->get_row("SELECT * FROM $table_name_person WHERE person_fullname = '$current_user_fullname'");

	$person_kb_user_id = $person_detail->person_kb_user_id;


	//$url= "https://kanbanflow.com/api/v1/board/events?from=".$format_import_date."T00:00Z&to=".$format_import_date."T23:59Z&" . $token;

	$result = file_get_contents($url);	

	$result_array = json_decode($result, true);

	// print_Var($result_array);

	$id_array = array();

	

	foreach($result_array['events'] as $key => $event_tasks){

		foreach($event_tasks['detailedEvents'] as $detailed_events){

			if($detailed_events['changedProperties'][0]['property'] == 'totalSecondsSpent'){

				$task_id = $detailed_events['taskId'];

				array_push($id_array,$task_id);

			}

		}	

	}	

	$ids = array_unique($id_array);

	

	if($ids == null){

		$tasks_data['no_task'] = 'no_task';

	}

	

	foreach($ids as $id){

		$get_task_item = "https://kanbanflow.com/api/v1/tasks/" . $id . "?&" . $token;

		$changed_task = file_get_contents($get_task_item);										

		$task_details = json_decode($changed_task, true);

		$reposible_user_id = $task_details['responsibleUserId'];

		

		if($reposible_user_id == $person_kb_user_id){

			$get_task_label = "https://kanbanflow.com/api/v1/tasks/". $id. "/labels" . "?&" . $token;

			$task_label_array = @file_get_contents($get_task_label);

			$task_label_details = json_decode($task_label_array, true);	

			

			$task_color = $task_details['color'];

			$task_color_detail = ucfirst($task_color);

			$table_color = $wpdb->prefix . "custom_project_color";

			$colors = $wpdb->get_row("SELECT * FROM {$table_color} WHERE project_color = '$task_color_detail'");

			

			$get_task_by_date = "https://kanbanflow.com/api/v1/tasks/". $id ."/events?from=".$format_import_date."T00:00Z&to=".$format_import_date."T23:59Z&" . $token;

			$task_by_date = @file_get_contents($get_task_by_date);

			$get_task_event = json_decode($task_by_date, true);		

			foreach($get_task_event['events'] as $key => $task_event){

				foreach($task_event['detailedEvents'] as $task_event['taskId'] => $detailed_events){

					if($detailed_events['changedProperties'][0]['property'] == 'totalSecondsSpent'){

						$old_hour = $detailed_events['changedProperties'][0]['oldValue'];

						$new_hour = $detailed_events['changedProperties'][0]['newValue'];

					}

				}	

			}



			$task_hour_diff = $new_hour - $old_hour;

			$task_hour_real = gmdate("H:i:s", $new_hour);

			$task_hour = time_format($task_hour_real);

			

			$task_name = $task_details['name'];		

			$task_label = $task_label_details[0]['name'];

			$task_person = $current_user_fullname;

			$task_description = $task_details['description'];

			$task_project_name = $colors->project_category;	



			$task_label_explode = explode(' ', $task_label);

			$last_word = array_pop($task_label_explode);

			if($last_word == "AB"){

				$client_name = str_replace(" AB","",$task_label);

			}else{

				$client_name = $task_label;

			}	



			if($task_label == 'SEOWeb'){

				$client_name = 'SEOWeb Solutions';

			}

			

			$task_hour_decimal = decimalHours($task_hour);

			$total_hour_decimal += $task_hour_decimal;		

			if($task_hour != null){

				$tasks_data[] = array(

				'task_name'			=> $task_name, 

				'task_hour'			=> $task_hour,

				'task_label'		=> $client_name,

				'task_person'		=> $task_person,

				'task_description' 	=> $task_description,

				'task_color' 		=> $task_color,

				'task_project_name' => $task_project_name,

				'user_id'			=> $user_id,

				'import_date'		=> $import_date,

				'import_day'		=> $import_day,

				'import_week' 		=> $import_week

				);

			}

		}

	}

	$import_total_hour_decimal = decimalHours($import_total_hour);	

	$current_total = $total_hour_decimal + $import_total_hour_decimal;	

	$total_hour_real =  convertTime($current_total);

	$total_hour = time_format($total_hour_real);

	$tasks_data['total_hour'] = $total_hour;

	return $tasks_data;

}

/* ==================================== END TIMESHEET IMPORT TASK ==================================== */



/* ==================================== TIMESHEET SAVE TASK ==================================== */

// function save_task_timesheet($save_timesheet_task_data){

// 	$save_timesheet_form_data = array();

// 	parse_str($save_timesheet_task_data, $save_timesheet_form_data);

// 	$total_hours_worked = $save_timesheet_form_data['total_hours_worked'];	

// 	$hour_balance = $save_timesheet_form_data['hour_balance'];	

// 	global $wpdb;	



// 	$table_name = $wpdb->prefix . "custom_timesheet";

// 	$total_hour_decimal = "";

// 	foreach($save_timesheet_form_data['task_name'] as $key => $task_names){

// 		$result_task_name_explode = explode('-', $task_names);

// 		$task_name_import = trim($result_task_name_explode['0']);		

// 		$task_name_explode = explode(' ', $task_name_import);

// 		$task_name_array = array();

// 		foreach($task_name_explode as $exploded_task_name){			

// 			if(strtoupper($exploded_task_name) !== $exploded_task_name){

// 				$exploded_task_name = strtolower($exploded_task_name);

// 			}

// 			$task_name_array[] = $exploded_task_name;

// 		}		

// 		$task_name = implode(" ",$task_name_array);

// 		$task_suffix = trim($result_task_name_explode['1']);		

// 		$task_label = $save_timesheet_form_data['task_label'][$key];

// 		$task_hour = $save_timesheet_form_data['task_hour'][$key];

// 		$task_person = $save_timesheet_form_data['task_person'][$key];

// 		$task_description = $save_timesheet_form_data['task_description'][$key];

// 		$task_color = $save_timesheet_form_data['task_color'][$key];

// 		$task_project_name = $save_timesheet_form_data['task_project_name'][$key];

// 		$user_id = $save_timesheet_form_data['user_id'][$key];		

// 		$date_now = $save_timesheet_form_data['import_date'];

// 		$day_now = $save_timesheet_form_data['import_day'];

// 		$week_number = $save_timesheet_form_data['import_week'];					

		

// 		$user_id = $save_timesheet_form_data['user_id'][$key];

		

// 		$insert = $wpdb->insert( $table_name , array( 

// 			'task_name' => $task_name,

// 			'task_suffix' => $task_suffix,

// 			'date_now' => $date_now,

// 			'day_now' => ucfirst($day_now),

// 			'week_number' => $week_number,		

// 			'task_hour' => $task_hour,

// 			'task_label' => $task_label,	

// 			'task_person' => $task_person,

// 			'task_description' => htmlentities($task_description),

// 			'task_color' => $task_color,

// 			'task_project_name' => $task_project_name,

// 			'user_id' => $user_id,

// 			'status' => 1

// 		),	

// 		array( '%s', '%s' ));

// 		$submit_id = $wpdb->insert_id;

// 		$save_timesheet_form_data['id'][] = $submit_id;

// 		$task_hour_decimal = decimalHours($task_hour);

// 		$total_hour_decimal += $task_hour_decimal;

// 	}

	

// 	$total_hour_decimal_round = round($total_hour_decimal, 2);

// 	$total_month_hours_worked = $total_hours_worked + $total_hour_decimal_round;

// 	$total_month_hour_balance = $hour_balance + $total_hour_decimal_round;

// 	$save_timesheet_form_data['total_month_hours_worked'] = $total_month_hours_worked;

// 	$save_timesheet_form_data['total_month_hour_balance'] = $total_month_hour_balance;

// 	return $save_timesheet_form_data;

// }

/* ==================================== END TIMESHEET SAVE TASK ==================================== */



/* ==================================== TIMESHEET EDIT TASK ==================================== */

function task_edit_timesheet_task($data_id){

	$data_id_explode = explode("_", $data_id);

	$data_id = $data_id_explode[0];

	$current_task_hour = $data_id_explode[1];

	global $wpdb;			

	$table_name = $wpdb->prefix . "custom_timesheet";	

	$table_name_client = $wpdb->prefix . "custom_client"; 

	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");	

	$table_name_project = $wpdb->prefix . "custom_project";

	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project}");

	$table_name_task = $wpdb->prefix . "custom_task";

	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");

	

	$results_edit = $wpdb->get_row("SELECT * FROM $table_name WHERE ID = $data_id");

	$id = $results_edit->ID;

	$task_name = (isset($results_edit->task_name)) ? $results_edit->task_name : "";

	$task_suffix = (isset($results_edit->task_suffix)) ? $results_edit->task_suffix : "";

	$task_person = (isset($results_edit->task_person)) ? $results_edit->task_person : "";

	$task_description = (isset($results_edit->task_description)) ? $results_edit->task_description : "";

	$task_hour = (isset($results_edit->task_hour)) ? $results_edit->task_hour : "";

	$date_now = (isset($results_edit->date_now)) ? $results_edit->date_now : "";

	$day_now = (isset($results_edit->day_now)) ? $results_edit->day_now : "";

	$week_number = (isset($results_edit->week_number)) ? $results_edit->week_number : "";

	if($results_edit->user_id != ""){

		$user_id = $results_edit->user_id;

		$user_data = get_userdata($user_id);

		$user_name = $user_data->display_name;

	}else{

		$user_id = "";

		$user_name = "";

	}

	

	foreach ($clients as $client){

		$client_option .= "<optgroup label = ".$client->client_name.">";

		foreach ($projects as $project){

			if($client->client_name == $project->project_client){

				$client_option .= "<option>".$project->project_name."</option>";

			}

		}

		$client_option .= "</optgroup>";

	}

	

	foreach ($tasks as $task){

		if($task_name != $task->task_name){

			$task_name_option .= "<option>".format_task_name($task->task_name)."</option>";

		}

	}

	$html ='

	<form method="post" id="update_timesheet">

	<fieldset>

	<label class="modal_label">Task Name</label>

	<select class="modal_select" name="task_name">

	<option value="'.$task_name.'">'.format_task_name($task_name).'</option>

	'.$task_name_option.'

	</select>

	<label class="modal_label">Task Suffix</label>

	<input type="text" class="modal_input" name="task_suffix" value="'.$task_suffix.'">

	<div class="textareas">

	<textarea class="modal_textarea1" name="task_description" placeholder="Notes (optional)">'.$task_description.'</textarea>

	<textarea class="modal_textarea2" name="task_hour" placeholder="0:00">'.$task_hour.'</textarea>

	</div>

	<div id="update_kanban_'.$id.'" class="button_1 update_button">Update</div>

	<div style="display: none" class="loader"></div>

	<input type="hidden" name="task_person" value="'.$task_person.'" />

	<input type="hidden" name="user_id" value="'.$user_id.'" />

	<input type="hidden" name="date_now" value="'.$date_now.'" />

	<input type="hidden" name="day_now" value="'.$day_now.'" />

	<input type="hidden" name="week_number" value="'.$week_number.'" />

	<input type="hidden" name="id" value="'.$id.'" />

	<input type="hidden" name="current_task_hour" value="'.$current_task_hour.'" />

	</fieldset>

	</form>

	';

	

	return $html;

}

/* ==================================== END TIMESHEET EDIT TASK ==================================== */



/* ==================================== TIMESHEET UPDATE TASK ==================================== */

function update_task_timesheet($update_timesheet_data){

	global $wpdb;			

	$table_name = $wpdb->prefix . "custom_timesheet";

	$update_timesheet_form_data = array();

	parse_str($update_timesheet_data, $update_timesheet_form_data);

	$task_id			= $update_timesheet_form_data['id'];	

	$task_name			= $update_timesheet_form_data['task_name'];

	$task_hour_unformat	= $update_timesheet_form_data['task_hour'];

	$task_description	= $update_timesheet_form_data['task_description'];

	$task_suffix		= $update_timesheet_form_data['task_suffix'];

	

	$task_hour = time_format($task_hour_unformat);

	

	$update = $wpdb->update( $table_name , array( 

		'task_name'			=> $task_name,

		'task_hour'			=> $task_hour,

		'task_description'	=> $task_description,

		'task_suffix'		=> $task_suffix

	),

	array( 'ID' => $task_id ),

	array( '%s', '%s' ));

		

	$current_task_hour					= $update_timesheet_form_data['current_task_hour'];

	$current_task_hour_decimal 			= decimalHours($current_task_hour);

	$current_task_hour_decimal_round 	= round($current_task_hour_decimal, 2);

	

	$task_hour_decimal = decimalHours($task_hour);

	$task_hour_decimal_round = round($task_hour_decimal, 2);

	

	$current_total_hour		= $update_timesheet_form_data['current_total_hour'];

	$current_total_hour_decimal = decimalHours($current_total_hour);

	$current_total_hour_decimal_round 	= round($current_total_hour_decimal, 2);

	

	$current_total_hours_worked	= $update_timesheet_form_data['total_hours_worked'];

	$current_hour_balance		= $update_timesheet_form_data['hour_balance'];	

	

	if($current_task_hour_decimal_round > $task_hour_decimal_round){

		$task_hour_diff = $current_task_hour_decimal_round - $task_hour_decimal_round;

		$total_task_hour = $current_total_hour_decimal_round - $task_hour_diff;

		$total_hours_worked = $current_total_hours_worked - $task_hour_diff;

		$hour_balance = $current_hour_balance - $task_hour_diff;

	}elseif($current_task_hour_decimal_round < $task_hour_decimal_round){

		$task_hour_diff = $task_hour_decimal_round - $current_task_hour_decimal_round;

		$total_task_hour = $current_total_hour_decimal_round + $task_hour_diff;

		$total_hours_worked = $current_total_hours_worked + $task_hour_diff;

		$hour_balance = $current_hour_balance + $task_hour_diff;

	}

	$update_timesheet_form_data['task_hour'] = time_format($task_hour);

	$update_timesheet_form_data['total_task_hour'] = gmdate('H:i', floor($total_task_hour * 3600));

	$update_timesheet_form_data['total_hours_worked'] = $total_hours_worked;

	$update_timesheet_form_data['hour_balance'] = $hour_balance;

	return $update_timesheet_form_data;

}

/* ==================================== END TIMESHEET UPDATE TASK ==================================== */



/* ==================================== TIMESHEET ADD TASK ==================================== */

function timesheet_add_task($day_date_week){	

	global $wpdb;

	$table_name_task = $wpdb->prefix . "custom_task";

	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");

	$table_projects = $wpdb->prefix . "custom_project";	

	$table_clients = $wpdb->prefix . "custom_client";

	$table_person = $wpdb->prefix . "custom_person";

	$clients = $wpdb->get_results("SELECT * FROM {$table_clients}");

	$persons = $wpdb->get_results("SELECT * FROM {$table_person}");

	

	$current_user = wp_get_current_user();

	$user_id = get_current_user_id();

	$current_user_name = $current_user->data->display_name;

	$current_user_role = $current_user->roles['0'];

	

	$day_date_week_explode = explode('_', $day_date_week);	

	$day_now = $day_date_week_explode[0];

	$date_now = $day_date_week_explode[1];

	$week_number  = $day_date_week_explode[2];

	

	$task_names = array();

	foreach($tasks as $task){ 

		$task_names[] = $task->task_name;

	}

	sort($task_names);

	foreach ($task_names as $task_name){

		$task_name_option .= "<option>".$task_name."</option>";

	}

	

	$client_names = array();

	foreach($clients as $client){

		$client_names[] = $client->client_name;

	}

	

	sort($client_names);

	foreach($client_names as $key => $client_name){

		if($key == 0){

			$selected_client = $client_name;

		}

		$task_client_option .= '<option>'.$client_name.'</option>';

	}

	

	$projects = $wpdb->get_results("SELECT DISTINCT project_name FROM {$table_projects} WHERE project_client = '$selected_client'");

	$project_names = array();

	foreach($projects as $project){

		$project_names[] = $project->project_name;

	}

	sort($project_names);

	foreach($project_names as $project_name){

		$task_project_option .= '<option value="' . $project_name . '">'. $project_name.  '</option>';

	}	

	

	$project_persons = array();

	foreach($persons as $person){

		$project_persons[] = $person->person_fullname;

	}

	sort($project_persons);

	foreach($project_persons as $person_name){

		if($person_name != $current_user_name){

			$task_person_option .= '<option value="' . $person_name . '">'. $person_name.  '</option>';

		}

	}	

	

	$html='

	<form method="post" id="add_task_timesheet">

	<fieldset>

	<div class="timesheet_task_name">

	<label class="modal_label">Task Name</label>

	<select class="modal_select" name="task_name">

	'.$task_name_option.'

	</select>

	</div>

	<div class="timesheet_task_label">

	<label class="modal_label">Client</label>

	<select class="modal_input task_label" name="task_label">

	'.$task_client_option.'

	</select>

	</div>

	<div class="timesheet_task_color">

	<label class="modal_label modal_label_project">Project</label>

	<div style="display: none;" class="loader project_name_loader"></div>

	<select class="modal_input task_project_name" name="task_project_name">

	'.$task_project_option.'

	</select>	

	</div>	

	<div class="timesheet_task_person">

	<label class="modal_label">User</label>

	<select class="modal_input task_person" name="task_person">

	<option>'.$current_user_name.'</option>

	'.$task_person_option.'

	</select>	

	</div>	

	<div class="textareas">

	<div class="timesheet_task_description">

	<label class="modal_label">Description</label>

	<textarea class="modal_textarea1" name="task_description" placeholder="Notes (optional)"></textarea>

	</div>

	<div class="timesheet_task_hour timesheet_task_hour_worked">

	<label class="modal_label">Hours worked</label>

	<textarea class="modal_textarea2" name="task_hour" placeholder="00:00"></textarea>

	</div>

	<div class="timesheet_task_hour">

	<label class="modal_label">Hours Billable</label>

	<textarea class="modal_textarea2" name="task_hour_billable" placeholder="00:00"></textarea>

	</div>

	</div>

	<div class="button_1 save_add_button button_import">Add Entry</div>

	<input type="hidden" name="user_id" value="'.$user_id.'" />

	<input type="hidden" name="date_now" value="'.$date_now.'" />

	<input type="hidden" name="day_now" value="'.$day_now.'" />

	<input type="hidden" name="week_number" value="'.$week_number.'" />

	<input type="hidden" name="current_hour" value="'.$current_hour.'" />

	</fieldset>

	</form>

	';

	return $html;

}



/* ==================================== END TIMESHEET ADD TASK ==================================== */



/* ==================================== TIMESHEET SAVE ADD TASK ==================================== */

function save_add_task_timesheet($save_add_timesheet_task_data){	

	$save_add_timesheet_form_data = array();

	parse_str($save_add_timesheet_task_data, $save_add_timesheet_form_data);

	global $wpdb;

	$table_name = $wpdb->prefix . "custom_timesheet";

	$table_color = $wpdb->prefix . "custom_project_color";

	$colors = $wpdb->get_results("SELECT * FROM {$table_color}");	

	

	$task_name 						= $save_add_timesheet_form_data['task_name'];

	$date_now 						= $save_add_timesheet_form_data['date_now'];

	$day_now 						= $save_add_timesheet_form_data['day_now'];

	$week_number 					= $save_add_timesheet_form_data['week_number'];

	$task_hour_unformat 			= $save_add_timesheet_form_data['task_hour'];

	$task_hour_billable_unformat 	= $save_add_timesheet_form_data['task_hour_billable'];

	$task_label 					= $save_add_timesheet_form_data['task_label'];	

	$task_project_name 				= $save_add_timesheet_form_data['task_project_name'];

	$task_person 					= $save_add_timesheet_form_data['task_person'];

	$task_description 				= $save_add_timesheet_form_data['task_description'];

	$user_id 						= $save_add_timesheet_form_data['user_id'];

	

	$current_hour = $save_add_timesheet_form_data['current_hour'];

	$task_hour = time_format($task_hour_unformat);

	$task_hour_billable = time_format($task_hour_billable_unformat);

	$task_hour_decimal = decimalHours($task_hour);

	$task_hour_billable_decimal = decimalHours($task_hour_billable);

	$task_current_hour_decimal = decimalHours($current_hour);

	

	$sum = $task_current_hour_decimal + $task_hour_decimal;

	$total_hour =  gmdate('H:i', floor($sum * 3600));

	

	foreach($colors as $color){

		if($color->project_color == $task_color ){

			$task_category = $color->project_category;

		}

	}

	

	$insert = $wpdb->insert( $table_name , array( 

		'task_name' 			=> $task_name,

		'date_now' 				=> $date_now,

		'day_now' 				=> $day_now,

		'week_number' 			=> $week_number,		

		'task_hour' 			=> $task_hour,

		'task_hour_billable'	=> $task_hour_billable,

		'task_label' 			=> $task_label,

		'task_project_name' 	=> $task_project_name,		

		'task_person' 			=> $task_person,

		'task_description' 		=> $task_description,		

		'user_id' 				=> $user_id,

		'status' 				=> 1

	),	

	array( '%s', '%s' ));

	$submit_id = $wpdb->insert_id;	

	$save_add_timesheet_form_data['id'] = $submit_id;

	$save_add_timesheet_form_data['task_category'] = $task_category;

	$save_add_timesheet_form_data['total_hour'] = $total_hour;

	$save_add_timesheet_form_data['task_hour_format'] = time_format($task_hour);

	$save_add_timesheet_form_data['task_hour_billable_format'] = time_format($task_hour_billable);

	

	return $save_add_timesheet_form_data;

}

/* ==================================== END TIMESHEET SAVE ADD TASK ==================================== */



/* ====================================  ADD FILTER PROJECT TASK ==================================== */

function filter_project_client($client_id){

	global $wpdb;

	$table_projects = $wpdb->prefix . "custom_project";	
	$table_clients = $wpdb->prefix . "custom_client";
	$table_tasks = $wpdb->prefix . "custom_task";



	$projects = $wpdb->get_results("SELECT * FROM {$table_projects} WHERE project_client_id = ". $client_id." ORDER BY project_name");
	$client_info = $wpdb->get_row("SELECT client_name, client_default_task, client_default_project FROM {$table_clients} WHERE ID = ". $client_id);
	$tasks = $wpdb->get_results("SELECT * FROM {$table_tasks}");

	if(!empty($projects)){

		foreach($projects as $project){
			$selected =  ($project->ID == $client_info->client_default_project)? 'selected' : '';
			$project_html .= '<option value="'.$project->project_name.'" '.$selected.'>'.$project->project_name. '</option>';
		}

		$check_project = 'not_null';

	}else{

		$check_project = 'null';

	}

	foreach ($tasks as $task) {
		$selected  = ($client_info->client_default_task == $task->ID)? 'selected' : '';
		$tasks_html .= '<option '. $selected .' value="'.$task->task_name.'">'.$task->task_name. '</option>';
	}

	$result_array['check_project'] = $check_project;

	$result_array['client_name'] = $client_info->client_name;

	$result_array['client_id'] = $client_id;

	$result_array['tasks'] = $tasks_html;

	$result_array['project_name'] = $project_name;

	$result_array['projects'] = $project_html;
	

	return $result_array;

}

/* ====================================  END ADD FILTER PROJECT TASK ==================================== */



/* ====================================  ADD PROJECT TASK ==================================== */

function add_client_project_form($add_project_details){	

	global $wpdb;

	$table_name_project = $wpdb->prefix . "custom_project";

	$table_name_department = $wpdb->prefix . "custom_department";

	$table_name_person = $wpdb->prefix . "custom_person";

	$table_name_client = $wpdb->prefix . "custom_client";

	$departments = $wpdb->get_col("SELECT DISTINCT department_name FROM {$table_name_department}");

	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");

	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");

	$projects = $wpdb->get_results("SELECT DISTINCT project_name FROM {$table_name_project}");

	$add_project_details_explode = explode('_', $add_project_details);

	$client_id  = $add_project_details_explode[0];

	$client_name = $add_project_details_explode[1];	

	$project_name= $add_project_details_explode[2];

	foreach($clients as $client){
		if($client->client_name != $client_name){
			$client_option .= '<option value="'.$client->ID.'">'.$client->client_name.'</option>';
		}
	}

	

	foreach($projects as $project){

		$project_option .= '<option>'.$project->project_name.'</option>';

	}

	

	foreach ($persons as $person){

		$person_option .= '<option>'.$person->person_fullname.'</option>';

	}

	

	$current_status_array = array('Planned', 'In progress', 'Paused', 'Complete');

		

	foreach ($current_status_array as $current_status){

		$current_status_option .= '<option>'.$current_status.'</option>';

	}


	$html = '

	<form action="" method="post" name="project" id="submit_project_client">

		<div class="submit_section">

			<div class="submit_left">

				<label>Client</label>

				<select name="project_client">

					<option value="'.$client_id.'">'. $client_name .'</option>

					'. $client_option .'

				</select>

			</div>

			<div class="submit_right">

				<label>Project Name</label>

				<select name="project_name" class="project_name">

					'. $project_option .'

					<option>Other</option>

				</select>

			</div>

		</div>

		<div class="submit_section three_input">

			<div class="submit_left check_box_container">

				<label class="check_box_label">Billable</label>

				<input type="checkbox" name="project_billable" value="1" class="project_billable check_box" checked />

			</div>

			<div class="submit_middle">

				<label>Estimated Hours</label>

				<input type="text" name="project_estimated_hour" class="project_estimated_hour" /><p class="project_estimated_label">h</p>

				<input type="text" name="project_estimated_minute" class="project_estimated_minute" /><p class="project_estimated_label">m</p>

			</div>	

			<div style="display:none" class="submit_right add_peoject_name_section">

				<label>Add Project Name</label>

				<input type="text" name="add_project_name" class="add_project_name" />

				<div class="button_1 add_project_option">Add</div>

			</div>

		</div>

		<div class="submit_section">

			<div class="submit_left">

				<label>Start Date</label>

				<input type="text" name="project_start_date" class="project_start_date" />

			</div>

			<div class="submit_right">

				<label for="tape_backup_model">Estimated Deadline</label>

				<input type="text" name="project_estimated_deadline" class="project_estimated_deadline" />

			</div>

		</div>

		<div class="submit_section">

			<div class="submit_left">

				<label>Main consultant</label>

				<select class="project_main_consultant" name="project_main_consultant">'.$person_option.'</select>

			</div>

			<div class="submit_right">

				<label>Current Status</label>

				<select class="project_current_status" name="project_current_status">'.$current_status_option.'</select>

			</div>

		</div>		

		<div class="submit_section">

			<div class="submit_left">

				<label>Fixed price</label>

				<input type="text" name="project_fixed_price" class="project_fixed_price" />

			</div>

			<div class="submit_right">

				<label>Description</label>

				<textarea name="project_description" class="project_description textarea_medium"></textarea>

			</div>

		</div>

		<div class="save_project_buttons">

			<div class="button_2 cancel_add_project_client">Cancel</div>

			<div class="button_1 save_project_client">Save</div>

			<div style="display:none;" class="loader"></div>

		</div>

	</form>

	';

	return $html;

}


//Saving to DB the add new project to client.
function save_client_project($save_project_client){

	global $wpdb;

	$table_name = $wpdb->prefix . "custom_project";
	$table_client = $wpdb->prefix ."custom_client";
	$table_task = $wpdb->prefix ."custom_task";

	

	$save_form_data = array();

	parse_str($save_project_client, $save_form_data);

	$query = $wpdb->prepare("SELECT client_name, client_default_task FROM {$table_client} WHERE ID = %d", $save_form_data['project_client']);
	$tasks = $wpdb->get_results('SELECT * FROM '. $table_task);


	$client = $wpdb->get_row($query);


	$project_client					= (isset($save_form_data['project_client']) ? $save_form_data['project_client'] : '');

	$project_name					= (isset($save_form_data['project_name']) ? $save_form_data['project_name'] : '');

	$project_start_date				= (isset($save_form_data['project_start_date']) ? $save_form_data['project_start_date'] : '');

	$project_estimated_deadline		= (isset($save_form_data['project_estimated_deadline']) ? $save_form_data['project_estimated_deadline'] : '');

	$project_main_consultant		= (isset($save_form_data['project_main_consultant']) ? $save_form_data['project_main_consultant'] : '');

	$project_current_status			= (isset($save_form_data['project_current_status']) ? $save_form_data['project_current_status'] : '');

	$project_billable				= (isset($save_form_data['project_billable'])) ? $save_form_data['project_billable'] : 0;	

	if(isset($save_form_data['project_estimated_hour']) && isset($save_form_data['project_estimated_minute'])){

		$project_estimated_hours = $save_form_data['project_estimated_hour'] .'h'.' '. $save_form_data['project_estimated_minute'] .'m';

	}elseif(isset($save_form_data['project_estimated_hour']) && $save_form_data['project_estimated_minute'] == null){

		$project_estimated_hours = $save_form_data['project_estimated_hour'] .'h 0m';

	}elseif($save_form_data['project_estimated_hour'] == null && isset($save_form_data['project_estimated_minute'])){

		$project_estimated_hours = '0h'. $save_form_data['project_estimated_minute'] .'m';

	}

	$project_fixed_price			= (isset($save_form_data['project_fixed_price']) ? $save_form_data['project_fixed_price'] : '');

	$project_description			= (isset($save_form_data['project_description']) ? $save_form_data['project_description'] : '');



	$insert = $wpdb->insert( $table_name , array( 

	'project_client_id'				=> $project_client,

	'project_client'				=> $client->client_name,

	'project_name'					=> $project_name,

	'project_start_date'			=> $project_start_date,

	'project_estimated_deadline'	=> $project_estimated_deadline,

	'project_main_consultant'		=> $project_main_consultant,

	'project_current_status'		=> $project_current_status,

	'project_billable'				=> $project_billable,

	'project_estimated_hours'		=> $project_estimated_hours,

	'project_fixed_price'			=> $project_fixed_price,

	'project_description'			=> $project_description

	), array( '%s', '%s' ));


	if($insert == 1){

		$status = 1;

	}else{

		$status = 0;

	}

	$task_option = '';
	foreach($tasks as $task){
		$task_option .= "<option>".$task->task_name."</option>";
	}

	$status_array = array();

	$status_array['status'] = $status;

	$status_array['project_name'] = $project_name;

	$status_array['client_id'] = $project_client;

	$status_array['tasks'] = $task_option;

	return $status_array;

}

/* ====================================  END ADD PROJECT TASK ==================================== */



/* ==================================== TIMESHEET DELETE TASK ==================================== */

function confirm_delete_task($delete_form_details){	

	parse_str($delete_form_details, $delete_form_data);

	global $wpdb;

	$task_id = $delete_form_data['timesheet_task_id'];
	$current_hour = $delete_form_data['timesheet_task_current_hour'];
	$total_hours_worked = $delete_form_data['timesheet_task_total_hours_worked'];
	$hour_balance = $delete_form_data['timesheet_task_hour_balance'];
	$timesheet_delete_day = $delete_form_data['timesheet_delete_day'];
	$table_name = $wpdb->prefix . "custom_timesheet";
	$timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID ='$task_id'");

	$timesheet_week_number = $timesheet_data->week_number; 
	$task_hour = $timesheet_data->task_hour;
	$timesheet_person = $timesheet_data->task_person; 

	$task_hour_decimal = decimalHours($task_hour);
	$task_current_hour_decimal = decimalHours($current_hour);

	$difference = $task_current_hour_decimal - $task_hour_decimal;
	$total_hour =  gmdate('H:i', floor($difference * 3600));

	$wpdb->query( "DELETE FROM {$table_name} WHERE ID = '$task_id'" );

	$tasks_data[] = array(
		'task_id'	=> $task_id, 
		'task_hour'	=> $total_hour
	);

	$date_string = explode("/", $timesheet_data->date_now);
	$data_date = $date_string[1]."/".$date_string[2];
	$year = $date_string[2];
	$month = $date_string[1];

	if($data_date == date('m/Y')) {
		$date1 = $year."/".$month."/01";
		$date2 =  date('Y/m/d');
		$date_end_range = date("d/m/Y");
	} else {
		$date1 = $year."/".$month."/01";
		$date2 =  date('Y/m/d');
		$date_end_range = date("31/".$month."/".$month);		   
	}

	$updated_timesheet = $wpdb->get_row('SELECT 
			SUM(IF(task_name = "Semester", TIME_TO_SEC(task_hour)/3600, 0 )) as vacation, 
			SUM(IF(task_name = "Sjuk", TIME_TO_SEC(task_hour)/3600, 0 )) as sickness, 
			SUM(IF(task_name = "Ledig", TIME_TO_SEC(task_hour)/3600, 0 )) as ledig,
			SUM(IF(task_name = "Helg", TIME_TO_SEC(task_hour)/3600, 0 )) as holiday,  
			SUM(TIME_TO_SEC(task_hour)/3600) as totalhours 
			FROM '.TIMESHEET_TABLE.' 
			WHERE task_person = "'.$timesheet_data->task_person.' " 
			AND STR_TO_DATE(date_now, "%d/%m/%Y") BETWEEN STR_TO_DATE("01/'.$month.'/'.$year.'", "%d/%m/%Y") AND STR_TO_DATE("31/'.$month.'/'.$year.'", "%d/%m/%Y")'); 
	$week = getStartAndEndDate($timesheet_week_number, $year);

	$Tidbank_hours = $wpdb->get_row('SELECT ROUND(SUM(time_to_sec(t.task_hour) / (60 * 60)), 2) as tidbank_total_hrs FROM '.TIMESHEET_TABLE.' as t WHERE task_person = "'.$timesheet_data->task_person.'" AND STR_TO_DATE(date_now, "%d/%m/%Y") BETWEEN STR_TO_DATE("01/'.$month.'/'.$year.'", "%d/%m/%Y") AND STR_TO_DATE("31/'.$month.'/'.$year.'", "%d/%m/%Y") AND task_name = "Tidbank"');

	$current_date = $wpdb->get_row('SELECT 
			ROUND(SUM(time_to_sec(task_hour) / (60 * 60)), 2) as total_hours
			FROM '.TIMESHEET_TABLE.' 
			WHERE task_person = "'.$timesheet_data->task_person.'" AND date_now = "'.$date.'"');

	$current_date->total_hours = ($total_hours->total_hours < 0)? 0 : $current_date->total_hours;
	
	if($Tidbank_hours->tidbank_total_hrs <= 0){
		$tidbank_total_hrs = abs($Tidbank_hours->tidbank_total_hrs);
		$tid_bank_class= "";
	}else{
		$tidbank_total_hrs = "-".(string)$Tidbank_hours->tidbank_total_hrs;
		$tid_bank_class = 'red_text';
	}

	$dwork_filter = array(
		'person_name' => $timesheet_person,
		'date_start' => date('d/m/Y', strtotime($week[0])),
		'date_end' =>  date('d/m/Y', strtotime($week[1]))
	);	

	$dwork_percent = calculate_person_dwork($dwork_filter);

	$working_days = getWorkingDays($date1, $date2);
	$worked_hours = (($working_days * 8));
	$hour_balance = ((float)$updated_timesheet->totalhours - (float)$worked_hours);
	$hour_balance_color = ($hour_balance >= 0)? 'green' : 'red';		

	$total_hour_decimal_round = round($task_hour_decimal, 2);
	$total_month_hours_worked = $total_hours_worked - $total_hour_decimal_round;
	$total_month_hour_balance = $hour_balance - $total_hour_decimal_round;
	$tasks_data['side_panel_total_worked_hours'] = floatval(number_format($updated_timesheet->totalhours, 2));
	$tasks_data['side_panel_total_semester'] = floatval(number_format($updated_timesheet->vacation, 2));
	$tasks_data['side_panel_total_helg'] = floatval(number_format($updated_timesheet->holiday, 2));
	$tasks_data['side_panel_total_sjuk'] = floatval(number_format($updated_timesheet->sickness, 2));
	$tasks_data['side_panel_total_ledig'] = floatval(number_format($updated_timesheet->ledig, 2));
	$tasks_data['side_panel_total_workable_hours'] = floatval(number_format($worked_hours, 2));
	$tasks_data['side_panel_total_hour_balance'] = floatval(number_format($hour_balance, 2));
	$tasks_data['side_panel_total_hours_tidbank'] = floatval(number_format($tidbank_total_hrs, 2));
	$tasks_data['side_panel_tid_bank_class'] = $tid_bank_class;
	$tasks_data['side_panel_total_hour_balance_color'] = $hour_balance_color;
	$tasks_data['dwork_percent'] = $dwork_percent;
	$tasks_data['total_month_hours_worked'] = $total_month_hours_worked;
	$tasks_data['total_month_hour_balance'] = $total_month_hour_balance;
	$tasks_data['timesheet_delete_day'] = $timesheet_delete_day;

	return $tasks_data;
}

/* ==================================== END TIMESHEET DELETE TASK ==================================== */



/* ==================================== TIMESHEET DONE TODAY ==================================== */

function done_today_edit($data_id){	

	global $wpdb;

	$table_name = $wpdb->prefix . "custom_timesheet";

	$task = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID='$data_id'");	

	$task_done_today = unserialize($task->task_done_today);

	$task_hour = $task->task_hour;

	$array_count = count($task_done_today);

	$task_exist = "";

	$counter = 1;

	if($task_done_today != null){

		foreach($task_done_today as $done_today_task){	

			if($counter == $array_count){

				$last_class = 'done_today_last';

			}

			$done_today_task_explode = explode('_', $done_today_task);

			$task_done_today_description = $done_today_task_explode[0];

			$task_done_today_hours = $done_today_task_explode[1];

			$task_exist .= '

			<li class="done_today_list '. $last_class .'" id="done_today_'. $counter .'">

			<div class="full_width">		

			<input type="hidden" id="hidden_list_'. $counter .'" name="submit_done_today[]" value="'. $task_done_today_description .'_' .$task_done_today_hours. '"/>		

			<div class="one_half"><p class="task_done_today_description">'. $task_done_today_description .'</p></div>

			<div class="one_fourth"><p class="task_done_today_hours">'. $task_done_today_hours .'</p></div>

			<div class="one_fourth last">

			<div id="done_today_edit_'. $counter .'" class="done_today_edit button_2 done_today_action_button">E</div>

			<div id="done_today_delete_'. $counter .'" class="confirm done_today_delete button_2 done_today_action_button">D</div>

			</div>

			</div>

			</li>

			<div class="edit_div" id="edit_div_'. $counter .'" style="display:none;">

			<div class="full_width">		

			<div class="one_half"><textarea type="text" id="done_today_description_edit_area_'. $counter .'" class="done_today_edit_area" /></textarea></div>

			<div class="one_fourth"><textarea type="text" id="done_today_task_hour_edit_area_'. $counter .'" class="done_today_edit_area" /></textarea></div>		

			<div class="one_fourth last">

			<div id="check_edit_'. $counter .'" class="check_edit"></div>

			</div>

			</div>

			</div>

			';

			$counter++;

		}

	}

	$html ='

	<form id="done_today_form">

	<input type="hidden" name="task_id" class="task_id" value="'. $data_id .'" />	

	<h3 class="task_hour">Task Hour: '. $task_hour .'</h3>

	<div class="full_width">

	<div class="done_today_task_container">

	'. $task_exist .'

	</div>

	<div class="one_half">

	<textarea class="task_done_today_description" name="task_done_today_description" placeholder="Notes (optional)"></textarea>

	</div>

	<div class="one_fourth">

	<textarea class="task_done_today_hours" name="task_done_today_hours" placeholder="0:00"></textarea>

	</div>

	<div class="one_fourth last">

	<div class="add_more_done_today button_2">Add More</div>

	</div>

	</div>

	<div class="button_1 add_task_done_today">Add</div>

	<div style="display: none;" class="loader"></div>

	</form>

	';

	

	return $html;

}



function task_done_today_save($done_today_form){

	global $wpdb;

	$table_name = $wpdb->prefix . "custom_timesheet";

	$save_add_done_today_form_data = array();

	parse_str($done_today_form, $save_add_done_today_form_data);

	$task_id = $save_add_done_today_form_data['task_id'];	

	$tasks_hour = $save_add_done_today_form_data['submit_done_today'];

	$task_hour_format_array = array();

	foreach($tasks_hour as $task_hour){

		$task_hour_explode = explode('_', $task_hour);

		$task = $task_hour_explode[0];

		$hour = $task_hour_explode[1];

		$format_hour = time_format($hour);	

		$task_hour_format_array[] = $task ."_". $format_hour ."_". $task_id;

	}

	

	$serialize = serialize($task_hour_format_array);

	

	$update = $wpdb->update( $table_name , array( 

	'task_done_today'			=> $serialize

	),

	array( 'ID' => $task_id ),

	array( '%s', '%s' ));	



}

/* ==================================== END TIMESHEET DONE TODAY ==================================== */



/* ==================================== STAFF TIMESHEET ==================================== */

function staff_timesheet($staff_timesheet_data){

	global $wpdb;

	$staff_timesheet_data_explode = explode('_', $staff_timesheet_data);
	$current_user = wp_get_current_user();
	$current_user_name = $current_user->data->display_name;

	$person_name = ($staff_timesheet_data_explode[0] != 'null' ? $staff_timesheet_data_explode[0] : $current_user_name);
	$week_number = $staff_timesheet_data_explode[1];
	$picked_year = $staff_timesheet_data_explode[2];	
	$picked_month = $staff_timesheet_data_explode[3];
	$start_date = $staff_timesheet_data_explode[4];
	$end_date = $staff_timesheet_data_explode[5];

	$table_name = $wpdb->prefix . "custom_timesheet"; 
	$table_name_person = $wpdb->prefix . "custom_person";
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person} WHERE person_fullname ='$person_name'");	

	$year = date('Y');
	$month_number = date('m');
	$week = getStartAndEndDate($week_number, $year);

	if($person_name == $current_user_name){
		$check_same_user = 'yes';
	}

	$timesheet_month_details = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_person = '$person_name' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$picked_month/$picked_year', '%d/%m/%Y') AND STR_TO_DATE('31/$picked_month/$picked_year', '%d/%m/%Y')");

	$timesheet_month_stats = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_person = '$person_name' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$month_number/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$month_number/$year', '%d/%m/%Y')"); 

	foreach($persons as $person){
		$person_hour_per_day = $person->person_hours_per_day;
	}	

	if($person_hour_per_day != null ){
		$hour_per_day = $person_hour_per_day;
	}else{
		$hour_per_day = 8;
	}

	$holiday_date = array();

	foreach($timesheet_month_stats as $timesheet_month_stat){
		$task_name = format_task_name($timesheet_month_stat->task_name);
		if($task_name == 'Holiday'){
			$date = date('Y/m/d', strtotime($timesheet_month_stat->date_now));
			$holiday_date[] = $date;
		}
	}

	$holiday_count = count($holiday_date);
	$holiday_hours = $holiday_count * $hour_per_day;
	$date1 = "$year/$month_number/01";
	$date2 =  date('Y/m/d');
	$working_days = getWorkingDays($date1, $date2);
	$worked_hours = ($working_days * $hour_per_day) - $holiday_hours;

	$total_month_hours = 0;

	foreach($timesheet_month_stats as $timesheet_month_stat){
		$task_name = format_task_name($timesheet_month_stat->task_name);
		if($task_name != 'Holiday'){			
			$task_hour 			= $timesheet_month_stat->task_hour;
			$task_hour_decimal 	= round(decimalHours($task_hour),2);
			$total_month_hours	+= $task_hour_decimal;
		}					
	}

	$total_hours_worked = $total_month_hours;
	$hour_balance = ($total_hours_worked - $worked_hours);
	$month_total_hour_decimal = 0;
	$total_holiday_hour = 0;

	foreach($timesheet_month_details as $timesheet_month_detail){
		$task_hour 						= $timesheet_month_detail->task_hour;
		$task_hour_decimal 				= decimalHours($task_hour);
		$month_total_hour_decimal		+= $task_hour_decimal;
		$task_name						= format_task_name($timesheet_month_detail->task_name);
		
		if($task_name == 'Holiday'){
			if($timesheet_month_detail->task_hour != null){
				$task_hour = $timesheet_month_detail->task_hour;
				$holiday_hour 	= decimalHours($task_hour);
			}else{
				$holiday_hour = 8;			
			}
			$total_holiday_hour += $holiday_hour;
		}
	}

	$total_month_hour =  gmdate('H:i', floor($month_total_hour_decimal * 3600));

	foreach($timesheet_month_details as $timesheet_month_detail){
		$task_name = format_task_name($timesheet_month_detail->task_name);				
		if($task_name == 'Holiday Work'){
			$holiday_work_date = $timesheet_month_detail->date_now;
			$holiday_work_details = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_person = '$person_name' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$month_number/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$month_number/$year', '%d/%m/%Y') AND date_now ='$holiday_work_date'"); 
			$holiday_work_hours = 0;
			foreach ($holiday_work_details as $holiday_work_detail){
				$task_hour = $holiday_work_detail->task_hour;
				$task_hour_decimal 	= round(decimalHours($task_hour), 2);
				$holiday_work_hours	+= $task_hour_decimal;
			}
		}					
	}

	if($holiday_work_hours != null){
		$total_holiday_work = $holiday_work_hours;
		}else{
		$total_holiday_work = 0;
	}

	$timesheet_details = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_person = '$person_name' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$start_date', '%d/%m/%Y') AND STR_TO_DATE('$end_date', '%d/%m/%Y') AND week_number = $week_number");	

	$monday_total_hour_decimal = 0;
	foreach($timesheet_details as $timesheet_detail){
		if(strtolower($timesheet_detail->day_now) == 'monday'){
			$task_hour 						= $timesheet_detail->task_hour;
			$task_hour_decimal 				= decimalHours($task_hour);
			$monday_total_hour_decimal		+= $task_hour_decimal;
			$edit_time_string = date('h:i A', strtotime(substr($timesheet_detail->edited_by, -5)));
			$edited_by = substr($timesheet_detail->edited_by, 0, -5 ) . " " .$edit_time_string;
		}
	}	

	$total_hour_monday =  gmdate('H:i', floor($monday_total_hour_decimal * 3600));

	$tuesday_total_hour_decimal = 0;
	foreach($timesheet_details as $timesheet_detail){
		if(strtolower($timesheet_detail->day_now) == 'tuesday'){
			$task_hour 						= $timesheet_detail->task_hour;
			$task_hour_decimal 				= decimalHours($task_hour);
			$tuesday_total_hour_decimal		+= $task_hour_decimal;
			$edit_time_string = date('h:i A', strtotime(substr($timesheet_detail->edited_by, -5)));
			$edited_by = substr($timesheet_detail->edited_by, 0, -5 ) . " " .$edit_time_string;
		}
	}	

	$total_hour_tuesday =  gmdate('H:i', floor($tuesday_total_hour_decimal * 3600));

	$wednesday_total_hour_decimal = 0;
	foreach($timesheet_details as $timesheet_detail){
		if(strtolower($timesheet_detail->day_now) == 'wednesday'){
			$task_hour 						= $timesheet_detail->task_hour;
			$task_hour_decimal 				= decimalHours($task_hour);
			$wednesday_total_hour_decimal	+= $task_hour_decimal;
			$edit_time_string = date('h:i A', strtotime(substr($timesheet_detail->edited_by, -5)));
			$edited_by = substr($timesheet_detail->edited_by, 0, -5 ) . " " .$edit_time_string;
		}
	}	

	$total_hour_wednesday =  gmdate('H:i', floor($wednesday_total_hour_decimal * 3600));

	$thursday_total_hour_decimal = 0;
	foreach($timesheet_details as $timesheet_detail){
		if(strtolower($timesheet_detail->day_now) == 'thursday'){
			$task_hour 						= $timesheet_detail->task_hour;
			$task_hour_decimal 				= decimalHours($task_hour);
			$thursday_total_hour_decimal	+= $task_hour_decimal;
			$edit_time_string = date('h:i A', strtotime(substr($timesheet_detail->edited_by, -5)));
			$edited_by = substr($timesheet_detail->edited_by, 0, -5 ) . " " .$edit_time_string;
		}
	}	

	$total_hour_thursday =  gmdate('H:i', floor($thursday_total_hour_decimal * 3600));

	$friday_total_hour_decimal = 0;
	foreach($timesheet_details as $timesheet_detail){
		if(strtolower($timesheet_detail->day_now) == 'friday'){
			$task_hour 						= $timesheet_detail->task_hour;
			$task_hour_decimal 				= decimalHours($task_hour);
			$friday_total_hour_decimal		+= $task_hour_decimal;
			$edit_time_string = date('h:i A', strtotime(substr($timesheet_detail->edited_by, -5)));
			$edited_by = substr($timesheet_detail->edited_by, 0, -5 ) . " " .$edit_time_string;
		}
	}	

	$total_hour_friday =  gmdate('H:i', floor($friday_total_hour_decimal * 3600));

	$saturday_total_hour_decimal = 0;
	foreach($timesheet_details as $timesheet_detail){
		if(strtolower($timesheet_detail->day_now) == 'saturday'){
			$task_hour 						= $timesheet_detail->task_hour;
			$task_hour_decimal 				= decimalHours($task_hour);
			$saturday_total_hour_decimal	+= $task_hour_decimal;
			$edit_time_string = date('h:i A', strtotime(substr($timesheet_detail->edited_by, -5)));
			$edited_by = substr($timesheet_detail->edited_by, 0, -5 ) . " " .$edit_time_string;
		}
	}	

	$total_hour_saturday =  gmdate('H:i', floor($saturday_total_hour_decimal * 3600));

	$sunday_total_hour_decimal = 0;
	foreach($timesheet_details as $timesheet_detail){
		if(strtolower($timesheet_detail->day_now) == 'sunday'){
			$task_hour 						= $timesheet_detail->task_hour;
			$task_hour_decimal 				= decimalHours($task_hour);
			$sunday_total_hour_decimal		+= $task_hour_decimal;
			$edit_time_string = date('h:i A', strtotime(substr($timesheet_detail->edited_by, -5)));
			$edited_by = substr($timesheet_detail->edited_by, 0, -5 ) . " " .$edit_time_string;
		}
	}	

	$total_hour_sunday =  gmdate('H:i', floor($sunday_total_hour_decimal * 3600));
	$month_name = date("F", strtotime($picked_month));

	$dwork_filter = array(
		'person_name' => $person_name,
		'date_start' => $start_date,
		'date_end' =>  $end_date
	);

	$nonworked_filter = array(
		'person_name' =>$person_name,
		'month' => $picked_month,
		'year' => $year
	);	

	$person_dwork = calculate_person_dwork($dwork_filter);
	$total_no_work_hours_tasks = GetPersonNoneWorkTasksCurrentMonth($nonworked_filter);

	$Tidbank_hours = $wpdb->get_row('SELECT ROUND(SUM(time_to_sec(t.task_hour) / (60 * 60)), 2) as tidbank_total_hrs FROM '.TIMESHEET_TABLE.' as t WHERE task_person = "'.$person->person_fullname.'" AND STR_TO_DATE(date_now, "%d/%m/%Y") BETWEEN STR_TO_DATE("01/'.$picked_month.'/'.$year.'", "%d/%m/%Y") AND STR_TO_DATE("31/'.$picked_month.'/'.$year.'", "%d/%m/%Y") AND task_name = "Tidbank"');

	if($Tidbank_hours->tidbank_total_hrs <= 0){
		$tidbank_total_hrs = abs($Tidbank_hours->tidbank_total_hrs);
		$tid_bank_class= "";
	}else{
		$tidbank_total_hrs = "-".(string)$Tidbank_hours->tidbank_total_hrs;
		$tid_bank_class = 'red_text';
	}
	
	$rounded_total_month_hour = round($month_total_hour_decimal, 2);
	$timesheet_details['person_dwork'] = $person_dwork;
	$timesheet_details['check_same_user'] = $check_same_user;
	$timesheet_details['total_holiday_work'] = $total_holiday_work;
	$timesheet_details['worked_hours'] = $worked_hours;
	$timesheet_details['total_hours_worked'] = $total_hours_worked;
	$timesheet_details['hour_balance'] = round($hour_balance, 2);
	$timesheet_details['holiday_hours'] = $holiday_hours;
	$timesheet_details['month_name'] = $month_name;
	$timesheet_details['year_name'] = $picked_year;

	$timesheet_details['ledig_hours'] = floatval(number_format($total_no_work_hours_tasks->ledig_hours, 2));
	$timesheet_details['holiday_hours'] = floatval(number_format($total_no_work_hours_tasks->holiday_hours, 2));
	$timesheet_details['vacation_hours'] = floatval(number_format($total_no_work_hours_tasks->vacation_hours, 2));
	$timesheet_details['sick_hours'] = floatval(number_format($total_no_work_hours_tasks->sick_hours, 2));
	$timesheet_details['tidbank_hours'] = floatval(number_format($tidbank_total_hrs, 2));
	$timesheet_details['tidbank_class'] = $tid_bank_class;

	$timesheet_details['total_holiday_hour'] = $total_holiday_hour;
	$timesheet_details['rounded_total_month_hour'] = $rounded_total_month_hour;
	$timesheet_details['total_month_hour'] = $total_month_hour;
	$timesheet_details['total_hour_monday'] = $total_hour_monday;
	$timesheet_details['total_hour_tuesday'] = $total_hour_tuesday;
	$timesheet_details['total_hour_wednesday'] = $total_hour_wednesday;
	$timesheet_details['total_hour_thursday'] = $total_hour_thursday;
	$timesheet_details['total_hour_friday'] = $total_hour_friday;
	$timesheet_details['total_hour_saturday'] = $total_hour_saturday;
	$timesheet_details['total_hour_sunday'] = $total_hour_sunday;
	$timesheet_details['person_name'] = $person_name;
	$timesheet_details['week_start'] = $start_date;
	$timesheet_details['week_end'] = $end_date;
	$timesheet_details['edited_by'] = $edited_by;
	$timesheet_details['hour_per_day'] = $hour_per_day;

	return $timesheet_details;
}

/* ==================================== END STAFF TIMESHEET ==================================== */



/* ==================================== GET ALL TASKNAME TIMESHEET ==================================== */

function get_add_new_row($new_entry_info){

	global $wpdb;

	extract($new_entry_info);

	//Get All Tasknames

	$index_num = $index_num + 1;

	$table_name_task = $wpdb->prefix . "custom_task";

	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");

	$dropdown_taskname = "<li class='data_list_". $entry_day . " new_entry_client_".$index_num." data_taskname_entry' id='new_entry_taskname_".$index_num."'><select>";

	foreach($tasks as $task){

		$dropdown_taskname .= "<option value='" . $task->task_name . "'>" . $task->task_name . "</option>";

	}
	$dropdown_taskname .= "</select></li>";

	// Get All Client
	$table_name_client = $wpdb->prefix . "custom_client"; 

	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");

	$dropdown_client_name = "<li class='data_list_". $entry_day . " data_client_entry new_entry_client_".$index_num."' id='new_entry_client_".$index_num."'><select>";	

	foreach($clients as $client){
		$dropdown_client_name .= "<option value='" . $client->client_name . "'>" . $client->client_name . "</option>";
	}

	$dropdown_client_name .= "</select></li>";

	// Get Client Projects

	$table_name_project = $wpdb->prefix . "custom_project";

	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project} WHERE project_client = '{$clients[0]->client_name}'");

	$dropdown_projects = "<li class='data_list_". $entry_day . " data_project_entry' id='new_entry_project_".$index_num."'><select>";

	foreach($projects as $project){

		$dropdown_projects .= "<option value='" . $project->project_name . "'>" . $project->project_name . "</option>";

	}

	$dropdown_projects .= "</select></li>";	


	// //Get task person

	// $table_users = $wpdb->prefix . "custom_person";

	// $current_user = wp_get_current_user();
	// $users = $wpdb->get_results("SELECT * FROM {$table_users}");

	// $dropdown_users = "<li id='new_task_person' class='data_list_". $day . "'><select>";

	// $dropdown_users .= "<option>" . $current_user->data->display_name . "</option>";
	// foreach($users as $user){
	// 	$dropdown_users .= "<option value='" . $user->person_fullname . "'>" . $user->person_fullname . "</option>";
	// }

	// $dropdown_users .= "</select></li>";	


	return $dropdown_html = array(
			'tasknames' => $dropdown_taskname,
			'clients' => $dropdown_client_name,
			'projects' => $dropdown_projects,
			'index' => $index_num
		);

}

function get_client_projects($client){

	global $wpdb;

	$table_name_project = $wpdb->prefix . "custom_project";

	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project} WHERE project_client = '{$client}'");

	$dropdown_projects = "";

	foreach($projects as $project){

		$dropdown_projects .= "<option value='" . $project->project_name . "'>" . $project->project_name . "</option>";

	}



	return $dropdown_projects;

}

function save_timesheet_entry($entry){
	global $wpdb;
	extract($entry);

	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_client = $wpdb->prefix . "custom_client";
	$table_person = $wpdb->prefix . "custom_person";

	$query = $wpdb->prepare("SELECT * FROM {$table_person} WHERE person_fullname = %s", $username);

	$person = $wpdb->get_row($query);

	$query = $wpdb->prepare("SELECT client_name FROM {$table_client} WHERE ID = %d", $client_id);

	$client = $wpdb->get_row($query);

	$date_string = explode("/", $date);
	$data_date = $date_string[1]."/".$date_string[2];
	$year = $date_string[2];
	$month = $date_string[1];

	if($data_date == date('m/Y')) {
		$date1 = $year."/".$month."/01";
		$date2 =  date('Y/m/d');
		$date_end_range = date("d/m/Y");
	} else {
		$date1 = $year."/".$month."/01";
		$date2 =  date('Y/m/d');
		$date_end_range = date("31/".$month."/".$month);		   
	}

	$negative_value_string = ($negative_value == 1)? "-" : "";

	$insert = $wpdb->insert( $table_name , array( 
		'task_name' 			=> $taskname,
		'date_now' 				=> $date,
		'day_now' 				=> $active_day,
		'week_number' 			=> $week_number,		
		'task_hour' 			=> $negative_value_string . $hour,
		'task_hour_billable'	=> '',
		'task_label' 			=> $client->client_name,
		'task_project_name' 	=> $project,		
		'task_person' 			=> $person->person_fullname,
		'task_description' 		=> $description,		
		'user_id' 				=> $person->ID,
		'orderno'				=> $ordernumber,
		'km'					=> $kilometer,
		'status' 				=> 1
	),
	array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%d' ));

	if($insert == 1){

		$updated_timesheet = $wpdb->get_row('SELECT 
				ROUND(SUM(time_to_sec(task_hour) / (60 * 60)), 2) as total_hours,
				SUM(IF(task_name = "Semester", TIME_TO_SEC(task_hour)/3600, 0 )) as vacation, 
				SUM(IF(task_name = "Helg", TIME_TO_SEC(task_hour)/3600, 0 )) as helg, 
				SUM(IF(task_name = "Sjuk", TIME_TO_SEC(task_hour)/3600, 0 )) as sickness, 
				SUM(IF(task_name = "Ledig", TIME_TO_SEC(task_hour)/3600, 0 )) as ledig, 
				SUM(TIME_TO_SEC(task_hour)/3600) as totalhours FROM '.TIMESHEET_TABLE.' 
				WHERE task_person = "'.$person->person_fullname.' " AND STR_TO_DATE(date_now, "%d/%m/%Y") BETWEEN STR_TO_DATE("01/'.$month.'/'.$year.'", "%d/%m/%Y") AND STR_TO_DATE("31/'.$month.'/'.$year.'", "%d/%m/%Y")');
		$Tidbank_hours = $wpdb->get_row('SELECT ROUND(SUM(time_to_sec(t.task_hour) / (60 * 60)), 2) as tidbank_total_hrs FROM '.TIMESHEET_TABLE.' as t WHERE task_person = "'.$person->person_fullname.'" AND STR_TO_DATE(date_now, "%d/%m/%Y") BETWEEN STR_TO_DATE("01/'.$month.'/'.$year.'", "%d/%m/%Y") AND STR_TO_DATE("31/'.$month.'/'.$year.'", "%d/%m/%Y") AND task_name = "Tidbank"');

		$current_date = $wpdb->get_row('SELECT 
				ROUND(SUM(time_to_sec(task_hour) / (60 * 60)), 2) as total_hours
				FROM '.TIMESHEET_TABLE.' 
				WHERE task_person = "'.$person->person_fullname.'" AND date_now = "'.$date.'"');

		$current_date->total_hours = ($total_hours->total_hours < 0)? 0 : $current_date->total_hours;
		
		if($Tidbank_hours->tidbank_total_hrs <= 0){
			$tidbank_total_hrs = abs($Tidbank_hours->tidbank_total_hrs);
			$tid_bank_class= "";
		}else{
			$tidbank_total_hrs = "-".(string)$Tidbank_hours->tidbank_total_hrs;
			$tid_bank_class = 'red_text';
		}

		$week = getStartAndEndDate($week_number, $year);

		$dwork_filter = array(
			'person_name' => $person->person_fullname,
			'date_start' => date('d/m/Y', strtotime($week[0])),
			'date_end' =>  date('d/m/Y', strtotime($week[1]))
		);	

		$dwork_percent = calculate_person_dwork($dwork_filter);

		$working_days = getWorkingDays($date1, $date2);
		$worked_hours = (($working_days * 8));
		$hour_balance = ((float)$updated_timesheet->totalhours - (float)$worked_hours);
		$hour_balance_color = ($hour_balance >= 0)? 'green' : 'red';		

		$submit_id = $wpdb->insert_id;	
		$save_add_timesheet_form_data['id'] = $submit_id;
		$save_add_timesheet_form_data['task_category'] = '';
		$save_add_timesheet_form_data['task_name'] = $taskname;
		$save_add_timesheet_form_data['task_hour_format'] = $negative_value_string . $hour;
		$save_add_timesheet_form_data['task_project_name'] = $project;
		$save_add_timesheet_form_data['task_label'] = $client->client_name;
		$save_add_timesheet_form_data['task_person'] = $person->person_fullname;
		$save_add_timesheet_form_data['task_description'] = $description;
		$save_add_timesheet_form_data['task_orderno'] = $ordernumber;
		$save_add_timesheet_form_data['task_kilometer'] = $kilometer;
		$save_add_timesheet_form_data['worked_hours'] = $worked_hours;
		$save_add_timesheet_form_data['day_total_work_hours'] = ConvertDecimalTOTimeFormat($current_date->total_hours);
		$save_add_timesheet_form_data['side_panel_total_worked_hours'] = floatval(number_format(($updated_timesheet->totalhours > 0)? $updated_timesheet->totalhours : 0, 2));
		$save_add_timesheet_form_data['side_panel_total_semester'] = floatval(number_format($updated_timesheet->vacation, 2));
		$save_add_timesheet_form_data['side_panel_total_sjuk'] = floatval(number_format($updated_timesheet->sickness, 2));
		$save_add_timesheet_form_data['side_panel_total_helg'] = floatval(number_format($updated_timesheet->helg, 2));
		$save_add_timesheet_form_data['side_panel_total_ledig'] = floatval(number_format($updated_timesheet->ledig, 2));
		$save_add_timesheet_form_data['side_panel_total_workable_hours'] = floatval(number_format($worked_hours, 2));
		$save_add_timesheet_form_data['side_panel_total_hour_balance'] = floatval(number_format($hour_balance, 2));
		$save_add_timesheet_form_data['side_panel_total_hour_balance_color'] = $hour_balance_color;
		$save_add_timesheet_form_data['side_panel_total_hours_tidbank'] = floatval(number_format($tidbank_total_hrs, 2));
		$save_add_timesheet_form_data['side_panel_tid_bank_class'] = $tid_bank_class;
		$save_add_timesheet_form_data['dwork_percent'] = $dwork_percent;
		return $save_add_timesheet_form_data;
	}else{
		print_r('SAVING TIMESHEET ERROR!');
		die();
	}
}

//function for updating or editing for hour and description.
function update_entry_column($update_entries){
	global $wpdb;
	extract($update_entries);

	$current_user = wp_get_current_user();

	$table_name = $wpdb->prefix . "custom_timesheet";

	if($input_type == 'hour'){
		$field_name = 'task_hour';
	}else if($input_type == 'description'){
		$field_name = 'task_description';
	}else if($input_type == 'orderno'){
		$field_name = 'orderno';
	}else if($input_type == 'kilometer'){
		$field_name = 'km';
	}

	$edited_by = $current_user->display_name . ' - ' . date("Y-m-d H:i");

	$check_value = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = ".$input_id);

	if((string)$check_value->task_hour == (string)$input_value){
		$response = array(
			'id' => $input_id,
			'value' => $input_value,
			'type' => $field_name,
			'status' => 'success-update'
		);
	}else{
		//Updating to DB.
		$update_status = $wpdb->update( 
			$table_name, 
			array( 
				$field_name => $input_value,
				'edited_by' => $edited_by
			), 
			array( 'ID' => $input_id ), 
			array( 
				'%s'
			)
		);

		if($update_status == 1){

			$edit_time_string = date('h:i A', strtotime(substr($edited_by, -5)));
			$edited_by = substr($edited_by, 0, -5 ) . " " .$edit_time_string;

			$date_string = explode("/", $check_value->date_now);
			$data_date = $date_string[1]."/".$date_string[2];
			$year = $date_string[2];
			$month = $date_string[1];

			if($data_date == date('m/Y')) {
				$date1 = $year."/".$month."/01";
				$date2 =  date('Y/m/d');
				$date_end_range = date("d/m/Y");
			} else {
				$date1 = $year."/".$month."/01";
				$date2 =  date('Y/m/d');
				$date_end_range = date("31/".$month."/".$month);		   
			}

			$updated_timesheet = $wpdb->get_row('SELECT SUM(IF(task_name = "Semester", TIME_TO_SEC(task_hour)/3600, 0 )) as vacation, SUM(IF(task_name = "Sjuk", TIME_TO_SEC(task_hour)/3600, 0 )) as sickness, SUM(IF(task_name = "Helg", TIME_TO_SEC(task_hour)/3600, 0 )) as holiday, SUM(IF(task_name = "Ledig", TIME_TO_SEC(task_hour)/3600, 0 )) as ledig, SUM(TIME_TO_SEC(task_hour)/3600) as totalhours FROM '.TIMESHEET_TABLE.' WHERE task_person = "'.$check_value->task_person.' " AND STR_TO_DATE(date_now, "%d/%m/%Y") BETWEEN STR_TO_DATE("01/'.$month.'/'.$year.'", "%d/%m/%Y") AND STR_TO_DATE("'.$date_end_range.'", "%d/%m/%Y")');

			$working_days = getWorkingDays($date1, $date2);
			$worked_hours = (($working_days * 8));
			$hour_balance = ((float)$updated_timesheet->totalhours - (float)$worked_hours);
			$hour_balance_color = ($hour_balance >= 0)? 'green' : 'red';		

			$response = array(
				'id' => $input_id,
				'value' => $input_value,
				'type' => $field_name,
				'edited_by' => $edited_by,
				'status' => 'success-update',
				'side_panel_total_worked_hours' => floatval(number_format($updated_timesheet->totalhours, 2)),
				'side_panel_total_workable_hours' => floatval(number_format($worked_hours, 2)),
				'side_panel_total_sjuk' => floatval(number_format($updated_timesheet->sickness, 2)),
				'side_panel_total_hour_balance' => floatval(number_format($hour_balance, 2)),
				'side_panel_total_ledig' => floatval(number_format($updated_timesheet->ledig, 2)),
				'side_panel_total_semester' => floatval(number_format($updated_timesheet->vacation, 2)),
				'side_panel_total_helg' => floatval(number_format($updated_timesheet->holiday, 2)),
				'side_panel_total_hour_balance_color' => $hour_balance_color
			);

		}else{
			$response = array(
				'status' => 'failed-update'
			);		
		}		
	}
	return $response;
}
//Edit function for project editing on timesheet.
function EditProjectTimeSheet($entry){
	global $wpdb;
	extract($entry);
	$table_client_name =  $wpdb->prefix . 'custom_client';
	$table_project_name = $wpdb->prefix . 'custom_project';
	$dropdown_html = '';

	//Get client ID and NAME from client table DB
	$client_info = $wpdb->get_row("SELECT ID, client_name FROM " . $table_client_name . " WHERE client_name = '" . $client_name . "'");
	//Get all projects related to client.
	$projects = $wpdb->get_results("SELECT project_name FROM " . $table_project_name . " WHERE project_client_id = '" . $client_info->ID . "'");

	//Build the select option for project
	$dropdown_html = '<select>';
	foreach($projects as $project){
		$select = ($project_current_selected == $project->project_name)? 'selected' : '';
		$dropdown_html .= '<option '.$select.'>'.$project->project_name.'</option>';
	}
	$dropdown_html .= '</select><div id="project_button_'.$id.'" class="check_update_timesheet_project"></div>
<div id="project_loader_'.$id.'" class="row-update-loader-project" style="display: none;"></div>';

	$response = array(
		'option_dropdown' => $dropdown_html
	);
	return $response;
}


//Save editing taskname to DB.
function EditTaskNameTimeSheet($entry){
	global $wpdb;
	extract($entry);
	$table_client_name =  $wpdb->prefix . 'custom_client';
	$table_task_name = $wpdb->prefix . 'custom_task';
	$dropdown_html = '';
	$tasknames =  $wpdb->get_results("SELECT task_name FROM " . $table_task_name);
	$client_default_task = $wpdb->get_row("SELECT client_default_task FROM {$table_client_name} WHERE client_name ='". str_replace("&amp;","&",$client_name)."'");

	//Build the select option for project
	$dropdown_html = '<select>';
	foreach($tasknames as $taskname){
		// $select = ($taskname_current_selected == $taskname->task_name)? 'selected' : '';
		$select = ($client_default_task->client_default_task = $taskname->ID)? 'selected' : '';
		$dropdown_html .= '<option '.$select.'>'.$taskname->task_name.'</option>';
	}
	$dropdown_html .= '</select><div id="taskname_button_'.$id.'" class="check_update_timesheet_taskname"></div>
<div id="taskname_loader_'.$id.'" class="row-update-loader-taskname" style="display: none;"></div>';

	$response = array(
		'option_dropdown' => $dropdown_html
	);

	return $response;
}
//Save editing Taskname to DB.
function UpdateTaskNameOnClient($entry){
	global $wpdb;
	extract($entry);
	$table_timesheet_name = $wpdb->prefix . 'custom_timesheet';
	$current_user = wp_get_current_user();

	$edited_by = $current_user->display_name . ' - ' . date("Y-m-d H:i");
	$check_value = $wpdb->get_row("SELECT task_name FROM {$table_timesheet_name} WHERE ID = ".$taskname_id);

	if((string)$check_value->task_name == (string)$taskname){
		$response = array(
			'taskname_id' => $taskname_id,
			'taskname' => $taskname,
			'status' => 'success-update-timesheet'
		);
	}else{
		//Updating to DB.
		$update_status = $wpdb->update( 
			$table_timesheet_name, 
			array(
				'task_name' => $taskname,
				'edited_by' => $edited_by
			), 
			array( 'ID' => $taskname_id ), 
			array( 
				'%s'
			)
		);
		if($update_status == 1){

			$edit_time_string = date('h:i A', strtotime(substr($edited_by, -5)));
			$edited_by = substr($edited_by, 0, -5 ) . " " .$edit_time_string;

			$response = array(
				'taskname_id' => $taskname_id,
				'taskname_name' => $taskname,
				'edited_by' => $edited_by,
				'status' => 'success-update-timesheet'
			);
		}else{
			$response = array(
				'status' => 'failed-update-timesheet'
			);		
		}	
	}
	return $response;
}

//Save editing project to DB.
function UpdateProjectNameOnClient($entry){
	global $wpdb;
	extract($entry);
	$current_user = wp_get_current_user();
	$table_timesheet_name = $wpdb->prefix . 'custom_timesheet';

	$check_value = $wpdb->get_row("SELECT task_name FROM {$table_timesheet_name} WHERE ID = ".$project_id);

	$edited_by = $current_user->display_name . ' - ' . date("Y-m-d H:i");

	if((string)$check_value->task_name == (string)$project_name){
		$response = array(
			'project_id' => $project_id,
			'project_name' => $project_name,
			'status' => 'success-update-timesheet'
		);
	}else{
		//Updating to DB.
		$update_status = $wpdb->update( 
			$table_timesheet_name, 
			array( 
				'task_project_name' => $project_name,
				'edited_by' => $edited_by
			), 
			array( 'ID' => $project_id ), 
			array( 
				'%s'
			)
		);
		if($update_status == 1){

			$edit_time_string = date('h:i A', strtotime(substr($edited_by, -5)));
			$edited_by = substr($edited_by, 0, -5 ) . " " .$edit_time_string;

			$response = array(
				'project_id' => $project_id,
				'project_name' => $project_name,
				'edited_by' => $edited_by,
				'status' => 'success-update-timesheet'
			);
		}else{
			$response = array(
				'status' => 'failed-update-timesheet'
			);		
		}	
	}
	return $response;
}

function ConvertDecimalTOTimeFormat($time){
	return sprintf('%02d:%02d', (int) $time, fmod($time, 1) * 60);
}

?>