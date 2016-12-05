<?php /* Template name: Report Table */ ?>
<script>
	jQuery(document).ready(function(){	
		jQuery('.tabs-wrapper').each(function() {
			jQuery(this).find(".tab_content").hide(); //Hide all content
			if(document.location.hash && jQuery(this).find("ul.tabs li a[href='"+document.location.hash+"']").length >= 1) {
				jQuery(this).find("ul.tabs li a[href='"+document.location.hash+"']").parent().addClass("active").show(); //Activate first tab
				jQuery(this).find(document.location.hash+".tab_content").show(); //Show first tab content
				jQuery(this).find(".tab_content.active").show(); //Show first tab content
			} else {
				jQuery(this).find("ul.tabs li:first").addClass("active").show(); //Activate first tab
				jQuery(this).find(".tab_content:first").show(); //Show first tab content				
			}
		});
		//On Click Event
		jQuery("ul.tabs li").click(function(e) {
			jQuery(this).parents('.tabs-wrapper').find("ul.tabs li").removeClass("active"); //Remove any "active" class
			jQuery(this).addClass("active"); //Add "active" class to selected tab
			jQuery(this).parents('.tabs-wrapper').find(".tab_content").hide(); //Hide all tab content
			
			var activeTab = jQuery(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
			jQuery(this).parents('.tabs-wrapper').find(activeTab).show(); //Fade in the active ID content
			
			
			jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.content-boxes').each(function() {
				var cols = jQuery(this).find('.col').length;
				jQuery(this).addClass('columns-'+cols);
			});
			
			jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.columns-3 .col:nth-child(3n), .columns-4 .col:nth-child(4n)').css('margin-right', '0px');
			
			jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.portfolio-wrapper').isotope('reLayout');
			
			jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.content-boxes-icon-boxed').each(function() {
				//console.log(jQuery(this).find('.col'));
				jQuery(this).find('.col').equalHeights();
			});
			
			jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.shortcode-map').each(function() {
				jQuery("#"+this.id).goMap();
				marker = jQuery.goMap.markers[0];
				if(marker) {
					info = jQuery.goMap.getInfo(marker);
					jQuery.goMap.setInfo(marker, info);
				}			
				var center = jQuery.goMap.getMap().getCenter();
				google.maps.event.trigger(jQuery.goMap.getMap(), 'resize');
				jQuery.goMap.getMap().setCenter(center);
			});
			
			generateCarousel();
			
			e.preventDefault();
		});
		jQuery("ul.tabs li a").click(function(e) {
			e.preventDefault();
		});		
	});
	
		
		
</script>
<div id="report_table">
<?php
	if($_POST['week_number'] != null){
		$week_number = $_POST['week_number'];
	}

	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_task = $wpdb->prefix . "custom_task";

	$import_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE week_number = $week_number");
	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project}");
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
	
	$year = date('Y');
	$week = getStartAndEndDate($week_number, $year);
	$start_num = $week[0];
	$end_num = $week[1];
	$start = date("d M Y", strtotime($start_num));
	$end = date("d M Y", strtotime($end_num));
	
	$total_hour_decimal = 0;
	$total_bill = 0;
	foreach ($clients as $client){
		$client_n = "";
		$client_x = "";
		$get_hour = array();
		foreach ($import_data as $import_item){
			$client_name = $client->client_name;
			$client_name_import = $import_item->task_label;
			$client_hour = $import_item->task_hour;									
			if($client_name == $client_name_import) {										
				if ($client_n != $client_name) {											
					$client_n = $client_name;											
					$get_hour[$client_name] = $client_hour;
				} 
				else {											
					$cur_date = strtotime($get_hour[$client_name]) + strtotime($client_hour);
					$get_hour[$client_name] = date('h:i:s', $cur_date);											
				}
			}
		}
		foreach ($import_data as $import_item){
			$client_name = $client->client_name;
			$client_name_import = $import_item->task_label;
			if($client_name == $client_name_import){
				$client_hour = $import_item->task_hour;										
				if ($client_x != $client_name) {
					$client_x = $client_name;
					$decimal_hours = decimalHours($get_hour[$client_name]);
					$rounded_hour = round($decimal_hours, 2);
					foreach ($projects as $project){
						$project_budget = $project->project_budget;
						$project_client = $project->project_client;
						if($client_name == $project_client){
							$billable_amount = $rounded_hour * $project_budget; 
					$total_hour_decimal += $rounded_hour;
					$total_bill += $billable_amount;
						}
					}
				}
			}									
		}		
	}							
