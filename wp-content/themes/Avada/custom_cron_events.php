<?php /* Template Name: Cron Events */ ?>
<?php get_header(); ?>
<div style="text-align: center; width:100%; float:left">
<h1 style="color:red; font-weight:bold;">PLEASE DO NOT CLOSE THIS TAB</h1>
<p style="color:red; font-weight:bold;">This tab is used for CRONJOB function on Timesheet</p>
<br/>
</div>
<div class="cron_events">
<?php 
global $wp_filter;

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

if (isset($_POST['submit'])) {
	$crons = _unschedule_event($_POST['time'], $_POST['procname'], $_POST['key']);
?>
		<div id="message" class="updated fade">
			<p>Sucessfully unscheduled <?php echo $_POST['procname'] ?></p>
		</div>
<?php
}
?>
	<div class="wrap">
		<div style="width:100%; float:left; margin-bottom:10px;">
			<div class="header_titles">Cron Name</div>
			<div class="header_titles">Task Name</div>
			<div class="header_titles">Task Description</div>
			<div class="header_titles">Task Label</div>
			<div class="header_titles">Cron Status</div>
			<div class="header_titles">Next Schedule</div>
		</div>
	</div>
<?php 
		$timeslots = $crons == '' ? _get_cron_array() : $crons;	
		if ( empty($timeslots) ) { 
?>
			<div style="margin:.5em 0;width:100%;">
				<p>Nothing scheduled</p>
			</div>
<?php	}else{ ?>
	
<?php
			$count = 1;
			foreach ( $timeslots as $time => $tasks ) {
?>
				
<?php 
				foreach ($tasks as $procname => $task) {
					if (substr($procname, 0, 3) != 'wp_' && substr($procname, 0, 8) != 'do_pings'){
?>					
					
<?php 
						$prockey = '';
						foreach ($task as $key => $args) {
							$prockey = $key;
						
							if($tasks[$procname][$prockey]['args'] != null){
								//print_var($tasks[$procname][$prockey]['args']);
								$task_name = $tasks[$procname][$prockey]['args']['task_name']; 
								$task_description = $tasks[$procname][$prockey]['args']['task_description'];
								$task_label = $tasks[$procname][$prockey]['args']['task_label'];
								}else{
								$task_name = "--";
								$task_description = "--";
								$task_label = "--";
							}
?>
							<div class="detail_row">
								<div id="tasks-<?php echo $count; ?>" class="detail_column"><?php echo $procname ?></div>
								<div class="detail_column"><?php echo $task_name; ?></div>
								<div class="detail_column"><?php echo $task_description; ?></div>
								<div class="detail_column"><?php echo $task_label; ?></div>
<?php							if ( function_exists('has_action') ) { ?>
									<div class="detail_column">
<?php								if( has_action( $procname )){ ?>
											<span style="color:green;" >&#8730; action exists</span>
<?php								}else{ ?>
											<span style="color:red;">X no action exists with this name</span>
<?php								} ?>
									</div>
<?php							} ?>
								<div class="detail_column"><?php echo date('Y/m/d H:i:s', get_tz_timestamp($time)); ?></div>
								<form style="float:left; width: 45px;" method="post">
									<input type="hidden" name="procname" value="<?php echo $procname; ?>" />
									<input type="hidden" name="time" value="<?php echo $time; ?>" />
									<input type="hidden" name="key" value="<?php echo $prockey; ?>" />
									<input name="submit" class="detail_column" type="submit" value="Delete"/>
								</form>
		<?php 				$count++; ?>
							</div>
<?php 					}
					}
				}
			}
		}
