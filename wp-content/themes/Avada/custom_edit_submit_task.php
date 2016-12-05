<?php /* Template name: Edit Submit Task */ ?>
<?php get_header(); ?>
<script>
	jQuery(document).ready(function(){
		jQuery('.submit_starting_date').datepicker();
		
		
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
global $wpdb;			
$table_name = $wpdb->prefix . "custom_submit_task";
$table_name_options = $wpdb->prefix . "options";
$options = $wpdb->get_row("SELECT * FROM {$table_name_options} WHERE option_name ='cron'");
$id = $_GET['editID'];
?>
<?php
if(isset($_POST['submit'])):
	global $wpdb;
		$submit_task_name				= $_POST['submit_task_name'];
		$submit_task_name_suffix		= $_POST['submit_task_name_suffix'];
		$submit_description				= $_POST['submit_description'];
		$submit_label					= $_POST['submit_label'];
		$submit_responsible_person		= $_POST['submit_responsible_person'];
		$submit_collaborators_array		= $_POST['submit_collaborators'];
		$submit_collaborators 			= serialize($submit_collaborators_array);
		$submit_color					= $_POST['submit_color'];
		$submit_project_name			= $_POST['submit_project_name'];
		$submit_time_spent_hour			= $_POST['submit_time_spent_hour'];
		$submit_time_spent_minute		= $_POST['submit_time_spent_minute'];
		$submit_time_estimate_hour		= $_POST['submit_time_estimate_hour'];
		$submit_time_estimate_minute	= $_POST['submit_time_estimate_minute'];
		$submit_department				= $_POST['submit_department'];
		$submit_department_name			= $_POST['submit_department_name'];
		$submit_column					= $_POST['submit_column'];
		$submit_column_name				= $_POST['submit_column_name'];
		$submit_schedule_each			= $_POST['submit_schedule_each'];
		$submit_starting_date			= $_POST['submit_starting_date'];

	$update = $wpdb->update( $table_name , array( 
		'submit_task_name'				=> $submit_task_name,
		'submit_task_name_suffix'		=> $submit_task_name_suffix,
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
		'submit_department'				=> $submit_department,
		'submit_department_name'		=> $submit_department_name,
		'submit_column'					=> $submit_column,
		'submit_column_name'			=> $submit_column_name,
		'submit_schedule_each'			=> $submit_schedule_each,
		'submit_starting_date'			=> $submit_starting_date
	), 
	array( 'ID' => $id ),
	array( '%s', '%s' ));
	
		
		
	// $date_format = date("n/j/Y" , strtotime($submit_starting_date));
	// $date_array = explode("/", $date_format);
	// $month	= $date_array['0'];
	// $day 	= $date_array['1'];
	// $year	= $date_array['2'];
	// $timestamp = mktime('0', '1', '0', $month, $day , $year);
	
	// $submit_cron_unique_id = $results_edit->submit_cron_unique_id;
	
	// $cron_unserialize = unserialize($options->option_value);
	
	// foreach($cron_unserialize as $time => $cron_tasks){
		// foreach ($cron_tasks as $procname => $task) {
			// foreach ($task as $key => $args) {
				// $cron_unique_id = $args['args']['task_unique_id'];
				// if($cron_unique_id == $submit_cron_unique_id){					
					// $cron_serialize = serialize($cron_unserialize);
					// $update_time = str_replace($time, $timestamp, $cron_serialize);
				// }
			// }
		// }
	// }
	// $update_cron = $wpdb->update( $table_name_options , array( 
		// 'option_value'	=> $update_time
	// ), 
	// array( 'option_name' => 'cron' ),
	// array( '%s' ));
	
	if($update == 1):
		echo "<p class='message'>";
		echo "Project Updated!";
	else:
		echo "Project was not successfully updated.";
		echo "</p>";
	endif;	
	
	if($update_cron == 1):
		echo "<p class='message'>";
		echo "CRON Updated!";
	else:
		echo "CRON was not successfully updated.";
		echo "</p>";
	endif;	
endif;
?>
<?php
$results_edit = $wpdb->get_row("SELECT * FROM $table_name WHERE id=$id");
$table_name_task = $wpdb->prefix . "custom_task";
$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
$table_name_label = $wpdb->prefix . "custom_client";
$labels = $wpdb->get_results("SELECT * FROM {$table_name_label}");
$table_name_color = $wpdb->prefix . "custom_project_color";
$colors = $wpdb->get_results("SELECT * FROM {$table_name_color}");
$table_name_person = $wpdb->prefix . "custom_person";
$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
?>
<?php 
	// $submit_starting_date =$results_edit->submit_starting_date;
	// $date_format = date("n/j/Y" , strtotime($submit_starting_date));
	// $date_array = explode("/", $date_format);
	// $month	= $date_array['0'];
	// $day 	= $date_array['1'];
	// $year	= $date_array['2'];
	// $timestamp = mktime('0', '1', '0', $month, $day , $year);
	
	// $submit_cron_unique_id = $results_edit->submit_cron_unique_id;
	
	// $cron_unserialize = unserialize($options->option_value);
	
	// foreach($cron_unserialize as $time => $cron_tasks){
		// foreach ($cron_tasks as $procname => $task) {
			// foreach ($task as $key => $args) {				
				// $cron_unique_id = $args['args']['task_unique_id'];
				// $schedule = $args['schedule'];				
				// if($cron_unique_id == $submit_cron_unique_id){
					// print_var($cron_unserialize);
				// }
			// }
		// }
	// }
?>
<?php 
	$seconds = 50000;
	set_time_limit($seconds);
	$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
	$url="https://kanbanflow.com/api/v1/board?" . $token;
	$result = file_get_contents($url);
	$result_array = json_decode($result, true);
?>
<?php
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

 ?>
<div class="submit_task">
	<form action="" method="post" name="submit_task_form" id="submit_task_form">
		<div class="submit_section">
			<div class="submit_left">
				<p class="label">Task</p>
				<select class="submit_task_name" name="submit_task_name">
					<option value="<?php echo (isset($results_edit->submit_task_name)) ? $results_edit->submit_task_name : '';  ?>"><?php echo $results_edit->submit_task_name; ?></option>
					<?php foreach($tasks as $task): ?>
					<?php if($task->task_name != $results_edit->submit_task_name): ?>
					<option><?php echo $task->task_name; ?></option>
					<?php endif; endforeach;?>
				</select>
			</div>
			<div class="submit_right">
				<p class="label">Task Suffix</p>
				<input type="submit_task_name_suffix" class="submit_task_name_suffix" name="submit_task_name_suffix" value="<?php echo (isset($results_edit->submit_task_name_suffix)) ? $results_edit->submit_task_name_suffix : '';  ?>" />
			</div>
		</div>
		<div class="submit_section">
			<p class="label">Description</p>
			<textarea class="submit_description" name="submit_description"><?php echo $results_edit->submit_description; ?></textarea>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<p class="label">Label</p>
				<select class="submit_label" name="submit_label">
					<option value="<?php echo (isset($results_edit->submit_label)) ? $results_edit->submit_label : '';  ?>"><?php echo $results_edit->submit_label; ?></option>
					<?php foreach($labels as $label): ?>
					<?php if($results_edit->submit_label != $label->client_name): ?>
					<option><?php echo $label->client_name; ?></option>
					<?php endif; endforeach;?>
				</select>
			</div>
			<div class="submit_right">
				<p class="label">Color</p>
				<select class="submit_color" name="submit_color">
					<option value="<?php echo (isset($results_edit->submit_color)) ? $results_edit->submit_color : '';  ?>"><?php echo $results_edit->submit_project_name; ?></option>
					<?php foreach($colors as $color): ?>
					<?php if($results_edit->submit_project_name != $color->project_category): ?>
					<option value="<?php echo $color->project_color; ?>"><?php echo $color->project_category; ?></option>
					<?php endif; endforeach;?>
				</select>
				<input type="hidden" name="submit_project_name" id="submit_project_name" value="<?php echo (isset($results_edit->submit_project_name)) ? $results_edit->submit_project_name : '';  ?>">				
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<p class="label">Responsible</p>
				<select class="submit_responsible_person" name="submit_responsible_person">
					<option value="<?php echo (isset($results_edit->submit_responsible_person)) ? $results_edit->submit_responsible_person : '';  ?>"><?php echo $results_edit->submit_responsible_person; ?></option>
					<?php foreach($persons as $person): ?>
					<?php if($person->person_first_name ." ".  $person->person_last_name != $results_edit->submit_responsible_person): ?>
					<option><?php echo $person->person_first_name ." ".  $person->person_last_name; ?></option>
					<?php endif; endforeach; ?>
				</select>
			</div>
			<div class="submit_right">
				<p class="label">Collaborators</p>
				<?php 
					$unserialize_collaborator = unserialize($results_edit->submit_collaborators);
					if($unserialize_collaborator != null){
				?>
				<select class="submit_collaborators" name="submit_collaborators[]" multiple="multiple">
					<?php foreach($persons as $person): ?>
						<?php $names = $person->person_first_name ." ".  $person->person_last_name; ?>
						<?php if($results_edit->submit_collaborators != $names): ?>
						<option <?php echo in_array($names, $unserialize_collaborator) ? "selected" : ""; ?> ><?php echo $names; ?></option>
					<?php endif; endforeach; ?>
				</select>
				<?php } else { ?>
					<select class="submit_collaborators" name="submit_collaborators[]" multiple="multiple">
						<?php foreach($persons as $person): ?>
						<?php $names = $person->person_first_name ." ".  $person->person_last_name; ?>
						<?php if(isset($names)): ?>
							<option <?php echo ($results_edit->submit_collaborators == $names ) ? "selected" : ""; ?>><?php echo $names; ?></option>
						<?php endif; endforeach; ?>
					</select>
				<?php } ?>
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<p class="label">Time Spent</p>
				<input type="text" class="submit_time_spent_hour time" name="submit_time_spent_hour" value="<?php echo (isset($results_edit->submit_time_spent_hour)) ? $results_edit->submit_time_spent_hour : '';  ?>" /> h
				<input type="text" class="submit_time_spent_minute time" name="submit_time_spent_minute" value="<?php echo (isset($results_edit->submit_time_spent_minute)) ? $results_edit->submit_time_spent_minute : '';  ?>" /> m
			</div>
			<div class="submit_right">
				<p class="label">Time Estimate</p>
				<input type="text" class="submit_time_estimate_hour time" name="submit_time_estimate_hour" value="<?php echo (isset($results_edit->submit_time_estimate_hour)) ? $results_edit->submit_time_estimate_hour : '';  ?>" /> h
				<input type="text" class="submit_time_estimate_minute time" name="submit_time_estimate_minute" value="<?php echo (isset($results_edit->submit_time_estimate_minute)) ? $results_edit->submit_time_estimate_minute : '';  ?>" /> m
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<p class="label">Department</p>
				<select class="submit_department" name="submit_department">
					<option value="<?php echo (isset($results_edit->submit_department)) ? $results_edit->submit_department : '';  ?>"><?php echo $results_edit->submit_department_name?></option>
					<?php foreach($result_array['swimlanes'] as $swimlane):	?>
					<?php if($swimlane['name'] != $results_edit->submit_department_name): ?>
					<option value="<?php echo $swimlane['uniqueId']; ?>"><?php echo $swimlane['name']; ?></option>
					<?php endif; endforeach; ?>
				</select>
				<input type="hidden" name="submit_department_name" class="submit_department_name" id="submit_department_name" value="<?php echo (isset($results_edit->submit_department_name)) ? $results_edit->submit_department_name : '';  ?>">
			</div>
			<div class="submit_right">
				<p class="label">Column</p>
				<select class="submit_column" name="submit_column">
					<option value="<?php echo (isset($results_edit->submit_column)) ? $results_edit->submit_column : '';  ?>"><?php echo $results_edit->submit_column_name; ?></option>
					<?php foreach($result_array['columns'] as $swimlane_columns): ?>
					<?php if($swimlane_columns['name'] != $results_edit->submit_column_name): ?>
					<option value="<?php echo $swimlane_columns['uniqueId']; ?>"><?php echo $swimlane_columns['name']; ?></option>
					<?php endif; endforeach; ?>
				</select>
				<input type="hidden" name="submit_column_name" class="submit_column_name" id="submit_column_name" value="<?php echo (isset($results_edit->submit_column_name)) ? $results_edit->submit_column_name : '';  ?>">
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<p class="label">Schedule Each</p>				
				<select class="submit_schedule_each" name="submit_schedule_each">
					<option value="<?php echo (isset($results_edit->submit_schedule_each)) ? $results_edit->submit_schedule_each : '';  ?>"><?php echo $results_edit->submit_schedule_each; ?></option>
					<?php foreach($submit_schedule_each_options as $submit_schedule_each_option): ?>
					<?php if($submit_schedule_each_option != $results_edit->submit_schedule_each): ?>
					<option><?php echo $submit_schedule_each_option; ?></option>
					<?php endif; endforeach; ?>
				</select>
			</div>
			<div class="submit_right">
				<p class="label">Starting Date</p>
				<input type="text" class="submit_starting_date" name="submit_starting_date" value="<?php echo (isset($results_edit->submit_starting_date)) ? $results_edit->submit_starting_date : '';  ?>" />
			</div>
		</div>
		<input type="submit" name="submit" class="button_1 submit_button" value="Update Task" />
		<a class="button_2" href="/manage-projects/submit-new-task/">Cancel</a>
	</form>
</div>

<?php get_footer(); ?>