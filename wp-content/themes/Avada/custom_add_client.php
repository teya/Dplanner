<?php /* Template name: Add Client */ ?>
<?php 
get_header(); 
global $wpdb;			
$table_name = $wpdb->prefix . "custom_client";
$table_name_service_options = $wpdb->prefix . "custom_service_options";	
$table_consultant = $wpdb->prefix . "custom_person";
$table_project = $wpdb->prefix . "custom_project";
$table_project_main = $wpdb->prefix . "custom_project_main";
$tasks = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."custom_task");
// $projects = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."custom_project GROUP BY project_name");
$projects = $wpdb->get_results("SELECT * FROM {$table_name_project} WHERE project_client_id = '{$clients[0]->ID}'");
$services = $wpdb->get_results("SELECT * FROM {$table_name_service_options}");
$consultants = $wpdb->get_results("SELECT * FROM {$table_consultant}");
$query_get_next_id = $wpdb->get_results("SELECT MAX(ID) as ID FROM {$table_name}");
$next_client_id = $query_get_next_id[0]->ID + 1;

?>
<?php
if(isset($_POST['submit'])):

	global $wpdb;
	$client_name						= (isset($_POST['client_name']) ? $_POST['client_name'] : '');
	$client_address						= (isset($_POST['client_address']) ? $_POST['client_address'] : '');
	$client_website						= (isset($_POST['client_website']) ? $_POST['client_website'] : '');
	$client_phone_number				= (isset($_POST['client_phone_number']) ? $_POST['client_phone_number'] : '');
	$client_contact_person				= (isset($_POST['client_contact_person']) ? $_POST['client_contact_person'] : '');
	$client_service_agreement			= (isset($_POST['client_service_agreement']) ? $_POST['client_service_agreement'] : '');
	$client_maintenance_schedule		= (isset($_POST['client_maintenance_schedule']) ? $_POST['client_maintenance_schedule'] : '');
	$client_maintenance_hours			= (isset($_POST['client_maintenance_hours']) ? $_POST['client_maintenance_hours'] : '');
	$client_start_date					= (isset($_POST['client_start_date']) ? $_POST['client_start_date'] : '');
	$client_next_schedule_maintenance	= (isset($_POST['client_next_schedule_maintenance']) ? $_POST['client_next_schedule_maintenance'] : '');
	$client_default_task				= (isset($_POST['client_default_task']) ? $_POST['client_default_task'] : '');
	$client_internet_service_provider	= (isset($_POST['client_internet_service_provider']) ? $_POST['client_internet_service_provider'] : '');
	$client_phone_company				= (isset($_POST['client_phone_company']) ? $_POST['client_phone_company'] : '');
	$client_external_ip_numbers			= (isset($_POST['client_external_ip_numbers']) ? $_POST['client_external_ip_numbers'] : '');
	$client_external_dns_name			= (isset($_POST['client_external_dns_name']) ? $_POST['client_external_dns_name'] : '');
	$client_remote_connection			= (isset($_POST['client_remote_connection']) ? $_POST['client_remote_connection'] : '');
	$client_accounts_info				= (isset($_POST['client_accounts_info']) ? $_POST['client_accounts_info'] : '');
	$client_notes						= (isset($_POST['client_notes']) ? $_POST['client_notes'] : '');
	$client_asset						= (isset($_POST['client_asset']) ? $_POST['client_asset'] : '');
	$client_default_project				= (isset($_POST['client_default_project']) ? $_POST['client_default_project'] : '');
	$client_default_consultant_id		= (isset($_POST['client_default_consultant_id']) ? $_POST['client_default_consultant_id'] : '');
	$client_hourly_rate 				= (isset($_POST['client_hourly_rate']) ? $_POST['client_hourly_rate'] : '');
		
	$insert = $wpdb->insert( $table_name , array( 
	'client_name'						=> $client_name,
	'client_address'					=> $client_address,
	'client_website'					=> $client_website,
	'client_phone_number'				=> $client_phone_number,
	'client_contact_person'				=> $client_contact_person,
	'client_service_agreement'			=> $client_service_agreement,
	'client_maintenance_schedule'		=> $client_maintenance_schedule,
	'client_maintenance_hours'			=> $client_maintenance_hours,
	'client_start_date'					=> $client_start_date,
	'client_next_schedule_maintenance'	=> $client_next_schedule_maintenance,
	'client_default_task'				=> $client_default_task,
	'client_internet_service_provider'	=> $client_internet_service_provider,
	'client_phone_company'				=> $client_phone_company,
	'client_external_ip_numbers'		=> $client_external_ip_numbers,
	'client_external_dns_name'			=> $client_external_dns_name,
    'client_remote_connection'          => serialize($client_remote_connection),
	'client_accounts_info'				=> $client_accounts_info,
	'client_notes'						=> $client_notes,
	'client_asset'						=> $client_asset,
	'client_default_project'			=> $client_default_project,
	'client_default_consultant_id'		=> $client_default_consultant_id,
	'client_hourly_rate' 				=> $client_hourly_rate
	), array( '%s', '%s' ));

	if($insert == 1):

		$new_client_id = $wpdb->insert_id;
	
		$auto_project_id  = array('1','2');

		foreach ($auto_project_id as $project_id) {
		$auto_project = $wpdb->get_row('SELECT * FROM '.$table_project_main.' WHERE ID = '.$project_id);
		$default_consultant = $wpdb->get_row('SELECT * FROM '.$table_consultant.' WHERE ID = '.$client_default_consultant_id);

		$insert_project = $wpdb->insert( $table_project , array( 
			'project_client'		 		=> $client_name,
			'project_client_id' 			=> $new_client_id,
			'project_name'					=> $auto_project->project_name,
			'project_start_date' 			=> $auto_project->project_start_date,
			'project_estimated_deadline' 	=> ($auto_project->project_estimated_deadline)? $auto_project->project_estimated_deadline : '',
			'project_main_consultant'		=> $default_consultant->person_fullname,
			'project_billable' 				=> $auto_project->project_billable,
			'project_estimated_hours' 		=> ($auto_project->project_estimated_hours)? $auto_project->project_estimated_hours : '',
			'project_fixed_price' 			=> ($auto_project->project_fixed_price)? $auto_project->project_fixed_price : '',
			'project_description'			=> ($auto_project->project_description)? $auto_project->project_description : '',
			'project_current_status'		=> ($auto_project->project_current_status)? $auto_project->project_current_status : '',
		), array( '%s', '%s' ));
		if($insert_project == 1):
				// echo "<p class='message'>";
				// echo "Client Added!";
			else:
				echo "Client Default Projects was not successfully added.";
				echo "</p>";
			endif;
		 }

		echo "<p class='message'>";
		echo "Client Added!";
	else:
		echo "Client was not successfully added.";
		echo "</p>";
	endif;


	