?>	
	<div class="week_section">
		<h3 class="week">
			Week: <?php echo $start .' '.'-'.' '. $end?>
			<h3>
			</div>
			<div class="top_reports">						
				<div class="one_third">
					<p class="top_reports_label">Hours Tracked</p>
					<h1><?php echo $total_hour_decimal; ?></h1>
				</div>
				<div class="one_third">
					<p class="top_reports_label">Billable Hours</p>
					<h1><?php echo $rounded_hour; ?></h1>
				</div>
				<div class="one_third last">
					<p class="top_reports_label">Billable Amount</p>
					<h1>kr&nbsp;<?php echo $total_bill; ?></h1>
				</div>
			</div>
	<div class="table_container">
		<div class="tab-holder">
			<div class="tab-hold tabs-wrapper">
				<div class="full_width">				
					<ul id="tabs" class="tabset tabs">
						<li class="tabs_li"><a href="#clients">Clients</a></li>					
						<li class="tabs_li"><a href="#projects">Projects</a></li>					
						<li class="tabs_li"><a href="#tasks">Tasks</a></li>					
						<li class="tabs_li"><a href="#staff">Staff</a></li>
					</ul>
				</div>
				<div class="tab-box tabs-container">	
<!------------------------------------------------------ CLIENTS ------------------------------------------------------->					
					<div id="clients" class="tab tab_content" style="display: none;">
						<div class="header_titles">
							<div class="first_column">
								<h3>Name</h3>
							</div>
							<div class="second_column">
								<h3>Hours</h3>
							</div>
							<div class="third_column">
								<h3>Billable Amount</h3>
							</div>
						</div>
						<?php 
						$total_hour_decimal = 0;
						$total_bill = 0;
						foreach ($clients as $client){
							$client_n = "";
							$client_x = "";
							$get_hour = array();
							foreach ($import_data as $import_item){
								$client_name = $client->client_name;
								$client_name_import = $import_item->task_label;
								$client_hour = $import_item->task_hour;									
								if($client_name == $client_name_import) {										
									if ($client_n != $client_name) {											
										$client_n = $client_name;											
										$get_hour[$client_name] = $client_hour;
									} 
									else {											
										$cur_date = strtotime($get_hour[$client_name]) + strtotime($client_hour);
										$get_hour[$client_name] = date('h:i:s', $cur_date);											
									}
								}
							}
							foreach ($import_data as $import_item){
								$client_name = $client->client_name;
								$client_name_import = $import_item->task_label;
								if($client_name == $client_name_import){
									$client_hour = $import_item->task_hour;
									if ($client_x != $client_name) {
										$client_x = $client_name;
										$decimal_hours = decimalHours($get_hour[$client_name]);
										$rounded_hour = round($decimal_hours, 2);
										foreach ($projects as $project){
											$project_budget = $project->project_budget;
											$project_client = $project->project_client;
											if($client_name == $project_client){
												$billable_amount = $rounded_hour * $project_budget;
						?>
						<div class="info_div">
							<div class="first_column">
								<li><?php echo $client_name; ?></li>
							</div>
							<div class="second_column">
								<li><?php echo $rounded_hour; ?></li>
							</div>
							<div class="third_column">
								<li><?php echo $billable_amount; ?></li>
							</div>
						</div>																			
					<?php			
						$total_hour_decimal += $rounded_hour;
						$total_bill += $billable_amount;
											}
										}
									}
								}
							}
						}						
					?>
						<div class="info_div_total">
							<div class="first_column">
								<li><p class="report_total">Total</p></li>
							</div>
							<div class="second_column">
								<li><p class="report_total"><?php echo $total_hour_decimal; ?></p></li>
							</div>
							<div class="third_column">
								<li><p class="report_total"><?php echo $total_bill; ?></p></li>
							</div>
						</div>	
					</div>
