<?php 
	/* Template name: Maintainance */ 
	if (!is_user_logged_in()) {
	    wp_redirect( wp_login_url( $redirect ) );
	    exit();
	}
	$current_user = wp_get_current_user();
	$client_tablename = $wpdb->prefix ."custom_client";
 	$clients = $wpdb->get_results("SELECT 
									c.ID, 
									c.client_name, 
									c.client_maintenance_schedule, 
									p.person_initial, 
									CASE WHEN (c.client_maintenance_hours is null OR c.client_maintenance_hours = '')
									THEN '--' ELSE c.client_maintenance_hours END AS client_maintenance_hours, 
									CASE WHEN (c.client_next_schedule_maintenance is null or c.client_next_schedule_maintenance = '') 
									THEN '--'ELSE DATE_FORMAT(STR_TO_DATE(c.client_next_schedule_maintenance,'%m/%d/%Y'),'%Y-%m-%d') END AS client_next_schedule_maintenance, 
									(DATE_FORMAT(STR_TO_DATE(c.client_next_schedule_maintenance,'%m/%d/%Y'),'%Y-%m-%d') < CURDATE()) as date_passed 
									FROM ".CLIENT_TABLE." as c 
									INNER JOIN ".PERSON_TABLE." as p 
									ON c.client_default_consultant_id = p.id
									WHERE c.client_service_agreement = 'Yes'
									ORDER BY client_next_schedule_maintenance ASC"); ?> 
 	<?php get_header(); ?>
	<table id="client-maintenance-table" class="dplan-table">
		<thead>
			<tr>
				<th>Client</th>
				<th>Maintainance Schedule</th>
				<th>Maintainance Hours</th>
				<th>Consultant</th>
				<th>Scheduled Date</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($clients as $client){ ?>
				<tr id="<?php echo $client->ID; ?>">
					<?php
						$date_passed = '';
					?>
					<td class="clientname"><?php echo $client->client_name ?></td>
					<td class="schedule-interval"><?php echo $client->client_maintenance_schedule ?></td>
					<td class="hours"><?php echo $client->client_maintenance_hours ?></td>
					<?php
						if(trim($client->client_next_schedule_maintenance) != '--'){
							
							$date_passed = ($client->date_passed == 1)? 'date_passed' : '';	
						}
					?>
					<td>
						<?php echo $client->person_initial ?>
					</td>
					<td>
						<span class="edit_client_next_schedule_maintenance <?php echo $date_passed; ?>"><?php echo $client->client_next_schedule_maintenance ?></span>
					</td>
					<td>
						<div class="option-list">
						<i class="fa fa-eye view_client_maintenance pull-right" aria-hidden="true" title="View Client Details"></i>
						<?php if($client->client_next_schedule_maintenance != '--'): ?>
							<i class="fa fa-check-square complete_client_maintenance pull-right" aria-hidden="true" title="Comp[ete Maintenanace"></i>
						<?php endif; ?>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<!-- POP-UP to view TOdo List -->
	<div style="display:none;" class="maintenance_view_todolist" id="maintenance_view_todolist" title="View List">
		<form class="" id="todolist_view_form">
			<input type="hidden" id="todolist_id" name="todolist_id" value="">
			<table>
				<tr>
					<td><p>Taskname:</p></td>
					<td><p id="todolist_name"></p></td>
				</tr>
				<tr>
					<td><p>Client:</p></td>
					<td><p id="todolist_clientname"></p></td>
				</tr>
				<tr>
					<td><p>Consultant:</p></td>
					<td><p id="todolist_consultant"></p></td>
				</tr>
				<tr>
					<td><p>Descriptions:</p></td>
					<td><p id="todolist_descriptions"></p></td>
				</tr>
				<tr>
					<td>
						<p>Priority:</p></td>
					<td>
						<select name="todolist_priority" id="todolist_priority"></select>
					</td>
				</tr>
				<tr>
					<td>
						<p>Status:</p></td>
					<td>
						<select name="todolist_status" id="todolist_status"></select>
					</td>
				</tr>
				<tr>
					<td><p>Deadline:</p></td>
					<td><p id="todolist_deadline"></p></td>
				</tr>
				<tr>
					<td>
						<p>Subtasks:</p></td>
					<td>
						<div id="task_subtasks">
						</div>
					</td>
				</tr>
			</table>
			<div id="bottom-actions-list">
				<div id="save_list_progress" class="button_1 pull-left">Save</div>
			</div>
			<div style="display:none;" class="loader saving_todolist_progress pull-left"></div>
		</form>
		<p id="message_saving_progress" class="message" style="display: none;">Successfully updating Todo list.</p>
	</div>
	<!-- POP-UP to view Maintenance  -->
	<div style="display:none;" class="view_maintenance_popup" id="view_maintenance_popup" title="Maintainance Info">
		<form class="" id="">
			<input type="hidden" id="client_maintenance_info_id" name="" value="">
			<table>
				<tr>
					<td><p>Client:</p></td>
					<td><p id="maintenance_client"></p></td>
				</tr>
				<tr>
					<td><p>Client Maintenance Intervals:</p></td>
					<td><p id="client_maintenanace_intervat"></p></td>
				</tr>
				<tr>
					<td><p>Maintenance Hours:</p></td>
					<td><p id="maintenance_hours_client"><input name="maitenance_hours_client" type="text"></p></td>
				</tr>
				<tr>
					<td>
						<p>Schedule Date:</p>
					</td>
					<td>
						<p id="maintenance_schedule_date"></p>
					</td>
				</tr>
			</table>
			<p class="title-section-todolist">Client Todo List</p>
			<table id="maintenance-todolist" class="dplan-table">
				<thead>
					<tr>
						<th>Task</th>
						<th>Priority</th>
						<th>Status</th>
						<th>Deadline</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<p id="table-status-message" style="display: none;"></p>
		<div class="maintenance_info_footer">	
			<!-- <div id="save_list_progress" class="button_1 pull-left">Save</div> -->
			<div id="done_maintenance_open_dialog" class="button_1 pull-left">Done Maintenance</div>
			<div style="display:none;" class="loader pull-left"></div>
		</div>
		</form>
	</div>
	<!-- POP-Up to confirm delete TodoList -->
	<div style="display:none;" class="confirm_delete_todolist" id="view_todolist" title="Delete List">
		<form class="" id="confirm_delete_form">
			<p class="label">
				Are you sure you want to delete <span class="listname"></span> list for <span class="clientname"></span>?
			</p>
			<input type="hidden" id="delete_row_list_id" value="">	
			<div  id="confirmed_delete_row" class="button_1 pull-right">Delete</div>
			<div  id="confirmed_delete_row_ok" style="display: none;" class="button_1 pull-right">OK</div>
			<div style="display: none;" class="loader pull-right"></div>
		</form>
	</div>

	<div style="display:none;" class="done_maintenance_dialog" id="done_maintenance_dialog" title="Confirm Done Maintenanace">
		<form class="" id="confirm_done_maintenance_dialog">
			<p class="">
				Are you sure you are done with the maintenance of <span class="clientname text-bold"></span>?
			</p>
			<!-- <p>Next maintenance schedule: <span id="next-maintenance-schedule"></p> -->
			<div  id="confirmed_next_maintenance_schedule" class="button_1 pull-right">Done</div>
			<div style="display: none;" class="loader pull-right"></div>
		</form>
	</div>
	<!-- POP-Up to confirm delete TodoList -->
	<div style="display:none;" class="complete_maintenance_dialog" id="complete_maintenance_dialog" title="Confirm Done Maintenanace">
		<form class="" id="confirm_complete_maintenance_dialog">
			<input type="hidden" id="complete_mainternance_id" name="">
			<p class="">
				Are you sure you are done with the maintenance of <span class="clientname text-bold"></span>?
			</p>
			<!-- <p>Next maintenance schedule: <span id="next-maintenance-schedule"></p> -->
			<div class="maintenance_info_footer">
				<div  id="cancel_client_maintenance_button" class="button_1 pull-right">Cancel</div>
				<div  id="complete_client_maintenance_button" class="button_1 pull-right">Done Maintenance</div>
				<div style="display: none;" class="loader pull-right"></div>
			</div>
		</form>
	</div>
	<script type="text/javascript">

		jQuery(document).on('click', '#complete_client_maintenance_button', function(){
			jQuery('#complete_maintenance_dialog .maintenance_info_footer .loader').show();
			var id = jQuery('#complete_mainternance_id').val();


			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'complete_maintenance',
					'data_id' : id				
				},
				success: function (data) {
					var parsed = jQuery.parseJSON(data);
					console.log(parsed);
					jQuery('#client-maintenance-table tr#'+parsed.client_id+' .edit_client_next_schedule_maintenance').text(parsed.client_next_schedule_maintenance).removeClass('date_passed');
					jQuery('#client-maintenance-table tr#'+parsed.client_id+' .hours').text(parsed.client_maintenance_hours);
					jQuery('#client-maintenance-table tr#'+parsed.client_id+' .schedule-interval').text(parsed.client_maintenance_schedule);
					jQuery('#table-status-message').text('Succesfully Updating Maintenanace Schedule!').fadeIn().delay(2000).fadeOut()
					jQuery('#complete_maintenance_dialog .maintenance_info_footer .loader').hide();
					jQuery('#complete_maintenance_dialog').dialog('close');
				},
				error: function (data) {
					
				}
			});				
		});

		//show dialog box for complete maintenance
		jQuery(document).on('click', '.complete_client_maintenance', function(){
			var client = jQuery(this).closest('tr').find('.clientname').text();
			var id = jQuery(this).closest('tr').attr('id');
			jQuery('#complete_mainternance_id').val(id);

			jQuery('#complete_maintenance_dialog .clientname').text(client);
			jQuery('#complete_maintenance_dialog').dialog('open');
		});

		jQuery(document).on('click', '#cancel_client_maintenance_button', function(){
			jQuery('#complete_maintenance_dialog').dialog('close');
		});
		jQuery(document).on('click', '#confirmed_next_maintenance_schedule', function(){
			var client_id = jQuery('#client_maintenance_info_id').val();
			var interval = jQuery('#client_maintenanace_intervat select').val();
			var hour = jQuery('#maintenance_hours_client input').val();
			var data = {
				'client_id' : client_id,
				'interval' : interval,
				'hour' : hour
			}
			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'done_maintenance_schedule',
					'data_object' : data				
				},
				success: function (data) {
					var parsed = jQuery.parseJSON(data);

					jQuery('#maintenance_schedule_date').text(parsed.client_next_schedule_maintenance);
					jQuery('#client-maintenance-table tr#'+parsed.client_id+' .edit_client_next_schedule_maintenance').text(parsed.client_next_schedule_maintenance).removeClass('date_passed');
					jQuery('#client-maintenance-table tr#'+parsed.client_id+' .hours').text(parsed.client_maintenance_hours);
					jQuery('#client-maintenance-table tr#'+parsed.client_id+' .schedule-interval').text(parsed.client_maintenance_schedule);
					jQuery('#table-status-message').text('Succesfully Updating Maintenanace Schedule!').fadeIn().delay(2000).fadeOut()
					jQuery('#done_maintenance_dialog').dialog('close');

				},
				error: function (data) {
	
				}
			});				
		});
		// function NextMaintenanceSchedule(date, next){
		// 	var myMonth = date[1];
		//     var myDay = date[2];
		//     var myYear = date[0];

		//     var joindate = new Date(myYear, myMonth, myDay);
		//     console.log(joindate);
		//     var numberOfDaysToAdd = 1;
		//     joindate.setDate(joindate.getDate() + 7);
		//     var dd = joindate.getDate();
		//     var mm = joindate.getMonth() + 1;
		//     var y = joindate.getFullYear();
		//     var joinFormattedDate =  y + "-" + mm + "-" + dd;
		//     console.log(joinFormattedDate);

    		// var combineDatestr = myYear + "/" + myMonth + "/" + myDay;
    		// var dt = new Date(combineDatestr);


	
    		// var day = 0;
    		// var month = 0;
   //  		var year = 0;
			// switch(next) {
			//     case '1W':
			// 			var next_date = dt.setDate(dt.getDate() + 7);
			//         break;
			//     case '2W':
		 //     		day = dt.getDay() + 15;
		 //     		month = dt.getMonth() + 1;
		 //     		year = dt.getFullYear();			      
			//         break;
			//     case '1M':
		 //     		day = dt.getDay() + 1;
		 //     		month = dt.getMonth() + 2;
		 //     		year = dt.getFullYear();	
			//     	break;
			//     case '2M':
		 //     		day = dt.getDay() + 1;
		 //     		month = dt.getMonth() + 3;
		 //     		year = dt.getFullYear();	
			//     	break;
			//     case '3M':
		 //     		day = dt.getDay() + 1;
		 //     		month = dt.getMonth() + 4;
		 //     		year = dt.getFullYear();	
			//     	break;
			//  	case '4M':
		 //     		day = dt.getDay() + 1;
		 //     		month = dt.getMonth() + 5;
		 //     		year = dt.getFullYear();	
			//  		break;
			//  	case '6M':
		 //     		day = dt.getDay() + 1;
		 //     		month = dt.getMonth() + 7;
		 //     		year = dt.getFullYear();
			//  		break;
			//     default:
			       //End Case
			// } 				
			       // console.log(next_date.getDay());
		// }
		jQuery( ".view_maintenance_popup" ).dialog({
			autoOpen: false,
			height: 530,
			width: 650,
			modal: true,
			close: function() {
			}
		});
		jQuery( ".maintenance_view_todolist" ).dialog({
			autoOpen: false,
			height: 530,
			width: 350,
			modal: true,
			close: function() {
			}
		});
		jQuery( ".confirm_delete_todolist" ).dialog({
			autoOpen: false,
			height: 180,
			width: 350,
			modal: true,
			close: function() {
			}
		});
		jQuery( ".done_maintenance_dialog" ).dialog({
			autoOpen: false,
			height: 180,
			width: 350,
			modal: true,
			close: function() {
			}
		});
		jQuery( ".complete_maintenance_dialog" ).dialog({
			autoOpen: false,
			height: 180,
			width: 350,
			modal: true,
			close: function() {
			}
		});
		jQuery(document).on('click', '#done_maintenance_open_dialog', function(){
			var clientname = jQuery('#maintenance_client').text();
			var current_schedule = jQuery('#maintenance_schedule_date').text();
			var schedule_interval = jQuery('#client_maintenanace_intervat select').val();

			var sptdate = String(current_schedule).split("-");

			jQuery('#confirm_done_maintenance_dialog p .clientname').text(clientname);
			jQuery('.done_maintenance_dialog').dialog('open');
		});
		//Delete Todo List on DB
		jQuery('#confirmed_delete_row').click(function(){
			var id = jQuery('#delete_row_list_id').val();
			jQuery('#confirmed_delete_row').fadeOut();
			jQuery('#confirm_delete_form .loader').delay(500).fadeIn();
			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'delete_todolist_row',
					'data_id' : id				
				},
				success: function (data) {
					var Todolist_info = jQuery.parseJSON(data);
					console.log(Todolist_info);
					jQuery('#confirm_delete_form .loader').fadeOut();
					jQuery('#confirmed_delete_row').delay(500).fadeIn();
					jQuery(".confirm_delete_todolist").dialog( "close" );
					jQuery('#table-status-message').text('Successufully Deleted A List!').fadeIn().delay(2000).fadeOut()
					jQuery('#maintenance-todolist tbody tr#'+Todolist_info.id).fadeOut(1000).delay(1000).remove();
				},
				error: function (data) {
					
				}
			});	

		});

		//SHow Delete todolist confirm dialog
		jQuery(document).on('click', '.maintenance-delete-todolist', function() {
			var row_id = jQuery(this).closest('tr').attr('id');

			
			var clientname = jQuery('#maintenance_client').text();
			var todolist_Name = jQuery('#maintenance-todolist tr#'+row_id+' td span.todolist_name_row').text();

			jQuery('#confirm_delete_form p span.listname').text(todolist_Name);
			jQuery('#confirm_delete_form p span.clientname').text(clientname);

			jQuery('#confirm_delete_form #delete_row_list_id').val(row_id);

			
			jQuery(".confirm_delete_todolist").dialog( "open" );
		});


		//Save the TodoList Progress
		jQuery(document).on('click', '#save_list_progress', function(){
			jQuery('.saving_todolist_progress').css('display', 'block');
			var todolist_form_data = jQuery('#todolist_view_form').serialize();

			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'save_todolist_progress',
					'data_object' : todolist_form_data				
				},
				success: function (data) {
					var Todolist_info = jQuery.parseJSON(data);
					jQuery('#manange-client-table table tr#'+Todolist_info.todolist_id+' span.todolist_status').text(Todolist_info.todolist_status);
					jQuery('#manange-client-table table tr#'+Todolist_info.todolist_id+' span.todolist_priority').text(Todolist_info.todolist_priority);
					jQuery('.saving_todolist_progress').css('display', 'none');
					jQuery('#message_saving_progress').fadeIn().delay(2000).fadeOut();
				},
				error: function (data) {
					
				}
			});	
		});

		//View Todolist full details dialog
		jQuery(document).on('click','.maintenance-view-todolist', function(){
			var row_id_string = jQuery(this).closest('tr').attr('id');
			var row_id = row_id_string.split('_')[2];

			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'get_todolist_info',
					'data_id' : row_id				
				},
				success: function (data) {
					var Todolist_info = jQuery.parseJSON(data);
					// var deadline = Todolist_info.deadline;
					if(Todolist_info.deadline == '1970-01-01' || Todolist_info.deadline == '0000-00-00'){
						var date = '--';
					}else{
						var date = Todolist_info.deadline;
					}
					jQuery('#todolist_id').val(Todolist_info.id)		
					jQuery('#todolist_name').text(Todolist_info.taskname);
					jQuery('#todolist_clientname').text(Todolist_info.client_name);
					jQuery('#todolist_consultant').text(Todolist_info.consultant_name);
					jQuery('#todolist_descriptions').text(Todolist_info.descriptions);
					jQuery('#todolist_priority').html(Todolist_info.priority_dropdown);
					jQuery('#todolist_status').html(Todolist_info.status_dropdown);
					jQuery('#todolist_deadline').html(date);
					jQuery('#task_subtasks').html(Todolist_info.list);
					jQuery("#maintenance_view_todolist").dialog( "open" );
					jQuery('.list_loader').css('display', 'none');
				},
				error: function (data) {
					
				}
			});	
			// jQuery('#maintenance_view_todolist').dialog('open');
		});

		//Initialize Datepicker
		jQuery('body').on('focus',".datepicker", function(){
			jQuery(this).datepicker({ dateFormat: 'yy-mm-dd', minDate: 0});
		});
		
		//view Maintenance Info Popup.
		jQuery(document).ready(function(){
			jQuery('.view_client_maintenance').on('click', function(){
				var row_id = jQuery(this).closest('tr').attr('id');
				var maintenance_table = jQuery('#maintenance-todolist');
				maintenance_table.dataTable().fnDestroy();
				var data = {
					'client_id' : row_id,
					'current_user_id' : <?php echo $current_user->ID; ?>
				}

				jQuery.ajax({
					type: "POST",
					url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
					data:{
						'type' : 'get_client_maitenance_info',
						'data_object' : data				
					},
					success: function (data) {
						var parsed = jQuery.parseJSON(data);
						jQuery('#client_maintenance_info_id').val(parsed.client_id);

						jQuery('#maintenance_client').text(parsed.clientname);
						jQuery('#client_maintenanace_intervat').html(parsed.client_maintenance_interval);
						jQuery('#maintenance_hours_client input').val(parsed.client_maintenance_hours);
						jQuery('#maintenance_schedule_date').text(parsed.client_next_schedule_maintenance);
						jQuery('#maintenance-todolist tbody').html(parsed.todolist_html_sting);
						//Initialize DataTables Pagination
						maintenance_table.DataTable({
							"searching": false,
				    		"ordering":  true,
				    		"pageLength": 10,
				    		"bLengthChange": false,
							"columnDefs": [
							   { orderable: false, targets: -1 }
							]
						});
						jQuery(".view_maintenance_popup").dialog( "open" );

					},
					error: function (data) {
						
					}
				});	


				
			});

			//show input for edit date
			jQuery('.edit_client_next_schedule_maintenance').on('dblclick', function(){
				var current_row = jQuery(this);
				var date = current_row.text();
				var d = new Date();
				var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
				date = (date == '--')? strDate : date;

				current_row.html('<input name="" readonly="" class="datepicker new_client_scheduled_date" value="'+date+'"><div class="pull-right edit_client_scheduled_date"></div><div style="display: none;" class="row-update-loader pull-right"></div>');
			});


			jQuery('body').on('click',".edit_client_scheduled_date", function(){
				var row_id = jQuery(this).closest('tr').attr('id');

				var new_date = jQuery('#'+row_id).find('.new_client_scheduled_date').val();
				jQuery('#'+row_id).find('.edit_client_scheduled_date').hide();
				jQuery('#'+row_id).find('.row-update-loader').show();

				var data = {
					'client_id' : row_id,
					'new_date' : new_date
				}

				jQuery.ajax({
					type: "POST",
					url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
					data:{
						'type' : 'client_maintenanace_update_date',
						'data_object' : data				
					},
					success: function (data) {
						var filter_data = jQuery.parseJSON(data);

					},
					error: function (data) {
						
					}
				});	


			});
		});
	</script>
<?php get_footer(); ?>