<?php /* Template name: Project Information */ ?>
<?php get_header(); 
$id = $_GET['id'];
$table_name = $wpdb->prefix . "custom_project"; 
$project = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = '$id'");
$table_name_color = $wpdb->prefix . "custom_project_color";
$colors = $wpdb->get_results("SELECT * FROM {$table_name_color}");

?>
<div class="info_project">
	<div class="section">
		<div class="left">
			<p class="label">Client</p>
		</div>
		<div class="right">
			<p><?php echo $project->project_client; ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Project Name</p>
		</div>
		<div class="right">
			<p><?php echo $project->project_name; ?></p>
		</div>
	</div>	
	<div class="border_separator"></div>	
	<div class="section">
		<div class="left">
			<p class="label">Start date</p>
		</div>
		<div class="right">
			<p><?php echo $project->project_start_date; ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Estimated Deadline</p>
		</div>
		<div class="right">
			<p><?php echo $project->project_estimated_deadline; ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Main consultant</p>
		</div>
		<div class="right">
			<p><?php echo $project->project_main_consultant; ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Current status</p>
		</div>
		<div class="right">
			<p><?php echo $project->project_current_status; ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Billable</p>
		</div>		
		<div class="right">
			<?php if($project->project_billable == 1): ?>
			<p><?php echo "Billable"; ?></p>
			<?php else: ?>
			<p><?php echo "Non Billable"; ?></p>
			<?php endif; ?>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">
		<div class="left">
			<p class="label">Estimated hours</p>
		</div>
		<div class="right">
			<p><?php echo $project->project_estimated_hours; ?></p>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">	
		<div class="left">
			<p class="label">Fixed price</p>
		</div>
		<div class="right">
			<?php echo $project->project_fixed_price; ?>
		</div>
	</div>
	<div class="border_separator"></div>
	<div class="section">	
		<div class="left">
			<p class="label">Description</p>
		</div>
		<div class="right">
			<?php echo $project->project_description; ?>
		</div>
	</div>	
	<a class="button_2 display_button" href="/projects/">Return</a>
	<a id="create_projects" class="button_1 display_button padding_button" href="/add-project/">+ Add Project</a>
	<a class="button_2 display_button" href="/edit-project/?editID=<?php echo $project->ID ?>">Edit</a>
	<a class="button_2 display_button confirm" href="/projects/?deleteID=<?php echo $project->ID ?>">Delete</a>
</div>