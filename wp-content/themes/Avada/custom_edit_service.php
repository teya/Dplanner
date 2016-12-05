<?php /* Template name: Edit Service */ ?>
<?php get_header(); ?>
<?php
global $wpdb;
$id = $_GET['editID'];		
$table_name_services = $wpdb->prefix . "custom_services";
$table_name_service_options =  $wpdb->prefix . "custom_service_options";
$table_name_client = $wpdb->prefix . "custom_client";		
$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");
$services = $wpdb->get_results("SELECT * FROM {$table_name_services}");
$service_options = $wpdb->get_results("SELECT * FROM {$table_name_service_options}");
$query = "SELECT * FROM $table_name_services WHERE id=$id";

?>
<?php 
if(isset($_POST['submit'])):
	global $wpdb;
	// $service_client_id						= (isset($_POST['service_client_id']) ? $_POST['service_client_id'] : '');
	$service_id						= (isset($_POST['service_id']) ? $_POST['service_id'] : '');
	$service_licenses						= (isset($_POST['service_licenses']) ? $_POST['service_licenses'] : '');
	$service_customer_price				= (isset($_POST['service_customer_price']) ? $_POST['service_customer_price'] : '');
	$service_our_price				= (isset($_POST['service_our_price']) ? $_POST['service_our_price'] : '');
	$service_start_date			= (isset($_POST['service_start_date']) ? $_POST['service_start_date'] : '');
	$service_invoice_interval		= (isset($_POST['service_invoice_interval']) ? $_POST['service_invoice_interval'] : '');
	$service_notes = 	(isset($_POST['service_notes']) ? $_POST['service_notes'] : '');

	$service_info = $wpdb->get_row("SELECT * FROM ".$table_name_service_options." WHERE ID = ".$service_id);
		
	$update = $wpdb->update( $table_name_services , array( 
		'service_name'					=> $service_info->service_name,
		'licenses'					=> $service_licenses,
		'customer_price'				=> $service_customer_price,
		'our_price'				=> $service_our_price,
		'start_date'			=> $service_start_date,
		'invoice_interval'		=> $service_invoice_interval,
		'notes'				=> $service_notes
	), 
	array( 'ID' => $id ),
	array( '%s', '%s','%s', '%s','%s', '%s', '%s' ));
	
	if($update == 1):
		echo "<p class='message'>";
		echo "Service Updated!";
	else:
		echo "Service was not successfully updated.";
		echo "</p>";
	endif;
	
endif;
?>
<?php 
	$results_edit = $wpdb->get_row($query);
	$current_status_array = array('Planned', 'In progress', 'Paused', 'Complete');
	// $services = array('Wecloud','Kaseya Server', 'Kaseya Vserver', 'Kaseya Workstation', 'Webroot', 'Ahsey', 'Altaro Offline', 'Office 365', 'Ilait');
	$invoice_intervals  = array('1M', '3M', '6M', '1Y', 'Lifetime');

?>
<div class="add_services">
	<form action="" method="post" name="services" id="services">
		<div class="section">
			<div class="left">
				<p class="label">Client</p>
			</div>
			<div class="right">
				<select class="service_client_id" disabled="disabled" name="service_client_id">
					<?php foreach($clients as $client){ ?>
						<option <?php echo ($results_edit->client_id == $client->ID)? 'selected' : ''; ?> value="<?php echo $client->ID ?>"><?php echo $client->client_name; ?></option>					
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Service</p>
			</div>
			<div class="right">	
				<select class="service_name" id="service_name" name="service_id">
					<?php foreach($service_options as $service): ?>
						<option <?php echo ($results_edit->service_name == $service->service_name)? 'selected' : ' '; ?> value="<?php echo  $service->ID; ?>"><?php echo $service->service_name; ?></option>
					<?php endforeach;?>
					<option class="add-new-service" value="Add New Service Option">Add New Service</option>
				</select>
				<i class="fa fa-trash-o delete-service-option" title="Remove Option" aria-hidden="true"></i>
				<div style="display:none;" class="loader inline-element"></div>
				<div class="updating-service-status" style="display: none;">Successfully Deleting a Option.</div>
				<p class="error-msg service-error" style="display: none;">Please select service</p>				
			</div>
		</div>
		<div id="service_input" style="display: none;">
			<div class="border_separator"></div>		
			<div class="section">
				<div class="left">
					<p class="label">New Service</p>
				</div>
				<div class="right">
					<input type="text" name="service_add_new" class="service_add_new" />
					<input class="button_1" id="save_new_service" value="Add New Service" type="button">
				</div>
			</div>			
		</div>
		<div class="border_separator"></div>		
		<div class="section">
			<div class="left">
				<p class="label">Licenses</p>
			</div>
			<div class="right">
				<input type="text" name="service_licenses" class="service_licenses" value="<?php echo $results_edit->licenses; ?>" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Customer Price</p>
			</div>
			<div class="right">
				<input type="text" name="service_customer_price" class="service_customer_price" value="<?php echo $results_edit->customer_price; ?>" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">	
			<div class="left">
				<p class="label">Our Price</p>
			</div>
			<div class="right">
				<input type="text" name="service_our_price" class="service_our_price" value="<?php echo $results_edit->our_price; ?>"   />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">	
			<div class="left">
				<p class="label">Start Date</p>
			</div>
			<div class="right">
				<input type="text" name="service_start_date" class="service_start_date datepicker" value="<?php echo $results_edit->start_date; ?>" >
			</div>
		</div>		
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Invoice Interval</p>
			</div>
			<div class="right">	
				<select class="service_invoice_interval" name="service_invoice_interval">
					<?php foreach($invoice_intervals as $invoice_interval => $value): ?>
						<option <?php echo ($results_edit->invoice_interval ==  $value)? 'selected' : ''; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php 	
						endforeach;
					?>
				</select>		
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">	
			<div class="left">
				<p class="label">Notes</p>
			</div>
			<div class="right">
				<textarea name="service_notes" class="service_notes textarea_wide"><?php echo $results_edit->notes; ?></textarea>
			</div>
		</div>
		<input type="submit" id="submit-form-add-service" name="submit" class="button_1" value="Update Service" />
		<a class="button_2" href="<?php echo get_site_url(); ?>/manage-services/services/">Cancel</a>
	</form>
</div>
</div>
<?php require_once('function_service_js.php'); ?>
<?php get_footer(); ?>