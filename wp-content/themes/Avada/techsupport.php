<?php /* Template Name: Techsupport */ ?>
<?php get_header(); ?>
<!--<p>add website modal : custom_add_project.php</p>
<p>add website modal : custom_manage_submit_task.php</p>
<a href='http://lastvagnsdelar.com/' target='_blank'>http://lastvagnsdelar.com/</a>
<a href='http://norrahalland.se/' target='_blank'>http://norrahalland.se/</a>-->

<?php 
// global $wpdb;
// $table_name = 'wp_custom_getharvest';
/////////////////// $table_name = 'wp_custom_timesheet';
// $search_all = $wpdb->get_results("SELECT * FROM $table_name WHERE Client='Lewrens AB'");
////////////////// $search_all = $wpdb->get_results("SELECT * FROM $table_name WHERE task_label='Lewrens AB'");

// $counter = 1;
// foreach($search_all as $search_replace){
	// $replace_id = $search_replace->ID;
	// $update = $wpdb->update($table_name , array( 
	// 'Client' => 'Lewrens'
	////////////////// 'task_label' => 'Lewrens'
	// ),
	// array( 'ID' => $replace_id ),
	// array( '%s' ));
	
	// if($update == 1){
		// echo 'success<br/>';
	// }else{
		// echo 'fail<br/>';
	// }
	// print_var($counter);
	// $counter++;
// }
?>
<?php

// you can obtain you access id and secret key here: http://www.seomoz.org/api/keys
// $accessID = "mozscape-7552c70f84"; // * Add unique Access ID
// $secretKey = "50fdd246150803253e037cd3b835669"; // * Add unique Secret Key
 
// Set your expires for several minutes into the future.
// Values excessively far in the future will not be honored by the Mozscape API.
// $expires = time() + 300;
 
// A new linefeed is necessary between your AccessID and Expires.
// $stringToSign = $accessID."\n".$expires;
 
// Get the "raw" or binary output of the hmac hash.
// $binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
 
// We need to base64-encode it and then url-encode that.
// $urlSafeSignature = urlencode(base64_encode($binarySignature));
 
// This is the URL that we want link metrics for.
// $objectURL = $_POST['url'];
 
// Add up all the bit flags you want returned.
// Learn more here: http://apiwiki.seomoz.org/categories/api-reference
// $cols = "103079215140";
 
// Now put your entire request together.
// This example uses the Mozscape URL Metrics API.
// $requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
 
// We can easily use Curl to send off our request.
// $options = array(
    // CURLOPT_RETURNTRANSFER => true
    // );
 
// $ch = curl_init($requestUrl);
// curl_setopt_array($ch, $options);
// $content = curl_exec($ch);
// curl_close($ch);
 
// * Store URL metrics in array

// $json_a = json_decode($content);

// * Assign URL metrics to separate variables

// $pageAuthority = round($json_a->upa,0); // * Use the round() function to return integer
// $domainAuthority = round($json_a->pda,0);
// $externalLinks = $json_a->ueid;
// $theUrl = $json_a->uu;
 
?>
<!--<form method="post" action="">
	<label for="url">Enter URL:</label><input type="url" name="url" id="url"/>
	<input type="submit" value="Get URL Metrics!"/>
</form>
<ul>
	<li><strong>URL:</strong> <?php //echo $theUrl; ?></li>
	<li><strong>Page Authority:</strong> <?php// echo $pageAuthority; ?></li>
	<li><strong>Domain Authority:</strong> <?php //echo $domainAuthority; ?></li>
	<li><strong>External Links:</strong> <?php// echo $externalLinks; ?></li>
