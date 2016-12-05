<?php /* Template Name: Add Message */ ?>
<?php get_header(); ?>
<?php 
if(isset($_POST['submit'])){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_message";
	
	date_default_timezone_set('Asia/Manila');
	
	$add_option 		= (isset($_POST['message_type']) ? $_POST['message_type'] : '');
	$message_date 		= date("Y-m-d H:i:s");
	$message_text		= (isset($_POST['message']) ? $_POST['message'] : '');
	$message			= array($message_text ."_". $message_date);
	$message_person		= (isset($_POST['message_person']) ? $_POST['message_person'] : '');
	
	if($add_option == 'global_message'){
		$message_type		= 'Global';		
		$messages = $wpdb->get_row("SELECT * FROM {$table_name} WHERE message_type = 'Global'");
		$message_id = $messages->ID;
		
		if($messages != null){
			$unserialized = unserialize($messages->message);			
			$merge_message = array_merge($unserialized, $message);
			$serialized = serialize($merge_message);
			
			$insert = $wpdb->update( $table_name , array( 
				'message'	=> $serialized
			),	
			array( 'ID' => $message_id ),
			array( '%s', '%s' ));
		}else{
			$serialized = serialize($message); 
			$insert = $wpdb->insert( $table_name , array(
				'message_type'		=> $message_type,
				'message'			=> $serialized
			), array( '%s', '%s' ));
		}
	}
	
	if($add_option == 'personal_message'){
		$message_type		= 'Personal';		
		$messages = $wpdb->get_row("SELECT * FROM {$table_name} WHERE message_person = '$message_person'");
		$message_id = $messages->ID;
		if($messages != null){
			$unserialized = unserialize($messages->message);			
			$merge_message = array_merge($unserialized, $message);
			$serialized = serialize($merge_message);
			
			$insert = $wpdb->update( $table_name , array( 
				'message'	=> $serialized
			),	
			array( 'ID' => $message_id ),
			array( '%s', '%s' ));
		}else{
			$serialized = serialize($message); 
			$insert = $wpdb->insert( $table_name , array(
				'message_type'		=> $message_type,
				'message_person'	=> $message_person,
				'message'			=> $serialized
			), array( '%s', '%s' ));
		}		
	}
	
		
	if($insert == 1){
		echo "<p class='message'>";
		echo $message_type . " Message Added!";
	}else{
		echo $message_type . " Message was not successfully added.";
		echo "</p>";
	}		
}
$table_name_person = $wpdb->prefix . "custom_person";
$persons = $wpdb->get_col("SELECT person_fullname FROM {$table_name_person} WHERE person_status='0'");	
?>
<div class="add_message">
	<form action="" method="post" name="message" id="message">
		<div class="section">
			<div class="left">
				<p class="label">Add: </p>
			</div>
			<div class="right">
				<div class="type_option">
					<input type="radio" name="message_type" class="option_message global_message" value="global_message" required />Global Message
					<input type="radio" name="message_type" class="option_message personal_message" value="personal_message" required />Personal Message
				</div>			
				<select style="display: none;" class="message_person" name="message_person">
					<?php foreach($persons as $person){	?>
							<option><?php echo $person; ?></option>
					<?php }	?>
				</select>
			</div>
		</div>		
		<div class="section">
			<div class="left">
				<p class="label">Message</p>
			</div>
			<div class="right">
				<textarea name="message" class="message"></textarea>
			</div>
		</div>		
			<input type="submit" name="submit" class="button_1 add_message_button" value="Add Message" />
			<a class="button_2" href="/message/">Cancel</a>
		</div>
	</form>
</div>
<?php get_footer(); ?>