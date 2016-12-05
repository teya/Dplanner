<script>
/*==================================== SCHEDULED TASK ==================================== */
jQuery(document).on('click', '#dialog_form_add_task .schedule_task', function(){
	if(!required_input()) return false;
	var submit_schedule_task_data = jQuery('#submit_task_form').serialize();
	jQuery(".schedule_task_loader").show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'submit_schedule_task_data' : submit_schedule_task_data,
			'type' : 'submit_schedule_task'
		},
		success: function (data) {
			jQuery('.dialog_form_add_task').dialog('close');
			jQuery(".schedule_task_loader").hide();
			var parsed = jQuery.parseJSON(data);
			jQuery('html, body').animate({ scrollTop: 0 }, 0);
			jQuery(".status_message p").text("Task Scheduled");
			jQuery(".status_message").fadeIn( "slow", function() {
				jQuery(".status_message").delay(2000).fadeOut('slow');
			});
			var estimated_hour = parsed.submit_time_estimate_hour;
			var estimated_minute = parsed.submit_time_estimate_minute;
			if(estimated_hour != null && estimated_minute != null){
				var estimated_time = parsed.submit_time_estimate_hour +' h'+ parsed.submit_time_estimate_minute +' m';
				}else if(estimated_hour != null && estimated_minute == null){
				var estimated_time = parsed.submit_time_estimate_hour +' h 0 m';
				}else if(estimated_hour == null && estimated_minute != null){
				var estimated_time = ' 0 h '+ parsed.submit_time_estimate_minute +' m';
				}else if(estimated_hour == null && estimated_minute == null){
				var estimated_time = '0 h 0 m';
			}
			jQuery.each( parsed.label_id, function(key, label_id) {
				var label_id_array = label_id.split('_');
				if(parsed.submit_task_name_suffix == ""){
					var task_name_suffix = parsed.submit_task_name;
					}else{
					var task_name_suffix = parsed.submit_task_name +' - '+ parsed.submit_task_name_suffix;
				}
				jQuery('.submit_task .submit_task_cells.scheduled_submit').append('<div id="column_cells_'+label_id_array[1]+'" class="column_cells">'
				+'<div class="bulk_action_column column"><input class="bulk_delete" type="checkbox" value="'+label_id_array[1]+'" name="bulk_delete_id[]"></div>'
				+'<div class="first_column column"><p class="table_header">'+task_name_suffix+'</p></div>'
				+'<div class="second_column column"><p class="table_header">'+((label_id_array[0] == "") ? "--" : label_id_array[0])+'</p></div>'
				+'<div class="third_column column"><p class="table_header">'+((parsed.submit_responsible_person == "") ? "--" : parsed.submit_responsible_person)+'</p></div>'
				+'<div class="fourth_column column"><p class="table_header">'+((parsed.submit_schedule_each == "") ? "--" : parsed.submit_schedule_each)+'</p></div>'
				+'<div class="fifth_column column"><p class="table_header">'+estimated_time+'</p></div>'
				+'<div class="sixth_column column">--</div>'
				+'<div class="seventh_column column"><p class="table_header">Ongoing</p></div>'
				+'<div class="eighth_column column">'
				+'<div class="table_header">'
				+'<p id="edit_task_cron_'+label_id_array[1]+'" class="edit_task_cron action_buttons">Edit</p>'
				+'<p id="delete_task_cron_'+label_id_array[1]+'" class="delete_task_cron confirm action_buttons">Delete</p>'
				+'<p id="pause_task_cron_'+label_id_array[1]+'" class="pause_task_cron confirm action_buttons">Pause</p>'
				+'</div></div>'
				+'<div style="display:none;" id="submit_task_note_'+label_id_array[1]+'" class="submit_task_note">'+((parsed.submit_description == "") ? "--" : parsed.submit_description)+'</div>'
				);
			});
			required_input();
		},
		error: function (data) {
			alert('error');
		}				
	});
});
/*==================================== END SCHEDULED TASK ==================================== */

/* ==================================== SUBTASK ==================================== */
jQuery(document).ready(function(){
	jQuery( ".dialog_form_add_subtask" ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		close: function() {
		}
	});
});

jQuery(document).on('click', '#submit_subtask', function(){
	jQuery(".loader").show();
	jQuery(".status_message p").text("Getting Task Names from KanbanFlow");
	jQuery(".status_message").fadeIn("slow")
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{'type' : 'submit_subtask_form'},
		success: function (data) {
			jQuery(".loader").hide();
			jQuery('#dialog_form_add_subtask').dialog('open');
			jQuery(".status_message").delay(1000).fadeOut('slow');
			jQuery("#dialog_form_add_subtask").html(data);
		},
		error: function (data) {
			alert('error');
		}				
	});
});	
/* ==================================== END SUBTASK ==================================== */

/*==================================== SAVE CLIENT PROJECT ==================================== */
// function trigger_save_client_project(){
	// jQuery('#submit_project_client .project_start_date').datepicker();
	// jQuery('#submit_project_client .project_estimated_deadline').datepicker();
	// jQuery('#submit_project_client .project_date_completed').datepicker();
	// jQuery('#submit_project_client .project_invoice_date').datepicker();
	// jQuery('#submit_project_client .save_project_client').click(function(){
		// jQuery('#submit_project_client .loader').show();
		// var save_project_client = jQuery('#submit_project_client').serialize();
			// jQuery.ajax({
			// type: "POST",
			// url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			// data:{
			// 'save_project_client' : save_project_client,
			// 'type' : 'save_client_project'
			// },
			// success: function (data) {
				// jQuery('#submit_project_client .loader').hide();
				// if(data == 1){
					// jQuery('#dialog_form_add_project_client').dialog('close');
				// }else{
					// jQuery("<div class='status_message'><p>ERROR: Project was not saved</p></div>").fadeIn( "slow", function() {
					// jQuery(".status_message").delay(2000).fadeOut('slow');
				// });
				// }
			// },
			// error: function (data) {
				// alert('error');
			// }				
		// });
	// });
// }
/* ==================================== SAVE CLIENT PROJECT ==================================== */