</ul>-->
<?php
	// $website_id_array = array(
    // '0' => 34,
    // '1' => 294,
    // '2' => 295,
    // '3' => 296,
    // '4' => 297,
    // '5' => 298,
    // '6' => 299,
    // '7' => 300,
    // '8' => 301,
    // '9' => 302,
    // '10' => 303,
    // '11' => 304,
    // '12' => 305,
    // '13' => 306,
    // '14' => 307,
    // '15' => 308,
    // '16' => 309,
    // '17' => 310,
    // '18' => 311,
    // '19' => 312,
    // '20' => 313,
    // '21' => 314,
    // '22' => 315,
    // '23' => 316,
    // '24' => 317,
    // '25' => 52,
    // '26' => 36,
    // '27' => 47,
    // '28' => 108,
    // '29' => 109,
    // '30' => 110,
    // '31' => 111,
    // '32' => 112,
    // '33' => 113,
    // '34' => 114,
    // '35' => 115,
    // '36' => 116,
    // '37' => 117,
    // '38' => 118,
    // '39' => 119,
    // '40' => 120,
    // '41' => 121,
    // '42' => 122,
    // '43' => 123,
    // '44' => 124,
    // '45' => 125,
    // '46' => 126,
    // '47' => 127,
    // '48' => 128,
    // '49' => 129,
    // '50' => 130,
    // '51' => 131,
    // '52' => 132,
    // '53' => 133,
    // '54' => 134,
    // '55' => 135,
    // '56' => 136,
    // '57' => 137,
    // '58' => 138,
    // '59' => 139,
    // '60' => 140,
    // '61' => 141,
    // '62' => 142,
    // '63' => 143,
    // '64' => 144,
    // '65' => 145,
    // '66' => 146,
    // '67' => 147,
    // '68' => 148,
    // '69' => 149,
    // '70' => 150,
    // '71' => 151,
    // '72' => 152,
    // '73' => 153,
    // '74' => 154,
    // '75' => 15 ,
    // '76' => 378,
    // '77' => 379,
    // '78' => 380,
    // '79' => 381,
    // '80' => 382,
    // '81' => 383,
    // '82' => 384,
    // '83' => 385,
    // '84' => 386,
    // '85' => 387,
    // '86' => 388,
    // '87' => 389,
    // '88' => 390,
    // '89' => 391,
    // '90' => 392,
    // '91' => 393,
    // '92' => 394,
    // '93' => 395,
    // '94' => 396,
    // '95' => 397,
    // '96' => 17,
    // '97' => 37,
    // '98' => 58,
    // '99' => 59,
    // '100' => 60,
    // '101' => 61,
    // '102' => 62,
    // '103' => 63,
    // '104' => 64,
    // '105' => 65,
    // '106' => 66,
    // '107' => 67,
    // '108' => 68,
    // '109' => 69,
    // '110' => 70,
    // '111' => 71,
    // '112' => 72,
    // '113' => 73,
    // '114' => 74,
    // '115' => 75,
    // '116' => 76,
    // '117' => 77,
    // '118' => 78,
    // '119' => 79,
    // '120' => 80,
    // '121' => 81,
    // '122' => 82,
    // '123' => 83,
    // '124' => 84,
    // '125' => 85,
    // '126' => 86,
    // '127' => 87,
    // '128' => 88,
    // '129' => 89,
    // '130' => 90,
    // '131' => 91,
    // '132' => 92,
    // '133' => 93,
    // '134' => 94,
    // '135' => 95,
    // '136' => 96,
    // '137' => 97,
    // '138' => 98,
    // '139' => 51,
    // '140' => 35,
    // '141' => 318,
    // '142' => 319,
    // '143' => 320,
    // '144' => 321,
    // '145' => 322,
    // '146' => 323,
    // '147' => 324,
    // '148' => 325,
    // '149' => 326,
    // '150' => 327,
    // '151' => 328,
    // '152' => 329,
    // '153' => 330,
    // '154' => 331,
    // '155' => 332,
    // '156' => 333,
    // '157' => 334,
    // '158' => 335,
    // '159' => 336,
    // '160' => 337,
    // '161' => 24,
    // '162' => 247,
    // '163' => 248,
    // '164' => 249,
    // '165' => 250,
    // '166' => 251,
    // '167' => 252,
    // '168' => 253,
    // '169' => 254,
    // '170' => 255,
    // '171' => 256,
    // '172' => 257,
    // '173' => 258,
    // '174' => 259,
    // '175' => 260,
    // '176' => 261,
    // '177' => 262,
    // '178' => 263,
    // '179' => 264,
    // '180' => 265,
    // '181' => 266,
    // '182' => 267,
    // '183' => 268,
    // '184' => 269,
    // '185' => 270,
    // '186' => 271,
    // '187' => 272,
    // '188' => 28,
    // '189' => 357,
    // '190' => 358,
    // '191' => 359,
    // '192' => 360,
    // '193' => 361,
    // '194' => 362,
    // '195' => 363,
    // '196' => 364,
    // '197' => 365,
    // '198' => 366,
    // '199' => 367,
    // '200' => 368,
    // '201' => 369,
    // '202' => 370,
    // '203' => 371,
    // '204' => 372,
    // '205' => 373,
    // '206' => 374,
    // '207' => 375,
    // '208' => 376,
    // '209' => 377,
    // '210' => 25,
    // '211' => 33,
    // '212' => 155,
    // '213' => 156,
    // '214' => 157,
    // '215' => 158,
    // '216' => 159,
    // '217' => 160,
    // '218' => 161,
    // '219' => 162,
    // '220' => 163,
    // '221' => 164,
    // '222' => 165,
    // '223' => 166,
    // '224' => 167,
    // '225' => 168,
    // '226' => 169,
    // '227' => 170,
    // '228' => 171,
    // '229' => 172,
    // '230' => 173,
    // '231' => 174,
    // '232' => 175,
    // '233' => 176,
    // '234' => 177,
    // '235' => 178,
    // '236' => 179,
    // '237' => 180,
    // '238' => 181,
    // '239' => 182,
    // '240' => 183,
    // '241' => 184,
    // '242' => 185,
    // '243' => 186,
    // '244' => 187,
    // '245' => 188,
    // '246' => 189,
    // '247' => 190,
    // '248' => 191,
    // '249' => 192,
    // '250' => 193,
    // '251' => 194,
    // '252' => 195,
    // '253' => 40 ,
    // '254' => 99 ,
    // '255' => 100,
    // '256' => 101,
    // '257' => 102,
    // '258' => 103,
    // '259' => 104,
    // '260' => 105,
    // '261' => 106,
    // '262' => 107,
    // '263' => 45,
    // '264' => 46,
    // '265' => 48,
    // '266' => 49,
    // '267' => 338,
    // '268' => 339,
    // '269' => 340,
    // '270' => 341,
    // '271' => 342,
    // '272' => 343,
    // '273' => 344,
    // '274' => 345,
    // '275' => 346,
    // '276' => 347,
    // '277' => 348,
    // '278' => 349,
    // '279' => 350,
    // '280' => 351,
    // '281' => 352,
    // '282' => 353,
    // '283' => 354,
    // '284' => 355,
    // '285' => 356,
    // '286' => 44,
    // '287' => 196,
    // '288' => 197,
    // '289' => 198,
    // '290' => 199,
    // '291' => 200,
    // '292' => 201,
    // '293' => 202,
    // '294' => 203,
    // '295' => 204,
    // '296' => 205,
    // '297' => 206,
    // '298' => 207,
    // '299' => 208,
    // '300' => 209,
    // '301' => 210,
    // '302' => 211,
    // '303' => 212,
    // '304' => 213,
    // '305' => 214,
    // '306' => 215,
    // '307' => 216,
    // '308' => 32,
    // '309' => 41,
    // '310' => 42,
    // '311' => 273,
    // '312' => 274,
    // '313' => 275,
    // '314' => 276,
    // '315' => 277,
    // '316' => 278,
    // '317' => 279,
    // '318' => 280,
    // '319' => 281,
    // '320' => 282,
    // '321' => 283,
    // '322' => 284,
    // '323' => 285,
    // '324' => 286,
    // '325' => 287,
    // '326' => 288,
    // '327' => 289,
    // '328' => 290,
    // '329' => 291,
    // '330' => 292,
    // '331' => 293,
    // '332' => 53,
    // '333' => 43,
    // '334' => 217,
    // '335' => 218,
    // '336' => 219,
    // '337' => 220,
    // '338' => 221,
    // '339' => 222,
    // '340' => 223,
    // '341' => 224,
    // '342' => 225,
    // '343' => 226,
    // '344' => 227,
    // '345' => 228,
    // '346' => 229,
    // '347' => 230,
    // '348' => 231,
    // '349' => 232,
    // '350' => 233,
    // '351' => 234,
    // '352' => 235,
    // '353' => 236,
    // '354' => 237,
    // '355' => 238,
    // '356' => 239,
    // '357' => 240,
    // '358' => 241,
    // '359' => 242,
    // '360' => 243,
    // '361' => 244,
    // '362' => 245,
    // '363' => 246,
    // '364' => 55
	// );