<!------------------------------------------------------ PROJECTS ------------------------------------------------------->
					<div id="projects" class="tab tab_content" style="display: none;">
						<div class="header_titles">
							<div class="first_column">
								<h3>Name</h3>
							</div>
							<div class="second_column">
								<h3>Client</h3>
							</div>
							<div class="third_column">
								<h3>Hours</h3>
							</div>
							<div class="fourth_column">
								<h3>Billable Amount</h3>
							</div>
						</div>
						<?php
							$total_hour_decimal_project = 0;
							$total_bill_project = 0;
							foreach ($projects as $project){
								$client_n = "";
								$client_x = "";
								$get_hour = array();
								foreach ($import_data as $import_item){
									$project_name = $project->project_name;
									$project_client = $project->project_client;
									$client_name_import = $import_item->task_label;
									$client_hour = $import_item->task_hour;							
									if($project_client == $client_name_import) {										
										if ($client_n != $project_client) {											
											$client_n = $project_client;											
											$get_hour[$project_client] = $client_hour;
										} 
										else {											
											$cur_date = strtotime($get_hour[$project_client]) + strtotime($client_hour);
											$get_hour[$project_client] = date('h:i:s', $cur_date);											
										}
									}
								}
								foreach ($import_data as $import_item){
									$project_client = $project->project_client;
									$client_name_import = $import_item->task_label;
									if($project_client == $client_name_import){
										$client_hour = $import_item->task_hour;	
										if ($client_x != $project_client) {
											$client_x = $project_client;
											$decimal_hours = decimalHours($get_hour[$project_client]);
											$rounded_hour = round($decimal_hours, 2);
											$billable_amount = $rounded_hour*20;			
											?>				
										<div class="info_div">
											<div class="first_column">
												<li><?php echo $project_name; ?></li>
											</div>
											<div class="second_column">
												<li><?php echo $project_client; ?></li>
											</div>
											<div class="third_column">												
												<li><?php echo $rounded_hour; ?></li>
											</div>
											<div class="fourth_column">
												<li><?php echo $billable_amount; ?></li>
											</div>
										</div>												
										<?php
											$total_hour_decimal_project += $rounded_hour;
											$total_bill_project += $billable_amount;
										}
									}									
								}		
							}							
						?>	
						<div class="info_div_total">
							<div class="first_column">
								<li><p class="report_total">Total</p></li>
							</div>
							<div class="second_column">
								<li><p class="report_total">&nbsp;</p></li>
							</div>
							<div class="third_column">
								<li><p class="report_total"><?php echo $total_hour_decimal_project; ?></p></li>
							</div>
							<div class="fourth_column">
								<li><p class="report_total"><?php echo $total_bill_project; ?></p></li>
							</div>
						</div>
					</div>