/* ==================================== ADD TASK ==================================== */
jQuery(document).ready(function(){	
	jQuery( ".dialog_form_add_task" ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		close: function() {
		}
	});
	
	jQuery('#submit_addtask').click(function(){
		jQuery('.dialog_form_add_task').dialog('open');
	});
	
	var counter = 1;
	jQuery('.add_subtask_button').click(function(){
		var subtasks = jQuery('.sub_task').val();
		jQuery('.subtask_container').append('<li class="subtask_list" id="subtask_'+counter+'">'
		+'<input type="hidden" class="submit_subtask" name="submit_subtask[]" value="'+subtasks+'"/><p>'+subtasks+'</p>'
		+'<div id="subtask_delete_'+counter+'" class="confirm subtask_delete button_2 subtask_action_button">D</div>'
		+'<div id="subtask_edit_'+counter+'" class="subtask_edit button_2 subtask_action_button">E</div>'		
		+'</li>'
		+'<div class="edit_div" id="edit_div_'+counter+'" style="display:none;">'
		+'<input type="text"  id="subtask_edit_area_'+counter+'" class="subtask_edit_area" />'
		+'<div id="check_edit_'+counter+'" class="check_edit"></div>'
		+'</div>'
		);
		jQuery(".sub_task").val("");
		counter++;
		jQuery('.subtask_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(13, div_id.length);
			var edit_data = jQuery('#subtask_'+data_id+' p').text();
			jQuery('#subtask_'+data_id).hide();
			jQuery('#edit_div_'+data_id).css('display', 'block');
			jQuery('#subtask_edit_area_'+data_id).val(edit_data);
		});
		jQuery('.check_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(11, div_id.length);
			var edited_value = jQuery('#subtask_edit_area_'+data_id).val();
			jQuery('#edit_div_'+data_id).css('display', 'none');
			jQuery('#subtask_'+data_id).show();
			jQuery('#subtask_'+data_id+' p').text(edited_value);
			jQuery('#subtask_'+data_id+' .submit_subtask').val(edited_value);
		});		
		jQuery('.subtask_delete').click(function(){		
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(15, div_id.length);
			jQuery('#subtask_'+data_id).remove();
			jQuery('#edit_div_'+data_id).remove();
		});		
	});
	
	jQuery( "#add_project_client_confirm" ).dialog({
		autoOpen: false,
		height: 150,
		width: 285,
		modal: true,
		close: function() {
		}
	});	
	
	jQuery( "#dialog_form_add_project_client" ).dialog({
		autoOpen: false,
		height: 500,
		width: 285,
		modal: true,
		close: function() {
		}
	});	
	
	jQuery('#submit_task_form .submit_label').click(function(){
		var project_name = jQuery('#submit_task_form #submit_project_name').val();
		var client_name = jQuery('#submit_task_form .submit_label :selected:last').val();
		jQuery('.submit_select_client .loader').show();
		var check_details = project_name +'_'+ client_name +'_'+ 'null';
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'check_details' : check_details,
				'type' : 'check_project_details'
			},
			success: function (data) {
				jQuery('.submit_select_client .loader').hide();
				var parsed = jQuery.parseJSON(data);
				var response = parsed.response;
				var client_name = parsed.client_name;
				var project_name = parsed.project_name;
				if(response == '0'){
					jQuery('#add_project_client_confirm').dialog('open');					
					jQuery('#add_project_client_confirm  h3.add_project_client_title').html('Add project: ' +project_name+ ' to client: ' +client_name+ '?');
					jQuery('#add_project_client_confirm #add_project_client_form .client_name').val(client_name);
					jQuery('#add_project_client_confirm #add_project_client_form .project_name').val(project_name);
				}else{
					jQuery(".project_check").fadeIn( "slow", function() {
						jQuery(".project_check").delay(1000).fadeOut('slow');
					});
				}
			},
			error: function (data) {
				alert('error');
			}				
		});
	});
	
	
	jQuery('#submit_project_client .cancel_add_project_client').click(function(){
		jQuery('#dialog_form_add_project_client').dialog('close');
	});
	jQuery('#add_project_client_confirm .add_project_buttons .cancel_add_project_client').click(function(){
		jQuery('#add_project_client_confirm').dialog('close');
	});	
	var checklist_counter = 0;
	jQuery('#submit_checklist').click(function(){
		if(jQuery(this).prop("checked") == true){				
			jQuery('#submit_task_form .submit_checklist_div').slideDown();
			var current_selected_template = jQuery('#submit_task_form .submit_checklist_div .submit_checklist_template').val();			
			jQuery('#subtask .subtask_container').append('<li class="subtask_list task_checklist" id="subtask_'+checklist_counter+'">'
			+'<input type="hidden" class="submit_subtask" name="submit_subtask[]" value="'+ current_selected_template +'" />'
			+'<p>'+current_selected_template+'</p>'
			+'<div id="subtask_delete_'+checklist_counter+'" class="confirm subtask_delete button_2 subtask_action_button">D</div>'
			+'<div id="subtask_edit_'+checklist_counter+'" class="subtask_edit button_2 subtask_action_button">E</div>'		
			+'</li>'
			+'<div class="edit_div" id="edit_div_'+checklist_counter+'" style="display:none;">'
			+'<input type="text"  id="subtask_edit_area_'+checklist_counter+'" class="subtask_edit_area" />'
			+'<div id="check_edit_'+checklist_counter+'" class="check_edit"></div>'
			+'</div>'
			);			
        }else if(jQuery(this).prop("checked") == false){				
			jQuery('#submit_task_form .submit_checklist_div').slideUp();
			jQuery('#subtask .subtask_container .task_checklist').remove();
		}
		jQuery('#submit_task_form .add_template').click(function(){
			var template_name = jQuery('.add_checklist_template_input').val();
			jQuery('.add_template_loader').show();
			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'check_template_exist',
					'template_name' : template_name				
				},
				success: function (data) {
					jQuery('.add_template_loader').hide();
					var data_split = data.split('<_>');
					var check_result = data_split[0];
					var template_name = data_split[1];
					if(check_result == 'not_exist'){
						var copy_template = jQuery('.submit_checklist_template').val();
						jQuery('#subtask .subtask_container .task_checklist p').text(template_name);
						jQuery('#subtask .subtask_container .task_checklist .submit_subtask').val(template_name);
						jQuery('.template_exist_note').removeClass('text_red').addClass('full_width');
						jQuery(".template_exist_note").html('Copy <strong>'+copy_template+'</strong> to <strong>' +template_name +'</strong>');
						jQuery(".template_exist_note").fadeIn( "slow", function() {
							jQuery(".template_exist_note").delay(3000).fadeOut('slow');
						});
					}else if(check_result == 'exist'){	
						jQuery(".template_exist_note").text('Template name already exist.');
						jQuery(".template_exist_note").fadeIn( "slow", function() {
							jQuery(".template_exist_note").delay(1500).fadeOut('slow');
						});
					}
					
				},
				error: function (data) {
					
				}
			});	
		});		
		jQuery('.subtask_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var data_id = div_id_split[2];
			var edit_data = jQuery('#subtask_'+data_id+' p').text();
			jQuery('#subtask_'+data_id).hide();
			jQuery('#edit_div_'+data_id).css('display', 'block');
			jQuery('#subtask_edit_area_'+data_id).val(edit_data);
		});
		jQuery('.check_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var data_id = div_id_split[2];
			var edited_value = jQuery('#subtask_edit_area_'+data_id).val();
			jQuery('#edit_div_'+data_id).css('display', 'none');
			jQuery('#subtask_'+data_id).show();
			jQuery('#subtask_'+data_id+' p').text(edited_value);
			jQuery('#subtask_'+data_id+ ' .submit_subtask').val(edited_value);
		});		
		jQuery('.subtask_delete').click(function(){		
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var data_id = div_id_split[2];
			jQuery('#subtask_'+data_id).remove();
			jQuery('#edit_div_'+data_id).remove();
		});	
	});
	
	jQuery('#submit_task_form .submit_checklist_template').change(function(){
		var checklist_template_name = jQuery(this).val();
		jQuery('#submit_task_form #subtask li#subtask_0 p').text(checklist_template_name);
		jQuery('#submit_task_form #subtask li#subtask_0 input.submit_subtask').val(checklist_template_name);
	});
});
/* ==================================== END ADD TASK ==================================== */

