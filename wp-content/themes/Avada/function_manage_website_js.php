<script>
/* ==================================== SORT ==================================== */
/* CLIENT SORT */
function get_client_sort_details(sort_type){
	jQuery('.website_client_sort_loader').show();
	var website_sort_details = [];
	jQuery('.tab_content.active .info_div').each(function(){
		var div_classes = jQuery(this).attr('class');
		var div_classes_split = div_classes.split(' ');	
		var website_class = div_classes_split[0];
		var website_id_split = website_class.split('_');
		var website_id = website_id_split[1];
		
		var site_url = jQuery(this).find(".first_column").text();
		var client_name = jQuery(this).find(".second_column").text();
		var site_type = jQuery(this).find(".third_column").text();
		var site_platform = jQuery(this).find(".fourth_column").text();
		var wp_ver = jQuery(this).find(".fifth_column").text();
		var theme = jQuery(this).find(".sixth_column").text();
		var th_ver = jQuery(this).find(".seventh_column").text();
		var hosting = jQuery(this).find(".eighth_column").text();
		var registrar = jQuery(this).find(".ninth_column").text();
		var website_login = jQuery(this).find(".tenth_column .website_login_button").attr('href');
		
		website_sort_details.push(client_name +"|join|"+ 
			website_id +"|join|"+ 
			site_url +"|join|"+ 
			site_type +"|join|"+ 
			site_platform +"|join|"+ 
			wp_ver +"|join|"+ 
			theme +"|join|"+ 
			th_ver +"|join|"+ 
			hosting +"|join|"+ 
			registrar +"|join|"+ 
			website_login +"|join|"+ 
			sort_type +"|join|"+ 
			'websites' +"|join|"+ 
			'client_sort'
		);
	});
	website_sort_details.push({'sort_type': sort_type, 'tab_name': 'websites', 'sort_name': 'client_sort'});
	website_sort(website_sort_details);
}
jQuery(document).on('click','.website_client_sort_asc',function(){
	get_client_sort_details('asc');
});

jQuery(document).on('click','.website_client_sort_desc',function(){
	get_client_sort_details('desc');
});
/* END CLIENT SORT */

/* SITE TYPE SORT */
function get_site_type_sort_details(sort_type){
	jQuery('.website_type_sort_loader').show();
	var website_sort_details = [];
	jQuery('.tab_content.active .info_div').each(function(){
		var div_classes = jQuery(this).attr('class');
		var div_classes_split = div_classes.split(' ');	
		var website_class = div_classes_split[0];
		var website_id_split = website_class.split('_');
		var website_id = website_id_split[1];
		
		var site_url = jQuery(this).find(".first_column").text();
		var client_name = jQuery(this).find(".second_column").text();
		var site_type = jQuery(this).find(".third_column").text();
		var site_platform = jQuery(this).find(".fourth_column").text();
		var wp_ver = jQuery(this).find(".fifth_column").text();
		var theme = jQuery(this).find(".sixth_column").text();
		var th_ver = jQuery(this).find(".seventh_column").text();
		var hosting = jQuery(this).find(".eighth_column").text();
		var registrar = jQuery(this).find(".ninth_column").text();
		var website_login = jQuery(this).find(".tenth_column .website_login_button").attr('href');
		
		website_sort_details.push(site_type +"|join|"+
		client_name +"|join|"+ 
		website_id +"|join|"+ 			
		site_url +"|join|"+ 			
		site_platform +"|join|"+ 
		wp_ver +"|join|"+ 
		theme +"|join|"+ 
		th_ver +"|join|"+ 
		hosting +"|join|"+ 
		registrar +"|join|"+ 
		website_login +"|join|"+ 
		sort_type +"|join|"+ 
		'websites' +"|join|"+ 
		'site_type_sort'
		);
	});
	website_sort_details.push({'sort_type': sort_type, 'tab_name': 'websites', 'sort_name': 'site_type_sort'});
	website_sort(website_sort_details);
}

jQuery(document).on('click','.website_type_sort_asc',function(){
	get_site_type_sort_details('asc');	
});

jQuery(document).on('click','.website_type_sort_desc',function(){	
	get_site_type_sort_details('desc');		
});	
/* END SITE TYPE SORT */

/* PLATFORM SORT */
function get_platform_sort_deatils(sort_type){
	jQuery('.website_platform_sort_loader').show();
	var website_sort_details = [];
	jQuery('.tab_content.active .info_div').each(function(){
		var div_classes = jQuery(this).attr('class');
		var div_classes_split = div_classes.split(' ');	
		var website_class = div_classes_split[0];
		var website_id_split = website_class.split('_');
		var website_id = website_id_split[1];
		
		var site_url = jQuery(this).find(".first_column").text();
		var client_name = jQuery(this).find(".second_column").text();
		var site_type = jQuery(this).find(".third_column").text();
		var site_platform = jQuery(this).find(".fourth_column").text();
		var wp_ver = jQuery(this).find(".fifth_column").text();
		var theme = jQuery(this).find(".sixth_column").text();
		var th_ver = jQuery(this).find(".seventh_column").text();
		var hosting = jQuery(this).find(".eighth_column").text();
		var registrar = jQuery(this).find(".ninth_column").text();
		var website_login = jQuery(this).find(".tenth_column .website_login_button").attr('href');
		
		website_sort_details.push(site_platform +"|join|"+ 
		client_name +"|join|"+
		website_id +"|join|"+ 
		site_type +"|join|"+					
		site_url +"|join|"+ 			
		wp_ver +"|join|"+ 
		theme +"|join|"+ 
		th_ver +"|join|"+ 
		hosting +"|join|"+ 
		registrar +"|join|"+ 
		website_login +"|join|"+ 
		sort_type +"|join|"+ 
		'websites' +"|join|"+ 
		'site_platform_sort'
		);
	});
	website_sort_details.push({'sort_type': sort_type, 'tab_name': 'websites', 'sort_name': 'site_platform_sort'});
	website_sort(website_sort_details);
}

jQuery(document).on('click','.website_platform_sort_asc',function(){
	get_platform_sort_deatils('asc');
});	

jQuery(document).on('click','.website_platform_sort_desc',function(){
	get_platform_sort_deatils('desc');
});
/* END PLATFORM SORT */

