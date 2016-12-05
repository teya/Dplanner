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
					$total_hour_decimal = "";
					$billable_id_array = array();
					$unbillable_id_array = array();
					foreach($import_data as $timesheet_data){
						$task_hour = $timesheet_data->task_hour;
						$task_hour_decimal = round(decimalHours($task_hour), 2);					
						$total_hour_decimal += $task_hour_decimal;
						$task_project_name = $timesheet_data->task_project_name;
						$task_client_name = $timesheet_data->task_label;
						$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");
						//////// if($task_project_name == $project_data->project_name && $task_client_name == $project_data->project_client && $project_data->project_invoice_method == 1){											
							//////// $timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
							//////// foreach($timesheet_items as $timesheet_item){
								//////// $task_id = $timesheet_item->ID;
								//////// array_push($id_array,$task_id);
							//////// }						
						//////// }
	
						if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){
							$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
							foreach($timesheet_items as $timesheet_item){
								$task_name = format_task_name($timesheet_item->task_name);
								$timesheet_id = $timesheet_item->ID;
								$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
								if($tasks->task_billable == 1){
									array_push($billable_id_array,$timesheet_id);
								}else{
									array_push($unbillable_id_array,$timesheet_id);
								}
							}
						}
						
						if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){
							$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");												
							foreach($timesheet_items as $timesheet_item){
								$task_name = format_task_name($timesheet_item->task_name);
								$timesheet_id = $timesheet_item->ID;
								$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
								if($tasks->task_billable == 1){													
									array_push($billable_id_array,$timesheet_id);
									}else{
									array_push($unbillable_id_array,$timesheet_id);
								}
							}
						}
					}	
					$billable_ids = array_unique($billable_id_array);
					$billable_total_hour_decimal = "";
					$total_billable_amount = 0;
					foreach($billable_ids as $id){					
						$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter_month AND ID = '$id'");				
						$billable_task_hour = $billable_timesheet_data->task_hour;
						$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
						$billable_total_hour_decimal += $billable_task_hour_decimal;
						$fullname = $billable_timesheet_data->task_person;						
						$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");	
						$client_name = $billable_timesheet_data->task_label;
						$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");		
						$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
						$client_hourly_rate = $client_info->client_hourly_rate;
						$task_billable_amount = $billable_task_hour_decimal * $client_hourly_rate;
						$total_billable_amount += $task_billable_amount;
					}
					
					$unbillable_ids = array_unique($unbillable_id_array);
					$unbillable_total_hour_decimal = "";
					$total_unbillable_amount = 0;
					$top_seoweb_total = 0;
					$top_bq_total = 0;
					// $total_ledig_time_decimal = 0;
					// $total_helg_time_decomal = 0;
					// $total_semester_time_decimal = 0;
					foreach($unbillable_ids as $id){
						$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter_month AND ID = '$id'");
						$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
						$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);
						$top_taskname = strtolower($unbillable_timesheet_data->task_name);

						if($top_taskname == 'ledig'){ //Free
							$total_no_work += $unbillable_task_hour_decimal;
						}

						if($top_taskname == 'helg'){ // Weekend										
							$total_no_work += $unbillable_task_hour_decimal;
						}	

						if($top_taskname == 'semester'){ // Holiday										
							$total_no_work += $unbillable_task_hour_decimal;
						}	

						if($top_taskname == 'sjuk'){ // Sick										
							$total_no_work += $unbillable_task_hour_decimal;
						}	

						if($top_taskname == 'seoweb'){
							$top_seoweb_total += $unbillable_task_hour_decimal;
						}
						if($top_taskname == 'bq'){
							$top_bq_total += $unbillable_task_hour_decimal;	
						}

						$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
						$fullname = $unbillable_timesheet_data->task_person;																						
						$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");	
						$client_name = $unbillable_timesheet_data->task_label;
						$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");					
						$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;											
						$client_hourly_rate = $client_info->client_hourly_rate;
						$task_unbillable_amount = $unbillable_task_hour_decimal * $client_hourly_rate;
						$total_unbillable_amount += $task_unbillable_amount;
					}	

					$dwork_total = $total_no_work + $top_seoweb_total + $top_bq_total;

					// if($dwork_total != 0 || $dwork_total != ""){
						$top_dwork_total = $total_hour_decimal - $dwork_total;
					 
						// $top_dwork_percent = 
					// }else{
					// 	$top_dwork_total = 0;
					// }

					if($billable_total_hour_decimal != ''){
						$top_total_dwork = round(($billable_total_hour_decimal / $top_dwork_total) * 100);
					}else{
						$top_total_dwork = 0;
					}

				?>
				<div class="one_fourth"><p class="top_reports_label">Total Tracked</p><h1 class="top_hours_tracked"><?php echo round_quarter($total_hour_decimal); ?></h1></div>
				<!--  <div class="one_fourth"><p class="top_reports_label">Dwork</p><h1 class="top_hours_tracked"><?php echo round_quarter($total_hour_decimal); ?></h1></div>
				<div class="one_fourth"><p class="top_reports_label">Billable Hours</p><h1 class="top_billable_hours"><?php echo round_quarter($billable_total_hour_decimal); ?></h1></div> -->
				<div class="one_fourth"><p class="top_reports_label">Billable A</p><h1 class="top_billable_amount">kr&nbsp;<?php echo ($total_billable_amount == 0 || $total_billable_amount == "" )? '00:00' : $total_billable_amount; ?></h1></div>
				<div class="one_fourth"><p class="top_reports_label">D%</p><h1 class="top_dwork_hours"><?php echo $top_total_dwork; ?>%</h1></div>
				<div class="one_fourth"><p class="top_reports_label">No Work</p><h1 class="top_ledig_hours"><?php echo round_quarter($total_no_work);  ?></h1></div>
				<div class="one_fourth last"><p class="top_reports_label">Unbillable Hours</p><h1 class="top_unbillable_hours"><?php echo round_quarter($unbillable_total_hour_decimal); ?></h1></div>
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
									<div class="tenth_column"><h3>Vacation</h3></div>
									<div class="eleventh_column"><h3>Sick</h3></div>
								</div>
								<div class="project_hour_sort_container sort_name_container">
								<?php
									$import_data_person = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month ORDER BY task_person ASC");
									$person_name_array = array();
									foreach ($import_data_person as $timesheet_data){
										$person_names = $timesheet_data->task_person;
										array_push($person_name_array, $person_names);
									}
									$person_name = array_unique($person_name_array);
									$staff_tab_counter = 1;
									foreach($person_name as $person){
										$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_person ='$person'");
										$total_person_hour = "";
										$dwork_percent = 0;
										$dwork_total_hour_decimal = 0;
										$billable_id_array = array();
										$unbillable_id_array = array();
										foreach($timesheet_data as $timesheet_item){
											$task_hour = $timesheet_item->task_hour;
											$task_hour_decimal = round(decimalHours($task_hour), 2);
											$total_person_hour += $task_hour_decimal;
											$task_project_name = $timesheet_item->task_project_name;
											$task_client_name = $timesheet_item->task_label;
											$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");											
											if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){												
												$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_person = '$person' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
												foreach($timesheet_items as $timesheet_item){
													$task_name = format_task_name($timesheet_item->task_name);													
													$timesheet_id = $timesheet_item->ID;
													$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
													if($tasks->task_billable == 1){
														array_push($billable_id_array,$timesheet_id);
													}else{
														array_push($unbillable_id_array,$timesheet_id);
													}
												}
											}
											
											// if($task_project_name == $project_data->project_name && $task_client_name == $project_data->project_client){												
											// 	$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_person = '$person' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");												
											// 	foreach($timesheet_items as $timesheet_item){
											// 		$task_name = format_task_name($timesheet_item->task_name);													
											// 		$timesheet_id = $timesheet_item->ID;
											// 		$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
											// 		if($tasks->task_billable == 1){													
											// 			array_push($billable_id_array,$timesheet_id);
											// 		}else{
											// 			array_push($unbillable_id_array,$timesheet_id);
											// 		}
											// 	}
											// }
										}
										$billable_ids = array_unique($billable_id_array);
										$billable_total_hour_decimal = 0;
										$total_billable_amount = "";
										foreach($billable_ids as $id){
											$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter_month AND ID = '$id'");
											$billable_task_hour = $billable_timesheet_data->task_hour;
											$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
											$billable_total_hour_decimal += $billable_task_hour_decimal;											
											$fullname = $billable_timesheet_data->task_person;
											$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
											$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
											$client_name = $billable_timesheet_data->task_label;
											$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");
											$client_hourly_rate = $client_info->client_hourly_rate;
											$task_billable_amount = $billable_task_hour_decimal * $client_hourly_rate;
											$total_billable_amount += $task_billable_amount;
										}	
										
										$unbillable_ids = array_unique($unbillable_id_array);
										$unbillable_total_hour_decimal = 0;
										$total_unbillable_amount = "";

										foreach($unbillable_ids as $id){
											$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter_month AND ID = '$id'");
											$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
											$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
											$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
											$fullname = $unbillable_timesheet_data->task_person;																						
											$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
											$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
											$client_name = $unbillable_timesheet_data->task_label;
											$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");											
											$client_hourly_rate = $client_info->client_hourly_rate;
											$task_unbillable_amount = $unbillable_task_hour_decimal * $client_hourly_rate;
											$total_unbillable_amount += $task_unbillable_amount;
										}
										
										$non_working_timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_person = '$person'");										
										$holiday_total_hour_decimal = "";
										$vacation_total_hour_decimal = "";
										$sickness_total_hour_decimal = "";
										$ledig_total_hour_decimal = "";
										$seoweb_total_hour_decimal = "";
										$bq_total_hour_decimal = "";
										$Dpercent = "";


										$electric_internet_total_hour_decimal = "";
										foreach($non_working_timesheet_items as $non_working_timesheet_item){
											$task_name = strtolower($non_working_timesheet_item->task_name);
											if($task_name == 'helg'){ // Weekend
												$holiday_task_hour = $non_working_timesheet_item->task_hour;
												$holiday_task_hour_decimal = round(decimalHours($holiday_task_hour), 2);											
												$holiday_total_hour_decimal += $holiday_task_hour_decimal;	
											}											
											if($task_name == 'semester'){ //Holiday
												$vacation_task_hour = $non_working_timesheet_item->task_hour;
												$vacation_task_hour_decimal = round(decimalHours($vacation_task_hour), 2);											
												$vacation_total_hour_decimal += $vacation_task_hour_decimal;	
											}
											if($task_name == 'sjuk'){ //Sick
												$sickness_task_hour = $non_working_timesheet_item->task_hour;
												$sickness_task_hour_decimal = round(decimalHours($sickness_task_hour), 2);											
												$sickness_total_hour_decimal += $sickness_task_hour_decimal;	
											}
											if($task_name == 'ledig'){ //Free
												$ledig_task_hour = $non_working_timesheet_item->task_hour;
												$ledig_task_hour_decimal = round(decimalHours($ledig_task_hour), 2);											
												$ledig_total_hour_decimal += $ledig_task_hour_decimal;													
											}
											if($task_name == 'seoweb'){
												$seoweb_task_hour = $non_working_timesheet_item->task_hour;
												$seoweb_task_hour_decimal = round(decimalHours($seoweb_task_hour), 2);											
												$seoweb_total_hour_decimal += $seoweb_task_hour_decimal;
											}
											if($task_name == 'bq'){
												$bq_task_hour = $non_working_timesheet_item->task_hour;
												$bq_task_hour_decimal = round(decimalHours($bq_task_hour), 2);											
												$bq_total_hour_decimal += $bq_task_hour_decimal;
											}
											// if($task_name == 'electric / internet problems'){
											// 	$electric_internet_task_hour = $non_working_timesheet_item->task_hour;
											// 	$electric_internet_task_hour_decimal = round(decimalHours($electric_internet_task_hour), 2);											
											// 	$electric_internet_total_hour_decimal += $electric_internet_task_hour_decimal;	
											// }
										}

										// Total-Sjuk-Semester-Ledig-SEOWeb-BQ
										$dwork_total_hour_decimal = $sickness_total_hour_decimal + $vacation_total_hour_decimal + $ledig_total_hour_decimal + $seoweb_total_hour_decimal + $bq_total_hour_decimal;
										// $Dpercent = ($total_person_hour / 0) * 100;
										$person_tab_total_hour += $total_person_hour;
										$person_tab_total_billable_hour += $billable_total_hour_decimal;
										$person_tab_total_billable_amount += $total_billable_amount;
										$person_tab_total_unbillable_amount += $total_unbillable_amount;
										$person_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
										$person_tab_total_holiday_hour += $holiday_total_hour_decimal;
										$person_tab_total_vacation_hour += $vacation_total_hour_decimal;
										$person_tab_total_sickness_hour += $sickness_total_hour_decimal;
										$person_tab_total_ledig_hour += $ledig_total_hour_decimal;
										$person_tab_total_seoweb_hour += $seoweb_total_hour_decimal;
										// $person_tab_total_electric_internet_hour += $electric_internet_total_hour_decimal;
										
										// if($dwork_total_hour_decimal != 0 || $dwork_total_hour_decimal != ""){
											$total_dwork_hour = $total_person_hour - $dwork_total_hour_decimal;
											$dwork_percent = ($billable_total_hour_decimal  / $total_dwork_hour) * 100;
										// }else{
										// 	$total_dwork_hour = 0;
										// 	$dwork_percent = 0;
										// }

										//Add all staff Dwork
										$person_tab_total_dwork_hour += $total_dwork_hour;
										$person_tab_total_dwork_percent +=  $dwork_percent;


								?>
										<div id="info_div_<?php echo $staff_tab_counter; ?>" class='info_div'>
											<div class="first_column"><li><?php echo $person; ?></li></div>
											<div class="second_column"><li><?php echo ($total_person_hour != "" ? round_quarter($total_person_hour) : "00:00"); ?></li></div>
											<div class="third_column"><li><?php echo round_quarter($total_person_hour - $dwork_total_hour_decimal); ?></li></div>
											<div class="fourth_column"><li><?php echo ($billable_total_hour_decimal != "" ? round_quarter($billable_total_hour_decimal) : "00:00"); ?></li></div>
											<div class="fifth_column"><li><?php echo ($unbillable_total_hour_decimal != "" ? round_quarter($unbillable_total_hour_decimal) : "00:00"); ?></li></div>
											<div class="sixth_column"><li><?php echo ($total_billable_amount != "" ? $total_billable_amount : 0); ?></li></div>
											<div class="seventh_column"><li><?php echo  round($dwork_percent); ?>%</li></div> 
											<div class="eight_column"><li><?php  echo ($ledig_total_hour_decimal != "" ? round_quarter($ledig_total_hour_decimal) : "00:00"); ?></li></div>
											<div class="ninth_column"><li><?php echo ($holiday_total_hour_decimal != "" ? round_quarter($holiday_total_hour_decimal) : "00:00"); ?></li></div>
											<div class="tenth_column"><li><?php echo ($vacation_total_hour_decimal != "" ? round_quarter($vacation_total_hour_decimal) : "00:00"); ?></li></div>
											<div class="eleventh_column"><li><?php echo ($sickness_total_hour_decimal != "" ? round_quarter($sickness_total_hour_decimal) : "00:00"); ?></li></div>
										</div>
								<?php
										$staff_tab_counter++;
										if($person_tab_total_billable_hour != ''){
											$person_table_total_billable_a = round(($person_tab_total_billable_hour / $person_tab_total_dwork_hour)*100);
										}else{
											$person_table_total_billable_a = 0;
										}
									}							
								?>
								</div>
								<div class="info_div_total">
									<div class="first_column"><li><p class="report_total">Total</p></li></div>
									<div class="second_column"><li><p class="report_total"><?php echo round_quarter($person_tab_total_hour); ?></p></li></div>
									<div class="third_column"><li><p class="report_total"><?php echo round_quarter($person_tab_total_dwork_hour); ?></p></li></div>
									<div class="fourth_column"><li><p class="report_total"><?php echo round_quarter($person_tab_total_billable_hour); ?></p></li></div>
									<div class="fifth_column"><li><p class="report_total"><?php echo round_quarter($person_tab_total_unbillable_hour); ?></p></li></div>
									<div class="sixth_column"><li><p class="report_total"><?php echo $person_tab_total_billable_amount; ?></p></li></div>
									<div class="seventh_column"><li><p class="report_total"><?php  echo $person_table_total_billable_a; ?>%</p></li></div>
									<div class="eight_column"><li><p class="report_total"><?php echo round_quarter($person_tab_total_ledig_hour); ?></p></li></div>
									<div class="ninth_column"><li><p class="report_total"><?php echo round_quarter($person_tab_total_holiday_hour); ?></p></li></div>
									<div class="tenth_column"><li><p class="report_total"><?php echo round_quarter($person_tab_total_vacation_hour); ?></p></li></div>
									<div class="eleventh_column"><li><p class="report_total"><?php echo round_quarter($person_tab_total_sickness_hour); ?></p></li></div>
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
									$import_data_client = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month ORDER BY task_label ASC");
									$task_client_name_array = array();
									foreach ($import_data_client as $timesheet_data){
										$task_client_name = $timesheet_data->task_label;
										array_push($task_client_name_array,$task_client_name);
									}
									$client_names = array_unique($task_client_name_array);
									$client_tab_total_hour = "";							
									$client_tab_total_billable_hour = "";
									$client_tab_counter = 1;
									foreach($client_names as $client_name){ 
										$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_label = '$client_name'");				
										$array_count = count($timesheet_data);
										$total_client_hours = "";
										$billable_id_array = array();
										$unbillable_id_array = array();
										for($x = 0; $x <= $array_count; $x++){
											$task_hour = $timesheet_data[$x]->task_hour;								
											$task_hour_decimal = round(decimalHours($task_hour), 2);
											$total_client_hours += $task_hour_decimal;											
											$task_project_name = $timesheet_data[$x]->task_project_name;
											$task_client_name =$timesheet_data[$x]->task_label;
											$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");
											if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){
												$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
												foreach($timesheet_items as $timesheet_item){
													$task_name = format_task_name($timesheet_item->task_name);
													$timesheet_id = $timesheet_item->ID;
													$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
													if($tasks->task_billable == 1){
														array_push($billable_id_array,$timesheet_id);
													}else{
														array_push($unbillable_id_array,$timesheet_id);
													}
												}
											}
											
											if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){	
												$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");												
												foreach($timesheet_items as $timesheet_item){
													$task_name = format_task_name($timesheet_item->task_name);
													$timesheet_id = $timesheet_item->ID;
													$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
													if($tasks->task_billable == 1){													
														array_push($billable_id_array,$timesheet_id);
													}else{
														array_push($unbillable_id_array,$timesheet_id);
													}
												}
											}
										}
																			
										$billable_ids = array_unique($billable_id_array);
										$billable_total_hour_decimal = "";
										$total_billable_amount = "";
										foreach($billable_ids as $id){
											$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter_month AND ID = '$id'");
											$billable_task_hour = $billable_timesheet_data->task_hour;
											$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
											$billable_total_hour_decimal += $billable_task_hour_decimal;											
											$fullname = $billable_timesheet_data->task_person;																						
											$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
											$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
											$client_name = $billable_timesheet_data->task_label;
											$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");											
											$client_hourly_rate = $client_info->client_hourly_rate;
											$task_billable_amount = $billable_task_hour_decimal * $client_hourly_rate;
											$total_billable_amount += $task_billable_amount;
										}
										
										$unbillable_ids = array_unique($unbillable_id_array);
										$unbillable_total_hour_decimal = "";
										$total_unbillable_amount = "";
										foreach($unbillable_ids as $id){
											$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter_month AND ID = '$id'");

											$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
											$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
											$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
											$fullname = $unbillable_timesheet_data->task_person;																						
											$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
											$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
											$client_name = $unbillable_timesheet_data->task_label;
											$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");	
											$client_hourly_rate = $client_info->client_hourly_rate;
											$task_unbillable_amount = $unbillable_task_hour_decimal * $client_hourly_rate;
											$total_unbillable_amount += $task_unbillable_amount;
										}
										
										$client_tab_total_hour += $total_client_hours;										
										$client_tab_total_billable_hour += $billable_total_hour_decimal;
										$client_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
										$client_tab_total_billable_amount += $total_billable_amount;
										$client_tab_total_unbillable_amount += $total_unbillable_amount;
										
									?>
									<div id="info_div_<?php echo $client_tab_counter; ?>" class='info_div'>
										<div class="first_column"><li><?php echo $client_name; ?></li></div>
										<div class="second_column"><li><?php echo ($total_client_hours != "" ? round_quarter($total_client_hours) : 0); ?></li></div>
										<div class="third_column"><li><?php echo  ($billable_total_hour_decimal != "" ? round_quarter($billable_total_hour_decimal) : 0); ?></li></div>
										<div class="fourth_column"><li><?php echo ($unbillable_total_hour_decimal != "" ? round_quarter($unbillable_total_hour_decimal) : 0); ?></li></div>
										<div class="fifth_column"><li><?php echo ($total_billable_amount != "" ? $total_billable_amount : 0); ?></li></div>
										<div class="sixth_column"><li><?php echo ($total_unbillable_amount != "" ? $total_unbillable_amount : 0); ?></li></div>
									</div>								
								<?php 
									$client_tab_counter++;
								} 
								?>
								</div>
								<div class="info_div_total">
									<div class="first_column"><li><p class="report_total">Total</p></li></div>
									<div class="second_column"><li><p class="report_total"><?php echo round_quarter($client_tab_total_hour); ?></p></li></div>
									<div class="third_column"><li><p class="report_total"><?php echo round_quarter($client_tab_total_billable_hour); ?></p></li></div>
									<div class="fourth_column"><li><p class="report_total"><?php echo round_quarter($client_tab_total_unbillable_hour); ?></p></li></div>
									<div class="fifth_column"><li><p class="report_total"><?php echo $client_tab_total_billable_amount; ?></p></li></div>
									<div class="sixth_column"><li><p class="report_total"><?php echo ($client_tab_total_unbillable_amount != "" ? $client_tab_total_unbillable_amount : 0); ?></p></li></div>
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
										$import_data_project = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month ORDER BY task_project_name ASC");
										$project_client_array = array();
										foreach ($import_data_project as $timesheet_data){
											$project_name = $timesheet_data->task_project_name;
											$task_client_name = $timesheet_data->task_label;
											$project_client_combine = $project_name ."_". $task_client_name;
											array_push($project_client_array, $project_client_combine);
										}

										$project_clients = array_unique($project_client_array);
										$project_tab_counter = 1;
										foreach($project_clients as $project_client){
											$project_client_explode = explode("_", $project_client);
											$project_name_title = $project_client_explode[0];
											$client_name_title = $project_client_explode[1];

											$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month  AND task_project_name ='$project_name_title' AND task_label = '$client_name_title'");										
											$array_count = count($timesheet_data);
											$total_project_hour = "";
											$billable_id_array = array();
											$unbillable_id_array = array();
											for($x = 0; $x <= $array_count; $x++){
												$task_hour = $timesheet_data[$x]->task_hour;
												$task_hour_decimal = round(decimalHours($task_hour), 2);
												$total_project_hour += $task_hour_decimal;
												$task_project_name = $timesheet_data[$x]->task_project_name;
												$task_client_name =$timesheet_data[$x]->task_label;
												$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");
												// if($task_project_name == $project_data->project_name && $task_client_name == $project_data->project_client && $project_data->project_invoice_method == 1){
													// $timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
													// foreach($timesheet_items as $timesheet_item){
														// $task_id = $timesheet_item->ID;
														// array_push($id_array,$task_id);
													// }
												// }
												
												if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
													$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");												
													foreach($timesheet_items as $timesheet_item){
														$task_name = format_task_name($timesheet_item->task_name);
														$timesheet_id = $timesheet_item->ID;
														$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
														if($tasks->task_billable == 1){
															array_push($billable_id_array,$timesheet_id);
															}else{
															array_push($unbillable_id_array,$timesheet_id);
														}
													}
												}
												
												if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
													$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");												
													foreach($timesheet_items as $timesheet_item){
														$task_name = format_task_name($timesheet_item->task_name);
														$timesheet_id = $timesheet_item->ID;
														$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
														if($tasks->task_billable == 1){													
															array_push($billable_id_array,$timesheet_id);
															}else{
															array_push($unbillable_id_array,$timesheet_id);
														}
													}
												}
											}																			
											$billable_ids = array_unique($billable_id_array);
											$billable_total_hour_decimal = "";
											$total_billable_amount = "";
											foreach($billable_ids as $id){
												$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter_month AND ID = '$id'");
												$billable_task_hour = $billable_timesheet_data->task_hour;
												$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
												$billable_total_hour_decimal += $billable_task_hour_decimal;												
												$fullname = $billable_timesheet_data->task_person;												
												$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
												$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
												$client_name = $billable_timesheet_data->task_label;
												$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");	
												$client_hourly_rate = $client_info->client_hourly_rate;
												$task_billable_amount = $billable_task_hour_decimal * $client_hourly_rate;
												$total_billable_amount += $task_billable_amount;
											}
											
											$unbillable_ids = array_unique($unbillable_id_array);
											$unbillable_total_hour_decimal = "";
											$total_unbillable_amount = "";
											foreach($unbillable_ids as $id){
												$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter_month AND ID = '$id'");
												$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
												$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
												$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
												$fullname = $unbillable_timesheet_data->task_person;																						
												$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
												$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
												$client_name = $unbillable_timesheet_data->task_label;
												$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");											
												$client_hourly_rate = $client_info->client_hourly_rate;
												$task_unbillable_amount = $unbillable_task_hour_decimal * $client_hourly_rate;
												$total_unbillable_amount += $task_unbillable_amount;
											}
											
											$project_tab_total_hour += $total_project_hour;
											$project_tab_total_billable_hour += $billable_total_hour_decimal;
											$project_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
											$project_tab_total_billable_amount += $total_billable_amount;
											$project_tab_total_unbillable_amount += $total_unbillable_amount;
										?>
										<div id="info_div_<?php echo $project_tab_counter; ?>" class='info_div'>
											<div class="first_column"><li><?php echo $project_name_title; ?></li></div>
											<div class=" second_column"><li><?php echo $client_name_title; ?></li></div>
											<div class="third_column"><li><?php echo ($total_project_hour != "" ? round_quarter($total_project_hour) : 0); ?></li></div>
											<div class="fourth_column"><li><?php echo ($billable_total_hour_decimal != "" ? round_quarter($billable_total_hour_decimal) : 0); ?></li></div>
											<div class="fifth_column"><li><?php echo ($unbillable_total_hour_decimal != "" ? round_quarter($unbillable_total_hour_decimal) : 0); ?></li></div>
											<div class="sixth_column"><li><?php echo ($total_billable_amount != "" ? $total_billable_amount : 0); ?></li></div>
											<div class="seventh_column"><li><?php  echo ($total_unbillable_amount != "" ? $total_unbillable_amount : 0); ?></li></div>
										</div>
									<?php 
										$project_tab_counter++;
									}	
									?>
								</div>
								<div class="info_div_total">
									<div class="first_column"><li><p class="report_total">Total</p></li></div>
									<div class="second_column"><li><p class="report_total">&nbsp;</p></li></div>
									<div class="third_column"><li><p class="report_total"><?php echo round_quarter($project_tab_total_hour); ?></p></li></div>
									<div class="fourth_column"><li><p class="report_total"><?php echo round_quarter($project_tab_total_billable_hour); ?></p></li></div>
									<div class="fifth_column"><li><p class="report_total"><?php echo round_quarter($project_tab_total_unbillable_hour); ?></p></li></div>
									<div class="sixth_column"><li><p class="report_total"><?php echo $project_tab_total_billable_amount; ?></p></li></div>
									<div class="seventh_column"><li><p class="report_total"><?php echo $project_tab_total_unbillable_amount; ?></p></li></div>
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
									$import_data_task = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month ORDER BY task_name ASC");
									$task_name_array = array();
									foreach ($import_data_task as $timesheet_data){
										$task_names = $timesheet_data->task_name;
										array_push($task_name_array, $task_names);
									}
									$task_tab_counter = 1;
									$task_name = array_unique($task_name_array);
									foreach($task_name as $task){
										$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_name ='$task'");
										$total_task_hour = "";
										$billable_id_array = array();
										$unbillable_id_array = array();
										foreach($timesheet_data as $timesheet_item){											
											$task_hour = $timesheet_item->task_hour;
											$task_hour_decimal = round(decimalHours($task_hour), 2);
											$total_task_hour += $task_hour_decimal;
											$task_project_name = $timesheet_item->task_project_name;
											$task_client_name = $timesheet_item->task_label;
											$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");
											// if($task_project_name == $project_data->project_name && $task_client_name == $project_data->project_client && $project_data->project_invoice_method == 1){
												// $timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_name = '$task' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
												// foreach($timesheet_items as $timesheet_item){
													// $task_id = $timesheet_item->ID;
													// array_push($id_array,$task_id);
												// }
											// }

											if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
												// $timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
												$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_name = '$task' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
												foreach($timesheet_items as $timesheet_item){
													$task_name = format_task_name($timesheet_item->task_name);
													$timesheet_id = $timesheet_item->ID;
													$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
													if($tasks->task_billable == 1){
														array_push($billable_id_array,$timesheet_id);
														}else{
														array_push($unbillable_id_array,$timesheet_id);
													}
												}
											}
											
											if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
												// $timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
												$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter_month AND task_name = '$task' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
												foreach($timesheet_items as $timesheet_item){
													$task_name = format_task_name($timesheet_item->task_name);
													$timesheet_id = $timesheet_item->ID;
													$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
													if($tasks->task_billable == 1){													
														array_push($billable_id_array,$timesheet_id);
														}else{
														array_push($unbillable_id_array,$timesheet_id);
													}
												}
											}											
										}
										$billable_ids = array_unique($billable_id_array);
										$billable_total_hour_decimal = "";
										$total_billable_amount = "";
										foreach($billable_ids as $id){
											$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter_month AND ID = '$id'");
											$billable_task_hour = $billable_timesheet_data->task_hour;
											$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
											$billable_total_hour_decimal += $billable_task_hour_decimal;											
											$fullname = $billable_timesheet_data->task_person;
											$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
											$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
											$client_name = $billable_timesheet_data->task_label;
											$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");
											$client_hourly_rate = $client_info->client_hourly_rate;
											$task_billable_amount = $billable_task_hour_decimal * $client_hourly_rate;
											$total_billable_amount += $task_billable_amount;
										}

										$unbillable_ids = array_unique($unbillable_id_array);
										$unbillable_total_hour_decimal = "";
										$total_unbillable_amount = "";
										foreach($unbillable_ids as $id){
											$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter_month AND ID = '$id'");
											$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
											$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
											$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
											$fullname = $unbillable_timesheet_data->task_person;																						
											$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
											$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
											$client_name = $unbillable_timesheet_data->task_label;
											$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");											
											$client_hourly_rate = $client_info->client_hourly_rate;
											$task_unbillable_amount = $unbillable_task_hour_decimal * $client_hourly_rate;
											$total_unbillable_amount += $task_unbillable_amount;
										}
										
										$task_tab_total_hour += $total_task_hour;
										$task_tab_total_billable_hour += $billable_total_hour_decimal;
										$task_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
										$task_tab_total_billable_amount += $total_billable_amount;
										$task_tab_total_unbillable_amount += $total_unbillable_amount;
								?>
									<div id="info_div_<?php echo $task_tab_counter; ?>" class="info_div">
										<div class="first_column"><li><?php echo format_task_name($task); ?></li></div>
										<div class="second_column"><li><?php echo round_quarter($total_task_hour); ?></li></div>
										<div class="third_column"><li><?php  echo ($billable_total_hour_decimal != "" ? round_quarter($billable_total_hour_decimal) : 0); ?></li></div>
										<div class="fourth_column"><li><?php  echo ($unbillable_total_hour_decimal != "" ? round_quarter($unbillable_total_hour_decimal) : 0); ?></li></div>
										<div class="fifth_column"><li><?php echo ($total_billable_amount != "" ? $total_billable_amount : 0); ?></li></div>
										<div class="sixth_column"><li><?php echo ($total_unbillable_amount != "" ? $total_unbillable_amount : 0); ?></li></div>
									</div>
								<?php 
									$task_tab_counter++;
								}								
								?>
								</div>
								<div class="info_div_total">
									<div class="first_column"><li><p class="report_total">Total</p></li></div>
									<div class="second_column"><li><p class="report_total"><?php echo round_quarter($task_tab_total_hour); ?></p></li></div>
									<div class="third_column"><li><p class="report_total"><?php echo round_quarter($task_tab_total_billable_hour); ?></p></li></div>
									<div class="fourth_column"><li><p class="report_total"><?php echo round_quarter($task_tab_total_unbillable_hour); ?></p></li></div>
									<div class="fifth_column"><li><p class="report_total"><?php echo $task_tab_total_billable_amount; ?></p></li></div>
									<div class="sixth_column"><li><p class="report_total"><?php echo $task_tab_total_unbillable_amount; ?></p></li></div>
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