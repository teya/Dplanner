<?php
	$timezone = get_option('timezone_string'); 
	date_default_timezone_set($timezone); 
?>

<script>

var d = new Date();
var weekday = new Array(7);
weekday[0]=  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";
var day_now_id = weekday[d.getDay()].toLowerCase();

/* ==================================== IMPORT TASK ==================================== */

jQuery(document).on('click', '.import_kanban_task', function(){
	var div_id = jQuery(this).attr('id');		
	var div_id_split = div_id.split('_');
	var import_day = div_id_split[3];
	var current_hour = jQuery('#'+import_day+' .total_hours .task_total_hour h3').text();
	var day_not_current_capital = import_day.toLowerCase().replace(/\b[a-z]/g, function(letter) {
		return letter.toUpperCase();
	});		
	var import_date = jQuery('.' + import_day + '_date').val();
	var import_week = jQuery('.' + import_day + '_week').val();
	var date_hour_day_week = import_date +"_"+ current_hour +"_"+ import_day +"_"+ import_week;
	jQuery(".status_message").fadeIn( "slow", function() {
		jQuery(".status_message p").text("Importing data from Kanban. This will take some time. Please be patient.");
	});
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'import_task_kanban',
			'date_hour_day_week' : date_hour_day_week
		},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);			
			jQuery.each(parsed, function(index, value){
				var task_name = (value.task_name == "") ? "--" : value.task_name;
				var task_hour = (value.task_hour == "") ? "--" : value.task_hour;
				var task_project_name = (value.task_project_name == "") ? "--" : value.task_project_name;
				var task_color = (value.task_color == "") ? "--" : value.task_color;
				var task_label = (value.task_label == "") ? "--" : value.task_label;
				var person_full_name = (value.task_person == "") ? "--" : value.task_person;
				var import_date = (value.import_date == "") ? "--" : value.import_date;
				var import_day = (value.import_day == "") ? "--" : value.import_day;
				var import_week = (value.import_week == "") ? "--" : value.import_week;
				var user_id = (value.user_id == "") ? "--" : value.user_id;
				var task_description = (value.task_description == "") ? "--" : value.task_description;
				var short_description = jQuery.trim(task_description).substring(0, 24).split(" ").slice(0, -1).join(" ") + "...";
				if(index != 'total_hour'){						
					jQuery('#'+import_day+'.tab_content .task_name').append("<li class='data_list_"+index+" data_list_"+import_day+"'><p>"+task_name+"</p></li>");												
					jQuery('#'+import_day+'.tab_content .task_hour').append("<li class='data_list_"+index+" data_list_"+import_day+"'><p>"+task_hour+"</p></li>");
					jQuery('#'+import_day+'.tab_content .task_label').append("<li class='data_list_"+index+" data_list_"+import_day+"'><p>"+task_label+"</p></li>");
					jQuery('#'+import_day+'.tab_content .task_color').append("<li class='data_list_"+index+" data_list_"+import_day+"'><p>"+task_project_name+"</p></li>");
					jQuery('#'+import_day+'.tab_content .task_person').append("<li class='data_list_"+index+" data_list_"+import_day+"'><p>"+person_full_name+"</p></li>");
					jQuery('#'+import_day+'.tab_content .task_description').append("<div id='accordian_"+index+"' class='accordian'><h5 class='toggle'><a href='#'><li class='data_list_"+day_now_id+"'>"+short_description+"<span class='arrow'></span></li></a></h5></div>");						
					jQuery('#'+import_day+'.tab_content .task_description #accordian_'+index).append("<div class='toggle-content' style='display: none;'>"+task_description+"</div>");
					
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='import_date' value='"+import_date+"' />");
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='import_day' value='"+import_day+"' />");
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='import_week' value='"+import_week+"' />");
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='task_name[]' value='"+task_name+"' />");
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='task_hour[]' value='"+task_hour+"' />");												
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='task_label[]' value='"+task_label+"' />");
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='task_project_name[]' value='"+task_project_name+"' />");
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='task_color[]' value='"+task_color+"' />");
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='task_person[]' value='"+person_full_name+"' />");												
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='user_id[]' value='"+user_id+"' />");												
					jQuery('#'+import_day+'.tab_content .import_save').append('<input type="hidden" name="task_description[]" value="'+task_description+'" />');			
					jQuery('#'+import_day+'.tab_content .import_save').append("<input type='hidden' name='task_color[]' value='"+task_color+"' />");
					var total_hours_worked = jQuery('.month_details .total_hours_worked').text();
					var hour_balance = jQuery('.month_details .hour_balance').text();
					jQuery('.tab_content.active .import_save').append("<input type='hidden' name='total_hours_worked' value='"+total_hours_worked+"' />");
					jQuery('.tab_content.active .import_save').append("<input type='hidden' name='hour_balance' value='"+hour_balance+"' />");
				}				
				jQuery('.import_message').show();
				jQuery(".status_message").delay(500).fadeOut('slow');
			});	
			
			if(parsed.no_task){
				var empty_task_date = change_date_format(import_date,'full_date');
				jQuery('<p class="no_task text_red">No Hours Detected for '+empty_task_date+'<span>You can add task manually by clicking "Add Task" button.</span></p>').insertBefore('#'+import_day+' .total_hours');
				jQuery(".no_task").delay(7000).fadeOut('slow');
			}
			jQuery('#'+import_day+'.tab_content .total_hours .task_total_hour h3').text(parsed.total_hour);
			jQuery('.clear_add_buttons').show();
			jQuery('#save_kanban_'+import_day).show();
			jQuery('#clear_kanban_'+import_day).show();
			trigger_accordion_toggle();
		},
		error: function (data) {
			alert('error');
		}				
	});
});

/* ==================================== END IMPORT TASK ==================================== */



/* ==================================== SAVE IMPORT TASK ==================================== */

jQuery(document).ready(function(){

	var thetime = '<?php echo date('H:i:s') ;?>';
	var arr_time = thetime.split(':');
	var ss = arr_time[2];
	var mm = arr_time[1];
	var hh = arr_time[0];

	var update_ss = setInterval(updatetime, 1000);

	function updatetime() {
	    ss++;
	    if (ss < 10) {
	        ss = '0' + ss;
	    }
	    if (ss == 60) {
	        ss = '00';
	        mm++;
	        if (mm < 10) {
	            mm = '0' + mm;
	        }
	        if (mm == 60) {
	            mm = '00';
	            hh++;
	            if (hh < 10) {
	                hh = '0' + hh;
	            }
	            if (hh == 24) {
	                hh = '00';
	            }
	            jQuery("#dplan_hours").html(hh);
	        }
	        jQuery("#dplan_minutes").html(mm);
	    }
	    // $("#seconds").html(ss);
	}
});

/* ==================================== END SAVE IMPORT TASK ==================================== */



/* ==================================== DELETE TASK ==================================== */

jQuery(document).ready(function(){

	jQuery( "#dialog_form_timesheet_delete_task" ).dialog({

		autoOpen: false,

		height: 300,

		width: 350,

		modal: true,

		close: function() {

			jQuery('.loader').hide();

		}

	});	

});

jQuery(document).on('change', '.new_entry_taskname_1', function(){
	var this_element = jQuery(this);
	var taskname = this_element.find('option:selected').val();
	var clientname = jQuery('.tab_content.active .person_task_timesheet .new_entry_client_1 select').find('option:selected').text();

	if(clientname == '0 Digerati' && taskname == 'Tidbank'){
		jQuery('.tab_content.active .person_task_timesheet .task_color .new_entry_project_1 select').prop("selectedIndex", 5);
	}

	if(clientname ==  '0 Digerati'){
		if(taskname == 'Helg' || taskname == 'Sjuk' || taskname == 'Ledig' || taskname == 'Semester'){
			jQuery('.tab_content.active .person_task_timesheet .task_color .new_entry_project_1 select').prop("selectedIndex", 4);
		}		
	}else{
		if(taskname == 'Tid' || taskname == 'BQ' || taskname == 'SEOWeb' || taskname == 'Utbildning'){
			jQuery('.tab_content.active .person_task_timesheet .new_entry_button_1 .save_button_timesheet').hide();
			jQuery('.tab_content.active .person_task_timesheet .new_entry_button_1 .loader-save-entry').show();

			var client_id = jQuery('.tab_content.active .person_task_timesheet .new_entry_client_1 select').val();
			if(taskname == 'Tid'){
				jQuery.ajax({
					type: "POST",
					url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
					data:{
						'type' : 'get_client_default_project',
						'data_id' : client_id
					},
					success: function (data) {
						var parsed = jQuery.parseJSON(data);
						jQuery('.tab_content.active .person_task_timesheet .new_entry_button_1 .save_button_timesheet').show();
						jQuery('.tab_content.active .person_task_timesheet .new_entry_button_1 .loader-save-entry').hide();
						if(parsed.default_project == 'Löpande'){
							jQuery('.tab_content.active .person_task_timesheet .task_color .new_entry_project_1 select').prop("selectedIndex", 1);
						}else{
							console.log(clientname);
							if(clientname == '0 Digerati' || clientname == 'SEOWeb Solutions'){
								jQuery('.tab_content.active .person_task_timesheet .task_color .new_entry_project_1 select option').each(function() {
								  // if(jQuery(this).text() == theText) {
								  //   $(this).attr('selected', 'selected');            
								  // }  
								  console.log(jQuery(this).text());                      
								});
							}
						}
					},
					error: function (data) {
						alert('error');
					}				
				});	
			}else{

			}
		}
	}
});

jQuery(document).on('click', '.delete_edit_kanban', function(){

	var div_id = jQuery(this).attr('id');
	var div_id_split = div_id.split("_");
	var data_day = div_id_split[2];
	var data_id = div_id_split[3];
	var person_hours_per_day = jQuery('#person_hours_per_day').val();
	jQuery('.task-complete .timesheet_data_id_'+data_id+' .info_help').css('visibility', 'hidden');
	jQuery("#delete_loader_"+data_id).css('visibility', 'visible');
	var current_hour = jQuery('#'+data_day+'.tab_content .total_hours .task_total_hour h3').text();
	var total_hours_worked = jQuery('.month_details .total_hours_worked').text();
	var hour_balance = jQuery('.month_details .hour_balance').text();
	jQuery("#dialog_form_timesheet_delete_task #timesheet_task_id").val(data_id);
	jQuery("#dialog_form_timesheet_delete_task #timesheet_task_current_hour").val(current_hour);
	jQuery("#dialog_form_timesheet_delete_task #timesheet_task_total_hours_worked").val(total_hours_worked);
	jQuery("#dialog_form_timesheet_delete_task #timesheet_delete_day").val(data_day);
	jQuery("#dialog_form_timesheet_delete_task #timesheet_task_hour_balance").val(hour_balance);	
	var delete_form_details = jQuery('#timesheet_delete_task_form').serialize();

	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'confirm_delete_task',
			'delete_form_details' : delete_form_details
		},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);
			var task_hour = parsed[0].task_hour;
			var task_id = parsed[0].task_id;				
			var timesheet_delete_day = parsed.timesheet_delete_day;		
	
			//Side Panel Info Update
			jQuery('.month_details .worked_hours').text(parsed.side_panel_total_workable_hours);
			jQuery('.month_details .hour_balance').text(parsed.side_panel_total_hour_balance);
			jQuery('.month_details .total_hours_worked').text(parsed.side_panel_total_worked_hours);
			jQuery('.month_details .hour_vacation').text(parsed.side_panel_total_semester);
			jQuery('.month_details .hour_ledig').text(parsed.side_panel_total_ledig);
			jQuery('.month_details .hour_sjuk').text(parsed.side_panel_total_sjuk);
			jQuery('.month_details .hour_tidbank').text(parsed.side_panel_total_hours_tidbank);
			jQuery('.header_person_name .total_dwork').text(parsed.dwork_percent);
			if(parsed.side_panel_total_hour_balance_color == 'green'){
				jQuery('.month_details .hour_balance ').removeClass('text_red').addClass('text_green');
			}else{
				jQuery('.month_details .hour_balance ').removeClass('text_green').addClass('text_red');
			}
			if(parsed.side_panel_tid_bank_class == 'red_text'){
				jQuery('.month_details .hour_tidbank').addClass('text_red');
			}else{
				jQuery('.month_details .hour_tidbank').removeClass('text_red');
			}	
			jQuery('#'+timesheet_delete_day+' .total_hours .task_total_hour h3').html(parsed.total_current_day_worked_hrs);
			jQuery("#loader_id_"+task_id).hide();
			jQuery('#'+timesheet_delete_day+' .timesheet_data_id_'+task_id).hide();
			jQuery('#'+timesheet_delete_day+' .task_description .accordian_'+task_id).hide();
			jQuery("#delete_loader_"+div_id).hide();
			jQuery('.action_message p').text("Task Deleted");
			jQuery('.action_message').fadeIn( "slow", function() {
				jQuery(".action_message").delay(1000).fadeOut('slow');
			});
			if(8 <= parsed.total_current_day_worked_hrs_dec){
				
			}else{
				jQuery('#tabs .tabs_li.active a').removeClass('green-day').addClass('red-day');
			}
		},
		error: function (data) {
			alert('error');
		}				
	});		
});
/* ==================================== END DELETE TASK ==================================== */



/* ==================================== EDIT TASK ==================================== */

jQuery(document).ready(function(){
	jQuery( "#dialog_form_timesheet_edit_task" ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		close: function() {
		}
	});
});


jQuery(document).on('click', '.edit_kanban', function(){

	var div_id = jQuery(this).attr('id');
	var div_id_split = div_id.split("_");
	var data_day = div_id_split[2];
	var data_div_id = div_id_split[3];	
	var current_task_hour = jQuery('#'+data_day+' .task_hour .timesheet_data_id_'+data_div_id).text();
	var data_id = data_div_id+"_"+current_task_hour;
	jQuery('#loader_id_'+data_div_id).show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'task_edit_timesheet_task',
			'data_id' : data_id
		},
		success: function (data) {
			jQuery('#loader_id_'+data_div_id).hide();
			jQuery('#dialog_form_timesheet_edit_task').dialog('open');
			jQuery('#dialog_form_timesheet_edit_task').html(data);
		},
		error: function (data) {
			alert('error');
		}				
	});
});

/* ==================================== END EDIT TASK ==================================== */



/* ==================================== UPDATE TASK ==================================== */

jQuery(document).on('click', '.update_button', function(){
	jQuery('.update_timesheet .loader').show();
	var current_total_hour = jQuery('.tab_content.active .total_hours .task_total_hour h3').text();
	var total_hours_worked = jQuery('.month_details .total_hours_worked').text();
	var hour_balance = jQuery('.month_details .hour_balance').text();
	var update_timesheet_task_data = jQuery('#update_timesheet').serialize() + "&current_total_hour=" + current_total_hour + "&total_hours_worked=" + total_hours_worked + "&hour_balance=" + hour_balance;
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'task_update_timesheet',
			'update_timesheet_task_data' : update_timesheet_task_data
		},
		success: function (data) {
			jQuery('.update_timesheet .loader').hide();
			var parsed = jQuery.parseJSON(data);
			jQuery(".action_message p").text("Task Updated");
				jQuery(".action_message").fadeIn( "slow", function() {
				jQuery(".action_message").delay(1000).fadeOut('slow');
			});
			var task_id = parsed.id;
			var task_name = parsed.task_name;
			var task_suffix = parsed.task_suffix;
			var task_hour = parsed.task_hour;
			
			if(task_suffix == ""){
				var task_name_suffix = task_name;
				}else{
				var task_name_suffix = task_name +' - '+ task_suffix;
			}
			var task_name_suffix_count = task_name_suffix.length;
			if(task_name_suffix_count <= 25){
				var task_name = task_name_suffix;
				}else{
				var task_name = jQuery.trim(task_name_suffix).substring(0, 24).split(" ").slice(0, -1).join(" ") + "...";
			}
										
			var task_description = parsed.task_description;
			var short_description = jQuery.trim(task_description).substring(0, 24).split(" ").slice(0, -1).join(" ") + "...";
			console.log('UPDATE TIME');
			jQuery('.task_name .timesheet_data_id_'+task_id).text(task_name);
			jQuery('.task_hour .timesheet_data_id_'+task_id).text(task_hour);
			jQuery('info_div.same_user .timesheet_data_id_'+task_id+ '.second_column').text(task_hour);
			jQuery('.task_total_hour h3').text(parsed.total_task_hour);
			jQuery('.month_details .total_hours_worked').text(parsed.total_hours_worked);
			jQuery('.month_details .hour_balance').text(parsed.hour_balance);
			var toggle = jQuery('.accordian_'+task_id+' .timesheet_data_id_'+task_id).find('span');
			jQuery('.accordian_'+task_id+' .timesheet_data_id_'+task_id).text(short_description);
			jQuery('.accordian_'+task_id+' .timesheet_data_id_'+task_id).append(toggle);
			jQuery('.accordian_'+task_id+' .toggle-content').text(task_description);
			jQuery( "#dialog_form_timesheet_edit_task" ).dialog('close');
		},
		error: function (data) {
			alert('error');
		}
	});
});

/* ==================================== END UPDATE TASK ==================================== */



/* ==================================== DONE TODAY TASK ==================================== */