/* ==================================== SUBMIT NOW TASK ==================================== */
jQuery(document).on('click', '.submit_now', function(){
	jQuery('.submit_schedule_each').removeClass('required');
	if(!required_input()) return false;
	var submit_now_task_data = jQuery('#submit_task_form').serialize();
	jQuery(".schedule_task_loader").show();
	jQuery.ajax({				
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'submit_now_task_data' : submit_now_task_data,
			'type' : 'submit_now_task'
		},
		success: function (data) {
			jQuery('.dialog_form_add_task').dialog('close');
			jQuery(".schedule_task_loader").hide();
			var parsed = jQuery.parseJSON(data);
			jQuery('html, body').animate({ scrollTop: 0 }, 0);
			jQuery(".status_message p").text("Task Submitted");
			jQuery(".status_message").fadeIn( "slow", function() {
				jQuery(".status_message").delay(2000).fadeOut('slow');
			});
			var estimated_hour = parsed.submit_time_estimate_hour;
			var estimated_minute = parsed.submit_time_estimate_minute;
			if(estimated_hour != null && estimated_minute != null){
				var estimated_time = parsed.submit_time_estimate_hour +' h'+ parsed.submit_time_estimate_minute +' m';
				}else if(estimated_hour != null && estimated_minute == null){
				var estimated_time = parsed.submit_time_estimate_hour +' h 0 m';
				}else if(estimated_hour == null && estimated_minute != null){
				var estimated_time = ' 0 h '+ parsed.submit_time_estimate_minute +' m';
				}else if(estimated_hour == null && estimated_minute == null){
				var estimated_time = '0 h 0 m';
			}
			jQuery.each( parsed.label_id, function(key, label_id) {
				var label_id_array = label_id.split('_');
				if(parsed.submit_task_name_suffix == ""){
					var task_name_suffix = parsed.submit_task_name;
					}else{
					var task_name_suffix = parsed.submit_task_name +' - '+ parsed.submit_task_name_suffix;
				}
				jQuery('.submit_task .submit_task_cells.scheduled_submit').append('<div id="column_cells_'+label_id_array[1]+'" class="column_cells">'
				+'<div class="bulk_action_column column"><input class="bulk_delete" type="checkbox" value="'+label_id_array[1]+'" name="bulk_delete_id[]"></div>'
				+'<div class="first_column column"><p class="table_header">'+task_name_suffix+'</p></div>'
				+'<div class="second_column column"><p class="table_header">'+((label_id_array[0] == "") ? "--" : label_id_array[0])+'</p></div>'
				+'<div class="third_column column"><p class="table_header">'+((parsed.submit_responsible_person == "") ? "--" : parsed.submit_responsible_person)+'</p></div>'
				+'<div class="fourth_column column"><p class="table_header">Submitted</p></div>'
				+'<div class="fifth_column column"><p class="table_header">'+estimated_time+'</p></div>'
				+'<div class="sixth_column column">--</div>'
				+'<div class="eighth_column column">'
				+'<div class="table_header">'
				+'<p id="edit_task_cron_'+label_id_array[1]+'" class="edit_task_cron action_buttons">Edit</p>'
				+'<p id="delete_task_cron_'+label_id_array[1]+'" class="delete_task_cron confirm action_buttons">Delete</p>'
				+'<p id="pause_task_cron_'+label_id_array[1]+'" class="pause_task_cron confirm action_buttons">Pause</p>'
				+'</div></div>'
				+'<div style="display:none;" id="submit_task_note_'+label_id_array[1]+'" class="submit_task_note">'+((parsed.submit_description == "") ? "--" : parsed.submit_description)+'</div>'
				);
			});
			required_input();
		},
		error: function (data) {
			alert('error');
		}				
	});
});
/* ==================================== END SUBMIT NOW TASK ==================================== */

/* ==================================== DELETE TASK ==================================== */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_delete_task" ).dialog({
		autoOpen: false,
		height: 150,
		width: 285,
		modal: true,
		close: function() {
		}
	});		
});

jQuery(document).on('click', '.delete_task_cron', function(){
	jQuery('#dialog_form_delete_task').dialog('open');
	var div_id = jQuery(this).attr('id');
	var data_id = div_id.substring(17, div_id.length);
	jQuery('#dialog_form_delete_task #delete_task_id').val(data_id);
	
	jQuery('#dialog_form_delete_task .delete_confirm').click(function(){
		jQuery("#dialog_form_delete_task .loader").show();
		jQuery.ajax({				
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data: {'data_id' : data_id, 'type' : 'submit_task_delete_cron'},
			success: function (data) {
				jQuery('#dialog_form_delete_task').dialog('close');
				var parsed = jQuery.parseJSON(data);
				jQuery('#column_cells_'+parsed).css('display' , 'none');
				jQuery(".loader").hide();
				jQuery(".status_message p").text("Task Deleted");
				jQuery(".status_message").fadeIn( "slow", function() {
					jQuery(".status_message").delay(1000).fadeOut('slow');
				});	
			},
			error: function (data) {
				alert('error');
			}		
		});
	});			
});	

jQuery(document).on('click', '.delete_cancel', function(){
	jQuery("#dialog_form_delete_task").dialog("close");
	jQuery('.loader').hide();
});
/* ==================================== END DELETE TASK ==================================== */

/* ==================================== PAUSE TASK ==================================== */
jQuery(document).on('click', '.pause_task_cron', function(){
	var div_id = jQuery(this).attr('id');
	var data_id = div_id.substring(16, div_id.length);
	jQuery("#loader_"+data_id).show();
	jQuery.ajax({				
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data: {'data_id' : data_id, 'type' : 'submit_task_pause_cron'},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);
			var submit_id = parsed.submit_id;
			var submit_task_name = ((parsed.submit_task_name == "") ? "--" : parsed.submit_task_name);
			var submit_label = ((parsed.submit_label == "") ? "--" : parsed.submit_label);
			var submit_responsible_person = ((parsed.submit_responsible_person == "") ? "--" : parsed.submit_responsible_person);
			var submit_schedule_each = ((parsed.submit_schedule_each == "") ? "--" : parsed.submit_schedule_each);				
			var estimated_hour = parsed.submit_time_estimate_hour;
			var estimated_minute = parsed.submit_time_estimate_minute;
			if(estimated_hour != null && estimated_minute != null){
				var estimated_time = parsed.submit_time_estimate_hour +' h'+ parsed.submit_time_estimate_minute +' m';
				}else if(estimated_hour != null && estimated_minute == null){
				var estimated_time = parsed.submit_time_estimate_hour +' h 0 m';
				}else if(estimated_hour == null && estimated_minute != null){
				var estimated_time = ' 0 h '+ parsed.submit_time_estimate_minute +' m';
				}else if(estimated_hour == null && estimated_minute == null){
				var estimated_time = '0 h 0 m';
			}
			if(parsed.submit_task_name_suffix == ""){
				var task_name_suffix = parsed.submit_task_name;
				}else{
				var task_name_suffix = parsed.submit_task_name +' - '+ parsed.submit_task_name_suffix;
			}	
			jQuery('#column_cells_'+submit_id).remove();
			jQuery('.paused_task .submit_task_cells').append('<div id="column_cells_'+submit_id+'" class="column_cells">'
			+'<div class="bulk_action_column column"><input type="checkbox" name="bulk_delete_id[]" class="bulk_delete_paused" value="'+parsed.submit_id+'"></div>'
			+'<div class="first_column column"><p class="table_header">'+task_name_suffix+'</p></div>'
			+'<div class="second_column column"><p class="table_header">'+submit_label+'</p></div>'
			+'<div class="third_column column"><p class="table_header">'+submit_responsible_person+'</p></div>'
			+'<div class="fourth_column column"><p class="table_header">'+submit_schedule_each+'</p></div>'
			+'<div class="fifth_column column"><p class="table_header">'+estimated_time+'</p></div>'
			+'<div class="sixth_column column"><p class="table_header">--</p></div>'
			+'<div class="seventh_column column"><p class="table_header">Paused</p></div>'
			+'<div class="eighth_column column">'
			+'<div class="table_header">'
			+'<p id="edit_task_cron_'+submit_id+'" class="edit_task_cron action_buttons">Edit</p>'
			+'<p id="delete_task_cron_'+submit_id+'" class="delete_task_cron confirm action_buttons">Delete</p>'				
			+'<p id="start_task_cron_'+submit_id+'" class="start_task_cron action_buttons">Start</p>'
			+'</div>'
			+'</div>'
			);
			jQuery(".loader").hide();
		},
		error: function (data) {
			alert('error');
		}		
	});
});
/* ==================================== END PAUSE TASK ==================================== */

/* ==================================== START TASK ==================================== */
jQuery(document).ready(function(){
	jQuery( ".dialog_form_start_task" ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		close: function() {
		}
	});		
});

jQuery(document).on('click', '.start_task_cron', function(){
	var div_id = jQuery(this).attr('id');
	var data_id = div_id.substring(16, div_id.length);
	jQuery(".schedule_start_task_loader").show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{'data_id': data_id, 'type' : 'submit_start_cron_form'},
		success: function (data) {				
			jQuery(".schedule_start_task_loader").hide();
			jQuery('#dialog_form_start_task').dialog('open');
			jQuery(".status_message").delay(1000).fadeOut('slow');
			jQuery("#dialog_form_start_task").html(data);
			trigger_start_task_submit();
		},
		error: function (data) {
			alert('error');
		}				
	});
});	

