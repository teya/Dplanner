<?php
/* ==================================== WEBSITE SORT ==================================== */
function website_sort($website_sort_details){
	$array_count = count($website_sort_details) - 1;
	$sort_type = $website_sort_details[$array_count]['sort_type'];
	$tab_name = $website_sort_details[$array_count]['tab_name'];
	$sort_name = $website_sort_details[$array_count]['sort_name'];
	// print_Var($website_sort_details);
	if($sort_type == 'asc'){
		sort($website_sort_details);
	}elseif($sort_type == 'desc'){
		rsort($website_sort_details);
	}
	$website_sort_details['sort_type'] = $sort_type;
	$website_sort_details['tab_name'] = $tab_name;
	$website_sort_details['sort_name'] = $sort_name;
	return $website_sort_details;
}
/* ==================================== END WEBSITE SORT ==================================== */

/* ==================================== SITE TYPE FILTER ==================================== */
function site_type_filter($site_type){
	global $wpdb;
	
	$table_name_client = $wpdb->prefix . "custom_client";
	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client} ORDER BY client_name ASC");
	$table_name_website = $wpdb->prefix . "custom_website";	
	$table_name_website_moz = $wpdb->prefix . "custom_website_moz";
	if($site_type == '-- Site Type --'){
		$websites = $wpdb->get_results("SELECT * FROM {$table_name_website}");
	}else{
		$websites = $wpdb->get_results("SELECT * FROM {$table_name_website} WHERE site_type = '$site_type'");
	}
	$site_type_filter_array = array();
	foreach($clients as $client){		
		foreach($websites as $website){
			if($website->site_client == $client->client_name){
				$website_id 		= $website->ID;
				$client_id 			= $client->ID;
				$site_url 			= ($website->site_url != "" ? $website->site_url : "--");
				$site_client 		= ($website->site_client != "" ? $website->site_client : "--");
				$site_type 			= ($website->site_type != "" ? $website->site_type : "--");
				$site_platform 		= ($website->site_platform != "" ? $website->site_platform : "--");
				$site_wp_version 	= ($website->site_wp_version != "" ? $website->site_wp_version : "--");
				$site_theme_name 	= ($website->site_theme_name != "" ? $website->site_theme_name : "--");
				$site_theme_version = ($website->site_theme_version != "" ? $website->site_theme_version : "--");
				$site_hosting_name 	= ($website->site_hosting_name != "" ? $website->site_hosting_name : "--");
				$site_domain_name 	= ($website->site_domain_name != "" ? $website->site_domain_name : "--");			
				$site_login_url 	= ($website->site_login_url != "" ? $website->site_login_url : "#");
				
				$site_type_filter_array['website_tab_array'][] = $website_id ."_".
					$site_url ."_".
					$site_client ."_".
					$site_type ."_".
					$site_platform ."_".
					$site_wp_version ."_".
					$site_theme_name ."_".
					$site_theme_version ."_".
					$site_hosting_name ."_".
					$site_domain_name ."_".
					$site_login_url
				;
				
				$website_moz 			= $wpdb->get_row("SELECT * FROM {$table_name_website_moz} WHERE moz_website_id='$website_id'");
				$moz_datetime 			= ($website_moz->moz_datetime != "" ? $website_moz->moz_datetime : "--");
				$moz_page_authority 	= ($website_moz->moz_page_authority != "" ? $website_moz->moz_page_authority : "--");
				$moz_domain_authority	= ($website_moz->moz_domain_authority != "" ? $website_moz->moz_domain_authority : "--");
				$moz_rank				= ($website_moz->moz_rank != "" ? $website_moz->moz_rank : "--");
				$moz_external_links		= ($website_moz->moz_external_links != "" ? $website_moz->moz_external_links : "--");
				$moz_trust				= ($website_moz->moz_trust != "" ? $website_moz->moz_trust : "--");
				
				$site_type_filter_array['seo_stats_tab_array'][] = $website_id ."_".
				$client_id ."_".
				$site_client ."_".
				$site_url ."_".
				$site_type ."_".
				$site_platform ."_".
				$moz_page_authority ."_".
				$moz_domain_authority ."_".
				$moz_rank ."_".
				$moz_trust ."_".
				$moz_external_links ."_".
				$site_login_url
				;
			}
		}
	}
	return $site_type_filter_array;
}
/* ==================================== END SITE TYPE FILTER ==================================== */