/* WP-VERSION SORT */
function get_wpver_sort_details(sort_type){
	jQuery('.website_wpver_sort_loader').show();
	var website_sort_details = [];
	jQuery('.tab_content.active .info_div').each(function(){
		var div_classes = jQuery(this).attr('class');
		var div_classes_split = div_classes.split(' ');	
		var website_class = div_classes_split[0];
		var website_id_split = website_class.split('_');
		var website_id = website_id_split[1];
		
		var site_url = jQuery(this).find(".first_column").text();
		var client_name = jQuery(this).find(".second_column").text();
		var site_type = jQuery(this).find(".third_column").text();
		var site_platform = jQuery(this).find(".fourth_column").text();
		var wp_ver = jQuery(this).find(".fifth_column").text();
		var theme = jQuery(this).find(".sixth_column").text();
		var th_ver = jQuery(this).find(".seventh_column").text();
		var hosting = jQuery(this).find(".eighth_column").text();
		var registrar = jQuery(this).find(".ninth_column").text();
		var website_login = jQuery(this).find(".tenth_column .website_login_button").attr('href');
		
		website_sort_details.push(wp_ver +"|join|"+ 
		client_name +"|join|"+
		website_id +"|join|"+ 
		site_type +"|join|"+
		site_platform +"|join|"+ 			
		site_url +"|join|"+			
		theme +"|join|"+ 
		th_ver +"|join|"+ 
		hosting +"|join|"+ 
		registrar +"|join|"+ 
		website_login +"|join|"+ 
		sort_type +"|join|"+ 
		'websites' +"|join|"+ 
		'site_wpver_sort'
		);
	});
	website_sort_details.push({'sort_type': sort_type, 'tab_name': 'websites', 'sort_name': 'site_wpver_sort'});
	website_sort(website_sort_details);
}

jQuery(document).on('click','.website_wpver_sort_asc',function(){
	get_wpver_sort_details('asc');
});	

jQuery(document).on('click','.website_wpver_sort_desc',function(){
	get_wpver_sort_details('desc');
});
/* END WP-VERSION SORT */

/* SEO CLIENT SORT */
function get_seo_client_sort_details(sort_type){
	jQuery('.seo_stat_client_sort_loader').show();
	var website_sort_details = [];
	jQuery('.tab_content.active .info_div').each(function(){
		var div_classes = jQuery(this).attr('id');
		var div_classes_split = div_classes.split('_');	
		var website_client_id = div_classes_split[2];
		
		var client_name = jQuery(this).find(".first_column").text();
		var site_url = jQuery(this).find(".second_column").text();
		var site_type = jQuery(this).find(".third_column").text();
		var site_platform = jQuery(this).find(".fourth_column").text();
		var page_authority = jQuery(this).find(".fifth_column").text();
		var domain_authority = jQuery(this).find(".sixth_column").text();
		var moz_rank = jQuery(this).find(".seventh_column").text();
		var moz_trust = jQuery(this).find(".eighth_column").text();
		var extenal_link = jQuery(this).find(".ninth_column").text();
		var website_login = jQuery(this).find(".tenth .seo_stat_login_button").attr('href');
		
		website_sort_details.push(client_name +"|join|"+ 
		website_client_id +"|join|"+
		site_url +"|join|"+ 
		site_type +"|join|"+
		site_platform +"|join|"+
		page_authority +"|join|"+ 			
		domain_authority +"|join|"+			
		moz_rank +"|join|"+ 
		moz_trust +"|join|"+ 
		extenal_link +"|join|"+ 
		website_login +"|join|"+ 
		sort_type +"|join|"+ 
		'seo_stats' +"|join|"+ 
		'site_client_sort'
		);
	});
	website_sort_details.push({'sort_type': sort_type, 'tab_name': 'seo_stats', 'sort_name': 'site_client_sort'});
	website_sort(website_sort_details);
}

jQuery(document).on('click','.seo_stat_client_sort_asc',function(){
	get_seo_client_sort_details('asc');
});

jQuery(document).on('click','.seo_stat_client_sort_desc',function(){
	get_seo_client_sort_details('desc');
});
/* END SEO CLIENT SORT */

/* SEO SITE TYPE SORT */
function get_seo_site_type_sort_details(sort_type){
	jQuery('.seo_stat_type_sort_loader').show();
		var website_sort_details = [];
		jQuery('.tab_content.active .info_div').each(function(){
		var div_classes = jQuery(this).attr('id');
		var div_classes_split = div_classes.split('_');	
		var website_client_id = div_classes_split[2];
		
		var client_name = jQuery(this).find(".first_column").text();
		var site_url = jQuery(this).find(".second_column").text();
		var site_type = jQuery(this).find(".third_column").text();
		var site_platform = jQuery(this).find(".fourth_column").text();
		var page_authority = jQuery(this).find(".fifth_column").text();
		var domain_authority = jQuery(this).find(".sixth_column").text();
		var moz_rank = jQuery(this).find(".seventh_column").text();
		var moz_trust = jQuery(this).find(".eighth_column").text();
		var extenal_link = jQuery(this).find(".ninth_column").text();
		var website_login = jQuery(this).find(".tenth .seo_stat_login_button").attr('href');
		
		website_sort_details.push(site_type +"|join|"+
		client_name +"|join|"+ 
		website_client_id +"|join|"+
		site_url +"|join|"+ 			
		site_platform +"|join|"+ 			
		page_authority +"|join|"+ 			
		domain_authority +"|join|"+			
		moz_rank +"|join|"+ 
		moz_trust +"|join|"+ 
		extenal_link +"|join|"+ 
		website_login +"|join|"+ 
		sort_type +"|join|"+ 
		'seo_stats' +"|join|"+ 
		'site_type_sort'
		);
	});
	website_sort_details.push({'sort_type': sort_type, 'tab_name': 'seo_stats', 'sort_name': 'site_type_sort'});
	website_sort(website_sort_details);
}

jQuery(document).on('click','.seo_stat_type_sort_asc',function(){
	get_seo_site_type_sort_details('asc');
});

jQuery(document).on('click','.seo_stat_type_sort_desc',function(){
	get_seo_site_type_sort_details('desc');
});
/* END SEO SITE TYPE SORT */

