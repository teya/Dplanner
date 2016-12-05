<script>
jQuery(document).ready(function(){
	jQuery('.datepicker').datepicker();
});

jQuery(document).ready(function(){
	jQuery( ".asset_dialog" ).dialog({
		autoOpen: false,
		width: 350,
		modal: true,
		close: function() {
			jQuery('.asset_dialog form').trigger("reset");
		}
	});		
});
jQuery(document).ready(function(){
	jQuery( ".service_dialog" ).dialog({
		autoOpen: false,
		width: 350,
		modal: true,
		close: function() {
			jQuery('.service_dialog form').trigger("reset");
		}
	});		
});
jQuery(document).on('click', '.cancel_dialog', function(){
	jQuery('.asset_dialog').dialog('close');	
	jQuery('.service_dialog').dialog('close');	
	jQuery('#add_service_to_client').text('Add Service').removeClass('update_service_group').addClass('add_service');	
});

//Adding Client Services Popup
jQuery(document).on('change', '.client_service_selection', function(){
	var selected_service = jQuery(this).val();
	if(selected_service == '-- Services --'){
		return false;
	}
	var client_id = jQuery('#client_next_id').val();
	jQuery('#client_id').val(client_id);

	if(selected_service == 'Add New Service Option'){
		jQuery('#dialog_form_service').dialog('open');
		jQuery('#dialog_form_service .service_name').attr('readonly', false);
		jQuery('#dialog_form_service #new_service_option').val(1);
	}else{
		jQuery('#dialog_form_service').dialog('open');
		jQuery('#dialog_form_service .service_name').val(selected_service).attr('readonly', true);
	}
});


// Add Service to Client on "Add Client Page"
jQuery(document).on('click', '#add_service_to_client.add_service', function(){

	console.log('add service');
	var form =  jQuery('#client_service');

	// Get All Info on add service to client.
	var form_details = form.serialize();

	jQuery.ajax({				
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'form_details' : form_details,
			'type' : 'add_services_to_client'
		},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);
		
			//Reset the Add client dialog form.
			var service_String = '';
			jQuery(form)[0].reset();

			//Reset dropdown option for services.
			var dropdown_selection = jQuery('.client_service_selection');
			dropdown_selection[0].selectedIndex = 0;
			jQuery('.service_dialog').dialog('close');

			var services_container = jQuery('#client_services_container .service_separator').length;

			console.log(services_container);

			//List of Services that where added on client.
			//Check if services already added.
			if(services_container == 0){
				service_String = '<ul style="display: none;" id="service_id_'+parsed.service_id+'" class="service_group_separator"><li><p class="label">Service<p class="input_value">'+parsed.client_new_option.service_name+'</p></li> <li><p class="label">Licenses<p class="input_value">'+parsed.client_new_option.service_licenses+'</p></li> <li><p class="label">Customer Price<p class="input_value">'+parsed.client_new_option.service_customer_price+'</p></li> <li><p class="label">Our Price<p class="input_value">'+parsed.client_new_option.service_our_price+'</p></li> <li><p class="label">Start Date<p class="input_value">'+parsed.client_new_option.service_start_date+'</p></li> <li><p class="label">Invoice Interval<p class="input_value">'+parsed.client_new_option.service_invoice_interval+'</p></li> <li><p class="label">Notes<p class="input_value">'+parsed.client_new_option.service_notes+'</p></li> <div class="edit_service_group button_1" id="edit_service_'+parsed.service_id+'">Edit</div></ul>';
					jQuery('#client_services_container').html('<div class="service_separator service_group"><p class="service_title label">Service</p>'+service_String+'</div>');
					jQuery('#client_services_container .service_separator ul').fadeIn()

			}else{
				service_String = '<ul style="display: none;" id="service_id_'+parsed.service_id+'" class="service_group_separator"><li><p class="label">Service<p class="input_value">'+parsed.client_new_option.service_name+'</p></li> <li><p class="label">Licenses<p class="input_value">'+parsed.client_new_option.service_licenses+'</p></li> <li><p class="label">Customer Price<p class="input_value">'+parsed.client_new_option.service_customer_price+'</p></li> <li><p class="label">Our Price<p class="input_value">'+parsed.client_new_option.service_our_price+'</p></li> <li><p class="label">Start Date<p class="input_value">'+parsed.client_new_option.service_start_date+'</p></li> <li><p class="label">Invoice Interval<p class="input_value">'+parsed.client_new_option.service_invoice_interval+'</p></li> <li><p class="label">Notes<p class="input_value">'+parsed.client_new_option.service_notes+'</p></li> <div class="edit_service_group button_1" id="edit_service_'+parsed.service_id+'">Edit</div></ul>';
					jQuery(service_String).insertBefore('#client_services_container .service_separator ul:first').fadeIn();
			}
		},
		error: function (data) {
			alert('error');
		}				
	});

});