function trigger_start_task_submit(){
	jQuery('#dialog_form_start_task .submit_starting_date').datepicker();
	jQuery('.tab_general').click(function(){
		jQuery(this).addClass('active');
		jQuery('.tab_subtask').removeClass('active');
		jQuery('.tabs-container #general').css('display','block');
		jQuery('.tabs-container #subtask').css('display','none');
	});
	jQuery('.tab_subtask').click(function(){
		jQuery(this).addClass('active');
		jQuery('.tab_general').removeClass('active');
		jQuery('.tabs-container #general').css('display','none');
		jQuery('.tabs-container #subtask').css('display','block');
	});
	
	var start_form_data = jQuery('#submit_start_task_form').serialize();
	var subtask_form_counter = jQuery('input[name="submit_subtask_counter"]').val();
	if(subtask_form_counter == 1){
		var counter = 1;
	}else{
		var counter = subtask_form_counter;
	}
	jQuery('#dialog_form_start_task .add_subtask_button').click(function(){
		var subtasks = jQuery('#dialog_form_start_task .sub_task').val();
		jQuery('#dialog_form_start_task .subtask_container').append('<li class="subtask_list" id="subtask_'+counter+'">'
		+'<input type="hidden" name="submit_subtask[]" value="'+subtasks+'"/><p>'+subtasks+'</p>'
		+'<div id="subtask_delete_'+counter+'" class="confirm subtask_delete button_2 subtask_action_button">D</div>'
		+'<div id="subtask_edit_'+counter+'" class="subtask_edit button_2 subtask_action_button">E</div>'		
		+'</li>'
		+'<div class="edit_div" id="edit_div_'+counter+'" style="display:none;">'
		+'<input type="text"  id="subtask_edit_area_'+counter+'" class="subtask_edit_area" />'
		+'<div id="check_edit_'+counter+'" class="check_edit"></div>'
		+'</div>'
		);
		jQuery(".sub_task").val("");
		counter++;
		jQuery('#dialog_form_start_task .subtask_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(13, div_id.length);
			var edit_data = jQuery('#subtask_'+data_id+' p').text();
			jQuery('#subtask_'+data_id).hide();
			jQuery('#edit_div_'+data_id).css('display', 'block');
			jQuery('#subtask_edit_area_'+data_id).val(edit_data);
		});
		jQuery('#dialog_form_start_task .check_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(11, div_id.length);
			var edited_value = jQuery('#subtask_edit_area_'+data_id).val();
			jQuery('#edit_div_'+data_id).css('display', 'none');
			jQuery('#subtask_'+data_id).show();
			jQuery('#subtask_'+data_id+' p').text(edited_value);
		});		
		jQuery('#dialog_form_start_task .subtask_delete').click(function(){		
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(15, div_id.length);
			jQuery('#subtask_'+data_id).remove();
			jQuery('#edit_div_'+data_id).remove();
		});		
	});
	jQuery('#dialog_form_start_task .subtask_edit').click(function(){
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(13, div_id.length);
		var edit_data = jQuery('#subtask_'+data_id+' p').text();
		jQuery('#subtask_'+data_id).hide();
		jQuery('#edit_div_'+data_id).css('display', 'block');
		jQuery('#subtask_edit_area_'+data_id).val(edit_data);
	});
	jQuery('#dialog_form_start_task .check_edit').click(function(){
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(11, div_id.length);
		var edited_value = jQuery('#subtask_edit_area_'+data_id).val();
		jQuery('#edit_div_'+data_id).css('display', 'none');
		jQuery('#subtask_'+data_id).show();
		jQuery('#subtask_'+data_id+' p').text(edited_value);
	});		
	jQuery('#dialog_form_start_task .subtask_delete').click(function(){		
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(15, div_id.length);
		jQuery('#subtask_'+data_id).remove();
		jQuery('#edit_div_'+data_id).remove();
	});

	/* START SCHEDULED TASK */	
	jQuery('#dialog_form_start_task .schedule_task').click(function(){		
		var submit_start_schedule_task_data = jQuery('#submit_start_task_form').serialize();
		jQuery("#dialog_form_start_task .schedule_task_loader").show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'submit_start_schedule_task_data' : submit_start_schedule_task_data,
				'type' : 'submit_start_schedule_task'
			},
			success: function (data) {
				jQuery('.dialog_form_start_task').dialog('close');
				jQuery(".schedule_task_loader").hide();
				var parsed = jQuery.parseJSON(data);
				jQuery('html, body').animate({ scrollTop: 0 }, 0);
				jQuery(".status_message p").text("Task Started");
				jQuery(".status_message").fadeIn( "slow", function() {
					jQuery(".status_message").delay(2000).fadeOut('slow');
				});
				var submit_id = parsed.submit_start_id;
				var submit_label = ((parsed.submit_label == "") ? "--" : parsed.submit_label);
				var submit_responsible_person = ((parsed.submit_responsible_person == "") ? "--" : parsed.submit_responsible_person);
				var submit_schedule_each = ((parsed.submit_schedule_each == "") ? "--" : parsed.submit_schedule_each);
				var submit_starting_date = ((parsed.submit_starting_date == "") ? "--" : parsed.submit_starting_date);				
				var estimated_hour = parsed.submit_time_estimate_hour;
				var estimated_minute = parsed.submit_time_estimate_minute;
				if(estimated_hour != null && estimated_minute != null){
					var estimated_time = parsed.submit_time_estimate_hour +' h'+ parsed.submit_time_estimate_minute +' m';
					}else if(estimated_hour != null && estimated_minute == null){
					var estimated_time = parsed.submit_time_estimate_hour +' h 0 m';
					}else if(estimated_hour == null && estimated_minute != null){
					var estimated_time = ' 0 h '+ parsed.submit_time_estimate_minute +' m';
					}else if(estimated_hour == null && estimated_minute == null){
					var estimated_time = '0 h 0 m';
				}
				
				if(parsed.submit_task_name_suffix == ""){
					var task_name_suffix = parsed.submit_task_name;
					}else{
					var task_name_suffix = parsed.submit_task_name +' - '+ parsed.submit_task_name_suffix;
				}					
				
				jQuery('.paused_task .submit_task_cells #column_cells_'+submit_id).hide();				
				jQuery('.temp_container').append('<div id="column_cells_'+submit_id+'" class="column_cells">'
				+'<div class="bulk_action_column column"><input class="bulk_delete" type="checkbox" value="'+submit_id+'" name="bulk_delete_id[]"></div>'
				+'<div class="first_column column"><p class="table_header">'+task_name_suffix+'</p></div>'
				+'<div class="second_column column"><p class="table_header">'+submit_label+'</p></div>'
				+'<div class="third_column column"><p class="table_header">'+submit_responsible_person+'</p></div>'
				+'<div class="fourth_column column"><p class="table_header">'+submit_schedule_each+'</p></div>'
				+'<div class="fifth_column column"><p class="table_header">'+estimated_time+'</p></div>'
				+'<div class="sixth_column column"><p class="table_header">'+submit_starting_date+'</p></div>'
				+'<div class="seventh_column column"><p class="table_header">Ongoing</p></div>'
				+'<div class="eighth_column column">'
				+'<div class="table_header">'
				+'<p id="edit_task_cron_'+submit_id+'" class="edit_task_cron action_buttons">Edit</p>'
				+'<p id="delete_task_cron_'+submit_id+'" class="delete_task_cron confirm action_buttons">Delete</p>'
				+'<p id="pause_task_cron_'+submit_id+'" class="pause_task_cron confirm action_buttons">Pause</p>'
				+'</div>'
				+'</div>'
				+'</div>'
				);
				if(!required_input()) return false;
				required_input();
			},
			error: function (data) {
				alert('error');
			}				
		});
	});
	/* END START SCHEDULED TASK */
}

/* ==================================== END START TASK ==================================== */

/* ==================================== EDIT TASK ==================================== */

jQuery(document).ready(function(){
	jQuery( ".dialog_form_edit_task" ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		close: function() {
		}
	});		
});

