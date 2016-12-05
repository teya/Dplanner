<!-- ==================================== ASSET DIALOG ==================================== -->
<?php 
global $wpdb;
$options_table = $wpdb->prefix . "custom_client_assets_options";

//Get All inputs fields data
$get_options_fields = $wpdb->get_results( 'SELECT * FROM '. $options_table . '');

//Loop to all input fields
foreach ($get_options_fields as $option_field) {

	// GEt Server Roles
	if($option_field->input_field == 'server_roles'){
		$server_roles = unserialize($option_field->data_fields);
	}
	// GEt Server Softwares
	if($option_field->input_field == 'server_softwares'){
		$server_softwares = unserialize($option_field->data_fields);
	}
	//Get Server OS
	if($option_field->input_field == 'server_os'){
		$server_os = unserialize($option_field->data_fields);
	}	
}

?>
<!-- Client Services -->
<div style="display: none;" class="service_dialog"  id="dialog_form_service" title="Service">
	<form name="client_service" id="client_service">
		<div class="submit_section">
			<div class="submit_left">
				<label for="service_name">Service</label>
				<input type="text" class="service_name" name="service_name" />
				<input type="hidden" id="client_id" name="client_id">
				<input type="hidden" id="new_service_option" name="new_service_option" value='0'>
				<input type="hidden" id="service_id" name="service_id">
			</div>
			<div class="submit_right">
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="service_licenses">Licenses</label>
				<input type="text" class="service_licenses" name="service_licenses" />
			</div>
			<div class="submit_right">
				<label for="service_customer_price">Customer Price</label>
				<input type="text" class="service_customer_price" name="service_customer_price" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="service_our_price">Our Price</label>
				<input type="text" class="service_our_price" name="service_our_price"  />
			</div>
			<div class="submit_right">
				<label for="service_start_date">Start Date</label>
				<input type="text" class="service_start_date datepicker" name="service_start_date" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="service_invoice_interval">Invoice Interval</label>
				<select name="service_invoice_interval" id="service_invoice_interval">
					<option value="1M">1M</option>
					<option value="3M">3M</option>
					<option value="6M">6M</option>
					<option value="1Y">1Y</option>
				</select>
			</div>
			<div class="submit_right">
		
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="service_notes">Notes</label>
				<textarea name="service_notes" class="service_notes textarea_wide" ></textarea>
			</div>
		</div>		
		<div class="cancel_dialog button_2 dialog_button">Cancel</div>
		<div id="add_service_to_client" class="add_service button_1 dialog_button">Add Service</div>
		<div style="display:none;" class="service_dialog_loader loader"></div>
	</form>
</div>	

