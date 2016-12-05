<?php
/* ==================================== ADD ASSET ==================================== */
function build_array($form_details){
	parse_str($form_details, $form_details_array);
	$asset_type = $form_details_array['asset_type'] .'_'. $form_details_array['asset_type_counter'];
	$build_array = array();
	$build_array[$asset_type] = $form_details_array;
	return json_encode($build_array);
}
/* ==================================== END ADD ASSET ==================================== */

/* ==================================== EDIT ASSET ==================================== */
function edit_add_asset($form_details){
	parse_str($form_details, $form_details_array);
	$current_assets = stripslashes($form_details_array['current_assets']);	
	$json_decode = json_decode('[' .$current_assets. ']');
	$edit_type_counter = $form_details_array['asset_type_counter'];	
	$current_assets_array = array();
	foreach($json_decode as $key => $current_assets){
		foreach($current_assets as $asset_type_counter => $current_asset){
			if($edit_type_counter != $asset_type_counter){
				foreach($current_assets as $key => $asset){
					$current_assets_array[$asset_type_counter][$key] = $asset;
				}
			}
		}
	}	

	$filter_array = array();
	foreach($current_assets_array as $key => $current_asset_array){
		foreach($current_asset_array as $asset_type_counter => $current_array){
			foreach($current_array as $input_name => $input_value){
				$filter_array[$asset_type_counter][$input_name] = $input_value;
			}
		}
	}		

	$edited_details_array  = array();
	foreach($form_details_array as $key => $edited_detail){
		if($key != 'asset_type_counter' && $key != 'current_assets'){
			$edited_details_array[$edit_type_counter][$key] = $edited_detail;
		}
	}	

	$asset_type_counter = get_numerics($form_details_array['asset_type_counter']);
	$asset_type = preg_replace('/[0-9]+/', '', $form_details_array['asset_type_counter']);
	$asset_type = substr($asset_type, 0, -1);	
	$edited_details_array[$edit_type_counter]['asset_type_counter'] = $asset_type_counter[0];
	$edited_details_array[$edit_type_counter]['asset_type'] = $asset_type;	
	
	
	foreach($edited_details_array as $key => $edited_details){
		$asset_type = $edited_details['asset_type'];
		$asset_type = str_replace('asset_', "", $asset_type);
		foreach($edited_details as $input_title => $input_value){
			$title_filter = str_replace($asset_type .'_', "", $input_title);
			$title = str_replace('_', " ", $title_filter);
			if($input_title != 'asset_type_counter' && $input_title != 'asset_type' && $input_title != 'other_option_input'){				
				$html .= '<li><p class="label">'.ucwords($title).': </p><p class="input_value">'.(is_array($input_value) ? implode(', ', $input_value) : $input_value).'</p></li>';
			}
		}
	}	
	
	$results_array = array();
	$merge_current_edited = array_merge($filter_array, $edited_details_array);
	$results_array['merge_current_edited'] = json_encode($merge_current_edited);
	$results_array['html'] = $html;
	$results_array['edit_type_counter'] = $edit_type_counter;
	$results_array['asset_type'] = $asset_type;	

	return $results_array;
}

function get_numerics ($str) {
    preg_match_all('/\d+/', $str, $matches);
    return $matches[0];

}

/* ==================================== ADD OPTION ==================================== */
function add_other_option($form_details){
	global $wpdb;
	$options_table = $wpdb->prefix . "custom_client_assets_options";
	
	$form_details_explode = explode('(join)', $form_details);
	$input_field = $form_details_explode[0];
	$input_value = $form_details_explode[1];
	$option_table = $wpdb->get_row("SELECT * FROM {$options_table} WHERE input_field = '$input_field'");
		
	$current_options = unserialize($option_table->data_fields);
	array_push($current_options, $input_value);
	// if(($key = array_search($input_value, $current_options)) !== false) {
		// unset($current_options[$key]);
	// }
	
	$serialized = serialize($current_options);
	$update = $wpdb->update( $options_table , array( 
		'data_fields'	=> $serialized
	),
	array( 'input_field' => $input_field ),
	array( '%s', '%s' ));	

	return $form_details;
}
/* ==================================== END ADD OPTION ==================================== */


