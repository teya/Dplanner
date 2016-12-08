<?php /* Template Name: Profile */ if ( !is_user_logged_in() ) {   auth_redirect();}?><?php get_header(); ?><?php $current_user_details = wp_get_current_user();$current_user_fullname = $current_user_details->data->display_name;$table_name = $wpdb->prefix . "custom_person"; $person = $wpdb->get_row("SELECT * FROM {$table_name} WHERE wp_user_id = ".$current_user_details->ID);$person_department = implode('<br />', unserialize($person->person_department));?><div class="info_project">	<div class="person_left">		<figure class="person_image">			<?php if($person->person_image != null){ ?>				<img class="person_image" src="<?php echo site_url().'/wp-content/uploads/person_image/'.$person->person_image; ?>" />			<?php }else{ ?>				<img class="person_image" src="<?php echo site_url().'/wp-content/themes/Avada/img/mystery_man.jpeg' ?>" />			<?php } ?>		</figure>		<div class="person_info">			<h3 class="person_fullname"><?php echo $person->person_fullname; ?></h3>			<p class="display_permission"><?php echo $person->person_permission; ?></p>		</div>	</div>	<div class="person_right">		<h1 class="person_fullname"><?php echo $person->person_fullname . "'s Information"; ?></h1>		<div class="section">			<div class="left">				<p class="label">Name</p>			</div>			<div class="right">				<p><?php echo $person->person_fullname; ?></p>			</div>		</div>		<div class="section">			<div class="left">				<p class="label">Birthdate</p>			</div>			<div class="right">				<p><?php echo $person->person_birthmonth ." ". $person->person_birthday .", ". $person->person_birthyear; ?></p>			</div>		</div>		<div class="section">			<div class="left">				<p class="label">Address</p>			</div>			<div class="right">				<p><?php echo $person->person_address; ?></p>			</div>		</div>		<div class="section">			<div class="left">				<p class="label">Mobile Phone</p>			</div>			<div class="right">				<p><?php echo $person->person_mobile; ?></p>			</div>		</div>		<div class="section">			<div class="left">				<p class="label">Email</p>			</div>			<div class="right">				<p><?php echo $person->person_email; ?></p>								<p>Email Notification is <?php echo ($person->person_email_notification == 1) ? "Enabled" : "Disabled"; ?></p>			</div>		</div>		<div class="section">			<div class="left">				<p class="label">Skype Name</p>			</div>			<div class="right">				<p><?php echo $person->person_skype; ?></p>			</div>		</div>		<div class="border_separator"></div>		<div class="section">			<div class="left">				<p class="label">Title</p>			</div>			<div class="right">				<p><?php echo $person->person_title; ?></p>			</div>		</div>				<div class="section">			<div class="left">				<p class="label">Department</p>			</div>			<div class="right">				<p><?php echo $person_department; ?></p>			</div>		</div>		<div class="border_separator"></div>		<div class="section">			<div class="left">				<p class="label">Permissions</p>			</div>			<div class="right">				<p><?php echo $person->person_permission; ?></p>							</div>		</div>		<div class="border_separator"></div>		<div class="section">			<div class="left">				<p class="label">Timezone</p>			</div>			<div class="right">				<p><?php echo $person->person_timezone; ?></p>			</div>		</div>		<div class="border_separator"></div>		<div class="section">			<div class="left">				<p class="label">Description</p>			</div>			<div class="right">				<p><?php echo $person->person_description; ?></p>			</div>		</div>		<div class="border_separator"></div>		<div class="section">			<div class="left">				<p class="label">Completed Goals</p>			</div>			<div class="right">				<?php 					$year = date('Y');					$month_name = date('F');					$month_number = date('m');								$person_goal_array = unserialize($person->person_goal);					$table_name = $wpdb->prefix . "custom_goals"; 					$goals_details = $wpdb->get_results("SELECT * FROM {$table_name}");										?>				<div class="tab-holder">					<div class="tab-hold tabs-wrapper">						<div class="full_width">							<ul id="tabs" class="tabset tabs">								<li class="tabs_li active"><a href="#year"><h3 class="title">SEOWEB Goals <?php echo $year; ?></h3></a></li>								<li class="tabs_li"><a href="#month"><h3 class="title">SEOWEB Goals <?php echo $month_name; ?></h3></a></li>								<li class="tabs_li"><a href="#personal_year"><h3 class="title">Personal Goals <?php echo $year; ?></h3></a></li>								<li class="tabs_li"><a href="#personal_month"><h3 class="title">Personal Goals <?php echo $month_name; ?></h3></a></li>							</ul>						</div>						<div class="data_content inner_padding">							<div class="tab-box tabs-container">																<div id="year" class="tab tab_content active">									<?php										foreach($goals_details as $goals_detail){																						if($goals_detail->goal_type == 'Yearly' && $goals_detail->goal_person == null){												$goals_array = unserialize($goals_detail->goals);												$goal_key_array = array();												$goals_list_array = array();												foreach($goals_array as $key => $goals_list){													$goal_key_array[] = $key;													$goals_list_array[] = $goals_list;												}											}										}																				$person_goal_key_array = array();										if($person_goal_array != null){											foreach($person_goal_array as $person_goal_list){												$goal_array_explode = explode('_', $person_goal_list);												$person_goal_type = $goal_array_explode[0];												$person_goal_year = $goal_array_explode[1];												$person_goal_time = $goal_array_explode[2];												$person_goal_key = $goal_array_explode[3];												if($person_goal_type == 'yearly'){													$person_goal_key_array[] = $person_goal_key;												}											}																																foreach($person_goal_key_array as $goal_key){												if(in_array($goal_key, $goal_key_array)){													echo "<li>".$goals_list_array[$goal_key]."</li>";												}											}										}									?>											</div>								<div id="month" class="tab tab_content" style="display: none;">									<?php										foreach($goals_details as $goals_detail){																						if($goals_detail->goal_type == 'Monthly' && $goals_detail->goal_person == null){												$goals_array = unserialize($goals_detail->goals);												$goal_key_array = array();												$goals_list_array = array();												foreach($goals_array as $key => $goals_list){													$goal_key_array[] = $key;													$goals_list_array[] = $goals_list;												}											}										}																				$person_goal_key_array = array();										foreach($person_goal_array as $person_goal_list){											$goal_array_explode = explode('_', $person_goal_list);											$person_goal_type = $goal_array_explode[0];											$person_goal_year = $goal_array_explode[1];											$person_goal_time = $goal_array_explode[2];											$person_goal_key = $goal_array_explode[3];											if($person_goal_type == 'monthly'){												$person_goal_key_array[] = $person_goal_key;											}										}																				foreach($person_goal_key_array as $goal_key){											if(in_array($goal_key, $goal_key_array)){												echo "<li>".$goals_list_array[$goal_key]."</li>";											}										}									?>								</div>								<div id="personal_year" class="tab tab_content" style="display: none;">									<?php										foreach($goals_details as $goals_detail){																						if($goals_detail->goal_type == 'Yearly' && $goals_detail->goal_person != null){												$goals_array = unserialize($goals_detail->goals);												$goal_key_array = array();												$goals_list_array = array();												foreach($goals_array as $key => $goals_list){													$goal_key_array[] = $key;													$goals_list_array[] = $goals_list;												}											}										}																				$person_goal_key_array = array();										foreach($person_goal_array as $person_goal_list){											$goal_array_explode = explode('_', $person_goal_list);											$person_goal_type = $goal_array_explode[0];											$person_goal_year = $goal_array_explode[1];											$person_goal_time = $goal_array_explode[2];											$person_goal_key = $goal_array_explode[3];											if($person_goal_type == 'personalyearly'){												$person_goal_key_array[] = $person_goal_key;											}										}																				foreach($person_goal_key_array as $goal_key){											if(in_array($goal_key, $goal_key_array)){												echo "<li>".$goals_list_array[$goal_key]."</li>";											}										}									?>								</div>								<div id="personal_month" class="tab tab_content" style="display: none;">									<?php										foreach($goals_details as $goals_detail){																						if($goals_detail->goal_type == 'Monthly' && $goals_detail->goal_person != null){												$goals_array = unserialize($goals_detail->goals);												$goal_key_array = array();												$goals_list_array = array();												foreach($goals_array as $key => $goals_list){													$goal_key_array[] = $key;													$goals_list_array[] = $goals_list;												}											}										}																				$person_goal_key_array = array();										foreach($person_goal_array as $person_goal_list){											$goal_array_explode = explode('_', $person_goal_list);											$person_goal_type = $goal_array_explode[0];											$person_goal_year = $goal_array_explode[1];											$person_goal_time = $goal_array_explode[2];											$person_goal_key = $goal_array_explode[3];											if($person_goal_type == 'personalmonthly'){												$person_goal_key_array[] = $person_goal_key;											}										}																				foreach($person_goal_key_array as $goal_key){											if(in_array($goal_key, $goal_key_array)){												echo "<li>".$goals_list_array[$goal_key]."</li>";											}										}									?>								</div>							</div>						</div>					</div>				</div>			</div>		</div>	</div>	<a class="button_2 display_button" href="<?php echo get_site_url(); ?>/profile/">Return</a>	<a class="button_2 display_button" href="<?php echo get_site_url(); ?>/profile/edit-profile/?editID=<?php echo $person->ID ?>">Edit</a>		</div><?php get_footer(); ?>