//Show  Client Service Dialog for Edit function.
jQuery(document).on('click', '.edit_service_group', function(){
	console.log('EDITING SERVICE');
	var service_id = jQuery(this).attr('id').split('_')[2];
	jQuery('#dialog_form_service').dialog('open');
	jQuery('#add_service_to_client').text('Update Service').removeClass('add_service').addClass('update_service_group');
	jQuery('#service_id').val(service_id);
	jQuery('#client_service .service_dialog_loader').show();

	jQuery.ajax({				
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'service_id' : service_id,
			'type' : 'get_service_info'
		},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);
			var dialog_form = jQuery('#dialog_form_service');
			console.log(parsed.service_info.service_name);
			// jQuery(form)[0].reset();
			jQuery(dialog_form).find('.service_name').val(parsed.service_info.service_name);	
			jQuery(dialog_form).find('#client_id').val(parsed.service_info.client_id);
			jQuery(dialog_form).find('#service_id').val(parsed.service_id);
			jQuery(dialog_form).find('.service_licenses').val(parsed.service_info.licenses);		
			jQuery(dialog_form).find('.service_customer_price').val(parsed.service_info.customer_price);
			jQuery(dialog_form).find('.service_our_price').val(parsed.service_info.our_price);
			jQuery(dialog_form).find('.service_start_date').val(parsed.service_info.start_date);	
			// jQuery(dialog_form+' .service_start_date').val(parsed.service_info.start_date);
			jQuery(dialog_form).find('.service_notes').val(parsed.service_info.notes);	
			jQuery(dialog_form).find('#service_id').val(parsed.service_info.ID);
			jQuery('#client_service .service_dialog_loader').hide();
		},
		error: function (data) {
			alert('error');
		}				
	});	

});

jQuery(document).on('click', '.update_service_group', function(){
	jQuery('#client_service .service_dialog_loader').show();
	var service_id = jQuery(this).attr('id').split('_')[2];
	var form =  jQuery('#client_service');
	jQuery('#dialog_form_service').dialog('open');
	var form_details = form.serialize();

	jQuery.ajax({				
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'form_details' : form_details,
			'service_id' : service_id,
			'type' : 'edit_services_to_client'
		},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);
			console.log(parsed);
			jQuery(form)[0].reset();
			jQuery('.service_dialog').dialog('close');
			jQuery('#client_service .service_dialog_loader').hide();
			jQuery('#service_id_'+parsed.service_id+'').fadeOut().empty();
			jQuery('#service_id_'+parsed.service_id+'').append('<li><p class="label">Service<p class="input_value">'+parsed.client_updated_option.service_name+'</p></li> <li><p class="label">Licenses<p class="input_value">'+parsed.client_updated_option.service_licenses+'</p></li> <li><p class="label">Customer Price<p class="input_value">'+parsed.client_updated_option.service_customer_price+'</p></li> <li><p class="label">Our Price<p class="input_value">'+parsed.client_updated_option.service_our_price+'</p></li> <li><p class="label">Start Date<p class="input_value">'+parsed.client_updated_option.service_start_date+'</p></li> <li><p class="label">Invoice Interval<p class="input_value">'+parsed.client_updated_option.service_invoice_interval+'</p></li> <li><p class="label">Notes<p class="input_value">'+parsed.client_updated_option.service_notes+'</p></li> <div class="edit_service_group button_1" id="edit_service_'+parsed.service_id+'">Edit</div>').fadeIn();
			jQuery('#add_service_to_client').text('Add Service').removeClass('update_service_group').addClass('add_service');	
		
		},
		error: function (data) {
			alert('error');
		}				
	});	

});

// Adding Clien Assets
jQuery(document).on('change', '.client_asset_selection', function(){
	var asset_type = jQuery(this).val();
	switch(asset_type) {
		case 'Server Physical':
			jQuery('#dialog_form_asset_server').dialog('open');
		break;
		case 'Server Virtual':
			jQuery('#dialog_form_asset_virtual').dialog('open');
		break;
		case 'Switch':
			jQuery('#dialog_form_asset_switch').dialog('open');
		break;
		case 'Firewall':
			jQuery('#dialog_form_asset_firewall').dialog('open');
		break;
		case 'Printer':
			jQuery('#dialog_form_asset_printer').dialog('open');
		break;
		case 'NAS':
			jQuery('#dialog_form_asset_nas').dialog('open');
		break;
		case 'UPS':
			jQuery('#dialog_form_asset_ups').dialog('open');
		break;
		case 'Tape Backup':
			jQuery('#dialog_form_asset_tape_backup').dialog('open');
		break;
	}

});