<!-- Physical Server Dialog -->
<div style="display: none;" class="asset_dialog" id="dialog_form_asset_server" title="Asset: Physical Server">
	<form name="asset_server_form" id="asset_server_form">
		<div class="submit_section">
			<div class="submit_left">
				<label for="server_com_name">Computer Name:</label>
				<input type="text" class="server_brand" name="server_com_name" />
				<input type="hidden" class="server_physical_virtual" name="server_physical_virtual" value="Physical" />
			</div>
			<div class="submit_middle">
				<label for="server_brand">Brand</label>
				<input type="text" class="server_brand" name="server_brand" />
			</div>
			<div class="submit_right">
				<label for="server_model">Model</label>
				<input type="text" class="server_model" name="server_model"/>
			</div>
		</div>
		<div class="submit_section">			
			<div class="estimated_time submit_left">
				<label for="server_disk">Server Disk Configuation</label>
				<input type="text" class="server_disk" name="server_disk" />
			</div>
			<div class="submit_middle">
				<label for="server_memory">Total Memory</label>
				<input type="text" class="server_memory" name="server_memory" />
			</div>
			<div class="submit_right">
				<label for="memory_modues">Memory modules</label>
				<input type="text" class="memory_modues" name="memory_modues" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="server_carepack">Carepack</label>
				<select class="server_carepack required full_width" name="server_carepack">
					<option value="Yes">Yes</option>
					<option value="No" selected="selected">No</option>
				</select>
				<div id="server_carepack_expiration_date" class="submit_section" style="display: none;">
					<label for="server_carepack_expiration_date">Carepack Expiration Date</label>
					<input type="text" class="server_carepack_expiration_date datepicker" name="server_carepack_expiration_date">
				</div>
			</div>
			<div class="submit_middle">
				<label for="server_ip_address">IP Address</label>
				<input type="text" class="server_ip_address" name="server_ip_address" required pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" />			
			</div>
			<div class="submit_right">
				<label for="server_ip_address">ILO IP Address</label>
				<input type="text" class="server_ip_address" name="server_ilo_ip_address" required pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" />		
			</div>			
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="server_ip_address">ILO External URL</label>
				<input type="text" class="server_ip_address" name="server_ilo_external_url" required />	
			</div>
			<div class="submit_middle">
				<label for="server_os">Operating System</label>
				<select id="server_os" class="server_os full_width" name="server_os">
					<?php 
						foreach ($server_os as $os) {
							echo '<option value="'. $os .'">'. $os .'</option>';
						}
					?>
					<option class="server_os other_option" value="Operating System">Other</option>
				</select>
			</div>
			<div class="submit_right">
				<label for="server_installation_date">Installation Date</label>
				<input type="text" class="server_installation_date datepicker" name="server_installation_date" />
			</div>
		</div>		
		<div class="submit_section">			
			<div class="submit_left">
				<label for="server_purchase_date">Purchase Date</label>
				<input type="text" class="server_purchase_date datepicker" name="server_purchase_date" />
			</div>
			<div class="submit_middle">
				<label for="server_serial_number">Serial Number</label>
				<input type="text" class="server_serial_number" name="server_serial_number" />
			</div>
			<div class="submit_right">
				<label for="server_warranty">Warranty <em>(0=Lifetime)</em></label>
				<input type="text" class="server_warranty" name="server_warranty" placeholder="Number of Years" />
			</div>
		</div>
		<div class="submit_section">			
			<div class="submit_left">
				<label class="check_box_title">Server Roles</label>				
				<?php foreach ($server_roles as $role) { ?>
						<div class="two_column">
							<input type="checkbox" name="server_roles[]" class="server_roles check_box" value="<?php echo $role; ?>">
							<p class="check_box_label"><?php echo $role; ?></p>
						</div>
				<?php }	?>
				<input type="checkbox" name="server_roles" class="server_roles check_box other_option" value="Server Roles">
				<p class="check_box_label">Other</p>
			</div>
			<div class="submit_middle">
				<label class="check_box_title">Software</label>				
				<?php foreach ($server_softwares as $software) { ?>
						<div class="two_column">
							<input type="checkbox" name="server_softwares[]" class="server_softwares check_box" value="<?php echo $software; ?>">
							<p class="check_box_label"><?php echo $software; ?></p>
						</div>
				<?php }	?>
				<input type="checkbox" name="server_softwares" class="server_softwares check_box other_option" value="Software">
				<p class="check_box_label">Other</p>	
			</div>
			<div class="submit_right">
				<label for="server_notes">Notes</label>
				<textarea class="server_notes" name="server_notes" /></textarea>
			</div>
			<div id="other_option_container" style="display: none;" class="submit_section">         
				<div class="submit_left">
					<input type="text" class="other_option_input" name="other_option_input">
				</div>
				<div class="submit_middle">
					<div class="add_option button_2"></div>
					<div style="display: none;" class="loader add_other_asset_loader"></div>
				</div>
			</div>
		</div>
		<div class="dialog_button_container">
			<div class="cancel_dialog button_2 dialog_button">Cancel</div>
			<div id="asset_server" class="add_asset_server add_asset button_1 dialog_button">Add Server</div>
			<div style="display:none;" class="asset_dialog_loader loader"></div>
		</div>
	</form>
