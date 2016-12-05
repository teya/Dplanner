<?php
function array_flatten($array) { 
	if (!is_array($array)) { 
		return FALSE; 
	} 
	$result = array(); 
	foreach ($array as $key => $value) {
		if(is_array($value)) { 
			$result = array_merge($result, array_flatten($value)); 
		}else{ 
			$result[$key] = $value; 
		} 
	} 
	return $result; 
}

function inventory_client_filter($client_name){
	global $wpdb;
	$table_client = $wpdb->prefix . "custom_client";
	if($client_name == "all"){
		$clients = $wpdb->get_results("SELECT * FROM {$table_client}");
	}else{
		$clients = $wpdb->get_results("SELECT * FROM {$table_client} WHERE client_name = '$client_name'");
	}
	
	foreach($clients as $client){
		$html .= '<div class="client_asset">';
		$html .= '<div class="first_column column">';
		$html .= '<p>'. $client->client_name .'</p>';
		$html .= '</div>';
		$html .= '<div class="asset_container">';
		
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
			$html .= '<div class="asset_separator asset_group asset_'.$asset_type.'">';
			$asset_type_title = str_replace('_', " ", $asset_type);
			foreach($json_decode as $key => $assets){ 
				foreach($assets as $asset_type_counter => $asset){
					$html .= '<ul class="asset_groups '.$asset_type_counter.'">';
					$html .= '<li class="second_column column"><p>'. (($asset_type_title != null) ? ucwords($asset_type_title) : '--') .'</p></li>';
					$counter = 1;
					foreach($asset as $input_title => $input_value){
						$title_filter = str_replace($asset_type .'_', "", $input_title);
						$title = str_replace('_', " ", $title_filter);
						$check_asset_type_title = str_replace(" ", "_", $asset_type_title);
						
						if (in_array($check_asset_type_title .'_brand', $input_name_array)) {
							if($input_title == $check_asset_type_title .'_brand'){
								$html .= '<li class="third_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
							}
						}else{
							if($counter == 1){
								$html .= '<li class="third_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">--</p></li>';
							}										
						}
						
						if (in_array($check_asset_type_title .'_model', $input_name_array)) {
							if($input_title == $check_asset_type_title .'_model'){
								$html .= '<li class="fourth_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
							}
						}else{
							if($counter == 1){
								$html .= '<li class="fourth_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">--</p></li>';
							}										
						}
						
						if (in_array($check_asset_type_title .'_purchase_date', $input_name_array)) {
							if($input_title == $check_asset_type_title .'_purchase_date'){
								$html .= '<li class="fifth_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
							}
						}else{
							if($counter == 1){
								$html .= '<li class="fifth_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">--</p></li>';
							}										
						}
						
						if (in_array($check_asset_type_title .'_warranty', $input_name_array)) {
							if($input_title == $check_asset_type_title .'_warranty'){
								$html .= '<li class="sixth_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
							}
						}else{
							if($counter == 1){
								$html .= '<li class="sixth_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">--</p></li>';
							}										
						}
						
						if (in_array($check_asset_type_title .'_carepack_expiration_date', $input_name_array)) {
							if($input_title == $check_asset_type_title .'_carepack_expiration_date'){
								$html .= '<li class="seventh_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
							}
						}else{
							if($counter == 1){
								$html .= '<li class="seventh_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">--</p></li>';
							}										
						}
						
						if (in_array($check_asset_type_title .'_firmware', $input_name_array)) {
							if($input_title == $check_asset_type_title .'_firmware'){
								$html .= '<li class="eight_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">'. (($input_value != null) ? $input_value : '--') .'</p></li>';
							}
						}else{
							if($counter == 1){
								$html .= '<li class="eight_column column"><p style="display:none" class="label">'.ucwords($title).': </p><p class="input_value">--</p></li>';
							}										
						}
						$counter++;
					}
					// echo '<li class="seventh_column column"><div id="edit_'. $asset_type_counter.'" class="edit_asset_group button_1">Edit</div></li>';
					$html .= '</ul>';
				}
			}
			$html .= '</div>';
			
		}
		$html .= '</div>';		
	$html .= '</div>';
	}
	
	return $html;
}
?>