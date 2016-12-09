<?php /* Template Name: Todo Lists */ 
	if (!is_user_logged_in()) {
	    wp_redirect( wp_login_url( $redirect ) );
	    exit();
	}
?>
<?php get_header(); ?>
<?php 

	$user_id = get_current_user_id();
	$client_tablename = $wpdb->prefix . "custom_client";
	$client_todolist_tablename = $wpdb->prefix . "custom_client_todo_lists";
	$consultant_tablename = $wpdb->prefix . "custom_person";
	$clients = $wpdb->get_results("SELECT * FROM {$client_todolist_tablename} WHERE consultant_id = ". $user_id . " OR consultant_id = 0");
	$ids = array();
	$consultant_ids = array();

	$client_list = $wpdb->get_results('SELECT DISTINCT client_id, consultant_id FROM '.$client_todolist_tablename);
	if(count($client_list) != 0){
		foreach($client_list as $obj){ 
			array_push($ids, $obj->client_id);
			array_push($consultant_ids, $obj->consultant_id);
		}

		$id_strings = implode(',', $ids);
		$client_ids_string = implode(',', $consultant_ids);
		$dropdown_clients = $wpdb->get_results("SELECT ID, client_name FROM ".$client_tablename." WHERE ID in ({$id_strings})");
		$dropdown_consultants = $wpdb->get_results("SELECT wp_user_id, person_fullname, person_initial FROM ".$consultant_tablename." WHERE wp_user_id in ({$client_ids_string})");			
	}
?>
<div class="clients">
	<p id="table-status-message" style="display: none;"></p>
	<a id="create_clients" class="button_1" href="<?php echo get_home_url();  ?>/add-task/">+ Add Task</a>
	<div class="list_loader" style="display: none;"></div>
	<div class="pull-right">
		<p>
			Client
			<select name="select_client" id="filter_select_client" class="todolist_filter">
				<option value="0">Any</option>
				<?php
					foreach ($dropdown_clients as $dropdown_client) {
						echo '<option value="'.$dropdown_client->ID.'">'.$dropdown_client->client_name.'</option>';
					}
				?>
			</select>
			Consultant
			<select name="filter_select_consultant" id="filter_select_consultant" class="todolist_filter">
				<option value="0">Any</option>
				<?php
					if(count($dropdown_consultants) != 0){
						foreach ($dropdown_consultants as $consultant) {
							echo '<option value="'.$consultant->wp_user_id.'">'.$consultant->person_initial.'</option>';
						}
					} 
				?>
			</select>
			Priority
			<select name="filter_task_priority" id="filter_task_priority" class="todolist_filter">
				<option value="Any">Any</option>
				<option value="1 Urgent">Urgent</option>
				<option value="2 Asap">Asap</option>
				<option value="3 Next visit">Next Visit</option>
			</select>			
		</p>
	</div>
</div>
<div  id="manange-client-table"  class="display_main">
	<table class="list_table">
		<thead>
			<td>Client</td>
			<td>Task</td>
			<td>Consultant</td>
			<td>Priority</td>
			<td>Status</td>
			<td>Deadline</td>
			<td></td>
		</thead>
	<?php
		if(!empty($clients)){
		foreach ($clients as $client){
				$client_info = $wpdb->get_row("SELECT * FROM ".$client_tablename." WHERE ID = ". $client->client_id);
				if($client->consultant_id == 0){
					$consultant_initials = 'Any';
					$consultant_id = 0;
				}else{
					$consultant_info = $wpdb->get_row("SELECT * FROM ".$consultant_tablename." WHERE wp_user_id = ". $client->consultant_id);
					$name = explode(" ", $consultant_info->person_fullname);
					$consultant_initials = '';
					foreach ($name as $w) {
  						$consultant_initials .= strtoupper($w[0]);
					}
					// $consultant_name = $consultant_info->person_fullname;
					$consultant_id = $client->consultant_id;
				}
	?>
			<tr id="<?php echo $client->id; ?>">
				<td><span class="clientname"><?php echo $client_info->client_name;  ?></span></td> 
				<td><span class="todolist_name_row"><?php echo $client->taskname;  ?></span></td>
				<td><span class="todolist_consultant"><input type="hidden" class="consultant_id_row" value="<?php echo $consultant_id; ?>"><?php echo $consultant_initials; ?></span></td>
				<td><span class="todolist_priority"><?php echo $client->priority ?></span></td>
				<td><span class="todolist_status"><?php echo $client->status ?></span></td>
				<td><span class="todolist_deadline"><?php echo ($client->deadline == '1970-01-01' || $client->deadline == '0000-00-00')? '--' : $client->deadline; ?></span></td>
				<td>
					<!-- <a class="button_2 display_button pull-right delete_todolist_row">Delete</a> -->
					<!-- <a class="button_2 display_button pull-right view_list_button">View Task</a> -->
					<div class="option-list">
						<i class="fa fa-trash-o delete_todolist_row pull-right" aria-hidden="true" title="Delete Task"></i>
						<i class="fa fa-eye view_list_button pull-right" aria-hidden="true" title="View Task"></i>
					</div>
				</td>
			</tr>
	<?php 
		}//END CLIENT FOREACH LOOP
	}else{
	?>
		<tr><td colspan="6">No Currently List Available.</td></tr>

	<?php
	}
	?>

	</table>
