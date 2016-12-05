<?php /* Template Name: Department */ ?>
<?php get_header(); ?>
<div class="projects">
	<a id="create_department" class="button_1 wide_button" href="/add-department/">+ Create Department</a>
</div>
<div class="display_main">
<?php 
	$table_name = $wpdb->prefix . "custom_department"; 
	$departments = $wpdb->get_results("SELECT * FROM {$table_name}");
?>
	<div class="display_section">
		<h2 class="display_title">Department</h2>
		<?php foreach($departments as $department): ?>
		<div class="display_list">
			<a class="button_2 display_button" href="/edit-department/?id=<?php echo $department->ID ?>">Edit</a>
			<h3 class="display_subtitle float_left"><?php echo $department->department_name; ?></h3>
		</div>
		<div class="display_separator"></div>
		<?php endforeach; ?>
	</div>
</div>

<?php get_footer(); ?>