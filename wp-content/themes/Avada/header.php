<!DOCTYPE html>
<html xmlns="http<?php echo (is_ssl())? 's' : ''; ?>://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta property="fb:1603844059888195" content="1603844059888195" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="Shortcut Icon" type="image/x-icon" href="<?php echo get_template_directory_uri() . '/img/splan_icon.ico';?>" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<link href="<?php echo get_template_directory_uri() . '/img/splan_icon_196x196.png';?>" sizes="196x196" rel="shortcut icon">
	<link href="<?php echo get_template_directory_uri() . '/img/splan_icon_152x152.png';?>" sizes="152x152" rel="apple-touch-icon-precomposed">
	<link href="<?php echo get_template_directory_uri() . '/img/splan_icon_144x144.png';?>" sizes="144x144" rel="apple-touch-icon-precomposed">
	<link href="<?php echo get_template_directory_uri() . '/img/splan_icon_120x120.png';?>" sizes="120x120" rel="apple-touch-icon-precomposed">
	<link href="<?php echo get_template_directory_uri() . '/img/splan_icon_114x114.png';?>" sizes="114x114" rel="apple-touch-icon-precomposed">
	<link href="<?php echo get_template_directory_uri() . '/img/splan_icon_76x76.png';?>" sizes="76x76" rel="apple-touch-icon-precomposed">
	<link href="<?php echo get_template_directory_uri() . '/img/splan_icon_72x72.png';?>" sizes="72x72" rel="apple-touch-icon-precomposed">	

	<title>
	<?php
	if ( defined('WPSEO_VERSION') ) {
		wp_title('');
	} else {
		bloginfo('name'); ?> <?php wp_title(' - ', true, 'left');
	}
	?>
	</title>

	<?php global $data; ?>

	<?php $theme_info = wp_get_theme();
	if ($theme_info->parent_theme) {
		$template_dir =  basename(get_template_directory());
		$theme_info = wp_get_theme($template_dir);
	}
	?>
	<style type="text/css"><?php echo $theme_info->get( 'Name' ) . "_" . $theme_info->get( 'Version' ); ?>{color:green;}</style>

	<?php $GLOBALS['backup_wp_query'] = $wp_query; ?>

	<?php if($data['google_body'] && $data['google_body'] != 'Select Font'): ?>
	<?php $gfont[urlencode($data['google_body'])] = '"' . urlencode($data['google_body']) . ':400,400italic,700,700italic:latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese"'; ?>
	<?php endif; ?>

	<?php if($data['google_nav'] && $data['google_nav'] != 'Select Font' && $data['google_nav'] != $data['google_body']): ?>
	<?php $gfont[urlencode($data['google_nav'])] = '"' . urlencode($data['google_nav']) . ':400,400italic,700,700italic:latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese"'; ?>
	<?php endif; ?>

	<?php if($data['google_headings'] && $data['google_headings'] != 'Select Font' && $data['google_headings'] != $data['google_body'] && $data['google_headings'] != $data['google_nav']): ?>
	<?php $gfont[urlencode($data['google_headings'])] = '"' . urlencode($data['google_headings']) . ':400,400italic,700,700italic:latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese"'; ?>
	<?php endif; ?>

	<?php if($data['google_footer_headings'] && $data['google_footer_headings'] != 'Select Font' && $data['google_footer_headings'] != $data['google_body'] && $data['google_footer_headings'] != $data['google_nav'] && $data['google_footer_headings'] != $data['google_headings']): ?>
	<?php $gfont[urlencode($data['google_footer_headings'])] = '"' . urlencode($data['google_footer_headings']) . ':400,400italic,700,700italic:latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese"'; ?>
	<?php endif; ?>

	<?php if($gfont): ?>
	<?php
	if(is_array($gfont) && !empty($gfont)) {
		$gfonts = implode($gfont, ', ');
	}
	?>
	<?php endif; ?>
	<script type="text/javascript">
	WebFontConfig = {
		<?php if(!empty($gfonts)): ?>google: { families: [ <?php echo $gfonts; ?> ] },<?php endif; ?>
		custom: { families: ['FontAwesome'], urls: ['<?php bloginfo('template_directory'); ?>/fonts/fontawesome.css'] }
	};
	(function() {
		var wf = document.createElement('script');
		wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
		  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		wf.type = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(wf, s);
	})();
	</script>

	<?php
	wp_deregister_style( 'style-css' );
	wp_register_style( 'style-css', get_stylesheet_uri() );
	wp_enqueue_style( 'style-css' );
	?>
	<!--[if lte IE 8]>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ie8.css" />
	<![endif]-->

	<!--[if IE]>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ie.css" />
	<![endif]-->

	<?php global $data,$woocommerce; ?>

	<?php
	if(is_page('header-2')) {
		$data['header_right_content'] = 'Social Links';
		if($data['scheme_type'] == 'Dark') {
			$data['header_top_bg_color'] = '#29292a';
			$data['header_icons_color'] = 'Light';
			$data['snav_color'] = '#ffffff';
			$data['header_top_first_border_color'] = '#3e3e3e';
		} else {
			$data['header_top_bg_color'] = '#ffffff';
			$data['header_icons_color'] = 'Dark';
			$data['snav_color'] = '#747474';
			$data['header_top_first_border_color'] = '#efefef';
		}
	} elseif(is_page('header-3')) {
		$data['header_right_content'] = 'Social Links';
	} elseif(is_page('header-4')) {
		$data['header_left_content'] = 'Social Links';
		$data['header_right_content'] = 'Navigation';
	} elseif(is_page('header-5')) {
		$data['header_right_content'] = 'Social Links';
	}
	?>

	<?php if($data['responsive']): ?>
	<?php $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
	if(!$isiPad || !$data['ipad_potrait']): ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<?php endif; ?>
	<?php
	wp_deregister_style( 'media-css' );
	wp_register_style( 'media-css', get_bloginfo('template_directory').'/css/media.css', array(), null, 'all');
	wp_enqueue_style( 'media-css' );
	?>
		<?php if(!$data['ipad_potrait']): ?>
		<?php
		wp_deregister_style( 'ipad-css' );
		wp_register_style( 'ipad-css', get_bloginfo('template_directory').'/css/ipad.css', array(), null, 'all');
		wp_enqueue_style( 'ipad-css' );
		?>
		<?php else: ?>
		<style type="text/css">
		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait){
			#wrapper .ei-slider{width:100% !important;}
		}
		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape){
			#wrapper .ei-slider{width:100% !important;}
		}
		</style>
		<?php endif; ?>
	<?php else: ?>
		<style type="text/css">
		@media only screen and (min-device-width : 768px) and (max-device-width : 1024px){
			#wrapper .ei-slider{width:100% !important;}
		}
		</style>
		<?php $isiPhone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
		if($isiPhone):
		?>
		<style type="text/css">
		@media only screen and (min-device-width : 320px) and (max-device-width : 480px){
			#wrapper .ei-slider{width:100% !important;}
		}
		</style>
		<?php endif; ?>
	<?php endif; ?>

	<?php if(!$data['use_animate_css']): ?>
	<?php if(wp_is_mobile()): ?>
	<?php if(!$data['disable_mobile_animate_css']):
	    wp_deregister_style( 'animate-css' );
	    wp_register_style( 'animate-css', get_bloginfo('template_directory').'/css/animate-custom.css', array(), null, 'all');
		wp_enqueue_style( 'animate-css' );
	?>
	<style type="text/css">
	.animated { visibility:hidden;}
	</style>
	<?php else: ?>
	<style type="text/css">
	.animated { visibility:visible;}
	</style>
	<?php endif; ?>
	<?php else:
	    wp_deregister_style( 'animate-css' );
	    wp_register_style( 'animate-css', get_bloginfo('template_directory').'/css/animate-custom.css', array(), null, 'all');
		wp_enqueue_style( 'animate-css' );
	?>
	<style type="text/css">
	.animated { visibility:hidden;}
	</style>
	<?php endif; ?>
	<?php else: ?>
	<style type="text/css">
	.animated { visibility:visible;}
	</style>
	<?php endif; ?>

	<!--[if lt IE 10]>
	<style type="text/css">
	.animated { visibility:visible;}
	</style>
	<![endif]-->

	<?php if (is_tablet($_SERVER['HTTP_USER_AGENT']) && !$data['header_sticky_tablet']): ?>
	<style type="text/css">
	body #header.sticky-header,body #header.sticky-header.sticky{display:none !important;}
	</style>
	<?php endif; ?>

	<?php if(wp_is_mobile()): ?>
	<style type="text/css">
	.fullwidth-box { background-attachment: scroll !important; }
	</style>
	<?php if(!$data['status_totop_mobile']): ?>
	<style type="text/css">
	#toTop {display: none !important;}
	</style>
	<?php else: ?>
	<style type="text/css">
	#toTop {bottom: 30px !important; border-radius: 4px !important; height: 28px; padding-bottom:10px !important; line-height:28px; z-index: 10000;}
	#toTop:hover {background-color: #333333 !important;}
	</style>
	<?php endif; ?>
	<?php endif; ?>

	<?php if(wp_is_mobile() && $data['mobile_slidingbar_widgets']): ?>
	<style type="text/css">
	#slidingbar-area{display:none !important;}
	</style>
	<?php endif; ?>
	<?php if(wp_is_mobile() && !$data['header_sticky_mobile'] && !is_tablet($_SERVER['HTTP_USER_AGENT'])): ?>
	<style type="text/css">
	body #header.sticky-header,body #header.sticky-header.sticky{display:none !important;}
	</style>
	<?php endif; ?>

	<?php if(wp_is_mobile() && !is_tablet($_SERVER['HTTP_USER_AGENT'])): ?>
	<style type="text/css">
	.header-v5 #header .logo { float: none !important; }
	</style>
	<?php endif; ?>

	<?php if($data['favicon']): ?>
	<link rel="shortcut icon" href="<?php echo $data['favicon']; ?>" type="image/x-icon" />
	<?php endif; ?>

	<?php if($data['iphone_icon']): ?>
	<!-- For iPhone -->
	<link rel="apple-touch-icon-precomposed" href="<?php echo $data['iphone_icon']; ?>">
	<?php endif; ?>

	<?php if($data['iphone_icon_retina']): ?>
	<!-- For iPhone 4 Retina display -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $data['iphone_icon_retina']; ?>">
	<?php endif; ?>

	<?php if($data['ipad_icon']): ?>
	<!-- For iPad -->
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $data['ipad_icon']; ?>">
	<?php endif; ?>

	<?php if($data['ipad_icon_retina']): ?>
	<!-- For iPad Retina display -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $data['ipad_icon_retina']; ?>">
	<?php endif; ?>

	<?php if($data['status_totop']): ?>
	<style type="text/css">
	#toTop {display: none !important;}
	</style>
	<?php endif; ?>

	<?php wp_head(); ?>

	<?php
	if((get_option('show_on_front') && get_option('page_for_posts') && is_home()) ||
		(get_option('page_for_posts') && is_archive() && !is_post_type_archive()) && !(is_tax('product_cat') || is_tax('product_tag'))) {
		$c_pageID = get_option('page_for_posts');
	} else {
		if(isset($post)) {
			$c_pageID = $post->ID;
		}

		if(class_exists('Woocommerce')) {
			if(is_shop() || is_tax('product_cat') || is_tax('product_tag')) {
				$c_pageID = get_option('woocommerce_shop_page_id');
			}
		}
	}
	?>

	<!--[if lte IE 8]>
	<script type="text/javascript">
	jQuery(document).ready(function() {
	var imgs, i, w;
	var imgs = document.getElementsByTagName( 'img' );
	for( i = 0; i < imgs.length; i++ ) {
	    w = imgs[i].getAttribute( 'width' );
	    imgs[i].removeAttribute( 'width' );
	    imgs[i].removeAttribute( 'height' );
	}
	});
	</script>
	<![endif]-->
	<script type="text/javascript">
	/*@cc_on
	  @if (@_jscript_version == 10)
	    document.write('<style type="text/css">.search input{padding-left:5px;}header .tagline{margin-top:3px !important;}.star-rating span:before {letter-spacing: 0;}.avada-select-parent .avada-select-arrow,.gravity-select-parent .select-arrow,.wpcf7-select-parent .select-arrow,.select-arrow{background: #fff;}.star-rating{width: 5.2em!important;}.star-rating span:before {letter-spacing: 0.1em!important;}</style>');
	  @end
	@*/
	<?php
	$lang = '';
	if(defined('ICL_LANGUAGE_CODE')) {
		global $sitepress;
		if(ICL_LANGUAGE_CODE != 'en' && ICL_LANGUAGE_CODE != 'all') {
			$lang = '_'.ICL_LANGUAGE_CODE;
			if(!get_option($theme_name.'_options'.$lang)) {
				update_option($theme_name.'_options'.$lang, get_option($theme_name.'_options'));
			}
		} elseif( ICL_LANGUAGE_CODE == 'all' ) {
			$lang = '_' . $sitepress->get_default_language();
		} else {
			$lang = '';
		}
	}

	ob_start();
	include_once get_template_directory() . '/framework/dynamic_js.php';
	$dynamic_js = ob_get_contents();
	ob_get_clean();

	$upload_dir = wp_upload_dir();
	$filename = trailingslashit($upload_dir['basedir']) . 'avada' . $lang . '.js';

	global $wp_filesystem;
	if( empty( $wp_filesystem ) ) {
	    require_once( ABSPATH .'/wp-admin/includes/file.php' );
	    WP_Filesystem();
	}

	if( $wp_filesystem ) {
		$js_file_status = $wp_filesystem->get_contents( $filename );

		if( ! trim( $js_file_status ) ) { // if js file creation fails
			echo $dynamic_js;
		}
	} else { // if filesystem api fails
		echo $dynamic_js;
	}
	?>
	</script>

	<style type="text/css">
	<?php
	ob_start();
	include_once get_template_directory() . '/framework/dynamic_css.php';
	$dynamic_css = ob_get_contents();
	ob_get_clean();

	$upload_dir = wp_upload_dir();
	$filename = trailingslashit($upload_dir['basedir']) . 'avada' . $lang . '.css';

	global $wp_filesystem;
	if( empty( $wp_filesystem ) ) {
	    require_once( ABSPATH .'/wp-admin/includes/file.php' );
	    WP_Filesystem();
	}

	if( $wp_filesystem ) {
		$css_file_status = $wp_filesystem->get_contents( $filename );

		if( ! trim( $css_file_status ) ) { // if css file creation fails
			echo $dynamic_css;
		}
	} else { // if filesystem api fails
		echo $dynamic_css;
	}
	?>
	<?php if($data['layout'] == 'Boxed'): ?>
	body{
		<?php if(get_post_meta($c_pageID, 'pyre_page_bg_color', true)): ?>
		background-color:<?php echo get_post_meta($c_pageID, 'pyre_page_bg_color', true); ?>;
		<?php else: ?>
		background-color:<?php echo $data['bg_color']; ?>;
		<?php endif; ?>

		<?php if(get_post_meta($c_pageID, 'pyre_page_bg', true)): ?>
		background-image:url(<?php echo get_post_meta($c_pageID, 'pyre_page_bg', true); ?>);
		background-repeat:<?php echo get_post_meta($c_pageID, 'pyre_page_bg_repeat', true); ?>;
			<?php if(get_post_meta($c_pageID, 'pyre_page_bg_full', true) == 'yes'): ?>
			background-attachment:fixed;
			background-position:center center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			<?php endif; ?>
		<?php elseif($data['bg_image']): ?>
		background-image:url(<?php echo $data['bg_image']; ?>);
		background-repeat:<?php echo $data['bg_repeat']; ?>;
			<?php if($data['bg_full']): ?>
			background-attachment:fixed;
			background-position:center center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			<?php endif; ?>
		<?php endif; ?>

		<?php if($data['bg_pattern_option'] && $data['bg_pattern'] && !(get_post_meta($c_pageID, 'pyre_page_bg_color', true) || get_post_meta($c_pageID, 'pyre_page_bg', true))): ?>
		background-image:url("<?php echo get_bloginfo('template_directory') . '/images/patterns/' . $data['bg_pattern'] . '.png'; ?>");
		background-repeat:repeat;
		<?php endif; ?>
	}
	#wrapper{
		background:#fff;
		width:1000px;
		margin:0 auto;
	}
	.wrapper_blank { display: block; }
	@media only screen and (min-width: 801px) and (max-width: 1014px){
		#wrapper{
			width:auto;
		}
	}
	@media only screen and (min-device-width: 801px) and (max-device-width: 1014px){
		#wrapper{
			width:auto;
		}
	}
	<?php endif; ?>

	<?php if($data['layout'] == 'Wide'): ?>
	#wrapper{
		width:100%;
	}
	//.wrapper_blank { display: block; }
	@media only screen and (min-width: 801px) and (max-width: 1014px){
		#wrapper{
			width:auto;
		}
	}
	@media only screen and (min-device-width: 801px) and (max-device-width: 1014px){
		#wrapper{
			width:auto;
		}
	}
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_page_bg_layout', true) == 'boxed'): ?>
	body{
		<?php if(get_post_meta($c_pageID, 'pyre_page_bg_color', true)): ?>
		background-color:<?php echo get_post_meta($c_pageID, 'pyre_page_bg_color', true); ?>;
		<?php else: ?>
		background-color:<?php echo $data['bg_color']; ?>;
		<?php endif; ?>

		<?php if(get_post_meta($c_pageID, 'pyre_page_bg', true)): ?>
		background-image:url(<?php echo get_post_meta($c_pageID, 'pyre_page_bg', true); ?>);
		background-repeat:<?php echo get_post_meta($c_pageID, 'pyre_page_bg_repeat', true); ?>;
			<?php if(get_post_meta($c_pageID, 'pyre_page_bg_full', true) == 'yes'): ?>
			background-attachment:fixed;
			background-position:center center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			<?php endif; ?>
		<?php elseif($data['bg_image']): ?>
		background-image:url(<?php echo $data['bg_image']; ?>);
		background-repeat:<?php echo $data['bg_repeat']; ?>;
			<?php if($data['bg_full']): ?>
			background-attachment:fixed;
			background-position:center center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			<?php endif; ?>
		<?php endif; ?>

		<?php if($data['bg_pattern_option'] && $data['bg_pattern'] && !(get_post_meta($c_pageID, 'pyre_page_bg_color', true) || get_post_meta($c_pageID, 'pyre_page_bg', true))): ?>
		background-image:url("<?php echo get_bloginfo('template_directory') . '/images/patterns/' . $data['bg_pattern'] . '.png'; ?>");
		background-repeat:repeat;
		<?php endif; ?>
	}
	#wrapper{
		background:#fff;
		width:1000px;
		margin:0 auto;
	}
	.wrapper_blank { display: block; }
	@media only screen and (min-width: 801px) and (max-width: 1014px){
		#wrapper{
			width:auto;
		}
	}
	@media only screen and (min-device-width: 801px) and (max-device-width: 1014px){
		#wrapper{
			width:auto;
		}
	}
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_page_bg_layout', true) == 'wide'): ?>
	#wrapper{
		width:100%;
	}
	//.wrapper_blank { display: block; }
	@media only screen and (min-width: 801px) and (max-width: 1014px){
		#wrapper{
			width:auto;
		}
	}
	@media only screen and (min-device-width: 801px) and (max-device-width: 1014px){
		#wrapper{
			width:auto;
		}
	}
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_page_title_custom_subheader', true) != ''): ?>
	.page-title ul {line-height: 40px;}
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_page_title_bar_bg', true)): ?>
	.page-title-container{
		background-image:url(<?php echo get_post_meta($c_pageID, 'pyre_page_title_bar_bg', true); ?>) !important;
	}
	<?php elseif($data['page_title_bg']): ?>
	.page-title-container{
		background-image:url(<?php echo $data['page_title_bg']; ?>) !important;
	}
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_page_title_bar_bg_color', true)): ?>
	.page-title-container{
		background-color:<?php echo get_post_meta($c_pageID, 'pyre_page_title_bar_bg_color', true); ?>;
	}
	<?php elseif($data['page_title_bg_color']): ?>
	.page-title-container{
		background-color:<?php echo $data['page_title_bg_color']; ?>;
	}
	<?php endif; ?>

	#header{
		<?php if($data['header_bg_image']): ?>
		background-image:url(<?php echo $data['header_bg_image']; ?>);
		<?php if($data['header_bg_repeat'] == 'repeat-y' || $data['header_bg_repeat'] == 'no-repeat'): ?>
		background-position: center center;
		<?php endif; ?>
		background-repeat:<?php echo $data['header_bg_repeat']; ?>;
			<?php if($data['header_bg_full']): ?>
			background-attachment:fixed;
			background-position:center center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			<?php endif; ?>
		<?php endif; ?>
	}

	#header{
		<?php if(get_post_meta($c_pageID, 'pyre_header_bg_color', true)): ?>
		background-color:<?php echo get_post_meta($c_pageID, 'pyre_header_bg_color', true); ?> !important;
		<?php endif; ?>
		<?php if(get_post_meta($c_pageID, 'pyre_header_bg', true)): ?>
		background-image:url(<?php echo get_post_meta($c_pageID, 'pyre_header_bg', true); ?>);
		<?php if(get_post_meta($c_pageID, 'pyre_header_bg_repeat', true) == 'repeat-y' || get_post_meta($c_pageID, 'pyre_header_bg_repeat', true) == 'no-repeat'): ?>
		background-position: center center;
		<?php endif; ?>
		background-repeat:<?php echo get_post_meta($c_pageID, 'pyre_header_bg_repeat', true); ?>;
			<?php if(get_post_meta($c_pageID, 'pyre_header_bg_full', true) == 'yes'): ?>
			background-attachment:fixed;
			background-position:center center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			<?php endif; ?>
		<?php endif; ?>
	}

	#main{
		<?php if($data['content_bg_image'] && !get_post_meta($c_pageID, 'pyre_wide_page_bg_color', true)): ?>
		background-image:url(<?php echo $data['content_bg_image']; ?>);
		background-repeat:<?php echo $data['content_bg_repeat']; ?>;
			<?php if($data['content_bg_full']): ?>
			background-attachment:fixed;
			background-position:center center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			<?php endif; ?>
		<?php endif; ?>

		<?php if($data['main_top_padding'] && !get_post_meta($c_pageID, 'pyre_main_top_padding', true)): ?>
		padding-top: <?php echo $data['main_top_padding']; ?> !important;
		<?php endif; ?>

		<?php if($data['main_bottom_padding'] && !get_post_meta($c_pageID, 'pyre_main_bottom_padding', true)): ?>
		padding-bottom: <?php echo $data['main_bottom_padding']; ?> !important;
		<?php endif; ?>
	}

	#main{
		<?php if(get_post_meta($c_pageID, 'pyre_wide_page_bg_color', true)): ?>
		background-color:<?php echo get_post_meta($c_pageID, 'pyre_wide_page_bg_color', true); ?> !important;
		<?php endif; ?>
		<?php if(get_post_meta($c_pageID, 'pyre_wide_page_bg', true)): ?>
		background-image:url(<?php echo get_post_meta($c_pageID, 'pyre_wide_page_bg', true); ?>);
		background-repeat:<?php echo get_post_meta($c_pageID, 'pyre_wide_page_bg_repeat', true); ?>;
			<?php if(get_post_meta($c_pageID, 'pyre_wide_page_bg_full', true) == 'yes'): ?>
			background-attachment:fixed;
			background-position:center center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			<?php endif; ?>
		<?php endif; ?>

		<?php if(get_post_meta($c_pageID, 'pyre_main_top_padding', true)): ?>
		padding-top:<?php echo get_post_meta($c_pageID, 'pyre_main_top_padding', true); ?> !important;
		<?php endif; ?>

		<?php if(get_post_meta($c_pageID, 'pyre_main_top_padding', true)): ?>
		padding-bottom:<?php echo get_post_meta($c_pageID, 'pyre_main_top_padding', true); ?> !important;
		<?php endif; ?>

	}

	.page-title-container{
		<?php if($data['page_title_bg_full']): ?>
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		<?php endif; ?>

		<?php if(get_post_meta($c_pageID, 'pyre_page_title_bar_bg_full', true) == 'yes'): ?>
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		<?php elseif(get_post_meta($c_pageID, 'pyre_page_title_bar_bg_full', true) == 'no'): ?>
		-webkit-background-size: auto;
		-moz-background-size: auto;
		-o-background-size: auto;
		background-size: auto;
		<?php endif; ?>

		<?php if($data['page_title_bg_parallax']): ?>
		background-attachment: fixed;
		background-position:top center;
		<?php endif; ?>

		<?php if(get_post_meta($c_pageID, 'pyre_page_title_bg_parallax', true) == 'yes'): ?>
		background-attachment: fixed;
		background-position:top center;
		<?php elseif(get_post_meta($c_pageID, 'pyre_page_title_bg_parallax', true) == 'no'): ?>
		background-attachment: scroll;
		<?php endif; ?>

	}

	<?php if(get_post_meta($c_pageID, 'pyre_page_title_height', true)): ?>
	.page-title-container{
		height:<?php echo get_post_meta($c_pageID, 'pyre_page_title_height', true); ?> !important;
	}
	<?php elseif($data['page_title_height']): ?>
	.page-title-container{
		height:<?php echo $data['page_title_height']; ?> !important;
	}
	<?php endif; ?>

	<?php if(is_single() && get_post_meta($c_pageID, 'pyre_fimg_width', true)): ?>
	<?php if(get_post_meta($c_pageID, 'pyre_fimg_width', true) != 'auto' && get_post_meta($c_pageID, 'pyre_width', true) != 'half'): ?>
	#post-<?php echo $c_pageID; ?> .post-slideshow {max-width:<?php echo get_post_meta($c_pageID, 'pyre_fimg_width', true); ?> !important;}
	<?php else: ?>
	.post-slideshow .flex-control-nav{position:relative;text-align:left;margin-top:10px;}
	<?php endif; ?>
	#post-<?php echo $c_pageID; ?> .post-slideshow img{max-width:<?php echo get_post_meta($c_pageID, 'pyre_fimg_width', true); ?> !important;}
		<?php if(get_post_meta($c_pageID, 'pyre_fimg_width', true) == 'auto'): ?>
		#post-<?php echo $c_pageID; ?> .post-slideshow img{width:<?php echo get_post_meta($c_pageID, 'pyre_fimg_width', true); ?> !important;}
		<?php endif; ?>
	<?php endif; ?>

	<?php if(is_single() && get_post_meta($c_pageID, 'pyre_fimg_height', true)): ?>
	#post-<?php echo $c_pageID; ?> .post-slideshow, #post-<?php echo $c_pageID; ?> .post-slideshow img{max-height:<?php echo get_post_meta($c_pageID, 'pyre_fimg_height', true); ?> !important;}
	#post-<?php echo $c_pageID; ?> .post-slideshow .slides { max-height: 100%; }
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_page_title_bar_bg_retina', true)): ?>
	@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2) {
		.page-title-container {
			background-image: url(<?php echo get_post_meta($c_pageID, 'pyre_page_title_bar_bg_retina', true); ?>) !important;
			-webkit-background-size:cover;
			   -moz-background-size:cover;
			     -o-background-size:cover;
			        background-size:cover;
		}
	}
	<?php elseif($data['page_title_bg_retina']): ?>
	@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2) {
		.page-title-container {
			background-image: url(<?php echo $data['page_title_bg_retina']; ?>) !important;
			-webkit-background-size:cover;
			   -moz-background-size:cover;
			     -o-background-size:cover;
			        background-size:cover;
		}
	}
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_hundredp_padding', true)): ?>
	.width-100 .fullwidth-box {
		margin-left: -<?php echo get_post_meta($c_pageID, 'pyre_hundredp_padding', true); ?>; margin-right: -<?php echo get_post_meta($c_pageID, 'pyre_hundredp_padding', true); ?>;
	}
	<?php elseif($data['hundredp_padding']): ?>
	.width-100 .fullwidth-box {
		margin-left: -<?php echo $data['hundredp_padding'] ?>; margin-right: -<?php echo $data['hundredp_padding'] ?>;
	}
	<?php endif; ?>

	<?php if((float) $wp_version < 3.8): ?>
	#wpadminbar *{color:#ccc !important;}
	#wpadminbar .hover a, #wpadminbar .hover a span{color:#464646 !important;}
	<?php endif; ?>
	<?php echo $data['custom_css']; ?>
	</style>

	<?php echo $data['google_analytics']; ?>

	<?php echo $data['space_head']; ?>

	<!--[if lte IE 8]>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/respond.js"></script>
	<![endif]-->
	<link rel="stylesheet" id="custom" href="<?php echo get_stylesheet_directory_uri();?>/custom.css?ver=1" type="text/css" media="all" />
	<link rel="stylesheet" id="custom" href="<?php echo get_stylesheet_directory_uri();?>/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.css" type="text/css" media="all" />
	<link rel="stylesheet" id="custom" href="<?php echo get_stylesheet_directory_uri();?>/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" type="text/css" media="all" />
		
	<script type="text/javascript" src="<?php echo get_template_directory_uri(). '/jquery-ui-1.10.4.custom/js/jquery-1.10.2.js';?>"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(). '/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js';?>"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(). '/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js';?>"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(). '/js/jquery.paginate.js';?>"></script>	
	<script type="application/javascript">
jQuery(document).ready(function(){

	/* ============= TOOLTIP ============= */
	jQuery('.submit_task input.submit_hour').tooltip();
	jQuery('.submit_task input.submit_end_hour').tooltip();
	/* ============= END TOOLTIP ============= */

	/* ============= DESCRIPTION ON HOVER ============= */
	jQuery('.display_note').mouseover(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];		
		jQuery('#project_notes_' + data_id).show();
	}).mouseout(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#project_notes_' + data_id).hide();
	});	

	jQuery('.column_cells').mouseover(function(){
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(12, div_id.length);
		jQuery('#submit_task_note' + data_id).show();
	}).mouseout(function(){
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(12, div_id.length);
		jQuery('#submit_task_note' + data_id).hide();
	});
	
	jQuery('.table_data').mouseover(function(){
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(11, div_id.length);
		jQuery('#task_note_' + data_id).show();
	}).mouseout(function(){
		var div_id = jQuery(this).attr('id');
		var data_id = div_id.substring(11, div_id.length);
		jQuery('#task_note_' + data_id).hide();
	});
	
	jQuery('.has_description').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_category = div_id_split[3];
		var data_id = div_id_split[4];		
		jQuery('#checklist_description_'+data_category+'_'+data_id).toggle("medium");
		jQuery(this).toggleClass('open').siblings().removeClass('closed');
	});
	
	jQuery('.checklist_display_list').mouseover(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_category = div_id_split[2];
		var data_id = div_id_split[3];
		jQuery('#checklist_description_'+data_category+'_'+data_id).show();
		}).mouseout(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_category = div_id_split[2];
		var data_id = div_id_split[3];
		jQuery('#checklist_description_'+data_category+'_'+data_id).hide();
	});
		
	/* ============= END DESCRIPTION ON HOVER ============= */
			
	/* ============= MODAL ============= */
	jQuery( ".dialog_form_project_management" ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		close: function() {
		}
	});		

	/* ============= END MODAL ============= */
});
function trigger_note_display(){
	jQuery('.display_note').mouseover(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];		
		jQuery('#project_notes_' + data_id).show();
		}).mouseout(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#project_notes_' + data_id).hide();
	});
}

/* ============= DELETE CONFIRMATION ============= */
jQuery(document).ready(function(){
	jQuery('.confirm').click(function(){
		var answer = confirm("Are you sure you want to continue?");		
		if (answer == 'true'){
			return true;
		} else {
			return false;
		}
	});
});

function trigger_confirm(){
	jQuery('.confirm').click(function(){
		var answer = confirm("Are you sure you want to continue?");
		if (answer == 'true'){
			return true;
		} else {
			return false;
		}
	});
}
/* ============= END DELETE CONFIRMATION ============= */


/* custom_report_project_management.php EDIT MODAL */
jQuery(document).ready(function(){
	jQuery('.modal_form_edit').each(function(){
		jQuery(this).click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(5, div_id.length);	
			jQuery("#loader_"+data_id).show();			
			jQuery.ajax({				
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data: {'data_id' : data_id, 'type' : 'project_management_edit_modal'},
				success: function (data) {
					jQuery(".loader").hide();
					jQuery("#dialog_form_edit_project_management").html(data);
					jQuery("#dialog_form_edit_project_management").dialog( "open" );	
					trigger_modal_edit();
				},
				error: function (data) {
					alert('error');
				}				
			});
		});
	});	
});

function trigger_modal_edit(){
	jQuery('.modal_project_start_date').datepicker();
	jQuery('.modal_project_estimated_deadline').datepicker();
	jQuery(".modal_cancel_project_management").click(function(){
		jQuery(".dialog_form_project_management").dialog("close");
	});
	jQuery('#modal_save_edit_project_management').click(function(){
		jQuery(".modal_save_edit_project_management_loader").show();
		var edit_form_data = jQuery('#edit_modal_project_management').serialize();
		jQuery.ajax({				
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'edit_form_data' : edit_form_data,
				'type' : 'project_management_save_edit_modal'
			},
			success: function (data) {						
				var parsed = jQuery.parseJSON(data);
				var date = new Date();					
				var month_format = (date.getMonth()+1).toString();
				var month = (month_format.length == 1) ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1);										
				var day_format = date.getDate().toString();
				var day = (day_format.length == 1) ? '0' + date.getDate() : date.getDate();					
				var year = date.getFullYear();					
				var today = month+"/"+day+"/"+year;
				if(today > parsed.project_estimated_deadline){
					jQuery('.current #fifth_column_'+parsed.row_id).addClass("red_bg");
					}else{
					jQuery('.current #fifth_column_'+parsed.row_id).removeClass("red_bg");
				}
				jQuery('.current #first_column_'+parsed.row_id).text((parsed.project_client == "") ? "--" : parsed.project_client);
				jQuery('.current #second_column_'+parsed.row_id).text((parsed.project_name == "") ? "--" : parsed.project_name);
				jQuery('.current #third_column_'+parsed.row_id).text((parsed.project_start_date == "") ? "--" : parsed.project_start_date);
				jQuery('.current #fifth_column_'+parsed.row_id).text((parsed.project_estimated_deadline == "") ? "--" : parsed.project_estimated_deadline);
				jQuery('.current #sixth_column_'+parsed.row_id).text((parsed.decimal_hours == "") ? "--" : parsed.decimal_hours);
				jQuery('.current #seventh_column_'+parsed.row_id).text((parsed.revenue == "") ? "--" : parsed.revenue);
				jQuery('.current #eighth_column_'+parsed.row_id).text((parsed.current_expense == "") ? "--" : parsed.current_expense);
				jQuery('.current #tenth_column_'+parsed.row_id).text((parsed.project_current_status == "") ? "--" : parsed.project_current_status);									
				jQuery('.current #eleventh_column_'+parsed.row_id).text((parsed.project_description == "") ? "--" : parsed.project_description);
				jQuery(".dialog_form_project_management").dialog("close");
				jQuery(".status_message p").text("Project Updated");
				jQuery(".status_message").fadeIn( "slow", function() {
					jQuery(".status_message").delay(1000).fadeOut('slow');
				});
				jQuery(".dialog_form_project_management").dialog("close");
				jQuery(".loader").hide();
			},
			error: function (data) {
				alert('error');
			}				
		});
	});
}
/* END custom_report_project_management.php EDIT MODAL */

