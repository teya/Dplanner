<?php /* Template Name: Person */ ?>
<?php get_header(); ?>
<?php 
global $wpdb;
$table_name = $wpdb->prefix . "custom_person";
$current_user = wp_get_current_user();
$current_user_name = $current_user->data->display_name;
$current_user_role = $current_user->roles['0'];
$user_info = $wpdb->get_row('SELECT * FROM '.$table_name.' WHERE wp_user_id = '.$current_user->ID);
?>
<?php
if(isset($_GET['deleteID'])) {
	$id = $_GET['deleteID'];	
	$wpdb->query( "DELETE FROM {$table_name} WHERE ID = '$id'" ) ;
}
?>
<div class="persons">
	<a id="create_person" class="button_1" href="<?php echo get_site_url(); ?>/add-people/">+ Add Person</a>
</div>
<div class="display_main persons">
<?php 
	$table_name = $wpdb->prefix . "custom_person"; 
	$people = $wpdb->get_results("SELECT * FROM {$table_name}");
	// $inactive_people = $wpdb->get_results("SELECT * FROM {$table_name} WHERE person_status='1'");
	$active_people_count = (count($active_people));	
	$inactive_people_count = (count($inactive_people));	
?>		
		
		<div class="active_people_container">
			<?php 
				foreach($people as $person){
					$person_fullname = $person->person_fullname;
			?>
			<div class="display_section display_section_archive_<?php echo $person->ID; ?> delete_ajax_<?php echo $person->ID; ?>">
				<div class="display_list" onclick="window.open('<?php echo get_site_url(); ?>/person-information/?id=<?php echo $person->ID ?>');">
					<?php if($current_user_name == $person_fullname || $user_info->person_permission == 'Administrator'){ ?>
					<a class="button_2 display_button" href="<?php echo get_site_url(); ?>/edit-people/?editID=<?php echo $person->ID ?>">Edit</a>
					<?php } ?>
					<h3 id="name_<?php echo $person->ID; ?>" class="display_subtitle float_left"><?php echo $person_fullname; ?></h3>
					<p class="display_hourly_rate">(kr <?php echo $person->person_hourly_rate; ?>/hr)</p>
					<p class="display_permission"><?php echo $person->person_permission; ?></p>			
				</div>
				<div class="ajax_action_buttons">
					<?php if($current_user_name == $person_fullname || $user_info->person_permission == 'Administrator'){ ?>
						<div id="delete_person_<?php echo $person->ID; ?>" class="button_2 display_button float_right delete_person_button delete_ajax">Delete</div>
						<div id="archive_person_<?php echo $person->ID; ?>" class="button_2 display_button float_right archive_person_button">Archive</div>
					<?php } ?>
				</div>
				<div class="display_separator"></div>
			</div>
			<?php } ?>
		</div>
</div>
<div style="display:none;" id="dialog_form_archive_people" title="Archive Person">
	<form id="archive_person">
		<p>Are you sure you want to archive <span class="span_bold"></span>?</p>	
		<div class="button_1 archive_person">Archive</div>
		<div style="display:none" class="loader"></div>
		<input type="hidden" class="person_name" name="person_name" />		
		<input type="hidden" class="person_id" name="person_id" />		
	</form>
</div>
<div style="display:none;" id="dialog_form_unarchive_people" title="Unarchive Person">
	<form id="unarchive_person">
		<p>Are you sure you want to unarchive <span class="span_bold"></span>?</p>	
		<div class="button_1 unarchive_person">Unarchive</div>
		<div style="display:none" class="loader"></div>
		<input type="hidden" class="person_name" name="person_name" />		
		<input type="hidden" class="person_id" name="person_id" />		
	</form>
</div>
<div style="display:none;" class="dialog_form_delete_ajax" id="dialog_form_delete_people" title="Delete Person">
	<form class="delete_action_ajax" id="delete_person">
		<p class="label">
			Are you sure you want to delete 
			<span class="delete_name"></span>
			<span style="display:none;" class="delete_prep">from</span>
			<span style="display:none;" class="delete_parent"></span>
		</p>	
		<div class="button_1 delete_button_ajax">Delete</div>
		<div style="display:none" class="loader delete_ajax_loader"></div>
		<input type="hidden" class="delete_id" name="delete_id" />
		<input type="hidden" class="delete_type" name="delete_type" value="Person" />		
	</form>
</div>
<?php get_footer(); ?>