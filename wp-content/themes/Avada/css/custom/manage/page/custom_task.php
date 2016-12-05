<?php /* Template Name: Task */ ?>
<?php get_header(); ?>
<div class="projects">
	<a id="create_projects" class="button_1" href="/add-task/">+ Add Task</a>
</div>
<div class="display_main">
<?php 
	$table_name = $wpdb->prefix . "custom_task"; 
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name}");
?>
	<div class="display_section">
		<h2 class="display_title">Other tasks</h2>
		<p class="display_bg">Billable by default</p>
		<?php 
		foreach($tasks as $task): 
			if( $task->task_billable == 1):
		?>
			<div class="display_list">
				<a class="button_2 display_button" href="/edit-task/?id=<?php echo $task->ID ?>">Edit</a>
				<h3 class="display_subtitle"><?php echo $task->task_name; ?></h3>
			</div>
			<div class="display_separator"></div>			
			<?php endif; ?>
		<?php endforeach; ?>
		<p class="display_bg">Non-billable by default</p>
		<?php 
			foreach($tasks as $task): 
			if( $task->task_billable == 0):
		?>
		<div class="display_list">
			<a class="button_2 display_button" href="#">Edit</a>
			<h3 class="display_subtitle"><?php echo $task->task_name; ?></h3>
		</div>
		<div class="display_separator"></div>			
		<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>
<?php get_footer(); ?>