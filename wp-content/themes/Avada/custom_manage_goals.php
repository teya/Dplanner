<?php /* Template Name: Goals */ ?>
<?php get_header(); ?>
<?php 
$table_name = $wpdb->prefix . "custom_goals"; 
$goals = $wpdb->get_results("SELECT * FROM {$table_name}");
$table_name_person = $wpdb->prefix . "custom_person";
$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
?>
<div class="goals">	
	<a id="create_goals" class="button_1 add_goals" href="/add-goals/">+ Add Goals</a>	
</div>
<div class="display_main">
	<div class="display_section goals">
		<?php 
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
			
			$checked_key_array = array();
			$unchecked_key_array = array();
			foreach($goal_key_array as $goal_keys){
				if (in_array($goal_keys, $person_goal_key_array)) {
					$checked_key_array[] = $goal_keys;
				}else{
					$unchecked_key_array[] = $goal_keys;
				}
			}
			/* CHECKED GOALS */		
			
			if($checked_key_array != null){
				$checked_goal_list_array = array();
				foreach($checked_key_array as $checked_key){			
					$checked_key_explode = explode('_', $checked_key);				
					$checked_goal_type_check = $checked_key_explode[0];
					$check_personal_goal = substr($checked_goal_type_check, 0, 8);				
					$checked_goal_year = $checked_key_explode[1];
					$checked_goal_time = $checked_key_explode[2];
					$checked_goal_key = $checked_key_explode[3];
					if($check_personal_goal == 'personal'){
						$checked_goal_person_id = $checked_key_explode[4];
						$checked_goal_type = ucfirst(str_replace('personal', '', $checked_goal_type_check));
						$checked_personal_goal_person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE ID='$checked_goal_person_id'");
						$person_fullname = $checked_personal_goal_person->person_fullname;
						$goals = $wpdb->get_results("SELECT * FROM {$table_name} WHERE goal_person ='$person_fullname' AND goal_type='$checked_goal_type' AND goal_year='$checked_goal_year' AND goals_time='$checked_goal_time'");					
						foreach($goals as $goal){
							$goal_person = $goal->goal_person;						
							$checked_goal_lists = unserialize($goal->goals);							
							foreach($checked_goal_lists as $checked_goal_list_key => $checked_goal_list){
								if($checked_goal_list_key == $checked_goal_key){									
									$checked_goal_list_array[] = $checked_goal_type ."_". $checked_goal_time ."_". $checked_goal_year ."_". $checked_goal_list ."_". $checked_goal_key ."_". $goal_person;
								}
							}						
						}				
					}else{
						$checked_goal_type = ucfirst($checked_goal_type_check);
						$goals = $wpdb->get_results("SELECT * FROM {$table_name} WHERE goal_person ='' AND goal_type='$checked_goal_type' AND goal_year='$checked_goal_year' AND goals_time='$checked_goal_time'");
						$personal_checked_goal_list_array = array();
						foreach($goals as $goal){						
							$checked_goal_lists = unserialize($goal->goals);												
							foreach($checked_goal_lists as $checked_goal_list_key => $checked_goal_list){
								if($checked_goal_list_key == $checked_goal_key){														
									$checked_goal_list_array[] = $checked_goal_type ."_". $checked_goal_time ."_". $checked_goal_year ."_". $checked_goal_list ."_". $checked_goal_key;
								}
							}						
						}					
					}				
				}			
			}
			
			$check_yearly_inarray = array();
			$check_monthly_inarray = array();
			$personal_check_yearly_inarray = array();
			$personal_check_monthly_inarray = array();
			if($checked_goal_list_array != null){
				foreach($checked_goal_list_array as $checked_goal_list){
					$checked_goal_list_explode = explode('_', $checked_goal_list);							
					$display_goal_type = $checked_goal_list_explode[0];
					$display_goal_time = $checked_goal_list_explode[1];
					$display_goal_year = $checked_goal_list_explode[2];
					$display_goal_item = $checked_goal_list_explode[3];
					$display_goal_key = $checked_goal_list_explode[4];
					$display_goal_person = $checked_goal_list_explode[5];				
					if($display_goal_type == 'Yearly' && $display_goal_person == null){								
						$yearly_goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goal_person ='' AND goal_type='$display_goal_type' AND goal_year='$display_goal_year' AND goals_time='$display_goal_time'");
						$yearly_unserialize = unserialize($yearly_goals->goals);					
						if($yearly_unserialize != null){
							foreach($yearly_unserialize as $key => $yearly_items){
								if($display_goal_key == $key){
									$check_yearly_inarray[] = $yearly_goals->goal_type ."_". $yearly_goals->goals_time ."_". $yearly_goals->goal_year ."_". $yearly_items ."_". $key;
								}
							}
						}
					}
					if($display_goal_type == 'Monthly' && $display_goal_person == null){								
						$monthly_goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goal_person ='' AND goal_type='$display_goal_type' AND goal_year='$display_goal_year' AND goals_time='$display_goal_time'");
						$monthly_unserialize = unserialize($monthly_goals->goals);					
						if($monthly_unserialize != null){
							foreach($monthly_unserialize as $key => $monthly_items){
								if($display_goal_key == $key){
									$check_monthly_inarray[] = $monthly_goals->goal_type ."_". $monthly_goals->goals_time ."_". $monthly_goals->goal_year ."_". $monthly_items ."_". $key;
								}
							}
						}
					}
					if($display_goal_type == 'Yearly' && $display_goal_person != null){								
						$yearly_goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goal_person ='$display_goal_person' AND goal_type='$display_goal_type' AND goal_year='$display_goal_year' AND goals_time='$display_goal_time'");
						$yearly_unserialize = unserialize($yearly_goals->goals);					
						if($yearly_unserialize != null){
							foreach($yearly_unserialize as $key => $yearly_items){
								if($display_goal_key == $key){
									$personal_check_yearly_inarray[] = $yearly_goals->goal_type ."_". $yearly_goals->goals_time ."_". $yearly_goals->goal_year ."_". $yearly_items ."_". $key ."_". $yearly_goals->goal_person;
								}
							}
						}
					}	
					if($display_goal_type == 'Monthly' && $display_goal_person != null){								
						$yearly_goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goal_person ='$display_goal_person' AND goal_type='$display_goal_type' AND goal_year='$display_goal_year' AND goals_time='$display_goal_time'");
						$yearly_unserialize = unserialize($yearly_goals->goals);					
						if($yearly_unserialize != null){
							foreach($yearly_unserialize as $key => $yearly_items){
								if($display_goal_key == $key){
									$personal_check_monthly_inarray[] = $yearly_goals->goal_type ."_". $yearly_goals->goals_time ."_". $yearly_goals->goal_year ."_". $yearly_items ."_". $key ."_". $yearly_goals->goal_person;
								}
							}
						}
					}				
				}
			}
			/* UNCHECKED GOALS */
						
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
						$goals = $wpdb->get_results("SELECT * FROM {$table_name} WHERE goal_person ='$person_fullname' AND goal_type='$unchecked_goal_type' AND goal_year='$unchecked_goal_year' AND goals_time='$unchecked_goal_time'");					
						foreach($goals as $goal){
							$goal_person = $goal->goal_person;						
							$unchecked_goal_lists = unserialize($goal->goals);						
							foreach($unchecked_goal_lists as $unchecked_goal_list_key => $unchecked_goal_list){
								if($unchecked_goal_list_key == $unchecked_goal_key){
									$unchecked_goal_list_array[] = $unchecked_goal_type ."_". $unchecked_goal_time ."_". $unchecked_goal_year ."_". $unchecked_goal_list ."_". $unchecked_goal_key ."_". $goal_person;									
								}
							}						
						}				
						}else{
						$unchecked_goal_type = ucfirst($unchecked_goal_type_check);
						$goals = $wpdb->get_results("SELECT * FROM {$table_name} WHERE goal_person ='' AND goal_type='$unchecked_goal_type' AND goal_year='$unchecked_goal_year' AND goals_time='$unchecked_goal_time'");
						$personal_unchecked_goal_list_array = array();
						foreach($goals as $goal){						
							$unchecked_goal_lists = unserialize($goal->goals);												
							foreach($unchecked_goal_lists as $unchecked_goal_list_key => $unchecked_goal_list){
								if($unchecked_goal_list_key == $unchecked_goal_key){														
									$unchecked_goal_list_array[] = $unchecked_goal_type ."_". $unchecked_goal_time ."_". $unchecked_goal_year ."_". $unchecked_goal_list ."_". $unchecked_goal_key;
								}
							}						
						}					
					}				
				}			
			}
			
			$uncheck_yearly_inarray = array();
			$uncheck_monthly_inarray = array();
			$personal_uncheck_yearly_inarray = array();
			$personal_uncheck_monthly_inarray = array();
			if($unchecked_goal_list_array != null){
				foreach($unchecked_goal_list_array as $unchecked_goal_list){
					$unchecked_goal_list_explode = explode('_', $unchecked_goal_list);							
					$display_goal_type = $unchecked_goal_list_explode[0];
					$display_goal_time = $unchecked_goal_list_explode[1];
					$display_goal_year = $unchecked_goal_list_explode[2];
					$display_goal_item = $unchecked_goal_list_explode[3];
					$display_goal_key = $unchecked_goal_list_explode[4];
					$display_goal_person = $unchecked_goal_list_explode[5];				
					if($display_goal_type == 'Yearly' && $display_goal_person == null){								
						$yearly_goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goal_person ='' AND goal_type='$display_goal_type' AND goal_year='$display_goal_year' AND goals_time='$display_goal_time'");
						$yearly_unserialize = unserialize($yearly_goals->goals);					
						if($yearly_unserialize != null){
							foreach($yearly_unserialize as $key => $yearly_items){
								if($display_goal_key == $key){
									$uncheck_yearly_inarray[] = $yearly_goals->goal_type ."_". $yearly_goals->goals_time ."_". $yearly_goals->goal_year ."_". $yearly_items ."_". $key;
								}
							}
						}
					}
					if($display_goal_type == 'Monthly' && $display_goal_person == null){								
						$monthly_goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goal_person ='' AND goal_type='$display_goal_type' AND goal_year='$display_goal_year' AND goals_time='$display_goal_time'");
						$monthly_unserialize = unserialize($monthly_goals->goals);					
						if($monthly_unserialize != null){
							foreach($monthly_unserialize as $key => $monthly_items){
								if($display_goal_key == $key){
									$uncheck_monthly_inarray[] = $monthly_goals->goal_type ."_". $monthly_goals->goals_time ."_". $monthly_goals->goal_year ."_". $monthly_items ."_". $key;
								}
							}
						}
					}
					if($display_goal_type == 'Yearly' && $display_goal_person != null){								
						$yearly_goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goal_person ='$display_goal_person' AND goal_type='$display_goal_type' AND goal_year='$display_goal_year' AND goals_time='$display_goal_time'");
						$yearly_unserialize = unserialize($yearly_goals->goals);					
						if($yearly_unserialize != null){
							foreach($yearly_unserialize as $key => $yearly_items){
								if($display_goal_key == $key){
									$personal_uncheck_yearly_inarray[] = $yearly_goals->goal_type ."_". $yearly_goals->goals_time ."_". $yearly_goals->goal_year ."_". $yearly_items ."_". $key ."_". $yearly_goals->goal_person;
								}
							}
						}
					}
					if($display_goal_type == 'Monthly' && $display_goal_person != null){								
						$yearly_goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goal_person ='$display_goal_person' AND goal_type='$display_goal_type' AND goal_year='$display_goal_year' AND goals_time='$display_goal_time'");
						$yearly_unserialize = unserialize($yearly_goals->goals);					
						if($yearly_unserialize != null){
							foreach($yearly_unserialize as $key => $yearly_items){
								if($display_goal_key == $key){
									$personal_uncheck_monthly_inarray[] = $yearly_goals->goal_type ."_". $yearly_goals->goals_time ."_". $yearly_goals->goal_year ."_". $yearly_items ."_". $key ."_". $yearly_goals->goal_person;
								}
							}
						}
					}
				}
			}
		?>
		<div class="global_goals">
			<h1>Global Goals</h1>
			<div class="accordian">
				<h5 class="toggle">
					<div class="display_list">
						<a class="" href="#">
						<h3 class="display_subtitle">Completed Goals</h3>								
						<span class="arrow"></span>
						</a>
					</div>						
				</h5>
				<div class="toggle-content" style="display: none;">
					<div class="yearly_global_goals yearly_goals checked_goals">
						<h2 class="display_title">Yearly</h2>
						<?php 
							$global_checked_display_year = "";
							$count_check_yearly_inarray = count($check_yearly_inarray);
							if($check_yearly_inarray != null){
								$counter = 1;
								foreach($check_yearly_inarray as $yearly_inarray){
									if (in_array($yearly_inarray, $checked_goal_list_array)) {									
										$yearly_inarray_explode = explode('_', $yearly_inarray);
										$display_goal_type = $yearly_inarray_explode[0];
										$display_goal_time = $yearly_inarray_explode[1];
										$display_goal_year = $yearly_inarray_explode[2];
										$display_goal_item = $yearly_inarray_explode[3];
										$display_goal_key = $yearly_inarray_explode[4];
									?>
									<?php if($global_checked_display_year != $display_goal_time){ 
										$global_checked_display_year = $display_goal_time;
										?>
										<p class="display_bg"><?php echo $global_checked_display_year; ?></p>	
									<?php } ?>
									<div id="goal_display_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="display_list">
										<div id="goal_edit_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_edit button_2 display_button">Edit</div>
										<h3 id="goal_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="display_subtitle"><?php echo $display_goal_item; ?></h3>
										<div id="goal_delete_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_delete button_2 display_button float_right">Delete</div>
										<div style="display:none;" id="goal_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_loader loader"></div>
									</div>
									<div class="display_separator <?php echo ($counter == $count_check_yearly_inarray) ? "last_accordian_content" : "";   ?>"></div>
									<?php
									}
									$counter++;
								}
							}else{
								echo "No entries found.";
							}
						?>
					</div>
					<div class="monthly_global_goals monthly_goals checked_goals">
						<h2 class="display_title">Monthly</h2>					
						<?php 
							$global_checked_display_month_name = "";
							$count_check_monthly_inarray = count($check_monthly_inarray);
							if($check_monthly_inarray != null){
								$counter = 1;
								foreach($check_monthly_inarray as $monthly_inarray){
									if (in_array($monthly_inarray, $checked_goal_list_array)) {									
										$monthly_inarray_explode = explode('_', $monthly_inarray);
										$display_goal_type = $monthly_inarray_explode[0];
										$display_goal_time = $monthly_inarray_explode[1];
										$display_goal_year = $monthly_inarray_explode[2];
										$display_goal_item = $monthly_inarray_explode[3];
										$display_goal_key = $monthly_inarray_explode[4];
								?>
									<?php if($global_checked_display_month_name != $display_goal_time){ 
											$global_checked_display_month_name = $display_goal_time;
									?>
									<p class="display_bg"><?php echo $global_checked_display_month_name; ?></p>	
									<?php } ?>
									<div id="goal_display_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="display_list">
										<div id="goal_edit_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_edit button_2 display_button">Edit</div>
										<h3 id="goal_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="display_subtitle"><?php echo $display_goal_item; ?></h3>
										<div id="goal_delete_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_delete button_2 display_button float_right">Delete</div>
										<div style="display:none;" id="goal_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_loader loader"></div>
									</div>
									<div class="display_separator <?php echo ($counter == $count_check_monthly_inarray) ? "last_accordian_content" : "";   ?>"></div>
								<?php
									}
									$counter++;
								}
							}else{
								echo "No entries found.";
							}
						?>
					</div>
				</div>
			</div>
			<div class="accordian">
				<h5 class="toggle">
					<div class="display_list">
						<a class="" href="#">
						<h3 class="display_subtitle">Ongoing Goals</h3>								
						<span class="arrow"></span>
						</a>
					</div>						
				</h5>
				<div class="toggle-content" style="display: none;">
					<div class="yearly_global_goals yearly_goals unchecked_goals">
						<h2 class="display_title">Yearly</h2>
						<?php						
							$global_unchecked_display_year = "";
							$count_uncheck_yearly_inarray = count($uncheck_yearly_inarray);
							if($uncheck_yearly_inarray != null){
								$counter = 1;
								foreach($uncheck_yearly_inarray as $yearly_inarray){
									if (in_array($yearly_inarray, $unchecked_goal_list_array)) {									
										$yearly_inarray_explode = explode('_', $yearly_inarray);
										$display_goal_type = $yearly_inarray_explode[0];
										$display_goal_time = $yearly_inarray_explode[1];
										$display_goal_year = $yearly_inarray_explode[2];
										$display_goal_item = $yearly_inarray_explode[3];
										$display_goal_key = $yearly_inarray_explode[4];
									?>
									<?php if($global_unchecked_display_year != $display_goal_time){ 
										$global_unchecked_display_year = $display_goal_time;
										?>
										<p class="display_bg"><?php echo $global_unchecked_display_year; ?></p>	
									<?php } ?>
									<div id="goal_display_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="display_list">
										<div id="goal_edit_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_edit button_2 display_button">Edit</div>
										<h3 id="goal_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="display_subtitle"><?php echo $display_goal_item; ?></h3>
										<div id="goal_delete_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_delete button_2 display_button float_right">Delete</div>
										<div style="display:none;" id="goal_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_loader loader"></div>
									</div>
									<div class="display_separator <?php echo ($counter == $uncount_check_yearly_inarray) ? "last_accordian_content" : "";   ?>"></div>
									<?php
									}
									$counter++;
								}
							}else{
								echo "No entries found.";
							}
						?>
					</div>
					<div class="monthly_global_goals monthly_goals unchecked_goals">
						<h2 class="display_title">Monthly</h2>					
						<?php 
							$global_unchecked_display_month_name = "";
							$uncount_check_monthly_inarray = count($uncheck_monthly_inarray);
							if($uncheck_monthly_inarray != null){
								$counter = 1;
								foreach($uncheck_monthly_inarray as $monthly_inarray){
									if (in_array($monthly_inarray, $unchecked_goal_list_array)) {									
										$monthly_inarray_explode = explode('_', $monthly_inarray);
										$display_goal_type = $monthly_inarray_explode[0];
										$display_goal_time = $monthly_inarray_explode[1];
										$display_goal_year = $monthly_inarray_explode[2];
										$display_goal_item = $monthly_inarray_explode[3];
										$display_goal_key = $monthly_inarray_explode[4];
									?>
									<?php if($global_unchecked_display_month_name != $display_goal_time){ 
										$global_unchecked_display_month_name = $display_goal_time;
										?>
										<p class="display_bg"><?php echo $global_unchecked_display_month_name; ?></p>	
									<?php } ?>
									<div id="goal_display_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="display_list">
										<div id="goal_edit_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_edit button_2 display_button">Edit</div>
										<h3 id="goal_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="display_subtitle"><?php echo $display_goal_item; ?></h3>
										<div id="goal_delete_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_delete button_2 display_button float_right">Delete</div>
										<div style="display:none;" id="goal_<?php echo $display_goal_time .'_'. $display_goal_key; ?>" class="goals_loader loader"></div>
									</div>
									<div class="display_separator <?php echo ($counter == $uncount_check_monthly_inarray) ? "last_accordian_content" : "";   ?>"></div>
									<?php
									}
									$counter++;
								}
								}else{
								echo "No entries found.";
							}
						?>
					</div>
				</div>
			</div>	
		</div>
		<div class="personal_goals">
			<h1>Personal Goals</h1>
			<div class="accordian">
				<h5 class="toggle">
					<div class="display_list">
						<a class="" href="#">
						<h3 class="display_subtitle">Completed Goals</h3>								
						<span class="arrow"></span>
						</a>
					</div>						
				</h5>
				<div class="toggle-content" style="display: none;">
					<div class="yearly_personal_goals yearly_goals checked_goals">
						<h2 class="display_title">Yearly</h2>
						<?php							
							$ypc_goals_array = array();
							foreach($personal_check_yearly_inarray as $yearly_inarray){
								if (in_array($yearly_inarray, $checked_goal_list_array)) {									
									$monthly_inarray_explode = explode('_', $yearly_inarray);									
									$display_goal_type = $monthly_inarray_explode[0];
									$display_goal_time = $monthly_inarray_explode[1];
									$display_goal_year = $monthly_inarray_explode[2];
									$display_goal_item = $monthly_inarray_explode[3];
									$display_goal_key = $monthly_inarray_explode[4];
									$display_goal_person_name = $monthly_inarray_explode[5];									
									$ypc_goals_array[$display_goal_time][$display_goal_person_name][] = $display_goal_type ."_". $display_goal_time ."_". $display_goal_year ."_". $display_goal_item ."_". $display_goal_key;								
								}								
							}
							
						?>						
						<?php if($ypc_goals_array != null){	?>
							<div class="custom_accordian">							
								<?php foreach($ypc_goals_array as $ypc_goals_time => $ypc_goal_array){ ?>
									<p class="display_bg"><?php echo $ypc_goals_time; ?></p>
									<?php
										foreach($ypc_goal_array as $ypc_goals_person => $ypc_goals){	
											$ypc_goal_person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$ypc_goals_person'");
											$ypc_goal_person_id = $ypc_goal_person->ID;
										?>
										<div class="category_name_container">											
											<div class="display_list">	
												<h3 class="display_subtitle checklist_category_name"><?php echo $ypc_goals_person; ?></h3>
												<h5 id="custom_toggle_<?php echo 'ypc-'.$ypc_goals_time.'-'.$ypc_goal_person_id; ?>" class="custom_toggle">
													<span class="arrow"></span>
												</h5>
											</div>
										</div>
										<div class="display_separator"></div>
										<div id="custom_toggle_content_<?php echo 'ypc-'.$ypc_goals_time.'-'.$ypc_goal_person_id; ?>" class="custom_toggle_content" style="display: none;">
											<?php 
												$counter = 1;
												$ypc_goal_count = count($ypc_goals);
												foreach($ypc_goals as $ypc_goal){
													$ypc_goals_explode = explode('_', $ypc_goal);
													$ypc_goal_type = $ypc_goals_explode[0];
													$ypc_goal_time = $ypc_goals_explode[1];
													$ypc_goal_year = $ypc_goals_explode[2];
													$ypc_goal_item = $ypc_goals_explode[3];
													$ypc_goal_key = $ypc_goals_explode[4];
												?>
												<div id="goal_display_<?php echo $ypc_goal_time .'_'. $ypc_goal_key; ?>" class="display_list">
													<div id="goal_edit_<?php echo $ypc_goal_time .'_'. $ypc_goal_key; ?>" class="goals_edit button_2 display_button">Edit</div>
													<h3 id="goal_<?php echo $ypc_goal_time .'_'. $ypc_goal_key; ?>" class="display_subtitle"><?php echo $ypc_goal_item; ?></h3>
													<div id="goal_delete_<?php echo $ypc_goal_time .'_'. $ypc_goal_key; ?>" class="goals_delete button_2 display_button float_right">Delete</div>
													<div style="display:none;" id="goal_<?php echo $ypc_goal_time .'_'. $ypc_goal_key; ?>" class="goals_loader loader"></div>
												</div>
												<div class="display_separator <?php echo ($counter == $ypc_goal_count) ? "last_accordian_content" : "";   ?>"></div>											
												<?php
													$counter++;
												} 
											?>
										</div>
										<?php 
										} 
									} 
								?>
							</div>
							<?php 
								}else{
								echo "No entries found.";
							}
						?>
					</div>
					<div class="monthly_personal_goals monthly_goals checked_goals">
						<h2 class="display_title">Monthly</h2>
						<?php							
							$mpc_goals_array = array();								
							foreach($personal_check_monthly_inarray as $monthly_inarray){
								if (in_array($monthly_inarray, $checked_goal_list_array)) {									
									$monthly_inarray_explode = explode('_', $monthly_inarray);									
									$display_goal_type = $monthly_inarray_explode[0];
									$display_goal_time = $monthly_inarray_explode[1];
									$display_goal_year = $monthly_inarray_explode[2];
									$display_goal_item = $monthly_inarray_explode[3];
									$display_goal_key = $monthly_inarray_explode[4];
									$display_goal_person_name = $monthly_inarray_explode[5];									
									$mpc_goals_array[$display_goal_time][$display_goal_person_name][] = $display_goal_type ."_". $display_goal_time ."_". $display_goal_year ."_". $display_goal_item ."_". $display_goal_key;								
								}								
							}
							
						?>						
						<?php if($mpc_goals_array != null){	?>
							<div class="custom_accordian">							
								<?php foreach($mpc_goals_array as $mpc_goals_time => $mpc_goal_array){ ?>
									<p class="display_bg"><?php echo $mpc_goals_time; ?></p>
									<?php
										foreach($mpc_goal_array as $mpc_goals_person => $mpc_goals){	
											$mpc_goal_person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$mpc_goals_person'");
											$mpc_goal_person_id = $mpc_goal_person->ID;
										?>
										<div class="category_name_container">											
											<div class="display_list">	
												<h3 class="display_subtitle checklist_category_name"><?php echo $mpc_goals_person; ?></h3>
												<h5 id="custom_toggle_<?php echo 'mpc-'.$mpc_goals_time.'-'.$mpc_goal_person_id; ?>" class="custom_toggle">
													<span class="arrow"></span>
												</h5>
											</div>
										</div>
										<div class="display_separator"></div>
										<div id="custom_toggle_content_<?php echo 'mpc-'.$mpc_goals_time.'-'.$mpc_goal_person_id; ?>" class="custom_toggle_content" style="display: none;">
											<?php 
												$counter = 1;
												$mpc_goal_count = count($mpc_goals);
												foreach($mpc_goals as $mpc_goal){
													$mpc_goals_explode = explode('_', $mpc_goal);
													$mpc_goal_type = $mpc_goals_explode[0];
													$mpc_goal_time = $mpc_goals_explode[1];
													$mpc_goal_year = $mpc_goals_explode[2];
													$mpc_goal_item = $mpc_goals_explode[3];
													$mpc_goal_key = $mpc_goals_explode[4];
												?>
												<div id="goal_display_<?php echo $mpc_goal_time .'_'. $mpc_goal_key; ?>" class="display_list">
													<div id="goal_edit_<?php echo $mpc_goal_time .'_'. $mpc_goal_key; ?>" class="goals_edit button_2 display_button">Edit</div>
													<h3 id="goal_<?php echo $mpc_goal_time .'_'. $mpc_goal_key; ?>" class="display_subtitle"><?php echo $mpc_goal_item; ?></h3>
													<div id="goal_delete_<?php echo $mpc_goal_time .'_'. $mpc_goal_key; ?>" class="goals_delete button_2 display_button float_right">Delete</div>
													<div style="display:none;" id="goal_<?php echo $mpc_goal_time .'_'. $mpc_goal_key; ?>" class="goals_loader loader"></div>
												</div>
												<div class="display_separator <?php echo ($counter == $mpc_goal_count) ? "last_accordian_content" : "";   ?>"></div>
												<?php
													$counter++;
												} 
											?>
										</div>
										<?php 
										} 
									} 
								?>
							</div>
							<?php 
								}else{
								echo "No entries found.";
							}
						?>						
					</div>
				</div>
			</div>
			<div class="accordian">
				<h5 class="toggle">
					<div class="display_list">
						<a class="" href="#">
						<h3 class="display_subtitle">Ongoing Goals</h3>								
						<span class="arrow"></span>
						</a>
					</div>						
				</h5>
				<div class="toggle-content" style="display: none;">
					<div class="yearly_personal_goals yearly_goals unchecked_goals">
						<h2 class="display_title">Yearly</h2>
						<?php							
							$ypo_goals_array = array();								
							foreach($personal_uncheck_yearly_inarray as $yearly_inarray){
								if (in_array($yearly_inarray, $unchecked_goal_list_array)) {									
									$monthly_inarray_explode = explode('_', $yearly_inarray);									
									$display_goal_type = $monthly_inarray_explode[0];
									$display_goal_time = $monthly_inarray_explode[1];
									$display_goal_year = $monthly_inarray_explode[2];
									$display_goal_item = $monthly_inarray_explode[3];
									$display_goal_key = $monthly_inarray_explode[4];
									$display_goal_person_name = $monthly_inarray_explode[5];									
									$ypo_goals_array[$display_goal_time][$display_goal_person_name][] = $display_goal_type ."_". $display_goal_time ."_". $display_goal_year ."_". $display_goal_item ."_". $display_goal_key;								
								}								
							}
							
						?>						
						<?php if($ypo_goals_array != null){	?>
							<div class="custom_accordian">							
								<?php foreach($ypo_goals_array as $ypo_goals_time => $ypo_goal_array){ ?>
									<p class="display_bg"><?php echo $ypo_goals_time; ?></p>
									<?php
										foreach($ypo_goal_array as $ypo_goals_person => $ypo_goals){	
											$ypo_goal_person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$ypo_goals_person'");
											$ypo_goal_person_id = $ypo_goal_person->ID;
										?>
										<div class="category_name_container">											
											<div class="display_list">	
												<h3 class="display_subtitle checklist_category_name"><?php echo $ypo_goals_person; ?></h3>
												<h5 id="custom_toggle_<?php echo 'ypo-'.$ypo_goals_time.'-'.$ypo_goal_person_id; ?>" class="custom_toggle">
													<span class="arrow"></span>
												</h5>
											</div>
										</div>
										<div class="display_separator"></div>
										<div id="custom_toggle_content_<?php echo 'ypo-'.$ypo_goals_time.'-'.$ypo_goal_person_id; ?>" class="custom_toggle_content" style="display: none;">
											<?php 
												$counter = 1;
												$ypo_goal_count = count($ypo_goals);
												foreach($ypo_goals as $ypo_goal){
													$ypo_goals_explode = explode('_', $ypo_goal);
													$ypo_goal_type = $ypo_goals_explode[0];
													$ypo_goal_time = $ypo_goals_explode[1];
													$ypo_goal_year = $ypo_goals_explode[2];
													$ypo_goal_item = $ypo_goals_explode[3];
													$ypo_goal_key = $ypo_goals_explode[4];
												?>
												<div id="goal_display_<?php echo $ypo_goal_time .'_'. $ypo_goal_key; ?>" class="display_list">
													<div id="goal_edit_<?php echo $ypo_goal_time .'_'. $ypo_goal_key; ?>" class="goals_edit button_2 display_button">Edit</div>
													<h3 id="goal_<?php echo $ypo_goal_time .'_'. $ypo_goal_key; ?>" class="display_subtitle"><?php echo $ypo_goal_item; ?></h3>
													<div id="goal_delete_<?php echo $ypo_goal_time .'_'. $ypo_goal_key; ?>" class="goals_delete button_2 display_button float_right">Delete</div>
													<div style="display:none;" id="goal_<?php echo $ypo_goal_time .'_'. $ypo_goal_key; ?>" class="goals_loader loader"></div>
												</div>
												<div class="display_separator <?php echo ($counter == $ypo_goal_count) ? "last_accordian_content" : "";   ?>"></div>											
												<?php
													$counter++;
												} 
											?>
										</div>
										<?php 
										} 
									} 
								?>
							</div>
							<?php 
								}else{
								echo "No entries found.";
							}
						?>					
					</div>
					<div class="monthly_personal_goals monthly_goals unchecked_goals">
						<h2 class="display_title">Monthly</h2>
						<?php							
							$mpo_goals_array = array();								
							foreach($personal_uncheck_monthly_inarray as $monthly_inarray){
								if (in_array($monthly_inarray, $unchecked_goal_list_array)) {									
									$monthly_inarray_explode = explode('_', $monthly_inarray);									
									$display_goal_type = $monthly_inarray_explode[0];
									$display_goal_time = $monthly_inarray_explode[1];
									$display_goal_year = $monthly_inarray_explode[2];
									$display_goal_item = $monthly_inarray_explode[3];
									$display_goal_key = $monthly_inarray_explode[4];
									$display_goal_person_name = $monthly_inarray_explode[5];									
									$mpo_goals_array[$display_goal_time][$display_goal_person_name][] = $display_goal_type ."_". $display_goal_time ."_". $display_goal_year ."_". $display_goal_item ."_". $display_goal_key;								
								}								
							}
							
						?>						
						<?php if($mpo_goals_array != null){	?>
							<div class="custom_accordian">							
								<?php foreach($mpo_goals_array as $mpo_goals_time => $mpo_goal_array){ ?>
								<p class="display_bg"><?php echo $mpo_goals_time; ?></p>
								<?php
										foreach($mpo_goal_array as $mpo_goals_person => $mpo_goals){	
											$mpo_goal_person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$mpo_goals_person'");
											$mpo_goal_person_id = $mpo_goal_person->ID;
								?>
											<div class="category_name_container">											
												<div class="display_list">	
													<h3 class="display_subtitle checklist_category_name"><?php echo $mpo_goals_person; ?></h3>
													<h5 id="custom_toggle_<?php echo 'mpo-'.$mpo_goals_time.'-'.$mpo_goal_person_id; ?>" class="custom_toggle">
														<span class="arrow"></span>
													</h5>
												</div>
											</div>
											<div class="display_separator"></div>
											<div id="custom_toggle_content_<?php echo 'mpo-'.$mpo_goals_time.'-'.$mpo_goal_person_id; ?>" class="custom_toggle_content" style="display: none;">
												<?php 
													$counter = 1;
													$mpo_goal_count = count($mpo_goals);
													foreach($mpo_goals as $mpo_goal){
														$mpo_goals_explode = explode('_', $mpo_goal);
														$mpo_goal_type = $mpo_goals_explode[0];
														$mpo_goal_time = $mpo_goals_explode[1];
														$mpo_goal_year = $mpo_goals_explode[2];
														$mpo_goal_item = $mpo_goals_explode[3];
														$mpo_goal_key = $mpo_goals_explode[4];
													?>
													<div id="goal_display_<?php echo $mpo_goal_time .'_'. $mpo_goal_key; ?>" class="display_list">
														<div id="goal_edit_<?php echo $mpo_goal_time .'_'. $mpo_goal_key; ?>" class="goals_edit button_2 display_button">Edit</div>
														<h3 id="goal_<?php echo $mpo_goal_time .'_'. $mpo_goal_key; ?>" class="display_subtitle"><?php echo $mpo_goal_item; ?></h3>
														<div id="goal_delete_<?php echo $mpo_goal_time .'_'. $mpo_goal_key; ?>" class="goals_delete button_2 display_button float_right">Delete</div>
														<div style="display:none;" id="goal_<?php echo $mpo_goal_time .'_'. $mpo_goal_key; ?>" class="goals_loader loader"></div>
													</div>
													<div class="display_separator <?php echo ($counter == $mpo_goal_count) ? "last_accordian_content" : "";   ?>"></div>											
													<?php
														$counter++;
													} 
												?>
											</div>
								<?php 
										} 
									} 
								?>
							</div>
							<?php 
								}else{
								echo "No entries found.";
							}
						?>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>
<div style="display:none;" id="dialog_form_edit_goals" title="Edit Goal"></div>
<div style="display:none;" id="dialog_form_delete_goals" title="Delete Goal"></div>
<?php get_footer(); ?>