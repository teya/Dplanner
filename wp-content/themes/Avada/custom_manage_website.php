<?php /* Template Name: Websites */ ?>
<?php get_header(); ?>
<?php 
if(isset($_GET['deleteID'])) {
	$id = $_GET['deleteID'];	
	global $wpdb;	
	$table_name = $wpdb->prefix . "custom_website";	
	$wpdb->query( "DELETE FROM {$table_name} WHERE ID = '$id'" );
}
$table_name_client = $wpdb->prefix . "custom_client";
$clients = $wpdb->get_results("SELECT * FROM {$table_name_client} ORDER BY client_name ASC");
$table_name_website = $wpdb->prefix . "custom_website";
$websites = $wpdb->get_results("SELECT * FROM {$table_name_website}");
$table_name_website_moz = $wpdb->prefix . "custom_website_moz";
?>
<script>
jQuery(document).ready(function(){
	//On Click Event
	jQuery("ul.tabs li").click(function(e) {
		jQuery(this).parents('.tabs-wrapper').find("ul.tabs li").removeClass("active");
		jQuery(this).addClass("active");
		jQuery(this).parents('.tabs-wrapper').find(".tab_content").hide().removeClass("active");
		var activeTab = jQuery(this).find("a").attr("href"); 
		jQuery(this).parents('.tabs-wrapper').find(activeTab).show().addClass("active"); 
		
		jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.content-boxes').each(function() {
			var cols = jQuery(this).find('.col').length;
			jQuery(this).addClass('columns-'+cols);
		});
		
		jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.columns-3 .col:nth-child(3n), .columns-4 .col:nth-child(4n)').css('margin-right', '0px');
		
		jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.portfolio-wrapper').isotope('reLayout');
		
		jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.content-boxes-icon-boxed').each(function() {
			jQuery(this).find('.col').equalHeights();
		});
		
		jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.shortcode-map').each(function() {
			jQuery("#"+this.id).goMap();
			marker = jQuery.goMap.markers[0];
			if(marker) {
				info = jQuery.goMap.getInfo(marker);
				jQuery.goMap.setInfo(marker, info);
			}			
			var center = jQuery.goMap.getMap().getCenter();
			google.maps.event.trigger(jQuery.goMap.getMap(), 'resize');
			jQuery.goMap.getMap().setCenter(center);
		});
		
		generateCarousel();
		
		e.preventDefault();
	});
	
	jQuery("ul.tabs li a").click(function(e) {
		e.preventDefault();
	});
});
</script>
<div class="websites">
	<div class="create_website_container">
		<a id="create_website" class="button_1" href="/add-website/">+ Add Website</a>
	</div>
	<div class="bulk_action_select_website">
		<select class="website_bulk_actions">
			<option>-- Bulk Actions --</option>			
			<option>Edit</option>
			<option>Delete</option>
		</select>				
		<div class="apply_bulk_action_website button_2">Apply</div>				
	</div>
	<div class="site_type_filter_section">		
		<select class="site_type_filter">
			<option>-- Site Type --</option>
			<option>Affiliate site</option>
			<option>Demo site</option>
			<option>Main site</option>
			<option>PBN site T1</option>
			<option>PBN site T2</option>
			<option>Secondary site</option>
		</select>
		<div style="display: none" class="site_type_filter_loader loader"></div>
	</div>
