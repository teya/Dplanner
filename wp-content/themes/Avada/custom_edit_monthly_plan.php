<?php /* TEMPLATE NAME: Edit Monthly Plan */ ?>
<?php get_header(); ?>
<?php
$id = $_GET['id'];

global $wpdb;
$table_name = $wpdb->prefix . "custom_monthly_plan";
?>
<?php 
if(isset($_POST['submit'])){
	
	$monthly_name			= $_POST['monthly_name'];
	$monthly_seo_hours		= $_POST['monthly_seo_hours'];
	$monthly_webdev_hours	= $_POST['monthly_webdev_hours'];
	$monthly_services_array	= $_POST['monthly_services'];
	$monthly_services		= serialize($monthly_services_array);
	$monthly_budget			= $_POST['monthly_budget'];
	$monthly_seo_extra_expense	= $_POST['monthly_seo_extra_expense'];
	$monthly_dev_extra_expense	= $_POST['monthly_dev_extra_expense'];
	
	$update = $wpdb->update( $table_name , array( 
	'monthly_name'			=> $monthly_name,
	'monthly_seo_hours'		=> $monthly_seo_hours,
	'monthly_webdev_hours'	=> $monthly_webdev_hours,
	'monthly_services'		=> $monthly_services,
	'monthly_budget'		=> $monthly_budget,
	'monthly_seo_extra_expense'	=> $monthly_seo_extra_expense,
	'monthly_dev_extra_expense'	=> $monthly_dev_extra_expense
	),
	array( 'ID' => $id ),
	array( '%s', '%s' ));	
	if($update == 1){
		echo "<p class='message'>";
		echo "Monthly Plan Updated!";
		echo "</p>";
	}else{
		echo "<p class='message'>";
		echo "Monthly Plan was not successfully Updated.";
		echo "</p>";
	}	
}
	
?>	
<?php 
	$results_edit = $wpdb->get_row("SELECT * FROM $table_name WHERE ID=$id");
	$monthly_services_options = array('Onpage SEO', 'Offpage SEO', 'Pinterest', 'Instagram', 'Social Media', 'Video', 'Reputation Marketing', 'Press Releases', 'Adwords', 'Website Support' );
?>
<div class="edit_monthly_plan">
	<form action="" method="post" name="monthly_plan" id="monthly_plan">
		<div class="section">
			<div class="left">
				<p class="label">Name</p>
			</div>
			<div class="right">
				<input type="text" class="monthly_name" name="monthly_name" value="<?php echo (isset($results_edit->monthly_name)) ? $results_edit->monthly_name : '';  ?>" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">SEO Hours / Month</p>
			</div>
			<div class="right">
				<input type="text" class="monthly_seo_hours" name="monthly_seo_hours" value="<?php echo (isset($results_edit->monthly_seo_hours)) ? $results_edit->monthly_seo_hours : '';  ?>" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Webdev Hours / Month</p>
			</div>
			<div class="right">
				<input type="text" class="monthly_webdev_hours" name="monthly_webdev_hours" value="<?php echo (isset($results_edit->monthly_webdev_hours)) ? $results_edit->monthly_webdev_hours : '';  ?>" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Services</p>
			</div>
			<div class="right">
				<div class="right monthly_plan_container">
					<?php
						$monthly_services_option_array = array();
						foreach($monthly_services_options as $monthly_services_option){ 
							$monthly_services_option_array[] = $monthly_services_option;
						}
						sort($monthly_services_option_array);
					?>
				<?php 
					$services_result_array = unserialize($results_edit->monthly_services);	
					foreach($monthly_services_option_array as $key => $monthly_service_option){
				?>
						<input type="checkbox" class="monthly_checkbox" name="monthly_services[]" value="<?php echo $monthly_service_option; ?>" <?php echo (in_array($monthly_service_option, $services_result_array)) ? "checked" : ""; ?>>
						<p class="label checkbox_label"><?php echo $monthly_service_option; ?></p>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Budget / Month:</p>
			</div>
			<div class="right">
				<input type="text" class="monthly_budget" name="monthly_budget" value="<?php echo (isset($results_edit->monthly_budget)) ? $results_edit->monthly_budget : '';  ?>" />
			</div>
		</div>
		<div class="small_input">
			<div class="left">
				<p class="label">SEO Extra Expense</p>
				<input type="text" class="monthly_seo_extra_expense" name="monthly_seo_extra_expense" value="<?php echo (isset($results_edit->monthly_seo_extra_expense)) ? $results_edit->monthly_seo_extra_expense : '';  ?>" />
			</div>
			<div class="right">
				<p class="label">DEV Extra Expense</p>
				<input type="text" class="monthly_dev_extra_expense" name="monthly_dev_extra_expense" value="<?php echo (isset($results_edit->monthly_dev_extra_expense)) ? $results_edit->monthly_dev_extra_expense : '';  ?>" />
			</div>
		</div>
		<input type="submit" name="submit" class="button_1" value="Update Monthly Plan" />
		<a class="button_2" href="/monthly-plan/">Cancel</a>
	</form>
</div>
<?php get_footer(); ?>