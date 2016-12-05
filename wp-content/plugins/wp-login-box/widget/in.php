<?php
//get the data to an array
$data = get_option('wplb_options');
//access each field by its id
?>

<div id="wplb_wrap" style="float: <?php echo $data['float']; ?>">
<a  style='margin-top: 5px;' class='wplb_link'><?php echo $data['greeting']; ?>
<?php 
global $current_user;
get_currentuserinfo();
echo $current_user->user_login;
?>
</a>
<?php
$home = site_url();
$profilelink = $home."/wp-admin/profile.php";
$profiletext = "Your Profile";
$outred = 'index.php';
$logouttext = "Logout?";

if ($data['outred'] != "") {
    $outred = $data['outred'];
}
$redto = wp_logout_url($outred);

if ($data['uprofilelink'] != "") {
	$profilelink = $data['uprofilelink'];
}

if ($data['uprofiletext'] != "") {
	$profiletext = $data['uprofiletext'];
}

if ($data['ulogouttext'] != "") {
	$logouttext = $data['ulogouttext'];
}

if ($data['profile'] == "1") {
    echo "<a style='margin-top: 5px;' class='wplb_link' href='".$profilelink."'>".$profiletext."</a>\n";
}

if ($data['logout'] == "1") {
	echo "<a style='margin-top: 5px;' class='wplb_link' href='".$redto."'>".$logouttext."</a>\n";
}
?>
</div>