/* custom_report_project_management.php ARCHIVE MODAL */
jQuery(document).ready(function(){
	jQuery('.modal_form_archive').each(function(){
		jQuery(this).click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(8, div_id.length);
			jQuery("#loader_"+data_id).show();
			jQuery.ajax({				
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data: {'data_id' : data_id, 'type' : 'project_management_archive_modal'},
				success: function (data) {
					jQuery(".loader").hide();
					jQuery("#dialog_form_archive_project_management").html(data);
					jQuery("#dialog_form_archive_project_management").dialog( "open" );
					trigger_modal_archive();
				},
				error: function (data) {
					alert('error');
				}				
			});
		});
	});
});

function trigger_modal_archive(){
	jQuery('.modal_project_invoice_date').datepicker();
	jQuery('.modal_project_date_completed').datepicker();
	jQuery(".modal_cancel_project_management").click(function(){
		jQuery(".dialog_form_project_management").dialog("close");
	});
	jQuery('#modal_save_archive_project_management').click(function(){
		if(!required_input()) return false;
		jQuery(".achive_modal_loader").show();
		var archive_form_data = jQuery('#archive_modal_project_management').serialize();
		jQuery.ajax({				
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'archive_form_data' : archive_form_data,
				'type' : 'project_management_save_archive_modal'
			},
			success: function (data) {	
				jQuery(".achive_modal_loader").hide();			
				var parsed = jQuery.parseJSON(data);
				jQuery('.completed').append('<div class="display_list">'
				+'<div class="info_div">'
				+'<div class="buttons column">'
				+'<div class="button_2" href="#">D</div>'
				+'</div>'					
				+'<p id="first_column_'+parsed.row_id+'" class="first_column column">'+((parsed.project_client == "") ? "--" : parsed.project_client)+'</p>'
				+'<p id="second_column_'+parsed.row_id+'" class="second_column column">'+((parsed.project_name == "") ? "--" : parsed.project_name)+'</p>'
				+'<p id="third_column_'+parsed.row_id+'" class="third_column column">'+((parsed.project_start_date == "") ? "--" : parsed.project_start_date)+'</p>'
				+'<p id="fourth_column_'+parsed.row_id+'" class="fourth_column column">'+((parsed.project_days_in_production == "") ? "--" : parsed.project_days_in_production)+'</p>'
				+'<p id="fifth_column_'+parsed.row_id+'" class="fifth_column column">'+((parsed.project_date_completed == "") ? "--" : parsed.project_date_completed)+'</p>'
				+'<p id="sixth_column_'+parsed.row_id+'" class="sixth_column column">'+((parsed.project_estimated_deadline == "") ? "--" : parsed.project_estimated_deadline)+'</p>'
				+'<p id="seventh_column_'+parsed.row_id+'" class="seventh_column column">'+((parsed.project_invoice_date == "") ? "--" : parsed.project_invoice_date)+'</p>'
				+'<p id="eighth_column_'+parsed.row_id+'" class="eighth_column column">'+((parsed.total_hour_decimal == "") ? "--" : parsed.total_hour_decimal)+'</p>'
				+'<p id="ninth_column_'+parsed.row_id+'" class="ninth_column column">'+((parsed.revenue == "") ? "--" : parsed.revenue)+'</p>'
				+'<p id="tenth_column_'+parsed.row_id+'" class="tenth_column column">'+((parsed.project_responsible_worker == "") ? "--" : parsed.project_responsible_worker)+'</p>'
				+'<p id="eleventh_column_'+parsed.row_id+'" class="eleventh_column column">Invoiced</p>'				
				);
				jQuery("input.modal_project_date_completed").prop('required',true);
				jQuery(".hide_list_"+parsed.row_id+"").css('display', 'none');
				jQuery(".dialog_form_project_management").dialog("close");
				jQuery(".status_message p").text("Project Archived");
				jQuery(".status_message").fadeIn( "slow", function() {
					jQuery(".status_message").delay(1000).fadeOut('slow');
				});
				jQuery(".loader").hide();
				required_input();
			},
			error: function (data) {
				alert('error');
			}				
		});
	});
}
/* END custom_report_project_management.php ARCHIVE MODAL */

/* custom_report_project_management.php EDIT MODAL */
jQuery(document).ready(function(){		
	jQuery(document).on('click', '.modal_form_edit_archive', function(){
		var div_id = jQuery(this).attr('id');
		var data_id_split = div_id.split('_');
		var data_id = data_id_split[2];
		jQuery("#loader_"+data_id).show();			
		jQuery.ajax({				
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data: {'data_id' : data_id, 'type' : 'project_management_edit_archive_modal'},
			success: function (data) {
				jQuery(".loader").hide();
				jQuery("#dialog_form_edit_archive_project_management").html(data);
				jQuery("#dialog_form_edit_archive_project_management").dialog( "open" );	
				trigger_modal_update_archive();
			},
			error: function (data) {
				alert('error');
			}				
		});
	});
});

function trigger_modal_update_archive(){
	jQuery('.modal_project_invoice_date').datepicker();
	jQuery('.modal_project_date_completed').datepicker();
	jQuery('.modal_project_estimated_deadline').datepicker();
	jQuery(".modal_cancel_project_management").click(function(){
		jQuery(".dialog_form_project_management").dialog("close");
	});
	jQuery('#modal_update_archive_project_management').click(function(){
		if(!required_input()) return false;
		jQuery(".achive_modal_loader").show();
		var update_archive_form_data = jQuery('#edit_archive_modal_project_management').serialize();
		jQuery.ajax({				
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'update_archive_form_data' : update_archive_form_data,
				'type' : 'project_management_update_archive_modal'
			},
			success: function (data) {	
				jQuery(".achive_modal_loader").hide();			
				var parsed = jQuery.parseJSON(data);
				var row_id = parsed.row_id;				
				var project_client = parsed.project_client;
				var project_name = parsed.project_name;
				var project_start_date = parsed.project_start_date;
				var project_days_in_production = parsed.project_days_in_production;
				var project_date_completed = parsed.project_date_completed;
				var project_estimated_deadline = parsed.project_estimated_deadline;
				var project_invoice_date = parsed.project_invoice_date;
				var total_hour_decimal = parsed.total_hour_decimal;
				var revenue = parsed.revenue;				
				var project_responsible_worker = parsed.project_responsible_worker;
				var project_current_status = parsed.project_current_status;
				var project_description = parsed.project_description;
				var project_date_completed_mktime = parsed.project_date_completed_mktime;
				var project_estimated_deadline_mktime = parsed.project_estimated_deadline_mktime;
				
				jQuery('#display_note_'+row_id+' #first_column_'+row_id).text(project_client);
				jQuery('#display_note_'+row_id+' #second_column_'+row_id).text(project_name);
				jQuery('#display_note_'+row_id+' #third_column_'+row_id).text(project_start_date);
				jQuery('#display_note_'+row_id+' #fourth_column_'+row_id).text(project_days_in_production);
				jQuery('#display_note_'+row_id+' #fifth_column_'+row_id).text(project_date_completed);
				jQuery('#display_note_'+row_id+' #sixth_column_'+row_id).text(project_estimated_deadline);
				jQuery('#display_note_'+row_id+' #seventh_column_'+row_id).text(project_invoice_date);
				jQuery('#display_note_'+row_id+' #eighth_column_'+row_id).text(total_hour_decimal);
				jQuery('#display_note_'+row_id+' #ninth_column_'+row_id).text(revenue);
				jQuery('#display_note_'+row_id+' #tenth_column_'+row_id).text(project_responsible_worker);
				jQuery('#display_note_'+row_id+' #eleventh_column_'+row_id).text(project_current_status);
				jQuery('#display_note_'+row_id+' #project_notes_'+row_id+ ' p strong').text(project_client +':');
				jQuery('#display_note_'+row_id+' #project_notes_'+row_id+ ' p:nth-of-type(2)').text(project_description);
				
				jQuery('#display_note_'+row_id+' #fifth_column_'+row_id).removeClass('red_bg');
				jQuery('#display_note_'+row_id+' #ninth_column_'+row_id).removeClass('red_bg');
				jQuery('#display_note_'+row_id+' #ninth_column_'+row_id).removeClass('green_bg');
				
				if(project_date_completed_mktime > project_estimated_deadline_mktime){
					jQuery('#display_note_'+row_id+' #fifth_column_'+row_id).addClass('red_bg');
				}

				if(revenue > 0){
					jQuery('#display_note_'+row_id+' #ninth_column_'+row_id).addClass('green_bg');
				}else{
					jQuery('#display_note_'+row_id+' #ninth_column_'+row_id).addClass('red_bg');
				}
				
				jQuery("input.modal_project_date_completed").prop('required',true);				
				jQuery(".dialog_form_project_management").dialog("close");
				jQuery(".status_message p").text("Project Updated");
				jQuery(".status_message").fadeIn( "slow", function() {
					jQuery(".status_message").delay(1000).fadeOut('slow');
				});
				jQuery(".loader").hide();
				required_input();
			},
			error: function (data) {
				alert('error');
			}				
		});
		});
}
/* END custom_report_project_management.php EDIT MODAL */

/* custom_report_project_management.php DELETE MODAL */
jQuery(document).ready(function(){
	jQuery('.modal_form_delete').each(function(){
		jQuery(this).click(function(){			
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(7, div_id.length);
			jQuery("#loader_"+data_id).show();
			jQuery.ajax({				
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data: {
					'data_id' : data_id, 
					'type' : 'project_management_confirm_delete_modal'
				},
				success: function (data) {
					jQuery(".loader").hide();
					jQuery("#dialog_form_delete_project_management").html(data);
					jQuery("#dialog_form_delete_project_management").dialog( "open" );
					trigger_modal_delete();
				},
				error: function (data) {
					alert('error');
				}				
			});
		});
	});
});

function trigger_modal_delete(){
	jQuery(".modal_cancel_project_management").click(function(){
		jQuery(".dialog_form_project_management").dialog("close");
	});
	jQuery('#modal_delete_project_management').click(function(){
		jQuery(".loader").show();
		var delete_form_data = jQuery('#delete_modal_project_management').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'delete_form_data' : delete_form_data,
				'type' : 'project_management_delete_modal_row'
			},
			success: function (data) {						
				var parsed = jQuery.parseJSON(data);
				jQuery(".hide_list_"+parsed.row_id+"").css('display', 'none');
				jQuery(".dialog_form_project_management").dialog("close");
				jQuery(".status_message p").text("Project Deleted");
				jQuery(".status_message").fadeIn( "slow", function() {
					jQuery(".status_message").delay(1000).fadeOut('slow');
				});
				jQuery(".loader").hide();					
			},
			error: function (data) {
				alert('error');
			}				
		});
	});
}
/* END custom_report_project_management.php DELETE MODAL */

/* custom_report_project_management.php COMPLETED WEBDEV FILTER */
jQuery(document).ready(function(){
	jQuery('.completed_webdev_filter .year_previous').click(function(){
		jQuery('.completed_project_filter_loader').show();
		var current_year = jQuery('.section.completed .current_year').val();
		var filter_year = parseInt(current_year) - 1;
		pm_completed_webdev_filter(filter_year);
	});
	
	jQuery('.completed_webdev_filter .year_next').click(function(){
		jQuery('.completed_project_filter_loader').show();
		var current_year = jQuery('.section.completed .current_year').val();
		var filter_year = parseInt(current_year) + 1;
		pm_completed_webdev_filter(filter_year);
	});
});

function pm_completed_webdev_filter(filter_year){
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'filter_year' : filter_year,
			'type' : 'pm_completed_webdev_filter'
		},
		success: function (data) {
			jQuery('.completed_webdev_container').empty();
			jQuery('.completed_webdev_totals').empty();
			var parsed = jQuery.parseJSON(data);
			if(parsed.result == 'not_null'){
				jQuery.each(parsed.project_management_filter_details, function(key, value) {
						var value_split = value.split('_');					
						var project_id = value_split[0];
						var project_client = value_split[1];
						var project_name = value_split[2];
						var project_start_date = value_split[3];
						var project_days_in_production = value_split[4];
						var project_date_completed = value_split[5];
						var project_estimated_deadline = value_split[6];
						var project_invoice_date  = value_split[7];
						var total_hour_decimal = value_split[8];
						var revenue = value_split[9];
						var project_responsible_worker = value_split[10];
						var project_current_status = value_split[11];
						var project_description = value_split[12];
						var project_date_completed_mktime = value_split[13];
						var project_estimated_deadline_mktime = value_split[14];
						var today = value_split[15];					
						jQuery('.completed_webdev_container').append('<div id="display_note_'+project_id+'" class="display_note display_list hide_list_'+project_id+'">'					
						+'<div class="info_div">'
						+'<div class="buttons column">'
						+'<div id="edit_archive_'+project_id+'" class="button_2 modal_form_edit_archive">E</div>'
						+'<div id="delete_'+project_id+'" class="button_2 modal_form_delete">D</div>'
						+'<div style="display:none;" id="loader_'+project_id+'" class="loader"></div>'
						+'</div>'
						+'<p id="first_column_'+project_id+'" class="first_column column">'+((project_client == "") ? "--" : project_client)+'</p>'
						+'<p id="second_column_'+project_id+'" class="second_column column">'+((project_name == "") ? "--" : project_name)+'</p>'
						+'<p id="third_column_'+project_id+'" class="third_column column">'+((project_start_date == "") ? "--" : project_start_date)+'</p>'
						+'<p id="fourth_column_'+project_id+'" class="fourth_column column">'+((project_days_in_production == "") ? "--" : project_days_in_production)+'</p>'
						+'<p id="fifth_column_'+project_id+'" class="fifth_column column '+((project_date_completed_mktime > project_estimated_deadline_mktime) ? "red_bg" : "")+'">'+((project_date_completed == "") ? "--" : project_date_completed)+'</p>'
						+'<p id="sixth_column_'+project_id+'" class="sixth_column column">'+((project_estimated_deadline == "") ? "--" : project_estimated_deadline)+'</p>'
						+'<p id="seventh_column_'+project_id+'" class="seventh_column column">'+((project_invoice_date == "") ? "--" : project_invoice_date)+'</p>'
						+'<p id="eighth_column_'+project_id+'" class="eighth_column column">'+((total_hour_decimal == "") ? "--" : total_hour_decimal)+'</p>'
						+'<p id="ninth_column_'+project_id+'" class="ninth_column column '+((revenue > 0) ? "green_bg" : "red_bg")+'">'+((revenue == "") ? "--" : revenue)+'</p>'
						+'<p id="tenth_column_'+project_id+'" class="tenth_column column">'+((project_responsible_worker == "") ? "--" : project_responsible_worker)+'</p>'
						+'<p id="eleventh_column_'+project_id+'" class="eleventh_column column">'+((project_current_status == "") ? "--" : project_current_status)+'</p>'
						+'</div>'
						+'<div style="display:none" id="project_notes_'+project_id+'" class="project_notes">'
						+'<p style="float:left"><strong>'+project_client+':&nbsp</strong></p>'
						+'<p style="float:left">'+project_description+'</p>'
						+'</div>'
						+'</div>'
						);
				});
				var year_total_hour_decimal = parsed.year_total_hour_decimal;
				var year_total_revenue = parsed.year_total_revenue;
				jQuery('.completed_webdev_totals').append('<p class="totals column">TOTAL</p>'
					+'<p class="first_column column">&nbsp;</p>'
					+'<p class="second_column column">&nbsp;</p>'
					+'<p class="third_column column">&nbsp;</p>'
					+'<p class="fourth_column column">&nbsp;</p>'
					+'<p class="fifth_column column">&nbsp;</p>'
					+'<p class="sixth_column column">&nbsp;</p>'
					+'<p class="seventh_column column">&nbsp;</p>'
					+'<p class="eighth_column column">'+year_total_hour_decimal+'</p>'
					+'<p class="ninth_column column">'+year_total_revenue+'</p>'
					+'<p class="tenth_column column">&nbsp;</p>'
					+'<p class="eleventh_column column">&nbsp;</p>'
				);				
			}else if(parsed.result == 'null'){
				jQuery('.completed_webdev_container').append('<p class="text_red no_found">No Entries Found.</p>');				
			}
			var filter_year = parsed.filter_year;			
			jQuery('.section .completed_webdev_filter .current_year').val(filter_year);
			jQuery('.section .completed_webdev_filter .report_top_label h1').text(filter_year);
			jQuery('.completed_project_filter_loader').hide();
		},
		error: function (data) {
			alert('error');
		}				
	});
}
/* END custom_report_project_management.php COMPLETED WEBDEV FILTER */