/* ==================================== BULK WORDPRESS AND THEME VERSION ==================================== */
function get_wp_th_details($website_id){	
	$get_wp_th_details_array = array();
	
	$get_wp_th_details_array['website_id'] = $website_id;
	
	global $wpdb;
	$table_name_website = $wpdb->prefix . "custom_website";	
	$websites = $wpdb->get_row("SELECT * FROM {$table_name_website} WHERE ID = $website_id");
	
	$site_url = $websites->site_url;
	
	$root_url = parse_url($site_url, PHP_URL_HOST);
	
	if($root_url == 'www.callidus.se'){
		$url = 'http://' . $root_url . '/readme.bd6efd116b1af0a29f041c8c080376fb.html';
		$get_readme_content = file_get_contents($url);				
		libxml_use_internal_errors(true);
		$dom = new DOMDocument();
		$dom->loadHTML($get_readme_content);
		$xpath = new DOMXPath($dom);
		$div = $xpath->query('//h1[@id="logo"]');
		$div = $div->item(0);
		$link_content = $dom->saveXML($div);
		$link_content_explode = explode('Version', $link_content);				
		$link_content_explode = explode(' ', $link_content_explode[1]);
		$wordpress_version = $link_content_explode[1];
		$get_wp_th_details_array['wordpress_version'] = $wordpress_version;
	}else{
		$url = 'http://' . $root_url . '/readme.html';
		$get_readme_content = @file_get_contents($url);
		if($get_readme_content != null){
			libxml_use_internal_errors(true);
			$dom = new DOMDocument();
			$dom->loadHTML($get_readme_content);
			$xpath = new DOMXPath($dom);
			$div = $xpath->query('//h1[@id="logo"]');
			$div = $div->item(0);
			$link_content = $dom->saveXML($div);
			$link_content_explode = explode('Version', $link_content);				
			$link_content_explode = explode(' ', $link_content_explode[1]);
			$wordpress_version = $link_content_explode[1];
			if($wordpress_version != null){
				$get_wp_th_details_array['wordpress_version'] = $wordpress_version;
			}else{
				$url = 'http://' . $root_url . '/wp-login.php';	
				$wordpress_details = get_web_page($url);
				$wordpress_content = $wordpress_details['content'];
				if($wordpress_content != null){
					libxml_use_internal_errors(true);
					$dom = new DOMDocument();
					$dom->loadHTML($wordpress_content);
					$xpath = new DOMXPath($dom);
					$div = $xpath->query('//link[@id="open-sans-css"]');
					$div = $div->item(0);
					$link_content = $dom->saveXML($div);
					$link_content = new SimpleXMLElement($link_content);
					$link_href_explode = explode("ver=", $link_content['href']);	
					$link_version_explode = explode("-", $link_href_explode[1]);
					$wordpress_version = $link_version_explode[0];
					if($wordpress_version != null){
						$get_wp_th_details_array['wordpress_version'] = $wordpress_version;			
						}else{
						$get_wp_th_details_array['wordpress_version'] = 'Secured';		
					}
				}
			}								
		}else{
			$url = 'http://' . $root_url . '/wp-login.php';	
			$wordpress_details = get_web_page($url);
			$wordpress_content = $wordpress_details['content'];
			if($wordpress_content != null){
				libxml_use_internal_errors(true);
				$dom = new DOMDocument();
				$dom->loadHTML($wordpress_content);
				$xpath = new DOMXPath($dom);
				$div = $xpath->query('//link[@id="open-sans-css"]');
				$div = $div->item(0);
				$link_content = $dom->saveXML($div);
				$link_content = new SimpleXMLElement($link_content);
				$link_href_explode = explode("ver=", $link_content['href']);	
				$link_version_explode = explode("-", $link_href_explode[1]);
				$wordpress_version = $link_version_explode[0];
				if($wordpress_version != null){
					$get_wp_th_details_array['wordpress_version'] = $wordpress_version;			
				}else{
					$get_wp_th_details_array['wordpress_version'] = 'Secured';		
				}
			}
		}
	}
	
	require_once('check_version/whatpress.class.php');
	require_once('check_version/config.php');
	
	$theme       = new WhatPress;
	$css         = $theme->theme_css($site_url);
	$information = $theme->theme_information($css);
	
	if ($css == false) {
		$response = array('Error' => 'This website doesn\'t use WordPress or has been heavily modified or is secured.');
		$theme_name = 'Modified';
		$theme_version = 'Modified';
	}
	else if ($information == false) {
		$response = array('Error' => 'WordPress detected, but no information can be determined. The theme is either customized or secured.');
		$theme_name = 'Secured';
		$theme_version = 'Secured';
	}
	else {
		$response = $information;
		$theme_name = $response['Name'];
		$theme_version = $response['Version'];
	}	
	
	$get_wp_th_details_array['theme_name'] = $theme_name;	
	$get_wp_th_details_array['theme_version'] = $theme_version;	
	return $get_wp_th_details_array;
}

