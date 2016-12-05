<?php /* Template name: Project Management */ ?>
<?php get_header(); ?>
<?php 
$table_name = $wpdb->prefix . "custom_timesheet";
$table_name_project = $wpdb->prefix . "custom_project";
$table_name_person = $wpdb->prefix . "custom_person";
$table_monthly_plan = $wpdb->prefix . "custom_monthly_plan";
$table_name_client = $wpdb->prefix . "custom_client";
$table_name_task = $wpdb->prefix . "custom_task";

$timesheets = $wpdb->get_results("SELECT * FROM {$table_name}");
$projects = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY project_client ASC");
$project_names = $wpdb->get_results("SELECT DISTINCT project_name FROM {$table_name_project}");
$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
?>
<?php $year = date('Y'); ?>
<?php $month = date('m'); ?>
<div class="project_management">
	<div style="display:none;" class="status_message"><p></p></div>
	<div class="tab-holder">
		<div class="tab-hold tabs-wrapper">
			<div class="full_width">
				<ul id="tabs" class="tabset tabs">
					<li class="tabs_li active"><a href="#dev">DEV</a></li>
					<li class="tabs_li"><a href="#seo">SEO</a></li>
					<li class="tabs_li"><a href="#internal_dev">Internal DEV</a></li>
					<li class="tabs_li"><a href="#internal_seo">Internal SEO</a></li>
					<li class="tabs_li"><a href="#customer_issues_bugs">Customer Issues/bugs</a></li>
				</ul>
			</div>
			<div class="tab-box tabs-container">
				<!-- ------------------------------------ DEV ------------------------------------  --> 
				<div id="dev" class="tab tab_content active" style="display: none;">
					<div class="display_main">
						<div class="section current">
							<h1>Current Ongoing Projects</h1>
							<div class="header_subtitle">
								<h3 class="button_header column"></h3>
								<h3 class="first_column column">Customer</h3>
								<h3 class="second_column column">Project Name</h3>
								<h3 class="third_column column">Started</h3>
								<h3 class="fourth_column column">DiP</h3>
								<h3 class="fifth_column column">Deadline</h3>
								<h3 class="sixth_column column">Hours</h3>
								<h3 class="seventh_column column">Revenue</h3>
								<h3 class="eighth_column column">Expenses</h3>
								<h3 class="ninth_column column">Main Dev.</h3>
								<h3 class="tenth_column column">Status</h3>				
							</div>
							<?php 
								$project_client_temp = "";
								$project_ongoing = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY STR_TO_DATE(project_start_date, '%m/%d/%Y')  DESC");
								foreach($project_ongoing as $project){
									if($project->project_date_completed == null){
										if($project->project_name != 'Monthly Ongoing SEO' && $project->project_name != 'Monthly Ongoing Dev' && $project->project_name != 'Issue/Bug'){
											if($project->project_client != 'SEOWeb Solutions'){
												$project_client				= $project->project_client;
												$project_name				= $project->project_name;
												$project_start_date			= $project->project_start_date;		
												$project_estimated_deadline	= $project->project_estimated_deadline;
												$project_hour				= $project->project_hour;
												$project_minute				= $project->project_minute;
												$project_responsible_worker = $project->project_responsible_worker;
												$project_current_status		= $project->project_current_status;
												$project_description		= $project->project_description;
												$project_budget				= $project->project_budget;
												$project_extra_expenses		= $project->project_extra_expenses;
												$project_default_expenses	= $project->project_default_expenses;
												$project_invoiced_amount	= $project->project_invoiced_amount;
												
												$today						= date('m/d/Y');
												if($project_start_date != null){
													$project_days_in_production	= dateDiff($project_start_date,$today);
													}else{
													$project_days_in_production = "--";
												}
												
												$project_hours = $project_hour.":".$project_minute.":00";
												$project_decimal_hours = decimalHours($project_hours);
												$project_rounded_hour = round($project_decimal_hours, 2);
												
												$start_date = date("d/m/Y", strtotime($project_start_date));
												$today_date	= date('d/m/Y');												
												$timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$start_date', '%d/%m/%Y') AND STR_TO_DATE('$today_date', '%d/%m/%Y')");
												
												$timesheet_hour_decimal = "";											
												foreach($timesheets as $timesheet){
													if($timesheet->task_label == $project_client){
														$task_hour = $timesheet->task_hour;										
														$decimal_hours = decimalHours($task_hour);
														$rounded_hour = round($decimal_hours, 2);		
														$timesheet_hour_decimal += $rounded_hour;
													}				
												}
												
												if($project_rounded_hour != null || $project_rounded_hour != 0){
													$total_hour_decimal = $project_rounded_hour;
												}else{
													$total_hour_decimal = $timesheet_hour_decimal;
												}
												
												$current_expense = $project_default_expenses + $project_extra_expenses;
												
												foreach($persons as $person){
													$person_full_name = $person->person_first_name ." ". $person->person_last_name;
													if($project_responsible_worker == $person_full_name){
														$person_hourly_rate = $person->person_hourly_rate;														
														$multiply = $total_hour_decimal * $person_hourly_rate;					
														$add = $multiply + $current_expense;
														$revenue = $project_budget - $add;
													}
												}
												
												$today_date_ongoing_format = date("d/m/y", strtotime($today));
												$today_date_ongoing_explode = explode('/', $today_date_ongoing_format);
												$today_date_ongoing_mktime = mktime(0, 0, 0, $today_date_ongoing_explode[1], $today_date_ongoing_explode[0], $today_date_ongoing_explode[2]);
												
												$project_estimated_deadline_format = date("d/m/y", strtotime($project_estimated_deadline));
												$project_estimated_deadline_explode = explode('/', $project_estimated_deadline_format);
												$project_estimated_deadline_mktime = mktime(0, 0, 0, $project_estimated_deadline_explode[1], $project_estimated_deadline_explode[0], $project_estimated_deadline_explode[2]);
							?>
												<div id="display_note_<?php echo $project->ID ?>" class="display_note display_list hide_list_<?php echo $project->ID ?>">
													<div class="info_div">
														<div class="buttons column">
															<div id="edit_<?php echo $project->ID ?>" class="button_2 modal_form_edit">E</div>
															<div id="archive_<?php echo $project->ID ?>" class="button_2 modal_form_archive">A</div>
															<div id="delete_<?php echo $project->ID ?>" class="button_2 modal_form_delete">D</div>
															<div style="display:none;" id="loader_<?php echo $project->ID ?>" class="loader"></div>
														</div>
														<p id="first_column_<?php echo $project->ID; ?>" class="client_info first_column column"><?php echo ($project_client != null) ? $project_client : "--"; ?></p>
														<p id="second_column_<?php echo $project->ID; ?>" class="second_column column"><?php echo ($project_name != null) ? $project_name : "--"; ?></p>
														<p id="third_column_<?php echo $project->ID; ?>" class="third_column column"><?php echo ($project_start_date != null) ? $project_start_date : "--"; ?></p>
														<p id="fourth_column_<?php echo $project->ID; ?>" class="fourth_column column"><?php echo $project_days_in_production; ?></p>
														<p id="fifth_column_<?php echo $project->ID; ?>" class="fifth_column column <?php echo ($today_date_ongoing_mktime > $project_estimated_deadline_mktime) ? "red_bg" : ""; ?>"><?php echo ($project_estimated_deadline != null) ? $project_estimated_deadline : "--"; ?></p>
														<p id="sixth_column_<?php echo $project->ID; ?>" class="sixth_column column"><?php echo ($total_hour_decimal != null) ? round_quarter($total_hour_decimal) : "--"; ?></p>
														<p id="seventh_column_<?php echo $project->ID; ?>" class="seventh_column column <?php echo ($revenue > 0) ? "green_bg" : "red_bg"; ?>"><?php echo ($revenue != null) ? round($revenue) : "--"; ?></p>
														<p id="eighth_column_<?php echo $project->ID; ?>" class="eighth_column column"><?php echo ($current_expense != null) ? $current_expense : "--"; ?></p>					 
														<p id="ninth_column_<?php echo $project->ID; ?>" class="ninth_column column"><?php echo ($project_responsible_worker != null) ? $project_responsible_worker : "--"; ?></p>
														<p id="tenth_column_<?php echo $project->ID; ?>" class="tenth_column_ column"><?php echo ($project_current_status != null) ? $project_current_status : "--"; ?></p>	
													</div>
													<div style="display:none" id="project_notes_<?php echo $project->ID ?>" class="project_notes">
														<p style="float:left"><strong><?php echo $project_client .":&nbsp";?></strong></p>
														<p style="float:left"><?php echo $project_description; ?></p>
													</div>
												</div>
							<?php 
											}
										}
									}
								}
							?>
						</div>
						<div class="section completed">
							<h1>Completed Webdev Projects</h1>
							<div class="top_navi">
								<div class="pm_filter completed_webdev_filter">
									<div style="display: none;" class="loader completed_project_filter_loader"></div>
									<div class="report_top_label"><h1><?php echo $year; ?></h1></div>
									<div class="arrow_container">										
										<div class="button_2"><div class="nav_buttons year_previous previous_arrow"></div></div>
										<div class="button_2"><div class="nav_buttons year_next next_arrow"></div></div>
									</div>									
									<input type="hidden" class="current_year" value="<?php echo $year; ?>" />
								</div>
							</div>
							<div class="header_subtitle">
								<h3 class="button_header column"></h3>
								<h3 class="first_column column">Customer</h3>
								<h3 class="second_column column">Project Name</h3>
								<h3 class="third_column column">Started</h3>
								<h3 class="fourth_column column">DiP</h3>
								<h3 class="fifth_column column">Completed</h3>
								<h3 class="sixth_column column">Deadline</h3>
								<h3 class="seventh_column column">Invoiced</h3>
								<h3 class="eighth_column column">Hours</h3>
								<h3 class="ninth_column column">Revenue</h3>
								<h3 class="tenth_column column">Main Dev.</h3>
								<h3 class="eleventh_column column">Status</h3>	
							</div>
							<div class="completed_webdev_container">
							<?php 
								$project_client_temp = "";
								$filter_year = "STR_TO_DATE(project_date_completed, '%m/%d/%Y') BETWEEN STR_TO_DATE('01/01/$year', '%m/%d/%Y') AND STR_TO_DATE('12/31/$year', '%m/%d/%Y')";
								$project_completed = $wpdb->get_results("SELECT * FROM {$table_name_project} WHERE $filter_year ORDER BY STR_TO_DATE(project_start_date, '%m/%d/%Y') DESC");									
								$year_total_hour_decimal = "";
								$year_total_revenue = "";
								foreach($project_completed as $project){
									if($project->project_date_completed != null){
										if($project->project_name != 'Monthly Ongoing SEO' && $project->project_name != 'Monthly Ongoing Dev'){	
											if($project->project_client != 'SEOWeb Solutions'){
												$project_client				= $project->project_client;
												$project_name				= $project->project_name;
												$project_start_date			= $project->project_start_date;		
												$project_estimated_deadline	= $project->project_estimated_deadline;
												$project_hour				= $project->project_hour;
												$project_minute				= $project->project_minute;
												$project_date_completed		= $project->project_date_completed;
												$project_responsible_worker = $project->project_responsible_worker;
												$project_current_status		= $project->project_current_status;
												$project_description		= $project->project_description;
												$project_budget				= $project->project_budget;
												$project_extra_expenses		= $project->project_extra_expenses;
												$project_invoice_date		= $project->project_invoice_date;
												$project_invoiced_amount	= $project->project_invoiced_amount;
												
												$today						= date('m/d/Y');
												if($project_start_date != null && $project_date_completed != null){
													$project_days_in_production	= dateDiff($project_start_date,$project_date_completed);			
													}else{
													$project_days_in_production = "--";
												}
												$project_hours = $project_hour.":".$project_minute.":00";
												$project_decimal_hours = decimalHours($project_hours);
												$project_rounded_hour = round($project_decimal_hours, 2);
												
												$task_project_status = "completed_".$project_start_date ."_". $project_date_completed;
												$completed_timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND task_project_status='$task_project_status'");
												
												$timesheet_hour_decimal = "";			
												foreach($completed_timesheets as $completed_timesheet){													
													$task_hour = $completed_timesheet->task_hour;					
													$decimal_hours = decimalHours($task_hour);
													$rounded_hour = round($decimal_hours, 2);		
													$timesheet_hour_decimal += $rounded_hour;			
												}
												
												if($project_rounded_hour != null || $project_rounded_hour != 0){
													$total_hour_decimal = $project_rounded_hour;
												}else{
													$total_hour_decimal = $timesheet_hour_decimal;
												}												
												$current_expense = $project_default_expenses + $project_extra_expenses;
												
												foreach($persons as $person){
													$person_full_name = $person->person_first_name ." ". $person->person_last_name;
													if($project_responsible_worker == $person_full_name){
														// print_var('timesheet_hour_decimal - ' . $total_hour_decimal);
														// print_var('person_hourly_rate - ' . $person_hourly_rate);
														// print_var('project_default_expenses - ' . $project_default_expenses);														
														// print_var('project_extra_expenses - ' . $project_extra_expenses);														
														// print_var('project_invoiced_amount - ' . $project_invoiced_amount);
														// print_var('formula: MULTIPLY = timesheet_hour_decimal * person_hourly_rate');
														// print_var('formula: ADD = MULTIPLY + (project_default_expenses + project_extra_expenses)');
														// print_var('formula: REVENUE = project_invoiced_amount - ADD');
														$person_hourly_rate = $person->person_hourly_rate;														
														$multiply = $total_hour_decimal * $person_hourly_rate;
														$add = $multiply + $current_expense;
														$revenue = $project_invoiced_amount - $add;													
													}
												}
												
												$project_date_completed_format = date("d/m/y", strtotime($project_date_completed));
												$project_date_completed_explode = explode('/', $project_date_completed_format);
												$project_date_completed_mktime = mktime(0, 0, 0, $project_date_completed_explode[1], $project_date_completed_explode[0], $project_date_completed_explode[2]);
												
												$project_estimated_deadline_format = date("d/m/y", strtotime($project_estimated_deadline));
												$project_estimated_deadline_explode = explode('/', $project_estimated_deadline_format);
												$project_estimated_deadline_mktime = mktime(0, 0, 0, $project_estimated_deadline_explode[1], $project_estimated_deadline_explode[0], $project_estimated_deadline_explode[2]);
							?>
											<div id="display_note_<?php echo $project->ID ?>" class="display_note display_list hide_list_<?php echo $project->ID ?>">
												<div class="info_div">
													<div class="buttons column">
														<div id="edit_archive_<?php echo $project->ID ?>" class="button_2 modal_form_edit_archive">E</div>
														<div id="delete_<?php echo $project->ID ?>" class="button_2 modal_form_delete">D</div>
														<div style="display:none;" id="loader_<?php echo $project->ID ?>" class="loader"></div>
													</div>
													<p id="first_column_<?php echo $project->ID; ?>" class="client_info first_column column"><?php echo ($project_client != null) ? $project_client : "--"; ?></p>
													<p id="second_column_<?php echo $project->ID; ?>" class="second_column column"><?php echo ($project_name != null) ? $project_name : "--"; ?></p>
													<p id="third_column_<?php echo $project->ID; ?>" class="third_column column"><?php echo ($project_start_date != null) ? $project_start_date : "--"; ?></p>
													<p id="fourth_column_<?php echo $project->ID; ?>" class="fourth_column column"><?php echo ($project_days_in_production != null) ? $project_days_in_production : "--"; ?></p>
													<p id="fifth_column_<?php echo $project->ID; ?>" class="fifth_column column <?php echo ($project_date_completed_mktime > $project_estimated_deadline_mktime) ? "red_bg" : ""; ?>"><?php echo ($project_date_completed != null) ? $project_date_completed : "--"; ?></p>
													<p id="sixth_column_<?php echo $project->ID; ?>" class="sixth_column column"><?php echo ($project_estimated_deadline != null) ? $project_estimated_deadline : "--"; ?></p>
													<p id="seventh_column_<?php echo $project->ID; ?>" class="seventh_column column"><?php echo ($project_invoice_date != null) ? $project_invoice_date : "--"; ?></p>
													<p id="eighth_column_<?php echo $project->ID; ?>" class="eighth_column column"><?php echo ($total_hour_decimal != null) ? round_quarter($total_hour_decimal) : "--"; ?></p>
													<p id="ninth_column_<?php echo $project->ID; ?>" class="ninth_column column <?php echo ($revenue > 0) ? "green_bg" : "red_bg"; ?>"><?php echo ($revenue != null) ? round($revenue) : "--"; ?></p>
													<p id="tenth_column_<?php echo $project->ID; ?>" class="tenth_column column"><?php echo ($project_responsible_worker != null) ? $project_responsible_worker : "--"; ?></p>
													<p id="eleventh_column_<?php echo $project->ID; ?>" class="eleventh_column column"><?php echo ($project_current_status != null) ? $project_current_status : "--"; ?></p>	
												</div>
												<div style="display:none" id="project_notes_<?php echo $project->ID ?>" class="project_notes">
													<p style="float:left"><strong><?php echo $project_client .":&nbsp";?></strong></p>
													<p style="float:left"><?php echo $project_description; ?></p>
												</div>
											</div>
							<?php 
											}
										}
									}
									$year_total_hour_decimal += $total_hour_decimal;
									$year_total_revenue += $revenue;
								}
							?>	
							</div>
							<div class="completed_webdev_totals">
								<p class="totals column">TOTAL</p>
								<p class="first_column column">&nbsp;</p>
								<p class="second_column column">&nbsp;</p>
								<p class="third_column column">&nbsp;</p>
								<p class="fourth_column column">&nbsp;</p>
								<p class="fifth_column column">&nbsp;</p>
								<p class="sixth_column column">&nbsp;</p>
								<p class="seventh_column column">&nbsp;</p>
								<p class="eighth_column column"><?php echo round_quarter($year_total_hour_decimal); ?></p>
								<p class="ninth_column column"><?php echo round($year_total_revenue); ?></p>
								<p class="tenth_column column">&nbsp;</p>
								<p class="eleventh_column column">&nbsp;</p>
							</div>
						</div>
					</div>
				</div>
				<!-- ------------------------------------ SEO ------------------------------------  --> 
				<div id="seo" class="tab tab_content" style="display: none;">
					<div class="display_main">
						<div class="section current">
							<h1>Current Ongoing Projects</h1>
							<div class="top_navi">
								<div class="pm_filter current_seo_filter">
									<div style="display: none;" class="loader current_seo_filter_loader"></div>
									<?php 
										$months = array (01=>'Jan', 02=>'Feb', 03=>'Mar', 04=>'Apr', 05=>'May', 06=>'Jun', 07=>'Jul', 08=>'Aug', 09=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');										
									?>
									<div class="report_top_label"><h1><?php echo $months[(int)$month] ." ". $year; ?></h1></div>
									<div class="default_arrow_container">
										<div class="button_2"><div class="nav_buttons previous_arrow"></div></div>
										<div class="button_2"><div class="nav_buttons next_arrow"></div></div>
									</div>
									<div style="display:none;" class="arrow_container">
										<div class="button_2"><div class="nav_buttons previous_arrow"></div></div>
										<div class="button_2"><div class="nav_buttons next_arrow"></div></div>
									</div>
									<select class="current_seo_filter_select">
										<option>Month</option>
										<option>Year</option>										
									</select>
									<input type="hidden" class="current_year" value="<?php echo $year; ?>" />
									<input type="hidden" class="current_month" value="<?php echo $month; ?>" />
								</div>
							</div>
							<div class="header_subtitle">								
								<h3 class="first_column column">Customer</h3>
								<h3 class="second_column column">SEO Plan</h3>
								<h3 class="third_column column">DEV Plan</h3>
								<h3 class="fourth_column column">SEO Hours</h3>
								<h3 class="fifth_column column">DEV Hours</h3>
								<h3 class="sixth_column column">CON Hours</h3>
								<h3 class="seventh_column column">Total Hours</h3>
								<h3 class="eighth_column column">Expenses</h3>
								<h3 class="ninth_column column">Revenue</h3>
								<h3 class="tenth_column column">Income</h3>
							</div>
							<div class="current_seo_container">
							<?php 
								$project_client_temp = "";
								$seo_ongoing_array = array();
								$seo_hours = array();
								$count = 0;
								foreach($projects as $project){
									if($project->project_date_completed == null){
										if($project->project_invoice_method == 1){
											if($project->project_name == 'Monthly Ongoing SEO' || $project->project_name == 'Monthly Ongoing Dev'){	
												if($project->project_client != 'SEOWeb Solutions'){												
													$project_client				= $project->project_client;
													$project_name				= $project->project_name;
													$project_start_date			= $project->project_start_date;		
													$project_estimated_deadline	= $project->project_estimated_deadline;
													$project_hour				= $project->project_hour;
													$project_minute				= $project->project_minute;
													$project_responsible_worker = $project->project_responsible_worker;
													$project_current_status		= $project->project_current_status;
													$project_description		= $project->project_description;
													$project_budget				= $project->project_budget;
													$project_extra_expenses		= $project->project_extra_expenses;
													$project_default_expenses	= $project->project_default_expenses;
													$project_invoiced_amount	= $project->project_invoiced_amount;
													
													$project_monthly_plan = $project->project_monthly_plan;
													$monthly_plans = $wpdb->get_row("SELECT * FROM {$table_monthly_plan} WHERE monthly_name='$project_monthly_plan'");
													$monthly_budget = $monthly_plans->monthly_budget;
													$monthly_seo_extra_expense = $monthly_plans->monthly_seo_extra_expense;
													$monthly_dev_extra_expense = $monthly_plans->monthly_dev_extra_expense;							
													
													$current_year = date('Y');
													$month_filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$month/$current_year', '%d/%m/%Y') AND STR_TO_DATE('31/$month/$current_year', '%d/%m/%Y')";
													$month_hours = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $month_filter AND task_project_name = '$project_name' AND task_label = '$project_client'");
													$total_month_hours_seo = "";
													$total_month_hours_dev = "";
													$total_month_con_hours = "";
													$total_month_hours = "";												
													foreach($month_hours as $month_hour){
														$task_name = format_task_name($month_hour->task_name);
														$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");
														$task_person = $month_hour->task_person;
														$task_hour = $month_hour->task_hour;
														if($tasks->task_billable == 1){																												
															if($project_name == 'Monthly Ongoing SEO'){
																$task_hour_decimal_seo = round(decimalHours($task_hour), 2);
																$total_month_hours_seo += $task_hour_decimal_seo;
															}													
															if($project_name == 'Monthly Ongoing Dev'){
																$task_hour_decimal_dev = round(decimalHours($task_hour), 2);
																$total_month_hours_dev += $task_hour_decimal_dev;
															}																											
															$task_hour = $month_hour->task_hour;
															$task_hour_decimal = round(decimalHours($task_hour), 2);
															$total_month_hours += $task_hour_decimal;
														}else{															
															if($month_hour->task_person == 'Quima May Renegado'){
																$task_hour_decimal_con = round(decimalHours($task_hour), 2);																
																$total_month_con_hours += $task_hour_decimal_con;
															}	
														}
													}
													
													$current_expense = $project_default_expenses + $project_extra_expenses + $monthly_seo_extra_expense + $monthly_dev_extra_expense;
													$seo_hours[$project_client][] = $total_month_hours_seo;
													if($total_month_hours_seo != null){
														$ar_total_month_hours_seo = $total_month_hours_seo;
														}elseif($ar_total_month_hours_seo == null){
														$ar_total_month_hours_seo =  0;
													}
													
													if($current_expense != null){
														$ar_current_expense = $current_expense;
														}elseif($ar_current_expense == null){
														$ar_current_expense =  0;
													}
													
													if($total_month_con_hours != null){
														$ar_total_month_con_hours = $total_month_con_hours;
													}elseif($ar_total_month_con_hours == null){
														$ar_total_month_con_hours =  0;
													}
													
													if($project_budgets != null){
														$project_budgets = $project_budgets + $project_budget;
														}else{
														$project_budgets = $project_budget;
													}
													
													if($project_descriptions != null){
														$project_descriptions = $project_descriptions .'<join>'. $project_description;
														}else{
														$project_descriptions = $project_description;
													}
													
													$ar_total_month_hours_dev = ($total_month_hours_dev != null) ? $total_month_hours_dev : 0;												
													$ar_total_month_hours = ($total_month_hours != null) ? $total_month_hours : 0;												
													$ar_project_budgets = ($project_budgets != null) ? $project_budgets : 0;												
													
													$seo_ongoing_array[$project_client] = $ar_total_month_hours_seo ."<_>". $ar_total_month_hours_dev ."<_>". $ar_total_month_con_hours ."<_>". $ar_current_expense ."<_>". $ar_project_budgets ."<_>". $project_descriptions;				
													if($count == 1){
														$ar_total_month_con_hours = "";
														$project_budgets = "";
														$project_descriptions = "";
														$count = 0;
														}else{
														$count++;
													}											
												}
											}
										}
									}
								}
								foreach($seo_ongoing_array as $seo_ongoing_client => $seo_ongoing){										
									$seo_detail_explode = explode('<_>', $seo_ongoing);
									if($seo_hours[$seo_ongoing_client][0] != null && $seo_hours[$seo_ongoing_client][1] == null){
										$total_month_hours_seo = $seo_hours[$seo_ongoing_client][0];
									}elseif($seo_hours[$seo_ongoing_client][0] == null && $seo_hours[$seo_ongoing_client][1] != null){
										$total_month_hours_seo = $seo_hours[$seo_ongoing_client][1];
									}elseif($seo_hours[$seo_ongoing_client][0] == null && $seo_hours[$seo_ongoing_client][1] == null){
										$total_month_hours_seo = 0;
									}
									// $total_month_hours_seo = $seo_detail_explode[0];
									$total_month_hours_dev = $seo_detail_explode[1];
									$total_month_con_hours = $seo_detail_explode[2];
									$current_expense = $seo_detail_explode[3];
									$project_budget = $seo_detail_explode[4];
									$project_description_explode = explode('<join>',$seo_detail_explode[5]);
									$prject_description_seo = $project_description_explode[0];
									$prject_description_dev = $project_description_explode[1];
									$client_details = $wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name='$seo_ongoing_client'");
									$client_id = $client_details->ID;
									
									$project_details_seo = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name='Monthly Ongoing SEO' AND project_client='$seo_ongoing_client'");
									$monthly_plan_seo_name = ($project_details_seo->project_monthly_plan) ? $project_details_seo->project_monthly_plan : "--";
									$monthly_plans_seo = $wpdb->get_row("SELECT * FROM {$table_monthly_plan} WHERE monthly_name='$monthly_plan_seo_name'");									
									$monthly_plans_seo_hour = ($monthly_plans_seo->monthly_seo_hours) ? $monthly_plans_seo->monthly_seo_hours : "--";
									$monthly_plans_seo_budget = $monthly_plans_seo->monthly_budget;
									$monthly_seo_extra_expense = $monthly_plans_seo->monthly_seo_extra_expense;
									
									
									$project_details_dev = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name='Monthly Ongoing Dev' AND project_client='$seo_ongoing_client'");								
									$monthly_plan_dev_name = ($project_details_dev->project_monthly_plan != null) ? $project_details_dev->project_monthly_plan : "--";
									$monthly_plans_dev = $wpdb->get_row("SELECT * FROM {$table_monthly_plan} WHERE monthly_name='$monthly_plan_dev_name'");									
									$monthly_plans_dev_hour = ($monthly_plans_dev->monthly_webdev_hours) ? $monthly_plans_dev->monthly_webdev_hours : "--";										
									$monthly_plans_dev_budget = $monthly_plans_dev->monthly_budget;
									$monthly_dev_extra_expense = $monthly_plans_dev->monthly_dev_extra_expense;
									
									$total_month_hours = $total_month_hours_seo + $total_month_hours_dev + $total_month_con_hours;
									
									
									foreach($persons as $person){
										$person_full_name = $person->person_fullname;
										$person_hourly_rate = $person->person_hourly_rate;
										if($person_full_name == 'Cristobal Dela Cuesta'){
											$multiply_tobal = $total_month_hours_seo * $person_hourly_rate;														
										}
										if($person_full_name == 'Gray Gonzales'){
											$multiply_gray = $total_month_hours_dev * $person_hourly_rate;														
										}
										if($person_full_name == 'Quima May Renegado'){
											$multiply_quima = $total_month_con_hours * $person_hourly_rate;														
										}
									}										
									$project_expense = $current_expense + $multiply_tobal + $multiply_gray + $multiply_quima;									
																		
									if($monthly_plans_seo_budget != null){
										$monthly_plans_buget = $monthly_plans_seo_budget;
										}else{
										$monthly_plans_buget = $monthly_plans_dev_budget;
									}
									
									$revenue = $monthly_plans_buget - $project_expense;
									if($revenue < 0){
										$revenue_class = 'red_bg';
										}else{
										$revenue_class = 'green_bg';
									}
								?>
								<div id="display_note_<?php echo $client_id; ?>" class="display_note display_list hide_list_<?php echo $client_id; ?>">
									<div class="info_div">										
										<p id="first_column_<?php echo $client_id; ?>" class="client_info first_column column"><?php echo $seo_ongoing_client; ?></p>								
										<p id="second_column_<?php echo $client_id; ?>" class="second_column column"><?php echo round_quarter($monthly_plans_seo_hour); ?></p>																								
										<p id="third_column_<?php echo $client_id; ?>" class="third_column column"><?php echo round_quarter($monthly_plans_dev_hour); ?></p>																								
										<p id="fourth_column_<?php echo $client_id; ?>" class="fourth_column column"><?php echo round_quarter($total_month_hours_seo); ?></p>
										<p id="fifth_column_<?php echo $client_id; ?>" class="fifth_column column"><?php echo round_quarter($total_month_hours_dev); ?></p>													
										<p id="sixth_column_<?php echo $client_id; ?>" class="sixth_column column"><?php echo round_quarter($total_month_con_hours); ?></p>
										<p id="seventh_column_<?php echo $client_id; ?>" class="seventh_column column"><?php echo round_quarter($total_month_hours); ?></p>
										<p id="eighth_column_<?php echo $client_id; ?>" class="eighth_column column"><?php echo $project_expense; ?></p>
										<p id="ninth_column_<?php echo $client_id; ?>" class="ninth_column column <?php echo $revenue_class; ?>"><?php echo round($revenue); ?></p>
										<p id="tenth_column_<?php echo $client_id; ?>" class="tenth_column column"><?php echo $monthly_plans_buget; ?></p>
									</div>
									<div style="display:none" id="project_notes_<?php echo $client_id; ?>" class="project_notes">
										<p style="float:left"><strong><?php echo $seo_ongoing_client .":&nbsp";?></strong></p>
										<p style="float:left"><?php echo '<strong>SEO: </strong>' . $prject_description_seo . '<br/>' . '<strong>DEV: </strong>' . $prject_description_dev; ?></p>
									</div>
								</div>
							<?php } ?>
							</div>
						</div>
						<div class="section completed">
							<h1>Cancelled SEO Projects</h1>
								<div class="header_subtitle">								
									<h3 class="first_column column">Customer</h3>
									<h3 class="second_column column">SEO Plan</h3>
									<h3 class="third_column column">DEV Plan</h3>
									<h3 class="fourth_column column">SEO Hours</h3>
									<h3 class="fifth_column column">DEV Hours</h3>
									<h3 class="sixth_column column">CON Hours</h3>
									<h3 class="seventh_column column">Total Hours</h3>
									<h3 class="eighth_column column">Expenses</h3>
									<h3 class="ninth_column column">Revenue</h3>			
								</div>
							<?php 
								$project_client_temp = "";
								$seo_ongoing_array = array();
								$count = 0;
								foreach($projects as $project){
									if($project->project_date_completed != null){
										if($project->project_name == 'Monthly Ongoing SEO' || $project->project_name == 'Monthly Ongoing Dev'){	
											if($project->project_client != 'SEOWeb Solutions'){												
												$project_client				= $project->project_client;
												$project_name				= $project->project_name;
												$project_start_date			= $project->project_start_date;		
												$project_estimated_deadline	= $project->project_estimated_deadline;
												$project_hour				= $project->project_hour;
												$project_minute				= $project->project_minute;
												$project_responsible_worker = $project->project_responsible_worker;
												$project_current_status		= $project->project_current_status;
												$project_description		= $project->project_description;
												$project_budget				= $project->project_budget;
												$project_extra_expenses		= $project->project_extra_expenses;
												$project_default_expenses	= $project->project_default_expenses;
												$project_invoiced_amount	= $project->project_invoiced_amount;
												
												$project_monthly_plan = $project->project_monthly_plan;
												$monthly_plans = $wpdb->get_row("SELECT * FROM {$table_monthly_plan} WHERE monthly_name='$project_monthly_plan'");							
												$monthly_budget = $monthly_plans->monthly_budget;
												$monthly_seo_extra_expense = $monthly_plans->monthly_seo_extra_expense;
												$monthly_dev_extra_expense = $monthly_plans->monthly_dev_extra_expense;							
												
												$current_year = date('Y');
												$year_filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/$current_year', '%d/%m/%Y') AND STR_TO_DATE('31/12/$current_year', '%d/%m/%Y')";
												$year_hours = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $year_filter AND task_project_name = '$project_name' AND task_label = '$project_client'");
												$total_year_hours_seo = "";
												$total_year_hours_dev = "";
												$total_year_con_hours = "";
												$total_year_hours = "";												
												foreach($year_hours as $year_hour){
													$task_person = $year_hour->task_person;
													$task_hour = $year_hour->task_hour;													
													if($project_name == 'Monthly Ongoing SEO'){
														$task_hour_decimal_seo = round(decimalHours($task_hour), 2);
														$total_year_hours_seo += $task_hour_decimal_seo;
													}													
													if($project_name == 'Monthly Ongoing Dev'){
														$task_hour_decimal_dev = round(decimalHours($task_hour), 2);
														$total_year_hours_dev += $task_hour_decimal_dev;
													}
													if($year_hour->task_person == 'Quima May Renegado'){														
														$task_hour_decimal_con = round(decimalHours($task_hour), 2);
														$total_year_con_hours += $task_hour_decimal_con;														
													}													
													$task_hour = $year_hour->task_hour;
													$task_hour_decimal = round(decimalHours($task_hour), 2);
													$total_year_hours += $task_hour_decimal;
												}
												
												$current_expense = $project_default_expenses + $project_extra_expenses + $monthly_seo_extra_expense + $monthly_dev_extra_expense;
												
												if($total_year_hours_seo != null){
													$ar_total_year_hours_seo = $total_year_hours_seo;
													}elseif($ar_total_year_hours_seo == null){
													$ar_total_year_hours_seo =  0;
												}
												
												if($current_expense != null){
													$ar_current_expense = $current_expense;
													}elseif($ar_current_expense == null){
													$ar_current_expense =  0;
												}
												
												if($total_year_con_hours != null){
													$ar_total_year_con_hours = $total_year_con_hours;
													}elseif($ar_total_year_con_hours == null){
													$ar_total_year_con_hours =  0;
												}
												
												if($project_budgets != null){
													$project_budgets = $project_budgets + $project_budget;
													}else{
													$project_budgets = $project_budget;
												}
												
												if($project_descriptions != null){
													$project_descriptions = $project_descriptions .'<join>'. $project_description;
													}else{
													$project_descriptions = $project_description;
												}
												
												$ar_total_year_hours_dev = ($total_year_hours_dev != null) ? $total_year_hours_dev : 0;												
												$ar_total_year_hours = ($total_year_hours != null) ? $total_year_hours : 0;												
												$ar_project_budgets = ($project_budgets != null) ? $project_budgets : 0;												
												
												$seo_ongoing_array[$project_client] = $ar_total_year_hours_seo ."<_>". $ar_total_year_hours_dev ."<_>". $ar_total_year_con_hours ."<_>". $ar_current_expense ."<_>". $ar_project_budgets ."<_>". $project_descriptions;				
												if($count == 1){
													$ar_total_year_con_hours = "";
													$project_budgets = "";
													$project_descriptions = "";
													$count = 0;
													}else{
													$count++;
												}											
											}
										}
									}
								}
								
								foreach($seo_ongoing_array as $seo_ongoing_client => $seo_ongoing){										
									$seo_detail_explode = explode('<_>', $seo_ongoing);										
									$total_year_hours_seo = $seo_detail_explode[0];
									$total_year_hours_dev = $seo_detail_explode[1];
									$total_year_con_hours = $seo_detail_explode[2];
									$current_expense = $seo_detail_explode[3];
									$project_budget = $seo_detail_explode[4];
									$project_description_explode = explode('<join>',$seo_detail_explode[5]);
									$prject_description_seo = $project_description_explode[0];
									$prject_description_dev = $project_description_explode[1];
									$client_details = $wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name='$seo_ongoing_client'");
									$client_id = $client_details->ID;
									$project_details_seo = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name='Monthly Ongoing SEO' AND project_client='$seo_ongoing_client'");
									$monthly_plan_seo_name = ($project_details_seo->project_monthly_plan) ? $project_details_seo->project_monthly_plan : "--";
									$project_details_dev = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name='Monthly Ongoing Dev' AND project_client='$seo_ongoing_client'");
									$monthly_plan_dev_name = ($project_details_dev->project_monthly_plan != null) ? $project_details_dev->project_monthly_plan : "--";
									$total_year_hours = $total_year_hours_seo + $total_year_hours_dev + $total_year_con_hours;
									
									
									foreach($persons as $person){
										$person_full_name = $person->person_fullname;
										$person_hourly_rate = $person->person_hourly_rate;
										if($person_full_name == 'Cristobal Dela Cuesta'){
											$multiply_tobal = $total_year_hours_seo * $person_hourly_rate;														
										}
										if($person_full_name == 'Gray Gonzales'){
											$multiply_gray = $total_year_hours_dev * $person_hourly_rate;														
										}
										if($person_full_name == 'Quima May Renegado'){
											$multiply_quima = $total_year_con_hours * $person_hourly_rate;														
										}
									}										
									$project_expense = $current_expense + $multiply_tobal + $multiply_gray + $multiply_quima;
									$revenue = $project_budget - $project_expense;
									if($revenue < 0){
										$revenue_class = 'red_bg';
										}else{
										$revenue_class = 'green_bg';
									}
							?>								
								<div id="display_note_<?php echo $client_id; ?>" class="display_note display_list hide_list_<?php echo $client_id; ?>">
									<div class="info_div">										
										<p id="first_column_<?php echo $client_id; ?>" class="client_info first_column column"><?php echo $seo_ongoing_client; ?></p>										
										<p id="second_column_<?php echo $client_id; ?>" class="second_column column"><?php echo $monthly_plan_seo_name; ?></p>										
										<p id="third_column_<?php echo $client_id; ?>" class="third_column column"><?php echo $monthly_plan_dev_name; ?></p>																								
										<p id="fourth_column_<?php echo $client_id; ?>" class="fourth_column column"><?php echo $total_year_hours_seo; ?></p>
										<p id="fifth_column_<?php echo $client_id; ?>" class="fifth_column column"><?php echo $total_year_hours_dev; ?></p>													
										<p id="sixth_column_<?php echo $client_id; ?>" class="sixth_column column"><?php echo $total_year_con_hours; ?></p>
										<p id="seventh_column_<?php echo $client_id; ?>" class="seventh_column column"><?php echo $total_year_hours; ?></p>
										<p id="eighth_column_<?php echo $client_id; ?>" class="eighth_column column"><?php echo $project_expense; ?></p>
										<p id="eighth_column_<?php echo $client_id; ?>" class="eighth_column column <?php echo $revenue_class; ?>"><?php echo round($revenue); ?></p>
									</div>
									<div style="display:none" id="project_notes_<?php echo $client_id; ?>" class="project_notes">
										<p style="float:left"><strong><?php echo $seo_ongoing_client .":&nbsp";?></strong></p>
										<p style="float:left"><?php echo '<strong>SEO: </strong>' . $prject_description_seo . '<br/>' . '<strong>DEV: </strong>' . $prject_description_dev; ?></p>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<!-- ------------------------------------ INTERNAL DEV ------------------------------------  --> 
				<div id="internal_dev" class="tab tab_content" style="display: none;">
					<div class="display_main">
						<div class="section current">
							<h1>Current Ongoing Projects</h1>
							<div class="top_navi">
								<div class="pm_filter current_internal_dev_filter">
									<div style="display: none;" class="loader current_internal_dev_filter_loader"></div>									
									<div class="report_top_label"><h1><?php echo $months[(int)$month] ." ". $year; ?></h1></div>
									<div class="default_arrow_container">
										<div class="button_2"><div class="nav_buttons previous_arrow"></div></div>
										<div class="button_2"><div class="nav_buttons next_arrow"></div></div>
									</div>
									<div style="display:none;" class="arrow_container">
										<div class="button_2"><div class="nav_buttons previous_arrow"></div></div>
										<div class="button_2"><div class="nav_buttons next_arrow"></div></div>
									</div>
									<select class="current_internal_dev_filter_select">
										<option>Month</option>
										<option>Year</option>										
									</select>
									<input type="hidden" class="current_year" value="<?php echo $year; ?>" />
									<input type="hidden" class="current_month" value="<?php echo $month; ?>" />
								</div>
							</div>
							<div class="header_subtitle">
								<h3 class="button_header column"></h3>
								<h3 class="first_column column">Customer</h3>
								<h3 class="second_column column">Project Name</h3>
								<h3 class="third_column column">Started</h3>
								<h3 class="fourth_column column">DiP</h3>
								<h3 class="fifth_column column">Deadline</h3>
								<h3 class="sixth_column column">Hours</h3>
								<h3 class="seventh_column column">Revenue</h3>
								<h3 class="eighth_column column">Expenses</h3>
								<h3 class="ninth_column column">Main Dev.</h3>
								<h3 class="tenth_column column">Status</h3>				
							</div>
							<div class="current_internal_dev_container">
							<?php 
								$project_internal_ongoing = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY STR_TO_DATE(project_start_date, '%m/%d/%Y') DESC");
								$project_client_temp = "";
								foreach($project_internal_ongoing as $project){
									if($project->project_date_completed == null){
										// if($project->project_name != 'Monthly Ongoing SEO' && $project->project_name != 'Monthly Ongoing Dev'){
											if($project->project_client == 'SEOWeb Solutions'){
												$project_client				= $project->project_client;
												$project_name				= $project->project_name;
												$project_start_date			= $project->project_start_date;		
												$project_estimated_deadline	= $project->project_estimated_deadline;
												$project_hour				= $project->project_hour;
												$project_minute				= $project->project_minute;
												$project_responsible_worker = $project->project_responsible_worker;
												$project_current_status		= $project->project_current_status;
												$project_description		= $project->project_description;
												$project_budget				= $project->project_budget;
												$project_extra_expenses		= $project->project_extra_expenses;
												$project_default_expenses	= $project->project_default_expenses;
												$project_invoiced_amount	= $project->project_invoiced_amount;
												
												$today = date('m/d/Y');
												
												if($project_start_date != null){
													$project_days_in_production	= dateDiff($project_start_date,$today);
												}else{
													$project_days_in_production = "--";
												}
												
												$project_hours = $project_hour.":".$project_minute.":00";
												$project_decimal_hours = decimalHours($project_hours);
												$project_rounded_hour = round($project_decimal_hours, 2);
												
												$start_date = date("d/m/Y", strtotime($project_start_date));
												$today_date	= date('d/m/Y');
												
												// $timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$start_date', '%d/%m/%Y') AND STR_TO_DATE('$today_date', '%d/%m/%Y')");
												
												$timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$month/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$month/$year', '%d/%m/%Y')");
												
												$timesheet_hour_decimal = "";											
												foreach($timesheets as $timesheet){
													if($timesheet->task_label == $project_client){
														$task_hour = $timesheet->task_hour;
														$decimal_hours = decimalHours($task_hour);
														$rounded_hour = round($decimal_hours, 2);		
														$timesheet_hour_decimal += $rounded_hour;
													}				
												}
												
												if($project_rounded_hour != null || $project_rounded_hour != 0){
													$total_hour_decimal = $project_rounded_hour;
												}else{
													$total_hour_decimal = $timesheet_hour_decimal;
												}
												$current_expense = $project_default_expenses + $project_extra_expenses;
												
												foreach($persons as $person){
													$person_full_name = $person->person_fullname;
													if($project_responsible_worker == $person_full_name){
														$person_hourly_rate = $person->person_hourly_rate;
														$multiply = $total_hour_decimal * $person_hourly_rate;					
														$add = $multiply + $current_expense;
														$revenue = $project_budget - $add;
													}
												}
												
											?>
											<div id="display_note_<?php echo $project->ID ?>" class="display_note display_list hide_list_<?php echo $project->ID ?>">
												<div class="info_div">
													<div class="buttons column">
														<div id="edit_<?php echo $project->ID ?>" class="button_2 modal_form_edit">E</div>
														<div id="archive_<?php echo $project->ID ?>" class="button_2 modal_form_archive">A</div>
														<div id="delete_<?php echo $project->ID ?>" class="button_2 modal_form_delete">D</div>
														<div style="display:none;" id="loader_<?php echo $project->ID ?>" class="loader"></div>
													</div>
													<p id="first_column_<?php echo $project->ID; ?>" class="client_info first_column column"><?php echo ($project_client != null) ? $project_client : "--"; ?></p>
													<p id="second_column_<?php echo $project->ID; ?>" class="second_column column"><?php echo ($project_name != null) ? $project_name : "--"; ?></p>
													<p id="third_column_<?php echo $project->ID; ?>" class="third_column column"><?php echo ($project_start_date != null) ? $project_start_date : "--"; ?></p>
													<p id="fourth_column_<?php echo $project->ID; ?>" class="fourth_column column"><?php echo $project_days_in_production; ?></p>
													<p id="fifth_column_<?php echo $project->ID; ?>" class="fifth_column column <?php echo ($today > $project_estimated_deadline) ? "red_bg" : ""; ?>"><?php echo ($project_estimated_deadline != null) ? $project_estimated_deadline : "--"; ?></p>
													<p id="sixth_column_<?php echo $project->ID; ?>" class="sixth_column column"><?php echo ($total_hour_decimal != null) ? round_quarter($total_hour_decimal) : "--"; ?></p>
													<p id="seventh_column_<?php echo $project->ID; ?>" class="seventh_column column <?php echo ($revenue > 0) ? "green_bg" : "red_bg"; ?>"><?php echo ($revenue != null) ? $revenue : "--"; ?></p>
													<p id="eighth_column_<?php echo $project->ID; ?>" class="eighth_column column"><?php echo ($current_expense != null) ? $current_expense : "--"; ?></p>					 
													<p id="ninth_column_<?php echo $project->ID; ?>" class="ninth_column column"><?php echo ($project_responsible_worker != null) ? $project_responsible_worker : "--"; ?></p>
													<p id="tenth_column_<?php echo $project->ID; ?>" class="tenth_column_ column"><?php echo ($project_current_status != null) ? $project_current_status : "--"; ?></p>	
												</div>
												<div style="display:none" id="project_notes_<?php echo $project->ID ?>" class="project_notes">
													<p style="float:left"><strong><?php echo $project_client .":&nbsp";?></strong></p>
													<p style="float:left"><?php echo $project_description; ?></p>
												</div>
											</div>
											<?php 
											}
										// }
									}
								}
							?>
							</div>
						</div>
						<div class="section completed">
							<h1>Completed Webdev Projects</h1>
							<div class="header_subtitle">
								<h3 class="button_header column">
									<h3 class="first_column column">Customer</h3>
									<h3 class="second_column column">Project Name</h3>
									<h3 class="third_column column">Started</h3>
									<h3 class="fourth_column column">DiP</h3>
									<h3 class="fifth_column column">Completed</h3>
									<h3 class="sixth_column column">Deadline</h3>
									<h3 class="seventh_column column">Invoiced</h3>
									<h3 class="eighth_column column">Hours</h3>
									<h3 class="ninth_column column">Revenue</h3>
									<h3 class="tenth_column column">Main Dev.</h3>
									<h3 class="eleventh_column column">Status</h3>	
								</div>
								<?php 
									$project_client_temp = "";
									$project_completed = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY STR_TO_DATE(project_start_date, '%m/%d/%Y')  DESC");									
									foreach($project_completed as $project){
										if($project->project_date_completed != null){
											if($project->project_name != 'Monthly Ongoing SEO' && $project->project_name != 'Monthly Ongoing Dev'){	
												if($project->project_client == 'SEOWeb Solutions'){
													$project_client				= $project->project_client;
													$project_name				= $project->project_name;
													$project_start_date			= $project->project_start_date;		
													$project_estimated_deadline	= $project->project_estimated_deadline;
													$project_hour				= $project->project_hour;
													$project_minute				= $project->project_minute;
													$project_date_completed		= $project->project_date_completed;
													$project_responsible_worker = $project->project_responsible_worker;
													$project_current_status		= $project->project_current_status;
													$project_description		= $project->project_description;
													$project_budget				= $project->project_budget;
													$project_extra_expenses		= $project->project_extra_expenses;
													$project_invoice_date		= $project->project_invoice_date;
													$project_invoiced_amount	= $project->project_invoiced_amount;
													
													$today						= date('m/d/Y');
													if($project_start_date != null && $project_date_completed != null){
														$project_days_in_production	= dateDiff($project_start_date,$project_date_completed);			
														}else{
														$project_days_in_production = "--";
													}
													$project_hours = $project_hour.":".$project_minute.":00";
													$project_decimal_hours = decimalHours($project_hours);
													$project_rounded_hour = round($project_decimal_hours, 2);
													
													$task_project_status = "completed_".$project_start_date ."_". $project_date_completed;
													$completed_timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND task_project_status='$task_project_status'");
													
													$timesheet_hour_decimal = "";			
													foreach($completed_timesheets as $completed_timesheet){													
														$task_hour = $completed_timesheet->task_hour;					
														$decimal_hours = decimalHours($task_hour);
														$rounded_hour = round($decimal_hours, 2);		
														$timesheet_hour_decimal += $rounded_hour;			
													}
													
													if($project_rounded_hour != null || $project_rounded_hour != 0){
														$total_hour_decimal = $project_rounded_hour;
													}else{
														$total_hour_decimal = $timesheet_hour_decimal;
													}
													$current_expense = $project_default_expenses + $project_extra_expenses;
													
													foreach($persons as $person){
														$person_full_name = $person->person_first_name ." ". $person->person_last_name;
														if($project_responsible_worker == $person_full_name){														
															$person_hourly_rate = $person->person_hourly_rate;														
															$multiply = $total_hour_decimal * $person_hourly_rate;
															$add = $multiply + $current_expense;
															$revenue = $project_invoiced_amount - $add;													
														}
													}
													
													$project_date_completed_format = date("d/m/y", strtotime($project_date_completed));
													$project_date_completed_explode = explode('/', $project_date_completed_format);
													$project_date_completed_mktime = mktime(0, 0, 0, $project_date_completed_explode[1], $project_date_completed_explode[0], $project_date_completed_explode[2]);
													
													$project_estimated_deadline_format = date("d/m/y", strtotime($project_estimated_deadline));
													$project_estimated_deadline_explode = explode('/', $project_estimated_deadline_format);
													$project_estimated_deadline_mktime = mktime(0, 0, 0, $project_estimated_deadline_explode[1], $project_estimated_deadline_explode[0], $project_estimated_deadline_explode[2]);
													
												?>
												<!--<div id="display_list_<?php //echo $project->ID ?>" class="display_list hide_list_<?php // echo $project->ID ?>">-->
												<div id="display_note_<?php echo $project->ID ?>" class="display_note display_list hide_list_<?php echo $project->ID ?>">
													<div class="info_div">
														<div class="buttons column">
															<div id="edit_archive_<?php echo $project->ID ?>" class="button_2 modal_form_edit_archive">E</div>
															<div id="delete_<?php echo $project->ID ?>" class="button_2 modal_form_delete">D</div>
															<div style="display:none;" id="loader_<?php echo $project->ID ?>" class="loader"></div>
														</div>
														<p id="first_column_<?php echo $project->ID; ?>" class="client_info first_column column"><?php echo ($project_client != null) ? $project_client : "--"; ?></p>
														<p id="second_column_<?php echo $project->ID; ?>" class="second_column column"><?php echo ($project_name != null) ? $project_name : "--"; ?></p>
														<p id="third_column_<?php echo $project->ID; ?>" class="third_column column"><?php echo ($project_start_date != null) ? $project_start_date : "--"; ?></p>
														<p id="fourth_column_<?php echo $project->ID; ?>" class="fourth_column column"><?php echo ($project_days_in_production != null) ? $project_days_in_production : "--"; ?></p>
														<p id="fifth_column_<?php echo $project->ID; ?>" class="fifth_column column <?php echo ($project_date_completed_mktime > $project_estimated_deadline_mktime) ? "red_bg" : ""; ?>"><?php echo ($project_date_completed != null) ? $project_date_completed : "--"; ?></p>
														<p id="sixth_column_<?php echo $project->ID; ?>" class="sixth_column column"><?php echo ($project_estimated_deadline != null) ? $project_estimated_deadline : "--"; ?></p>
														<p id="seventh_column_<?php echo $project->ID; ?>" class="seventh_column column"><?php echo ($project_invoice_date != null) ? $project_invoice_date : "--"; ?></p>
														<p id="eighth_column_<?php echo $project->ID; ?>" class="eighth_column column"><?php echo ($total_hour_decimal != null) ? round_quarter($total_hour_decimal) : "--"; ?></p>
														<p id="ninth_column_<?php echo $project->ID; ?>" class="ninth_column column <?php echo ($revenue > 0) ? "green_bg" : "red_bg"; ?>"><?php echo ($revenue != null) ? $revenue : "--"; ?></p>
														<p id="tenth_column_<?php echo $project->ID; ?>" class="tenth_column column"><?php echo ($project_responsible_worker != null) ? $project_responsible_worker : "--"; ?></p>
														<p id="eleventh_column_<?php echo $project->ID; ?>" class="eleventh_column column"><?php echo ($project_current_status != null) ? $project_current_status : "--"; ?></p>	
													</div>
													<div style="display:none" id="project_notes_<?php echo $project->ID ?>" class="project_notes">
														<p style="float:left"><strong><?php echo $project_client .":&nbsp";?></strong></p>
														<p style="float:left"><?php echo $project_description; ?></p>
													</div>
												</div>
												<?php 
												}
											}
										}
									}
								?>
							</div>
						</div>
					</div>		
					<!-- ------------------------------------ INTERNAL SEO ------------------------------------  --> 					
					<div id="internal_seo" class="tab tab_content" style="display: none;">
						<div class="display_main">
							<div class="section current">
								<h1>Current Ongoing Projects</h1>
								<div class="top_navi">
									<div class="pm_filter current_internal_seo_filter">
										<div style="display: none;" class="loader current_internal_seo_filter_loader"></div>									
										<div class="report_top_label"><h1><?php echo $months[(int)$month] ." ". $year; ?></h1></div>
										<div class="default_arrow_container">
											<div class="button_2"><div class="nav_buttons previous_arrow"></div></div>
											<div class="button_2"><div class="nav_buttons next_arrow"></div></div>
										</div>
										<div style="display:none;" class="arrow_container">
											<div class="button_2"><div class="nav_buttons previous_arrow"></div></div>
											<div class="button_2"><div class="nav_buttons next_arrow"></div></div>
										</div>
										<select class="current_internal_seo_filter_select">
											<option>Month</option>
											<option>Year</option>										
										</select>
										<input type="hidden" class="current_year" value="<?php echo $year; ?>" />
										<input type="hidden" class="current_month" value="<?php echo $month; ?>" />
									</div>
								</div>
								<div class="header_subtitle">
									<h3 class="button_header column"></h3>
									<h3 class="first_column column">Customer</h3>
									<h3 class="second_column column">Project Name</h3>
									<h3 class="third_column column">M-Hours</h3>
									<h3 class="fourth_column column">M-Plan</h3>
									<h3 class="fifth_column column">Y-Hours</h3>
									<h3 class="sixth_column column">M-Payment</h3>
									<h3 class="seventh_column column">Expenses</h3>
									<h3 class="eighth_column column">Revenue</h3>			
								</div>
								<div class="current_internal_seo_container">
								<?php 
									$project_client_temp = "";
									foreach($projects as $project){
										if($project->project_date_completed == null){
											// if($project->project_name == 'Monthly Ongoing SEO' || $project->project_name == 'Monthly Ongoing Dev'){	
												if($project->project_client == 'SEOWeb Solutions'){
													$project_client				= $project->project_client;
													$project_name				= $project->project_name;
													$project_start_date			= $project->project_start_date;		
													$project_estimated_deadline	= $project->project_estimated_deadline;
													$project_hour				= $project->project_hour;
													$project_minute				= $project->project_minute;
													$project_responsible_worker = $project->project_responsible_worker;
													$project_current_status		= $project->project_current_status;
													$project_description		= $project->project_description;
													$project_budget				= $project->project_budget;
													$project_extra_expenses		= $project->project_extra_expenses;
													$project_default_expenses	= $project->project_default_expenses;
													$project_invoiced_amount	= $project->project_invoiced_amount;
													
													$today						= date('m/d/Y');
													if($project_start_date != null){
														$project_days_in_production	= dateDiff($project_start_date,$today);
														}else{
														$project_days_in_production = "--";
													}
													
													$project_hours = $project_hour.":".$project_minute.":00";
													$project_decimal_hours = decimalHours($project_hours);
													$project_rounded_hour = round($project_decimal_hours, 2);
													
													$start_date	= date('1/m/Y');												
													$end_date	= date('31/m/Y');												
													
													// $timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$start_date', '%d/%m/%Y') AND STR_TO_DATE('$end_date', '%d/%m/%Y')");
													$timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$month/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$month/$year', '%d/%m/%Y')");
													
													$timesheet_hour_decimal = "";
													foreach($timesheets as $timesheet){
														if($timesheet->task_label == $project_client && $timesheet->task_project_name == $project_name){
															$task_hour = $timesheet->task_hour;										
															$decimal_hours = decimalHours($task_hour);
															$rounded_hour = round($decimal_hours, 2);		
															$timesheet_hour_decimal += $rounded_hour;
														}
													}
													
													if($project_rounded_hour != null || $project_rounded_hour != 0){
														$total_hour_decimal = $project_rounded_hour;
														}else{
														$total_hour_decimal = $timesheet_hour_decimal;
													}
													
													$project_monthly_plan = $project->project_monthly_plan;
													$monthly_plans = $wpdb->get_row("SELECT * FROM {$table_monthly_plan} WHERE monthly_name='$project_monthly_plan'");							
													$monthly_budget = $monthly_plans->monthly_budget;
													$monthly_seo_extra_expense = $monthly_plans->monthly_seo_extra_expense;
													$monthly_dev_extra_expense = $monthly_plans->monthly_dev_extra_expense;							
													if($project_name == 'Monthly Ongoing SEO'){
														$monthly_plan_hour = $monthly_plans->monthly_seo_hours;
														}elseif($project_name == 'Monthly Ongoing Dev'){
														$monthly_plan_hour = $monthly_plans->monthly_webdev_hours;
													}
													
													
													$current_year = date('Y');
													$year_filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/$current_year', '%d/%m/%Y') AND STR_TO_DATE('31/12/$current_year', '%d/%m/%Y')";
													$year_hours = $wpdb->get_results("SELECT task_hour FROM {$table_name} WHERE $year_filter AND task_project_name = '$project_name' AND task_label = '$project_client'");
													$total_year_hours = "";
													foreach($year_hours as $year_hour){
														$task_hour = $year_hour->task_hour;
														$task_hour_decimal = round(decimalHours($task_hour), 2);
														$total_year_hours += $task_hour_decimal;
													}
													
													$current_expense = $project_default_expenses + $project_extra_expenses + $monthly_seo_extra_expense + $monthly_dev_extra_expense;
													foreach($persons as $person){
														$person_full_name = $person->person_first_name." ".$person->person_last_name;
														if($project_responsible_worker == $person_full_name){
															$person_hourly_rate = $person->person_hourly_rate;
															$multiply = $total_hour_decimal * $person_hourly_rate;					
															$project_expenses = $multiply + $current_expense;
															$revenue = $monthly_budget - $project_expenses;
														}
													}
													if($revenue < 0){
														$revenue_class = 'red_bg';
														}else{
														$revenue_class = 'green_bg';
													}
												?>
												<div id="display_note_<?php echo $project->ID ?>" class="display_note display_list hide_list_<?php echo $project->ID ?>">
													<div class="info_div">
														<div class="buttons column">
															<div id="edit_<?php echo $project->ID ?>" class="button_2 modal_form_edit">E</div>
															<div id="archive_<?php echo $project->ID ?>" class="button_2 modal_form_archive">A</div>
															<div id="delete_<?php echo $project->ID ?>" class="button_2 modal_form_delete">D</div>
															<div style="display:none;" id="loader_<?php echo $project->ID ?>" class="loader"></div>
														</div>
														<p id="first_column_<?php echo $project->ID; ?>" class="client_info first_column column"><?php echo ($project_client != null) ? $project_client : "--"; ?></p>
														<p id="second_column_<?php echo $project->ID; ?>" class="second_column column"><?php echo ($project_name != null) ? $project_name : "--"; ?></p>
														<p id="third_column_<?php echo $project->ID; ?>" class="third_column column"><?php echo ($timesheet_hour_decimal != null) ? round_quarter($timesheet_hour_decimal) : "--"; ?></p>
														<p id="fourth_column_<?php echo $project->ID; ?>" class="fourth_column column"><?php echo ($monthly_plan_hour != null) ? $monthly_plan_hour : "--"; ?></p>
														<p id="fifth_column_<?php echo $project->ID; ?>" class="fifth_column column"><?php echo ($total_year_hours != null) ? round_quarter($total_year_hours) : "--"; ?></p>
														<p id="sixth_column_<?php echo $project->ID; ?>" class="sixth_column column"><?php echo ($monthly_budget != null) ? $monthly_budget : "--"; ?></p>
														<p id="seventh_column_<?php echo $project->ID; ?>" class="seventh_column column"><?php echo ($project_expenses != null) ? $project_expenses : "--"; ?></p>
														<p id="eighth_column_<?php echo $project->ID; ?>" class="eighth_column column <?php echo $revenue_class; ?>"><?php echo ($revenue != null) ? $revenue : "--"; ?></p>
													</div>
													<div style="display:none" id="project_notes_<?php echo $project->ID ?>" class="project_notes">
														<p style="float:left"><strong><?php echo $project_client .":&nbsp";?></strong></p>
														<p style="float:left"><?php echo $project_description; ?></p>
													</div>
												</div>
												<?php 
												}
											// }
										}
									}
								?>
								</div>
							</div>
							<div class="section completed">
								<h1>Completed SEO Projects</h1>
								<div class="header_subtitle">
									<h3 class="button_header column"></h3>
									<h3 class="first_column column">Customer</h3>
									<h3 class="second_column column">Project Name</h3>
									<h3 class="third_column column">Started</h3>
									<h3 class="fourth_column column">DiP</h3>
									<h3 class="fifth_column column">Completed</h3>
									<h3 class="sixth_column column">Deadline</h3>
									<h3 class="seventh_column column">Invoiced</h3>
									<h3 class="eighth_column column">Hours</h3>
									<h3 class="ninth_column column">Revenue</h3>
									<h3 class="tenth_column column">M.Dev</h3>
									<h3 class="eleventh_column column">Status</h3>	
								</div>
								<?php 
									$project_client_temp = "";
									foreach($projects as $project){
										if($project->project_date_completed != null){
											if($project->project_name == 'Monthly Ongoing SEO' || $project->project_name == 'Monthly Ongoing Dev'){
												if( $project->project_client == 'SEOWeb Solutions'){
													$project_client				= $project->project_client;
													$project_name				= $project->project_name;
													$project_start_date			= $project->project_start_date;		
													$project_estimated_deadline	= $project->project_estimated_deadline;
													$project_hour				= $project->project_hour;
													$project_minute				= $project->project_minute;
													$project_date_completed		= $project->project_date_completed;
													$project_responsible_worker = $project->project_responsible_worker;
													$project_current_status		= $project->project_current_status;
													$project_description		= $project->project_description;
													$project_budget				= $project->project_budget;
													$project_extra_expenses		= $project->project_extra_expenses;
													$project_invoice_date		= $project->project_invoice_date;
													
													$today						= date('m/d/Y');
													if($project_start_date != null && $project_date_completed != null){
														$project_days_in_production	= dateDiff($project_start_date,$project_date_completed);			
														}else{
														$project_days_in_production = "--";
													}
													$project_hours = $project_hour.":".$project_minute.":00";
													$project_decimal_hours = decimalHours($project_hours);
													$project_rounded_hour = round($project_decimal_hours, 2);		
													
													$timesheet_hour_decimal = "";
													$task_project_status = "completed_".$project_start_date ."_". $project_date_completed;
													$completed_timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND task_project_status='$task_project_status'");
													
													foreach($completed_timesheets as $completed_timesheet){														
														$task_hour = $completed_timesheet->task_hour;
														$decimal_hours = decimalHours($task_hour);
														$rounded_hour = round($decimal_hours, 2);
														$timesheet_hour_decimal += $rounded_hour;
													}
													
													if($project_rounded_hour != null || $project_rounded_hour != 0){
														$total_hour_decimal = $project_rounded_hour;
														}else{
														$total_hour_decimal = $timesheet_hour_decimal;
													}
													$current_expense = $project_default_expenses + $project_extra_expenses;
													
													foreach($persons as $person){
														$person_full_name = $person->person_first_name ." ". $person->person_last_name;
														if($project_responsible_worker == $person_full_name){
															$person_hourly_rate = $person->person_hourly_rate;
															$multiply = $total_hour_decimal * $person_hourly_rate;
															$add = $multiply + $current_expense;
															$revenue = $project_budget - $add;										
														}
													}
													
													
												?>
												<div id="display_note_<?php echo $project->ID ?>" class="display_note display_list hide_list_<?php echo $project->ID ?>">
													<div class="info_div">
														<div class="buttons column">
															<div id="delete_<?php echo $project->ID ?>" class="button_2 modal_form_delete">D</div>
														</div>
														<p id="first_column_<?php echo $project->ID; ?>" class="client_info first_column column"><?php echo ($project_client != null) ? $project_client : "--"; ?></p>
														<p id="second_column_<?php echo $project->ID; ?>" class="second_column column"><?php echo ($project_name != null) ? $project_name : "--"; ?></p>
														<p id="third_column_<?php echo $project->ID; ?>" class="third_column column"><?php echo ($project_start_date != null) ? $project_start_date : "--"; ?></p>
														<p id="fourth_column_<?php echo $project->ID; ?>" class="fourth_column column"><?php echo ($project_days_in_production != null) ? $project_days_in_production : "--"; ?></p>
														<p id="fifth_column_<?php echo $project->ID; ?>" class="fifth_column column"><?php echo ($project_date_completed != null) ? $project_date_completed : "--"; ?></p>
														<p id="sixth_column_<?php echo $project->ID; ?>" class="sixth_column column"><?php echo ($project_estimated_deadline != null) ? $project_estimated_deadline : "--"; ?></p>
														<p id="seventh_column_<?php echo $project->ID; ?>" class="seventh_column column"><?php echo ($project_invoice_date != null) ? $project_invoice_date : "--"; ?></p>
														<p id="eighth_column_<?php echo $project->ID; ?>" class="eighth_column column"><?php echo ($total_hour_decimal != null) ? round_quarter($total_hour_decimal) : "--"; ?></p>
														<p id="ninth_column_<?php echo $project->ID; ?>" class="ninth_column column"><?php echo ($revenue != null) ? $revenue : "--"; ?></p>
														<p id="tenth_column_<?php echo $project->ID; ?>" class="tenth_column column"><?php echo ($project_responsible_worker != null) ? $project_responsible_worker : "--"; ?></p>
														<p id="eleventh_column_<?php echo $project->ID; ?>" class="eleventh_column column"><?php echo ($project_current_status != null) ? $project_current_status : "--"; ?></p>	
													</div>
													<div style="display:none" id="project_notes_<?php echo $project->ID ?>" class="project_notes">
														<p style="float:left"><strong><?php echo $project_client .":&nbsp";?></strong></p>
														<p style="float:left"><?php echo $project_description; ?></p>
													</div>
												</div>
												<?php 
												}
											}	
										}
									}
								?>
							</div>
						</div>
					</div>
					<!-- ------------------------------------ CUSTOMER ISSUES/BUGS ------------------------------------  --> 
					<div id="customer_issues_bugs" class="tab tab_content" style="display: none;">
						<div class="display_main">
							<div class="section current">
								<h1>Current Ongoing Projects</h1>
								<div class="top_navi">
								<div class="pm_filter current_issue_bug_filter">
									<div style="display: none;" class="loader current_issue_bug_filter_loader"></div>									
									<div class="report_top_label"><h1><?php echo $months[(int)$month] ." ". $year; ?></h1></div>
									<div class="default_arrow_container">
										<div class="button_2"><div class="nav_buttons previous_arrow"></div></div>
										<div class="button_2"><div class="nav_buttons next_arrow"></div></div>
									</div>
									<div style="display:none;" class="arrow_container">
										<div class="button_2"><div class="nav_buttons previous_arrow"></div></div>
										<div class="button_2"><div class="nav_buttons next_arrow"></div></div>
									</div>
									<select class="current_issue_bug_filter_select">
										<option>Month</option>
										<option>Year</option>										
									</select>
									<input type="hidden" class="current_year" value="<?php echo $year; ?>" />
									<input type="hidden" class="current_month" value="<?php echo $month; ?>" />
								</div>
							</div>
								<div class="header_subtitle">
									<h3 class="button_header column"></h3>
									<h3 class="first_column column">Customer</h3>
									<h3 class="second_column column">Project Name</h3>
									<h3 class="third_column column">Started</h3>
									<h3 class="fourth_column column">DiP</h3>
									<h3 class="fifth_column column">Deadline</h3>
									<h3 class="sixth_column column">Hours</h3>
									<h3 class="seventh_column column">Revenue</h3>
									<h3 class="eighth_column column">Expenses</h3>
									<h3 class="ninth_column column">Main Dev.</h3>
									<h3 class="tenth_column column">Status</h3>				
								</div>
								<div class="current_issue_bug_container">
								<?php 
									$project_issue_bug_ongoing = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY STR_TO_DATE(project_start_date, '%m/%d/%Y')  DESC");
									$project_client_temp = "";
									foreach($project_issue_bug_ongoing as $project){
										if($project->project_date_completed == null){
											if($project->project_name != 'Monthly Ongoing SEO' && $project->project_name != 'Monthly Ongoing Dev'){												
												if($project->project_name == 'Issue/Bug'){
													$project_client				= $project->project_client;
													$project_name				= $project->project_name;
													$project_start_date			= $project->project_start_date;		
													$project_estimated_deadline	= $project->project_estimated_deadline;
													$project_hour				= $project->project_hour;
													$project_minute				= $project->project_minute;
													$project_responsible_worker = $project->project_responsible_worker;
													$project_current_status		= $project->project_current_status;
													$project_description		= $project->project_description;
													$project_budget				= $project->project_budget;
													$project_extra_expenses		= $project->project_extra_expenses;
													$project_default_expenses	= $project->project_default_expenses;
													$project_invoiced_amount	= $project->project_invoiced_amount;
													
													$today						= date('m/d/Y');
													if($project_start_date != null){
														$project_days_in_production	= dateDiff($project_start_date,$today);
														}else{
														$project_days_in_production = "--";
													}
													
													$project_hours = $project_hour.":".$project_minute.":00";
													$project_decimal_hours = decimalHours($project_hours);
													$project_rounded_hour = round($project_decimal_hours, 2);
													
													$start_date = date("d/m/Y", strtotime($project_start_date));
													$today_date	= date('d/m/Y');												
													$timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$start_date', '%d/%m/%Y') AND STR_TO_DATE('$today_date', '%d/%m/%Y')");
													
													$timesheet_hour_decimal = "";											
													foreach($timesheets as $timesheet){
														if($timesheet->task_label == $project_client){
															$task_hour = $timesheet->task_hour;										
															$decimal_hours = decimalHours($task_hour);
															$rounded_hour = round($decimal_hours, 2);		
															$timesheet_hour_decimal += $rounded_hour;
														}				
													}
													
													if($project_rounded_hour != null || $project_rounded_hour != 0){
														$total_hour_decimal = $project_rounded_hour;
														}else{
														$total_hour_decimal = $timesheet_hour_decimal;
													}
													$current_expense = $project_default_expenses + $project_extra_expenses;
													
													foreach($persons as $person){
														$person_full_name = $person->person_first_name ." ". $person->person_last_name;
														if($project_responsible_worker == $person_full_name){
															$person_hourly_rate = $person->person_hourly_rate;
															$multiply = $total_hour_decimal * $person_hourly_rate;					
															$add = $multiply + $current_expense;
															$revenue = $project_budget - $add;
														}
													}
													
												?>
												<div id="display_note_<?php echo $project->ID ?>" class="display_note display_list hide_list_<?php echo $project->ID ?>">
													<div class="info_div">
														<div class="buttons column">
															<div id="edit_<?php echo $project->ID ?>" class="button_2 modal_form_edit">E</div>
															<div id="archive_<?php echo $project->ID ?>" class="button_2 modal_form_archive">A</div>
															<div id="delete_<?php echo $project->ID ?>" class="button_2 modal_form_delete">D</div>
															<div style="display:none;" id="loader_<?php echo $project->ID ?>" class="loader"></div>
														</div>
														<p id="first_column_<?php echo $project->ID; ?>" class="client_info first_column column"><?php echo ($project_client != null) ? $project_client : "--"; ?></p>
														<p id="second_column_<?php echo $project->ID; ?>" class="second_column column"><?php echo ($project_name != null) ? $project_name : "--"; ?></p>
														<p id="third_column_<?php echo $project->ID; ?>" class="third_column column"><?php echo ($project_start_date != null) ? $project_start_date : "--"; ?></p>
														<p id="fourth_column_<?php echo $project->ID; ?>" class="fourth_column column"><?php echo $project_days_in_production; ?></p>
														<p id="fifth_column_<?php echo $project->ID; ?>" class="fifth_column column <?php echo ($today > $project_estimated_deadline) ? "red_bg" : ""; ?>"><?php echo ($project_estimated_deadline != null) ? $project_estimated_deadline : "--"; ?></p>
														<p id="sixth_column_<?php echo $project->ID; ?>" class="sixth_column column"><?php echo ($total_hour_decimal != null) ? round_quarter($total_hour_decimal) : "--"; ?></p>
														<p id="seventh_column_<?php echo $project->ID; ?>" class="seventh_column column <?php echo ($revenue > 0) ? "green_bg" : "red_bg"; ?>"><?php echo ($revenue != null) ? $revenue : "--"; ?></p>
														<p id="eighth_column_<?php echo $project->ID; ?>" class="eighth_column column"><?php echo ($current_expense != null) ? $current_expense : "--"; ?></p>					 
														<p id="ninth_column_<?php echo $project->ID; ?>" class="ninth_column column"><?php echo ($project_responsible_worker != null) ? $project_responsible_worker : "--"; ?></p>
														<p id="tenth_column_<?php echo $project->ID; ?>" class="tenth_column_ column"><?php echo ($project_current_status != null) ? $project_current_status : "--"; ?></p>	
													</div>
													<div style="display:none" id="project_notes_<?php echo $project->ID ?>" class="project_notes">
														<p style="float:left"><strong><?php echo $project_client .":&nbsp";?></strong></p>
														<p style="float:left"><?php echo $project_description; ?></p>
													</div>
												</div>
												<?php 
												}
											}
										}
									}
								?>
								</div>
							</div>
							<div class="section completed">
								<h1>Completed Webdev Projects</h1>
								<div class="header_subtitle">
									<h3 class="button_header column">
										<h3 class="first_column column">Customer</h3>
										<h3 class="second_column column">Project Name</h3>
										<h3 class="third_column column">Started</h3>
										<h3 class="fourth_column column">DiP</h3>
										<h3 class="fifth_column column">Completed</h3>
										<h3 class="sixth_column column">Deadline</h3>
										<h3 class="seventh_column column">Invoiced</h3>
										<h3 class="eighth_column column">Hours</h3>
										<h3 class="ninth_column column">Revenue</h3>
										<h3 class="tenth_column column">Main Dev.</h3>
										<h3 class="eleventh_column column">Status</h3>	
									</div>
									<?php 
										$project_client_temp = "";
										$project_completed = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY STR_TO_DATE(project_start_date, '%m/%d/%Y')  DESC");									
										foreach($project_completed as $project){
											if($project->project_date_completed != null){
												if($project->project_name != 'Monthly Ongoing SEO' && $project->project_name != 'Monthly Ongoing Dev'){	
													if($project->project_client == 'Issue/Bug'){
														$project_client				= $project->project_client;
														$project_name				= $project->project_name;
														$project_start_date			= $project->project_start_date;		
														$project_estimated_deadline	= $project->project_estimated_deadline;
														$project_hour				= $project->project_hour;
														$project_minute				= $project->project_minute;
														$project_date_completed		= $project->project_date_completed;
														$project_responsible_worker = $project->project_responsible_worker;
														$project_current_status		= $project->project_current_status;
														$project_description		= $project->project_description;
														$project_budget				= $project->project_budget;
														$project_extra_expenses		= $project->project_extra_expenses;
														$project_invoice_date		= $project->project_invoice_date;
														$project_invoiced_amount	= $project->project_invoiced_amount;
														
														$today						= date('m/d/Y');
														if($project_start_date != null && $project_date_completed != null){
															$project_days_in_production	= dateDiff($project_start_date,$project_date_completed);			
															}else{
															$project_days_in_production = "--";
														}
														$project_hours = $project_hour.":".$project_minute.":00";
														$project_decimal_hours = decimalHours($project_hours);
														$project_rounded_hour = round($project_decimal_hours, 2);
														
														$task_project_status = "completed_".$project_start_date ."_". $project_date_completed;
														$completed_timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND task_project_status='$task_project_status'");
														
														$timesheet_hour_decimal = "";			
														foreach($completed_timesheets as $completed_timesheet){													
															$task_hour = $completed_timesheet->task_hour;					
															$decimal_hours = decimalHours($task_hour);
															$rounded_hour = round($decimal_hours, 2);		
															$timesheet_hour_decimal += $rounded_hour;			
														}
														
														if($project_rounded_hour != null || $project_rounded_hour != 0){
															$total_hour_decimal = $project_rounded_hour;
															}else{
															$total_hour_decimal = $timesheet_hour_decimal;
														}
														$current_expense = $project_default_expenses + $project_extra_expenses;
														
														foreach($persons as $person){
															$person_full_name = $person->person_first_name ." ". $person->person_last_name;
															if($project_responsible_worker == $person_full_name){														
																$person_hourly_rate = $person->person_hourly_rate;														
																$multiply = $total_hour_decimal * $person_hourly_rate;
																$add = $multiply + $current_expense;
																$revenue = $project_invoiced_amount - $add;													
															}
														}
														
														$project_date_completed_format = date("d/m/y", strtotime($project_date_completed));
														$project_date_completed_explode = explode('/', $project_date_completed_format);
														$project_date_completed_mktime = mktime(0, 0, 0, $project_date_completed_explode[1], $project_date_completed_explode[0], $project_date_completed_explode[2]);
														
														$project_estimated_deadline_format = date("d/m/y", strtotime($project_estimated_deadline));
														$project_estimated_deadline_explode = explode('/', $project_estimated_deadline_format);
														$project_estimated_deadline_mktime = mktime(0, 0, 0, $project_estimated_deadline_explode[1], $project_estimated_deadline_explode[0], $project_estimated_deadline_explode[2]);
														
													?>
													<!--<div id="display_list_<?php //echo $project->ID ?>" class="display_list hide_list_<?php // echo $project->ID ?>">-->
													<div id="display_note_<?php echo $project->ID ?>" class="display_note display_list hide_list_<?php echo $project->ID ?>">
														<div class="info_div">
															<div class="buttons column">
																<div id="edit_archive_<?php echo $project->ID ?>" class="button_2 modal_form_edit_archive">E</div>
																<div id="delete_<?php echo $project->ID ?>" class="button_2 modal_form_delete">D</div>
																<div style="display:none;" id="loader_<?php echo $project->ID ?>" class="loader"></div>
															</div>
															<p id="first_column_<?php echo $project->ID; ?>" class="client_info first_column column"><?php echo ($project_client != null) ? $project_client : "--"; ?></p>
															<p id="second_column_<?php echo $project->ID; ?>" class="second_column column"><?php echo ($project_name != null) ? $project_name : "--"; ?></p>
															<p id="third_column_<?php echo $project->ID; ?>" class="third_column column"><?php echo ($project_start_date != null) ? $project_start_date : "--"; ?></p>
															<p id="fourth_column_<?php echo $project->ID; ?>" class="fourth_column column"><?php echo ($project_days_in_production != null) ? $project_days_in_production : "--"; ?></p>
															<p id="fifth_column_<?php echo $project->ID; ?>" class="fifth_column column <?php echo ($project_date_completed_mktime > $project_estimated_deadline_mktime) ? "red_bg" : ""; ?>"><?php echo ($project_date_completed != null) ? $project_date_completed : "--"; ?></p>
															<p id="sixth_column_<?php echo $project->ID; ?>" class="sixth_column column"><?php echo ($project_estimated_deadline != null) ? $project_estimated_deadline : "--"; ?></p>
															<p id="seventh_column_<?php echo $project->ID; ?>" class="seventh_column column"><?php echo ($project_invoice_date != null) ? $project_invoice_date : "--"; ?></p>
															<p id="eighth_column_<?php echo $project->ID; ?>" class="eighth_column column"><?php echo ($total_hour_decimal != null) ? round_quarter($total_hour_decimal) : "--"; ?></p>
															<p id="ninth_column_<?php echo $project->ID; ?>" class="ninth_column column <?php echo ($revenue > 0) ? "green_bg" : "red_bg"; ?>"><?php echo ($revenue != null) ? $revenue : "--"; ?></p>
															<p id="tenth_column_<?php echo $project->ID; ?>" class="tenth_column column"><?php echo ($project_responsible_worker != null) ? $project_responsible_worker : "--"; ?></p>
															<p id="eleventh_column_<?php echo $project->ID; ?>" class="eleventh_column column"><?php echo ($project_current_status != null) ? $project_current_status : "--"; ?></p>	
														</div>
														<div style="display:none" id="project_notes_<?php echo $project->ID ?>" class="project_notes">
															<p style="float:left"><strong><?php echo $project_client .":&nbsp";?></strong></p>
															<p style="float:left"><?php echo $project_description; ?></p>
														</div>
													</div>
													<?php 
													}
												}
											}
										}
									?>
								</div>
							</div>
						</div>					
					</div>
				</div>				
			</div>			
		</div>
	</div>
</div>

<div style="display:none;" class="dialog_form_project_management" id="dialog_form_edit_project_management" title="Edit Project"></div>
<div style="display:none;" class="dialog_form_project_management" id="dialog_form_archive_project_management" title="Archive Project"></div>
<div style="display:none;" class="dialog_form_project_management" id="dialog_form_edit_archive_project_management" title="Edit Archived Project"></div>
<div style="display:none;" class="dialog_form_project_management" id="dialog_form_delete_project_management" title="Delete Project"></div>
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