/* custom_report_project_management.php CURRENT SEO FILTER */
jQuery(document).ready(function(){
	jQuery('.current_seo_filter .default_arrow_container .previous_arrow').click(function(){
		var current_year = jQuery('.current_seo_filter .current_year').val();
		var current_month = jQuery('.current_seo_filter .current_month').val();
		if(current_month == 01){
			var filter_month = 12;
			var filter_year = parseInt(current_year) - 1;
			}else{
			var filter_month = parseInt(current_month) - 1;
			var filter_year = current_year;
		}
		var filter_details = filter_year +"_"+ filter_month;
		pm_current_seo_filter(filter_details);
		jQuery('.current_seo_filter .current_year').val(filter_year);
		jQuery('.current_seo_filter .current_month').val(filter_month);				
		jQuery('.section .current_seo_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
	});
	
	jQuery('.current_seo_filter .default_arrow_container .next_arrow').click(function(){
		var current_year = jQuery('.current_seo_filter .current_year').val();
		var current_month = jQuery('.current_seo_filter .current_month').val();
		if(current_month == 12){
			var filter_month = 01;
			var filter_year = parseInt(current_year) + 1;
			}else{
			var filter_month = parseInt(current_month) + 1;
			var filter_year = current_year;
		}
		var filter_details = filter_year +"_"+ filter_month;
		pm_current_seo_filter(filter_details);
		jQuery('.current_seo_filter .current_year').val(filter_year);
		jQuery('.current_seo_filter .current_month').val(filter_month);
		jQuery('.section .current_seo_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
	});
	
	jQuery('.current_seo_filter .current_seo_filter_select').change(function(){
		var filter_type = jQuery(this).val();
		if(filter_type == 'Year'){
			jQuery('.current_seo_filter .default_arrow_container').hide();
			jQuery('.current_seo_filter .arrow_container').show();
			var current_year = jQuery('.current_seo_filter .current_year').val();
			var filter_details = current_year +"_"+ 'null';
			pm_current_seo_filter(filter_details);
			jQuery('.section .current_seo_filter .report_top_label h1').text(current_year);
			
			jQuery('.current_seo_filter .previous_arrow').click(function(){
				var current_year = jQuery('.current_seo_filter .current_year').val();
				var filter_year = parseInt(current_year) - 1;
				var filter_details = filter_year +"_"+ 'null';
				pm_current_seo_filter(filter_details);
				jQuery('.current_seo_filter .current_year').val(filter_year);
				jQuery('.section .current_seo_filter .report_top_label h1').text(filter_year);
			});
			
			jQuery('.current_seo_filter .next_arrow').click(function(){
				var current_year = jQuery('.current_seo_filter .current_year').val();
				var filter_year = parseInt(current_year) + 1;
				var filter_details = filter_year +"_"+ 'null';
				pm_current_seo_filter(filter_details);
				jQuery('.current_seo_filter .current_year').val(filter_year);
				jQuery('.section .current_seo_filter .report_top_label h1').text(filter_year);
			});
		}
		if(filter_type == 'Month'){
			jQuery('.current_seo_filter .default_arrow_container').hide();
			jQuery('.current_seo_filter .arrow_container').show();
			var current_year = jQuery('.current_seo_filter .current_year').val();
			var current_month = jQuery('.current_seo_filter .current_month').val();
			var filter_details = current_year +"_"+ current_month;
			pm_current_seo_filter(filter_details);			
			jQuery('.section .current_seo_filter .report_top_label h1').text(get_month_name(current_month.toString(), 'true') +" "+ current_year);
			
			jQuery('.current_seo_filter .previous_arrow').click(function(){
				var current_year = jQuery('.current_seo_filter .current_year').val();
				var current_month = jQuery('.current_seo_filter .current_month').val();
				if(current_month == 01){
					var filter_month = 12;
					var filter_year = parseInt(current_year) - 1;
				}else{
					var filter_month = parseInt(current_month) - 1;
					var filter_year = current_year;
				}
				var filter_details = filter_year +"_"+ filter_month;
				pm_current_seo_filter(filter_details);
				jQuery('.current_seo_filter .current_year').val(filter_year);
				jQuery('.current_seo_filter .current_month').val(filter_month);				
				jQuery('.section .current_seo_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
			});
			
			jQuery('.current_seo_filter .next_arrow').click(function(){
				var current_year = jQuery('.current_seo_filter .current_year').val();
				var current_month = jQuery('.current_seo_filter .current_month').val();
				if(current_month == 12){
					var filter_month = 01;
					var filter_year = parseInt(current_year) + 1;
				}else{
					var filter_month = parseInt(current_month) + 1;
					var filter_year = current_year;
				}
				var filter_details = filter_year +"_"+ filter_month;
				pm_current_seo_filter(filter_details);
				jQuery('.current_seo_filter .current_year').val(filter_year);
				jQuery('.current_seo_filter .current_month').val(filter_month);
				jQuery('.section .current_seo_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
			});
		}
	});
});
function pm_current_seo_filter(filter_details){
	jQuery('.current_seo_filter_loader').show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'filter_details' : filter_details,
			'type' : 'pm_current_seo_filter'
		},
		success: function (data) {
			jQuery('.current_seo_container').empty();
			var parsed = jQuery.parseJSON(data);			
			jQuery.each( parsed.current_seo_filter_details, function(key, seo_filter_details) {
				var seo_filter_details_split = seo_filter_details.split('_');
				var client_id = seo_filter_details_split[0];
				var seo_ongoing_client = seo_filter_details_split[1];
				var monthly_plan_seo_name = seo_filter_details_split[2];
				var monthly_plan_dev_name = seo_filter_details_split[3];
				var total_year_hours_seo = seo_filter_details_split[4];
				var total_year_hours_dev = seo_filter_details_split[5];
				var total_year_con_hours = seo_filter_details_split[6];
				var total_year_hours = seo_filter_details_split[7];
				var project_expense = seo_filter_details_split[8];
				var revenue = seo_filter_details_split[9];
				var revenue_class = seo_filter_details_split[10];
				var project_description_split = seo_filter_details_split[11].split('<join>');
				var prject_description_seo = project_description_split[0];
				var prject_description_dev = project_description_split[1];
				var monthly_plans_budget = seo_filter_details_split[12];
				if(revenue_class == 'redbg'){
					revenue_class = 'red_bg';
				}else if(revenue_class == 'greenbg'){
					revenue_class = 'green_bg';
				}
				jQuery('.current_seo_container').append('<div id="display_note_'+client_id+'" class="display_note display_list hide_list_'+client_id+'">'
				+'<div class="info_div">'
				+'<p id="first_column_'+client_id+'" class="first_column column">'+seo_ongoing_client+'</p>'
				+'<p id="second_column_'+client_id+'" class="second_column column">'+monthly_plan_seo_name+'</p>'
				+'<p id="third_column_'+client_id+'" class="third_column column">'+monthly_plan_dev_name+'</p>'
				+'<p id="fourth_column_'+client_id+'" class="fourth_column column">'+total_year_hours_seo+'</p>'
				+'<p id="fifth_column_'+client_id+'" class="fifth_column column">'+total_year_hours_dev+'</p>'
				+'<p id="sixth_column_'+client_id+'" class="sixth_column column">'+total_year_con_hours+'</p>'
				+'<p id="seventh_column_'+client_id+'" class="seventh_column column">'+total_year_hours+'</p>'
				+'<p id="eighth_column_'+client_id+'" class="eighth_column column">'+project_expense+'</p>'
				+'<p id="ninth_column_'+client_id+'" class="ninth_column column '+revenue_class+'">'+revenue+'</p>'
				+'<p id="tenth_column_'+client_id+'" class="tenth_column column">'+monthly_plans_budget+'</p>'
				+'</div>'
				+'<div style="display:none" id="project_notes_'+client_id+'" class="project_notes">'
				+'<p style="float:left"><strong>'+seo_ongoing_client+':&nbsp</strong></p>'
				+'<p style="float:left"><strong>SEO: </strong>'+((typeof prject_description_seo == 'undefined') ? "" : prject_description_seo)+'<br/>'+'<strong>DEV: </strong>'+((typeof prject_description_dev == 'undefined') ? "" : prject_description_dev)+'</p>'
				+'</div>'
				+'</div>'
				);
			});
			trigger_note_display();
			jQuery('.current_seo_filter_loader').hide();	
		},
		error: function (data) {
			alert('error');
		}				
	});
}
/* END custom_report_project_management.php CURRENT SEO FILTER */

/* custom_report_project_management.php CURRENT INTERNAL DEV FILTER */
jQuery(document).ready(function(){
	jQuery('.current_internal_dev_filter .default_arrow_container .previous_arrow').click(function(){		
		var current_year = jQuery('.current_internal_dev_filter .current_year').val();
		var current_month = jQuery('.current_internal_dev_filter .current_month').val();
		if(current_month == 01){
			var filter_month = 12;
			var filter_year = parseInt(current_year) - 1;
		}else{
			var filter_month = parseInt(current_month) - 1;
			var filter_year = current_year;
		}
		var filter_details = filter_year +"_"+ filter_month;
		pm_current_internal_dev_filter(filter_details);
		jQuery('.current_internal_dev_filter .current_year').val(filter_year);
		jQuery('.current_internal_dev_filter .current_month').val(filter_month);				
		jQuery('.section .current_internal_dev_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
	});
	
	jQuery('.current_internal_dev_filter .default_arrow_container .next_arrow').click(function(){
		var current_year = jQuery('.current_internal_dev_filter .current_year').val();
		var current_month = jQuery('.current_internal_dev_filter .current_month').val();
		if(current_month == 12){
			var filter_month = 01;
			var filter_year = parseInt(current_year) + 1;
			}else{
			var filter_month = parseInt(current_month) + 1;
			var filter_year = current_year;
		}
		var filter_details = filter_year +"_"+ filter_month;
		pm_current_internal_dev_filter(filter_details);
		jQuery('.current_internal_dev_filter .current_year').val(filter_year);
		jQuery('.current_internal_dev_filter .current_month').val(filter_month);
		jQuery('.section .current_internal_dev_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
	});
	
	jQuery('.current_internal_dev_filter .current_internal_dev_filter_select').change(function(){
		var filter_type = jQuery(this).val();
		if(filter_type == 'Year'){
			jQuery('.current_internal_dev_filter .default_arrow_container').hide();
			jQuery('.current_internal_dev_filter .arrow_container').show();
			var current_year = jQuery('.current_internal_dev_filter .current_year').val();
			var filter_details = current_year +"_"+ 'null';
			pm_current_internal_dev_filter(filter_details);
			jQuery('.section .current_internal_dev_filter .report_top_label h1').text(current_year);
			
			jQuery('.current_internal_dev_filter .previous_arrow').click(function(){
				var current_year = jQuery('.current_internal_dev_filter .current_year').val();
				var filter_year = parseInt(current_year) - 1;
				var filter_details = filter_year +"_"+ 'null';
				pm_current_internal_dev_filter(filter_details);
				jQuery('.current_internal_dev_filter .current_year').val(filter_year);
				jQuery('.section .current_internal_dev_filter .report_top_label h1').text(filter_year);
			});
			
			jQuery('.current_internal_dev_filter .next_arrow').click(function(){
				var current_year = jQuery('.current_internal_dev_filter .current_year').val();
				var filter_year = parseInt(current_year) + 1;
				var filter_details = filter_year +"_"+ 'null';
				pm_current_internal_dev_filter(filter_details);
				jQuery('.current_internal_dev_filter .current_year').val(filter_year);
				jQuery('.section .current_internal_dev_filter .report_top_label h1').text(filter_year);
			});
		}
		if(filter_type == 'Month'){
			jQuery('.current_internal_dev_filter .default_arrow_container').hide();
			jQuery('.current_internal_dev_filter .arrow_container').show();
			var current_year = jQuery('.current_internal_dev_filter .current_year').val();
			var current_month = jQuery('.current_internal_dev_filter .current_month').val();
			var filter_details = current_year +"_"+ current_month;
			pm_current_internal_dev_filter(filter_details);			
			jQuery('.section .current_internal_dev_filter .report_top_label h1').text(get_month_name(current_month.toString(), 'true') +" "+ current_year);
			
			jQuery('.current_internal_dev_filter .previous_arrow').click(function(){
				var current_year = jQuery('.current_internal_dev_filter .current_year').val();
				var current_month = jQuery('.current_internal_dev_filter .current_month').val();
				if(current_month == 01){
					var filter_month = 12;
					var filter_year = parseInt(current_year) - 1;
					}else{
					var filter_month = parseInt(current_month) - 1;
					var filter_year = current_year;
				}
				var filter_details = filter_year +"_"+ filter_month;
				pm_current_internal_dev_filter(filter_details);
				jQuery('.current_internal_dev_filter .current_year').val(filter_year);
				jQuery('.current_internal_dev_filter .current_month').val(filter_month);				
				jQuery('.section .current_internal_dev_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
			});
			
			jQuery('.current_internal_dev_filter .next_arrow').click(function(){
				var current_year = jQuery('.current_internal_dev_filter .current_year').val();
				var current_month = jQuery('.current_internal_dev_filter .current_month').val();
				if(current_month == 12){
					var filter_month = 01;
					var filter_year = parseInt(current_year) + 1;
					}else{
					var filter_month = parseInt(current_month) + 1;
					var filter_year = current_year;
				}
				var filter_details = filter_year +"_"+ filter_month;
				pm_current_internal_dev_filter(filter_details);
				jQuery('.current_internal_dev_filter .current_year').val(filter_year);
				jQuery('.current_internal_dev_filter .current_month').val(filter_month);
				jQuery('.section .current_internal_dev_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
			});
		}
	});
});
function pm_current_internal_dev_filter(filter_details){
	jQuery('.current_internal_dev_filter_loader').show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'filter_details' : filter_details,
			'type' : 'pm_current_internal_dev_filter'
		},
		success: function (data) {
			jQuery('.current_internal_dev_container').empty();
			var parsed = jQuery.parseJSON(data);
			jQuery.each( parsed.current_internal_dev_filter_details, function(key, internal_dev_filter_details) {
				var internal_dev_filter_details_split = internal_dev_filter_details.split('_');
				var project_id = internal_dev_filter_details_split[0];
				var project_client = internal_dev_filter_details_split[1];
				var project_name = internal_dev_filter_details_split[2];
				var project_start_date = internal_dev_filter_details_split[3];
				var project_days_in_production  = internal_dev_filter_details_split[4];
				var project_estimated_deadline = internal_dev_filter_details_split[5];
				var project_estimated_deadline_class = internal_dev_filter_details_split[6];
				var total_hour_decimal = internal_dev_filter_details_split[7];
				var revenue = internal_dev_filter_details_split[8];
				var revenue_class = internal_dev_filter_details_split[9];
				var current_expense = internal_dev_filter_details_split[10];
				var project_responsible_worker = internal_dev_filter_details_split[11];
				var project_current_status = internal_dev_filter_details_split[12];
				var project_description = internal_dev_filter_details_split[13];
				if(revenue_class == 'redbg'){
					revenue_class = 'red_bg';
					}else if(revenue_class == 'greenbg'){
					revenue_class = 'green_bg';
				}
				jQuery('.current_internal_dev_container').append('<div id="display_note_'+project_id+'" class="display_note display_list hide_list_'+project_id+'">'
				+'<div class="info_div">'
				+'<div class="buttons column">'
				+'<div id="edit_'+project_id+'" class="button_2 modal_form_edit">E</div>'
				+'<div id="archive_'+project_id+'" class="button_2 modal_form_archive">A</div>'
				+'<div id="delete_'+project_id+'" class="button_2 modal_form_delete">D</div>'
				+'<div style="display:none;" id="loader_'+project_id+'" class="loader"></div>'
				+'</div>'
				+'<p id="first_column_'+project_id+'" class="first_column column">'+project_client+'</p>'
				+'<p id="second_column_'+project_id+'" class="second_column column">'+project_name+'</p>'
				+'<p id="third_column_'+project_id+'" class="third_column column">'+project_start_date+'</p>'
				+'<p id="fourth_column_'+project_id+'" class="fourth_column column">'+project_days_in_production +'</p>'
				+'<p id="fifth_column_'+project_id+'" class="fifth_column column '+project_estimated_deadline_class+'">'+project_estimated_deadline+'</p>'
				+'<p id="sixth_column_'+project_id+'" class="sixth_column column">'+total_hour_decimal+'</p>'
				+'<p id="seventh_column_'+project_id+'" class="seventh_column column '+revenue_class+'">'+revenue+'</p>'
				+'<p id="eighth_column_'+project_id+'" class="eighth_column column">'+current_expense+'</p>'					 
				+'<p id="ninth_column_'+project_id+'" class="ninth_column column">'+project_responsible_worker+'</p>'
				+'<p id="tenth_column_'+project_id+'" class="tenth_column_ column">'+project_current_status+'</p>'	
				+'</div>'
				+'<div style="display:none" id="project_notes_'+project_id+'" class="project_notes">'
				+'<p style="float:left"><strong>'+project_client+':&nbsp</strong></p>'
				+'<p style="float:left">'+project_description+'</p>'
				+'</div>'
				+'</div>'
				);
			});
			trigger_note_display();
			jQuery('.current_internal_dev_filter_loader').hide();	
		},
		error: function (data) {
			alert('error');
		}				
	});
}
/* END custom_report_project_management.php CURRENT INTERNAL DEV FILTER */

/* custom_report_project_management.php CURRENT INTERNAL SEO FILTER */
jQuery(document).ready(function(){
	jQuery('.current_internal_seo_filter .default_arrow_container .previous_arrow').click(function(){		
		var current_year = jQuery('.current_internal_seo_filter .current_year').val();
		var current_month = jQuery('.current_internal_seo_filter .current_month').val();
		if(current_month == 01){
			var filter_month = 12;
			var filter_year = parseInt(current_year) - 1;
			}else{
			var filter_month = parseInt(current_month) - 1;
			var filter_year = current_year;
		}
		var filter_details = filter_year +"_"+ filter_month;
		pm_current_internal_seo_filter(filter_details);
		jQuery('.current_internal_seo_filter .current_year').val(filter_year);
		jQuery('.current_internal_seo_filter .current_month').val(filter_month);				
		jQuery('.section .current_internal_seo_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
	});
	
	jQuery('.current_internal_seo_filter .default_arrow_container .next_arrow').click(function(){
		var current_year = jQuery('.current_internal_seo_filter .current_year').val();
		var current_month = jQuery('.current_internal_seo_filter .current_month').val();
		if(current_month == 12){
			var filter_month = 01;
			var filter_year = parseInt(current_year) + 1;
			}else{
			var filter_month = parseInt(current_month) + 1;
			var filter_year = current_year;
		}
		var filter_details = filter_year +"_"+ filter_month;
		pm_current_internal_seo_filter(filter_details);
		jQuery('.current_internal_seo_filter .current_year').val(filter_year);
		jQuery('.current_internal_seo_filter .current_month').val(filter_month);
		jQuery('.section .current_internal_seo_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
	});
	
	jQuery('.current_internal_seo_filter .current_internal_seo_filter_select').change(function(){
		var filter_type = jQuery(this).val();
		if(filter_type == 'Year'){
			jQuery('.current_internal_seo_filter .default_arrow_container').hide();
			jQuery('.current_internal_seo_filter .arrow_container').show();
			var current_year = jQuery('.current_internal_seo_filter .current_year').val();
			var filter_details = current_year +"_"+ 'null';
			pm_current_internal_seo_filter(filter_details);
			jQuery('.section .current_internal_seo_filter .report_top_label h1').text(current_year);
			
			jQuery('.current_internal_seo_filter .previous_arrow').click(function(){
				var current_year = jQuery('.current_internal_seo_filter .current_year').val();
				var filter_year = parseInt(current_year) - 1;
				var filter_details = filter_year +"_"+ 'null';
				pm_current_internal_seo_filter(filter_details);
				jQuery('.current_internal_seo_filter .current_year').val(filter_year);
				jQuery('.section .current_internal_seo_filter .report_top_label h1').text(filter_year);
			});
			
			jQuery('.current_internal_seo_filter .next_arrow').click(function(){
				var current_year = jQuery('.current_internal_seo_filter .current_year').val();
				var filter_year = parseInt(current_year) + 1;
				var filter_details = filter_year +"_"+ 'null';
				pm_current_internal_seo_filter(filter_details);
				jQuery('.current_internal_seo_filter .current_year').val(filter_year);
				jQuery('.section .current_internal_seo_filter .report_top_label h1').text(filter_year);
			});
		}
		if(filter_type == 'Month'){
			jQuery('.current_internal_seo_filter .default_arrow_container').hide();
			jQuery('.current_internal_seo_filter .arrow_container').show();
			var current_year = jQuery('.current_internal_seo_filter .current_year').val();
			var current_month = jQuery('.current_internal_seo_filter .current_month').val();
			var filter_details = current_year +"_"+ current_month;
			pm_current_internal_seo_filter(filter_details);			
			jQuery('.section .current_internal_seo_filter .report_top_label h1').text(get_month_name(current_month.toString(), 'true') +" "+ current_year);
			
			jQuery('.current_internal_seo_filter .previous_arrow').click(function(){
				var current_year = jQuery('.current_internal_seo_filter .current_year').val();
				var current_month = jQuery('.current_internal_seo_filter .current_month').val();
				if(current_month == 01){
					var filter_month = 12;
					var filter_year = parseInt(current_year) - 1;
					}else{
					var filter_month = parseInt(current_month) - 1;
					var filter_year = current_year;
				}
				var filter_details = filter_year +"_"+ filter_month;
				pm_current_internal_seo_filter(filter_details);
				jQuery('.current_internal_seo_filter .current_year').val(filter_year);
				jQuery('.current_internal_seo_filter .current_month').val(filter_month);				
				jQuery('.section .current_internal_seo_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
			});
			
			jQuery('.current_internal_seo_filter .next_arrow').click(function(){
				var current_year = jQuery('.current_internal_seo_filter .current_year').val();
				var current_month = jQuery('.current_internal_seo_filter .current_month').val();
				if(current_month == 12){
					var filter_month = 01;
					var filter_year = parseInt(current_year) + 1;
					}else{
					var filter_month = parseInt(current_month) + 1;
					var filter_year = current_year;
				}
				var filter_details = filter_year +"_"+ filter_month;
				pm_current_internal_seo_filter(filter_details);
				jQuery('.current_internal_seo_filter .current_year').val(filter_year);
				jQuery('.current_internal_seo_filter .current_month').val(filter_month);
				jQuery('.section .current_internal_seo_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
			});
		}
	});
});
function pm_current_internal_seo_filter(filter_details){
	jQuery('.current_internal_seo_filter_loader').show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'filter_details' : filter_details,
			'type' : 'pm_current_internal_seo_filter'
		},
		success: function (data) {
			jQuery('.current_internal_seo_container').empty();
			var parsed = jQuery.parseJSON(data);
			jQuery.each( parsed.current_internal_seo_filter_details, function(key, internal_seo_filter_details) {
				var internal_seo_filter_details_split = internal_seo_filter_details.split('_');
				var project_id = internal_seo_filter_details_split[0];
				var project_client = internal_seo_filter_details_split[1];
				var project_name = internal_seo_filter_details_split[2];
				var timesheet_hour_decimal = internal_seo_filter_details_split[3];
				var monthly_plan_hour  = internal_seo_filter_details_split[4];
				var total_year_hours = internal_seo_filter_details_split[5];
				var monthly_budget = internal_seo_filter_details_split[6];
				var project_expenses = internal_seo_filter_details_split[7];
				var revenue = internal_seo_filter_details_split[8];
				var revenue_class = internal_seo_filter_details_split[9];
				var project_description = internal_seo_filter_details_split[10];
				if(revenue_class == 'redbg'){
					revenue_class = 'red_bg';
					}else if(revenue_class == 'greenbg'){
					revenue_class = 'green_bg';
				}
				jQuery('.current_internal_seo_container').append('<div id="display_note_'+project_id+'" class="display_note display_list hide_list_'+project_id+'">'
				+'<div class="info_div">'
				+'<div class="buttons column">'
				+'<div id="edit_'+project_id+'" class="button_2 modal_form_edit">E</div>'
				+'<div id="archive_'+project_id+'" class="button_2 modal_form_archive">A</div>'
				+'<div id="delete_'+project_id+'" class="button_2 modal_form_delete">D</div>'
				+'<div style="display:none;" id="loader_'+project_id+'" class="loader"></div>'
				+'</div>'
				+'<p id="first_column_'+project_id+'" class="first_column column">'+project_client+'</p>'
				+'<p id="second_column_'+project_id+'" class="second_column column">'+project_name+'</p>'
				+'<p id="third_column_'+project_id+'" class="third_column column">'+timesheet_hour_decimal+'</p>'
				+'<p id="fourth_column_'+project_id+'" class="fourth_column column">'+monthly_plan_hour+'</p>'
				+'<p id="fifth_column_'+project_id+'" class="fifth_column column">'+total_year_hours+'</p>'
				+'<p id="sixth_column_'+project_id+'" class="sixth_column column">'+monthly_budget+'</p>'
				+'<p id="seventh_column_'+project_id+'" class="seventh_column column">'+project_expenses+'</p>'
				+'<p id="eighth_column_'+project_id+'" class="eighth_column column '+revenue_class+'">'+revenue+'</p>'
				+'</div>'
				+'<div style="display:none" id="project_notes_'+project_id+'" class="project_notes">'
				+'<p style="float:left"><strong>'+project_client+':&nbsp</strong></p>'
				+'<p style="float:left">'+project_description+'</p>'
				+'</div>'
				+'</div>'
				);
			});
			trigger_note_display();
			jQuery('.current_internal_seo_filter_loader').hide();	
		},
		error: function (data) {
			alert('error');
		}				
	});
}
/* END custom_report_project_management.php CURRENT INTERNAL SEO FILTER */

/* custom_report_project_management.php CURRENT CUSTOMERS ISSUES / BUGS */
jQuery(document).ready(function(){
	jQuery('.current_issue_bug_filter .default_arrow_container .previous_arrow').click(function(){		
		var current_year = jQuery('.current_issue_bug_filter .current_year').val();
		var current_month = jQuery('.current_issue_bug_filter .current_month').val();
		if(current_month == 01){
			var filter_month = 12;
			var filter_year = parseInt(current_year) - 1;
			}else{
			var filter_month = parseInt(current_month) - 1;
			var filter_year = current_year;
		}
		var filter_details = filter_year +"_"+ filter_month;
		pm_current_issue_bug_filter(filter_details);
		jQuery('.current_issue_bug_filter .current_year').val(filter_year);
		jQuery('.current_issue_bug_filter .current_month').val(filter_month);				
		jQuery('.section .current_issue_bug_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
	});
	
	jQuery('.current_issue_bug_filter .default_arrow_container .next_arrow').click(function(){
		var current_year = jQuery('.current_issue_bug_filter .current_year').val();
		var current_month = jQuery('.current_issue_bug_filter .current_month').val();
		if(current_month == 12){
			var filter_month = 01;
			var filter_year = parseInt(current_year) + 1;
			}else{
			var filter_month = parseInt(current_month) + 1;
			var filter_year = current_year;
		}
		var filter_details = filter_year +"_"+ filter_month;
		pm_current_issue_bug_filter(filter_details);
		jQuery('.current_issue_bug_filter .current_year').val(filter_year);
		jQuery('.current_issue_bug_filter .current_month').val(filter_month);
		jQuery('.section .current_issue_bug_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
	});
	
	jQuery('.current_issue_bug_filter .current_issue_bug_filter_select').change(function(){
		var filter_type = jQuery(this).val();
		if(filter_type == 'Year'){
			jQuery('.current_issue_bug_filter .default_arrow_container').hide();
			jQuery('.current_issue_bug_filter .arrow_container').show();
			var current_year = jQuery('.current_issue_bug_filter .current_year').val();
			var filter_details = current_year +"_"+ 'null';
			pm_current_issue_bug_filter(filter_details);
			jQuery('.section .current_issue_bug_filter .report_top_label h1').text(current_year);
			
			jQuery('.current_issue_bug_filter .previous_arrow').click(function(){
				var current_year = jQuery('.current_issue_bug_filter .current_year').val();
				var filter_year = parseInt(current_year) - 1;
				var filter_details = filter_year +"_"+ 'null';
				pm_current_issue_bug_filter(filter_details);
				jQuery('.current_issue_bug_filter .current_year').val(filter_year);
				jQuery('.section .current_issue_bug_filter .report_top_label h1').text(filter_year);
			});
			
			jQuery('.current_issue_bug_filter .next_arrow').click(function(){
				var current_year = jQuery('.current_issue_bug_filter .current_year').val();
				var filter_year = parseInt(current_year) + 1;
				var filter_details = filter_year +"_"+ 'null';
				pm_current_issue_bug_filter(filter_details);
				jQuery('.current_issue_bug_filter .current_year').val(filter_year);
				jQuery('.section .current_issue_bug_filter .report_top_label h1').text(filter_year);
			});
		}
		if(filter_type == 'Month'){
			jQuery('.current_issue_bug_filter .default_arrow_container').hide();
			jQuery('.current_issue_bug_filter .arrow_container').show();
			var current_year = jQuery('.current_issue_bug_filter .current_year').val();
			var current_month = jQuery('.current_issue_bug_filter .current_month').val();
			var filter_details = current_year +"_"+ current_month;
			pm_current_issue_bug_filter(filter_details);			
			jQuery('.section .current_issue_bug_filter .report_top_label h1').text(get_month_name(current_month.toString(), 'true') +" "+ current_year);
			
			jQuery('.current_issue_bug_filter .previous_arrow').click(function(){
				var current_year = jQuery('.current_issue_bug_filter .current_year').val();
				var current_month = jQuery('.current_issue_bug_filter .current_month').val();
				if(current_month == 01){
					var filter_month = 12;
					var filter_year = parseInt(current_year) - 1;
					}else{
					var filter_month = parseInt(current_month) - 1;
					var filter_year = current_year;
				}
				var filter_details = filter_year +"_"+ filter_month;
				pm_current_issue_bug_filter(filter_details);
				jQuery('.current_issue_bug_filter .current_year').val(filter_year);
				jQuery('.current_issue_bug_filter .current_month').val(filter_month);				
				jQuery('.section .current_issue_bug_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
			});
			
			jQuery('.current_issue_bug_filter .next_arrow').click(function(){
				var current_year = jQuery('.current_issue_bug_filter .current_year').val();
				var current_month = jQuery('.current_issue_bug_filter .current_month').val();
				if(current_month == 12){
					var filter_month = 01;
					var filter_year = parseInt(current_year) + 1;
					}else{
					var filter_month = parseInt(current_month) + 1;
					var filter_year = current_year;
				}
				var filter_details = filter_year +"_"+ filter_month;
				pm_current_issue_bug_filter(filter_details);
				jQuery('.current_issue_bug_filter .current_year').val(filter_year);
				jQuery('.current_issue_bug_filter .current_month').val(filter_month);
				jQuery('.section .current_issue_bug_filter .report_top_label h1').text(get_month_name(filter_month.toString(), 'false') +" "+ filter_year);
			});
		}
	});
});
function pm_current_issue_bug_filter(filter_details){
	jQuery('.current_issue_bug_filter_loader').show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'filter_details' : filter_details,
			'type' : 'pm_current_issue_bug_filter'
		},
		success: function (data) {
			jQuery('.current_issue_bug_container').empty();
			var parsed = jQuery.parseJSON(data);
			jQuery.each( parsed.current_issue_bug_filter_details, function(key, issue_bug_filter_details) {
				var issue_bug_filter_details_split = issue_bug_filter_details.split('_');
				var project_id = issue_bug_filter_details_split[0];
				var project_client = issue_bug_filter_details_split[1];
				var project_name = issue_bug_filter_details_split[2];
				var project_start_date = issue_bug_filter_details_split[3];
				var project_days_in_production  = issue_bug_filter_details_split[4];
				var project_estimated_deadline = issue_bug_filter_details_split[5];
				var project_estimated_deadline_class = issue_bug_filter_details_split[6];
				var total_hour_decimal = issue_bug_filter_details_split[7];
				var revenue = issue_bug_filter_details_split[8];
				var revenue_class = issue_bug_filter_details_split[9];
				var current_expense = issue_bug_filter_details_split[10];
				var project_responsible_worker = issue_bug_filter_details_split[11];
				var project_current_status = issue_bug_filter_details_split[12];
				var project_description = issue_bug_filter_details_split[13];
				if(project_estimated_deadline_class == 'redbg'){
					project_estimated_deadline_class = 'red_bg';
					}else if(project_estimated_deadline_class == 'greenbg'){
					project_estimated_deadline_class = 'green_bg';
				}
				if(revenue_class == 'redbg'){
					revenue_class = 'red_bg';
					}else if(revenue_class == 'greenbg'){
					revenue_class = 'green_bg';
				}
				jQuery('.current_issue_bug_container').append('<div id="display_note_'+project_id+'" class="display_note display_list hide_list_'+project_id+'">'
				+'<div class="info_div">'
				+'<div class="buttons column">'
				+'<div id="edit_'+project_id+'" class="button_2 modal_form_edit">E</div>'
				+'<div id="archive_'+project_id+'" class="button_2 modal_form_archive">A</div>'
				+'<div id="delete_'+project_id+'" class="button_2 modal_form_delete">D</div>'
				+'<div style="display:none;" id="loader_'+project_id+'" class="loader"></div>'
				+'</div>'
				+'<p id="first_column_'+project_id+'" class="first_column column">'+project_client+'</p>'
				+'<p id="second_column_'+project_id+'" class="second_column column">'+project_name+'</p>'
				+'<p id="third_column_'+project_id+'" class="third_column column">'+project_start_date+'</p>'
				+'<p id="fourth_column_'+project_id+'" class="fourth_column column">'+project_days_in_production+'</p>'
				+'<p id="fifth_column_'+project_id+'" class="fifth_column column '+project_estimated_deadline_class+'">'+project_estimated_deadline+'</p>'
				+'<p id="sixth_column_'+project_id+'" class="sixth_column column">'+total_hour_decimal+'</p>'
				+'<p id="seventh_column_'+project_id+'" class="seventh_column column '+revenue_class+'">'+revenue+'</p>'
				+'<p id="eighth_column_'+project_id+'" class="eighth_column column">'+current_expense+'</p>'
				+'<p id="ninth_column_'+project_id+'" class="ninth_column column">'+project_responsible_worker+'</p>'
				+'<p id="tenth_column_'+project_id+'" class="tenth_column column">'+project_current_status+'</p>'
				+'</div>'
				+'<div style="display:none" id="project_notes_'+project_id+'" class="project_notes">'
				+'<p style="float:left"><strong>'+project_client+':&nbsp</strong></p>'
				+'<p style="float:left">'+project_description+'</p>'
				+'</div>'
				+'</div>'
				);
			});
			trigger_note_display();
			jQuery('.current_issue_bug_filter_loader').hide();	
		},
		error: function (data) {
			alert('error');
		}				
	});
}
/* END custom_report_project_management.php CURRENT CUSTOMERS ISSUES / BUGS */
/* ========================================================================================================== */



/* FORM DEFAULT VARIABLE */
jQuery(document).ready(function(){	
	jQuery('.submit_task_name_suffix').keyup(function(){
		var word = this.value;		
		if (word.toLowerCase().indexOf("%month%") >= 0){
			var month_name = jQuery('#current_month').val();
			var month_replace = jQuery(this).val();
			month_replace = month_replace.replace("%month%", month_name);
			jQuery(this).val(month_replace);
			jQuery('.submit_task_name_suffix_time').val('%month%_' + month_name);
		}
		if (word.toLowerCase().indexOf("%year%") >= 0){
			var year = jQuery('#current_year').val();
			var year_replace = jQuery(this).val();
			year_replace = year_replace.replace("%year%", year);
			jQuery(this).val(year_replace);
			jQuery('.submit_task_name_suffix_time').val('%year%_' + year);
		}
		if (word.toLowerCase().indexOf("%week%") >= 0){
			var week = jQuery('#current_week').val();
			var week_replace = jQuery(this).val();
			week_replace = week_replace.replace("%week%", week);
			jQuery(this).val(week_replace);
			jQuery('.submit_task_name_suffix_time').val('%week%_' + week);
		}		
	});
});
function trigger_month_week_year_change(){
	jQuery('.submit_task_name_suffix').keyup(function(){
		var word = this.value;		
		if (word.toLowerCase().indexOf("%month%") >= 0){
			var month_name = jQuery('#current_month').val();
			var month_replace = jQuery(this).val();
			month_replace = month_replace.replace("%month%", month_name);
			jQuery(this).val(month_replace);
			jQuery('.submit_task_name_suffix_time').val('%month%_' + month_name);
		}
		if (word.toLowerCase().indexOf("%year%") >= 0){
			var year = jQuery('#current_year').val();
			var year_replace = jQuery(this).val();
			year_replace = year_replace.replace("%year%", year);
			jQuery(this).val(year_replace);
			jQuery('.submit_task_name_suffix_time').val('%year%_' + year);
		}
		if (word.toLowerCase().indexOf("%week%") >= 0){
			var week = jQuery('#current_week').val();
			var week_replace = jQuery(this).val();
			week_replace = week_replace.replace("%week%", week);
			jQuery(this).val(week_replace);
			jQuery('.submit_task_name_suffix_time').val('%week%_' + week);
		}		
	});
}
/* END FORM DEFAULT VARIABLE */

/* custom_add_project.php ADD PROJECT CATEGORY */
jQuery(document).ready(function(){
	jQuery('.add_project_name').click(function(){
		jQuery('.add_project_category_color').slideDown();
	});
	jQuery('.save_project_category_color').click(function(){
		var project_category = jQuery('.project_category').val();
		var project_color = jQuery('.project_color').val();
		var project_category_color = project_category +"_"+ project_color;
		
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'save_project_category_color',
				'project_category_color' : project_category_color				
			},
			success: function (data) {
				var proj_cat_col = data.split('_');
				var project_category = proj_cat_col[0];
				var trimmed = project_category.substring(1);
				jQuery('.project_name').prepend('<option selected>'+trimmed+'</option>');
				jQuery('.add_project_category_color').slideUp();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});

/* custom_add_project.php END ADD PROJECT CATEGORY */

/* custom_add_project.php ADD WEBSITE */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_website_add" ).dialog({
		autoOpen: false,
		width: 700,
		dialogClass: "dialog_form_website_add",
		modal: true,
		close: function() {
		}
	});
	jQuery('.add_website_url').click(function(){
		jQuery('#dialog_form_website_add').dialog('open');
	});
	jQuery('.save_website').click(function(){
		jQuery('.add_site_loader').show();
		var website_form = jQuery('#dialog_form_website_add #website').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'website_form_save',
				'website_form' : website_form				
			},
			success: function (data) {
				var site_url = jQuery.parseJSON(data);
				jQuery('.website_url').prepend('<option selected>'+site_url+'</option>');
				jQuery('.project_site_url').prepend('<option selected>'+site_url+'</option>');
				jQuery('#dialog_form_website_add').dialog('close');
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
function trigger_add_website(){
	jQuery( "#dialog_form_website_add" ).dialog({
		autoOpen: false,
		height: 390,
		width: 700,
		dialogClass: "dialog_form_website_add",
		modal: true,
		close: function() {
		}
	});
	jQuery('.add_website_url').click(function(){
		jQuery('#dialog_form_website_add').dialog('open');
		trigger_save_website();
	});
}
function trigger_save_website(){
	jQuery('.save_website').click(function(){
		jQuery('.add_site_loader').show();
		var website_form = jQuery('#dialog_form_website_add #website').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'website_form_save',
				'website_form' : website_form				
			},
			success: function (data) {
				var site_url = jQuery.parseJSON(data);
				jQuery('.website_url').prepend('<option selected>'+site_url+'</option>');
				jQuery('#dialog_form_website_add').dialog('close');
			},
			error: function (data) {
				alert('error');
			}
		});
	});
}
/* custom_add_project.php END ADD WEBSITE */

/* custom_add_website.php ADD WEBSITE */
jQuery(document).ready(function(){
	jQuery('.site_platform').change(function(){
		var platform_value = jQuery(this).val();		
		if(platform_value == 'Other'){
			jQuery('.add_other_platform').slideDown();
		}else{
			jQuery('.add_other_platform').slideUp();
		}
	});
});

/* custom_add_website.php END ADD WEBSITE */

/* custom_reports_time.php FILTER TIME */
jQuery(document).ready(function(){
	jQuery('.timeframe_navigation .month_previous').click(function(){
		prev_filter();
	});
	jQuery('.timeframe_navigation .month_next').click(function(){
		next_filter();
	});
	jQuery('#custom_filter').change(function(){
		jQuery('.timeframe_navigation .month_default').remove();
		jQuery('.timeframe_navigation .onchange').show();
		var timeframe = jQuery(this).val();
		var active_tab = jQuery('#tabs .tabs_li.active a').attr('href');

		if(timeframe == 'Month'){
			jQuery('#filter_details .filter_current_week').val('null');
		
			var current_month = jQuery('#filter_details .current_month').val();
			jQuery('#filter_details .filter_current_month').val(current_month);
			var current_year = jQuery('#filter_details .current_year').val();
			jQuery('#filter_details .filter_current_year').val(current_year);
			
			var week = jQuery('#filter_details .filter_current_week').val();
			var month = jQuery('#filter_details .filter_current_month').val();
			var year = jQuery('#filter_details .filter_current_year').val();			
			var filter_details = week +'_'+ month +'_'+ year +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ active_tab;
			filter_ajax_function(filter_details);		
		}
		if(timeframe == 'Week'){
			var current_week = jQuery('#filter_details .current_week').val();
			jQuery('#filter_details .filter_current_week').val(current_week);
			var current_month = jQuery('#filter_details .current_month').val();
			jQuery('#filter_details .filter_current_month').val(current_month);			
			var current_year = jQuery('#filter_details .current_year').val();
			jQuery('#filter_details .filter_current_year').val(current_year);
			
			var week = jQuery('#filter_details .filter_current_week').val();
			var month = jQuery('#filter_details .filter_current_month').val();
			var year = jQuery('#filter_details .filter_current_year').val();			
			var filter_details = week +'_'+ month +'_'+ year +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ active_tab;
			filter_ajax_function(filter_details);
		}
		if(timeframe == 'Year'){
			jQuery('#filter_details .filter_current_week').val('null');
			jQuery('#filter_details .filter_current_month').val('null');
			var current_year = jQuery('#filter_details .current_year').val();
			jQuery('#filter_details .filter_current_year').val(current_year);
			
			var week = jQuery('#filter_details .filter_current_week').val();
			var month = jQuery('#filter_details .filter_current_month').val();
			var year = jQuery('#filter_details .filter_current_year').val();			
			var filter_details = week +'_'+ month +'_'+ year +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ active_tab;
			filter_ajax_function(filter_details);			
		}
		if(timeframe == 'Quarter'){
			var current_month = jQuery('#filter_details .current_month').val();
			jQuery('#filter_details .filter_current_month').val(current_month);
			var current_year = jQuery('#filter_details .current_year').val();
			jQuery('#filter_details .filter_current_year').val(current_year);
			
			var month = jQuery('#filter_details .filter_current_month').val();
			var year = jQuery('#filter_details .filter_current_year').val();
			var from_month_format = parseInt(month) - 2;
			var from_month_count = from_month_format.toString().length;
			var from_month = (from_month_count == 1) ? '0' + from_month_format : from_month_format;
			var set_month_format = parseInt(from_month) + 1;
			var set_month_count = set_month_format.toString().length;
			var set_month = (set_month_count == 1) ? '0' + set_month_format : set_month_format;
			jQuery('#filter_details .filter_current_month').val(set_month);
			var to_month = month;
			var filter_details = 'null' +'_'+ 'null' +'_'+ year +'_'+ from_month +'_'+ to_month +'_'+ 'null' +'_'+ 'null' +'_'+ active_tab;
			filter_ajax_function(filter_details);			
		}
		
		jQuery('.custom_date_filter .from_date').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy',
			firstDay: 1
		});	
		jQuery('.custom_date_filter .to_date').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy',
			firstDay: 1
		});
		
		if(timeframe == 'Custom'){
			jQuery('.custom_date_filter').slideDown();
		}else{
			jQuery('.custom_date_filter').slideUp();
		}
		jQuery('.custom_date_filter_go').click(function(){
			var from_date = jQuery('.custom_date_filter .from_date').val();
			var to_date = jQuery('.custom_date_filter .to_date').val();
			var filter_details = 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ from_date +'_'+ to_date +'_'+ active_tab;
			var report_sorting_type = jQuery('#filter_sorting_type').val();
			filter_ajax_function(filter_details);
		});
	});
	
	jQuery('.timeframe_navigation .nav_previous').click(function(){
		prev_filter();
	});
	jQuery('.timeframe_navigation .nav_next').click(function(){
		next_filter();
	});
	
});

