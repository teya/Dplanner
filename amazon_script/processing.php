<?php
include("simple_html_dom.php");
include("amazon_api_class.php");
error_reporting(0);
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
$csv = array_map('str_getcsv', file($target_file));
$myfile = fopen("Details.csv", "w");
$file = fopen("$target_file", "r");
fwrite($myfile, fgets($file));
fclose($file);

function print_var($variable){
	echo "<pre>";
	print_r($variable);
	echo "</pre>";
}

// $obj = new AmazonProductAPI();
// $result = $obj->searchProducts(849179000561,AmazonProductAPI::DVD,"UPC");
// print_var($result);

$upc_column = $_POST['upc_column'] - 1;
$columns = $csv[1];
$column_count = 0;
foreach($columns as $column){
	if($column != null){
		$column_count += 1;
	}
}

$counter = 0;
foreach ($csv as $key) {
	
	
	if ($counter == 0) {
		$counter = 1;
		continue;
	}
	
	fwrite($myfile, "\n");
	for ($x = 0; $x <= $column_count; $x++) {
		if($x != $column_count){
			fwrite($myfile, $key[$x] . ",");
			}else{
			fwrite($myfile, $key[$x]);
		}		
	}
	
	$upc = $key[$upc_column];	
	$obj = new AmazonProductAPI();
	try{
		$result = $obj->searchProducts($upc,AmazonProductAPI::DVD,"UPC");
	}catch(Exception $e){
		$e->getMessage();
	}
	
	$reviews_url = $result->Items->Item->ItemLinks->ItemLink[5]->URL;
	$get_reviews = file_get_contents($reviews_url);
	preg_match_all("/\<span class\=\"a-size-medium a-text-beside-button totalReviewCount\"\>(.*?)\<\/span\>/", $get_reviews, $review_array);
	
	$review_average = preg_match_all("/\<span class\=\"arp-rating-out-of-text\"\>(.*?)\<\/span\>/", $get_reviews, $review_average_array);
	
	$seller_url = $result->Items->Item->DetailPageURL;	
	$get_seller = file_get_contents($seller_url);	
	$full_seller_div_first = explode( '<div id="merchant-info" class="a-section a-spacing-mini">' , $get_seller );
	$full_seller_div_second = explode("</div>" , $full_seller_div_first[1] );	
	preg_match_all('/<a .*?>(.*?)<\/a>/',$full_seller_div_second[0],$seller_array);
	
	$price = $result->Items->Item->OfferSummary->LowestNewPrice->FormattedPrice;
	$dimensions = $result->Items->Item->ItemAttributes->Feature[2];
	$asin = $result->Items->Item->ASIN;
	$buybox = $result->Items->Item->OfferSummary->TotalNew;
	$seller = $seller_array[1][0];	
	$bsr = $result->Items->Item->SalesRank;
	$reviews = $review_array[1][0];	
	$review_average = $review_average_array[1][0];	
	
	fwrite($myfile, $price . ",");
	fwrite($myfile, $dimensions . ",");
	fwrite($myfile, $asin . ",");
	fwrite($myfile, $buybox . ",");
	fwrite($myfile, $seller . ",");
	fwrite($myfile, $bsr . ",");
	fwrite($myfile, $reviews . ",");
	fwrite($myfile, $review_average . ",");
	
	$counter++;
}

fclose($myfile);
$file = 'Details.csv';
if (file_exists($file)) {
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.basename($file).'"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	readfile($file);
	exit;
}
?>