<?php 
	/* Template name: Maintainance */ 
	if (!is_user_logged_in()) {
	    wp_redirect( wp_login_url( $redirect ) );
	    exit();
	}
	$client_tablename = $wpdb->prefix ."custom_client";
 	$clients = $wpdb->get_results("SELECT ID, client_name, client_maintenance_schedule, CASE WHEN (client_maintenance_hours is null OR client_maintenance_hours = '') THEN '--'ELSE client_maintenance_hours END AS client_maintenance_hours, CASE WHEN (client_next_schedule_maintenance is null or client_next_schedule_maintenance = '') THEN '--'ELSE DATE_FORMAT(STR_TO_DATE(client_next_schedule_maintenance,'%m/%d/%Y'),'%Y-%m-%d') END AS client_next_schedule_maintenance FROM wp_custom_client WHERE client_service_agreement = 'Yes'ORDER BY  client_name ASC"); ?> <?php get_header(); ?>
	<table id="client-maintenance-table" class="dplan-table">
		<thead>
			<tr>
				<th>Client</th>
				<th>Maintainance Schedule</th>
				<th>Maintainance Hours</th>
				<th>Scheduled Date</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($clients as $client){ ?>
				<tr id="client_id_<?php echo $client->ID; ?>">
					<td><?php echo $client->client_name ?></td>
					<td><?php echo $client->client_maintenance_schedule ?></td>
					<td><?php echo $client->client_maintenance_hours ?></td>
					<td><span class="edit_client_next_schedule_maintenance"><?php echo $client->client_next_schedule_maintenance ?></span></td>
					<td>
						<div class="option-list">
							<i class="fa fa-eye view_list_button pull-right" aria-hidden="true" title="View Client Details"></i>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<script type="text/javascript">
		//Initialize Datepicker
		jQuery('body').on('focus',".datepicker", function(){
			jQuery(this).datepicker({ dateFormat: 'yy-mm-dd', minDate: 0});
		});
		
		jQuery(document).ready(function(){
			jQuery('.view_list_button').on('click', function(){
				var row_id = jQuery(this).closest('tr').attr('id');
				
			});

			//show input for edit date
			jQuery('.edit_client_next_schedule_maintenance').on('dblclick', function(){
				var current_row = jQuery(this);
				var date = current_row.text();
				var d = new Date();
				var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
				date = (date == '--')? strDate : date;

				current_row.html('<input name="" readonly="" class="datepicker new_client_scheduled_date" value="'+date+'"><div class="pull-right edit_client_scheduled_date"></div><div style="display: none;" class="row-update-loader pull-right"></div>');
			});


			jQuery('body').on('click',".edit_client_scheduled_date", function(){
				var row_id = jQuery(this).closest('tr').attr('id');

				var new_date = jQuery('#'+row_id).find('.new_client_scheduled_date').val();
				jQuery('#'+row_id).find('.edit_client_scheduled_date').hide();
				jQuery('#'+row_id).find('.row-update-loader').show();

				var data = {
					'client_id' : row_id,
					'new_date' : new_date
				}

				jQuery.ajax({
					type: "POST",
					url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
					data:{
						'type' : 'client_maintenanace_update_date',
						'data_object' : data				
					},
					success: function (data) {
						var filter_data = jQuery.parseJSON(data);

					},
					error: function (data) {
						
					}
				});	


			});
		});
	</script>
<?php get_footer(); ?>