?>
</div>
<a style="margin-top:20px; float:left; height: 15px; line-height: 15px;" href="/manage-projects/submit-new-task/" class="button_2">Submit Task</a>
<div class="check_empty_day">
<?php // daily_email_empty_task(); ?>
<?php
	global $wpdb; 
	$table_name_submit_task = $wpdb->prefix . "custom_submit_task";
	$submitted_tasks = $wpdb->get_results("SELECT * FROM {$table_name_submit_task}");
	foreach($submitted_tasks as $submitted_task){		
		$id = $submitted_task->ID;
		$month_year_week_status = $submitted_task->submit_task_name_suffix_time;
		$month_year_week_explode = explode("_", $month_year_week_status);
		$checker = $month_year_week_explode[0];		
		$month_year_week_value = $month_year_week_explode[1];		
		$current_month = date('F');
		$current_year = date('Y');
		$current_week = date('W');
		$submit_task_name_suffix = $submitted_task->submit_task_name_suffix;
		$month_array = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		
		if($checker != null){
			if($checker == '%month%'){
				if($month_year_week_value != $current_month){
					$replace_current_month = str_replace($month_year_week_value,$current_month,$submit_task_name_suffix);
					$update = $wpdb->update($table_name_submit_task, 
					array(
					'submit_task_name_suffix' => $replace_current_month,
					'submit_task_name_suffix_time' => '%month%_' . $current_month
					),
					array( 'ID' => $id ),
					array( '%s', '%s' ));
				}
			}
			if($checker == '%year%'){
				if($month_year_week_value != $current_year){
					$replace_current_year = str_replace($month_year_week_value,$current_year,$submit_task_name_suffix);
					$update = $wpdb->update($table_name_submit_task, 
					array(
					'submit_task_name_suffix' => $replace_current_year,
					'submit_task_name_suffix_time' => '%year%_' . $current_year
					),
					array( 'ID' => $id ),
					array( '%s', '%s' ));
				}
			}
			if($checker == '%week%'){
				if($month_year_week_value != $current_week){
					$replace_current_week = str_replace($month_year_week_value,$current_week,$submit_task_name_suffix);
					$update = $wpdb->update($table_name_submit_task, 
					array(
					'submit_task_name_suffix' => $replace_current_week,
					'submit_task_name_suffix_time' => '%week%_' . $current_week
					),
					array( 'ID' => $id ),
					array( '%s', '%s' ));
				}
			}
		}else{
			foreach($month_array as $month){
				if (strpos($submit_task_name_suffix, $month) !== false) {
					if($month != $current_month){
						$replace_current_month = str_replace($month,$current_month,$submit_task_name_suffix);
						$update = $wpdb->update($table_name_submit_task, 
						array(
							'submit_task_name_suffix' => $replace_current_month,
							'submit_task_name_suffix_time' => '%month%_' . $current_month
						),
						array( 'ID' => $id ),
						array( '%s', '%s' ));
					}
				}
			}
		}
	}