jQuery(document).on('click','.edit_task_cron', function(){
	var div_id = jQuery(this).attr('id');
	var data_id = div_id.substring(15, div_id.length);
	jQuery("#loader_"+data_id).show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{'data_id': data_id, 'type' : 'submit_edit_cron_form'},
		success: function (data) {
			jQuery(".loader").hide();
			jQuery('#dialog_form_edit_task').dialog('open');
			jQuery(".status_message").delay(1000).fadeOut('slow');
			jQuery("#dialog_form_edit_task").html(data);
			trigger_edit_task_submit();
			trigger_month_week_year_change();
		},
		error: function (data) {
			alert('error');
		}				
	});
});	

function trigger_edit_task_submit(){
	jQuery('#dialog_form_edit_task .submit_starting_date').datepicker();
	jQuery('.tab_general').click(function(){
		jQuery(this).addClass('active');
		jQuery('.tab_subtask').removeClass('active');
		jQuery('.tabs-container #general').css('display','block');
		jQuery('.tabs-container #subtask').css('display','none');
	});
	jQuery('.tab_subtask').click(function(){
		jQuery(this).addClass('active');
		jQuery('.tab_general').removeClass('active');
		jQuery('.tabs-container #general').css('display','none');
		jQuery('.tabs-container #subtask').css('display','block');
	});
	
	var start_form_data = jQuery('#submit_start_task_form').serialize();
	var subtask_form_counter = jQuery('input[name="submit_subtask_counter"]').val();
	if(subtask_form_counter == 1){
		var counter = 1;
		}else{
		var counter = subtask_form_counter;
	}
	jQuery('#dialog_form_edit_task .add_subtask_button').click(function(){
		var subtasks = jQuery('#dialog_form_edit_task .sub_task').val();
		jQuery('#dialog_form_edit_task .subtask_container').append('<li class="subtask_list" id="subtask_'+counter+'">'
		+'<input type="hidden" name="submit_subtask[]" value="'+subtasks+'"/><p>'+subtasks+'</p>'
		+'<div id="subtask_delete_'+counter+'" class="confirm subtask_delete button_2 subtask_action_button">D</div>'
		+'<div id="subtask_edit_'+counter+'" class="subtask_edit button_2 subtask_action_button">E</div>'		
		+'</li>'
		+'<div class="edit_div" id="edit_div_'+counter+'" style="display:none;">'
		+'<input type="text"  id="subtask_edit_area_'+counter+'" class="subtask_edit_area" />'
		+'<div id="check_edit_'+counter+'" class="check_edit"></div>'
		+'</div>'
		);
		jQuery(".sub_task").val("");
		counter++;
		jQuery('#dialog_form_edit_task .subtask_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(13, div_id.length);
			var edit_data = jQuery('#subtask_'+data_id+' p').text();
			jQuery('#subtask_'+data_id).hide();
			jQuery('#edit_div_'+data_id).css('display', 'block');
			jQuery('#subtask_edit_area_'+data_id).val(edit_data);
		});
		jQuery('#dialog_form_edit_task .check_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(11, div_id.length);
			var edited_value = jQuery('#subtask_edit_area_'+data_id).val();
			jQuery('#edit_div_'+data_id).css('display', 'none');
			jQuery('#subtask_'+data_id).show();
			jQuery('#subtask_'+data_id+' p').text(edited_value);
		});		
		jQuery('#dialog_form_edit_task .subtask_delete').click(function(){		
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(15, div_id.length);
			jQuery('#subtask_'+data_id).remove();
			jQuery('#edit_div_'+data_id).remove();
		});		
	});
	jQuery('#dialog_form_edit_task .subtask_edit').click(function(){
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(13, div_id.length);
		var edit_data = jQuery('#subtask_'+data_id+' p').text();
		jQuery('#subtask_'+data_id).hide();
		jQuery('#edit_div_'+data_id).css('display', 'block');
		jQuery('#subtask_edit_area_'+data_id).val(edit_data);
	});
	jQuery('#dialog_form_edit_task .check_edit').click(function(){
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(11, div_id.length);
		var edited_value = jQuery('#subtask_edit_area_'+data_id).val();
		jQuery('#edit_div_'+data_id).css('display', 'none');
		jQuery('#subtask_'+data_id).show();
		jQuery('#subtask_'+data_id+' p').text(edited_value);
	});		
	jQuery('#dialog_form_edit_task .subtask_delete').click(function(){		
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(15, div_id.length);
		jQuery('#subtask_'+data_id).remove();
		jQuery('#edit_div_'+data_id).remove();
	});
	
	/* EDIT SCHEDULED TASK */	
	jQuery('#dialog_form_edit_task .schedule_task').click(function(){		
		var submit_edit_schedule_task_data = jQuery('#submit_edit_task_form').serialize();
		jQuery("#dialog_form_edit_task .schedule_task_loader").show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'submit_edit_schedule_task_data' : submit_edit_schedule_task_data,
				'type' : 'submit_edit_schedule_task'
			},
			success: function (data) {
				jQuery('.dialog_form_edit_task').dialog('close');
				jQuery(".schedule_task_loader").hide();
				var parsed = jQuery.parseJSON(data);
				jQuery('html, body').animate({ scrollTop: 0 }, 0);
				jQuery(".status_message p").text("Task Updated");
				jQuery(".status_message").fadeIn( "slow", function() {
					jQuery(".status_message").delay(2000).fadeOut('slow');
				});
				var estimated_hour = parsed.submit_time_estimate_hour;
				var estimated_minute = parsed.submit_time_estimate_minute;
				if(estimated_hour != null && estimated_minute != null){
					var estimated_time = parsed.submit_time_estimate_hour +' h'+ parsed.submit_time_estimate_minute +' m';
					}else if(estimated_hour != null && estimated_minute == null){
					var estimated_time = parsed.submit_time_estimate_hour +' h 0 m';
					}else if(estimated_hour == null && estimated_minute != null){
					var estimated_time = ' 0 h '+ parsed.submit_time_estimate_minute +' m';
					}else if(estimated_hour == null && estimated_minute == null){
					var estimated_time = '0 h 0 m';
				}
				if(parsed.submit_task_name_suffix == ""){
					var task_name_suffix = parsed.submit_task_name;
				}else{
					var task_name_suffix = parsed.submit_task_name +' - '+ parsed.submit_task_name_suffix;
				}				
				jQuery('#column_cells_'+parsed.submit_edit_id+' .first_column p').text(task_name_suffix);
				jQuery('#column_cells_'+parsed.submit_edit_id+' .second_column p').text((parsed.submit_label == "") ? "--" : parsed.submit_label);
				jQuery('#column_cells_'+parsed.submit_edit_id+' .third_column p').text((parsed.submit_responsible_person == "") ? "--" : parsed.submit_responsible_person);
				jQuery('#column_cells_'+parsed.submit_edit_id+' .fourth_column p').text((parsed.submit_schedule_each == "") ? "--" : parsed.submit_schedule_each);
				jQuery('#column_cells_'+parsed.submit_edit_id+' .fifth_column p').text(estimated_time);
				jQuery('#column_cells_'+parsed.submit_edit_id+' .sixth_column p').text('--');
				jQuery('#column_cells_'+parsed.submit_edit_id+' .seventh_column p').text('Ongoing');
				if(!required_input()) return false;
				required_input();
				
			},
			error: function (data) {
				alert('error');
			}				
		});
	});
	/* END EDIT SCHEDULED TASK */
}

/* ==================================== END EDIT TASK ==================================== */
function seen_screen(elem){
    var $elem = $(elem);
    var $window = $(window);

    var docViewTop = $window.scrollTop();
    var docViewBottom = docViewTop + $window.height();

    var elemTop = $elem.offset().top;
    var elemBottom = elemTop + $elem.height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}