</div>
<div class="display_main websites">
	<div class="table_container">
		<div class="tab-holder">
			<div class="tab-hold tabs-wrapper">
				<div class="full_width">				
					<ul id="tabs" class="tabset tabs">
						<li class="tabs_li active"><a href="#websites">Websites</a></li>					
						<li class="tabs_li"><a href="#seo_stats">SEO Stats</a></li>													
					</ul>
				</div>
				<div class="tab-box tabs-container">
					<!------------------------------------------------------ WEBSITES ------------------------------------------------------->
					<div id="websites" class="tab tab_content active" style="display: block;">
						<div class="header_titles">
							<div class="column check_all_container_website"><input type="checkbox" id="check_all_website" name="check_all_website" class="check_all_website"></div>
							<div class="first_column column"><h3>URL</h3></div>
							<div class="second_column column">
								<h3>Client</h3>
								<div style="display:none" class="asc_button website_client_sort_asc"></div>
								<div class="desc_button website_client_sort_desc"></div>
								<div style="display:none" class="website_client_sort_loader loader"></div>
							</div>
							<div class="third_column column">
								<h3>Type</h3>
								<div class="asc_button website_type_sort_asc"></div>
								<div style="display:none" class="desc_button website_type_sort_desc"></div>
								<div style="display:none" class="website_type_sort_loader loader"></div>
							</div>
							<div class="fourth_column column">
								<h3>Platform</h3>
								<div class="asc_button website_platform_sort_asc"></div>
								<div style="display:none" class="desc_button website_platform_sort_desc"></div>
								<div style="display:none" class="website_platform_sort_loader loader"></div>
							</div>
							<div class="fifth_column column">
								<h3>WP-Ver</h3>
								<div class="asc_button website_wpver_sort_asc"></div>
								<div style="display:none" class="desc_button website_wpver_sort_desc"></div>
								<div style="display:none" class="website_wpver_sort_loader loader"></div>
							</div>
							<div class="sixth_column column"><h3>Theme</h3></div>
							<div class="seventh_column column"><h3>Th-Ver</h3></div>
							<div class="eighth_column column"><h3>Hosting</h3></div>
							<div class="ninth_column column"><h3>Registrar</h3></div>
							<div class="tenth_column column">
								<div class="bulk_get_wp_th_details_button">									
									<div class="button_2 display_button bulk_get_wp_th_details float_right">C</div>												
									<div style="display:none;" class="loader bulk_get_wp_th_details_loader float_right"></div>
								</div>
							</div>
						</div>
						<?php
							
							foreach($clients as $client){
								foreach($websites as $website){
									if($website->site_client == $client->client_name){
										$site_url 			= ($website->site_url != "" ? $website->site_url : "--");
										$site_client 		= ($website->site_client != "" ? $website->site_client : "--");
										$site_type 			= ($website->site_type != "" ? $website->site_type : "--");
										$site_platform 		= ($website->site_platform != "" ? $website->site_platform : "--");
										$site_wp_version 	= ($website->site_wp_version != "" ? $website->site_wp_version : "--");
										$site_theme_name 	= ($website->site_theme_name != "" ? $website->site_theme_name : "--");
										$site_theme_version = ($website->site_theme_version != "" ? $website->site_theme_version : "--");
										$site_hosting_name 	= ($website->site_hosting_name != "" ? $website->site_hosting_name : "--");
										$site_domain_name 	= ($website->site_domain_name != "" ? $website->site_domain_name : "--");			
										$site_login_url 	= ($website->site_login_url != "" ? $website->site_login_url : "#");
									?>			
									
									<div id="wp_th_<?php echo $website->ID; ?>" class="website_<?php echo $website->ID; ?> info_div delete_ajax_<?php echo $website->ID; ?>">										
										<div class="bulk_action_column column"><input type="checkbox" name="website_bulk_delete_id[]" class="website_bulk_action_id" value="<?php echo $website->ID;?>"></div>
										<div class="first_column column"><a href="<?php echo $site_url; ?>"><?php echo $site_url; ?></a></div>
										<div id="name_<?php echo $website->ID; ?>" class="client_info second_column column"><?php echo $site_client; ?></div>
										<div onclick="window.open('/website-information/?id=<?php echo $website->ID ?>');" class="third_column column"><?php echo $site_type; ?></div>
										<div onclick="window.open('/website-information/?id=<?php echo $website->ID ?>');" class="fourth_column column"><?php echo $site_platform; ?></div>
										<div onclick="window.open('/website-information/?id=<?php echo $website->ID ?>');" class="fifth_column column"><?php echo $site_wp_version; ?></div>
										<div onclick="window.open('/website-information/?id=<?php echo $website->ID ?>');" class="sixth_column column"><?php echo $site_theme_name; ?></div>
										<div onclick="window.open('/website-information/?id=<?php echo $website->ID ?>');" class="seventh_column column"><?php echo $site_theme_version; ?></div>
										<div onclick="window.open('/website-information/?id=<?php echo $website->ID ?>');" class="eighth_column column"><?php echo $site_hosting_name; ?></div>
										<div onclick="window.open('/website-information/?id=<?php echo $website->ID ?>');" class="ninth_column column"><?php echo $site_domain_name; ?></div>
										<div class="tenth_column column">
											<p style="display:none" id="website_button_note_<?php echo $website->ID; ?>" class="website_button_note"></p>
											<a id="login_button_<?php echo $website->ID; ?>" class="button_2 display_button website_login_button" href="http://<?php echo $site_login_url; ?>">L</a>
											<a id="edit_button_<?php echo $website->ID; ?>" class="button_2 display_button website_edit_button" href="/edit-website/?editID=<?php echo $website->ID ?>">E</a>
											<div class="ajax_action_buttons">									
												<div id="delete_project_<?php echo $website->ID; ?>" class="button_2 display_button float_right delete_website_button delete_ajax">D</div>
											</div>
											<div class="get_wp_th_details_section">									
												<div id="get_wp_th_details_<?php echo $website->ID; ?>" class="button_2 display_button get_wp_th_details float_left">C</div>												
											</div>
											<div id="website_action_loader_<?php echo $website->ID; ?>" style="display:none;" class="loader website_action_loader"></div>
										</div>
									</div>
									<?php 
									}
								}
							}
						?>
					</div>
					<!------------------------------------------------------ SEO STATS ------------------------------------------------------->
					<div id="seo_stats" class="tab tab_content" style="display: none;">								
						<div class="header_titles">
							<div class="first_column column">
								<h3>Client</h3>
								<div style="display:none" class="asc_button seo_stat_client_sort_asc"></div>
								<div class="desc_button seo_stat_client_sort_desc"></div>
								<div style="display:none" class="seo_stat_client_sort_loader loader"></div>
							</div>
							<div class="second_column column"><h3>URL</h3></div>
							<div class="third_column column">
								<h3>Type</h3>
								<div class="asc_button seo_stat_type_sort_asc"></div>
								<div style="display:none" class="desc_button seo_stat_type_sort_desc"></div>
								<div style="display:none" class="seo_stat_type_sort_loader loader"></div>
							</div>
							<div class="fourth_column column">
								<h3>Platform</h3>
								<div class="asc_button seo_stat_platform_sort_asc"></div>
								<div style="display:none" class="desc_button seo_stat_platform_sort_desc"></div>
								<div style="display:none" class="seo_stat_platform_sort_loader loader"></div>
							</div>
							<div class="fifth_column column"><h3>Page Authority</h3></div>
							<div class="sixth_column column"><h3>Domain Authority</h3></div>
							<div class="seventh_column column"><h3>Moz Rank</h3></div>
							<div class="eighth_column column"><h3>Moz Trust</h3></div>
							<div class="ninth_column column"><h3>External Links</h3></div>
							<div class="tenth_column column">
								<div class="bulk_get_metrix_button">									
									<div class="button_2 display_button bulk_get_metrix float_right">C</div>
									<div style="display:none;" class="loader bulk_get_metrix_loader float_right"></div>
								</div>
							</div>
						</div>
						<?php 
							foreach($clients as $client){
								foreach($websites as $website){
									if($website->site_client == $client->client_name){
										$website_id 			= $website->ID;										
										$site_url 				= ($website->site_url != "" ? $website->site_url : "--");
										$site_client 			= ($website->site_client != "" ? $website->site_client : "--");
										$site_type 				= ($website->site_type != "" ? $website->site_type : "--");
										$site_platform 			= ($website->site_platform != "" ? $website->site_platform : "--");
										$site_login_url 		= ($website->site_login_url != "" ? $website->site_login_url : "#");	
											
										$website_moz 			= $wpdb->get_row("SELECT * FROM {$table_name_website_moz} WHERE moz_website_id='$website_id'");
										$moz_datetime 			= ($website_moz->moz_datetime != "" ? $website_moz->moz_datetime : "--");
										$moz_page_authority 	= ($website_moz->moz_page_authority != "" ? $website_moz->moz_page_authority : "--");
										$moz_domain_authority	= ($website_moz->moz_domain_authority != "" ? $website_moz->moz_domain_authority : "--");
										$moz_rank				= ($website_moz->moz_rank != "" ? $website_moz->moz_rank : "--");
										$moz_external_links		= ($website_moz->moz_external_links != "" ? $website_moz->moz_external_links : "--");
										$moz_trust				= ($website_moz->moz_trust != "" ? $website_moz->moz_trust : "--");
										
						?>
									<div id="moz_metrix_<?php echo $website_id ."join". $client->ID; ?>" class="website_<?php echo $website->ID; ?> info_div delete_ajax_<?php echo $website_id; ?>">
										<div id="name_<?php echo $website_id; ?>" class="client_info first_column column"><?php echo $site_client; ?></div>
										<div class="second_column column"><a href="<?php echo $site_url; ?>"><?php echo $site_url; ?></a></div>										
										<div class="third_column column"><?php echo $site_type ?></div>										
										<div class="fourth_column column"><?php echo $site_platform ?></div>										
										<div class="fifth_column column"><?php echo $moz_page_authority ?></div>
										<div class="sixth_column column"><?php echo $moz_domain_authority ?></div>
										<div class="seventh_column column"><?php echo $moz_rank ?></div>
										<div class="eighth_column column"><?php echo $moz_trust ?></div>
										<div class="ninth_column column"><?php echo $moz_external_links ?></div>
										<div class="tenth_column column">
											<p style="display:none" id="website_button_note_<?php echo $website->ID; ?>" class="website_button_note"></p>
											<a id="login_button_<?php echo $website->ID; ?>" class="button_2 display_button seo_stat_login_button website_login_button" href="http://<?php echo $site_login_url; ?>">L</a>
											<a id="edit_button_<?php echo $website->ID; ?>" class="button_2 display_button website_edit_button" href="/edit-website/?editID=<?php echo $website->ID ?>">E</a>
											<div class="ajax_action_buttons">									
												<div id="delete_project_<?php echo $website_id; ?>" class="button_2 display_button float_left delete_website_button delete_ajax">D</div>
											</div>
											<div class="get_metrix_button">									
												<div id="get_metrix_<?php echo $website_id ."join". $client->ID; ?>" class="button_2 display_button get_metrix float_left">C</div>
												<div id="get_metrix_loader_<?php echo $website_id ."join". $client->ID; ?>" style="display:none;" class="loader"></div>
											</div>
										</div>
									</div>
						<?php
									}
								}
							}
						?>
					</div>							
				</div>
			</div>
		</div>
	</div>
