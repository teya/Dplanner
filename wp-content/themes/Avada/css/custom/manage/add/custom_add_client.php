<?php /* Template name: Add Client */ ?>
<?php 
get_header(); 
global $wpdb;			
$table_name = $wpdb->prefix . "custom_client";
?>
<div class="add_client">
	<form action="" method="post" name="client" id="client">
		<div class="section">
			<div class="left">
				<p class="label">Name</p>
			</div>
			<div class="right">
				<input type="text" class="client_name" name="client_name" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Address</p>
			</div>
			<div class="right">
				<textarea name="client_address" class="client_address textarea_wide"></textarea>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Contact Person</p>
			</div>
			<div class="right">
				<input type="text" class="client_contact_person" name="client_contact_person" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Contact Phone</p>
			</div>
			<div class="right">
				<input type="text" class="client_contact_phone" name="client_contact_phone" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Contact E-mail</p>
			</div>
			<div class="right">
				<input type="text" class="client_contact_email" name="client_contact_email" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Website URL</p>
			</div>
			<div class="right">
				<input type="text" class="client_website_url" name="client_website_url" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Website login URL</p>
			</div>
			<div class="right">
				<input type="text" class="client_website_login_url" name="client_website_login_url" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Login Credentials</p>
			</div>
			<div class="right">
				<div class="full_width">
					<p class="right_label">Username</p>
					<input type="text" class="client_username input_float_left" name="client_username" />
				</div>
				<div class="full_width">
					<p class="right_label">Password</p>
					<input type="text" class="client_password input_float_left" name="client_password" />
				</div>
			</div>
		</div>
		<input type="submit" name="submit" class="button_1" value="Add Client" />
		<a class="button_2" href="/add-client/">Cancel</a>
	</form>
</div>
<?php
if(isset($_POST['submit'])):
	global $wpdb;
	$client_name				= $_POST['client_name'];
	$client_address				= $_POST['client_address'];
	$client_contact_person		= $_POST['client_contact_person'];
	$client_contact_phone		= $_POST['client_contact_phone'];
	$client_contact_email		= $_POST['client_contact_email'];
	$client_website_url			= $_POST['client_website_url'];
	$client_website_login_url	= $_POST['client_website_login_url'];
	$client_username			= $_POST['client_username'];
	$client_password			= $_POST['client_password'];
		
	$insert = $wpdb->insert( $table_name , array( 
	'client_name'				=> $client_name,
	'client_address'			=> $client_address,
	'client_contact_person'		=> $client_contact_person,
	'client_contact_phone'		=> $client_contact_phone,
	'client_contact_email'		=> $client_contact_email,
	'client_website_url'		=> $client_website_url,
	'client_website_login_url'	=> $client_website_login_url,
	'client_username'			=> $client_username,
	'client_password'			=> $client_password	
	), array( '%s', '%s' ));
	
	if($insert == 1):
		echo "<p class='message'>";
		echo "Client Added!";
	else:
		echo "Client was not successfully added.";
		echo "</p>";
	endif;
	
endif;
?>
<?php get_footer(); ?>