// $get_wp_th_details_array = array();
	
// foreach($website_id_array as $website_id){		
	// $websites = $wpdb->get_row("SELECT * FROM {$table_name_website}");		
	// $wordpress_split = explode('.',$websites->site_url);		
	// if($wordpress_split[1] == "wordpress"){			
	// $update = $wpdb->update( $table_name_website , array( 
	// 'site_platform'		=> 'Wordpress.com'
	// ),
	// array( 'ID' => $websites->ID ),
	// array( '%s', '%s' ));
	// }
	
	// if($websites->site_platform == 'Wordpress'){
		// $get_wp_th_details_array['website_id'] = $website_id;
	// }
		// $site_url = $websites->site_url;			
		// $root_url = parse_url($site_url, PHP_URL_HOST);			
		// if($root_url == 'www.callidus.se'){
			// $url = 'http://' . $root_url . '/readme.bd6efd116b1af0a29f041c8c080376fb.html';
			// $get_readme_content = @file_get_contents($url);				
			// if($get_readme_content != null){
				// libxml_use_internal_errors(true);
				// $dom = new DOMDocument();
				// $dom->loadHTML($get_readme_content);
				// $xpath = new DOMXPath($dom);
				// $div = $xpath->query('//h1[@id="logo"]');
				// $div = $div->item(0);
				// $link_content = $dom->saveXML($div);
				// $link_content_explode = explode('Version', $link_content);				
				// $link_content_explode = explode(' ', $link_content_explode[1]);
				// $wordpress_version = $link_content_explode[1];
				// $get_wp_th_details_array['wordpress_version'] = $wordpress_version;
			// }
			// }else{
			// $url = 'http://' . $root_url . '/readme.html';
			// $get_readme_content = @file_get_contents($url);
			// if($get_readme_content != null){
				// libxml_use_internal_errors(true);
				// $dom = new DOMDocument();
				// $dom->loadHTML($get_readme_content);
				// $xpath = new DOMXPath($dom);
				// $div = $xpath->query('//h1[@id="logo"]');
				// $div = $div->item(0);
				// $link_content = $dom->saveXML($div);
				// $link_content_explode = explode('Version', $link_content);				
				// $link_content_explode = explode(' ', $link_content_explode[1]);
				// $wordpress_version = $link_content_explode[1];
				// if($wordpress_version != null){
					// $get_wp_th_details_array['wordpress_version'] = $wordpress_version;
					// }else{
					// $url = 'http://' . $root_url . '/wp-login.php';	
					// $get_login_content = @file_get_contents($url);
					// if($get_login_content != null){
						// print_var($get_login_content);
						// libxml_use_internal_errors(true);
						// $dom = new DOMDocument();
						// $dom->loadHTML($wordpress_content);
						// $xpath = new DOMXPath($dom);
						// $div = $xpath->query('//link[@id="open-sans-css"]');
						// $div = $div->item(0);
						// $link_content = $dom->saveXML($div);
						// $link_content = new SimpleXMLElement($link_content);
						// $link_href_explode = explode("ver=", $link_content['href']);	
						// $link_version_explode = explode("-", $link_href_explode[1]);
						// $wordpress_version = $link_version_explode[0];
						// if($wordpress_version != null){
						// $get_wp_th_details_array['wordpress_version'] = $wordpress_version;			
						// }else{
						// $get_wp_th_details_array['wordpress_version'] = 'Secured';		
						// }
					// }
					// $wordpress_details = get_web_page($url);
					// $wordpress_content = $wordpress_details['content'];												
					// if($wordpress_content != null){
					// print_var("3--" . $wordpress_content);
					// libxml_use_internal_errors(true);
					// $dom = new DOMDocument();
					// $dom->loadHTML($wordpress_content);
					// $xpath = new DOMXPath($dom);
					// $div = $xpath->query('//link[@id="open-sans-css"]');
					// $div = $div->item(0);
					// $link_content = $dom->saveXML($div);
					// $link_content = new SimpleXMLElement($link_content);
					// $link_href_explode = explode("ver=", $link_content['href']);	
					// $link_version_explode = explode("-", $link_href_explode[1]);
					// $wordpress_version = $link_version_explode[0];
					// if($wordpress_version != null){
					// $get_wp_th_details_array['wordpress_version'] = $wordpress_version;			
					// }else{
					// $get_wp_th_details_array['wordpress_version'] = 'Secured';		
					// }
					// }
				// }								
			// }//else{
			// $url = 'http://' . $root_url . '/wp-login.php';	
			// $wordpress_details = get_web_page($url);
			// $wordpress_content = $wordpress_details['content'];					
			// if($wordpress_content != null){
			// print_var("4--" . $wordpress_content);
			// libxml_use_internal_errors(true);
			// $dom = new DOMDocument();
			// $dom->loadHTML($wordpress_content);
			// $xpath = new DOMXPath($dom);
			// $div = $xpath->query('//link[@id="open-sans-css"]');
			// $div = $div->item(0);
			// $link_content = $dom->saveXML($div);
			// $link_content = new SimpleXMLElement($link_content);
			// $link_href_explode = explode("ver=", $link_content['href']);	
			// $link_version_explode = explode("-", $link_href_explode[1]);
			// $wordpress_version = $link_version_explode[0];
			// if($wordpress_version != null){
			// $get_wp_th_details_array['wordpress_version'] = $wordpress_version;			
			// }else{
			// $get_wp_th_details_array['wordpress_version'] = 'Secured';		
			// }
			// }
			// }
		// }
		
		// require_once('check_version/whatpress.class.php');
		// require_once('check_version/config.php');
		
		// $theme       = new WhatPress;
		// $css         = $theme->theme_css($site_url);
		// $information = $theme->theme_information($css);
		
		// if ($css == false) {
			// $response = array('Error' => 'This website doesn\'t use WordPress or has been heavily modified or is secured.');
			// $theme_name = 'Modified';
			// $theme_version = 'Modified';
		// }
		// else if ($information == false) {
			// $response = array('Error' => 'WordPress detected, but no information can be determined. The theme is either customized or secured.');
			// $theme_name = 'Secured';
			// $theme_version = 'Secured';
		// }