//Show Edited By record dialog 
jQuery(document).ready(function(){
	jQuery(document).on("mouseenter", ".info_help" , function() {
		var id = jQuery(this).attr('id').split('_')[2];
		jQuery('#edited_note_id_'+id).toggle("small");
	});
	jQuery(document).on("mouseleave", ".info_help" , function() {
		var id = jQuery(this).attr('id').split('_')[2];
        jQuery('#edited_note_id_'+id).toggle("close");
	});
});



jQuery(document).on('click', '.done_today_button', function(){
	jQuery('.timesheet_loader').show();
	var div_id = jQuery(this).attr('id');
	var div_id_split = div_id.split('_');
	var data_id = div_id_split[4];	
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'done_today_edit',
			'data_id' : data_id
		},
		success: function (data) {
			jQuery('.timesheet_loader').hide();
			jQuery( "#dialog_form_timesheet_done_today" ).dialog('open');
			jQuery( "#dialog_form_timesheet_done_today" ).html(data);
		},
		error: function (data) {
			alert('error');
		}
	});
});



var div_id_last = jQuery('.done_today_last').attr('id');	
if(div_id_last != null && div_id_last != 'undefined'){
	var div_id_last_split = div_id_last.split('_');
	var last_counter = div_id_last_split[2];	
	var counter = parseInt(last_counter, 10) + 1;
}else{
	var counter = 1;
}	

jQuery(document).on('click', '.add_more_done_today', function(){
	var task_hour = jQuery().text();
	var task_done_today_description = jQuery('textarea.task_done_today_description').val();
	var task_done_today_hours = jQuery('textarea.task_done_today_hours').val();	
	jQuery('.done_today_task_container').append('<li class="done_today_list" id="done_today_'+counter+'">'
	+'<div class="full_width">'		
	+'<input type="hidden" id="hidden_list_'+counter+'" name="submit_done_today[]" value="'+task_done_today_description+'_'+task_done_today_hours+'"/>'		
	+'<div class="one_half"><p class="task_done_today_description">'+task_done_today_description+'</p></div>'
	+'<div class="one_fourth"><p class="task_done_today_hours">'+task_done_today_hours+'</p></div>'		
	+'<div class="one_fourth last">'		
	+'<div id="done_today_edit_'+counter+'" class="done_today_edit button_2 done_today_action_button">E</div>'
	+'<div id="done_today_delete_'+counter+'" class="confirm done_today_delete button_2 done_today_action_button">D</div>'
	+'</div>'
	+'</div>'
	+'</li>'
	+'<div class="edit_div" id="edit_div_'+counter+'" style="display:none;">'
	+'<div class="full_width">'		
	+'<div class="one_half"><textarea type="text" id="done_today_description_edit_area_'+counter+'" class="done_today_edit_area" /></textarea></div>'
	+'<div class="one_fourth"><textarea type="text" id="done_today_task_hour_edit_area_'+counter+'" class="done_today_edit_area" /></textarea></div>'		
	+'<div class="one_fourth last">'
	+'<div id="check_edit_'+counter+'" class="check_edit"></div>'
	+'</div>'
	+'</div>'
	+'</div>'
	);
	jQuery(".task_done_today_description").val("");
	jQuery(".task_done_today_hours").val("");
	counter++;
});	

jQuery(document).on('click', '.add_task_done_today', function(){
	jQuery('#done_today_form .loader').show();
	var done_today_form = jQuery('#done_today_form').serialize();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'task_done_today_save',
			'done_today_form' : done_today_form
		},
		success: function (data) {
			jQuery('#done_today_form .loader').hide();
			jQuery( "#dialog_form_timesheet_done_today" ).dialog('close');
		},
		error: function (data) {
			alert('error');
		}
	});
});

/* DONE TODAY ACTIONS */
jQuery(document).on('click', '.done_today_edit', function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[3];
		var edit_task_done_today_description = jQuery('#done_today_'+data_id+' p.task_done_today_description').text();
		var edit_task_done_today_hours = jQuery('#done_today_'+data_id+' p.task_done_today_hours').text();
		jQuery('#done_today_'+data_id).hide();
		jQuery('#edit_div_'+data_id).css('display', 'block');
		jQuery('#done_today_description_edit_area_'+data_id).text(edit_task_done_today_description);
		jQuery('#done_today_task_hour_edit_area_'+data_id).text(edit_task_done_today_hours);
});

jQuery(document).on('click', '.check_edit', function(){
	var div_id = jQuery(this).attr('id');
	var div_id_split = div_id.split('_');
	var data_id = div_id_split[2];	
	var edit_task_done_today_description = jQuery('#done_today_description_edit_area_'+data_id).val();
	var edit_task_done_today_hours = jQuery('#done_today_task_hour_edit_area_'+data_id).val();
	jQuery('#edit_div_'+data_id).css('display', 'none');
	jQuery('#done_today_'+data_id).show();
	jQuery('#done_today_'+data_id+' p.task_done_today_description').text(edit_task_done_today_description);
	jQuery('#done_today_'+data_id+' p.task_done_today_hours').text(edit_task_done_today_hours);			
	jQuery('#hidden_list_'+data_id).val(edit_task_done_today_description +"_"+ edit_task_done_today_hours);
});		



jQuery(document).on('click', '.done_today_delete', function(){
	var div_id = jQuery(this).attr('id');
	var div_id_split = div_id.split('_');
	var data_id = div_id_split[3];	
	jQuery('#done_today_'+data_id).remove();
	jQuery('#edit_div_'+data_id).remove();
});

/* END DONE TODAY ACTIONS */

/* ==================================== END DONE TODAY TASK ==================================== */



/* ==================================== CLEAR TASK ==================================== */

jQuery(document).ready(function(){
	jQuery('#clear_kanban_'+day_now_id).click(function(){
		jQuery('#'+day_now_id+' form.import_save').contents().remove();
		jQuery('#'+day_now_id+' .data_list_'+day_now_id).remove();
		jQuery('#'+day_now_id+' .task_description .accordian').remove();
		jQuery('#'+day_now_id+' .task_total_hour h3').html("00:00");
		jQuery('#'+day_now_id+' .clear_add_buttons').hide();
		jQuery('#'+day_now_id+' .import_message').hide();
	});
});

/* ==================================== END CLEAR TASK ==================================== */


/* ==================================== ADD ENTRY TASK ==================================== */

jQuery(document).ready(function(){
	jQuery( "#dialog_form_timesheet_add_kanban_task" ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		close: function() {
		}
	});
});

jQuery(document).on('click', '.add_task', function(){
	var div_id = jQuery(this).attr('id');		
	var div_id_split = div_id.split('_');
	var add_day = div_id_split[3];
	var current_hour = jQuery('#'+add_day+' .total_hours .task_total_hour h3').text();
	var day_not_current_capital = add_day.toLowerCase().replace(/\b[a-z]/g, function(letter) {
		return letter.toUpperCase();
	});
	var add_date = jQuery('.' + add_day + '_date').val();
	var date_format = change_date_format(add_date, "dd/M");
	var add_week = jQuery('#week_number').val();
	var day_date_week = add_day +"_"+ add_date +"_"+ add_week +"_"+ current_hour;
	jQuery(".top_loader").show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'timesheet_add_task',
			'day_date_week' : day_date_week
		},
		success: function (data) {
			jQuery(".top_loader").hide();			
			var check_modal_title = jQuery('div[aria-describedby^="dialog_form_timesheet_add_kanban_task"] div.modal_header p.modal_date').length;
			if(check_modal_title == 0){
				jQuery('div[aria-describedby^="dialog_form_timesheet_add_kanban_task"] .ui-widget-header').append('<div class="modal_header"><p class="modal_title">New Time Entry</p><p class="modal_date">'+day_not_current_capital +", "+ date_format+'</p></div>');
			}else{
				jQuery('div[aria-describedby^="dialog_form_timesheet_add_kanban_task"] div.modal_header p.modal_date').text(day_not_current_capital +", "+ date_format);
			}
			jQuery("#dialog_form_timesheet_add_kanban_task").html(data);
			jQuery('#dialog_form_timesheet_add_kanban_task').dialog('open');
		},
		error: function (data) {
			alert('error');
		}				
	});
});

/* ==================================== END ADD ENTRY TASK ==================================== */



/* ====================================  ADD FILTER PROJECT TASK ==================================== */

//DROPDOWN SELECT CLIENT NAME

jQuery(document).on('change', '.tab_content.active .new_entry_client_1 select', function(){
	var this_element = jQuery(this);
	var project_select_input = this_element.closest('.person_task_timesheet').find('.new_entry_project_1 select');
	var task_select_input = this_element.closest('.person_task_timesheet').find('.new_entry_taskname_1 select');
	project_select_input.prop('disabled', 'disabled');
	task_select_input.prop('disabled', 'disabled');
	var client_id = this_element.val();
	jQuery('.tab_content.active').find('.save_button_timesheet').hide();
	jQuery('.tab_content.active').find('.loader-save-entry').show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'filter_project_client',
			'client_id' : client_id
		},
		success: function (data) {
			jQuery('.project_name_loader').hide();
			var parsed = jQuery.parseJSON(data);
			var client_name = parsed.client_name;
			var project_name = parsed.project_name;
			var check_project = parsed.check_project;
			var client_id = parsed.client_id;
			var tasks = parsed.tasks;
			var project = parsed.projects;
			jQuery('.tab_content.active .new_entry_project_1 select').empty();
			jQuery('.tab_content.active .new_entry_taskname_1 select').empty();
			if(check_project == 'not_null'){
				jQuery('.tab_content.active .new_entry_project_1 select').html(project);
				jQuery('.tab_content.active .new_entry_taskname_1 select').html(tasks);
			}else{
				jQuery('#add_project_client_confirm  h3.add_project_client_title').html('Add project to client: ' +client_name+ '?');
				jQuery('#add_project_client_confirm #add_project_client_form .client_name').val(client_name);
				jQuery('#add_project_client_confirm #add_project_client_form .client_id').val(project_name);
				jQuery('#add_project_client_confirm #add_project_client_form .project_name').val(client_id);
				jQuery('#add_project_client_confirm').dialog('open');
			}
			jQuery('.tab_content.active').find('.save_button_timesheet').show();
			jQuery('.tab_content.active').find('.loader-save-entry').hide();
			project_select_input.prop('disabled', false);
			task_select_input.prop('disabled', false);
		},
		error: function (data) {
			alert('error');
		}
	});
});

// ADD PROJECT NAME
jQuery(document).on('click', '#add_project_client_confirm .add_project_buttons .add_project_client' , function(){
	jQuery('#add_project_client_confirm .loader').show();
	var client_name = jQuery('#add_project_client_confirm #add_project_client_form .client_name').val();
	var project_name = jQuery('#add_project_client_confirm #add_project_client_form .project_name').val();
	var client_id = jQuery('#add_project_client_confirm #add_project_client_form .client_id').val();
	var add_project_details = project_name +'_'+ client_name  +'_'+  client_id;
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'add_project_details' : add_project_details,
			'type' : 'add_client_project'
		},
		success: function (data) {			
			jQuery('#add_project_client_confirm .loader').hide();
			jQuery('#add_project_client_confirm').dialog('close');
			jQuery('#dialog_form_add_project_client').dialog('open');
			jQuery("#dialog_form_add_project_client").html(data);
			jQuery('.project_start_date').datepicker();
			jQuery('.project_estimated_deadline').datepicker();
		},
		error: function (data) {
			alert('error');
		}				
	});
});

jQuery(document).on('change', '#submit_project_client .project_name', function(){
	var value = jQuery(this).val();
	if(value == 'Other'){		
		jQuery('#submit_project_client .add_peoject_name_section').slideDown();
	}else{
		jQuery('#submit_project_client .add_peoject_name_section').slideUp();
	}
});


jQuery(document).on('click', '#submit_project_client .add_project_option', function(){
	var value = jQuery('#submit_project_client .add_project_name').val();
	jQuery('#submit_project_client .project_name').prepend('<option selected="selected">'+value+'</option>').prop('selected', true);
	jQuery('#submit_project_client .add_peoject_name_section').slideUp();
});


//Adding new project on client when no available project for cleint.
jQuery(document).on('click', '#submit_project_client .save_project_client', function(){
	jQuery('#submit_project_client .loader').show();
	var save_project_client = jQuery('#submit_project_client').serialize();
		jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
		'save_project_client' : save_project_client,
		'type' : 'save_client_project'
		},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);
			var status = parsed.status;
			var project_name = parsed.project_name;
			var tasks = parsed.tasks;
			jQuery('#submit_project_client .loader').hide();
			
			if(status == 1){
				jQuery('#dialog_form_add_project_client').dialog('close');
				jQuery('.tab_content.active .task_color .new_entry_project_1 select').prepend('<option selected="selected">'+project_name+'</option>').prop('selected', true);
				jQuery('.tab_content.active .task_name .new_entry_taskname_1 select').prepend(tasks);
			}else{
				jQuery("<div class='status_message'><p>ERROR: Project was not saved</p></div>").fadeIn( "slow", function() {
				jQuery(".status_message").delay(2000).fadeOut('slow');
			});
			}
		},
		error: function (data) {
			alert('error');
		}				
	});
});

/* ====================================  END ADD FILTER PROJECT TASK ==================================== */



/* ==================================== SAVE ADD ENTRY TASK ==================================== */

jQuery(document).on('click', '.save_add_button', function(){
	var save_add_timesheet_task_data = jQuery('#add_task_timesheet').serialize();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'task_save_add_timesheet',
			'save_add_timesheet_task_data' : save_add_timesheet_task_data
		},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);
			jQuery('#dialog_form_timesheet_add_kanban_task').dialog('close');
			jQuery(".action_message p").text("Task Added");
			jQuery(".action_message").fadeIn( "slow", function() {
				jQuery(".action_message").delay(1000).fadeOut('slow');
			});
			
			var task_name 			= (parsed.task_name == "") ? "--" : parsed.task_name;
			var total_hour 			= (parsed.total_hour == "") ? "--" : parsed.total_hour;
			var task_hour_format 	= (parsed.task_hour_format == "") ? "--" : parsed.task_hour_format;
			var task_hour_billable_format 	= (parsed.task_hour_billable_format == "") ? "--" : parsed.task_hour_billable_format;
			var task_label 			= (parsed.task_label == "") ? "--" : parsed.task_label;
			var task_project_name 	= (parsed.task_project_name == "") ? "--" : parsed.task_project_name;
			var task_person 		= (parsed.task_person == "") ? "--" : parsed.task_person;
			var task_description 	= (parsed.task_description == "") ? "--" : parsed.task_description;
			var description_length 	= task_description.length;
			if(description_length >= 20){
				var short_description = jQuery.trim(task_description).substring(0, 24).split(" ").slice(0, -1).join(" ") + "...";
			}else{
				var short_description = task_description +"...";
			}
			
							
			jQuery('.tab_content.active .task_name').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_name+'</li>');
			jQuery('.tab_content.active .task_hour').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_hour_format+'</li>');
			jQuery('.tab_content.active .task_hour_billable').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_hour_billable_format+'</li>');
			jQuery('.tab_content.active .task_label').append('<li class="client_info data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_label+'</li>');
			jQuery('.tab_content.active .task_color').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_project_name+'</li>');
			jQuery('.tab_content.active .task_person').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_person+'</li>');
			jQuery('.tab_content.active .task_description').append('<div class="accordian accordian_'+parsed.id+'"><h5 class="toggle"><a href="#"><li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+short_description+'<span class="arrow"></span></li></a></h5></div>');						
			jQuery('.tab_content.active .task_description .accordian_'+parsed.id).append("<div class='toggle-content' style='display: none;'>"+task_description+"</div>");
			jQuery('.tab_content.active .task_delete').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'"><div id="delete_kanban_'+day_now_id+'_'+parsed.id+'" class="button_1 confirm delete_button delete_kanban_'+day_now_id+'">Delete</div></li>');			
			jQuery('.tab_content.active .task_edit').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'"><div id="edit_kanban_'+day_now_id+'_'+parsed.id+'" class="button_1 edit_button edit_kanban">E</div></li>');			
			jQuery('.tab_content.active .task_edit').append("<div id='loader_id_"+parsed.id+"' style='display: none;' class='loader timesheet_loader'></div>");
			jQuery('.tab_content.active .task_done_today').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'"><div id="done_today_kanban_'+day_now_id+'_'+parsed.id+'" class="button_1 done_today_button done_today_kanban_'+day_now_id+' done_today_not_current">Done Today</div></li>');
			jQuery('.tab_content.active .total_hours .task_total_hour h3').text(total_hour);
			trigger_accordion_toggle();
		},
		error: function (data) {
			alert('error');
		}
	});
});

/* ==================================== END SAVE ADD ENTRY TASK ==================================== */