function prev_filter(){
	timeframe = jQuery('#custom_filter').val();
	var week = jQuery('#filter_details .filter_current_week').val();
	var month = jQuery('#filter_details .filter_current_month').val();
	var year = jQuery('#filter_details .filter_current_year').val();
	var report_sorting_type = jQuery('#filter_sorting_type').val();

	
	if(timeframe == 'Month'){
		if(month == '01'){
			month = '13';
			year = parseInt(year) - 1;
			jQuery('#filter_details .filter_current_year').val(year);
		}
		var month_format = parseInt(month) - 1;
		var month_count = month_format.toString().length;
		var month_number = (month_count == 1) ? '0' + month_format : month_format;
		jQuery('#filter_details .filter_current_month').val(month_number);
	}else{
		var month_number = month;
	}	
	
	if(timeframe == 'Week'){
		if(week == '1'){
			year = parseInt(year) - 1;
			jQuery('#filter_details .filter_current_year').val(year);			
		}
		var week_number = parseInt(week) - 1;
		jQuery('#filter_details .filter_current_week').val(week_number);
		if(week_number == '0'){			
			var filter_year = jQuery('#filter_details .filter_current_year').val();
			week_number = weeksInYear(filter_year);
			jQuery('#filter_details .filter_current_week').val(week_number);
		}
	}else{
		var week_number = 'null';
	}
	
	if(timeframe == 'Year'){
		var year_number = parseInt(year) - 1;
		jQuery('#filter_details .filter_current_year').val(year_number);
	}else{
		var year_number = year;
	}
	
	if(timeframe == 'Quarter'){
		var week_number = 'null';
		var month_number = 'null';
		var set_month_format = parseInt(month) - 3;
		if(set_month_format > 0){
			var from_month_format = parseInt(set_month_format) - 1;
			var from_month_count = from_month_format.toString().length;
			var from_month = (from_month_count == 1) ? '0' + from_month_format : from_month_format;
			var to_month_format = parseInt(set_month_format) + 1;
			var to_month_count = to_month_format.toString().length;
			var to_month = (to_month_count == 1) ? '0' + to_month_format : to_month_format;
			jQuery('#filter_details .filter_current_month').val(set_month_format);
		}else{
			switch (set_month_format) {
				case 0:
					set_month_format = '12';
				break;
				case -1:
					set_month_format = '11';
				break;
				case -2:
					set_month_format = '10';
				break;
				case -3:
					set_month_format = '09';
				break;
				case -4:
					set_month_format = '08';
				break;
				case -5:
					set_month_format = '07';
				break;
				case -6:
					set_month_format = '06';
				break;
				case -7:
					set_month_format = '05';
				break;
				case -8:
					set_month_format = '04';
				break;
				case -9:
					set_month_format = '03';
				break;
				case -10:
					set_month_format = '02';
				break;
				case -11:
					set_month_format = '01';
				break;		
			} 
			var from_month_format = parseInt(set_month_format) - 1;
			var from_month_count = from_month_format.toString().length;
			var from_month = (from_month_count == 1) ? '0' + from_month_format : from_month_format;
			var to_month_format = parseInt(set_month_format) + 1;
			var to_month_count = to_month_format.toString().length;
			var to_month = (to_month_count == 1) ? '0' + to_month_format : to_month_format;
			jQuery('#filter_details .filter_current_month').val(set_month_format);
			var year_number = parseInt(year) - 1;
			jQuery('#filter_details .filter_current_year').val(year_number);
		}
	}else{		
		var from_month = 'null';
		var to_month = 'null';
	}
	
	var filter_details = week_number +'_'+ month_number +'_'+ year_number +'_'+ from_month +'_'+ to_month +'_'+ 'null' +'_'+ 'null';
	filter_ajax_function(filter_details, report_sorting_type);
}
function next_filter(){
	timeframe = jQuery('#custom_filter').val();
	var week = jQuery('#filter_details .filter_current_week').val();
	var month = jQuery('#filter_details .filter_current_month').val();
	var year = jQuery('#filter_details .filter_current_year').val();
	var report_sorting_type = jQuery('#filter_sorting_type').val();
	
	if(timeframe == 'Month'){
		if(month == '12'){
			month = '00';
			year = parseInt(year)+ 1;
			jQuery('#filter_details .filter_current_year').val(year);
		}
		var month_format = parseInt(month) + 1;
		var month_count = month_format.toString().length;
		var month_number = (month_count == 1) ? '0' + month_format : month_format;
		jQuery('#filter_details .filter_current_month').val(month_number);
		}else{
		var month_number = month;
	}
	
	if(timeframe == 'Week'){
		var week_number = parseInt(week) + 1;
		jQuery('#filter_details .filter_current_week').val(week_number);
		var current_year = jQuery('#filter_details .filter_current_year').val();		
		var current_total_week = weeksInYear(current_year);
		if(week == current_total_week){
			year = parseInt(current_year) + 1;
			var week_number = 1;
			jQuery('#filter_details .filter_current_year').val(year);
			jQuery('#filter_details .filter_current_week').val(week_number);			
		}
	}else{
		var week_number = 'null';
	}
	
	if(timeframe == 'Year'){
		var year_number = parseInt(year) + 1;
		jQuery('#filter_details .filter_current_year').val(year_number);
	}else{
		var year_number = year;
	}
	
	if(timeframe == 'Quarter'){
		var week_number = 'null';
		var month_number = 'null';
		var set_month_format = parseInt(month) + 3;
		if(set_month_format < 12){
			var from_month_format = parseInt(set_month_format) - 1;
			var from_month_count = from_month_format.toString().length;
			var from_month = (from_month_count == 1) ? '0' + from_month_format : from_month_format;
			var to_month_format = parseInt(set_month_format) + 1;
			var to_month_count = to_month_format.toString().length;
			var to_month = (to_month_count == 1) ? '0' + to_month_format : to_month_format;
			jQuery('#filter_details .filter_current_month').val(set_month_format);
		}else{
		switch (set_month_format) {
				case 13:
					set_month_format = '1';
				break;
				case 14:
					set_month_format = '2';
				break;
				case 15:
					set_month_format = '3';
				break;
				case 16:
					set_month_format = '4';
				break;
				case 17:
					set_month_format = '5';
				break;
				case 18:
					set_month_format = '6';
				break;
				case 19:
					set_month_format = '7';
				break;
				case 20:
					set_month_format = '8';
				break;
				case 21:
					set_month_format = '9';
				break;
				case 22:
					set_month_format = '10';
				break;
				case 23:
					set_month_format = '11';
				break;
				case 24:
					set_month_format = '12';
				break;		
			} 
			var from_month_format = parseInt(set_month_format) - 1;
			var from_month_count = from_month_format.toString().length;
			var from_month = (from_month_count == 1) ? '0' + from_month_format : from_month_format;
			var to_month_format = parseInt(set_month_format) + 1;
			var to_month_count = to_month_format.toString().length;
			var to_month = (to_month_count == 1) ? '0' + to_month_format : to_month_format;
			jQuery('#filter_details .filter_current_month').val(set_month_format);
			var year_number = parseInt(year) + 1;
			jQuery('#filter_details .filter_current_year').val(year_number);
		}		
	}else{		
		var from_month = 'null';
		var to_month = 'null';
	}	
	
	var filter_details = week_number +'_'+ month_number +'_'+ year_number +'_'+ from_month +'_'+ to_month +'_'+ 'null' +'_'+ 'null';
	filter_ajax_function(filter_details, report_sorting_type);
}
function filter_ajax_function(filter_details, report_sorting_type){
	jQuery('.top_detail_loader').show();	
	jQuery('.tab_loader').show();



	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'report_time_filter_top',
			'filter_details' : filter_details				
		},
		success: function (data) {
			jQuery('.loader').hide();
			var parsed = jQuery.parseJSON(data);			
			var report_top_label = parsed.report_top_label;
			jQuery('.report_container .report_top_label h1').text(report_top_label);
			
			var top_report_detail = parsed.top_report_detail;

			console.log(top_report_detail);
			var top_report_detail_split = top_report_detail.split("_");
			var top_hours_tracked = top_report_detail_split[0];
			var top_billable_hours = top_report_detail_split[1];
			var top_ledig_hours = top_report_detail_split[2];
			var top_unbillable_hours = top_report_detail_split[3];
			var top_billable_amount = top_report_detail_split[4];
			var top_no_work = top_report_detail_split[5];
			var top_dwork_percent = top_report_detail_split[6];

			var total_bill_amount = (top_billable_amount == 0 || top_billable_amount == "")? 0 :  top_billable_amount;
			jQuery('.report_container .top_reports h1.top_hours_tracked').html(top_hours_tracked);
			jQuery('.report_container .top_reports h1.top_billable_amount').html("kr "+top_billable_amount);
			jQuery('.report_container .top_reports h1.top_dwork_hours_percent').html(top_dwork_percent+"%");
			jQuery('.report_container .top_reports h1.top_ledig_hours').html(top_no_work);
			jQuery('.report_container .top_reports h1.top_unbillable_hours').html(top_unbillable_hours);
		},		
		error: function (data) {
			alert('error');
		}
	});
	
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'report_time_filter_client',
			'filter_details' : filter_details				
		},
		success: function (data) {
			jQuery('.client_detail_loader').hide();
			jQuery('#clients .sort_name_container').empty();
			var parsed = jQuery.parseJSON(data);
			var client_tab_counter = 1;
			jQuery.each(parsed.client_details, function(index, value){
				var client_details_split = value.split("_");
				var client_name = client_details_split[0];
				var total_client_hours = client_details_split[1];
				var billable_total_hour_decimal = client_details_split[2];
				var total_billable_amount = client_details_split[3];
				var unbillable_total_hour_decimal = client_details_split[4];
				var total_unbillable_amount = client_details_split[5];
				
				jQuery('#clients .sort_name_container').append('<div id="info_div_'+client_tab_counter+'" class="info_div">'
				+'<div class="first_column"><li>'+client_name+'</li></div>'
				+'<div class="second_column"><li>'+total_client_hours+'</li></div>'
				+'<div class="third_column"><li>'+billable_total_hour_decimal+'</li></div>'
				+'<div class="fourth_column"><li>'+unbillable_total_hour_decimal+'</li></div>'
				+'<div class="fifth_column"><li>'+total_billable_amount+'</li></div>'
				+'<div class="sixth_column"><li>'+total_unbillable_amount+'</li></div>'
				+'</div>');
				
				client_tab_counter++;
			});
			jQuery('#clients .info_div_total .second_column p').text(parsed.client_tab_total_hour);
			jQuery('#clients .info_div_total .third_column p').text(parsed.client_tab_total_billable_hour);
			jQuery('#clients .info_div_total .fourth_column p').text(parsed.client_tab_total_unbillable_hour);
			jQuery('#clients .info_div_total .fifth_column p').text(parsed.client_tab_total_billable_amount);
			jQuery('#clients .info_div_total .sixth_column p').text(parsed.client_tab_total_unbillable_amount);

		},		
		error: function (data) {
			alert('error');
		}
	});

	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'report_time_filter_project',
			'filter_details' : filter_details				
		},
		success: function (data) {
			jQuery('.project_detail_loader').hide();
			jQuery('#projects .sort_name_container').empty();
			var parsed = jQuery.parseJSON(data);
			var project_tab_counter = 1; 
			jQuery.each(parsed.project_details, function(index, value){
				var project_details_split = value.split("_");
				var project_name_title = project_details_split[0];
				var project_client_name = project_details_split[1];
				var total_project_hour = project_details_split[2];
				var billable_total_hour_decimal = project_details_split[3];
				var unbillable_total_hour_decimal = project_details_split[5];
				var total_billable_amount = project_details_split[4];
				var total_unbillable_amount = project_details_split[6];
				
				jQuery('#projects .sort_name_container').append('<div id="info_div_'+project_tab_counter+'" class="info_div">'
				+'<div class="first_column"><li>'+project_name_title+'</li></div>'
				+'<div class="second_column"><li>'+project_client_name+'</li></div>'
				+'<div class="third_column"><li>'+total_project_hour+'</li></div>'
				+'<div class="fourth_column"><li>'+billable_total_hour_decimal+'</li></div>'
				+'<div class="fifth_column"><li>'+unbillable_total_hour_decimal+'</li></div>'
				+'<div class="sixth_column"><li>'+total_billable_amount+'</li></div>'
				+'<div class="seventh_column"><li>'+total_unbillable_amount+'</li></div>'
				+'</div>');
					
				project_tab_counter++;
			});
			jQuery('#projects .info_div_total .third_column p').text(parsed.project_tab_total_hour);
			jQuery('#projects .info_div_total .fourth_column p').text(parsed.project_tab_total_billable_hour);
			jQuery('#projects .info_div_total .fifth_column p').text(parsed.project_tab_total_unbillable_hour);
			jQuery('#projects .info_div_total .sixth_column p').text(parsed.project_tab_total_billable_amount);
			jQuery('#projects .info_div_total .seventh_column p').text(parsed.project_tab_total_unbillable_amount);
		},		
		error: function (data) {
			alert('error');
		}
	});
	
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'report_time_filter_task',
			'filter_details' : filter_details				
		},
		success: function (data) {
			jQuery('.task_detail_loader').hide();
			jQuery('#tasks .sort_name_container').empty();
			var parsed = jQuery.parseJSON(data);
			var task_tab_counter = 1;
			jQuery.each(parsed.task_details, function(index, value){
				var task_details_split = value.split("_");
				var task_name_title = task_details_split[0];
				var total_task_hour = task_details_split[1];
				var billable_total_hour_decimal = task_details_split[2];
				var unbillable_total_hour_decimal = task_details_split[4]
				var total_billable_amount = task_details_split[3];
				var total_unbillable_amount = task_details_split[5];

				jQuery('#tasks .sort_name_container').append('<div id="info_div_'+task_tab_counter+'" class="info_div">'
				+'<div class="first_column"><li>'+task_name_title+'</li></div>'
				+'<div class="second_column"><li>'+total_task_hour+'</li></div>'
				+'<div class="third_column"><li>'+billable_total_hour_decimal+'</li></div>'
				+'<div class="fourth_column"><li>'+unbillable_total_hour_decimal+'</li></div>'
				+'<div class="fifth_column"><li>'+total_billable_amount+'</li></div>'
				+'<div class="sixth_column"><li>'+total_unbillable_amount+'</li></div>'
				+'</div>');
				
				task_tab_counter++;
			});
			jQuery('#tasks .info_div_total .second_column p').text(parsed.task_tab_total_hour);
			jQuery('#tasks .info_div_total .third_column p').text(parsed.task_tab_total_billable_hour);
			jQuery('#tasks .info_div_total .fourth_column p').text(parsed.task_tab_total_unbillable_hour);
			jQuery('#tasks .info_div_total .fifth_column p').text(parsed.task_tab_total_billable_amount);
			jQuery('#tasks .info_div_total .sixth_column p').text(parsed.task_tab_total_unbillable_amount);
		},		
		error: function (data) {
			alert('error');
		}
	});
	
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'report_time_filter_staff',
			'filter_details' : filter_details				
		},
		success: function (data) {
			jQuery('.staff_detail_loader').hide();
			jQuery('#staff .sort_name_container').empty();
			var parsed = jQuery.parseJSON(data);
			console.log(parsed);
			var staff_tab_counter = 1;
			jQuery.each(parsed.person_details, function(index, value){

				var person_details_split = value.split("_");
				var person_name_title = person_details_split[0];
				var total_person_hour = person_details_split[1];
				var total_dwork_hour = person_details_split[2];
				var billable_total_hour_decimal = person_details_split[3];
				var unbillable_total_hour_decimal = person_details_split[4];
				var total_billable_amount = person_details_split[5];
				var legdig_total_hour_decimal = person_details_split[6];
				var holiday_total_hour_decimal = person_details_split[7];
				var vacation_total_hour_decimal = person_details_split[8];
				var sickness_total_hour_decimal = person_details_split[9];
				var Dworkpercent = person_details_split[10];
				
				jQuery('#staff .sort_name_container').append('<div id="info_div_'+staff_tab_counter+'" class="info_div">'
				+'<div class="first_column"><li>'+person_name_title+'</li></div>'
				+'<div class="second_column"><li>'+total_person_hour+'</li></div>'
				+'<div class="third_column"><li>'+total_dwork_hour+'</li></div>'
				+'<div class="fourth_column"><li>'+billable_total_hour_decimal+'</li></div>'
				+'<div class="fifth_column"><li>'+unbillable_total_hour_decimal+'</li></div>'
				+'<div class="sixth_column"><li>'+total_billable_amount+'</li></div>'
				+'<div class="seventh_column"><li>'+Dworkpercent+'%</li></div>'
				+'<div class="eight_column"><li>'+legdig_total_hour_decimal+'</li></div>'
				+'<div class="ninth_column"><li>'+holiday_total_hour_decimal+'</li></div>'
				+'<div class="tenth_column"><li>'+vacation_total_hour_decimal+'</li></div>'
				+'<div class="eleventh_column"><li>'+sickness_total_hour_decimal+'</li></div>'
				+'</div>');
				
				staff_tab_counter++;
			});
			jQuery('#staff .info_div_total .second_column p').text(parsed.person_tab_total_hour);
			jQuery('#staff .info_div_total .third_column p').text(parsed.person_tab_total_dwork_hour);
			jQuery('#staff .info_div_total .fourth_column p').text(parsed.person_tab_total_billable_hour);
			jQuery('#staff .info_div_total .fifth_column p').text(parsed.person_tab_total_unbillable_hour);
			jQuery('#staff .info_div_total .sixth_column p').text(parsed.person_tab_total_billable_amount);
			jQuery('#staff .info_div_total .seventh_column p').text(parsed.person_tab_total_dwork_pecent + '%');
			jQuery('#staff .info_div_total .eight_column p').text(parsed.person_tab_total_ledig_hour);
			jQuery('#staff .info_div_total .ninth_column p').text(parsed.person_tab_total_holiday_hour);
			jQuery('#staff .info_div_total .tenth_column p').text(parsed.person_tab_total_vacation_hour);
			jQuery('#staff .info_div_total .eleventh_column p').text(parsed.person_tab_total_sickness_hour);
			 jQuery('.report_container .top_reports h1.top_dwork_hours').html(parsed.person_tab_total_dwork_pecent+ '%');
			
		},		
		error: function (data) {
			alert('error');
		}
	});
}

/*  WAIT TILL ELEMENT EXIST */
(function ($) {		
	$.fn.waitUntilExists = function (handler, shouldRunHandlerOnce, isChild) {
		var found = 'found';
		var $this = $(this.selector);
		var $elements = $this.not(function () { return $(this).data(found); }).each(handler).data(found, true);
		if (!isChild) {
			(window.waitUntilExists_Intervals = window.waitUntilExists_Intervals || {})[this.selector] =
			window.setInterval(function () { $this.waitUntilExists(handler, shouldRunHandlerOnce, true); }, 500)
			;
		}
		else if (shouldRunHandlerOnce && $elements.length) {
			window.clearInterval(window.waitUntilExists_Intervals[this.selector]);
		}
		return $this;
	}
	
} (jQuery));
/*  END WAIT TILL ELEMENT EXIST */

/* SORT CLIENT ASC */
jQuery("div.tab_content.active .report_time_client_sort_asc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var report_client_sort = [];
		jQuery('.tab_content.active .project_client_sort_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();


			
			report_client_sort.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column +'_'+ info_div_id);			
		});
		report_client_sort.push("asc");
		
		jQuery('.report_time_client_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_client_sort',
				'report_client_sort' : report_client_sort				
			},
			success: function (data) {
				jQuery('.tab_content.active .project_client_sort_container').empty();
				jQuery('.report_time_client_sort_asc').hide();
				jQuery('.report_time_client_sort_desc').show();	
				var parsed = jQuery.parseJSON(data);
				var report_hour_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
				
					var project_name = hour_detail_split[0];
					var client_name = hour_detail_split[1];
					var hours = hour_detail_split[2];
					var billable_hours = hour_detail_split[3];	
					var unbillable_hours = hour_detail_split[4];	
					var billable_amount = hour_detail_split[5];	
					var unbillable_amount = hour_detail_split[6];
				
					jQuery('.tab_content.active .project_client_sort_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
					+'<div class="first_column"><li>'+project_name+'</li></div>'
					+'<div class="second_column"><li>'+client_name+'</li></div>'
					+'<div class="third_column"><li>'+hours+'</li></div>'
					+'<div class="fourth_column"><li>'+billable_hours+'</li></div>'
					+'<div class="fifth_column"><li>'+unbillable_hours+'</li></div>'
					+'<div class="sixth_column"><li>'+billable_amount+'</li></div>'
					+'<div class="seventh_column"><li>'+unbillable_amount+'</li></div>'
					+'</div>'
					);	
					report_hour_sort_count++;
				});
				jQuery('.report_time_client_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT CLIENT ASC */	

/* SORT CLIENT DESC */
jQuery("div.tab_content.active .report_time_client_sort_desc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var report_client_sort = [];
		jQuery('.tab_content.active .project_client_sort_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();
			
			report_client_sort.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column  +'_'+ ninth_column +'_'+ info_div_id);			
		});
		report_client_sort.push("desc");
		
		jQuery('.report_time_client_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_client_sort',
				'report_client_sort' : report_client_sort				
			},
			success: function (data) {
				jQuery('.tab_content.active .project_client_sort_container').empty();
				jQuery('.report_time_client_sort_asc').show();
				jQuery('.report_time_client_sort_desc').hide();	
				var parsed = jQuery.parseJSON(data);
				var report_hour_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var project_name = hour_detail_split[0];
					var client_name = hour_detail_split[1];
					var hours = hour_detail_split[2];
					var billable_hours = hour_detail_split[3];	
					var unbillable_hours = hour_detail_split[4];	
					var billable_amount = hour_detail_split[5];	
					var unbillable_amount = hour_detail_split[6];	
					jQuery('.tab_content.active .project_client_sort_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
					+'<div class="first_column"><li>'+project_name+'</li></div>'
					+'<div class="second_column"><li>'+client_name+'</li></div>'
					+'<div class="third_column"><li>'+hours+'</li></div>'
					+'<div class="fourth_column"><li>'+billable_hours+'</li></div>'
					+'<div class="fifth_column"><li>'+unbillable_hours+'</li></div>'
					+'<div class="sixth_column"><li>'+billable_amount+'</li></div>'
					+'<div class="seventh_column"><li>'+unbillable_amount+'</li></div>'
					+'</div>'
					);	
					report_hour_sort_count++;
				});
				jQuery('.report_time_client_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});	
/* END SORT CLIENT DESC */

/* SORT UNBILLABLE HOUR ASC */
jQuery("div.tab_content.active .report_unbillable_sort_asc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_unbillable = [];
		jQuery('.tab_content.active .project_hour_sort_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();
			
			report_time_sort_unbillable.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column  +'_'+ info_div_id +'_'+ tab_id +'_'+ ninth_column);			
		});
		report_time_sort_unbillable.push("asc");
		
		jQuery('.report_unbillable_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_unbillable_sort',
				'report_time_sort_unbillable' : report_time_sort_unbillable				
			},
			success: function (data) {
				jQuery('.tab_content.active .project_hour_sort_container').empty();
				jQuery('.report_unbillable_sort_asc').hide();
				jQuery('.report_unbillable_sort_desc').show();	
				var parsed = jQuery.parseJSON(data);
				var report_hour_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var tab_id = hour_detail_split[8];
					var ninth_column = hour_detail_split[9];
					
					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class=" first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					report_hour_sort_count++;
				});
				jQuery('.report_unbillable_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT UNBILLABLE HOUR ASC */


/* SORT UNBILLABLE HOUR DESC */
jQuery("div.tab_content.active .report_unbillable_sort_desc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_unbillable = [];
		jQuery('.tab_content.active .project_hour_sort_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();

			
			report_time_sort_unbillable.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column +'_'+ info_div_id +'_'+ tab_id +'_'+ninth_column);			
		});
		report_time_sort_unbillable.push("desc");
		jQuery('.report_unbillable_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_unbillable_sort',
				'report_time_sort_unbillable' : report_time_sort_unbillable				
			},
			success: function (data) {
				jQuery('.tab_content.active .project_hour_sort_container').empty();
				jQuery('.report_unbillable_sort_asc').show();
				jQuery('.report_unbillable_sort_desc').hide();	
				var parsed = jQuery.parseJSON(data);
				var report_hour_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var ninth_column = hour_detail_split[9];
					var tab_id = hour_detail_split[8];
					
					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					report_hour_sort_count++;
				});
				jQuery('.report_unbillable_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT BILLABLE HOUR DESC */


/* SORT BILLABLE HOUR ASC */
jQuery("div.tab_content.active .report_billable_sort_asc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_billable = [];
		jQuery('.tab_content.active .project_hour_sort_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();
			
			report_time_sort_billable.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column  +'_'+ info_div_id +'_'+ tab_id +'_'+ ninth_column);			
		});
		report_time_sort_billable.push("asc");
		
		jQuery('.report_billable_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_billable_sort',
				'report_time_sort_billable' : report_time_sort_billable				
			},
			success: function (data) {
				jQuery('.tab_content.active .project_hour_sort_container').empty();
				jQuery('.report_billable_sort_asc').hide();
				jQuery('.report_billable_sort_desc').show();	
				var parsed = jQuery.parseJSON(data);
				var report_hour_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var tab_id = hour_detail_split[8];
					var ninth_column = hour_detail_split[9];
					
					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class=" first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					report_hour_sort_count++;
				});
				jQuery('.report_billable_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT BILLABLE HOUR ASC */

/* SORT BILLABLE HOUR DESC */
jQuery("div.tab_content.active .report_billable_sort_desc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_billable = [];
		jQuery('.tab_content.active .project_hour_sort_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();

			
			report_time_sort_billable.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column +'_'+ info_div_id +'_'+ tab_id +'_'+ninth_column);			
		});
		report_time_sort_billable.push("desc");
		jQuery('.report_billable_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_billable_sort',
				'report_time_sort_billable' : report_time_sort_billable				
			},
			success: function (data) {
				jQuery('.tab_content.active .project_hour_sort_container').empty();
				jQuery('.report_billable_sort_asc').show();
				jQuery('.report_billable_sort_desc').hide();	
				var parsed = jQuery.parseJSON(data);
				var report_hour_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var ninth_column = hour_detail_split[9];
					var tab_id = hour_detail_split[8];
					
					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					report_hour_sort_count++;
				});
				jQuery('.report_billable_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT BILLABLE HOUR DESC */

/* SORT HOUR ASC */
jQuery("div.tab_content.active .report_hour_sort_asc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_hour = [];
		jQuery('.tab_content.active .project_hour_sort_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();
			
			report_time_sort_hour.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column  +'_'+ info_div_id +'_'+ tab_id +'_'+ ninth_column);			
		});
		report_time_sort_hour.push("asc");
		
		jQuery('.report_hour_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_hour_sort',
				'report_time_sort_hour' : report_time_sort_hour				
			},
			success: function (data) {
				jQuery('.tab_content.active .project_hour_sort_container').empty();
				jQuery('.report_hour_sort_asc').hide();
				jQuery('.report_hour_sort_desc').show();	
				var parsed = jQuery.parseJSON(data);
				var report_hour_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var tab_id = hour_detail_split[8];
					var ninth_column = hour_detail_split[9];
					
					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class=" first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					report_hour_sort_count++;
				});
				jQuery('.report_hour_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT HOUR ASC */

/* SORT HOUR DESC */
jQuery("div.tab_content.active .report_hour_sort_desc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_hour = [];
		jQuery('.tab_content.active .project_hour_sort_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();

			
			report_time_sort_hour.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column +'_'+ info_div_id +'_'+ tab_id +'_'+ninth_column);			
		});
		report_time_sort_hour.push("desc");
		jQuery('.report_hour_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_hour_sort',
				'report_time_sort_hour' : report_time_sort_hour				
			},
			success: function (data) {
				jQuery('.tab_content.active .project_hour_sort_container').empty();
				jQuery('.report_hour_sort_asc').show();
				jQuery('.report_hour_sort_desc').hide();	
				var parsed = jQuery.parseJSON(data);
				var report_hour_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var ninth_column = hour_detail_split[9];
					var tab_id = hour_detail_split[8];
					
					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_hour_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					report_hour_sort_count++;
				});
				jQuery('.report_hour_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT HOUR DESC */

/* SORT BILLABLE A ASC */
jQuery("div.tab_content.active .report_billable_a_sort_asc").waitUntilExists(function () {	
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_billable_a = [];
		jQuery('.tab_content.active .sort_name_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
		
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();
			
			report_time_sort_billable_a.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column   +'_'+ info_div_id +'_'+ tab_id +'_'+ ninth_column);			
		});
		report_time_sort_billable_a.push("asc");
		jQuery('.report_billable_a_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_billable_a_sort',
				'report_time_sort_billable_a' : report_time_sort_billable_a				
			},
			success: function (data) {
				jQuery('.tab_content.active .sort_name_container').empty();
				jQuery('.report_billable_a_sort_asc').hide();
				jQuery('.report_billable_a_sort_desc').show();	
				var parsed = jQuery.parseJSON(data);
				var report_name_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var ninth_column = hour_detail_split[9];
					var tab_id = hour_detail_split[8];


					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					report_name_sort_count++;
				});
				jQuery('.report_billable_a_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT BILLABLE AMOUNT ASC */

/* SORT BILLABLE AMOUNT DESC */
jQuery("div.tab_content.active .report_billable_a_sort_desc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_billable_a = [];
		jQuery('.tab_content.active .sort_name_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();
		
			report_time_sort_billable_a.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column +'_'+ info_div_id +'_'+ tab_id +'_'+ ninth_column);			
		});
		report_time_sort_billable_a.push("desc");
		jQuery('.report_billable_a_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_billable_a_sort',
				'report_time_sort_billable_a' : report_time_sort_billable_a				
			},
			success: function (data) {
				jQuery('.tab_content.active .sort_name_container').empty();
				jQuery('.report_name_sort_asc').show();
				jQuery('.report_name_sort_desc').hide();	
				var parsed = jQuery.parseJSON(data);
				var report_name_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var tab_id = hour_detail_split[8];
					var ninth_column = hour_detail_split[9];
					// console.log(eight_column);
				
					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
				
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					report_name_sort_count++;
				});
				jQuery('.report_billable_a_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT BILLABLE AMOUNT DESC */

/* SORT BILLABLE A ASC */
jQuery("div.tab_content.active .report_unbillable_a_sort_asc").waitUntilExists(function () {	
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_unbillable_a = [];
		jQuery('.tab_content.active .sort_name_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
		
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();
			
			report_time_sort_unbillable_a.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column   +'_'+ info_div_id +'_'+ tab_id +'_'+ ninth_column);			
		});
		report_time_sort_unbillable_a.push("asc");
		jQuery('.report_unbillable_a_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_unbillable_a_sort',
				'report_time_sort_unbillable_a' : report_time_sort_unbillable_a				
			},
			success: function (data) {
				jQuery('.tab_content.active .sort_name_container').empty();
				jQuery('.report_unbillable_a_sort_asc').hide();
				jQuery('.report_unbillable_a_sort_desc').show();	
				var parsed = jQuery.parseJSON(data);
				var report_name_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var ninth_column = hour_detail_split[9];
					var tab_id = hour_detail_split[8];


					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					report_name_sort_count++;
				});
				jQuery('.report_unbillable_a_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT BILLABLE AMOUNT ASC */

/* SORT UNBILLABLE AMOUNT DESC */
jQuery("div.tab_content.active .report_unbillable_a_sort_desc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_unbillable_a = [];
		jQuery('.tab_content.active .sort_name_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();
		
			report_time_sort_unbillable_a.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column +'_'+ info_div_id +'_'+ tab_id +'_'+ ninth_column);			
		});
		report_time_sort_unbillable_a.push("desc");
		jQuery('.report_unbillable_a_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_unbillable_a_sort',
				'report_time_sort_unbillable_a' : report_time_sort_unbillable_a				
			},
			success: function (data) {
				jQuery('.tab_content.active .sort_name_container').empty();
				jQuery('.report_unbillable_sort_asc').show();
				jQuery('.report_unbillable_sort_desc').hide();	
				var parsed = jQuery.parseJSON(data);
				var report_name_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var tab_id = hour_detail_split[8];
					var ninth_column = hour_detail_split[9];
					// console.log(eight_column);
				
					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
				
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					report_name_sort_count++;
				});
				jQuery('.report_unbillable_a_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});

/* SORT NAME ASC */
jQuery("div.tab_content.active .report_name_sort_asc").waitUntilExists(function () {	
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_name = [];
		jQuery('.tab_content.active .sort_name_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
		
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();
			
			report_time_sort_name.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column   +'_'+ info_div_id +'_'+ tab_id +'_'+ ninth_column);			
		});
		report_time_sort_name.push("asc");
		jQuery('.report_name_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_name_sort',
				'report_time_sort_name' : report_time_sort_name				
			},
			success: function (data) {
				jQuery('.tab_content.active .sort_name_container').empty();
				jQuery('.report_name_sort_asc').hide();
				jQuery('.report_name_sort_desc').show();	
				var parsed = jQuery.parseJSON(data);
				var report_name_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var ninth_column = hour_detail_split[9];
					var tab_id = hour_detail_split[8];


					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					report_name_sort_count++;
				});
				jQuery('.report_name_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT NAME ASC */

/* SORT NAME DESC */
jQuery("div.tab_content.active .report_name_sort_desc").waitUntilExists(function () {
	jQuery(this).click(function(){
		var tab_id = jQuery(this).parents().eq(2);
		tab_id = jQuery(tab_id).attr('id');
		var report_time_sort_name = [];
		jQuery('.tab_content.active .sort_name_container .info_div').each(function() {
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var info_div_id = div_id_split[2];
			
			var first_column = jQuery(this).find(".first_column").text();
			var second_column = jQuery(this).find(".second_column").text();
			var third_column = jQuery(this).find(".third_column").text();
			var fourth_column = jQuery(this).find(".fourth_column").text();
			var fifth_column = jQuery(this).find(".fifth_column").text();
			var sixth_column = jQuery(this).find(".sixth_column").text();
			var seventh_column = jQuery(this).find(".seventh_column").text();
			var eight_column = jQuery(this).find(".eight_column").text();
			var ninth_column = jQuery(this).find(".ninth_column").text();
		
			report_time_sort_name.push(first_column +'_'+ second_column +'_'+ third_column +'_'+ fourth_column +'_'+ fifth_column +'_'+ sixth_column +'_'+ seventh_column +'_'+ eight_column +'_'+ info_div_id +'_'+ tab_id +'_'+ ninth_column);			
		});
		report_time_sort_name.push("desc");
		jQuery('.report_name_sort_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'report_time_name_sort',
				'report_time_sort_name' : report_time_sort_name				
			},
			success: function (data) {
				jQuery('.tab_content.active .sort_name_container').empty();
				jQuery('.report_name_sort_asc').show();
				jQuery('.report_name_sort_desc').hide();	
				var parsed = jQuery.parseJSON(data);
				var report_name_sort_count = 1;
				jQuery.each(parsed, function(index, value){
					var hour_detail_split = value.split('_');
					var first_column = hour_detail_split[0];
					var second_column = hour_detail_split[1];
					var third_column = hour_detail_split[2];
					var fourth_column = hour_detail_split[3];
					var fifth_column = hour_detail_split[4];
					var sixth_column = hour_detail_split[5];
					var seventh_column = hour_detail_split[6];
					var eight_column = hour_detail_split[7];
					var tab_id = hour_detail_split[8];
					var ninth_column = hour_detail_split[9];
					// console.log(eight_column);
				
					if(tab_id == 'clients'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'projects'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'</div>'					
						);
					}
				
					if(tab_id == 'tasks'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					if(tab_id == 'staff'){
						jQuery('.tab_content.active .sort_name_container').append('<div id="info_div_'+report_name_sort_count+'" class="info_div">'
						+'<div class="first_column"><li>'+first_column+'</li></div>'
						+'<div class="second_column"><li>'+second_column+'</li></div>'
						+'<div class="third_column"><li>'+third_column+'</li></div>'
						+'<div class="fourth_column"><li>'+fourth_column+'</li></div>'
						+'<div class="fifth_column"><li>'+fifth_column+'</li></div>'
						+'<div class="sixth_column"><li>'+sixth_column+'</li></div>'
						+'<div class="seventh_column"><li>'+seventh_column+'</li></div>'
						+'<div class="eight_column"><li>'+eight_column+'</li></div>'
						+'<div class="ninth_column"><li>'+ninth_column+'</li></div>'
						+'</div>'					
						);
					}
					
					report_name_sort_count++;
				});
				jQuery('.report_name_sort_loader').hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});
/* END SORT NAME DESC */

/* END custom_reports_time.php FILTER TIME */

/* END custom_reports_detailed_time.php FILTER TIME */
jQuery(document).ready(function(){
	jQuery('.detailed_time_nav_week .detailed_time_nav_previous').click(function(){
		jQuery('#show_desc_task').show();
		jQuery('#hide_desc_task').hide();
		console.log('detailed_time_nav_week');
		prev_detailed_time_filter();
	});
	jQuery('.detailed_time_nav_week .detailed_time_nav_next').click(function(){
		jQuery('#show_desc_task').show();
		jQuery('#hide_desc_task').hide();
		next_detailed_time_filter();
	});
	jQuery('.detailed_time_nav_month .detailed_time_nav_previous').click(function(){
		jQuery('#show_desc_task').show();
		jQuery('#hide_desc_task').hide();
		console.log('detailed_time_nav_month');
		prev_detailed_time_filter();
	});
	jQuery('.detailed_time_nav_month .detailed_time_nav_next').click(function(){
		jQuery('#show_desc_task').show();
		jQuery('#hide_desc_task').hide();
		next_detailed_time_filter();
	});

	jQuery('.report_filter_selection').change(function(){	

		var time_filter = jQuery('#detailed_time_custom_filter').val();
		var report_sorting_type = jQuery('#filter_sorting_type').val();

		// console.log(time_filter);

		if(report_sorting_type == null){
			report_sorting_type = 'Date';
		}
		
		if(time_filter == 'Week' || time_filter == null){
			
			jQuery('.custom_date_filter').slideUp();
			jQuery('#filter_sorting_type').slideDown();
			jQuery('.detailed_time .timeframe_navigation').show();
			jQuery('.detailed_time_nav_week').show();
			jQuery('.detailed_time_nav_month').hide();		
			
			var current_week = jQuery('#filter_details .filter_current_week').val();

			jQuery('#filter_details .filter_current_week').val(current_week);
			var current_month = jQuery('#filter_details .filter_current_month').val();
			jQuery('#filter_details .filter_current_month').val(current_month);			
			var current_year = jQuery('#filter_details .filter_current_year').val();
			jQuery('#filter_details .filter_current_year').val(current_year);
			
			var week = jQuery('#filter_details .filter_current_week').val();
			var month = jQuery('#filter_details .filter_current_month').val();
			var year = jQuery('#filter_details .filter_current_year').val();			
			var filter_details = week +'_'+ month +'_'+ year +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null';
			filter_ajax_function_detailed_time(filter_details, report_sorting_type);
		}
		
		if(time_filter == 'Month'){
			
			jQuery('.custom_date_filter').slideUp();
			jQuery('#filter_sorting_type').slideDown();
			jQuery('.detailed_time .timeframe_navigation').show();
			jQuery('#filter_details .filter_current_week').val();

			jQuery('.detailed_time_nav_week').hide();
			jQuery('.detailed_time_nav_month').show();			
		
			var current_month = jQuery('#filter_details .current_month').val();
			jQuery('#filter_details .filter_current_month').val(current_month);
			var current_year = jQuery('#filter_details .current_year').val();
			jQuery('#filter_details .filter_current_year').val(current_year);
			
			var month = jQuery('#filter_details .filter_current_month').val();
			var year = jQuery('#filter_details .filter_current_year').val();			
			var filter_details = 'null' +'_'+ month +'_'+ year +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null';
			filter_ajax_function_detailed_time(filter_details, report_sorting_type);
		}
		if(time_filter == 'Custom'){

			jQuery('#filter_sorting_type').slideUp();	
			jQuery('.custom_date_filter').slideDown();
			jQuery('.detailed_time .timeframe_navigation').hide();
			jQuery('.custom_date_filter .from_date').datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd/mm/yy',
				firstDay: 1,
				beforeShow: function (input, inst) {
					var rect = input.getBoundingClientRect();
					setTimeout(function () {
						inst.dpDiv.css({ top: rect.top + 40, left: rect.left + 0 });
					}, 0);
				}
			});	
			jQuery('.custom_date_filter .to_date').datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd/mm/yy',
				firstDay: 1,
				beforeShow: function (input, inst) {
					var rect = input.getBoundingClientRect();
					setTimeout(function () {
						inst.dpDiv.css({ top: rect.top + 40, left: rect.left + 0 });
					}, 0);
				}
			});
			
			jQuery('.custom_date_filter_go').click(function(){				
				var project_name = jQuery('.custom_date_filter .project_name').val();
				var client_name = jQuery('.custom_date_filter .client_name').val();
				var person_name = jQuery('.custom_date_filter .person_name').val();
				var from_date = jQuery('.custom_date_filter .from_date').val();
				var to_date = jQuery('.custom_date_filter .to_date').val();
				var filter_details = 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ project_name +'_'+ client_name +'_'+ person_name +'_'+ from_date +'_'+ to_date;
				filter_ajax_function_detailed_time(filter_details);
			});
		}
	});	
});

function prev_detailed_time_filter(){
	var timeframe = jQuery('#detailed_time_custom_filter').val();
	var report_sorting_type = jQuery('#filter_sorting_type').val();
	var week = jQuery('#filter_details .filter_current_week').val();
	var month = jQuery('#filter_details .filter_current_month').val();
	var year = jQuery('#filter_details .filter_current_year').val();

	if(timeframe == null){
		timeframe = 'Week';
	}
	if(report_sorting_type == null){
		report_sorting_type = 'Date';
	}

	if(timeframe == 'Month'){
		if(month == '01'){
			month = '13';
			year = parseInt(year) - 1;
			jQuery('#filter_details .filter_current_year').val(year);
		}
		var month_format = parseInt(month) - 1;
		var month_count = month_format.toString().length;
		var month_number = (month_count == 1) ? '0' + month_format : month_format;
		jQuery('#filter_details .filter_current_month').val(month_number);
		}else{
		var month_number = month;
	}	
	
	if(timeframe == 'Week' || timeframe == null){
		if(week == '1'){
			year = parseInt(year) - 1;
			jQuery('#filter_details .filter_current_year').val(year);			
		}
		var week_number = parseInt(week) - 1;
		jQuery('#filter_details .filter_current_week').val(week_number);
		
		if(week_number == '0'){			
			var filter_year = jQuery('#filter_details .filter_current_year').val();
			week_number = weeksInYear(filter_year);
			jQuery('#filter_details .filter_current_week').val(week_number);
		}
	}else{
		var week_number = 'null';
	}
	if(timeframe == 'Year'){
		var year_number = parseInt(year) - 1;
		jQuery('#filter_details .filter_current_year').val(year_number);
	}else{
		var year_number = year;
	}
	
	var filter_details = week_number +'_'+ month_number +'_'+ year_number +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null';
	filter_ajax_function_detailed_time(filter_details, report_sorting_type);
}
function next_detailed_time_filter(){
	var timeframe = jQuery('#detailed_time_custom_filters').val();
	var report_sorting_type = jQuery('#filter_sorting_type').val();
	var week = jQuery('#filter_details .filter_current_week').val();
	var month = jQuery('#filter_details .filter_current_month').val();
	var year = jQuery('#filter_details .filter_current_year').val();

	if(timeframe == null){
		timeframe = 'Week';
	}
	if(report_sorting_type == null){
		report_sorting_type = 'Date';
	}
	
	if(timeframe == 'Month'){
		if(month == '12'){
			month = '00';
			year = parseInt(year)+ 1;
			jQuery('#filter_details .filter_current_year').val(year);
		}
		var month_format = parseInt(month) + 1;
		var month_count = month_format.toString().length;
		var month_number = (month_count == 1) ? '0' + month_format : month_format;
		jQuery('#filter_details .filter_current_month').val(month_number);
		}else{
		var month_number = month;
	}
	
	if(timeframe == 'Week'){
		var week_number = parseInt(week) + 1;
		jQuery('#filter_details .filter_current_week').val(week_number);
		var current_year = jQuery('#filter_details .filter_current_year').val();		
		var current_total_week = weeksInYear(current_year);
		if(week == current_total_week){
			year = parseInt(current_year) + 1;
			var week_number = 1;
			jQuery('#filter_details .filter_current_year').val(year);
			jQuery('#filter_details .filter_current_week').val(week_number);			
		}
		}else{
		var week_number = 'null';
	}
	
	if(timeframe == 'Year'){
		var year_number = parseInt(year) + 1;
		jQuery('#filter_details .filter_current_year').val(year_number);
	}else{
		var year_number = year;
	}	
	
	var filter_details = week_number +'_'+ month_number +'_'+ year_number +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null' +'_'+ 'null';
	filter_ajax_function_detailed_time(filter_details, report_sorting_type);
}

