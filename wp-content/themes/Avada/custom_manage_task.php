<?php /* Template Name: Task */ ?>
<?php get_header(); ?>
<?php 
if(isset($_GET['deleteID'])) {
	$id = $_GET['deleteID'];	
	global $wpdb;	
	$table_name = $wpdb->prefix . "custom_task";
	
	$wpdb->query( "DELETE FROM {$table_name} WHERE ID = '$id'" ) ;
}
?>
<div class="projects">
	<a id="create_projects" class="button_1" href="<?php echo get_home_url(); ?>/manage-projects/task/add-task/">+ Add Task</a>
</div>
<div class="display_main tasks">
<?php 
	$table_name = $wpdb->prefix . "custom_task"; 
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name}");
?>
	
		<h2 class="display_title">Other tasks</h2>
		<p class="display_bg">Billable</p>
		<?php 
		foreach($tasks as $task){ 
			if( $task->task_billable == 1){
		?>
			<div class="display_section delete_ajax_<?php echo $task->ID; ?>">
			<!--	<div class="display_list" onclick="window.open('/task-information/?id=<?php // echo $task->ID ?>');"> -->
			<div class="display_list"> 
					<a class="button_2 display_button" href="<?php echo get_home_url(); ?>/manage-projects/task/edit-task/?id=<?php echo $task->ID ?>">Edit</a>
					<h3 id="name_<?php echo $task->ID; ?>" class="display_subtitle"><?php echo $task->task_name; ?></h3>					
				</div>
				<div class="ajax_action_buttons">
					<div id="delete_task_<?php echo $task->ID; ?>" class="button_2 display_button float_right delete_task_button delete_ajax">Delete</div>
				</div>
				<div class="display_separator"></div>
			</div>
			<?php } ?>			
		<?php }?>
			<p class="display_bg">Non-billable by default</p>
			<?php 
				foreach($tasks as $task){ 
					if( $task->task_billable == 0){
			?>
				<div class="display_section delete_ajax_<?php echo $task->ID; ?>">
					<div class="display_list" onclick="window.open('<?php echo get_home_url(); ?>/task-information/?id=<?php echo $task->ID ?>');">
						<a class="button_2 display_button" href="<?php echo get_home_url(); ?>/edit-task/?id=<?php echo $task->ID ?>">Edit</a>
						<h3 id="name_<?php echo $task->ID; ?>" class="display_subtitle"><?php echo $task->task_name; ?></h3>						
					</div>
					<div class="ajax_action_buttons">
						<div id="delete_task_<?php echo $task->ID; ?>" class="button_2 display_button float_right delete_task_button delete_ajax">Delete</div>
					</div>
					<div class="display_separator"></div>
				</div>
			<?php } ?>			
		<?php } ?>
	
</div>
<div style="display:none;" class="dialog_form_delete_ajax" id="dialog_form_delete_task" title="Delete Task">
	<form class="delete_action_ajax" id="delete_task">
		<p class="label">
			Are you sure you want to delete 
			<span class="delete_name"></span>
			<span style="display:none;" class="delete_prep">from</span>
			<span style="display:none;" class="delete_parent"></span>
		</p>	
		<div class="button_1 delete_button_ajax">Delete</div>
		<div style="display:none" class="loader delete_ajax_loader"></div>
		<input type="hidden" class="delete_id" name="delete_id" />
		<input type="hidden" class="delete_type" name="delete_type" value="Task" />		
	</form>
</div>
<?php get_footer(); ?>