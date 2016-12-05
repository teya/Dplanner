<?php /* Template name: Task Information */ ?>
<?php get_header(); ?>
<?php
$id = $_GET['id'];
$table_name = $wpdb->prefix . "custom_task"; 
$task = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = '$id'");
?>
<div class="info_task">
	<div class="section">
		<div class="left">
			<p class="label">Task Name</p>
		</div>
		<div class="right">
			<p><?php echo $task->task_name; ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">URL</p>
		</div>
		<div class="right">
			<p><?php echo $task->task_url; ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">Billing</p>
		</div>
		<div class="right">
			<p><?php echo ($task->task_billable == 1) ? 'Billable' : 'Non Billable'; ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">Description</p>
		</div>
		<div class="right">
			<p><?php echo $task->task_description; ?></p>
		</div>
	</div>
	<a class="button_2 display_button" href="/task/">Return</a>
	<a id="create_projects" class="button_1 display_button padding_button" href="/add-task/">+ Add Task</a>
	<a class="button_2 display_button" href="/edit-task/?editID=<?php echo $task->ID ?>">Edit</a>
	<a class="button_2 display_button confirm" href="/task/?deleteID=<?php echo $task->ID ?>">Delete</a>
</div>
<?php get_footer(); ?>