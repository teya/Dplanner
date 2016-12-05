<?php /* Template Name: Edit People */ ?>
<?php get_header(); 
include('custom_timezones.php');
global $wpdb;			
$table_name = $wpdb->prefix . "custom_person";
$id = $_GET['id'];	
$query = "SELECT * FROM $table_name " .
"WHERE id=$id";
$people = $wpdb->get_results("SELECT * FROM {$table_name}");
$results_edit = $wpdb->get_row($query);	

if(isset($_POST['submit'])):
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
	if(empty($_FILES["person_image"]["name"])):
	$person_image = $results_edit->person_image;
	else:
		$person_image 			= $_FILES["person_image"]["name"];
	endif;
	
	$table_array = 
	$update = $wpdb->update( $table_name , array( 
	'person_type'			=> $person_type,
	'person_first_name'		=> $person_first_name,
	'person_last_name'		=> $person_last_name,
	'person_email'			=> $person_email,
	'person_department'		=> $person_department,
	'person_hourly_rate'	=> $person_hourly_rate,
	'person_permission'		=> $person_permission,	
	'person_timezone'		=> $person_timezone,
	'person_image'			=> $person_image
	),
	array( 'ID' => $id ),
	array( '%s', '%s' ));	
	if($update == 1):
	echo "<p class='message'>";
	echo "Project Updates!";
	else:
	echo "Project was not successfully Updated.";
	echo "</p>";
	endif;		
endif;
	$destination= get_home_path().'wp-content/uploads/person_image/';
	$move =	move_uploaded_file($_FILES["person_image"]["tmp_name"], $destination.$_FILES["person_image"]["name"]);

	$permission_array = array("Administrator", "Project Manager", "User");
?>
<div class="edit_person">
	<form action="" method="post" name="person" enctype="multipart/form-data" id="person">
		<div class="section">
			<div class="left">
				<p class="label">Person Type</p>
			</div>
			<div class="right">
				<input type="checkbox" name="person_type" value="<?php echo (isset($results_edit->person_type)) ? $results_edit->person_type : '';  ?>" <?php echo $results_edit->person_type == 1 ? 'checked' : ''; ?> class="person_type checkbox">Employee<br/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">First Name</p>
			</div>
			<div class="right">
				<input type="text" class="person_first_name" name="person_first_name" value="<?php echo (isset($results_edit->person_first_name)) ? $results_edit->person_first_name : '';  ?>"/>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Last Name</p>
			</div>
			<div class="right">
				<input type="text" class="person_last_name" name="person_last_name" value="<?php echo (isset($results_edit->person_last_name)) ? $results_edit->person_last_name : '';  ?>"/>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Email</p>
			</div>
			<div class="right">
				<input type="text" class="person_email" name="person_email" value="<?php echo (isset($results_edit->person_email)) ? $results_edit->person_email : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Department</p>
			</div>
			<div class="right">
				<select class="person_department" name="person_department">
					<option value="<?php echo (isset($results_edit->person_department)) ? $results_edit->person_department : '';  ?>"><?php echo $results_edit->person_department; ?></option>
					<?php 
					foreach($people as $person):
					if($person->person_department != $results_edit->person_department):
					?>
					<option><?php echo $person->person_department ?></option>
					<?php endif; endforeach; ?>
				</select>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Hourly rate</p>
			</div>
			<div class="right">
				<p class="right_label">kr</p>
				<input type="text" class="person_hourly_rate" name="person_hourly_rate" value="<?php echo (isset($results_edit->person_hourly_rate)) ? $results_edit->person_hourly_rate : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Permissions</p>
			</div>
			<div class="right">
				<select name="person_permission">
					<option value="<?php echo (isset($results_edit->person_permission)) ? $results_edit->person_permission : '';  ?>"><?php echo $results_edit->person_permission; ?></option>
					<?php 
					foreach($permission_array as $permission): 
					if($permission != $results_edit->person_permission):
					?>
					<option><?php echo $permission; ?></option>
					<?php endif; endforeach;?>
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
					<option value="<?php echo (isset($results_edit->person_timezone)) ? $results_edit->person_timezone : '';  ?>"><?php echo $results_edit->person_timezone; ?></option>
					<?php foreach ($timezones as $time => $timezone): 
					if($time != $results_edit->person_timezone):
					?>
					<option value="<?php echo $time; ?>"><?php echo $time; ?></option>
					<?php endif; endforeach; ?>
				</select>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Photo</p>
			</div>
			<div class="right">
				<?php if($results_edit->person_image != null): ?>
				<div class="image">
					<img class="person_image" src="<?php echo site_url().'/wp-content/uploads/person_image/'.$results_edit->person_image; ?>" />
				</div>
				<?php endif; ?>
				<input type="file" name="person_image" class="person_image" value="<?php echo (isset($results_edit->person_image)) ? $results_edit->person_image : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<input type="submit" name="submit" class="add_person button_1" value="Update" />
		<a class="button_2" href="/add-person/">Cancel</a>
	</form>
</div>
<?php get_footer(); ?>