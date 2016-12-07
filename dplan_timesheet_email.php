<?php 
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
$persons_table = $wpdb->prefix . "custom_person";
$table_name_timesheet = $wpdb->prefix . 'custom_timesheet';

$timezone = get_option('timezone_string'); 
date_default_timezone_set($timezone);

$persons = $wpdb->get_results('SELECT * FROM '.$persons_table);

foreach($persons as $person){
if($person->person_email_notification == 1){
		/* empty task */
		$end_date = date("Y-m-d", strtotime("yesterday"));
		$list_empty_dates = '';
		// $yesterday = date("d/m/Y", strtotime("yesterday"));
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
			if($day_number != 0 && $day_number != 6){
				$timesheet_empty_days = $wpdb->get_results("SELECT * FROM {$table_name_timesheet} WHERE task_person = '$person->person_fullname' AND date_now = '$date'");				
				if($timesheet_empty_days == null){
					$empty_dates_array[] = $date;			
				}
			}
		}

		$list_empty_dates = '<ul>';

		foreach($empty_dates_array as $date_empty){
			$date = DateTime::createFromFormat('d/m/Y', $date_empty);
			$list_empty_dates .= '<li>'. $date->format('M d, Y') .'</li>';
		}
		$list_empty_dates .="</ul>";

		if(count($empty_dates_array) != 0){
			$body = '
			<h1>Hello '.$person->person_fullname.',</h1>
			<p>You have empty timsheet slots from Splan</p>
			<p>Here are the following dates:</p>
			'.$list_empty_dates.'
			<br />
			<p>Please fill up your empty timehsheet days ASAP. Thank You and have a Good day.</P>
			<p><a href="http://dplan.seowebsolutions.com/" target="_blank">Log In Here to Dplan</a></p>
			<br />
			';

			$to = $person->person_email;
			$subject = 'Dplan Timesheet reminder';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			 
			$email_status = wp_mail( $to, $subject, $body, $headers );
			echo $email_status;

		}
	}
}
?>