jQuery(document).on('change', '.server_carepack', function(){
	var carepack = jQuery(this).val();
	if(carepack == 'Yes'){
		jQuery('#server_carepack_expiration_date').show();
	}else if(carepack == 'No'){
		jQuery('#server_carepack_expiration_date').hide();
	}
});


/* ==================================== ADD ASSET  ==================================== */
jQuery(document).ready(function() {
    var counter = 0;
	var check_exsist = jQuery('.asset_container .asset_groups').length;
	var asset_type_array = [];
	if(check_exsist != 0){
		jQuery('.asset_container .asset_groups').each(function(){
			var ul_classes = jQuery(this).attr('class').split(' ');
			jQuery(ul_classes).each(function(key, div_class){
				if(div_class != 'asset_groups'){
					asset_type = jQuery.trim(div_class.replace(/\_/g,' ').replace(/\d+/g, '')).replace(/ /g,"_");
					asset_type_array.push(asset_type);
					
				}
			});
		});	
	}
	
	var asset_count = {};
	for (var i = 0, j = asset_type_array.length; i < j; i++) {
	   asset_count[asset_type_array[i]] = (asset_count[asset_type_array[i]] || 0) + 1;
	}

	jQuery.each(asset_count, function(asset_type, value){
		jQuery('.asset_counter_container').append('<input type="hidden" class="'+asset_type+'_counter" value="'+value+'">');
	});
});
jQuery(document).on('click', '.add_asset', function(){	

	// console.log('add assets');
	var asset_id = jQuery(this).attr("id");
	var counter_check = jQuery('.'+asset_id+'_counter').length;
	if(counter_check == 0){
		counter = 1;
		jQuery('.asset_counter_container').append('<input type="hidden" class="'+asset_id+'_counter" value="'+counter+'">');
	}else{
		current_counter = jQuery('.'+asset_id+'_counter').val();
		jQuery('.'+asset_id+'_counter').val(parseInt(current_counter) + 1);
	}
	counter++;
	jQuery('.asset_dialog_loader').show();
	var asset_type = jQuery(this).attr('id');
	asset_type_counter = jQuery('.'+asset_id+'_counter').val();
	var form_details = jQuery('#'+ asset_type + '_form').serialize() + '&asset_type=' + asset_type + '&asset_type_counter=' + asset_type_counter;	

	jQuery.ajax({				
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'form_details' : form_details,
			'type' : 'build_array'
		},
		success: function (data) {
			if(!jQuery(".client_asset").val()){
				jQuery("#add_client_form .client_asset").val(data);
				console.log('not empty');
			}else{
				var existing_asset = jQuery('.client_asset').val();
				var add_asset_hidden = existing_asset +','+ data;
				console.log(add_asset_hidden);
				jQuery('.client_asset').val(add_asset_hidden);
				console.log('empty');
			}			
			
			var parsed = jQuery.parseJSON(data);			
			jQuery.each(parsed, function(key, asset_array){
				var asset_type = asset_array.asset_type;

				// Add Physical Server on Virtual server Installed On dropdown.
				if(asset_array.server_physical_virtual =='Physical'){
					var physical_servers = asset_array.server_com_name +' - ' + asset_array.server_ip_address;
					jQuery('#installed_on').append($("<option></option>").attr("value",physical_servers).text(physical_servers)); 
				}

				var div_counter = jQuery('.'+asset_type+'_counter').val();
				var asset_group_class = jQuery.trim(key.replace(/\_/g,' ').replace(/\d+/g, '')).replace(/ /g,"_");

				if(div_counter == 1){
					jQuery('.asset_container').append('<div class="asset_separator asset_group '+asset_group_class+'"><p class="asset_title label">'+ucwords(asset_type.replace('asset_','').replace(/\_/g,' '))+'</p><ul class="'+key+'"></ul></div>');					
				}else{
					jQuery('.'+asset_group_class).append('<ul class="asset_group_separator '+key+'"></ul>');
				}
				jQuery.each(asset_array, function(input_name, input_value){	
					if(typeof input_value == 'string'){
						var  asset_input = input_value;
					}else{
						var asset_input = input_value.join(', ');
					}
					console.log(input_name);
					if(input_name != 'asset_type' && input_name != 'asset_type_counter' && input_name != 'other_option_input' && input_name != 'other_option_container'){
						var extract_asset_type = asset_type.replace('asset_','');
						console.log(input_name);
						var title = input_name.replace(extract_asset_type,'').replace(/\_/g,' ');
						// console.log(title);
						var input_title = ucwords(title);						
						jQuery('.asset_container .'+asset_group_class+' ul.'+key).append('<li>'
							+'<p class="label">'+input_title+': </p>'
							+'<p class="input_value">'+asset_input+'</p>'
							+'</li>'
						);
					}
				});
				jQuery('.asset_container .'+asset_group_class+' ul.'+key).append('<div id="edit_'+key+'" class="edit_asset_group button_1">Edit</div>');
			});
			jQuery(".client_asset_selection option:first").prop('selected','selected');
			jQuery('.asset_dialog_loader').hide();
			jQuery('.asset_dialog').dialog('close');
		},
		error: function (data) {
			alert('error');
		}				
	});
});

