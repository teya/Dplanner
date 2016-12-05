<?php /* Template Name: Department */ ?>
<?php get_header(); ?>
<?php 
if(isset($_GET['deleteID'])) {
	$id = $_GET['deleteID'];	
	global $wpdb;	
	$table_name = $wpdb->prefix . "custom_department";
	
	$wpdb->query( "DELETE FROM {$table_name} WHERE ID = '$id'" ) ;
}
?>
<div class="departments">
	<a id="create_department" class="button_1 wide_button" href="/add-department/">+ Add Department</a>
</div>
<div class="display_main departments">
	<?php 
		$table_name = $wpdb->prefix . "custom_department"; 
		$departments = $wpdb->get_results("SELECT * FROM {$table_name}");
	?>	
	<h2 class="display_title">Department</h2>
	<?php foreach($departments as $department){ ?>
		<div class="display_section delete_ajax_<?php echo $department->ID; ?>">
			<div class="display_list" onclick="window.open('/department-information/?id=<?php echo $department->ID ?>');">
				<a class="button_2 display_button" href="/edit-department/?id=<?php echo $department->ID ?>">Edit</a>
				<h3 id="name_<?php echo $department->ID; ?>" class="display_subtitle float_left"><?php echo $department->department_name; ?></h3>				
			</div>
			<div class="ajax_action_buttons">
				<div id="delete_department_<?php echo $department->ID; ?>" class="button_2 display_button float_right delete_department_button delete_ajax">Delete</div>
			</div>
			<div class="display_separator"></div>
		</div>
	<?php } ?>	
</div>
<div style="display:none;" class="dialog_form_delete_ajax" id="dialog_form_delete_department" title="Delete Department">
	<form class="delete_action_ajax" id="delete_department">
		<p class="label">
			Are you sure you want to delete 
			<span class="delete_name"></span>
			<span style="display:none;" class="delete_prep">from</span>
			<span style="display:none;" class="delete_parent"></span>
		</p>	
		<div class="button_1 delete_button_ajax">Delete</div>
		<div style="display:none" class="loader delete_ajax_loader"></div>
		<input type="hidden" class="delete_id" name="delete_id" />
		<input type="hidden" class="delete_type" name="delete_type" value="Department" />		
	</form>
</div>
<?php get_footer(); ?>