</div>

<!-- Virtual Server Dialog -->
<div style="display: none;" class="asset_dialog" id="dialog_form_asset_virtual" title="Asset: Virtual Server">
	<form name="asset_server_form" id="asset_virtual_form">
		<div class="submit_section">
			<div class="submit_left">
				<label for="virtual_com_name">Computer Name:</label>
				<input type="text" class="virtual_com_name" name="virtualr_com_name	" />
			</div>
			<div class="submit_middle">
				<label for="virtual_ip_address">IP Address</label>
				<input type="text" class="virtual_ip_address" name="virtual_ip_address" required pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" />
				<input type="hidden" class="server_physical_virtual" name="server_physical_virtual" value="Virtual" />	
			</div>
			<div class="submit_right">
				<label for="virtual_os">Operating System</label>
				<select id="virtual_os" class="server_os full_width" name="virtual_os">
					<?php 
						foreach ($server_os as $os) {
							echo '<option value="'. $os .'">'. $os .'</option>';
						}
					?>
					<option class="server_os other_option" value="Operating System">Other</option>
				</select>		
			</div>			
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="virtual_installation_date">Installation Date</label>
				<input type="text" class="virtual_installation_date datepicker" name="virtual_installation_date" />	
			</div>
			<div class="submit_middle">
				<label for="virtual_purchase_date">Purchase Date</label>
				<input type="text" class="virtual_purchase_date datepicker" name="virtual_purchase_date" />	
			</div>
			<div class="submit_right">
				<label for="virtual_purchase_date">Installed On:</label>
				<select id="installed_on" class="full_width virtual_installed_on" name="installed_on">
					<option> -- </option>
				</select>
			</div>
		</div>		
<!-- 		<div class="submit_section">			
			<div class="submit_left">
				<label for="server_serial_number">Serial Number</label>
				<input type="text" class="server_serial_number" name="server_serial_number" />
			</div>
			<div class="submit_middle">
				<label for="server_warranty">Warranty <em>(0=Lifetime)</em></label>
				<input type="text" class="server_warranty" name="server_warranty" placeholder="Number of Years" />
			</div>
			<div class="submit_right">

			</div>
		</div> -->
		<div class="submit_section">			
			<div class="submit_left">
				<label for="virtual_notes">Notes</label>
				<textarea class="virtual_notes" name="virtual_notes" /></textarea>	
			</div>
			<div class="submit_middle">
				<label class="check_box_title">Software</label>	
				<?php foreach ($server_softwares as $software) { ?>
						<div class="two_column">
							<input type="checkbox" name="virtual_softwares[]" class="virtual_softwares check_box" value="<?php echo $software; ?>">
							<p class="check_box_label"><?php echo $software; ?></p>
						</div>
				<?php }	?>
				<input type="checkbox" name="virtual_softwares" class="virtual_softwares check_box other_option" value="Software"><p class="check_box_label">Other</p>
			</div>
			<div class="submit_right">
				<label class="check_box_title">Server Roles</label>				
				<?php foreach ($server_roles as $role) { ?>
						<div class="two_column">
							<input type="checkbox" name="virtual_roles[]" class="virtual_roles check_box" value="<?php echo $role; ?>">
							<p class="check_box_label"><?php echo $role; ?></p>
						</div>
				<?php }	?>
				<input type="checkbox" name="virtual_roles" class="virtual_roles check_box other_option" value="Server Roles">
				<p class="check_box_label">Other</p>
			</div>
			<div id="other_option_container_virtual" style="display: none;" class="submit_section">         
				<div class="submit_left">
					<input type="text" class="other_option_input" name="other_option_container">
				</div>
				<div class="submit_middle">
					<div class="add_option button_2"></div>
					<div style="display: none;" class="loader add_other_asset_loader"></div>
				</div>
			</div>
		</div>
		<div class="dialog_button_container">
			<div class="cancel_dialog button_2 dialog_button">Cancel</div>
			<div id="asset_virtual" class="add_asset_server add_asset button_1 dialog_button">Add Server</div>
			<div style="display:none;" class="asset_dialog_loader loader"></div>
		</div>
	</form>