</div>
<div style="display:none;" class="dialog_form_delete_ajax" id="dialog_form_delete_website" title="Delete Website">
	<form class="delete_action_ajax" id="delete_website">
		<p class="label">
			Are you sure you want to delete 
			<span class="delete_name"></span>
			<span style="display:none;" class="delete_prep">from</span>
			<span style="display:none;" class="delete_parent"></span>
		</p>	
		<div class="button_1 delete_button_ajax">Delete</div>
		<div style="display:none" class="loader delete_ajax_loader"></div>
		<input type="hidden" class="delete_id" name="delete_id" />
		<input type="hidden" class="delete_type" name="delete_type" value="Website" />		
	</form>
</div>	
<div style="display:none;" class="dialog_client_information" id="dialog_client_information" title="Client Information">
	<div class="full_width">
		<div class="one_half">
			<p class="label">Customer Info:</p>
			<p class="client_name"></p>
			<p class="client_address"></p>
			<p class="label">Contact Person:</p>
			<p class="client_contact_person"></p>
			<p class="client_contact_phone"></p>
			<p class="client_contact_email"></p>
		</div>
		<div class="one_half last">
			<div class="full_width">
				<p class="label">Monthly Plan: </p>
				<p class="client_monthly_plan"></p>
			</div>
			<div class="full_width">
				<p class="label">Customer Satisfaction: </p>
				<p class="client_satisfaction"></p>
			</div>
			<div class="full_width">
				<p class="label">Current Active WebDev Projects: </p>
				<p class="current_active_webdev_projects"></p>
			</div>
			<div class="full_width">
				<p class="label">Monthly Ongoing Stat: </p>
				<p class="monthly_ongoing_stat"></p>
			</div>
		</div>
	</div>
	<div class="full_width">
		<h3>Customer Sites</h3>
		<div class="header_titles">
			<div class="first_column column">URL</div>
			<div class="second_column column">Site Type</div>
			<div class="third_column column">Platform</div>
			<div class="fourth_column column">Version</div>
			<div class="fifth_column column">Username</div>
			<div class="sixth_column column">Password</div>
			<div class="seventh_column column">L</div>
		</div>
		<div class="site_container"></div>
	</div>
</div>
<?php get_footer(); ?>