/* ==================================== BULK ACTIONS ==================================== */
jQuery(document).ready(function(){
	jQuery('#check_all').click(function () {    
		jQuery('.ongoing .bulk_action_id').prop('checked', this.checked);    
	});
	
	jQuery('#check_all_paused').click(function () {    
		jQuery('.paused_task .bulk_action_id').prop('checked', this.checked);    
	});	
	
	jQuery('#check_all_submitted').click(function () {    
		jQuery('.submitted_task .bulk_action_id').prop('checked', this.checked);    
	});	
	
	jQuery('.bulk_action_id').click(function(){
		seen_screen('.bulk_action_select');
	});
	
	jQuery( "#dialog_form_bulk_action_task" ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		close: function() {
			title: '';
		}
	});	
});
function trigger_start_date_daterpicker(){
	jQuery('.submit_starting_date').datepicker();
}
jQuery(document).on('click', '.apply_bulk_action', function(){
	jQuery('.top_loader').show();
	var bulk_action_type = jQuery('.submit_bulk_actions').val();
	var dialog_bulk_actions_details = {};
	var bulk_action_ids = jQuery('input:checkbox:checked.bulk_action_id').map(function () {
		return this.value;
	}).get();
		
	dialog_bulk_actions_details['bulk_action_ids'] = bulk_action_ids;
	dialog_bulk_actions_details['bulk_action_type'] = bulk_action_type;
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'dialog_bulk_actions',
			'dialog_bulk_actions_details' : dialog_bulk_actions_details
			
		},
		success: function (data) {
			jQuery('.top_loader').hide();
			var div = jQuery(data);
			var bulk_action_type = jQuery(div).find(".bulk_action_type").val();
			if(bulk_action_type == 'Delete'){
				jQuery('div.ui-dialog[aria-describedby=dialog_form_bulk_action_task] .ui-dialog-title').text("Delete Tasks");
				jQuery('#dialog_form_bulk_action_task .bulk_action_confirm').text('Delete');
			}else if(bulk_action_type == 'Edit Schedule'){
				jQuery('div.ui-dialog[aria-describedby=dialog_form_bulk_action_task] .ui-dialog-title').text("Edit Task Schedules");
				jQuery('#dialog_form_bulk_action_task .bulk_action_confirm').text('Edit');
			}else if(bulk_action_type == 'Pause'){
				jQuery('div.ui-dialog[aria-describedby=dialog_form_bulk_action_task] .ui-dialog-title').text("Pause Tasks");
				jQuery('#dialog_form_bulk_action_task .bulk_action_confirm').text('Pause');
			}
			
			jQuery('#dialog_form_bulk_action_task .confirm_bulk_action_details').html(data);
			
			if(bulk_action_type != '-- Bulk Actions --'){
				jQuery('#dialog_form_bulk_action_task').dialog('open');
			}
			trigger_start_date_daterpicker();
		},
		error: function (data) {
			alert('error');
		}				
	});	
});

jQuery(document).on('click', '#dialog_form_bulk_action_task .bulk_action_confirm', function(){
	jQuery('#dialog_form_bulk_action_task .loader').show();
	var apply_bulk_action_form = jQuery('#apply_bulk_action_form').serialize();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'apply_bulk_actions',
			'apply_bulk_action_form' : apply_bulk_action_form
			
		},
		success: function (data) {
			jQuery('#dialog_form_bulk_action_task .loader').hide();
			jQuery('#dialog_form_bulk_action_task').dialog('close');
			var parsed 						= jQuery.parseJSON(data);
			var bulk_action_type 			= parsed.bulk_action_type;			
			var submit_task_name 			= parsed.submit_task_name;
			var submit_task_name_suffix 	= parsed.submit_task_name_suffix;
			var submit_label 				= parsed.submit_label;
			var submit_responsible_person 	= parsed.submit_responsible_person;
			var submit_schedule_each 		= parsed.submit_schedule_each;
			var submit_starting_date 		= parsed.submit_starting_date;
			var estimated_hour 				= parsed.submit_time_estimate_hour;
			var estimated_minute 			= parsed.submit_time_estimate_minute;
			if(parsed.submit_task_name_suffix == ""){
				var task_name_suffix = submit_task_name;
			}else{
				var task_name_suffix = submit_task_name +' - '+ submit_task_name_suffix;
			}			
			
			if(estimated_hour != null && estimated_minute != null){
				var estimated_time = estimated_hour +' h'+ estimated_minute +' m';
			}else if(estimated_hour != null && estimated_minute == null){
				var estimated_time = estimated_hour +' h 0 m';
			}else if(estimated_hour == null && estimated_minute != null){
				var estimated_time = ' 0 h '+ estimated_minute +' m';
			}else if(estimated_hour == null && estimated_minute == null){
				var estimated_time = '0 h 0 m';
			}
			
			var bulk_action_ids = parsed.bulk_action_ids;
			var bulk_action_ids_split = bulk_action_ids.split(',');
			jQuery(bulk_action_ids_split).each(function(index, bulk_action_id){
				if(bulk_action_type == 'Delete'){
					jQuery('#column_cells_'+bulk_action_id).remove();
					jQuery('#column_cells_'+bulk_action_id).remove();
				}else if(bulk_action_type == 'Edit Schedule'){
					jQuery('#column_cells_'+bulk_action_id+ ' .fourth_column p').text(submit_schedule_each);
					jQuery('#column_cells_'+bulk_action_id+ ' .sixth_column p').text(submit_starting_date+ ' 01:01:00');
				}else if(bulk_action_type == 'Pause'){
					jQuery('#column_cells_'+bulk_action_id).remove();
					jQuery('.paused_task .submit_task_cells').append('<div id="column_cells_'+bulk_action_id+'" class="column_cells">'
					+'<div class="bulk_action_column column"><input type="checkbox" name="bulk_delete_id[]" class="bulk_action_id" value="'+bulk_action_id+'"></div>'
					+'<div class="first_column column"><p class="table_header">'+task_name_suffix+'</p></div>'
					+'<div class="second_column column"><p class="table_header">'+submit_label+'</p></div>'
					+'<div class="third_column column"><p class="table_header">'+submit_responsible_person+'</p></div>'
					+'<div class="fourth_column column"><p class="table_header">'+submit_schedule_each+'</p></div>'
					+'<div class="fifth_column column"><p class="table_header">'+estimated_time+'</p></div>'
					+'<div class="sixth_column column"><p class="table_header">--</p></div>'
					+'<div class="seventh_column column"><p class="table_header">Paused</p></div>'
					+'<div class="eighth_column column">'
					+'<div class="table_header">'
					+'<p id="edit_task_cron_'+bulk_action_id+'" class="edit_task_cron action_buttons button_2 display_button">E</p>'
					+'<p id="delete_task_cron_'+bulk_action_id+'" class="delete_task_cron confirm action_buttons button_2 display_button">D</p>'
					+'<p id="start_task_cron_'+bulk_action_id+'" class="start_task_cron action_buttons button_2 display_button">S</p>'
					+'</div>'
					+'</div>'
					);
				}
			});			
		},
		error: function (data) {
			alert('error');
		}				
	});	
});
/* ==================================== END BULK ACTIONS ==================================== */