/* SEO PLATFORM SORT */
function get_seo_platform_sort_deatils(sort_type){
	jQuery('.seo_stat_platform_sort_loader').show();
	var website_sort_details = [];
	jQuery('.tab_content.active .info_div').each(function(){
		var div_classes = jQuery(this).attr('id');
		var div_classes_split = div_classes.split('_');	
		var website_client_id = div_classes_split[2];
		
		var client_name = jQuery(this).find(".first_column").text();
		var site_url = jQuery(this).find(".second_column").text();
		var site_type = jQuery(this).find(".third_column").text();
		var site_platform = jQuery(this).find(".fourth_column").text();
		var page_authority = jQuery(this).find(".fifth_column").text();
		var domain_authority = jQuery(this).find(".sixth_column").text();
		var moz_rank = jQuery(this).find(".seventh_column").text();
		var moz_trust = jQuery(this).find(".eighth_column").text();
		var extenal_link = jQuery(this).find(".ninth_column").text();
		var website_login = jQuery(this).find(".tenth .seo_stat_login_button").attr('href');
		
		website_sort_details.push(site_platform +"|join|"+
		client_name +"|join|"+ 
		website_client_id +"|join|"+
		site_url +"|join|"+ 			
		site_type +"|join|"+ 			
		page_authority +"|join|"+ 			
		domain_authority +"|join|"+			
		moz_rank +"|join|"+ 
		moz_trust +"|join|"+ 
		extenal_link +"|join|"+ 
		website_login +"|join|"+ 
		sort_type +"|join|"+ 
		'seo_stats' +"|join|"+ 
		'site_platform_sort'
		);
	});
	website_sort_details.push({'sort_type': sort_type, 'tab_name': 'seo_stats', 'sort_name': 'site_platform_sort'});
	website_sort(website_sort_details);
}

jQuery(document).on('click','.seo_stat_platform_sort_asc',function(){
	get_seo_platform_sort_deatils('asc');
});	

jQuery(document).on('click','.seo_stat_platform_sort_desc',function(){
	get_seo_platform_sort_deatils('desc');
});	
/* END SEO PLATFORM SORT */

