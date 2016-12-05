<?php /* Template name: Submit Task */ ?>
<?php get_header(); ?>
<?php 
global $wpdb; 
$table_name = $wpdb->prefix . "custom_submit_task";
$table_name_cron = $wpdb->prefix . "crony_jobs";
$table_name_cron_logs = $wpdb->prefix . "crony_logs";
?>
<?php 
function get_tz_timestamp($timestamp) {
	$utctzobj = timezone_open('UTC');	
	if  ( $tz = get_option('timezone_string') )  
	$tzobj = timezone_open($tz);
	else
	$tzobj = $utctzobj;
	$timeintz = new DateTime(date('Y-m-d H:i:s', $timestamp), $utctzobj);
	date_timezone_set( $timeintz, $tzobj );
	return strtotime( $timeintz->format('Y-m-d H:i:s') );
}
?>
<input type="hidden" id="current_month" value="<?php echo date('F'); ?>" />
<input type="hidden" id="current_year" value="<?php echo date('Y'); ?>" />
<input type="hidden" id="current_week" value="<?php echo date('W'); ?>" />
<script>
	jQuery(document).ready(function(){
		jQuery('.submit_starting_date').datepicker();
		jQuery('.submit_end_date').datepicker();
		
		
		var proj_name = '';
		jQuery(".submit_color").change(function(){			
			proj_name = jQuery(this).find("option:selected").text();
			jQuery('#submit_project_name').val(proj_name);
		});
		
		var apartment_name = '';
		jQuery(".submit_department").change(function(){			
			apartment_name = jQuery(this).find("option:selected").text();
			jQuery('#submit_department_name').val(apartment_name);
		});
		
		var swim_lane_name = '';
		jQuery(".submit_column").change(function(){			
			swim_lane_name = jQuery(this).find("option:selected").text();
			jQuery('#submit_column_name').val(swim_lane_name);
		});
	});
</script>
<?php  
	$seconds = 50000;
	set_time_limit($seconds);
	$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
	$url="https://kanbanflow.com/api/v1/board?" . $token;
	$result = file_get_contents($url);
	$result_array = json_decode($result, true);	
	
	$url_users = "https://kanbanflow.com/api/v1/users" . "?&" . $token;
	$result_users = file_get_contents($url_users);
	$result_users_array = json_decode($result_users, true);	
