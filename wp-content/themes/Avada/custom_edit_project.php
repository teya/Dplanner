<?php /* Template Name: Edit Project */ ?>
<?php get_header(); ?>
<?php  
global $wpdb;			
$table_name = $wpdb->prefix . "custom_project";
$table_name_clients = $wpdb->prefix . "custom_client";
$table_name_person = $wpdb->prefix . "custom_person";
$table_name_color = $wpdb->prefix . "custom_project_color";
$table_name_department = $wpdb->prefix . "custom_department";
$table_name_color = $wpdb->prefix . "custom_project_color";
$table_name_website = $wpdb->prefix . "custom_website";

$projects = $wpdb->get_results("SELECT * FROM {$table_name}");
$client_names = $wpdb->get_results("SELECT * FROM {$table_name_clients}");
$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
$departments = $wpdb->get_results("SELECT * FROM {$table_name_department}");
$project_colors = $wpdb->get_results("SELECT * FROM {$table_name_color}");
$id = $_GET['editID'];
$results_edit = $wpdb->get_row("SELECT * FROM $table_name WHERE id=$id"); 
$colors = $wpdb->get_results("SELECT * FROM {$table_name_color}");
$websites = $wpdb->get_results("SELECT * FROM {$table_name_website}");
?>
<?php
if(isset($_POST['submit'])):
	$project_client				= (isset($_POST['project_client']) ? $_POST['project_client'] : '');
	$project_name				= (isset($_POST['project_name']) ? $_POST['project_name'] : '');
	$project_start_date			= (isset($_POST['project_start_date']) ? $_POST['project_start_date'] : '');
	$project_estimated_deadline	= (isset($_POST['project_estimated_deadline']) ? $_POST['project_estimated_deadline'] : '');
	$project_main_consultant	= (isset($_POST['project_main_consultant']) ? $_POST['project_main_consultant'] : '');
	$project_current_status		= (isset($_POST['project_current_status']) ? $_POST['project_current_status'] : '');
	$project_billable			= (isset($_POST['project_billable'])) ? $_POST['project_billable'] : 0;	
	if(isset($_POST['project_estimated_hour']) && isset($_POST['project_estimated_minute'])){
			$project_estimated_hours = $_POST['project_estimated_hour'] .'h'.' '. $_POST['project_estimated_minute'] .'m';
		}elseif(isset($_POST['project_estimated_hour']) && $_POST['project_estimated_minute'] == null){
			$project_estimated_hours = $_POST['project_estimated_hour'] .'h 0m';
		}elseif($_POST['project_estimated_hour'] == null && isset($_POST['project_estimated_minute'])){
			$project_estimated_hours = '0h'. $_POST['project_estimated_minute'] .'m';
		}
	$project_fixed_price		= (isset($_POST['project_fixed_price']) ? $_POST['project_fixed_price'] : '');
	$project_description		= (isset($_POST['project_description']) ? $_POST['project_description'] : '');
		
	$update = $wpdb->update( $table_name , array( 
	'project_client'				=> $project_client,
	'project_name'					=> $project_name,
	'project_start_date'			=> $project_start_date,
	'project_estimated_deadline'	=> $project_estimated_deadline,
	'project_main_consultant'		=> $project_main_consultant,
	'project_current_status'		=> $project_current_status,
	'project_billable'				=> $project_billable,
	'project_estimated_hours'		=> $project_estimated_hours,
	'project_fixed_price'			=> $project_fixed_price,
	'project_description'			=> $project_description
	),	
	array( 'ID' => $id ),
	array( '%s', '%s' ));	
	
	if($update == 1):
		echo "<p class='message'>";
		echo "Project Updated!";
		echo "</p>";
	else:
		echo "<p class='message'>";
		echo "Project was not Updated.";
		echo "</p>";
	endif;	
endif;
?>
<?php $current_status_array = array('Planned', 'In progress', 'Paused', 'Complete'); ?>
<?php $results_edit = $wpdb->get_row("SELECT * FROM $table_name WHERE id=$id"); ?> 
<script>
	jQuery(document).ready(function(){
		jQuery('.project_start_date').datepicker();
		jQuery('.project_estimated_deadline').datepicker();
		jQuery('.project_date_completed').datepicker();
		jQuery('.project_invoice_date').datepicker();
	});
