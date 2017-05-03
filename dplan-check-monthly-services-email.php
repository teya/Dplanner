<?php
	require( dirname( __FILE__ ) . '/wp-blog-header.php' );
	$timezone = get_option('timezone_string'); 
	date_default_timezone_set($timezone);
	setlocale(LC_ALL, 'sv_SE');

	$next_date_month = date('m', strtotime('+1 month'));
	$next_date_year = date('Y', strtotime('+1 month'));

	$client_services_sql = "SELECT 
		c.client_name as customer, 
		so.service_name as service, 
		s.start_date as next_invoice,
		s.notes as notes 
		FROM ".CLIENT_SERVICES_TABLE." as s 
		RIGHT JOIN ".CLIENT_TABLE." as c 
		ON s.client_id = c.ID
		LEFT JOIN ".SEVICES_OPTION_TABLE." as so
		ON s.service_id = so.ID
		WHERE STR_TO_DATE(start_date, '%m/%d/%Y') BETWEEN STR_TO_DATE('".$next_date_month."/01/".$next_date_year."', '%m/%d/%Y') AND STR_TO_DATE('".$next_date_month."/31/".$next_date_year."', '%m/%d/%Y') ORDER by next_invoice ASC";


	$client_services = $wpdb->get_results($client_services_sql);

	if(!empty($client_services)){
		$services_table_string = "<table style='width: 520px;'><tr><th style='padding: 20px 5px 20px 5px; text-align: left;'>Kund</th><th style='padding: 20px 5px 20px 5px; text-align: left;'>Tjänst</th><th style='padding: 20px 5px 20px 5px; text-align: left;'>Datum</th><th style='padding: 20px 5px 20px 5px; text-align: left;'>Beskrivning</th></tr>";
		foreach ($client_services as $service) {
			$services_table_string .= "<tr><td style='padding: 20px 5px 20px 5px; text-align: left;'>".$service->customer."</td><td style='padding: 20px 5px 20px 5px; text-align: left;'>".$service->service."</td><td style='padding: 10px 5px 10px 5px; text-align: left;'>".date("Y-m-d", strtotime($service->next_invoice))."</td><td style='padding: 20px 5px 20px 5px; text-align: left;'>".$service->notes."</td></tr>"; 
		}
		$services_table_string .= "</table>";

		$body = "<h3>Information från DPLAN</h3>";
		$body .= "<p>Dessa tjänster går ut inom kort.</p>";
		$body .= $services_table_string;

		//Email Headers
		$to = 'teknik@digerati.se';
		// $to = 'gray.greecos@gmail.com';
		$admin_email = get_option( 'admin_email' ); 
		$subject = 'Digerati tjänster som går ut snart.';
		$headers = array('Content-Type: text/html; charset=UTF-8','From: Dplan <'.$admin_email.'>');
		
		//Send the Email to Person. 
		$email_status = wp_mail( $to, $subject, $body, $headers );
		// echo $body;
		echo $email_status;
	
	}



?>