//Change Data List when clicking the Calendar or selecting a specific day.
function day_sort(value, day, check_same_user){

	// if(value.task_suffix == ""){

	// 	var task_name_suffix = format_task_name(value.task_name);

	// }else{

	// 	var task_name_suffix = format_task_name(value.task_name) +' - '+ value.task_suffix;

	// }

	// var task_name_suffix_count = task_name_suffix.length;							

	// if(task_name_suffix_count <= 25){

	// 	var task_name = task_name_suffix;

	// }else{

	// 	var task_name = jQuery.trim(task_name_suffix).substring(0, 25).split(" ").slice(0, -1).join(" ") + "...";

	// }



	var task_description = (value.task_description == "") ? "--" : value.task_description;

	var task_description_count = task_description.length;

	var task_hour = (value.task_hour == "") ? "--" : value.task_hour;

	var task_label = (value.task_label == "") ? "--" : value.task_label;

	var task_project_name = (value.task_project_name == "") ? "--" : value.task_project_name;

	var task_person = (value.task_person == "") ? "--" : value.task_person;

	var ordernumber = (value.orderno == "" || value.orderno == undefined) ? "--" : value.orderno;

	var kilometer = (value.km == "" || value.km == undefined) ? "--" : value.km;

	if(day == 'saturday'){
		if(parseInt(task_hour) > 0){
			jQuery('.saturday.tabs_li a').addClass('yellow-day');	
		}
	}
	if(day == 'sunday'){
		if(parseInt(task_hour) > 0){
			jQuery('.sunday.tabs_li a').addClass('yellow-day');	
		}
	}
	if(task_description_count <= 24){

		var short_description = task_description;

	}else{

		var short_description = jQuery.trim(task_description).substring(0, 34).split(" ").slice(0, -1).join(" ") + "...";

	}

	

	// jQuery('#'+day+' .task_name').append('<li class="data_list_'+day+' timesheet_data_id_'+value.ID+'">'+task_name+'</li>');

	// jQuery('#'+day+' .task_hour').append('<li class="client_info  data_list_'+day+' timesheet_data_id_'+value.ID+'">'+task_hour+'</li>');

	// jQuery('#'+day+' .task_label').append('<li class="client_info  data_list_'+day+' timesheet_data_id_'+value.ID+'">'+task_label+'</li>');

	// jQuery('#'+day+' .task_color').append('<li class="data_list_'+day+' timesheet_data_id_'+value.ID+'">'+task_project_name+'</li>');

	// jQuery('#'+day+' .task_person').append('<li class="data_list_'+day+' timesheet_data_id_'+value.ID+'">'+task_person+'</li>');

	// jQuery('#'+day+' .task_description').append('<div class="accordian accordian_'+value.ID+'"><h5 class="toggle"><a href="#"><li class="data_list_'+day+' timesheet_data_id_'+value.ID+'">'+short_description+'<span class="arrow"></span></li></a></h5><div class="toggle-content" style="display: none;">'+task_description+'</div></div>');


	//Taskname
	jQuery('<li id="taskname_id_'+value.ID+'" class="data_list_'+day+' edit_taskname_record timesheet_data_id_'+value.ID+'">'+value.task_name+'<div id="taskname_loader_'+value.ID+'" class="row-update-loader-taskname" style="display: none;</li>">').insertBefore('#'+day+' .task_name li:last');
	//Hour
	jQuery('<li  id="timesheet_hour_id_'+value.ID+'" class="data_list_'+day+' timesheet_data_id_'+value.ID+' edit_column_field">'+task_hour+'</li>').insertBefore('#'+day+' .task_hour li:last');
	//Client Name
	jQuery('<li id="client_list_'+value.ID+'" class="client_info  data_list_'+day+' timesheet_data_id_'+value.ID+'">'+task_label+'</li>').insertBefore('#'+day+' .task_label li:last');
	//Project
	jQuery('<li id="project_id_'+value.ID+'" class="data_list_'+day+' edit_project_record timesheet_data_id_'+value.ID+'">'+task_project_name+'<div id="project_loader_'+value.ID+'" class="row-update-loader-project" style="display: none;"></li>').insertBefore('#'+day+' .task_color li:last');

	jQuery('<li class="data_list_'+day+' timesheet_data_id_'+value.ID+'">'+task_person+'</li>').insertBefore('#'+day+' .task_person li:last');

	//Description
	jQuery('<div class="accordian accordian_'+value.ID+'"><h5 class="toggle"><div class="desc edit_column_field" id="toggle_description_id_'+value.ID+'"><li class="data_list_'+day+' timesheet_data_id_'+value.ID+' description_data_id_'+value.ID+'">'+short_description+'<span class="arrow"></span></li></div></h5><div id="timesheet_description_id_'+value.ID+'" class="toggle-content edit_column_field" style="display: none;">'+task_description+'</div></div>').insertBefore('#'+day+' .task_description div.accordian_input');

	//Order Number
	jQuery('<li id="timesheet_orderno_id_'+value.ID+'" class="data_list_'+day+' edit_column_field timesheet_data_id_'+value.ID+'">'+ordernumber+'</li>').insertBefore('#'+day+' .ordernumber li:last');

	//Kilometer
	jQuery('<li id="timesheet_kilometer_id_'+value.ID+'" class="data_list_'+day+' edit_column_field timesheet_data_id_'+value.ID+'">'+kilometer+'</li>').insertBefore('#'+day+' .kilometer li:last');


		var lastFive = value.edited_by.substr(value.edited_by.length - 5); // => "Tabs1"
		var edited_time = tConv24(lastFive);


		jQuery('<li class="data_list_'+day+' timesheet_data_id_'+value.ID+'"><div id="edit_kanban_'+day+'_'+value.ID+'" class="button_1 edit_button edit_kanban hide-element">E</div></li>').insertBefore('#'+day+' .task_edit li:last');
		
		if(value.edited_by != null && value.edited_by != ''){
			jQuery('<li class="data_list_'+day+' timesheet_data_id_'+value.ID+'"><div style="visibility: hidden;" class="row-delete-loader" id="delete_loader_'+value.ID+'"></div><div class="info_help" id="edited_data_'+value.ID+'"></div><p class="edit_note" style="display: none;" id="edited_note_id_'+value.ID+'">Edited By: '+value.edited_by.slice(0,-1)+" "+edited_time+' </p></li>').insertBefore('#'+day+' .task-complete li:last');
		}else{
			jQuery('<li class="data_list_'+day+' timesheet_data_id_'+value.ID+'"><div style="visibility: hidden;" class="row-delete-loader" id="delete_loader_'+value.ID+'"></div></li>').insertBefore('#'+day+' .task-complete li:last');
		}
		jQuery('<li class="data_list_'+day+' timesheet_data_id_'+value.ID+'"><div id="delete_kanban_'+day+'_'+value.ID+'" class="button_1 delete_button delete_edit_kanban">-</div></li>').insertBefore('#'+day+' .task_delete li:last');
		jQuery('<li class="data_list_'+day+' timesheet_data_id_'+value.ID+'" style="display: none;"><div id="done_today_kanban_'+day+'_'+value.ID+'" class="button_1 done_today_button done_today_kanban">Done Today</div></li>').insertBefore('#'+day+' .task_done_today li:last');

}

/* ==================================== SEARCH PERSON TASK BY NAME ==================================== */

jQuery(document).ready(function(){

	jQuery('form.staff_timesheet_form .person_name').change(function() {

		jQuery('.timesheet .left_div .loader').show();

		var todolist_table = jQuery('#manange-client-table');
		todolist_table.fadeOut(300);
		todolist_table.find('tbody').html('').html('<tr><td colspan="6"><div class="loading-table"></div></td></tr>');

		var current_tab_date = jQuery('.tab_content.active .tab_date').val();

		var date = change_date_format(current_tab_date, 'yyyy-month-dd');

		var start_date = new Date(date);

		var end_date = new Date(date);

		var index = start_date.getDay();

		if(index == 0) {

			start_date.setDate(start_date.getDate() - 6);   

			end_date.setDate(end_date.getDate() + 1);

        }else if(index == 1) {

			start_date.setDate(start_date.getDate());

			end_date.setDate(end_date.getDate() + 7);               

        }else if(index == 2) {

			start_date.setDate(start_date.getDate() - 1);

			end_date.setDate(end_date.getDate() + 6); 

		}else if(index == 3) {

			start_date.setDate(start_date.getDate() - 2);

			end_date.setDate(end_date.getDate() + 5); 

		}else if(index == 4) {

			start_date.setDate(start_date.getDate() - 3);

			end_date.setDate(end_date.getDate() + 4); 

		}else if(index == 5) {

			start_date.setDate(start_date.getDate() - 4);

			end_date.setDate(end_date.getDate() + 3); 

		}else if(index == 6) {

			start_date.setDate(start_date.getDate() - 5);

			end_date.setDate(end_date.getDate() + 2); 

		}

		var dates_range = get_date_range(start_date, end_date);
		var person_name = jQuery('.staff_timesheet_form .person_name').val();
		var week_number = jQuery('.staff_timesheet_form .week_number').val();
		var picked_year = jQuery('.staff_timesheet_form .picked_year').val();
		var picked_month = jQuery('.staff_timesheet_form .picked_month').val();

		var staff_timesheet_data = person_name +'_'+ week_number +'_'+ picked_year +'_'+ picked_month +'_'+ new_date_format(dates_range[0]) +'_'+ new_date_format(dates_range[6]);

		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'search_staff_timesheet',
				'staff_timesheet_data' : staff_timesheet_data				
			},

			success: function (data) {

				jQuery('.timesheet .left_div .loader').hide();

				var parsed = jQuery.parseJSON(data);

				console.log(parsed);
				var person_dwork = parsed.person_dwork;
				var check_same_user = parsed.check_same_user;
				var month_name = parsed.month_name;
				var year_name = parsed.year_name;
				var rounded_total_month_hour = parsed.rounded_total_month_hour;
				var worked_hours = parsed.worked_hours;
				var total_hours_worked = parsed.total_hours_worked;
				var hour_balance = parsed.hour_balance;
				var holiday_hours = parsed.holiday_hours;

				var tidbank_hours = parsed.tidbank_hours;
				var tidbank_class = parsed.tidbank_class;

				var total_ledig_hours = parsed.ledig_hours;
				var total_holiday_work = parsed.holiday_hours;
				var total_semester_hours = parsed.vacation_hours;
				var total_sjuk_hours = parsed.sick_hours;

				var total_month_hour = parsed.total_month_hour;
				var total_holiday_hour = parsed.total_holiday_hour;
				var total_hour_monday = parsed.total_hour_monday;
				var total_hour_tuesday = parsed.total_hour_tuesday;
				var total_hour_wednesday = parsed.total_hour_wednesday;
				var total_hour_thursday = parsed.total_hour_thursday;
				var total_hour_friday = parsed.total_hour_friday;
				var total_hour_saturday = parsed.total_hour_saturday;
				var total_hour_sunday = parsed.total_hour_sunday;
				var edited_by = parsed.edited_by;
				var hour_per_day = parsed.hour_per_day;

				var day_date = jQuery('.tabs_li.active .day_date').text();

				var full_day_name = jQuery('.tab.tab_content.active').attr('id');
				jQuery('.week_section h3 span.header_day_date').text(full_day_name.capitalize()+ " " +day_date);

				jQuery('#person_hours_per_day').val(hour_per_day);

				var total_hours_worked_day = jQuery('#person_hours_per_day').val();

				var weekNum = jQuery('.tab_content.active .datepicker_week').val();
				
				jQuery('.header_person_name h1').html('Week <span class="top_nav_week_number">'+weekNum+'</span> ( <span class="week">'+change_date_format(parsed.week_start, 'dd/M/Y')+" - "+change_date_format(parsed.week_end, 'dd/M/Y')+"</span> ) "+parsed.person_name + ' - WD: <span class="total_dwork">'+person_dwork+'%</span>');

				var days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"]; 

				jQuery.each(days, function(index, value){
					jQuery('#'+value+ ' .data_list_'+value).remove();
					jQuery('#'+value+ ' .data_title .accordian').remove();
					if(check_same_user != 'yes'){
						jQuery('.import_button').hide();
					}else{
						jQuery('.import_button').show();
					}
				});

				jQuery('.total_hours .task_total_hour h3').text('00:00');

					//Monday
				    time_array = parsed.total_hour_monday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .monday a').removeClass('red-day');
				    	jQuery('#tabs .monday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .monday a').removeClass('green-day');
				    	jQuery('#tabs .monday a').addClass('red-day');
				    }

				    //Tuesday
				    time_array = parsed.total_hour_tuesday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .tuesday a').removeClass('red-day');
				    	jQuery('#tabs .tuesday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .tuesday a').removeClass('green-day');
				    	jQuery('#tabs .tuesday a').addClass('red-day');
				    }

				    //Wednesday
				    time_array = parsed.total_hour_wednesday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .wednesday a').removeClass('red-day');
				    	jQuery('#tabs .wednesday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .wednesday a').removeClass('green-day');
				    	jQuery('#tabs .wednesday a').addClass('red-day');
				    }

				    //Thursday
				    time_array = parsed.total_hour_thursday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .thursday a').removeClass('red-day');
				    	jQuery('#tabs .thursday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .thursday a').removeClass('green-day');
				    	jQuery('#tabs .thursday a').addClass('red-day');
				    }

				    //Friday
				    time_array = parsed.total_hour_friday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .friday a').removeClass('red-day');
				    	jQuery('#tabs .friday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .friday a').removeClass('green-day');
				    	jQuery('#tabs .friday a').addClass('red-day');
				    }

				    //Saturday
				    time_array = parsed.total_hour_saturday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) > 0){
				    	jQuery('#tabs .saturday a').addClass('yellow-day');
				    }else{
				    	jQuery('#tabs .saturday a').removeClass('yellow-day');
				    }

				    //Sunday
				    time_array = parsed.total_hour_sunday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) > 0){
				    	jQuery('#tabs .sunday a').addClass('yellow-day');
				    }else{
				    	jQuery('#tabs .sunday a').removeClass('yellow-day');
				    }

				    //Remove status color if dates are in future.

				    var d = new Date();
					var curr_date = d.getDate();
					var curr_month = d.getMonth();
					var curr_year = d.getFullYear();
					curr_month = (curr_month < 10? '0' : '') + curr_month;
					var today_date = new Date(curr_year, curr_month, curr_date);

					var monday_string = jQuery('#monday .tab_date').val().split("/");
					var monday_date = new Date(monday_string[2], monday_string[1] - 1, monday_string[0]);

				    var tuesday_string = jQuery('#tuesday .tab_date').val().split("/");
				    var tuesday_date = new Date(tuesday_string[2], tuesday_string[1] - 1, tuesday_string[0]);

				    var wednesday_string = jQuery('#wednesday .tab_date').val().split("/");
				    var wednesday_date = new Date(wednesday_string[2], wednesday_string[1] - 1, wednesday_string[0]);

				    var thursday_string = jQuery('#thursday .tab_date').val().split("/");
				    var thursday_date = new Date(thursday_string[2], thursday_string[1] - 1, thursday_string[0]);

				    var friday_string = jQuery('#friday .tab_date').val().split("/");
				    var friday_date = new Date(friday_string[2], friday_string[1] - 1, friday_string[0]);

				    var saturday_string = jQuery('#saturday .tab_date').val().split("/");
				    var saturday_date = new Date(saturday_string[2], saturday_string[1] - 1, saturday_string[0]);

				    var sunday_string = jQuery('#sunday .tab_date').val().split("/");
					var sunday_date = new Date(sunday_string[2], sunday_string[1] - 1, sunday_string[0]);

				    if(today_date <= monday_date){
				    	jQuery('#tabs .monday a').removeClass('green-day red-day');
				    }

				    if(today_date <= tuesday_date){
				    	jQuery('#tabs .tuesday a').removeClass('green-day red-day');
				    }
				    if(today_date <= wednesday_date){
				    	jQuery('#tabs .wednesday a').removeClass('green-day red-day');
				    }

				    if(today_date <= thursday_date){
				    	jQuery('#tabs .thursday a').removeClass('green-day red-day');
				    }

				    if(today_date <= friday_date){
				    	jQuery('#tabs .friday a').removeClass('green-day red-day');
				    }	

				    if(today_date <= saturday_date){
				    	jQuery('#tabs .saturday a').removeClass('gray-day');
				    }

				    if(today_date <= sunday_date){
				    	jQuery('#tabs .sunday a').removeClass('gray-day');
				    }

				jQuery.each(parsed, function(index, value){					

					if(value){

						if(value.day_now){

							var day = value.day_now.toLowerCase();						

							if(day == 'monday'){

								day_sort(value, 'monday', check_same_user);

								jQuery('div#monday .total_hours .task_total_hour h3').html(total_hour_monday);


							}

							if(day == 'tuesday'){

								day_sort(value, 'tuesday', check_same_user);

								jQuery('div#tuesday .total_hours .task_total_hour h3').html(total_hour_tuesday);


							}

							if(day == 'wednesday'){

								day_sort(value, 'wednesday', check_same_user);

								jQuery('div#wednesday .total_hours .task_total_hour h3').html(total_hour_wednesday);

							}

							if(day == 'thursday'){

								day_sort(value, 'thursday', check_same_user);

								jQuery('div#thursday .total_hours .task_total_hour h3').html(total_hour_thursday);

							}

							if(day == 'friday'){

								day_sort(value, 'friday', check_same_user);

								jQuery('div#friday .total_hours .task_total_hour h3').html(total_hour_friday);

							}

							if(day == 'saturday'){

								day_sort(value, 'saturday', check_same_user);

								jQuery('div#saturday .total_hours .task_total_hour h3').html(total_hour_saturday);

							}

							if(day == 'sunday'){

								day_sort(value, 'sunday', check_same_user);

								jQuery('div#sunday .total_hours .task_total_hour h3').html(total_hour_sunday);

							}

						}

					}

					jQuery('.month_name').html(month_name +" - "+ year_name);

					

					

					jQuery('.total_month_hour').html(rounded_total_month_hour);

					

					if(rounded_total_month_hour < '176'){

						jQuery('.total_month_hour').addClass('text_red');

						var hour_balance_decimal = (176 - rounded_total_month_hour).toFixed(2);

					}else if(rounded_total_month_hour > '176'){

						jQuery('.total_month_hour').addClass('text_green');

					}else if(rounded_total_month_hour = '176'){

						jQuery('.total_month_hour').addClass('text_black');

					}

					jQuery('.total_holiday_hour').html(total_holiday_hour);

					

					jQuery('.month_stat .hour_balance').removeClass("text_red text_green");

					if(worked_hours  > total_hours_worked){

						jQuery('.month_stat .hour_balance').addClass("text_red");

						}else{

						jQuery('.month_stat .hour_balance').addClass("text_green");

					}

					jQuery('.month_stat .worked_hours').html(worked_hours);

					jQuery('.month_stat .total_hours_worked').html(total_hours_worked);	

					jQuery('.month_stat .month_details .hour_ledig').html(total_ledig_hours);		
					jQuery('.month_stat .month_details .hour_sjuk').html(total_sjuk_hours);		
					jQuery('.month_stat .month_details .hour_vacation').html(total_semester_hours);						

					jQuery('.month_stat .hour_balance').html(hour_balance);

					jQuery('.month_stat .holiday_hours').html(holiday_hours);

					jQuery('.month_stat .holiday_balance').html(total_holiday_work);


					jQuery('.month_stat .hour_tidbank').html(tidbank_hours);

					if(parsed.tidbank_class == 'red_text'){
						jQuery('.month_details .hour_tidbank').addClass('text_red');
					}else{
						jQuery('.month_details .hour_tidbank').removeClass('text_red');
					}

					//jQuery('.month_summary').show();

				});

				trigger_accordion_toggle();

			},

			error: function (data) {

				

			}

		});

	});

});

