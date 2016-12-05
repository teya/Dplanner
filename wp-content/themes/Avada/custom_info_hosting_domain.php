<?php /* Template Name: Hosting & Domain Information */  ?>
<?php get_header(); ?>
<?php
$id = $_GET['id'];
$table_name = $wpdb->prefix . "custom_hosting_domain"; 
$hosting_domain = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = '$id'");
if($hosting_domain->site_status == 'Hosting'){
	$title = "Hosting";
	$name = $hosting_domain->site_hosting_name;
	$url = $hosting_domain->site_hosting_url;
	$username = $hosting_domain->site_hosting_username;
	$password = $hosting_domain->site_hosting_password;
	$additional_info = $hosting_domain->site_hosting_info;
}elseif($hosting_domain->site_status == 'Domain'){
	$title = "Domain";
	$name = $hosting_domain->site_domain_name;
	$url = $hosting_domain->site_domain_url;
	$username = $hosting_domain->site_domain_username;
	$password = $hosting_domain->site_domain_password;
	$additional_info = $hosting_domain->site_domain_info;
}
?>
	<div class="info_hosting_domain">
		<div class="section">
			<div class="left">
				<p class="label"><?php echo $title; ?> Name</p>
			</div>
			<div class="right">
				<p><?php echo $name; ?></p>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label"><?php echo $title; ?> URL</p>
			</div>
			<div class="right">
				<p><?php echo $url; ?></p>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label"><?php echo $title; ?> Username</p>
			</div>
			<div class="right">
				<p><?php echo $username; ?></p>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label"><?php echo $title; ?> Password</p>
			</div>
			<div class="right">
				<p><?php echo $password; ?></p>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label"><?php echo $title; ?> Additional Info</p>
			</div>
			<div class="right">
				<p><?php echo $additional_info; ?></p>
			</div>
		</div>
	</div>
	<a class="button_2 display_button" href="/hosting-domain/">Return</a>
	<a id="create_projects" class="button_1 display_button padding_button add_hosting_domain_button" href="/add-hosting-domain/">+ Add Hosting/Domain</a>
	<a class="button_2 display_button" href="/edit-hosting-domain/?id=<?php echo $id ?>">Edit</a>
	<a class="button_2 display_button" href="/hosting-domain/?deleteID=<?php echo $id ?>">Delete</a>
</div>
<?php get_footer(); ?>