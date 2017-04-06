<?php /* Template name: Reports Time */ ?>
<?php get_header(); ?>
<?php
$table_name = $wpdb->prefix . "custom_timesheet";
$import_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE date_now >= $start and (date_now <= $end)");
?>
<script>
jQuery(document).ready(function(){	
	
	jQuery('#get_week_number').click(function(){
		jQuery('.search-loading').show();
		var weekNumber = jQuery( "#week_number" ).val();
		var formData = {week_number:weekNumber};	
		jQuery.ajax({
			url: 'http://research.seowebsolutions.com/reports/time/report-table/',
			type: "POST",
			data : formData,
			success: function (data, textStatus) {
				jQuery("#result_table").html(data);
				jQuery('.search-loading').hide();
			},
			error: function(){
				alert('failure');
			}
		});
	});	
	jQuery('.tabs-wrapper').each(function() {
		jQuery(this).find(".tab_content").hide(); //Hide all content
		if(document.location.hash && jQuery(this).find("ul.tabs li a[href='"+document.location.hash+"']").length >= 1) {
			jQuery(this).find("ul.tabs li a[href='"+document.location.hash+"']").parent().addClass("active").show(); //Activate first tab
			jQuery(this).find(document.location.hash+".tab_content").show(); //Show first tab content
			//jQuery(this).find(".tab_content.active").show(); //Show first tab content
		} else {
			jQuery(this).find("ul.tabs li:first").addClass("active").show(); //Activate first tab
			jQuery(this).find(".tab_content:first").addClass("active").show(); //Show first tab content
			//jQuery(this).find(".tab_content.active").show(); //Show first tab content
		}
	});
	
	//On Click Event
	jQuery("ul.tabs li").click(function(e) {
		jQuery(this).parents('.tabs-wrapper').find("ul.tabs li").removeClass("active"); //Remove any "active" class
		jQuery(this).addClass("active"); //Add "active" class to selected tab
		jQuery(this).parents('.tabs-wrapper').find(".tab_content").hide(); //Hide all tab content
		
		var activeTab = jQuery(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		jQuery(this).parents('.tabs-wrapper').find(activeTab).fadeIn(); //Fade in the active ID content
		jQuery('.tab_content').each(function() {
			var div_ids = jQuery(this).attr('id');			
			var active_div_id = activeTab.substring(1);
			if(div_ids != active_div_id){
				jQuery('div#'+div_ids).removeClass('active');
			}
		});
		jQuery('div'+activeTab).addClass('active');
	});
});
	jQuery("#week_number_calendar").ready(function(){
		jQuery("#get_week_number").show();
		jQuery("#report_table").show();  
	});
</script>
<div class="report_container">
	<div id="result_table">
		<div id="report_table" style="display:none;">
			<?php				
				$week_number = date('W');
				$month_number = date('m');				
				$month_name = date('F');
				$year = date('Y');
				
				$filter_month = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$month_number/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$month_number/$year', '%d/%m/%Y')";
				
				$table_name = $wpdb->prefix . "custom_timesheet";
				$table_name_client = $wpdb->prefix . "custom_client";
				$table_name_person = $wpdb->prefix . "custom_person";
				$table_name_project = $wpdb->prefix . "custom_project";
				$table_name_task = $wpdb->prefix . "custom_task";
				$table_name_color = $wpdb->prefix . "custom_project_color";
				
				$import_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month");
				$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");
				$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
				$projects = $wpdb->get_results("SELECT * FROM {$table_name_project}");
				$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
				$colors = $wpdb->get_results("SELECT * FROM {$table_name_color}");
				
				$year = date('Y');
				$week = getStartAndEndDate($week_number, $year);
				$start_num = $week[0];
				$end_num = $week[1];
				$start = date("d M Y", strtotime($start_num));
				$end = date("d M Y", strtotime($end_num));			
				
			?>
			<div class="top_navi">
				<div class="left">
					<div class="timeframe_navigation">
						<form id="filter_details">
							<input type="hidden" class="current_week" value="<?php echo $week_number; ?>" />
							<input type="hidden" class="current_month" value="<?php echo $month_number; ?>" />
							<input type="hidden" class="current_year" value="<?php echo $year; ?>" />
							<input type="hidden" class="filter_current_month" value="<?php echo $month_number; ?>" />
							<input type="hidden" class="filter_current_week" value="null" />							
							<input type="hidden" class="filter_current_year" value="<?php echo $year; ?>" />							
						</form>
						<div class="month_default">
							<div class="button_2"><div class="month_previous"></div></div>
							<div class="button_2"><div class="month_next"></div></div>
						</div>
						<div style="display: none" class="onchange">
							<div class="button_2"><div class="nav_previous"></div></div>
							<div class="button_2"><div class="nav_next"></div></div>
						</div>
						<div style="display: none;" class="top_detail_loader loader"></div>
					</div>
					<div class="report_top_label"><h1><?php echo "Month: " . $month_name ." ". $year; ?></h1></div>
				</div>
				<div class="right">					
					<select id="custom_filter">
						<option>Month</option>
						<option>Week</option>
						<option>Year</option>
						<option>Quarter</option>
						<option>Custom</option>
					</select>
					<div style="display:none;" class="custom_date_filter">
						<p class="label">From:</p>
						<input type="text" class="from_date" />
						<p class="label">To:</p>
						<input type="text" class="to_date" />
						<div class="button_2"><div class="custom_date_filter_go"></div></div>
					</div>
				</div>
			</div>	
			<div class="border_separator"></div>
			<div class="top_reports">
				<?php
					$top_results = filter_report_time_top_query($filter_month);

					$top_total_hours = (float)$top_results->total_hours;
					$top_total_billable_amount = $top_results->billable_amount;
					$top_total_no_work_hours = (float)$top_results->total_no_work_hours;
					$top_total_unbillable_amount = (float)$top_results->unbillable_hours;
					$top_dwork_total_hour_decimal = $top_results->total_hours - $top_results->total_no_work_hours;

					if($top_dwork_total_hour_decimal != 0){
						$top_total_dwork_percent = floor(($top_results->billable_hours / $top_dwork_total_hour_decimal ) * 100);
					}else{
						$top_total_dwork_percent = 0;
					}

				?>
				<div class="one_fourth"><p class="top_reports_label">Total Tracked</p><h1 class="top_hours_tracked"><?php echo $top_total_hours; ?></h1></div>
				<!--  <div class="one_fourth"><p class="top_reports_label">Dwork</p><h1 class="top_hours_tracked"><?php echo round_quarter($total_hour_decimal); ?></h1></div>
				<div class="one_fourth"><p class="top_reports_label">Billable Hours</p><h1 class="top_billable_hours"><?php echo round_quarter($billable_total_hour_decimal); ?></h1></div> -->
				<div class="one_fourth"><p class="top_reports_label">Billable A</p><h1 class="top_billable_amount"><?php echo (int)$top_total_billable_amount; ?>kr</h1></div>
				<div class="one_fourth"><p class="top_reports_label">D%</p><h1 class="top_dwork_hours_percent"><?php echo $top_total_dwork_percent; ?>%</h1></div>
				<div class="one_fourth"><p class="top_reports_label">No Work</p><h1 class="top_ledig_hours"><?php echo $top_total_no_work_hours;  ?></h1></div>
				<div class="one_fourth last"><p class="top_reports_label">Unbillable Hours</p><h1 class="top_unbillable_hours"><?php echo $top_total_unbillable_amount ?></h1></div>
			</div>
			<div class="table_container">
			<?php /* print_r($billable_timesheet_data->task_hour); */?>
				<div class="tab-holder">
					<div class="tab-hold tabs-wrapper">
						<div class="full_width">				
							<ul id="tabs" class="tabset tabs">
								<li class="tabs_li"><a href="#staff">Staff<div style="display:none" class="staff_detail_loader tab_loader loader"></div></a></li>
								<li class="tabs_li"><a href="#clients">Clients<div style="display:none" class="client_detail_loader tab_loader loader"></div></a></li>					
								<li class="tabs_li"><a href="#projects">Projects<div style="display:none" class="project_detail_loader tab_loader loader"></div></a></li>					
								<li class="tabs_li"><a href="#tasks">Tasks<div style="display:none" class="task_detail_loader tab_loader loader"></div></a></li>					
							</ul>
						</div>
						<div class="tab-box tabs-container">
							<!-- STAFF -->
							<div id="staff" class="tab tab_content" style="display: block;">
								<div class="header_titles">
									<div class="first_column">
										<h3>Name</h3>
										<div style="display:none" class="asc_button report_name_sort_asc"></div>
										<div class="desc_button report_name_sort_desc"></div>
										<div style="display:none" class="report_name_sort_loader loader"></div>
									</div>
									<div class="second_column">
										<h3>Hours</h3>
										<div class="asc_button report_hour_sort_asc"></div>
										<div style="display:none" class="desc_button report_hour_sort_desc"></div>
										<div style="display:none" class="report_hour_sort_loader loader"></div>
									</div>
									<div class="third_column"><h3>Dwork</h3></div>
									<div class="fifth_column"><h3>Billable</h3></div>
									<div class="fourth_column"><h3>Unbillable</h3></div>
									<!-- <div class="sixth_column"><h3>Unbillable A</h3></div> -->
									<div class="sixth_column"><h3>Billable A</h3></div>
									<div class="seventh_column"><h3>D%</h3></div>
									<div class="eight_column"><h3>Ledig</h3></div>
									<div class="ninth_column"><h3>Holiday</h3></div>
									<div class="tenth_column"><h3>Sick</h3></div>
									<div class="eleventh_column"><h3>Vacation</h3></div>
								</div>
								<div class="project_hour_sort_container sort_name_container">
								<?php
									$person_name = filter_report_time_staff_query($filter_month);
									foreach($person_name as $person){
										$person_total_hours = $person->total_hours;
										$dwork_total_hour_decimal_hour = $person->total_dwork_hours;
										$billable_total_hour_decimal = $person->billable_hours;
										$unbillable_total_hour_decimal = $person->unbillable_hours;
										$ledig_total_hour_decimal = $person->ledig_hours;
										$holiday_total_hour_decimal = $person->holiday_hours;
										$vacation_total_hour_decimal = $person->vacation_hours;
										$sickness_total_hour_decimal = $person->sick_hours;


										if($billable_total_hour_decimal != 0){
											$dwork_percent = ($billable_total_hour_decimal / ($person->total_hours - $person->total_no_work_hours)) * 100;
										}else{
											$dwork_percent = 0;
										}

								?>
										<div id="info_div_<?php echo $staff_tab_counter; ?>" class='info_div'>
											<div class="first_column"><li><?php echo $person->person_fullname; ?></li></div>
											<div class="second_column"><li><?php echo CleanDecimal($person_total_hours); ?></li></div>
											<div class="third_column"><li><?php echo CleanDecimal($dwork_total_hour_decimal_hour); ?></li></div>
											<div class="fourth_column"><li><?php echo CleanDecimal($billable_total_hour_decimal); ?></li></div>
											<div class="fifth_column"><li><?php echo CleanDecimal($unbillable_total_hour_decimal); ?></li></div>
											<div class="sixth_column"><li><?php echo CleanDecimal($person->billable_amount); ?></li></div>
											<div class="seventh_column"><li><?php echo  floor($dwork_percent); ?>%</li></div> 
											<div class="eight_column"><li><?php  echo CleanDecimal($ledig_total_hour_decimal); ?></li></div>
											<div class="ninth_column"><li><?php echo CleanDecimal($holiday_total_hour_decimal); ?></li></div>
											<div class="tenth_column"><li><?php echo CleanDecimal($vacation_total_hour_decimal); ?></li></div>
											<div class="eleventh_column"><li><?php echo CleanDecimal($sickness_total_hour_decimal); ?></li></div>
										</div>
								<?php
										$staff_tab_counter++;

										$person_tab_total_hour += $person->total_hours;
										$person_tab_total_dwork_hour += $person->total_dwork_hours;
										$person_tab_total_billable_hour += $person->billable_hours;
										$person_tab_total_unbillable_hour += $person->unbillable_hours;
										$person_tab_total_billable_amount += $person->billable_amount;
										$person_tab_total_ledig_hour += $person->ledig_hours;
										$person_tab_total_holiday_hour += $person->holiday_hours;
										$person_tab_total_vacation_hour += $person->vacation_hours;
										$person_tab_total_sickness_hour += $person->sick_hours;
										$person_all_total_no_work_hours += $person->total_no_work_hours;
									}							
								?>
		
								<?php 
									$all_total_working_hours = $person_tab_total_hour - $person_all_total_no_work_hours;

									if($all_total_working_hours != 0){
										$total_dwork_percent = floor(($person_tab_total_billable_hour / $all_total_working_hours) * 100);
									}else{
										$total_dwork_percent = 0;
									}

								?>
								</div>
								<div class="info_div_total">
									<div class="first_column"><li><p class="report_total">Total</p></li></div>
									<div class="second_column"><li><p class="report_total"><?php echo CleanDecimal($person_tab_total_hour); ?></p></li></div>
									<div class="third_column"><li><p class="report_total"><?php echo CleanDecimal($person_tab_total_dwork_hour); ?></p></li></div>
									<div class="fourth_column"><li><p class="report_total"><?php echo CleanDecimal($person_tab_total_billable_hour); ?></p></li></div>
									<div class="fifth_column"><li><p class="report_total"><?php echo CleanDecimal($person_tab_total_unbillable_hour); ?></p></li></div>
									<div class="sixth_column"><li><p class="report_total"><?php echo CleanDecimal($person_tab_total_billable_amount); ?></p></li></div>
									<div class="seventh_column"><li><p class="report_total"><?php echo $total_dwork_percent; ?>%</p></li></div>
									<div class="eight_column"><li><p class="report_total"><?php echo CleanDecimal($person_tab_total_ledig_hour); ?></p></li></div>
									<div class="ninth_column"><li><p class="report_total"><?php echo CleanDecimal($person_tab_total_holiday_hour); ?></p></li></div>
									<div class="tenth_column"><li><p class="report_total"><?php echo CleanDecimal($person_tab_total_vacation_hour); ?></p></li></div>
									<div class="eleventh_column"><li><p class="report_total"><?php echo CleanDecimal($person_tab_total_sickness_hour);  ?></p></li></div>
								</div>
							</div>
							<!-- CLIENTS -->
							<div id="clients" class="tab tab_content" style="display: none;">
								<div class="header_titles">
									<div class="first_column">
										<h3>Client</h3>
										<div class="asc_button report_name_sort_asc"></div>
										<div style="display:none" class="desc_button report_name_sort_desc"></div>
										<div style="display:none" class="report_name_sort_loader loader"></div>
									</div>
									<div class="second_column">
										<h3>Hours</h3>
										<div class="asc_button report_hour_sort_asc"></div>
										<div style="display:none" class="desc_button report_hour_sort_desc"></div>
										<div style="display:none" class="report_hour_sort_loader loader"></div>
									</div>
									<div class="third_column">
										<h3>Billable</h3>
										<div class="asc_button report_billable_sort_asc"></div>
										<div style="display:none" class="desc_button report_billable_sort_desc"></div>
										<div style="display:none" class="report_billable_sort_loader loader"></div>
									</div>
									<div class="fourth_column">
										<h3>Unbillable</h3>
										<div class="asc_button report_unbillable_sort_asc"></div>
										<div style="display:none" class="desc_button report_unbillable_sort_desc"></div>
										<div style="display:none" class="report_unbillable_sort_loader loader"></div>
									</div>
									<div class="fifth_column">
										<h3>Billable A</h3>
										<div class="asc_button report_billable_a_sort_asc"></div>
										<div style="display:none" class="desc_button report_billable_a_sort_desc"></div>
										<div style="display:none" class="report_billable_a_sort_loader loader"></div>
									</div>
									<div class="sixth_column">
										<h3>Unbillable A</h3>
										<div class="asc_button report_unbillable_a_sort_asc"></div>
										<div style="display:none" class="desc_button report_unbillable_a_sort_desc"></div>
										<div style="display:none" class="report_unbillable_a_sort_loader loader"></div>
									</div>
								</div>
							<div class="project_hour_sort_container sort_name_container">
								<?php
									$client_tab_counter = 1;
									$client_names = filter_report_time_client_query($filter_month);

									foreach($client_names as $client){ 
										$total_client_hours =  $client->total_hours;
										$billable_total_hour_decimal = $client->billable_hours;
										$total_billable_amount = $client->billable_amount;
										$unbillable_total_hour_decimal = $client->unbillable_hours;
										$total_unbillable_amount = $client->unbillable_amount;

										$client_tab_total_hour += $client->total_hours;
										$client_tab_total_billable_hour += $client->billable_hours;
										$client_tab_total_unbillable_hour += $client->unbillable_hours;
										$client_tab_total_billable_amount += $client->billable_amount;
										$client_tab_total_unbillable_amount += $client->unbillable_amount;
										
									?>
									<div id="info_div_<?php echo $client_tab_counter; ?>" class='info_div'>
										<div class="first_column"><li><?php echo $client->task_label; ?></li></div>
										<div class="second_column"><li><?php echo CleanDecimal($total_client_hours); ?></li></div>
										<div class="third_column"><li><?php echo CleanDecimal($billable_total_hour_decimal); ?></li></div>
										<div class="fourth_column"><li><?php echo CleanDecimal($unbillable_total_hour_decimal); ?></li></div>
										<div class="fifth_column"><li><?php echo CleanDecimal($total_billable_amount); ?></li></div>
										<div class="sixth_column"><li><?php echo CleanDecimal($total_unbillable_amount); ?></li></div>
									</div>								
								<?php 
									$client_tab_counter++;
								} 
								?>
								</div>
								<div class="info_div_total">
									<div class="first_column"><li><p class="report_total">Total</p></li></div>
									<div class="second_column"><li><p class="report_total"><?php echo CleanDecimal($client_tab_total_hour); ?></p></li></div>
									<div class="third_column"><li><p class="report_total"><?php echo CleanDecimal($client_tab_total_billable_hour); ?></p></li></div>
									<div class="fourth_column"><li><p class="report_total"><?php echo CleanDecimal($client_tab_total_unbillable_hour); ?></p></li></div>
									<div class="fifth_column"><li><p class="report_total"><?php echo CleanDecimal($client_tab_total_billable_amount); ?></p></li></div>
									<div class="sixth_column"><li><p class="report_total"><?php echo CleanDecimal($client_tab_total_unbillable_amount); ?></p></li></div>
								</div>
							</div>
							<!-- PROJECTS -->
							<div id="projects" class="tab tab_content" style="display: none;">								
								<div class="header_titles">
									<div class="first_column">
										<h3>Name</h3>
										<div style="display:none" class="asc_button report_name_sort_asc"></div>
										<div class="desc_button report_name_sort_desc"></div>
										<div style="display:none" class="report_name_sort_loader loader"></div>
									</div>
									<div class="second_column">
										<h3>Client</h3>
										<div class="asc_button report_time_client_sort_asc"></div>
										<div style="display:none" class="desc_button report_time_client_sort_desc"></div>
										<div style="display:none" class="report_time_client_sort_loader loader"></div>
									</div>
									<div class="third_column">
										<h3>Hours</h3>
									</div>
									<div class="fourth_column">
										<h3>Billable</h3>
									</div>
									<div class="fifth_column">
										<h3>Unbillable</h3>
									</div>
									<div class="sixth_column">
										<h3>Billable A</h3>
									</div>
									<div class="seventh_column">
										<h3>Unbillable A</h3>
									</div>
								</div>
								<div class="project_client_sort_container sort_name_container">
									<?php

										$project_clients = filter_report_time_project_query($filter_month);
										$project_tab_counter = 1;
										foreach($project_clients as $project_client){

											$total_project_hour = CleanDecimal($project_client->total_hours);
											$billable_total_hour_decimal = CleanDecimal($project_client->total_hours);
											$unbillable_total_hour_decimal = CleanDecimal($project_client->unbillable_hours);
	
											$project_tab_total_hour += $project_client->total_hours;
											$project_tab_total_billable_hour += $project_client->billable_hours;
											$project_tab_total_unbillable_hour += $project_client->unbillable_hours;
											$project_tab_total_billable_amount += $project_client->billable_amount;
											$project_tab_total_unbillable_amount += $project_client->unbillable_amount;

										?>
										<div id="info_div_<?php echo $project_tab_counter; ?>" class='info_div'>
											<div class="first_column"><li><?php echo $project_client->task_project_name; ?></li></div>
											<div class="second_column"><li><?php echo $project_client->task_label; ?></li></div>
											<div class="third_column"><li><?php echo $total_project_hour; ?></li></div>
											<div class="fourth_column"><li><?php echo $billable_total_hour_decimal; ?></li></div>
											<div class="fifth_column"><li><?php echo $unbillable_total_hour_decimal; ?></li></div>
											<div class="sixth_column"><li><?php echo CleanDecimal($project_client->billable_amount); ?></li></div>
											<div class="seventh_column"><li><?php  echo CleanDecimal($project_client->unbillable_amount); ?></li></div>
										</div>
									<?php 
										$project_tab_counter++;
									}	
									?>
								</div>
								<div class="info_div_total">
									<div class="first_column"><li><p class="report_total">Total</p></li></div>
									<div class="second_column"><li><p class="report_total">&nbsp;</p></li></div>
									<div class="third_column"><li><p class="report_total"><?php echo CleanDecimal($project_tab_total_hour); ?></p></li></div>
									<div class="fourth_column"><li><p class="report_total"><?php echo CleanDecimal($project_tab_total_billable_hour); ?></p></li></div>
									<div class="fifth_column"><li><p class="report_total"><?php echo CleanDecimal($project_tab_total_unbillable_hour); ?></p></li></div>
									<div class="sixth_column"><li><p class="report_total"><?php echo CleanDecimal($project_tab_total_billable_amount); ?></p></li></div>
									<div class="seventh_column"><li><p class="report_total"><?php echo CleanDecimal($project_tab_total_unbillable_amount); ?></p></li></div>
								</div>								
							</div>
							<!-- TASKS -->
							<div id="tasks" class="tab tab_content" style="display: none;">
								<div class="header_titles">
									<div class="first_column">
										<h3>Name</h3>
										<div style="display:none" class="asc_button report_name_sort_asc"></div>
										<div class="desc_button report_name_sort_desc"></div>
										<div style="display:none" class="report_name_sort_loader loader"></div>
									</div>
									<div class="second_column">
										<h3>Hours</h3>
										<div class="asc_button report_hour_sort_asc"></div>
										<div style="display:none" class="desc_button report_hour_sort_desc"></div>
										<div style="display:none" class="report_hour_sort_loader loader"></div>
									</div>
									<div class="third_column">
										<h3>Billable </h3>
									</div>
									<div class="fourth_column">
										<h3>Unbillable </h3>
									</div>
									<div class="fifth_column">
										<h3>Billable A</h3>
									</div>
									<div class="sixth_column">
										<h3>Unbillable A</h3>
									</div>
								</div>
								<div class="project_hour_sort_container sort_name_container">
								<?php
									$$task_tab_counter = 1;
									$import_data_task = filter_report_time_task_query($filter_month);

									foreach ($import_data_task as $timesheet_data){
										$total_task_hour = CleanDecimal($timesheet_data->total_hours);
										$billable_total_hour_decimal = CleanDecimal($timesheet_data->billable_hours);
										$total_billable_amount = CleanDecimal($timesheet_data->billable_amount);
										$unbillable_total_hour_decimal = CleanDecimal($timesheet_data->unbillable_hours);
										$total_unbillable_amount = CleanDecimal($timesheet_data->unbillable_amount);
										

										$task_tab_total_hour += $timesheet_data->total_hours;
										$task_tab_total_billable_hour += $timesheet_data->billable_hours;
										$task_tab_total_unbillable_hour += $timesheet_data->unbillable_hours;
										$task_tab_total_billable_amount += $timesheet_data->billable_amount;
										$task_tab_total_unbillable_amount += $timesheet_data->unbillable_amount;

								?>
									<div id="info_div_<?php echo $task_tab_counter; ?>" class="info_div">
										<div class="first_column"><li><?php echo format_task_name($timesheet_data->task_name); ?></li></div>
										<div class="second_column"><li><?php echo $total_task_hour; ?></li></div>
										<div class="third_column"><li><?php  echo $billable_total_hour_decimal; ?></li></div>
										<div class="fourth_column"><li><?php  echo $unbillable_total_hour_decimal; ?></li></div>
										<div class="fifth_column"><li><?php echo $total_billable_amount; ?></li></div>
										<div class="sixth_column"><li><?php echo $total_unbillable_amount; ?></li></div>
									</div>
								<?php 
									$task_tab_counter++;
								}								
								?>
								</div>
								<div class="info_div_total">
									<div class="first_column"><li><p class="report_total">Total</p></li></div>
									<div class="second_column"><li><p class="report_total"><?php echo CleanDecimal($task_tab_total_hour); ?></p></li></div>
									<div class="third_column"><li><p class="report_total"><?php echo CleanDecimal($task_tab_total_billable_hour); ?></p></li></div>
									<div class="fourth_column"><li><p class="report_total"><?php echo CleanDecimal($task_tab_total_unbillable_hour); ?></p></li></div>
									<div class="fifth_column"><li><p class="report_total"><?php echo CleanDecimal($task_tab_total_billable_amount); ?></p></li></div>
									<div class="sixth_column"><li><p class="report_total"><?php echo CleanDecimal($task_tab_total_unbillable_amount); ?></p></li></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
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