/*  ==================================== SORT ==================================== */
/* DATE SORT ASC */
jQuery(document).on('click', '.date_sort_asc', function(){
	jQuery('.loader').show();
	var asc_date_array = {};		
	jQuery('.unsorted .sixth_column.schedule_date p').each(function(index, value){				
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(15, div_id.length);
		asc_date_array[index] = jQuery(this).text() +"_"+ data_id;
	});
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'sort_asc_submit_date_task',
			'asc_date_array' : asc_date_array
			
		},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);
			jQuery('.unsorted').hide();
			jQuery('.date_sort_asc').hide();
			jQuery('.desc_sorted').hide();
			jQuery('.date_sort_desc').show();
			jQuery('.loader').hide();
			jQuery.each( parsed, function( index, value ) {
				var sorted_data = value.split('_');	
				var sorted_date = sorted_data[0];
				var id = sorted_data[1];
				var submit_task_name = sorted_data[2];
				var submit_label = sorted_data[3];
				var submit_responsible_person = sorted_data[4];
				var submit_schedule_each = sorted_data[5];
				var submit_time_estimate_hour = sorted_data[6];
				var submit_cron_status = sorted_data[7];
				var submit_description = sorted_data[8];
				jQuery('.schedule_order').append("<div id='column_cells_"+id+"' class='column_cells asc_sorted'>"
				+"<div class='bulk_action_column column'><input type='checkbox' name='bulk_delete_id[]' class='bulk_delete' value="+id+"></div>"
				+"<div class='first_column column'><p class='table_header'>"+submit_task_name+"</p></div>"
				+"<div class='second_column column'><p class='client_info table_header'>"+submit_label+"</p></div>"
				+"<div class='third_column column'><p class='table_header'>"+submit_responsible_person+"</p></div>"
				+"<div class='fourth_column column'><p class='table_header'>"+submit_schedule_each+"</p></div>"
				+"<div class='fifth_column column'><p class='table_header'>"+submit_time_estimate_hour+"</p></div>"
				+"<div class='sixth_column column schedule_date'><p id='scheduled_date_"+id+"' class='table_header'>"+sorted_date+"</p></div>"
				+"<div class='seventh_column column'><p class='table_header'>"+submit_cron_status+"</p></div>"
				+"<div class='table_header'><p id='edit_task_cron_"+id+"' class='edit_task_cron action_buttons'>Edit</p>"
				+"<p id='delete_task_cron_"+id+"' class='delete_task_cron confirm action_buttons'>Delete</p>"
				+"<p id='pause_task_cron_"+id+"' class='pause_task_cron confirm action_buttons'>Pause</p>"
				+"</div>"
				+"</div>"
				);
				jQuery('submit_task_note_'+id).text(submit_description);					
			});
		},
		error: function (data) {
			alert('error');
		}				
	});
});
/* DATE SORT DESC */
jQuery(document).on('click', '.date_sort_desc', function(){
	jQuery('.loader').show();
	var desc_date_array = {};		
	jQuery('.unsorted .sixth_column.schedule_date p').each(function(index, value){				
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(15, div_id.length);
		desc_date_array[index] = jQuery(this).text() +"_"+ data_id;
	});
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'sort_desc_submit_date_task',
			'desc_date_array' : desc_date_array
			
		},
		success: function (data) {				
			var parsed = jQuery.parseJSON(data);
			jQuery('.asc_sorted').hide();
			jQuery('.desc_sorted').hide();
			jQuery('.date_sort_asc').show();
			jQuery('.date_sort_desc').hide();
			jQuery('.loader').hide();
			jQuery.each( parsed, function( index, value ) {
				var sorted_data = value.split('_');		
				var sorted_date = sorted_data[0];
				var id = sorted_data[1];
				var submit_task_name = sorted_data[2];
				var submit_label = sorted_data[3];
				var submit_responsible_person = sorted_data[4];
				var submit_schedule_each = sorted_data[5];
				var submit_time_estimate_hour = sorted_data[6];
				var submit_cron_status = sorted_data[7];
				var submit_description = sorted_data[8];
				jQuery('.schedule_order').append("<div id='column_cells_"+id+"' class='column_cells desc_sorted'>"
				+"<div class='bulk_action_column column'><input type='checkbox' name='bulk_delete_id[]' class='bulk_delete' value="+id+"></div>"
				+"<div class='first_column column'><p class='table_header'>"+submit_task_name+"</p></div>"
				+"<div class='second_column column'><p class='table_header'>"+submit_label+"</p></div>"
				+"<div class='third_column column'><p class='table_header'>"+submit_responsible_person+"</p></div>"
				+"<div class='fourth_column column'><p class='table_header'>"+submit_schedule_each+"</p></div>"
				+"<div class='fifth_column column'><p class='table_header'>"+submit_time_estimate_hour+"</p></div>"
				+"<div class='sixth_column column schedule_date'><p id='scheduled_date_"+id+"' class='table_header'>"+sorted_date+"</p></div>"
				+"<div class='seventh_column column'><p class='table_header'>"+submit_cron_status+"</p></div>"
				+"<div class='table_header'><p id='edit_task_cron_"+id+"' class='edit_task_cron action_buttons'>Edit</p>"
				+"<p id='delete_task_cron_"+id+"' class='delete_task_cron confirm action_buttons'>Delete</p>"
				+"<p id='pause_task_cron_"+id+"' class='pause_task_cron confirm action_buttons'>Pause</p>"
				+"</div>"
				+"</div>"
				);
				jQuery('submit_task_note_'+id).text(submit_description);					
			});
		},
		error: function (data) {
			alert('error');
		}				
	});
});
/* CLIENT SORT ASC */
jQuery(document).ready(function(){
	jQuery('.client_sort_asc').click(function(){
		jQuery('.loader').show();
		var asc_client_array = {};		
		jQuery('.unsorted .second_column.client_name p').each(function(index, value){			
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(12, div_id.length);
			var task_date = jQuery(".unsorted .sixth_column.schedule_date p#scheduled_date_"+data_id+"").text();
			asc_client_array[index] = jQuery(this).text() +"_"+ task_date +"_"+ data_id;
		});
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'sort_asc_submit_client_task',
				'asc_client_array' : asc_client_array
				
			},
			success: function (data) {				
				var parsed = jQuery.parseJSON(data);
				jQuery('.unsorted').hide();
				jQuery('.client_sort_asc').hide();
				jQuery('.desc_sorted').hide();
				jQuery('.client_sort_desc').show();				
				jQuery('.loader').hide();
				jQuery.each( parsed, function( index, value ) {
					var sorted_data = value.split('_');		
					var sorted_date = sorted_data[0];
					var id = sorted_data[1];
					var submit_task_name = sorted_data[2];
					var submit_label = sorted_data[3];
					var submit_responsible_person = sorted_data[4];
					var submit_schedule_each = sorted_data[5];
					var submit_time_estimate_hour = sorted_data[6];
					var submit_cron_status = sorted_data[7];
					var submit_description = sorted_data[8];
					jQuery('.schedule_order').append("<div id='column_cells_"+id+"' class='column_cells asc_sorted'>"
					+"<div class='bulk_action_column column'><input type='checkbox' name='bulk_delete_id[]' class='bulk_delete' value="+id+"></div>"
					+"<div class='first_column column'><p class='table_header'>"+submit_task_name+"</p></div>"
					+"<div class='second_column column'><p class='client_info table_header'>"+submit_label+"</p></div>"
					+"<div class='third_column column'><p class='table_header'>"+submit_responsible_person+"</p></div>"
					+"<div class='fourth_column column'><p class='table_header'>"+submit_schedule_each+"</p></div>"
					+"<div class='fifth_column column'><p class='table_header'>"+submit_time_estimate_hour+"</p></div>"
					+"<div class='sixth_column column schedule_date'><p id='scheduled_date_"+id+"' class='table_header'>"+sorted_date+"</p></div>"
					+"<div class='seventh_column column'><p class='table_header'>"+submit_cron_status+"</p></div>"
					+"<div class='table_header'><p id='edit_task_cron_"+id+"' class='edit_task_cron action_buttons'>Edit</p>"
					+"<p id='delete_task_cron_"+id+"' class='delete_task_cron confirm action_buttons'>Delete</p>"
					+"<p id='pause_task_cron_"+id+"' class='pause_task_cron confirm action_buttons'>Pause</p>"
					+"</div>"
					+"</div>"
					);
					jQuery('submit_task_note_'+id).text(submit_description);					
				});
			},
			error: function (data) {
				alert('error');
			}				
		});
	});
});
/* CLIENT SORT DESC */
jQuery(document).on('click', '.client_sort_desc', function(){
	jQuery('.loader').show();
	var desc_client_array = {};		
	jQuery('.unsorted .second_column.client_name p').each(function(index, value){			
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(12, div_id.length);
		var task_date = jQuery(".unsorted .sixth_column.schedule_date p#scheduled_date_"+data_id+"").text();
		desc_client_array[index] = jQuery(this).text() +"_"+ task_date +"_"+ data_id;
	});
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'sort_desc_submit_client_task',
			'desc_client_array' : desc_client_array
			
		},
		success: function (data) {				
			var parsed = jQuery.parseJSON(data);			
			jQuery('.loader').hide();				
			jQuery('.asc_sorted').hide();
			jQuery('.desc_sorted').hide();
			jQuery('.client_sort_asc').show();
			jQuery('.client_sort_desc').hide();
			jQuery.each( parsed, function( index, value ) {
				var sorted_data = value.split('_');		
				var sorted_date = sorted_data[0];
				var id = sorted_data[1];
				var submit_task_name = sorted_data[2];
				var submit_label = sorted_data[3];
				var submit_responsible_person = sorted_data[4];
				var submit_schedule_each = sorted_data[5];
				var submit_time_estimate_hour = sorted_data[6];
				var submit_cron_status = sorted_data[7];
				var submit_description = sorted_data[8];
				jQuery('.schedule_order').append("<div id='column_cells_"+id+"' class='column_cells desc_sorted'>"
				+"<div class='bulk_action_column column'><input type='checkbox' name='bulk_delete_id[]' class='bulk_delete' value="+id+"></div>"
				+"<div class='first_column column'><p class='table_header'>"+submit_task_name+"</p></div>"
				+"<div class='second_column column'><p class='table_header'>"+submit_label+"</p></div>"
				+"<div class='third_column column'><p class='table_header'>"+submit_responsible_person+"</p></div>"
				+"<div class='fourth_column column'><p class='table_header'>"+submit_schedule_each+"</p></div>"
				+"<div class='fifth_column column'><p class='table_header'>"+submit_time_estimate_hour+"</p></div>"
				+"<div class='sixth_column column schedule_date'><p id='scheduled_date_"+id+"' class='table_header'>"+sorted_date+"</p></div>"
				+"<div class='seventh_column column'><p class='table_header'>"+submit_cron_status+"</p></div>"
				+"<div class='table_header'><p id='edit_task_cron_"+id+"' class='edit_task_cron action_buttons'>Edit</p>"
				+"<p id='delete_task_cron_"+id+"' class='delete_task_cron confirm action_buttons'>Delete</p>"
				+"<p id='pause_task_cron_"+id+"' class='pause_task_cron confirm action_buttons'>Pause</p>"
				+"</div>"
				+"</div>"
				);
				jQuery('submit_task_note_'+id).text(submit_description);					
			});
		},
		error: function (data) {
			alert('error');
		}				
	});
});

