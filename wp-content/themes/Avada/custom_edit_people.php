<?php /* Template Name: Edit People */ ?>

<?php get_header(); ?>

<?php

include('custom_timezones.php');

global $wpdb;			

$table_name = $wpdb->prefix . "custom_person";

$table_name_wp_user = $wpdb->prefix . "users";

$table_name_department = $wpdb->prefix . "custom_department";	

$id = $_GET['editID'];	

$query = "SELECT * FROM $table_name WHERE id=$id";

$person_info = $wpdb->get_row($query);

$wp_user_id = $person_info->wp_user_id;

$people = $wpdb->get_results("SELECT * FROM {$table_name}");

$departments = $wpdb->get_results("SELECT * FROM {$table_name_department}");

$permission_array = array("Administrator", "Project Manager", "User");

$birthmonths = array('January', 'February','March','April','May','June','July','August','September','October','November','December');

$person_department_checked = unserialize($person_info->person_department);

$checked = ''

?>

<?php 

	

if(isset($_POST['submit'])){

	$person_fullname			= $_POST['person_fullname'];

	$person_birthday			= $_POST['person_birthday'];

	$person_birthmonth			= $_POST['person_birthmonth'];

	$person_birthyear			= $_POST['person_birthyear'];

	$person_address				= $_POST['person_address'];

	$person_mobile				= $_POST['person_mobile'];

	$person_email				= $_POST['person_email'];

	if(isset($_POST['person_email_notification'])){

		$person_email_notification	= 1;

		}else{

		$person_email_notification	= 0;

	}


	$person_skype				= $_POST['person_skype'];

	$person_title				= $_POST['person_title'];

	$person_description			= $_POST['person_description'];

	$person_department			= $_POST['person_department'];

	$person_hours_per_day		= $_POST['person_hours_per_day'];

	$person_hourly_rate			= $_POST['person_hourly_rate'];

	if(isset($_POST['person_time_track'])){

		$person_time_track	= 1;

		}else{

		$person_time_track	= 0;

	}

	$person_monthly_rate		= $_POST['person_monthly_rate'];

	$person_permission 			= $_POST['person_permission'];

	$person_timezone			= $_POST['person_timezone'];	

	if(empty($_FILES["person_image"]["name"])){

	$person_image = $results_edit->person_image;

	}else{

	$person_image 			= $_FILES["person_image"]["name"];

	}

	

	$update = $wpdb->update( $table_name , array(

	'person_fullname'			=> $person_fullname,

	'person_birthday'			=> $person_birthday,

	'person_birthmonth'			=> $person_birthmonth,

	'person_birthyear'			=> $person_birthyear,

	'person_address'			=> $person_address,

	'person_mobile'				=> $person_mobile,

	'person_email'				=> $person_email,

	'person_email_notification'	=> $person_email_notification,

	'person_skype'				=> $person_skype,

	'person_title'				=> $person_title,

	'person_description'		=> $person_description,

	'person_department'			=> ($person_department)? serialize($person_department) : '',

	'person_hours_per_day'		=> $person_hours_per_day,

	'person_hourly_rate'		=> $person_hourly_rate,

	'person_time_track'			=> $person_time_track,

	'person_monthly_rate'		=> $person_monthly_rate,

	'person_permission'			=> $person_permission,	

	// 'person_timezone'			=> $person_timezone,

	'person_image'				=> $person_image

	),

	array( 'ID' => $id ),

	array( '%s', '%s' ));	

	

	$update_wp = $wpdb->update( $table_name_wp_user , array(

	'display_name'			=> $person_fullname,

	'user_email'			=> $person_email

	),

	array( 'ID' => $wp_user_id ),

	array( '%s', '%s' ));	

	

	if($update == 1):

		$person_department_checked = $person_department;

		echo "<p class='message'>";

		echo "Person Updated!";

		echo "</p>";

	else:

		echo "<p class='message'>";

		echo "Person was not successfully Updated.";

		echo "</p>";

	endif;		

}

	$destination= get_home_path().'wp-content/uploads/person_image/';

	$move =	move_uploaded_file($_FILES["person_image"]["tmp_name"], $destination.$_FILES["person_image"]["name"]);

	$results_edit = $wpdb->get_row($query);

