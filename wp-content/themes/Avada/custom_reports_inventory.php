<?php /* Template Name: Inventory */ ?>
<?php get_header(); ?>
<?php
$table_client = $wpdb->prefix . "custom_client"; 
$clients = $wpdb->get_results("SELECT * FROM {$table_client}");
 ?>
<div class="inventory">
	<div class="top_navi">
		<select class="top_type_filter">
			<option>Physical</option>
			<option>Virtual</option>						
		</select>
		<select class="top_client_filter">
			<option selected="selected">-- All Client --</option>
			<?php foreach($clients as $client){ ?>
				<option><?php echo $client->client_name; ?></option>	
			<?php } ?>
		</select>		
		<div style="display:none;" class="loader inventory_loader"></div>	
	</div>
	<div class="border_separator"></div>
	<div class="header_titles">
		<div class="first_column column">
			<p class="table_header">Client</p>
		</div>
		<div class="second_column column">
			<p class="table_header">Asset</p>
		</div>
		<div class="third_column column">
			<p class="table_header">Brand</p>
		</div>
		<div class="fourth_column column">
			<p class="table_header">Model</p>
		</div>
		<div class="fifth_column column">
			<p class="table_header">Purchse Date</p>
		</div>
		<div class="sixth_column column">
			<p class="table_header">Warranty</p>
		</div>
		<div class="seventh_column column">
			<p class="table_header">Carepack Expiration</p>
		</div>
		<div class="eight_column column">
			<p class="table_header">Firmware</p>
		</div>
		<div class="ninth_column column">
			<p class="table_header">&nbsp;</p>
		</div>
	</div>
	<div class="client_details">
		<?php foreach($clients as $client){	?>
			<div class="client_asset">
				<div class="first_column column">
					<p><?php echo $client->client_name; ?></p>
				</div>
				<div class="asset_container">
		<?php 
					$client_asset = stripslashes($client->client_asset);	
					$json_decode = json_decode('[' .$client_asset. ']');
					
					$group_assets_array = array();					
					$input_name_array = array();
					foreach($json_decode as $key => $assets){
						foreach($assets as $asset_type_counter => $asset){
							$asset_type = $asset->asset_type;
							$asset_type = str_replace('asset_', "", $asset_type);
							$group_assets_array[$asset_type][] = $assets;
							foreach($asset as $input_title => $input_value){
								$input_name_array[] = $input_title;
							}
						}
					}	
					
					
					foreach($group_assets_array as $asset_type => $json_decode){
						echo '<div class="asset_separator asset_group asset_'.$asset_type.'">';
						$asset_type_title = str_replace('_', " ", $asset_type);
						foreach($json_decode as $key => $assets){ 
							foreach($assets as $asset_type_counter => $asset){
								echo '<ul class="asset_groups '.$asset_type_counter.'">';
								echo '<li class="second_column column"><p>'. (($asset_type_title != null) ? ucwords($asset_type_title) : '--') .'</p></li>';
								$counter = 1;								
								foreach($asset as $input_title => $input_value){
									$title_filter = str_replace($asset_type .'_', "", $input_title);
									$title = str_replace('_', " ", $title_filter);
									$check_asset_type_title = str_replace(" ", "_", $asset_type_title);
									// print_var('input_title = ' .$input_title.'----------------------');
									// print_var($check_asset_type_title .'_brand');
									// print_var($check_asset_type_title .'_model');
									// print_var($check_asset_type_title .'_purchase_date');
									// print_var($check_asset_type_title .'_warranty');
									// print_var($check_asset_type_title .'_carepack_expiration_date');
									// print_var($check_asset_type_title .'_firmware');
									// if($input_title == $check_asset_type_title .'_brand'){
										// echo '<li class="third_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
									// }elseif($input_title == $check_asset_type_title .'_model'){
										// echo '<li class="fourth_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
									// }elseif($input_title == $check_asset_type_title .'_purchase_date'){
										// echo '<li class="fifth_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
									// }elseif($input_title == $check_asset_type_title .'_warranty'){
										// echo '<li class="sixth_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
									// }elseif($input_title == $check_asset_type_title .'_carepack_expiration_date'){
										// echo '<li class="seventh_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
									// }elseif($input_title == $check_asset_type_title .'_firmware'){
										// echo '<li class="eight_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
									// }
									
									if (in_array($check_asset_type_title .'_brand', $input_name_array)) {
										if($input_title == $check_asset_type_title .'_brand'){
											$brand = $input_value != null ? $input_value : '--';
										}
									}else{
										if($counter == 1){
											$brand = '--';
										}										
									}
									
									if (in_array($check_asset_type_title .'_model', $input_name_array)) {										
										if($input_title == $check_asset_type_title .'_model'){
											$model = $input_value != null ? $input_value : '--';
										}
									}else{
										if($counter == 1){
											$model = '--';
										}										
									}
									
									if (in_array($check_asset_type_title .'_purchase_date', $input_name_array)) {										
										if($input_title == $check_asset_type_title .'_purchase_date'){
											$purchase_date = $input_value != null ? $input_value : '--';
										}
									}else{
										if($counter == 1){
											$purchase_date = '--';
										}										
									}
									
									if (in_array($check_asset_type_title .'_warranty', $input_name_array)) {										
										if($input_title == $check_asset_type_title .'_warranty'){
											$warranty = $input_value != null ? $input_value : '--';
										}
									}else{
										if($counter == 1){
											$warranty = '--';
										}										
									}
									
									if (in_array($check_asset_type_title .'_carepack_expiration_date', $input_name_array)) {										
										if($input_title == $check_asset_type_title .'_carepack_expiration_date'){
											$carepack_expiration_date = $input_value != null ? $input_value : '--';
										}
									}else{
										if($counter == 1){
											$carepack_expiration_date = '--';
										}										
									}
									
									if (in_array($check_asset_type_title .'_firmware', $input_name_array)) {										
										if($input_title == $check_asset_type_title .'_firmware'){
											$firmware = $input_value != null ? $input_value : '--';
										}
									}else{
										if($counter == 1){
											$firmware = '--';
										}										
									}
									$counter++;
								}
								echo '<li class="third_column column "><p class="input_value">'. $brand .'</p></li>';
								echo '<li class="fourth_column column"><p class="input_value">'. $model .'</p></li>';
								echo '<li class="fifth_column column"><p class="input_value">'. $purchase_date .'</p></li>';
								echo '<li class="sixth_column column"><p class="input_value">'. $warranty .'</p></li>';
								echo '<li class="seventh_column column"><p class="input_value">'. $carepack_expiration_date .'</p></li>';
								echo '<li class="eight_column column"><p class="input_value">'. $firmware .'</p></li>';
								// echo '<li class="ninth_column column"><div id="edit_'. $asset_type_counter.'" class="edit_asset_group button_1">Edit</div></li>';
								echo '</ul>';
							}
						}
						echo '</div>';
						
					}
		?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<?php get_footer(); ?>