/* ==================================== END SEARCH PERSON TASK BY NAME ==================================== */



/* ==================================== SEARCH PERSON TASK BY NAME AND WEEK NUMBER ==================================== */

//DATE PICKER

jQuery(document).ready(function(){

	//DATE NAVIGATION
	jQuery('.navigation_button .date_navigation').click(function(){
		var button_nav = jQuery(this).attr('id')
		var current_tab = jQuery('#tabs .tabs_li.active');
		var current_date = current_tab.find('a').attr('href').replace('#', '');

		var dayNames = new Array('monday','tuesday','wednesday','thursday','friday','saturday', 'sunday');
		var year_date = jQuery('.staff_timesheet_form .picked_year').val();
		var day_date = jQuery('#tabs .tabs_li.active a p.day_date').text();

		if(button_nav == 'prev_day'){
			if(current_date != 'monday'){
				//remove active active on current tab
				
				jQuery('#tabs'+ ' .'+ current_date + '.tabs_li').removeClass('active');
				jQuery('.tabs-container #' + current_date).removeClass('active').hide();

				var day_number = jQuery.inArray(current_date, dayNames) - 1;

				var prev_day  = new Date(day_date + " " + year_date) - 1;
				jQuery(".timesheet #week_number_calendar").datepicker("setDate", new Date(prev_day));

				// //add class on prev day
				jQuery('#tabs'+ ' .'+ dayNames[day_number] + '.tabs_li').addClass('active');
				jQuery('.tabs-container #' + dayNames[day_number]).addClass('active').show();

			}else{
				// var calendar = jQuery(".timesheet #week_number_calendar");
				jQuery('#tabs'+ ' .'+ current_date + '.tabs_li').removeClass('active');
				jQuery('.tabs-container #' + current_date).removeClass('active').hide();
				// console.log(current_date);

				var prev_day  = new Date(day_date + " " + year_date) - 1;
				jQuery(".timesheet #week_number_calendar").datepicker("setDate", new Date(prev_day));

				jQuery('#tabs'+ ' .'+ dayNames[6] + '.tabs_li').addClass('active');
				jQuery('.tabs-container #' + dayNames[6]).addClass('active').show();

				MoveDaysCalendar(prev_day);
			}		
		}else if(button_nav == 'next_day'){
			if(current_date != 'sunday'){
			
				//remove active active on current tab
				jQuery('#tabs'+ ' .'+ current_date + '.tabs_li').removeClass('active');
				jQuery('.tabs-container #' + current_date).removeClass('active').hide();

				var day_number = jQuery.inArray(current_date, dayNames) + 1;

				var current_day  = new Date(day_date + " " + year_date);

				var next_day = new Date(current_day).setDate(current_day.getDate()+1);

				jQuery(".timesheet #week_number_calendar").datepicker("setDate", new Date(next_day));

				// //add class on prev day
				jQuery('#tabs'+ ' .'+ dayNames[day_number] + '.tabs_li').addClass('active');
				jQuery('.tabs-container #' + dayNames[day_number]).addClass('active').show();
			}else{
				// var calendar = jQuery(".timesheet #week_number_calendar");
				jQuery('#tabs'+ ' .'+ current_date + '.tabs_li').removeClass('active');
				jQuery('.tabs-container #' + current_date).removeClass('active').hide();
				// console.log(current_date);

				var current_day  = new Date(day_date + " " + year_date);

				var next_day = new Date(current_day).setDate(current_day.getDate()+1);

				jQuery(".timesheet #week_number_calendar").datepicker("setDate", new Date(next_day));

				jQuery('#tabs'+ ' .'+ dayNames[0] + '.tabs_li').addClass('active');
				jQuery('.tabs-container #' + dayNames[0]).addClass('active').show();

				MoveDaysCalendar(next_day);		
			}	
		}else if(button_nav == 'prev_week'){
			var current_day  = new Date(day_date + " " + year_date);
			var prev_week = new Date(current_day).setDate(current_day.getDate()-7);
			jQuery(".timesheet #week_number_calendar").datepicker("setDate", new Date(prev_week));
			MoveDaysCalendar(prev_week);	
		}else if(button_nav == 'next_week'){
			var current_day  = new Date(day_date + " " + year_date);
			var next_week = new Date(current_day).setDate(current_day.getDate()+7);
			jQuery(".timesheet #week_number_calendar").datepicker("setDate", new Date(next_week));
			MoveDaysCalendar(next_week);		
		}
		var day_date = jQuery('.tabs_li.active').find('.day_date').text();
		var full_day_name = jQuery('.tab.tab_content.active').attr('id');

		jQuery('.week_section h3 span.header_day_date').text(full_day_name.capitalize()+ " " +day_date);
	});

	jQuery('.timesheet #week_number_calendar').datepicker({

		dateFormat: 'yy-mm-dd',

		showWeek: true,

		firstDay: 1,

		markerClassName: 'hasDatepicker',

		onSelect: function (dateText, inst) {

			// dateText = "19 Aug 2016";

			var start_date = new Date(dateText);

			var end_date = new Date(dateText);

			var index = start_date.getDay();

			if(index == 0) {

				start_date.setDate(start_date.getDate() - 6);   

				end_date.setDate(end_date.getDate() + 1);

            }else if(index == 1) {

				start_date.setDate(start_date.getDate());

				end_date.setDate(end_date.getDate() + 7);               

            }else if(index == 2) {

				start_date.setDate(start_date.getDate() - 1);

				end_date.setDate(end_date.getDate() + 6);            

			}else if(index == 3) {

				start_date.setDate(start_date.getDate() - 2);

				end_date.setDate(end_date.getDate() + 5); 

			}else if(index == 4) {

				start_date.setDate(start_date.getDate() - 3);

				end_date.setDate(end_date.getDate() + 4); 

			}else if(index == 5) {

				start_date.setDate(start_date.getDate() - 4);

				end_date.setDate(end_date.getDate() + 3); 

			}else if(index == 6) {

				start_date.setDate(start_date.getDate() - 5);

				end_date.setDate(end_date.getDate() + 2); 

			}



			var dates_range = get_date_range(start_date, end_date);

			var weekday=new Array(7);

			weekday[0]="monday";

			weekday[1]="tuesday";

			weekday[2]="wednesday";

			weekday[3]="thursday";

			weekday[4]="friday";

			weekday[5]="saturday";

			weekday[6]="sunday";
			

			var week_date = jQuery(this).datepicker('getDate');

			var day_of_week = weekday[week_date.getUTCDay()];

			jQuery('.tabs_li').each(function(){

				jQuery(this).removeClass('active');

			});

			jQuery('li.tabs_li').find('a[href*="#'+day_of_week+'"]').parent().addClass('active');

			jQuery('.tab_content').each(function(){

				jQuery(this).removeClass('active');

				jQuery(this).attr('style', 'display:none');

			});

			jQuery('div#'+day_of_week+'.tab_content').addClass('active');

			jQuery('div#'+day_of_week+'.tab_content').attr('style', 'display:block');

			var weekNum = jQuery.datepicker.iso8601Week(new Date(dateText));

			var startDate = new Date(dateText);

			var picked_year = startDate.getFullYear();

			var picked_month_one = startDate.getMonth()+1;

			var picked_day = startDate.getDate();

			var count = picked_month_one.toString().length;

			if(count == 1){

				var picked_month = 0 +""+ picked_month_one;

			}else{

				var picked_month = picked_month_one;

			}			

			jQuery('#week_number').val(weekNum);

			jQuery('#picked_year').val(picked_year);

			jQuery('#picked_month').val(picked_month);

			jQuery('.timesheet .left_div .loader').show();

			var week_dates = writeDays(picked_year, weekNum);

			jQuery('.monday .day_date').text(change_date_format(new_date_format(dates_range[0]), 'dd/M'));

			jQuery('.tuesday .day_date').text(change_date_format(new_date_format(dates_range[1]), 'dd/M'));

			jQuery('.wednesday .day_date').text(change_date_format(new_date_format(dates_range[2]), 'dd/M'));

			jQuery('.thursday .day_date').text(change_date_format(new_date_format(dates_range[3]), 'dd/M'));

			jQuery('.friday .day_date').text(change_date_format(new_date_format(dates_range[4]), 'dd/M'));

			jQuery('.saturday .day_date').text(change_date_format(new_date_format(dates_range[5]), 'dd/M'));

			jQuery('.sunday .day_date').text(change_date_format(new_date_format(dates_range[6]), 'dd/M'));

			

			jQuery('#monday .monday_date').attr('value', new_date_format(dates_range[0]));

			jQuery('#tuesday .tuesday_date').attr('value', new_date_format(dates_range[1]));

			jQuery('#wednesday .wednesday_date').attr('value', new_date_format(dates_range[2]));

			jQuery('#thursday .thursday_date').attr('value', new_date_format(dates_range[3]));

			jQuery('#friday .friday_date').attr('value', new_date_format(dates_range[4]));

			jQuery('#saturday .saturday_date').attr('value', new_date_format(dates_range[5]));

			jQuery('#sunday .sunday_date').attr('value', new_date_format(dates_range[6]));

			jQuery('.tab_content .datepicker_week').attr('value', weekNum);
			jQuery('.week_section .top_nav_week_number').text(weekNum);


			var person_name = jQuery('.staff_timesheet_form .person_name').val();

			var week_number = jQuery('.staff_timesheet_form .week_number').val();

			var picked_year = jQuery('.staff_timesheet_form .picked_year').val();

			var picked_month = jQuery('.staff_timesheet_form .picked_month').val();

			var staff_timesheet_data = person_name +'_'+ week_number +'_'+ picked_year +'_'+ picked_month +'_'+ new_date_format(dates_range[0]) +'_'+ new_date_format(dates_range[6]);	


			jQuery.ajax({

				type: "POST",

				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

				data:{

					'type' : 'search_staff_timesheet',

					'staff_timesheet_data' : staff_timesheet_data				

				},

				success: function (data) {	


					jQuery('.timesheet .left_div .loader').hide();

					var parsed = jQuery.parseJSON(data);	

					var person_dwork = parsed.person_dwork;

					var check_same_user = parsed.check_same_user;

					var month_name = parsed.month_name;

					var year_name = parsed.year_name;

					var rounded_total_month_hour = parsed.rounded_total_month_hour;

					var worked_hours = parsed.worked_hours;

					var total_hours_worked = parsed.total_hours_worked;

					var hour_balance = parsed.hour_balance;

					var holiday_hours = parsed.holiday_hours;

					var total_holiday_work = parsed.total_holiday_work;

					var total_month_hour = parsed.total_month_hour;

					var total_holiday_hour = parsed.total_holiday_hour;

					var total_hour_monday = parsed.total_hour_monday;

					var total_hour_tuesday = parsed.total_hour_tuesday;

					var total_hour_wednesday = parsed.total_hour_wednesday;

					var total_hour_thursday = parsed.total_hour_thursday;

					var total_hour_friday = parsed.total_hour_friday;

					var total_hour_saturday = parsed.total_hour_saturday;

					var total_hour_sunday = parsed.total_hour_sunday;

					var edited_by = parsed.edited_by;


					var day_date = jQuery('.tabs_li.active').find('.day_date').text();
					var full_day_name = jQuery('.tab.tab_content.active').attr('id');
					jQuery('.week_section h3 span.header_day_date').text(full_day_name.capitalize()+ " " +day_date);

				
					jQuery('.header_person_name h1').html('Week <span class="top_nav_week_number">'+weekNum+'</span> ( <span class="week">'+change_date_format(parsed.week_start, 'dd/M/Y')+" - "+change_date_format(parsed.week_end, 'dd/M/Y')+"</span> ) "+parsed.person_name + ' - WD: <span class="total_dwork">'+person_dwork+'%</span>');


					var days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"]; 

					jQuery.each(days, function(index, value){						

						//Clear all Days timesheet list on calendar selection.
						jQuery('#'+value+ ' .data_list_'+value).remove();
						jQuery('#'+value+ ' .data_title .accordian').remove();

						if(check_same_user != 'yes'){

							jQuery('.import_button').hide();

						}else{

							jQuery('.import_button').show();

						}

					});

					jQuery('.total_hours .task_total_hour h3').text('00:00');

					//Monday
				    time_array = parsed.total_hour_monday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .monday a').removeClass('red-day');
				    	jQuery('#tabs .monday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .monday a').removeClass('green-day');
				    	jQuery('#tabs .monday a').addClass('red-day');
				    }

				    //Tuesday
				    time_array = parsed.total_hour_tuesday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .tuesday a').removeClass('red-day');
				    	jQuery('#tabs .tuesday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .tuesday a').removeClass('green-day');
				    	jQuery('#tabs .tuesday a').addClass('red-day');
				    }

				    //Wednesday
				    time_array = parsed.total_hour_wednesday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .wednesday a').removeClass('red-day');
				    	jQuery('#tabs .wednesday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .wednesday a').removeClass('green-day');
				    	jQuery('#tabs .wednesday a').addClass('red-day');
				    }

				    //Thursday
				    time_array = parsed.total_hour_thursday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .thursday a').removeClass('red-day');
				    	jQuery('#tabs .thursday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .thursday a').removeClass('green-day');
				    	jQuery('#tabs .thursday a').addClass('red-day');
				    }

				    //Friday
				    time_array = parsed.total_hour_friday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .friday a').removeClass('red-day');
				    	jQuery('#tabs .friday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .friday a').removeClass('green-day');
				    	jQuery('#tabs .friday a').addClass('red-day');
				    }

				    //Saturday
				    time_array = parsed.total_hour_saturday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) > 0){
				    	jQuery('#tabs .saturday a').addClass('yellow-day');
				    	console.log('time');
				    }else{
				    	jQuery('#tabs .saturday a').removeClass('yellow-day');
				    	console.log('no time');
				    }

				    //Sunday
				    time_array = parsed.total_hour_sunday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) > 0){
				    	jQuery('#tabs .sunday a').addClass('yellow-day');
				    }else{
				    	jQuery('#tabs .sunday a').removeClass('yellow-day');
				    }


				    //Remove status color if dates are in future.

				    var d = new Date();
					var curr_date = d.getDate();
					var curr_month = d.getMonth();
					var curr_year = d.getFullYear();
					curr_month = (curr_month < 10? '0' : '') + curr_month;
					var today_date = new Date(curr_year, curr_month, curr_date);

					var monday_string = jQuery('#monday .tab_date').val().split("/");
					var monday_date = new Date(monday_string[2], monday_string[1] - 1, monday_string[0]);

				    var tuesday_string = jQuery('#tuesday .tab_date').val().split("/");
				    var tuesday_date = new Date(tuesday_string[2], tuesday_string[1] - 1, tuesday_string[0]);

				    var wednesday_string = jQuery('#wednesday .tab_date').val().split("/");
				    var wednesday_date = new Date(wednesday_string[2], wednesday_string[1] - 1, wednesday_string[0]);

				    var thursday_string = jQuery('#thursday .tab_date').val().split("/");
				    var thursday_date = new Date(thursday_string[2], thursday_string[1] - 1, thursday_string[0]);

				    var friday_string = jQuery('#friday .tab_date').val().split("/");
				    var friday_date = new Date(friday_string[2], friday_string[1] - 1, friday_string[0]);

				    var saturday_string = jQuery('#saturday .tab_date').val().split("/");
				    var saturday_date = new Date(saturday_string[2], saturday_string[1] - 1, saturday_string[0]);

				    var sunday_string = jQuery('#sunday .tab_date').val().split("/");
					var sunday_date = new Date(sunday_string[2], sunday_string[1] - 1, sunday_string[0]);

				    if(today_date <= monday_date){
				    	jQuery('#tabs .monday a').removeClass('green-day red-day');
				    }

				    if(today_date <= tuesday_date){
				    	jQuery('#tabs .tuesday a').removeClass('green-day red-day');
				    }
				    if(today_date <= wednesday_date){
				    	jQuery('#tabs .wednesday a').removeClass('green-day red-day');
				    }

				    if(today_date <= thursday_date){
				    	jQuery('#tabs .thursday a').removeClass('green-day red-day');
				    }

				    if(today_date <= friday_date){
				    	jQuery('#tabs .friday a').removeClass('green-day red-day');
				    }	

				    if(today_date <= saturday_date){
				    	jQuery('#tabs .saturday a').removeClass('yellow-day');
				    }

				    if(today_date <= sunday_date){
				    	jQuery('#tabs .sunday a').removeClass('yellow-day');
				    }

					jQuery.each(parsed, function(index, value){
	
						if(value){
							if(value.day_now){
								var day = value.day_now.toLowerCase();				

								if(day == 'monday'){
									day_sort(value, 'monday', check_same_user);

									jQuery('div#monday .total_hours .task_total_hour h3').html(total_hour_monday);

									//Check Day Status Color
									// if (total_hour_monday.indexOf(":") != -1) {
									// }

								}


								if(day == 'tuesday'){

									day_sort(value, 'tuesday', check_same_user);

									jQuery('div#tuesday .total_hours .task_total_hour h3').html(total_hour_tuesday);

									//Check Day Status Color
									// console.log(total_hour_tuesday);
									// if (total_hour_tuesday.indexOf(":") != -1) {
									// }

								}

								if(day == 'wednesday'){
									day_sort(value, 'wednesday', check_same_user);
									jQuery('div#wednesday .total_hours .task_total_hour h3').html(total_hour_wednesday);

									//Check Day Status Color
									// if (total_hour_wednesday.indexOf(":") != -1) {

									// }

								}

								if(day == 'thursday'){

									day_sort(value, 'thursday', check_same_user);

									jQuery('div#thursday .total_hours .task_total_hour h3').html(total_hour_thursday);

									//Check Day Status Color
									// if (total_hour_thursday.indexOf(":") != -1) {

									// }
								}

								if(day == 'friday'){

									day_sort(value, 'friday', check_same_user);

									jQuery('div#friday .total_hours .task_total_hour h3').html(total_hour_friday);

									//Check Day Status Color
									// if (total_hour_friday.indexOf(":") != -1) {

									// }

								}

								if(day == 'saturday'){

									day_sort(value, 'saturday', check_same_user);

									jQuery('div#saturday .total_hours .task_total_hour h3').html(total_hour_saturday);

									//Check Day Status Color
									// if (total_hour_saturday.indexOf(":") != -1) {

									// }

								}

								if(day == 'sunday'){

									day_sort(value, 'sunday', check_same_user);

									jQuery('div#sunday .total_hours .task_total_hour h3').html(total_hour_sunday);

									//Check Day Status Color
									// if (total_hour_sunday.indexOf(":") != -1) {

									// }

								}

							}

						}

						jQuery('.month_name').html(month_name +" - "+ year_name);

					

						jQuery('.total_month_hour').html(rounded_total_month_hour);

						

						if(rounded_total_month_hour < '176'){

							jQuery('.total_month_hour').addClass('text_red');

							var hour_balance_decimal = (176 - rounded_total_month_hour).toFixed(2);

						}else if(rounded_total_month_hour > '176'){

							jQuery('.total_month_hour').addClass('text_green');

						}else if(rounded_total_month_hour = '176'){

							jQuery('.total_month_hour').addClass('text_black');

						}

						jQuery('.total_holiday_hour').html(total_holiday_hour);

						

						jQuery('.month_stat .hour_balance').removeClass("text_red text_green");

						if(worked_hours  > total_hours_worked){

							jQuery('.month_stat .hour_balance').addClass("text_red");

						}else{

							jQuery('.month_stat .hour_balance').addClass("text_green");

						}						

						jQuery('.month_stat .worked_hours').html(worked_hours);

						jQuery('.month_stat .total_hours_worked').html(total_hours_worked);

						jQuery('.month_stat .hour_balance').html(hour_balance);

						jQuery('.month_stat .holiday_hours').html(holiday_hours);

						jQuery('.month_stat .holiday_balance').html(total_holiday_work);

						//jQuery('.month_summary').show();

					});

					trigger_accordion_toggle();

				},

				error: function (data) {

					

				}

			});

		}	

	});		

});