?>

<div class="edit_person">

	<form action="" method="post" name="person" enctype="multipart/form-data" id="person">

		<div class="section">

			<div class="left">

				<p class="label">Name</p>

			</div>

			<div class="right">

				<input type="text" class="person_fullname" name="person_fullname" value="<?php echo (isset($results_edit->person_fullname)) ? $results_edit->person_fullname : '';  ?>"/>

			</div>

		</div>

		<div class="section">

			<div class="left">

				<p class="label">Birthdate</p>

			</div>

			<div class="right">

				<select class="person_birthday" name="person_birthday">

					<option value="<?php echo (isset($results_edit->person_birthday)) ? $results_edit->person_birthday : '';  ?>"><?php echo $results_edit->person_birthday; ?></option>

					<?php 

						for($day = 1; $day <= 31;  $day++){ 

							if($day != $results_edit->person_birthday){

					?>

							<option><?php echo $day; ?></option>

					<?php

							} 

						}

					?>

				</select>

				<select class="person_birthmonth" name="person_birthmonth">

					<option value="<?php echo (isset($results_edit->person_birthmonth)) ? $results_edit->person_birthmonth : '';  ?>"><?php echo $results_edit->person_birthmonth; ?></option>

					<?php 

						foreach($birthmonths as $birthmonth){

							if($birthmonth != $results_edit->person_birthmonth){

					?>

							<option><?php echo $birthmonth; ?></option>

					<?php 

							}

						}

					?>

				</select>

				<select class="person_birthyear" name="person_birthyear">

					<option value="<?php echo (isset($results_edit->person_birthyear)) ? $results_edit->person_birthyear : '';  ?>"><?php echo $results_edit->person_birthyear; ?></option>

					<?php

						$current_year = date('Y');

						for($year = 1965; $year <= $current_year;  $year++){ 

							if($year != $results_edit->person_birthyear){

					?>

							<option><?php echo $year; ?></option>

					<?php 

							}

						} 

					?>

				</select>

			</div>

		</div>

		<div class="section">

			<div class="left">

				<p class="label">Address</p>

			</div>

			<div class="right">				

				<textarea name="person_address" class="person_address"><?php echo (isset($results_edit->person_address)) ? $results_edit->person_address : '';  ?></textarea>

			</div>

		</div>

		<div class="section">

			<div class="left">

				<p class="label">Mobile Phone</p>

			</div>

			<div class="right">

				<input type="text" class="person_mobile" name="person_mobile" value="<?php echo (isset($results_edit->person_mobile)) ? $results_edit->person_mobile : '';  ?>" />

			</div>

		</div>

		<div class="section">

			<div class="left">

				<p class="label">Email</p>

			</div>

			<div class="right">

				<input type="text" class="person_email" name="person_email" value="<?php echo (isset($results_edit->person_email)) ? $results_edit->person_email : '';  ?>"/>

				<input type="checkbox" name="person_email_notification" class="person_email_notification" <?php echo ($results_edit->person_email_notification == 1) ? "checked" : ''; ?> />Enable Notification

			</div>

		</div>

<!-- 		<div class="section">

			<div class="left">

				<p class="label">Skype Name</p>

			</div>

			<div class="right">

				<input type="text" class="person_skype" name="person_skype" value="<?php echo (isset($results_edit->person_skype)) ? $results_edit->person_skype : '';  ?>" />

			</div>

		</div> -->

		<div class="border_separator"></div>

		<div class="section">

			<div class="left">

				<p class="label">Title</p>

			</div>

			<div class="right">

				<input type="text" class="person_title" name="person_title" value="<?php echo (isset($results_edit->person_title)) ? $results_edit->person_title : '';  ?>" />

			</div>

		</div>		

		<div class="section">

			<div class="left">

				<p class="label">Department</p>

			</div>

			<div class="right">
					<?php
						
						$person_department_array = array();

						foreach($departments as $department){ 

							$person_department_array[] = $department->department_name;

						}

						sort($person_department_array);						

					?>
