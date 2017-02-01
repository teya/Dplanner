<?php 
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
$persons_table = $wpdb->prefix . "custom_person";
$table_name_timesheet = $wpdb->prefix . 'custom_timesheet';
$table_name_todolist = $wpdb->prefix . 'custom_client_todo_lists';
$table_name_client = $wpdb->prefix . 'custom_client';


$timezone = get_option('timezone_string'); 
date_default_timezone_set($timezone);

$persons = $wpdb->get_results('SELECT * FROM wp_custom_person');

foreach($persons as $person){
	if($person->person_email_notification == 1){
<<<<<<< HEAD
			/* empty task */
			$end_date = date("Y-m-d", strtotime("yesterday"));
			$list_empty_dates = '';
		
			$date = date_create($end_date);
			date_sub($date,date_interval_create_from_date_string("4 days"));
			$start_date = date_format($date,"Y-m-d");
			$date_range = date_range($start_date, $end_date);
			$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
			$current_person = $wpdb->get_row("SELECT * FROM {$persons_table} WHERE wp_user_id = ".$person->wp_user_id);

			$empty_dates_array = array();
			foreach($date_range as $date){
				$explode_date = explode('/', $date);
				$day = $explode_date[0];
				$month = $explode_date[1];
				$year = $explode_date[2];
				$date_format = $year."/".$month."/".$day;
				$day_number = date('w', strtotime($date_format));
				$total_hours_day = 0;

				if($day_number != 0 && $day_number != 6){ //Exclude Saturday and Sunday
					$timesheet_empty_days = $wpdb->get_results("SELECT * FROM {$table_name_timesheet} WHERE task_person = '$person->person_fullname' AND date_now = '$date'");

					//Add Totol Hours per day
					if(!empty($timesheet_empty_days)){
						if($date == $timesheet_empty_days[0]->date_now){
							foreach($timesheet_empty_days as $day_inputs){
								$total_hours_day += decimalHours($day_inputs->task_hour);
							}
						}
					}
=======
>>>>>>> bf10af1d19872f4d38729839c2cabe251c662c25

		$query = 'SELECT 
					client_tbl.id,
					todolist_tbl.taskname,
				    todolist_tbl.priority,
				    client_tbl.client_name,
				    IF(todolist_tbl.deadline = "0000-00-00", "--", date_format(todolist_tbl.deadline, "%Y-%b-%d")) as deadline
				    FROM '.$table_name_todolist.' as todolist_tbl 
				    LEFT JOIN '.$table_name_client.' as client_tbl  
				    ON todolist_tbl.client_id = client_tbl.id
				    WHERE todolist_tbl.priority = "1 Urgent" 
				    AND ( todolist_tbl.consultant_id = '. $person->wp_user_id.' OR  todolist_tbl.consultant_id = 0 )';

		//Get All Person's Urgent Todolist
		$Todolist = $wpdb->get_results($query);
		$Todolist_html_table = '';

		if(!empty($Todolist)){
			$Todolist_html_table = '<p>You have a Urgent Todolist/s</P>';
			$Todolist_html_table .= '<table border="1">';
			$Todolist_html_table .= '<teadh><tr><th>Todolist name</th><th>Client</th><th>Priority</th><th>Deadline</th></tr></thead>';
			foreach($Todolist as $list){
				$Todolist_html_table .= '<tr><td>'.$list->taskname.'</td><td>'.$list->client_name.'</td><td>'.$list->priority.'</td><td>'.$list->deadline.'</td></tr>';
			}
			$Todolist_html_table .= '</table>';
		}

		/* empty task */
		$end_date = date("Y-m-d", strtotime("yesterday"));
		$list_empty_dates = '';
	
		$date = date_create($end_date);
		date_sub($date,date_interval_create_from_date_string("4 days"));
		$start_date = date_format($date,"Y-m-d");
		$date_range = date_range($start_date, $end_date);
		$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
		$current_person = $wpdb->get_row("SELECT * FROM {$persons_table} WHERE wp_user_id = ".$person->wp_user_id);

		$empty_dates_array = array();
		foreach($date_range as $date){
			$explode_date = explode('/', $date);
			$day = $explode_date[0];
			$month = $explode_date[1];
			$year = $explode_date[2];
			$date_format = $year."/".$month."/".$day;
			$day_number = date('w', strtotime($date_format));
			$total_hours_day = 0;

			if($day_number != 0 && $day_number != 6){
				$timesheet_empty_days = $wpdb->get_results("SELECT * FROM {$table_name_timesheet} WHERE task_person = '$person->person_fullname' AND date_now = '$date'");

				//Add Totol Hours per day
				if(!empty($timesheet_empty_days)){
					if($date == $timesheet_empty_days[0]->date_now){
						foreach($timesheet_empty_days as $day_inputs){
							$total_hours_day += decimalHours($day_inputs->task_hour);
						}
					}
				}

				//If total hours is not person's total work hours per day.
				if($person->person_hours_per_day > $total_hours_day){
					array_push($empty_dates_array, array($date => $total_hours_day));
				}

			}
		}

		// List the days not completed for for person's total work hours.
		$list_empty_dates = '<ul>';
		$days_count = 0;
		foreach($empty_dates_array as $date){
			$days_count++;	
			$total_hours = array_values($date)[0];
			$date = DateTime::createFromFormat('d/m/Y', array_keys($date)[0]);
			$list_empty_dates .= '<li>'. $date->format('M d, Y') .' - Total: '.$total_hours.' hour/s filled in so far.</li>';
		}
		$list_empty_dates .="</ul>";

<<<<<<< HEAD
			//Create the Email Template
			if($days_count > 0){
				$body = '
				<h1>Dear '.$person->person_fullname.',</h1>
				<p>You have '.$days_count.' days which are not yet completed in Dplan timesheet.</p>
				<p>Here are the dates::</p>
				'.$list_empty_dates.'
				<br />
				<p>I have spend many hours creating this function, so please use it properly by filling in your timesheet ASAP!</p>
				<p>Thank you and have a good day.</p>
				<p>Regards,<br />
				Gray</p>
				<p><a href="http://dplan.seowebsolutions.com/" target="_blank">Login to Dplan Here Now!</a></p>
				<br />
				';

				//Email Headers
				$to = $person->person_email;
				$admin_email = get_option( 'admin_email' ); 
				$subject = 'Dplan Timesheet reminder';
				$headers = array('Content-Type: text/html; charset=UTF-8','From: Dplan <'.$admin_email.'>');
				
				//Send the Email to Person. 
				$email_status = wp_mail( $to, $subject, $body, $headers );
				// echo $body;
				echo $email_status;				
			}

=======
		//Create the Email Template
		if($days_count > 0){
			$body = '
			<h1>Dear '.$person->person_fullname.',</h1>
			<p>You have '.$days_count.' days which are not yet completed in Dplan timesheet.</p>
			<p>Here are the dates:</p>
			'.$list_empty_dates.'
			<br />'.$Todolist_html_table 
			.'<p>I have spend many hours creating this function, so please use it properly by filling in your timesheet ASAP!</p>
			<p>Thank you and have a good day.</p>
			<p>Regards,<br />
			Gray</p>
			<p><a href="http://dplan.seowebsolutions.com/" target="_blank">Login to Dplan Here Now!</a></p>
			<br />
			';

			//Email Headers
			$to = $person->person_email;
			$admin_email = get_option( 'admin_email' ); 
			$subject = 'Dplan Timesheet reminder';
			$headers = array('Content-Type: text/html; charset=UTF-8','From: Dplan <'.$admin_email.'>');
			
			//Send the Email to Person. 
			$email_status = wp_mail( $to, $subject, $body, $headers );
			// echo $body;
			echo $email_status;		
		}
>>>>>>> bf10af1d19872f4d38729839c2cabe251c662c25
	}
}
?>