<!------------------------------------------------------ TASKS ------------------------------------------------------->					
					<div id="tasks" class="tab tab_content" style="display: none;">
						<div class="header_titles">
							<div class="first_column">
								<h3>Name</h3>
							</div>
							<div class="second_column">
								<h3>Hours</h3>
							</div>
							<div class="third_column">
								<h3>Billable Amount</h3>
							</div>
						</div>								
						<?php	
							$total_hour_decimal_task = 0;
							$total_bill_task = 0;
							foreach ($tasks as $task){
								$task_name_temp = "";
								$task_name_temp2 = "";
								$get_hour = array();										
								foreach ($import_data as $import_item){
									$task_name = $task->task_name;
									$import_task_name_full = $import_item->task_name;																						
									$import_task_name_trim = substr($import_task_name_full, 0, strpos($import_task_name_full, "-"));											
									$import_task_name = rtrim($import_task_name_trim);
									$task_hour = $import_item->task_hour;
									//echo $import_task_name_full ."--". $task_hour ."<br/>";
									if($task_name == $import_task_name){
										if ($task_name_temp != $task_name){																									
											$task_name_temp = $task_name;
											$get_hour[$task_name] = $task_hour;													
										} 
										else {											
											$cur_date = strtotime($get_hour[$task_name]) + strtotime($task_hour);
											$get_hour[$task_name] = date('h:i:s', $cur_date);
										}
									}
								}
								foreach ($import_data as $import_item){
									$task_name = $task->task_name;
									$import_task_name_full = $import_item->task_name;																						
									$import_task_name_trim = substr($import_task_name_full, 0, strpos($import_task_name_full, "-"));											
									$import_task_name = rtrim($import_task_name_trim);
									$task_hour = $import_item->task_hour;
									if($task_name == $import_task_name){
										$task_hour = $import_item->task_hour;
										if ($task_name_temp2 != $task_name) {
											$task_name_temp2 = $task_name;
											$decimal_hours = decimalHours($get_hour[$task_name]);
											$rounded_hour = round($decimal_hours, 2);
											$billable_amount = $rounded_hour*20;
										?>
										<div class="info_div">
											<div class="first_column">
												<li><?php echo $task_name; ?></li>
											</div>
											<div class="second_column">
												<li><?php echo $rounded_hour; ?></li>
											</div>
											<div class="third_column">												
												<li><?php echo $billable_amount; ?></li>
											</div>
										</div>												
										<?php
											$total_hour_decimal_task += $rounded_hour;
											$total_bill_task += $billable_amount;
										}
									}									
								}		
							}							
						?>	
						<div class="info_div_total">
							<div class="first_column">
								<li><p class="report_total">Total</p></li>
							</div>
							<div class="second_column">
								<li><p class="report_total"><?php echo $total_hour_decimal_task; ?></p></li>
							</div>
							<div class="third_column">
								<li><p class="report_total"><?php echo $total_bill_task; ?></p></li>
							</div>
						</div>
					</div>
<!------------------------------------------------------ STAFF ------------------------------------------------------->					
					<div id="staff" class="tab tab_content" style="display: none;">		
						<div class="header_titles">
							<div class="first_column">
								<h3>Name</h3>
							</div>
							<div class="second_column">
								<h3>Hours</h3>
							</div>
							<div class="third_column">
								<h3>Billable Amount</h3>
							</div>
							<?php
							$total_hour_decimal_person = 0;
							$total_bill_person = 0;
							$person_n = "";
							$person_x = "";
							$get_hour = array();									
							foreach($persons as $person){
								foreach ($import_data as $import_item){
									$person_name = $person->person_first_name ." ". $person->person_last_name;
									$person_name_import = $import_item->task_person;
									$client_hour = $import_item->task_hour;									
									if($person_name == $person_name_import) {										
										if ($person_n != $person_name) {											
											$person_n = $person_name;											
											$get_hour[$person_name] = $client_hour;
										} 
										else {											
											$cur_date = strtotime($get_hour[$person_name]) + strtotime($client_hour);
											$get_hour[$person_name] = date('h:i:s', $cur_date);											
										}
									}
								}
								
								foreach ($import_data as $import_item){
									$person_name = $person->person_first_name ." ". $person->person_last_name;
									$person_hourly_rate -> $perso->person_hourly_rate;
									$person_name_import = $import_item->task_person;
									$client_hour = $import_item->task_hour;
									$person_hourly_rate = $person->person_hourly_rate;
									$billable_amount = $get_hour[$person_name]*$person_hourly_rate;
									if($person_name == $person_name_import){
										if ($person_x != $person_name) {
											$person_x = $person_name;
											$decimal_hours = decimalHours($get_hour[$person_name]);
											$rounded_hour = round($decimal_hours, 2);
											$billable_amount = $rounded_hour * $person_hourly_rate;
 							?>
							<div class="info_div">
								<div class="first_column">											
									<li><?php echo $person_name; ?></li>
								</div>
								<div class="second_column">											
									<li><?php echo $rounded_hour; ?></li>
								</div>
								<div class="third_column">
									<li><?php echo $billable_amount; ?></li>
								</div>
							</div>
								<?php
									$total_hour_decimal_person += $rounded_hour;
									$total_bill_person += $billable_amount;
										}
									}
								}
							}
								
							?>
							<div class="info_div_total">
								<div class="first_column">
									<li><p class="report_total">Total</p></li>
								</div>
								<div class="second_column">
									<li><p class="report_total"><?php echo $total_hour_decimal_person; ?></p></li>
								</div>
								<div class="third_column">
									<li><p class="report_total"><?php echo $total_bill_person; ?></p></li>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>