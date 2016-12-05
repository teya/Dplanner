<?php /* Template Name: Checklist Task */ ?>
<?php get_header(); ?>
<?php if ( is_user_logged_in() ){ ?>
<?php 
$current_user_details = wp_get_current_user();
$current_user_role = $current_user_details->roles[0];
$current_user_fullname = $current_user_details->data->display_name;
$table_name = $wpdb->prefix . "custom_checklist_task";
$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 
$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category";
?>
<?php 
$today = date('m/d/Y');
if(isset($_POST['update_checklists'])){
	$checklist_task_id = (isset($_POST['checklist_task_id']) ? $_POST['checklist_task_id'] : '');
	$task_checklist_items = (isset($_POST['checklist']) ? $_POST['checklist'] : '');
	$checklist_category_array = array();
	if($task_checklist_items != null){
		foreach($task_checklist_items as $checklist_category){			
			$checklist_category_explode = explode("<__>", $checklist_category);			
			$checklist_description_category_explode = explode('_', $checklist_category_explode[1]);
			$checklist_name = stripslashes($checklist_category_explode[0]);
			$checklist_description = $checklist_description_category_explode[0];
			$checklist_category_priority = $checklist_description_category_explode[1];
			$checklist_category_name = $checklist_description_category_explode[2];
			
			$checklist_category_array[$checklist_category_priority ."_". $checklist_category_name][] = $checklist_name ."<__>". $checklist_description;
			
		}
		$serialized = serialize($checklist_category_array);	
	}

	
	$check_checklist_task = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = $checklist_task_id");
	$task_checklist_items = $check_checklist_task->task_checklist_items;
	if($task_checklist_items == null){
		$insert = $wpdb->update( $table_name , array( 
			'task_checklist_items'	=> $serialized
		),	
		array( 'ID' => $checklist_task_id ),
		array( '%s', '%s' ));
	}else{
		$unserialized = unserialize($task_checklist_items);
		$merge_template_check_list = array_merge($unserialized, $checklist_category_array);		
		$serialized = serialize($merge_template_check_list);
		$insert = $wpdb->update( $table_name , array( 
			'task_checklist_items'	=> $serialized
		),	
		array( 'ID' => $checklist_task_id ),
		array( '%s', '%s' ));		
	}
}
if(isset($_POST['complete_checklists'])){
	$checkboxes_count = (isset($_POST['checkboxes_count']) ? $_POST['checkboxes_count'] : '');
	$task_checklist_items = (isset($_POST['checklist']) ? $_POST['checklist'] : '');
	$checked_checkboxes_count = count($task_checklist_items);	
	
	if($checkboxes_count == $checked_checkboxes_count){
		$checklist_task_id = (isset($_POST['checklist_task_id']) ? $_POST['checklist_task_id'] : '');
		$checklist_category_array = array();
		if($task_checklist_items != null){
			foreach($task_checklist_items as $checklist_category){			
				$checklist_category_explode = explode("<__>", $checklist_category);			
				$checklist_description_category_explode = explode('_', $checklist_category_explode[1]);
				$checklist_name = stripslashes($checklist_category_explode[0]);
				$checklist_description = $checklist_description_category_explode[0];
				$checklist_category_priority = $checklist_description_category_explode[1];
				$checklist_category_name = $checklist_description_category_explode[2];
				
				$checklist_category_array[$checklist_category_priority ."_". $checklist_category_name][] = $checklist_name ."<__>". $checklist_description;
				
			}
			$serialized = serialize($checklist_category_array);	
		}
		
		
		$check_checklist_task = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = $checklist_task_id");
		$task_checklist_items = $check_checklist_task->task_checklist_items;
		if($task_checklist_items == null){			
			$insert = $wpdb->update( $table_name , array( 
			'task_checklist_items'			=> $serialized,
			'task_checklist_date_completed'	=> $today,
			'task_checklist_status'			=> 'Completed'
			),	
			array( 'ID' => $checklist_task_id ),
			array( '%s', '%s' ));
		}else{			
			$unserialized = unserialize($task_checklist_items);
			$merge_template_check_list = array_merge($unserialized, $checklist_category_array);			
			$serialized = serialize($merge_template_check_list);
			$insert = $wpdb->update( $table_name , array( 
			'task_checklist_items'			=> $serialized,
			'task_checklist_date_completed'	=> $today,
			'task_checklist_status'			=> 'Completed'
			),	
			array( 'ID' => $checklist_task_id ),
			array( '%s', '%s' ));
		}	
	}else{
		echo "<p class='text_red'>Error: Only " .$checked_checkboxes_count. " out of " .$checkboxes_count. " checkboxes are checked.</p>";
	}
}
?>
<?php 
$tasks_checklist_ongoing = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_checklist_person_name='$current_user_fullname' AND task_checklist_status='Ongoing'");
if($current_user_role == 'administrator'){
	$tasks_checklist_completed = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_checklist_status='Completed'");
}else{
	$tasks_checklist_completed = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_checklist_person_name='$current_user_fullname' AND task_checklist_status='Completed'");
}
$tasks_checklist_person = $wpdb->get_results("SELECT DISTINCT task_checklist_person_name FROM {$table_name} WHERE task_checklist_status='Ongoing'")
?>
<div class="checklist_task">
	<h3>Your ongoing checklist tasks:</h3>
	<div class="section">
		<?php if($current_user_role == 'administrator'){ ?>
		<div class="left">
			<p class="label">Person Name</p>
		</div>
		<div class="right">
			<select name="checklist_person" class="checklist_person">
				<option><?php echo $current_user_fullname; ?></option>
				<?php foreach($tasks_checklist_person as $checklist_person){ ?>						
					<?php if($checklist_person->task_checklist_person_name != $current_user_fullname){ 	?>
						<option><?php echo $checklist_person->task_checklist_person_name; ?></option>
					<?php } ?>
				<?php } ?>
			</select>				
			<div style="display:none;" class="checklist_person_loader loader"></div>				
		</div>
		<?php }else{ ?>
			<input type="hidden" name="checklist_person" class="checklist_person" value="<?php echo $current_user_fullname; ?>">
		<?php } ?>
		<div class="left">
			<p class="label">Checklist Template</p>
		</div>
		<div class="right">
			<select name="checklist_template" class="checklist_template">
				<?php foreach($tasks_checklist_ongoing as $key => $checklist_template){ ?>
					<option value="<?php echo $checklist_template->ID; ?>"><?php echo $checklist_template->task_checklist_template; ?></option>
					<?php
						if($key == 0){
							$selected_template = $checklist_template->task_checklist_template;
						}
					?>
				<?php } ?>
			</select>			
			<div style="display:none;" class="checklist_template_loader loader"></div>				
		</div>				
	</div>
	<div class="border_separator"></div>
	<div class="checklist">
		<form action="" method="post" name="task_checklist_form" id="task_checklist_form">
			<input type="hidden" class="checkboxes_count" name="checkboxes_count" value="" />
			<?php $checklist_task = $wpdb->get_row("SELECT * FROM {$table_name} WHERE task_checklist_template = '$selected_template'"); ?>
			<input type="hidden" class="checklist_task_id" name="checklist_task_id" value="<?php echo $checklist_task->ID; ?>" />
			<div class="columns">
				<div class="column">
					<?php 
						$checked_task_checklists = $wpdb->get_row("SELECT * FROM {$table_name} WHERE task_checklist_template = '$selected_template' AND task_checklist_person_name='$current_user_fullname'");
						$checked_items_array = array();												
						$unserialized = unserialize($checked_task_checklists->task_checklist_items);
						if($unserialized != null){
							foreach($unserialized as $key => $checklist_items){
								foreach($checklist_items as $checklist_item){
									$checked_items_array[] = $checklist_item ."_". $key;
								}							
							}
						}
						$checklist_project = $checked_task_checklists->task_checklist_project_name;
						$checklist_client = $checked_task_checklists->task_checklist_client_name;
					?>
					<div class="checklist_class_labels">
						<p class="chekclist_project label">Project Name: <span><?php echo $checklist_project; ?></span>
						<p class="chekclist_client label">Client Name: <span><?php echo $checklist_client; ?></span></p>
					</div>
					<?php $checklists = $wpdb->get_results("SELECT * FROM {$table_name_checklist_template} WHERE checklist_template = '$selected_template'"); ?>					
					<?php 
						foreach($checklists as $checklist) { 
						$checklist_items = unserialize($checklist->checklist_items);
						if($checklist_items != null){
							ksort($checklist_items);						
								foreach($checklist_items as $checklist_category => $checklist_item){								
									$checklist_category_priority_explode = explode('_', $checklist_category);
									$checklist_category_name = $checklist_category_priority_explode[1];
									$check_category = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE check_list_category = '$checklist_category_name'");								
									$check_category_id = $check_category->ID;
						?>
							<?php  ?>
							<div class="check_group">
								<div class="group_title"><h3><?php echo $checklist_category_name; ?></h3></div>
								<div class="checkboxes">
									<?php 								
										if($checklist_item != null){
											foreach($checklist_item as $key => $checklist){
												$checklist_item_explode = explode('<__>', $checklist);																				
												$checklist_name = stripslashes($checklist_item_explode[0]);
												$checklist_description = $checklist_item_explode[1];
												$checklist_value = $checklist_name .'<__>'. $checklist_description .'_'. $checklist_category;
												$checklist_description_display = find_url($checklist_description);
											?>
											<div id="checklist_item_display_<?php echo $check_category_id ."_". $key; ?>" class="checklist_item_display">
												<label  class="checklist_label">
													<input type="checkbox" <?php echo (in_array($checklist_value, $checked_items_array)) ? "checked" : ""; ?> name="checklist[]" class="template_checklist" value="<?php echo $checklist_value; ?>" />
													<?php echo $checklist_name; ?>
												</label>	
												<?php if($checklist_description != null){ ?>
													<div id="checklist_item_display_<?php echo $check_category_id ."_". $key; ?>" class="has_description closed"></div>
												<?php } ?>												
												<div style="display:none;" id="checklist_description_<?php echo $check_category_id ."_". $key; ?>" class="checklist_description_display">
													<span class="span_bold"><?php echo $checklist_name; ?>: </span><?php echo $checklist_description_display; ?>
												</div>
											</div>
											
											<?php 
											} 
										}
									?>
								</div>
							</div>
						<?php 
								}
							}
						}
					?>
				</div>
			</div>
			<input type="submit" name="update_checklists" class="button_1 add_button" value="Update" />
			<input type="submit" name="complete_checklists" class="button_1 add_button" value="Complete" />			
		</form>
	</div>
	<?php if($current_user_role == 'administrator'){ ?>
		<div class="accordian completed_checklist">
			<h5 class="toggle">
				<a href="#"><span class="arrow"></span>Completed Checklist</a>				
			</h5>
			<div class="toggle-content" style="display: none;">
				<div class="header_titles">
					<div class="first_column column">
						<p class="table_header">Checklist</p>
					</div>
					<div class="second_column column">
						<p class="table_header">Project</p>
					</div>
					<div class="third_column column">
						<p class="table_header">Client</p>
					</div>
					<div class="fourth_column column">
						<p class="table_header">Person</p>
					</div>
					<div class="fifth_column column">
						<p class="table_header">Date Completed</p>
					</div>
				</div>
				
				<?php
					$counter = 1;
					$item_count = count($tasks_checklist_completed);
					foreach($tasks_checklist_completed as $task_checklist_completed){						
						$completed_id = $task_checklist_completed->ID;
						$template_name = $task_checklist_completed->task_checklist_template;
						$project_name = $task_checklist_completed->task_checklist_project_name;
						$client_name = $task_checklist_completed->task_checklist_client_name;
						$date_completed = $task_checklist_completed->task_checklist_date_completed;
						$person_name = $task_checklist_completed->task_checklist_person_name;
						$completed_items = unserialize($task_checklist_completed->task_checklist_items);
						ksort($completed_items);	
				?>			
						<div class="info_div <?php echo ($counter == $item_count) ? "info_div_last" : ""; ?>">
							<div class="first_column column"><p><?php echo $template_name; ?></p></div>
							<div class="second_column column"><p><?php echo $project_name; ?></p></div>
							<div class="third_column column"><p><?php echo $client_name; ?></p></div>
							<div class="fourth_column column"><p><?php echo $person_name; ?></p></div>
							<div class="fifth_column column"><p><?php echo $date_completed; ?></p></div>							
							<div class="sixth_column column">
								<div class="custom_accordian completed_checklis_items">
									<h5 id="custom_toggle_<?php echo $completed_id; ?>" class="custom_toggle">
										<span class="arrow"></span>						
									</h5>								
								</div>
							</div>
							<div class="seventh_column column"><a class="test button_2"  href="/checklist-pdf/?id=<?php echo $completed_id; ?>" target="_blank">PDF</a></div>
						</div>						
						<div id="custom_toggle_content_<?php echo $completed_id; ?>" class="custom_toggle_content <?php echo ($counter == $item_count) ? "custom_toggle_content_last" : ""; ?>" style="display: none;">
							<div class="checklist_items_container">
							<?php foreach($completed_items as $completed_category => $completed_item){ 
									$completed_category_explode = explode('_', $completed_category);
									$completed_category = $completed_category_explode[1];
									$check_category = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE check_list_category = '$completed_category'");								
									$check_category_id = $check_category->ID;
							?>
								<div class="completed_items">
									<p class="category"><?php echo $completed_category ?></p>
									<?php 
										foreach($completed_item as $key => $item){ 
										$item_explode = explode('<__>', $item);
										$checklist_name = $item_explode[0];
										$checklist_description = $item_explode[1];
										$checklist_description_display = find_url($checklist_description);
									?>
										
										<div class="checklist_item_container">
											<p class="completed_checklist_items"><?php echo $checklist_name; ?></p>
											<?php if($checklist_description != null){ ?>
												<div id="completed_checklist_item_display_<?php echo $check_category_id ."_". $key; ?>" class="completed_has_description closed"></div>
											<?php } ?>												
											<div style="display:none;" id="completed_checklist_description_<?php echo $check_category_id ."_". $key; ?>" class="completed_checklist_description_display">
												<span class="span_bold"><?php echo $checklist_name; ?>: </span><?php echo $checklist_description_display; ?>
											</div>
										</div>
									<?php }	?>
								</div>
							<?php }	?>
							</div>
						</div>
					<?php $counter++; ?>
				<?php } ?>				
			</div>	
		</div>
	<?php }else{ ?>
		<div class="accordian completed_checklist">
			<h5 class="toggle">
				<a href="#"><span class="arrow"></span>Completed Checklist</a>
				<div style="display: none;" class="schedule_start_task_loader"></div>
			</h5>
			<div class="toggle-content" style="display: none;">
				<div class="header_titles">
					<div class="first_column column">
						<p class="table_header">Template</p>
					</div>
					<div class="second_column column">
						<p class="table_header">Project</p>
					</div>
					<div class="third_column column">
						<p class="table_header">Client</p>
					</div>
					<div class="fourth_column column">
						<p class="table_header">Date Completed</p>
					</div>
				</div>
				<?php 
					foreach($tasks_checklist_completed as $task_checklist_completed){				
						$template_name = $task_checklist_completed->task_checklist_template;
						$project_name = $task_checklist_completed->task_checklist_project_name;
						$client_name = $task_checklist_completed->task_checklist_client_name;
						$date_completed = $task_checklist_completed->task_checklist_date_completed;
					?>			
					<div class="info_div">
						<div class="first_column column"><p><?php echo $template_name; ?></p></div>
						<div class="second_column column"><p><?php echo $project_name; ?></p></div>
						<div class="third_column column"><p><?php echo $client_name; ?></p></div>
						<div class="fourth_column column"><p><?php echo $date_completed; ?></p></div>
					</div>
				<?php } ?>
			</div>	
		</div>
	<?php } ?>
</div>

<?php
}else{
	echo "<div class='login_box'>";
	if  (function_exists ('wplb_login'))   { wplb_login(); } 
	echo "</div>";
} 
?>
<?php get_footer(); ?>