/* TASK SORT ASC */
jQuery(document).ready(function(){
	jQuery('.task_sort_asc').click(function(){
		jQuery('.loader').show();
		var asc_task_array = {};		
		jQuery('.unsorted .first_column.task_name p').each(function(index, value){			
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(10, div_id.length);
			var task_date = jQuery(".unsorted .sixth_column.schedule_date p#scheduled_date_"+data_id+"").text();
			asc_task_array[index] = jQuery(this).text() +"_"+ task_date +"_"+ data_id;
		});
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'sort_asc_submit_task',
				'asc_task_array' : asc_task_array
				
			},
			success: function (data) {				
				var parsed = jQuery.parseJSON(data);
				jQuery('.unsorted').hide();
				jQuery('.task_sort_asc').hide();
				jQuery('.desc_sorted').hide();
				jQuery('.task_sort_desc').show();				
				jQuery('.loader').hide();
				jQuery.each( parsed, function( index, value ) {
					var sorted_data = value.split('_');		
					var sorted_date = sorted_data[0];
					var id = sorted_data[1];
					var submit_task_name = sorted_data[2];
					var submit_label = sorted_data[3];
					var submit_responsible_person = sorted_data[4];
					var submit_schedule_each = sorted_data[5];
					var submit_time_estimate_hour = sorted_data[6];
					var submit_cron_status = sorted_data[7];
					var submit_description = sorted_data[8];
					jQuery('.schedule_order').append("<div id='column_cells_"+id+"' class='column_cells asc_sorted'>"
					+"<div class='bulk_action_column column'><input type='checkbox' name='bulk_delete_id[]' class='bulk_delete' value="+id+"></div>"
					+"<div class='first_column column'><p class='table_header'>"+submit_task_name+"</p></div>"
					+"<div class='second_column column'><p class='client_info table_header'>"+submit_label+"</p></div>"
					+"<div class='third_column column'><p class='table_header'>"+submit_responsible_person+"</p></div>"
					+"<div class='fourth_column column'><p class='table_header'>"+submit_schedule_each+"</p></div>"
					+"<div class='fifth_column column'><p class='table_header'>"+submit_time_estimate_hour+"</p></div>"
					+"<div class='sixth_column column schedule_date'><p id='scheduled_date_"+id+"' class='table_header'>"+sorted_date+"</p></div>"
					+"<div class='seventh_column column'><p class='table_header'>"+submit_cron_status+"</p></div>"
					+"<div class='table_header'><p id='edit_task_cron_"+id+"' class='edit_task_cron action_buttons'>Edit</p>"
					+"<p id='delete_task_cron_"+id+"' class='delete_task_cron confirm action_buttons'>Delete</p>"
					+"<p id='pause_task_cron_"+id+"' class='pause_task_cron confirm action_buttons'>Pause</p>"
					+"</div>"
					+"</div>"
					);
					jQuery('submit_task_note_'+id).text(submit_description);					
				});
			},
			error: function (data) {
				alert('error');
			}				
		});
	});
});
/* TASK SORT DESC */
jQuery(document).on('click', '.task_sort_desc', function(){
	jQuery('.loader').show();
	var desc_task_array = {};		
	jQuery('.unsorted .first_column.task_name p').each(function(index, value){			
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(10, div_id.length);
		var task_date = jQuery(".unsorted .sixth_column.schedule_date p#scheduled_date_"+data_id+"").text();
		desc_task_array[index] = jQuery(this).text() +"_"+ task_date +"_"+ data_id;
	});
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'sort_desc_submit_task',
			'desc_task_array' : desc_task_array
			
		},
		success: function (data) {				
			var parsed = jQuery.parseJSON(data);			
			jQuery('.loader').hide();				
			jQuery('.asc_sorted').hide();
			jQuery('.desc_sorted').hide();
			jQuery('.task_sort_asc').show();
			jQuery('.task_sort_desc').hide();
			jQuery.each( parsed, function( index, value ) {
				var sorted_data = value.split('_');		
				var sorted_date = sorted_data[0];
				var id = sorted_data[1];
				var submit_task_name = sorted_data[2];
				var submit_label = sorted_data[3];
				var submit_responsible_person = sorted_data[4];
				var submit_schedule_each = sorted_data[5];
				var submit_time_estimate_hour = sorted_data[6];
				var submit_cron_status = sorted_data[7];
				var submit_description = sorted_data[8];
				jQuery('.schedule_order').append("<div id='column_cells_"+id+"' class='column_cells desc_sorted'>"
				+"<div class='bulk_action_column column'><input type='checkbox' name='bulk_delete_id[]' class='bulk_delete' value="+id+"></div>"
				+"<div class='first_column column'><p class='table_header'>"+submit_task_name+"</p></div>"
				+"<div class='second_column column'><p class='table_header'>"+submit_label+"</p></div>"
				+"<div class='third_column column'><p class='table_header'>"+submit_responsible_person+"</p></div>"
				+"<div class='fourth_column column'><p class='table_header'>"+submit_schedule_each+"</p></div>"
				+"<div class='fifth_column column'><p class='table_header'>"+submit_time_estimate_hour+"</p></div>"
				+"<div class='sixth_column column schedule_date'><p id='scheduled_date_"+id+"' class='table_header'>"+sorted_date+"</p></div>"
				+"<div class='seventh_column column'><p class='table_header'>"+submit_cron_status+"</p></div>"
				+"<div class='table_header'><p id='edit_task_cron_"+id+"' class='edit_task_cron action_buttons'>Edit</p>"
				+"<p id='delete_task_cron_"+id+"' class='delete_task_cron confirm action_buttons'>Delete</p>"
				+"<p id='pause_task_cron_"+id+"' class='pause_task_cron confirm action_buttons'>Pause</p>"
				+"</div>"
				+"</div>"
				);
				jQuery('submit_task_note_'+id).text(submit_description);					
			});
		},
		error: function (data) {
			alert('error');
		}				
	});
});
/* ==================================== END SORT ==================================== */
</script>