/* ==================================== END SEARCH PERSON TASK BY NAME AND WEEK NUMBER ==================================== */

jQuery(document).on('click', '#add_new_row', function(){

	var day = jQuery('.tab_content.active').attr('id');

	jQuery(".top_loader").show();	

	jQuery.ajax({

		type: "POST",

		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

		data:{

			'type' : 'get_add_new_row',

			'day' : day

		},

		success: function (data) {				

			var html = jQuery.parseJSON(data);

			var client_exist = jQuery('.tab_content.active .task_name li:last').length;

			// jQuery('#'+day+' #add_new_row').addClass('hide-element');

			if(client_exist == 0){


				jQuery('.tab_content.active .task_label h3').after(html.clients);

				jQuery('.tab_content.active .task_name h3').after(html.tasknames);

				jQuery('.tab_content.active .task_color h3').after(html.projects);

				jQuery('.tab_content.active .task_person h3').after(html.users);

				jQuery('<li id="new_row_hour" class="data_list_'+day+'"><input type="text" id="new_hour_input" placeholder="00:00"></li>').insertAfter('.tab_content.active .task_hour h3');

				jQuery('<div id="new_row_description" class="accordian"><input type="text"></div>').insertAfter('.tab_content.active .task_description h3');

				jQuery('<li class="data_list_'+day+' new_row_option"><div id="" class="button_1 save_row">S</div></li>').insertAfter('.tab_content.active .task_edit .top_label');

				jQuery('<li class="data_list_'+day+' new_row_option"><div id="" class="button_1 cancel_row">-</div></li>').insertAfter('.tab_content.active .task_delete .top_label');

			}else{
		

				jQuery('.tab_content.active .task_label li:last').after(html.clients);

				jQuery('.tab_content.active .task_name li:last').after(html.tasknames);

				jQuery('.tab_content.active .task_color li:last').after(html.projects);

				jQuery('.tab_content.active .task_person li:last').after(html.users);

				jQuery('<li id="new_row_hour" class="data_list_'+day+'"><input type="text" id="new_hour_input" placeholder="00:00"></li>').insertAfter('.tab_content.active .task_hour li:last');

				jQuery('<div id="new_row_description" class="accordian"><input type="text"></div>').insertAfter('.tab_content.active .task_description div.accordian:last');

				jQuery('<li class="data_list_'+day+' new_row_option"><div id="" class="button_1 save_row">S</div></li>').insertAfter('.tab_content.active .task_edit li:last');

				jQuery('<li class="data_list_'+day+' new_row_option"><div id="" class="button_1 cancel_row">-</div></li>').insertAfter('.tab_content.active .task_delete li:last');



			}

			jQuery(".top_loader").hide();



		},

		error: function (data) {

			alert('error');

		}				

	});

});




jQuery(document).on('click', '.cancel_row', function(){

	jQuery('#new_row_client').remove();

	jQuery('#new_row_task').remove();

	jQuery('#new_row_project').remove();

	jQuery('#new_row_hour').remove();

	jQuery('#new_row_description').remove();

	jQuery('#new_task_person').remove();

	jQuery('.new_row_option').remove();
});

jQuery(document).on('click', '.save_row', function(){

	var new_task = jQuery('#new_row_task select').val();
	var new_client_id = jQuery('#new_row_client select').val();
	var new_project = jQuery('#new_row_project select').val();
	var new_hour_input = jQuery('#new_row_hour input#new_hour_input').val();
	var new_description = jQuery('#new_row_description input').val();
	var new_task_person = jQuery('#new_task_person select').val();

	var date = jQuery('.tab_content.active .tab_date').val();
	var week = jQuery('.tab_content.active .tab_week').val();
	var day = jQuery('.tab_content.active').attr('id');

	var new_entry = {
		task : new_task,
		client_id : new_client_id,
		project : new_project,
		hour_input : new_hour_input,
		description : new_description,
		task_person : new_task_person,
		date_entry : date,
		week_number : week,
		day_now : day
	};

	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data: { 
			'type' : 'add_new_entry_timesheet',
			'new_entry_timesheet' : new_entry
		},
		success: function (data) {

			jQuery('#new_row_client').remove();

			jQuery('#new_row_task').remove();

			jQuery('#new_row_project').remove();

			jQuery('#new_row_hour').remove();

			jQuery('#new_row_description').remove();

			jQuery('#new_task_person').remove();

			jQuery('.new_row_option').remove();		

			var parsed = jQuery.parseJSON(data);


			var task_name 			= (parsed.task_name == "") ? "--" : parsed.task_name;

			var total_hour 			= (parsed.total_hour == "") ? "--" : parsed.total_hour;

			var task_hour_format 	= (parsed.task_hour_format == "") ? "--" : parsed.task_hour_format;

			var task_hour_billable_format 	= (parsed.task_hour_billable_format == "") ? "--" : parsed.task_hour_billable_format;

			var task_label 			= (parsed.task_label == "") ? "--" : parsed.task_label;

			var task_project_name 	= (parsed.task_project_name == "") ? "--" : parsed.task_project_name;

			var task_person 		= (parsed.task_person == "") ? "--" : parsed.task_person;

			var task_description 	= (parsed.task_description == "") ? "--" : parsed.task_description;

			var description_length 	= task_description.length;

			if(description_length >= 24){

				var short_description = jQuery.trim(task_description).substring(0, 24).split(" ").slice(0, -1).join(" ") + "...";

			}else{

				var short_description = task_description +"...";

			}


			jQuery('.tab_content.active .task_name').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_name+'</li>');

			jQuery('.tab_content.active .task_hour').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_hour_format+'</li>');

			jQuery('.tab_content.active .task_hour_billable').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_hour_billable_format+'</li>');

			jQuery('.tab_content.active .task_label').append('<li class="client_info data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_label+'</li>');

			jQuery('.tab_content.active .task_color').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_project_name+'</li>');

			jQuery('.tab_content.active .task_person').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+task_person+'</li>');

			jQuery('.tab_content.active .task_description').append('<div class="accordian accordian_'+parsed.id+'"><h5 class="toggle"><a href="#"><li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'">'+short_description+'<span class="arrow"></span></li></a></h5></div>');						

			jQuery('.tab_content.active .task_description .accordian_'+parsed.id).append("<div class='toggle-content' style='display: none;'>"+task_description+"</div>");

			jQuery('.tab_content.active .task_delete').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'"><div id="delete_kanban_'+day_now_id+'_'+parsed.id+'" class="button_1 confirm delete_button delete_kanban_'+day_now_id+'">-</div></li>');			

			jQuery('.tab_content.active .task_edit').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'"><div id="edit_kanban_'+day_now_id+'_'+parsed.id+'" class="button_1 edit_button edit_kanban">E</div></li>');			

			// jQuery('.tab_content.active .task_edit').append("<div id='loader_id_"+parsed.id+"' style='display: none;' class='loader timesheet_loader'></div>");

			jQuery('.tab_content.active .task_done_today').append('<li class="data_list_'+day_now_id+' timesheet_data_id_'+parsed.id+'"><div id="done_today_kanban_'+day_now_id+'_'+parsed.id+'" class="button_1 done_today_button done_today_kanban_'+day_now_id+' done_today_not_current">Done Today</div></li>');

			// jQuery('.tab_content.active .total_hours .task_total_hour h3').text(total_hour);

			trigger_accordion_toggle();

		},
		error: function (data) {
			alert('error');
		}				

	});

});

/* ==================================== CHECK STATUS DAY TAB COLOR ==================================== */
jQuery(document).ready(function(){
	var monday = jQuery('#monday .total_hours .task_total_hour input').val();
	var tuesday = jQuery('#tuesday .total_hours .task_total_hour input').val();
	var wednesday = jQuery('#wednesday .total_hours .task_total_hour input').val();
	var thursday = jQuery('#thursday .total_hours .task_total_hour input').val();
	var friday = jQuery('#friday .total_hours .task_total_hour input').val();
	var saturday = jQuery('#saturday .total_hours .task_total_hour input').val();
	var sunday = jQuery('#sunday .total_hours .task_total_hour input').val();
	
	if(monday == 'green'){
		jQuery('#tabs .monday a').addClass('green-day');
	}else if(monday == 'red'){
		jQuery('#tabs .monday a').addClass('red-day');
	}
	if(tuesday == 'green'){
		jQuery('#tabs .tuesday a').addClass('green-day');
	}else if(tuesday == 'red'){
		jQuery('#tabs .tuesday a').addClass('red-day');
	}
	if(wednesday == 'green'){
		jQuery('#tabs .wednesday a').addClass('green-day');
	}else if(wednesday == 'red'){
		jQuery('#tabs .wednesday a').addClass('red-day');
	}
	if(thursday == 'green'){
		jQuery('#tabs .thursday a').addClass('green-day');
	}else if(thursday == 'red'){
		jQuery('#tabs .thursday a').addClass('red-day');
	}
	if(friday == 'green'){
		jQuery('#tabs .friday a').addClass('green-day');
	}else if(friday == 'red'){
		jQuery('#tabs .friday a').addClass('red-day');
	}
	if(saturday == 'green'){
		jQuery('#tabs .saturday a').addClass('green-day');
	}else if(saturday == 'red'){
		jQuery('#tabs .saturday a').addClass('red-day');
	}
	if(sunday == 'green'){
		jQuery('#tabs .sunday a').addClass('green-day');
	}else if(sunday == 'red'){
		jQuery('#tabs .sunday a').addClass('red-day');
	}

});



