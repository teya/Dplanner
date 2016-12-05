<?php
/*
Plugin Name: WP Login Box
Plugin URI: http://itzoovim.com/plugins/wordpress-login-form/
Description: WP Login Box lets you add a wordpress login form to your website.
Version: 2.0.2
Author: Ziv, Itzoovim
Author URI: itzoovim.com
*/
$wplb_style = "light";
$data = get_option('wplb_options');

if ($data['style'] != "") {
	$wplb_style = $data['style'];
}

//include the main class file
require_once("admin-page-class/admin-page-class.php");

 $config = array(
    'menu'=> 'settings',                 //sub page to settings page
    'page_title' => 'WPLB Options',   //The name of this page
    'capability' => 'edit_themes',       // The capability needed to view the page
    'option_group' => 'wplb_options',    //the name of the option to create in the database
    'id' => 'admin_page',                // Page id, unique per page
    'fields' => array(),                 // list of fields (can be added by field arrays)
    'local_images' => false,             // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false            //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
); 
 
 /**
 * Initiate your admin page
 */
 
$options_panel = new BF_Admin_Page_Class($config);


/**
 * define your admin page tabs listing
 */
$options_panel->OpenTabs_container('');
$options_panel->TabsListing(array(
   'links' => array(
   'options_1' =>  __('Basic Options'),
   'options_2' =>  __('Text Options')
   )
));

$options_panel->Title('<h2 style="margin-left: 5px;">Login Box Options</h2>');
//title
$options_panel->Title('<p style="font-size: 14px;margin-left: 5px;">Thank you for downloading and installing this plugin. <br /> On this page you will be able to customize it to your liking. <br /> To include the login box in your site, paste the following function in any theme file you desire:<br /> <strong>&lt;?php
if&nbsp;
(function_exists (&#39;wplb_login&#39;))&nbsp;&nbsp;&nbsp;{
wplb_login();
}
?&gt;</strong><br />
You can also use the plugin as a shortcode or widget. Click <a href="http://wordpress.org/extend/plugins/wp-login-box/installation/" target="_blank">here</a> for more information on how to do so (it&#39;s not complicated).
<br />If this plugin helped you giving it a good rating would be great!</p>');


$options_panel->OpenTab('options_1');


//select field
$options_panel->addSelect('style',array('blue'=>'Blue','green'=>'Green','dark'=>'Dark','light'=>'Light'),array('name'=> 'Select a style', 'std'=> array('selectkey2')));
//radio field
$options_panel->addRadio('float',array('left'=>'Left            ','right'=>'Right'),array('name'=> 'Do you want the login box to float (align) to the left, or to the rigth?', 'std'=> array('radionkey2')));

$options_panel->addCheckbox('wplogin',array('name'=> '<strong>*****</strong> Disable WP-Login redirects? '));
$options_panel->addCheckbox('register',array('name'=> 'Enable the Register link? '));
$options_panel->addCheckbox('forgot',array('name'=> 'Enable the Forgot Your Password link? '));
$options_panel->addCheckbox('profile',array('name'=> ' Enable the Profile link? <strong>(Only appears when logged in)</strong>   '));
$options_panel->addCheckbox('logout',array('name'=> 'Enable the Logout link? <strong>(Only appears when logged in)</strong>     '));
$options_panel->addCheckbox('rme',array('name'=> 'Disable the remember me checkbox? <strong>(Only appears when logged out)</strong>     '));

$options_panel->addCheckbox('wplb_widget',array('name'=> 'Enable the login box widget?'));

$options_panel->addCheckbox('wplb_shortcode',array('name'=> 'Enable the login box shortcode? [wplb]'));

$options_panel->addParagraph("<h3>*** This option will make sure your users are not redirect to wp-login.php after a failed login attempty. This option will affect your entire theme. ****</h3>");
// Close first tab
$options_panel->CloseTab();


$options_panel->OpenTab('options_2');


//text field
$options_panel->addText('greeting',array('name'=> 'Greeting Text'));
$options_panel->addText('inred',array('name'=> 'Redirect after login to this url (full url): '));
$options_panel->addText('outred',array('name'=> 'Redirect after logout to this url (Must be from this site. Only the part after your site'."'s".' name. (For example, example.com/<strong>yourlink</strong>): '));
$options_panel->addText('reglink',array('name'=> 'Custom Registration Form link (leave empty if you do not have one, enter a full URL): '));
$options_panel->addText('uremembermetext',array('name'=> 'Custom remember me checkbox text (leave empty if you do not have one): '));
$options_panel->addText('ulogintext',array('name'=> 'Custom login button text (leave empty if you do not have one): '));
$options_panel->addText('uregistertext',array('name'=> 'Custom register link text (leave empty if you do not have one): '));
$options_panel->addText('uforgottext',array('name'=> 'Custom forgot your password link text (leave empty if you do not have one, enter a full URL): '));
$options_panel->addText('uprofilelink',array('name'=> 'Custom your profile link (leave empty if you do not have one, enter a full URL): '));
$options_panel->addText('uprofiletext',array('name'=> 'Custom your profile link text (leave empty if you do not have one): '));
$options_panel->addText('passlink',array('name'=> 'Custom forgot your password link (leave empty if you do not have one, enter a full URL): '));
$options_panel->addText('ulogouttext',array('name'=> 'Custom logout link text (leave empty if you do not have one): '));

// Close first tab
$options_panel->CloseTab();


function wplb_login() {
    if(is_user_logged_in()) {
	    include "in.php";		
	} else {
        include "out.php";
	}
}

function wplb_shortcode() {
	ob_start();
	echo '<div style="overflow: hidden;width: 100%;">';
    if(is_user_logged_in()) {
	    include "in.php";		
	} else {
        include "out.php";
	}
	echo '</div>';
	return ob_get_clean();
}

if ($data['wplb_shortcode'] == "1") {
   add_shortcode('wplb', 'wplb_shortcode'); 
}

function my_front_end_login_fail() {
    // Get the reffering page, where did the post submission come from?
    $referrer = $_SERVER['HTTP_REFERER'];
 
    // if there's a valid referrer, and it's not the default log-in screen
    if(!empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin')){
        // let's append a query string to the URL for the plugin to use
        wp_redirect($referrer . '?failed_login&failed_login'); 
    exit;
    }
}

if ($data['wplogin'] == "1") {
    // hook failed login
    add_action('wp_login_failed', 'my_front_end_login_fail'); 
}

// Add settings link on plugin page
function your_plugin_settings_link($links) { 
    $settings_link = '<a href="options-general.php?page=options-general.php_wplb_options">Settings</a>'; 
    array_unshift($links, $settings_link); 
    return $links; 
}


class Wplb_Widget extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
	 		'wplb_widget', // Base ID
			'Login Box', // Name
			array( 'description' => __( 'This widget lets you use the login box plugin as a widget', 'text_domain' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
		echo '<div style="overflow: hidden; margin: 0 auto; width: 99%;">';
		if(is_user_logged_in()) {
	        include "widget/in.php";		
	    } else {
            include "widget/out.php";
	    }
		echo '</div>';
		echo $after_widget;
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Login Box', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        
        
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}

if ($data['wplb_widget'] == "1") {
    function reg_wplb_no_anon() {
        register_widget( 'Wplb_Widget' );
    }
    add_action('widgets_init','reg_wplb_no_anon');
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'your_plugin_settings_link' );
wp_register_style( 'wplbstyle', plugins_url("styles/".$wplb_style.".css", __FILE__) );

if (!is_admin()) {
    wp_enqueue_style( 'wplbstyle' );
}
?>