function bulk_get_wp_th($website_id_array){
	$get_wp_th_details_array = array();
	global $wpdb;
	$table_name_website = $wpdb->prefix . "custom_website";	
	foreach($website_id_array as $website_id){		
		$websites = $wpdb->get_row("SELECT * FROM {$table_name_website} WHERE ID = $website_id");		
		// $wordpress_split = explode('.',$websites->site_url);		
		// if($wordpress_split[1] == "wordpress"){			
		// $update = $wpdb->update( $table_name_website , array( 
		// 'site_platform'		=> 'Wordpress.com'
		// ),
		// array( 'ID' => $websites->ID ),
		// array( '%s', '%s' ));
		// }
		
		if($websites->site_platform == 'Wordpress'){
			$get_wp_th_details_array['website_id'] = $website_id;
			$site_url = $websites->site_url;			
			$root_url = parse_url($site_url, PHP_URL_HOST);			
			if($root_url == 'www.callidus.se'){
				$url = 'http://' . $root_url . '/readme.bd6efd116b1af0a29f041c8c080376fb.html';
				$get_readme_content = @file_get_contents($url);				
				if($get_readme_content != null){
					libxml_use_internal_errors(true);
					$dom = new DOMDocument();
					$dom->loadHTML($get_readme_content);
					$xpath = new DOMXPath($dom);
					$div = $xpath->query('//h1[@id="logo"]');
					$div = $div->item(0);
					$link_content = $dom->saveXML($div);
					$link_content_explode = explode('Version', $link_content);				
					$link_content_explode = explode(' ', $link_content_explode[1]);
					$wordpress_version = $link_content_explode[1];
					$get_wp_th_details_array['wordpress_version'] = $wordpress_version;
				}
				}else{
				$url = 'http://' . $root_url . '/readme.html';
				$get_readme_content = @file_get_contents($url);
				if($get_readme_content != null){
					libxml_use_internal_errors(true);
					$dom = new DOMDocument();
					$dom->loadHTML($get_readme_content);
					$xpath = new DOMXPath($dom);
					$div = $xpath->query('//h1[@id="logo"]');
					$div = $div->item(0);
					$link_content = $dom->saveXML($div);
					$link_content_explode = explode('Version', $link_content);				
					$link_content_explode = explode(' ', $link_content_explode[1]);
					$wordpress_version = $link_content_explode[1];
					if($wordpress_version != null){
						$get_wp_th_details_array['wordpress_version'] = $wordpress_version;
						}else{
						$url = 'http://' . $root_url . '/wp-login.php';	
						$get_login_content = @file_get_contents($url);
						if($get_login_content != null){
							print_var($get_login_content);
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
						}
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
					}								
				}//else{
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
			}
			
			require_once('check_version/whatpress.class.php');
			require_once('check_version/config.php');
			
			$theme       = new WhatPress;
			$css         = $theme->theme_css($site_url);
			$information = $theme->theme_information($css);
			
			if ($css == false) {
				$response = array('Error' => 'This website doesn\'t use WordPress or has been heavily modified or is secured.');
				$theme_name = 'Modified';
				$theme_version = 'Modified';
			}
			else if ($information == false) {
				$response = array('Error' => 'WordPress detected, but no information can be determined. The theme is either customized or secured.');
				$theme_name = 'Secured';
				$theme_version = 'Secured';
			}
			else {
				$response = $information;
				$theme_name = $response['Name'];
				$theme_version = $response['Version'];
			}	
			
			$get_wp_th_details_array['theme_name'] = $theme_name;	
			$get_wp_th_details_array['theme_version'] = $theme_version;	
		}
	}
	return $get_wp_th_details_array;	
}