endif;

$service_agreements = array('Yes', 'No');
$maintenance_schedules = array('1W', '2W','1M', '2M','3M','4M','6M');
$remote_connections = array('RDP', 'Teamviewer', 'Kaseya', 'VPN');

?>
<div class="add_client">
	<?php 
		// echo '<pre>';
		// print_r($projects);
		// echo '</pre>'; 
	?>
	<form action="" method="post" name="add_client_form" id="add_client_form">
		<div class="section">
			<div class="left">
				<p class="label">Name</p>
			</div>
			<div class="right">
				<input type="text" class="client_name" name="client_name" />
				<input type="hidden" id="client_next_id" value="<?php echo $next_client_id; ?>">
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Address</p>
			</div>
			<div class="right">
				<textarea name="client_address" class="client_address textarea_medium"></textarea>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Website</p>
			</div>
			<div class="right">
				<input type="text" class="client_website" name="client_website" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
			<div class="left">
				<p class="label">Contact Person</p>
				<input type="text" class="client_contact_person" name="client_contact_person" />
			</div>
			<div class="right">
				<p class="label">Phone Number</p>
				<input type="text" class="client_phone_number" name="client_phone_number" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
			<div class="left">
				<p class="label">Service Agreement</p>
				<select type="text" class="client_service_agreement" name="client_service_agreement">
					<?php foreach($service_agreements as $service_agreement){ ?>
						<option value="<?php echo $service_agreement; ?>"><?php echo $service_agreement; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="right">
				<p class="label">Default Task</p>
				<select name="client_default_task" id="">
					<?php foreach($tasks as $task){ ?>
						<option value="<?php echo $task->ID; ?>"><?php echo $task->task_name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
			<div class="left">			
				<p class="label">Maintenance Schedule</p>
				<select type="text" class="client_maintenance_schedule" name="client_maintenance_schedule">
					<?php foreach($maintenance_schedules as $maintenance_schedule){  ?>
						<option value="<?php echo $maintenance_schedule; ?>"><?php echo $maintenance_schedule; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="right">
				<p class="label">Maintenance Hours</p>
				<input type="text" class="client_maintenance_hours" name="client_maintenance_hours" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
<!-- 			<div class="left">
				<p class="label">Default Projects</p>
				<select name="client_default_project" class="client_default_project">
					<?php foreach($projects as $project){  ?>
						<option value="<?php echo $project->ID; ?>"><?php echo $project->project_name; ?></option>
					<?php } ?>
				</select>
			</div> -->
			<div class="left">
				<p class="label">Main Consultant</p>
				<select name="client_default_consultant_id" class="client_default_project">
					<?php foreach($consultants as $consultant){  ?>
						<option value="<?php echo $consultant->ID; ?>"><?php echo $consultant->person_fullname; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
			<div class="left">
				<p class="label">Start Date</p>
				<input type="text" class="client_start_date datepicker" name="client_start_date" />
			</div>
			<div class="right">
				<p class="label">Hourly Rate</p>
				<input type="text" class="client_hourly_rate" name="client_hourly_rate" />				
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Next Schedule Maintenance</p>
			</div>
			<div class="right">
				<input type="text" class="client_next_schedule_maintenance datepicker" name="client_next_schedule_maintenance" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
			<div class="left">
				<p class="label">Internet Service Provider</p>
				<input type="text" class="client_internet_service_provider" name="client_internet_service_provider" />
			</div>
			<div class="right">
				<p class="label">Phone Company</p>
				<input type="text" class="client_phone_company" name="client_phone_company" />
			</div>
		</div>
		<div class="border_separator"></div>		
		<div class="section multiple_input">
			<div class="left">
				<p class="label">External IP Numbers</p>
				<input type="text" class="client_external_ip_numbers" name="client_external_ip_numbers" />
			</div>
			<div class="right">
				<p class="label">External DNS Name</p>
				<input type="text" class="client_external_dns_name" name="client_external_dns_name" />
			</div>
		</div>
		<div class="border_separator"></div>		
		<div class="section">
			<div class="left">
				<p class="label">Remote Connection</p>
			</div>
			<div class="right">
				<?php foreach($remote_connections as $remote_connection){ ?>
					<input type="checkbox" name="client_remote_connection[]" class="client_remote_connection check_box" value="<?php echo $remote_connection ?>"><p class="check_box_label"><?php echo $remote_connection ?></p>
				<?php } ?>
			</div>
		</div>
		<div class="border_separator"></div>		
		<div class="section">
			<div class="left">
				<p class="label">Accounts Info</p>
			</div>
			<div class="right">
				<textarea name="client_accounts_info" class="client_accounts_info textarea_wide"></textarea>
			</div>
		</div>
		<div class="border_separator"></div>		
		<div class="section">
			<div class="left">
				<p class="label">Notes</p>
			</div>
			<div class="right">
				<textarea name="client_notes" class="client_notes textarea_wide"></textarea>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Services</p>
			</div>
			<div class="right">
				<select type="text" class="client_service_selection" name="client_service_selection">
					<option>-- Services --</option>	

					<?php
						foreach($services as $service):
							echo '<option value="'.$service->service_name.'">'.$service->service_name.'</option>'; 
						endforeach;
					?>
					<option class="add-new-service" value="Add New Service Option">Add New Service</option>					
				</select>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Asset</p>
			</div>
			<div class="right">
				<select type="text" class="client_asset_selection" name="client_asset_selection">
					<option>-- Asset --</option>			
					<option>Server Physical</option>
					<option>Server Virtual</option>				
					<option>Switch</option>				
					<option>Firewall</option>				
					<option>Printer</option>				
					<option>NAS</option>				
					<option>UPS</option>				
					<option>Tape Backup</option>				
				</select>
			</div>
		</div>
        <div id="service_counter_container" class="service_counter_container"></div>
        <div id="client_services_container"></div>
        <div id="asset_counter_container" class="asset_counter_container"></div>
        <div class="asset_container"></div>
		<input type="hidden" class="client_asset" name="client_asset" value="" />
		<input type="submit" name="submit" class="button_1" value="Add Client" />
		<a class="button_2" href="<?php echo get_site_url(); ?>/client/">Cancel</a>
	</form>
</div>
<?php require_once('custom_dialog_client.php'); ?>
<?php get_footer(); ?>