<?php /* Template name: Add Switch */ ?>
<?php
get_header();
			global $wpdb;
$table_name = $wpdb->prefix . "custom_switch";
?>
<div class="add_switch">
	<form action="" method="post" name="add_switch" id="add_switch">
		<div class="section">
			<div class="left">
				<p class="label">Brand</p>
			</div>
			<div class="right">
				<input type="text" class="switch_brand" name="switch_brand" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Model</p>
			</div>
			<div class="right">
				<input type="text" class="switch_model" name="switch_model" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">IP Address</p>
			</div>
			<div class="right">
				<input type="text" class="switch_ip_address" name="switch_ip_address" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Firmware</p>
			</div>
			<div class="right">
				<input type="text" class="switch_firmware" name="switch_firmware" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Purchase Date</p>
			</div>
			<div class="right">
				<input type="text" class="switch_purchase_date" name="client_service_agreement"></input>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Notes</p>
			</div>
			<div class="right">
				<textarea name="switch_notes" class="switch_notes textarea_wide"></textarea>
			</div>
		</div>
		<div class="border_separator"></div>
		<input type="submit" name="submit" class="button_1" value="Add Switch" />
		<a class="button_2" href="/switch/">Cancel</a>
	</form>
</div>
<?php
if(isset($_POST['submit'])):
	global $wpdb;

	$switch_brand						= (isset($_POST['switch_brand']) ? $_POST['switch_brand'] : '');
	$switch_model						= (isset($_POST['switch_model']) ? $_POST['switch_model'] : '');
	$switch_ip_address					= (isset($_POST['switch_ip_address']) ? $_POST['switch_ip_address'] : '');
	$switch_firmware					= (isset($_POST['switch_firmware']) ? $_POST['switch_firmware'] : '');
	$switch_purchase_date				= (isset($_POST['switch_purchase_date']) ? $_POST['switch_purchase_date'] : '');
	$switch_notes						= (isset($_POST['switch_notes']) ? $_POST['switch_notes'] : '');
		
	$insert = $wpdb->insert( $table_name , array(
		'switch_brand'						=> $switch_brand,
		'switch_model'						=> $switch_model,
		'switch_ip_address'					=> $switch_ip_address,
		'switch_firmware'					=> $switch_firmware,
		'switch_purchase_date'				=> $switch_purchase_date,
		'switch_notes'						=> $switch_notes
	), array( '%s', '%s' ));
	
	if($insert == 1):
		echo "<p class='message'>";
		echo "Switch Added!";
	else:
		echo "Switch was not successfully added.";
		echo "</p>";
	endif;
	
endif;
?>
<?php get_footer(); ?>