function website_sort(website_sort_details){	
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'website_sort',
			'website_sort_details' : website_sort_details				
		},
		success: function (data) {	
			var parsed = jQuery.parseJSON(data);
			var sort_name = parsed.sort_name;
			var sort_type = parsed.sort_type;
			var tab_name = parsed.tab_name;
			
			if(sort_name == 'client_sort' && tab_name == 'websites' && sort_type == 'desc'){				
				jQuery('#websites .info_div').remove();
			}
			
			if(sort_name == 'client_sort' && tab_name == 'websites' && sort_type == 'asc'){
				jQuery('#websites .info_div').remove();
			}
			
			if(sort_name == 'site_type_sort' && tab_name == 'websites' && sort_type == 'asc'){
				jQuery('#websites .info_div').remove();
			}
			
			if(sort_name == 'site_type_sort' && tab_name == 'websites' && sort_type == 'desc'){
				jQuery('#websites .info_div').remove();
			}
			
			if(sort_name == 'site_platform_sort' && tab_name == 'websites' && sort_type == 'asc'){
				jQuery('#websites .info_div').remove();
			}
			
			if(sort_name == 'site_platform_sort' && tab_name == 'websites' && sort_type == 'desc'){
				jQuery('#websites .info_div').remove();
			}
			
			if(sort_name == 'site_wpver_sort' && tab_name == 'websites' && sort_type == 'asc'){
				jQuery('#websites .info_div').remove();
			}
			
			if(sort_name == 'site_wpver_sort' && tab_name == 'websites' && sort_type == 'desc'){
				jQuery('#websites .info_div').remove();
			}
			
			if(sort_name == 'site_client_sort' && tab_name == 'seo_stats' && sort_type == 'asc'){
				jQuery('#seo_stats .info_div').remove();
			}
			
			if(sort_name == 'site_client_sort' && tab_name == 'seo_stats' && sort_type == 'desc'){
				jQuery('#seo_stats .info_div').remove();
			}
			
			if(sort_name == 'site_type_sort' && tab_name == 'seo_stats' && sort_type == 'asc'){
				jQuery('#seo_stats .info_div').remove();
			}
			
			if(sort_name == 'site_type_sort' && tab_name == 'seo_stats' && sort_type == 'desc'){
				jQuery('#seo_stats .info_div').remove();
			}
			
			if(sort_name == 'site_platform_sort' && tab_name == 'seo_stats' && sort_type == 'asc'){
				jQuery('#seo_stats .info_div').remove();
			}
			
			if(sort_name == 'site_platform_sort' && tab_name == 'seo_stats' && sort_type == 'desc'){
				jQuery('#seo_stats .info_div').remove();
			}
			
			
			jQuery.each(parsed, function(index, value){
				if(typeof value != 'object'){
					var website_detail_split = value.split('|join|');
					var first = website_detail_split[0];
					var second = website_detail_split[1];
					var third = website_detail_split[2];
					var fourth = website_detail_split[3];
					var fifth = website_detail_split[4];
					var sixth = website_detail_split[5];
					var seventh = website_detail_split[6];
					var eighth = website_detail_split[7];
					var ninth = website_detail_split[8];
					var tenth = website_detail_split[9];
					var eleventh = website_detail_split[10];
					var twelfth = website_detail_split[11];
					var thirteenth = website_detail_split[12];
					var fourteenth = website_detail_split[13];
					
					if(twelfth == 'asc' && thirteenth == 'websites' &&  fourteenth == 'client_sort'){						
						jQuery('#websites').append('<div class="website_'+second+' info_div delete_ajax_'+second+'">'
							+'<div class="first_column column">'+third+'</div>'
							+'<div id="name_'+second+'" class="client_info second_column column">'+first+'</div>'
							+'<div class="third_column column">'+fourth+'</div>'
							+'<div class="fourth_column column">'+fifth+'</div>'
							+'<div class="fifth_column column">'+sixth+'</div>'
							+'<div class="sixth_column column">'+seventh+'</div>'
							+'<div class="seventh_column column">'+eighth+'</div>'
							+'<div class="eighth_column column">'+ninth+'</div>'
							+'<div class="ninth_column column">'+tenth+'</div>'
							+'<div class="tenth_column column">'
							+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
							+'<a id="login_button_'+website_id+'" class="button_2 display_button website_login_button website_login_button" href="'+eleventh+'">L</a>'
							+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button website_edit_button" href="/edit-website/?editID='+second+'">E</a>'
							+'<div class="ajax_action_buttons">'
							+'<div id="delete_project_'+second+'" class="button_2 display_button float_right delete_website_button delete_ajax">D</div>'
							+'</div>'
							+'</div>'
						);
						jQuery('.website_client_sort_asc').hide();
						jQuery('.website_client_sort_desc').show();
						jQuery('.website_client_sort_loader').hide();
					}
					
					if(twelfth == 'desc' && thirteenth == 'websites' &&  fourteenth == 'client_sort'){						
						jQuery('#websites').append('<div class="website_'+second+' info_div delete_ajax_'+second+'">'
						+'<div class="first_column column">'+third+'</div>'
						+'<div id="name_'+second+'" class="client_info second_column column">'+first+'</div>'
						+'<div class="third_column column">'+fourth+'</div>'
						+'<div class="fourth_column column">'+fifth+'</div>'
						+'<div class="fifth_column column">'+sixth+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button website_login_button website_login_button" href="'+eleventh+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button website_edit_button" href="/edit-website/?editID='+second+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+second+'" class="button_2 display_button float_right delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.website_client_sort_desc').hide();
						jQuery('.website_client_sort_asc').show();
						jQuery('.website_client_sort_loader').hide();
					}
					
					if(twelfth == 'asc' && thirteenth == 'websites' &&  fourteenth == 'site_type_sort'){
						jQuery('#websites').append('<div class="website_'+third+' info_div delete_ajax_'+third+'">'
						+'<div class="first_column column">'+fourth+'</div>'
						+'<div id="name_'+third+'" class="client_info second_column column">'+second+'</div>'
						+'<div class="third_column column">'+first+'</div>'
						+'<div class="fourth_column column">'+fifth+'</div>'
						+'<div class="fifth_column column">'+sixth+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button website_login_button website_login_button" href="'+eleventh+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button website_edit_button" href="/edit-website/?editID='+third+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+third+'" class="button_2 display_button float_right delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.website_type_sort_desc').show();
						jQuery('.website_type_sort_asc').hide();
						jQuery('.website_type_sort_loader').hide();
					}
					
					if(twelfth == 'desc' && thirteenth == 'websites' &&  fourteenth == 'site_type_sort'){
						jQuery('#websites').append('<div class="website_'+third+' info_div delete_ajax_'+third+'">'
						+'<div class="first_column column">'+fourth+'</div>'
						+'<div id="name_'+third+'" class="client_info second_column column">'+second+'</div>'
						+'<div class="third_column column">'+first+'</div>'
						+'<div class="fourth_column column">'+fifth+'</div>'
						+'<div class="fifth_column column">'+sixth+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button website_login_button website_login_button" href="'+eleventh+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button website_edit_button" href="/edit-website/?editID='+third+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+third+'" class="button_2 display_button float_right delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.website_type_sort_desc').hide();
						jQuery('.website_type_sort_asc').show();
						jQuery('.website_type_sort_loader').hide();
					}	
					
					if(twelfth == 'asc' && thirteenth == 'websites' &&  fourteenth == 'site_platform_sort'){
						jQuery('#websites').append('<div class="website_'+third+' info_div delete_ajax_'+third+'">'
						+'<div class="first_column column">'+fifth+'</div>'
						+'<div id="name_'+third+'" class="client_info second_column column">'+second+'</div>'
						+'<div class="third_column column">'+fourth+'</div>'
						+'<div class="fourth_column column">'+first+'</div>'
						+'<div class="fifth_column column">'+sixth+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button website_login_button website_login_button" href="'+eleventh+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button website_edit_button" href="/edit-website/?editID='+third+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+third+'" class="button_2 display_button float_right delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.website_platform_sort_desc').show();
						jQuery('.website_platform_sort_asc').hide();
						jQuery('.website_platform_sort_loader').hide();
					}	
					
					if(twelfth == 'desc' && thirteenth == 'websites' &&  fourteenth == 'site_platform_sort'){
						jQuery('#websites').append('<div class="website_'+third+' info_div delete_ajax_'+third+'">'
						+'<div class="first_column column">'+fifth+'</div>'
						+'<div id="name_'+third+'" class="client_info second_column column">'+second+'</div>'
						+'<div class="third_column column">'+fourth+'</div>'
						+'<div class="fourth_column column">'+first+'</div>'
						+'<div class="fifth_column column">'+sixth+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button website_login_button website_login_button" href="'+eleventh+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button website_edit_button" href="/edit-website/?editID='+third+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+third+'" class="button_2 display_button float_right delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.website_platform_sort_desc').hide();
						jQuery('.website_platform_sort_asc').show();
						jQuery('.website_platform_sort_loader').hide();
					}
					if(twelfth == 'asc' && thirteenth == 'websites' &&  fourteenth == 'site_wpver_sort'){
						jQuery('#websites').append('<div class="website_'+third+' info_div delete_ajax_'+third+'">'
						+'<div class="first_column column">'+sixth+'</div>'
						+'<div id="name_'+third+'" class="client_info second_column column">'+second+'</div>'
						+'<div class="third_column column">'+fourth+'</div>'
						+'<div class="fourth_column column">'+fifth+'</div>'
						+'<div class="fifth_column column">'+first+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button website_login_button website_login_button" href="'+eleventh+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button website_edit_button" href="/edit-website/?editID='+third+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+third+'" class="button_2 display_button float_right delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.website_wpver_sort_desc').show();
						jQuery('.website_wpver_sort_asc').hide();
						jQuery('.website_wpver_sort_loader').hide();
					}	
					
					if(twelfth == 'desc' && thirteenth == 'websites' &&  fourteenth == 'site_wpver_sort'){
						jQuery('#websites').append('<div class="website_'+third+' info_div delete_ajax_'+third+'">'
						+'<div class="first_column column">'+sixth+'</div>'
						+'<div id="name_'+third+'" class="client_info second_column column">'+second+'</div>'
						+'<div class="third_column column">'+fourth+'</div>'
						+'<div class="fourth_column column">'+fifth+'</div>'
						+'<div class="fifth_column column">'+first+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button website_login_button website_login_button" href="'+eleventh+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button website_edit_button" href="/edit-website/?editID='+third+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+third+'" class="button_2 display_button float_right delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.website_wpver_sort_desc').hide();
						jQuery('.website_wpver_sort_asc').show();
						jQuery('.website_wpver_sort_loader').hide();
					}
					if(twelfth == 'asc' && thirteenth == 'seo_stats' &&  fourteenth == 'site_client_sort'){
						var website_client_id = second.split('join');
						var website_id = website_client_id[0];
												
						jQuery('#seo_stats').append('<div id="moz_metrix_'+second+'" class="website_'+website_id+' info_div delete_ajax_'+website_id+'">'
							+'<div id="name_'+website_id+'" class="client_info first_column column">'+first+'</div>'
							+'<div class="second_column column">'+third+'</div>'
							+'<div class="third_column column">'+fourth+'</div>'
							+'<div class="fourth_column column">'+fifth+'</div>'
							+'<div class="fifth_column column">'+sixth+'</div>'
							+'<div class="sixth_column column">'+seventh+'</div>'
							+'<div class="seventh_column column">'+eighth+'</div>'
							+'<div class="eighth_column column">'+ninth+'</div>'
							+'<div class="ninth_column column">'+tenth+'</div>'
							+'<div class="tenth_column column">'
							+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
							+'<a id="login_button_'+website_id+'" class="button_2 display_button seo_stat_login_button website_login_button" href="'+tenth+'">L</a>'
							+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button" href="/edit-website/?editID='+website_id+'">E</a>'
							+'<div class="ajax_action_buttons">'
							+'<div id="delete_project_'+website_id+'" class="button_2 display_button float_left delete_website_button delete_ajax">D</div>'
							+'</div>'
							+'<div class="get_metrix_button">'
							+'<div id="get_metrix_'+second+'" class="button_2 display_button get_metrix float_left">M</div>'
							+'<div id="get_metrix_loader_'+second+'" class="loader" style="display:none;"></div>'
							+'</div>'
							+'</div>'
							+'</div>'
						);
						jQuery('.seo_stat_client_sort_desc').show();
						jQuery('.seo_stat_client_sort_asc').hide();
						jQuery('.seo_stat_client_sort_loader').hide();
					}
					
					if(twelfth == 'desc' && thirteenth == 'seo_stats' &&  fourteenth == 'site_client_sort'){
						var website_client_id = second.split('join');
						var website_id = website_client_id[0];
						jQuery('#seo_stats').append('<div id="moz_metrix_'+second+'" class="website_'+website_id+' info_div delete_ajax_'+website_id+'">'
						+'<div id="name_'+website_id+'" class="client_info first_column column">'+first+'</div>'
						+'<div class="second_column column">'+third+'</div>'
						+'<div class="third_column column">'+fourth+'</div>'
						+'<div class="fourth_column column">'+fifth+'</div>'
						+'<div class="fifth_column column">'+sixth+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button seo_stat_login_button website_login_button" href="'+tenth+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button" href="/edit-website/?editID='+website_id+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+website_id+'" class="button_2 display_button float_left delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'<div class="get_metrix_button">'
						+'<div id="get_metrix_'+second+'" class="button_2 display_button get_metrix float_left">M</div>'
						+'<div id="get_metrix_loader_'+second+'" class="loader" style="display:none;"></div>'
						+'</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.seo_stat_client_sort_desc').hide();
						jQuery('.seo_stat_client_sort_asc').show();
						jQuery('.seo_stat_client_sort_loader').hide();
					}
					
					if(twelfth == 'asc' && thirteenth == 'seo_stats' &&  fourteenth == 'site_type_sort'){
						var website_client_id = third.split('join');
						var website_id = website_client_id[0];
						
						jQuery('#seo_stats').append('<div id="moz_metrix_'+third+'" class="website_'+website_id+' info_div delete_ajax_'+website_id+'">'
						+'<div id="name_'+website_id+'" class="client_info first_column column">'+second+'</div>'
						+'<div class="second_column column">'+fourth+'</div>'
						+'<div class="third_column column">'+first+'</div>'
						+'<div class="fourth_column column">'+fifth+'</div>'
						+'<div class="fifth_column column">'+sixth+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button seo_stat_login_button website_login_button" href="'+tenth+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button" href="/edit-website/?editID='+website_id+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+website_id+'" class="button_2 display_button float_left delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'<div class="get_metrix_button">'
						+'<div id="get_metrix_'+third+'" class="button_2 display_button get_metrix float_left">M</div>'
						+'<div id="get_metrix_loader_'+third+'" class="loader" style="display:none;"></div>'
						+'</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.seo_stat_type_sort_desc').show();
						jQuery('.seo_stat_type_sort_asc').hide();
						jQuery('.seo_stat_type_sort_loader').hide();
					}
					
					if(twelfth == 'desc' && thirteenth == 'seo_stats' &&  fourteenth == 'site_type_sort'){
						var website_client_id = third.split('join');
						var website_id = website_client_id[0];
						
						jQuery('#seo_stats').append('<div id="moz_metrix_'+third+'" class="website_'+website_id+' info_div delete_ajax_'+website_id+'">'
						+'<div id="name_'+website_id+'" class="client_info first_column column">'+second+'</div>'
						+'<div class="second_column column">'+fourth+'</div>'
						+'<div class="third_column column">'+first+'</div>'
						+'<div class="fourth_column column">'+fifth+'</div>'
						+'<div class="fifth_column column">'+sixth+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button seo_stat_login_button website_login_button" href="'+tenth+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button" href="/edit-website/?editID='+website_id+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+website_id+'" class="button_2 display_button float_left delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'<div class="get_metrix_button">'
						+'<div id="get_metrix_'+third+'" class="button_2 display_button get_metrix float_left">M</div>'
						+'<div id="get_metrix_loader_'+third+'" class="loader" style="display:none;"></div>'
						+'</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.seo_stat_type_sort_desc').hide();
						jQuery('.seo_stat_type_sort_asc').show();
						jQuery('.seo_stat_type_sort_loader').hide();
					}
					
					if(twelfth == 'asc' && thirteenth == 'seo_stats' &&  fourteenth == 'site_platform_sort'){
						var website_client_id = third.split('join');
						var website_id = website_client_id[0];
						
						jQuery('#seo_stats').append('<div id="moz_metrix_'+third+'" class="website_'+website_id+' info_div delete_ajax_'+website_id+'">'
						+'<div id="name_'+website_id+'" class="client_info first_column column">'+second+'</div>'
						+'<div class="second_column column">'+fourth+'</div>'
						+'<div class="third_column column">'+fifth+'</div>'
						+'<div class="fourth_column column">'+first+'</div>'
						+'<div class="fifth_column column">'+sixth+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button seo_stat_login_button website_login_button" href="'+tenth+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button" href="/edit-website/?editID='+website_id+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+website_id+'" class="button_2 display_button float_left delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'<div class="get_metrix_button">'
						+'<div id="get_metrix_'+third+'" class="button_2 display_button get_metrix float_left">M</div>'
						+'<div id="get_metrix_loader_'+third+'" class="loader" style="display:none;"></div>'
						+'</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.seo_stat_platform_sort_desc').show();
						jQuery('.seo_stat_platform_sort_asc').hide();
						jQuery('.seo_stat_platform_sort_loader').hide();
					}
					
					if(twelfth == 'desc' && thirteenth == 'seo_stats' &&  fourteenth == 'site_platform_sort'){
						var website_client_id = third.split('join');
						var website_id = website_client_id[0];
						
						jQuery('#seo_stats').append('<div id="moz_metrix_'+third+'" class="website_'+website_id+' info_div delete_ajax_'+website_id+'">'
						+'<div id="name_'+website_id+'" class="client_info first_column column">'+second+'</div>'
						+'<div class="second_column column">'+fourth+'</div>'
						+'<div class="third_column column">'+fifth+'</div>'
						+'<div class="fourth_column column">'+first+'</div>'
						+'<div class="fifth_column column">'+sixth+'</div>'
						+'<div class="sixth_column column">'+seventh+'</div>'
						+'<div class="seventh_column column">'+eighth+'</div>'
						+'<div class="eighth_column column">'+ninth+'</div>'
						+'<div class="ninth_column column">'+tenth+'</div>'
						+'<div class="tenth_column column">'
						+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
						+'<a id="login_button_'+website_id+'" class="button_2 display_button seo_stat_login_button website_login_button" href="'+tenth+'">L</a>'
						+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button" href="/edit-website/?editID='+website_id+'">E</a>'
						+'<div class="ajax_action_buttons">'
						+'<div id="delete_project_'+website_id+'" class="button_2 display_button float_left delete_website_button delete_ajax">D</div>'
						+'</div>'
						+'<div class="get_metrix_button">'
						+'<div id="get_metrix_'+third+'" class="button_2 display_button get_metrix float_left">M</div>'
						+'<div id="get_metrix_loader_'+third+'" class="loader" style="display:none;"></div>'
						+'</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.seo_stat_platform_sort_desc').hide();
						jQuery('.seo_stat_platform_sort_asc').show();
						jQuery('.seo_stat_platform_sort_loader').hide();
					}
				}
				
			});
			trigger_website_note();
		},
		error: function (data) {
			
		}
	});	
}
/* ==================================== END SORT ==================================== */