</div>

<div style="display: none;" class="asset_dialog" id="dialog_form_asset_switch" title="Asset: Switch">
	<form name="asset_switch_form" id="asset_switch_form">
		<div class="submit_section">
			<div class="submit_left">
				<label for="switch_brand">Brand</label>
				<input type="text" class="switch_brand" name="switch_brand" />
			</div>
			<div class="submit_right">
				<label for="switch_model">Model</label>
				<input type="text" class="switch_model" name="switch_model" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="switch_ip_address">IP Address</label>
				<input type="text" class="switch_ip_address" name="switch_ip_address" />
			</div>
			<div class="submit_right">
				<label for="switch_firmware">Firmware</label>
				<input type="text" class="switch_firmware" name="switch_firmware" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="switch_serial_number">Serial Number</label>
				<input type="text" class="switch_serial_number" name="switch_serial_number" />
			</div>
			<div class="submit_right">
				<label for="switch_warranty">Warranty <em>(0=Lifetime)</em></label>
				<input type="text" class="switch_warranty" name="switch_warranty" placeholder="Number of Years" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="switch_purchase_date">Purchase Date</label>
				<input type="text" class="switch_purchase_date datepicker" name="switch_purchase_date" />
			</div>
			<div class="submit_right">
				<label for="switch_notes">Notes</label>
				<textarea name="switch_notes" class="switch_notes textarea_wide" /></textarea>
			</div>
		</div>		
		<div class="cancel_dialog button_2 dialog_button">Cancel</div>
		<div id="asset_switch" class="add_asset_switch add_asset button_1 dialog_button">Add Switch</div>
		<div style="display:none;" class="asset_dialog_loader loader"></div>		
	</form>
</div>
<div style="display: none;" class="asset_dialog" id="dialog_form_asset_firewall" title="Asset: Firewall">
	<form name="asset_firewall_form" id="asset_firewall_form">
		<div class="submit_section">
			<div class="submit_left">
				<label for="firewall_brand">Brand</label>
				<input type="text" class="firewall_brand" name="firewall_brand" />
			</div>
			<div class="submit_right">
				<label for="firewall_model">Model</label>
				<input type="text" class="firewall_model" name="firewall_model" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
			<label for="firewall_ip_address">IP Address</label>
				<input type="text" class="firewall_ip_address" name="firewall_ip_address" />
			</div>
			<div class="submit_right">
				<label for="fireware_firmware">Firmware</label>	
				<input type="text" class="firewall_firmware" name="firewall_firmware" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="firewall_addon_modules">Addon Modules</label>
				<input type="text" class="firewall_addon_modules" name="firewall_addon_modules" />
			</div>
			<div class="submit_right">
				<label for="firewall_purchase_date">Purchase Date</label>
				<input type="text" class="firewall_purchase_date datepicker" name="firewall_purchase_date" />				
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="firewall_serial_number">Serial Number</label>
				<input type="text" class="firewall_serial_number" name="firewall_serial_number" />
			</div>
			<div class="submit_right">
				<label for="firewall_warranty">Warranty <em>(0=Lifetime)</em></label>
				<input type="text" class="firewall_warranty" name="firewall_warranty" placeholder="Number of Years" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="firewall_sat_rules">SAT rules</label>
				<textarea name="firewall_sat_rules" class="firewall_sat_rules textarea_wide" /></textarea>
			</div>
			<div class="submit_right">
				<label for="firewall_notes">Notes</label>
				<textarea name="firewall_notes" class="firewall_notes textarea_wide"></textarea>			
			</div>
		</div>		
		<div class="cancel_dialog button_2 dialog_button">Cancel</div>
		<div id="asset_firewall" class="add_asset_firewall add_asset button_1 dialog_button">Add Firewall</div>
		<div style="display:none;" class="asset_dialog_loader loader"></div>
	</form>
