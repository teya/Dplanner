<?php /* Template Name: Edit Task */ ?>
<?php get_header(); ?>
<?php
global $wpdb;
$id = $_GET['id'];
$table_name = $wpdb->prefix . "custom_task";
?>
<?php
if(isset($_POST['submit'])):	
	$task_name			= $_POST['task_name'];
	// $hourly_rate		= $_POST['hourly_rate'];
	$task_billable		= $_POST['task_billable'];
	if(isset($_POST['task_billable'])):
	$task_billable = $_POST['task_billable'];
	else:
	$task_billable = 0;
	endif;
	$task_description	= $_POST['task_description'];
	
	$table_array = 
	$update = $wpdb->update( $table_name , array( 
	'task_name'			=> $task_name,
	// 'hourly_rate'		=> $hourly_rate,
	'task_billable'		=> $task_billable,
	'task_description'	=> $task_description
	),
	array( 'ID' => $id ),
	array( '%s', '%s' ));	
	if($update == 1):
		echo "<p class='message'>";
		echo "Task Updated!";
		echo "</p>";
	else:
		echo "<p class='message'>";
		echo "Task was not successfully Updated.";
		echo "</p>";
	endif;	
endif;

$results_edit = $wpdb->get_row("SELECT * FROM $table_name WHERE ID=$id");
?>
<div class="edit_task">
	<form action="" method="post" name="task" id="task">
		<div class="section">
			<div class="left">
				<p class="label">Task Name</p>
			</div>
			<div class="right">
				<input type="text" placeholder="New task name" name="task_name" value="<?php echo (isset($results_edit->task_name)) ? $results_edit->task_name : '';  ?>"/>
			</div>
		</div>
<!-- 		<div class="section">
			<div class="left">
				<p class="label">Hourly rate</p>
			</div>
			<div class="right">
				<input type="text" name="hourly_rate" value="<?php // echo (isset($results_edit->hourly_rate)) ? $results_edit->hourly_rate : '';  ?>"/>
			</div>
		</div> -->
		<div class="section">
			<div class="left">
				<p class="label">Billing</p>
			</div>
			<div class="right">
				<label><input type="checkbox" name="task_billable" value="<?php echo (isset($results_edit->task_billable)) ? $results_edit->task_billable : '';  ?>" <?php echo $results_edit->task_billable == 1 ? 'checked' : ''; ?> class="checkbox">Billable</label>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Description</p>
			</div>
			<div class="right">
				<textarea name="task_description" class="task_description textarea_wide"><?php echo (isset($results_edit->task_description)) ? $results_edit->task_description : '';  ?></textarea>
			</div>
		</div>
		<input type="submit" name="submit" class="add_task button_1" value="Update" />
		<a class="button_2" href="<?php echo get_home_url(); ?>/manage-projects/task/">Cancel</a>
	</form>
</div>
<?php get_footer(); ?>