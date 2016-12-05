<?php /* TEMPLATE NAME: Monthly Plan */ ?>
<?php get_header(); ?>
<?php 
if(isset($_GET['deleteID'])) {
	$id = $_GET['deleteID'];	
	global $wpdb;	
	$table_name = $wpdb->prefix . "custom_monthly_plan";
	
	$wpdb->query( "DELETE FROM {$table_name} WHERE ID = '$id'" ) ;
}
?>
<div class="projects">
	<a id="create_projects" class="button_1" href="/add-monthly-plan/">+ Add Monthly Plan</a>
</div>
<div class="display_main monthly_plans">
	<?php 
		$table_name = $wpdb->prefix . "custom_monthly_plan"; 
		$monthly_plans = $wpdb->get_results("SELECT * FROM {$table_name}");
	?>	
	<?php foreach($monthly_plans as $monthly_plan){	?>
		<div class="display_section delete_ajax_<?php echo $monthly_plan->ID; ?>">
			<div class="display_list" onclick="window.open('/monthly-plan-information/?id=<?php echo $monthly_plan->ID ?>');">
				<a class="button_2 display_button" href="/edit-monthly-plan/?id=<?php echo $monthly_plan->ID ?>">Edit</a>
				<h3 id="name_<?php echo $monthly_plan->ID; ?>" class="display_subtitle"><?php echo $monthly_plan->monthly_name; ?></h3>				
			</div>
			<div class="ajax_action_buttons">
				<div id="delete_monthlyplan_<?php echo $monthly_plan->ID; ?>" class="button_2 display_button float_right delete_monthlyplan_button delete_ajax">Delete</div>
			</div>
			<div class="display_separator"></div>
		</div>
	<?php } ?>
</div>
<div style="display:none;" class="dialog_form_delete_ajax" id="dialog_form_delete_monthlyplan" title="Delete Monthly Plan">
	<form class="delete_action_ajax" id="delete_monthlyplan">
		<p class="label">
			Are you sure you want to delete 
			<span class="delete_name"></span>
			<span style="display:none;" class="delete_prep">from</span>
			<span style="display:none;" class="delete_parent"></span>
		</p>	
		<div class="button_1 delete_button_ajax">Delete</div>
		<div style="display:none" class="loader delete_ajax_loader"></div>
		<input type="hidden" class="delete_id" name="delete_id" />
		<input type="hidden" class="delete_type" name="delete_type" value="Monthly Plan" />		
	</form>
</div>
<?php get_footer(); ?>