/* ==================================== SITE TYPE FILTER ==================================== */
jQuery(document).on('change','.site_type_filter',function(){
jQuery('.site_type_filter_loader').show();
	var site_type = jQuery(this).val();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'site_type_filter',
			'site_type' : site_type				
		},
		success: function (data) {
			var parsed = jQuery.parseJSON(data);
			jQuery('#websites .info_div').remove();
			jQuery('#seo_stats .info_div').remove();
			
			jQuery.each(parsed.website_tab_array, function(index, values){
				var website_tab = values.split('_');
				var website_id = website_tab[0];
				var site_url = website_tab[1];
				var site_client = website_tab[2];
				var site_type = website_tab[3];
				var site_platform = website_tab[4];
				var site_wp_version = website_tab[5];
				var site_theme_name = website_tab[6];
				var site_theme_version = website_tab[7];
				var site_hosting_name = website_tab[8];
				var site_domain_name = website_tab[9];
				var site_login_url = website_tab[10];
				
				jQuery('#websites').append('<div class="website_'+website_id+' info_div delete_ajax_'+website_id+'">'
					+'<div class="first_column column">'+site_url+'</div>'
					+'<div id="name_'+website_id+'" class="client_info second_column column">'+site_client+'</div>'
					+'<div class="third_column column">'+site_type+'</div>'
					+'<div class="fourth_column column">'+site_platform+'</div>'
					+'<div class="fifth_column column">'+site_wp_version+'</div>'
					+'<div class="sixth_column column">'+site_theme_name+'</div>'
					+'<div class="seventh_column column">'+site_theme_version+'</div>'
					+'<div class="eighth_column column">'+site_hosting_name+'</div>'
					+'<div class="ninth_column column">'+site_domain_name+'</div>'
					+'<div class="tenth_column column">'
					+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
					+'<a id="login_button_'+website_id+'" class="button_2 display_button website_login_button website_login_button" href="https://'+site_login_url+'">L</a>'
					+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button" href="/edit-website/?editID='+website_id+'">E</a>'
					+'<div class="ajax_action_buttons">'
					+'<div id="delete_project_'+website_id+'" class="button_2 display_button float_right delete_website_button delete_ajax">D</div>'
					+'</div>'
					+'</div>'
					+'</div>'					
				);
			});
			
			jQuery.each(parsed.seo_stats_tab_array, function(index, values){					
				var seo_stats_tab = values.split('_');
				var website_id = seo_stats_tab[0];
				var client_id = seo_stats_tab[1];
				var site_client = seo_stats_tab[2];
				var site_url = seo_stats_tab[3];
				var site_type = seo_stats_tab[4];
				var site_platform = seo_stats_tab[5];
				var moz_page_authority = seo_stats_tab[6];
				var moz_domain_authority = seo_stats_tab[7];
				var moz_rank = seo_stats_tab[8];
				var moz_trust = seo_stats_tab[9];
				var moz_external_links = seo_stats_tab[10];
				var site_login_url = seo_stats_tab[11];
				
				jQuery('#seo_stats').append('<div id="moz_metrix_'+website_id+'join'+client_id+'" class="website_'+website_id+' info_div delete_ajax_'+website_id+'">'
					+'<div id="name_'+website_id+'" class="client_info first_column column">'+site_client+'</div>'
					+'<div class="second_column column">'+site_url+'</div>'
					+'<div class="third_column column">'+site_type+'</div>'
					+'<div class="fourth_column column">'+site_platform+'</div>'
					+'<div class="fifth_column column">'+moz_page_authority+'</div>'
					+'<div class="sixth_column column">'+moz_domain_authority+'</div>'
					+'<div class="seventh_column column">'+moz_rank+'</div>'
					+'<div class="eighth_column column">'+moz_trust+'</div>'
					+'<div class="ninth_column column">'+moz_external_links+'</div>'
					+'<div class="tenth_column column">'
					+'<p style="display:none" id="website_button_note_'+website_id+'" class="website_button_note"></p>'
					+'<a id="login_button_'+website_id+'" class="button_2 display_button seo_stat_login_button website_login_button" href="http://'+site_login_url+'">L</a>'
					+'<a id="edit_button_'+website_id+'" class="button_2 display_button website_edit_button" href="/edit-website/?editID='+website_id+'">E</a>'
					+'<div class="ajax_action_buttons">'
					+'<div id="delete_project_'+website_id+'" class="button_2 display_button float_left delete_website_button delete_ajax">D</div>'
					+'</div>'
					+'<div class="get_metrix_button">'
					+'<div id="get_metrix_'+website_id+'join'+client_id+'" class="button_2 display_button get_metrix float_left">C</div>'
					+'<div id="get_metrix_loader_'+website_id+'join'+client_id+'" style="display:none;" class="loader"></div>'
					+'</div>'
					+'</div>'
					+'</div>'
				);
			});
			jQuery('.site_type_filter_loader').hide();
			trigger_website_note();
		},
		error: function (data) {
			
		}
	});	
});

