<?php /* Template Name: Services */ ?>
<?php get_header(); ?>
	<?php

		//Get Client that have services
		$sql = "SELECT c.id, c.client_name FROM ".CLIENT_TABLE." as c LEFT OUTER JOIN ".CLIENT_SERVICES_TABLE." as cs ON c.id = cs.client_id WHERE cs.service_name IS NOT NULL GROUP BY c.client_name";
		$clients = $wpdb->get_results($sql);
	?>
	<div class="">
		<a id="add_service_btn" class="button_1 float_left" href="<?php echo get_site_url(); ?>/manage-services/add-service/">+ Add Service</a>
		<div style="display:none;" class="loader filter_loader"></div>
		<div id="filter_services">
			<ul>
				<li>
					<label for="filter_client_service">Client</label>
					<select name="filter_client_service" id="filter_client_service" class="filter_client_service">
						<option value="0">All</option>
						<?php foreach($clients as $client){ ?>
							<?php echo '<option value="'.$client->id.'">'.$client->client_name.'</option>';?>
						<?php } ?>
					</select>
				</li>
				<li>
					<?php 
						$sql_services = "SELECT cs.id, so.service_name, cs.service_id FROM ".CLIENT_TABLE." as c LEFT OUTER JOIN ".CLIENT_SERVICES_TABLE." as cs ON c.id = cs.client_id  LEFT OUTER JOIN ".SEVICES_OPTION_TABLE." as so ON cs.service_id = so.id WHERE cs.service_name IS NOT NULL GROUP BY cs.service_name";
						$services = $wpdb->get_results($sql_services);
					?>
					<label for="filter_service">Services</label> 
					<select name="filter_service" id="filter_service" class="filter_service">
						<option value="0">All</option>
						<?php foreach($services as $service){ ?>
							<?php echo '<option value="'.$service->service_id.'">'.$service->service_name.'</option>'; ?>
						<?php } ?>
					</select>
				</li>
				<li>
					<label for="filter_due_date">Due</label> 
					<select name="filter_due_date" id="filter_due_date" class="filter_due_date">
						<option value="0">All</option>
						<option value="1">3 Months</option>
						<option value="2">1 Months</option>
						<option value="3">Overdue</option>
					</select>
				</li>
			</ul>
		</div>
	</div>
	<table id="client_services_table" class="dplan-table">
		<?php foreach($clients as $client) {?>
			<thead>
				<tr class="top_row">
					<th class="client_name"><?php echo $client->client_name; ?></th>
					<th>Licenses</th>
					<th>Price</th>
					<th>Revenue</th>
					<th>Renewal</th>
					<th>Notes</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php 
					//Get client services
					$sql_get_services = "SELECT cs.ID, so.service_name, cs.licenses, cs.customer_price, cs.our_price, cs.start_date, cs.invoice_interval, cs.notes as notes  FROM ".CLIENT_SERVICES_TABLE." as cs LEFT OUTER JOIN ".SEVICES_OPTION_TABLE." as so ON cs.service_id = so.id  WHERE client_id = ".$client->id;

					$get_client_services = $wpdb->get_results($sql_get_services);
				?>
				<?php foreach($get_client_services as $service){  ?>
					<?php
						$total = $service->customer_price * $service->licenses;
						$revenue = $total - ($service->our_price * $service->licenses);
						$date_passed = IfDatePassed($service->start_date);
						if($service->invoice_interval == 'Lifetime'){
							$service->start_date = 'Lifetime';
							$hide = 'hide';
							$date_passed = '';
						}
						if($service->start_date != ''){
							$next_invoice_date = date("Y-m-d", strtotime($service->start_date));
						}else{
							$next_invoice_date = '--';
							$hide_btn_invoice = 'hide';
						}

						$description = (!empty($service->notes))? $service->notes : '--';
						$no_desc = ($description == '--')? '' : '...';
						$short_description = substr($description, 0, 35) . $no_desc;


					?>
					<tr id="service_id_<?php echo $service->ID; ?>">
						<td class="service_name"><?php echo $service->service_name; ?></td>
						<td><?php echo $service->licenses; ?></td>
						<td><?php echo ($service->customer_price != '')? $service->customer_price : 0; ?></td>
						<td><?php echo $total; ?></td>
						<td class="invoice-date"><span class="<?php echo ($date_passed == 1)? 'date-passed' : ''; ?>"><?php echo $next_invoice_date; ?></span></td>
						<td>
							<div class="accordian">
								<h5 class="toggle">
									<div class="desc">
										<div>
											<?php echo $short_description; ?>
											<span class="arrow">
												
											</span>
										</div>
									</div>
								</h5>
								<div class="toggle-content" style="display: none;">
									<?php echo $description ?>
								</div>
							</div>
						</td>
						<td>
							<ul class="table-action-btn">
								<li>
									<div style="display: none;" class="loader invoice-loader"></div>
								</li>
								<li>
									<?php if($service->start_date != '' AND $next_invoice_date != 'Lifetime'){ ?>
										<i title="Invoice" class="fa fa-file-text-o invoiced_service" aria-hidden="true"></i>
									<?php } ?>
								</li>
								<li>
									<a href="<?php echo get_site_url(); ?>/manage-projects/edit-service/?editID=<?php echo $service->ID ?>"><i title="Edit" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</li>
								<li>
									<i title="Delete" class="fa fa-trash-o delete_client_service" aria-hidden="true"></i>
								</li>
							</ul>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		<?php } ?>
	</table>
	<!-- POP-Up to confirm delete Client service -->
	<div style="display:none;" class="delete_client_service_dialog" id="delete_client_service_dialog" title="Deleting Service">
		<form class="" id="">
			<input type="hidden" id="client_form_id" name="" value="">
			<p class="">
				Are you sure you want to delete <span class="service_name text-bold"></span> service from <span class="clientname text-bold"></span>?
			</p>
			<div class="dplan_dialog_footer">
				<div  id="cancel_delete" class="button_1 pull-right">Cancel</div>
				<div  id="confirmed_delete_client_service" class="button_1 pull-right">Delete</div>
				<div style="display: none;" class="loader loader-delete pull-right"></div>
			</div>
		</form>
	</div>
	<!-- POP-Up succesfully deleting client service -->
	<div style="display:none;" class="success-delete-service-dialog" id="success-delete-service-dialog" title="SUccessfully Deleting Service">
		<form class="" id="">
			<input type="hidden" id="client_form_id" name="" value="">
			<p class="">
				Successfull Deleting services.</p>
			<div class="dplan_dialog_footer">

				<div  id="close_delete_client_service_dialog" class="button_1 pull-right">OK</div>

			</div>
		</form>
	</div>
	<!-- POP-Up to confirm invoicing Client service -->
	<div style="display:none;" class="invoice_service_dialog" id="invoice_service_dialog" title="Invoicing Client Service">
		<form class="" id="">
			<input type="hidden" id="service_id_invoicing" name="" value="">
			<p class="">
				Are you sure you want to invoice this <span class="service_name text-bold"></span> service from <span class="clientname text-bold"></span>?
			</p>
			<div class="dplan_dialog_footer">
				<div  id="cancel_invoice_dialog" class="button_1 pull-right">Cancel</div>
				<div  id="confirmed_invoicing_client_service" class="button_1 pull-right">Invoice</div>
				<div style="display: none;" class="loader loader-delete pull-right"></div>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		function trigger_accordion_toggle(){
			jQuery('.toggle-content').each(function() {
				if(!jQuery(this).hasClass('default-open')){
					jQuery(this).hide();
				}
			});
		}
		jQuery( "#invoice_service_dialog" ).dialog({
			autoOpen: false,
			height: 180,
			width: 350,
			modal: true,
			close: function() {
			}
		});
		jQuery( "#delete_client_service_dialog" ).dialog({
			autoOpen: false,
			height: 180,
			width: 350,
			modal: true,
			close: function() {
			}
		});
		jQuery( "#success-delete-service-dialog" ).dialog({
			autoOpen: false,
			height: 180,
			width: 350,
			modal: true,
			close: function() {
			}
		});
		jQuery(document).ready(function(){

			//Filter table
			jQuery(document).on('change', '#filter_services ul li select', function(){
				var client_id = jQuery('#filter_client_service').val();
				var service_id = jQuery('#filter_service').val();
				var due_value = jQuery('#filter_due_date').val();
				jQuery('.filter_loader').show();

				jQuery('#client_services_table').fadeOut();

				var data ={
					'client_id' : client_id,
					'service_id' : service_id,
					'due_value' : due_value
				}

				jQuery.ajax({				
						type: "POST",
						url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
						data:{
							'type' : 'filter_client_service',
							'data_object' : data
						},
					success: function (data) {
						var parsed = jQuery.parseJSON(data);
						jQuery('#client_services_table').html(parsed.client_services_html).fadeIn();;
						jQuery('.filter_loader').hide();
						trigger_accordion_toggle();
					},
					error: function(){
						
					}
				});
			});

			//COnfirm dialog box for invoicing service for client
			 jQuery(document).on('click', '.invoiced_service', function(){
				var id = jQuery(this).closest('tr').attr('id').split('_')[2];
				jQuery('#service_id_invoicing').val(id);
				var client = jQuery(this).closest('tbody').prev('thead').find('.client_name').text();
				jQuery("#client_form_id").val(id);
	
				var service_name = jQuery('#service_id_'+id+' .service_name').text();
			 	var invoice_dialog_box = jQuery('#invoice_service_dialog');
				invoice_dialog_box.find('.service_name ').text(service_name);
				invoice_dialog_box.find('.clientname').text(client);
				invoice_dialog_box.dialog('open');
			 });

			 //Cancel dialog box for invoicing service for client
			 jQuery(document).on('click', '#cancel_invoice_dialog', function(){
			 	jQuery('#invoice_service_dialog').dialog('close');
			 });

			jQuery(document).on('click', '#confirmed_invoicing_client_service', function(){
				var id = jQuery('#service_id_invoicing').val();

				jQuery('#service_id_'+id+' td .table-action-btn .loader').show();

				jQuery.ajax({				
						type: "POST",
						url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
						data:{
							'type' : 'invoice_services',
							'data_id' : id
						},
					success: function (data) {
						var parsed = jQuery.parseJSON(data);

						if(parsed.status == 'successfully-updated-invoice-date'){
							// jQuery('#display_note_'+parsed.id+" .display_list div .invoice-date").html("Next Invoice : "+parsed.new_invoice_date).removeClass('date-passed');
							jQuery('#invoice_service_dialog').dialog('close');
							jQuery('#service_id_'+parsed.id+' td.invoice-date span').text(parsed.new_invoice_date).removeClass('date-passed');
							jQuery('#service_id_'+parsed.id+' td .table-action-btn .loader').hide();
						}else{
							alert('ERROR INVOICING SERVICE!');
						}


					},
					error: function(){
						
					}
				});	
			});			

			//Close succussfully deleting service dialogbox 
			jQuery(document).on('click', '#close_delete_client_service_dialog', function(){
				jQuery('#success-delete-service-dialog').dialog('close');
			});

			//confirm delete client service 
			jQuery(document).on('click', '.delete_client_service', function(){
				var id = jQuery(this).closest('tr').attr('id').split('_')[2];
				var client = jQuery(this).closest('tbody').prev('thead').find('.client_name').text();
				jQuery("#client_form_id").val(id);
	
				var service_name = jQuery('#service_id_'+id+' .service_name').text();
				
				var dialog_box = jQuery('#delete_client_service_dialog');
				dialog_box.find('.service_name ').text(service_name);
				dialog_box.find('.clientname').text(client);
				dialog_box.dialog('open');
			});

			//close delete service dialog
			jQuery(document).on('click', '#cancel_delete', function(){
				jQuery('#delete_client_service_dialog').dialog('close');
			});

			//deleting client service from DB
			jQuery(document).on('click', '#confirmed_delete_client_service', function(){
				jQuery(".loader-delete").show();
				var id = jQuery('#client_form_id').val();
				jQuery.ajax({
					type: "POST",
					url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
					data:{
						'type' : 'delete_client_service',
						'data_id' : id				
					},
					success: function (data) {
						var parsed = jQuery.parseJSON(data);

						if(parsed.delete_client_service_status == 'successfully-deleting-client-service'){
							jQuery(".loader-delete").hide();
							jQuery('#service_id_'+parsed.service_id).fadeOut().remove();
							jQuery('#delete_client_service_dialog').dialog('close');
							jQuery('#success-delete-service-dialog').dialog('open');
						}else{
							alert('error deleting client service!');
						}
					
					},
					error: function (data) {
		
					}
				});
			});
		});
		trigger_accordion_toggle();
	</script> 
<?php get_footer(); ?>