?>
<?php 
$table_name_label = $wpdb->prefix . "custom_client";
$labels = $wpdb->get_results("SELECT * FROM {$table_name_label}");
$table_name_person = $wpdb->prefix . "custom_person";
$persons = $wpdb->get_results("SELECT * FROM {$table_name_person} WHERE person_status='0'");
$table_name_project = $wpdb->prefix . "custom_project";
$projects = $wpdb->get_results("SELECT DISTINCT project_name FROM {$table_name_project}");
$projects_all = $wpdb->get_results("SELECT * FROM {$table_name_project}");
$table_name_color = $wpdb->prefix . "custom_project_color";
$colors = $wpdb->get_results("SELECT * FROM {$table_name_color}");
$table_name_task = $wpdb->prefix . "custom_task";
$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
$submitted_ongoing_tasks = $wpdb->get_results("SELECT * FROM {$table_name} WHERE submit_cron_status='ongoing'");
$submitted_paused_tasks = $wpdb->get_results("SELECT * FROM {$table_name} WHERE submit_cron_status='paused'");
$submitted_tasks = $wpdb->get_results("SELECT * FROM {$table_name} WHERE submit_schedule_each='Submitted'");
$table_name_hosting_domain = $wpdb->prefix . "custom_hosting_domain";
$hosting_domain = $wpdb->get_results("SELECT * FROM $table_name_hosting_domain");
$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 
$checklist_templates = $wpdb->get_results("SELECT * FROM {$table_name_checklist_template}");
?>
<?php $submit_schedule_each_options = array(
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
?>
<div style="display:none;" class="dialog_form_add_subtask" id="dialog_form_add_subtask" title="Add Subtask"></div>
<div style="display:none;" class="dialog_form_start_task" id="dialog_form_start_task" title="Start Task"></div>
<div style="display:none;" class="dialog_form_edit_task" id="dialog_form_edit_task" title="Edit Task"></div>
<div class="submit_task">	
	<div style="display:none" class="status_message"><p></p></div>
	<div id="submit_addtask" class="button_1 submit_button">Add Task</div>
	<div id="submit_subtask" class="button_1 submit_button">Add Subtask</div>
	<a style="padding: 0px 12px; line-height: 25px; float:left" class="button_2" href="/cron-events/">Cron Events</a>
	<div style="display: none" class="top_loader loader"></div>
	<!-- ==================================== BOARD ==================================== -->
	<div class="board ongoing">		
		<div class="board_websitedev">		
			<div class="bulk_action_select column">
				<select class="submit_bulk_actions">
					<option>-- Bulk Actions --</option>
					<option>Delete</option>
					<option>Edit Schedule</option>
					<option>Pause</option>
				</select>				
				<div class="apply_bulk_action button_2">Apply</div>				
			</div>		
			<div class="header_titles">
				<div class="column check_all_container"><input type="checkbox" id="check_all" name="check_all" class="check_all"></div>
				<div class="first_column column">
					<p class="table_header">Task Name</p>
					<div class="asc_button task_sort_asc"></div>
					<div style="display: none" class="desc_button task_sort_desc"></div>
				</div>
				<div class="second_column column">
					<p class="table_header">Client</p>
					<div class="asc_button client_sort_asc"></div>
					<div style="display: none" class="desc_button client_sort_desc"></div>
				</div>
				<div class="third_column column">
					<p class="table_header">Responsible</p>
				</div>
				<div class="fourth_column column">
					<p class="table_header">Scheduled</p>
				</div>
				<div class="fifth_column column">
					<p class="table_header">Est/Hours</p>
				</div>
				<div class="sixth_column column sort_schedule_asc">
					<p class="table_header">Next Scheduled</p>					
					<div class="asc_button date_sort_asc"></div>
					<div style="display: none" class="desc_button date_sort_desc"></div>
				</div>
				<div class="seventh_column column">
					<p class="table_header">Task Status</p>
				</div>
				<div class="eighth_column column">
					<p class="table_header">Actions</p>
				</div>
			</div>
			<div class="submit_task_cells scheduled_submit schedule_order">
					<?php 
						foreach($submitted_ongoing_tasks as $submitted_task){
							// print_var($submitted_task);
							$date_now = date("Y/m/d");
							$date_now_mktime = strtotime($date_now);
							
							$next_schedule = $submitted_task->submit_next_schedule;
							$next_schedule_explode = explode(" ", $next_schedule);
							$next_schedule_date = $next_schedule_explode[0];
							$next_schedule_date_mktime = strtotime($next_schedule_date);
							
							// if($next_schedule_date_mktime >= $date_now_mktime){
								if($submitted_task->submit_task_name_suffix != null){
									$submit_task_name = $submitted_task->submit_task_name ." - ". $submitted_task->submit_task_name_suffix;
								}else{
									$submit_task_name = $submitted_task->submit_task_name;
								}
								$submit_label = $submitted_task->submit_label;
								$submit_responsible_person = $submitted_task->submit_responsible_person;
								$submit_schedule_each = $submitted_task->submit_schedule_each;
								$submit_time_estimate_hour = $submitted_task->submit_time_estimate_hour;
								$submit_time_estimate_minute = $submitted_task->submit_time_estimate_minute;
								$submit_description = $submitted_task->submit_description;
					?>
								<div id="column_cells_<?php echo $submitted_task->ID; ?>" class="column_cells unsorted">
									<div class="bulk_action_column column">
										<input type="checkbox" name="bulk_delete_id[]" class="bulk_action_id" value="<?php echo $submitted_task->ID;?>">					
									</div>
									<div class="first_column column task_name">
										<p id="task_name_<?php echo $submitted_task->ID; ?>" class="table_header"><?php echo ($submit_task_name != null) ? $submit_task_name : "--" ; ?></p>
									</div>
									<div class="second_column column client_name">
										<p id="client_name_<?php echo $submitted_task->ID; ?>" class="client_info table_header"><?php echo ($submit_label != null) ? $submit_label : "--"; ?></p>
									</div>
									<div class="third_column column">
										<p class="table_header"><?php echo ($submit_responsible_person != null) ? $submit_responsible_person : "--"; ?></p>
									</div>
									<div class="fourth_column column">
										<p class="table_header"><?php echo ($submit_schedule_each != null) ? $submit_schedule_each : "--" ; ?></p>
									</div>
									<div class="fifth_column column">
										<p class="table_header"><?php echo (($submit_time_estimate_hour != null) ? $submit_time_estimate_hour ." h " : " 0 h ") . "" . (($submit_time_estimate_minute != null) ? $submit_time_estimate_minute ." m " : " 0 m "); ?></p>
									</div>
									<?php  if($submit_schedule_each != "Submitted" && $submitted_task->submit_cron_unique_id != ""){ ?>
									<div class="sixth_column column schedule_date">						
									<?php 						
										$timeslots = $crons == '' ? _get_cron_array() : $crons;
										foreach ( $timeslots as $time => $cron_tasks ) {
											foreach ($cron_tasks as $procname => $task) {
												foreach ($task as $key => $args){
													$cron_submit_id = $args['args']['submit_id'];													
													if($cron_submit_id != ""){
														if($cron_submit_id == $submitted_task->ID){															
															$next_run = date('Y/m/d H:i:s', get_tz_timestamp($time));
															$wpdb->update( $table_name , array( 'submit_next_schedule'=> $next_run),
															array( 'ID' => $submitted_task->ID ),
															array( '%s', '%s' ));
														}
													}
												}
											}
										}
									?>
									<?php $submit_next_schedule = $wpdb->get_row("SELECT submit_next_schedule FROM {$table_name} WHERE ID = $submitted_task->ID"); ?>
									<p id="scheduled_date_<?php echo $submitted_task->ID; ?>" class="table_header"><?php echo ($submit_next_schedule->submit_next_schedule != null)? $submit_next_schedule->submit_next_schedule : "--"; ?></p>													
									</div>									
									<?php } ?>
									<div class="seventh_column column">
										<?php if($submitted_task->submit_cron_status == 'paused'){ ?>
											<p class="table_header">Paused</p>	
										<?php }elseif($submitted_task->submit_cron_status == 'ongoing'){ ?>
											<p class="table_header">Ongoing</p>
										<?php } ?>
									</div>
									<div class="eighth_column column">
										<div class="table_header">
											<p id="edit_task_cron_<?php echo $submitted_task->ID?>" class="edit_task_cron action_buttons button_2 display_button">E</p>
											<p id="delete_task_cron_<?php echo $submitted_task->ID?>" class="delete_task_cron action_buttons button_2 display_button">D</p>
											<?php if($submitted_task->submit_cron_status == 'ongoing'){ ?>
												<p id="pause_task_cron_<?php echo $submitted_task->ID?>" class="pause_task_cron confirm action_buttons button_2 display_button">P</p>
											<?php }elseif($submitted_task->submit_cron_status == 'paused'){ ?>
												<p id="start_task_cron_<?php echo $submitted_task->ID?>" class="start_task_cron action_buttons button_2 display_button">S</p>
											<?php } ?>
											<div id="loader_<?php echo $submitted_task->ID?>" class="loader" style="display:none;"></div>
										</div>						
									</div>
									<div style="display:none;" id="submit_task_note_<?php echo $submitted_task->ID?>" class="submit_task_note"><?php echo $submitted_task->submit_description; ?></div>
								</div>
				<?php 
							// }
						} 
				
				?>
			</div>
			<div class="temp_container scheduled_submit"></div>
		</div>
	</div>
	<!-- ==================================== PAUSED ==================================== -->
	<div class="paused_task">
		<div class="accordian">
			<h5 class="toggle">
				<a href="#"><span class="arrow"></span>Paused Tasks</a>
				<div style="display: none;" class="schedule_start_task_loader"></div>
			</h5>
			<div class="toggle-content" style="display: none;">
				<div class="board">
					<div class="header_titles">
						<div class="column check_all_container"><input type="checkbox" id="check_all_paused" name="check_all_paused" class="check_all_paused"></div>
						<div class="first_column column">
							<p class="table_header">Task Name</p>
						</div>
						<div class="second_column column">
							<p class="table_header">Client</p>
						</div>
						<div class="third_column column">
							<p class="table_header">Responsible</p>
						</div>
						<div class="fourth_column column">
							<p class="table_header">Scheduled</p>
						</div>
						<div class="fifth_column column">
							<p class="table_header">Est/Hours</p>
						</div>
						<div class="sixth_column column">
							<p class="table_header">Next Scheduled</p>
						</div>
						<div class="seventh_column column">
							<p class="table_header">Task Status</p>
						</div>
						<div class="eighth_column column">
							<p class="table_header">Actions</p>
						</div>
					</div>
					<div class="submit_task_cells">
						<?php 
							foreach($submitted_paused_tasks as $submitted_task){
								if($submitted_task->submit_task_name_suffix != null){
									$submit_task_name = $submitted_task->submit_task_name ." - ". $submitted_task->submit_task_name_suffix;
									}else{
									$submit_task_name = $submitted_task->submit_task_name;
								}
								$submit_label = $submitted_task->submit_label;
								$submit_responsible_person = $submitted_task->submit_responsible_person;
								$submit_schedule_each = $submitted_task->submit_schedule_each;
								$submit_time_estimate_hour = $submitted_task->submit_time_estimate_hour;
								$submit_time_estimate_minute = $submitted_task->submit_time_estimate_minute;
								$submit_description = $submitted_task->submit_description;
							?>
							<div id="column_cells_<?php echo $submitted_task->ID; ?>" class="column_cells">
								<div class="bulk_action_column column">
									<input type="checkbox" name="bulk_delete_id[]" class="bulk_action_id" value="<?php echo $submitted_task->ID;?>">					
								</div>
								<div class="first_column column">
									<p class="table_header"><?php echo ($submit_task_name != null) ? $submit_task_name : "--" ; ?></p>
								</div>
								<div class="second_column column">
									<p class="client_info table_header"><?php echo ($submit_label != null) ? $submit_label : "--"; ?></p>
								</div>
								<div class="third_column column">
									<p class="table_header"><?php echo ($submit_responsible_person != null) ? $submit_responsible_person : "--"; ?></p>
								</div>
								<div class="fourth_column column">
									<p class="table_header"><?php echo ($submit_schedule_each != null) ? $submit_schedule_each : "--" ; ?></p>
								</div>
								<div class="fifth_column column">
									<p class="table_header"><?php echo (($submit_time_estimate_hour != null) ? $submit_time_estimate_hour ." h " : " 0 h ") . "" . (($submit_time_estimate_minute != null) ? $submit_time_estimate_minute ." m " : " 0 m "); ?></p>
								</div>
								<?php  if($submit_schedule_each != "Submitted" && $submitted_task->submit_cron_unique_id != ""){ ?>
									<div class="sixth_column column">
										
										<?php 						
											$timeslots = $crons == '' ? _get_cron_array() : $crons;
											
											foreach ( $timeslots as $time => $cron_tasks ) {
												foreach ($cron_tasks as $procname => $task) {
													foreach ($task as $key => $args){									
														$cron_submit_id = $args['args']['submit_id'];
														if($cron_submit_id != ""){
															if($cron_submit_id == $submitted_task->ID){
																$next_run = date('Y/m/d H:i:s', get_tz_timestamp($time));											
															}
														}
													}
												}
											}
										?>
										<p class="table_header"><?php echo ($next_run != null)? $next_run : "--"; ?></p>
									</div>
								<?php } ?>
								<div class="seventh_column column">
									<?php if($submitted_task->submit_cron_status == 'paused'){ ?>
										<p class="table_header">Paused</p>	
										<?php }elseif($submitted_task->submit_cron_status == 'ongoing'){ ?>
										<p class="table_header">Ongoing</p>
									<?php } ?>
								</div>
								<div class="eighth_column column">
									<div class="table_header">
										<p id="edit_task_cron_<?php echo $submitted_task->ID?>" class="edit_task_cron action_buttons button_2 display_button">E</p>
										<p id="delete_task_cron_<?php echo $submitted_task->ID?>" class="delete_task_cron confirm action_buttons button_2 display_button">D</p>
										<?php if($submitted_task->submit_cron_status == 'ongoing'){ ?>
											<p id="pause_task_cron_<?php echo $submitted_task->ID?>" class="pause_task_cron confirm action_buttons button_2 display_button">P</p>
											<?php }elseif($submitted_task->submit_cron_status == 'paused'){ ?>
											<p id="start_task_cron_<?php echo $submitted_task->ID?>" class="start_task_cron action_buttons button_2 display_button">S</p>
										<?php } ?>
									</div>						
								</div>
								<div style="display:none;" id="submit_task_note_<?php echo $submitted_task->ID?>" class="submit_task_note"><?php echo $submitted_task->submit_description; ?></div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ==================================== SUBMITTED ==================================== -->
	<div class="submitted_task">
		<div class="accordian">
			<h5 class="toggle">
				<a href="#"><span class="arrow"></span>Submitted Tasks</a>
				<div style="display: none;" class="schedule_start_task_loader"></div>
			</h5>
			<div class="toggle-content" style="display: none;">
				<div class="board">
		<div class="board_websitedev">
			<h3 class="department_title"></h3>
			<div class="header_titles">
				<div class="column check_all_container"><input type="checkbox" id="check_all_submitted" name="check_all_submitted" class="check_all_submitted"></div>				
				<div class="first_column column">
					<p class="table_header">Task Name</p>
				</div>
				<div class="second_column column">
					<p class="table_header">Client</p>					
				</div>
				<div class="third_column column">
					<p class="table_header">Responsible</p>
				</div>
				<div class="fourth_column column">
					<p class="table_header">Scheduled</p>
				</div>
				<div class="fifth_column column">
					<p class="table_header">Est/Hours</p>
				</div>
				<div class="eighth_column column">
					<p class="table_header">Actions</p>
				</div>
			</div>
			<div class="submit_task_cells scheduled_submit">
					<?php 
						foreach($submitted_tasks as $submitted_task){
							$date_now = date("Y/m/d");
							$date_now_mktime = strtotime($date_now);
							
							$next_schedule = $submitted_task->submit_next_schedule;
							$next_schedule_explode = explode(" ", $next_schedule);
							$next_schedule_date = $next_schedule_explode[0];
							$next_schedule_date_mktime = strtotime($next_schedule_date);
							if($next_schedule_date_mktime < $date_now_mktime){
						
								if($submitted_task->submit_task_name_suffix != null){
									$submit_task_name = $submitted_task->submit_task_name ." - ". $submitted_task->submit_task_name_suffix;
								}else{
									$submit_task_name = $submitted_task->submit_task_name;
								}
								$submit_label = $submitted_task->submit_label;
								$submit_responsible_person = $submitted_task->submit_responsible_person;
								$submit_schedule_each = $submitted_task->submit_schedule_each;
								$submit_time_estimate_hour = $submitted_task->submit_time_estimate_hour;
								$submit_time_estimate_minute = $submitted_task->submit_time_estimate_minute;
								$submit_description = $submitted_task->submit_description;
					?>
								<div id="column_cells_<?php echo $submitted_task->ID; ?>" class="column_cells">
									<div class="bulk_action_column column">
										<input type="checkbox" name="bulk_delete_id[]" class="bulk_action_id" value="<?php echo $submitted_task->ID;?>">					
									</div>
									<div class="first_column column">
										<p class="table_header"><?php echo ($submit_task_name != null) ? $submit_task_name : "--" ; ?></p>
									</div>
									<div class="second_column column client_name">
										<p id="client_name_<?php echo $submitted_task->ID; ?>" class="client_info table_header"><?php echo ($submit_label != null) ? $submit_label : "--"; ?></p>
									</div>
									<div class="third_column column">
										<p class="table_header"><?php echo ($submit_responsible_person != null) ? $submit_responsible_person : "--"; ?></p>
									</div>
									<div class="fourth_column column">
										<p class="table_header"><?php echo ($submit_schedule_each != null) ? $submit_schedule_each : "--" ; ?></p>
									</div>
									<div class="fifth_column column">
										<p class="table_header"><?php echo (($submit_time_estimate_hour != null) ? $submit_time_estimate_hour ." h " : " 0 h ") . "" . (($submit_time_estimate_minute != null) ? $submit_time_estimate_minute ." m " : " 0 m "); ?></p>
									</div>
									<div class="eighth_column column">
										<div class="table_header">
											<p id="edit_task_cron_<?php echo $submitted_task->ID?>" class="edit_task_cron action_buttons">Edit</p>
											<p id="delete_task_cron_<?php echo $submitted_task->ID?>" class="delete_task_cron confirm action_buttons">Delete</p>
											<?php if($submitted_task->submit_cron_status == 'ongoing'){ ?>
												<p id="pause_task_cron_<?php echo $submitted_task->ID?>" class="pause_task_cron confirm action_buttons">Pause</p>
											<?php }elseif($submitted_task->submit_cron_status == 'paused'){ ?>
												<p id="start_task_cron_<?php echo $submitted_task->ID?>" class="start_task_cron action_buttons">Start</p>
											<?php } ?>
										</div>						
									</div>
									<div style="display:none;" id="submit_task_note_<?php echo $submitted_task->ID?>" class="submit_task_note"><?php echo $submitted_task->submit_description; ?></div>
								</div>
				<?php 
							}
						} 
				
				?>
			</div>
			<div class="temp_container scheduled_submit"></div>
		</div>
	</div>
			</div>
		</div>
	</div>
</div>
<div style="display:none;" class="dialog_form_add_task" id="dialog_form_add_task" title="Add Task">
	<div class="tab-holder">
		<div class="tab-hold tabs-wrapper">
			<div class="full_width">
				<ul id="tabs" class="tabset tabs">
					<li class="tabs_li"><a href="#general">General</a></li>
					<li class="tabs_li"><a href="#subtask">Subtask</a></li>
				</ul>
			</div>
			<div class="tab-box tabs-container">
				<form action="" method="post" name="submit_task_form" id="submit_task_form">
					<div class="submit_inputs">
						<div id="general" class="tab tab_content active" style="display: none;">
							<div class="submit_section">
								<div class="submit_left">
									<select class="submit_task_name required" name="submit_task_name">
										<option disabled selected>-- Select Task --</option>
										<?php
											$task_names = array();
											foreach($tasks as $task){ 
												$task_names[] = $task->task_name;
											}
											sort($task_names);
											foreach($task_names as $task_name){
										?>
										<option><?php echo $task_name; ?></option>
										<?php } ?>									
									</select>
								</div>
								<div class="submit_right">
									<input type="submit_task_name_suffix" class="submit_task_name_suffix" name="submit_task_name_suffix" placeholder="Task Suffix"/>
									<input type="hidden" class="submit_task_name_suffix_time" name="submit_task_name_suffix_time" />
								</div>
							</div>
							<div class="submit_section">
								<div class="submit_left">
									<textarea class="submit_description" name="submit_description" placeholder="Descriptions"></textarea>
								</div>
								<div class="estimated_time submit_right">
									<p class="label">Time Estimate:</p>
									<input type="text" class="submit_time_estimate_hour time" name="submit_time_estimate_hour" placeholder="Hour"/>
									<input type="text" class="submit_time_estimate_minute time" name="submit_time_estimate_minute" placeholder="Minute" />
								</div>
							</div>
							<div class="submit_section">
								<div class="submit_left">				
									<select class="submit_color required" name="submit_color">
										<option disabled selected>-- Project --</option>
										<?php 
										$project_categories = array();
										foreach($colors as $color){
											$project_categories[] = $color->project_category;
										}
										sort($project_categories);
										foreach($project_categories as $project_category){
											$color_name = $wpdb->get_results("SELECT project_color FROM {$table_name_color} WHERE project_category = '$project_category'");											
										?>
										<option value="<?php echo $color_name[0]->project_color; ?>"><?php echo $project_category; ?></option>	
									<?php } ?>
																			
									</select>
									<input type="hidden" name="submit_project_name" id="submit_project_name" value="">		
								</div>
								<div class="submit_right">
									<select class="submit_responsible_person required" name="submit_responsible_person">
										<option disabled selected>-- Select Responsible --</option>
										<?php 
										$person_full_names = array();
										foreach($persons as $person){
											$person_full_names[] = $person->person_first_name ." ".  $person->person_last_name;
										}
										sort($person_full_names);
										foreach($person_full_names as $person_full_name){										
										?>
										<option><?php echo $person_full_name; ?></option>
									<?php } ?>
									</select>				
								</div>			
							</div>
							<div class="submit_section">
								<div class="submit_left submit_select_client">
									<div style="display:none;" class="loader"></div>
									<div style="display:none;" class="project_check"></div>
									<select class="submit_label required" name="submit_label[]" multiple>
										<option disabled selected>-- Select Client--</option>
										<?php 
										$label_array = array();
										foreach($labels as $label){
											$label_array[] = $label->client_name;
										}
										sort($label_array);
										foreach($label_array as $label_name){
										?>
										<option><?php echo $label_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="submit_right">
									<select class="submit_collaborators" name="submit_collaborators[]" multiple="multiple">
										<option disabled selected>-- Select Collaborators --</option>
										<?php
										$person_full_names = array();
										foreach($persons as $person){
											$person_full_names[] = $person->person_first_name ." ".  $person->person_last_name;
										}
										sort($person_full_names);
										foreach($person_full_names as $person_full_name){
										?>
										<option><?php echo $person_full_name; ?></option>
										<?php } ?>
									</select>
								</div>			
							</div>
							<div class="submit_section">
								<div class="submit_left">
									<select class="submit_department required" name="submit_department">
										<option disabled selected>-- Select Department --</option>										
										<?php 
										$swimlanes = array();										
										foreach($result_array['swimlanes'] as $swimlane){	
											$swimlanes[] = $swimlane['name'] ."_". $swimlane['uniqueId'];
										}
										sort($swimlanes);
										foreach($swimlanes as $swimlane_name_id){
											$swimlane_explode = explode("_",$swimlane_name_id);
											$swimlane_name = $swimlane_explode[0];
											$swimlane_id = $swimlane_explode[1];										
										?>
										<option value="<?php echo $swimlane_id; ?>"><?php echo $swimlane_name; ?></option>
									<?php }	?>									
										<input type="hidden" name="submit_department_name" class="submit_department_name" id="submit_department_name" value="">
									</select>
								</div>
								<div class="submit_right">
									<select class="submit_column required" name="submit_column">
										<option disabled selected>-- Select Column --</option>
										<?php 
										$swimlane_column_array = array();
										foreach($result_array['columns'] as $swimlane_columns){ 
											$swimlane_column_array[] = $swimlane_columns['name'] ."_". $swimlane_columns['uniqueId'];
										}
										sort($swimlane_column_array);
										foreach($swimlane_column_array as $swimlane_column_name_id){
											$swimlane_column_explode = explode("_", $swimlane_column_name_id);
											$swimlane_column_name = $swimlane_column_explode[0];
											$swimlane_column_id = $swimlane_column_explode[1];
										?>
										<option value="<?php echo $swimlane_column_id; ?>"><?php echo $swimlane_column_name; ?></option>
										<?php } ?>
									</select>
									<input type="hidden" name="submit_column_name" class="submit_column_name" id="submit_column_name" value="">
								</div>
							</div>
							<div class="submit_section add_task_checklist">
								<div class="include_checklist">
									<input type="checkbox" name="submit_checklist" class="submit_checklist" id="submit_checklist" value="1">
									<p class="label">Include Checklist</p>									
								</div>
								<div style="display:none;" class="submit_checklist_div">
									<div style="display:none;" class="loader add_checklist_template_loader"></div>	
									<div class="add_checklist_template button_2">Copy Template</div>	
									<select name="submit_checklist_template" class="submit_checklist_template">										
										<?php 
											$counter = 0;
											foreach($checklist_templates as $checklist_template){ 
												if($counter == 0){
													$current_checklist_template = $checklist_template->checklist_template;
												}
											?>
											<option><?php echo $checklist_template->checklist_template; ?></option>
										<?php $counter++; } ?>
									</select>										
								</div>
								<div style="display: none;" class="checklist_template_div">
									<div class="add_template button_1">Add</div>
									<input type="text" name="add_checklist_template_input" class="add_checklist_template_input" />									
									<div style="display:none;" class="add_template_loader loader"></div>
									<p style="display: none;" class="text_red template_exist_note">Template name already exist.</p>
								</div>
							</div>
							
							<div class="submit_section">
								<h3>Cron Settings</h3>
								<div class="submit_left schedule_today_div">
									<input type="checkbox" name="schedule_today" class="schedule_today" id="schedule_today" value="1">
									<p class="label">Schedule Today</p>									
								</div>
								<div class="submit_left">
									<select class="submit_schedule_each required" name="submit_schedule_each">
										<option value="" disabled selected>-- Select Schedule Each --</option>
										<?php 
										$submit_schedule_each_option_array = array();
										foreach($submit_schedule_each_options as $submit_schedule_each_option){ 
											$submit_schedule_each_option_array[] = $submit_schedule_each_option;
										}
										sort($submit_schedule_each_option_array);
										foreach($submit_schedule_each_option_array as $submit_schedule_each_name){
										?>
										<option><?php echo $submit_schedule_each_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="submit_right">
									<div class="submit_date">
										<input type="text" class="submit_starting_date " name="submit_starting_date" placeholder="Starting Date" />
									</div>
								</div>
							</div>
							
							<!--
							<div class="submit_section">
								<h3>Cron Settings</h3>
								<div class="submit_left">
									<select class="submit_schedule_each required" name="submit_schedule_each">
										<option value="" disabled selected>-- Select Schedule Each --</option>
										<?php // foreach($submit_schedule_each_options as $submit_schedule_each_option): ?>
										<option><?php // echo $submit_schedule_each_option; ?></option>
										<?php // endforeach; ?>
									</select>
								</div>
								<div class="submit_right">
									<div class="submit_date">
										<input type="text" class="submit_starting_date " name="submit_starting_date" placeholder="Starting Date" />
									</div>
									<div class="submit_hour">
										<input type="text" class="submit_hour " name="submit_hour" title="Enter 24 hour format" placeholder="Hour" />
									</div>
									<div class="submit_minute">
										<input type="text" class="submit_minute " name="submit_minute" placeholder="Minute" />
									</div>
								</div>
							</div>
							-->
						</div>
						<div id="subtask" class="tab tab_content" style="display: none;">
							<div class="subtask_container"></div>
							<div class="submit_task_input">
								<input type="text" class="sub_task " name="sub_task" />
								<div class="button_2 add_subtask_button">Add Subtask</div>
							</div>
						</div>
					</div>
					<div class="submit_task_buttons">
						<div class="button_1 submit_button schedule_task">Schedule Task</div>
						<div class="submit_now button_1 submit_button">Submit Now</div>
						<div style="display: none;" class="schedule_task_loader"></div>
					</div>
				</form>
			</div>
		</div>
	</div>			
<!--<div class="submit_section">
	<div class="submit_left">
		<p class="label">Time Spent</p>
		<input type="text" class="submit_time_spent_hour time" name="submit_time_spent_hour" /> h
		<input type="text" class="submit_time_spent_minute time" name="submit_time_spent_minute" /> m
	</div>
	<div class="submit_right">
		<p class="label">Time Estimate</p>
		<input type="text" class="submit_time_estimate_hour time" name="submit_time_estimate_hour" /> h
		<input type="text" class="submit_time_estimate_minute time" name="submit_time_estimate_minute" /> m
	</div>
</div>-->		
</div>
<div style="display:none;" id="dialog_form_delete_task" title="Delete Task">
	<h3>Are you sure you want to continue?</h3>
	<div class="confirm_delete_buttons">
		<div style="display: none" class="loader"></div>
		<div class="button_2 delete_cancel">No</div>
		<div class="button_1 delete_confirm">Yes</div>		
	</div>
</div>
<div style="display:none;" id="dialog_form_bulk_action_task">
	<div class="confirm_bulk_action_details"></div>
	<div class="confirm_bulk_action_buttons">
		<div style="display: none" class="loader"></div>
		<div class="button_1 bulk_action_confirm"></div>
		<div class="button_2 bulk_action_cancel">No</div>		
	</div>
</div>
<div style="display:none;" class="add_project_client_confirm" id="add_project_client_confirm" title="Project does not exist!">
	<h3 class="add_project_client_title"></h3>
	<div class="add_project_buttons">
		<div class="button_2 cancel_add_project_client">No</div>
		<div class="button_1 add_project_client">Yes</div>
		<div style="display:none;" class="loader"></div>
		<form id="add_project_client_form">
			<input type="hidden" class="client_name" />			
			<input type="hidden" class="project_name" />
			<input type="hidden" class="client_id" />			
		</form>
	</div>
</div>
<div style="display:none;" class="dialog_form_add_project_client" id="dialog_form_add_project_client" title="Add Project"></div>
<div style="display:none;" id="dialog_form_website_add" title="Add Website">
	<?php 
		$table_name_client = $wpdb->prefix . "custom_client";
		$clients = $wpdb->get_results("SELECT * FROM $table_name_client");
		$site_types = array('Main site', 'Secondary site', 'Demo site', 'PBN Site');
		$site_platforms = array('Wordpress', 'Drupal', 'Web2.0');
		$site_domain_owners = array('Customer', 'SEOWEB');
	?>
	<div class="add_website website_style">
		<form action="" method="post" name="website" id="website">
			<div class="section first_section">
				<div class="left">
					<p class="label">Site URL:</p>
				</div>
				<div class="right">
					<input type="text" name="site_url" class="site_url" placeholder="http://">	
					<div class="error_message"><p></p></div>
					<div class="get_details_buttons">
						<div class="button_1 get_wp_details">Get WP Details</div>
						<div class="button_1 get_theme_details">Get Theme Details</div>	
						<div style="display:none;" class="loader"></div>
					</div>
				</div>				
			</div>
			<div class="border_separator"></div>		
			<div style="display:none" class="section wp_readme_details"></div>
			<div class="section wp_version"></div>
			<div class="section theme_details"></div>
			<div class="section three_column">
				<select name="site_type">
					<option disabled selected>-- Site Type --</option>
					<?php foreach($site_types as $site_type){	?>
						<option><?php echo $site_type; ?></option>
					<?php } ?>
				</select>			
			</div>
			<div class="section three_column">
				<select name="site_client">
					<option disabled selected>-- Site Client --</option>
					<?php foreach($clients as $client){	?>
						<option><?php echo $client->client_name; ?></option>
					<?php } ?>
				</select>		
			</div>
			<div class="section three_column">
				<select name="site_platform">
					<option disabled selected>-- Site Platform --</option>
					<?php foreach($site_platforms as $site_platform){ ?>
						<option><?php echo $site_platform; ?></option>
					<?php } ?>
				</select>		
			</div>
			<div class="border_separator"></div>
			<div class="section four_column">
				<input type="text" name="site_login_url" placeholder="Site Login URL" />
				<input type="text" class="site_username input_float_left" name="site_username" placeholder="Site Login Username" />
				<input type="text" class="site_password input_float_left" name="site_password" placeholder="Site Login Password" />					
			</div>
			<div class="section four_column">
				<input type="text" class="site_mysql_url" name="site_mysql_url" placeholder="MySQL URL" />
				<input type="text" class="site_mysql_username input_float_left" name="site_mysql_username" placeholder="MySQL Username" />
				<input type="text" class="site_mysql_password input_float_left" name="site_mysql_password" placeholder="MySQL Password" />
			</div>
			<div class="section four_column">
				<input type="text" class="site_database_name input_float_left" name="site_database_name" placeholder="Database Name" />
				<input type="text" class="site_database_username input_float_left" name="site_database_username" placeholder="Database Username" />
				<input type="text" class="site_database_password input_float_left" name="site_database_password" placeholder="Database Password" />
			</div>
			<div class="section four_column last">
				<input type="text" class="site_ftp_server input_float_left" name="site_ftp_server" placeholder="FTP server" />
				<input type="text" class="site_ftp_username input_float_left" name="site_ftp_username" placeholder="FTP Username" />
				<input type="text" class="site_ftp_password input_float_left" name="site_ftp_password" placeholder="FTP Password" />
			</div>
			<div class="border_separator"></div>
			<div class="section two_column">
				<div class="left">
					<select class="site_hosting_name" name="site_hosting_name">
						<option>Unknown</option>
						<?php 
							foreach($hosting_domain as $hosting){
								$hosting_name = $hosting->site_hosting_name;
								if($hosting_name != null){
								?>
								<option><?php echo $hosting_name; ?></option>
								<?php	
								}
							}
						?>
					</select>
					<div class="button_2 add_hosting add_other_hosting_domain">Add Hosting</div>
					<div style="display: none;" class="add_hosting_url add_hosting_domain_div">
						<div class="add_url_details">
							<div class="hosting_domain_input">
							<input type="text" name="add_site_hosting_name" class="add_site_hosting_name add_hosting_domain_input" placeholder="Hosting Name" />			
							<input type="text" name="add_site_hosting_url" class="add_site_hosting_url add_hosting_domain_input" placeholder="Hosting URL" />
							</div>
							<div class="hosting_domain_input">
							<input type="text" name="add_site_hosting_username" class="add_site_hosting_username add_hosting_domain_input" placeholder="Hosting Username" />
							<input type="text" name="add_site_hosting_password" class="add_site_hosting_password add_hosting_domain_input" placeholder="Hosting Password" />
							</div>
							<div class="button_1 save_hosting_url">Add</div>
						</div>
						<div style="display: none;" class="loader hosting_domain_loader"></div>
					</div>
				</div>	
			</div>
			<div class="section two_column last">
				<div class="left">
					<?php $domain_count = count($domains); ?>
					<select class="site_domain_name" name="site_domain_name">
						<option>Unknown</option>
						<optgroup label = "Domain Registrars">
							<?php 
								foreach($hosting_domain as $domain){
									$domain_name = $domain->site_domain_name;
									if($domain_name != null){ 
									?>
									<option><?php echo $domain_name; ?></option>
									<?php	
									}
								}
							?>
						</optgroup>
						<optgroup label = "Hosting">
							<?php 
								foreach($hosting_domain as $hosting){
									$hosting_name = $hosting->site_hosting_name;
									if($hosting_name != null){
									?>
									<option><?php echo $hosting_name; ?></option>
									<?php	
									}
								}
							?>
						</optgroup>
					</select>
					<div class="button_2 add_domain add_other_hosting_domain">Add Domain</div>
					<div style="display: none;" class="add_domain_url add_hosting_domain_div">
						<div class="add_url_details">
							<div class="hosting_domain_input">
								<input type="text" name="add_site_domain_name" class="add_site_domain_name add_hosting_domain_input" placeholder="Domain Name" />
								<input type="text" name="add_site_domain_url" class="add_site_domain_url add_hosting_domain_input" placeholder="Domain URL" />
							</div>
							<div class="hosting_domain_input">
								<input type="text" name="add_site_domain_username" class="add_site_domain_username add_hosting_domain_input" placeholder="Domain Username" />
								<input type="text" name="add_site_domain_password" class="add_site_domain_password add_hosting_domain_input" placeholder="Domain Password" />
							</div>
							<div class="button_1 save_domain_url">Add</div>
						</div>
						<div style="display: none;" class="loader hosting_domain_loader"></div>
					</div>
				</div>			
			</div>
			<div class="border_separator"></div>
			<div class="section three_column">
				<select name="site_domain_owner">
					<option disabled selected>-- Domain Owner --</option>
					<?php foreach($site_domain_owners as $site_domain_owner){	?>
						<option><?php echo $site_domain_owner; ?></option>
					<?php } ?>
				</select>			
			</div>
			<div class="section three_column">
				<input type="text" name="site_renewal_date" class="site_renewal_date" placeholder="Renewal date" />						
			</div>
			<div class="section three_column">
				<input type="text" name="site_cost" class="site_cost" placeholder="Cost" />	
			</div>
			<div class="border_separator"></div>
			<div class="section">
				<div class="left">
					<p class="label">Additional Information:</p>
				</div>
				<div class="right">
					<textarea name="site_additional_info" class="site_additional_info textarea_wide"></textarea>
				</div>
			</div>				
			<div class="add_website_buttons">				
				<div class="save_website button_1" />Add Website</div>
				<div style="display:none;" class="add_site_loader"></div>
			</div>
		</form>
	</div>
</div>
<div style="display:none;" class="dialog_client_information" id="dialog_client_information" title="Client Information">
	<div class="full_width">
		<div class="one_half">
			<p class="label">Customer Info:</p>
			<p class="client_name"></p>
			<p class="client_address"></p>
			<p class="label">Contact Person:</p>
			<p class="client_contact_person"></p>
			<p class="client_contact_phone"></p>
			<p class="client_contact_email"></p>
		</div>
		<div class="one_half last">
			<div class="full_width">
				<p class="label">Monthly Plan: </p>
				<p class="client_monthly_plan"></p>
			</div>
			<div class="full_width">
				<p class="label">Customer Satisfaction: </p>
				<p class="client_satisfaction"></p>
			</div>
			<div class="full_width">
				<p class="label">Current Active WebDev Projects: </p>
				<p class="current_active_webdev_projects"></p>
			</div>
			<div class="full_width">
				<p class="label">Monthly Ongoing Stat: </p>
				<p class="monthly_ongoing_stat"></p>
			</div>
		</div>
	</div>
	<div class="full_width">
		<h3>Customer Sites</h3>
		<div class="header_titles">
			<div class="first_column column">URL</div>
			<div class="second_column column">Site Type</div>
			<div class="third_column column">Platform</div>
			<div class="fourth_column column">Version</div>
			<div class="fifth_column column">Username</div>
			<div class="sixth_column column">Password</div>
			<div class="seventh_column column">L</div>
		</div>
		<div class="site_container"></div>
	</div>
</div>
<?php get_footer(); ?>