function get_web_page( $url ){
	$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
	$options = array(
		CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
		CURLOPT_POST           =>false,        //set to GET
		CURLOPT_USERAGENT      => $user_agent, //set user agent
		CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
		CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
		CURLOPT_RETURNTRANSFER => true,     // return web page
		CURLOPT_HEADER         => false,    // don't return headers
		CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		CURLOPT_ENCODING       => "",       // handle all encodings
		CURLOPT_AUTOREFERER    => true,     // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
		CURLOPT_TIMEOUT        => 120,      // timeout on response
		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	);	
	
	$ch      = curl_init( $url );
	curl_setopt_array( $ch, $options );
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );
	
	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	
	return $header;
}
/* ==================================== END WORDPRESS AND THEME VERSION ==================================== */

/* ==================================== WEBSITE MOZ ==================================== */
function get_moz_metrix($website_client_id){
	$website_client_id_explode = explode('join', $website_client_id);
	$website_id = $website_client_id_explode[0];
	$client_id = $website_client_id_explode[1];
	
	global $wpdb;
	$table_name_website = $wpdb->prefix . "custom_website";
	$table_name_website_moz = $wpdb->prefix . "custom_website_moz";
	$websites = $wpdb->get_row("SELECT * FROM {$table_name_website} WHERE ID = $website_id");
	
	$site_url = $websites->site_url;
	$moz_id = "mozscape-7552c70f84";
	$moz_key = "50fdd246150803253e037cd3b835669";
		
	$expires = time() + 500;		
	$sign_string = $moz_id."\n".$expires;	
	$binary_signature = hash_hmac('sha1', $sign_string, $moz_key, true);	
	$url_safe_signature = urlencode(base64_encode($binary_signature));	
	$cols = "103616137252"; // http://www.stateofdigital.com/getting-started-moz-api-tutorial/
	// $cols = "103080394752"; // added value
	// $cols = "103079215140"; // techsupport
	$request_url = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($site_url)."?Cols=".$cols."&AccessID=".$moz_id."&Expires=".$expires."&Signature=".$url_safe_signature;	
	$options = array(
		CURLOPT_RETURNTRANSFER => true
	);
	
	$ch = curl_init($request_url);
	curl_setopt_array($ch, $options);
	$content = curl_exec($ch);
	curl_close($ch);	
	$json = json_decode($content);
	
	$moz_datetime = date("Y-m-d H:i:s");
	$moz_page_authority = round($json->upa,0);
	$moz_domain_authority = round($json->pda,0);
	$moz_rank = round($json->umrp,0);
	$moz_external_links = ($json->ueid != null ? $json->ueid : "--");
	$the_url = $json->uu;
		
	$moz_array = array();
	$moz_array['website_id'] = $website_id;
	$moz_array['client_id'] = $client_id;
	$moz_array['moz_page_authority'] = $moz_page_authority;
	$moz_array['moz_domain_authority'] = $moz_domain_authority;
	$moz_array['moz_rank'] = $moz_rank;
	$moz_array['moz_external_links'] = $moz_external_links;
	
	$insert = $wpdb->insert( $table_name_website_moz , array( 
		'moz_datetime'			=> $moz_datetime,
		'moz_website_id'		=> $website_id,
		'moz_client_id'			=> $client_id,
		'moz_page_authority'	=> $moz_page_authority,
		'moz_domain_authority'	=> $moz_domain_authority,
		'moz_rank'				=> $moz_rank,
		'moz_external_links'	=> $moz_external_links,
		'moz_trust'				=> ""
	), array( '%s', '%s' ));
	
	return $moz_array;		
}
/* ==================================== END WEBSITE MOZ ==================================== */

