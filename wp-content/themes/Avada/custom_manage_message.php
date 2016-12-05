<?php /* Template Name: Message */ ?>
<?php get_header(); ?>
<?php 
$table_name = $wpdb->prefix . "custom_message"; 
$messages = $wpdb->get_results("SELECT * FROM {$table_name}");
$table_name_person = $wpdb->prefix . "custom_person";
?>
<div class="message">	
	<a id="create_message" class="button_1 add_message" href="/add-message/">+ Add message</a>	
</div>
<div class="display_main">
	<div class="display_section message">
		<h2 class="display_title">Global Message</h2>
		<?php			
			foreach($messages as $global_message){
				if($global_message->message_type == 'Global'){
					$message_id = $global_message->ID;
					$unserialize = unserialize($global_message->message);
					foreach($unserialize as $key => $message_date){
						$message_date_explode = explode('_', $message_date);
						$message = $message_date_explode[0];
					
			?>
					<div id="message_display_global_<?php echo $key; ?>" class="display_list">
						<div id="message_edit_global_<?php echo $key; ?>" class="message_edit button_2 display_button">Edit</div>
						<h3 id="message_global_<?php echo $key; ?>" class="display_subtitle"><?php echo $message; ?></h3>
						<div id="message_delete_global_<?php echo $key; ?>" class="message_delete button_2 display_button float_right">Delete</div>
						<div style="display:none;" id="message_global_<?php echo $key; ?>_loader" class="message_loader loader"></div>
					</div>
					<div class="display_separator"></div>
		<?php		
					}
				}	
			}			
		?>
		<h2 class="display_title">Personal Message</h2>	
		<?php			
			foreach($messages as $personal_message){
				if($personal_message->message_type == 'Personal'){					
					$message_person = $personal_message->message_person;
					$unserialize = unserialize($personal_message->message);
					$person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$message_person'");
					$person_id = $person->ID;
				?>								
				<div class="accordian personal_message">
					<h5 class="toggle">
						<div class="display_list">
							<a class="message_person_name" href="#">
							<h3 class="display_subtitle"><?php echo $message_person; ?></h3>								
							<span class="arrow"></span>
							</a>
						</div>						
					</h5>
					<div class="toggle-content" style="display: none;">
						<?php 
							foreach($unserialize as $key => $message_date){
								$message_date_explode = explode('_', $message_date);
								$message = $message_date_explode[0];
						?>
						<div id="message_display_personal_<?php echo $key ."_". $person_id; ?>" class="display_list">
							<div id="message_edit_personal_<?php echo $key ."_". $person_id; ?>" class="message_edit button_2 display_button">Edit</div>
							<h3 id="message_personal_<?php echo $key ."_". $person_id; ?>" class="display_subtitle"><?php echo $message; ?></h3>
							<div id="message_delete_personal_<?php echo $key ."_". $person_id; ?>" class="message_delete button_2 display_button float_right">Delete</div>
							<div style="display:none;" id="message_personal_<?php echo $key ."_". $person_id; ?>_loader" class="message_loader loader"></div>
						</div>
						<div class="display_separator"></div>
						<?php } ?>
					</div>
				</div>
				<?php			
				}	
			}			
		?>
	</div>
</div>
<div style="display:none;" id="dialog_form_edit_message" title="Edit Message"></div>
<div style="display:none;" id="dialog_form_delete_message" title="Delete Message"></div>
<?php get_footer(); ?>