function filter_ajax_function_detailed_time(filter_details_detailed_time, report_sorting_type = "Custom"){

	console.log(filter_details_detailed_time);

	jQuery('.custom_filter_loader').show();
	jQuery.ajax({
		type: "POST",
		url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
		data:{
			'type' : 'report_time_filter_detailed_time',
			'filter_details_detailed_time' : filter_details_detailed_time,
			'report_sorting_type' : report_sorting_type		
		},
		success: function (data) {			
			jQuery('.detailed_time .detailed_time_details').empty();
			jQuery('.detailed_time .detailed_total_hours').remove();
			var parsed = jQuery.parseJSON(data);
		
			var report_top_label = parsed.report_top_label;
			jQuery('.detailed_time .report_top_label h1').text(report_top_label);
			
			var check_empty = parsed.detailed_time_details.length;
			if(check_empty != 0){
				jQuery('<h3 class="detailed_total_hours" style="float: left; margin-bottom: 5px;">Total Hours: '+ parsed.total_hours +'</h3>').insertAfter('.header_titles');
				var task_date_temp = "";
				var task_client_temp = "";
				var tid_hour = 0;
				var tid_1_hour = 0;	
				var tid_2_hour = 0;
				var total_hours_row = 0;
				var billable_hours_row = 0;
				var unbillable_hours_row = 0;
				var total_kilometer = 0;

		jQuery.each(parsed.detailed_time_details, function(index, value){
					var detailed_time_details_split = value.split('<_>');
					var client_name = detailed_time_details_split[0];
					var project_name = detailed_time_details_split[1];
					var task_name = detailed_time_details_split[2];
					var person_name = detailed_time_details_split[3];
					var task_hour = detailed_time_details_split[4];
					var task_description = detailed_time_details_split[5];
					var task_date = detailed_time_details_split[6];	
					var task_id = detailed_time_details_split[7];
					var orderno = detailed_time_details_split[8];
					var kilometer = detailed_time_details_split[9];
					var billable = detailed_time_details_split[10];
					var filter_unbillabel = jQuery('#filter_unbillable_checkbox').prop('checked');

					if(filter_unbillabel == true){
						if(billable == 0)
							return true;
					}


					if(report_sorting_type == 'Custom'){
						report_sorting_type = 'Date';
					}
				
					var task_date_id = task_date.replace(/\//g, '_');
					if(report_sorting_type == 'Date' ){
						
						jQuery('.header_titles .first_column .table_header').text('Client');
						jQuery('.column_group .client-title').hide();
						jQuery('.column_group .fifth_column').show();
						jQuery('.column_group .third_column').show();

						if(task_date_temp != task_date){
							task_date_temp = task_date;																										              
							jQuery('.detailed_time .detailed_time_details').append('<div id="task_date_'+task_date_id+'" class="date_container"><div class="date_header"><p>'+task_date+'</p><p class="total_day_hour"></p><p class="total_km_row"></p><p class="total_hours_row"></p><p class="unbillable_hours_row"></p><p class="billable_hours_row"></p><p class="tid_2_total_hours"></p><p class="tid_1_total_hours"></p><p class="tid_total_hours"></p></div>	<div class="header_titles"><div class="first_column column"> <p class="table_header">Client</p> </div> <div class="column_group"> <div class="second_column column client-title" style="display: none;"> <p class="table_header">Client</p> </div> <div class="second_column column"> <p class="table_header">Project</p> </div> <div class="fourth_column column"> <p class="table_header">Task</p> </div> <div class="third_column column_group"> <p class="table_header">Order No.</p> </div> <div class="fifth_column column"> <p class="table_header">Person</p> </div> <div class="sixth_column column"> <p class="table_header">Hours</p> </div> <div class="seventh_column column"> <p class="table_header">KM</p> </div> </div> </div></div>'); 
							tid_hour = 0;
							 tid_1_hour = 0;
							 tid_2_hour = 0;
							 total_hours_row = 0;
							billable_hours_row = 0;
							unbillable_hours_row = 0;
							 total_kilometer = 0;

						}
						if(task_name == "Tid"){
							tid_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(task_name == "Tid-Ö1"){
							tid_1_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(task_name == "Tid-Ö2"){
							tid_2_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(billable == 1){
							billable_hours_row += parseFloat(timeStringToFloat(task_hour));
						}else{
							unbillable_hours_row += parseFloat(timeStringToFloat(task_hour));
						}
						total_hours_row += parseFloat(timeStringToFloat(task_hour));
						total_kilometer += Number(kilometer);
						jQuery('#task_date_'+task_date_id+' .tid_total_hours').text("Tid: " + tid_hour);
						jQuery('#task_date_'+task_date_id+' .tid_1_total_hours').text("Ö1: " + tid_1_hour);
						jQuery('#task_date_'+task_date_id+' .tid_2_total_hours').text("Ö2: " + tid_2_hour);
						jQuery('#task_date_'+task_date_id+' .total_hours_row').text("Total: " + total_hours_row);
						jQuery('#task_date_'+task_date_id+' .billable_hours_row').text("Billable: " + billable_hours_row);
						jQuery('#task_date_'+task_date_id+' .unbillable_hours_row').text("Unbillable: " + unbillable_hours_row);	
						jQuery('#task_date_'+task_date_id+' .total_km_row').text("KM: " + total_kilometer);							
						jQuery('.detailed_time #task_date_' + task_date_id +'.date_container').append('<div class="info_div">'
						+'<div id="client_name_'+ task_id +'" class="first_column column edit_client_name">'
						+'<p>'+ client_name +'</p>'	
						+'<div style="display:none;" class="client_name_edit_container">'
						+'<select name="client_name_edit" class="client_name_edit">'
						+'<option>'+ client_name +'</option>'
						+'</select>'
						+'<div id="check_edit_'+ task_id +'" class="check_edit_client_name"></div>'
						+'</div>'
						+'<div style="display:none;" id="client_name_loader_'+ task_id +'" class="loader"></div>'
						+'</div>'
						+'<div class="column_group">'
						+'<div id="project_name_'+ task_id +'" class="second_column column detailed_time_edit_project_name">'
						+'<input id="detailed_time_clientname_'+task_id+'" type="hidden" value="'+client_name+'">'
						+'<p>'+ project_name +'</p>'
						// +'<div style="display:none;" class="project_name_edit_container">'
						// +'<select name="project_name_edit" class="project_name_edit">'
						// +'<option>'+ project_name +'</option>'
						// +'</select>'
						// +'<div id="check_edit_'+ task_id +'" class="check_edit_project_name"></div>'
						// +'</div>'
						+'<div style="display:none;" id="project_name_loader_'+ task_id +'" class="loader"></div>'
						+'</div>'
						+'<div id="taskname_id_'+task_id+'" class="fourth_column column detailed_time_edit_taskname"><p>'+task_name+'</p><div class="loader" id="taskname_loader_'+ task_id +'" style="display:none;"></div></div>'
						+'<div class="third_column column"><p>'+orderno+'</p></div>'					
						+'<div class="fifth_column column"><p>'+person_name+'</p></div>'
						+'<div class="sixth_column column"><p>'+task_hour+'</p></div>'
						+'<div class="seventh_column column"><p>'+kilometer+'</p></div>'
						//+'<div class="eighth_column column"><div id="task_desc_btn_id_'+task_id+'" class="show_desc_btn" title="Show Task Description"></div></div>'
						+'<div id="task_description_id_'+task_id+'" class="full_width task_description" style="display: none;"><p>'+task_description+'</p></div>'
						+'<div id="accordian_'+ task_id +'" style="display:none;" class="accordian task_done_today_display full_width">'
						+'<h5 class="toggle">'
						+'<a href="#"><li class="">Done Today<span class="arrow"></span></li></a>'
						+'</h5>'
						+'<div class="toggle-content" style="display: none;">'
						+'<div class="full_width">'
						+'<div class="header_titles">'
						+'<div class="three_fourth"><p class="table_header">Task Description</p></div>'
						+'<div class="one_fourth last"><p class="table_header">Task Hour</p></div>'										
						+'</div>'
						+'<div class="task_done_today_display_container">'					
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						);
					}
					if(report_sorting_type == 'Client'){
						if(task_client_temp != client_name){
							task_client_temp = client_name;	
																																	              
							jQuery('.detailed_time .detailed_time_details').append('<div id="task_date_'+client_name.replace(/ /g,"")+'" class="date_container"><div class="date_header"><p>'+client_name+'</p><p class="total_day_hour"></p><p class="total_km_row"></p><p class="total_hours_row"></p><p class="unbillable_hours_row"></p><p class="tid_2_total_hours"></p><p <p class="billable_hours_row"></p><p class="tid_1_total_hours"></p><p class="tid_total_hours"></p></div><div class="header_titles"> <div class="first_column column"> <p class="table_header">Client</p> </div> <div class="column_group"> <div class="second_column column client-title" style="display: none;"> <p class="table_header">Client</p> </div> <div class="second_column column"> <p class="table_header">Project</p> </div> <div class="fourth_column column"> <p class="table_header">Task</p> </div> <div class="third_column column_group"> <p class="table_header">Order No.</p> </div> <div class="fifth_column column"> <p class="table_header">Person</p> </div> <div class="sixth_column column"> <p class="table_header">Hours</p> </div> <div class="seventh_column column"> <p class="table_header">KM</p> </div> </div> </div></div>'); 
							tid_hour = 0;
							 tid_1_hour = 0;
							 tid_2_hour = 0;
							 total_hours_row = 0;
							billable_hours_row = 0;
							unbillable_hours_row = 0;	
							 total_kilometer = 0;			
						}
						if(task_name == "Tid"){
							tid_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(task_name == "Tid-Ö1"){
							tid_1_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(task_name == "Tid-Ö2"){
							tid_2_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(billable == 1){
							billable_hours_row += parseFloat(timeStringToFloat(task_hour));
						}else{
							unbillable_hours_row += parseFloat(timeStringToFloat(task_hour));
						}
						total_hours_row += parseFloat(timeStringToFloat(task_hour));
						total_kilometer += Number(kilometer);
						jQuery('#task_date_'+client_name.replace(/ /g,"")+' .tid_total_hours').text("Tid: " + tid_hour);
						jQuery('#task_date_'+client_name.replace(/ /g,"")+' .tid_1_total_hours').text("Ö1: " + tid_1_hour);
						jQuery('#task_date_'+client_name.replace(/ /g,"")+' .tid_2_total_hours').text("Ö2: " + tid_2_hour);
						jQuery('#task_date_'+client_name.replace(/ /g,"")+' .total_hours_row').text("Total: " + total_hours_row);
						jQuery('#task_date_'+client_name.replace(/ /g,"")+' .billable_hours_row').text("Billable: " + billable_hours_row);
						jQuery('#task_date_'+client_name.replace(/ /g,"")+' .unbillable_hours_row').text("Unbillable: " + unbillable_hours_row);	
						jQuery('#task_date_'+client_name.replace(/ /g,"")+'  .total_km_row').text("KM: " + total_kilometer);	
						jQuery('.detailed_time #task_date_' +client_name.replace(/ /g,"")+	'.date_container').append('<div class="info_div">'
						+'<div id="client_name_'+ task_id +'" class="first_column column edit_client_name">'
						+'<p>'+ task_date +'</p>'	
						+'<div style="display:none;" class="client_name_edit_container">'
						+'<select name="client_name_edit" class="client_name_edit">'
						+'<option>'+ client_name +'</option>'
						+'</select>'
						+'<div id="check_edit_'+ task_id +'" class="check_edit_client_name"></div>'
						+'</div>'
						+'<div style="display:none;" id="client_name_loader_'+ task_id +'" class="loader"></div>'
						+'</div>'
						+'<div class="column_group">'
						+'<div id="project_name_'+ task_id +'" class="second_column column detailed_time_edit_project_name">'
						+'<input id="detailed_time_clientname_'+task_id+'" type="hidden" value="'+client_name+'">'
						+'<p>'+ project_name +'</p>'
						// +'<div style="display:none;" class="project_name_edit_container">'
						// +'<select name="project_name_edit" class="project_name_edit">'
						// +'<option>'+ project_name +'</option>'
						// +'</select>'
						// +'<div id="check_edit_'+ task_id +'" class="check_edit_project_name"></div>'
						// +'</div>'
						+'<div style="display:none;" id="project_name_loader_'+ task_id +'" class="loader"></div>'
						+'</div>'
						+'<div id="taskname_id_'+task_id+'" class="fourth_column column detailed_time_edit_taskname"><p>'+task_name+'</p><div class="loader" id="taskname_loader_'+ task_id +'" style="display:none;"></div></div>'
						+'<div class="third_column column"><p>'+orderno+'</p></div>'					
						+'<div class="fifth_column column"><p>'+person_name+'</p></div>'
						+'<div class="sixth_column column"><p>'+task_hour+'</p></div>'
						+'<div class="seventh_column column"><p>'+kilometer+'</p></div>'
						// +'<div class="eighth_column column"><div id="task_desc_btn_id_'+task_id+'" class="show_desc_btn" title="Show Task Description"></div></div>'
						+'<div id="task_description_id_'+task_id+'" class="full_width task_description" style="display: none;"><p>'+task_description+'</p></div>'
						+'<div id="accordian_'+ task_id +'" style="display:none;" class="accordian task_done_today_display full_width">'
						+'<h5 class="toggle">'
						+'<a href="#"><li class="">Done Today<span class="arrow"></span></li></a>'
						+'</h5>'
						+'<div class="toggle-content" style="display: none;">'
						+'<div class="full_width">'
						+'<div class="header_titles">'
						+'<div class="three_fourth"><p class="table_header">Task Description</p></div>'
						+'<div class="one_fourth last"><p class="table_header">Task Hour</p></div>'										
						+'</div>'
						+'<div class="task_done_today_display_container">'					
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.header_titles .first_column .table_header').text('Date');
					}

					if(report_sorting_type == 'Order No'){
						if(task_client_temp != orderno){
							task_client_temp = orderno;																														              
							jQuery('.detailed_time .detailed_time_details').append('<div id="task_order_'+orderno+'" class="date_container"><div class="date_header"><p>'+orderno+'</p><p class="total_day_hour"></p><p class="total_km_row"></p><p class="total_hours_row"></p><p class="unbillable_hours_row"></p><p class="billable_hours_row"></p><p class="tid_2_total_hours"></p><p class="tid_1_total_hours"></p><p class="tid_total_hours"></p></div><div class="header_titles"> <div class="first_column column"> <p class="table_header">Client</p> </div> <div class="column_group"> <div class="second_column column client-title" style="display: none;"> <p class="table_header">Client</p> </div> <div class="second_column column"> <p class="table_header">Project</p> </div> <div class="fourth_column column"> <p class="table_header">Task</p> </div> <div class="third_column column_group"> <p class="table_header">Order No.</p> </div> <div class="fifth_column column"> <p class="table_header">Person</p> </div> <div class="sixth_column column"> <p class="table_header">Hours</p> </div> <div class="seventh_column column"> <p class="table_header">KM</p> </div> </div> </div></div>'); 
							tid_hour = 0;
							 tid_1_hour = 0;
							 tid_2_hour = 0;
							 total_hours_row = 0;
							billable_hours_row = 0;
							unbillable_hours_row = 0;	
							total_kilometer = 0;		
						}


						if(task_name == "Tid"){
							tid_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(task_name == "Tid-Ö1"){
							tid_1_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(task_name == "Tid-Ö2"){
							tid_2_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(billable == 1){
							billable_hours_row += parseFloat(timeStringToFloat(task_hour));
						}else{
							unbillable_hours_row += parseFloat(timeStringToFloat(task_hour));
						}
						total_hours_row += parseFloat(timeStringToFloat(task_hour));
						total_kilometer += Number(kilometer);
						jQuery('#task_order_'+orderno+' .tid_total_hours').text("Tid: " + tid_hour);
						jQuery('#task_order_'+orderno+' .tid_1_total_hours').text("Ö1: " + tid_1_hour);
						jQuery('#task_order_'+orderno+' .tid_2_total_hours').text("Ö2: " + tid_2_hour);
						jQuery('#task_order_'+orderno+' .total_hours_row').text("Total: " + total_hours_row);
						jQuery('#task_order_'+orderno+' .billable_hours_row').text("Billable: " + billable_hours_row);
						jQuery('#task_order_'+orderno+' .unbillable_hours_row').text("Unbillable: " + unbillable_hours_row);	
						jQuery('#task_order_'+orderno+' .total_km_row').text("KM: " + total_kilometer);		
						jQuery('.column_group .third_column').hide();
						jQuery('.column_group .client-title').show();
						jQuery('.column_group .client_info').show();
						jQuery('.detailed_time #task_order_'+ orderno +'.date_container').append('<div class="info_div">'
						+'<div class="first_column"><p>'+task_date+'</p></div>'
						+'<div id="orderno_column_'+ task_id +'" class="column_group order_number_column">'
						+'<div id="client_name_'+ task_id +'" class="third_column column edit_client_name">'
						+'<p class="column_align">'+ client_name +'</p>'	
						+'<div style="display:none;" class="client_name_edit_container">'
						+'<select name="client_name_edit" class="client_name_edit">'
						+'<option>'+ client_name +'</option>'
						+'</select>'
						+'<div id="check_edit_'+ task_id +'" class="check_edit_client_name"></div>'
						+'</div>'
						+'<div style="display:none;" id="client_name_loader_'+ task_id +'" class="loader"></div>'
						+'</div>'	
						+'<div id="project_name_'+ task_id +'" class="second_column column detailed_time_edit_project_name">'
						+'<input id="detailed_time_clientname_'+task_id+'" type="hidden" value="'+client_name+'">'
						+'<p class="column_align">'+ project_name +'</p>'
						// +'<div style="display:none;" class="project_name_edit_container">'
						// +'<select name="project_name_edit" class="project_name_edit">'
						// +'<option>'+ project_name +'</option>'
						// +'</select>'
						+'<div id="check_edit_'+ task_id +'" class="check_edit_project_name"></div>'
						// +'</div>'
						+'<div style="display:none;" id="project_name_loader_'+ task_id +'" class="loader"></div>'
						+'</div>'
						// +'<div class="third_column column"><p>'+orderno+'</p></div>'				
							+'<div id="taskname_id_'+task_id+'" class="fourth_column column detailed_time_edit_taskname"><p class="column_align">'+task_name+'</p><div class="loader" id="taskname_loader_'+ task_id +'" style="display:none;"></div></div>'
						+'<div class="fifth_column column"><p class="column_align">'+person_name+'</p></div>'
						+'<div class="sixth_column column"><p class="column_align">'+task_hour+'</p></div>'
						+'<div class="seventh_column column"><p class="column_align">'+kilometer+'</p></div>'
						//+'<div class="eighth_column column"><div id="task_desc_btn_id_'+task_id+'" class="show_desc_btn" title="Show Task Description"></div></div>'
						+'<div id="task_description_id_'+task_id+'" class="full_width task_description" style="display: none;"><p>'+task_description+'</p></div>'
						+'<div id="accordian_'+ task_id +'" style="display:none;" class="accordian task_done_today_display full_width">'
						+'<h5 class="toggle">'
						+'<a href="#"><li class="">Done Today<span class="arrow"></span></li></a>'
						+'</h5>'
						+'<div class="toggle-content" style="display: none;">'
						+'<div class="full_width">'
						+'<div class="header_titles">'
						+'<div class="three_fourth"><p class="table_header">Task Description</p></div>'
						+'<div class="one_fourth last"><p class="table_header">Task Hour</p></div>'										
						+'</div>'
						+'<div class="task_done_today_display_container">'					
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.header_titles .first_column .table_header').text('Date');
						jQuery('.order_number_column .third_column.column.edit_client_name').show();
					}

					if(report_sorting_type == 'Consultant'){
						// jQuery('.column_group .fifth_column').show();
						if(task_client_temp != person_name){
							task_client_temp = person_name;																														              
							jQuery('.detailed_time .detailed_time_details').append('<div id="task_person_'+person_name.replace(/ /g,"")+'" class="date_container"><div class="date_header"><p>'+person_name+'</p><p class="total_day_hour"></p><p class="total_km_row"></p><p class="total_hours_row"></p><p class="unbillable_hours_row"></p><p class="billable_hours_row"></p><p class="tid_2_total_hours"></p><p class="tid_1_total_hours"></p><p class="tid_total_hours"></p></div><div class="header_titles"> <div class="first_column column"> <p class="table_header">Client</p> </div> <div class="column_group"> <div class="second_column column client-title" style="display: none;"> <p class="table_header">Client</p> </div> <div class="second_column column"> <p class="table_header">Project</p> </div> <div class="fourth_column column"> <p class="table_header">Task</p> </div> <div class="third_column" style="width: 16.5%;" > <p class="table_header">Order No.</p> </div> <div class="fifth_column column"> <p class="table_header">Person</p> </div> <div class="sixth_column column"> <p class="table_header">Hours</p> </div> <div class="seventh_column column"> <p class="table_header">KM</p> </div> </div> </div></div>'); 
							 tid_hour = 0;
							 tid_1_hour = 0;
							 tid_2_hour = 0;
							 total_hours_row = 0;
							 billable_hours_row = 0;
							 unbillable_hours_row = 0;
							 total_kilometer = 0;			
						}
						if(task_name == "Tid"){
							tid_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(task_name == "Tid-Ö1"){
							tid_1_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(task_name == "Tid-Ö2"){
							tid_2_hour += parseFloat(timeStringToFloat(task_hour));
						}
						if(billable == 1){
							billable_hours_row += parseFloat(timeStringToFloat(task_hour));
						}else{
							unbillable_hours_row += parseFloat(timeStringToFloat(task_hour));
						}
						total_hours_row += parseFloat(timeStringToFloat(task_hour));
						total_kilometer += Number(kilometer);
						jQuery('#task_person_'+person_name.replace(/ /g,"")+' .tid_total_hours').text("Tid: " + tid_hour);
						jQuery('#task_person_'+person_name.replace(/ /g,"")+' .tid_1_total_hours').text("Ö1: " + tid_1_hour);
						jQuery('#task_person_'+person_name.replace(/ /g,"")+' .tid_2_total_hours').text("Ö2: " + tid_2_hour);
						jQuery('#task_person_'+person_name.replace(/ /g,"")+' .total_hours_row').text("Total: " + total_hours_row);
						jQuery('#task_person_'+person_name.replace(/ /g,"")+' .billable_hours_row').text("Billable: " + billable_hours_row);
						jQuery('#task_person_'+person_name.replace(/ /g,"")+' .unbillable_hours_row').text("Unbillable: " + unbillable_hours_row);
						jQuery('#task_person_'+person_name.replace(/ /g,"")+' .total_km_row').text("KM: " + total_kilometer);			
						jQuery('.detailed_time #task_person_'+person_name.replace(/ /g,"")+'.date_container').append('<div class="info_div">'
						+'<div class="first_column"><p>'+task_date+'</p></div>'
						+'<div id="colsultant_column" class="column_group">'
						+'<div id="client_name_'+ task_id +'" class="third_column column edit_client_name">'
						+'<p class="column_align2">'+ client_name +'</p>'	
						+'<div style="display:none;" class="client_name_edit_container">'
						+'<select name="client_name_edit" class="client_name_edit">'
						+'<option>'+ client_name +'</option>'
						+'</select>'
						+'<div id="check_edit_'+ task_id +'" class="check_edit_client_name"></div>'
						+'</div>'
						+'<div style="display:none;" id="client_name_loader_'+ task_id +'" class="loader"></div>'
						+'</div>'	
						+'<div id="project_name_'+ task_id +'" class="second_column column detailed_time_edit_project_name">'
						+'<input id="detailed_time_clientname_'+task_id+'" type="hidden" value="'+client_name+'">'
						+'<p class="column_align2">'+ project_name +'</p>'
						// +'<div style="display:none;" class="project_name_edit_container">'
						// +'<select name="project_name_edit" class="project_name_edit">'
						// +'<option>'+ project_name +'</option>'
						// +'</select>'
						+'<div id="check_edit_'+ task_id +'" class="check_edit_project_name"></div>'
						// +'</div>'
						+'<div style="display:none;" id="project_name_loader_'+ task_id +'" class="loader"></div>'
						+'</div>'
						// +'<div class="third_column column"><p>'+orderno+'</p></div>'	
						+'<div id="taskname_id_'+task_id+'" class="fourth_column column detailed_time_edit_taskname"><p class="column_align2">'+task_name+'</p><div class="loader" id="taskname_loader_'+ task_id +'" style="display:none;"></div></div>'
						+'<div class="fourth_column column"><p class="column_align2">'+orderno+'</p></div>'					
						+'<div class="fifth_column column"><p>'+person_name+'</p></div>'
						+'<div class="sixth_column column"><p>'+task_hour+'</p></div>'
						+'<div class="seventh_column column"><p>'+kilometer+'</p></div>'
						//+'<div class="eighth_column column"><div id="task_desc_btn_id_'+task_id+'" class="show_desc_btn" title="Show Task Description"></div></div>'
						+'<div id="task_description_id_'+task_id+'" class="full_width task_description" style="display: none;"><p>'+task_description+'</p></div>'
						+'<div id="accordian_'+ task_id +'" style="display:none;" class="accordian task_done_today_display full_width">'
						+'<h5 class="toggle">'
						+'<a href="#"><li class="">Done Today<span class="arrow"></span></li></a>'
						+'</h5>'
						+'<div class="toggle-content" style="display: none;">'
						+'<div class="full_width">'
						+'<div class="header_titles">'
						+'<div class="three_fourth"><p class="table_header">Task Description</p></div>'
						+'<div class="one_fourth last"><p class="table_header">Task Hour</p></div>'										
						+'</div>'
						+'<div class="task_done_today_display_container">'					
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>'
						);
						jQuery('.column_group .fifth_column').hide();
						jQuery('.column_group .client-title').show();
						jQuery('.header_titles .first_column .table_header').text('Date');
					}
				});				
			
				jQuery.each(parsed.project_name_select, function(index, project_name_option){					
					jQuery('.edit_project_name select.project_name_edit').append('<option>'+ project_name_option +'</option>');
				});
				
				jQuery.each(parsed.client_name_select, function(index, client_name_option){					
					jQuery('.edit_client_name select.client_name_edit').append('<option>'+ client_name_option +'</option>');
				});
				
				if(parsed.tasks_done_today.length != 0 && parsed.tasks_done_today != null){
					jQuery.each(parsed.tasks_done_today, function(task_today_id, tasks_done_today){
						if(tasks_done_today != 'null'){														
							var task_done_today_split = tasks_done_today.split('_');
							var task_done_today_description = task_done_today_split[0];
							var task_done_today_hour = task_done_today_split[1];
							var task_done_today_id = task_done_today_split[2];
							jQuery('#accordian_'+ task_done_today_id).show();								
							jQuery('#accordian_'+ task_done_today_id +' .task_done_today_display_container').append('<div class="task_done_today_border">'
							+'<div class="three_fourth"><p>'+ task_done_today_description +'</p></div>'
							+'<div class="one_fourth last"><p>'+ task_done_today_hour +'</p></div>'
							+'</div>'							
							);			
						}
					});
				}				
				
				jQuery.each(parsed.total_day_hours, function(index, total_day_hours){
					var total_day_hours_split = total_day_hours.split("_");
					var total_day_hour = total_day_hours_split[0];
					var day_hour_date = total_day_hours_split[1].replace(/\//g, '_');
					jQuery('#task_date_'+day_hour_date+' p.total_day_hour').text(total_day_hour);

				});
				
				jQuery('.custom_filter_loader').hide();
			}else{
				jQuery('.custom_filter_loader').hide();
				jQuery('.detailed_time .detailed_total_hours').text(report_top_label);
			}
			trigger_accordion_toggle();
			trigger_project_name_edit();
			trigger_client_name_edit();
		},
		error: function (data) {
			alert('error');
		}
	});
}
/* END custom_reports_detailed_time.php FILTER TIME */

/* custom_reports_detailed_time.php EDIT PROJECT NAME */
jQuery(document).ready(function(){
	jQuery('.edit_project_name').dblclick(function() {
		jQuery('.project_name_edit_container').hide();
		jQuery('.client_name_edit_container').hide();
		jQuery('.edit_project_name p').show();
		jQuery('.edit_client_name p').show();
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#project_name_'+data_id+' p').hide();
		jQuery('#project_name_'+data_id+' .project_name_edit_container').show();
	});
	
	jQuery('.detailed_time .check_edit_project_name').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#project_name_loader_'+data_id).show();
		
		var project_name = jQuery('#project_name_'+ data_id +' .project_name_edit').val();
		var project_name_edit_details = project_name +"_"+ data_id;
		
		jQuery.ajax({
			type : "POST",
			url : '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'project_name_edit',
				'project_name_edit_details' : project_name_edit_details				
			},
			success: function (data) {			
				var project_name_edit_details_split = data.split('_');				
				var project_name = project_name_edit_details_split[0];
				var project_id = project_name_edit_details_split[1];
				jQuery('#project_name_'+project_id+' p').text(project_name);
				jQuery('.project_name_edit_container').hide();
				jQuery('#project_name_'+project_id+' p').show();
				jQuery('#project_name_loader_'+project_id).hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});

	//Detailed Time Page Report Show Description Button
	 jQuery(document).on('click', '.show_desc_btn', function(){
	// jQuery(".show_desc_btn").live("click", function(){
			jQuery(this).toggleClass( "active" );
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var data_id = div_id_split[4];

			console.log(data_id);

			jQuery('#task_description_id_'+data_id).slideToggle();    
	});	

});


//Detailed Time Report Edit taskname OLD VERSION
function trigger_project_name_edit(){
	jQuery('.edit_project_name').dblclick(function() {
		jQuery('.project_name_edit_container').hide();
		jQuery('.client_name_edit_container').hide();
		jQuery('.edit_project_name p').show();
		jQuery('.edit_client_name p').show();
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#project_name_'+data_id+' p').hide();
		jQuery('#project_name_'+data_id+' .project_name_edit_container').show();
	});
	
	jQuery('.detailed_time .check_edit_project_name').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#project_name_loader_'+data_id).show();
		
		var project_name = jQuery('#project_name_'+ data_id +' .project_name_edit').val();
		var project_name_edit_details = project_name +"_"+ data_id;
		
		jQuery.ajax({
			type : "POST",
			url : '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'project_name_edit',
				'project_name_edit_details' : project_name_edit_details				
			},
			success: function (data) {			
				var project_name_edit_details_split = data.split('_');
				var project_name = project_name_edit_details_split[0];
				var project_id = project_name_edit_details_split[1];
				jQuery('#project_name_'+project_id+' p').text(project_name);
				jQuery('.project_name_edit_container').hide();
				jQuery('#project_name_'+project_id+' p').show();
				jQuery('#project_name_loader_'+project_id).hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
}
/* END custom_reports_detailed_time.php EDIT PROJECT NAME */

/* custom_reports_detailed_time.php EDIT CLIENT NAME */
jQuery(document).ready(function(){
	jQuery('.edit_client_name').dblclick(function() {
		jQuery('.project_name_edit_container').hide();
		jQuery('.client_name_edit_container').hide();
		jQuery('.edit_project_name p').show();
		jQuery('.edit_client_name p').show();
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#client_name_'+data_id+' p').hide();
		jQuery('#client_name_'+data_id+' .client_name_edit_container').show();
	});
	
	jQuery('.detailed_time .check_edit_client_name').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#client_name_loader_'+data_id).show();
		
		var client_name = jQuery('#client_name_'+ data_id +' .client_name_edit').val();
		var client_name_edit_details = client_name +"_"+ data_id;
		
		jQuery.ajax({
			type : "POST",
			url : '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'client_name_edit',
				'client_name_edit_details' : client_name_edit_details
			},
			success: function (data) {			
				var client_name_edit_details_split = data.split('_');				
				var client_name = client_name_edit_details_split[0];
				var client_id = client_name_edit_details_split[1];
				jQuery('#client_name_'+client_id+' p').text(client_name);
				jQuery('.client_name_edit_container').hide();
				jQuery('#client_name_'+client_id+' p').show();
				jQuery('#client_name_loader_'+client_id).hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
});

function trigger_client_name_edit(){
	jQuery('.edit_client_name').dblclick(function() {
		jQuery('.project_name_edit_container').hide();
		jQuery('.client_name_edit_container').hide();
		jQuery('.edit_project_name p').show();
		jQuery('.edit_client_name p').show();
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#client_name_'+data_id+' p').hide();
		jQuery('#client_name_'+data_id+' .client_name_edit_container').show();
	});
	
	jQuery('.detailed_time .check_edit_client_name').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#client_name_loader_'+data_id).show();
		
		var client_name = jQuery('#client_name_'+ data_id +' .client_name_edit').val();
		var client_name_edit_details = client_name +"_"+ data_id;
		
		jQuery.ajax({
			type : "POST",
			url : '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'client_name_edit',
				'client_name_edit_details' : client_name_edit_details
			},
			success: function (data) {			
				var client_name_edit_details_split = data.split('_');				
				var client_name = client_name_edit_details_split[0];
				var client_id = client_name_edit_details_split[1];
				jQuery('#client_name_'+client_id+' p').text(client_name);
				jQuery('.client_name_edit_container').hide();
				jQuery('#client_name_'+client_id+' p').show();
				jQuery('#client_name_loader_'+client_id).hide();
			},
			error: function (data) {
				alert('error');
			}
		});
	});
}
/* END custom_reports_detailed_time.php EDIT CLIENT NAME */

/* custom_add_website.php ADD WEBSITE */
jQuery(document).ready(function(){

	jQuery('#show_desc_task').click(function(){
		console.log('show desc');
		jQuery(this).hide();
		jQuery('#hide_desc_task').show();
		jQuery('.full_width.task_description').slideDown();
		jQuery('.date_container').css({'top':'5px', 'position' : 'inherit'});
	});

	jQuery('#hide_desc_task').click(function(){
		jQuery(this).hide();
		jQuery('#show_desc_task').show();
		jQuery('.full_width.task_description').slideUp().hide();
		jQuery('.date_container').css({'top':'0','position':'relative'});
	});

	jQuery('.site_renewal_date').datepicker();
	jQuery('.get_wp_details').click(function(){
		if(jQuery('#website .site_url').val() != ""){		
			var site_url = jQuery('.add_website .site_url').val();
			jQuery('.add_website .loader').show();
			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'get_wp_details',
					'site_url' : site_url				
				},
				success: function (data) {
					jQuery('.add_website .loader').hide();
					jQuery('.add_website .wp_readme_details').html(data);
					var h1_content = jQuery('.add_website .wp_readme_details h1#logo').contents().last().text();
					var trim = jQuery.trim(h1_content);
					var split_content = trim.split(" "); 
					var version = split_content[1];				
					if(version != null){
						jQuery('.add_website .wp_version').append("<div class='left'><p class='label'>Wordpress Version:</p></div>"				
							+"<div class='right'><input type='text' name='site_wp_version' class='site_wp_version' value='"+version+"'></div>"
							+"<div class='border_separator'></div>"
						);
					}else{
						jQuery(".error_message p").text(data);
						jQuery(".error_message").fadeIn( "slow", function() {
							jQuery(".error_message").delay(3000).fadeOut('slow');
						});
					}
					jQuery('.section.wp_version').css('width', '100%');
					jQuery('.section.wp_version .right input').css('width', '25%');
					jQuery('.dialog_form_website_add').css('height', '455px','important');
				},
				error: function (data) {
					alert('error');
				}
			});
		}else{
			jQuery(".error_message p").text('This field is required');
			jQuery(".error_message").fadeIn( "slow", function() {
				jQuery(".error_message").delay(3000).fadeOut('slow');
			});
			return false;
		}
	});
	
	jQuery('.edit_get_wp_details').click(function(){
		if(jQuery('#website .site_url').val() != ""){
			var site_url = jQuery('.edit_website .site_url').val();
			jQuery('.edit_website .wp_details_loader').show();
			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'get_wp_details',
					'site_url' : site_url				
				},
				success: function (data) {
					jQuery('.edit_website .wp_details_loader').hide();
					jQuery('.edit_website .wp_readme_details').html(data);
					var h1_content = jQuery('.edit_website .wp_readme_details h1#logo').contents().last().text();
					var trim = jQuery.trim(h1_content);
					var split_content = trim.split(" "); 
					var version = split_content[1];
					var current_version = jQuery('.site_wp_version').val();					
					if(version != null){
						if(version == current_version){
							jQuery(".wp_note p").text(current_version +" is the current site version");
							jQuery(".wp_note").fadeIn( "slow", function() {
								jQuery(".wp_note").delay(3000).fadeOut('slow');
							});
							}else{
							jQuery('.site_wp_version').val(version);
						}
					}else{
						jQuery(".error_message p").text(data);
						jQuery(".error_message").fadeIn( "slow", function() {
							jQuery(".error_message").delay(3000).fadeOut('slow');
						});
					}
				},
				error: function (data) {
					alert('error');
				}
			});
		}else{
			jQuery(".error_message p").text('This field is required');
			jQuery(".error_message").fadeIn( "slow", function() {
				jQuery(".error_message").delay(3000).fadeOut('slow');
			});
			return false;
		}
	});
	
	jQuery('.get_theme_details').click(function(){
		if(jQuery('#website .site_url').val() != ""){
			jQuery('.add_website .loader').show();
			var site_url = jQuery('.add_website .site_url').val();
			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'get_theme_details',
					'site_url' : site_url				
				},
				success: function (data) {
					jQuery('.add_website .loader').hide();
					var parsed = jQuery.parseJSON(data);
					if(parsed.Name != null){
						jQuery('.add_website .theme_details').append("<div class='theme_name'>"
						+"<div class='left'><p class='label'>Theme Name:</p></div>"				
						+"<div class='right'><input type='text' name='site_theme_name' class='site_theme_name' value='"+parsed.Name+"'></div>"
						+"</div>"
						+"<div class='theme_version'>"
						+"<div class='left'><p class='label'>Theme Version:</p></div>"
						+"<div class='right'><input type='text' name='site_theme_version' class='site_theme_version' value='"+parsed.Version+"'></div>"
						+"</div>"
						+"<div class='border_separator'></div>"
						);
						jQuery('.section.wp_version').css('width', '30%');
						jQuery('.section.wp_version .right input').css('width', '100%');
						jQuery('.dialog_form_website_add').css('height', '455px','important');
					}
					if(parsed.Error != null){
						jQuery(".error_message p").text(parsed.Error);
						jQuery(".error_message").fadeIn( "slow", function() {
							jQuery(".error_message").delay(3000).fadeOut('slow');
						});
					}
					
				},
				error: function (data) {
					jQuery(".error_message p").text('WordPress detected, but no information can be determined. The theme is either customized or secured.');
					jQuery(".error_message").fadeIn( "slow", function() {
						jQuery(".error_message").delay(3000).fadeOut('slow');
					});
				}
			});
		}else{
			jQuery(".error_message p").text('This field is required');
			jQuery(".error_message").fadeIn( "slow", function() {
				jQuery(".error_message").delay(3000).fadeOut('slow');
			});
			return false;
		}
	});
	
	jQuery('.edit_get_theme_details').click(function(){
		if(jQuery('#website .site_url').val() != ""){
			jQuery('.edit_website .theme_details_loader').show();
			var site_url = jQuery('.edit_website .site_url').val();
			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'get_theme_details',
					'site_url' : site_url				
				},
				success: function (data) {
					jQuery('.edit_website .theme_details_loader').hide();
					var parsed = jQuery.parseJSON(data);
					var current_theme_name = jQuery('.site_theme_name').val();
					var current_theme_version = jQuery('.site_theme_version').val();
					if(parsed.Name != null){					
						if(parsed.Name == current_theme_name && parsed.Version == current_theme_version){
							jQuery(".wp_theme_note p").html(current_theme_name +" is the current site theme<br/>"+current_theme_version +" is the current site theme version");
							jQuery(".wp_theme_note").fadeIn( "slow", function() {
								jQuery(".wp_theme_note").delay(3000).fadeOut('slow');
							});
						}else if(parsed.Name != current_theme_name && parsed.Version != current_theme_version){
							jQuery('.site_theme_name').val(parsed.Name);
							jQuery('.site_theme_version').val(parsed.Version);						
						}else if(parsed.Name == current_theme_name && parsed.Version != current_theme_version){
							jQuery(".wp_theme_note p").html(current_theme_name +" is the current site theme<br/> Theme Version Updated");
							jQuery(".wp_theme_note").fadeIn( "slow", function() {
								jQuery(".wp_theme_note").delay(3000).fadeOut('slow');
							});
							jQuery('.site_theme_version').val(parsed.Version);
						}else if(parsed.Name != current_theme_name && parsed.Version == current_theme_version){
							jQuery(".wp_theme_note p").html(current_theme_version +" is the current site theme version<br/> Theme Name Updated");
							jQuery(".wp_theme_note").fadeIn( "slow", function() {
								jQuery(".wp_theme_note").delay(3000).fadeOut('slow');
							});
							jQuery('.site_theme_name').val(parsed.Name);
						}
						
					}
					if(parsed.Error != null){
						jQuery(".error_message p").text(parsed.Error);
						jQuery(".error_message").fadeIn( "slow", function() {
							jQuery(".error_message").delay(3000).fadeOut('slow');
						});
					}		
				},
				error: function (data) {
					jQuery(".error_message p").text('WordPress detected, but no information can be determined. The theme is either customized or secured.');
					jQuery(".error_message").fadeIn( "slow", function() {
						jQuery(".error_message").delay(3000).fadeOut('slow');
					});
				}
			});
		}else{
			jQuery(".error_message p").text('This field is required');
			jQuery(".error_message").fadeIn( "slow", function() {
				jQuery(".error_message").delay(3000).fadeOut('slow');
			});
			return false;
		}
	});
	
	jQuery('.add_hosting').click(function(){
		jQuery('.add_hosting_url').slideDown();
	});
	
	jQuery('.add_domain').click(function(){
		jQuery('.add_domain_url').slideDown();
	});
	
	jQuery('.save_hosting_url').click(function(){
		jQuery('.hosting_domain_loader').show();
		var hosting_name = jQuery('.add_site_hosting_name').val();
		var hosting_url = jQuery('.add_site_hosting_url').val();
		var hosting_username = jQuery('.add_site_hosting_username').val();		
		var hosting_password = jQuery('.add_site_hosting_password').val();		
		var hosting_domain = hosting_name +"_"+ hosting_url +"_"+ hosting_username +"_"+ hosting_password +"_"+ 'null' +"_"+ 'null' +"_"+ 'null' +"_"+ 'null';
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'save_hosting_domain',
				'hosting_domain' : hosting_domain				
			},
			success: function (data) {
				jQuery('.hosting_domain_loader').hide();
				jQuery('.add_hosting_domain_div').slideUp();
				jQuery('.site_hosting_name').prepend('<option selected>'+data+'</option>');
			},
			error: function (data) {
				
			}
		});	
	});
	
	jQuery('.save_domain_url').click(function(){
		jQuery('.hosting_domain_loader').show();
		var domain_name = jQuery('.add_site_domain_name').val();
		var domain_url = jQuery('.add_site_domain_url').val();
		var domain_username = jQuery('.add_site_domain_username').val();		
		var domain_password = jQuery('.add_site_domain_password').val();		
		var hosting_domain = 'null' +"_"+ 'null' +"_"+ 'null' +"_"+ 'null' +"_"+ domain_name +"_"+ domain_url +"_"+ domain_username +"_"+ domain_password;
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'save_hosting_domain',
				'hosting_domain' : hosting_domain				
			},
			success: function (data) {
				jQuery('.hosting_domain_loader').hide();
				jQuery('.add_hosting_domain_div').slideUp();
				jQuery('.site_domain_name').prepend('<option selected>'+data+'</option>');
			},
			error: function (data) {
				
			}
		});	
	});
});
/* END custom_add_website.php ADD WEBSITE */

