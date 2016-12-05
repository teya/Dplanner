<?php /* Template Name: Person */ ?>
<?php get_header(); ?>
<div class="persons">
	<a id="create_person" class="button_1" href="/add-people/">+ Add Person</a>
</div>
<div class="display_main">
<?php 
	$table_name = $wpdb->prefix . "custom_person"; 
	$people = $wpdb->get_results("SELECT * FROM {$table_name}");
	$people_count = (count($people));	
?>
	<div class="display_section">
		<h2 class="display_title">Employees (<?php echo $people_count; ?>)</h2>
		<?php foreach($people as $person): ?>
		<div class="display_list">
			<a class="button_2 display_button" href="/edit-people/?id=<?php echo $person->ID ?>">Edit</a>
			<h3 class="display_subtitle float_left"><?php echo $person->person_first_name . ' ' . $person->person_last_name; ?></h3>
			<p class="display_hourly_rate">(<?php echo $person->person_hourly_rate; ?>)</p>
			<p class="display_permission"><?php echo $person->person_permission; ?></p>
		</div>
		<div class="display_separator"></div>
		<?php endforeach; ?>
	</div>
</div>

<?php get_footer(); ?>