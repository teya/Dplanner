<?php
if (!function_exists('curPageURL')) {
function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {
	    $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
}

$data = get_option('wplb_options');
$home = site_url();
$redirect = $home."/index.php";
if ($data['inred'] != "") {
    $redirect = $data['inred'];
}

$rme = "0";
if ($data['rme'] != "") {
	$rme = $data['rme'];
}

$reglink = $home.'/wp-signup.php';
if ($data['reglink'] != "") {
	$reglink = $data['reglink'];
}

$passlink = $home.'/wp-login.php?action=lostpassword';
if ($data['passlink'] != "") {
	$passlink = $data['passlink'];
}

$remembermetext = "Remember<br /> me?";
if ($data['uremembermetext'] != "") {
    $remembermetext = $data['uremembermetext'];
}

$logintext = "Log In";
if ($data['ulogintext'] != "") {
    $logintext = $data['ulogintext'];
}

$registertext = "Register";
if ($data['uregistertext'] != "") {
    $registertext = $data['uregistertext'];
}

$forgottext = "Forgot Your Password?";
if ($data['uforgottext'] != "") {
    $forgottext = $data['uforgottext'];
}

$extra = "";
if (isset($_GET['failed_login'])) {
	$extra = "style = \"color: red;\"";
}

$blog_url = site_url();
?>
<div id='wplb_wrap' style='float: <?php echo $data['float']; ?>;'>
<div id='wplb_main'>
<form name='loginform' id='loginform' action='<?php echo $home; ?>/wp-login.php' method='post'>
		<p class="unpw">Username</p>
		<input type='text' class='wplb_field' name='log' id='user_login' <?php echo $extra; ?> value='' onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" /> 
		<p class="unpw">Password</p>
		<input type='password' class='wplb_field' <?php echo $extra; ?> name='pwd' id='user_pass' value='' onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
        <?php if($rme != "1") {?>
	<input name='rememberme' class='wplb_check' type='checkbox' id='rememberme' value='forever' /> 
        <span class='wplb_text'><?php echo $remembermetext; ?></span>
    <?php } ?>
		<input type='submit' name='wp-submit' class='wplb_button' id='wp-submit'  value='<?php echo $logintext; ?>'  />
        <input type="hidden" name="curl" value="<?php echo curPageURL(); ?>" />
		<input type='hidden' name='redirect_to' value='<?php echo $redirect; ?>' />
		<input type='hidden' name='testcookie' value='1' />
</form>
</div>
<?php 
if ($data['register'] == "1") {
	echo "<a class='wplb_link' href='".$reglink."'>".$registertext."</a>\n";
}

if ($data['forgot'] == "1") {
	echo "<a class='wplb_link' href='".$passlink."'>".$forgottext."</a>\n";
}
?>
</div>