/* ==================================== BULK WEBSITE MOZ ==================================== */
function bulk_get_moz_metrix($website_client_id_array){
	global $wpdb;
	$table_name_website = $wpdb->prefix . "custom_website";
	$table_name_website_moz = $wpdb->prefix . "custom_website_moz";
	
	$site_url_array = array();
	$site_url_id_array = array();
	foreach($website_client_id_array as $website_client_id){
		$website_client_id_explode = explode('join', $website_client_id);
		$website_id = $website_client_id_explode[0];
		$client_id = $website_client_id_explode[1];	
		
		$websites = $wpdb->get_row("SELECT * FROM {$table_name_website} WHERE ID = $website_id");
		
		$site_url = $websites->site_url;
		$site_url_id_array[] = $website_id ."_". $client_id ."_". $site_url;
		$site_url_array[] = $site_url;	
	}
	$array_count = count($site_url_array);
	$chunks = array_chunk($site_url_array,$array_count);
	foreach($chunks as $chunk){
		$moz_id = "mozscape-7552c70f84";
		$moz_key = "50fdd246150803253e037cd3b835669";
		
		$expires = time() + 500;		
		$sign_string = $moz_id."\n".$expires;	
		$binary_signature = hash_hmac('sha1', $sign_string, $moz_key, true);	
		$url_safe_signature = urlencode(base64_encode($binary_signature));	
		$cols = "103616137252"; // http://www.stateofdigital.com/getting-started-moz-api-tutorial/
		// $cols = "103080394752"; // added value
		// $cols = "103079215140"; // techsupport
		// $request_url = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($site_url)."?Cols=".$cols."&AccessID=".$moz_id."&Expires=".$expires."&Signature=".$url_safe_signature;	
		
		$request_url = "http://lsapi.seomoz.com/linkscape/url-metrics/?Cols=".$cols."&AccessID=".$moz_id."&Expires=".$expires."&Signature=".$url_safe_signature;
		$options = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS     => json_encode($chunk)
		);
		
		$ch = curl_init($request_url);
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		curl_close($ch);	
		$json = json_decode($content);	
				
		$moz_array = array();
		foreach($json as $key => $moz_bulk_details){
			$site_url_id_array_explode = explode("_", $site_url_id_array[$key]);
			$website_id = $site_url_id_array_explode[0];
			$client_id = $site_url_id_array_explode[1];
			$moz_datetime = date("Y-m-d H:i:s");
			$moz_page_authority = round($moz_bulk_details->upa,0);
			$moz_domain_authority = round($moz_bulk_details->pda,0);
			$moz_rank = round($moz_bulk_details->umrp,0);
			$moz_external_links = ($moz_bulk_details->ueid != null ? $moz_bulk_details->ueid : "--");
			$moz_trust = "--";
			$the_url = $moz_bulk_details->uu;
			$moz_array['moz_bulk_details'][] = $moz_datetime ."_". $website_id ."_". $client_id ."_". $moz_page_authority ."_". $moz_domain_authority ."_". $moz_rank ."_". $moz_external_links ."_". $moz_trust;
			
			$insert = $wpdb->insert( $table_name_website_moz , array( 
				'moz_datetime'			=> $moz_datetime,
				'moz_website_id'		=> $website_id,
				'moz_client_id'			=> $client_id,
				'moz_page_authority'	=> $moz_page_authority,
				'moz_domain_authority'	=> $moz_domain_authority,
				'moz_rank'				=> $moz_rank,
				'moz_external_links'	=> $moz_external_links,
				'moz_trust'				=> ""
			), array( '%s', '%s' ));
		}
	}
	return $moz_array;
}


/* ==================================== END BULK WEBSITE MOZ ==================================== */
?>