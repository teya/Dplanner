<?php /* Template name: Department Information */ ?>
<?php get_header(); 
$id = $_GET['id'];
$table_name = $wpdb->prefix . "custom_department"; 
$department = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = '$id'");
?>
<div class="info_department">
	<div class="section">
		<div class="left">
			<p class="label">Department Name</p>
		</div>
		<div class="right">
			<p><?php echo $department->department_name; ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">Default Expenses</p>
		</div>
		<div class="right">
			<p><?php echo $department->department_default_expenses; ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">Description</p>
		</div>
		<div class="right">
			<p><?php echo $department->department_description; ?></p>
		</div>
	</div>
	<a class="button_2 display_button" href="/department/">Return</a>
	<a id="create_projects" class="button_1 display_button padding_button" href="/add-department/">+ Add Department</a>
	<a class="button_2 display_button" href="/edit-department/?id=<?php echo $department->ID ?>">Edit</a>
	<a class="button_2 display_button confirm" href="/department/?deleteID=<?php echo $department->ID ?>">Delete</a>	
</div>
<?php get_footer(); ?>