</div>
<div style="display: none;" class="asset_dialog" id="dialog_form_asset_printer" title="Asset: Printer">
	<form name="asset_printer_form" id="asset_printer_form">
		<div class="submit_section">
			<div class="submit_left">
				<label for="printer_brand">Brand</label>
				<input type="text" class="printer_brand" name="printer_brand" />
			</div>
			<div class="submit_right">
				<label for="printer_model">Model</label>
				<input type="text" class="printer_model" name="printer_model" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="printer_ip_address">IP Address</label>
				<input type="text" class="printer_ip_address" name="printer_ip_address"  />
			</div>
			<div class="submit_right">
				<label for="printer_firmware">Firmware</label>
				<input type="text" class="printer_firmware" name="printer_firmware" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="printer_share">Share</label>
				<input type="text" class="printer_share" name="printer_share" />
			</div>
			<div class="submit_right">
				<label for="printer_purchase_date">Purchase Date</label>
				<input type="text" class="printer_purchase_date datepicker" name="printer_purchase_date" />				
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="server_serial_number">Serial Number</label>
				<input type="text" class="server_serial_number" name="server_serial_number" />
			</div>
			<div class="submit_right">
				<label for="server_warranty">Warranty <em>(0=Lifetime)</em></label>
				<input type="text" class="server_warranty" name="server_warranty" placeholder="Number of Years" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="printer_notes">Notes</label>
				<textarea name="printer_notes" class="printer_notes textarea_wide" ></textarea>
			</div>
		</div>		
		<div class="cancel_dialog button_2 dialog_button">Cancel</div>
		<div id="asset_printer" class="add_asset_printer add_asset button_1 dialog_button">Add Printer</div>
		<div style="display:none;" class="asset_dialog_loader loader"></div>
	</form>
</div>	
<div style="display: none;" class="asset_dialog" id="dialog_form_asset_nas" title="Asset: NAS">
	<form name="asset_nas_form" id="asset_nas_form">
		<div class="submit_section">
			<div class="submit_left">
				<label for="nas_brand">Brand</label>
				<input type="text" class="nas_brand" name="nas_brand"  />
			</div>
			<div class="submit_right">
				<label for="nas_model">Model</label>
				<input type="text" class="nas_model" name="nas_model" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="nas_ip_address">IP Address</label>
				<input type="text" class="nas_ip_address" name="nas_ip_address" />
			</div>
			<div class="submit_right">
				<label for="nas_firmware">Firmware</label>
				<input type="text" class="nas_firmware" name="nas_firmware" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="nas_max_disks">Max Disks</label>
				<input type="text" class="nas_max_disks" name="nas_max_disks" />
			</div>
			<div class="submit_right">
				<label for="nas_disk_config">Disk Config</label>
				<input type="text" class="nas_disk_config" name="nas_disk_config" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="nas_serial_number">Serial Number</label>
				<input type="text" class="nas_serial_number" name="nas_serial_number" />
			</div>
			<div class="submit_right">
				<label for="nas_warranty">Warranty <em>(0=Lifetime)</em></label>
				<input type="text" class="nas_warranty" name="nas_warranty" placeholder="Number of Years" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="nas_purchase_date">Purchase Date</label>
				<input type="text" class="nas_purchase_date datepicker" name="nas_purchase_date" />				
			</div>
			<div class="submit_right">
				<label for="nas_notes">Notes</label>
				<textarea name="nas_notes" class="nas_notes textarea_wide"></textarea>
			</div>
		</div>		
		<div class="cancel_dialog button_2 dialog_button">Cancel</div>
		<div id="asset_nas" class="add_asset_nas add_asset button_1 dialog_button">Add NAS</div>
		<div style="display:none;" class="asset_dialog_loader loader"></div>
	</form>