/* custom_add_goals.php ADD GOALS */
jQuery(document).ready(function(){
	jQuery('.yearly_goal').change(function(){
		jQuery('.goals_time_year').slideDown();
		jQuery('.goals_time_month').slideUp();
	});
	jQuery('.monthly_goal').change(function(){
		jQuery('.goals_time_year').slideDown();
		jQuery('.goals_time_month').slideDown();
	});
	jQuery('.personal_goal').click(function(){
		jQuery('.goals_time_person').slideToggle();
	});
	var counter = 1;
	jQuery('.add_more_goals').click(function(){
		var goals = jQuery('.goals').val();
		jQuery('.goals_container').append('<li class="goals_list" id="goals_'+counter+'">'
		+'<div class="goal_width">'
		+'<input type="hidden" name="submit_goals[]" value="'+goals+'"/><p>'+goals+'</p>'
		+'<div id="goals_delete_'+counter+'" class="confirm goals_delete button_2 subtask_action_button">D</div>'
		+'<div id="goals_edit_'+counter+'" class="goals_edit button_2 subtask_action_button">E</div>'
		+'</div>'
		+'</li>'
		+'<div class="edit_div" id="edit_div_'+counter+'" style="display:none;">'
		+'<input type="text"  id="goals_edit_area_'+counter+'" class="goals_edit_area" />'
		+'<div id="check_edit_'+counter+'" class="check_edit"></div>'
		+'</div>'
		);
		jQuery(".goals").val("");
		counter++;
		jQuery('.goals_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(11, div_id.length);
			var edit_data = jQuery('#goals_'+data_id+' p').text();
			jQuery('#goals_'+data_id).hide();
			jQuery('#edit_div_'+data_id).css('display', 'block');
			jQuery('#goals_edit_area_'+data_id).val(edit_data);
		});
		jQuery('.check_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(11, div_id.length);
			var edited_value = jQuery('#goals_edit_area_'+data_id).val();
			jQuery('#edit_div_'+data_id).css('display', 'none');
			jQuery('#goals_'+data_id).show();
			jQuery('#goals_'+data_id+' p').text(edited_value);
		});		
		jQuery('.goals_delete').click(function(){		
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(13, div_id.length);
			jQuery('#goals_'+data_id).remove();
			jQuery('#edit_div_'+data_id).remove();
		});		
	});
});
/* END custom_add_goals.php ADD GOALS */

/* custom_add_goals.php EDIT GOALS */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_edit_goals" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});		
	jQuery('.goals_edit').click(function(){		
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var goals_time = div_id_split[2];
		var goals_key = div_id_split[3];
		jQuery('#goal_'+goals_time+'_'+goals_key+'.loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'edit_goals',
				'div_id' : div_id				
			},
			success: function (data) {
				jQuery('#goal_'+goals_time+'_'+goals_key+'.loader').hide();
				jQuery("#dialog_form_edit_goals").html(data);
				jQuery("#dialog_form_edit_goals").dialog( "open" );
				trigger_update_goals();
			},
			error: function (data) {
				
			}
		});	
	});
});
function trigger_update_goals(){	
	jQuery('.modal_save_edit_goals').click(function(){
		jQuery('#edit_modal_goals .loader').show();
		var div_id = jQuery(this).attr('id');
		var goal_update_edit_details = jQuery('#edit_modal_goals').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'update_edit_goals',
				'goal_update_edit_details' : goal_update_edit_details				
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var goals = parsed.goals;
				var goals_time = parsed.goals_time;				
				var goal_key = parsed.goal_key;
				var goal_person = parsed.goal_person;
				var goal_person_id = parsed.goal_person_id;
				if(goal_person_id != null){
					jQuery('h3#goal_'+goals_time+'_'+goal_key+'_'+goal_person_id).text(goals);
				}else{
					jQuery('h3#goal_'+goals_time+'_'+goal_key).text(goals);
				}
				jQuery("#dialog_form_edit_goals").dialog( "close" );
			},
			error: function (data) {
				
			}
		});	
	});
}
/* END custom_add_goals.php EDIT GOALS */

/* custom_add_goals.php DELETE GOALS */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_delete_goals" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});	
	
	jQuery('.goals_delete').click(function(){		
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var goals_time = div_id_split[2];
		var goals_key = div_id_split[3];
		jQuery('#goal_'+goals_time+'_'+goals_key+'.loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'confirm_delete_goals',
				'div_id' : div_id				
			},
			success: function (data) {
				jQuery('#goal_'+goals_time+'_'+goals_key+'.loader').hide();
				jQuery("#dialog_form_delete_goals").html(data);
				jQuery("#dialog_form_delete_goals").dialog( "open" );
				trigger_delete_goals();
			},
			error: function (data) {
				
			}
		});	
	});	
});
function trigger_delete_goals(){
	jQuery('.modal_save_delete_goals').click(function(){
		jQuery('#delete_modal_goals .loader').show();
		var div_id = jQuery(this).attr('id');
		var goal_delete_details = jQuery('#delete_modal_goals').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'delete_goals',
				'goal_delete_details' : goal_delete_details				
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var goals = parsed.goals;
				var goals_time = parsed.goals_time;
				var goal_key = parsed.goal_key;
				jQuery('#goal_display_'+goals_time+'_'+goal_key).remove();
				jQuery("#dialog_form_delete_goals").dialog( "close" );
			},
			error: function (data) {
				
			}
		});	
	});
}
/* END custom_add_goals.php DELETE GOALS */

/* custom_add_message.php ADD MESSAGE */
jQuery(document).ready(function(){
	jQuery('.global_message').change(function(){
		jQuery('.message_person').slideUp();
	});
	jQuery('.personal_message').change(function(){
		jQuery('.message_person').slideDown();
	});
});
		
/* END custom_add_message.php ADD MESSAGE */

/* custom_manage_message.php EDIT MESSAGE */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_edit_message" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});		
	jQuery('.message_edit').click(function(){		
		var message_div_id = jQuery(this).attr('id');
		var div_id_split = message_div_id.split('_');
		var message_type = div_id_split[2];
		var message_key = div_id_split[3];
		var message_person_id = div_id_split[4];
		if(message_person_id != null){
			jQuery('#message_'+message_type+'_'+message_key+'_'+message_person_id+'_loader').show();
		}else{
			jQuery('#message_'+message_type+'_'+message_key+'_loader').show();
		}
		
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'edit_message',
				'message_div_id' : message_div_id				
			},
			success: function (data) {
				if(message_person_id != null){
					jQuery('#message_'+message_type+'_'+message_key+'_'+message_person_id+'_loader').hide();
				}else{
					jQuery('#message_'+message_type+'_'+message_key+'_loader').hide();
				}
				jQuery("#dialog_form_edit_message").html(data);
				jQuery("#dialog_form_edit_message").dialog( "open" );
				trigger_update_messages();
			},
			error: function (data) {
				
			}
		});	
	});
});
function trigger_update_messages(){	
	jQuery('.modal_save_edit_messages').click(function(){
		jQuery('#edit_modal_message .loader').show();
		var message_update_edit_details = jQuery('#edit_modal_message').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'update_edit_message',
				'message_update_edit_details' : message_update_edit_details				
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var messages = parsed.messages;
				var message_date = parsed.message_date;				
				var message_type = parsed.message_type;
				var message_key = parsed.message_key;
				var message_person = parsed.message_person;
				var message_person_id = parsed.message_person_id;
				if(message_person_id != null && message_person_id != ""){
					jQuery('h3#message_'+message_type+'_'+message_key+'_'+message_person_id).text(messages);
				}else{
					jQuery('h3#message_'+message_type+'_'+message_key).text(messages);
				}
				jQuery("#dialog_form_edit_message").dialog( "close" );
			},
			error: function (data) {
				
			}
		});	
	});
}
/* END custom_manage_message.php EDIT MESSAGE */

/* custom_manage_message.php DELETE MESSAGE */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_delete_message" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});	
	
	jQuery('.message_delete').click(function(){		
		var message_div_id = jQuery(this).attr('id');
		var div_id_split = message_div_id.split('_');
		var message_type = div_id_split[2];
		var message_key = div_id_split[3];
		var message_person_id = div_id_split[4];
		if(message_person_id != null){
			jQuery('#message_'+message_type+'_'+message_key+'_'+message_person_id+'_loader').show();
		}else{
			jQuery('#message_'+message_type+'_'+message_key+'_loader').show();
		}
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'confirm_delete_message',
				'message_div_id' : message_div_id				
			},
			success: function (data) {
				if(message_person_id != null){
					jQuery('#message_'+message_type+'_'+message_key+'_'+message_person_id+'_loader').hide();
					}else{
					jQuery('#message_'+message_type+'_'+message_key+'_loader').hide();
				}
				jQuery("#dialog_form_delete_message").html(data);
				jQuery("#dialog_form_delete_message").dialog( "open" );
				trigger_delete_message();
			},
			error: function (data) {
				
			}
		});	
	});	
});
function trigger_delete_message(){
	jQuery('.modal_save_delete_message').click(function(){
		jQuery('#delete_modal_message .loader').show();
		var div_id = jQuery(this).attr('id');
		var message_delete_details = jQuery('#delete_modal_message').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'delete_message',
				'message_delete_details' : message_delete_details				
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var delete_message = parsed.delete_message;
				var message_type = parsed.message_type;
				var message_key = parsed.message_key;
				var message_person = parsed.message_person;
				var message_person_id = parsed.message_person_id;
				if(message_person_id != null){
					jQuery('#message_display_'+message_type+'_'+message_key+'_'+message_person_id).remove();
				}else{
					jQuery('#message_display_'+message_type+'_'+message_key).remove();
				}
				jQuery("#dialog_form_delete_message").dialog( "close" );
			},
			error: function (data) {
				
			}
		});	
	});
}
/* END custom_manage_message.php DELETE MESSAGE */

/* custom_dashboard.php SAVE GOALS */
jQuery(document).ready(function(){
	var dashboard_current_user = jQuery('.dashboard .current_user_fullname').val();	
	jQuery('.dashboard .goals_checklist').each(function(){
		if(jQuery(this).hasClass('yearly_goals')){
			jQuery('input.yearly_goal_input_key').each(function(){
				var key = jQuery(this).val();
				jQuery('#icon_yearly_goal_key_'+key).addClass('checked_goals');	
				jQuery('#icon_yearly_goal_key_'+key).removeClass('unchecked_goals');
			});						
		}
		if(jQuery(this).hasClass('monthly_goals')){
			jQuery('input.monthly_goal_input_key').each(function(){
				var key = jQuery(this).val();
				jQuery('#icon_monthy_goal_key_'+key).addClass('checked_goals');	
				jQuery('#icon_monthy_goal_key_'+key).removeClass('unchecked_goals');			
			});						
		}
	});
	jQuery('.dashboard .goals_checkbox').each(function(){
		// if(jQuery(this).hasClass('yearly_goals')){
			// jQuery('input.yearly_goal_input_key').each(function(){
				// var key = jQuery(this).val();
				// jQuery('#yearly_goal_key_'+key).attr('checked', 'checked');				
			// });						
		// }
		// if(jQuery(this).hasClass('monthly_goals')){
			// jQuery('input.monthly_goal_input_key').each(function(){
				// var key = jQuery(this).val();
				// jQuery('#monthly_goal_key_'+key).attr('checked', 'checked');				
			// });						
		// }
		// if(jQuery(this).hasClass('personal_yearly_goals')){
			// jQuery('input.personalyearly_goal_input_key').each(function(){
				// var key = jQuery(this).val();
				// jQuery('#personal_yearly_goal_key_'+key).attr('checked', 'checked');				
			// });						
		// }
		// if(jQuery(this).hasClass('personal_monthly_goals')){
			// jQuery('input.personalmonthly_goal_input_key').each(function(){
				// var key = jQuery(this).val();
				// jQuery('#personal_monthly_goal_key_'+key).attr('checked', 'checked');				
			// });						
		// }
		jQuery(this).click(function(){
			jQuery('.goal_action_loader').show();
            if(jQuery(this).prop("checked") == true){				
                var dashboard_goals_value = jQuery(this).val();
				jQuery.ajax({
					type: "POST",
					url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
					data:{
					'type' : 'dashboard_goals',
					'dashboard_goals_value' : dashboard_goals_value				
					},
					success: function (data) {
						jQuery('.goal_action_loader').hide();
					},
					error: function (data) {
					
					}
				});				
            }else if(jQuery(this).prop("checked") == false){				
               	var dashboard_goals_input_value = jQuery(this).val();				
				var dashboard_goals_value_uncheck = dashboard_goals_input_value +"_"+ dashboard_current_user;
				jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
				'type' : 'dashboard_goals_uncheck',
				'dashboard_goals_value_uncheck' : dashboard_goals_value_uncheck				
				},
				success: function (data) {
					jQuery('.goal_action_loader').hide();
				},
				error: function (data) {
				
				}
				});				
            }			
        });
	});	
});
/* END custom_dashboard.php SAVE GOALS */

/* custom_dashboard.php SMILEY HOVER */
jQuery(document).ready(function(){
	jQuery('.client_satisfaction_column').mouseover(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];	
		var pos = jQuery(this).position();
		var width = jQuery(this).outerWidth();
		var top_value = pos.top - 10;
		var left_value = pos.left + 6;		
		jQuery('#client_satisfaction_note_' + data_id).css({
			position: "absolute",
			top: top_value + "px",
			left: (left_value + width) + "px"
		}).show();
		}).mouseout(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#client_satisfaction_note_' + data_id).hide();
	});	
});
/* END custom_dashboard.php SMILEY HOVER */

/*  custom_add_checklists.php ADD CHECKLIST */
jQuery(document).ready(function(){
	jQuery('.clear_checkboxes').click(function(){
		jQuery('.template_checklist').each(function(){			
			jQuery(this).removeAttr('checked');
		});
	});
});
jQuery(document).ready(function(){
	// <!-- ADD CHECKLIST TEMPLATE -->
	jQuery('.add_checklist_template').click(function(){
		jQuery('.checklist_template_div').slideDown();
	});
	jQuery('#check_list_template .add_template').click(function(){
		var template_name = jQuery('.add_checklist_template_input').val();
		jQuery('.add_template_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'check_template_exist',
				'template_name' : template_name				
			},
			success: function (data) {
				jQuery('.add_template_loader').hide();
				var data_split = data.split('<_>');
				var check_result = data_split[0];
				var template_name = data_split[1];
				if(check_result == 'not_exist'){
					jQuery('.checklist_template_section select.checklist_template').prepend('<option selected>'+template_name+'</option>');
					jQuery('.checklist_template_div').slideUp();
					jQuery("input[name='checklist[]']").removeAttr("checked");
				}else if(check_result == 'exist'){					
					jQuery(".template_exist_note").fadeIn( "slow", function() {
						jQuery(".template_exist_note").delay(3000).fadeOut('slow');
					});
				}
				
			},
			error: function (data) {
				
			}
		});		
	});
	
	jQuery('.checklist_template_section select.checklist_template').change(function(){
		jQuery('.checklist_template_section .loader').show();
		var template_name = jQuery(this).val();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'template_checklist_select',
				'template_name' : template_name				
			},
			success: function (data) {
				jQuery('.checklist_template_section .loader').hide();
				if(data != null && data != 'undefined'){					
					var parsed = jQuery.parseJSON(data);
					var checked_items_array = jQuery.makeArray(parsed);
					jQuery('.template_checklist').each(function(){
						var checkbox_value = jQuery(this).val();
						if(jQuery.inArray( checkbox_value, checked_items_array ) >  -1){
							jQuery(this).prop('checked', true);
							}else{
							jQuery(this).removeAttr('checked');
						}
					});
				}
			},
			error: function (data) {
				
			}
		});	
	});
	<!-- END ADD CHECKLIST TEMPLATE -->
	
	<!-- ADD CHECKLIST ITEMS -->
	jQuery('.add_checklist_category').click(function(){
		jQuery('.checklist_category_div').slideDown();
	});
	jQuery('#check_list .add_category').click(function(){
		var add_category = jQuery('.add_checklist_category_input').val();
		jQuery('select.checklist_category').prepend('<option selected>'+add_category+'</option>');
		jQuery('.checklist_category_div').slideUp();
		jQuery('.category_checklist_items .checklist_category_items').empty();
	});
	
	var counter = 1;
	jQuery('.add_more_list').click(function(){
		var list_name = jQuery('.checklist_name').val();
		var list_description = jQuery('.checklist_description').val();
		var header_exist = jQuery('.checklist_add_items_section').length;
		if(header_exist == 0){
			jQuery('.checklist_container').append('<div class="section checklist_add_items_section">'
			+'<div class="left">'
			+'<p class="list_name_header label">Items</p>'
			+'<p class="list_description_header label">Description</p>'
			+'</div>'
			+'</div>'
			);
		}
		jQuery('.checklist_container').append('<li class="checklist_list" id="checklist_'+counter+'">'		
		+'<div class="section">'
		+'<div class="left">'
		+'<input type="hidden" id="hidden_list_'+counter+'" name="submit_checklist[]" value="'+list_name +'<__>'+ list_description +'"/>'
		+'<p class="list_name">'+list_name+'</p>'
		+'<p class="list_description">'+ find_url(list_description)+'</p>'
		+'</div>'		
		+'<div class="right">'		
		+'<div id="add_checklist_delete_'+counter+'" class="confirm add_checklist_delete button_2 checklist_action_button">D</div>'
		+'<div id="add_checklist_edit_'+counter+'" class="add_checklist_edit button_2 checklist_action_button">E</div>'
		+'</div>'
		+'</div>'
		+'</li>'		
		+'<div class="edit_div" id="edit_div_'+counter+'" style="display:none;">'
		+'<div class="section">'
		+'<div class="left">'
		+'<input type="text" id="checklist_name_edit_area_'+counter+'" class="checklist_edit_area" />'
		+'<textarea id="checklist_description_edit_area_'+counter+'" class="checklist_edit_area" />'
		+'</div>'	
		+'<div class="right">'
		+'<div id="add_check_edit_'+counter+'" class="add_check_edit"></div>'
		+'</div>'
		+'</div>'
		+'</div>'
		);
		jQuery(".checklist_name").val("");
		jQuery(".checklist_description").val("");
		counter++;
		jQuery('.add_checklist_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var data_id = div_id_split[3];
			var edit_list_name = jQuery('#checklist_'+data_id+' p.list_name').text();
			var edit_list_description = jQuery('#checklist_'+data_id+' p.list_description').text();
			jQuery('#checklist_'+data_id).hide();
			jQuery('#edit_div_'+data_id).css('display', 'block');
			jQuery('#checklist_name_edit_area_'+data_id).val(edit_list_name);
			jQuery('#checklist_description_edit_area_'+data_id).val(edit_list_description);
		});
		jQuery('.add_check_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var data_id = div_id_split[3];
			var edited_list_name = jQuery('#checklist_name_edit_area_'+data_id).val();
			var edited_list_description = jQuery('#checklist_description_edit_area_'+data_id).val();
			jQuery('#edit_div_'+data_id).css('display', 'none');
			jQuery('#checklist_'+data_id).show();
			jQuery('#checklist_'+data_id+' p.list_name').text(edited_list_name);
			jQuery('#hidden_list_'+data_id).val(edited_list_name);
			jQuery('#checklist_'+data_id+' p.list_description').html(find_url(edited_list_description));
			jQuery('#hidden_list_'+data_id).val(edited_list_description);
		});		
		jQuery('.add_checklist_delete').click(function(){		
			var div_id = jQuery(this).attr('id');
			var div_id_split = div_id.split('_');
			var data_id = div_id_split[3];
			jQuery('#checklist_'+data_id).remove();
			jQuery('#edit_div_'+data_id).remove();
		});		
	});
	<!-- END ADD CHECKLIST ITEMS -->
	jQuery('.edit_checklist_item').click(function(){		
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#name_item_p_'+data_id).hide();
		jQuery('#description_item_p_'+data_id).hide();
		jQuery('#edit_item_'+data_id).hide();
		jQuery('.delete_item_'+data_id).hide();
		jQuery('#checklist_name_input_'+data_id).show();
		jQuery('#checklist_description_input_'+data_id).show();
		jQuery('#check_item_'+data_id).show();
	});
	
	jQuery('.category_checklist_items .check_button').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#check_item_loader_'+data_id).show();
		var checklist_name = jQuery('#checklist_name_input_'+data_id).val();
		var checklist_description = jQuery('#checklist_description_input_'+data_id).val();		
		jQuery('#edit_modal_checklist .checklist_name').val(checklist_name);
		jQuery('#edit_modal_checklist .checklist_description').val(checklist_description);
		jQuery('#edit_modal_checklist .checklist_key').val(data_id);		
		var checklist_update_edit_details = jQuery('#edit_modal_checklist').serialize();			
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'update_edit_checklist',
				'checklist_update_edit_details' : checklist_update_edit_details
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);				
				var checklist_key = parsed.checklist_key;
				var checklist_name = parsed.checklist_name;
				var checklist_description = parsed.checklist_description;				
				var add_checklist_category_id = parsed.add_checklist_category_id;				
				var check_description = jQuery('#checklist_item_display_'+add_checklist_category_id+'_'+checklist_key+' .has_description').length;
				if(check_description == 0){
				jQuery('<div id="checklist_item_display_'+add_checklist_category_id+'_'+checklist_key+'" class="has_description closed"></div>').insertAfter('#checklist_item_display_'+add_checklist_category_id+'_'+checklist_key);
				jQuery('<div id="checklist_description_'+add_checklist_category_id+'_'+checklist_key+'" class="checklist_description_display" style="display:none;">'
				+'<span class="span_bold">'+checklist_name+': </span>'
				+checklist_description
				+'</div>').insertAfter('#checklist_item_display_'+add_checklist_category_id+'_'+checklist_key+' .has_description');
				}else{
					jQuery('#checklist_description_'+add_checklist_category_id+'_'+checklist_key+'').html(find_url(checklist_description));
					jQuery('#checklist_description_'+add_checklist_category_id+'_'+checklist_key+' span').text(checklist_name);
				}
				jQuery('#check_item_loader_'+checklist_key).hide();
				jQuery('#name_item_p_'+checklist_key).html(checklist_name);
				jQuery('#name_item_p_'+checklist_key).show();
				jQuery('#description_item_p_'+checklist_key).html(find_url(checklist_description));
				jQuery('#description_item_p_'+checklist_key).show();
				jQuery('#edit_item_'+checklist_key).show();
				jQuery('.delete_item_'+checklist_key).show();
				jQuery('#checklist_name_input_'+checklist_key).hide();
				jQuery('#checklist_description_input_'+checklist_key).hide();
				jQuery('#check_item_'+checklist_key).hide();

				
			},
			error: function (data) {
				
			}
		});	
	});	
	jQuery('.category_add_checklist_section .checklist_category').change(function(){
		jQuery('.checklist_select_loader').show();
		var checklist_category_name = jQuery(this).val();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'add_checklist_category_select',
				'checklist_category_name' : checklist_category_name				
			},
			success: function (data) {				
				var data_split = data.split('<_>');
				var checklist_html = data_split[0];
				var checklist_category_name = data_split[1];
				var checklist_category_id = data_split[2];
				jQuery('.checklist_select_loader').hide();
				jQuery('.category_checklist_items .checklist_category_items').empty();
				jQuery('.category_checklist_items .checklist_category_items').html(checklist_html);
				jQuery('#edit_modal_checklist .checklist_category').val(checklist_category_name);
				jQuery('#edit_modal_checklist .checklist_category_id').val(checklist_category_id);
				trigger_edit_checklist_item();				
				trigger_checklist_delete();				
			},
			error: function (data) {
				
			}
		});	
	});	
});
function trigger_edit_checklist_item(){
	jQuery('.edit_checklist_item').click(function(){		
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#name_item_p_'+data_id).hide();
		jQuery('#description_item_p_'+data_id).hide();
		jQuery('#edit_item_'+data_id).hide();
		jQuery('.delete_item_'+data_id).hide();
		jQuery('#checklist_name_input_'+data_id).show();
		jQuery('#checklist_description_input_'+data_id).show();
		jQuery('#check_item_'+data_id).show();
	});
	
	jQuery('.category_checklist_items .check_button').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		jQuery('#check_item_loader_'+data_id).show();
		var checklist_name = jQuery('#checklist_name_input_'+data_id).val();
		jQuery('#edit_modal_checklist .checklist_name').val(checklist_name);
		jQuery('#edit_modal_checklist .checklist_key').val(data_id);		
		var checklist_update_edit_details = jQuery('#edit_modal_checklist').serialize();			
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'update_edit_checklist',
				'checklist_update_edit_details' : checklist_update_edit_details
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var checklist_key = parsed.checklist_key;
				var checklist_name = parsed.checklist_name;
				jQuery('#check_item_loader_'+checklist_key).hide();
				jQuery('#name_item_p_'+checklist_key).html(checklist_name);
				jQuery('#name_item_p_'+checklist_key).show();
				jQuery('#edit_item_'+checklist_key).show();
				jQuery('.delete_item_'+checklist_key).show();
				jQuery('#checklist_name_input_'+checklist_key).hide();
				jQuery('#check_item_'+checklist_key).hide();
				
			},
			error: function (data) {
				
			}
		});	
	});
}
function trigger_checklist_delete(){
	jQuery( "#dialog_form_delete_checklist" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});	
	
	jQuery('.checklist_delete').click(function(){		
		var checklist_div_id = jQuery(this).attr('id');
		var div_id_split = checklist_div_id.split('_');
		var checklist_category = div_id_split[2];
		var checklist_key = div_id_split[3];
		jQuery('#checklist_'+checklist_category+'_'+checklist_key+'.loader').show();
		jQuery('#check_item_loader_'+checklist_key).show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'confirm_delete_checklist',
				'checklist_div_id' : checklist_div_id				
			},
			success: function (data) {
				jQuery('#checklist_'+checklist_category+'_'+checklist_key+'.loader').hide();
				jQuery('#check_item_loader_'+checklist_key).hide();
				jQuery("#dialog_form_delete_checklist").html(data);
				jQuery("#dialog_form_delete_checklist").dialog( "open" );
				trigger_delete_checklist();
			},
			error: function (data) {
				
			}
		});	
	});
}		
/* END custom_add_checklists.php ADD CHECKLIST */