</script>
<div class="edit_project">
	<form action="" method="post" name="project" id="project">
		<div class="section">
			<div class="left">
				<p class="label">Client</p>
			</div>
			<div class="right">
				<select class="project_client" name="project_client">
					<option value="<?php echo (isset($results_edit->project_client)) ? $results_edit->project_client : '';  ?>"><?php echo $results_edit->project_client; ?></option>
					<?php 
						$project_client_array = array();
						foreach ($client_names as $client){
							$project_client_array[] = $client->client_name;;
						}
						sort($project_client_array);
					?>
					<?php 
					foreach($project_client_array as $project_client){
						if($project_client != $results_edit->project_client){
					?>
						<option><?php echo $project_client; ?></option>
					<?php 
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Project Name</p>
			</div>
			<div class="right">
				<input type="text" name="project_name" class="project_name" value="<?php echo (isset($results_edit->project_name)) ? $results_edit->project_name : '';  ?>"/>							
			</div>
		</div>
		<div class="border_separator"></div>		
		<div class="section">
			<div class="left">
				<p class="label">Start date</p>
			</div>
			<div class="right">
				<input type="text" name="project_start_date" class="project_start_date" value="<?php echo (isset($results_edit->project_start_date)) ? $results_edit->project_start_date : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Estimated Deadline</p>
			</div>
			<div class="right">
				<input type="text" name="project_estimated_deadline" class="project_estimated_deadline" value="<?php echo (isset($results_edit->project_estimated_deadline)) ? $results_edit->project_estimated_deadline : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Main consultant</p>
			</div>
			<div class="right">	
				<select class="project_main_consultant" name="project_main_consultant">
					<!-- <option value="<?php echo (isset($results_edit->project_main_consultant)) ? $results_edit->project_main_consultant : '';  ?>"><?php echo $results_edit->project_main_consultant; ?></option> -->
					<?php 
						$project_person_array = array();
						foreach ($persons as $person){
							$project_person_array[] = $persons->person_fullname;
						}
						sort($project_person_array);
					?>
					<?php 
					foreach($persons as $project_person){
						if($project_person != $results_edit->project_main_consultant){
					?>
						<option <?php echo ($results_edit->project_main_consultant == $project_person->person_fullname)? 'selected' : ''; ?>><?php echo $project_person->person_fullname; ?></option>
					<?php 
						}
					}
					?>
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
					<!-- <option value="<?php echo (isset($results_edit->project_current_status)) ? $results_edit->project_current_status : '';  ?>"><?php echo $results_edit->project_current_status;?></option> -->
					<?php 
						// $project_current_status_array = array();
						foreach ($current_status_array as $current_status){
							$project_current_status_array[] = $current_status;
						}
						sort($project_current_status_array);
					?>
					<?php 
						foreach ($project_current_status_array as $project_current_status){ 
							if($project_current_status != $results_edit->project_current_status){
					?>
								<option <?php echo ($results_edit->project_current_status == $project_current_status)? 'selected' : ''; ?> ><?php echo $project_current_status; ?></option>
					<?php 
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">	
			<div class="left">
				<p class="label">Billable</p>
			</div>
			<div class="right">
				<input type="checkbox" name="project_billable" <?php echo ($results_edit->project_billable == 1) ? 'checked' : '';  ?> class="project_invoice_method checkbox">Billable
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
				<input type="text" name="project_fixed_price" value="<?php echo (isset($results_edit->project_fixed_price)) ? $results_edit->project_fixed_price : '';  ?>" class="project_invoice_date">
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Description</p>
			</div>
			<div class="right">
				<textarea name="project_description" class="project_description textarea_wide" ><?php echo (isset($results_edit->project_description)) ? $results_edit->project_description : '';  ?></textarea>
			</div>
		</div>		
		<input type="submit" name="submit" class="add_project button_1" value="Update" />
		<a class="button_2" href="/projects/">Cancel</a>
	</form>
</div>
<div style="display:none;" id="dialog_form_website_add" title="Add Website">
	<?php 
		$table_name_client = $wpdb->prefix . "custom_client";
		$clients = $wpdb->get_results("SELECT * FROM $table_name_client");
		$site_types = array('Main site', 'Secondary site', 'Demo site');
		$site_platforms = array('Wordpess', 'Drupal');
	?>
	<div class="add_website website_style">
		<form action="" method="post" name="website" id="website">
			<div class="section first_section">
				<div class="left">
					<p class="label">Site URL:</p>
				</div>
				<div class="right">
					<input type="text" name="site_url" class="site_url required" placeholder="http://">	
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
			<div class="section three_column">
				<select name="site_platform">
					<option disabled selected>-- Site Platform --</option>
					<?php foreach($site_platforms as $site_platform){ ?>
						<option><?php echo $site_platform; ?></option>
					<?php } ?>
				</select>		
			</div>
			<div class="border_separator"></div>
			<div class="section two_column">
				<input type="text" name="site_login_url" placeholder="Site Login URL" />
				<input type="text" class="site_username input_float_left" name="site_username" placeholder="Site Login Username" />
				<input type="text" class="site_password input_float_left" name="site_password" placeholder="Site Login Password" />					
			</div>
			<div class="section two_column">
				<input type="text" class="site_hosting_url" name="site_hosting_url" placeholder="Hosting URL" />
				<input type="text" class="site_hosting_username input_float_left" name="site_hosting_username" placeholder="Hosting Username" />
				<input type="text" class="site_hosting_password input_float_left" name="site_hosting_password" placeholder="Hosting Password" />
			</div>
			<div class="border_separator"></div>
			<div class="section two_column">
				<input type="text" class="site_mysql_url" name="site_mysql_url" placeholder="MySQL URL" />
				<input type="text" class="site_mysql_username input_float_left" name="site_mysql_username" placeholder="MySQL Username" />
				<input type="text" class="site_mysql_password input_float_left" name="site_mysql_password" placeholder="MySQL Password" />
			</div>
			<div class="section two_column">
				<input type="text" class="site_database_name input_float_left" name="site_database_name" placeholder="Database Name" />
				<input type="text" class="site_database_password input_float_left" name="site_database_password" placeholder="Database Password" />
			</div>
			<div class="border_separator"></div>
			<div class="add_website_buttons">				
				<div class="save_website button_1" />Add Website</div>
				<div style="display:none;" class="add_site_loader"></div>
			</div>
		</form>
	</div>
</div>
<?php get_footer(); ?>