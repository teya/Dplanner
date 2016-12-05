<?php /* Template Name: Add Goals */ ?>
<?php get_header(); ?>
<?php 
if(isset($_POST['submit'])){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_goals";
	
	$add_option = (isset($_POST['goal_type']) ? $_POST['goal_type'] : '');
	
	if(isset($_POST['personal_goal'])){
		$goal_person 	= (isset($_POST['goal_person']) ? $_POST['goal_person'] : '');	
		if($add_option == 'goal_yearly'){
			$goals_time		= (isset($_POST['goal_year']) ? $_POST['goal_year'] : '');	
			$goals_array	= (isset($_POST['submit_goals']) ? $_POST['submit_goals'] : '');	
			$goal_details = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goals_time' AND goal_person = '$goal_person'");
			if($goal_details != null){
				$goals_id = $goal_details->ID;
				$goals_list = unserialize($goal_details->goals);
				if($goals_list != null){
					$merge_goals = array_merge($goals_list, $goals_array);
					$serialized_array = serialize($merge_goals);
				}else{
					$serialized_array = serialize($goals_array);
				}				
				$update = $wpdb->update( $table_name , array( 
					'goals'	=> $serialized_array
				),	
				array( 'ID' => $goals_id ),
				array( '%s', '%s' ));
			}else{
				$db_status = 'add_goal';
			}
		}elseif($add_option == 'goal_monthly'){
			$goals_time		= (isset($_POST['goal_month']) ? $_POST['goal_month'] : '');
			$goals_array	= (isset($_POST['submit_goals']) ? $_POST['submit_goals'] : '');
			$goal_details = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goals_time' AND goal_person = '$goal_person'");
			if($goal_details != null){
				$goals_id = $goal_details->ID;
				$goals_list = unserialize($goal_details->goals);
				if($goals_list != null){
					$merge_goals = array_merge($goals_list, $goals_array);
					$serialized_array = serialize($merge_goals);
				}else{
					$serialized_array = serialize($goals_array);
				}				
				$update = $wpdb->update( $table_name , array( 
					'goals'	=> $serialized_array
				),	
				array( 'ID' => $goals_id ),
				array( '%s', '%s' ));
			}else{
				$db_status = 'add_goal';
			}
		}		
	}else{
		if($add_option == 'goal_yearly'){
			$goal_type		= 'Yearly';	
			$goals_time		= (isset($_POST['goal_year']) ? $_POST['goal_year'] : '');
			$goal_year		= (isset($_POST['goal_year']) ? $_POST['goal_year'] : '');
			$goals_array	= (isset($_POST['submit_goals']) ? $_POST['submit_goals'] : ''); 
			$goal_details = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goals_time'");
			if($goal_details != null){
				$goals_id = $goal_details->ID;
				$goals_list = unserialize($goal_details->goals);		
				if($goals_list != null){
					$merge_goals = array_merge($goals_list, $goals_array);
					$serialized_array = serialize($merge_goals);
				}else{
					$serialized_array = serialize($goals_array);
				}			
				$update = $wpdb->update( $table_name , array( 
					'goals'	=> $serialized_array
				),	
				array( 'ID' => $goals_id ),
				array( '%s', '%s' ));
			}else{
				$db_status = 'add_goal';
			}
		}elseif($add_option == 'goal_monthly'){
			$goal_type		= 'Monthly';
			$goals_time		= (isset($_POST['goal_month']) ? $_POST['goal_month'] : ''); 
			$goal_year		= (isset($_POST['goal_year']) ? $_POST['goal_year'] : ''); 
			$goals_array	= (isset($_POST['submit_goals']) ? $_POST['submit_goals'] : ''); 
			$goal_details = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goals_time'");
			if($goal_details != null){
				$goals_id = $goal_details->ID;
				$goals_list = unserialize($goal_details->goals);		
				if($goals_list != null){
					$merge_goals = array_merge($goals_list, $goals_array);
					$serialized_array = serialize($merge_goals);					
				}else{
					$serialized_array = serialize($goals_array);
				}			
				$update = $wpdb->update( $table_name , array( 
					'goals'	=> $serialized_array
				),	
				array( 'ID' => $goals_id ),
				array( '%s', '%s' ));
			}else{
				$db_status = 'add_goal';
			}
		}
	}
	
	if($db_status == 'add_goal'){
		$goal_person = (isset($_POST['goal_person']) ? $_POST['goal_person'] : ''); 
		if($add_option == 'goal_yearly'){
			$goal_type		= 'Yearly';	
			$goals_time		= (isset($_POST['goal_year']) ? $_POST['goal_year'] : ''); 
			$goal_year		= (isset($_POST['goal_year']) ? $_POST['goal_year'] : '');
			$goals_array	= (isset($_POST['submit_goals']) ? $_POST['submit_goals'] : '');
			$goals			=  serialize($goals_array);
		}elseif($add_option == 'goal_monthly'){
			$goal_type		= 'Monthly';
			$goals_time		= (isset($_POST['goal_month']) ? $_POST['goal_month'] : '');
			$goal_year		= (isset($_POST['goal_year']) ? $_POST['goal_year'] : '');
			$goals_array	= (isset($_POST['submit_goals']) ? $_POST['submit_goals'] : '');
			$goals			=  serialize($goals_array);
		}		
		$insert = $wpdb->insert( $table_name , array(
			'goal_person' 	=> $goal_person,
			'goal_type'		=> $goal_type,
			'goals_time'	=> $goals_time,
			'goal_year'		=> $goal_year,
			'goals'			=> $goals
		), array( '%s', '%s' ));
		if($insert == 1){
			echo "<p class='message'>";
			echo $status . " Added!";
			}else{
			echo $status . " was not successfully added.";
			echo "</p>";
		}
	}	
			
}
$current_year = date('Y');
$current_month = date('F');
$months = array('January', 'February','March','April','May','June','July','August','September','October','November','December');
$table_name_person = $wpdb->prefix . "custom_person";
$persons = $wpdb->get_col("SELECT person_fullname FROM {$table_name_person} WHERE person_status='0'");	
?>
<div class="add_goals">
	<form action="" method="post" name="goals" id="goals">
		<div class="section">
			<div class="left">
				<p class="label">Add: </p>
			</div>
			<div class="right">
				<div class="type_option">
					<input type="radio" name="goal_type" class="option_goal yearly_goal" value="goal_yearly" required />Yearly Goals
					<input type="radio" name="goal_type" class="option_goal monthly_goal" value="goal_monthly" required />Monthly Goals
					<input type="checkbox" name="personal_goal" class="option_goal personal_goal" value="goal_personal" />Personal Goals
				</div>
				<div class="time_option">
					<select style="display: none;" class="goals_time_year" name="goal_year">
							<option><?php echo $current_year; ?></option>
						<?php
							$future_years = $current_year + 5;
							$past_years = $current_year - 5;					
							for($year = $past_years; $year <= $future_years;  $year++){ 
								if($current_year != $year){
							?>
									<option><?php echo $year; ?></option>
						<?php 
								}
							} 					
						?>
					</select>
					<select style="display: none;" class="goals_time_month" name="goal_month">
						<option><?php echo $current_month; ?></option>
						<?php
							foreach($months	as $month){
								if($current_month != $month){
						?>
									<option><?php echo $month; ?></option>
						<?php 
								}	
							}
						?>
					</select>
					<select style="display: none;" class="goals_time_person" name="goal_person">
						<?php foreach($persons as $person){	?>
								<option><?php echo $person; ?></option>
						<?php }	?>
					</select>
				</div>
			</div>
		</div>		
		<div class="section">
			<div class="left">
				<p class="label">Goals</p>
			</div>
			<div class="right">
				<div class="goals_container"></div>
				<textarea name="goals" class="goals"></textarea>				
				<div class="button_2 add_more_goals">Add Goal</div>
			</div>
		</div>		
		<input type="submit" name="submit" class="button_1 add_goals_button" value="Add Goals" />
		<a class="button_2" href="/goals/">Cancel</a>
	</form>
</div>
<?php get_footer(); ?>