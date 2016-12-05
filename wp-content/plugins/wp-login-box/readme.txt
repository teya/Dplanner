=== WP Login Box ===
Contributors:       Ziv , itzoovim
Plugin Name:       WP Login Box
Plugin URI:        http://itzoovim.com/plugins/customize-and-add-a-wordpress-login-form-to-your-site/
Tags:              login, log in, wordpress, box, custom, shortcode, wordpress login form, wp login form, wordpress login box, wp login box
Author URI:        http://itzoovim.com/
Donate link:       http://itzoovim.com/donate/
Requires at least: 3.0 
Tested up to:      3.5.2
Stable tag:        2.0.2
Version:           2.0.2
License: GPLv3 or later

Easily add a forum like log in/out form to your site.

== Description ==

<p>WordPress Login Box (WPLB) lets you add a log in/out box to your website.</p>

<p>WPLB includes an options panel which gives you control over your form.</p>

<strong>Features</strong>:
<ul>
	<li>Different styles</li>
	<li>Highly customizable</li>
	<li>Lightweight</li>
	<li>Can be integreated with any theme</li>
	<li>Works well with other plugins</li>
	<li>Hackable</li>
</ul>


<p>This plugin lets you choose custom links for a forgot your password page,and registration page.
It also lets you choose a url that you users will be redirected to after they log-in/out.
You can also enable the option to not redirect your users to WP-Login after failed login attempts!
This plugins works well with other member plugins, and can help you create an overall better user experience.</p>

<p>You can view a sample <a href="http://itzoovim.com/plugins/customize-and-add-a-wordpress-login-form-to-your-site/#sample_wordpres_login_form">wordpress login form</a> by visiting this link.</p>

== Installation ==

The automatic plugin installer should work for most people. Manual installation is easy and takes fewer than five minutes.

1. Download the plugin, unpack it and upload the '<em>wp-login-box</em>' folder to your wp-content/plugins directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings -> WPLB Options to configure the basic options.
4. Make sure you select your login box's theme and setup all of the options (should take 1 minute).

<strong>If you would like to use the plugin in a shortcode/widget, read this next step:</strong>
Make sure you enabled the login box widget/shortcode options from the plugin's options panel (can be found under the basic options tab). 
To use the plugin as a shortcode, paste <strong>[wplb]</strong> somewhere in your post editor. To use the plugin as a widget, navigate to your widget editor (Under Appearance-> Widgets). The plugin's widget is called "Login Box". Drag the login box widget to one of your widget areas. Enter a widget title then click save. You're done! Enjoy!


<strong>If you would like to use the plugin in a theme file, read this next step:</strong>
Paste the following code in the location you want the box to appear in (most of the times this is header.php). Then refresh the page and you're done! Enjoy!
`
<?php
	if(function_exists('wplb_login')) {
	    wplb_login();
	}
?>
`

<strong>Note</strong>
After you download this plugin, and finish setting it up you will have to paste the plugin's function somewhere in your theme. This can be hard if you don't have any coding knowledge. If you need help with that final step, please post a question in the plugin's forum so that I can help you. I am not going to create a plugin, just so that it could sit there with no support. So please, if you ever need any help with this plugin, create a thread in the forums.


== Changelog ==

= 2.0.2 =
* Fixed a bug in the widget.
* Fixed the custom forgot your password link.
* Fixed a urls bug.
* Added donations link.

= 2.0.1 =
* Fixed a bug in the shortcode.

= 2.0.0 =
* The options panel got a new look.
* Added the option to use the plugin as a widget.
* Added the option to use the plugin as a shortcode.
* Update is a must!!

= 1.07 =
* Added the option to remove the remember me option from the login field.

= 1.06 = 
* Major code cleanup!
* The option to controll every peice of text and every link that this plugin displays.
* Update is a must!!

= 1.05 = 
* Major updates!! CSS fixes and more options added. Must update!

= 1.04 = 
* Fixed a one-line minor css bug.

= 1.03 = 
* Changed the encoding of the plugin.php file and fixed a few stylesheet errors. Important update.

= 1.02 = 
* Fixed the stylesheets and removed the blank spaces. Important update.

= 1.01 = 
* Fixed a few bugs

= 1.0 = 
* Initial release

== Upgrade Notice ==

= 2.0.2 =
* Fixed a bug in the widget.
* Fixed the custom forgot your password link.
* Fixed a urls bug.
* Added donations link.

= 2.0.1 =
* Fixed a bug in the shortcode.

= 2.0.0 =
* The options panel got a new look.
* Added the option to use the plugin as a widget.
* Added the option to use the plugin as a shortcode.
* Update is a must!!

= 1.07 =
* Added the option to remove the remember me option from the login field.

= 1.06 = 
* Major code cleanup!
* The option to controll every peice of text and every link that this plugin displays.
* Update is a must!!

= 1.05 = 
* Major updates!! CSS fixes and more options added. Must update!

= 1.04 =
Fixed a one-line minor css bug.

= 1.03 =
Fixed stylesheets font-style bug and changed encoding, important update!

= 1.02 =
Removed white spaces and fixed stylesheets, important update!

= 1.01 =
Fixed errors, please update.

= 1.0 =
First release.

== Frequently Asked Questions ==

= How do I integrate it with my theme? =

All you need to do is paste the following code anywhere in your theme. You can ask for help in the forums and I will help you:
`
<?php
	if(function_exists('wplb_login')) {
		wplb_login();
	}
?>
`

= I don't want to edit any theme files, is there any other way I can use this plugin? =

Yes! You can use the plugin as a shortcode or as a widget. Install the plugin and enable the widget or shortcode from the plugin options panel :)

= Registartions are not working, what do I do? =

If registrations don't work, make sure you enabled them in your wordpress general settings. Go to yourdomain.com/wp-admin/options-general.php and check the box that says "anyone can register".

== Screenshots ==

1. The Log-In form with the Blue style.
2. The Log-In form with the Dark style.
3. The Log-Out form with the Dark style.
4. The options panel.


== Requirements ==

In order to work, WPLB needs the following :

1. PHP version 5+
2. Preferably the latest version of WordPress.

== Donations ==
We are still working on a donations link at the moment. For now, leaving a nice rating will be appreciated as well.