/* ==================================== END SITE TYPE FILTER ==================================== */

/* ==================================== BUTTON HOVER ==================================== */
jQuery(document).ready(function(){		
	jQuery('.website_login_button').mouseover(function() {
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var id = div_id_split[2];
		jQuery('p#website_button_note_'+id).text('Login');
		jQuery('p#website_button_note_'+id).show();
	})
	.mouseout(function() {
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var id = div_id_split[2];
		jQuery('p#website_button_note_'+id).text('');
		jQuery('p#website_button_note_'+id).hide();
	});
	
	jQuery('.website_edit_button').mouseover(function() {
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var id = div_id_split[2];
		jQuery('p#website_button_note_'+id).text('Edit');
		jQuery('p#website_button_note_'+id).show();
	})
	.mouseout(function() {
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var id = div_id_split[2];
		jQuery('p#website_button_note_'+id).text('');
		jQuery('p#website_button_note_'+id).hide();
	});
	
	jQuery('.delete_website_button').mouseover(function() {
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var id = div_id_split[2];
		jQuery('p#website_button_note_'+id).text('Delete');
		jQuery('p#website_button_note_'+id).show();
	})
	.mouseout(function() {
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var id = div_id_split[2];
		jQuery('p#website_button_note_'+id).text('');
		jQuery('p#website_button_note_'+id).hide();
	});
	
	jQuery('.get_metrix').mouseover(function() {
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var id = div_id_split[2];
		var id_split = id.split('join');
		id = id_split[0];
		jQuery('p#website_button_note_'+id).text('Check');
		jQuery('p#website_button_note_'+id).show();
	})
	.mouseout(function() {
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var id = div_id_split[2];
		var id_split = id.split('join');
		id = id_split[0];
		jQuery('p#website_button_note_'+id).text('');
		jQuery('p#website_button_note_'+id).hide();
	});
	
	jQuery('.get_wp_th_details').mouseover(function() {
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var id = div_id_split[4];
		jQuery('p#website_button_note_'+id).text('Check');
		jQuery('p#website_button_note_'+id).show();
	})
	.mouseout(function() {
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var id = div_id_split[4];
		jQuery('p#website_button_note_'+id).text('');
		jQuery('p#website_button_note_'+id).hide();
	});
});

