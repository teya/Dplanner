<?php /* Template Name: Edit Client */ ?>
<?php get_header();
global $wpdb;			
$id = $_GET['editID'];
$table_name = $wpdb->prefix . "custom_client";
$table_name_monthly_plan = $wpdb->prefix . "custom_monthly_plan";
$table_consultant = $wpdb->prefix . "custom_person";
$table_name_service_options = $wpdb->prefix . "custom_service_options";
$table_client_services = 'wp_custom_services';
$client_services = $wpdb->get_results("SELECT * FROM {$table_client_services} WHERE client_id = ". $id);
$monthly_plans = $wpdb->get_results("SELECT * FROM {$table_name_monthly_plan}");
$query = "SELECT * FROM $table_name WHERE id=$id";
$tasks = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."custom_task");
// $projects = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."custom_project GROUP BY project_name");
$projects = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."custom_project  WHERE project_client_id = '{$id}'");
$services = $wpdb->get_results("SELECT * FROM {$table_name_service_options}");
$consultants = $wpdb->get_results("SELECT * FROM {$table_consultant}");

 ?>
<?php
if(isset($_POST['submit'])):
	$client_name						= $_POST['client_name'];
	$client_address						= $_POST['client_address'];
	$client_website						= $_POST['client_website'];
	$client_phone_number				= $_POST['client_phone_number'];
	$client_contact_person				= $_POST['client_contact_person'];
	$client_service_agreement			= $_POST['client_service_agreement'];
	$client_maintenance_schedule		= $_POST['client_maintenance_schedule'];
	$client_maintenance_hours			= $_POST['client_maintenance_hours'];
	$client_start_date					= $_POST['client_start_date'];
	$client_next_schedule_maintenance	= $_POST['client_next_schedule_maintenance'];
	$client_default_task				= $_POST['client_default_task'];
	$client_internet_service_provider	= $_POST['client_internet_service_provider'];
	$client_phone_company				= $_POST['client_phone_company'];
	$client_external_ip_numbers			= $_POST['client_external_ip_numbers'];
	$client_external_dns_name			= $_POST['client_external_dns_name'];
	$client_remote_connection			= $_POST['client_remote_connection'];
	$client_accounts_info				= $_POST['client_accounts_info'];
	$client_notes						= $_POST['client_notes'];
	$client_asset						= $_POST['client_asset'];
	$client_default_project				= $_POST['client_default_project'];
	$client_hourly_rate					= $_POST['client_hourly_rate'];
	$client_default_consultant_id		= $_POST['client_default_consultant_id'];

	
	$update = $wpdb->update( $table_name , array( 
	'client_name'						=> $client_name,
	'client_address'					=> $client_address,
	'client_website'					=> $client_website,
	'client_phone_number'				=> $client_phone_number,
	'client_contact_person'				=> $client_contact_person,
	'client_service_agreement'			=> $client_service_agreement,
	'client_maintenance_hours'			=> $client_maintenance_hours,
	'client_maintenance_schedule'		=> $client_maintenance_schedule,
	'client_start_date'					=> $client_start_date,
	'client_next_schedule_maintenance'	=> $client_next_schedule_maintenance,
	'client_default_task'				=> $client_default_task,
	'client_internet_service_provider'	=> $client_internet_service_provider,
	'client_phone_company'				=> $client_phone_company,
	'client_external_ip_numbers'		=> $client_external_ip_numbers,
	'client_external_dns_name'			=> $client_external_dns_name,
	'client_remote_connection'			=> serialize($client_remote_connection),
	'client_accounts_info'				=> $client_accounts_info,
	'client_notes'						=> $client_notes,
	'client_asset'						=> $client_asset,
	'client_default_project'			=> $client_default_project,
	'client_hourly_rate'				=> $client_hourly_rate,
	'client_default_consultant_id'		=> $client_default_consultant_id
	),
	array( 'ID' => $id ),
	array( '%s', '%s' ));	
	if($update == 1):
		echo "<p class='message'>";
		echo "Client Updated!";
		echo "</p>";
	else:
		echo "<p class='message'>";
		echo "Client was not successfully Updated.";
		echo "</p>";
	endif;		