</div>	
<div style="display: none;" class="asset_dialog" id="dialog_form_asset_ups" title="Asset: UPS">
	<form name="asset_ups_form" id="asset_ups_form">
		<div class="submit_section">
			<div class="submit_left">
				<label for="ups_brand">Brand</label>
				<input type="text" class="ups_brand" name="ups_brand" />
			</div>
			<div class="submit_right">
				<label for="ups_model">Model</label>
				<input type="text" class="ups_model" name="ups_model" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="ups_ip_address">IP Address</label>
				<input type="text" class="ups_ip_address" name="ups_ip_address" />
			</div>
			<div class="submit_right">
				<label for="ups_connection_serial_network">Connection</label>
				<select class="ups_connection_serial_network full_width" name="ups_connection_serial_network">
					<option value="USB">USB</option>
					<option value="Serial">Serial</option>
					<option value="Network">Network</option>
				</select>
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="ups_software">Software</label>
				<input type="text" class="ups_software" name="ups_software" />
			</div>
			<div class="submit_right">
				<label for="ups_purchase_date">Purchase Date</label>
				<input type="text" class="ups_purchase_date datepicker" name="ups_purchase_date" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="ups_serial_number">Serial Number</label>
				<input type="text" class="ups_serial_number" name="ups_serial_number" />
			</div>
			<div class="submit_right">
				<label for="ups_warranty">Warranty <em>(0=Lifetime)</em></label>
				<input type="text" class="ups_warranty" name="ups_warranty" placeholder="Number of Years" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="ups_notes">Notes</label>
				<textarea name="ups_notes" class="ups_notes textarea_wide" ></textarea>
			</div>
		</div>		
		<div class="cancel_dialog button_2 dialog_button">Cancel</div>
		<div id="asset_ups" class="add_asset_ups add_asset button_1 dialog_button">Add UPS</div>
		<div style="display:none;" class="asset_dialog_loader loader"></div>		
	</form>
</div>
<div style="display: none;" class="asset_dialog" id="dialog_form_asset_tape_backup" title="Asset: Tape Backup">
	<form name="asset_tape_backup_form" id="asset_tape_backup_form">
		<div class="submit_section">
			<div class="submit_left">
				<label for="tape_backup_brand">Brand</label>
				<input type="text" class="tape_backup_brand" name="tape_backup_brand"  />
			</div>
			<div class="submit_right">
				<label for="tape_backup_model">Tape Model</label>
				<input type="text" class="tape_backup_model" name="tape_backup_model" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="tape_backup_firmware">Firmware</label>
				<input type="text" class="tape_backup_firmware" name="tape_backup_firmware" />
			</div>
			<div class="submit_right">
				<label for="tape_backup_capacity">Capacity</label>
				<input type="text" class="tape_backup_capacity" name="tape_backup_capacity" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="tape_backup_tape_model">Tape Model</label>
				<input type="text" class="tape_backup_tape_model" name="tape_backup_tape_model"/>
			</div>
			<div class="submit_right">
				<label for="tape_backup_purchase_date">Purchase Date</label>
				<input type="text" class="tape_backup_purchase_date datepicker" name="tape_backup_purchase_date" placeholder="Purchase Date" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<label for="tape_backup_serial_number">Serial Number</label>
				<input type="text" class="tape_backup_serial_number" name="tape_backup_serial_number" />
			</div>
			<div class="submit_right">
				<label for="tape_backup_warranty">Warranty <em>(0=Lifetime)</em></label>
				<input type="text" class="tape_backup_warranty" name="tape_backup_warranty" placeholder="Number of Years" />
			</div>
		</div>
		<div class="submit_section">
			<div class="submit_left">
				<textarea name="tape_backup_notes" class="tape_backup_notes textarea_wide" placeholder="Notes"></textarea>
			</div>
		</div>		
		<div class="cancel_dialog button_2 dialog_button">Cancel</div>
		<div id="asset_tape_backup" class="add_asset_tape_backup add_asset button_1 dialog_button">Add Tape Backup</div>
		<div style="display:none;" class="asset_dialog_loader loader"></div>
	</form>
</div>