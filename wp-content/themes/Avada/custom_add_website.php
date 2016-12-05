<?php /* Template Name: Add Website */ ?>
<?php get_header(); ?>
<?php 
global $wpdb;
$table_name = $wpdb->prefix . "custom_website";
$table_name_client = $wpdb->prefix . "custom_client";
$table_name_hosting_domain = $wpdb->prefix . "custom_hosting_domain";
$table_name_platform = $wpdb->prefix . "custom_platform";
$clients = $wpdb->get_results("SELECT * FROM $table_name_client");
$hosting_domain = $wpdb->get_results("SELECT * FROM $table_name_hosting_domain");
$site_platforms = $wpdb->get_results("SELECT * FROM $table_name_platform");
?>
<?php 
$site_types = array('Affiliate site', 'Demo site', 'Main site', 'PBN site T1', 'PBN site T2', 'Secondary site');
$site_domain_owners = array('Customer', 'SEOWEB');
?>
<div class="add_website website_style">
	<form action="" method="post" name="website" id="website">
		<div class="section">
			<div class="left">
				<p class="label">Site URL:</p>
			</div>
			<div class="right">
				<input type="text" name="site_url" class="site_url" placeholder="http://">	
				<div class="error_message"><p></p></div>
				<div class="get_details_buttons">
					<div class="button_1 get_wp_details">Get WP Details</div>
					<div class="button_1 get_theme_details">Get Theme Details</div>	
					<div style="display:none;" class="loader"></div>
				</div>
			</div>				
		</div>
		<div class="border_separator"></div>		
		<div style="display:none" class="section wp_readme_details"></div>
		<div class="section wp_version"></div>
		<div class="section theme_details"></div>
		<div class="section">
			<div class="left">
				<p class="label">Site Type:</p>
			</div>
			<div class="right">
				<select name="site_type">
					<?php
						$website_site_type_array = array();
						foreach($site_types as $site_type){ 
							$website_site_type_array[] = $site_type;
						}
						sort($website_site_type_array);						
					?>
					<?php foreach($website_site_type_array as $website_site_type){	?>
						<option><?php echo $website_site_type; ?></option>
					<?php } ?>
				</select>	
			</div>				
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Site Client:</p>
			</div>
			<div class="right">
				<select name="site_client">
					<?php
						$website_client_array = array();
						foreach($clients as $client){ 
							$website_client_array[] = $client->client_name;
						}
						sort($website_client_array);						
					?>
					<?php foreach($website_client_array as $website_client){ ?>
						<option><?php echo $website_client; ?></option>
					<?php } ?>
				</select>	
			</div>				
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Site Platform:</p>
			</div>
			<div class="right">
				<select class="site_platform" name="site_platform">
					<?php
						$website_site_platform_array = array();
						foreach($site_platforms as $site_platform){ 
							$website_site_platform_array[] = $site_platform->site_platform;
						}
						sort($website_site_platform_array);						
					?>
					<?php foreach($website_site_platform_array as $website_site_platform){ ?>
						<option><?php echo $website_site_platform; ?></option>
					<?php } ?>
						<option>Other</option>
				</select>
				<div style="display:none" class="add_other_platform">
					<input type="text" name="other_platform" class="other_platform" />
				</div>
			</div>				
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Site Login URL:</p>
			</div>
			<div class="right">
				<input type="text" name="site_login_url" />
			</div>				
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Site Login Credentials:</p>
			</div>
			<div class="right">
				<div class="full_width">
					<p class="right_label">Username</p>
					<input type="text" class="site_username input_float_left" name="site_username" />
				</div>
				<div class="full_width">
					<p class="right_label">Password</p>
					<input type="text" class="site_password input_float_left" name="site_password" />
				</div>
			</div>
		</div>
		<div class="border_separator"></div>		
		<div class="section">
			<div class="left">
				<p class="label">Hosting name:</p>
			</div>
			<div class="right">				
				<select class="site_hosting_name" name="site_hosting_name">
					<option>Unknown</option>
					<?php
						$website_hosting_array = array();
						foreach($hosting_domain as $hosting){ 
							$website_hosting_array[] = $hosting->site_hosting_name;
						}
						sort($website_hosting_array);						
					?>
					<?php 
						foreach($website_hosting_array as $website_hosting){							
							if($website_hosting != null){
					?>
						<option><?php echo $website_hosting; ?></option>
				<?php	
							}
						}
					?>
				</select>
				<div class="button_2 add_hosting add_other_hosting_domain">Add Hosting</div>
				<div style="display: none;" class="add_hosting_url add_hosting_domain_div">
					<div class="add_url_details">
						<div class="left">
							<p class="label">Hosting Name</p>
							<input type="text" name="add_site_hosting_name" class="add_site_hosting_name add_hosting_domain_input" />
							<p class="label">Hosting URL</p>						
							<input type="text" name="add_site_hosting_url" class="add_site_hosting_url add_hosting_domain_input" />
						</div>
						<div class="left">
							<p class="label">Hosting Username</p>
							<input type="text" name="add_site_hosting_username" class="add_site_hosting_username add_hosting_domain_input" />
							<p class="label">Hosting Password</p>
							<input type="text" name="add_site_hosting_password" class="add_site_hosting_password add_hosting_domain_input" />
							<div class="button_1 save_hosting_url">Add</div>
						</div>
					</div>
					<div style="display: none;" class="loader hosting_domain_loader"></div>
				</div>
			</div>			
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Domain Registrar:</p>
			</div>
			<div class="right">
				<?php $domain_count = count($domains); ?>
				<select class="site_domain_name" name="site_domain_name">
					<option>Unknown</option>
					<optgroup label = "Domain Registrars">
					<?php
						$website_domain_array = array();
						foreach($hosting_domain as $domain){ 
							$website_domain_array[] = $domain->site_domain_name;
						}
						sort($website_domain_array);						
					?>
					<?php 
						foreach($website_domain_array as $website_domain){
							if($website_domain != null){ 
					?>
							<option><?php echo $website_domain; ?></option>
							<?php	
							}
						}
					?>
					</optgroup>
					<optgroup label = "Hosting">
					<?php
						$website_hosting_array = array();
						foreach($hosting_domain as $hosting){ 
							$website_hosting_array[] = $hosting->site_hosting_name;
						}
						sort($website_hosting_array);						
					?>
					<?php 
						foreach($website_hosting_array as $website_hosting){							
							if($website_hosting != null){
							?>
							<option><?php echo $website_hosting; ?></option>
							<?php	
							}
						}
					?>
					</optgroup>
				</select>
				<div class="button_2 add_domain add_other_hosting_domain">Add Domain</div>
				<div style="display: none;" class="add_domain_url add_hosting_domain_div">
					<div class="add_url_details">
						<div class="left">
							<p class="label">Domain Name</p>
							<input type="text" name="add_site_domain_name" class="add_site_domain_name add_hosting_domain_input" />
							<p class="label">Domain URL</p>
							<input type="text" name="add_site_domain_url" class="add_site_domain_url add_hosting_domain_input" />
						</div>
						<div class="left">
							<p class="label">Domain Username</p>
							<input type="text" name="add_site_domain_username" class="add_site_domain_username add_hosting_domain_input" />
							<p class="label">Domain Password</p>
							<input type="text" name="add_site_domain_password" class="add_site_domain_password add_hosting_domain_input" />
							<div class="button_1 save_domain_url">Add</div>
						</div>
					</div>
					<div style="display: none;" class="loader hosting_domain_loader"></div>
				</div>
			</div>			
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Domain Owner:</p>
			</div>
			<div class="right">
				<select class="site_domain_owner" name="site_domain_owner">
					<?php foreach($site_domain_owners as $site_domain_owner){ ?>
						<option><?php echo $site_domain_owner; ?></option>
					<?php } ?>
				</select>				
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Renewal date:</p>
			</div>
			<div class="right">
				<input type="text" class="site_renewal_date" name="site_renewal_date" />				
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Cost:</p>
			</div>
			<div class="right">
				<input type="text" class="site_cost" name="site_cost" />				
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">MySQL Server URL:</p>
			</div>
			<div class="right">
				<input type="text" class="site_mysql_url" name="site_mysql_url" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">MySQL Server Login Credentials:</p>
			</div>
			<div class="right">
				<div class="full_width">
					<p class="right_label">Username</p>
					<input type="text" class="site_mysql_username input_float_left" name="site_mysql_username" />
				</div>
				<div class="full_width">
					<p class="right_label">Password</p>
					<input type="text" class="site_mysql_password input_float_left" name="site_mysql_password" />
				</div>
			</div>
		</div>
		<div class="border_separator"></div>		
		<div class="section">
			<div class="left">
				<p class="label">MySQL Database:</p>
			</div>
			<div class="right">
				<div class="full_width">
					<p class="right_label">Name</p>
					<input type="text" class="site_database_name input_float_left" name="site_database_name" />
				</div>
				<div class="full_width">
					<p class="right_label">Username</p>
					<input type="text" class="site_database_username input_float_left" name="site_database_username" />
				</div>
				<div class="full_width">
					<p class="right_label">Password</p>
					<input type="text" class="site_database_password input_float_left" name="site_database_password" />
				</div>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">FTP server:</p>
			</div>
			<div class="right">
				<div class="full_width">					
					<input type="text" class="site_ftp_server input_float_left" name="site_ftp_server" />
				</div>
				<div class="full_width">
					<p class="right_label">Username</p>
					<input type="text" class="site_ftp_username input_float_left" name="site_ftp_username" />
				</div>
				<div class="full_width">
					<p class="right_label">Password</p>
					<input type="text" class="site_ftp_password input_float_left" name="site_ftp_password" />
				</div>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Additional Information:</p>
			</div>
			<div class="right">
				<textarea name="site_additional_info" class="site_additional_info textarea_wide"></textarea>
			</div>
		</div>		
		<input type="submit" name="submit" class="button_1" value="Add Website" />
		<a class="button_2" href="/websites/">Cancel</a>
	</form>