// else {
	// $response = $information;
	// $theme_name = $response['Name'];
	// $theme_version = $response['Version'];
// }	
		
		// $get_wp_th_details_array['theme_name'] = $theme_name;	
		// $get_wp_th_details_array['theme_version'] = $theme_version;	
	// }
// }

// ACTIVE
global $wpdb;
$table_name_website = $wpdb->prefix . "custom_website";
$websites = $wpdb->get_results("SELECT * FROM {$table_name_website} WHERE site_platform = 'Wordpress'");
$get_wp_th_details_array = array();
// foreach($websites as $website){		
	// $website_id = $website->ID;
	// $site_url = $website->site_url;			
	// $root_url = parse_url($site_url, PHP_URL_HOST);
	// if($root_url == 'www.callidus.se'){
		// $url = 'http://' . $root_url . '/readme.bd6efd116b1af0a29f041c8c080376fb.html';
		// $wordpress_details = get_web_page($url);
		// $wordpress_content = $wordpress_details['content'];
		// if($wordpress_content != null){			
			// $tag_content = get_id_tag('h1','id', 'logo', $wordpress_content);
			// $wordpress_version = preg_replace("/[^0-9\.]/", '', trim(strip_tags($tag_content)));
			// if($wordpress_version != null){				
				// $get_wp_th_details_array[$website_id]['wordpress_version'] = $wordpress_version;			
			// }else{
				// $get_wp_th_details_array[$website_id]['wordpress_version'] = 'Secured';		
			// }
		// }
	// }else{
		// $url = 'http://' . $root_url . '/readme.html';
		// $wordpress_details = get_web_page($url);
		// $wordpress_content = $wordpress_details['content'];
		// if($wordpress_content != null){
			// $tag_content = get_id_tag('h1','id', 'logo', $wordpress_content);
			// $wordpress_version = preg_replace("/[^0-9\.]/", '', trim(strip_tags($tag_content)));
			// if($wordpress_version != null){				
				// $get_wp_th_details_array[$website_id]['wordpress_version'] = $wordpress_version;			
			// }else{
				// $url = 'http://' . $root_url . '/wp-login.php';
				// $wordpress_details = get_web_page($url);
				// $wordpress_content = $wordpress_details['content'];
				// if($wordpress_content != null){
					// $tag_content = get_id_tag('link','id', 'open-sans-css', $wordpress_content);
					// print_var($tag_content);
					
				// }
			// }
		// }
	// }
// }


foreach($websites as $website){		
	$website_id = $website->ID;
	$site_url = $website->site_url;			
	$root_url = parse_url($site_url, PHP_URL_HOST);
	if($root_url == 'www.callidus.se'){
		$url = 'http://' . $root_url . '/wp-login.php';	
		$wordpress_details = get_web_page($url);
		$wordpress_content = $wordpress_details['content'];
		print_Var($wordpress_content);
		if($wordpress_content != null){
			$tag_content = get_id_tag('link','id', 'open-sans-css', $wordpress_content);
			print_var($tag_content);
		}
	}
}


// print_var($get_wp_th_details_array);

?>
<?php get_footer(); ?>