//Saving New timesheet entry
jQuery(document).on('click', '.tab_content.active .save_button_timesheet', function(){

	var id = jQuery(this).attr('id').split('_')[3];

	var this_button = jQuery(this);
	this_button.hide().next('.loader-save-entry').show();

	var taskname = jQuery('.tab_content.active .new_entry_taskname_1 select').val();
	var client = jQuery('.tab_content.active .new_entry_client_1 select').val();
	var project = jQuery('.tab_content.active .new_entry_project_1 select').val();
	var ordernumber = jQuery('.tab_content.active .new_entry_ordernumber_1 input').val();
	var hour = jQuery('.tab_content.active .new_entry_hours_1 input').val();
	var kilometer = jQuery('.tab_content.active .new_entry_kilometer_1 input').val();
	var description =  jQuery('.tab_content.active .new_entry_description_1 input').val();
	var user = jQuery('.tab_content.active #current_logged_user').val();
	var active_day = jQuery('.tab_content.active').attr('id');
	var week_number = jQuery('.tab_content.active .tab_week').val();
	var date = jQuery('.tab_content.active .tab_date').val();
	var username =  jQuery('.staff_timesheet_form .choose_person .person_name').val();
	var task_description_count = description.length;

	var validation_hour = input_time_validation(hour, taskname);

	if(validation_hour.taskname_validation == false){
		jQuery(".status_message").fadeIn( "slow", function() {
			jQuery(".status_message p").html("<p class='error-msg'>Only <b>Tidbank</b> task accept negative value.</p>");
		});
		jQuery(".status_message").delay(1000).fadeOut('slow');
		jQuery('#save-loader').css('visibility', 'hidden');	 	
		this_button.show().next('.loader-save-entry').hide();	
 		return false;		
	} 
	if(validation_hour.input_time_format_validation == false){
		jQuery(".status_message").fadeIn( "slow", function() {
			jQuery(".status_message p").html("<p class='error-msg'>Invalid Time Format.</p>");
		});
		jQuery(".status_message").delay(1000).fadeOut('slow');
		jQuery('#save-loader').css('visibility', 'hidden');	 	
		this_button.show().next('.loader-save-entry').hide();	
 		return false;
	}

	// console.log(validation_hour.hour);
	// return false;

	var new_entry_obj = {
		taskname : taskname,
		client_id : client,
		project : project,
		description : description,
		// negative_value : negative_value,
		active_day : active_day,
		week_number : week_number,
		date : date,
		hour : validation_hour.hour,
		username : username,
		ordernumber : ordernumber,
		kilometer : kilometer
	};


	jQuery.ajax({

			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

			data:{
				'type' : 'save_timesheet_entry',
				'save_timesheet_row' : new_entry_obj
			},
			success: function (data) {				
				var parsed = jQuery.parseJSON(data);
				jQuery(".top_loader").hide();
				if(task_description_count >= 24){

					var short_description = jQuery.trim(description).substr(0, 34)+'...';
											
				}else{

					var short_description = description+'...';

				}				

				var orderno = (parsed.task_orderno == "")? "--" : parsed.task_orderno;

				var kilometer = (parsed.task_kilometer == "")? "--" : parsed.task_kilometer;

				//Taskname
				jQuery('<li id="taskname_id_'+parsed.id+'" class="data_list_'+active_day+' edit_taskname_record timesheet_data_id_'+parsed.id+'">'+parsed.task_name+'</li>').insertBefore('.tab_content.active .task_name li:last');
				
				//Hours
				jQuery('<li id="timesheet_hour_id_'+parsed.id+'" class="data_list_'+active_day+' timesheet_data_id_'+parsed.id+' edit_column_field">'+parsed.task_hour_format+'</li>').insertBefore('.tab_content.active .task_hour li:last');

				//Client
				jQuery('<li id="client_list_'+parsed.id+'" class="client_info data_list_'+active_day+' timesheet_data_id_'+parsed.id+'">'+parsed.task_label+'</li>').insertBefore('.tab_content.active .task_label li:last');

				//Project
				jQuery('<li id="project_id_'+parsed.id+'" class="data_list_'+active_day+' edit_project_record timesheet_data_id_'+parsed.id+'">'+parsed.task_project_name+'<div id="project_loader_'+parsed.id+'" class="row-update-loader-project" style="display: none;"></div></li>').insertBefore('.tab_content.active .task_color li:last');

				jQuery('<li class="data_list_'+active_day+' timesheet_data_id_'+parsed.id+'">'+parsed.task_person+'</li>').insertBefore('.tab_content.active .task_person li:last');

				//Order Number
				jQuery('<li id="timesheet_orderno_id_'+parsed.id+'" class="data_list_'+active_day+' edit_column_field timesheet_data_id_'+parsed.id+'">'+orderno+'</li>').insertBefore('.tab_content.active .ordernumber li:last');		

				//Kilometer
				jQuery('<li id="timesheet_kilometer_id_'+parsed.id+'" class="data_list_'+active_day+' edit_column_field timesheet_data_id_'+parsed.id+'">'+kilometer+'</li>').insertBefore('.tab_content.active .kilometer li:last');		
			

				//Description
				jQuery('<div class="accordian accordian_'+parsed.id+'"><h5 class="toggle"><div id="toggle_description_id_'+parsed.id+'" class="edit_column_field desc"><li class="data_list_'+active_day+' timesheet_data_id_'+parsed.id+' description_data_id_'+parsed.id+'">'+short_description+'<span class="arrow"></span></li></div></h5><div id="timesheet_description_id_'+parsed.id+'" class="toggle-content" style="display: none;">'+parsed.task_description+'</div></div>').insertBefore('.tab_content.active .task_description div:last');						

		
				jQuery('<li class="data_list_'+active_day+' timesheet_data_id_'+parsed.id+'"><div id="edit_kanban_'+active_day+'_'+parsed.id+'" class="button_1 edit_button edit_kanban">E</div></li>').insertBefore('.tab_content.active .task_edit li:last');	

				//Task
				jQuery('<li class="data_list_'+active_day+' edit_taskname_record timesheet_data_id_'+parsed.id+'"><div style="visibility: hidden;" class="row-delete-loader" id="delete_loader_'+parsed.id+'"></div></li>').insertBefore('.tab_content.active .task-complete li:last');


				if(jQuery('.tab_content.active .task_delete li').length == 0){
					jQuery('<li class="data_list_'+active_day+' timesheet_data_id_'+parsed.id+'"><div id="delete_kanban_'+active_day+'_'+parsed.id+'" class="button_1 delete_button delete_edit_kanban">-</div></li>').insertAfter('.tab_content.active .task_delete h3');	
				}else{
					jQuery('<li class="data_list_'+active_day+' timesheet_data_id_'+parsed.id+'"><div id="delete_kanban_'+active_day+'_'+parsed.id+'" class="button_1 delete_button delete_edit_kanban">-</div></li>').insertBefore('.tab_content.active .task_delete li:last');
				}	

				//Side Panel Info Update
				jQuery('.month_details .worked_hours').text(parsed.side_panel_total_workable_hours);
				jQuery('.month_details .hour_balance').text(parsed.side_panel_total_hour_balance);
				jQuery('.month_details .total_hours_worked').text(parsed.side_panel_total_worked_hours);
				jQuery('.month_details .hour_vacation').text(parsed.side_panel_total_semester);
				jQuery('.month_details .holiday_hours').text(parsed.side_panel_total_helg);
				jQuery('.month_details .hour_ledig').text(parsed.side_panel_total_ledig);
				jQuery('.month_details .hour_sjuk').text(parsed.side_panel_total_sjuk);
				jQuery('.month_details .hour_tidbank').text(parsed.side_panel_total_hours_tidbank);
				jQuery('.header_person_name .total_dwork').text(parsed.dwork_percent);

				if(parsed.side_panel_tid_bank_class == 'red_text'){
					jQuery('.month_details .hour_tidbank').addClass('text_red');
				}else{
					jQuery('.month_details .hour_tidbank').removeClass('text_red');
				}

				if(parsed.side_panel_total_hour_balance_color == 'green'){
					jQuery('.month_details .hour_balance ').removeClass('text_red').addClass('text_green');
				}else{
					jQuery('.month_details .hour_balance ').removeClass('text_green').addClass('text_red');
				}

				jQuery('.tab_content.active .new_entry_description_1 input').val('');
				jQuery('.tab_content.active .new_entry_hours_1 input').val('');
				jQuery('.tab_content.active .new_entry_ordernumber_1 input').val('');
				jQuery('.tab_content.active .new_entry_kilometer_1 input').val('');

				trigger_accordion_toggle();

				// UpdateTotalTime(active_day, parsed.task_hour_format);
				jQuery('.tab_content.active .task_total_hour h3').text(parsed.day_total_work_hours);

				jQuery('.action_message p').text("Task Saved!");

				jQuery('.action_message').fadeIn( "slow", function() {

					jQuery(".action_message").delay(1000).fadeOut('slow');

				});
				var total_hours_worked = jQuery('.tabs-container .tab_content.active .total_hours .task_total_hour h3').text();
				var total_person_working_hours = jQuery('#person_hours_per_day').val();

				this_button.show().next('.loader-save-entry').hide();

				if(parsed.day_total_work_hours_dec >= 8){
					jQuery('#tabs .tabs_li.active a').removeClass('red-day').addClass('green-day');
				}

			},

			error: function (data) {
				alert('error');
			}				

	});


});

function timestrToSec(timestr) {
  var parts = timestr.split(":");
  return (parts[0] * 3600) +
         (parts[1] * 60) +
         (+parts[2]);
}

function pad(num) {
  if(num < 10) {
    return "0" + num;
  } else {
    return "" + num;
  }
}

function formatTime(seconds) {
  return [pad(Math.floor(seconds/3600)%60),
          pad(Math.floor(seconds/60)%60),
          pad(seconds%60),
          ].join(":");
}


//functions for timesheet days and weeks navigations buttons
function MoveDaysCalendar(day_date){

	var calendar = jQuery('.timesheet #week_number_calendar');

	var start_date = new Date(day_date);

	var end_date = new Date(day_date);

	var index = start_date.getDay();

			if(index == 0) {

				start_date.setDate(start_date.getDate() - 6);   

				end_date.setDate(end_date.getDate() + 1);

            }else if(index == 1) {

				start_date.setDate(start_date.getDate());

				end_date.setDate(end_date.getDate() + 7);               

            }else if(index == 2) {

				start_date.setDate(start_date.getDate() - 1);

				end_date.setDate(end_date.getDate() + 6);            

			}else if(index == 3) {

				start_date.setDate(start_date.getDate() - 2);

				end_date.setDate(end_date.getDate() + 5); 

			}else if(index == 4) {

				start_date.setDate(start_date.getDate() - 3);

				end_date.setDate(end_date.getDate() + 4); 

			}else if(index == 5) {

				start_date.setDate(start_date.getDate() - 4);

				end_date.setDate(end_date.getDate() + 3); 

			}else if(index == 6) {

				start_date.setDate(start_date.getDate() - 5);

				end_date.setDate(end_date.getDate() + 2); 

			}



			var dates_range = get_date_range(start_date, end_date);

			var weekday=new Array(7);

			weekday[0]="monday";

			weekday[1]="tuesday";

			weekday[2]="wednesday";

			weekday[3]="thursday";

			weekday[4]="friday";

			weekday[5]="saturday";

			weekday[6]="sunday";
			

			var week_date = jQuery(calendar).datepicker('getDate');

			var day_of_week = weekday[week_date.getUTCDay()];

			jQuery('.tabs_li').each(function(){

				jQuery(calendar).removeClass('active');

			});

			var weekNum = jQuery.datepicker.iso8601Week(new Date(day_date));

			var startDate = new Date(day_date);

			var picked_year = startDate.getFullYear();

			var picked_month_one = startDate.getMonth()+1;

			var picked_day = startDate.getDate();

			var count = picked_month_one.toString().length;

			if(count == 1){

				var picked_month = 0 +""+ picked_month_one;

			}else{

				var picked_month = picked_month_one;

			}			

			jQuery('#week_number').val(weekNum);

			jQuery('#picked_year').val(picked_year);

			jQuery('#picked_month').val(picked_month);

			jQuery('.timesheet .left_div .loader').show();

			var week_dates = writeDays(picked_year, weekNum);

			jQuery('.monday .day_date').text(change_date_format(new_date_format(dates_range[0]), 'dd/M'));

			jQuery('.tuesday .day_date').text(change_date_format(new_date_format(dates_range[1]), 'dd/M'));

			jQuery('.wednesday .day_date').text(change_date_format(new_date_format(dates_range[2]), 'dd/M'));

			jQuery('.thursday .day_date').text(change_date_format(new_date_format(dates_range[3]), 'dd/M'));

			jQuery('.friday .day_date').text(change_date_format(new_date_format(dates_range[4]), 'dd/M'));

			jQuery('.saturday .day_date').text(change_date_format(new_date_format(dates_range[5]), 'dd/M'));

			jQuery('.sunday .day_date').text(change_date_format(new_date_format(dates_range[6]), 'dd/M'));

			

			jQuery('#monday .monday_date').attr('value', new_date_format(dates_range[0]));

			jQuery('#tuesday .tuesday_date').attr('value', new_date_format(dates_range[1]));

			jQuery('#wednesday .wednesday_date').attr('value', new_date_format(dates_range[2]));

			jQuery('#thursday .thursday_date').attr('value', new_date_format(dates_range[3]));

			jQuery('#friday .friday_date').attr('value', new_date_format(dates_range[4]));

			jQuery('#saturday .saturday_date').attr('value', new_date_format(dates_range[5]));

			jQuery('#sunday .sunday_date').attr('value', new_date_format(dates_range[6]));

			jQuery('.tab_content .datepicker_week').attr('value', weekNum);
			jQuery('.week_section .top_nav_week_number').text(weekNum);

			var person_name = jQuery('.staff_timesheet_form .person_name').val();

			var week_number = jQuery('.staff_timesheet_form .week_number').val();

			var picked_year = jQuery('.staff_timesheet_form .picked_year').val();

			var picked_month = jQuery('.staff_timesheet_form .picked_month').val();

			var staff_timesheet_data = person_name +'_'+ week_number +'_'+ picked_year +'_'+ picked_month +'_'+ new_date_format(dates_range[0]) +'_'+ new_date_format(dates_range[6]);	

	
			jQuery.ajax({

				type: "POST",

				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

				data:{

					'type' : 'search_staff_timesheet',

					'staff_timesheet_data' : staff_timesheet_data				

				},

				success: function (data) {	


					jQuery('.timesheet .left_div .loader').hide();

					var parsed = jQuery.parseJSON(data);	

					var person_dwork = parsed.person_dwork;

					var check_same_user = parsed.check_same_user;

					var month_name = parsed.month_name;

					var year_name = parsed.year_name;

					var rounded_total_month_hour = parsed.rounded_total_month_hour;

					var worked_hours = parsed.worked_hours;

					var total_hours_worked = parsed.total_hours_worked;

					var hour_balance = parsed.hour_balance;

					var holiday_hours = parsed.holiday_hours;

					var total_holiday_work = parsed.total_holiday_work;

					var total_month_hour = parsed.total_month_hour;

					var total_holiday_hour = parsed.total_holiday_hour;

					var total_hour_monday = parsed.total_hour_monday;

					var total_hour_tuesday = parsed.total_hour_tuesday;

					var total_hour_wednesday = parsed.total_hour_wednesday;

					var total_hour_thursday = parsed.total_hour_thursday;

					var total_hour_friday = parsed.total_hour_friday;

					var total_hour_saturday = parsed.total_hour_saturday;

					var total_hour_sunday = parsed.total_hour_sunday;

					var edited_by = parsed.edited_by;

					var day_date = jQuery('.tabs_li.active').find('.day_date').text();
					var full_day_name = jQuery('.tab.tab_content.active').attr('id');
					jQuery('.week_section h3 span.header_day_date').text(full_day_name.capitalize()+ " " +day_date);
					console.log(person_dwork);
					jQuery('.header_person_name h1').html('Week <span class="top_nav_week_number">'+weekNum+'</span> ( <span class="week">'+change_date_format(parsed.week_start, 'dd/M/Y')+" - "+change_date_format(parsed.week_end, 'dd/M/Y')+"</span>  "+parsed.person_name + ' - WD: <span class="total_dwork">'+person_dwork+'%</span>');


					var days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"]; 


					jQuery.each(days, function(index, value){						

						//Clear all Days timesheet list on calendar selection.
						jQuery('#'+value+ ' .data_list_'+value).remove();
						jQuery('#'+value+ ' .data_title .accordian').remove();

						if(check_same_user != 'yes'){

							jQuery('.import_button').hide();

						}else{

							jQuery('.import_button').show();

						}

					});

					jQuery('.total_hours .task_total_hour h3').text('00:00');

					//Monday
				    time_array = parsed.total_hour_monday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .monday a').removeClass('red-day');
				    	jQuery('#tabs .monday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .monday a').removeClass('green-day');
				    	jQuery('#tabs .monday a').addClass('red-day');
				    }

				    //Tuesday
				    time_array = parsed.total_hour_tuesday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .tuesday a').removeClass('red-day');
				    	jQuery('#tabs .tuesday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .tuesday a').removeClass('green-day');
				    	jQuery('#tabs .tuesday a').addClass('red-day');
				    }

				    //Wednesday
				    time_array = parsed.total_hour_wednesday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .wednesday a').removeClass('red-day');
				    	jQuery('#tabs .wednesday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .wednesday a').removeClass('green-day');
				    	jQuery('#tabs .wednesday a').addClass('red-day');
				    }

				    //Thursday
				    time_array = parsed.total_hour_thursday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .thursday a').removeClass('red-day');
				    	jQuery('#tabs .thursday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .thursday a').removeClass('green-day');
				    	jQuery('#tabs .thursday a').addClass('red-day');
				    }

				    //Friday
				    time_array = parsed.total_hour_friday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) >= 8){
				    	jQuery('#tabs .friday a').removeClass('red-day');
				    	jQuery('#tabs .friday a').addClass('green-day');

				    }else{
				    	jQuery('#tabs .friday a').removeClass('green-day');
				    	jQuery('#tabs .friday a').addClass('red-day');
				    }

				    //Saturday
				    time_array = parsed.total_hour_saturday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) > 0){
				    	jQuery('#tabs .saturday a').addClass('yellow-day');
				    }else{
				    	jQuery('#tabs .saturday a').removeClass('yellow-day');
				    }

				    //Sunday
				    time_array = parsed.total_hour_sunday.split(":");
				    hh = time_array[0];
				    if(parseInt(hh) > 0){
				    	jQuery('#tabs .sunday a').addClass('yellow-day');
				    }else{
				    	jQuery('#tabs .sunday a').removeClass('yellow-day');
				    }


				    //Remove status color if dates are in future.

				    var d = new Date();
					var curr_date = d.getDate();
					var curr_month = d.getMonth();
					var curr_year = d.getFullYear();
					curr_month = (curr_month < 10? '0' : '') + curr_month;
					var today_date = new Date(curr_year, curr_month, curr_date);

					var monday_string = jQuery('#monday .tab_date').val().split("/");
					var monday_date = new Date(monday_string[2], monday_string[1] - 1, monday_string[0]);

				    var tuesday_string = jQuery('#tuesday .tab_date').val().split("/");
				    var tuesday_date = new Date(tuesday_string[2], tuesday_string[1] - 1, tuesday_string[0]);

				    var wednesday_string = jQuery('#wednesday .tab_date').val().split("/");
				    var wednesday_date = new Date(wednesday_string[2], wednesday_string[1] - 1, wednesday_string[0]);

				    var thursday_string = jQuery('#thursday .tab_date').val().split("/");
				    var thursday_date = new Date(thursday_string[2], thursday_string[1] - 1, thursday_string[0]);

				    var friday_string = jQuery('#friday .tab_date').val().split("/");
				    var friday_date = new Date(friday_string[2], friday_string[1] - 1, friday_string[0]);

				    var saturday_string = jQuery('#saturday .tab_date').val().split("/");
				    var saturday_date = new Date(saturday_string[2], saturday_string[1] - 1, saturday_string[0]);

				    var sunday_string = jQuery('#sunday .tab_date').val().split("/");
					var sunday_date = new Date(sunday_string[2], sunday_string[1] - 1, sunday_string[0]);

				    if(today_date <= monday_date){
				    	jQuery('#tabs .monday a').removeClass('green-day red-day');
				    }

				    if(today_date <= tuesday_date){
				    	jQuery('#tabs .tuesday a').removeClass('green-day red-day');
				    }
				    if(today_date <= wednesday_date){
				    	jQuery('#tabs .wednesday a').removeClass('green-day red-day');
				    }

				    if(today_date <= thursday_date){
				    	jQuery('#tabs .thursday a').removeClass('green-day red-day');
				    }

				    if(today_date <= friday_date){
				    	jQuery('#tabs .friday a').removeClass('green-day red-day');
				    }	

				    if(today_date <= saturday_date){
				    	jQuery('#tabs .saturday a').removeClass('yellow-day');
				    }

				    if(today_date <= sunday_date){
				    	jQuery('#tabs .sunday a').removeClass('yellow-day');
				    }

					jQuery.each(parsed, function(index, value){
	
						if(value){
							if(value.day_now){
								var day = value.day_now.toLowerCase();				

								if(day == 'monday'){
									day_sort(value, 'monday', check_same_user);

									jQuery('div#monday .total_hours .task_total_hour h3').html(total_hour_monday);

									//Check Day Status Color
									// if (total_hour_monday.indexOf(":") != -1) {
									// }

								}


								if(day == 'tuesday'){

									day_sort(value, 'tuesday', check_same_user);

									jQuery('div#tuesday .total_hours .task_total_hour h3').html(total_hour_tuesday);

									//Check Day Status Color
									// console.log(total_hour_tuesday);
									// if (total_hour_tuesday.indexOf(":") != -1) {
									// }

								}

								if(day == 'wednesday'){
									day_sort(value, 'wednesday', check_same_user);
									jQuery('div#wednesday .total_hours .task_total_hour h3').html(total_hour_wednesday);

									//Check Day Status Color
									// if (total_hour_wednesday.indexOf(":") != -1) {

									// }

								}

								if(day == 'thursday'){

									day_sort(value, 'thursday', check_same_user);

									jQuery('div#thursday .total_hours .task_total_hour h3').html(total_hour_thursday);

									//Check Day Status Color
									// if (total_hour_thursday.indexOf(":") != -1) {

									// }
								}

								if(day == 'friday'){

									day_sort(value, 'friday', check_same_user);

									jQuery('div#friday .total_hours .task_total_hour h3').html(total_hour_friday);

									//Check Day Status Color
									// if (total_hour_friday.indexOf(":") != -1) {

									// }

								}

								if(day == 'saturday'){

									day_sort(value, 'saturday', check_same_user);

									jQuery('div#saturday .total_hours .task_total_hour h3').html(total_hour_saturday);

									//Check Day Status Color
									// if (total_hour_saturday.indexOf(":") != -1) {

									// }

								}

								if(day == 'sunday'){

									day_sort(value, 'sunday', check_same_user);

									jQuery('div#sunday .total_hours .task_total_hour h3').html(total_hour_sunday);

									//Check Day Status Color
									// if (total_hour_sunday.indexOf(":") != -1) {

									// }

								}

							}

						}

						jQuery('.month_name').html(month_name +" - "+ year_name);

					

						jQuery('.total_month_hour').html(rounded_total_month_hour);

						

						if(rounded_total_month_hour < '176'){

							jQuery('.total_month_hour').addClass('text_red');

							var hour_balance_decimal = (176 - rounded_total_month_hour).toFixed(2);

						}else if(rounded_total_month_hour > '176'){

							jQuery('.total_month_hour').addClass('text_green');

						}else if(rounded_total_month_hour = '176'){

							jQuery('.total_month_hour').addClass('text_black');

						}

						jQuery('.total_holiday_hour').html(total_holiday_hour);

						

						jQuery('.month_stat .hour_balance').removeClass("text_red text_green");

						if(worked_hours  > total_hours_worked){

							jQuery('.month_stat .hour_balance').addClass("text_red");

						}else{

							jQuery('.month_stat .hour_balance').addClass("text_green");

						}						

						jQuery('.month_stat .worked_hours').html(worked_hours);

						jQuery('.month_stat .total_hours_worked').html(total_hours_worked);

						jQuery('.month_stat .hour_balance').html(hour_balance);

						jQuery('.month_stat .holiday_hours').html(holiday_hours);

						jQuery('.month_stat .holiday_balance').html(total_holiday_work);

						//jQuery('.month_summary').show();

					});

					trigger_accordion_toggle();

				},

				error: function (data) {

					

				}

			});

		


			
}