function trigger_website_note(){
	// jQuery('.website_login_button').mouseover(function() {
		// var div_id = jQuery(this).attr('id');
		// var div_id_split = div_id.split('_');
		// var id = div_id_split[2];
		// jQuery('p#website_button_note_'+id).text('Login');
		// jQuery('p#website_button_note_'+id).show();
	// })
	// .mouseout(function() {
		// var div_id = jQuery(this).attr('id');
		// var div_id_split = div_id.split('_');
		// var id = div_id_split[2];
		// jQuery('p#website_button_note_'+id).text('');
		// jQuery('p#website_button_note_'+id).hide();
	// });
	
	// jQuery('.website_edit_button').mouseover(function() {
		// var div_id = jQuery(this).attr('id');
		// var div_id_split = div_id.split('_');
		// var id = div_id_split[2];
		// jQuery('p#website_button_note_'+id).text('Edit');
		// jQuery('p#website_button_note_'+id).show();
	// })
	// .mouseout(function() {
		// var div_id = jQuery(this).attr('id');
		// var div_id_split = div_id.split('_');
		// var id = div_id_split[2];
		// jQuery('p#website_button_note_'+id).text('');
		// jQuery('p#website_button_note_'+id).hide();
	// });
	
	// jQuery('.delete_website_button').mouseover(function() {
		// var div_id = jQuery(this).attr('id');
		// var div_id_split = div_id.split('_');
		// var id = div_id_split[2];
		// jQuery('p#website_button_note_'+id).text('Delete');
		// jQuery('p#website_button_note_'+id).show();
	// })
	// .mouseout(function() {
		// var div_id = jQuery(this).attr('id');
		// var div_id_split = div_id.split('_');
		// var id = div_id_split[2];
		// jQuery('p#website_button_note_'+id).text('');
		// jQuery('p#website_button_note_'+id).hide();
	// });
	
	// jQuery('.get_metrix').mouseover(function() {
		// var div_id = jQuery(this).attr('id');
		// var div_id_split = div_id.split('_');
		// var id = div_id_split[2];
		// var id_split = id.split('join');
		// id = id_split[0];
		// jQuery('p#website_button_note_'+id).text('Check');
		// jQuery('p#website_button_note_'+id).show();
	// })
	// .mouseout(function() {
		// var div_id = jQuery(this).attr('id');
		// var div_id_split = div_id.split('_');
		// var id = div_id_split[2];
		// jQuery('p#website_button_note_'+id).text('');
		// jQuery('p#website_button_note_'+id).hide();
	// });
}
/* ==================================== END BUTTON HOVER ==================================== */

