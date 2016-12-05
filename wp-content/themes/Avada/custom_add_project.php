<?php /* Template name: Add Project */ ?>
<?php get_header(); ?>
<?php
global $wpdb;
$table_name = $wpdb->prefix . "custom_project";			
$table_name_client = $wpdb->prefix . "custom_client";
$table_name_person = $wpdb->prefix . "custom_person";
$table_name_department = $wpdb->prefix . "custom_department";
$table_name_color = $wpdb->prefix . "custom_project_color";
$table_name_website = $wpdb->prefix . "custom_website";
$table_name_hosting_domain = $wpdb->prefix . "custom_hosting_domain";
$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");	
$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
$departments = $wpdb->get_col("SELECT DISTINCT department_name FROM {$table_name_department}");
$project_colors = $wpdb->get_results("SELECT * FROM {$table_name_color}");
$websites = $wpdb->get_results("SELECT * FROM {$table_name_website}");
$hosting_domain = $wpdb->get_results("SELECT * FROM $table_name_hosting_domain");

// echo '<pre>';
// print_r($clients);
// echo '</pre>';
?>
<?php 
if(isset($_POST['submit'])):
	global $wpdb;
	foreach ($_POST['project_client_ids'] as $client_id){	

		$client_info = $wpdb->get_row('SELECT client_name FROM '. $table_name_client .' WHERE ID = ' . $client_id);

		$project_client					= $client_info->client_name;
		$project_client_id				= $client_id;
		$project_name					= (isset($_POST['project_name']) ? $_POST['project_name'] : '');
		$project_start_date				= (isset($_POST['project_start_date']) ? $_POST['project_start_date'] : '');
		$project_estimated_deadline		= (isset($_POST['project_estimated_deadline']) ? $_POST['project_estimated_deadline'] : '');
		$project_main_consultant		= (isset($_POST['project_main_consultant']) ? $_POST['project_main_consultant'] : '');
		$project_current_status			= (isset($_POST['project_current_status']) ? $_POST['project_current_status'] : '');
		$project_billable				= (isset($_POST['project_billable'])) ? $_POST['project_billable'] : 0;	
		if(isset($_POST['project_estimated_hour']) && isset($_POST['project_estimated_minute'])){
			$project_estimated_hours = $_POST['project_estimated_hour'] .'h'.' '. $_POST['project_estimated_minute'] .'m';
		}elseif(isset($_POST['project_estimated_hour']) && $_POST['project_estimated_minute'] == null){
			$project_estimated_hours = $_POST['project_estimated_hour'] .'h 0m';
		}elseif($_POST['project_estimated_hour'] == null && isset($_POST['project_estimated_minute'])){
			$project_estimated_hours = '0h'. $_POST['project_estimated_minute'] .'m';
		}
		$project_fixed_price			= (isset($_POST['project_fixed_price']) ? $_POST['project_fixed_price'] : '');
		$project_description			= (isset($_POST['project_description']) ? $_POST['project_description'] : '');

		$insert = $wpdb->insert( $table_name , array( 
		'project_client'				=> $project_client,
		'project_client_id'				=> $project_client_id,
		'project_name'					=> $project_name,
		'project_start_date'			=> $project_start_date,
		'project_estimated_deadline'	=> $project_estimated_deadline,
		'project_main_consultant'		=> $project_main_consultant,
		'project_current_status'		=> $project_current_status,
		'project_billable'				=> $project_billable,
		'project_estimated_hours'		=> $project_estimated_hours,
		'project_fixed_price'			=> $project_fixed_price,
		'project_description'			=> $project_description
		), array( '%s', '%d','%s', '%s','%s', '%s','%s', '%s','%s' ));
	}

	if($insert == 1):
		echo "<p class='message'>";
		echo "Project Added!";
	else:
		echo "Project was not successfully added.";
		echo "</p>";
	endif;	
endif;
?>
<?php $current_status_array = array('Planned', 'In progress', 'Paused', 'Complete'); ?>
<script>
	jQuery(document).ready(function(){
		jQuery('.project_start_date').datepicker();
		jQuery('.project_estimated_deadline').datepicker();
		jQuery('.project_date_completed').datepicker();
		jQuery('.project_invoice_date').datepicker();
	});
