<?php /* Template Name: Services */ ?>
<?php get_header(); ?>
<script>
	jQuery(document).on('click', '.invoiced_service', function(){
		var id = jQuery(this).attr('id').split("_")[1];
				jQuery('#loader_'+id).show();
				jQuery.ajax({				
					type: "POST",
					url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
					data:{
						'type' : 'invoice_services',
						'data_id' : id
					},
				success: function (data) {
					var parsed = jQuery.parseJSON(data);
					jQuery('#display_note_'+parsed.id+" .display_list div .invoice-date").html("Next Invoice : "+parsed.new_invoice_date).removeClass('date-passed');
					jQuery('#loader_'+id).hide();
				},
				error: function(){
					
				}
			});	


	});
	jQuery(document).ready(function(){
		jQuery( "#archive_form" ).dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			close: function() {
			}
		});
		// jQuery("#archive_button").click(function() {
			
			// var firstVar = jQuery('#archive_id').val;
			// location.href = '/manage-projects/projects/?firstvar='+firstVar;
			// return false;
			// jQuery.ajax({
				// url: "http://research.seowebsolutions.com/manage-projects/projects/",
				// type: "POST",				
				// data: { id1: id},
				// success: function (result) {
					// alert('success');
					
				// }
			// });  
		// });
		jQuery('.archive_button').click(function(){	
			jQuery('.search-loading').show();		
			var wrapper_id = jQuery(this).attr('id');
			var archiveId = jQuery( '#' + wrapper_id + " .archive_id_hidden" ).val();
			jQuery.ajax({
				url: "http://research.seowebsolutions.com/manage-projects/projects/",
				type: "POST",
				data : {archive_id:archiveId},
				success: function (data) {
					jQuery( "#archive_form" ).dialog( "open" );
					jQuery(".archive_form_id").val(archiveId);
					jQuery('.search-loading').hide();
				},
				error: function(){
					alert('failure');
				}
			});		
			return false;			
		});
				
		jQuery('.project_invoice_date').datepicker();
		
	});
</script>
<?php 
$table_name = $wpdb->prefix . "custom_project";
$archive_id = $_POST['archive_form_id'];
if(isset($_POST['archive_save'])):
	$project_invoiced_amount	= $_POST['project_invoiced_amount'];
	$project_extra_expenses		= $_POST['project_extra_expenses'];
	$project_invoice_date		= $_POST['project_invoice_date'];
	$project_status				= 0;
	
	
	$update = $wpdb->update( $table_name , array( 
	'project_invoiced_amount'	=> $project_invoiced_amount,
	'project_extra_expenses'	=> $project_extra_expenses,
	'project_invoice_date'		=> $project_invoice_date,
	'project_status'			=> $project_status
	),
	array( 'ID' => $archive_id ),
	array( '%s', '%s' ));
endif;
?> 
<div style="display:none;" id="archive_form" title="Archive">
	<form action="" method="post" name="" id="">		
		<fieldset>
			<div class="full_width">
				Invoiced Amount: <input name="project_invoiced_amount" class="project_invoiced_amount">
			</div>
			<div class="full_width">
			Extra expenses: <input name="project_extra_expenses" class="project_extra_expenses">
			</div>
			<div class="full_width">
			Date of Invoice: <input name="project_invoice_date" class="project_invoice_date">
			</div>
			<input type="hidden" name="archive_form_id" class="archive_form_id"/>
			<input type="submit" name="archive_save" class="button_1 archive_save" value="Archive">
		</fieldset>
	</form>
</div>
<div class="projects">
	<a id="create_projects" class="button_1 float_left" href="<?php echo get_site_url(); ?>/manage-services/add-service/">+ Add Service</a>
	<div style="display:none;" class="loader"></div>
