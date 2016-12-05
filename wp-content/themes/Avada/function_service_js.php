<script type="text/javascript">

	jQuery('.service_start_date').datepicker();

	jQuery(document).on('click ', '.delete-service-option', function(){
		jQuery('.loader').show();
		var service_id = jQuery('#service_name').val();

		jQuery.ajax({				
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'delete_service_option',
				'data_id' : service_id
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);;
				jQuery("#service_name option[value='"+parsed.service_id+"']").remove();
				jQuery('.loader').hide();
				jQuery('.updating-service-status').fadeIn(1000).delay(2000).fadeOut(1000);
			},
			error: function (data) {

			}				
		});
	});

	// When selecting add new service, add service input will show
	 jQuery(document).on('change', '.service_name', function(){
	 	var selected = jQuery(this).val();
	 	if(selected == 'Add New Service Option'){
	 		jQuery('#service_input').fadeIn();
	 		jQuery('#service_input .service_add_new').val('');
	 		jQuery('.delete-service-option').hide();
	 	}else{
	 		jQuery('#service_input').fadeOut();
	 		jQuery('.delete-service-option').show();
	 	}	
	 });

	 // Ajax function for saving add new service option.
	 jQuery(document).on('click', '#save_new_service', function(){

	 	var new_option = jQuery('#service_input .service_add_new').val();

		jQuery.ajax({				
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'add_new_service_option',
				'option' : new_option
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				console.log(parsed);

				if(parsed.status == 'save-new-service-option'){
					jQuery('<option value="'+parsed.service_id+'">'+parsed.new_service_option+'</option>').insertBefore('#service_name option.add-new-service').prop('selected', true);
					jQuery('#service_input').fadeOut();
				}else{

				}
			},
			error: function (data) {

			}				
		});

	 });

	 jQuery(document).on('click', '#submit-form-add-service', function(){

	 	var option = jQuery('#service_name').val();

	 	if(option == 'Add New Service Option'){
	 		jQuery('.service-error').fadeIn();
	 		return false;
	 	}else{
	 		jQuery('.service-error').fadeOut();
	 		return true;
	 	}
	 });
</script>

<!-- new_service_option -->