</script>
<div class="add_project">
	<form action="" method="post" name="project" id="project">
		<div class="section">
			<div class="left">
				<p class="label">Client</p>
			</div>
			<div class="right">
				<select multiple class="project_client_ids" name="project_client_ids[]">
					<?php foreach($clients as $client){ ?>
						<option value="<?php echo $client->ID ?>"><?php echo $client->client_name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Project Name</p>
			</div>
			<div class="right">				
				<input type="text" name="project_name" class="project_name" />
			</div>
		</div>
		<div class="border_separator"></div>		
		<div class="section">
			<div class="left">
				<p class="label">Start date</p>
			</div>
			<div class="right">
				<input type="text" name="project_start_date" class="project_start_date" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Estimated Deadline</p>
			</div>
			<div class="right">
				<input type="text" name="project_estimated_deadline" class="project_estimated_deadline" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Main consultant</p>
			</div>
			<div class="right">
				<select name="project_main_consultant" class="project_main_consultant">
					<?php 					
						$project_person_array = array();
						foreach ($persons as $person){
							$project_person_array[] = $person->person_fullname;
						}
						sort($project_person_array); 
						foreach ($project_person_array as $project_person){ 
					?>
						<option><?php echo $project_person; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Current Status</p>
			</div>
			<div class="right">
				<select name="project_current_status" class="project_current_status">
					<?php 
						$project_current_status_array = array();
						foreach ($current_status_array as $current_status){
							$project_current_status_array[] = $current_status;
						}
						sort($project_current_status_array);
						foreach ($project_current_status_array as $project_current_status){ 
					?>
						<option><?php echo $project_current_status; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">	
			<div class="left">
				<p class="label">Billable</p>
			</div>
			<div class="right">
				<input type="checkbox" name="project_billable" value="1" class="project_billable checkbox" checked />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Estimated hours</p>
			</div>
			<div class="right">
				<input type="text" name="project_estimated_hour" class="project_estimated_hour" /> h
				<input type="text" name="project_estimated_minute" class="project_estimated_minute" /> m
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">	
			<div class="left">
				<p class="label">Fixed price</p>
			</div>
			<div class="right">
				<input type="text" name="project_fixed_price" class="project_fixed_price">
			</div>
		</div>		
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Description</p>
			</div>
			<div class="right">
				<textarea name="project_description" class="project_description textarea_wide"></textarea>
			</div>
		</div>
		<input type="submit" name="submit" class="button_1" value="Add Project" />
		<a class="button_2" href="/projects/">Cancel</a>
	</form>
</div>
<div style="display:none;" id="dialog_form_website_add" title="Add Website">
	<?php 
		$table_name_client = $wpdb->prefix . "custom_client";
		$clients = $wpdb->get_results("SELECT * FROM $table_name_client");
		$site_types = array('Main site', 'Secondary site', 'Demo site', 'PBN Site');
		$site_platforms = array('Wordpress', 'Drupal', 'Web2.0');
		$site_domain_owners = array('Customer', 'SEOWEB');
	?>
	<div class="add_website website_style">
		<form action="" method="post" name="website" id="website">
			<div class="section first_section">
				<div class="left">
					<p class="label">Site URL:</p>
				</div>
				<div class="right">
					<input type="text" name="site_url" class="site_url" placeholder="http://">	
					<div class="error_message"><p></p></div>
					<div class="get_details_buttons">
						<div class="button_1 get_wp_details">Get WP Details</div>
						<div class="button_1 get_theme_details">Get Theme Details</div>	
						<div style="display:none;" class="loader"></div>
					</div>
				</div>				
			</div>
			<div class="border_separator"></div>		
			<div style="display:none" class="section wp_readme_details"></div>
			<div class="section wp_version"></div>
			<div class="section theme_details"></div>
			<div class="section three_column">
				<select name="site_type">
					<option disabled selected>-- Site Type --</option>
					<?php foreach($site_types as $site_type){	?>
						<option><?php echo $site_type; ?></option>
					<?php } ?>
				</select>			
			</div>
			<div class="section three_column">
				<select name="site_client">
					<option disabled selected>-- Site Client --</option>
					<?php foreach($clients as $client){	?>
						<option><?php echo $client->client_name; ?></option>
					<?php } ?>
				</select>		
			</div>
			<div class="section three_column last">
				<select name="site_platform">
					<option disabled selected>-- Site Platform --</option>
					<?php foreach($site_platforms as $site_platform){ ?>
						<option><?php echo $site_platform; ?></option>
					<?php } ?>
				</select>		
			</div>
			<div class="border_separator"></div>
			<div class="section four_column">
				<input type="text" name="site_login_url" placeholder="Site Login URL" />
				<input type="text" class="site_username input_float_left" name="site_username" placeholder="Site Login Username" />
				<input type="text" class="site_password input_float_left" name="site_password" placeholder="Site Login Password" />					
			</div>
			<div class="section four_column">
				<input type="text" class="site_mysql_url" name="site_mysql_url" placeholder="MySQL URL" />
				<input type="text" class="site_mysql_username input_float_left" name="site_mysql_username" placeholder="MySQL Username" />
				<input type="text" class="site_mysql_password input_float_left" name="site_mysql_password" placeholder="MySQL Password" />
			</div>
			<div class="section four_column">
				<input type="text" class="site_database_name input_float_left" name="site_database_name" placeholder="Database Name" />
				<input type="text" class="site_database_username input_float_left" name="site_database_username" placeholder="Database Username" />
				<input type="text" class="site_database_password input_float_left" name="site_database_password" placeholder="Database Password" />
			</div>
			<div class="section four_column last">
				<input type="text" class="site_ftp_server input_float_left" name="site_ftp_server" placeholder="FTP server" />
				<input type="text" class="site_ftp_username input_float_left" name="site_ftp_username" placeholder="FTP Username" />
				<input type="text" class="site_ftp_password input_float_left" name="site_ftp_password" placeholder="FTP Password" />
			</div>
			<div class="border_separator"></div>
			<div class="section two_column">
				<div class="left">
					<select class="site_hosting_name" name="site_hosting_name">
						<option>Unknown</option>
						<?php 
							foreach($hosting_domain as $hosting){
								$hosting_name = $hosting->site_hosting_name;
								if($hosting_name != null){
								?>
								<option><?php echo $hosting_name; ?></option>
								<?php	
								}
							}
						?>
					</select>
					<div class="button_2 add_hosting add_other_hosting_domain">Add Hosting</div>
					<div style="display: none;" class="add_hosting_url add_hosting_domain_div">
						<div class="add_url_details">
							<div class="hosting_domain_input">
							<input type="text" name="add_site_hosting_name" class="add_site_hosting_name add_hosting_domain_input" placeholder="Hosting Name" />			
							<input type="text" name="add_site_hosting_url" class="add_site_hosting_url add_hosting_domain_input" placeholder="Hosting URL" />
							</div>
							<div class="hosting_domain_input">
							<input type="text" name="add_site_hosting_username" class="add_site_hosting_username add_hosting_domain_input" placeholder="Hosting Username" />
							<input type="text" name="add_site_hosting_password" class="add_site_hosting_password add_hosting_domain_input" placeholder="Hosting Password" />
							</div>
							<div class="button_1 save_hosting_url">Add</div>
						</div>
						<div style="display: none;" class="loader hosting_domain_loader"></div>
					</div>
				</div>	
			</div>
			<div class="section two_column last">
				<div class="left">
					<?php $domain_count = count($domains); ?>
					<select class="site_domain_name" name="site_domain_name">
						<option>Unknown</option>
						<optgroup label = "Domain Registrars">
							<?php 
								foreach($hosting_domain as $domain){
									$domain_name = $domain->site_domain_name;
									if($domain_name != null){ 
									?>
									<option><?php echo $domain_name; ?></option>
									<?php	
									}
								}
							?>
						</optgroup>
						<optgroup label = "Hosting">
							<?php 
								foreach($hosting_domain as $hosting){
									$hosting_name = $hosting->site_hosting_name;
									if($hosting_name != null){
									?>
									<option><?php echo $hosting_name; ?></option>
									<?php	
									}
								}
							?>
						</optgroup>
					</select>
					<div class="button_2 add_domain add_other_hosting_domain">Add Domain</div>
					<div style="display: none;" class="add_domain_url add_hosting_domain_div">
						<div class="add_url_details">
							<div class="hosting_domain_input">
								<input type="text" name="add_site_domain_name" class="add_site_domain_name add_hosting_domain_input" placeholder="Domain Name" />
								<input type="text" name="add_site_domain_url" class="add_site_domain_url add_hosting_domain_input" placeholder="Domain URL" />
							</div>
							<div class="hosting_domain_input">
								<input type="text" name="add_site_domain_username" class="add_site_domain_username add_hosting_domain_input" placeholder="Domain Username" />
								<input type="text" name="add_site_domain_password" class="add_site_domain_password add_hosting_domain_input" placeholder="Domain Password" />
							</div>
							<div class="button_1 save_domain_url">Add</div>
						</div>
						<div style="display: none;" class="loader hosting_domain_loader"></div>
					</div>
				</div>			
			</div>
			<div class="border_separator"></div>
			<div class="section three_column">
				<select name="site_domain_owner">
					<option disabled selected>-- Domain Owner --</option>
					<?php foreach($site_domain_owners as $site_domain_owner){	?>
						<option><?php echo $site_domain_owner; ?></option>
					<?php } ?>
				</select>			
			</div>
			<div class="section three_column">
				<input type="text" name="site_renewal_date" class="site_renewal_date" placeholder="Renewal date" />						
			</div>
			<div class="section three_column">
				<input type="text" name="site_cost" class="site_cost" placeholder="Cost" />	
			</div>
			<div class="border_separator"></div>
			<div class="section">
				<div class="left">
					<p class="label">Additional Information:</p>
				</div>
				<div class="right">
					<textarea name="site_additional_info" class="site_additional_info textarea_wide"></textarea>
				</div>
			</div>				
			<div class="add_website_buttons">				
				<div class="save_website button_1" />Add Website</div>
				<div style="display:none;" class="add_site_loader"></div>
			</div>
		</form>
	</div>
</div>
<?php get_footer(); ?>