<?php /* Template Name: Edit Task */ ?>
<?php get_header();
global $wpdb;			
$table_name = $wpdb->prefix . "custom_task";
$id = $_GET['id'];	 
if(isset($_POST['submit'])):	
	$task_name			= $_POST['task_name'];
	$task_billable		= $_POST['task_billable'];
	if(isset($_POST['task_billable'])):
	$task_billable = $_POST['task_billable'];
	else:
	$task_billable = 0;
	endif;
	$task_description	= $_POST['task_description'];
	
	$table_array = 
	$update = $wpdb->update( $table_name , array( 
	'task_name'			=> $task_name,
	'task_billable'		=> $task_billable,
	'task_description'	=> $task_description
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
<div class="add_task">
	<form action="" method="post" name="task" id="task">
		<div class="section">
			<div class="left">
				<p class="label">Task Name</p>
			</div>
			<div class="right">
				<input type="text" placeholder="New task name" name="task_name" value="<?php echo (isset($results_edit->task_name)) ? $results_edit->task_name : '';  ?>"/>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Billing</p>
			</div>
			<div class="right">
				<label><input type="checkbox" name="task_billable" value="<?php echo (isset($results_edit->task_billable)) ? $results_edit->task_billable : '';  ?>" <?php echo $results_edit->task_billable == 1 ? 'checked' : ''; ?> class="checkbox">Billable by default</label>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Description</p>
			</div>
			<div class="right">
				<textarea name="task_description" class="task_description textarea_wide"><?php echo (isset($results_edit->task_description)) ? $results_edit->task_description : '';  ?></textarea>
			</div>
		</div>
		<input type="submit" name="submit" class="add_task button_1" value="Update" />
		<a class="button_2" href="/add-task/">Cancel</a>
	</form>
</div>
<?php get_footer(); ?>