//Add Service to Client on Add CLient Page
function add_services_to_client($form_details){
	global $wpdb;
	$table_services_options = $wpdb->prefix . "custom_service_options";	
	$table_service_client = $wpdb->prefix . "custom_services";	
	parse_str($form_details, $form_details_array);

	//Check if the service name already exists
	if((int)$form_details_array['new_service_option'] == 0){
		$response = AddingServiceToClienttoDB($form_details_array);
	}
	// If Adding new service option
	else{
		$check_string = $wpdb->get_row('SELECT service_name  FROM '.$table_services_options.' WHERE service_name="'.$form_details_array['service_name'].'"');
		//If service name already exists.
		if($check_string == 1){
			$response = array(
				'status' => 'service-name-already-exist'
			);
		//If not already on service database
		}else{
			$response = AddingServiceToClienttoDB($form_details_array);
		}
	}
	return $response;
}

//Get Service Info
function get_service_info($service_id){
	global $wpdb;
	$table_service_client = $wpdb->prefix . "custom_services";
	$service = $wpdb->get_row('SELECT * FROM '.$table_service_client.' WHERE ID = '. $service_id);
	// print_r($service);
    // [client_id] => 20
    // [service_name] => Kaseya Workstation
    // [licenses] => asdasd
    // [customer_price] => 1213
    // [our_price] => 12
    // [start_date] => 06/15/2016
    // [invoice_interval] => 1Y
    // [notes] => asdsadsasdasd

    $response = array( 
    	'service_info' => $service
    );
    return $response;
}
//Edit Client service.
function edit_services_to_client($form_details, $service_id){
	global $wpdb;
	$table_service_client = $wpdb->prefix . "custom_services";
	parse_str($form_details, $form_details_array);

	$update = $wpdb->update( $table_service_client , array( 
		'service_name'		=> $form_details_array['service_name'],
		'licenses'			=> $form_details_array['service_licenses'],
		'customer_price'	=> $form_details_array['service_customer_price'],
		'our_price'			=> $form_details_array['service_our_price'],
		'start_date'		=> $form_details_array['service_start_date'],
		'invoice_interval'	=> $form_details_array['service_invoice_interval'],
		'notes'				=> $form_details_array['service_notes'],
	),
	array( 'ID' => $form_details_array['service_id'] ),
	array( '%s', '%s','%s','%s','%s','%s','%s' ));

	if($update == 1){
		$response = array(
			'client_updated_option' => $form_details_array,
			'service_id' => $form_details_array['service_id'],
			'status' => 'updated-service-to-client'
		);
	//If Saving to database error occurred.	
	}else{
		$response = array(
			'status' => 'failed-updating-service-to-client'
		);
	}
	return $response;	
}

//Adding Service TO client To DB
function AddingServiceToClientToDB($form_details_array){
	global $wpdb;
	$table_services_options = $wpdb->prefix . "custom_service_options";	
	$table_service_client = $wpdb->prefix . "custom_services";	
	$insert = $wpdb->insert( $table_service_client , array( 
		'client_id' 		=> $form_details_array['client_id'],
		'service_name' 		=> $form_details_array['service_name'],
		'licenses' 			=> $form_details_array['service_licenses'],
		'customer_price'	=> $form_details_array['service_customer_price'],
		'our_price' 		=> $form_details_array['service_our_price'],
		'start_date'		=> $form_details_array['service_start_date'],
		'invoice_interval'	=> $form_details_array['service_invoice_interval'],
		'notes' 			=> $form_details_array['service_notes']
	),
	array( '%d', '%s', '%s','%s','%s','%s','%s','%s' ));
	//If adding service to client was successfull.
	if($insert == 1){
		$response = array(
			'client_new_option' => $form_details_array,
			'service_id' => $wpdb->insert_id,
			'status' => 'added-new-service-to-client'
		);
	//If Saving to database error occurred.	
	}else{
		$response = array(
			'status' => 'failed-adding-new-service-to-client'
		);
	}
	//Add new Service Option on DB
	if((int)$form_details_array['new_service_option'] == 1){
		$insert = $wpdb->insert( $table_services_options , array( 
			'service_name' => $form_details_array['service_name']
		),
		array( '%s' ));
		//If adding service to client was successfull.
		if($insert == 1){
			$response = array(
				'client_new_option' => $form_details_array,
				'service_id' => $wpdb->insert_id,
				'status' => 'added-new-service-to-client'
			);
		//If Saving to database error occurred.	
		}else{
			$response = array(
				'status' => 'failed-adding-new-service-to-client'
			);
		}		
	}
	return 	$response;	
}
?>