endif;
$results_edit = $wpdb->get_row($query);

$service_agreements = array('Yes', 'No');
$maintenance_schedules = array('1W', '2W','1M', '2M','3M','4M','6M');
$remote_connections = array('RDP', 'Teamviewer', 'Kaseya', 'VPN');
// echo '<pre>';
// print_r($client_services);
// echo '</pre>';
?>
<div class="edit_client">
	<form action="" method="post" name="client" id="client">
		<div class="section">
			<div class="left">
				<p class="label">Name</p>
			</div>
			<div class="right">
				<input type="text" readonly="readonly" class="client_name" name="client_name" value="<?php echo (isset($results_edit->client_name)) ? $results_edit->client_name : '';  ?>"/>
				<input type="hidden" id="client_next_id" value="<?php echo $id; ?>">
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Address</p>
			</div>
			<div class="right">
				<textarea name="client_address" class="client_address textarea_medium"><?php echo (isset($results_edit->client_address)) ? $results_edit->client_address : '';  ?></textarea>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Website</p>
			</div>
			<div class="right">
				<input type="text" class="client_website" name="client_website" value="<?php echo (isset($results_edit->client_website)) ? $results_edit->client_website : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">			
			
			<div class="left">
				<p class="label">Contact Person</p>
				<input type="text" class="client_contact_person" name="client_contact_person" value="<?php echo (isset($results_edit->client_contact_person)) ? $results_edit->client_contact_person : '';  ?>"/>
				
			</div>
			<div class="right">
				<p class="label">Phone Number</p>
				<input type="text" class="client_phone_number" name="client_phone_number" value="<?php echo (isset($results_edit->client_phone_number)) ? $results_edit->client_phone_number : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
			<div class="left">
				<p class="label">Service Agreement</p>
				<select class="client_service_agreement" name="client_service_agreement">
					<option value="<?php echo (isset($results_edit->client_service_agreement)) ? $results_edit->client_service_agreement : '';  ?>"><?php echo $results_edit->client_service_agreement; ?></option>					
					<?php 
					foreach($service_agreements as $service_agreement){
						if($service_agreement != $results_edit->client_service_agreement){
					?>
						<option value="<?php echo $service_agreement; ?>"><?php echo $service_agreement; ?></option>
					<?php 
						}
					}
					?>
				</select>				
			</div>
			<div class="right">
				<p class="label">Default Task</p>
				<select name="client_default_task" id="">
					<?php foreach($tasks as $task){ ?>
						<option <?php echo ($results_edit->client_default_task == $task->ID)? 'selected' : '';  ?> value="<?php echo $task->ID; ?>"><?php echo $task->task_name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
			<div class="left">
				<p class="label">Maintenance Schedule</p>
				<select class="client_maintenance_schedule" name="client_maintenance_schedule">
					<option value="<?php echo (isset($results_edit->client_maintenance_schedule)) ? $results_edit->client_maintenance_schedule : '';  ?>"><?php echo $results_edit->client_maintenance_schedule; ?></option>					
					<?php 
					foreach($maintenance_schedules as $maintenance_schedule){
						if($maintenance_schedule != $results_edit->client_maintenance_schedule){
					?>
						<option value="<?php echo $maintenance_schedule; ?>"><?php echo $maintenance_schedule; ?></option>
					<?php 
						}
					}
					?>
				</select>				
			</div>
			<div class="right">
				<p class="label">Maintenance Hours</p>
				<input type="text" class="client_maintenance_hours" name="client_maintenance_hours" value="<?php echo (isset($results_edit->client_maintenance_hours)) ? $results_edit->client_maintenance_hours : '';  ?>"/>
			</div>
		</div>
			<div class="border_separator"></div>
			<div class="section multiple_input">
			<div class="left">
				<p class="label">Main Consultant</p>
				<select name="client_default_consultant_id" class="client_default_project">
					<?php foreach($consultants as $consultant){  ?>
						<?php $selected = ($results_edit->client_default_consultant_id == $consultant->ID)? 'selected' : ''; ?>
						<option <?php echo $selected; ?> value="<?php echo $consultant->ID; ?>"><?php echo $consultant->person_fullname; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="right">

			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
			<div class="left">
				<p class="label">Default Project</p>
				<select name="client_default_project" class="client_default_project">
					<?php foreach($projects as $project){  ?>
						<option <?php echo ($results_edit->client_default_project ==  $project->ID)? 'selected' : ''; ?>  value="<?php echo $project->ID; ?>"><?php echo $project->project_name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="right">
				<p class="label">Hourly Rate</p>
				<input type="text" class="client_hourly_rate" name="client_hourly_rate" value="<?php echo (isset($results_edit->client_hourly_rate)) ? $results_edit->client_hourly_rate : '';  ?>"/>	
			</div>
		</div>	
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Start Date</p>
			</div>
			<div class="right">
				<input type="text" class="client_start_date datepicker" name="client_start_date" value="<?php echo (isset($results_edit->client_start_date)) ? $results_edit->client_start_date : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Next Schedule Maintenance</p>
			</div>
			<div class="right">
				<input type="text" class="client_next_schedule_maintenance datepicker" name="client_next_schedule_maintenance" value="<?php echo (isset($results_edit->client_next_schedule_maintenance)) ? $results_edit->client_next_schedule_maintenance : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
			<div class="left">
				<p class="label">Internet Service Provider</p>
				<input type="text" class="client_internet_service_provider" name="client_internet_service_provider" value="<?php echo (isset($results_edit->client_internet_service_provider)) ? $results_edit->client_internet_service_provider : '';  ?>"/>
			</div>
			<div class="right">
				<p class="label">Phone Company</p>
				<input type="text" class="client_phone_company" name="client_phone_company" value="<?php echo (isset($results_edit->client_phone_company)) ? $results_edit->client_phone_company : '';  ?>"/>				
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section multiple_input">
			<div class="left">
				<p class="label">External IP Numbers</p>
				<input type="text" class="client_external_ip_numbers" name="client_external_ip_numbers" value="<?php echo (isset($results_edit->client_external_ip_numbers)) ? $results_edit->client_external_ip_numbers : '';  ?>"/>
			</div>
			<div class="right">
				<p class="label">External DNS Name</p>
				<input type="text" class="client_external_dns_name" name="client_external_dns_name" value="<?php echo (isset($results_edit->client_external_dns_name)) ? $results_edit->client_external_dns_name : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Remote Connection</p>
			</div>
			<div class="right">
				<?php 
					$client_remote_connection = unserialize($results_edit->client_remote_connection);
					if(is_string($client_remote_connection)){
						$client_remote_connection = array($client_remote_connection);
					}
					foreach($remote_connections as $remote_connection){
				?>
					<input type="checkbox" name="client_remote_connection[]" class="client_remote_connection check_box" value="<?php echo $remote_connection ?>"<?php echo $client_remote_connection != null ? (in_array($remote_connection, $client_remote_connection) ? 'checked="checked"': '') : ''; ?>><p class="check_box_label"><?php echo $remote_connection ?></p>
				<?php 
					} 
				
				?>				
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Accounts Info</p>
			</div>
			<div class="right">
				<textarea name="client_accounts_info" class="client_accounts_info textarea_wide"><?php echo (isset($results_edit->client_accounts_info)) ? $results_edit->client_accounts_info : '';  ?></textarea>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Notes</p>
			</div>
			<div class="right">
				<textarea name="client_notes" class="client_notes textarea_wide"><?php echo (isset($results_edit->client_notes)) ? $results_edit->client_notes : '';  ?></textarea>
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
        	<div id="client_services_container">
        		<?php
	        		if(count($client_services) >= 1){
	        			echo '<div class="service_group service_separator">';
	        			echo '<p class="service_title label">Service</p>';
	        			foreach($client_services as $client_service):
	        				$cleint_services_string = ''; 
	        				$cleint_services_string .= '<ul id="service_id_'.$client_service->ID.'" class="service_group_separator">';
	        				$cleint_services_string .= '<li><p class="label">Service</p><p class="input_value">'.$client_service->service_name.'</p></li>';
	        				$cleint_services_string .= '<li><p class="label">Licenses</p><p class="input_value">'.$client_service->licenses.'</p></li>';
	        				$cleint_services_string .= '<li><p class="label">Customer Price</p><p class="input_value">'.$client_service->customer_price.'</p></li>';
	        				$cleint_services_string .= '<li><p class="label">Our Price</p><p class="input_value">'.$client_service->our_price.'</p></li>';
	        				$cleint_services_string .= '<li><p class="label">Star Date</p><p class="input_value">'.$client_service->start_date.'</p></li>';
	        				$cleint_services_string .= '<li><p class="label">Invoice Interval</p><p class="input_value">'.$client_service->invoice_interval.'</p></li>';
	        				$cleint_services_string .= '<li><p class="label">Notes</p><p class="input_value">'.$client_service->notes.'</p></li>';
	        				$cleint_services_string .= '<div class="edit_service_group button_1" id="edit_service_'.$client_service->ID.'">Edit</div>';
	        				$cleint_services_string .= '</ul>';
	        				echo $cleint_services_string;
	        			endforeach;
	        			echo '</div>';
	        		}
        		?>
        	</div>
			<div class="asset_counter_container"></div>
			<div class="asset_container">				
				<?php 
					$client_asset = stripslashes($results_edit->client_asset);	
					$json_decode = json_decode('[' .$client_asset. ']');
					
					$group_assets_array = array();
					foreach($json_decode as $key => $assets){
					if (is_array($assets) || is_object($assets)){
							foreach($assets as $asset_type_counter => $asset){
								$asset_type = $asset->asset_type;
								$asset_type = str_replace('asset_', "", $asset_type);
								$group_assets_array[$asset_type][] = $assets;
							}
						}	
					}
					foreach($group_assets_array as $asset_type => $json_decode){
						echo '<div class="asset_separator asset_group asset_'.$asset_type.'">';
						$asset_type_title = str_replace('_', " ", $asset_type);
						echo '<p class="asset_title label">'. ucwords($asset_type_title) .'</p>';
						foreach($json_decode as $key => $assets){ 
							foreach($assets as $asset_type_counter => $asset){
								echo '<ul class="asset_groups '.$asset_type_counter.'">';
								foreach($asset as $input_title => $input_value){
									$title_filter = str_replace($asset_type .'_', "", $input_title);
									$title = str_replace('_', " ", $title_filter);
									if($input_title != 'asset_type_counter' && $input_title != 'asset_type' && $input_title != 'other_option_input'){
										echo '<li><p class="label">'.ucwords($title).': </p><p class="input_value">'.(is_array($input_value) ? implode(', ', $input_value) : $input_value).'</p></li>';
									}
								}
								echo '<div id="edit_'. $asset_type_counter.'" class="edit_asset_group button_1">Edit</div>';
								echo '</ul>';
							}
						}
						echo '</div>';
					}
				?>				
			</div>
		</div>
		<input type="hidden" class="client_asset" name="client_asset" value="<?php echo htmlentities($client_asset); ?>" />
		<input type="submit" name="submit" class="add_client button_1" value="Update Client" />
		<a class="button_2" href="<?php echo get_site_url(); ?>/client/">Cancel</a>
	</form>
</div>
<?php require_once('custom_dialog_client.php'); ?>	
<?php get_footer(); ?>