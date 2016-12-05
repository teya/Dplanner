<?php /* Template name: Add Task */ ?>
<?php get_header(); ?>
<?php
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_task";
?>
<div class="add_task">
	<form action="" method="post" name="task" id="task">
		<div class="section">
			<div class="left">
				<p class="label">Task Name</p>
			</div>
			<div class="right">
				<input type="text" placeholder="New task name" name="task_name" />
			</div>
		</div>
<!-- 		<div class="section">
			<div class="left">
				<p class="label">Hourly Rate</p>
			</div>
			<div class="right">
				<input type="text" name="hourly_rate" />
			</div>
		</div> -->
		<div class="section">
			<div class="left">
				<p class="label">Billing</p>
			</div>
			<div class="right">
				<label><input type="checkbox" name="task_billable" value="1" class="checkbox" checked>Billable</label>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Description</p>
			</div>
			<div class="right">
				<textarea name="task_description" class="task_description textarea_wide"></textarea>
			</div>
		</div>
		<input type="submit" name="submit" class="button_1" value="Add Task" />
		<a class="button_2" href="<?php echo get_home_url(); ?>/manage-projects/task">Cancel</a>
	</form>
</div>
<?php 
if(isset($_POST['submit'])):
	global $wpdb;	
	
	$task_name		=  (isset($_POST['task_name']) ? $_POST['task_name'] : '');
	// $hourly_rate		= (isset($_POST['hourly_rate']) ? $_POST['hourly_rate'] : '');
	$task_billable	=  (isset($_POST['task_billable']) ? $_POST['task_billable'] : 0);	
	$task_description	= (isset($_POST['task_description']) ? $_POST['task_description'] : '');

	$insert = $wpdb->insert( $table_name , array( 
	'task_name'			=> $task_name,
	// 'hourly_rate'			=> $hourly_rate,
	'task_billable'		=> $task_billable,
	'task_description'		=> $task_description
	), array( '%s', '%s','%s', '%s' ));

	// $wpdb->show_errors();
	// $wpdb->print_error();
	
	if($insert == 1):
		echo "<p class='message'>";
		echo "Task Added!";
	else:
		echo "Task was not successfully added.";
		echo "</p>";
	endif;		
endif;
?>
<?php get_footer(); ?>