?>
</div>
<div class="add_latest_goal">
	<?php 
		$table_name_person = $wpdb->prefix . "custom_person";
		$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
		$table_name_goal = $wpdb->prefix . "custom_goals";
		$goals = $wpdb->get_results("SELECT * FROM {$table_name_goal}");
				
		$person_goal_array = array();
		foreach($persons as $person){			
			$person_goals = unserialize($person->person_goal);			
			if($person_goals != null){
				foreach($person_goals as $person_goal){
					$person_goal_explode = explode('_', $person_goal);
					$person_goal_type = $person_goal_explode[0];
					$person_goal_year = $person_goal_explode[1];
					$person_goal_time = $person_goal_explode[2];
					$person_goal_key = $person_goal_explode[3];
					$person_id = $person->ID;
					if($person_goal_type == 'personalyearly' || $person_goal_type == 'personalmonthly'){
						$person_goal_type_array = $person_goal_type ."_". $person_goal_year ."_". $person_goal_time ."_". $person_goal_key ."_". $person_id;
					}else{
						$person_goal_type_array = $person_goal_type ."_". $person_goal_year ."_". $person_goal_time ."_". $person_goal_key;
					}
					
					$person_goal_array[] = $person_goal_type_array;
				}
			}
		}
		$person_goal_unique = array_unique($person_goal_array);		
		
		$person_goal_key_array = array();		
		foreach($person_goal_unique as $person_goal_lists){			
			$person_goal_explode = explode('_', $person_goal_lists);
			$person_goal_type = ucfirst($person_goal_explode[0]);
			$person_goal_year = $person_goal_explode[1];
			$person_goal_time = $person_goal_explode[2];
			$person_goal_key = $person_goal_explode[3];
			$person_goal_key_array[] = $person_goal_lists;			
		}	
		
		$goal_key_array = array();
		foreach($goals as $goal){
			$goal_lists = unserialize($goal->goals);			
			$goal_type = strtolower($goal->goal_type);
			$goal_year = $goal->goal_year;
			$goals_time = $goal->goals_time;
			if($goal_lists != null){
				foreach($goal_lists as $goal_key => $goal_list){
					if($goal->goal_person != null){
						$personal_goal_person_name = $goal->goal_person;
						$personal_goal_person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$personal_goal_person_name'");
						$goal_person_id = $personal_goal_person->ID;
						$goal_type_array = 'personal'.$goal_type ."_". $goal_year ."_". $goals_time ."_". $goal_key ."_". $goal_person_id;
					}else{
						$goal_type_array = $goal_type ."_". $goal_year ."_". $goals_time ."_". $goal_key;
					}
					$goal_key_array[] = $goal_type_array;
				}
			}							
		}	
		
		$unchecked_key_array = array();
		foreach($goal_key_array as $goal_keys){
			if (in_array($goal_keys, $person_goal_key_array)) {
				
			}else{
				$unchecked_key_array[] = $goal_keys;
			}
		}
		
		
		if($unchecked_key_array != null){
			$unchecked_goal_list_array = array();
			foreach($unchecked_key_array as $unchecked_key){			
				$unchecked_key_explode = explode('_', $unchecked_key);				
				$unchecked_goal_type_check = $unchecked_key_explode[0];
				$check_personal_goal = substr($unchecked_goal_type_check, 0, 8);				
				$unchecked_goal_year = $unchecked_key_explode[1];
				$unchecked_goal_time = $unchecked_key_explode[2];
				$unchecked_goal_key = $unchecked_key_explode[3];
				if($check_personal_goal == 'personal'){
					$unchecked_goal_person_id = $unchecked_key_explode[4];
					$unchecked_goal_type = ucfirst(str_replace('personal', '', $unchecked_goal_type_check));
					$unchecked_personal_goal_person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE ID='$unchecked_goal_person_id'");
					$person_fullname = $unchecked_personal_goal_person->person_fullname;
					$goals = $wpdb->get_results("SELECT * FROM {$table_name_goal} WHERE goal_person ='$person_fullname' AND goal_type='$unchecked_goal_type' AND goal_year='$unchecked_goal_year' AND goals_time='$unchecked_goal_time'");					
					foreach($goals as $goal){
						$goal_person = $goal->goal_person;						
						$unchecked_goal_lists = unserialize($goal->goals);						
						foreach($unchecked_goal_lists as $unchecked_goal_list_key => $unchecked_goal_list){
							if($unchecked_goal_list_key == $unchecked_goal_key){								
								$unchecked_goal_list_array[] = $unchecked_goal_type ."_". $unchecked_goal_list ."_". $goal_person;
							}
						}						
					}				
				}else{
					$unchecked_goal_type = ucfirst($unchecked_goal_type_check);
					$goals = $wpdb->get_results("SELECT * FROM {$table_name_goal} WHERE goal_person ='' AND goal_type='$unchecked_goal_type' AND goal_year='$unchecked_goal_year' AND goals_time='$unchecked_goal_time'");
					$personal_unchecked_goal_list_array = array();
					foreach($goals as $goal){						
						$unchecked_goal_lists = unserialize($goal->goals);												
						foreach($unchecked_goal_lists as $unchecked_goal_list_key => $unchecked_goal_list){
							if($unchecked_goal_list_key == $unchecked_goal_key){														
								$unchecked_goal_list_array[] = $unchecked_goal_type ."_". $unchecked_goal_list;							
							}
						}						
					}					
				}				
			}			
		}
		
			
		$count_add_list_array_personalyearly = array();
		$count_add_list_array_personalmonthly = array();
		$count_add_list_array_yearly = array();
		$count_add_list_array_monthly = array();
		if($unchecked_goal_list_array != null){
			foreach($unchecked_goal_list_array as $count_add_goal_list_details){
				$count_add_goal_list_explode = explode('_', $count_add_goal_list_details);
				$count_add_goal_list_type = $count_add_goal_list_explode[0];
				$count_add_goal_list = $count_add_goal_list_explode[1];
				$count_add_goal_person_name = $count_add_goal_list_explode[2];			
				if($count_add_goal_list_type == 'Yearly' && $count_add_goal_person_name != null){
					array_push($count_add_list_array_personalyearly,$count_add_goal_list);
				}
				if($count_add_goal_list_type == 'Monthly' && $count_add_goal_person_name != null){
					array_push($count_add_list_array_personalmonthly,$count_add_goal_list);
				}
				if($count_add_goal_list_type == 'Yearly' && $count_add_goal_person_name == null){
					array_push($count_add_list_array_yearly,$count_add_goal_list);				
				}
				if($count_add_goal_list_type == 'Monthly' && $count_add_goal_person_name == null){
					array_push($count_add_list_array_monthly,$count_add_goal_list);				
				}		
			}
		}
		$count_personalyearly = count($count_add_list_array_personalyearly);
		$count_personalmonthly = count($count_add_list_array_personalmonthly);
		$count_yearly = count($count_add_list_array_yearly);
		$count_monthly = count($count_add_list_array_monthly);		
				
		$add_list_array_personalyearly = array();
		$add_list_array_personalmonthly = array();
		$add_list_array_yearly = array();
		$add_list_array_monthly = array();	
	
		$current_month_name = date('F');							
		$current_year = date('Y');
		
		$current_month_number = date('m');
		if($current_month_number == 1){
			$previous_year = $current_year - 1;
			$previous_month = 12;
			}else{
			$previous_year = $current_year;
			$previous_month = $current_month_number - 1;
		}						
		$previous_month_name = date("F", mktime(0, 0, 0, $previous_month, 10));	
		if($unchecked_goal_list_array != null){		
			foreach($unchecked_goal_list_array as $add_goal_list_details){						
				$add_goal_list_explode = explode('_', $add_goal_list_details);
				$add_goal_list_type = $add_goal_list_explode[0];
				$add_goal_list = $add_goal_list_explode[1];
				$add_goal_person_name = $add_goal_list_explode[2];			
				
				if($add_goal_list_type == 'Yearly' && $add_goal_person_name != null){
					$add_list_array_personalyearly[$add_goal_person_name][] = $add_goal_list;
				}
				if($add_goal_list_type == 'Monthly' && $add_goal_person_name != null){					
						$add_list_array_personalmonthly[$add_goal_person_name][] = $add_goal_list;
				}
				if($add_goal_list_type == 'Yearly' && $add_goal_person_name == null){				
					array_push($add_list_array_yearly, $add_goal_list);
					if(count($add_list_array_yearly) == $count_yearly){
						$serialize = serialize($add_list_array_yearly);				
						$check_yearly_exist = $wpdb->get_results("SELECT * FROM {$table_name_goal} WHERE goal_person ='' AND goal_year='$current_year' AND goals_time='$current_year'");				
						if($check_yearly_exist == null){
							$insert = $wpdb->insert( $table_name_goal , array(
							'goal_person' 	=> '',
							'goal_type'		=> 'Yearly',
							'goals_time'	=> $current_year,
							'goal_year'		=> $current_year,
							'goals'			=> $serialize
							), array( '%s', '%s' ));
						}
					}				
				}
				if($add_goal_list_type == 'Monthly' && $add_goal_person_name == null){
					array_push($add_list_array_monthly, $add_goal_list);
					if(count($add_list_array_monthly) == $count_monthly){
						$serialize = serialize($add_list_array_monthly);
						$check_monthly_exist = $wpdb->get_results("SELECT * FROM {$table_name_goal} WHERE goal_person ='' AND goal_year='$current_year' AND goals_time='$current_month_name'");								
						if($check_monthly_exist == null){
							$insert = $wpdb->insert( $table_name_goal , array(
							'goal_person' 	=> '',
							'goal_type'		=> 'Monthly',
							'goals_time'	=> $current_month_name,
							'goal_year'		=> $current_year,
							'goals'			=> $serialize
							), array( '%s', '%s' ));
						}
					}				
				}			
			}
		}
		
		foreach($add_list_array_personalmonthly as $goal_person_name => $add_personal_monthly_goal_list){
			$serialize = serialize($add_personal_monthly_goal_list);
			$check_personalmonthly_exist = $wpdb->get_results("SELECT * FROM {$table_name_goal} WHERE goal_person ='$goal_person_name' AND goal_year='$current_year' AND goals_time='$current_month_name'");			
			if($check_personalmonthly_exist == null){
				$insert = $wpdb->insert( $table_name_goal , array(
				'goal_person' 	=> $goal_person_name,
				'goal_type'		=> 'Monthly',
				'goals_time'	=> $current_month_name,
				'goal_year'		=> $current_year,
				'goals'			=> $serialize
				), array( '%s', '%s' ));
			}
		}
		
		foreach($add_list_array_personalyearly as $goal_person_name => $add_personal_yearly_goal_list){
			$serialize = serialize($add_personal_yearly_goal_list);
			$check_personalyearly_exist = $wpdb->get_results("SELECT * FROM {$table_name_goal} WHERE goal_person ='$goal_person_name' AND goal_year='$current_year' AND goals_time='$current_year'");					
			if($check_personalyearly_exist == null){
				$insert = $wpdb->insert( $table_name_goal , array(
				'goal_person' 	=> $goal_person_name,
				'goal_type'		=> 'Yearly',
				'goals_time'	=> $current_year,
				'goal_year'		=> $current_year,
				'goals'			=> $serialize
				), array( '%s', '%s' ));
			}
		}
		
		/* END ADD */
		
		$loop_track = 0;
		if($unchecked_goal_list_array != null){
			foreach($unchecked_goal_list_array as $add_goal_list_details){						
				$add_goal_list_explode = explode('_', $add_goal_list_details);
				$add_goal_list_type = $add_goal_list_explode[0];
				$add_goal_list = $add_goal_list_explode[1];
				$add_goal_person_name = $add_goal_list_explode[2];			
							
				if($add_goal_list_type == 'Yearly' && $add_goal_person_name != null){					
					$previous_personalyearly_exist = $wpdb->get_row("SELECT * FROM {$table_name_goal} WHERE goal_person ='$add_goal_person_name' AND goal_year='$previous_year' AND goals_time='$previous_year'");
					if($previous_personalyearly_exist->goals_time != $current_year && $previous_personalyearly_exist->goal_year != $current_year){
						$current_goals_id = $previous_personalyearly_exist->ID;					
						if($loop_track == 0){
							$current_goals = unserialize($previous_personalyearly_exist->goals);
							$loop_track++;
						}
						if($current_goals != null){
							$search_item = array_search($add_goal_list, $current_goals);
							if($current_goals[$search_item] == $add_goal_list){							
								unset($current_goals[$search_item]);
								if($current_goals != null){
									$serialize = serialize($current_goals);	
								}else{
									$serialize = "";	
								}
								$update = $wpdb->update( $table_name_goal , array( 
								'goals'	=> $serialize
								),	
								array( 'ID' => $current_goals_id ),
								array( '%s', '%s' ));
							}
						}
					}				
				}			
				if($add_goal_list_type == 'Monthly' && $add_goal_person_name != null){														
					$previous_personalmonthly_exist = $wpdb->get_row("SELECT * FROM {$table_name_goal} WHERE goal_person ='$add_goal_person_name' AND goal_year='$previous_year' AND goals_time='$previous_month_name'");								
					if($previous_personalmonthly_exist->goals_time != $current_month_name && $previous_personalmonthly_exist->goal_year == $current_year){
						$current_goals_id = $previous_personalmonthly_exist->ID;					
						if($loop_track == 0){
							$current_goals = unserialize($previous_personalmonthly_exist->goals);
							$loop_track++;
						}
						if($current_goals != null){
							$search_item = array_search($add_goal_list, $current_goals);
							if($current_goals[$search_item] == $add_goal_list){
								unset($current_goals[$search_item]);
								if($current_goals != null){
									$serialize = serialize($current_goals);	
								}else{
									$serialize = "";	
								}
								$update = $wpdb->update( $table_name_goal , array( 
								'goals'	=> $serialize
								),	
								array( 'ID' => $current_goals_id ),
								array( '%s', '%s' ));
							}
						}
					}				
				}
				if($add_goal_list_type == 'Yearly' && $add_goal_person_name == null){
					$previous_yearly_exist = $wpdb->get_row("SELECT * FROM {$table_name_goal} WHERE goal_person ='' AND goal_year='$previous_year' AND goals_time='$previous_year'");				
					if($previous_yearly_exist->goals_time != $current_year && $previous_yearly_exist->goal_year != $current_year){
						$current_goals_id = $previous_yearly_exist->ID;					
						if($loop_track == 0){
							$current_goals = unserialize($previous_yearly_exist->goals);
							$loop_track++;
						}
						if($current_goals != null){
							$search_item = array_search($add_goal_list, $current_goals);
							if($current_goals[$search_item] == $add_goal_list){
								unset($current_goals[$search_item]);
								if($current_goals != null){
									$serialize = serialize($current_goals);	
								}else{
									$serialize = "";	
								}
								$update = $wpdb->update( $table_name_goal , array( 
								'goals'	=> $serialize
								),	
								array( 'ID' => $current_goals_id ),
								array( '%s', '%s' ));
							}
						}
					}
				}
				
				if($add_goal_list_type == 'Monthly' && $add_goal_person_name == null){
					$previous_monthly_exist = $wpdb->get_row("SELECT * FROM {$table_name_goal} WHERE goal_person ='' AND goal_year='$previous_year' AND goals_time='$previous_month_name'");
					if($previous_monthly_exist->goals_time != $current_month_name && $previous_monthly_exist->goal_year == $current_year){
						$current_goals_id = $previous_monthly_exist->ID;
						if($loop_track == 0){
							$current_goals = unserialize($previous_monthly_exist->goals);
							$loop_track++;
						}
						if($current_goals != null){
							$search_item = array_search($add_goal_list, $current_goals);
							if($current_goals[$search_item] == $add_goal_list){
								unset($current_goals[$search_item]);
								if($current_goals != null){
									$serialize = serialize($current_goals);	
								}else{
									$serialize = "";	
								}								
								$update = $wpdb->update( $table_name_goal , array( 
									'goals'	=> $serialize
								),	
								array( 'ID' => $current_goals_id ),
								array( '%s', '%s' ));
							}							
						}										
					}
				}
				
				/* END PREVIOUS */
				
			}
		}
	$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
	$url= "https://kanbanflow.com/api/v1/users/?&" . $token;
	$result = file_get_contents($url);	
	$persons_array = json_decode($result, true);
	$table_person = $wpdb->prefix . "custom_person";
	
	foreach($persons_array as $person_array){
		$kanban_id = $person_array['_id'];
		$person_name = $person_array['fullName'];
		$person_details = $wpdb->get_row("SELECT * FROM {$table_person} WHERE person_fullname = '$person_name'");
		$person_kb_user_id = $person_details->person_kb_user_id;
		if($kanban_id != $person_kb_user_id){
			$update = $wpdb->update( $table_person , array( 
				'person_kb_user_id' => $kanban_id
			),	
			array( 'ID' => $id ),
			array( '%s', '%s' ));
		}
	}
	?>
</div>
<script type='text/javascript'>
setTimeout("location.reload();",60000);
</script>
<?php get_footer(); ?>