/* ==================================== WORDPRESS AND THEME VERSION ==================================== */
// GET WP AND TH DETAILS
jQuery(document).on('click', '.get_wp_th_details', function(){		
	var div_id = jQuery(this).attr('id');
	var div_id_split = div_id.split('_');
	var website_id = div_id_split[4];
	jQuery('#website_action_loader_'+website_id).show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'get_wp_th_details',
			'website_id' : website_id				
		},
		success: function (data) {				
			var parsed = jQuery.parseJSON(data);
			var website_id = parsed.website_id
			jQuery('#website_action_loader_'+website_id).hide();
			jQuery('#websites .website_'+website_id+'.info_div .fifth_column').text(parsed.wordpress_version);
			jQuery('#websites .website_'+website_id+'.info_div .sixth_column').text(parsed.theme_name);
			jQuery('#websites .website_'+website_id+'.info_div .seventh_column').text(parsed.theme_version);
		},
		error: function (data) {
			
		}
	});	
});
// END GET WP AND TH DETAILS
// BULK GET WP AND TH DETAILS
jQuery(document).on('click', '.bulk_get_wp_th_details', function(){	
	jQuery('.bulk_get_wp_th_details_section .bulk_get_wp_th_details_loader').show();
	var website_id_array = [];
	jQuery('#websites .info_div').each(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var website_id = div_id_split[2];
		website_id_array.push(website_id);
	});
	
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'bulk_get_wp_th',
			'website_id_array' : website_id_array				
		},
		success: function (data) {	
			var parsed = jQuery.parseJSON(data);
			console.log(parsed);
			// var website_id = parsed.website_id
			// jQuery('#website_action_loader_'+website_id).hide();
			// jQuery('#websites .website_'+website_id+'.info_div .fifth_column').text(parsed.wordpress_version);
			// jQuery('#websites .website_'+website_id+'.info_div .sixth_column').text(parsed.theme_name);
			// jQuery('#websites .website_'+website_id+'.info_div .seventh_column').text(parsed.theme_version);
			// jQuery('.bulk_get_wp_th_details_section .bulk_get_wp_th_details_loader').hide();
		},
		error: function (data) {
			
		}
	});	
});
// END BULK GET WP AND TH DETAILS
/* ==================================== END WORDPRESS AND THEME VERSION ==================================== */
/* ==================================== METRIX ==================================== */
// GET MATRIX
jQuery(document).on('click', '.get_metrix', function(){
	var div_id = jQuery(this).attr('id');
	var div_id_split = div_id.split('_');
	var website_client_id = div_id_split[2];
	jQuery('.get_metrix_button #get_metrix_loader_'+website_client_id+'').show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'get_moz_metrix',
			'website_client_id' : website_client_id				
		},
		success: function (data) {	
			var parsed = jQuery.parseJSON(data);
			var website_id = parsed.website_id;
			var client_id = parsed.client_id;
			var moz_page_authority = parsed.moz_page_authority;
			var moz_domain_authority = parsed.moz_domain_authority;
			var moz_rank = parsed.moz_rank;
			var moz_external_links = parsed.moz_external_links;
			jQuery('#moz_metrix_'+website_id+'join'+client_id+' .fifth_column').text(moz_page_authority);
			jQuery('#moz_metrix_'+website_id+'join'+client_id+' .sixth_column').text(moz_domain_authority);
			jQuery('#moz_metrix_'+website_id+'join'+client_id+' .seventh_column').text(moz_rank);
			jQuery('#moz_metrix_'+website_id+'join'+client_id+' .eighth_column').text('--');
			jQuery('#moz_metrix_'+website_id+'join'+client_id+' .ninth_column').text(moz_external_links);
			jQuery('.get_metrix_button #get_metrix_loader_'+website_id+'join'+client_id+'').hide();
		},
		error: function (data) {
			
		}
	});	
});
// END GET MATRIX

// BULK GET MATRIX
jQuery(document).on('click', '.bulk_get_metrix', function(){
	jQuery('.bulk_get_metrix_button .bulk_get_metrix_loader').show();
	var website_client_id_array = [];
	jQuery('#seo_stats .info_div').each(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var website_client_id = div_id_split[2];
		website_client_id_array.push(website_client_id);
	});
	
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'bulk_get_moz_metrix',
			'website_client_id_array' : website_client_id_array				
		},
		success: function (data) {	
			var parsed = jQuery.parseJSON(data);
			jQuery.each(parsed.moz_bulk_details, function(index, values){
				var value_split = values.split('_');
				var moz_datetime = value_split[0];
				var website_id = value_split[1];
				var client_id = value_split[2];
				var moz_page_authority = value_split[3];
				var moz_domain_authority = value_split[4];
				var moz_rank = value_split[5];
				var moz_external_links = value_split[6];
				var moz_trust = value_split[7];
				jQuery('#moz_metrix_'+website_id+'join'+client_id+' .fifth_column').text(moz_page_authority);
				jQuery('#moz_metrix_'+website_id+'join'+client_id+' .sixth_column').text(moz_domain_authority);
				jQuery('#moz_metrix_'+website_id+'join'+client_id+' .seventh_column').text(moz_rank);
				jQuery('#moz_metrix_'+website_id+'join'+client_id+' .eighth_column').text(moz_trust);
				jQuery('#moz_metrix_'+website_id+'join'+client_id+' .ninth_column').text(moz_external_links);
				jQuery('.bulk_get_metrix_button .bulk_get_metrix_loader').hide();
			});
		},
		error: function (data) {
			
		}
	});	
});
// END BULK GET MATRIX
/* ==================================== END METRIX ==================================== */

/* ==================================== BULK ACTIONS ==================================== */
jQuery(document).on('click', '#check_all_website',function () {    
	jQuery('.tab_content.active .website_bulk_action_id').prop('checked', this.checked);    
});
/* ==================================== END BULK ACTIONS ==================================== */


</script>