/* END custom_manage_checklist_task.php ADD CHECKLIST */
jQuery(document).ready(function(){
	var checkbox_count = jQuery('.template_checklist').length;	
	jQuery('#task_checklist_form .checkboxes_count').val(checkbox_count);
});
jQuery(document).ready(function(){
	jQuery('.checklist_task select.checklist_person').change(function(){
		jQuery('.checklist_task .checklist_person_loader').show();		
		var person_name = jQuery(this).val();		
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'task_person_checklist_select',
				'person_name' : person_name				
			},
			success: function (data) {				
				jQuery('.checklist_task .checklist_person_loader').hide();
				jQuery('.checklist_task .checklist .check_group').remove();
				var parsed = jQuery.parseJSON(data);
			
				var checklist_project = parsed.checklist_project;
				var checklist_client = parsed.checklist_client;
				var checklist_task_id = parsed.checklist_tsk_id;
				var checklist_categories = parsed.checklist_categories;
				var checklist_items = parsed.checklist_items;				
				var checked_items_array = parsed.checked_items_array;		
				var checklist_task_template_names = parsed.checklist_task_template_names;		
				var selected_template_name = parsed.selected_template_name;		
				
				jQuery('.checklist_task .checklist_class_labels .chekclist_project span').text(checklist_project);
				jQuery('.checklist_task .checklist_class_labels .chekclist_client span').text(checklist_client);
				jQuery('#task_checklist_form .checklist_task_id').val(checklist_task_id);
				
				if(checklist_categories != null && checklist_categories != 'undefined'){
					jQuery.each(checklist_categories, function(index, checklist_category){
						// var checklist_category_class = checklist_category.replace(/\s+/g, '_').toLowerCase();
						var checklist_category_class = checklist_category.replace('&', '').replace(/  +/g, ' ').replace(/\s+/g, '_').toLowerCase();
						jQuery('.checklist_task .checklist #task_checklist_form .columns .column').append('<div class="check_group '+ checklist_category_class +'">'
						+'<div class="group_title">'
						+'<h3>'+ checklist_category +'</h3>'
						+'</div>'
						);				
					});
				}
				
				if(checklist_items != null && checklist_items != 'undefined'){
					jQuery.each(checklist_items, function(index, checklist_items_details){						
						var checklist_item_split = checklist_items_details.split("<__>");
						var checklist_name = checklist_item_split[0];						
						var checklist_description_category_split = checklist_item_split[1].split('_');						
						var checklist_description = checklist_description_category_split[0];
						var checklist_description_display = find_url(checklist_description);
						var checklist_category_priority = checklist_description_category_split[1];
						var checklist_category = checklist_description_category_split[2];
						var checklist_key = checklist_description_category_split[3];
						var checklist_category_id = checklist_description_category_split[4];
						var checklist_value = checklist_name +'<__>'+ checklist_description +'_'+ checklist_category_priority +'_'+ checklist_category;
						// var checklist_category_class = checklist_category.replace(/\s+/g, '_').toLowerCase();
						var checklist_category_class = checklist_category.replace('&', '').replace(/  +/g, ' ').replace(/\s+/g, '_').toLowerCase();
						jQuery('.checklist_task .checklist #task_checklist_form .columns .column .check_group.'+checklist_category_class).append('<div class="checkboxes">'			
						+'<div id="checklist_item_display_'+ checklist_category_id +"_"+ checklist_key +'" class="checklist_item_display">'						
						+'<input type="checkbox" name="checklist[]" class="template_checklist" value="'+ checklist_value +'" />' 
						+'<p class="checklist_label">'+ checklist_name +'</p>'
						+'<div style="display:none;" id="checklist_description_'+ checklist_category_id +"_"+ checklist_key +'" class="checklist_description_display">'
						+'<span class="span_bold">'+checklist_name+': </span>'+ checklist_description_display
						+'</div>'
						+'</div>'
						+'</div>'
						);						
						
						
						if(checklist_description.length != 0){							
							jQuery('<div id="checklist_item_display_'+ checklist_category_id +"_"+ checklist_key+'" class="has_description closed"></div>').insertAfter('#checklist_item_display_'+checklist_category_id+"_"+checklist_key+ ' .checklist_label');							
						}
					});
				}
				
				if(checked_items_array != null && checked_items_array != 'undefined'){					
					jQuery('.template_checklist').each(function(){
						var checkbox_value = jQuery(this).val();
						if(jQuery.inArray( checkbox_value, checked_items_array ) >  -1){
							jQuery(this).prop('checked', true);
							}else{
							jQuery(this).removeAttr('checked');
						}
					});
				}
				jQuery('.checklist_task select.checklist_template option').remove();
				jQuery.each(checklist_task_template_names, function(index, template_name_option){
					if(template_name_option == selected_template_name){
						jQuery('.checklist_task select.checklist_template').append('<option selected>'+ template_name_option +'</option>');
					}else{
						jQuery('.checklist_task select.checklist_template').append('<option>'+ template_name_option +'</option>');
					}
				});
				
				var checkbox_count = jQuery('.template_checklist').length;	
				jQuery('#task_checklist_form .checkboxes_count').val(checkbox_count);
				trigger_toggle_checklist_description();
			},
			error: function (data) {
				
			}
		});	
	});
});

jQuery(document).ready(function(){
	jQuery('.checklist_task select.checklist_template').change(function(){
		jQuery('.checklist_task .checklist_template_loader').show();
		var template_name = jQuery(this).val();
		var person_name = jQuery('.checklist_task .checklist_person').val();
		var task_checklist_details = template_name +'_'+ person_name;		
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'task_checklist_select',
				'task_checklist_details' : task_checklist_details				
			},
			success: function (data) {
				jQuery('.checklist_task .checklist_template_loader').hide();
				jQuery('.checklist_task .checklist .check_group').remove();
				var parsed = jQuery.parseJSON(data);
				var checklist_project = parsed.checklist_project;
				var checklist_client = parsed.checklist_client;				
				var checklist_task_id = parsed.checklist_task_id;
				var checklist_categories = parsed.checklist_categories;
				var checklist_items = parsed.checklist_items;
				var checked_items_array = parsed.checked_items_array;
				
				jQuery('.checklist_task .checklist_class_labels .chekclist_project span').text(checklist_project);
				jQuery('.checklist_task .checklist_class_labels .chekclist_client span').text(checklist_client);				
				jQuery('#task_checklist_form .checklist_task_id').val(checklist_task_id);
				
				if(checklist_categories != null && checklist_categories != 'undefined'){
					jQuery.each(checklist_categories, function(index, checklist_category){
						// var checklist_category_class = checklist_category.replace(/\s+/g, '_').toLowerCase();
						var checklist_category_class = checklist_category.replace('&', '').replace(/  +/g, ' ').replace(/\s+/g, '_').toLowerCase();
						jQuery('.checklist_task .checklist #task_checklist_form .columns .column').append('<div class="check_group '+ checklist_category_class +'">'
						+'<div class="group_title">'
						+'<h3>'+ checklist_category +'</h3>'
						+'</div>'
						);				
					});
				}
				
				if(checklist_items != null && checklist_items != 'undefined'){
					jQuery.each(checklist_items, function(index, checklist_items_details){
						var checklist_item_split = checklist_items_details.split("<__>");
						var checklist_name = checklist_item_split[0];						
						var checklist_description_category_split = checklist_item_split[1].split('_');
						var checklist_description = checklist_description_category_split[0];
						var checklist_description_display = find_url(checklist_description);
						var checklist_category_priority = checklist_description_category_split[1];
						var checklist_category = checklist_description_category_split[2];
						var checklist_key = checklist_description_category_split[3];
						var checklist_category_id = checklist_description_category_split[4];
						var checklist_value = checklist_name +'<__>'+ checklist_description +'_'+ checklist_category_priority +'_'+ checklist_category;
						// var checklist_category_class = checklist_category.replace(/\s+/g, '_').toLowerCase();
						var checklist_category_class = checklist_category.replace('&', '').replace(/  +/g, ' ').replace(/\s+/g, '_').toLowerCase();
						jQuery('.checklist_task .checklist #task_checklist_form .columns .column .check_group.'+checklist_category_class).append('<div class="checkboxes">'			
						+'<div id="checklist_item_display_'+ checklist_category_id +"_"+ checklist_key +'" class="checklist_item_display">'						
						+'<input type="checkbox" name="checklist[]" class="template_checklist" value="'+ checklist_value +'" />'
						+'<p class="checklist_label">'+ checklist_name +'</p>'
						+'<div style="display:none;" id="checklist_description_'+ checklist_category_id +"_"+ checklist_key +'" class="checklist_description_display">'
						+'<span class="span_bold">'+checklist_name+': </span>'+ checklist_description_display
						+'</div>'
						+'</div>'
						+'</div>'
						);
						if(checklist_description.length != 0){							
							jQuery('<div id="checklist_item_display_'+ checklist_category_id +"_"+ checklist_key+'" class="has_description closed"></div>').insertAfter('#checklist_item_display_'+checklist_category_id+"_"+checklist_key+ ' .checklist_label');
						}
					});
				}
				
				var checked_item_array = [];
				jQuery(checked_items_array).each(function(index, value){
					var checked_items = value.replace('\\\\','');
					checked_item_array.push(checked_items)
				});
				if(checked_item_array != null && checked_item_array != 'undefined'){					
					jQuery('.template_checklist').each(function(){						
						var checkbox_value = jQuery(this).val();
						if(jQuery.inArray( checkbox_value, checked_item_array ) >  -1){
							jQuery(this).prop('checked', true);
							}else{
							jQuery(this).removeAttr('checked');
						}
					});
				}
				var checkbox_count = jQuery('.template_checklist').length;	
				jQuery('#task_checklist_form .checkboxes_count').val(checkbox_count);
				trigger_toggle_checklist_description();
			},
			error: function (data) {
				
			}
		});	
	});
});
function trigger_toggle_checklist_description(){
	jQuery('.has_description').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_category = div_id_split[3];
		var data_id = div_id_split[4];		
		jQuery('#checklist_description_'+data_category+'_'+data_id).toggle("medium");
		jQuery(this).toggleClass('open').siblings().removeClass('closed');
	});
}

jQuery(document).ready(function(){
	jQuery('.completed_has_description').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_category = div_id_split[4];
		var data_id = div_id_split[5];		
		jQuery('#completed_checklist_description_'+data_category+'_'+data_id).toggle("medium");
		jQuery(this).toggleClass('open').siblings().removeClass('closed');
	});
});
/* Custom toggle */
jQuery(document).ready(function(){		
	jQuery(".custom_toggle").click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2]; 
		if(jQuery(this).hasClass('active')){
			jQuery(this).removeClass('active');
			jQuery("#custom_toggle_content_"+data_id).slideUp();
		}else{
			jQuery(this).addClass('active');
			jQuery("#custom_toggle_content_"+data_id).slideDown();
		}
    });
});
/* END Custom toggle */

/* END custom_manage_checklist_task.php ADD CHECKLIST */

/* custom_manage_checklists.php EDIT TEMPLATE CHECKLIST */
jQuery(document).ready(function(){	
	jQuery( "#dialog_form_edit_checklist_template" ).dialog({
		autoOpen: false,
		height: 130,
		width: 350,
		modal: true,
		close: function() {
		}
	});
	jQuery('.checklist_template_edit').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[3];
		jQuery('#checklist_template_loader_'+data_id).show();		
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'edit_checklist_template',
				'data_id' : data_id				
			},
			success: function (data) {
				var data_split = data.split('_');
				var template_id = data_split[0];
				var template_name = data_split[1];
				jQuery('#checklist_template_loader_'+template_id).hide();
				jQuery('#dialog_form_edit_checklist_template .checklist_template_id').val(template_id);
				jQuery('#dialog_form_edit_checklist_template .checklist_template_name').val(template_name);
				jQuery('#dialog_form_edit_checklist_template .checklist_current_template_name').val(template_name);
				jQuery('#dialog_form_edit_checklist_template').dialog('open');
			},
			error: function (data) {				
				
			}
		});		
	});
	jQuery('.update_checklist_template').click(function(){
		jQuery('.edit_checklist_template_loader').show();
		var update_checklist_template_details = jQuery('#edit_checklist_template_form').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'update_checklist_template',
				'update_checklist_template_details' : update_checklist_template_details				
			},
			success: function (data) {
				jQuery('.edit_checklist_template_loader').hide();
				var data_split = data.split('<_>');
				var edited_template = data_split[0];
				var current_title_class = data_split[1];
				var title_class = edited_template.replace(/\s+/g, '_').toLowerCase();
				jQuery('.manage_checklist_template_category_items .display_section.template h3.'+current_title_class).html(edited_template);	
				jQuery('.manage_checklist_template_category_items .display_section.template h3.'+current_title_class).addClass(title_class);				
				jQuery('.manage_checklist_template_category_items .display_section.template h3').removeClass(current_title_class);
								
				jQuery('#dialog_form_edit_checklist_template').dialog('close');
			},
			error: function (data) {
				
			}
		});	
	});
});
/* END custom_manage_checklists.php EDIT TEMPLATE CHECKLIST */

/* END custom_manage_checklists.php DELETE TEMPLATE CHECKLIST */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_delete_checklist_template" ).dialog({
		autoOpen: false,
		height: 180,
		width: 350,
		modal: true,
		close: function() {
		}
	});
	jQuery('.checklist_template_delete').click(function(){		
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[3];
		jQuery('#checklist_template_loader_'+data_id).show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'confirm_delete_checklist_template',
				'data_id' : data_id				
			},
			success: function (data) {								
				var data_split = data.split('_');
				var template_id = data_split[0];
				var template_name = data_split[1];
				jQuery('#checklist_template_loader_'+template_id).hide();
				jQuery('#dialog_form_delete_checklist_template .checklist_template_id').val(template_id);
				jQuery('#dialog_form_delete_checklist_template .checklist_template_name').text(template_name);
				jQuery('#dialog_form_delete_checklist_template .checklist_template_name').val(template_name);
				jQuery('#dialog_form_delete_checklist_template .checklist_current_template_name').val(template_name);
				jQuery('#dialog_form_delete_checklist_template').dialog('open');
			},
			error: function (data) {
				
			}
		});	
	});
	jQuery('.delete_checklist_template').click(function(){		
		var delete_checklist_template_details = jQuery('#delete_checklist_template_form').serialize();
		jQuery('.delete_checklist_template_loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'delete_checklist_template',
				'delete_checklist_template_details' : delete_checklist_template_details				
			},
			success: function (data) {
				jQuery('.delete_checklist_template_loader').hide();
				jQuery('#dialog_form_delete_checklist_template').dialog('close');
				jQuery('#template_display_'+data).remove();
			},
			error: function (data) {
				
			}
		});	
	});
});
/* END custom_manage_checklists.php DELETE TEMPLATE CHECKLIST */

/* custom_manage_checklists.php EDIT CATEGORY CHECKLIST */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_edit_checklist_category" ).dialog({
		autoOpen: false,
		height: 130,
		width: 350,
		modal: true,
		close: function() {
		}
	});
	jQuery('.checklist_category_edit').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[3];
		jQuery('#checklist_category_loader_'+data_id).show();		
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'edit_checklist_category',
				'data_id' : data_id				
			},
			success: function (data) {
				var data_split = data.split('_');
				var category_id = data_split[0];
				var category_name = data_split[1];
				jQuery('#checklist_category_loader_'+category_id).hide();
				jQuery('#dialog_form_edit_checklist_category .checklist_category_id').val(category_id);
				jQuery('#dialog_form_edit_checklist_category .checklist_category_name').val(category_name);
				jQuery('#dialog_form_edit_checklist_category .checklist_current_category_name').val(category_name);
				jQuery('#dialog_form_edit_checklist_category').dialog('open');
			},
			error: function (data) {				
				
			}
		});		
	});
	jQuery('.update_checklist_category').click(function(){
		jQuery('.edit_checklist_category_loader').show();
		var update_checklist_category_details = jQuery('#edit_checklist_category_form').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'update_checklist_category',
				'update_checklist_category_details' : update_checklist_category_details				
			},
			success: function (data) {
				jQuery('.edit_checklist_category_loader').hide();
				var data_split = data.split('<_>');
				var edited_category = data_split[0];
				var current_toggle_class = data_split[1];
				var toggle_class = edited_category.replace(/\s+/g, '_').toLowerCase();
				jQuery('.manage_checklist_template_category_items .display_list.'+current_toggle_class+ ' h3.display_subtitle').html(edited_category);	
				jQuery('.manage_checklist_template_category_items .display_list.'+current_toggle_class).addClass(toggle_class);				
				jQuery('.manage_checklist_template_category_items .display_list').removeClass(current_toggle_class);
				
				jQuery('#dialog_form_edit_checklist_category').dialog('close');
			},
			error: function (data) {
				
			}
		});	
	});
});
/* END custom_manage_checklists.php EDIT CATEGORY CHECKLIST */

/* custom_manage_checklists.php DELETE CATEGORY CHECKLIST */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_delete_checklist_category" ).dialog({
		autoOpen: false,
		height: 180,
		width: 350,
		modal: true,
		close: function() {
		}
	});
	jQuery('.checklist_category_delete').click(function(){		
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[3];
		jQuery('#checklist_category_loader_'+data_id).show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'confirm_delete_checklist_category',
				'data_id' : data_id				
			},
			success: function (data) {
				var data_split = data.split('_');
				var category_id = data_split[0];
				var category_name = data_split[1];
				jQuery('#checklist_category_loader_'+category_id).hide();
				jQuery('#dialog_form_delete_checklist_category .checklist_category_id').val(category_id);
				jQuery('#dialog_form_delete_checklist_category input.checklist_category_name').val(category_name);
				jQuery('#dialog_form_delete_checklist_category .checklist_category_name').text(category_name);
				
				jQuery('#dialog_form_delete_checklist_category').dialog('open');
			},
			error: function (data) {
				
			}
		});
	});
	jQuery('.delete_checklist_category').click(function(){
		jQuery('.delete_checklist_category_loader').show();
		var delete_checklist_category_details = jQuery('#delete_checklist_category_form').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'delete_checklist_category',
				'delete_checklist_category_details' : delete_checklist_category_details				
			},
			success: function (data) {
				jQuery('.delete_checklist_category_loader').hide();
				jQuery('#dialog_form_delete_checklist_category').dialog('close');
				jQuery( ".manage_checklist_template_category_items .display_list."+data).closest( ".li_category_container" ).remove();				
			},
			error: function (data) {
				
			}
		});
	});
});
/* END custom_manage_checklists.php DELETE CATEGORY CHECKLIST */

/* custom_manage_checklists.php EDIT CHECKLIST */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_edit_checklist" ).dialog({
		autoOpen: false,
		height: 130,
		width: 350,
		modal: true,
		close: function() {
		}
	});		
	jQuery('.checklist_edit').click(function(){		
		var checklist_div_id = jQuery(this).attr('id');
		var div_id_split = checklist_div_id.split('_');
		var checklist_category = div_id_split[2];
		var checklist_key = div_id_split[3];
		jQuery('#checklist_'+checklist_category+'_'+checklist_key+'.loader').show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'edit_checklist',
				'checklist_div_id' : checklist_div_id				
			},
			success: function (data) {
				jQuery('#checklist_'+checklist_category+'_'+checklist_key+'.loader').hide();
				jQuery("#dialog_form_edit_checklist").html(data);
				jQuery("#dialog_form_edit_checklist").dialog( "open" );
				trigger_update_checklist();
			},
			error: function (data) {
				
			}
		});	
	});
});
function trigger_update_checklist(){	
	jQuery('.modal_save_edit_checklist').click(function(){
		jQuery('#edit_modal_checklist .loader').show();
		var div_id = jQuery(this).attr('id');
		var checklist_update_edit_details = jQuery('#edit_modal_checklist').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'update_edit_checklist',
				'checklist_update_edit_details' : checklist_update_edit_details				
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var checklist_category = parsed.checklist_category;
				var checklist_name = parsed.checklist_name;				
				var checklist_description = parsed.checklist_description;				
				var checklist_key = parsed.checklist_key;
				var checklist_category_id = parsed.checklist_category_id;
				jQuery('h3#checklist_'+checklist_category_id+'_'+checklist_key).text(checklist_name);
				jQuery('#checklist_description_'+checklist_category_id+'_'+checklist_key).text(checklist_description);
				jQuery("#dialog_form_edit_checklist").dialog( "close" );
			},
			error: function (data) {
				
			}
		});	
	});
}
/* END custom_manage_checklists.php EDIT CHECKLIST */

/* custom_manage_checklists.php DELETE CHECKLIST */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_delete_checklist" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});	
	
	jQuery('.checklist_delete').click(function(){		
		var checklist_div_id = jQuery(this).attr('id');
		var div_id_split = checklist_div_id.split('_');
		var checklist_category = div_id_split[2];
		var checklist_key = div_id_split[3];
		jQuery('#checklist_'+checklist_category+'_'+checklist_key+'.loader').show();
		jQuery('#check_item_loader_'+checklist_key).show();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'confirm_delete_checklist',
				'checklist_div_id' : checklist_div_id				
			},
			success: function (data) {
				jQuery('#checklist_'+checklist_category+'_'+checklist_key+'.loader').hide();
				jQuery('#check_item_loader_'+checklist_key).hide();
				jQuery("#dialog_form_delete_checklist").html(data);
				jQuery("#dialog_form_delete_checklist").dialog( "open" );
				trigger_delete_checklist();
			},
			error: function (data) {
				
			}
		});	
	});	
});
function trigger_delete_checklist(){
	jQuery('.modal_save_delete_checklist').click(function(){
		jQuery('#delete_modal_checklist .loader').show();
		var div_id = jQuery(this).attr('id');
		var checklist_delete_details = jQuery('#delete_modal_checklist').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'delete_checklist',
				'checklist_delete_details' : checklist_delete_details				
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var checklist = parsed.checklist;
				var checklist_category_name = parsed.checklist_category_name;
				var checklist_key = parsed.checklist_key;
				var checklist_category_id = parsed.checklist_category_id;				
				jQuery('#checklist_display_'+checklist_category_id+'_'+checklist_key).remove();
				jQuery("#dialog_form_delete_checklist").dialog( "close" );
			},
			error: function (data) {
				
			}
		});	
	});
}
/* END custom_manage_checklists.php DELETE CHECKLIST */

/* END custom_manage_checklists.php DRAG DROP CATEGORY CHECKLIST */
jQuery(document).ready(function(){
	jQuery('#category_sort_priority').sortable({
		stop: function(event, ui) {
			var this_div_id = jQuery(ui.item).attr('id');
			var this_div_id_split = this_div_id.split('_');
			var this_data_id = this_div_id_split[2];
			jQuery('#checklist_category_loader_'+this_data_id).show();
			var category_priority_item = {};
			var category_priority_details = {};
			jQuery(this).children().each(function(category_priority, value){					
				var div_id = jQuery(value).attr('id');
				var div_id_split = div_id.split('_');
				var data_id = div_id_split[2];				
				category_priority_item[category_priority + 1] = data_id;
			});
			category_priority_details['this_data_id'] = this_data_id;
			category_priority_details['category_priority_details'] = category_priority_item;
			
			jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
				data:{
					'type' : 'checklist_category_priority',
					'category_priority_details' : category_priority_details				
				},
				success: function (data) {
					jQuery('#checklist_category_loader_'+data).hide();
				},
				error: function (data) {
					
				}
			});				
		}
	});
	jQuery('#category_sort_priority').disableSelection();
});
/* custom_manage_checklists.php DRAG DROP CATEGORY CHECKLIST */

/* custom_manage_projects.php DELETE */
jQuery(document).ready(function(){
	jQuery( ".dialog_form_delete_ajax" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});	
	jQuery('.delete_ajax').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		var delete_name = jQuery('#name_'+data_id).text();		
		if (jQuery(".delete_ajax_parent").length > 0) {			
			var delete_parent_div = jQuery(this).parentsUntil(".delete_ajax_parent").find("h2").text();			
			if(delete_parent_div.length != 0){				
				jQuery(".delete_action_ajax .delete_name").text(delete_name);
				jQuery('.delete_parent').html(delete_parent_div  + '<span class="q_mark">?</span>');
				jQuery('.delete_parent').show();
				jQuery('.delete_prep').show();				
			}
		}else{
			jQuery(".delete_action_ajax .delete_name").html(delete_name + '<span class="q_mark">?</span>');
		}
		
		jQuery(".delete_action_ajax .delete_id").val(data_id);
		jQuery(".dialog_form_delete_ajax").dialog( "open" );		
	});
	
	jQuery('.delete_button_ajax').click(function(){
		jQuery('.delete_ajax_loader').show();
		var delete_ajax_details = jQuery('.delete_action_ajax').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'delete_ajax',
				'delete_ajax_details' : delete_ajax_details				
			},
			success: function (data) {
				jQuery('.delete_ajax_'+data).remove();
				jQuery('.delete_ajax_loader').hide();
				jQuery(".dialog_form_delete_ajax").dialog( "close" );
			},
			error: function (data) {
				
			}
		});	
	});
});
/* END custom_manage_projects.php DELETE */

/* custom_manage_people.php ARCHIVE */
jQuery(document).ready(function(){
	jQuery( "#dialog_form_archive_people" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});
	jQuery('.archive_person_button').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		var person_name = jQuery('.display_list h3#name_'+data_id).text();
		jQuery('#archive_person .span_bold').text(person_name);
		jQuery('#archive_person .person_id').val(data_id);
		jQuery('#archive_person .person_name').val(person_name);
		jQuery('#dialog_form_archive_people').dialog('open');
	});
	jQuery('.archive_person').click(function(){
		jQuery('#archive_person .loader').show();
		var person_details = jQuery('#archive_person').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'archive_person',
				'person_details' : person_details				
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var person_name = parsed.person_name;
				var person_id = parsed.person_id;				
				var person_hourly_rate = parsed.person_hourly_rate;				
				var person_permission = parsed.person_permission;	
				var current_active_count = jQuery('.active_people_header .person_count').text();
				var current_inactive_count = jQuery('.inactive_people_header .person_count').text();
				var active_people_count = parseInt(current_active_count) - 1;
				var inactive_people_count = parseInt(current_inactive_count) + 1;
				jQuery('.display_section_archive_'+person_id).remove();				
				jQuery('.active_people_header span.person_count').text(active_people_count);
				jQuery('.inactive_people_header span.person_count').text(inactive_people_count);				
				jQuery('.inactive_people_container').append('<div class="display_section display_section_unarchive_'+person_id+' delete_ajax_'+person_id+'">'
				+'<div class="display_list" onclick="window.location="/person-information/?id='+person_id+'";">'
				+'<a class="button_2 display_button" href="/edit-people/?editID='+person_id+'">Edit</a>'
				+'<h3 id="name_'+person_id+'" class="display_subtitle float_left">'+person_name+'</h3>'
				+'<p class="display_hourly_rate">(kr '+person_hourly_rate+'/hr)</p>'
				+'<p class="display_permission">'+person_permission+'</p>'
				+'</div>'
				+'<div class="ajax_action_buttons">'
				+'<div id="delete_person_'+person_id+'" class="button_2 display_button float_right delete_person_button delete_ajax">Delete</div>'
				+'<div id="unarchive_person_'+person_id+'" class="button_2 display_button float_right unarchive_person_button">Unarchive</div>'
				+'</div>'
				+'<div class="display_separator"></div>'
				+'</div>'
				);
				jQuery("#dialog_form_archive_people").dialog( "close" );
				trigger_unarchive_person();
			},
			error: function (data) {
				
			}
		});	
	});
	
	jQuery( "#dialog_form_unarchive_people" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});
	jQuery('.unarchive_person_button').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		var person_name = jQuery('.display_list h3#name_'+data_id).text();
		jQuery('#unarchive_person .span_bold').text(person_name);
		jQuery('#unarchive_person .person_id').val(data_id);
		jQuery('#unarchive_person .person_name').val(person_name);
		jQuery('#dialog_form_unarchive_people').dialog('open');
	});
	jQuery('.unarchive_person').click(function(){
		jQuery('#unarchive_person .loader').show();
		var person_details = jQuery('#unarchive_person').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'unarchive_person',
				'person_details' : person_details				
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var person_name = parsed.person_name;
				var person_id = parsed.person_id;				
				var person_hourly_rate = parsed.person_hourly_rate;				
				var person_permission = parsed.person_permission;	
				var current_active_count = jQuery('.active_people_header .person_count').text();
				var current_inactive_count = jQuery('.inactive_people_header .person_count').text();
				var active_people_count = parseInt(current_active_count) + 1;
				var inactive_people_count = parseInt(current_inactive_count) - 1;
				jQuery('.display_section_unarchive_'+person_id).remove();				
				jQuery('.active_people_header span.person_count').text(active_people_count);
				jQuery('.inactive_people_header span.person_count').text(inactive_people_count);				
				jQuery('.active_people_container').append('<div class="display_section display_section_archive_'+person_id+' delete_ajax_'+person_id+'">'
				+'<div class="display_list" onclick="window.location="/person-information/?id='+person_id+'";">'
				+'<a class="button_2 display_button" href="/edit-people/?editID='+person_id+'">Edit</a>'
				+'<h3 id="name_'+person_id+'" class="display_subtitle float_left">'+person_name+'</h3>'
				+'<p class="display_hourly_rate">(kr '+person_hourly_rate+'/hr)</p>'
				+'<p class="display_permission">'+person_permission+'</p>'
				+'</div>'
				+'<div class="ajax_action_buttons">'
				+'<div id="delete_person_'+person_id+'" class="button_2 display_button float_right delete_person_button delete_ajax">Delete</div>'
				+'<div id="archive_person_'+person_id+'" class="button_2 display_button float_right archive_person_button">Archive</div>'
				+'</div>'
				+'<div class="display_separator"></div>'
				+'</div>'
				);
				jQuery("#dialog_form_unarchive_people").dialog( "close" );				
			},
			error: function (data) {
				
			}
		});	
	});
});
function trigger_archive_person(){
	jQuery( "#dialog_form_archive_people" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});
	jQuery('.archive_person_button').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		var person_name = jQuery('.display_list h3#name_'+data_id).text();
		jQuery('#archive_person .span_bold').text(person_name);
		jQuery('#archive_person .person_id').val(data_id);
		jQuery('#archive_person .person_name').val(person_name);
		jQuery('#dialog_form_archive_people').dialog('open');
	});
	jQuery('.archive_person').click(function(){
		jQuery('#archive_person .loader').show();
		var person_details = jQuery('#archive_person').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'archive_person',
				'person_details' : person_details				
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var person_name = parsed.person_name;
				var person_id = parsed.person_id;				
				var person_hourly_rate = parsed.person_hourly_rate;				
				var person_permission = parsed.person_permission;	
				var current_active_count = jQuery('.active_people_header .person_count').text();
				var current_inactive_count = jQuery('.inactive_people_header .person_count').text();
				var active_people_count = parseInt(current_active_count) - 1;
				var inactive_people_count = parseInt(current_inactive_count) + 1;
				jQuery('.display_section_archive_'+person_id).remove();				
				jQuery('.active_people_header span.person_count').text(active_people_count);
				jQuery('.inactive_people_header span.person_count').text(inactive_people_count);				
				jQuery('.inactive_people_container').append('<div class="display_section display_section_unarchive_'+person_id+' delete_ajax_'+person_id+'">'
				+'<div class="display_list" onclick="window.location="/person-information/?id='+person_id+'";">'
				+'<a class="button_2 display_button" href="/edit-people/?editID='+person_id+'">Edit</a>'
				+'<h3 id="name_'+person_id+'" class="display_subtitle float_left">'+person_name+'</h3>'
				+'<p class="display_hourly_rate">(kr '+person_hourly_rate+'/hr)</p>'
				+'<p class="display_permission">'+person_permission+'</p>'
				+'</div>'
				+'<div class="ajax_action_buttons">'
				+'<div id="delete_person_'+person_id+'" class="button_2 display_button float_right delete_person_button delete_ajax">Delete</div>'
				+'<div id="unarchive_person_'+person_id+'" class="button_2 display_button float_right unarchive_person_button">Unarchive</div>'
				+'</div>'
				+'<div class="display_separator"></div>'
				+'</div>'
				);
				jQuery("#dialog_form_archive_people").dialog( "close" );				
			},
			error: function (data) {
				
			}
		});	
	});
}
function trigger_unarchive_person(){
	jQuery( "#dialog_form_unarchive_people" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		close: function() {
		}
	});
	jQuery('.unarchive_person_button').click(function(){
		var div_id = jQuery(this).attr('id');
		var div_id_split = div_id.split('_');
		var data_id = div_id_split[2];
		var person_name = jQuery('.display_list h3#name_'+data_id).text();
		jQuery('#unarchive_person .span_bold').text(person_name);
		jQuery('#unarchive_person .person_id').val(data_id);
		jQuery('#unarchive_person .person_name').val(person_name);
		jQuery('#dialog_form_unarchive_people').dialog('open');
	});
	jQuery('.unarchive_person').click(function(){
		jQuery('#unarchive_person .loader').show();
		var person_details = jQuery('#unarchive_person').serialize();
		jQuery.ajax({
			type: "POST",
			url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
			data:{
				'type' : 'unarchive_person',
				'person_details' : person_details				
			},
			success: function (data) {
				var parsed = jQuery.parseJSON(data);
				var person_name = parsed.person_name;
				var person_id = parsed.person_id;				
				var person_hourly_rate = parsed.person_hourly_rate;				
				var person_permission = parsed.person_permission;	
				var current_active_count = jQuery('.active_people_header .person_count').text();
				var current_inactive_count = jQuery('.inactive_people_header .person_count').text();
				var active_people_count = parseInt(current_active_count) + 1;
				var inactive_people_count = parseInt(current_inactive_count) - 1;
				jQuery('.display_section_unarchive_'+person_id).remove();				
				jQuery('.active_people_header span.person_count').text(active_people_count);
				jQuery('.inactive_people_header span.person_count').text(inactive_people_count);				
				jQuery('.active_people_container').append('<div class="display_section display_section_archive_'+person_id+' delete_ajax_'+person_id+'">'
				+'<div class="display_list" onclick="window.location="/person-information/?id='+person_id+'";">'
				+'<a class="button_2 display_button" href="/edit-people/?editID='+person_id+'">Edit</a>'
				+'<h3 id="name_'+person_id+'" class="display_subtitle float_left">'+person_name+'</h3>'
				+'<p class="display_hourly_rate">(kr '+person_hourly_rate+'/hr)</p>'
				+'<p class="display_permission">'+person_permission+'</p>'
				+'</div>'
				+'<div class="ajax_action_buttons">'
				+'<div id="delete_person_'+person_id+'" class="button_2 display_button float_right delete_person_button delete_ajax">Delete</div>'
				+'<div id="archive_person_'+person_id+'" class="button_2 display_button float_right archive_person_button">Archive</div>'
				+'</div>'
				+'<div class="display_separator"></div>'
				+'</div>'
				);
				jQuery("#dialog_form_unarchive_people").dialog( "close" );				
			},
			error: function (data) {
				
			}
		});	
	});
}
/* END custom_manage_people.php ARCHIVE */

