<?php /* Template name: Add Server - Physical  */ ?>
<?php
get_header();
			global $wpdb;
$table_name = $wpdb->prefix . "custom_server";
?>
<div class="add_server">
	<form action="" method="post" name="add_server" id="add_server">
		<div class="section">
			<div class="left">
				<p class="label">Brand</p>
			</div>
			<div class="right">
				<input type="text" class="asset_server_brand" name="asset_server_brand" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Model</p>
			</div>
			<div class="right">
				<input type="text" class="asset_server_model" name="asset_server_model" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Diskset</p>
			</div>
			<div class="right">
				<label for="Disks">Disks</label>
				<input type="text" class="asset_server_disk" name="asset_server_disk" />
				<label for="Disks">Raid:</label>
				<input type="text" class="asset_server_disk" name="asset_server_disk" />
				<label for="Disks">SP no:</label>
				<input type="text" class="asset_server_disk" name="asset_server_disk" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Total Memory: </p>
			</div>
			<div class="right">
				<input type="text" class="asset_server_total_memory" name="asset_server_total_memory" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Memory Modules: </p>
			</div>
			<div class="right">
				<input type="text" class="asset_server_total_memory" name="asset_server_total_memory" />
			</div>
		</div>
<!-- 		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Physical / Virtual</p>
			</div>
			<div class="right">
				<Select class="asset_server_physical_virtual" name="asset_server_physical_virtual">
					<option value="Physical">Physical</option>
					<option value="Virtual">Virtual</option>
				</Select>
			</div>
		</div> -->
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Carepack</p>
			</div>
			<div class="right">
				<Select class="carepack" name="carepack">
					<option value="Yes">Yes</option>
					<option selected="selected" value="No">No</option>
				</Select>
			</div>
		</div>
		<div class="border_separator carepack_exp_date"></div>
		<div class="section carepack_exp_date">
			<div class="left">
				<p class="label">Carepack Expiration Date</p>
			</div>
			<div class="right">
				<input type="text" name="asset_server_carepack_exp_date" id="asset_server_carepack_exp_date">
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">IP Address</p>
			</div>
			<div class="right">
				<input type="text" class="asset_server_ip_address" name="asset_server_ip_address" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">ILO IP Address: </p>
			</div>
			<div class="right">
				<input type="text" class="asset_server_ilo_ip_address" name="asset_server_ilo_ip_address" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">ILO External URL: </p>
			</div>
			<div class="right">
				<input type="text" class="asset_server_ilo_external_url" name="asset_server_ilo_external_url" />
			</div>
		</div>

		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">OS</p>
			</div>
			<div class="right">
				<Select class="asset_server_os" name="asset_server_os">
					<option value="Windows Server 2016">Windows Server 2016</option>
					<option value="Windows Server 2012">Windows Server 2012</option>
					<option value="Windows Server 2012 R2">Windows Server 2012 R2</option>
					<option value="Windows Server 2008 R2">Windows Server 2008 R2</option>
					<option value="Windwos Server 2008">Windwos Server 2008</option>
					<option value="Windows Server 2003">Windows Server 2003</option>
					<option value="WMWare">WMWare</option>
				</Select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Server Roles</p>
			</div>
			<div class="right">
				<Select class="asset_server_roles" name="asset_server_roles" multiple>
					<option value="Hyper-V Host">Hyper-V Host</option>
					<option value="WMWare Host">WMWare Host</option>
					<option value="DC">DC</option>
					<option value="SBS">SBS</option>
					<option value="File">File</option>
					<option value="Mail">Mail</option>
					<option value="Application">Application</option>
					<option value="Terminal Server">Terminal Server</option>
				</Select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Purchase Date</p>
			</div>
			<div class="right">
				<input type="text" class="asset_server_purchase_date" name="asset_server_purchase_date"></input>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Installation Date</p>
			</div>
			<div class="right">
				<input type="text" class="asset_server_installation_date" name="asset_server_installation_date"></input>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Software</p>
			</div>
			<div class="right">
				<Select class="asset_server_software" name="asset_server_software" multiple>
					<option value="Exchange 2007">Exchange 2007</option>
					<option value="Exchange 2010">Exchange 2010</option>
					<option value="Exchange 2013">Exchange 2013</option>
					<option value="SQL 2005">SQL 2005</option>
					<option value="SQL 2008">SQL 2008</option>
					<option value="SQL 2014">SQL 2014</option>
					<option value="SQL 2012">SQL 2012</option>
					<option value="SQL 2016">SQL 2016</option>
					<option value="Jeeves">Jeeves</option>
					<option value="Visma 2000">Visma 2000</option>
					<option value="Visma 1000">Visma 1000</option>
					<option value="Visma 500">Visma 500</option>
					<option value="Navision 2016">Navision 2016</option>
					<option value="Navision 2016">Navision 2015</option>
				</Select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Notes</p>
			</div>
			<div class="right">
				<textarea name="asset_server_notes" class="asset_server_notes textarea_wide"></textarea>
			</div>
		</div>
		<div class="border_separator"></div>
		<input type="submit" name="submit" class="button_1" value="Add Server" />
		<a class="button_2" href="/server/">Cancel</a>
	</form>
</div>
<script type="text/javascript">
	jQuery(document).on('change', '.carepack', function(){
		var carepack = jQuery('.carepack').val();
		if(carepack == 'Yes'){
			jQuery('.carepack_exp_date').css({ "display": "block" });
			jQuery('.carepack_exp_date input').focus();
		}else{
			jQuery('.carepack_exp_date').css({ "display": "none" });
		}
	});
</script>

<?php
if(isset($_POST['submit'])):
	global $wpdb;

	$server_brand						= (isset($_POST['server_brand']) ? $_POST['server_brand'] : '');
	$server_model						= (isset($_POST['server_model']) ? $_POST['server_model'] : '');
	$server_disk						= (isset($_POST['server_disk']) ? $_POST['server_disk'] : '');
	$server_memory						= (isset($_POST['server_memory']) ? $_POST['server_memory'] : '');
	$server_carepack					= (isset($_POST['server_carepack']) ? $_POST['server_carepack'] : '');	
	$server_ip_address					= (isset($_POST['server_ip_address']) ? $_POST['server_ip_address'] : '');
	$switch_notes						= (isset($_POST['switch_notes']) ? $_POST['switch_notes'] : '');
		
	$insert = $wpdb->insert( $table_name , array(
		'server_brand'						=> $server_brand,
		'server_model'						=> $server_model,
		'server_disk'						=> $server_disk,
		'server_memory'						=> $server_memory,
		'server_carepack'					=> $switch_purchase_date,
		'server_ip_address'					=> $server_ip_address
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