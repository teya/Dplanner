<?php /* Template name: Monthly Plan Information */ ?>
<?php get_header(); 
$id = $_GET['id'];
$table_name = $wpdb->prefix . "custom_monthly_plan"; 
$monthly_plan = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = '$id'");
?>
<div class="info_monthly_plan">
	<div class="section">
		<div class="left">
			<p class="label">Name</p>
		</div>
		<div class="right">
			<p><?php echo $monthly_plan->monthly_name; ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">SEO Hours / Month</p>
		</div>
		<div class="right">
			<p><?php echo $monthly_plan->monthly_seo_hours; ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">Webdev Hours / Month</p>
		</div>
		<div class="right">
			<p><?php echo $monthly_plan->monthly_webdev_hours; ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">Services</p>
		</div>
		<div class="right">
			<p>
				<ul>
				<?php
				$services = unserialize($monthly_plan->monthly_services); 
				foreach($services as $service){
				?>
				<li><?php echo $service; ?></li>
				<?php } ?>
				</ul>
			</p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">Budget / Month:</p>
		</div>
		<div class="right">
			<p><?php echo $monthly_plan->monthly_budget; ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">SEO Extra Expense</p>
		</div>
		<div class="right">
			<p><?php echo $monthly_plan->monthly_seo_extra_expense; ?></p>
		</div>
	</div>
	<div class="section">
		<div class="left">
			<p class="label">DEV Extra Expense</p>
		</div>
		<div class="right">
			<p><?php echo $monthly_plan->monthly_dev_extra_expense; ?></p>
		</div>
	</div>
	<a class="button_2 display_button" href="/monthly-plan/">Return</a>
	<a id="create_projects" class="button_1 display_button padding_button" href="/add-monthly-plan/">+ Add Monthly Plan</a>
	<a class="button_2 display_button" href="/edit-monthly-plan/?id=<?php echo $monthly_plan->ID ?>">Edit</a>
	<a class="button_2 display_button confirm" href="/monthly-plan/?deleteID=<?php echo $monthly_plan->ID ?>">Delete</a>
</div>
<?php get_footer(); ?>