/* custom_add_client_portal.php ADD MORE */
jQuery(document).ready(function(){
	var counter = 1;
	jQuery('.add_more_client_portal').click(function(){
		var client_portal_info = jQuery('.client_portal_info').val();
		var client_portal_url = jQuery('.client_portal_url').val();
		var client_portal_login = jQuery('.client_portal_login').val();
		var client_portal_password = jQuery('.client_portal_password').val();
		jQuery('.client_portal_container').append('<li class="client_portal_list" id="client_portal_'+counter+'">'
		+'<div class="client_portal_width">'
		+'<input type="hidden" name="client_portal_info" value="'+client_portal_info+'"/><p>'+client_portal_info+'</p>'
		+'<input type="hidden" name="client_portal_url" value="'+client_portal_url+'"/><p>'+client_portal_url+'</p>'
		+'<input type="hidden" name="client_portal_login" value="'+client_portal_login+'"/><p>'+client_portal_login+'</p>'
		+'<input type="hidden" name="client_portal_password" value="'+client_portal_password+'"/><p>'+client_portal_password+'</p>'
		+'<div id="client_portal_delete_'+counter+'" class="confirm client_portal_delete button_2 subtask_action_button">D</div>'
		+'<div id="client_portal_edit_'+counter+'" class="client_portal_edit button_2 subtask_action_button">E</div>'
		+'</div>'
		+'</li>'
		+'<div class="edit_div" id="edit_div_'+counter+'" style="display:none;">'
		+'<input type="text" id="client_portal_info_edit_area_'+counter+'" class="client_portal_info_edit_area" />'
		+'<input type="text" id="client_portal_url_edit_area_'+counter+'" class="client_portal_url_edit_area" />'
		+'<input type="text" id="client_portal_login_edit_area_'+counter+'" class="client_portal_login_edit_area" />'
		+'<input type="text" id="client_portal_password_edit_area_'+counter+'" class="client_portal_password_edit_area" />'
		+'<div id="check_edit_'+counter+'" class="check_edit"></div>'
		+'</div>'
		);
		jQuery(".goals").val("");
		counter++;
		jQuery('.client_portal_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(11, div_id.length);
			var edit_data = jQuery('#goals_'+data_id+' p').text();
			jQuery('#goals_'+data_id).hide();
			jQuery('#edit_div_'+data_id).css('display', 'block');
			jQuery('#goals_edit_area_'+data_id).val(edit_data);
		});
		jQuery('.check_edit').click(function(){
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(11, div_id.length);
			var edited_value = jQuery('#goals_edit_area_'+data_id).val();
			jQuery('#edit_div_'+data_id).css('display', 'none');
			jQuery('#goals_'+data_id).show();
			jQuery('#goals_'+data_id+' p').text(edited_value);
		});		
		jQuery('.goals_delete').click(function(){		
			var div_id = jQuery(this).attr('id');
			var data_id = div_id.substring(13, div_id.length);
			jQuery('#goals_'+data_id).remove();
			jQuery('#edit_div_'+data_id).remove();
		});		
	});
})		
/* END custom_add_client_portal.php ADD MORE */

//DETAILED TIME REPORT PAGE JQUERIES
jQuery(document).ready(function(){

	jQuery('#print_document').click(function(){
	    var divContents = $("#main").html();
	    var printWindow = window.open('', '', 'height=500,width=1100');
	    printWindow.document.write('<html><head><title>DIV Contents</title>');
	    printWindow.document.write('<link rel="stylesheet" id="custom" href="http://localhost/dplan/wp-content/themes/Avada/custom.css?ver=1" type="text/css" media="all" />');
	    printWindow.document.write('</head><body>');
	    printWindow.document.write(divContents);
	    printWindow.document.write('</body></html>');
	    printWindow.document.close();
	    printWindow.print();
	});
	//Load Client's Projects dropdown for Detailed time report page.
	jQuery(document).on('dblclick', '.detailed_time_edit_project_name', function(){
		var string = jQuery(this).attr('id').split("_");
		var column_id = string[2];
		var type = string[0];

		var client = jQuery('#detailed_time_clientname_'+column_id).val();

		var project_name = jQuery('#project_name_'+column_id+' p').text();

		jQuery('#project_name_loader_'+column_id).show();

		var entry = {
			client_name : client,
			id : column_id,
			type : type,
			project_current_selected : project_name
		};

		jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

				data:{
					'type' : 'detailed_time_get_client_projects',
					'edit_project_entry' : entry
				},
				success: function (data) {				
					var parsed = jQuery.parseJSON(data);
					jQuery('#project_name_'+column_id).html('<input id="detailed_time_clientname_'+column_id+'" type="hidden" value="'+client+'">'+parsed.option_dropdown);
					// jQuery('#project_loader_'+column_id).css('display', 'none');
				},

				error: function (data) {
					alert('error');
				}				

		});	
	});

	jQuery(document).on('dblclick', '.detailed_time_edit_taskname', function(){

		var string = jQuery(this).attr('id').split("_");
		var column_id = string[2];
		var client = jQuery('#detailed_time_clientname_'+column_id).val();

		var taskname = jQuery('#taskname_id_'+column_id+' p').text();

		jQuery('#taskname_loader_'+column_id).show();

		var entry = {
			client_name : client,
			id : column_id,
			taskname_current_selected : taskname
		};

		jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

				data:{
					'type' : 'detailed_time_edit_taskname',
					'edit_taskname_entry' : entry
				},
				success: function (data) {				
					var parsed = jQuery.parseJSON(data);
					// console.log(parsed);
					jQuery('#taskname_id_'+column_id).html(parsed.option_dropdown);
					// jQuery('#taskname_loader_'+column_id).css('display', 'none');
				},

				error: function (data) {
					alert('error');
				}				
		});	
	});

	jQuery(document).on('click', '.check_update_detailed_time_taskname', function(){
		var string = jQuery(this).attr('id').split("_");
		var id = string[2];
		var select_value = jQuery('#taskname_id_'+id+' select').val();

		jQuery(this).remove();
		jQuery('#taskname_loader_'+id).show();

		var taskname_edit_entry = {
			taskname_id: id,
			taskname: select_value
		}

		jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

				data:{
					'type' : 'save_editing_taskname_to_db',
					'taskname_editing_value' : taskname_edit_entry
				},
				success: function (data) {				
					var parsed = jQuery.parseJSON(data);
					if(parsed.status == 'success-update-timesheet'){
						jQuery('#taskname_id_'+parsed.taskname_id).html(parsed.taskname_name);
						jQuery('#taskname_loader_'+parsed.taskname_id).css('display', 'none');
						// jQuery('.action_message p').text("Taskname Updated.");
						// jQuery('<div class="info_help" id="edited_data_'+id+'"></div><p class="edit_note" style="display: none;" id="edited_note_id_'+id+'">Edited By: '+parsed.edited_by+' </p>').insertAfter('.task-complete #delete_loader_'+id);
						// jQuery('.action_message').fadeIn( "slow", function() {
						// 	jQuery(".action_message").delay(1000).fadeOut('slow');
						// });

					}else{

					}
				},

				error: function (data) {
					alert('error');
				}				

		});	

	});


	jQuery(document).on('click', '.detailed_time_update_project', function(){
		var string = jQuery(this).attr('id').split("_");
		var id = string[2];
		var select_value = jQuery('#project_name_'+id+' select').val();
		var clientname = jQuery("#detailed_time_clientname_"+id).val();

		jQuery('#project_loader_'+id).show();
		jQuery(this).remove();

		var project_edit_entry = {
			project_id: id,
			project_name: select_value
		}

		jQuery.ajax({
				type: "POST",
				url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',

				data:{
					'type' : 'detailed_time_update_project',
					'project_editing_value' : project_edit_entry
				},
				success: function (data) {				
				var parsed = jQuery.parseJSON(data);
				if(parsed.status == 'success-update-timesheet'){
					jQuery('#project_name_'+parsed.project_id+' select').remove();
					jQuery('#project_name_'+parsed.project_id).html('<input id="detailed_time_clientname_'+id+'" type="hidden" value="'+clientname+'"><p>'+parsed.project_name+'</p>');
					jQuery('#project_loader_'+parsed.project_id).css('display', 'none');
					jQuery('.action_message p').text("Project Updated.");
					jQuery('.action_message').fadeIn( "slow", function() {
						jQuery(".action_message").delay(1000).fadeOut('slow');

					});

				}else{

				}
				},
				error: function (data) {
					alert('error');
				}				
		});	
	});
});

/* CLIENT INFO */
jQuery(document).ready(function(){
	jQuery( ".dialog_client_information" ).dialog({
		autoOpen: false,
		height: 500,
		width: 900,
		modal: true,
		close: function() {
		}
	});
	
	
	var click_delay = 250, clicks = 0, timer = null;
	
	jQuery(document).on('click', '.client_info', function(){
		var client_name = jQuery(this).text();
		if (timer == null) {
			timer = setTimeout(function() {
				clicks = 0;
				timer = null;
				jQuery('body').addClass('wait');
				jQuery('.dialog_client_information .site_container').empty();
				jQuery.ajax({
					type: "POST",
					url: '<?php bloginfo("template_directory"); ?>/custom_ajax-functions.php',
					data:{
						'type' : 'client_information',
						'client_name' : client_name				
					},
					success: function (data) {
						var parsed = jQuery.parseJSON(data);
						var client_infomation = parsed.client_information;
						var client_infomation_split = client_infomation.split('<_>');
						var client_name = client_infomation_split[0];
						var client_address = client_infomation_split[1];
						var client_contact_person = client_infomation_split[2];
						var client_contact_phone = client_infomation_split[3];
						var client_contact_email = client_infomation_split[4];
						var client_monthly_plan = client_infomation_split[5];
						var client_satisfaction = client_infomation_split[6];
						
						var current_active_webdev_projects = parsed.current_active_webdev_projects
						jQuery('.dialog_client_information .client_name').text(client_name);
						jQuery('.dialog_client_information .client_address').text(client_address);
						jQuery('.dialog_client_information .client_contact_person').text(client_contact_person);
						jQuery('.dialog_client_information .client_contact_phone').text(client_contact_phone);
						jQuery('.dialog_client_information .client_contact_email').text(client_contact_email);
						jQuery('.dialog_client_information .client_monthly_plan').text(client_monthly_plan);
						jQuery('.dialog_client_information .client_satisfaction').text(client_satisfaction);
						jQuery('.dialog_client_information .current_active_webdev_projects').text(current_active_webdev_projects);
						
						if(parsed.client_site_information != null && parsed.client_site_information != 'undefined'){
							jQuery.each(parsed.client_site_information, function(index, values){					
								var client_site_information_split = values.split('<_>');
								var site_url = client_site_information_split[0];
								var site_type = client_site_information_split[1];
								var site_platform = client_site_information_split[2];
								var site_wp_version = client_site_information_split[3];
								var site_username = client_site_information_split[4];
								var site_password = client_site_information_split[5];
								var site_login_url = client_site_information_split[6];
								jQuery('.dialog_client_information .site_container').append('<div class="info_div">'
								+'<div class="first_column column">'+site_url+'</div>'
								+'<div class="second_column column">'+site_type+'</div>'
								+'<div class="third_column column">'+site_platform+'</div>'
								+'<div class="fourth_column column">'+site_wp_version+'</div>'
								+'<div class="fifth_column column">'+site_username+'</div>'
								+'<div class="sixth_column column">'+site_password+'</div>'
								+'<div class="seventh_column column">'
								+'<a class="button_2 display_button" href="'+site_login_url+'">L</a>'
								+'</div>'
								+'</div>'
								);
							});
						}
						jQuery('.dialog_client_information').dialog('open');
						jQuery('body').removeClass('wait');
					},
					error: function (data) {
						
					}
				});	
			}, click_delay);
		}
		
		if(clicks === 1) {
			clearTimeout(timer);
			timer = null;
			clicks = -1;
			// alert("double_click");
		}
		clicks++;
	});	
});
/* END CLIENT INFO */
/* FIND URL */
function find_url(text)
{
	var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
	return text.replace(exp,"<a href='$1'>$1</a>"); 
}
/* END FIND URL */

/* TEXTAREA AUTO HEIGHT */
function textAreaAdjust(o) {
	o.style.height = "1px";
	o.style.height = (25+o.scrollHeight)+"px";
}
/* END TEXTAREA AUTO HEIGHT */

/* REQUIRED INPUT */
function required_input(){
	var ret_val = true;
	jQuery('label.input_error').remove();
	jQuery('.required').each(function(){
		jQuery(this).removeClass('input_error');
		var field_val = jQuery(this).val();
		var id_attr = jQuery(this).attr('id'); 
		if(field_val!='')		
		if(id_attr == 'email_address'){
			var emailRegex = new RegExp(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
			var valid = emailRegex.test(field_val);
			if (!valid){
				jQuery(this).addClass('input_error');
				ret_val = false;
			}
		}
		if(jQuery(this).is(':visible')) {
			if(field_val == null || field_val == '' ){			
				jQuery(this).addClass('input_error');
				jQuery('<label generated="true" class="input_error_message">This field is required.</label>').insertAfter(this);
				ret_val = false;
			}
		}
		
	});
	return ret_val;
}
/* END REQUIRED INPUT */

/*  HOUR TO DECIMAL */
function timeStringToFloat(time) {
  var hoursMinutes = time.split(/[.:]/);
  var hours = parseInt(hoursMinutes[0], 10);
  var minutes = hoursMinutes[1] ? parseInt(hoursMinutes[1], 10) : 0;
  return hours + minutes / 60;
}
/*  END HOUR TO DECIMAL */
</script>	
</head>
<?php
require_once('function_page_timesheet_js.php');
require_once('function_manage_website_js.php');
require_once('function_manage_submit_task_js.php');
require_once('function_client_js.php');
require_once('function_reports_inventory_js.php');
?>
<?php
	$body_class = '';
	$wrapper_class = '';
	if(is_page_template('blank.php')):
	$body_class = 'body_blank';
	$wrapper_class = ' class="wrapper_blank"';
endif; ?>

<body <?php body_class(array($avada_color_scheme,$body_class, "body_id_" . $post->post_name)); ?>>
	<div id="fb-root"></div>
	<script type="text/javascript">	
(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=1603844059888195";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div id="wrapper" <?php echo $wrapper_class; ?>>
	<?php if($data['slidingbar_widgets'] && !is_page_template('blank.php')): ?>
	<?php get_template_part('slidingbar'); ?>
	<?php endif; ?>
		<?php if(!is_page_template('blank.php')): ?>
		<div class="header-wrapper">
			<?php
			if($data['header_layout']) {
				if(is_page('header-2')) {
					get_template_part('framework/headers/header-v2');
				} elseif(is_page('header-3')) {
					get_template_part('framework/headers/header-v3');
				} elseif(is_page('header-4')) {
					get_template_part('framework/headers/header-v4');
				} elseif(is_page('header-5')) {
					get_template_part('framework/headers/header-v5');
				} else {
					get_template_part('framework/headers/header-'.$data['header_layout']);
				}
			} else {
				if(is_page('header-2')) {
					get_template_part('framework/headers/header-v2');
				} elseif(is_page('header-3')) {
					get_template_part('framework/headers/header-v3');
				} elseif(is_page('header-4')) {
					get_template_part('framework/headers/header-v4');
				} elseif(is_page('header-5')) {
					get_template_part('framework/headers/header-v5');
				} else {
					get_template_part('framework/headers/header-'.$data['header_layout']);
				}
			}
			?>
		</div>
		<?php
		// sticky header
		get_template_part('framework/headers/sticky-header');
		?>
	<?php endif; ?>
	<div id="sliders-container">
	<?php
	if(is_search()) {
		$slider_page_id = '';
	}
	?>
	<?php if(!is_search()): ?>
	<?php wp_reset_query(); ?>
	<?php
	// Layer Slider
	$slider_page_id = '';
	if(!is_home() && !is_front_page() && !is_archive() && isset($post)) {
		$slider_page_id = $post->ID;
	}
	if(!is_home() && is_front_page() && isset($post)) {
		$slider_page_id = $post->ID;
	}
	if(is_home() && !is_front_page()){
		$slider_page_id = get_option('page_for_posts');
	}
	if(class_exists('Woocommerce')) {
		if(is_shop()) {
			$slider_page_id = get_option('woocommerce_shop_page_id');
		}
	}
	if(get_post_meta($slider_page_id, 'pyre_slider_type', true) == 'layer' && (get_post_meta($slider_page_id, 'pyre_slider', true) || get_post_meta($slider_page_id, 'pyre_slider', true) != 0)): ?>
	<?php
	// Get slider
	$ls_table_name = $wpdb->prefix . "layerslider";
	$ls_id = get_post_meta($slider_page_id, 'pyre_slider', true);
	$ls_slider = $wpdb->get_row("SELECT * FROM $ls_table_name WHERE id = ".(int)$ls_id." ORDER BY date_c DESC LIMIT 1" , ARRAY_A);
	$ls_slider = json_decode($ls_slider['data'], true);
	?>
	<style type="text/css">
	#layerslider-container{max-width:<?php echo $ls_slider['properties']['width'] ?>;}
	</style>
	<div id="layerslider-container">
		<div id="layerslider-wrapper">
		<?php if($ls_slider['properties']['skin'] == 'avada'): ?>
		<div class="ls-shadow-top"></div>
		<?php endif; ?>
		<?php echo do_shortcode('[layerslider id="'.get_post_meta($slider_page_id, 'pyre_slider', true).'"]'); ?>
		<?php if($ls_slider['properties']['skin'] == 'avada'): ?>
		<div class="ls-shadow-bottom"></div>
		<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<?php
	// Flex Slider
	if(get_post_meta($slider_page_id, 'pyre_slider_type', true) == 'flex' && (get_post_meta($slider_page_id, 'pyre_wooslider', true) || get_post_meta($slider_page_id, 'pyre_wooslider', true) != 0)) {
		echo do_shortcode('[wooslider slide_page="'.get_post_meta($slider_page_id, 'pyre_wooslider', true).'" slider_type="slides" limit="'.$data['flexslider_number'].'"]');
	}
	?>
	<?php
	if(get_post_meta($slider_page_id, 'pyre_slider_type', true) == 'rev' && get_post_meta($slider_page_id, 'pyre_revslider', true) && !$data['status_revslider'] && function_exists('putRevSlider')) {
		putRevSlider(get_post_meta($slider_page_id, 'pyre_revslider', true));
	}
	?>
	<?php
	if(get_post_meta($slider_page_id, 'pyre_slider_type', true) == 'flex2' && get_post_meta($slider_page_id, 'pyre_flexslider', true)) {
		include_once(get_template_directory().'/flexslider.php');
	}
	?>
	<?php
	// ThemeFusion Elastic Slider
	if(get_post_meta($slider_page_id, 'pyre_slider_type', true) == 'elastic' && (get_post_meta($slider_page_id, 'pyre_elasticslider', true) || get_post_meta($slider_page_id, 'pyre_elasticslider', true) != 0)) {
		include_once(get_template_directory().'/elastic-slider.php');
	}
	?>
	<?php endif; ?>
	</div>
	<?php if(get_post_meta($slider_page_id, 'pyre_fallback', true)): ?>
	<style type="text/css">
	@media only screen and (max-width: 940px){
		#sliders-container{display:none;}
		#fallback-slide{display:block;}
	}
	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait){
		#sliders-container{display:none;}
		#fallback-slide{display:block;}
	}
	</style>
	<div id="fallback-slide">
		<img src="<?php echo get_post_meta($slider_page_id, 'pyre_fallback', true); ?>" alt="" />
	</div>
	<?php endif; ?>
	<?php wp_reset_query(); ?>
	<?php if($data['page_title_bar']): ?>
	<?php if(((is_page() || is_single() || is_singular('avada_portfolio')) && get_post_meta($c_pageID, 'pyre_page_title', true) == 'yes') && !is_woocommerce() && !is_bbpress()) : ?>
	<div class="page-title-container">
		<div class="page-title">
			<?php if($post->ID == 139){ ?>
			<div class="page-title-wrapper">
				<div class="dashboard_current_user">					
				<?php 
					if ( is_user_logged_in() ){ 
						$current_user_details = wp_get_current_user();
						$current_user_fullname = $current_user_details->data->display_name;
						$table_name_person = $wpdb->prefix . "custom_person"; 
						$person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname = '$current_user_fullname'");
						$person_firstname = $person->person_first_name;
				?>
				<h3><?php the_title(); ?> - Welcome <?php echo $person_firstname; ?>!</h3>
				<?php } ?>
				</div>
			</div>
			<?php }else{ ?>
			<div class="page-title-wrapper">
				<div class="page-title-captions">
					<?php if(get_post_meta($c_pageID, 'pyre_page_title_text', true) != 'no'): ?>
					<h1 class="entry-title">
					<?php if(get_post_meta($c_pageID, 'pyre_page_title_custom_text', true) != ''): ?>
					<?php echo get_post_meta($c_pageID, 'pyre_page_title_custom_text', true); ?>
					<?php else: ?>
					<?php the_title(); ?>
					<?php endif; ?>
					</h1>
					<?php if(get_post_meta($c_pageID, 'pyre_page_title_custom_subheader', true) != ''): ?>
					<h3>
					<?php echo get_post_meta($c_pageID, 'pyre_page_title_custom_subheader', true); ?>
					</h3>
					<?php endif; ?>
					<?php endif; ?>
				</div>				
					<?php if($data['breadcrumb']): ?>
					<?php if($data['page_title_bar_bs'] == 'Breadcrumbs'): ?>
					<?php themefusion_breadcrumb(); ?>
					<?php else: ?>
					<?php get_search_form(); ?>
					<?php endif; ?>
					<?php endif; ?>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_home() && !is_front_page() && get_post_meta($slider_page_id, 'pyre_page_title', true) == 'yes'): ?>
	<div class="page-title-container">
		<div class="page-title">
			<div class="page-title-wrapper">
			<div class="page-title-captions">
			<?php if(get_post_meta($c_pageID, 'pyre_page_title_text', true) != 'no'): ?>
			<h1 class="entry-title"><?php echo $data['blog_title']; ?></h1>
			<?php endif; ?>
			</div>
			<?php if($data['breadcrumb']): ?>
			<?php if($data['page_title_bar_bs'] == 'Breadcrumbs'): ?>
			<?php themefusion_breadcrumb(); ?>
			<?php else: ?>
			<?php get_search_form(); ?>
			<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_search()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<div class="page-title-wrapper">
			<div class="page-title-captions">
			<h1 class="entry-title"><?php echo __('Search results for:', 'Avada'); ?> <?php echo get_search_query(); ?></h1>
			</div>
			<?php if($data['breadcrumb']): ?>
			<?php if($data['page_title_bar_bs'] == 'Breadcrumbs'): ?>
			<?php themefusion_breadcrumb(); ?>
			<?php else: ?>
			<?php get_search_form(); ?>
			<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_404()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<div class="page-title-wrapper">
			<div class="page-title-captions">
			<h1 class="entry-title"><?php echo __('Error 404 Page', 'Avada'); ?></h1>
			</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_archive() && !is_woocommerce() && !is_bbpress()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<div class="page-title-wrapper">
			<div class="page-title-captions">
			<h1 class="entry-title">
				<?php if ( is_day() ) : ?>
					<?php printf( __( 'Daily Archives: %s', 'Avada' ), '<span>' . get_the_date() . '</span>' ); ?>
				<?php elseif ( is_month() ) : ?>
					<?php printf( __( 'Monthly Archives: %s', 'Avada' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'Avada' ) ) . '</span>' ); ?>
				<?php elseif ( is_year() ) : ?>
					<?php printf( __( 'Yearly Archives: %s', 'Avada' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'Avada' ) ) . '</span>' ); ?>
				<?php elseif ( is_author() ) : ?>
					<?php
					$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
					?>
					<?php echo $curauth->nickname; ?>
				<?php else : ?>
					<?php single_cat_title(); ?>
				<?php endif; ?>
			</h1>
			</div>
			<?php if($data['breadcrumb']): ?>
			<?php if($data['page_title_bar_bs'] == 'Breadcrumbs'): ?>
			<?php themefusion_breadcrumb(); ?>
			<?php else: ?>
			<?php get_search_form(); ?>
			<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php
	if(class_exists('Woocommerce')):
	if($woocommerce->version && is_woocommerce() && ((is_product() && get_post_meta($c_pageID, 'pyre_page_title', true) == 'yes') || (is_shop() && get_post_meta($c_pageID, 'pyre_page_title', true) == 'yes')) && !is_search()):
	?>
	<div class="page-title-container">
		<div class="page-title">
			<div class="page-title-wrapper">
			<div class="page-title-captions">
			<?php if(get_post_meta($c_pageID, 'pyre_page_title_text', true) != 'no'): ?>
			<h1 class="entry-title">
				<?php
				if(is_product()) {
					if(get_post_meta($c_pageID, 'pyre_page_title_custom_text', true) != '') {
						echo get_post_meta($c_pageID, 'pyre_page_title_custom_text', true);
					} else {
						the_title();
					} ?>
					</h1>
					<?php if(get_post_meta($c_pageID, 'pyre_page_title_custom_subheader', true) != ''): ?>
					<h3>
					<?php echo get_post_meta($c_pageID, 'pyre_page_title_custom_subheader', true); ?>
					</h3>
					<?php endif;
				} else {
					woocommerce_page_title();
				}
				?>
			</h1>
			<?php endif; ?>
			</div>
			<?php if($data['breadcrumb']): ?>
			<?php if($data['page_title_bar_bs'] == 'Breadcrumbs'): ?>
			<?php woocommerce_breadcrumb(array(
				'wrap_before' => '<ul class="breadcrumbs">',
				'wrap_after' => '</ul>',
				'before' => '<li>',
				'after' => '</li>',
				'delimiter' => ''
			)); ?>
			<?php else: ?>
			<?php get_search_form(); ?>
			<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_tax('product_cat') || is_tax('product_tag')): ?>
	<div class="page-title-container">
		<div class="page-title">
			<div class="page-title-wrapper">
			<div class="page-title-captions">
			<h1 class="entry-title">
				<?php if ( is_day() ) : ?>
					<?php printf( __( 'Daily Archives: %s', 'Avada' ), '<span>' . get_the_date() . '</span>' ); ?>
				<?php elseif ( is_month() ) : ?>
					<?php printf( __( 'Monthly Archives: %s', 'Avada' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'Avada' ) ) . '</span>' ); ?>
				<?php elseif ( is_year() ) : ?>
					<?php printf( __( 'Yearly Archives: %s', 'Avada' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'Avada' ) ) . '</span>' ); ?>
				<?php elseif ( is_author() ) : ?>
					<?php
					$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
					?>
					<?php echo $curauth->nickname; ?>
				<?php else : ?>
					<?php single_cat_title(); ?>
				<?php endif; ?>
			</h1>
			</div>
			<?php if($data['breadcrumb']): ?>
			<?php if($data['page_title_bar_bs'] == 'Breadcrumbs'): ?>
			<?php themefusion_breadcrumb(); ?>
			<?php else: ?>
			<?php get_search_form(); ?>
			<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php endif; // end class check if for woocommerce ?>
	<?php
	if( class_exists('bbPress')):
	if(is_bbpress()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<div class="page-title-wrapper">
			<div class="page-title-captions">
			<?php if(get_post_meta($c_pageID, 'pyre_page_title_text', true) != 'no'): ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php endif; ?>
			</div>
			<?php if($data['breadcrumb']): ?>
			<?php if($data['page_title_bar_bs'] == 'Breadcrumbs'): ?>
			<?php bbp_breadcrumb( array ( 'before' => '<ul class="breadcrumbs">', 'after' => '</ul>', 'sep' => ' ', 'crumb_before' => '<li>', 'crumb_after' => '</li>', 'home_text' => __('Home', 'Avada')) ); ?>
			<?php else: ?>
			<?php get_search_form(); ?>
			<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php endif; ?>
	<?php endif; ?>
	<?php if(is_page_template('contact.php') && $data['recaptcha_public'] && $data['recaptcha_private']): ?>
	<script type="text/javascript">
	 var RecaptchaOptions = {
	    theme : '<?php echo $data['recaptcha_color_scheme']; ?>'
	 };
 	</script>
 	<?php endif; ?>
	<?php if(is_page_template('contact.php') && $data['gmap_address'] && !$data['status_gmap']): ?>
	<style type="text/css">
	#gmap{
		width:<?php echo $data['gmap_width']; ?>;
		margin:0 auto;
		<?php if($data['gmap_width'] != '100%'): ?>
		margin-top:55px;
		<?php endif; ?>

		<?php if($data['gmap_height']): ?>
		height:<?php echo $data['gmap_height']; ?>;
		<?php else: ?>
		height:415px;
		<?php endif; ?>
	}
	</style>
	<?php
	$data['gmap_address'] = addslashes($data['gmap_address']);
	$addresses = explode('|', $data['gmap_address']);
	$markers = '';
	if($data['map_popup']) {
		$map_popup = "false";
	} else {
		$map_popup = "true";
	}
	foreach($addresses as $address_string) {
		$markers .= "{
			address: '{$address_string}',
			html: {
				content: '{$address_string}',
				popup: {$map_popup}
			}
		},";
	}
	?>
	<script type='text/javascript'>
	jQuery(document).ready(function($) {
		jQuery('#gmap').goMap({
			address: '<?php echo $addresses[0]; ?>',
			maptype: '<?php echo $data['gmap_type']; ?>',
			zoom: <?php echo $data['map_zoom_level']; ?>,
			scrollwheel: <?php if($data['map_scrollwheel']): ?>false<?php else: ?>true<?php endif; ?>,
			scaleControl: <?php if($data['map_scale']): ?>false<?php else: ?>true<?php endif; ?>,
			navigationControl: <?php if($data['map_zoomcontrol']): ?>false<?php else: ?>true<?php endif; ?>,
	        <?php if(!$data['map_pin']): ?>markers: [<?php echo $markers; ?>],<?php endif; ?>
		});
	});
	</script>
	<div class="gmap" id="gmap">
	</div>
	<?php endif; ?>
	<?php if(is_page_template('contact-2.php') && $data['gmap_address'] && !$data['status_gmap']): ?>
	<style type="text/css">
	#gmap{
		width:940px;
		margin:0 auto;
		margin-top:55px;

		height:415px;
	}
	</style>
	<?php
	$data['gmap_address'] = addslashes($data['gmap_address']);
	$addresses = explode('|', $data['gmap_address']);
	$markers = '';
	if($data['map_popup']) {
		$map_popup = "false";
	} else {
		$map_popup = "true";
	}
	foreach($addresses as $address_string) {
		if(!$data['map_pin']) {
			$markers .= "{
				address: '{$address_string}',
				html: {
					content: '{$address_string}',
					popup: {$map_popup}
				}
			},";
		} else {
			$markers .= "{
				address: '{$address_string}'
			},";
		}
	}
	?>
	<script type='text/javascript'>
	jQuery(document).ready(function($) {
		jQuery('#gmap').goMap({
			address: '<?php echo $addresses[0]; ?>',
			maptype: '<?php echo $data['gmap_type']; ?>',
			zoom: <?php echo $data['map_zoom_level']; ?>,
			scrollwheel: <?php if($data['map_scrollwheel']): ?>false<?php else: ?>true<?php endif; ?>,
			scaleControl: <?php if($data['map_scale']): ?>false<?php else: ?>true<?php endif; ?>,
			navigationControl: <?php if($data['map_zoomcontrol']): ?>false<?php else: ?>true<?php endif; ?>,
			<?php if(!$data['map_pin']): ?>markers: [<?php echo $markers; ?>],<?php endif; ?>
		});
	});
	</script>
	<div class="gmap" id="gmap">
	</div>
	<?php endif; ?>
	<?php
	$main_css = '';
	$row_css = '';
	$main_class = '';
	$page_template = '';
	if (is_woocommerce()) {
		$custom_fields = get_post_custom_values('_wp_page_template', $c_pageID);
		if(is_array($custom_fields) && !empty($custom_fields)) {
			$page_template = $custom_fields[0];
		} else {
			$page_template = '';
		}
	}

	if(is_page_template('100-width.php') || is_page_template('blank.php') ||get_post_meta($slider_page_id, 'pyre_portfolio_width_100', true) == 'yes' || $page_template == '100-width.php') {
		$main_css = 'padding-left:0px;padding-right:0px;';
		if($data['hundredp_padding'] && !get_post_meta($c_pageID, 'pyre_hundredp_padding', true)) {
			$main_css = 'padding-left:'.$data['hundredp_padding'].';padding-right:'.$data['hundredp_padding'];
		}
		if(get_post_meta($c_pageID, 'pyre_hundredp_padding', true)) {
			$main_css = 'padding-left:'.get_post_meta($c_pageID, 'pyre_hundredp_padding', true).';padding-right:'.get_post_meta($c_pageID, 'pyre_hundredp_padding', true);
		}
		$row_css = 'max-width:100%;';
		$main_class = 'width-100';
	}
	?>
	<div id="main" class="clearfix <?php echo $main_class; ?>" style="<?php echo $main_css; ?>">
		<div class="avada-row" style="<?php echo $row_css; ?>">
			<?php wp_reset_query(); ?>