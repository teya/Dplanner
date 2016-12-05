<?php /* Template name: Add Project */ ?>
<?php get_header(); 
global $wpdb;
$table_name = $wpdb->prefix . "custom_project";			
$table_name_client = $wpdb->prefix . "custom_client";
$client_names = $wpdb->get_col("SELECT DISTINCT client_name FROM {$table_name_client}");	
?>
<div class="add_project">
	<form action="" method="post" name="project" id="project">
		<div class="section">
			<div class="left">
				<p class="label">Client</p>
			</div>
			<div class="right">
				<select class="project_client" name="project_client">
					<?php foreach ($client_names as $client_name): ?>
					<option><?php echo $client_name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Project Name</p>
			</div>
			<div class="right">
				<input type="text" name="project_name" class="project_name" />
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">	
			<div class="left">
				<p class="label">Invoice Method</p>
			</div>
			<div class="right">
				<input type="checkbox" name="project_invoice_method" value="1" class="project_invoice_method checkbox" checked>Billable
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Budget</p>
			</div>
			<div class="right">
				<p class="right_label">Estimated Project Budget</p>
				<input type="text" name="project_budget" class="project_budget input_float_left">
				<p class="right_label">[SEK]</p>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Description</p>
			</div>
			<div class="right">
				<textarea name="project_description" class="project_description textarea_wide"></textarea>
			</div>
		</div>
		<input type="submit" name="submit" class="button_1" value="Add Project" />
		<a class="button_2" href="/add-project/">Cancel</a>
	</form>
</div>
<?php 
if(isset($_POST['submit'])):
	global $wpdb;
	$project_client				= $_POST['project_client'];
	$project_name				= $_POST['project_name'];
	$project_invoice_method		= $_POST['project_invoice_method'];
	if(isset($_POST['project_invoice_method'])):
		$project_invoice_method = $_POST['project_invoice_method'];
	else:
		$project_invoice_method = 0;
	endif;
	$project_budget				= $_POST['project_budget'];
	$project_description		= $_POST['project_description'];
	
	$insert = $wpdb->insert( $table_name , array( 
	'project_client'			=> $project_client,
	'project_name'				=> $project_name,
	'project_invoice_method'	=> $project_invoice_method,
	'project_budget'			=> $project_budget,
	'project_description'		=> $project_description	
	), array( '%s', '%s' ));
	
	if($insert == 1):
		echo "<p class='message'>";
		echo "Project Added!";
	else:
		echo "Project was not successfully added.";
		echo "</p>";
	endif;	
endif;
?>
<?php get_footer(); ?>