//Editing hour and description records.
jQuery(document).on('click', '.tabs_li', function(){
	jQuery('.tab_content.active .new_entry_hours_1 input').focus();
	var day_selected = parseInt(jQuery(this).find('.day_date').text().match(/\d+/));
	jQuery('.ui-state-default').removeClass('ui-state-active');
	jQuery('.ui-state-default').each(function() {
	    var calendary_day = parseInt(jQuery(this).text());
	    if(day_selected == calendary_day){
	    	jQuery(this).addClass('ui-state-active');
	    }
	});
	var date = jQuery(this).find('.day_date').text();
	var full_day_name = jQuery('.tab_content.active').attr('id');
	jQuery('.week_section h3 span.header_day_date').text(full_day_name.capitalize()+ " " +date);

});


//Editing hour and description records.
jQuery(document).on('dblclick', '.tab_content.active .edit_column_field', function(){

	var string = jQuery(this).attr('id').split("_");

	jQuery(this).removeClass('edit_column_field');

	var id = string[3];
	var type = string[1];
	var negative_string = "";
	var decimal = 0;
	if(type == 'hour'){
		var value = jQuery(this).html().trim();
		jQuery(this).html('<input type="text" value="'+value+'" id="'+type+'_update_field_'+id+'"><div class="check_update_timesheet" id="'+type+'_button_'+id+'"></div><div class="row-update-loader" id="'+type+'_loader_'+id+'" style="display: none;"></div>');
	}else if(type == 'description'){
		var value = jQuery('#timesheet_description_id_'+id).text().trim();
		jQuery('#toggle_description_id_'+id).html('<input type="text" value="'+value+'" id="'+type+'_update_field_'+id+'"><div class="check_update_timesheet" id="'+type+'_button_'+id+'"></div><div class="row-update-loader" id="'+type+'_loader_'+id+'" style="display: none;"></div>');
	}else if(type == 'orderno'){
		var value = jQuery(this).html().trim();
		jQuery(this).html('<input type="text" value="'+value+'" id="'+type+'_update_field_'+id+'"><div class="check_update_timesheet" id="'+type+'_button_'+id+'"></div><div class="row-update-loader" id="'+type+'_loader_'+id+'" style="display: none;"></div>');
	}else if(type == 'kilometer'){
		var value = jQuery(this).html().trim();
		jQuery(this).html('<input type="text" value="'+value+'" id="'+type+'_update_field_'+id+'"><div class="check_update_timesheet" id="'+type+'_button_'+id+'"></div><div class="row-update-loader" id="'+type+'_loader_'+id+'" style="display: none;"></div>');
	}

});

//Update Button when editing a column.
jQuery(document).on('click', '.tab_content.active .check_update_timesheet', function(){
	var this_button = jQuery(this);
	var string = jQuery(this).attr('id').split("_");
	var active_day = jQuery('.tab_content.active').attr('id');
	var id = string[2];
	var type = string[0];
	var total_hours = '00:00';
	var negative_string = "";
	var value = "";
	var input = jQuery('.tab_content.active #'+type+'_update_field_'+id).val();
	var taskname = jQuery('.tab_content.active .person_task_timesheet #taskname_id_'+id).text();
	var update_value = "";
	if(type == 'hour'){
		var validation_hour = input_time_validation(input, taskname);
		if(validation_hour.taskname_validation == false){
			jQuery(".status_message").fadeIn( "slow", function() {
				jQuery(".status_message p").html("<p class='error-msg'>Only <b>Tidbank</b> task accept negative value.</p>");
			});
			jQuery(".status_message").delay(1000).fadeOut('slow');
			jQuery('#save-loader').css('visibility', 'hidden');	 	
			this_button.show().next('.loader-save-entry').hide();	
	 		return false;		
		} 
		if(validation_hour.input_time_format_validation == false){
			jQuery(".status_message").fadeIn( "slow", function() {
				jQuery(".status_message p").html("<p class='error-msg'>Invalid Time Format.</p>");
			});
			jQuery(".status_message").delay(1000).fadeOut('slow');
			jQuery('#save-loader').css('visibility', 'hidden');	 	
			this_button.show().next('.loader-save-entry').hide();	
	 		return false;
		}
		update_value = validation_hour.hour;	
	}else{
		update_value = input;
	}

	var current_hour = jQuery('#'+active_day+' .total_hours .task_total_hour h3').text();

	jQuery('#'+type+'_button_'+id).hide().remove();
	jQuery('#'+type+'_loader_'+id).css('display', 'inline-block');


	var update_entries = {
		input_type: type,
		input_id: id,
		input_value: update_value
	};

	jQuery.ajax({

			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

			data:{
				'type' : 'update_record_column_timesheet',
				'update_entries_values' : update_entries
			},
			success: function (data) {				
				var parsed = jQuery.parseJSON(data);
				console.log(parsed);

				if(parsed.type == 'task_hour'){
					jQuery('#timesheet_'+type+'_id_'+id).addClass('edit_column_field').html(parsed.value);
					jQuery('#'+type+'_loader_'+id).hide().remove();

					jQuery('#'+active_day+' .task_hour li.data_list_'+active_day).each(function(){
						var value = jQuery(this).html();
						total_hours = addTime(total_hours, value);
					});

					jQuery('#'+active_day+'.tab_content .total_hours .task_total_hour h3').text(total_hours);
					jQuery('<div class="info_help" id="edited_data_'+id+'"></div><p class="edit_note" style="display: none;" id="edited_note_id_'+id+'">Edited By: '+parsed.edited_by+' </p>').insertAfter('.task-complete #delete_loader_'+id);
					jQuery('.action_message p').text("Hour Updated.");
					jQuery('.action_message').fadeIn( "slow", function() {
						jQuery(".action_message").delay(1000).fadeOut('slow');
					});
				}else if(parsed.type == 'task_description'){
					if(parsed.value >= 24){
						var short_description = jQuery.trim(parsed.value).substring(0, 24).split(" ").slice(0, -1).join(" ") + "...";
					}else{
						var short_description = parsed.value +"...";
					}	

					jQuery('#toggle_description_id_'+id).addClass('edit_column_field').html('<li class="data_list_'+active_day+' timesheet_data_id_'+id+' description_data_id_'+id+'">'+short_description+'<span class="arrow"></span></li>');
					jQuery('#timesheet_description_id_'+id).text(parsed.value);
					trigger_accordion_toggle();
					jQuery('.action_message p').text("Description Updated.");
					jQuery('.action_message').fadeIn( "slow", function() {
						jQuery(".action_message").delay(1000).fadeOut('slow');
					});
					jQuery('#'+type+'_loader_'+id).hide().remove();			
					jQuery('<div class="info_help" id="edited_data_'+id+'"></div><p class="edit_note" style="display: none;" id="edited_note_id_'+id+'">Edited By: '+parsed.edited_by+' </p>').insertAfter('.task-complete #delete_loader_'+id);
				}else if(parsed.type == 'orderno'){
					jQuery('#timesheet_'+type+'_id_'+id).addClass('edit_column_field').html(parsed.value);
					jQuery('#'+type+'_loader_'+id).hide().remove();

					jQuery('<div class="info_help" id="edited_data_'+id+'"></div><p class="edit_note" style="display: none;" id="edited_note_id_'+id+'">Edited By: '+parsed.edited_by+' </p>').insertAfter('.task-complete #delete_loader_'+id);
					jQuery('.action_message p').text("Order No. Updated.");
					jQuery('.action_message').fadeIn( "slow", function() {
						jQuery(".action_message").delay(1000).fadeOut('slow');
					});
				}else if(parsed.type == 'km'){
					jQuery('#timesheet_'+type+'_id_'+id).addClass('edit_column_field').html(parsed.value);
					jQuery('#'+type+'_loader_'+id).hide().remove();

					jQuery('<div class="info_help" id="edited_data_'+id+'"></div><p class="edit_note" style="display: none;" id="edited_note_id_'+id+'">Edited By: '+parsed.edited_by+' </p>').insertAfter('.task-complete #delete_loader_'+id);
					jQuery('.action_message p').text("Kilometer Updated.");
					jQuery('.action_message').fadeIn( "slow", function() {
						jQuery(".action_message").delay(1000).fadeOut('slow');
					});
				}

				if(parsed.side_panel_total_hours_tidbank_class == "red_text"){
					jQuery('.month_details .hour_tidbank').addClass('text_red');
				}else{
					jQuery('.month_details .hour_tidbank').removeClass('text_red');
				}	

				//Side Panel Info Update
				jQuery('.month_details .worked_hours').text(parsed.side_panel_total_workable_hours);
				jQuery('.month_details .hour_balance').text(parsed.side_panel_total_hour_balance);
				jQuery('.month_details .total_hours_worked').text(parsed.side_panel_total_worked_hours);
				jQuery('.month_details .hour_vacation').text(parsed.side_panel_total_semester);
				jQuery('.month_details .hour_vacation').text(parsed.side_panel_total_semester);
				jQuery('.month_details .holiday_hours').text(parsed.side_panel_total_helg);
				jQuery('.month_details .hour_ledig').text(parsed.side_panel_total_ledig);
				jQuery('.month_details .hour_sjuk').text(parsed.side_panel_total_sjuk);
				jQuery('.month_details .hour_tidbank').text(parsed.side_panel_total_hours_tidbank);
				
				if(parsed.side_panel_total_hour_balance_color == 'green'){
					jQuery('.month_details .hour_balance ').removeClass('text_red').addClass('text_green');
				}else{
					jQuery('.month_details .hour_balance ').removeClass('text_green').addClass('text_red');
				}

			},

			error: function (data) {
				alert('error');
			}				

	});


});
//Editing Column task name for dropdown
jQuery(document).on('dblclick', '.tab_content.active .edit_taskname_record', function(){
	var string = jQuery(this).attr('id').split("_");
	var column_id = string[2];
	var client = jQuery('#client_list_'+string[2]).html();
	var taskname = jQuery('#taskname_id_'+column_id).text();
	jQuery('#taskname_loader_'+column_id).css('display', 'inline-block');

	var entry = {
		client_name : client,
		id : column_id,
		taskname_current_selected : taskname
	};

	jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

			data:{
				'type' : 'edit_taskname_timesheet',
				'edit_taskname_entry' : entry
			},
			success: function (data) {				
				var parsed = jQuery.parseJSON(data);
				jQuery('#taskname_id_'+column_id).html(parsed.option_dropdown);
				jQuery('#taskname_loader_'+column_id).css('display', 'none');
			},

			error: function (data) {
				alert('error');
			}				

	});	

});


//Editing Column project name for dropdown
jQuery(document).on('dblclick', '.tab_content.active .edit_project_record', function(){
	var string = jQuery(this).attr('id').split("_");
	var column_id = string[2];
	var client = jQuery('#client_list_'+string[2]).html();
	var project_name = jQuery('#project_id_'+column_id).text();
	jQuery('#project_loader_'+column_id).css('display', 'inline-block');

	var entry = {
		client_name : client,
		id : column_id,
		project_current_selected : project_name
	};

	jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

			data:{
				'type' : 'edit_project_timesheet',
				'edit_project_entry' : entry
			},
			success: function (data) {				
				var parsed = jQuery.parseJSON(data);
				jQuery('#project_id_'+column_id).html(parsed.option_dropdown);
				jQuery('#project_loader_'+column_id).css('display', 'none');
			},

			error: function (data) {
				alert('error');
			}				

	});	

});

// Submit editing task name to save on DB
jQuery(document).on('click', '.tab_content.active .check_update_timesheet_taskname', function(){
	var string = jQuery(this).attr('id').split("_");
	var this_button = jQuery(this);
	var id = string[2];
	var select_value = jQuery('#taskname_id_'+id+' select').val();
	this_button.hide();
	jQuery('#taskname_loader_'+id).css('display', 'inline-block');
	var hour = jQuery('#timesheet_hour_id_'+id).text();

	if(select_value != 'Tidbank'){
		if (hour.indexOf('-') > -1){
				jQuery(".status_message").fadeIn( "slow", function() {
					jQuery(".status_message p").html("<p class='error-msg'>Only <b>Tidbank</b> task accept negative value.</p>");
				});
				jQuery(".status_message").delay(1000).fadeOut('slow');
				jQuery('#taskname_loader_'+id).hide();	
				this_button.show();
		 		return false;	
		}		
	}

	var taskname_edit_entry = {
		taskname_id: id,
		taskname: select_value
	}

	jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

			data:{
				'type' : 'save_editing_taskname_to_db',
				'taskname_editing_value' : taskname_edit_entry
			},
			success: function (data) {				
				var parsed = jQuery.parseJSON(data);
				console.log(parsed);
				if(parsed.status == 'success-update-timesheet'){
					

					jQuery('.month_details .total_hours_worked').text(parsed.side_panel_total_worked_hours);
					jQuery('.month_details .hour_balance').text(parsed.side_panel_total_hour_balance);
					jQuery('.month_details .hour_tidbank').text(parsed.side_panel_total_hours_tidbank);
					jQuery('.month_details .hour_vacation').text(parsed.side_panel_total_semester);
					jQuery('.month_details .hour_ledig').text(parsed.side_panel_total_ledig);
					jQuery('.month_details .hour_sjuk').text(parsed.side_panel_total_sjuk);
					jQuery('.month_details .holiday_hours').text(parsed.side_panel_total_helg);
					jQuery('.header_person_name .total_dwork').text(parsed.person_dwork_percent);
					
					if(parsed.side_panel_total_hours_tidbank_class == 'red_text'){
						jQuery('.month_details .hour_tidbank').removeClass('text_green').addClass('text_red');
					}else{
						jQuery('.month_details .hour_tidbank').removeClass('text_red').addClass('text_green');
					}
					if(parsed.side_panel_total_hour_balance_color == 'red'){
						jQuery('.month_details .hour_balance').removeClass('text_green').addClass('text_red');
					}else{
						jQuery('.month_details .hour_balance').removeClass('text_red').addClass('text_green');
					}

					jQuery('#taskname_id_'+parsed.taskname_id).html(parsed.taskname_name);
					jQuery('#taskname_loader_'+parsed.taskname_id).css('display', 'none');
					jQuery('.action_message p').text("Taskname Updated.");
					jQuery('<div class="info_help" id="edited_data_'+id+'"></div><p class="edit_note" style="display: none;" id="edited_note_id_'+id+'">Edited By: '+parsed.edited_by+' </p>').insertAfter('.task-complete #delete_loader_'+id);
					jQuery('.action_message').fadeIn( "slow", function() {
						jQuery(".action_message").delay(1000).fadeOut('slow');
					});

				}else{

				}
			},

			error: function (data) {
				alert('error');
			}				

	});	

});




