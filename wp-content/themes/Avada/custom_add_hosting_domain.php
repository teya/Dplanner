<?php /* Template Name: Add Hosting & Domain */ ?>
<?php get_header(); ?>
<?php 
if(isset($_POST['submit'])){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_hosting_domain";
	
	$add_option = $_POST['option_add'];
	if($add_option == 'hosting'){
		$site_hosting_name		= (isset($_POST['hd_name']) ? $_POST['hd_name'] : '');
		$site_hosting_url		= (isset($_POST['url']) ? $_POST['url'] : '');
		$site_hosting_username	= (isset($_POST['username']) ? $_POST['username'] : '');
		$site_hosting_password	= (isset($_POST['password']) ? $_POST['password'] : '');
		$site_hosting_info		= (isset($_POST['additional_info']) ? $_POST['additional_info'] : '');
		$site_domain_name		= '';
		$site_domain_url		= '';
		$site_domain_username	= '';
		$site_domain_password	= '';
		$site_domain_info		= '';
		$status = 'Hosting';
	}elseif($add_option == 'domain'){		
		$site_domain_name		= (isset($_POST['hd_name']) ? $_POST['hd_name'] : '');
		$site_domain_url		= (isset($_POST['url']) ? $_POST['url'] : '');
		$site_domain_username	= (isset($_POST['username']) ? $_POST['username'] : '');
		$site_domain_password	= (isset($_POST['password']) ? $_POST['password'] : '');
		$site_domain_info		= (isset($_POST['additional_info']) ? $_POST['additional_info'] : '');
		$site_hosting_name		= '';
		$site_hosting_url		= '';
		$site_hosting_username	= '';
		$site_hosting_password	= '';
		$site_hosting_info		= '';
		$status = 'Domain';
	}
	
	$insert = $wpdb->insert( $table_name , array(
	'site_status'			=> $status,
	'site_hosting_name'		=> $site_hosting_name,
	'site_hosting_url'		=> $site_hosting_url,
	'site_hosting_username'	=> $site_hosting_username,
	'site_hosting_password'	=> $site_hosting_password,
	'site_hosting_info'		=> $site_hosting_info,
	'site_domain_name'		=> $site_domain_name,
	'site_domain_url'		=> $site_domain_url,
	'site_domain_username'	=> $site_domain_username,
	'site_domain_password'	=> $site_domain_password,
	'site_domain_info'		=> $site_domain_info
	), array( '%s', '%s' ));
	
	// $wpdb->show_errors();
	// $wpdb->print_error();
	
	if($insert == 1){
		echo "<p class='message'>";
		echo $status . " Added!";
	}else{
		echo $status . " was not successfully added.";
		echo "</p>";
	}		
}
?>
<div class="add_hosting_domain">
	<form action="" method="post" name="hosting_domain" id="hosting_domain">
		<div class="section">
			<div class="left">
				<p class="label">Add: </p>
			</div>
			<div class="right">
				<input type="radio" name="option_add" class="option_add hosting" value="hosting" required />Hosting Companies
				<input type="radio" name="option_add" class="option_add domain" value="domain" required />Domain Registrar
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Name</p>
			</div>
			<div class="right">
				<input type="text" name="hd_name" class="hd_name" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">URL</p>
			</div>
			<div class="right">
				<input type="text" name="url" class="url" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Login Credentials:</p>
			</div>
			<div class="right">
				<div class="full_width">
					<p class="right_label">Username</p>
					<input type="text" class="username input_float_left" name="username" />
				</div>
				<div class="full_width">
					<p class="right_label">Password</p>
					<input type="text" class="password input_float_left" name="password" />
				</div>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Additional Info</p>
			</div>
			<div class="right">
				<textarea cols="50" class="additional_info" name="additional_info"></textarea>
			</div>
		</div>
		<input type="submit" name="submit" class="button_1 add_hosting_domain_button" value="Add Hosting/Domain" />
		<a class="button_2" href="/hosting-domain/">Cancel</a>
	</form>
</div>
<?php get_footer(); ?>