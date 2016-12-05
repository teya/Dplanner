<?php /* Template Name: Getharvest */ ?>
<?php get_header(); ?>
<?php 
global $wpdb;
$table_name = $wpdb->prefix . "custom_getharvest";
// $getharvest_extracol = $wpdb->get_results("SELECT * FROM {$table_name} WHERE COL22 != ''");
$getharvest = $wpdb->get_results("SELECT * FROM {$table_name}");
?>
<div class="getharvest">	
	<table class="table_results" id="table_results">
		<tr class="table_head">
			<td>Date</td>
			<td>Client</td>
			<td>Project</td>
			<td>Task</td>
			<td>Hours</td>
			<td>Billable</td>
			<td>Invoiced</td>
			<td>Approved</td>
			<td>Person</td>
			<td>Department</td>
			<td class="two_rows">Billable Rate</td>
			<td class="two_rows">Billable Amount</td>
			<td class="two_rows">Cost Rate</td>
			<td class="two_rows">Cost Amount</td>
		</tr>
		<?php foreach( $getharvest as $results ){ ?>
		<tr id="table_data_<?php echo $results->ID; ?>" class="table_data">
			<td><?php echo $results->Date; ?></td>
			<td><?php echo $results->Client; ?></td>
			<td><?php echo $results->Project; ?></td>
			<td><?php echo $results->Task; ?></td>
			<td><?php echo $results->Hours; ?></td>
			<td><?php echo $results->Billable; ?></td>
			<td><?php echo $results->Invoiced; ?></td>
			<td><?php echo $results->Approved; ?></td>
			<?php $person_name = $results->FirstName ." ". $results->LastName; ?>
			<td><?php echo $person_name; ?></td>
			<td><?php echo $results->Department; ?></td>
			<td><?php echo $results->BillableRate; ?></td>
			<td><?php echo $results->BillableAmount; ?></td>
			<td><?php echo $results->CostRate; ?></td>
			<td><?php echo $results->CostAmount; ?></td>			
			<td style="display: none;" id="task_note_<?php echo $results->ID; ?>" class="task_note">				
				<p style="float:left"><strong><?php echo $results->Client .":&nbsp";?></strong></p>
				<p style="float:left"><?php echo $results->Notes; ?></p>
			</td>
		</tr>
		
		<?php } ?>
	</table>
</div>
<script>		 
	var options = {			
	currPage : 1, 			
	optionsForRows : [10,20,30,40,50,100],			
	rowsPerPage : 10,			
	firstArrow : (new Image()).src="<?php bloginfo("template_directory"); ?>/img/sprevious.png",			
	prevArrow : (new Image()).src="<?php bloginfo("template_directory"); ?>/img/previous.png",			
	lastArrow : (new Image()).src="<?php bloginfo("template_directory"); ?>/img/snext.png",			
	nextArrow : (new Image()).src="<?php bloginfo("template_directory"); ?>/img/next.png",			
	topNav : true		
	};		 
	jQuery('#table_results').tablePagination(options);				
			
</script>
<?php get_footer(); ?>