// Submit editing project name to save on DB
jQuery(document).on('click', '.tab_content.active .check_update_timesheet_project', function(){
	var string = jQuery(this).attr('id').split("_");
	var id = string[2];
	var select_value = jQuery('#project_id_'+id+' select').val();
	jQuery(this).remove();
	jQuery('#project_loader_'+id).css('display', 'inline-block');

	var project_edit_entry = {
		project_id: id,
		project_name: select_value
	}

	jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

			data:{
				'type' : 'save_editing_project_to_db',
				'project_editing_value' : project_edit_entry
			},
			success: function (data) {				
				var parsed = jQuery.parseJSON(data);
				if(parsed.status == 'success-update-timesheet'){
					jQuery('#project_id_'+parsed.project_id).html(parsed.project_name);
					jQuery('#project_loader_'+parsed.project_id).css('display', 'none');
					jQuery('.action_message p').text("Project Updated.");
					jQuery('<div class="info_help" id="edited_data_'+id+'"></div><p class="edit_note" style="display: none;" id="edited_note_id_'+id+'">Edited By: '+parsed.edited_by+' </p>').insertAfter('.task-complete #delete_loader_'+id);
					jQuery('.action_message').fadeIn( "slow", function() {
						jQuery(".action_message").delay(1000).fadeOut('slow');

					});

				}else{

				}
			},

			error: function (data) {
				alert('error');
			}				

	});	

});

function UpdateTotalTime(day, hour){
	var current_hour = jQuery('#'+day+' .total_hours .task_total_hour h3').text();

	var total_update_hours = formatTime(timestrToSec(current_hour+':00') + timestrToSec( hour+':00'));
	var numbersArray = total_update_hours.split(':');
	jQuery('#'+day+' .total_hours .task_total_hour h3').text(numbersArray[0] +':'+ numbersArray[1]);
}

function toSeconds( time ) {
    var parts = time.split(':');
    return (+parts[0]) * 60 * 60 + (+parts[1]) * 60 + (+parts[2]); 
}

function toHHMMSS(sec) {
    var sec_num = parseInt(sec, 10); // don't forget the second parm
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    var time    = hours+':'+minutes+':'+seconds;
    return time;
}

function timeInHours(str)
{
   var sp = str.split(":");
   return sp[0] + sp[1]/60;
}

function hoursToString(h)
{
   var hours = floor(h);
   var minutes = (h - hours)*60;

   return hours + ":" + minutes;
}


//Add All total hours
function AddTotalHours(){

}

//Add all task hour when update a row.
function addTime(){


    if (arguments.length < 2)
    {
        if (arguments.length == 1 && isFormattedDate(arguments[0])) return arguments[0];
        else return false;
    }
    
    var time1Split, time2Split, totalHours, totalMinutes;
    if (isFormattedDate(arguments[0])) var totalTime = arguments[0];
    else return false;
    
    for (var i = 1; i < arguments.length; i++)
    {
        // Add them up
        time1Split = totalTime.split(':');
        time2Split = arguments[i].split(':');

        totalHours = parseInt(time1Split[0]) + parseInt(time2Split[0]);
        totalMinutes = parseInt(time1Split[1]) + parseInt(time2Split[1]);

        // If total minutes is more than 59, then convert to hours and minutes
        if (totalMinutes > 59)
        {
            totalHours += Math.floor(totalMinutes / 60);
            totalMinutes = totalMinutes % 60;
        }

        totalTime = padWithZeros(totalHours) + ':' + padWithZeros(totalMinutes);
    }
    
    return totalTime;
}

function isFormattedDate(date)
{
    var splitDate = date.split(':');
    if (splitDate.length == 2 && (parseInt(splitDate[0]) + '').length <= 2 && (parseInt(splitDate[1]) + '').length <= 2) return true;
    else return false;
}

function padWithZeros(number)
{
    var lengthOfNumber = (parseInt(number) + '').length;
    if (lengthOfNumber == 2) return number;
    else if (lengthOfNumber == 1) return '0' + number;
    else if (lengthOfNumber == 0) return '00';
    else return false;
}
function timesheet_format(str) {
    if ( !/:/.test( str ) ) { str += ':00'; }
    return str.replace(/^\d{1}:/, '0$&').replace(/:\d{1}$/, '$&0' );
}
function convertToHHMM(info) {
  var hrs = parseInt(Number(info));
  var min = Math.round((Number(info)-hrs) * 60);
  if(min <= 9){
  	var mins = '0'+min;
  }else{
  	var	mins = min;
  }
  if(hrs <= 9){
  	return '0'+hrs+':'+mins;
  }else{
  	return hrs+':'+mins;
  }
 
}
/* CHANGE FORMAT */
function change_date_format(date, format){
	var split_date  = date.split("/");
	var day = split_date[0];
	var month = split_date[1];
	var year = split_date[2];
	switch(month){
		case "01":
			month_name = 'Jan';
		break;
		case "02":
			month_name = 'Feb';
		break;
		case "03":
			month_name = 'Mar';
		break;
		case "04":
			month_name = 'Apr';
		break;
		case "05":
			month_name = 'May';
		break;
		case "06":
			month_name = 'Jun';
		break;
		case "07":
			month_name = 'Jul';
		break;
		case "08":
			month_name = 'Aug';
		break;	
		case "09":
			month_name = 'Sept';
		break;	
		case "10":
			month_name = 'Oct';
		break;	
		case "11":
			month_name = 'Nov';
		break;	
		case "12":
			month_name = 'Dec';
		break;	
	}
	
	switch(month){
		case "01":
			full_month_name = 'January';
		break;
		case "02":
			full_month_name = 'February';
		break;
		case "03":
			full_month_name = 'March';
		break;
		case "04":
			full_month_name = 'April';
		break;
		case "05":
			full_month_name = 'May';
		break;
		case "06":
			full_month_name = 'June';
		break;
		case "07":
			full_month_name = 'July';
		break;
		case "08":
			full_month_name = 'August';
		break;	
		case "09":
			full_month_name = 'September';
		break;	
		case "10":
			full_month_name = 'October';
		break;	
		case "11":
			full_month_name = 'November';
		break;	
		case "12":
			full_month_name = 'Decemeber';
		break;	
	}
	
	if(format == "yyyy/mm/dd"){
		date_format = year +"/"+ month +"/"+ day;
	}
	
	if(format == "yyyy/M/dd"){
		date_format = year +" "+ month_name +" "+ day;
	}
	
	if(format == "dd/M"){
		date_format = day +" "+ month_name;
	}
	
	if(format == "dd/M/Y"){
		date_format = day +" "+ month_name +" "+ year;
	}
	
	if(format == "dd/mm/yyyy"){
		date_format = day +"/"+ month +"/"+ year;
	}
	
	if(format == "m"){
		date_format = month_name;
	}
	
	if(format == "yyyy-month-dd"){
		date_format = year +'-'+ month +'-'+ day;		
	}
	
	if(format == "full_date"){
		date_format = full_month_name +' '+ day +', '+ year;		
	}
	
	return date_format;
}

function get_month_name(month_number, leading_zero){
	if(leading_zero == 'true'){
		switch(month_number){
			case "01":
			month_name = 'Jan';
			break;
			case "02":
			month_name = 'Feb';
			break;
			case "03":
			month_name = 'Mar';
			break;
			case "04":
			month_name = 'Apr';
			break;
			case "05":
			month_name = 'May';
			break;
			case "06":
			month_name = 'Jun';
			break;
			case "07":
			month_name = 'Jul';
			break;
			case "08":
			month_name = 'Aug';
			break;	
			case "09":
			month_name = 'Sept';
			break;	
			case "10":
			month_name = 'Oct';
			break;	
			case "11":
			month_name = 'Nov';
			break;	
			case "12":
			month_name = 'Dec';
			break;	
		}	
	}
	
	if(leading_zero == 'false'){
		switch(month_number){
			case "1":
			month_name = 'Jan';
			break;
			case "2":
			month_name = 'Feb';
			break;
			case "3":
			month_name = 'Mar';
			break;
			case "4":
			month_name = 'Apr';
			break;
			case "5":
			month_name = 'May';
			break;
			case "6":
			month_name = 'Jun';
			break;
			case "7":
			month_name = 'Jul';
			break;
			case "8":
			month_name = 'Aug';
			break;	
			case "9":
			month_name = 'Sept';
			break;	
			case "10":
			month_name = 'Oct';
			break;	
			case "11":
			month_name = 'Nov';
			break;	
			case "12":
			month_name = 'Dec';
			break;	
		}	
	}
	
	return month_name;
}
function datepicker_month_number(month){
	switch(month){
		case "0":
		month_number = '01';
		break;
		case "1":
		month_number = '02';
		break;
		case "2":
		month_number = '03';
		break;
		case "3":
		month_number = '04';
		break;
		case "4":
		month_number = '05';
		break;
		case "5":
		month_number = '06';
		break;
		case "6":
		month_number = '07';
		break;
		case "7":
		month_number = '08';
		break;	
		case "8":
		month_number = '09';
		break;	
		case "9":
		month_number = '10';
		break;	
		case "10":
		month_number = '11';
		break;	
		case "11":
		month_number = '12';
		break;	
	}
	return month_number;
}
function new_date_format (dateObject) {
	var d = new Date(dateObject);
	var day = d.getDate();
	var month = d.getMonth() + 1;
	var year = d.getFullYear();
	if (day < 10) {
		day = "0" + day;
	}
	if (month < 10) {
		month = "0" + month;
	}
	var date = day + "/" + month + "/" + year;
	
	return date;
}
/* END CHANGE FORMAT */
/* GET FIRST DAY FROM WEEK */
function writeDays(myYear, myWeek){
	var days = getDays(myYear , myWeek);
	var strDays= [];
	for (var i in days) {
		strDays.push(new Date(days[i]));
	}
	return strDays;
}

function getDays(year, week) {
	var j10 = new Date(year, 0, 10, 12, 0, 0),
	j4 = new Date(year, 0, 4, 12, 0, 0),
	mon = j4.getTime() - (j10.getDay()-1) * 86400000,
	result = [];
	
	for (var i = -1; i < 6; i++) {
		result.push(new Date(mon + ((week - 1) * 7 + i) * 86400000));
	}
	
	return result;
}

function get_date_range( d1, d2 ){
	var oneDay = 24*3600*1000;
	for (var d=[],ms=d1*1,last=d2*1;ms<last;ms+=oneDay){
		d.push( new Date(ms) );
	}
	return d;
}
/* END FIRST DAY FROM WEEK */

/* TOTAL WEEK IN A YEAR */
function getWeekNumber(d) {
	d = new Date(+d);
	d.setHours(0,0,0);
	d.setDate(d.getDate() + 4 - (d.getDay()||7));
	var yearStart = new Date(d.getFullYear(),0,1);
	var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7)
	return [d.getFullYear(), weekNo];
}

function weeksInYear(year) {
	var month = 11, day = 31, week;
	do {
		d = new Date(year, month, day--);
		week = getWeekNumber(d)[1];
	} while (week == 1);
	
	return week;
}
/* END TOTAL WEEK IN A YEAR */

/* FORMAT TASK NAME */
function isUpperCase(str) {
	return str === str.toUpperCase();
}
function format_task_name(task_name){
	var task_name_split = task_name.split(' ');
	var task_name_array = [];
	jQuery.each(task_name_split, function(index, task_names){
		if(task_names != 'SEO'){
			if(isUpperCase){
				task_names = task_names.toLowerCase().replace(/\b[a-z]/g, function(letter) {
					return letter.toUpperCase();
				});
			}
		}
		task_name_array.push(task_names);
	});
	task_name = task_name_array.join(' ');	
	return task_name;
}
/* END FORMAT TASK NAME */
function tConv24(time24) {
  var ts = time24;
  var H = +ts.substr(0, 2);
  var h = (H % 12) || 12;
  h = (h < 10)?("0"+h):h;  // leading 0 at the left for 1 digit hours
  var ampm = H < 12 ? " AM" : " PM";
  ts = h + ts.substr(2, 3) + ampm;
  return ts;
};
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}
function timeStringToFloat(time) {
  var hoursMinutes = time.split(/[.:]/);
  var hours = parseInt(hoursMinutes[0], 10);
  var minutes = hoursMinutes[1] ? parseInt(hoursMinutes[1], 10) : 0;
  return hours + minutes / 60;
}
function deciHours(time) {
    return (function(i) {return i+(Math.round(((time-i)*60),10)/100);})(parseInt(time, 10));
}
function input_time_validation(value, taskname){
	//FALSE is invalid value.
	var response = {};
	if (value.indexOf(',') > -1){
		value = value.replace(',','.');
	}
	var regexp = /^(([0|1][0-9])|([2][0-3])):([0-5][0-9])$/;
	if(jQuery.isNumeric( value )){ //If Decimal format
		if ((new Number(value) < 0)){ //If decimal is negative value
			if(taskname != 'Tidbank'){ //If taskname is not Tidbank
				return response = {
					'taskname_validation' : false,
					'input_time_format_validation' : '',
					'hour' : ''
				}
			}else{
				value = value.replace(/-/g ,'');//removed - sign to convert hour
				hour_format = convertToHHMM(value); //Convert Decimal to hour Format
				return response = {
					'taskname_validation' : true,
					'input_time_format_validation' : true,
					'hour' : "-"+hour_format
				}				
			}
		}else{
			hour_format = convertToHHMM(value); //Convert Decimal to hour Format
			return response = {
				'taskname_validation' : true,
				'input_time_format_validation' : true,
				'hour' : hour_format
			}	
		}
	}else{ //If Hour format
		if (value.indexOf('-') > -1){ //If negative Hour format
			if(taskname != 'Tidbank'){
				return response = {
					'taskname_validation' : false,
					'input_time_format_validation' : '',
					'hour' : ''
				}
			}else{
				value = value.replace(/-/g ,''); //removed - sign to convert hour
				var validate_time_format = (value.search(regexp) >= 0) ? true : false;
				if(validate_time_format == false){
					if(value.length == 4){
						var hour = value.charAt(0)
						value = value.replace(hour+':','');
						var new_hour_format = '0'+hour+':'+value;
						var validate_time_format_2 = (new_hour_format.search(regexp) >= 0) ? true : false;
						if(validate_time_format_2 == true){
							return response = {
								'taskname_validation' : true,
								'input_time_format_validation' : true,
								'hour' : '-'+new_hour_format
							}	
						}else{
							return response = {
								'taskname_validation' : true,
								'input_time_format_validation' : false,
								'hour' : ''
							}	
						}
					}else{
						return response = {
							'taskname_validation' : true,
							'input_time_format_validation' : false,
							'hour' : ''
						}							
					}		
				}else{
					return response = {
						'taskname_validation' : true,
						'input_time_format_validation' : true,
						'hour' : "-"+value
					}					
				}
			}
		}else{
			var validate_time_format = (value.search(regexp) >= 0) ? true : false;
			if(validate_time_format == false){ //validate time format
				if(value.length == 4){
					var hour = value.charAt(0)
					value = value.replace(hour+':','');
					var new_hour_format = '0'+hour+':'+value;
					var validate_time_format_2 = (new_hour_format.search(regexp) >= 0) ? true : false;
					if(validate_time_format_2 == true){
						return response = {
							'taskname_validation' : true,
							'input_time_format_validation' : true,
							'hour' : new_hour_format
						}	
					}else{
						return response = {
							'taskname_validation' : true,
							'input_time_format_validation' : false,
							'hour' : ''
						}	
					}
				}else{
					return response = {
						'taskname_validation' : true,
						'input_time_format_validation' : false,
						'hour' : ""
					}					
				}
				
			}else{
				return response = {
					'taskname_validation' : true,
					'input_time_format_validation' : true,
					'hour' : value.replace(/[^0-9\:]/g,'')
				}					
			}
		}
	}
}
</script>