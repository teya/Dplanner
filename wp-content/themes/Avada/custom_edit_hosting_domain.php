<?php /* Template Name: Edit Hosting & Domain */  ?>
<?php get_header(); ?>
<?php
global $wpdb;
$id = $_GET['id'];
$table_name = $wpdb->prefix . "custom_hosting_domain";
?>
<?php
if(isset($_POST['submit'])){
	$check = $wpdb->get_row("SELECT * FROM $table_name WHERE ID=$id");
	if($check->site_status == 'Hosting'){
		$site_hosting_name		= $_POST['hd_name'];
		$site_hosting_url		= $_POST['url'];
		$site_hosting_username	= $_POST['username'];
		$site_hosting_password	= $_POST['password'];
		$site_hosting_info		= $_POST['additional_info'];
		$status = 'Hosting';
	}elseif($check->site_status == 'Domain'){
		$site_domain_name		= $_POST['hd_name'];
		$site_domain_url		= $_POST['url'];
		$site_domain_username	= $_POST['username'];
		$site_domain_password	= $_POST['password'];
		$site_domain_info		= $_POST['additional_info'];
		$status = 'Domain';
	}
	$update = $wpdb->update( $table_name , array( 
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
	),
	array( 'ID' => $id ),
	array( '%s', '%s' ));	
	if($update == 1){
		echo "<p class='message'>";
		echo $status . " Updated!";
		echo "</p>";
	}else{
		echo "<p class='message'>";
		echo $status . " was not successfully Updated.";
		echo "</p>";
	}	
}

$results_edit = $wpdb->get_row("SELECT * FROM $table_name WHERE ID=$id");
if($results_edit->site_status == 'Hosting'){
	$title = "Hosting";
	$hd_name = (isset($results_edit->site_hosting_name)) ? $results_edit->site_hosting_name : '';
	$url = (isset($results_edit->site_hosting_url)) ? $results_edit->site_hosting_url : '';
	$username = (isset($results_edit->site_hosting_username)) ? $results_edit->site_hosting_username : '';
	$password = (isset($results_edit->site_hosting_password)) ? $results_edit->site_hosting_password : '';
	$additional_info = (isset($results_edit->site_hosting_info)) ? $results_edit->site_hosting_info : '';
}elseif($results_edit->site_status == 'Domain'){
	$title = "Domain";
	$hd_name = (isset($results_edit->site_domain_name)) ? $results_edit->site_domain_name : '';
	$url = (isset($results_edit->site_domain_url)) ? $results_edit->site_domain_url : '';
	$username = (isset($results_edit->site_domain_username)) ? $results_edit->site_domain_username : '';
	$password = (isset($results_edit->site_domain_password)) ? $results_edit->site_domain_password : '';
	$additional_info = (isset($results_edit->site_domain_info)) ? $results_edit->site_domain_info : '';
}
?>
<div class="edit_hosting_domain">
	<form action="" method="post" name="hosting_domain" id="hosting_domain">
		<div class="section">
			<div class="left">
				<p class="label">Name</p>
			</div>
			<div class="right">
				<input type="text" name="hd_name" class="name" value="<?php echo $hd_name; ?>" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label"><?php echo $title; ?> URL</p>
			</div>
			<div class="right">
				<input type="text" name="url" class="url" value="<?php echo $url; ?>" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label"><?php echo $title; ?> Username</p>
			</div>
			<div class="right">
				<input type="text" name="username" class="username" value="<?php echo $username; ?>" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label"><?php echo $title; ?> Password</p>
			</div>
			<div class="right">
				<input type="text" name="password" class="password" value="<?php echo $password; ?>" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Additional Info</p>
			</div>
			<div class="right">
				<textarea cols="50" class="additional_info" name="additional_info"><?php echo $additional_info; ?></textarea>
			</div>
		</div>
		<input type="submit" name="submit" class="add_hosting/domain button_1" value="Update" />
		<a class="button_2" href="/hosting-domain/">Cancel</a>
	</form>
</div>
<?php get_footer(); ?>