/* ==================================== END ADD ASSET ==================================== */

/* ==================================== EDIT ASSET ==================================== */
jQuery(document).on('click', '.edit_asset_group', function(){
	var div_id = jQuery(this).attr('id');
	var key = jQuery.trim(div_id.replace('edit_',''));
	var exrtact_asset_type = jQuery.trim(div_id.replace('edit_','').replace(/\d+/g, '').replace(/\_/g,' '));
	var asset_type = exrtact_asset_type.replace(/ /g,"_").replace('asset_','');	
	jQuery('.'+key+' li').each(function( index ) {

		var input_name = jQuery(this).find('.label').text();
		var input_class = asset_type +'_'+ jQuery.trim(input_name.replace(/\:/g,'')).replace(/ /g,"_").toLowerCase();
		var input_value = jQuery(this).find('.input_value').text();	
		console.log(input_name+ " : " +input_value);
	
		if (input_value.contains(",")){
			jQuery.each(input_value.split(","), function(key,value){
				multiselect_value = jQuery.trim(value);
				jQuery('#dialog_form_asset_'+asset_type+' .'+input_class+'[value="' + multiselect_value + '"]').prop("checked", true);
			});
		}else{
			jQuery('#dialog_form_asset_'+asset_type+' .'+input_class).val(input_value);
		}
	});	
	jQuery('#dialog_form_asset_'+asset_type+' .add_asset').removeClass('add_asset_'+asset_type+' add_asset').addClass('edit_asset_'+asset_type+' edit_asset').attr('id', 'update_'+key).text('Edit '+ ucwords(asset_type));
	jQuery('#dialog_form_asset_'+asset_type).dialog('open');
});

jQuery(document).on('click', '.edit_asset', function(){
	jQuery('.asset_dialog_loader').show();
	var div_id = jQuery(this).attr('id');
	var asset_type = div_id.replace('update_asset_','').replace(/\d+/g, '').replace(/\_/g,'');
	var asset_type_counter = div_id.replace('update_','');
	var current_assets = jQuery('.client_asset').val();
	var form_details = jQuery('#asset_'+asset_type+'_form').serialize() + '&asset_type_counter=' + asset_type_counter + '&current_assets=' + current_assets;
	jQuery.ajax({				
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'form_details' : form_details,
			'type' : 'edit_add_asset'
		},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);
			var edit_type_counter = parsed.edit_type_counter;
			var html = parsed.html;
			var merge_current_edited = parsed.merge_current_edited;
			var asset_type = parsed.asset_type;
			jQuery('.asset_container ul.'+edit_type_counter).empty().html(html);
			jQuery('.asset_container ul.'+edit_type_counter).append('<div id="edit_'+edit_type_counter+'" class="edit_asset_group button_1">Edit</div>');
			jQuery('.client_asset').val(merge_current_edited);			
			jQuery('#dialog_form_asset_'+asset_type).dialog('close');
			jQuery('#dialog_form_asset_'+asset_type+' .edit_asset').removeClass('edit_asset_'+asset_type+' edit_asset').addClass('add_asset_'+asset_type+' add_asset').attr('id', 'asset_'+asset_type).text('Add '+ucwords(asset_type));
			jQuery('.asset_dialog_loader').hide();
		},
		error: function (data) {
			alert('error');
		}				
	});
});
/* ==================================== END  EDIT ASSET ==================================== */
/* ==================================== OTHER OPTION ==================================== */
jQuery(document).on('click', '.other_option', function(){
	if(jQuery(this).prop("checked") == true){			
		var option_for = jQuery(this).val();
		var option_for_class = jQuery(this).attr('class');
		var option_for_class_split = option_for_class.split(' ');
		var option_name	= "";
		jQuery(option_for_class_split).each(function(key, div_class){
			if(div_class != 'other_option' && div_class != 'check_box'){
				option_name = div_class;
			}
		});
		jQuery('#other_option_container .add_option').removeAttr('id');
		jQuery('#other_option_container .add_option').attr('id', option_name);
		jQuery('#other_option_container .add_option').text('Add '+ option_for);
		jQuery('#other_option_container').slideDown();
	}else if(jQuery(this).prop("checked") == false){				
		jQuery('#other_option_container').slideUp();
	}
});

