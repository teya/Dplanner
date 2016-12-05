<?php /* Template name: Add People */ ?>
<?php get_header(); ?>
<?php include('custom_timezones.php'); 
global $wpdb;
$table_name = $wpdb->prefix . "custom_person";
$table_name_department = $wpdb->prefix . "custom_department";
$departments = $wpdb->get_col("SELECT DISTINCT department_name FROM {$table_name_department}");	
$permission_array = array("Administrator", "Project Manager", "User");
?>
<div class="add_person">
	<form action="" method="post" name="person" enctype="multipart/form-data" id="person">
		<div class="section">
			<div class="left">
				<p class="label">Person Type</p>
			</div>
			<div class="right">
				<input type="checkbox" name="person_type" value="1" class="person_type checkbox">Employee<br/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">First Name</p>
			</div>
			<div class="right">
				<input type="text" class="person_first_name" name="person_first_name" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Last Name</p>
			</div>
			<div class="right">
				<input type="text" class="person_last_name" name="person_last_name" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Email</p>
			</div>
			<div class="right">
				<input type="text" class="person_email" name="person_email" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Department</p>
			</div>
			<div class="right">
				<select class="person_department" name="person_department">
					<?php foreach ($departments as $department): ?>
					<option><?php echo $department; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Hourly rate</p>
			</div>
			<div class="right">
				<p class="right_label">kr</p>
				<input type="text" class="person_hourly_rate" name="person_hourly_rate" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Permissions</p>
			</div>
			<div class="right">
				<select name="person_permission">
					<?php foreach ($permission_array as $permission):?>
					<option><?php echo $permission; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Timezone</p>
			</div>
			<div class="right">
				<select name="person_timezone">
					<?php foreach ($timezones as $time => $timezone): ?>
					<option value="<?php echo $time; ?>"><?php echo $time; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Photo</p>
			</div>
			<div class="right">
				<input type="file" name="person_image" class="person_image">
			</div>
		</div>
		<div class="border_separator"></div>
		<input type="submit" name="submit" class="button_1" value="Add People" />
		<a class="button_2" href="/add-person/">Cancel</a>
	</form>
</div>
<?php 
if(isset($_POST['submit'])):
	global $wpdb;	
	$person_type			= $_POST['person_type'];
	if(isset($_POST['person_type'])):
		$person_type = $_POST['person_type'];
	else:
		$person_type = 0;
	endif;
	$person_first_name		= $_POST['person_first_name'];
	$person_last_name		= $_POST['person_last_name'];
	$person_email			= $_POST['person_email'];
	$person_department		= $_POST['person_department'];
	$person_hourly_rate		= $_POST['person_hourly_rate'];
	$person_permission 		= $_POST['person_permission'];
	$person_timezone		= $_POST['person_timezone'];
	$person_image 			= $_FILES["person_image"]["name"];
		
	$insert = $wpdb->insert( $table_name , array( 
	'person_type'			=> $person_type,
	'person_first_name'		=> $person_first_name,
	'person_last_name'		=> $person_last_name,
	'person_email'			=> $person_email,
	'person_department'		=> $person_department,
	'person_hourly_rate'	=> $person_hourly_rate,
	'person_permission'		=> $person_permission,	
	'person_timezone'		=> $person_timezone,
	'person_image'			=> $person_image
	), array( '%s', '%s' ));
	
	if($insert == 1):
		echo "<p class='message'>";
		echo "Project Added!";
	else:
		echo "Project was not successfully added.";
		echo "</p>";
	endif;		
endif;
$destination= get_home_path().'wp-content/uploads/person_image/';
$move =	move_uploaded_file($_FILES["person_image"]["tmp_name"], $destination.$_FILES["person_image"]["name"]);
?>
<?php get_footer(); ?>