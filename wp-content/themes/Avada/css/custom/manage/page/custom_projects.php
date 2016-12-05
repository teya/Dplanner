<?php /* Template Name: Project */ ?>
<?php get_header(); ?>
<div class="projects">
	<a id="create_projects" class="button_1" href="/add-project/">+ Add Project</a>
</div>
<div class="display_main">
	<?php 
		$table_name = $wpdb->prefix . "custom_project"; 
		$projects = $wpdb->get_results("SELECT * FROM {$table_name}");
		$get_client = $wpdb->get_results("SELECT project_client FROM {$table_name} GROUP BY project_client");		
		
		foreach ($get_client as $client):				
	?>
	<div class="display_section">
		<h2 class="display_title"><?php echo $client->project_client; ?></h2>
		<?php foreach ($projects as $project): ?>
			<?php if ($project->project_client == $client->project_client): ?>			
				<div class="display_list">
					<a class="button_2 display_button" href="/edit-project/?id=<?php echo $project->ID ?>">Edit</a>
					<h3 class="display_subtitle"><?php echo $project->project_name; ?></h3>
				</div>
				<div class="display_separator"></div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>	
	<?php endforeach; ?>
</div>
<?php get_footer(); ?>