</div>
<!-- POP-UP to view TOdo List -->
<div style="display:none;" class="view_todolist" id="view_todolist" title="View List">
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
		<div id="save_list_progress" class="button_1 pull-left">Save</div>
		<!-- <div class="button_1 pull-left">Edit</div> -->
		<div style="display:none;" class="loader saving_todolist_progress pull-left"></div>
	</form>
	<p id="message_saving_progress" class="message" style="display: none;">Successfully updating Todo list.</p>
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
<script type="text/javascript">
	jQuery(document).ready(function(){

		jQuery('#manange-client-table .list_table').DataTable({
			"searching": false,
    		"ordering":  false,
    		"pageLength": 10,
    		"bLengthChange": false
		});

		//Todolist filter
		jQuery('.todolist_filter').on('change', function() {

			var rows = jQuery('#manange-client-table .list_table tbody tr');
			jQuery('#manange-client-table .list_table').dataTable().fnDestroy();
			rows.fadeOut(300, function() { jQuery(this).parent().html('<tr><td colspan="7"><div class="loading-table"></div></td></tr>').fadeIn(2000); } );
			// jQuery('#manange-client-table .list_table tbody').delay(6000).html('<tr><td>LOADING<td></tr>');
			var client_id = jQuery('#filter_select_client').val();
			var consultant_id = jQuery('#filter_select_consultant').val();
			var task_priority = jQuery('#filter_task_priority').val();

			var filter_data = {
				'client_id' : client_id,
				'consultant_id' : consultant_id,
				'task_priority' : task_priority
			};

			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'filter_todolist_table',
					'data_object' : filter_data				
				},
				success: function (data) {
					var filter_data = jQuery.parseJSON(data);
					// console.log(filter_data.list_data);
					jQuery('#manange-client-table .list_table tbody').html(filter_data.list_data).css('display', 'none').fadeIn(300);

					jQuery('#manange-client-table .list_table').DataTable({
						"searching": false,
			    		"ordering":  false,
			    		"pageLength": 10,
			    		"bLengthChange": false
					});


				},
				error: function (data) {
					
				}
			});	

		});
		//Initialize Datepicker
		jQuery('body').on('focus',".datepicker", function(){
			jQuery(this).datepicker({ dateFormat: 'yy-mm-dd' });
		});
		jQuery('body').on('dblclick', '.todolist_deadline', function() {
			var row_id = jQuery(this).closest('tr').attr('id');
			var string_value = jQuery(this).text();
			var updating_row_active = jQuery(this).hasClass('updating_row_active');

			if(updating_row_active == true){
				return false;
			}else{
				jQuery(this).addClass('updating_row_active');
			}

			if(string_value == '--'){
				var date = '';
				var disable = 'disabled="disabled"';
				var checked = ''
			}else{
				var date = string_value;
				var disable = '';
				var checked = 'checked'
			}
			var deadline_html = '<input name="todolist_dealine" '+disable+' class="datepicker todolist_dealine" readonly value="'+date+'"><input type="checkbox" name="enable-deadline" '+checked+' class="enable-deadline"><div class="update_todolist_row update_todolist_deadline_row pull-right"></div><div style="display: none;" class="row-update-loader pull-right">';
			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_deadline').html(deadline_html);
		});

		//Disable and Enable Deadine Date
		jQuery('body').on('click', '.enable-deadline', function() {
			var row_id = jQuery(this).closest('tr').attr('id');

			if(jQuery(this).is(':checked')){
				jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_deadline .datepicker').prop("disabled", false).datepicker({dateFormat:"yy-mm-dd"}).datepicker("setDate",new Date());
			}else{
				jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_deadline .datepicker').prop("disabled", true).val('');
				// jQuery('#deadline').val('');
			}
		});

		// update_todolist_deadline_row
		jQuery('body').on('click', '.update_todolist_deadline_row', function() {
			var row_id = jQuery(this).closest('tr').attr('id');
			var date = jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_deadline .datepicker').val();
	
			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_deadline .update_todolist_deadline_row').hide();
			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_deadline .row-update-loader').show();

			var data_object = {
				'row_id' : row_id,
				'deadline' : date
			};

			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'update_todolist_deadline',
					'data_object' : data_object				
				},
				success: function (data) {
					var Todolist_info = jQuery.parseJSON(data);
					console.log(Todolist_info);
					if(Todolist_info.deadline == '0000-00-00'){
						Todolist_info.deadline = '--';
					}
					jQuery('#manange-client-table .list_table tr#'+Todolist_info.row_id+' td .todolist_deadline').html('').text(Todolist_info.deadline).removeClass('updating_row_active');
					// todolist_consultant
					// jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_consultant').html(Todolist_info.dropdown_consultant);
				},
				error: function (data) {
					
				}
			});	

		});

		//Show Dropdown Colsultant on row to edit.
		jQuery('body').on('dblclick', '.todolist_consultant', function() {
			var row_id = jQuery(this).closest('tr').attr('id');
			var consultant_id = jQuery(this).find('input.consultant_id_row').val();

			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'get_consultants_dropdown_list',
					'data_id' : consultant_id				
				},
				success: function (data) {
					var Todolist_info = jQuery.parseJSON(data);
					// todolist_consultant
					jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_consultant').html(Todolist_info.dropdown_consultant);
				},
				error: function (data) {
					
				}
			});	

		});

		//Updating Consultant for Todolist
		jQuery('body').on('click', '.update_todolist_row_consultant', function() {
			var row_id = jQuery(this).closest('tr').attr('id');
			var consultant_id = jQuery('#default_consultant_id').val();

			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_consultant .update_todolist_row').hide();
			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_consultant .row-update-loader').show();

			var data_object = {
				'row_id' : row_id,
				'consultant_id' : consultant_id
			};

			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'updating_default_consultant_todolist',
					'data_object' : data_object				
				},
				success: function (data) {
					var Todolist_info = jQuery.parseJSON(data);
					jQuery('#manange-client-table table.list_table tr#'+Todolist_info.row_id+' span.todolist_consultant').html('<input class="consultant_id_row" value="'+Todolist_info.consultant_id+'" type="hidden">'+Todolist_info.consultant_name);
				},
				error: function (data) {
					
				}
			});	

		});

		//SHow Delete confirm dialog
		jQuery('body').on('click', '.delete_todolist_row', function() {
			var row_id = jQuery(this).closest('tr').attr('id');
			var clientname = jQuery('#manange-client-table .list_table tr#'+row_id+' td span.clientname').text();
			var todolist_Name = jQuery('#manange-client-table .list_table tr#'+row_id+' td span.todolist_name_row').text();

			jQuery('#confirm_delete_form p span.listname').text(todolist_Name);
			jQuery('#confirm_delete_form p span.clientname').text(clientname);

			jQuery('#confirm_delete_form #delete_row_list_id').val(row_id);

			
			jQuery(".confirm_delete_todolist").dialog( "open" );
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
					jQuery('table-status-message')
					jQuery('#confirmed_delete_row').delay(500).fadeIn();
					jQuery(".confirm_delete_todolist").dialog( "close" );
					jQuery('#table-status-message').text('Successufully Deleted A List!').fadeIn().delay(2000).fadeOut()
					jQuery('#manange-client-table .list_table tr#'+Todolist_info.id).fadeOut(1000).delay(1000).remove();
				},
				error: function (data) {
					
				}
			});	

		});

		//Get TodoList Data to View.
		jQuery('body').on('click', '.view_list_button', function(){
			jQuery('.list_loader').css('display', 'inline-block');

			var row_id = jQuery(this).closest('tr').attr('id');

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
					jQuery(".view_todolist").dialog( "open" );
					jQuery('.list_loader').css('display', 'none');
				},
				error: function (data) {
					
				}
			});	
			
		});	
		jQuery( ".view_todolist" ).dialog({
			autoOpen: false,
			height: 400,
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

		//Save the TodoList Progress
		jQuery('#save_list_progress').click(function(){
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
					jQuery('#manange-client-table table.list_table tr#'+Todolist_info.todolist_id+' span.todolist_status').text(Todolist_info.todolist_status);
					jQuery('#manange-client-table table.list_table tr#'+Todolist_info.todolist_id+' span.todolist_priority').text(Todolist_info.todolist_priority);
					jQuery('.saving_todolist_progress').css('display', 'none');
					jQuery('#message_saving_progress').fadeIn().delay(2000).fadeOut();
				},
				error: function (data) {
					
				}
			});	
		});

		//Show Taskname input field
		jQuery('body').on('dblclick', '.todolist_name_row', function() {
			var updating_row_active = jQuery(this).hasClass('updating_row_active');
	
			if(updating_row_active == true){
				return false;
			}else{
				jQuery(this).addClass('updating_row_active');
			}

			var row_id = jQuery(this).closest('tr').attr('id');
  			var string_value = jQuery(this).text();

  			var dropdown_html = "<input class='todolist_name_row' type='text' value='"+string_value+"'><div class='update_todolist_row update_todolist_taskname_row pull-right'></div><div style='display: none;' class='row-update-loader pull-right'></div>";
  			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_name_row').html(dropdown_html);
		});

		//Updating taskname on DB
		jQuery('body').on('click', '.update_todolist_taskname_row', function() {
			var row_id = jQuery(this).closest('tr').attr('id');
			var value = jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_name_row input').val();

			if(value == ''){
				jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_name_row input').addClass('input-error').focus();
				return false;
			}
			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_name_row .update_todolist_row').hide();
			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_name_row .row-update-loader').show();

			var todolist_form_data = {
				'value' : value,
				'type' : 'taskname',
				'id' : row_id
			};

			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'update_todolist_row_status',
					'data_object' : todolist_form_data
				},
				success: function (data) {
					var update_info = jQuery.parseJSON(data);
					jQuery('#manange-client-table .list_table tr#'+update_info.id+' td .todolist_name_row').removeClass('updating_row_active').html('').text(update_info.value);

				},
				error: function (data) {
					
				}
			});	
		});

		//show dropdown Priority for updating Priority status on row.
		jQuery('body').on('dblclick', '.todolist_status', function() {
  			var row_id = jQuery(this).closest('tr').attr('id');
  			var string_value = jQuery(this).text();
  			
  			var status_array = ['Todo', 'Started', 'Completed'];

  			var dropdown_html = "";
  			var selected = "";
  			dropdown_html = "<select class='row_change_status' name='row_change_status'>";
  			jQuery.each(status_array, function(key, value) {
  				selected = (value == string_value)? "selected='selected'" : '';
  				dropdown_html += "<option " + selected + " value='"+value+"'>"+value+"</option>";
			});
			dropdown_html += "</select><div class='update_todolist_row update_todolist_row_status'></div><div style='display: none;' class='row-update-loader pull-right'></div>";

			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_status').html(dropdown_html);
		});

		//show dropdown Priority for updating Priority status on row.
		jQuery('body').on('dblclick', '.todolist_priority', function() {
  			var row_id = jQuery(this).closest('tr').attr('id');
  			var string_value = jQuery(this).text();
  			
  			var priority_array = ['1 Urgent', '2 Asap', '3 Next visit'];

  			var dropdown_html = "";
  			var selected = "";
  			dropdown_html = "<select class='row_change_priority' name='row_change_priority'>";
  			jQuery.each(priority_array, function(key, value) {
  				selected = (value == string_value)? "selected='selected'" : '';
  				dropdown_html += "<option " + selected + " value='"+value+"'>"+value+"</option>";
			});
			dropdown_html += "</select><div class='update_todolist_row update_todolist_row_priority'></div><div style='display: none;' class='row-update-loader pull-right'></div>";

			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_priority').html(dropdown_html);
		});

		//Updating Priority status on row.
		jQuery('body').on('click', '.update_todolist_row_priority', function() {
			var row_id = jQuery(this).closest('tr').attr('id');
			var value = jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_priority select').val();
			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_priority .update_todolist_row').hide();
			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_priority .row-update-loader').show();

			var todolist_form_data = {
				'value' : value,
				'type' : 'priority',
				'id' : row_id
			};

			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'update_todolist_row_status',
					'data_object' : todolist_form_data
				},
				success: function (data) {
					var update_info = jQuery.parseJSON(data);
					jQuery('#manange-client-table .list_table tr#'+update_info.id+' td .todolist_priority').html('').text(update_info.value);
				},
				error: function (data) {
					
				}
			});	
		});

		//Updating status on row.
		jQuery('body').on('click', '.update_todolist_row_status', function() {
			var row_id = jQuery(this).closest('tr').attr('id');
			var value = jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_status select').val();


			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_status .update_todolist_row').hide();
			jQuery('#manange-client-table .list_table tr#'+row_id+' td .todolist_status .row-update-loader').show();

			var todolist_form_data = {
				'value' : value,
				'type' : 'status',
				'id' : row_id
			};

			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'update_todolist_row_status',
					'data_object' : todolist_form_data
				},
				success: function (data) {
					var update_info = jQuery.parseJSON(data);
					jQuery('#manange-client-table .list_table tr#'+update_info.id+' td .todolist_status').html('').text(update_info.value);
				},
				error: function (data) {
					
				}
			});	
		});
	});
</script>
<?php get_footer(); ?>