
	if(date('l') == 'Wednesday'){
		$wpdb->update($table_name,array(
			'status'				=> 0
		),
		array( 'ID' => '' ),
		array( '%s', '%s' ));
	}

if(isset($_POST['import'])):
	$seconds = 50000;
	set_time_limit($seconds);
	$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
	$url="https://kanbanflow.com/api/v1/board?" . $token;	
	$result = file_get_contents($url);	
	$result_array = json_decode($result, true);	
	$counter = 1;
	$task_counter = 1;
	$curr_task = "";
	$cur_user = "";
	
		foreach($result_array['columns'] as $column){
			$get_task_by_column = "https://kanbanflow.com/api/v1/tasks?" . $token . "&columnId=" . $column['uniqueId'];
			$column_content = file_get_contents($get_task_by_column);
			$task = json_decode($column_content, true);
			
			foreach($task as $task_col){
				if($task_col['swimlaneName'] == 'Website Dev'){
					if($counter == 1){
						$swimlane_name = $task_col['swimlaneName']; 											
					}
					$column_name = $task_col['columnName'];					
					foreach($task_col['tasks'] as $single_task){
						$get_task_by_date = "https://kanbanflow.com/api/v1/tasks/". $single_task['_id'] ."/events?from=".date("Y-m-d")."T00:00Z&" . $token;
						$task_by_date = file_get_contents($get_task_by_date);
						$task_now = json_decode($task_by_date, true);
						
						foreach ($task_now as $item){
							if($item != null){
								foreach($item as $event_item){									
									foreach($event_item['detailedEvents'] as $key => $item){										
										$get_task_item = "https://kanbanflow.com/api/v1/tasks/" . $item['taskId'] . "?&" . $token;
										$changed_task = file_get_contents($get_task_item);										
										$task = json_decode($changed_task, true);
										
										$get_task_label = "https://kanbanflow.com/api/v1/tasks/". $task['_id']. "/labels" . "?&" . $token;
										$task_label_array = file_get_contents($get_task_label);
										$task_label_decode = json_decode($task_label_array, true);
										
										$task_name = $task['name'];
										$task_hour = gmdate("H:i:s", $task['totalSecondsSpent']);
										foreach ($task_label_decode as $task_label_item){
											$task_label = $task_label_item['name'];											
											
											$get_task_person = "https://kanbanflow.com/api/v1/users" . "?&" . $token;
											$task_person_array = file_get_contents($get_task_person);
											$task_person_decode = json_decode($task_person_array, true);
											foreach ($task_person_decode as $task_persons){
												// echo $task_persons['_id'] . "======";
												// echo $task['responsibleUserId'] . "======";
												// echo "<pre>";
												// print_r($task_persons);
												// echo "</pre>"; 
												echo $count = count($task['responsibleUserId']);
												if ($task_persons['_id'] != $cur_user) {
													$cur_user = $task_persons['_id'];?>												
													<script>
														jQuery(document).ready(function(){
														<?php 
															
															if($task_persons['_id'] == $task['responsibleUserId']): 
															$task_person = $task_persons['fullName'];
														?>
														jQuery('.tab_content.active .task_person').append("<li><p><?php echo $task_person; ?></p></li>");												
														jQuery('.tab_content.active .import_save').append("<input type='hidden' name='task_person[]' value='<?php echo $task_person; ?>'/>");
														<?php endif; ?>
														});
													</script>
												<?php }
													if ($task_name != $curr_task){												
													$curr_task = $task_name;
?>													<script>
														jQuery(document).ready(function(){
															jQuery('.tab_content.active .task_name').append("<li><p><?php echo $task_name; ?></p></li>");
															jQuery('.tab_content.active .task_hour').append("<li><p><?php echo $task_hour; ?></p></li>");
															jQuery('.tab_content.active .task_label').append("<li><p><?php echo $task_label; ?></p></li>");
															
															
															jQuery('.tab_content.active .import_save').append("<input type='hidden' name='date_now' value='<?php echo $date_now; ?>' />");
															jQuery('.tab_content.active .import_save').append("<input type='hidden' name='task_name[]' value='<?php echo $task_name; ?>'/>");
															jQuery('.tab_content.active .import_save').append("<input type='hidden' name='task_hour[]' value='<?php echo $task_hour; ?>'/>");												
															jQuery('.tab_content.active .import_save').append("<input type='hidden' name='task_label[]' value='<?php echo $task_label; ?>'/>");	
															
															
														});
													</script>
<?php												
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
	$counter++;
		}
endif;