<!-- 
				<select class="person_department" name="person_department">

					<option value="<?php echo (isset($results_edit->person_department)) ? $results_edit->person_department : '';  ?>"><?php echo $results_edit->person_department; ?></option>


					<?php 

					foreach($person_department_array as $person_department){

						if($person_department != $results_edit->person_department){

					?>

						<option><?php echo $person_department; ?></option>

					<?php 

						}

					} 

					?>

				</select> -->

				<?php 
					//print_r($person_department_array);
					foreach($person_department_array as $department){
						//Checked if the Person have existing department
						// if(isset($person_department_checked) AND $person_department_checked != ''){
							//Select or checked Person's departments.
							if (in_array($department, $person_department_checked)){
								$checked = 'checked';
							}else{
								$checked = '';
							}
						// }
						echo '<input type="checkbox" name="person_department[]" value="'.$department.'" class="check_box" '.$checked.' />';
						echo '<p class="check_box_label">'.$department.'</p>';
					}
				?>

			</div>

		</div>

		<div class="section">

			<div class="left">

				<p class="label">Hours/day:</p>

			</div>

			<div class="right">

				<input type="text" class="person_hours_per_day" name="person_hours_per_day" value="<?php echo (isset($results_edit->person_hours_per_day)) ? $results_edit->person_hours_per_day : '';  ?>" />

				<input type="checkbox" name="person_time_track" class="person_time_track" <?php echo ($results_edit->person_time_track == 1) ? "checked" : ''; ?> />Enable Time Tracking

			</div>

		</div>

<!-- 		<div class="section">

			<div class="left">

				<p class="label">Hourly rate</p>

			</div>

			<div class="right">

				<p class="right_label">kr</p>

				<input type="text" class="person_hourly_rate" name="person_hourly_rate" value="<?php echo (isset($results_edit->person_hourly_rate)) ? $results_edit->person_hourly_rate : '';  ?>"/>

			</div>

		</div>

		<div class="section">

			<div class="left">

				<p class="label">Monthly rate</p>

			</div>

			<div class="right">

				<p class="right_label">kr</p>

				<input type="text" class="person_monthly_rate" name="person_monthly_rate" value="<?php echo (isset($results_edit->person_monthly_rate)) ? $results_edit->person_monthly_rate : '';  ?>"/>

			</div>

		</div> -->

		<div class="border_separator"></div>

		<div class="section">

			<div class="left">

				<p class="label">Permissions</p>

			</div>
			<div class="right">

				<select name="person_permission">

					<option value="<?php echo (isset($results_edit->person_permission)) ? $results_edit->person_permission : '';  ?>"><?php echo $results_edit->person_permission; ?></option>

					<?php

						$person_permission_array = array();

						foreach($permission_array as $permission){ 

							$person_permission_array[] = $permission;

						}

						sort($person_permission_array);						

					?>					

					<?php 

					foreach($person_permission_array as $person_permission): 

					if($person_permission != $results_edit->person_permission):

					?>

					<option><?php echo $person_permission; ?></option>

					<?php endif; endforeach;?>

				</select>

			</div>

		</div>

 		<div class="border_separator"></div>
<!--
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

		</div> -->

		<div class="section">

			<div class="left">

				<p class="label">Photo</p>

			</div>

			<div class="right">

				<?php if($results_edit->person_image != null): ?>

				<div class="image">

					<figure class="person_image">

						<img class="person_image" src="<?php echo site_url().'/wp-content/uploads/person_image/'.$results_edit->person_image; ?>" />

					</figure>

				</div>

				<?php endif; ?>

				<input type="file" name="person_image" class="person_image" value="<?php echo (isset($results_edit->person_image)) ? $results_edit->person_image : '';  ?>"/>

			</div>

		</div>

		<div class="border_separator"></div>

		<div class="section">

			<div class="left">

				<p class="label">Description</p>

			</div>

			<div class="right">

				<textarea name="person_description" class="person_description textarea_wide"><?php echo (isset($results_edit->person_description)) ? $results_edit->person_description : '';  ?></textarea>

			</div>

		</div>

		<input type="submit" name="submit" class="add_person button_1" value="Update" />

		<a class="button_2" href="/add-person/">Cancel</a>

	</form>

</div>

<?php get_footer(); ?>