<?php /* Template Name: Hosting & Domain */ ?>
<?php get_header(); ?>
<?php 
if(isset($_GET['deleteID'])) {
	$id = $_GET['deleteID'];	
	global $wpdb;	
	$table_name = $wpdb->prefix . "custom_hosting_domain";
	
	$wpdb->query( "DELETE FROM {$table_name} WHERE ID = '$id'" ) ;
}
?>
<div class="hosting_domain">
	<a id="create_projects" class="button_1 add_hosting_domain_button" href="/add-hosting-domain/">+ Add Hosting/Domain</a>
</div>
<div class="display_main hosting_domain">
<?php 
	$table_name = $wpdb->prefix . "custom_hosting_domain"; 
	$hosting_domains = $wpdb->get_results("SELECT * FROM {$table_name}");
?>
	
		<h2 class="display_title">Hosting Companies</h2>
		<?php 
		foreach($hosting_domains as $hosting_domain){
			if($hosting_domain->site_status == 'Hosting'){
		?>		
			<div class="display_section delete_ajax_<?php echo $hosting_domain->ID; ?>">
				<div class="display_list" onclick="window.open('/hosting-domain-information/?id=<?php echo $hosting_domain->ID ?>');">
					<a class="button_2 display_button" href="/edit-hosting-domain/?id=<?php echo $hosting_domain->ID ?>">Edit</a>
					<h3 id="name_<?php echo $hosting_domain->ID; ?>" class="display_subtitle"><?php echo ($hosting_domain->site_hosting_name) ? $hosting_domain->site_hosting_name : "--"; ?></h3>					
				</div>
				<div class="ajax_action_buttons">									
					<div id="delete_hostingdomain_<?php echo $hosting_domain->ID; ?>" class="button_2 display_button float_right delete_hostingdomain_button delete_ajax">Delete</div>
				</div>
				<div class="display_separator"></div>
			</div>
<?php 		
			}
		} 
?>
		<h2 class="display_title">Domain Registrars</h2>
<?php 
			foreach($hosting_domains as $hosting_domain){
				if($hosting_domain->site_status == 'Domain'){
?>
		<div class="display_section delete_ajax_<?php echo $hosting_domain->ID; ?>">
			<div class="display_list" onclick="window.open('/hosting-domain-information/?id=<?php echo $hosting_domain->ID ?>');">
				<a class="button_2 display_button" href="/edit-hosting-domain/?id=<?php echo $hosting_domain->ID ?>">Edit</a>
				<h3 id="name_<?php echo $hosting_domain->ID; ?>" class="display_subtitle"><?php echo ($hosting_domain->site_domain_name != null) ? $hosting_domain->site_domain_name : "--"; ?></h3>				
			</div>
			<div class="ajax_action_buttons">									
				<div id="delete_hostingdomain_<?php echo $hosting_domain->ID; ?>" class="button_2 display_button float_right delete_hostingdomain_button delete_ajax">Delete</div>
			</div>
			<div class="display_separator"></div>
		</div>
<?php 		
				}
			} 
?>
	
</div>
<div style="display:none;" class="dialog_form_delete_ajax" id="dialog_form_delete_hostingdomain" title="Delete Hosting/Domain">
	<form class="delete_action_ajax" id="delete_hostingdomain">
		<p class="label">
			Are you sure you want to delete 
			<span class="delete_name"></span>
			<span style="display:none;" class="delete_prep">from</span>
			<span style="display:none;" class="delete_parent"></span>
		</p>	
		<div class="button_1 delete_button_ajax">Delete</div>
		<div style="display:none" class="loader delete_ajax_loader"></div>
		<input type="hidden" class="delete_id" name="delete_id" />
		<input type="hidden" class="delete_type" name="delete_type" value="Hosting Domain" />		
	</form>
</div>
<?php get_footer(); ?>