</div>
<?php 
if(isset($_POST['submit'])):
	global $wpdb;	
	$site_url					= (isset($_POST['site_url']) ? $_POST['site_url'] : '');
	$site_wp_version			= (isset($_POST['site_wp_version']) ? $_POST['site_wp_version'] : '');
	$site_theme_name			= (isset($_POST['site_theme_name']) ? $_POST['site_theme_name'] : '');
	$site_theme_version			= (isset($_POST['site_theme_version']) ? $_POST['site_theme_version'] : '');
	$site_type					= (isset($_POST['site_type']) ? $_POST['site_type'] : '');
	$site_client				= (isset($_POST['site_client']) ? $_POST['site_client'] : '');
	$site_platform_select		= (isset($_POST['site_platform']) ? $_POST['site_platform'] : '');
	if($site_platform_select == 'Other'){
		$site_platform = (isset($_POST['other_platform']) ? $_POST['other_platform'] : '');
		if($site_platform != null){
			$insert_platform = $wpdb->insert( $table_name_platform , array( 
				'site_platform'	=> $site_platform
			), array( '%s', '%s' ));
		}
	}else{
		$site_platform = (isset($_POST['site_platform']) ? $_POST['site_platform'] : '');
	}
	$site_login_url				= (isset($_POST['site_login_url']) ? $_POST['site_login_url'] : '');
	$site_username				= (isset($_POST['site_username']) ? $_POST['site_username'] : '');
	$site_password				= (isset($_POST['site_password']) ? $_POST['site_password'] : '');
	$site_hosting_name			= (isset($_POST['site_hosting_name']) ? $_POST['site_hosting_name'] : '');
	$site_domain_name			= (isset($_POST['site_domain_name']) ? $_POST['site_domain_name'] : '');
	$site_domain_owner			= (isset($_POST['site_domain_owner']) ? $_POST['site_domain_owner'] : '');
	$site_renewal_date			= (isset($_POST['site_renewal_date']) ? $_POST['site_renewal_date'] : '');
	$site_cost					= (isset($_POST['site_cost']) ? $_POST['site_cost'] : '');
	$site_mysql_url				= (isset($_POST['site_mysql_url']) ? $_POST['site_mysql_url'] : '');
	$site_mysql_username		= (isset($_POST['site_mysql_username']) ? $_POST['site_mysql_username'] : '');
	$site_mysql_password		= (isset($_POST['site_mysql_password']) ? $_POST['site_mysql_password'] : '');
	$site_database_name			= (isset($_POST['site_database_name']) ? $_POST['site_database_name'] : '');
	$site_database_username		= (isset($_POST['site_database_username']) ? $_POST['site_database_username'] : '');
	$site_database_password		= (isset($_POST['site_database_password']) ? $_POST['site_database_password'] : '');
	$site_ftp_server			= (isset($_POST['site_ftp_server']) ? $_POST['site_ftp_server'] : '');
	$site_ftp_username			= (isset($_POST['site_ftp_username']) ? $_POST['site_ftp_username'] : '');
	$site_ftp_password			= (isset($_POST['site_ftp_password']) ? $_POST['site_ftp_password'] : '');
	$site_additional_info		= (isset($_POST['site_additional_info']) ? $_POST['site_additional_info'] : '');
		
	$insert = $wpdb->insert( $table_name , array( 
		'site_url'					=> $site_url,
		'site_wp_version'			=> $site_wp_version,
		'site_theme_name'			=> $site_theme_name,
		'site_theme_version'		=> $site_theme_version,
		'site_type'					=> $site_type,
		'site_client'				=> $site_client,
		'site_platform'				=> $site_platform,
		'site_login_url'			=> $site_login_url,
		'site_username'				=> $site_username,
		'site_password'				=> $site_password,
		'site_hosting_name'			=> $site_hosting_name,
		'site_domain_name'			=> $site_domain_name,
		'site_domain_owner'			=> $site_domain_owner,
		'site_renewal_date'			=> $site_renewal_date,
		'site_cost'					=> $site_cost,
		'site_mysql_url'			=> $site_mysql_url,
		'site_mysql_username'		=> $site_mysql_username,
		'site_mysql_password'		=> $site_mysql_password,
		'site_database_name'		=> $site_database_name,
		'site_database_username'	=> $site_database_username,
		'site_database_password'	=> $site_database_password,
		'site_ftp_server'			=> $site_ftp_server,
		'site_ftp_username'			=> $site_ftp_username,
		'site_ftp_password'			=> $site_ftp_password,
		'site_additional_info'		=> $site_additional_info
	), array( '%s', '%s' ));
	
	if($insert == 1):
		echo "<p class='message'>";
		echo "Website Added!";
	else:
		echo "Website was not successfully added.";
		echo "</p>";
	endif;		
endif;
?>
<?php get_footer(); ?>