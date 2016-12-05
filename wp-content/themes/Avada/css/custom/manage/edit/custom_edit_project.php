<?php /* Template Name: Edit Project */ ?>
<?php get_header(); 
global $wpdb;			
$table_name = $wpdb->prefix . "custom_project";
$id = $_GET['id'];	
if(isset($_POST['submit'])):
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

	$table_array = 
	$update = $wpdb->update( $table_name , array( 
		'project_client'			=> $project_client,
		'project_name'				=> $project_name,
		'project_invoice_method'	=> $project_invoice_method,
		'project_budget'			=> $project_budget,
		'project_description'		=> $project_description	
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

$query = "SELECT * FROM $table_name " .
"WHERE id=$id";
$projects = $wpdb->get_results("SELECT * FROM {$table_name}");
$results_edit = $wpdb->get_row($query);
?>
<div class="edit_project">
	<form action="" method="post" name="project" id="project">
		<div class="section">
			<div class="left">
				<p class="label">Client</p>
			</div>
			<div class="right">
				<select class="project_client" name="project_client">
					<option value="<?php echo (isset($results_edit->project_client)) ? $results_edit->project_client : '';  ?>"><?php echo $results_edit->project_client; ?></option>
					<?php 
					foreach($projects as $project):
					if($project->project_client != $results_edit->project_client):
					?>
					<option><?php echo $project->project_client; ?></option>
					<?php endif; endforeach; ?>
				</select>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Project Name</p>
			</div>
			<div class="right">
				<input type="text" name="project_name" class="project_name" value="<?php echo (isset($results_edit->project_name)) ? $results_edit->project_name : '';  ?>"/>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">	
			<div class="left">
				<p class="label">Invoice Method</p>
			</div>
			<div class="right">
				<input type="checkbox" name="project_invoice_method" value="<?php echo (isset($results_edit->project_invoice_method)) ? $results_edit->project_invoice_method : '';  ?>" class="project_invoice_method checkbox" checked>Billable
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Budget</p>
			</div>
			<div class="right">
				<p class="right_label">Estimated Project Budget</p>
				<input type="text" name="project_budget" class="project_budget input_float_left" value="<?php echo (isset($results_edit->project_budget)) ? $results_edit->project_budget : '';  ?>">
				<p class="right_label">[SEK]</p>
			</div>
		</div>
		<div class="border_separator"></div>
		<div class="section">
			<div class="left">
				<p class="label">Description</p>
			</div>
			<div class="right">
				<textarea name="project_description" class="project_description textarea_wide" ><?php echo (isset($results_edit->project_description)) ? $results_edit->project_description : '';  ?></textarea>
			</div>
		</div>
		<input type="submit" name="submit" class="add_project button_1" value="Update" />
		<a class="button_2" href="/add-project/">Cancel</a>
	</form>
</div>
<?php get_footer(); ?>