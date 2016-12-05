<?php /* Template Name: Website Information */ ?>
<?php get_header(); ?>
<?php
	$id = $_GET['id'];
	$table_name = $wpdb->prefix . "custom_website"; 
	$website = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = '$id'");
?>
<div class="info_website">
	<div class="section">
		<div class="left">
			<p class="label">Site URL</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_url ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Wordpress Version</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_wp_version ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Theme Name</p>
			<p class="label">Theme Version</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_theme_name ?></p>
			<p><?php echo $website->site_theme_version ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Site Type</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_type ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Site Client</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_client ?></p>				
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Site Platform</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_platform ?></p>				
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Site Login URL</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_login_url ?></p>				
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Site Login Credentials</p>
		</div>
		<div class="right">
			<div class="full_width">
				<p class="right_label">Username:</p>
				<p class="float_left"><?php echo $website->site_username ?></p>
			</div>
			<div class="full_width">
				<p class="right_label">Password:</p>
				<p class="float_left"><?php echo $website->site_password ?></p>
			</div>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Hosting Name</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_hosting_name ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Domain Registrar</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_domain_name ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Domain Owner</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_domain_owner ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Renewal date</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_renewal_date ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Cost</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_cost ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">MySQL Server URL</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_mysql_url ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">MySQL Server Login Credentials</p>
		</div>
		<div class="right">
			<div class="full_width">
				<p class="right_label">Login:</p>
				<p><?php echo $website->site_mysql_username ?></p>
			</div>
			<div class="full_width">
				<p class="right_label">Password:</p>
				<p><?php echo $website->site_mysql_password ?></p>
			</div>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">MySQL Database</p>
		</div>
		<div class="right">
			<div class="full_width">
				<p class="right_label">Name:</p>
				<p><?php echo $website->site_database_name ?></p>
			</div>
			<div class="full_width">
				<p class="right_label">Username</p>
				<p><?php echo $website->site_database_username ?></p>				
			</div>
			<div class="full_width">
				<p class="right_label">Password:</p>
				<p><?php echo $website->site_database_password ?></p>
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
				<p><?php echo $website->site_ftp_server ?></p>
			</div>
			<div class="full_width">
				<p class="right_label">Username</p>
				<p><?php echo $website->site_ftp_username ?></p>
			</div>
			<div class="full_width">
				<p class="right_label">Password</p>
				<p><?php echo $website->site_ftp_password ?></p>
			</div>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Additional Information:</p>
		</div>
		<div class="right">
			<p><?php echo $website->site_additional_info ?></p>
		</div>
	</div>	
	<a class="button_2 display_button" href="/website/">Return</a>
	<a id="create_clients" class="button_1 display_button padding_button" href="/add-website/">+ Add Website</a>
	<a class="button_2 display_button" href="/edit-website/?editID=<?php echo $website->ID ?>">Edit</a>
	<a class="button_2 display_button confirm" href="/website/?deleteID=<?php echo $website->ID ?>">Delete</a>
</div>
<?php get_footer(); ?>