</div>
<div class="display_main projects">	
<?php 
	$table_name_client = $wpdb->prefix . "custom_client";
	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");
	$table_name_project = $wpdb->prefix . "custom_services";
	$services = $wpdb->get_results("SELECT * FROM {$table_name_project}");
	foreach($clients as $client){			
?>
	<div style="display:none;" class="dialog_form_project_management" id="dialog_form_archive_project_management" title="Archive Project"></div>
	<div class="delete_ajax_parent">
		<div class="ajax_parent">
			<h2 class="client_info display_title"><?php echo $client->client_name; ?></h2>
			<?php
				foreach($services as $service){
					if($service->client_id == $client->ID){
						$service_name = $project->service_name;
						$total = $service->customer_price * $service->licenses;
						$revenue = $total - ($service->our_price * $service->licenses);
						$date_passed = IfDatePassed($service->start_date);
						$hide = '';
						$hide_btn_invoice ="";
						if($service->invoice_interval == 'Lifetime'){
							$service->start_date = 'Lifetime';
							$hide = 'hide';
						}
						if($service->start_date != ''){
							$next_invoice_date = $service->start_date;
						}else{
							$next_invoice_date = '--';
							$hide_btn_invoice = 'hide';
						}
							
			?>
			<div class="display_section delete_ajax_<?php echo $service->ID; ?>">
				<div id="display_note_<?php echo $service->ID; ?>" class="display_note">
					<div class="display_list display_list_max_width" >
						<a class="button_2 display_button" href="<?php echo get_site_url(); ?>/manage-projects/edit-service/?editID=<?php echo $service->ID ?>">Edit</a>
						<h3 id="name_<?php echo $service->ID; ?>" class="display_subtitle service_title_width"><?php echo $service->service_name; ?></h3>						
					<!--	<div style="display:none" id="project_notes_<?php // echo $service->ID ?>" class="project_notes"><?php // echo $project->project_description; ?></div> -->
					<div class="">
						<span class="service-column">Licenses: <?php echo $service->licenses; ?></span>
						<span class="service-column">Price: <?php echo $service->customer_price; ?></span>
						<span class="service-column">Total: <?php echo $total; ?></span>
						<span class="service-column">Revenue : <?php echo $revenue; ?></span>
						<span class="service-column invoice-date <?php echo ($date_passed == 1)? 'date-passed' : ''; ?>">Next Invoice : <?php echo $next_invoice_date ?></span>
					</div>
					</div>
					<div class="ajax_action_buttons">
						<div id="delete_project_<?php echo $service->ID; ?>" class="button_2 display_button float_right delete_project_button delete_ajax">Delete</div>
						<div id="invoiced_<?php echo $service->ID; ?>" class="button_2 display_button float_right invoiced_service <?php echo $hide; ?> <?php echo $hide_btn_invoice; ?>">Invoiced</div>
						<div style="display:none" id="loader_<?php echo $service->ID; ?>" class="loader project_loader"></div>
					</div>
				</div>
			</div>
			<div class="display_separator"></div>
			<?php 
					}
				}
			?>
		</div>
	</div>
	<?php } ?>
</div>
<div style="display:none;" class="dialog_form_delete_ajax" id="dialog_form_delete_project" title="Delete Project">
	<form class="delete_action_ajax" id="delete_project">
		<p class="label">
			Are you sure you want to delete 
			<span class="delete_name"></span>
			<span style="display:none;" class="delete_prep">from</span>
			<span style="display:none;" class="delete_parent"></span>
		</p>	
		<div class="button_1 delete_button_ajax">Delete</div>
		<div style="display:none" class="loader delete_ajax_loader"></div>
		<input type="hidden" class="delete_id" name="delete_id" />
		<input type="hidden" class="delete_type" name="delete_type" value="Project" />		
	</form>
</div>
<div style="display:none;" class="dialog_client_information" id="dialog_client_information" title="Client Information">
	<div class="full_width">
		<div class="one_half">
			<p class="label">Customer Info:</p>
			<p class="client_name"></p>
			<p class="client_address"></p>
			<p class="label">Contact Person:</p>
			<p class="client_contact_person"></p>
			<p class="client_contact_phone"></p>
			<p class="client_contact_email"></p>
		</div>
		<div class="one_half last">
			<div class="full_width">
				<p class="label">Monthly Plan: </p>
				<p class="client_monthly_plan"></p>
			</div>
			<div class="full_width">
				<p class="label">Customer Satisfaction: </p>
				<p class="client_satisfaction"></p>
			</div>
			<div class="full_width">
				<p class="label">Current Active WebDev Projects: </p>
				<p class="current_active_webdev_projects"></p>
			</div>
			<div class="full_width">
				<p class="label">Monthly Ongoing Stat: </p>
				<p class="monthly_ongoing_stat"></p>
			</div>
		</div>
	</div>
	<div class="full_width">
		<h3>Customer Sites</h3>
		<div class="header_titles">
			<div class="first_column column">URL</div>
			<div class="second_column column">Site Type</div>
			<div class="third_column column">Platform</div>
			<div class="fourth_column column">Version</div>
			<div class="fifth_column column">Username</div>
			<div class="sixth_column column">Password</div>
			<div class="seventh_column column">L</div>
		</div>
		<div class="site_container"></div>
	</div>
</div>
<?php get_footer(); ?>