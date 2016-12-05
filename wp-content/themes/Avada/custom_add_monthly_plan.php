<?php /* TEMPLATE NAME: Add Monthly Plan */ ?>
<?php get_header(); ?>
<?php
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_monthly_plan";
	
	$monthly_services_options = array('Onpage SEO', 'Offpage SEO', 'Pinterest', 'Instagram', 'Social Media', 'Video', 'Reputation Marketing', 'Press Releases', 'Adwords', 'Website Support' );
?>
<div class="add_monthly_plan">
	<form action="" method="post" name="monthly_plan" enctype="multipart/form-data" id="monthly_plan">
		<div class="section">
			<div class="left">
				<p class="label">Name</p>
			</div>
			<div class="right">
				<input type="text" class="monthly_name" name="monthly_name" />
			</div>
		</div>
		<div class="small_input">
			<div class="left">
				<p class="label">SEO Hours / Month</p>
				<input type="text" class="monthly_seo_hours" name="monthly_seo_hours" />
			</div>
			<div class="right">
				<p class="label">Webdev Hours / Month</p>
				<input type="text" class="monthly_webdev_hours" name="monthly_webdev_hours" />
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Services</p>
			</div>
			<div class="right monthly_plan_container">
					<?php
						$monthly_services_option_array = array();
						foreach($monthly_services_options as $monthly_services_option){ 
							$monthly_services_option_array[] = $monthly_services_option;
						}
						sort($monthly_services_option_array);
					?>
					<?php foreach($monthly_services_option_array as $monthly_service_option){ ?>
					<input type="checkbox" class="monthly_checkbox" name="monthly_services[]" value="<?php echo $monthly_service_option; ?>">
					<p class="label checkbox_label"><?php echo $monthly_service_option; ?></p>
					<?php } ?>
			</div>
		</div>
		<div class="section">
			<div class="left">
				<p class="label">Budget / Month:</p>
			</div>
			<div class="right">
				<input type="text" class="monthly_budget" name="monthly_budget" />
			</div>
		</div>
		<div class="small_input">
			<div class="left">
				<p class="label">SEO Extra Expense</p>
				<input type="text" class="monthly_seo_extra_expense" name="monthly_seo_extra_expense" />
			</div>
			<div class="right">
				<p class="label">DEV Extra Expense</p>
				<input type="text" class="monthly_dev_extra_expense" name="monthly_dev_extra_expense" />
			</div>
		</div>
		<input type="submit" name="submit" class="button_1" value="Add Monthly Plan" />
		<a class="button_2" href="/monthly-plan/">Cancel</a>
	</form>
</div>
<?php 
if(isset($_POST['submit'])){		
	$monthly_name				= (isset($_POST['monthly_name']) ? $_POST['monthly_name'] : '');
	$monthly_seo_hours			= (isset($_POST['monthly_seo_hours']) ? $_POST['monthly_seo_hours'] : '');
	$monthly_webdev_hours		= (isset($_POST['monthly_webdev_hours']) ? $_POST['monthly_webdev_hours'] : '');
	$monthly_services_array		= (isset($_POST['monthly_services']) ? $_POST['monthly_services'] : ''); 
	$monthly_services			= serialize($monthly_services_array);
	$monthly_budget				= (isset($_POST['monthly_budget']) ? $_POST['monthly_budget'] : ''); 
	$monthly_seo_extra_expense	= (isset($_POST['monthly_seo_extra_expense']) ? $_POST['monthly_seo_extra_expense'] : ''); 
	$monthly_dev_extra_expense	= (isset($_POST['monthly_dev_extra_expense']) ? $_POST['monthly_dev_extra_expense'] : ''); 
	
	$insert = $wpdb->insert( $table_name , array( 
	'monthly_name'				=> $monthly_name,
	'monthly_seo_hours'			=> $monthly_seo_hours,
	'monthly_webdev_hours'		=> $monthly_webdev_hours,
	'monthly_services'			=> $monthly_services,
	'monthly_budget'			=> $monthly_budget,
	'monthly_seo_extra_expense'	=> $monthly_seo_extra_expense,
	'monthly_dev_extra_expense'	=> $monthly_dev_extra_expense
	), array( '%s', '%s' ));
	
	if($insert == 1){
		echo "<p class='message'>";
		echo "Monthly Plan Added!";
	}else{
		echo "Monthly Plan was not successfully added.";
		echo "</p>";
	}		
}
?>
<?php get_footer(); ?>