<?php /* Template name: Add Department */ ?>
<?php get_header(); 
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_department";
?>
<div class="add_department">
	<form action="" method="post" name="department" id="department">
		<div class="section">
			<div class="left">
				<p class="label">Department Name</p>
			</div>
			<div class="right">
				<input type="text" name="department_name" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Default Expenses</p>
			</div>
			<div class="right">
				<input type="text" name="department_default_expenses" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Description</p>
			</div>
			<div class="right">
				<textarea name="department_description" class="department_description textarea_wide"></textarea>
			</div>
		</div>
		<input type="submit" name="submit" class="button_1 wide_button" value="Add Department" />
		<a class="button_2" href="/department/">Cancel</a>
	</form>
</div>
<?php 
if(isset($_POST['submit'])):
	global $wpdb;		
	$department_name				= (isset($_POST['department_name']) ? $_POST['department_name'] : '');
	$department_default_expenses	= (isset($_POST['department_default_expenses']) ? $_POST['department_default_expenses'] : '');
	$department_description			= (isset($_POST['department_description']) ? $_POST['department_description'] : '');
	
	$insert = $wpdb->insert( $table_name , array( 
	'department_name'				=> $department_name,
	'department_default_expenses'	=> $department_default_expenses,
	'department_description'		=> $department_description
	), array( '%s', '%s' ));
	
	if($insert == 1):
		echo "<p class='message'>";
		echo "Department Added!";
	else:
		echo "Department was not successfully added.";
		echo "</p>";
	endif;		
endif;
?>
<?php get_footer(); ?>