jQuery(document).on('change', '#server_os', function(){
	var option_for = jQuery(this).val();
	if(option_for == 'Operating System'){		
		jQuery('#other_option_container .add_option').removeAttr('id');
		jQuery('#other_option_container .add_option').attr('id', 'server_os');
		jQuery('#other_option_container .add_option').text('Add '+ option_for);
		jQuery('#other_option_container').slideDown();
	}else{				
		jQuery('#other_option_container').slideUp();
	}
});
jQuery(document).on('change', '#service_name', function(){
	var value = jQuery(this).val();

	if(value == 'Add New Service Option'){
		jQuery('.add_client_service_input').fadeIn();
	}else{
		jQuery('.add_client_service_input').fadeOut();
	}

});

// jQuery(document).on('click', '#save_new_service', function(){
// 	var new_option = jQuery('.service_add_new').val();
// 	jQuery(this).prop('disabled', true);
// 	jQuery('.add-client-service-loader').css('display', 'block');
// 		jQuery.ajax({				
// 			type: "POST",
// 			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
// 			data:{
// 				'type' : 'add_new_service_option',
// 				'option' : new_option
// 			},
// 			success: function (data) {
// 				var parsed = jQuery.parseJSON(data);
// 				console.log(parsed);

// 				if(parsed.status == 'save-new-service-option'){
// 					jQuery('<option value="'+parsed.new_service_option+'">'+parsed.new_service_option+'</option>').insertBefore('#service_name option.add-new-service').prop('selected', true);
// 					jQuery('.add_client_service_input').fadeOut();
// 					jQuery('.service_add_new').val('');
// 					jQuery('.add-client-service-loader').css('display', 'none');
// 					jQuery('#save_new_service').prop('disabled', false);
// 				}else{

// 				}
// 			},
// 			error: function (data) {

// 			}				
// 		});
// });

// save_new_service
// jQuery(document).on('change', '#server_os_virtual', function(){
// 	console.log('virtual os');
// 	var option_for = jQuery(this).val();
// 	if(option_for == 'Operating System'){		
// 		jQuery('#other_option_container_virtual .add_option').removeAttr('id');
// 		jQuery('#other_option_container_virtual .add_option').attr('id', 'server_os_virtual');
// 		jQuery('#other_option_container_virtual .add_option').text('Add '+ option_for);
// 		jQuery('#other_option_container_virtual').slideDown();
// 	}else{				
// 		jQuery('#other_option_container_virtual').slideUp();
// 	}
// });


jQuery(document).on('click', '.add_option', function(){
	jQuery('.add_other_asset_loader').show();
	var option_name = jQuery(this).attr('id');
	var add_other_option = jQuery('.other_option_input').val();
	var form_details = option_name +'(join)'+ add_other_option;
	jQuery.ajax({				
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'form_details' : form_details,
			'type' : 'add_other_option'
		},
		success: function (data) {
			var data_split = data.split('(join)');
			var input_field = data_split[0];
			var input_value = data_split[1];
			if(input_field == 'server_os'){
				jQuery('<option value="'+input_value+'">'+input_value+'</option>').insertBefore('#server_os option.server_os').prop('selected', true);
			}else{
				jQuery('<div class="two_column">'
					+'<input class="'+input_field+' check_box" type="checkbox" value="'+input_value+'" name="'+input_field+'" checked="checked" />'
					+'<p class="check_box_label">'+input_value+'</p>'
					+'</div>'
				).insertBefore('input.'+input_field+'.other_option');
				jQuery('.other_option').prop('checked', false);				
			}
			jQuery('#other_option_container').slideUp();
			jQuery('#other_option_input').val(''); 
			jQuery('.add_other_asset_loader').hide();
		},
		error: function (data) {
			alert('error');
		}				
	});
});
/* ==================================== END OTHER OPTION ==================================== */
// END ADD SERVER

function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}


// ================================ END ASSET ================================ -->
</script>