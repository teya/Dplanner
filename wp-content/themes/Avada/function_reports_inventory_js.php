<script>
jQuery(document).on('change', '.top_client_filter', function(){
	var filter_type = jQuery(this).val();
	if(filter_type == '-- All Client --'){
		var client_name = 'all';
	}else{
		var client_name = filter_type;
	}
	jQuery('.inventory_loader').show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'inventory_client_filter',
			'client_name' : client_name				
		},
		success: function (data) {
			jQuery('.client_details').empty();
			jQuery('.client_details').html(data);
			jQuery('.inventory_loader').hide();
		},
		error: function (data) {
			
		}
	});	
});
</script>