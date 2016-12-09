<?php /* Template name: Edit Todo Task */ ?>
<?php get_header(); ?>
<?php 
	// $user_id = get_current_user_id();
	$client_tablename = $wpdb->prefix . "custom_client";
	$todolist_tablename = $wpdb->prefix . "custom_client_todo_lists";
	$todolist_id = $_GET['id'];
	$consultant_tablename = $wpdb->prefix . "custom_person";
	$clients = $wpdb->get_results("SELECT * FROM {$client_tablename} ORDER BY client_name ASC");
	$consultants = $wpdb->get_results("SELECT * FROM {$consultant_tablename} ORDER BY person_fullname ASC");
	$todolist_info = $wpdb->get_row("SELECT * FROM {$todolist_tablename} WHERE id=".$todolist_id);

	$priorities_array = array('1 Urgent', '2 Asap', '3 Next visit');
	$status_array = array('Todo', 'Started', 'Completed');

	$sub_tasks = unserialize($todolist_info->task_checkboxes);

	// print_r($);

?>
<div class="add_client">
<?php 
	$array_subtasks = array();
	foreach($sub_tasks as $key => $value){
		array_push($array_subtasks, array_keys($sub_tasks[$key])[0]);
	}
 ?>
	<form action="" method="post" name="update_todo_list_form" id="update_todo_list_form">
		<div class="section">
			<div class="left">
				<p class="label">Task</p>
			</div>
			<div class="right">
				<input type="text" id="taskname" class="taskname" name="taskname" value="<?php echo $todolist_info->taskname; ?>" />
				<input type="hidden" id="todolist_id" class="todolist_id" name="todolist_id" value="<?php echo $todolist_id; ?>" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Client</p>
			</div>
			<div class="right select_client_wrapper">
				<select type="text" id="selected_clients" class="clients multipleSelect" multiple  name="client_ids[]" >
					<?php foreach($clients as $client){ ?>
						<?php $selected = ($client->ID == $todolist_info->client_id)? 'selected="selected"' : ''; ?>
						<option <?php echo $selected; ?> value="<?php echo $client->ID; ?>"><?php echo $client->client_name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Consultant</p>
			</div>
			<div class="right">
				<select type="text" class="task_consultant form_width_dropdown" name="task_consultant_id">
					<option value="0">Any</option>
					<?php foreach($consultants as $consultant){ 
						$selected = ($todolist_info->consultant_id == $consultant->wp_user_id)? 'selected="selected"' : '';
					?>

						<option <?php echo $selected; ?> value="<?php echo $consultant->wp_user_id; ?>"><?php echo $consultant->person_fullname; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Priority</p>
			</div>
			<div class="right">
				<select type="text" class="todolist_priority form_width_dropdown"  name="task_priority">
					<?php 
						foreach($priorities_array as $key => $value){
							$selected = ($value == $todolist_info->priority)? 'selected="selected"' : '';
							echo '<option '.$selected.' value="'.$value.'">'.$value.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Status</p>
			</div>
			<div class="right">
				<select type="text" class="todolist_status form_width_dropdown"  name="task_status">
					<?php 
						foreach($status_array as $key => $value){
							$selected = ($value == $todolist_info->status)? 'selected="selected"' : '';
							echo '<option '.$selected.' value="'.$value.'">'.$value.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Deadline</p>
			</div>
			<div class="right">
				<?php 
					if($todolist_info->deadline != '0000-00-00'){
						$dealine = $todolist_info->deadline;
						$disabled = '';
						$checked = 'checked="checked"';
					}else{
						$dealine = '';
						$disabled = 'disabled="disabled"';
						$checked = '';
					}
				?>
				<input type="text" id="deadline" class="deadline datepicker" name="task_deadline" <?php echo $disabled; ?> value="<?php echo $dealine; ?>"  readonly />
				<input type="checkbox" name="deadline_checkbox" <?php echo $checked; ?> id="deadline_checkbox"><label for="deadline_checkbox">Enable Deadline</label>
			</div>
		</div>
		<div class="border_separator"></div>		
		<div class="section">
			<div class="left">
				<p class="label">Description</p>
			</div>
			<div class="right">
				<textarea name="task_description" class="task_description textarea_wide"><?php echo $todolist_info->descriptions; ?></textarea>
			</div>
		</div>
		<div class="border_separator"></div>		
		<div class="section">
			<div class="left">
				<p class="label">Subtasks<br />(<em>separated by comma</em>)</p>
			</div>
			<div class="right">
				<textarea name="task_checkboxes" class="task_checkboxes textarea_wide"><?php echo implode(', ', $array_subtasks); ?></textarea>
			</div>
		</div>
		<div class="border_separator"></div>
		<input type="submit" name="submit" class="button_1" value="Update Task" />
		<a class="button_2" href="<?php echo get_site_url(); ?>/todo-list/">Cancel</a>
		<div class="list_loader" style="display: none;"></div>
	</form>
	<p id="addedlist" class="message" style="display: none;">Updated Added New Todo List.</p>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		//Disable and Enable Deadine Date
		jQuery('#deadline_checkbox').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('#deadline').prop("disabled", false);
				jQuery('#deadline').datepicker({dateFormat:"yyyy-mm-dd"}).datepicker("setDate",new Date());
			}else{
				jQuery('#deadline').prop("disabled", true);
				jQuery('#deadline').val('');
			}
		});
		//Initialize Fastselect for multiple clients.
		var Client_multipleselect = jQuery('.multipleSelect');
		Client_multipleselect.fastselect({placeholder: 'Select Clients'});

		//Form Submit
		jQuery( "#update_todo_list_form" ).submit(function( event ) {
		 	event.preventDefault();
			var taskname = jQuery('#taskname').val();
			var clients = jQuery('#selected_clients').val();
			if(taskname == '' ||  taskname == null ){
				jQuery('#taskname').addClass('input-error').focus();
				return false;
			}else{
				jQuery('#taskname').removeClass('input-error');
			}
			if(clients == '' ||  clients == null ){
				jQuery('.select_client_wrapper div.fstMultipleMode').addClass('input-error').focus();
				return false;
			}else{
				jQuery('.select_client_wrapper div.fstMultipleMode').removeClass('input-error');
			}
			//Show loading Icon
			jQuery('.list_loader').css("display", 'inline-block');
			var FormData = jQuery(this).serialize();

			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'update_client_todolist',
					'data_object' : FormData
				},
				success: function (data) {
					var Todolist_info = jQuery.parseJSON(data);
					jQuery('#update_todo_list_form')[0].reset();
					jQuery('#taskname').removeClass('input-error');
					jQuery('.list_loader').css("display", 'none');
					jQuery('#addedlist').fadeIn().delay(2000).fadeOut();
				},
				error: function (data) {
					alert('error');
				}				
			});		
		});		
	});
</script>
<?php get_footer(); ?>