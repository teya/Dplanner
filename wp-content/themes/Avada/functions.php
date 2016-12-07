<?php
require_once('function_manage_submit_task.php');
require_once('function_page_timesheet.php');
require_once('function_manage_website.php');
require_once('function_client.php');
require_once('function_reports_inventory.php');
// Translation
load_theme_textdomain('Avada', TEMPLATEPATH.'/languages');

// Default RSS feed links
add_theme_support('automatic-feed-links');

// Allow shortcodes in widget text
add_filter('widget_text', 'do_shortcode');

// Woocommerce Support
add_theme_support('woocommerce');
define('WOOCOMMERCE_USE_CSS', false);

// Register Navigation
register_nav_menu('main_navigation', 'Main Navigation');
register_nav_menu('top_navigation', 'Top Navigation');
register_nav_menu('404_pages', '404 Useful Pages');
register_nav_menu('sticky_navigation', 'Sticky Header Navigation');

/* Options Framework */
require_once(get_template_directory().'/admin/index.php');

//add_action('init','test_options');
/*function test_options() {
	// Rev up the Options Machine
	global $of_options, $options_machine;
	$options_machine = new Options_Machine($of_options);
	update_option(OPTIONS,$options_machine->Defaults);
	//$options_machine = new Options_Machine($of_options);
}*/

// Content Width
if (!isset( $content_width )) $content_width = '669px';

// Post Formats
add_theme_support('post-formats', array('gallery', 'link', 'image', 'quote', 'video', 'audio', 'chat'));

// Enable or disable shortcodes developer mode
if($data['dev_shortcodes']) {
	add_theme_support( 'fusion_shortcodes_embed' );
}

// Auto plugin activation
// Reset activated plugins because if pre-installed plugins are already activated in standalone mode, theme will bug out.
if(get_option('avada_int_plugins', '0') == '0') {
	global $wpdb;
	$wpdb->query("UPDATE ". $wpdb->options ." SET option_value = 'a:0:{}' WHERE option_name = 'active_plugins';");
	if($wpdb->sitemeta) {
		$wpdb->query("UPDATE ". $wpdb->sitemeta ." SET meta_value = 'a:0:{}' WHERE meta_key = 'active_plugins';");
	}
	update_option('avada_int_plugins', '1');
}

if(get_option('avada_int_plugins', '0') == '1') {
	/**************************/
	/* Include LayerSlider WP */
	/**************************/

	$layerslider = get_template_directory() . '/framework/plugins/LayerSlider/layerslider.php';

	if(!$data['status_layerslider']) {
		include $layerslider;

		$layerslider_last_version = get_option('avada_layerslider_last_version', '1.0');

		// Activate the plugin if necessary
		if(get_option('avada_layerslider_activated', '0') == '0') {
			// Run activation script
			layerslider_activation_scripts();

			// Save a flag that it is activated, so this won't run again
			update_option('avada_layerslider_activated', '1');

			// Save the current version number of LayerSlider
			update_option('avada_layerslider_last_version', $GLOBALS['lsPluginVersion']);

		// Do version check
		} else if(version_compare($GLOBALS['lsPluginVersion'], $layerslider_last_version, '>')) {
			// Run again activation scripts for possible adjustments
			layerslider_activation_scripts();

			// Update the version number
			update_option('avada_layerslider_last_version', $GLOBALS['lsPluginVersion']);
		}
	}

	/**************************/
	/* Include Flexslider WP */
	/**************************/

	$flexslider = get_template_directory() . '/framework/plugins/tf-flexslider/wooslider.php';
	if(!$data['status_flexslider']) {
		include $flexslider;
	}

	/**************************/
	/* Include Posts Type Order */
	/**************************/

	$pto = get_template_directory() . '/framework/plugins/post-types-order/post-types-order.php';
	if($data['post_type_order']) {
		include $pto;
	}

	/************************************************/
	/* Include Previous / Next Post Pagination Plus */
	/************************************************/
	$pnp = 	get_template_directory() . '/framework/plugins/ambrosite-post-link-plus.php';
	include $pnp;

	/***********************/
	/* Include WPML Fixes  */
	/***********************/
	if(defined('ICL_SITEPRESS_VERSION')) {
		$wpml_include = get_template_directory() . '/framework/plugins/wpml.php';
		include $wpml_include;
	}
}

// Metaboxes
include_once(get_template_directory().'/framework/metaboxes.php');

// Extend Visual Composer
get_template_part('shortcodes');

// Custom Functions
get_template_part('framework/custom_functions');

// Plugins
include_once(get_template_directory().'/framework/plugins/multiple_sidebars.php');

// Widgets
get_template_part('widgets/widgets');

// Add post thumbnail functionality
add_theme_support('post-thumbnails');
add_image_size('blog-large', 669, 272, true);
add_image_size('blog-medium', 320, 202, true);
add_image_size('tabs-img', 52, 50, true);
add_image_size('related-img', 180, 138, true);
add_image_size('portfolio-one', 540, 272, true);
add_image_size('portfolio-two', 460, 295, true);
add_image_size('portfolio-three', 300, 214, true);
add_image_size('portfolio-four', 220, 161, true);
add_image_size('portfolio-full', 940, 400, true);
add_image_size('recent-posts', 700, 441, true);
add_image_size('recent-works-thumbnail', 66, 66, true);

// Register widgetized locations
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'Blog Sidebar',
		'id' => 'avada-blog-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="heading"><h3>',
		'after_title' => '</h3></div>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 1',
		'id' => 'avada-footer-widget-1',
		'before_widget' => '<div id="%1$s" class="footer-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 2',
		'id' => 'avada-footer-widget-2',
		'before_widget' => '<div id="%1$s" class="footer-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 3',
		'id' => 'avada-footer-widget-3',
		'before_widget' => '<div id="%1$s" class="footer-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 4',
		'id' => 'avada-footer-widget-4',
		'before_widget' => '<div id="%1$s" class="footer-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'SlidingBar Widget 1',
		'id' => 'avada-slidingbar-widget-1',
		'before_widget' => '<div id="%1$s" class="slidingbar-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'SlidingBar Widget 2',
		'id' => 'avada-slidingbar-widget-2',
		'before_widget' => '<div id="%1$s" class="slidingbar-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'SlidingBar Widget 3',
		'id' => 'avada-slidingbar-widget-3',
		'before_widget' => '<div id="%1$s" class="slidingbar-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'SlidingBar Widget 4',
		'id' => 'avada-slidingbar-widget-4',
		'before_widget' => '<div id="%1$s" class="slidingbar-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array(
		'name' => 'Polls',
		'id' => 'polls',
		'before_widget' => '<div id="%1$s" class="polls %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array(
		'name' => 'Monthly Status',
		'id' => 'monthly_status',
		'before_widget' => '<div id="%1$s" class="monthly_status %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}

// Register custom post types
add_action('init', 'pyre_init');
function pyre_init() {
	global $data;
	register_post_type(
		'avada_portfolio',
		array(
			'labels' => array(
				'name' => 'Portfolio',
				'singular_name' => 'Portfolio'
			),
			'public' => true,
			'has_archive' => '404',
			'rewrite' => array('slug' => $data['portfolio_slug']),
			'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
			'can_export' => true,
		)
	);

	register_taxonomy('portfolio_category', 'avada_portfolio', array('hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true));
	register_taxonomy('portfolio_skills', 'avada_portfolio', array('hierarchical' => true, 'label' => 'Skills', 'query_var' => true, 'rewrite' => true));
	register_taxonomy('portfolio_tags', 'avada_portfolio', array('hierarchical' => false, 'label' => 'Tags', 'query_var' => true, 'rewrite' => true));

	register_post_type(
		'avada_faq',
		array(
			'labels' => array(
				'name' => 'FAQs',
				'singular_name' => 'FAQ'
			),
			'public' => true,
			'has_archive' => '404',
			'rewrite' => array('slug' => 'faq-items'),
			'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
			'can_export' => true,
		)
	);

	register_taxonomy('faq_category', 'avada_faq', array('hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true));

	register_post_type(
		'themefusion_elastic',
		array(
			'labels' => array(
				'name' => 'Elastic Slider',
				'singular_name' => 'Elastic Slide'
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'elastic-slide'),
			'supports' => array('title', 'thumbnail'),
			'can_export' => true,
			'menu_position' => 100,
		)
	);

	register_taxonomy('themefusion_es_groups', 'themefusion_elastic', array('hierarchical' => false, 'label' => 'Groups', 'query_var' => true, 'rewrite' => true));
}

// How comments are displayed
function avada_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<?php $add_below = ''; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

		<div class="the-comment">
			<div class="avatar">
				<?php echo get_avatar($comment, 54); ?>
			</div>

			<div class="comment-box">

				<div class="comment-author meta">
					<strong><?php echo get_comment_author_link() ?></strong>
					<?php printf(__('%1$s at %2$s', 'Avada'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__(' - Edit', 'Avada'),'  ','') ?><?php comment_reply_link(array_merge( $args, array('reply_text' => __(' - Reply', 'Avada'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>

				<div class="comment-text">
					<?php if ($comment->comment_approved == '0') : ?>
					<em><?php echo __('Your comment is awaiting moderation.', 'Avada') ?></em>
					<br />
					<?php endif; ?>
					<?php comment_text() ?>
				</div>

			</div>

		</div>

<?php }

/*function pyre_SearchFilter($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts','pyre_SearchFilter');*/

add_filter('wp_get_attachment_link', 'avada_pretty');
function avada_pretty($content) {
	$content = preg_replace("/<a/","<a rel=\"prettyPhoto[postimages]\"",$content,1);
	return $content;
}

require_once(get_template_directory().'/framework/plugins/multiple-featured-images/multiple-featured-images.php');

if( class_exists( 'kdMultipleFeaturedImages' )  && !$data['legacy_posts_slideshow']) {
		$i = 2;

		while($i <= $data['posts_slideshow_number']) {
	        $args = array(
	                'id' => 'featured-image-'.$i,
	                'post_type' => 'post',      // Set this to post or page
	                'labels' => array(
	                    'name'      => 'Featured image '.$i,
	                    'set'       => 'Set featured image '.$i,
	                    'remove'    => 'Remove featured image '.$i,
	                    'use'       => 'Use as featured image '.$i,
	                )
	        );

	        new kdMultipleFeaturedImages( $args );

	        $args = array(
	                'id' => 'featured-image-'.$i,
	                'post_type' => 'page',      // Set this to post or page
	                'labels' => array(
	                    'name'      => 'Featured image '.$i,
	                    'set'       => 'Set featured image '.$i,
	                    'remove'    => 'Remove featured image '.$i,
	                    'use'       => 'Use as featured image '.$i,
	                )
	        );

	        new kdMultipleFeaturedImages( $args );

	        $args = array(
	                'id' => 'featured-image-'.$i,
	                'post_type' => 'avada_portfolio',      // Set this to post or page
	                'labels' => array(
	                    'name'      => 'Featured image '.$i,
	                    'set'       => 'Set featured image '.$i,
	                    'remove'    => 'Remove featured image '.$i,
	                    'use'       => 'Use as featured image '.$i,
	                )
	        );

	        new kdMultipleFeaturedImages( $args );

	        $i++;
    	}

}

function avada_excerpt_length( $length ) {
	global $data;

	if(isset($data['excerpt_length_blog'])) {
		return $data['excerpt_length_blog'];
	}
}
add_filter('excerpt_length', 'avada_excerpt_length', 999);

function avada_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array(
		'parent' => 'site-name', // use 'false' for a root menu, or pass the ID of the parent menu
		'id' => 'smof_options', // link ID, defaults to a sanitized title value
		'title' => __('Theme Options', 'Avada'), // link title
		'href' => admin_url( 'themes.php?page=optionsframework'), // name of file
		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
	));
}
add_action( 'wp_before_admin_bar_render', 'avada_admin_bar_render' );

add_filter('upload_mimes', 'avada_filter_mime_types');
function avada_filter_mime_types($mimes)
{
	$mimes['ttf'] = 'font/ttf';
	$mimes['woff'] = 'font/woff';
	$mimes['svg'] = 'font/svg';
	$mimes['eot'] = 'font/eot';

	return $mimes;
}

function avada_process_tag( $m ) {
   if ($m[2] == 'dropcap' || $m[2] == 'highlight' || $m[2] == 'tooltip') {
      return $m[0];
   }

	// allow [[foo]] syntax for escaping a tag
	if ( $m[1] == '[' && $m[6] == ']' ) {
		return substr($m[0], 1, -1);
	}

   return $m[1] . $m[6];
}

function tf_content($limit, $strip_html) {
	global $data, $more;

	if(!$limit && $limit != 0) {
		$limit = 285;
	}

	$limit = (int) $limit;

	$test_strip_html = $strip_html;

	if($strip_html == "true" || $strip_html == true) {
		$test_strip_html = true;
	}

	if($strip_html == "false" || $strip_html == false) {
		$test_strip_html = false;
	}

	$custom_excerpt = false;

	$post = get_post(get_the_ID());

	$pos = strpos($post->post_content, '<!--more-->');

	if($data['link_read_more']) {
		$readmore = ' <a href="'.get_permalink( get_the_ID() ).'">&#91;...&#93;</a>';
	} else {
		$readmore = ' &#91;...&#93;';
	}

	if($test_strip_html) {
		$raw_content = strip_tags( get_the_content($readmore) );
		if($post->post_excerpt || $pos !== false) {
			$more = 0;
			$raw_content = strip_tags( get_the_content($readmore) );
			$custom_excerpt = true;
		}
	} else {
		$raw_content = get_the_content($readmore);
		if($post->post_excerpt || $pos !== false) {
			$more = 0;
			$raw_content = get_the_content($readmore);
			$custom_excerpt = true;
		}
	}

	if($raw_content && $custom_excerpt == false) {
		$content = $raw_content;

		if($test_strip_html == true) {
			$pattern = get_shortcode_regex();
			$content = preg_replace_callback("/$pattern/s", 'avada_process_tag', $content);
		}
		$content = explode(' ', $content, $limit);
		if(count($content)>=$limit) {
			array_pop($content);
			if($data['disable_excerpts']) {
				$content = implode(" ",$content);
			} else {
				$content = implode(" ",$content);
				if($limit != 0) {
					if($data['link_read_more']) {
						$content .= ' <a href="'.get_permalink( get_the_ID() ).'">&#91;...&#93;</a>';
					} else {
						$content .= ' &#91;...&#93;';
					}
				}
			}
		} else {
			$content = implode(" ",$content);
		}

		if( $limit != 0 ) {
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
		}
		
		$content = '<div class="excerpt-container">'.do_shortcode($content).'</div>';

		return $content;
	}

	if($custom_excerpt == true) {
		$content = $raw_content;
		if($test_strip_html == true) {
			$pattern = get_shortcode_regex();
			$content = preg_replace_callback("/$pattern/s", 'avada_process_tag', $content);
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$content = '<div class="excerpt-container">'.do_shortcode($content).'</div>';
		} else {
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
		}
	}

	if(has_excerpt()) {
		$content = get_the_excerpt();
	}

	return $content;
}

function avada_scripts() {
	if (!is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) )) {
	wp_reset_query();

	global $data,$post,$wp_filesystem;

	if( empty( $wp_filesystem ) ) {
	    require_once( ABSPATH .'/wp-admin/includes/file.php' );
	    WP_Filesystem();
	}

	if(isset($post)) {
		$slider_page_id = $post->ID;
	}
	if(is_home() && !is_front_page()){
		$slider_page_id = get_option('page_for_posts');
	}

	$upload_dir = wp_upload_dir();

    if( isset($lang) && !$lang ) {
        $lang = '';
        if(defined('ICL_LANGUAGE_CODE')) {
            global $sitepress;
            if(ICL_LANGUAGE_CODE != 'en' && ICL_LANGUAGE_CODE != 'all') {
                $lang = '_'.ICL_LANGUAGE_CODE;
                if(!get_option(THEMENAME.'_options'.$lang)) {
                    update_option(THEMENAME.'_options'.$lang, get_option(THEMENAME.'_options'));
                }
            } elseif( ICL_LANGUAGE_CODE == 'all' ) {
                $lang = '_' . $sitepress->get_default_language();
                if( $sitepress->get_default_language() == 'en' ) {
                    $lang = '';
                }
            } else {
                $lang = '';
            }
        }
    } else {
    	$lang = '';
    }

	if((get_option('show_on_front') && get_option('page_for_posts') && is_home()) ||
		(get_option('page_for_posts') && is_archive() && !is_post_type_archive())) {
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

    wp_enqueue_script( 'jquery', false, array(), null, true);

    if ( is_singular() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_deregister_script( 'modernizr' );
    wp_register_script( 'modernizr', get_bloginfo('template_directory').'/js/modernizr-min.js', array(), null, true);
	wp_enqueue_script( 'modernizr' );

	if( function_exists('novagallery_shortcode') ) {
	    wp_deregister_script( 'novagallery_modernizr' );
	    wp_register_script( 'novagallery_modernizr', get_bloginfo('template_directory').'/js/modernizr-min.js', array(), null, true);
		wp_enqueue_script( 'novagallery_modernizr' );
	}

	if( function_exists('ccgallery_shortcode') ) {
	    wp_deregister_script( 'ccgallery_modernizr' );
	    wp_register_script( 'ccgallery_modernizr', get_bloginfo('template_directory').'/js/modernizr-min.js', array(), null, true);
		wp_enqueue_script( 'ccgallery_modernizr' );
	}

    wp_deregister_script( 'jquery.carouFredSel' );
    wp_register_script( 'jquery.carouFredSel', get_bloginfo('template_directory').'/js/jquery.carouFredSel-6.2.1-min.js', array(), null, true);
    //if(is_single()) {
		wp_enqueue_script( 'jquery.carouFredSel' );
    //}

	if ( class_exists( 'Woocommerce' ) ) {
		if(!$data['status_lightbox'] && !is_woocommerce()) {
			wp_deregister_script( 'jquery.prettyPhoto' );
			wp_register_script( 'jquery.prettyPhoto', get_bloginfo('template_directory').'/js/jquery.prettyPhoto-min.js', array(), null, true);
			wp_enqueue_script( 'jquery.prettyPhoto' );
		}
		wp_dequeue_script('wc-add-to-cart-variation');
		wp_enqueue_script( 'wc-add-to-cart-variation', get_bloginfo( 'template_directory' ). '/woocommerce/js/add-to-cart-variation-min.js' , array( 'jquery' ), false, true );

		wp_dequeue_script('wc-single-product');
		wp_enqueue_script( 'wc-single-product', get_bloginfo( 'template_directory' ). '/woocommerce/js/single-product-min.js' , array( 'jquery' ), false, true );
	} else {
		if(!$data['status_lightbox']) {
			wp_deregister_script( 'jquery.prettyPhoto' );
			wp_register_script( 'jquery.prettyPhoto', get_bloginfo('template_directory').'/js/jquery.prettyPhoto-min.js', array(), null, true);
			wp_enqueue_script( 'jquery.prettyPhoto' );
		}
	}

    wp_deregister_script( 'jquery.flexslider' );
    wp_register_script( 'jquery.flexslider', get_bloginfo('template_directory').'/js/jquery.flexslider-min.js', array(), null, true);
    //if(is_home() || is_single() || is_search() || is_archive() || get_post_meta($slider_page_id, 'pyre_slider_type', true) == 'flex2') {
		wp_enqueue_script( 'jquery.flexslider' );
	//}

    wp_deregister_script( 'jquery.fitvids' );
    wp_register_script( 'jquery.fitvids', get_bloginfo('template_directory').'/js/jquery.fitvids-min.js', array(), null, true);
	wp_enqueue_script( 'jquery.fitvids' );

	if(!$data['status_gmap']) {
		wp_deregister_script( 'jquery.ui.map' );
		wp_register_script( 'jquery.ui.map', get_bloginfo('template_directory').'/js/gmap-min.js', array(), null, true);
		//if(is_page_template('contact.php') || is_page_template('contact-2.php')) {
			wp_enqueue_script( 'jquery.ui.map' );
		//}
	}

    wp_deregister_script( 'avada' );
    wp_register_script( 'avada', get_bloginfo('template_directory').'/js/main.js', array(), null, true);
	wp_enqueue_script( 'avada' );

	if(get_post_meta($c_pageID, 'pyre_fimg_width', true) == 'auto' && get_post_meta($c_pageID, 'pyre_width', true) == 'half') {
		$smoothHeight = 'true';
	} else {
		$smoothHeight = 'false';
	}

	if(get_post_meta($c_pageID, 'pyre_fimg_width', true) == 'auto' && get_post_meta($c_pageID, 'pyre_width', true) == 'half') {
		$flex_smoothHeight = 'true';
	} else {
		if($data["slideshow_smooth_height"]) {
			$flex_smoothHeight = 'true';
		} else {
			$flex_smoothHeight = 'false';
		}
	}

	wp_localize_script('avada', 'js_local_vars', array(
			'dropdown_goto' => __('Go to...', 'Avada'),
			'mobile_nav_cart' => __('Shopping Cart', 'Avada'),
			'page_smoothHeight' => $smoothHeight,
			'flex_smoothHeight' => $flex_smoothHeight
		)
	);

    $filename = trailingslashit($upload_dir['baseurl']) . 'avada' . $lang . '.js';
    $filename_dir = trailingslashit($upload_dir['basedir']) . 'avada' . $lang . '.js';
	if( $wp_filesystem ) {
		$file_status = $wp_filesystem->get_contents( $filename_dir );

		if( trim( $file_status ) ) { // if js file creation fails
			wp_enqueue_script('avada-dynamic-js', $filename, array(), null, true);
		}
	}

    $filename = trailingslashit($upload_dir['baseurl']) . 'avada' . $lang . '.css';
    $filename_dir = trailingslashit($upload_dir['basedir']) . 'avada' . $lang . '.css';
	if( $wp_filesystem ) {
		$file_status = $wp_filesystem->get_contents( $filename_dir );

		if( trim( $file_status ) ) { // if js file creation fails
			wp_enqueue_style('avada-dynamic-css', $filename);
		}
	}

	}
}
add_action('wp_enqueue_scripts', 'avada_scripts');

/*function avada_admin_scripts() {
	global $pagenow;

	if (is_admin() && ($pagenow=='post.php')) {
    	wp_register_script('avada_vc_converter', get_bloginfo('template_directory').'/js/vc_converter.js');
    	wp_enqueue_script('avada_vc_converter');

    	wp_register_style('avada_vc_converter', get_bloginfo('template_directory').'/css/vc_converter.css');
    	wp_enqueue_style('avada_vc_converter');
	}
}
add_action('admin_enqueue_scripts', 'avada_admin_scripts');*/

add_filter('jpeg_quality', 'avada_image_full_quality');
add_filter('wp_editor_set_quality', 'avada_image_full_quality');
function avada_image_full_quality($quality) {
    return 100;
}

add_filter('get_archives_link', 'avada_cat_count_span');
add_filter('wp_list_categories', 'avada_cat_count_span');
function avada_cat_count_span($links) {
	$get_count = preg_match_all('#\((.*?)\)#', $links, $matches);

	if($matches) {
		$i = 0;
		foreach($matches[0] as $val) {
			$links = str_replace('</a> '.$val, ' '.$val.'</a>', $links);
			$links = str_replace('</a>&nbsp;'.$val, ' '.$val.'</a>', $links);
			$i++;
		}
	}

	return $links;
}

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

add_filter('pre_get_posts','avada_SearchFilter');
function avada_SearchFilter($query) {
	global $data;
	if($query->is_search) {
		if($data['search_content'] == 'Only Posts') {
			$query->set('post_type', 'post');
		}

		if($data['search_content'] == 'Only Pages') {
			$query->set('post_type', 'page');
		}
	}
	return $query;
}

add_action('admin_head', 'avada_admin_css');
function avada_admin_css() {
	echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/css/admin_shortcodes.css">';
}

/* Theme Activation Hook */
add_action('admin_init','avada_theme_activation');
function avada_theme_activation()
{
	global $pagenow;
	if(is_admin() && 'themes.php' == $pagenow && isset($_GET['activated']))
	{
		update_option('shop_catalog_image_size', array('width' => 500, 'height' => '', 0));
		update_option('shop_single_image_size', array('width' => 500, 'height' => '', 0));
		update_option('shop_thumbnail_image_size', array('width' => 120, 'height' => '', 0));
	}
}

// Register default function when plugin not activated
add_action('wp_head', 'avada_plugins_loaded');
function avada_plugins_loaded() {
	if(!function_exists('is_woocommerce')) {
		function is_woocommerce() { return false; }
	}
	if(!function_exists('is_bbpress')) {
		function is_bbpress() { return false; }
	}
}

// Woocommerce Hooks
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

add_action('woocommerce_before_shop_loop', 'avada_woocommerce_catalog_ordering', 30);
function avada_woocommerce_catalog_ordering() {
	global $data;

	parse_str($_SERVER['QUERY_STRING'], $params);

	$query_string = '?'.$_SERVER['QUERY_STRING'];

	// replace it with theme option
	if($data['woo_items']) {
		$per_page = $data['woo_items'];
	} else {
		$per_page = 12;
	}

	$pob = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
	$po = !empty($params['product_order'])  ? $params['product_order'] : 'asc';
	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	$html = '';
	$html .= '<div class="catalog-ordering clearfix">';

	$html .= '<div class="orderby-order-container">';

	$html .= '<ul class="orderby order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a>'.__('Sort by', 'Avada').' <strong>'.__('Default Order', 'Avada').'</strong></a></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pob == 'default') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'default').'">'.__('Sort by', 'Avada').' <strong>'.__('Default Order', 'Avada').'</strong></a></li>';
	$html .= '<li class="'.(($pob == 'name') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'name').'">'.__('Sort by', 'Avada').' <strong>'.__('Name', 'Avada').'</strong></a></li>';
	$html .= '<li class="'.(($pob == 'price') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'price').'">'.__('Sort by', 'Avada').' <strong>'.__('Price', 'Avada').'</strong></a></li>';
	$html .= '<li class="'.(($pob == 'date') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'date').'">'.__('Sort by', 'Avada').' <strong>'.__('Date', 'Avada').'</strong></a></li>';
	$html .= '<li class="'.(($pob == 'rating') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'rating').'">'.__('Sort by', 'Avada').' <strong>'.__('Rating', 'Avada').'</strong></a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';


	$html .= '<ul class="order">';
	if($po == 'desc'):
	$html .= '<li class="desc"><a href="'.tf_addURLParameter($query_string, 'product_order', 'asc').'"><i class="icon-arrow-up"></i></a></li>';
	endif;
	if($po == 'asc'):
	$html .= '<li class="asc"><a href="'.tf_addURLParameter($query_string, 'product_order', 'desc').'"><i class="icon-arrow-down"></i></a></li>';
	endif;
	$html .= '</ul>';

	$html .= '</div>';

	$html .= '<ul class="sort-count order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a>'.__('Show', 'Avada').' <strong>'.$per_page.' '.__(' Products', 'Avada').'</strong></a></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pc == $per_page) ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_count', $per_page).'">'.__('Show', 'Avada').' <strong>'.$per_page.' '.__('Products', 'Avada').'</strong></a></li>';
	$html .= '<li class="'.(($pc == $per_page*2) ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_count', $per_page*2).'">'.__('Show', 'Avada').' <strong>'.($per_page*2).' '.__('Products', 'Avada').'</strong></a></li>';
	$html .= '<li class="'.(($pc == $per_page*3) ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_count', $per_page*3).'">'.__('Show', 'Avada').' <strong>'.($per_page*3).' '.__('Products', 'Avada').'</strong></a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	$html .= '</div>';

	echo $html;
}

add_action('woocommerce_get_catalog_ordering_args', 'avada_woocommerce_get_catalog_ordering_args', 20);
function avada_woocommerce_get_catalog_ordering_args($args)
{
	parse_str($_SERVER['QUERY_STRING'], $params);

	$pob = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
	$po = !empty($params['product_order'])  ? $params['product_order'] : 'asc';

	switch($pob) {
		case 'date':
			$orderby = 'date';
			$order = 'desc';
			$meta_key = '';
		break;
		case 'price':
			$orderby = 'meta_value_num';
			$order = 'asc';
			$meta_key = '_price';
		break;
		case 'popularity':
			$orderby = 'meta_value_num';
			$order = 'desc';
			$meta_key = 'total_sales';
		break;
		case 'title':
			$orderby = 'title';
			$order = 'asc';
			$meta_key = '';
		break;
		case 'default':
		default:
			$orderby = 'menu_order title';
			$order = 'asc';
			$meta_key = '';
		break;
	}

	switch($po) {
		case 'desc':
			$order = 'desc';
		break;
		case 'asc':
			$order = 'asc';
		break;
		default:
			$order = 'asc';
		break;
	}

	$args['orderby'] = $orderby;
	$args['order'] = $order;
	$args['meta_key'] = $meta_key;

	return $args;
}

add_filter('loop_shop_per_page', 'avada_loop_shop_per_page');
function avada_loop_shop_per_page()
{
	global $data;

	parse_str($_SERVER['QUERY_STRING'], $params);

	if($data['woo_items']) {
		$per_page = $data['woo_items'];
	} else {
		$per_page = 12;
	}

	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	return $pc;
}

add_action('woocommerce_before_shop_loop_item_title', 'avada_woocommerce_thumbnail', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
function avada_woocommerce_thumbnail() {
	global $product, $woocommerce;

	$items_in_cart = array();

	if($woocommerce->cart->get_cart() && is_array($woocommerce->cart->get_cart())) {
		foreach($woocommerce->cart->get_cart() as $cart) {
			$items_in_cart[] = $cart['product_id'];
		}
	}

	$id = get_the_ID();
	$in_cart = in_array($id, $items_in_cart);
	$size = 'shop_catalog';

	$gallery = get_post_meta($id, '_product_image_gallery', true);
	$attachment_image = '';
	if(!empty($gallery)) {
		$gallery = explode(',', $gallery);
		$first_image_id = $gallery[0];
		$attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'hover-image'));
	}
	$thumb_image = get_the_post_thumbnail($id , $size);

	if($attachment_image) {
		$classes = 'crossfade-images';
	} else {
		$classes = '';
	}

	echo '<span class="'.$classes.'">';
	echo $attachment_image;
	echo $thumb_image;
	if($in_cart) {
		echo '<span class="cart-loading"><i class="icon-check"></i></span>';
	} else {
		echo '<span class="cart-loading"><i class="icon-spinner"></i></span>';
	}
	echo '</span>';
}
add_filter('add_to_cart_fragments', 'avada_woocommerce_header_add_to_cart_fragment');
function avada_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();
	?>
	<li class="cart">
		<?php if(!$woocommerce->cart->cart_contents_count): ?>
		<a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('Cart', 'Avada'); ?></a>
		<?php else: ?>
		<a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php echo $woocommerce->cart->cart_contents_count; ?> <?php _e('Item(s)', 'Avada'); ?> - <?php echo woocommerce_price($woocommerce->cart->subtotal); ?></a>
		<div class="cart-contents">
			<?php foreach($woocommerce->cart->cart_contents as $cart_item): ?>
			<div class="cart-content">
				<a href="<?php echo get_permalink($cart_item['product_id']); ?>">
				<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
				<?php echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail'); ?>
				<div class="cart-desc">
					<span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
					<span class="product-quantity"><?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']); ?></span>
				</div>
				</a>
			</div>
			<?php endforeach; ?>
			<div class="cart-checkout">
				<div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'Avada'); ?></a></div>
				<div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'Avada'); ?></a></div>
			</div>
		</div>
		<?php endif; ?>
	</li>
	<?php
	$fragments['.top-menu .cart'] = ob_get_clean();

	ob_start();
	?>
	<li class="cart">
		<?php if(!$woocommerce->cart->cart_contents_count): ?>
		<a class="my-cart-link" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"></a>
		<?php else: ?>
		<a class="my-cart-link my-cart-link-active" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"></a>
		<div class="cart-contents">
			<?php foreach($woocommerce->cart->cart_contents as $cart_item): //var_dump($cart_item); ?>
			<div class="cart-content">
				<a href="<?php echo get_permalink($cart_item['product_id']); ?>">
				<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
				<?php echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail'); ?>
				<div class="cart-desc">
					<span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
					<span class="product-quantity"><?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']); ?></span>
				</div>
				</a>
			</div>
			<?php endforeach; ?>
			<div class="cart-checkout">
				<div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'Avada'); ?></a></div>
				<div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'Avada'); ?></a></div>
			</div>
		</div>
		<?php endif; ?>
	</li>
	<?php
	$fragments['#header .cart'] = ob_get_clean();

	return $fragments;

}

function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['author_facebook'] = 'Facebook ';
	$profile_fields['author_twitter'] = 'Twitter';
	$profile_fields['author_linkedin'] = 'LinkedIn';
	$profile_fields['author_dribble'] = 'Dribble';
	$profile_fields['author_gplus'] = 'Google+';
	$profile_fields['author_custom'] = 'Custom Message';

	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');

/* Change admin css */
function custom_admin_styles() {
	echo '<style type="text/css">
	.widget input { border-color: #DFDFDF !important; }
	</style>';
}
add_action('admin_head', 'custom_admin_styles');

/* Style Selector */
add_action('wp_ajax_avada_style_selector', 'tf_style_selector');
add_action('wp_ajax_nopriv_avada_style_selector', 'tf_style_selector');
function tf_style_selector() {
	global $data;

	$color = $_POST['color'];

	$data = array_merge($data, $color);

	ob_start();
	include(locate_template('style_selector_style.php', false));
	$html = ob_get_clean();

	echo $html;

	die();
}

/* Display a notice that can be dismissed */
if($data['ubermenu']) {
	update_option('avada_ubermenu_notice', true);
} elseif(!get_option('avada_ubermenu_notice_hidden')) {
	update_option('avada_ubermenu_notice', false);
}

add_action('admin_notices', 'avada_admin_notice');
function avada_admin_notice() {
    /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_option('avada_ubermenu_notice') && function_exists( 'uberMenu_direct' ) && ($_GET['page'] != 'uber-menu')
        && current_user_can( 'activate_plugins' ) ) {
		$url = admin_url( 'themes.php?page=optionsframework#of-option-extraoptions' );
        echo '<div class="updated"><p>';
        printf(__('It seems you have <a href="http://wpmegamenu.com/">Ubermenu</a> installed, please enable <a href="' . $url . '">Ubermenu Plugin Support</a> option on the Extras tab in Avada <a href="' . $url . '">theme options</a> to allow compatiblity.<br /><a href="%1$s" style="margin-top:5px;" class="button button-primary">Hide Notice</a>'), '?avada_uber_nag_ignore=0');
        echo "</p></div>";
	}

	if( ! get_option('avada_ubermenu_notice') && function_exists( 'uberMenu_direct' ) && $_GET['page'] == 'uber-menu'
        && current_user_can( 'activate_plugins' ) ) {
		echo '<div class="ubermenu-thanks" style="overflow: hidden;"><h3>Support Avada with Ubermenu</h3><p>';
		printf(__('It seems you have <a href="http://wpmegamenu.com/">Ubermenu</a> installed, please enable <a href="' . $url . '">Ubermenu Plugin Support</a> option on the Extras tab in Avada <a href="' . $url . '">theme options</a> to allow compatiblity.<a href="%1$s" class="button button-bad" style="margin-top: 10px;">Hide Notice</a>'), '?avada_uber_nag_ignore=0');
		echo '</p></div>';
	}

	if( isset($_GET['imported']) && $_GET['imported'] == 'success' ) {
        echo '<div class="updated"><p>';
        printf(__('Sucessfully imported demo data!'));
        echo "</p></div>";
	}
}

add_action('admin_init', 'avada_nag_ignore');
function avada_nag_ignore() {
	/* If user clicks to ignore the notice, add that to their user meta */
    if (isset($_GET['avada_uber_nag_ignore']) && '0' == $_GET['avada_uber_nag_ignore'] ) {
    	update_option('avada_ubermenu_notice', true);
    	update_option('avada_ubermenu_notice_hidden', true);
    	$referer = esc_url($_SERVER["HTTP_REFERER"]);
    	wp_redirect($referer);
	}
}

/* Importer */
$importer = get_template_directory() . '/framework/plugins/importer/importer.php';
include $importer;

//////////////////////////////////////////////////////////////////
// Woo Products Shortcode Recode
//////////////////////////////////////////////////////////////////
function avada_woo_product($atts, $content = null) {
	global $woocommerce_loop;

	if (empty($atts)) return;

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 1,
		'no_found_rows' => 1,
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => '_visibility',
				'value' => array('catalog', 'visible'),
				'compare' => 'IN'
			)
		),
		'columns' => 1
	);

	if(isset($atts['sku'])){
		$args['meta_query'][] = array(
			'key' => '_sku',
			'value' => $atts['sku'],
			'compare' => '='
		);
	}

	if(isset($atts['id'])){
		$args['p'] = $atts['id'];
	}

	ob_start();

	if(isset($columns)) {
		$woocommerce_loop['columns'] = $columns;
	}

	$products = new WP_Query( $args );

	if ( $products->have_posts() ) : ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	<?php endif;

	wp_reset_postdata();

	return '<div class="woocommerce">' . ob_get_clean() . '</div>';
}

add_action('wp_loaded', 'remove_product_shortcode');
function remove_product_shortcode() {
	if(class_exists('Woocommerce')) {
		// First remove the shortcode
		remove_shortcode('product');
		// Then recode it
		add_shortcode('product', 'avada_woo_product');
	}
}

// TGM Plugin Activation
require_once dirname( __FILE__ ) . '/framework/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'avada_register_required_plugins' );
function avada_register_required_plugins() {
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'Revolution Slider', // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/framework/plugins/revslider.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '4.1.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Fusion Core', // The plugin name
			'slug'     				=> 'fusion-core', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/framework/plugins/fusion-core.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.1.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),

	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'tgmpa';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin installed or update: %1$s.', 'This theme requires the following plugins installed or updated: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin installed or updated: %1$s.', 'This theme recommends the following plugins installed or updated: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}

/**
 * Show a shop page description on product archives
 */
function woocommerce_product_archive_description() {
	if ( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0 ) {
		$shop_page   = get_post( woocommerce_get_page_id( 'shop' ) );
		$description = apply_filters( 'the_content', $shop_page->post_content );
		if ( $description ) {
			echo '<div class="post-content">' . $description . '</div>';
		}
	}
}


/**
 * Check if the device is a tablet.
 */
function is_tablet($user_agent = null) {
	$tablet_devices = array(
        'iPad'              => 'iPad|iPad.*Mobile',
        'NexusTablet'       => '^.*Android.*Nexus(((?:(?!Mobile))|(?:(\s(7|10).+))).)*$',
        'SamsungTablet'     => 'SAMSUNG.*Tablet|Galaxy.*Tab|SC-01C|GT-P1000|GT-P1003|GT-P1010|GT-P3105|GT-P6210|GT-P6800|GT-P6810|GT-P7100|GT-P7300|GT-P7310|GT-P7500|GT-P7510|SCH-I800|SCH-I815|SCH-I905|SGH-I957|SGH-I987|SGH-T849|SGH-T859|SGH-T869|SPH-P100|GT-P3100|GT-P3108|GT-P3110|GT-P5100|GT-P5110|GT-P6200|GT-P7320|GT-P7511|GT-N8000|GT-P8510|SGH-I497|SPH-P500|SGH-T779|SCH-I705|SCH-I915|GT-N8013|GT-P3113|GT-P5113|GT-P8110|GT-N8010|GT-N8005|GT-N8020|GT-P1013|GT-P6201|GT-P7501|GT-N5100|GT-N5110|SHV-E140K|SHV-E140L|SHV-E140S|SHV-E150S|SHV-E230K|SHV-E230L|SHV-E230S|SHW-M180K|SHW-M180L|SHW-M180S|SHW-M180W|SHW-M300W|SHW-M305W|SHW-M380K|SHW-M380S|SHW-M380W|SHW-M430W|SHW-M480K|SHW-M480S|SHW-M480W|SHW-M485W|SHW-M486W|SHW-M500W|GT-I9228|SCH-P739|SCH-I925|GT-I9200|GT-I9205|GT-P5200|GT-P5210|SM-T311|SM-T310|SM-T210|SM-T210R|SM-T211|SM-P600|SM-P601|SM-P605|SM-P900|SM-T217|SM-T217A|SM-T217S|SM-P6000|SM-T3100|SGH-I467|XE500',
        // @reference: http://www.labnol.org/software/kindle-user-agent-string/20378/
        'Kindle'            => 'Kindle|Silk.*Accelerated|Android.*\b(KFOT|KFTT|KFJWI|KFJWA|KFOTE|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|WFJWAE)\b',
        // Only the Surface tablets with Windows RT are considered mobile.
        // @ref: http://msdn.microsoft.com/en-us/library/ie/hh920767(v=vs.85).aspx
        'SurfaceTablet'     => 'Windows NT [0-9.]+; ARM;',
        // @ref: http://shopping1.hp.com/is-bin/INTERSHOP.enfinity/WFS/WW-USSMBPublicStore-Site/en_US/-/USD/ViewStandardCatalog-Browse?CatalogCategoryID=JfIQ7EN5lqMAAAEyDcJUDwMT
        'HPTablet'          => 'HP Slate 7|HP ElitePad 900|hp-tablet|EliteBook.*Touch',
        // @note: watch out for PadFone, see #132
        'AsusTablet'        => '^.*PadFone((?!Mobile).)*$|Transformer|TF101|TF101G|TF300T|TF300TG|TF300TL|TF700T|TF700KL|TF701T|TF810C|ME171|ME301T|ME302C|ME371MG|ME370T|ME372MG|ME172V|ME173X|ME400C|Slider SL101',
        'BlackBerryTablet'  => 'PlayBook|RIM Tablet',
        'HTCtablet'         => 'HTC Flyer|HTC Jetstream|HTC-P715a|HTC EVO View 4G|PG41200',
        'MotorolaTablet'    => 'xoom|sholest|MZ615|MZ605|MZ505|MZ601|MZ602|MZ603|MZ604|MZ606|MZ607|MZ608|MZ609|MZ615|MZ616|MZ617',
        'NookTablet'        => 'Android.*Nook|NookColor|nook browser|BNRV200|BNRV200A|BNTV250|BNTV250A|BNTV400|BNTV600|LogicPD Zoom2',
        // @ref: http://www.acer.ro/ac/ro/RO/content/drivers
        // @ref: http://www.packardbell.co.uk/pb/en/GB/content/download (Packard Bell is part of Acer)
        // @ref: http://us.acer.com/ac/en/US/content/group/tablets
        // @note: Can conflict with Micromax and Motorola phones codes.
        'AcerTablet'        => 'Android.*; \b(A100|A101|A110|A200|A210|A211|A500|A501|A510|A511|A700|A701|W500|W500P|W501|W501P|W510|W511|W700|G100|G100W|B1-A71|B1-710|B1-711|A1-810)\b|W3-810',
        // @ref: http://eu.computers.toshiba-europe.com/innovation/family/Tablets/1098744/banner_id/tablet_footerlink/
        // @ref: http://us.toshiba.com/tablets/tablet-finder
        // @ref: http://www.toshiba.co.jp/regza/tablet/
        'ToshibaTablet'     => 'Android.*(AT100|AT105|AT200|AT205|AT270|AT275|AT300|AT305|AT1S5|AT500|AT570|AT700|AT830)|TOSHIBA.*FOLIO',
        // @ref: http://www.nttdocomo.co.jp/english/service/developer/smart_phone/technical_info/spec/index.html
        'LGTablet'          => '\bL-06C|LG-V900|LG-V909\b',
        'FujitsuTablet'     => 'Android.*\b(F-01D|F-05E|F-10D|M532|Q572)\b',
        // Prestigio Tablets http://www.prestigio.com/support
        'PrestigioTablet'   => 'PMP3170B|PMP3270B|PMP3470B|PMP7170B|PMP3370B|PMP3570C|PMP5870C|PMP3670B|PMP5570C|PMP5770D|PMP3970B|PMP3870C|PMP5580C|PMP5880D|PMP5780D|PMP5588C|PMP7280C|PMP7280|PMP7880D|PMP5597D|PMP5597|PMP7100D|PER3464|PER3274|PER3574|PER3884|PER5274|PER5474|PMP5097CPRO|PMP5097|PMP7380D|PMP5297C|PMP5297C_QUAD',
        // @ref: http://support.lenovo.com/en_GB/downloads/default.page?#
        'LenovoTablet'      => 'IdeaTab|S2110|S6000|K3011|A3000|A1000|A2107|A2109|A1107',
        'YarvikTablet'      => 'Android.*(TAB210|TAB211|TAB224|TAB250|TAB260|TAB264|TAB310|TAB360|TAB364|TAB410|TAB411|TAB420|TAB424|TAB450|TAB460|TAB461|TAB464|TAB465|TAB467|TAB468)',
        'MedionTablet'      => 'Android.*\bOYO\b|LIFE.*(P9212|P9514|P9516|S9512)|LIFETAB',
        'ArnovaTablet'      => 'AN10G2|AN7bG3|AN7fG3|AN8G3|AN8cG3|AN7G3|AN9G3|AN7dG3|AN7dG3ST|AN7dG3ChildPad|AN10bG3|AN10bG3DT',
        // IRU.ru Tablets http://www.iru.ru/catalog/soho/planetable/
        'IRUTablet'         => 'M702pro',
        'MegafonTablet'     => 'MegaFon V9|\bZTE V9\b',
        // @ref: http://www.e-boda.ro/tablete-pc.html
        'EbodaTablet'       => 'E-Boda (Supreme|Impresspeed|Izzycomm|Essential)',
        // @ref: http://www.allview.ro/produse/droseries/lista-tablete-pc/
        'AllViewTablet'           => 'Allview.*(Viva|Alldro|City|Speed|All TV|Frenzy|Quasar|Shine|TX1|AX1|AX2)',
        // @reference: http://wiki.archosfans.com/index.php?title=Main_Page
        'ArchosTablet'      => '\b(101G9|80G9|A101IT)\b|Qilive 97R',
        // @ref: http://www.ainol.com/plugin.php?identifier=ainol&module=product
        'AinolTablet'       => 'NOVO7|NOVO8|NOVO10|Novo7Aurora|Novo7Basic|NOVO7PALADIN|novo9-Spark',
        // @todo: inspect http://esupport.sony.com/US/p/select-system.pl?DIRECTOR=DRIVER
        // @ref: Readers http://www.atsuhiro-me.net/ebook/sony-reader/sony-reader-web-browser
        // @ref: http://www.sony.jp/support/tablet/
        'SonyTablet'        => 'Sony.*Tablet|Xperia Tablet|Sony Tablet S|SO-03E|SGPT12|SGPT121|SGPT122|SGPT123|SGPT111|SGPT112|SGPT113|SGPT211|SGPT213|SGP311|SGP312|SGP321|EBRD1101|EBRD1102|EBRD1201',
        // @ref: db + http://www.cube-tablet.com/buy-products.html
        'CubeTablet'        => 'Android.*(K8GT|U9GT|U10GT|U16GT|U17GT|U18GT|U19GT|U20GT|U23GT|U30GT)|CUBE U8GT',
        // @ref: http://www.cobyusa.com/?p=pcat&pcat_id=3001
        'CobyTablet'        => 'MID1042|MID1045|MID1125|MID1126|MID7012|MID7014|MID7015|MID7034|MID7035|MID7036|MID7042|MID7048|MID7127|MID8042|MID8048|MID8127|MID9042|MID9740|MID9742|MID7022|MID7010',
        // @ref: http://www.match.net.cn/products.asp
        'MIDTablet'         => 'M9701|M9000|M9100|M806|M1052|M806|T703|MID701|MID713|MID710|MID727|MID760|MID830|MID728|MID933|MID125|MID810|MID732|MID120|MID930|MID800|MID731|MID900|MID100|MID820|MID735|MID980|MID130|MID833|MID737|MID960|MID135|MID860|MID736|MID140|MID930|MID835|MID733',
        // @ref: http://pdadb.net/index.php?m=pdalist&list=SMiT (NoName Chinese Tablets)
        // @ref: http://www.imp3.net/14/show.php?itemid=20454
        'SMiTTablet'        => 'Android.*(\bMID\b|MID-560|MTV-T1200|MTV-PND531|MTV-P1101|MTV-PND530)',
        // @ref: http://www.rock-chips.com/index.php?do=prod&pid=2
        'RockChipTablet'    => 'Android.*(RK2818|RK2808A|RK2918|RK3066)|RK2738|RK2808A',
        // @ref: http://www.fly-phone.com/devices/tablets/ ; http://www.fly-phone.com/service/
        'FlyTablet'         => 'IQ310|Fly Vision',
        // @ref: http://www.bqreaders.com/gb/tablets-prices-sale.html
        'bqTablet'          => 'bq.*(Elcano|Curie|Edison|Maxwell|Kepler|Pascal|Tesla|Hypatia|Platon|Newton|Livingstone|Cervantes|Avant)|Maxwell.*Lite|Maxwell.*Plus',
        // @ref: http://www.huaweidevice.com/worldwide/productFamily.do?method=index&directoryId=5011&treeId=3290
        // @ref: http://www.huaweidevice.com/worldwide/downloadCenter.do?method=index&directoryId=3372&treeId=0&tb=1&type=software (including legacy tablets)
        'HuaweiTablet'      => 'MediaPad|IDEOS S7|S7-201c|S7-202u|S7-101|S7-103|S7-104|S7-105|S7-106|S7-201|S7-Slim',
        // Nec or Medias Tab
        'NecTablet'         => '\bN-06D|\bN-08D',
        // Pantech Tablets: http://www.pantechusa.com/phones/
        'PantechTablet'     => 'Pantech.*P4100',
        // Broncho Tablets: http://www.broncho.cn/ (hard to find)
        'BronchoTablet'     => 'Broncho.*(N701|N708|N802|a710)',
        // @ref: http://versusuk.com/support.html
        'VersusTablet'      => 'TOUCHPAD.*[78910]|\bTOUCHTAB\b',
        // @ref: http://www.zync.in/index.php/our-products/tablet-phablets
        'ZyncTablet'        => 'z1000|Z99 2G|z99|z930|z999|z990|z909|Z919|z900',
        // @ref: http://www.positivoinformatica.com.br/www/pessoal/tablet-ypy/
        'PositivoTablet'    => 'TB07STA|TB10STA|TB07FTA|TB10FTA',
        // @ref: https://www.nabitablet.com/
        'NabiTablet'        => 'Android.*\bNabi',
        'KoboTablet'        => 'Kobo Touch|\bK080\b|\bVox\b Build|\bArc\b Build',
        // French Danew Tablets http://www.danew.com/produits-tablette.php
        'DanewTablet'       => 'DSlide.*\b(700|701R|702|703R|704|802|970|971|972|973|974|1010|1012)\b',
        // Texet Tablets and Readers http://www.texet.ru/tablet/
        'TexetTablet'       => 'NaviPad|TB-772A|TM-7045|TM-7055|TM-9750|TM-7016|TM-7024|TM-7026|TM-7041|TM-7043|TM-7047|TM-8041|TM-9741|TM-9747|TM-9748|TM-9751|TM-7022|TM-7021|TM-7020|TM-7011|TM-7010|TM-7023|TM-7025|TM-7037W|TM-7038W|TM-7027W|TM-9720|TM-9725|TM-9737W|TM-1020|TM-9738W|TM-9740|TM-9743W|TB-807A|TB-771A|TB-727A|TB-725A|TB-719A|TB-823A|TB-805A|TB-723A|TB-715A|TB-707A|TB-705A|TB-709A|TB-711A|TB-890HD|TB-880HD|TB-790HD|TB-780HD|TB-770HD|TB-721HD|TB-710HD|TB-434HD|TB-860HD|TB-840HD|TB-760HD|TB-750HD|TB-740HD|TB-730HD|TB-722HD|TB-720HD|TB-700HD|TB-500HD|TB-470HD|TB-431HD|TB-430HD|TB-506|TB-504|TB-446|TB-436|TB-416|TB-146SE|TB-126SE',
        // @note: Avoid detecting 'PLAYSTATION 3' as mobile.
        'PlaystationTablet' => 'Playstation.*(Portable|Vita)',
        // @ref: http://www.galapad.net/product.html
        'GalapadTablet'     => 'Android.*\bG1\b',
        // @ref: http://www.micromaxinfo.com/tablet/funbook
        'MicromaxTablet'    => 'Funbook|Micromax.*\b(P250|P560|P360|P362|P600|P300|P350|P500|P275)\b',
        // http://www.karbonnmobiles.com/products_tablet.php
        'KarbonnTablet'     => 'Android.*\b(A39|A37|A34|ST8|ST10|ST7|Smart Tab3|Smart Tab2)\b',
        // @ref: http://www.myallfine.com/Products.asp
        'AllFineTablet'     => 'Fine7 Genius|Fine7 Shine|Fine7 Air|Fine8 Style|Fine9 More|Fine10 Joy|Fine11 Wide',
        // @ref: http://www.proscanvideo.com/products-search.asp?itemClass=TABLET&itemnmbr=
        'PROSCANTablet'     => '\b(PEM63|PLT1023G|PLT1041|PLT1044|PLT1044G|PLT1091|PLT4311|PLT4311PL|PLT4315|PLT7030|PLT7033|PLT7033D|PLT7035|PLT7035D|PLT7044K|PLT7045K|PLT7045KB|PLT7071KG|PLT7072|PLT7223G|PLT7225G|PLT7777G|PLT7810K|PLT7849G|PLT7851G|PLT7852G|PLT8015|PLT8031|PLT8034|PLT8036|PLT8080K|PLT8082|PLT8088|PLT8223G|PLT8234G|PLT8235G|PLT8816K|PLT9011|PLT9045K|PLT9233G|PLT9735|PLT9760G|PLT9770G)\b',
        // @ref: http://www.yonesnav.com/products/products.php
        'YONESTablet' => 'BQ1078|BC1003|BC1077|RK9702|BC9730|BC9001|IT9001|BC7008|BC7010|BC708|BC728|BC7012|BC7030|BC7027|BC7026',
        // @ref: http://www.cjshowroom.com/eproducts.aspx?classcode=004001001
        // China manufacturer makes tablets for different small brands (eg. http://www.zeepad.net/index.html)
        'ChangJiaTablet'    => 'TPC7102|TPC7103|TPC7105|TPC7106|TPC7107|TPC7201|TPC7203|TPC7205|TPC7210|TPC7708|TPC7709|TPC7712|TPC7110|TPC8101|TPC8103|TPC8105|TPC8106|TPC8203|TPC8205|TPC8503|TPC9106|TPC9701|TPC97101|TPC97103|TPC97105|TPC97106|TPC97111|TPC97113|TPC97203|TPC97603|TPC97809|TPC97205|TPC10101|TPC10103|TPC10106|TPC10111|TPC10203|TPC10205|TPC10503',
        // @ref: http://www.gloryunion.cn/products.asp
        // @ref: http://www.allwinnertech.com/en/apply/mobile.html
        // @ref: http://www.ptcl.com.pk/pd_content.php?pd_id=284 (EVOTAB)
        // aka. Cute or Cool tablets. Not sure yet, must research to avoid collisions.
        'GUTablet'          => 'TX-A1301|TX-M9002|Q702', // A12R|D75A|D77|D79|R83|A95|A106C|R15|A75|A76|D71|D72|R71|R73|R77|D82|R85|D92|A97|D92|R91|A10F|A77F|W71F|A78F|W78F|W81F|A97F|W91F|W97F|R16G|C72|C73E|K72|K73|R96G
        // @ref: http://www.pointofview-online.com/showroom.php?shop_mode=product_listing&category_id=118
        'PointOfViewTablet' => 'TAB-P506|TAB-navi-7-3G-M|TAB-P517|TAB-P-527|TAB-P701|TAB-P703|TAB-P721|TAB-P731N|TAB-P741|TAB-P825|TAB-P905|TAB-P925|TAB-PR945|TAB-PL1015|TAB-P1025|TAB-PI1045|TAB-P1325|TAB-PROTAB[0-9]+|TAB-PROTAB25|TAB-PROTAB26|TAB-PROTAB27|TAB-PROTAB26XL|TAB-PROTAB2-IPS9|TAB-PROTAB30-IPS9|TAB-PROTAB25XXL|TAB-PROTAB26-IPS10|TAB-PROTAB30-IPS10',
        // @ref: http://www.overmax.pl/pl/katalog-produktow,p8/tablety,c14/
        // @todo: add more tests.
        'OvermaxTablet'     => 'OV-(SteelCore|NewBase|Basecore|Baseone|Exellen|Quattor|EduTab|Solution|ACTION|BasicTab|TeddyTab|MagicTab|Stream|TB-08|TB-09)',
        // @ref: http://hclmetablet.com/India/index.php
        'HCLTablet'         => 'HCL.*Tablet|Connect-3G-2.0|Connect-2G-2.0|ME Tablet U1|ME Tablet U2|ME Tablet G1|ME Tablet X1|ME Tablet Y2|ME Tablet Sync',
        // @ref: http://www.edigital.hu/Tablet_es_e-book_olvaso/Tablet-c18385.html
        'DPSTablet'         => 'DPS Dream 9|DPS Dual 7',
        // @ref: http://www.visture.com/index.asp
        'VistureTablet'     => 'V97 HD|i75 3G|Visture V4( HD)?|Visture V5( HD)?|Visture V10',
        // @ref: http://www.mijncresta.nl/tablet
        'CrestaTablets'     => 'CTP(-)?810|CTP(-)?818|CTP(-)?828|CTP(-)?838|CTP(-)?888|CTP(-)?978|CTP(-)?980|CTP(-)?987|CTP(-)?988|CTP(-)?989',
        // @ref: http://www.tesco.com/direct/hudl/
        'Hudl'              => 'Hudl HT7S3',
        // @ref: http://www.telstra.com.au/home-phone/thub-2/
        'TelstraTablet'     => 'T-Hub2',
        'GenericTablet'     => 'Android.*\b97D\b|Tablet(?!.*PC)|ViewPad7|BNTV250A|MID-WCDMA|LogicPD Zoom2|\bA7EB\b|CatNova8|A1_07|CT704|CT1002|\bM721\b|rk30sdk|\bEVOTAB\b|SmartTabII10|SmartTab10',
    );

	foreach ($tablet_devices as $regex) {
		$regex = str_replace('/', '\/', $regex);

		if ((bool) preg_match('/'.$regex.'/is', $user_agent)) {
			return true;
		}
	}
	return false;
}

/* ==================================== Add Hours ==================================== */

function addHours($hour_one, $hour_two){
	$h =  strtotime($hour_one);
	$h2 = strtotime($hour_two);
	
	$minute = date("i", $h2);
	$second = date("s", $h2);
	$hour = date("H", $h2);
	
	$convert = strtotime("+$minute minutes", $h);
	$convert = strtotime("+$second seconds", $convert);
	$convert = strtotime("+$hour hours", $convert);
	$new_time = date('H:i:s', $convert);
	
	return $new_time;
}

/* ==================================== END Add Hours ==================================== */

/* ==================================== Hours to Seconds ==================================== */
function hoursToSeconds ($hour) { // $hour must be a string type: "HH:mm:ss"
	
	$parse = array();
	if (!preg_match ('#^(?<hours>[\d]{2}):(?<mins>[\d]{2}):(?<secs>[\d]{2})$#',$hour,$parse)) {
		// Throw error, exception, etc
		throw new RuntimeException ("Hour Format not valid");
	}
	
	return (int) $parse['hours'] * 3600 + (int) $parse['mins'] * 60 + (int) $parse['secs'];
	
}
/* ==================================== END Hours to Seconds ==================================== */

/* ==================================== print_var ==================================== */
function print_var($variable, $class='pre_class'){
	echo "<pre class='".$class."'>";
	print_r($variable);
	echo "</pre>";
}
/* ==================================== END print_var ==================================== */

/* ==================================== DATE DIFFERENCE ==================================== */
function dateDiff ($d1, $d2) {	
	return round(abs(strtotime($d1)-strtotime($d2))/86400);	
}
/* ==================================== END DATE DIFFERENCE ==================================== */

/* ==================================== LAST DAY OF MONTH ==================================== */
function last_day($month = '', $year = '') 
{
	if (empty($month)) 
	{
		$month = date('m');
	}
	
	if (empty($year)) 
	{
		$year = date('Y');
	}
	
	$result = strtotime("{$year}-{$month}-01");
	$result = strtotime('-1 second', strtotime('+1 month', $result));
	
	return date('d', $result);
}
/* ==================================== END LAST DAY OF MONTH ==================================== */

/* ==================================== CONVERT HOURS TO DECIMAL ==================================== */
function decimalHours($time){
	$hms = explode(":", $time);
	return ($hms[0] + ($hms[1]/60) + ($hms[2]/3600));
}
/* ==================================== END CONVERT HOURS TO DECIMAL ==================================== */

/* ==================================== DECIMAL TO HOURS ==================================== */
function convertTime($dec){
	$seconds = (int)($dec * 3600);
	$hours = floor($dec);
	$seconds -= $hours * 3600;
	$minutes = floor($seconds / 60);
	$seconds -= $minutes * 60;
	return lz($hours).":".lz($minutes).":".lz($seconds);
}
	
function lz($num){
	return (strlen($num) < 2) ? "0{$num}" : $num;
}
/* ==================================== END DECIMAL TO HOURS ==================================== */

/* ==================================== GET START AND END DATE ==================================== */
function getStartAndEndDate($week, $year) {
	$date_string = $year . 'W' . sprintf('%02d', $week);
	$return[0] = date('Y-n-j', strtotime($date_string));
	$return[1] = date('Y-n-j', strtotime($date_string . '7'));
	return $return;
}
/* ==================================== END GET START AND END DATE ==================================== */

/* ==================================== EDIT MODAL FORM ==================================== */
function edit_modal_form($data_id){
	global $wpdb;
	$table_name_project			= $wpdb->prefix . "custom_project";
	$projects					= $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE ID = $data_id");
	$project_client				= (isset($projects->project_client)) ? $projects->project_client : '';
	$project_name 				= (isset($projects->project_name)) ? $projects->project_name : '';
	$project_start_date 		= (isset($projects->project_start_date)) ? $projects->project_start_date : '';
	$project_estimated_deadline = (isset($projects->project_estimated_deadline)) ? $projects->project_estimated_deadline : '';
	$project_hour 				= (isset($projects->project_hour)) ? $projects->project_hour : '';
	$project_minute 			= (isset($projects->project_minute)) ? $projects->project_minute : '';
	$project_extra_expenses 	= (isset($projects->project_extra_expenses)) ? $projects->project_extra_expenses : '';
	$project_budget			 	= (isset($projects->project_budget)) ? $projects->project_budget : '';
	$project_current_status		= (isset($projects->project_current_status)) ? $projects->project_current_status : '';
	$project_description 		= (isset($projects->project_description)) ? $projects->project_description : '';
	$current_status_array 		= array('Quote sent', 'Planning', 'Setup', 'Design', 'Functionality', 'Adjustments', 'Invoiced', 'Cancelled');
	foreach ($current_status_array as $current_status){ 
		if($project_current_status != $current_status){
			$var_option .= '<option>'.$current_status.'</option>';
		}
	}	
	$html = '
	<form method="post" id="edit_modal_project_management">		
	<fieldset>
	<div class="input_div">
	<label class="modal_label">Customer</label>
	<input type="text" class="modal_client_name" name="project_client" value="'.$project_client.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Project Name</label>
	<input type="text" class="modal_project_name" name="project_name" value="'.$project_name.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Start Date</label>
	<input type="text" class="modal_project_start_date" name="project_start_date" value="'.$project_start_date.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Deadline</label>
	<input type="text" class="modal_project_estimated_deadline" name="project_estimated_deadline" value="'.$project_estimated_deadline.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Time Spent</label>
	<input type="text" class="modal_project_hour" name="project_hour" value="'.$project_hour.'" /><p class="time_label">h</p>
	<input type="text" class="modal_project_minute" name="project_minute" value="'.$project_minute.'" /><p class="time_label">m</p>
	</div>	
	<div class="input_div">
	<label class="modal_label">Extra Expenses</label>
	<input type="text" class="modal_project_extra_expenses" name="project_extra_expenses" value="'.$project_extra_expenses.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Budget</label>
	<input type="text" class="modal_project_budget" name="project_budget" value="'.$project_budget.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Status</label>
	<select class="project_current_status" name="project_current_status">
	<option value="'.$project_current_status.'">'.$project_current_status.'</option>
	'.$var_option.'
	</select>
	</div>
	<div class="input_div">
	<label class="modal_label">Notes</label>
	<input type="text" class="modal_project_description" name="project_description" value="'.$project_description.'">
	</div>
	<div class="button_2 modal_cancel_button modal_cancel_project_management">Cancel</div>
	<div id="modal_save_edit_project_management" class="button_1 action_button">Save</div>
	<div style="display: none;" class="modal_save_edit_project_management_loader loader"></div>
	</fieldset>
	<input type="hidden" value="'.$data_id.'" name="row_id">
	</form>';
	return $html;	
}

function save_edit_modal_form($edit_form_data){
	global $wpdb;
	$table_name_project = $wpdb->prefix . "custom_project";	
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_name_timesheet = $wpdb->prefix . "custom_timesheet";
	
	$form_array = array();
	parse_str($edit_form_data, $form_array);
	$row_id = $form_array['row_id'];	
	if(isset($row_id)){
		$project_client					= $form_array['project_client'];
		$project_name					= $form_array['project_name'];
		$project_start_date				= $form_array['project_start_date'];
		$project_estimated_deadline		= $form_array['project_estimated_deadline'];
		$project_hour					= $form_array['project_hour'];
		$project_minute					= $form_array['project_minute'];
		$project_extra_expenses			= $form_array['project_extra_expenses'];
		$project_default_expenses		= $form_array['project_default_expenses'];
		$project_current_status			= $form_array['project_current_status'];
		$project_description			= $form_array['project_description'];
		$project_budget					= $form_array['project_budget'];
	
	$update = $wpdb->update( $table_name_project , array( 
		'project_client'				=> $project_client,
		'project_name'					=> $project_name,
		'project_start_date'			=> $project_start_date,
		'project_estimated_deadline'	=> $project_estimated_deadline,
		'project_hour'					=> $project_hour,
		'project_minute'				=> $project_minute,
		'project_extra_expenses'		=> $project_extra_expenses,
		'project_default_expenses'		=> $project_default_expenses,
		'project_current_status'		=> $project_current_status,
		'project_description'			=> $project_description,
		'project_budget'				=> $project_budget
	),	
		array( 'ID' => $row_id ),
		array( '%s', '%s' ));
		
		if($update == 1){
			$html = $form_array;
		}else{
			$html = 'Project was Not Updated';
		}
	}
	$project = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE ID = {$row_id} ");
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$timesheets = $wpdb->get_results("SELECT * FROM {$table_name_timesheet}");
	
	$project_budget = $project->project_budget;
	$project_responsible_worker = $project->project_responsible_worker;
	
	$project_hours = $project_hour.":".$project_minute.":00";
	$project_decimal_hours = decimalHours($project_hours);
	$project_rounded_hour = round($project_decimal_hours, 2);
	
	$timesheet_hour_decimal = 0;
	foreach($timesheets as $timesheet){
		if($timesheet->task_label == $project_client){
			$task_hour = $timesheet->task_hour;										
			$decimal_hours = decimalHours($task_hour);
			$rounded_hour = round($decimal_hours, 2);		
			$timesheet_hour_decimal += $rounded_hour;					
		}				
	}
	
	$total_hour_decimal = $timesheet_hour_decimal + $project_rounded_hour;
	$current_expense = $project_default_expenses + $project_extra_expenses;
	
	foreach($persons as $person){
		$person_full_name = $person->person_first_name ." ". $person->person_last_name;
		if($project_responsible_worker == $person_full_name){
			$person_hourly_rate = $person->person_hourly_rate;
			$multiply = $total_hour_decimal * $person_hourly_rate;			
			$add = $multiply + $current_expense;
			$revenue = $project_budget - $add;
		}
	}
		
	$html['decimal_hours'] = $total_hour_decimal;
	$html['current_expense'] = $current_expense;
	$html['revenue'] = $revenue;
	return $html;
}
/* ==================================== END EDIT MODAL FORM ==================================== */

/* ==================================== ARCHIVE MODAL FORM ==================================== */
function archive_modal_form($data_id){
	global $wpdb;
	$table_name_project			= $wpdb->prefix . "custom_project";
	$projects					= $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE ID = $data_id");
	
	$project_client 			= (isset($projects->project_client)) ? $projects->project_client : " ";
	$project_name 				= (isset($projects->project_name)) ? $projects->project_name : " ";
	$project_date_completed 	= (isset($projects->project_date_completed)) ? $projects->project_date_completed : " ";
	$project_hour 				= (isset($projects->project_hour)) ? $projects->project_hour : " ";
	$project_minute 			= (isset($projects->project_minute)) ? $projects->project_minute : " ";
	$project_invoiced_amount 	= (isset($projects->project_invoiced_amount)) ? $projects->project_invoiced_amount : " ";
	$project_invoice_date 		= (isset($projects->project_invoice_date)) ? $projects->project_invoice_date : " ";
	$project_default_expenses 	= (isset($projects->project_default_expenses)) ? $projects->project_default_expenses : " ";
	$project_description 		= (isset($projects->project_description)) ? $projects->project_description : " ";
	$project_extra_expenses 	= (isset($projects->project_extra_expenses)) ? $projects->project_extra_expenses : " ";	
	
	$html = '
	<form method="post" id="archive_modal_project_management" class="archive_modal_project_management">		
	<fieldset>
	<h4>Project Name: '.$project_name.'</h4>
	<h4>Customer: '.$project_client.'</h4>
	<div class="input_div">
	<label class="modal_label">Invoiced Amount</label>
	<input type="text" class="modal_project_invoiced_amount" name="project_invoiced_amount" value="'.$project_invoiced_amount.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Date Completed</label>
	<input type="text" class="modal_project_date_completed required" name="project_date_completed" value="'.$project_date_completed.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Time Spent</label>
	<input type="text" class="modal_project_hour" name="project_hour" value="'.$project_hour.'" /><p class="time_label">h</p>
	<input type="text" class="modal_project_minute" name="project_minute" value="'.$project_minute.'" /><p class="time_label">m</p>
	</div>
	<div class="input_div">
	<label class="modal_label">Date of Invoice</label>
	<input type="text" class="modal_project_invoice_date" name="project_invoice_date" value="'.$project_invoice_date.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Current Expenses:</label>
	<p class="current_expense">'.$current_expense.'</p>
	</div>
	<div class="input_div">
	<label class="modal_label">Extra Expenses</label>
	<input type="text" class="modal_project_extra_expenses" name="project_extra_expenses" value="'.$project_extra_expenses.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Default Expenses</label>
	<input type="text" class="modal_project_default_expenses" name="project_default_expenses" value="'.$project_default_expenses.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Notes</label>
	<input type="text" class="modal_project_description" name="project_description" value="'.$project_description.'" />	
	</div>	
	<div class="button_2 modal_cancel_button modal_cancel_project_management">Cancel</div>
	<div id="modal_save_archive_project_management" class="button_1 action_button">Save</div>
	<div style="display: none;" class="loader achive_modal_loader"></div>
	</fieldset>
	<input type="hidden" value="'.$data_id.'" name="row_id">
	</form>
	';
	return $html;
}

function save_archive_modal_form($archive_form_data){
	global $wpdb;
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_timesheet = $wpdb->prefix . "custom_timesheet";
	$form_array = array();
	parse_str($archive_form_data, $form_array);
	$row_id = $form_array['row_id'];
	
	if(isset($row_id)){	
		$project_date_completed		= $form_array['project_date_completed'];		
		$project_hour				= $form_array['project_hour'];
		$project_minute				= $form_array['project_minute'];
		$project_invoiced_amount	= $form_array['project_invoiced_amount'];
		$project_invoice_date		= $form_array['project_invoice_date'];
		$project_default_expenses	= $form_array['project_default_expenses'];
		$project_description		= $form_array['project_description'];
		
		$project = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE ID = $row_id");		
		$project_name = $project->project_name;
		$project_client = $project->project_client;
		$project_start_date = $project->project_start_date;
		$start_date = date("d/m/Y", strtotime($project_start_date));
		$date_completed = date("d/m/Y", strtotime($project_date_completed));
		$timesheet_archive_details = $wpdb->get_results("SELECT * FROM {$table_name_timesheet} WHERE task_project_name='$project_name' AND task_label='$project_client' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$start_date', '%d/%m/%Y') AND STR_TO_DATE('$date_completed', '%d/%m/%Y')");
		foreach($timesheet_archive_details as $timesheet_archive_detail){
			$timesheet_archive_detail_id = $timesheet_archive_detail->ID;
			$update = $wpdb->update( $table_name_timesheet , array( 
				'task_project_status'	=> "completed_" . $project_start_date ."_". $project_date_completed
			),	
			array( 'ID' => $timesheet_archive_detail_id ),
			array( '%s', '%s' ));
		}
		
	$update = $wpdb->update( $table_name_project , array( 
		'project_date_completed'	=> $project_date_completed,
		'project_hour'				=> $project_hour,
		'project_minute'			=> $project_minute,
		'project_invoiced_amount'	=> $project_invoiced_amount,
		'project_invoice_date'		=> $project_invoice_date,
		'project_default_expenses'	=> $project_default_expenses,
		'project_description'		=> $project_description,
		'project_current_status'	=> 'Invoiced',
		'project_status'			=> 'archived',
		),	
		array( 'ID' => $row_id ),
		array( '%s', '%s' ));
		
		if($update == 1){
			$html = $form_array;
		}else{
			$html = 'Project was Not Updated';
		}	
	}
	
	$table_name_project			= $wpdb->prefix . "custom_project";
	$projects					= $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE ID = $row_id");
	$table_name 				= $wpdb->prefix . "custom_timesheet";
	$timesheets 				= $wpdb->get_results("SELECT * FROM {$table_name}");
	$table_name_person 			= $wpdb->prefix . "custom_person";
	$persons 					= $wpdb->get_results("SELECT * FROM {$table_name_person}");
	
	$project_client 			= (isset($projects->project_client)) ? $projects->project_client : " ";
	$project_name 				= (isset($projects->project_name)) ? $projects->project_name : " ";
	$project_start_date 		= (isset($projects->project_start_date)) ? $projects->project_start_date : " ";
	$project_estimated_deadline = (isset($projects->project_estimated_deadline)) ? $projects->project_estimated_deadline : " ";
	$project_responsible_worker = (isset($projects->project_responsible_worker)) ? $projects->project_responsible_worker : " ";
	$project_current_status 	= (isset($projects->project_current_status)) ? $projects->project_current_status : " ";	
	$project_invoice_date 		= (isset($projects->project_invoice_date)) ? $projects->project_invoice_date : " ";
	$project_budget 			= (isset($projects->project_budget)) ? $projects->project_budget : " ";
	$project_invoiced_amount 	= (isset($projects->project_invoiced_amount)) ? $projects->project_invoiced_amount : " ";
	$today						= date('m/d/Y');
	$project_days_in_production	= dateDiff($project_start_date,$today);
	
	$project_hours = $project_hour.":".$project_minute.":00";
	$project_decimal_hours = decimalHours($project_hours);
	$project_rounded_hour = round($project_decimal_hours, 2);	
	
	$timesheet_hour_decimal = 0;
	foreach($timesheets as $timesheet){
		if($timesheet->task_label == $project_client){
			$task_hour = $timesheet->task_hour;			
			$decimal_hours = decimalHours($task_hour);
			$rounded_hour = round($decimal_hours, 2);		
			$timesheet_hour_decimal += $rounded_hour;				
		}				
	}
	$total_hour_decimal = $timesheet_hour_decimal + $project_rounded_hour;
	$current_expense = $project_default_expenses + $project_extra_expenses;
	
	foreach($persons as $person){
		$person_full_name = $person->person_first_name ." ". $person->person_last_name;
		if($project_responsible_worker == $person_full_name){
			$person_hourly_rate = $person->person_hourly_rate;
			$multiply = $total_hour_decimal * $person_hourly_rate;			
			$add = $multiply + $current_expense;
			$revenue = $project_invoiced_amount - $add;
		}
	}
		
	$html['project_client'] 			= $project_client;
	$html['project_name']				= $project_name;
	$html['project_start_date']			= $project_start_date;
	$html['project_estimated_deadline'] = $project_estimated_deadline;
	$html['project_responsible_worker'] = $project_responsible_worker;
	$html['project_current_status'] 	= $project_current_status;
	$html['project_budget'] 			= $project_budget;
	$html['revenue'] 					= $revenue;	
	$html['project_days_in_production'] = $project_days_in_production;	
	$html['total_hour_decimal'] 		= $total_hour_decimal;	
	$html['project_invoice_date'] 		= $project_invoice_date;	
return $html;
}
/* ==================================== END ARCHIVE MODAL FORM ==================================== */

/* ==================================== EDIT ARCHIVE MODAL FORM ==================================== */
function project_management_edit_archive_modal($data_id){
	global $wpdb;
	$table_name_project			= $wpdb->prefix . "custom_project";
	$projects					= $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE ID = $data_id");	
	$table_name_person 			= $wpdb->prefix . "custom_person";
	$persons					= $wpdb->get_results("SELECT * FROM {$table_name_person}");
	
	$project_client 			= (isset($projects->project_client)) ? $projects->project_client : " ";
	$project_name 				= (isset($projects->project_name)) ? $projects->project_name : " ";
	$project_date_completed 	= (isset($projects->project_date_completed)) ? $projects->project_date_completed : " ";
	$project_estimated_deadline = (isset($projects->project_estimated_deadline)) ? $projects->project_estimated_deadline : " ";
	$project_hour 				= (isset($projects->project_hour)) ? $projects->project_hour : " ";
	$project_minute 			= (isset($projects->project_minute)) ? $projects->project_minute : " ";
	$project_invoiced_amount 	= (isset($projects->project_invoiced_amount)) ? $projects->project_invoiced_amount : " ";
	$project_invoice_date 		= (isset($projects->project_invoice_date)) ? $projects->project_invoice_date : " ";
	$project_default_expenses 	= (isset($projects->project_default_expenses)) ? $projects->project_default_expenses : " ";
	$project_description 		= (isset($projects->project_description)) ? $projects->project_description : " ";
	$project_extra_expenses 	= (isset($projects->project_extra_expenses)) ? $projects->project_extra_expenses : " ";
	$project_responsible_worker = (isset($projects->project_responsible_worker)) ? $projects->project_responsible_worker : " ";
		
	foreach($persons as $person){		
		if($person->person_fullname != $project_responsible_worker){			
			$person_option .= '<option>'.$person->person_fullname.'</option>';
		}
	}
	
	$html = '
	<form method="post" id="edit_archive_modal_project_management" class="archive_modal_project_management">		
	<fieldset>
	<h4>Project Name: '.$project_name.'</h4>
	<h4>Customer: '.$project_client.'</h4>
	<div class="input_div">
	<label class="modal_label">Main Dev.</label>
	<select class="modal_project_responsible_worker" name="project_responsible_worker">
	<option>'.$project_responsible_worker.'</option>
	'. $person_option .'
	</select>
	</div>
	<div class="input_div">
	<label class="modal_label">Invoiced Amount</label>
	<input type="text" class="modal_project_invoiced_amount" name="project_invoiced_amount" value="'.$project_invoiced_amount.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Date Completed</label>
	<input type="text" class="modal_project_date_completed required" name="project_date_completed" value="'.$project_date_completed.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Deadline</label>
	<input type="text" class="modal_project_estimated_deadline" name="project_estimated_deadline" value="'.$project_estimated_deadline.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Time Spent</label>
	<input type="text" class="modal_project_hour" name="project_hour" value="'.$project_hour.'" /><p class="time_label">h</p>
	<input type="text" class="modal_project_minute" name="project_minute" value="'.$project_minute.'" /><p class="time_label">m</p>
	</div>
	<div class="input_div">
	<label class="modal_label">Date of Invoice</label>
	<input type="text" class="modal_project_invoice_date" name="project_invoice_date" value="'.$project_invoice_date.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Current Expenses:</label>
	<p class="current_expense">'.$current_expense.'</p>
	</div>
	<div class="input_div">
	<label class="modal_label">Extra Expenses</label>
	<input type="text" class="modal_project_extra_expenses" name="project_extra_expenses" value="'.$project_extra_expenses.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Default Expenses</label>
	<input type="text" class="modal_project_default_expenses" name="project_default_expenses" value="'.$project_default_expenses.'" />
	</div>
	<div class="input_div">
	<label class="modal_label">Notes</label>
	<input type="text" class="modal_project_description" name="project_description" value="'.$project_description.'" />	
	</div>		
	<div id="modal_update_archive_project_management" class="button_1 action_button">Update</div>
	<div style="display: none;" class="loader achive_modal_loader"></div>
	</fieldset>
	<input type="hidden" value="'.$data_id.'" name="row_id">
	<input type="hidden" value="'.$project_date_completed.'" name="current_project_date_completed" >	
	</form>
	';
	return $html;
}

function update_archive_modal_form($update_archive_form_data){
	global $wpdb;
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_timesheet = $wpdb->prefix . "custom_timesheet";
	$form_array = array();
	parse_str($update_archive_form_data, $form_array);
		$project_invoiced_amount 			= $form_array['project_invoiced_amount'];	
		$project_date_completed				= $form_array['project_date_completed'];		
		$project_estimated_deadline			= $form_array['project_estimated_deadline'];		
		$project_hour						= $form_array['project_hour'];
		$project_minute						= $form_array['project_minute'];
		$project_invoice_date				= $form_array['project_invoice_date'];
		$project_extra_expenses				= $form_array['project_extra_expenses'];
		$project_default_expenses			= $form_array['project_default_expenses'];
		$project_description				= $form_array['project_description'];
		$row_id								= $form_array['row_id'];
		$current_project_date_completed		= $form_array['current_project_date_completed'];
		$project_responsible_worker			= $form_array['project_responsible_worker'];
		
		$project = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE ID = $row_id");		
		$project_name = $project->project_name;
		$project_client = $project->project_client;
		$project_start_date = $project->project_start_date;
		$start_date = date("d/m/Y", strtotime($project_start_date));
		$date_completed = date("d/m/Y", strtotime($project_date_completed));
		$current_date_completed = date("d/m/Y", strtotime($current_project_date_completed));
		$current_timesheet_archive_details = $wpdb->get_results("SELECT * FROM {$table_name_timesheet} WHERE task_project_name='$project_name' AND task_label='$project_client' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$start_date', '%d/%m/%Y') AND STR_TO_DATE('$current_date_completed', '%d/%m/%Y')");
		$timesheet_archive_details = $wpdb->get_results("SELECT * FROM {$table_name_timesheet} WHERE task_project_name='$project_name' AND task_label='$project_client' AND STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$start_date', '%d/%m/%Y') AND STR_TO_DATE('$date_completed', '%d/%m/%Y')");		
		
		foreach($current_timesheet_archive_details as $current_timesheet_archive_detail){
			$current_timesheet_archive_detail_id = $current_timesheet_archive_detail->ID;
			$update = $wpdb->update( $table_name_timesheet , array( 
				'task_project_status'	=> ""
			),	
			array( 'ID' => $current_timesheet_archive_detail_id ),
			array( '%s', '%s' ));
		}
		
		foreach($timesheet_archive_details as $timesheet_archive_detail){
			$timesheet_archive_detail_id = $timesheet_archive_detail->ID;
			$update = $wpdb->update( $table_name_timesheet , array( 
			'task_project_status'	=> "completed_" . $project_start_date ."_". $project_date_completed
			),	
			array( 'ID' => $timesheet_archive_detail_id ),
			array( '%s', '%s' ));
		}
		
		$update = $wpdb->update( $table_name_project , array( 
		'project_date_completed'		=> $project_date_completed,
		'project_estimated_deadline'	=> $project_estimated_deadline,
		'project_hour'					=> $project_hour,
		'project_minute'				=> $project_minute,
		'project_invoiced_amount'		=> $project_invoiced_amount,
		'project_invoice_date'			=> $project_invoice_date,
		'project_default_expenses'		=> $project_default_expenses,
		'project_description'			=> $project_description,
		'project_responsible_worker'	=> $project_responsible_worker,
		'project_current_status'		=> 'Invoiced',
		'project_status'				=> 'archived',
		),	
		array( 'ID' => $row_id ),
		array( '%s', '%s' ));
		
		if($update == 1){
			$html = $form_array;
			}else{
			$html = 'Project was Not Updated';
		}	
	
	$project					= $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE ID = $row_id");
	$table_name 				= $wpdb->prefix . "custom_timesheet";
	$timesheets 				= $wpdb->get_results("SELECT * FROM {$table_name}");
	$table_name_person 			= $wpdb->prefix . "custom_person";
	$persons 					= $wpdb->get_results("SELECT * FROM {$table_name_person}");
	
	$project_client				= $project->project_client;
	$project_name				= $project->project_name;
	$project_start_date			= $project->project_start_date;		
	$project_estimated_deadline	= $project->project_estimated_deadline;
	$project_hour				= $project->project_hour;
	$project_minute				= $project->project_minute;
	$project_date_completed		= $project->project_date_completed;
	$project_responsible_worker = $project->project_responsible_worker;
	$project_current_status		= $project->project_current_status;
	$project_description		= $project->project_description;
	$project_budget				= $project->project_budget;
	$project_extra_expenses		= $project->project_extra_expenses;
	$project_invoice_date		= $project->project_invoice_date;
	$project_invoiced_amount	= $project->project_invoiced_amount;
	
	$today						= date('m/d/Y');
	if($project_start_date != null && $project_date_completed != null){
		$project_days_in_production	= dateDiff($project_start_date,$project_date_completed);			
	}else{
		$project_days_in_production = "--";
	}
	$project_hours = $project_hour.":".$project_minute.":00";
	$project_decimal_hours = decimalHours($project_hours);
	$project_rounded_hour = round($project_decimal_hours, 2);
	
	$task_project_status = "completed_".$project_start_date ."_". $project_date_completed;
	$completed_timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND task_project_status='$task_project_status'");
	
	$timesheet_hour_decimal = 0;			
	foreach($completed_timesheets as $completed_timesheet){													
		$task_hour = $completed_timesheet->task_hour;					
		$decimal_hours = decimalHours($task_hour);
		$rounded_hour = round($decimal_hours, 2);		
		$timesheet_hour_decimal += $rounded_hour;			
	}
	$total_hour_decimal = $timesheet_hour_decimal + $project_rounded_hour;
	$current_expense = $project_default_expenses + $project_extra_expenses;
	
	foreach($persons as $person){
		$person_full_name = $person->person_first_name ." ". $person->person_last_name;
		if($project_responsible_worker == $person_full_name){														
			$person_hourly_rate = $person->person_hourly_rate;														
			$multiply = $timesheet_hour_decimal * $person_hourly_rate;
			$add = $multiply + $current_expense;
			$revenue = $project_invoiced_amount - $add;													
		}
	}
	
	$project_date_completed_format = date("d/m/y", strtotime($project_date_completed));
	$project_date_completed_explode = explode('/', $project_date_completed_format);
	$project_date_completed_mktime = mktime(0, 0, 0, $project_date_completed_explode[1], $project_date_completed_explode[0], $project_date_completed_explode[2]);
	
	$project_estimated_deadline_format = date("d/m/y", strtotime($project_estimated_deadline));
	$project_estimated_deadline_explode = explode('/', $project_estimated_deadline_format);
	$project_estimated_deadline_mktime = mktime(0, 0, 0, $project_estimated_deadline_explode[1], $project_estimated_deadline_explode[0], $project_estimated_deadline_explode[2]);
	
	$archive_edit_array['project_client'] 						= $project_client;
	$archive_edit_array['project_name'] 						= $project_name;
	$archive_edit_array['project_start_date'] 					= $project_start_date;
	$archive_edit_array['project_days_in_production'] 			= $project_days_in_production;
	$archive_edit_array['project_date_completed'] 				= $project_date_completed;	
	$archive_edit_array['project_estimated_deadline'] 			= $project_estimated_deadline;
	$archive_edit_array['project_invoice_date'] 				= $project_invoice_date;
	$archive_edit_array['total_hour_decimal'] 					= round_quarter($total_hour_decimal);
	$archive_edit_array['revenue']								= $revenue;
	$archive_edit_array['project_responsible_worker'] 			= $project_responsible_worker;
	$archive_edit_array['project_current_status'] 				= $project_current_status;
	$archive_edit_array['project_description'] 					= $project_description;
	$archive_edit_array['project_date_completed_mktime']		= $project_date_completed_mktime;
	$archive_edit_array['project_estimated_deadline_mktime']	= $project_estimated_deadline_mktime;
	$archive_edit_array['row_id']								= $row_id;
	
	
	return $archive_edit_array;
}
/* ==================================== END EDIT ARCHIVE MODAL FORM ==================================== */

/* ==================================== DELETE MODAL FORM ==================================== */
function delete_confirm_modal_form($data_id){
	global $wpdb;
	$table_name_project = $wpdb->prefix . "custom_project";
	$projects			= $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE ID = $data_id");
	$project_name		= $projects->project_name;
	$project_client		= $projects->project_client;
	
	$html = '
	<form method="post" id="delete_modal_project_management">
	<fieldset>
	<h3>Are you sure you want to delete?</h3>
	<h4>Project Name:'.$project_name.'</h4>
	<h4>Customer:'.$project_client.'</h4>	
	<div class="button_2 modal_cancel_button modal_cancel_project_management">Cancel</div>
	<div id="modal_delete_project_management" class="button_1 action_button">Delete</div>
	<div style="display: none;" class="loader"></div>
	</fieldset>
	<input type="hidden" value="'.$data_id.'" name="row_id">
	</form>
	';
	
	return $html;
}

function delete_modal_form($delete_form_data){
	global $wpdb;
	$table_name_project = $wpdb->prefix . "custom_project";
	
	$form_array = array();
	parse_str($delete_form_data, $form_array);
	$row_id = $form_array['row_id'];
	
	if(isset($row_id)) {	
		global $wpdb;	
		$table_name = $wpdb->prefix . "custom_department";
		
		$delete = $wpdb->query( "DELETE FROM {$table_name_project} WHERE ID = '$row_id'" ) ;
		
		if($delete == 1){
			$html = $form_array;
		}else{
			$html = 'Project was Not Updated';
		}
	}
	return $form_array;
}
/* ==================================== END DELETE MODAL FORM ==================================== */

/* ==================================== FILTER COMPLETED WEBDEV ==================================== */
function pm_completed_webdev_filter($filter_year){
	global $wpdb;
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_name = $wpdb->prefix . "custom_timesheet";
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$project_client_temp = "";
	$filter_year_query = "STR_TO_DATE(project_date_completed, '%m/%d/%Y') BETWEEN STR_TO_DATE('01/01/$filter_year', '%m/%d/%Y') AND STR_TO_DATE('12/31/$filter_year', '%m/%d/%Y')";
	$project_completed = $wpdb->get_results("SELECT * FROM {$table_name_project} WHERE $filter_year_query ORDER BY STR_TO_DATE(project_start_date, '%m/%d/%Y') DESC");
	$year_total_hour_decimal = "";
	$year_total_revenue = "";
	if($project_completed != null){
		foreach($project_completed as $project){
			if($project->project_date_completed != null){
				if($project->project_name != 'Monthly Ongoing SEO' && $project->project_name != 'Monthly Ongoing Dev'){	
					if($project->project_client != 'SEOWeb Solutions'){
						$project_client				= $project->project_client;
						$project_name				= $project->project_name;
						$project_start_date			= $project->project_start_date;		
						$project_estimated_deadline	= $project->project_estimated_deadline;
						$project_hour				= $project->project_hour;
						$project_minute				= $project->project_minute;
						$project_date_completed		= $project->project_date_completed;
						$project_responsible_worker = $project->project_responsible_worker;
						$project_current_status		= $project->project_current_status;
						$project_description		= $project->project_description;
						$project_budget				= $project->project_budget;
						$project_extra_expenses		= $project->project_extra_expenses;
						$project_invoice_date		= $project->project_invoice_date;
						$project_invoiced_amount	= $project->project_invoiced_amount;
						
						$today						= date('m/d/Y');
						if($project_start_date != null && $project_date_completed != null){
							$project_days_in_production	= dateDiff($project_start_date,$project_date_completed);			
							}else{
							$project_days_in_production = "--";
						}
						$project_hours = $project_hour.":".$project_minute.":00";
						$project_decimal_hours = decimalHours($project_hours);
						$project_rounded_hour = round($project_decimal_hours, 2);
						
						$task_project_status = "completed_".$project_start_date ."_". $project_date_completed;
						$completed_timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_project_name='$project_name' AND task_label='$project_client' AND task_project_status='$task_project_status'");
						
						$timesheet_hour_decimal = 0;			
						foreach($completed_timesheets as $completed_timesheet){													
							$task_hour = $completed_timesheet->task_hour;					
							$decimal_hours = decimalHours($task_hour);
							$rounded_hour = round($decimal_hours, 2);		
							$timesheet_hour_decimal += $rounded_hour;			
						}
						
						if($project_rounded_hour != null || $project_rounded_hour != 0){
							$total_hour_decimal = $project_rounded_hour;
						}else{
							$total_hour_decimal = $timesheet_hour_decimal;
						}
						$current_expense = $project_default_expenses + $project_extra_expenses;
						
						foreach($persons as $person){
							$person_full_name = $person->person_first_name ." ". $person->person_last_name;
							if($project_responsible_worker == $person_full_name){														
								$person_hourly_rate = $person->person_hourly_rate;														
								$multiply = $total_hour_decimal * $person_hourly_rate;
								$add = $multiply + $current_expense;
								$revenue = $project_invoiced_amount - $add;													
							}
						}
						
						$project_date_completed_format = date("d/m/y", strtotime($project_date_completed));
						$project_date_completed_explode = explode('/', $project_date_completed_format);
						$project_date_completed_mktime = mktime(0, 0, 0, $project_date_completed_explode[1], $project_date_completed_explode[0], $project_date_completed_explode[2]);
						
						$project_estimated_deadline_format = date("d/m/y", strtotime($project_estimated_deadline));
						$project_estimated_deadline_explode = explode('/', $project_estimated_deadline_format);
						$project_estimated_deadline_mktime = mktime(0, 0, 0, $project_estimated_deadline_explode[1], $project_estimated_deadline_explode[0], $project_estimated_deadline_explode[2]);
						
						$project_id	= $project->ID;
											
						$project_management_filter_details['project_management_filter_details'][] = $project_id ."_". $project_client ."_". $project_name ."_". $project_start_date ."_". $project_days_in_production ."_". $project_date_completed ."_". $project_estimated_deadline ."_". $project_invoice_date ."_". round_quarter($total_hour_decimal) ."_". round($revenue) ."_". $project_responsible_worker ."_". $project_current_status ."_". $project_description ."_". $project_date_completed_mktime ."_". $project_estimated_deadline_mktime ."_". $today;					
					}
				}
			}
			$year_total_hour_decimal += $total_hour_decimal;
			$year_total_revenue += $revenue;
		}
		
		$project_management_filter_details['result'] = 'not_null';
		$project_management_filter_details['year_total_hour_decimal'] = round_quarter($year_total_hour_decimal);
		$project_management_filter_details['year_total_revenue'] = round($year_total_revenue);				
	}else{
		$project_management_filter_details['result'] = 'null';
	}
	$project_management_filter_details['filter_year'] = $filter_year;
	return $project_management_filter_details;
	
}
/* ==================================== END FILTER COMPLETED WEBDEV ==================================== */
/* ==================================== FILTER CURRENT SEO  ==================================== */
function pm_current_seo_filter($filter_details){
	$filter_details_explode = explode('_', $filter_details);
	$filter_year = $filter_details_explode[0];
	$filter_month = strlen($filter_details_explode[1]);
	if($filter_month == 1){
		$filter_month = '0' . $filter_details_explode[1];
	}else{
		$filter_month = $filter_details_explode[1];
	}
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_project = $wpdb->prefix . "custom_project";	
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_monthly_plan = $wpdb->prefix . "custom_monthly_plan";
	$table_name_task = $wpdb->prefix . "custom_task";
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY project_client ASC");
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	
	$project_client_temp = "";
	$seo_ongoing_array = array();
	$seo_hours = array();
	$count = 0;
	foreach($projects as $project){
		if($project->project_date_completed == null){
			if($project->project_invoice_method == 1){
				if($project->project_name == 'Monthly Ongoing SEO' || $project->project_name == 'Monthly Ongoing Dev'){
					if($project->project_client != 'SEOWeb Solutions'){												
						$project_client				= $project->project_client;
						$project_name				= $project->project_name;
						$project_start_date			= $project->project_start_date;		
						$project_estimated_deadline	= $project->project_estimated_deadline;
						$project_hour				= $project->project_hour;
						$project_minute				= $project->project_minute;
						$project_responsible_worker = $project->project_responsible_worker;
						$project_current_status		= $project->project_current_status;
						$project_description		= $project->project_description;
						$project_budget				= $project->project_budget;
						$project_extra_expenses		= $project->project_extra_expenses;
						$project_default_expenses	= $project->project_default_expenses;
						$project_invoiced_amount	= $project->project_invoiced_amount;
						
						$project_monthly_plan = $project->project_monthly_plan;
						$monthly_plans = $wpdb->get_row("SELECT * FROM {$table_monthly_plan} WHERE monthly_name='$project_monthly_plan'");							
						$monthly_budget = $monthly_plans->monthly_budget;
						$monthly_seo_extra_expense = $monthly_plans->monthly_seo_extra_expense;
						$monthly_dev_extra_expense = $monthly_plans->monthly_dev_extra_expense;							
						if($filter_month == 'null'){					
							$seo_filter_query = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/$filter_year', '%d/%m/%Y') AND STR_TO_DATE('31/12/$filter_year', '%d/%m/%Y')";
						}else{
							$seo_filter_query = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$filter_month/$filter_year', '%d/%m/%Y') AND STR_TO_DATE('31/$filter_month/$filter_year', '%d/%m/%Y')";
						}
						
						$year_hours = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $seo_filter_query AND task_project_name = '$project_name' AND task_label = '$project_client'");					
						$total_year_hours_seo = "";
						$total_year_hours_dev = "";
						$total_year_con_hours = "";
						$total_year_hours = "";												
						foreach($year_hours as $year_hour){
							$task_name = format_task_name($year_hour->task_name);
							$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");
							$task_person = $year_hour->task_person;
							$task_hour = $year_hour->task_hour;	
							if($tasks->task_billable == 1){																				
								if($project_name == 'Monthly Ongoing SEO'){
									$task_hour_decimal_seo = round(decimalHours($task_hour), 2);
									$total_year_hours_seo += $task_hour_decimal_seo;
								}													
								if($project_name == 'Monthly Ongoing Dev'){
									$task_hour_decimal_dev = round(decimalHours($task_hour), 2);
									$total_year_hours_dev += $task_hour_decimal_dev;
								}																					
								$task_hour = $year_hour->task_hour;
								$task_hour_decimal = round(decimalHours($task_hour), 2);
								$total_year_hours += $task_hour_decimal;
							}else{
								if($year_hour->task_person == 'Quima May Renegado'){														
									$task_hour_decimal_con = round(decimalHours($task_hour), 2);
									$total_year_con_hours += $task_hour_decimal_con;														
								}
							}
						}
						
						$current_expense = $project_default_expenses + $project_extra_expenses + $monthly_seo_extra_expense + $monthly_dev_extra_expense;
						$seo_hours[$project_client][] = $total_year_hours_seo;
						if($total_year_hours_seo != null){
							$ar_total_year_hours_seo = $total_year_hours_seo;
							}elseif($ar_total_year_hours_seo == null){
							$ar_total_year_hours_seo =  0;
						}
						
						if($current_expense != null){
							$ar_current_expense = $current_expense;
							}elseif($ar_current_expense == null){
							$ar_current_expense =  0;
						}
						
						if($total_year_con_hours != null){
							$ar_total_year_con_hours = $total_year_con_hours;
							}elseif($ar_total_year_con_hours == null){
							$ar_total_year_con_hours =  0;
						}
						
						if($project_budgets != null){
							$project_budgets = $project_budgets + $project_budget;
							}else{
							$project_budgets = $project_budget;
						}
						
						if($project_descriptions != null){
							$project_descriptions = $project_descriptions .'<join>'. $project_description;
							}else{
							$project_descriptions = $project_description;
						}
						
						$ar_total_year_hours_dev = ($total_year_hours_dev != null) ? $total_year_hours_dev : 0;												
						$ar_total_year_hours = ($total_year_hours != null) ? $total_year_hours : 0;												
						$ar_project_budgets = ($project_budgets != null) ? $project_budgets : 0;												
						
						$seo_ongoing_array[$project_client] = $ar_total_year_hours_seo ."<_>". $ar_total_year_hours_dev ."<_>". $ar_total_year_con_hours ."<_>". $ar_current_expense ."<_>". $ar_project_budgets ."<_>". $project_descriptions;
						if($count == 1){
							$ar_total_year_con_hours = "";
							$project_budgets = "";
							$project_descriptions = "";
							$count = 0;
							}else{
							$count++;
						}											
					}
				}
			}
		}
	}
	
	foreach($seo_ongoing_array as $seo_ongoing_client => $seo_ongoing){
		$seo_detail_explode = explode('<_>', $seo_ongoing);
		if($seo_hours[$seo_ongoing_client][0] != null && $seo_hours[$seo_ongoing_client][1] == null){
			$total_year_hours_seo = $seo_hours[$seo_ongoing_client][0];
		}elseif($seo_hours[$seo_ongoing_client][0] == null && $seo_hours[$seo_ongoing_client][1] != null){
			$total_year_hours_seo = $seo_hours[$seo_ongoing_client][1];
		}elseif($seo_hours[$seo_ongoing_client][0] == null && $seo_hours[$seo_ongoing_client][1] == null){
			$total_year_hours_seo = 0;
		}
		// $total_year_hours_seo = $seo_detail_explode[0];
		$total_year_hours_dev = $seo_detail_explode[1];
		$total_year_con_hours = $seo_detail_explode[2];
		$current_expense = $seo_detail_explode[3];
		$project_budget = $seo_detail_explode[4];
		$project_description_explode = explode('<join>',$seo_detail_explode[5]);
		$prject_description_seo = $project_description_explode[0];
		$prject_description_dev = $project_description_explode[1];
		$client_details = $wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name='$seo_ongoing_client'");
		$client_id = $client_details->ID;
		
		$project_details_seo = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name='Monthly Ongoing SEO' AND project_client='$seo_ongoing_client'");										
		$monthly_plan_seo_name = ($project_details_seo->project_monthly_plan) ? $project_details_seo->project_monthly_plan : "--";
		$monthly_plans_seo = $wpdb->get_row("SELECT * FROM {$table_monthly_plan} WHERE monthly_name='$monthly_plan_seo_name'");										
		$monthly_plans_seo_hour = ($monthly_plans_seo->monthly_seo_hours) ? $monthly_plans_seo->monthly_seo_hours : "--";
		$monthly_plans_seo_budget = $monthly_plans_seo->monthly_budget;
		
		$project_details_dev = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name='Monthly Ongoing Dev' AND project_client='$seo_ongoing_client'");
		$monthly_plan_dev_name = ($project_details_dev->project_monthly_plan != null) ? $project_details_dev->project_monthly_plan : "--";
		$monthly_plans_dev = $wpdb->get_row("SELECT * FROM {$table_monthly_plan} WHERE monthly_name='$monthly_plan_dev_name'");										
		$monthly_plans_dev_hour = ($monthly_plans_dev->monthly_webdev_hours) ? $monthly_plans_dev->monthly_webdev_hours : "--";
		if($filter_month == 'null'){	
			$monthly_plans_dev_budget += $monthly_plans_dev->monthly_budget;	
		}else{
			$monthly_plans_dev_budget = $monthly_plans_dev->monthly_budget;	
		}	
		
		
		$total_year_hours = $total_year_hours_seo + $total_year_hours_dev + $total_year_con_hours;
		
		
		foreach($persons as $person){
			$person_full_name = $person->person_fullname;
			$person_hourly_rate = $person->person_hourly_rate;
			if($person_full_name == 'Cristobal Dela Cuesta'){
				$multiply_tobal = $total_year_hours_seo * $person_hourly_rate;														
			}
			if($person_full_name == 'Gray Gonzales'){
				$multiply_gray = $total_year_hours_dev * $person_hourly_rate;														
			}
			if($person_full_name == 'Quima May Renegado'){
				$multiply_quima = $total_year_con_hours * $person_hourly_rate;														
			}
		}										
		$project_expense = $current_expense + $multiply_tobal + $multiply_gray + $multiply_quima;
				
		if($monthly_plans_seo_budget != null){
			$monthly_plans_buget = $monthly_plans_seo_budget;
			}else{
			$monthly_plans_buget = $monthly_plans_dev_budget;
		}
		
		$revenue = $monthly_plans_buget - $project_expense;
		if($revenue < 0){
			$revenue_class = 'redbg';
			}else{
			$revenue_class = 'greenbg';
		}
		
		$filter_current_seo_array['current_seo_filter_details'][] = $client_id ."_". $seo_ongoing_client ."_". round_quarter($monthly_plans_seo_hour) ."_". round_quarter($monthly_plans_dev_hour) ."_". round_quarter($total_year_hours_seo) ."_". round_quarter($total_year_hours_dev) ."_". round_quarter($total_year_con_hours) ."_". round_quarter($total_year_hours) ."_". $project_expense ."_". round($revenue) ."_". $revenue_class ."_". $project_description ."_". $monthly_plans_buget;	
	}
	$filter_current_seo_array['filter_details'] = $filter_details;
	return $filter_current_seo_array;
}
/* ==================================== END FILTER CURRENT SEO  ==================================== */

/* ==================================== FILTER CURRENT INTERNAL DEV  ==================================== */
function pm_current_internal_dev_filter($filter_details){
	$filter_details_explode = explode('_', $filter_details);
	$filter_year = $filter_details_explode[0];
	$filter_month = strlen($filter_details_explode[1]);
	if($filter_month == 1){
		$filter_month = '0' . $filter_details_explode[1];
	}else{
		$filter_month = $filter_details_explode[1];
	}
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_project = $wpdb->prefix . "custom_project";	
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_monthly_plan = $wpdb->prefix . "custom_monthly_plan";
	$table_name_task = $wpdb->prefix . "custom_task";	
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");	
	$project_internal_ongoing = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY STR_TO_DATE(project_start_date, '%m/%d/%Y') DESC");
	$project_client_temp = "";
	$filter_current_internal_dev_array = array();
	foreach($project_internal_ongoing as $project){
		if($project->project_date_completed == null){
			// if($project->project_name != 'Monthly Ongoing SEO' && $project->project_name != 'Monthly Ongoing Dev'){
				if($project->project_client == 'SEOWeb Solutions'){
					$project_id 				= $project->ID;
					$project_client				= ($project->project_client != null) ? $project->project_client : "--";;
					$project_name				= ($project->project_name != null) ? $project->project_name : "--";
					$project_start_date			= ($project->project_start_date != null) ? $project->project_start_date : "--";
					$project_estimated_deadline	= ($project->project_estimated_deadline != null) ? $project->project_estimated_deadline : "--";
					$project_hour				= ($project->project_hour != null) ? $project->project_hour : "--";
					$project_minute				= ($project->project_minute != null) ? $project->project_minute : "--";
					$project_responsible_worker = ($project->project_responsible_worker != null) ? $project->project_responsible_worker : "--";
					$project_current_status		= ($project->project_current_status != null) ? $project->project_current_status : "--";
					$project_description		= ($project->project_description != null) ? $project->project_description : "--";
					$project_budget				= ($project->project_budget != null) ? $project->project_budget : "--";
					$project_extra_expenses		= ($project->project_extra_expenses != null) ? $project->project_extra_expenses : "--";
					$project_default_expenses	= ($project->project_default_expenses != null) ? $project->project_default_expenses : "--";
					$project_invoiced_amount	= ($project->project_invoiced_amount != null) ? $project->project_invoiced_amount : "--";
					
					$today = date('m/d/Y');
					
					if($project_start_date != null){
						$project_days_in_production	= dateDiff($project_start_date,$today);
					}else{
						$project_days_in_production = "--";
					}
					
					$project_hours = $project_hour.":".$project_minute.":00";
					$project_decimal_hours = decimalHours($project_hours);
					$project_rounded_hour = round($project_decimal_hours, 2);
					
					$start_date = date("d/m/Y", strtotime($project_start_date));
					$today_date	= date('d/m/Y');					
					
					if($filter_month == 'null'){					
						$internal_dev_filter_query = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/$filter_year', '%d/%m/%Y') AND STR_TO_DATE('31/12/$filter_year', '%d/%m/%Y')";
					}else{
						$internal_dev_filter_query = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$filter_month/$filter_year', '%d/%m/%Y') AND STR_TO_DATE('31/$filter_month/$filter_year', '%d/%m/%Y')";
					}
					$timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $internal_dev_filter_query AND task_project_name='$project_name' AND task_label='$project_client'");					
					$timesheet_hour_decimal = "";											
					foreach($timesheets as $timesheet){
						if($timesheet->task_label == $project_client){							
							$task_hour = $timesheet->task_hour;										
							$decimal_hours = decimalHours($task_hour);
							$rounded_hour = round($decimal_hours, 2);		
							$timesheet_hour_decimal += $rounded_hour;
						}				
					}
					
					if($project_rounded_hour != null || $project_rounded_hour != 0){
						$total_hour_decimal = $project_rounded_hour;
					}else{
						$total_hour_decimal = $timesheet_hour_decimal;
					}
					$current_expense = $project_default_expenses + $project_extra_expenses;
					
					foreach($persons as $person){
						$person_full_name = $person->person_fullname;
						if($project_responsible_worker == $person_full_name){
							$person_hourly_rate = $person->person_hourly_rate;
							$multiply = $total_hour_decimal * $person_hourly_rate;					
							$add = $multiply + $current_expense;
							$revenue = $project_budget - $add;
						}
					}					
					$filter_current_internal_dev_array['current_internal_dev_filter_details'][] = 
					$project_id ."_". 
					$project_client ."_". 
					$project_name ."_". 
					$project_start_date ."_". 
					$project_days_in_production ."_". 
					$project_estimated_deadline ."_". 
					(($today > $project_estimated_deadline) ? "redbg" : "") ."_". 
					round_quarter($total_hour_decimal) ."_". 
					$revenue ."_". 
					(($revenue > 0) ? "greenbg" : "redbg") ."_". 
					$current_expense ."_". 
					$project_responsible_worker ."_". 
					$project_current_status ."_". 
					$project_description;					
				}
			// }
		}
	}
	$filter_current_internal_dev_array['filter_details'] = $filter_details;
	return $filter_current_internal_dev_array;
}
/* ==================================== END FILTER CURRENT INTERNAL DEV  ==================================== */

/* ==================================== FILTER CURRENT INTERNAL SEO  ==================================== */
function pm_current_internal_seo_filter($filter_details){
	$filter_details_explode = explode('_', $filter_details);
	$filter_year = $filter_details_explode[0];
	$filter_month = strlen($filter_details_explode[1]);
	if($filter_month == 1){
		$filter_month = '0' . $filter_details_explode[1];
		}else{
		$filter_month = $filter_details_explode[1];
	}
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_project = $wpdb->prefix . "custom_project";	
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_monthly_plan = $wpdb->prefix . "custom_monthly_plan";
	$table_name_task = $wpdb->prefix . "custom_task";	
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");	
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY project_client ASC");
		$project_client_temp = "";
		foreach($projects as $project){
			if($project->project_date_completed == null){
				// if($project->project_name == 'Monthly Ongoing SEO' || $project->project_name == 'Monthly Ongoing Dev'){	
					if($project->project_client == 'SEOWeb Solutions'){						
						$project_id 				= $project->ID;
						$project_client				= ($project->project_client != null) ? $project->project_client : "--";;
						$project_name				= ($project->project_name != null) ? $project->project_name : "--";
						$project_start_date			= ($project->project_start_date != null) ? $project->project_start_date : "--";
						$project_estimated_deadline	= ($project->project_estimated_deadline != null) ? $project->project_estimated_deadline : "--";
						$project_hour				= ($project->project_hour != null) ? $project->project_hour : "--";
						$project_minute				= ($project->project_minute != null) ? $project->project_minute : "--";
						$project_responsible_worker = ($project->project_responsible_worker != null) ? $project->project_responsible_worker : "--";
						$project_current_status		= ($project->project_current_status != null) ? $project->project_current_status : "--";
						$project_description		= ($project->project_description != null) ? $project->project_description : "--";
						$project_budget				= ($project->project_budget != null) ? $project->project_budget : "--";
						$project_extra_expenses		= ($project->project_extra_expenses != null) ? $project->project_extra_expenses : "--";
						$project_default_expenses	= ($project->project_default_expenses != null) ? $project->project_default_expenses : "--";
						$project_invoiced_amount	= ($project->project_invoiced_amount != null) ? $project->project_invoiced_amount : "--";
						
						$today						= date('m/d/Y');
						if($project_start_date != null){
							$project_days_in_production	= dateDiff($project_start_date,$today);
							}else{
							$project_days_in_production = "--";
						}
						
						$project_hours = $project_hour.":".$project_minute.":00";
						$project_decimal_hours = decimalHours($project_hours);
						$project_rounded_hour = round($project_decimal_hours, 2);
						
						$start_date	= date('1/m/Y');
						$end_date	= date('31/m/Y');
						
						if($filter_month == 'null'){					
							$internal_seo_filter_query = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/$filter_year', '%d/%m/%Y') AND STR_TO_DATE('31/12/$filter_year', '%d/%m/%Y')";
						}else{
							$internal_seo_filter_query = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$filter_month/$filter_year', '%d/%m/%Y') AND STR_TO_DATE('31/$filter_month/$filter_year', '%d/%m/%Y')";
						}
						
						$timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $internal_seo_filter_query AND task_project_name='$project_name' AND task_label='$project_client'");
						
						$timesheet_hour_decimal = "";
						foreach($timesheets as $timesheet){
							if($timesheet->task_label == $project_client && $timesheet->task_project_name == $project_name){
								$task_hour = $timesheet->task_hour;
								$decimal_hours = decimalHours($task_hour);
								$rounded_hour = round($decimal_hours, 2);		
								$timesheet_hour_decimal += $rounded_hour;
							}
						}
						
						if($project_rounded_hour != null || $project_rounded_hour != 0){
							$total_hour_decimal = $project_rounded_hour;
							}else{
							$total_hour_decimal = $timesheet_hour_decimal;
						}
						
						$project_monthly_plan = $project->project_monthly_plan;
						$monthly_plans = $wpdb->get_row("SELECT * FROM {$table_monthly_plan} WHERE monthly_name='$project_monthly_plan'");							
						$monthly_budget = $monthly_plans->monthly_budget;
						$monthly_seo_extra_expense = $monthly_plans->monthly_seo_extra_expense;
						$monthly_dev_extra_expense = $monthly_plans->monthly_dev_extra_expense;							
						if($project_name == 'Monthly Ongoing SEO'){
							$monthly_plan_hour = $monthly_plans->monthly_seo_hours;
							}elseif($project_name == 'Monthly Ongoing Dev'){
							$monthly_plan_hour = $monthly_plans->monthly_webdev_hours;
						}
						
						
						$current_year = date('Y');
						$year_filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/$current_year', '%d/%m/%Y') AND STR_TO_DATE('31/12/$current_year', '%d/%m/%Y')";
						$year_hours = $wpdb->get_results("SELECT task_hour FROM {$table_name} WHERE $year_filter AND task_project_name = '$project_name' AND task_label = '$project_client'");
						$total_year_hours = "";
						foreach($year_hours as $year_hour){
							$task_hour = $year_hour->task_hour;
							$task_hour_decimal = round(decimalHours($task_hour), 2);
							$total_year_hours += $task_hour_decimal;
						}
						
						$current_expense = $project_default_expenses + $project_extra_expenses + $monthly_seo_extra_expense + $monthly_dev_extra_expense;
						foreach($persons as $person){
							$person_full_name = $person->person_first_name." ".$person->person_last_name;
							if($project_responsible_worker == $person_full_name){
								$person_hourly_rate = $person->person_hourly_rate;
								$multiply = $total_hour_decimal * $person_hourly_rate;					
								$project_expenses = $multiply + $current_expense;
								$revenue = $monthly_budget - $project_expenses;
							}
						}						
						$filter_current_internal_seo_array['current_internal_seo_filter_details'][] = 
						$project_id ."_". 
						$project_client ."_". 
						$project_name ."_". 
						round_quarter($timesheet_hour_decimal) ."_". 
						(($monthly_plan_hour != '') ? $monthly_plan_hour : "--") ."_". 
						round_quarter($total_year_hours) ."_". 
						(($monthly_budget != '') ? $monthly_budget : "--") ."_". 
						$project_expenses ."_". 
						(($revenue != '') ? $revenue : "--") ."_".
						(($revenue > 0) ? "greenbg" : "redbg") ."_". 
						$project_description;
					}
				// }
			}
		}
	$filter_current_internal_seo_array['filter_details'] = $filter_details;
	return $filter_current_internal_seo_array;
}
/* ==================================== END FILTER CURRENT INTERNAL SEO  ==================================== */

/* ==================================== FILTER CURRENT CUSTOMER ISSUE / BUG ==================================== */
function pm_current_issue_bug_filter($filter_details){
	$filter_details_explode = explode('_', $filter_details);
	$filter_year = $filter_details_explode[0];
	$filter_month = strlen($filter_details_explode[1]);
	if($filter_month == 1){
		$filter_month = '0' . $filter_details_explode[1];
		}else{
		$filter_month = $filter_details_explode[1];
	}
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_project = $wpdb->prefix . "custom_project";	
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_monthly_plan = $wpdb->prefix . "custom_monthly_plan";
	$table_name_task = $wpdb->prefix . "custom_task";	
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");	
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY project_client ASC");	
	$project_issue_bug_ongoing = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY STR_TO_DATE(project_start_date, '%m/%d/%Y') DESC");
	$project_client_temp = "";
	foreach($project_issue_bug_ongoing as $project){
		if($project->project_date_completed == null){
			if($project->project_name != 'Monthly Ongoing SEO' && $project->project_name != 'Monthly Ongoing Dev'){												
				if($project->project_name == 'Issue/Bug'){
					$project_id 				= $project->ID;
					$project_client				= $project->project_client;
					$project_name				= $project->project_name;
					$project_start_date			= $project->project_start_date;		
					$project_estimated_deadline	= $project->project_estimated_deadline;
					$project_hour				= $project->project_hour;
					$project_minute				= $project->project_minute;
					$project_responsible_worker = $project->project_responsible_worker;
					$project_current_status		= $project->project_current_status;
					$project_description		= $project->project_description;
					$project_budget				= $project->project_budget;
					$project_extra_expenses		= $project->project_extra_expenses;
					$project_default_expenses	= $project->project_default_expenses;
					$project_invoiced_amount	= $project->project_invoiced_amount;
					
					$today						= date('m/d/Y');
					if($project_start_date != null){
						$project_days_in_production	= dateDiff($project_start_date,$today);
						}else{
						$project_days_in_production = "--";
					}
					
					$project_hours = $project_hour.":".$project_minute.":00";
					$project_decimal_hours = decimalHours($project_hours);
					$project_rounded_hour = round($project_decimal_hours, 2);
					
					$start_date = date("d/m/Y", strtotime($project_start_date));
					$today_date	= date('d/m/Y');
					
					if($filter_month == 'null'){					
						$issue_bug_filter_query = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/$filter_year', '%d/%m/%Y') AND STR_TO_DATE('31/12/$filter_year', '%d/%m/%Y')";
					}else{
						$issue_bug_filter_query = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$filter_month/$filter_year', '%d/%m/%Y') AND STR_TO_DATE('31/$filter_month/$filter_year', '%d/%m/%Y')";
					}
					
					$timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $issue_bug_filter_query AND task_project_name='$project_name' AND task_label='$project_client'");
					
					$timesheet_hour_decimal = "";											
					foreach($timesheets as $timesheet){
						if($timesheet->task_label == $project_client){
							$task_hour = $timesheet->task_hour;										
							$decimal_hours = decimalHours($task_hour);
							$rounded_hour = round($decimal_hours, 2);		
							$timesheet_hour_decimal += $rounded_hour;
						}				
					}
					
					if($project_rounded_hour != null || $project_rounded_hour != 0){
						$total_hour_decimal = $project_rounded_hour;
						}else{
						$total_hour_decimal = $timesheet_hour_decimal;
					}
					$current_expense = $project_default_expenses + $project_extra_expenses;
					
					foreach($persons as $person){
						$person_full_name = $person->person_first_name ." ". $person->person_last_name;
						if($project_responsible_worker == $person_full_name){
							$person_hourly_rate = $person->person_hourly_rate;
							$multiply = $total_hour_decimal * $person_hourly_rate;					
							$add = $multiply + $current_expense;
							$revenue = $project_budget - $add;
						}
					}
					$filter_current_issue_bug_array['current_issue_bug_filter_details'][] = 
					$project_id ."_". 
					(($project_client != '') ? $project_client : "--") ."_". 
					(($project_name != '') ? $project_name : "--") ."_". 
					(($project_start_date != '') ? $project_start_date : "--") ."_". 
					(($project_days_in_production != '') ? $project_days_in_production : "--") ."_". 
					(($project_estimated_deadline != '') ? $project_estimated_deadline : "--") ."_". 
					(($today > $project_estimated_deadline) ? "redbg" : "") ."_". 
					(($total_hour_decimal != '') ? round_quarter($total_hour_decimal) : "--") ."_".
					(($revenue != '') ? $revenue : "--") ."_".
					(($revenue > 0) ? "greenbg" : "redbg") ."_". 
					(($current_expense != '') ? $current_expense : "--") ."_".
					(($project_responsible_worker != '') ? $project_responsible_worker : "--") ."_".
					(($project_current_status != '') ? $project_current_status : "--") ."_".
					(($project_description != '') ? $project_description : "--");
				}
			}
		}
	}
	return $filter_current_issue_bug_array;
}
/* ==================================== END FILTER CURRENT CUSTOMER ISSUE / BUG  ==================================== */

/* ==================================== SAVE PROJECT CATEGORY AND COLOR ==================================== */
function project_category_color_save($project_category_color){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_project_color";
	
	$proj_cat_col = explode("_", $project_category_color);
	$project_category = $proj_cat_col[0];
	$project_color = ucfirst($proj_cat_col[1]);
	
	$insert = $wpdb->insert( $table_name , array( 
		'project_category' => $project_category,
		'project_color' => $project_color
	),	
	array( '%s', '%s' ));
	
	return $project_category_color;
}
/* ==================================== END SAVE PROJECT CATEGORY AND COLOR ==================================== */

/* ==================================== FILTER REPORTS TIME ==================================== */
function filter_report_time($filter_details){
	$filter_details_explode = explode("_", $filter_details);
	$week_number = $filter_details_explode[0];
	$month_number = $filter_details_explode[1];
	$year = $filter_details_explode[2];
	$from_month = $filter_details_explode[3];
	$to_month = $filter_details_explode[4];
	$from_date = $filter_details_explode[5];
	$to_date = $filter_details_explode[6];
	
	global $wpdb;
	if($week_number != 'null'){
		$week = getStartAndEndDate($week_number, $year);
		$start = date("d_m_Y", strtotime($week[0]));
		$end = date("d_m_Y", strtotime($week[1]));
		$start_explode = explode('_', $start);
		$start_month = $start_explode[1];
		$end_explode = explode('_', $end);
		$end_month = $start_explode[1];
	}
	
	/* Filter Week */	
	if(	$week_number != 'null' && $month_number != 'null' && $year != 'null' && $from_month == 'null' && $to_month == 'null' && $from_date == 'null' && $to_date == 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$start_month/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$end_month/$year', '%d/%m/%Y') AND week_number = '$week_number'";
	}
	/* Filter Month */
	elseif(	$week_number == 'null' && $month_number != 'null' && $year != 'null' &&	$from_month == 'null' && $to_month == 'null' &&	$from_date == 'null' &&	$to_date == 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$month_number/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$month_number/$year', '%d/%m/%Y')";
	}
	/* Filter Year */
	elseif(	$week_number == 'null' && $month_number == 'null' && $year != 'null' &&	$from_month == 'null' && $to_month == 'null' &&	$from_date == 'null' && $to_date == 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/$year', '%d/%m/%Y') AND STR_TO_DATE('31/12/$year', '%d/%m/%Y')";
	}
	/* Filter Quarter */
	elseif(	$week_number == 'null' && $month_number == 'null' && $year != 'null' && $from_month != 'null' && $to_month != 'null' && $from_date == 'null' && $to_date == 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$from_month/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$to_month/$year', '%d/%m/%Y')"; 
	}
	/* Filter Custom */
	elseif(	$week_number == 'null' && $month_number == 'null' && $year == 'null' && $from_month == 'null' && $to_month == 'null' && $from_date != 'null' && $to_date != 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$from_date', '%d/%m/%Y') AND STR_TO_DATE('$to_date', '%d/%m/%Y')"; 
	}
	
	return $filter;
}

/* TOP REPORT */
function filter_report_time_top($filter_details){
	// die();
		
	$filter_details_explode = explode("_", $filter_details);
	$week_number = $filter_details_explode[0];
	$month_number = $filter_details_explode[1];
	$year = $filter_details_explode[2];
	$from_month = $filter_details_explode[3];
	$to_month = $filter_details_explode[4];
	$from_date = $filter_details_explode[5];
	$to_date = $filter_details_explode[6];

	global $wpdb;
	$filter = filter_report_time($filter_details);	
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_task = $wpdb->prefix . "custom_task";
	
	$import_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter");
	
	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project}");
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
	
	
	/* Filter Week */
	if(	$week_number != 'null' && $month_number != 'null' && $year != 'null' && $from_month == 'null' && $to_month == 'null' && $from_date == 'null' && $to_date == 'null'){
		$week = getStartAndEndDate($week_number, $year);
		$start_num = $week[0];
		$end_num = $week[1];
		$start = date("d M Y", strtotime($start_num));
		$end = date("d M Y", strtotime($end_num));
		$report_top_label = "Week: " . $start . "-" . $end;
		/* Filter Month */
		}elseif($week_number == 'null' && $month_number != 'null' && $year != 'null' &&	$from_month == 'null' && $to_month == 'null' &&	$from_date == 'null' &&	$to_date == 'null'){
		$month_name = date("F", mktime(0, 0, 0, $month_number, 10));
		$report_top_label = "Month: " . $month_name ." ". $year;
		/* Filter Year */
		}elseif($week_number == 'null' && $month_number == 'null' && $year != 'null' &&	$from_month == 'null' && $to_month == 'null' &&	$from_date == 'null' && $to_date == 'null'){
		$report_top_label = "Year: " . $year;
		/* Filter Quarter */
		}elseif($week_number == 'null' && $month_number == 'null' && $year != 'null' && $from_month != 'null' && $to_month != 'null' && $from_date == 'null' && $to_date == 'null'){
		$from_month_name = date("F", mktime(0, 0, 0, $from_month, 10));
		$to_month_name = date("F", mktime(0, 0, 0, $to_month, 10));
		$report_top_label = "Quarter: " . $from_month_name ."-". $to_month_name ." ". $year;
		/* Filter Custom */
		}elseif($week_number == 'null' && $month_number == 'null' && $year == 'null' && $from_month == 'null' && $to_month == 'null' && $from_date != 'null' && $to_date != 'null'){
		// $from_date_format = date("F d Y", strtotime($from_date));
		// $to_date_format = date("F d Y", strtotime($to_date));
		$from_date_explode = explode("/", $from_date);
		$from_date_month_name = date("F", mktime(0, 0, 0, $from_date_explode[1], 10));
		$from = $from_date_month_name ." ". $from_date_explode[0] .", ". $from_date_explode[2];
		
		$to_date_explode = explode("/", $to_date);		
		$to_date_month_name = date("F", mktime(0, 0, 0, $to_date_explode[1], 10));
		$to = $to_date_month_name ." ". $to_date_explode[0] .", ". $to_date_explode[2];
		$report_top_label = "Custom: " . $from ."-". $to;
	}
	$report_details['report_top_label'] = $report_top_label;
	
	$top_total_hour_decimal = "";
	$billable_id_array = array();
	$unbillable_id_array = array();
	foreach($import_data as $timesheet_data){
		$task_hour = $timesheet_data->task_hour;
		$task_hour_decimal = round(decimalHours($task_hour), 2);					
		$top_total_hour_decimal += $task_hour_decimal;
		$task_project_name = $timesheet_data->task_project_name;
		$task_client_name = $timesheet_data->task_label;
		$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");		
		if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
			$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
			foreach($timesheet_items as $timesheet_item){
				$task_name = format_task_name($timesheet_item->task_name);
				$timesheet_id = $timesheet_item->ID;
				$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
				if($tasks->task_billable == 1){
					array_push($billable_id_array,$timesheet_id);
					}else{
					array_push($unbillable_id_array,$timesheet_id);
				}
			}
		}
		
		if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
			$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");												
			foreach($timesheet_items as $timesheet_item){
				$task_name = format_task_name($timesheet_item->task_name);
				$timesheet_id = $timesheet_item->ID;
				$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
				if($tasks->task_billable == 1){													
					array_push($billable_id_array,$timesheet_id);
					}else{
					array_push($unbillable_id_array,$timesheet_id);
				}
			}
		}
	}	
	$billable_ids = array_unique($billable_id_array);
	$top_billable_total_hour_decimal = "";
	$top_total_billable_amount = "";
	foreach($billable_ids as $id){					
		$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");				
		$billable_task_hour = $billable_timesheet_data->task_hour;
		$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
		$top_billable_total_hour_decimal += $billable_task_hour_decimal;
		$fullname = $billable_timesheet_data->task_person;						
		$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
		$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
		$client_name = $billable_timesheet_data->task_label;
		$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");	
		$client_hourly_rate = $client_info->client_hourly_rate;
		$task_billable_amount = $billable_task_hour_decimal * $client_hourly_rate;
		$top_total_billable_amount += $task_billable_amount;
	}
	
	$unbillable_ids = array_unique($unbillable_id_array);
	$top_unbillable_total_hour_decimal = "";
	$total_unbillable_amount = "";
	$top_ledig_time_decimal = "";
	$top_no_work_decimal = "";
	$top_seoweb_decimal = "";
	$top_bq_decimal = "";
	foreach($unbillable_ids as $id){
		$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
		$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
		$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);

		$top_taskname = strtolower($unbillable_timesheet_data->task_name );

	
		if($top_taskname == 'ledig'){
			$top_no_work_decimal += round(decimalHours($unbillable_task_hour), 2);
		}
		if($top_taskname == 'helg'){
			$top_no_work_decimal += round(decimalHours($unbillable_task_hour), 2);
		}

		if($top_taskname == 'semester'){
			$semester += round(decimalHours($unbillable_task_hour), 2);
		}
		if($top_taskname == 'sjuk'){
			$top_no_work_decimal += round(decimalHours($unbillable_task_hour), 2);
		}
		if($top_taskname == 'seoweb'){
			$top_seoweb_decimal += round(decimalHours($unbillable_task_hour), 2);
		}
		if($top_taskname == 'bq'){
			$top_bq_decimal += round(decimalHours($unbillable_task_hour), 2);
		}


		$top_unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
		$fullname = $unbillable_timesheet_data->task_person;																						
		$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
		$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
		$client_name = $unbillable_timesheet_data->task_label;
		$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");												
		$client_hourly_rate = $client_info->client_hourly_rate;
		$task_unbillable_amount = $unbillable_task_hour_decimal * $persons_person_hourly_rate;
		$total_unbillable_amount += $task_unbillable_amount; 
	}

		$total_no_work = $top_no_work_decimal + $top_seoweb_decimal + $top_bq_decimal;
		$top_dwork_total_hour_decimal = $top_total_hour_decimal - $total_no_work;


	$top_report_details = round_quarter($top_total_hour_decimal) ."_". round_quarter($top_billable_total_hour_decimal) ."_". round_quarter($top_ledig_time_decimal) ."_". round_quarter($top_unbillable_total_hour_decimal) ."_". $top_total_billable_amount  ."_". round_quarter($top_no_work_decimal) ."_". round_quarter($top_dwork_total_hour_decimal);
	$report_details['top_report_detail'] = $top_report_details;	
	
	return $report_details;
}
/* END TOP REPORT */

/* CLIENT */
function filter_report_time_client($filter_details){	
	// die();
	ini_set('max_execution_time', 190);
	$filter_details_explode = explode("_", $filter_details);
	$week_number = $filter_details_explode[0];
	$month_number = $filter_details_explode[1];
	$year = $filter_details_explode[2];
	$from_month = $filter_details_explode[3];
	$to_month = $filter_details_explode[4];
	$from_date = $filter_details_explode[5];
	$to_date = $filter_details_explode[6];
	global $wpdb;
	$filter = filter_report_time($filter_details);
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_task = $wpdb->prefix . "custom_task";
	
	$import_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter ORDER BY task_label ASC");
	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project}");
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
	
	$task_client_name_array = array();
	foreach ($import_data as $timesheet_data){
		$task_client_name = $timesheet_data->task_label;
		array_push($task_client_name_array,$task_client_name);
	}
	$client_names = array_unique($task_client_name_array);
	$client_tab_total_hour = "";							
	$client_tab_total_billable_hour = "";
	$client_details_array = array();
	foreach($client_names as $client_name){ 
		$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_label = '$client_name'");										
		$array_count = count($timesheet_data);
		$total_client_hours = "";
		$billable_id_array = array();
		$unbillable_id_array = array();
		for($x = 0; $x <= $array_count; $x++){
			$task_hour = $timesheet_data[$x]->task_hour;
			$task_hour_decimal = round(decimalHours($task_hour), 2);
			$total_client_hours += $task_hour_decimal;
			$task_project_name = $timesheet_data[$x]->task_project_name;
			$task_client_name =$timesheet_data[$x]->task_label;
			$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");								
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
			
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){													
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
		}
		$billable_ids = array_unique($billable_id_array);
		$billable_total_hour_decimal = "";
		$total_billable_amount = "";
		foreach($billable_ids as $id){
			$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$billable_task_hour = $billable_timesheet_data->task_hour;
			$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);											
			$billable_total_hour_decimal += $billable_task_hour_decimal;			
			$fullname = $billable_timesheet_data->task_person;			
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$client_name = $billable_timesheet_data->task_label;
			$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");
			$client_hourly_rate = $client_info->client_hourly_rate;
			$task_billable_amount = $billable_task_hour_decimal * $client_hourly_rate;
			$total_billable_amount += $task_billable_amount;
		}
		
		$unbillable_ids = array_unique($unbillable_id_array);
		$unbillable_total_hour_decimal = "";
		$total_unbillable_amount = "";
		foreach($unbillable_ids as $id){
			$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
			$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
			$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
			$fullname = $unbillable_timesheet_data->task_person;																						
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$client_name = $unbillable_timesheet_data->task_label;
			$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");											
			$client_hourly_rate = $client_info->client_hourly_rate;
			$task_unbillable_amount = $unbillable_task_hour_decimal * $client_hourly_rate;
			$total_unbillable_amount += $task_unbillable_amount;
		}
		
		$client_tab_total_hour += $total_client_hours;										
		$client_tab_total_billable_hour += $billable_total_hour_decimal;
		$client_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
		$client_tab_total_billable_amount += $total_billable_amount;
		$client_tab_total_unbillable_amount += $total_unbillable_amount;
		
		$client_details = $client_name ."_". round_quarter($total_client_hours) ."_". round_quarter($billable_total_hour_decimal) ."_". ($total_billable_amount != "" ? ($total_billable_amount) : 0) ."_". round_quarter($unbillable_total_hour_decimal) . "_" .($total_unbillable_amount != "" ? ($total_unbillable_amount) : 0) ;
		$client_details_array[] = $client_details;
		$report_details['client_details'] = $client_details_array;
	}
	$report_details['client_tab_total_hour'] = round_quarter($client_tab_total_hour);
	$report_details['client_tab_total_billable_hour'] = round_quarter($client_tab_total_billable_hour);
	$report_details['client_tab_total_unbillable_hour'] = round_quarter($client_tab_total_unbillable_hour);
	$report_details['client_tab_total_billable_amount'] = $client_tab_total_billable_amount;
	$report_details['client_tab_total_unbillable_amount'] = $client_tab_total_unbillable_amount;
	return $report_details;
}
/* END CLIENT */

/* PROJECTS */
function filter_report_time_project($filter_details){
	// die();
		
	$filter_details_explode = explode("_", $filter_details);
	$week_number = $filter_details_explode[0];
	$month_number = $filter_details_explode[1];
	$year = $filter_details_explode[2];
	$from_month = $filter_details_explode[3];
	$to_month = $filter_details_explode[4];
	$from_date = $filter_details_explode[5];
	$to_date = $filter_details_explode[6];
	global $wpdb;
	$filter = filter_report_time($filter_details);
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_task = $wpdb->prefix . "custom_task";
	
	$import_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter ORDER BY task_project_name DESC");
	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project}");
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
	
	
	$project_client_array = array();
	foreach ($import_data as $timesheet_data){
		$project_name = $timesheet_data->task_project_name;
		$task_client_name = $timesheet_data->task_label;
		$project_client_combine = $project_name ."_". $task_client_name;
		array_push($project_client_array, $project_client_combine);
	}
	$project_clients = array_unique($project_client_array);
	foreach($project_clients as $project_client){
		$project_client_explode = explode("_", $project_client);
		$project_name_title = $project_client_explode[0];
		$client_name_title = $project_client_explode[1];
		
		$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter  AND task_project_name ='$project_name_title' AND task_label = '$client_name_title'");										
		$array_count = count($timesheet_data);
		$total_project_hour = "";
		$billable_id_array = array();
		$unbillable_id_array = array();
		for($x = 0; $x <= $array_count; $x++){
			$task_hour = $timesheet_data[$x]->task_hour;
			$task_hour_decimal = round(decimalHours($task_hour), 2);
			$total_project_hour += $task_hour_decimal;
			$task_project_name = $timesheet_data[$x]->task_project_name;
			$task_client_name =$timesheet_data[$x]->task_label;
			$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");			
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
			
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){													
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
		}																			
		$billable_ids = array_unique($billable_id_array);
		$billable_total_hour_decimal = "";
		$total_billable_amount = "";
		foreach($billable_ids as $id){
			$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$billable_task_hour = $billable_timesheet_data->task_hour;
			$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
			$billable_total_hour_decimal += $billable_task_hour_decimal;			
			$fullname = $billable_timesheet_data->task_person;			
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$client_name = $billable_timesheet_data->task_label;
			$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");
			$client_hourly_rate = $client_info->client_hourly_rate;
			$task_billable_amount = $billable_task_hour_decimal * $client_hourly_rate;
			$total_billable_amount += $task_billable_amount;
		}
		
		$unbillable_ids = array_unique($unbillable_id_array);
		$unbillable_total_hour_decimal = "";
		$total_unbillable_amount = "";
		foreach($unbillable_ids as $id){
			$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
			$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
			$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
			$fullname = $unbillable_timesheet_data->task_person;																						
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$client_name = $unbillable_timesheet_data->task_label;	
			$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");										
			$client_hourly_rate = $client_info->client_hourly_rate;
			$task_unbillable_amount = $unbillable_task_hour_decimal * $client_hourly_rate;
			$total_unbillable_amount += $task_unbillable_amount;
		}
		
		$project_tab_total_hour += $total_project_hour;
		$project_tab_total_billable_hour += $billable_total_hour_decimal;
		$project_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
		$project_tab_total_billable_amount += $total_billable_amount;
		$project_tab_total_unbillable_amount += $total_unbillable_amount;
		
		$project_details = $project_name_title ."_". $client_name_title ."_". round_quarter($total_project_hour) ."_". round_quarter($billable_total_hour_decimal) ."_". ($total_billable_amount != "" ? ($total_billable_amount) : 0) ."_". round_quarter($unbillable_total_hour_decimal) . "_". ($total_unbillable_amount != "" ? ($total_unbillable_amount) : 0);
		$project_details_array[] = $project_details;
		$report_details['project_details'] = $project_details_array;
	}
	$report_details['project_tab_total_hour'] = round_quarter($project_tab_total_hour);
	$report_details['project_tab_total_billable_hour'] = round_quarter($project_tab_total_billable_hour);
	$report_details['project_tab_total_unbillable_hour'] = round_quarter($project_tab_total_unbillable_hour);	
	$report_details['project_tab_total_billable_amount'] = $project_tab_total_billable_amount;
	$report_details['project_tab_total_unbillable_amount'] = $project_tab_total_unbillable_amount;
	
	return $report_details;
}
/* END PROJECTS */

/* TASKS */
function filter_report_time_task($filter_details){
	// die();
	$filter_details_explode = explode("_", $filter_details);
	$week_number = $filter_details_explode[0];
	$month_number = $filter_details_explode[1];
	$year = $filter_details_explode[2];
	$from_month = $filter_details_explode[3];
	$to_month = $filter_details_explode[4];
	$from_date = $filter_details_explode[5];
	$to_date = $filter_details_explode[6];
	global $wpdb;
	$filter = filter_report_time($filter_details);
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_task = $wpdb->prefix . "custom_task";
	
	$import_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter ORDER BY task_name ASC");
	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project}");
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
	
	
	$task_name_array = array();
	foreach ($import_data as $timesheet_data){
		$task_names = format_task_name($timesheet_data->task_name);
		array_push($task_name_array, $task_names);
	}									
	$task_name = array_unique($task_name_array);
	foreach($task_name as $task){
		$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_name ='$task'");
		$total_task_hour = "";
		$billable_id_array = array();
		$unbillable_id_array = array();
		foreach($timesheet_data as $timesheet_item){											
			$task_hour = $timesheet_item->task_hour;
			$task_hour_decimal = round(decimalHours($task_hour), 2);
			$total_task_hour += $task_hour_decimal;
			$task_project_name = $timesheet_item->task_project_name;
			$task_client_name = $timesheet_item->task_label;
			$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_name = '$task' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){
						array_push($billable_id_array,$timesheet_id);
					}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
			
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_name = '$task' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){													
						array_push($billable_id_array,$timesheet_id);
					}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}			
		}
		$billable_ids = array_unique($billable_id_array);
		$billable_total_hour_decimal = "";
		$total_billable_amount = "";
		foreach($billable_ids as $id){
			$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$billable_task_hour = $billable_timesheet_data->task_hour;
			$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
			$billable_total_hour_decimal += $billable_task_hour_decimal;			
			$fullname = $billable_timesheet_data->task_person;
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$client_name = $billable_timesheet_data->task_label;
			$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");
			$client_hourly_rate = $client_info->client_hourly_rate;
			$task_billable_amount = $billable_task_hour_decimal * $client_hourly_rate;
			$total_billable_amount += $task_billable_amount;
		}
		
		$unbillable_ids = array_unique($unbillable_id_array);
		$unbillable_total_hour_decimal = "";
		$total_unbillable_amount = "";
		foreach($unbillable_ids as $id){
			$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
			$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
			$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
			$fullname = $unbillable_timesheet_data->task_person;																						
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$client_name = $unbillable_timesheet_data->task_label;
			$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");										
			$client_hourly_rate = $client_info->client_hourly_rate;
			$task_unbillable_amount = $unbillable_task_hour_decimal * $client_hourly_rate;
			$total_unbillable_amount += $task_unbillable_amount;
		}
		
		$task_tab_total_hour += $total_task_hour;
		$task_tab_total_billable_hour += $billable_total_hour_decimal;
		$task_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
		$task_tab_total_billable_amount += $total_billable_amount;
		$task_tab_total_unbillable_amount += $total_unbillable_amount;
		
		$task_details = format_task_name($task) ."_". round_quarter($total_task_hour) ."_". round_quarter($billable_total_hour_decimal) ."_". ($total_billable_amount != "" ? ($total_billable_amount) : 0) ."_". round_quarter($unbillable_total_hour_decimal) ."_". ($total_unbillable_amount != "" ? ($total_unbillable_amount) : 0);
		$task_details_array[] = $task_details;
		$report_details['task_details'] = $task_details_array;
	}
	$report_details['task_tab_total_hour'] = round_quarter($task_tab_total_hour);
	$report_details['task_tab_total_billable_hour'] = round_quarter($task_tab_total_billable_hour);
	$report_details['task_tab_total_unbillable_hour'] = round_quarter($task_tab_total_unbillable_hour);	
	$report_details['task_tab_total_billable_amount'] = $task_tab_total_billable_amount;
	$report_details['task_tab_total_unbillable_amount'] = $task_tab_total_unbillable_amount;
	
	
	return $report_details;
}
/* END TASKS */

/* STAFF */
function filter_report_time_staff($filter_details){

	$filter_details_explode = explode("_", $filter_details);
	$week_number = $filter_details_explode[0];
	$month_number = $filter_details_explode[1];
	$year = $filter_details_explode[2];
	$from_month = $filter_details_explode[3];
	$to_month = $filter_details_explode[4];
	$from_date = $filter_details_explode[5];
	$to_date = $filter_details_explode[6];
	global $wpdb;
	$filter = filter_report_time($filter_details);
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_task = $wpdb->prefix . "custom_task";
	
	$import_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter ORDER BY task_person ASC");
	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project}");
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
	
	
	$person_name_array = array();
	foreach ($import_data as $timesheet_data){
		$person_names = $timesheet_data->task_person;
		array_push($person_name_array, $person_names);
	}									
	$person_name = array_unique($person_name_array);
	foreach($person_name as $person){
		$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_person ='$person'");
		$total_person_hour = 0;

		$billable_id_array = array();
		$unbillable_id_array = array();


		foreach($timesheet_data as $timesheet_item){											
			$task_hour = $timesheet_item->task_hour;
			$task_hour_decimal = round(decimalHours($task_hour), 2);
			$total_person_hour += $task_hour_decimal;
			$task_project_name = $timesheet_item->task_project_name;

			$task_client_name = $timesheet_item->task_label;
			$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");
			// if($person == "Johan Bergqvist"){
			// 	print_r("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");
			// }
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_person = '$person' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);

					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
			


			// if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
			// 	$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_person = '$person' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
			// 	foreach($timesheet_items as $timesheet_item){
			// 		$task_name = format_task_name($timesheet_item->task_name);
			// 		$timesheet_id = $timesheet_item->ID;
			// 		$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");
			// 		if($tasks->task_billable == 1){													
			// 			array_push($billable_id_array,$timesheet_id);
			// 			}else{
			// 			array_push($unbillable_id_array,$timesheet_id);
			// 		}
			// 	}
			// }			
		}
		$billable_ids = array_unique($billable_id_array);
		$billable_total_hour_decimal = 0;
		$total_billable_amount = "";
		$total_no_work = 0;
		foreach($billable_ids as $id){
			$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$billable_task_hour = $billable_timesheet_data->task_hour;
			$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
			$billable_total_hour_decimal += $billable_task_hour_decimal;
			$fullname = $billable_timesheet_data->task_person;
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$client_name = $billable_timesheet_data->task_label;
			$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");
			$persons_person_hourly_rate = $persons->person_hourly_rate;
			$client_hourly_rate = $client_info->client_hourly_rate;
			$task_billable_amount = $billable_task_hour_decimal * $client_hourly_rate;
			$total_billable_amount += $task_billable_amount;
		}

		
		$unbillable_ids = array_unique($unbillable_id_array);
		$unbillable_total_hour_decimal = 0;
		$total_unbillable_amount = "";

		foreach($unbillable_ids as $id){
			$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
			$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
			$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
			$fullname = $unbillable_timesheet_data->task_person;																						
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$client_name = $unbillable_timesheet_data->task_label;
			$client_info = 	$wpdb->get_row("SELECT * FROM {$table_name_client} WHERE client_name ='$client_name'");										
			$client_hourly_rate = $client_info->client_hourly_rate;
			$task_unbillable_amount = $unbillable_task_hour_decimal * $client_hourly_rate;
			$total_unbillable_amount += $task_unbillable_amount;
		}
	
		$non_working_timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_person = '$person'");										
		$holiday_total_hour_decimal = "";
		$vacation_total_hour_decimal = "";
		$sickness_total_hour_decimal = "";
		$ledig_total_hour_decimal = "";
		$seoweb_total_hour_decimal = "";
		$bq_total_hour_decimal = "";
	

		$electric_internet_total_hour_decimal = "";
		foreach($non_working_timesheet_items as $non_working_timesheet_item){
		// print_var($non_working_timesheet_item);
			$task_name = strtolower($non_working_timesheet_item->task_name);
			if($task_name == 'helg'){
				$holiday_task_hour = $non_working_timesheet_item->task_hour;
				$holiday_task_hour_decimal = round(decimalHours($holiday_task_hour), 2);											
				$holiday_total_hour_decimal += $holiday_task_hour_decimal;
			}											
			if($task_name == 'semester'){
				$vacation_task_hour = $non_working_timesheet_item->task_hour;
				$vacation_task_hour_decimal = round(decimalHours($vacation_task_hour), 2);											
				$vacation_total_hour_decimal += $vacation_task_hour_decimal;	
			}
			if($task_name == 'sjuk'){
				$sickness_task_hour = $non_working_timesheet_item->task_hour;
				$sickness_task_hour_decimal = round(decimalHours($sickness_task_hour), 2);											
				$sickness_total_hour_decimal += $sickness_task_hour_decimal;	
			}

			if($task_name == 'ledig'){
				$ledig_task_hour = $non_working_timesheet_item->task_hour;
				$ledig_task_hour_decimal = round(decimalHours($ledig_task_hour), 2);											
				$ledig_total_hour_decimal += $ledig_task_hour_decimal;													
			}
			if($task_name == 'seoweb'){
				$seoweb_task_hour = $non_working_timesheet_item->task_hour;
				$seoweb_task_hour_decimal = round(decimalHours($seoweb_task_hour), 2);											
				$seoweb_total_hour_decimal += $seoweb_task_hour_decimal;
			}
			if($task_name == 'bq'){
				$bq_task_hour = $non_working_timesheet_item->task_hour;
				$bq_task_hour_decimal = round(decimalHours($bq_task_hour), 2);											
				$bq_total_hour_decimal += $bq_task_hour_decimal;
			}

	
			// if($task_name == 'electric / internet problems'){
			// 	$electric_internet_task_hour = $non_working_timesheet_item->task_hour;
			// 	$electric_internet_task_hour_decimal = round(decimalHours($electric_internet_task_hour), 2);											
			// 	$electric_internet_total_hour_decimal += $electric_internet_task_hour_decimal;	
			// }
		}

		$dwork_total_hour_decimal = $sickness_total_hour_decimal + $vacation_total_hour_decimal + $ledig_total_hour_decimal + $seoweb_total_hour_decimal + $bq_total_hour_decimal;

		// $dwork_total_hour_decimal = $tid_total_hour_decimal;

		// print_r($dwork_total_hour_decimal . '<br/>');


	
		$person_tab_total_hour += $total_person_hour;
		$person_tab_total_billable_hour += $billable_total_hour_decimal;
		$person_tab_total_billable_amount += $total_billable_amount;
		$person_tab_total_unbillable_amount += $total_unbillable_amount;		
		$person_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
		$person_tab_total_holiday_hour += $holiday_total_hour_decimal;
		$person_tab_total_vacation_hour += $vacation_total_hour_decimal;
		$person_tab_total_sickness_hour += $sickness_total_hour_decimal;
		$person_tab_total_ledig_hour += $ledig_total_hour_decimal;
		$person_tab_total_seoweb_hour += $seoweb_total_hour_decimal;
		$dwork_total_hour = 0;


		$dwork_total_hour_decimal_hour = $total_person_hour - $dwork_total_hour_decimal;
		$person_tab_total_dwork_hour += $dwork_total_hour_decimal_hour;


		if($dwork_total_hour_decimal_hour != 0){
			$dwork_percent =  round(($billable_total_hour_decimal   / $dwork_total_hour_decimal_hour ) * 100);
		}else{
			$dwork_percent = 0;
		}

		if($person_tab_total_dwork_hour != 0){
			$total_dwork_percent = round(($person_tab_total_billable_hour / $person_tab_total_dwork_hour) * 100 );
		}else{
			$total_dwork_percent = 0;
		}

		$person_details = $person ."_". round_quarter($total_person_hour) ."_". round_quarter($dwork_total_hour_decimal_hour) ."_".  round_quarter($billable_total_hour_decimal) ."_".round_quarter($unbillable_total_hour_decimal) ."_". ($total_billable_amount != "" ? ($total_billable_amount) : 0) ."_". round_quarter($ledig_total_hour_decimal) ."_". round_quarter($holiday_total_hour_decimal) ."_". round_quarter($vacation_total_hour_decimal) ."_". round_quarter($sickness_total_hour_decimal) ."_". $dwork_percent;
		$person_details_array[] = $person_details;
		$report_details['person_details'] = $person_details_array;
	}
	$report_details['person_tab_total_hour'] = round_quarter($person_tab_total_hour);
	$report_details['person_tab_total_dwork_hour'] = round_quarter($person_tab_total_dwork_hour);
	$report_details['person_tab_total_billable_hour'] = round_quarter($person_tab_total_billable_hour);
	$report_details['person_tab_total_unbillable_hour'] = round_quarter($person_tab_total_unbillable_hour);
	$report_details['person_tab_total_billable_amount'] = $person_tab_total_billable_amount;
	$report_details['person_tab_total_ledig_hour'] = round_quarter($person_tab_total_ledig_hour);
	$report_details['person_tab_total_holiday_hour'] = round_quarter($person_tab_total_holiday_hour);
	$report_details['person_tab_total_vacation_hour'] = round_quarter($person_tab_total_vacation_hour);
	$report_details['person_tab_total_sickness_hour'] = round_quarter($person_tab_total_sickness_hour);
	$report_details['person_tab_total_dwork_pecent'] = $total_dwork_percent;		
	
	return $report_details;	
}
/* END STAFF */

function filter_report_time_client_test($filter_details){

	// set_time_limit(0);
	ini_set('max_execution_time', 600);
	//print_var($filter_details);
	$filter_details_explode = explode("_", $filter_details);
	$week_number = $filter_details_explode[0];
	$month_number = $filter_details_explode[1];
	$year = $filter_details_explode[2];
	$from_month = $filter_details_explode[3];
	$to_month = $filter_details_explode[4];
	$from_date = $filter_details_explode[5];
	$to_date = $filter_details_explode[6];
	
	global $wpdb;
	if($week_number != 'null'){
		$week = getStartAndEndDate($week_number, $year);
		$start = date("d_m_Y", strtotime($week[0]));
		$end = date("d_m_Y", strtotime($week[1]));
		$start_explode = explode('_', $start);
		$start_month = $start_explode[1];
		$end_explode = explode('_', $end);
		$end_month = $start_explode[1];
	}
	
	/* Filter Week */	
	if(	$week_number != 'null' && $month_number != 'null' && $year != 'null' && $from_month == 'null' && $to_month == 'null' && $from_date == 'null' && $to_date == 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$start_month/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$end_month/$year', '%d/%m/%Y') AND week_number = '$week_number'";
	}
	/* Filter Month */
	elseif(	$week_number == 'null' && $month_number != 'null' && $year != 'null' &&	$from_month == 'null' && $to_month == 'null' &&	$from_date == 'null' &&	$to_date == 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$month_number/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$month_number/$year', '%d/%m/%Y')";
	}
	/* Filter Year */
	elseif(	$week_number == 'null' && $month_number == 'null' && $year != 'null' &&	$from_month == 'null' && $to_month == 'null' &&	$from_date == 'null' && $to_date == 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/$year', '%d/%m/%Y') AND STR_TO_DATE('31/12/$year', '%d/%m/%Y')";
	}
	/* Filter Quarter */
	elseif(	$week_number == 'null' && $month_number == 'null' && $year != 'null' && $from_month != 'null' && $to_month != 'null' && $from_date == 'null' && $to_date == 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$from_month/$year', '%d/%m/%Y') AND STR_TO_DATE('31/$to_month/$year', '%d/%m/%Y')"; 
	}
	/* Filter Custom */
	elseif(	$week_number == 'null' && $month_number == 'null' && $year == 'null' && $from_month == 'null' && $to_month == 'null' && $from_date != 'null' && $to_date != 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$from_date', '%d/%m/%Y') AND STR_TO_DATE('$to_date', '%d/%m/%Y')"; 
	}
	
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_task = $wpdb->prefix . "custom_task";
	
	$import_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter");
	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project}");
	$tasks = $wpdb->get_results("SELECT * FROM {$table_name_task}");
	
	// /* TOP REPORT */
	// /* Filter Week */
	// if(	$week_number != 'null' && $month_number != 'null' && $year != 'null' && $from_month == 'null' && $to_month == 'null' && $from_date == 'null' && $to_date == 'null'){
		// $week = getStartAndEndDate($week_number, $year);
		// $start_num = $week[0];
		// $end_num = $week[1];
		// $start = date("d M Y", strtotime($start_num));
		// $end = date("d M Y", strtotime($end_num));
		// $report_top_label = "Week: " . $start . "-" . $end;
	// /* Filter Month */
	// }elseif($week_number == 'null' && $month_number != 'null' && $year != 'null' &&	$from_month == 'null' && $to_month == 'null' &&	$from_date == 'null' &&	$to_date == 'null'){
		// $month_name = date("F", mktime(0, 0, 0, $month_number, 10));
		// $report_top_label = "Month: " . $month_name ." ". $year;
	// /* Filter Year */
	// }elseif($week_number == 'null' && $month_number == 'null' && $year != 'null' &&	$from_month == 'null' && $to_month == 'null' &&	$from_date == 'null' && $to_date == 'null'){
		// $report_top_label = "Year: " . $year;
	// /* Filter Quarter */
	// }elseif($week_number == 'null' && $month_number == 'null' && $year != 'null' && $from_month != 'null' && $to_month != 'null' && $from_date == 'null' && $to_date == 'null'){
		// $from_month_name = date("F", mktime(0, 0, 0, $from_month, 10));
		// $to_month_name = date("F", mktime(0, 0, 0, $to_month, 10));
		// $report_top_label = "Quarter: " . $from_month_name ."-". $to_month_name ." ". $year;
	// /* Filter Custom */
	// }elseif($week_number == 'null' && $month_number == 'null' && $year == 'null' && $from_month == 'null' && $to_month == 'null' && $from_date != 'null' && $to_date != 'null'){
		/////////////////// $from_date_format = date("F d Y", strtotime($from_date));
		////////////////// $to_date_format = date("F d Y", strtotime($to_date));
		// $from_date_explode = explode("/", $from_date);
		// $from_date_month_name = date("F", mktime(0, 0, 0, $from_date_explode[1], 10));
		// $from = $from_date_month_name ." ". $from_date_explode[0] .", ". $from_date_explode[2];
		
		// $to_date_explode = explode("/", $to_date);		
		// $to_date_month_name = date("F", mktime(0, 0, 0, $to_date_explode[1], 10));
		// $to = $to_date_month_name ." ". $to_date_explode[0] .", ". $to_date_explode[2];
		// $report_top_label = "Custom: " . $from ."-". $to;
	// }
	// $report_details['report_top_label'] = $report_top_label;
	
	// $top_total_hour_decimal = "";
	// $billable_id_array = array();
	// $unbillable_id_array = array();
	// foreach($import_data as $timesheet_data){
		// $task_hour = $timesheet_data->task_hour;
		// $task_hour_decimal = round(decimalHours($task_hour), 2);					
		// $top_total_hour_decimal += $task_hour_decimal;
		// $task_project_name = $timesheet_data->task_project_name;
		// $task_client_name = $timesheet_data->task_label;
		// $project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");		
		// if($task_project_name == $project_data->project_name && $task_client_name == $project_data->project_client && $project_data->project_invoice_method == 1){											
			// $timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
			// foreach($timesheet_items as $timesheet_item){
				// $task_name = format_task_name($timesheet_item->task_name);
				// $timesheet_id = $timesheet_item->ID;
				// $tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
				// if($tasks->task_billable == 1){
					// array_push($billable_id_array,$timesheet_id);
				// }else{
					// array_push($unbillable_id_array,$timesheet_id);
				// }
			// }
		// }
		
		// if($task_project_name == $project_data->project_name && $task_client_name == $project_data->project_client && $project_data->project_invoice_method == 0){											
			// $timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");												
			// foreach($timesheet_items as $timesheet_item){
				// $task_name = format_task_name($timesheet_item->task_name);
				// $timesheet_id = $timesheet_item->ID;
				// $tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
				// if($tasks->task_billable == 1){													
					// array_push($billable_id_array,$timesheet_id);
					// }else{
					// array_push($unbillable_id_array,$timesheet_id);
				// }
			// }
		// }
	// }	
	// $billable_ids = array_unique($billable_id_array);
	// $top_billable_total_hour_decimal = "";
	// $top_total_billable_amount = "";
	// foreach($billable_ids as $id){					
		// $billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");				
		// $billable_task_hour = $billable_timesheet_data->task_hour;
		// $billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
		// $top_billable_total_hour_decimal += $billable_task_hour_decimal;
		// $fullname = $billable_timesheet_data->task_person;						
		// $persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
		// $person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
		// $persons_person_hourly_rate = $persons->person_hourly_rate;
		// $task_billable_amount = $billable_task_hour_decimal * $persons_person_hourly_rate;
		// $top_total_billable_amount += $task_billable_amount;
	// }
	
	// $unbillable_ids = array_unique($unbillable_id_array);
	// $top_unbillable_total_hour_decimal = "";
	// $total_unbillable_amount = "";
	// foreach($unbillable_ids as $id){
		// $unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
		// $unbillable_task_hour = $unbillable_timesheet_data->task_hour;
		// $unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
		// $top_unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
		// $fullname = $unbillable_timesheet_data->task_person;																						
		// $persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
		// $person_full_name = $persons->person_first_name ." ". $persons->person_last_name;											
		// $persons_person_hourly_rate = $persons->person_hourly_rate;
		// $task_unbillable_amount = $unbillable_task_hour_decimal * $persons_person_hourly_rate;
		// $total_unbillable_amount += $task_unbillable_amount;
	// }
	// $top_report_details = round_quarter($top_total_hour_decimal) ."_". round_quarter($top_billable_total_hour_decimal) ."_". $top_total_billable_amount ."_". round_quarter($top_unbillable_total_hour_decimal);
	// $report_details['top_report_detail'] = $top_report_details;	
	// /* END TOP REPORT */
	
	/* CLIENTS */
	$task_client_name_array = array();
	foreach ($import_data as $timesheet_data){
		$task_client_name = $timesheet_data->task_label;
		array_push($task_client_name_array,$task_client_name);
	}
	$client_names = array_unique($task_client_name_array);
	$client_tab_total_hour = "";							
	$client_tab_total_billable_hour = "";
	$client_details_array = array();
	foreach($client_names as $client_name){ 
		$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_label = '$client_name'");										
		$array_count = count($timesheet_data);
		$total_client_hours = "";
		$billable_id_array = array();
		$unbillable_id_array = array();
		for($x = 0; $x <= $array_count; $x++){
			$task_hour = $timesheet_data[$x]->task_hour;
			$task_hour_decimal = round(decimalHours($task_hour), 2);
			$total_client_hours += $task_hour_decimal;
			$task_project_name = $timesheet_data[$x]->task_project_name;
			$task_client_name =$timesheet_data[$x]->task_label;
			$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");								
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
			
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){													
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
		}
		$billable_ids = array_unique($billable_id_array);
		$billable_total_hour_decimal = "";
		$total_billable_amount = "";
		foreach($billable_ids as $id){
			$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$billable_task_hour = $billable_timesheet_data->task_hour;
			$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);											
			$billable_total_hour_decimal += $billable_task_hour_decimal;			
			$fullname = $billable_timesheet_data->task_person;			
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$persons_person_hourly_rate = $persons->person_hourly_rate;
			$task_billable_amount = $billable_task_hour_decimal * $persons_person_hourly_rate;
			$total_billable_amount += $task_billable_amount;
		}
		
		$unbillable_ids = array_unique($unbillable_id_array);
		$unbillable_total_hour_decimal = "";
		$total_unbillable_amount = "";
		foreach($unbillable_ids as $id){
			$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
			$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
			$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
			$fullname = $unbillable_timesheet_data->task_person;																						
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;											
			$persons_person_hourly_rate = $persons->person_hourly_rate;
			$task_unbillable_amount = $unbillable_task_hour_decimal * $persons_person_hourly_rate;
			$total_unbillable_amount += $task_unbillable_amount;
		}
		
		$client_tab_total_hour += $total_client_hours;										
		$client_tab_total_billable_hour += $billable_total_hour_decimal;
		$client_tab_total_billable_amount += $total_billable_amount;
		$client_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
		
		$client_details = $client_name ."_". round_quarter($total_client_hours) ."_". round_quarter($billable_total_hour_decimal) ."_". $total_billable_amount ."_". round_quarter($unbillable_total_hour_decimal);
		$client_details_array[] = $client_details;
		$report_details['client_details'] = $client_details_array;
	}
	$report_details['client_tab_total_hour'] = round_quarter($client_tab_total_hour);
	$report_details['client_tab_total_billable_hour'] = round_quarter($client_tab_total_billable_hour);
	$report_details['client_tab_total_billable_amount'] = $client_tab_total_billable_amount;
	$report_details['client_tab_total_unbillable_hour'] = round_quarter($client_tab_total_unbillable_hour);
	/* END CLIENTS */
	
	/* PROJECTS */
	$project_client_array = array();
	foreach ($import_data as $timesheet_data){
		$project_name = $timesheet_data->task_project_name;
		$task_client_name = $timesheet_data->task_label;
		$project_client_combine = $project_name ."_". $task_client_name;
		array_push($project_client_array, $project_client_combine);
	}
	$project_clients = array_unique($project_client_array);
	foreach($project_clients as $project_client){
		$project_client_explode = explode("_", $project_client);
		$project_name_title = $project_client_explode[0];
		$client_name_title = $project_client_explode[1];
		
		$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter  AND task_project_name ='$project_name_title' AND task_label = '$client_name_title'");										
		$array_count = count($timesheet_data);
		$total_project_hour = "";
		$billable_id_array = array();
		$unbillable_id_array = array();
		for($x = 0; $x <= $array_count; $x++){
			$task_hour = $timesheet_data[$x]->task_hour;
			$task_hour_decimal = round(decimalHours($task_hour), 2);
			$total_project_hour += $task_hour_decimal;
			$task_project_name = $timesheet_data[$x]->task_project_name;
			$task_client_name =$timesheet_data[$x]->task_label;
			$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");			
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
			
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){													
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
		}																			
		$billable_ids = array_unique($billable_id_array);
		$billable_total_hour_decimal = "";
		$total_billable_amount = "";
		foreach($billable_ids as $id){
			$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$billable_task_hour = $billable_timesheet_data->task_hour;
			$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
			$billable_total_hour_decimal += $billable_task_hour_decimal;			
			$fullname = $billable_timesheet_data->task_person;			
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$persons_person_hourly_rate = $persons->person_hourly_rate;
			$task_billable_amount = $billable_task_hour_decimal * $persons_person_hourly_rate;
			$total_billable_amount += $task_billable_amount;
		}
		
		$unbillable_ids = array_unique($unbillable_id_array);
		$unbillable_total_hour_decimal = "";
		$total_unbillable_amount = "";
		foreach($unbillable_ids as $id){
			$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
			$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
			$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
			$fullname = $unbillable_timesheet_data->task_person;																						
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;											
			$persons_person_hourly_rate = $persons->person_hourly_rate;
			$task_unbillable_amount = $unbillable_task_hour_decimal * $persons_person_hourly_rate;
			$total_unbillable_amount += $task_unbillable_amount;
		}
		
		$project_tab_total_hour += $total_project_hour;
		$project_tab_total_billable_hour += $billable_total_hour_decimal;
		$project_tab_total_billable_amount += $total_billable_amount;
		$project_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
		
		$project_details = $project_name_title ."_". $client_name_title ."_". round_quarter($total_project_hour) ."_". round_quarter($billable_total_hour_decimal) ."_". $total_billable_amount ."_". round_quarter($unbillable_total_hour_decimal);
		$project_details_array[] = $project_details;
		$report_details['project_details'] = $project_details_array;
	}
	$report_details['project_tab_total_hour'] = round_quarter($project_tab_total_hour);
	$report_details['project_tab_total_billable_hour'] = round_quarter($project_tab_total_billable_hour);
	$report_details['project_tab_total_unbillable_hour'] = round_quarter($project_tab_total_unbillable_hour);	
	$report_details['project_tab_total_billable_amount'] = $project_tab_total_billable_amount;
	$report_details['project_tab_total_unbillable_amount'] = $project_tab_total_unbillable_amount;
	/* END PROJECTS */
	
	/* TASKS */
	$task_name_array = array();
	foreach ($import_data as $timesheet_data){
		$task_names = $timesheet_data->task_name;
		array_push($task_name_array, $task_names);
	}									
	$task_name = array_unique($task_name_array);
	foreach($task_name as $task){
		$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_name ='$task'");
		$total_task_hour = "";
		$billable_id_array = array();
		$unbillable_id_array = array();
		foreach($timesheet_data as $timesheet_item){											
			$task_hour = $timesheet_item->task_hour;
			$task_hour_decimal = round(decimalHours($task_hour), 2);
			$total_task_hour += $task_hour_decimal;
			$task_project_name = $timesheet_item->task_project_name;
			$task_client_name = $timesheet_item->task_label;
			$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_name = '$task' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
			
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_name = '$task' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){													
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}			
		}
		$billable_ids = array_unique($billable_id_array);
		$billable_total_hour_decimal = "";
		$total_billable_amount = "";
		foreach($billable_ids as $id){
			$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$billable_task_hour = $billable_timesheet_data->task_hour;
			$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
			$billable_total_hour_decimal += $billable_task_hour_decimal;			
			$fullname = $billable_timesheet_data->task_person;
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$persons_person_hourly_rate = $persons->person_hourly_rate;
			$task_billable_amount = $billable_task_hour_decimal * $persons_person_hourly_rate;
			$total_billable_amount += $task_billable_amount;
		}
		
		$unbillable_ids = array_unique($unbillable_id_array);
		$unbillable_total_hour_decimal = "";
		$total_unbillable_amount = "";
		foreach($unbillable_ids as $id){
			$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
			$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
			$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
			$fullname = $unbillable_timesheet_data->task_person;																						
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;											
			$persons_person_hourly_rate = $persons->person_hourly_rate;
			$task_unbillable_amount = $unbillable_task_hour_decimal * $persons_person_hourly_rate;
			$total_unbillable_amount += $task_unbillable_amount;
		}
		
		$task_tab_total_hour += $total_task_hour;
		$task_tab_total_billable_hour += $billable_total_hour_decimal;
		$task_tab_total_billable_amount += $total_billable_amount;
		$task_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
		
		$task_details = format_task_name($task) ."_". round_quarter($total_task_hour) ."_". round_quarter($billable_total_hour_decimal) ."_". $total_billable_amount ."_". round_quarter($unbillable_total_hour_decimal);
		$task_details_array[] = $task_details;
		$report_details['task_details'] = $task_details_array;
	}
	$report_details['task_tab_total_hour'] = round_quarter($task_tab_total_hour);
	$report_details['task_tab_total_billable_hour'] = round_quarter($task_tab_total_billable_hour);
	$report_details['task_tab_total_billable_amount'] = $task_tab_total_billable_amount;
	$report_details['task_tab_total_unbillable_hour'] = round_quarter($task_tab_total_unbillable_hour);	
	/* END TASKS */
	
	/* STAFF */
	$person_name_array = array();
	foreach ($import_data as $timesheet_data){
		$person_names = $timesheet_data->task_person;
		array_push($person_name_array, $person_names);
	}									
	$person_name = array_unique($person_name_array);
	foreach($person_name as $person){
		$timesheet_data = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_person ='$person'");
		$total_person_hour = "";
		$billable_id_array = array();
		$unbillable_id_array = array();
		foreach($timesheet_data as $timesheet_item){											
			$task_hour = $timesheet_item->task_hour;
			$task_hour_decimal = round(decimalHours($task_hour), 2);
			$total_person_hour += $task_hour_decimal;
			$task_project_name = $timesheet_item->task_project_name;
			$task_client_name = $timesheet_item->task_label;
			$project_data = $wpdb->get_row("SELECT * FROM {$table_name_project} WHERE project_name = '$task_project_name' AND project_client = '$task_client_name'");
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_person = '$person' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}
			
			if(trim($task_project_name) == trim($project_data->project_name) && trim($task_client_name) == trim($project_data->project_client)){											
				$timesheet_items = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter AND task_person = '$person' AND task_project_name = '$task_project_name' AND task_label = '$task_client_name'");
				foreach($timesheet_items as $timesheet_item){
					$task_name = format_task_name($timesheet_item->task_name);
					$timesheet_id = $timesheet_item->ID;
					$tasks = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE task_name='$task_name'");													
					if($tasks->task_billable == 1){													
						array_push($billable_id_array,$timesheet_id);
						}else{
						array_push($unbillable_id_array,$timesheet_id);
					}
				}
			}			
		}
		$billable_ids = array_unique($billable_id_array);
		$billable_total_hour_decimal = "";
		$total_billable_amount = "";
		foreach($billable_ids as $id){
			$billable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$billable_task_hour = $billable_timesheet_data->task_hour;
			$billable_task_hour_decimal = round(decimalHours($billable_task_hour), 2);
			$billable_total_hour_decimal += $billable_task_hour_decimal;			
			$fullname = $billable_timesheet_data->task_person;
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;
			$persons_person_hourly_rate = $persons->person_hourly_rate;
			$task_billable_amount = $billable_task_hour_decimal * $persons_person_hourly_rate;
			$total_billable_amount += $task_billable_amount;
		}
		
		$unbillable_ids = array_unique($unbillable_id_array);
		$unbillable_total_hour_decimal = "";
		$total_unbillable_amount = "";
		foreach($unbillable_ids as $id){
			$unbillable_timesheet_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE $filter AND ID = '$id'");
			$unbillable_task_hour = $unbillable_timesheet_data->task_hour;
			$unbillable_task_hour_decimal = round(decimalHours($unbillable_task_hour), 2);											
			$unbillable_total_hour_decimal += $unbillable_task_hour_decimal;											
			$fullname = $unbillable_timesheet_data->task_person;																						
			$persons = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$fullname'");					
			$person_full_name = $persons->person_first_name ." ". $persons->person_last_name;											
			$persons_person_hourly_rate = $persons->person_hourly_rate;
			$task_unbillable_amount = $unbillable_task_hour_decimal * $persons_person_hourly_rate;
			$total_unbillable_amount += $task_unbillable_amount;
		}
		
		$person_tab_total_hour += $total_person_hour;
		$person_tab_total_billable_hour += $billable_total_hour_decimal;
		$person_tab_total_billable_amount += $total_billable_amount;
		$person_tab_total_unbillable_hour += $unbillable_total_hour_decimal;
		
		$person_details = $person ."_". round_quarter($total_person_hour) ."_". round_quarter($billable_total_hour_decimal) ."_". $total_billable_amount ."_". round_quarter($unbillable_total_hour_decimal);
		$person_details_array[] = $person_details;
		$report_details['person_details'] = $person_details_array;
	}
	$report_details['person_tab_total_hour'] = round_quarter($person_tab_total_hour);
	$report_details['person_tab_total_billable_hour'] = round_quarter($person_tab_total_billable_hour);
	$report_details['person_tab_total_billable_amount'] = $person_tab_total_billable_amount;
	$report_details['person_tab_total_unbillable_hour'] = round_quarter($person_tab_total_unbillable_hour);
	/* END STAFF */
	return $report_details;	

}
function last_week_year($filter_year){
	$last_week = get_last_week($filter_year);
	return $last_week;
}
function get_last_week($year) {
	$date = new DateTime;
	$date->setISODate($year, 53);
	return ($date->format("W") === "53" ? 53 : 52);
}
/* ==================================== END FILTER REPORTS TIME ==================================== */

/* ==================================== SORT CLIENT NAME REPORTS TIME ==================================== */
function report_time_client_sort($report_client_sort){
	print_r($report_client_sort);
	die();
	$report_client_details = preg_replace('/\_\s+/', '_', $report_client_sort);	
	$sort_hour_array = array();
	foreach($report_client_details as $report_client_detail){
		if($report_client_detail != 'asc' && $report_client_detail != 'desc'){
			if (substr($report_client_detail, 0, 1) === '_'){
				$report_client_clean = substr($report_client_detail, 1, -1);
				}else{
				$report_client_clean = $report_client_detail;
			}
			$report_client_explode = explode('_', $report_client_clean);
			
			$project_name = $report_client_explode[0];
			$client_name = $report_client_explode[1];
			$hours = $report_client_explode[2];
			$billable_hours = $report_client_explode[3];
			$unbillable_hours = $report_client_explode[4];
			$billable_amount = $report_client_explode[5];
			$unbillable_amount = $report_client_explode[6];
			$info_div_id = $report_client_explode[8];
			$report_time_hour_implode = $project_name .'_'. $client_name .'_'. $hours .'_'. $billable_hours .'_'. $unbillable_hours .'_'. $billable_amount.'_'. $unbillable_amount;
			
			$sort_hour_array[$client_name ."_". $info_div_id] = $report_time_hour_implode;
			}else{
			$sort_type = $report_client_detail;
		}
		
	}
	
	if($sort_type == 'asc'){
		ksort($sort_hour_array);
		}elseif($sort_type == 'desc'){
		krsort($sort_hour_array);
	}
	return $sort_hour_array;
}
/* ==================================== END SORT CLIENT NAME REPORTS TIME ==================================== */

/* ==================================== SORT BILLABLE HOUR REPORTS TIME ==================================== */
function report_time_billable_sort($report_time_sort_billable){
	$report_time_hour_details = preg_replace('/\_\s+/', '_', $report_time_sort_billable);	
	$sort_hour_array = array();
	foreach($report_time_hour_details as $report_time_hour_detail){
		if($report_time_hour_detail != 'asc' && $report_time_hour_detail != 'desc'){
			if (substr($report_time_hour_detail, 0, 1) === '_'){
				$report_time_hour_clean = substr($report_time_hour_detail, 1, -1);
			}else{
				$report_time_hour_clean = $report_time_hour_detail;
			}
			$report_time_hour_explode = explode('_', $report_time_hour_clean);
			$first_column = $report_time_hour_explode[0];
			$second_column = $report_time_hour_explode[1];
			$third_column = $report_time_hour_explode[2];
			$fourth_column = $report_time_hour_explode[3];
			$fifth_column = $report_time_hour_explode[4];
			$sixth_column = $report_time_hour_explode[5];
			$seventh_column = $report_time_hour_explode[6];
			$eight_column = $report_time_hour_explode[7];
			$info_div_id = $report_time_hour_explode[8];
			$tab_id = $report_time_hour_explode[9];
			$ninth_column = $report_time_hour_explode[10];

			$report_time_hour_implode = $first_column .'_'. $second_column .'_'. $third_column .'_'. $fourth_column .'_'. $fifth_column .'_'. $sixth_column .'_'. $seventh_column .'_'. $eight_column .'_'. $tab_id . '_' .$ninth_column;
			$hour_count = count($third_column);
			if($hour_count == 1){
				$hour_key = $third_column . ".00";
			}else{
				$hour_key = $third_column;
			}
			$sort_hour_array[$hour_key ."_". $info_div_id] = $report_time_hour_implode;
		}else{
			$sort_type = $report_time_hour_detail;
		}
		
	}
	
	if($sort_type == 'asc'){
		ksort($sort_hour_array, SORT_NUMERIC);
	}elseif($sort_type == 'desc'){
		krsort($sort_hour_array, SORT_NUMERIC);
	}
	
	return $sort_hour_array;
}

/* ==================================== SORT BILLABLE HOUR REPORTS TIME ==================================== */
function report_time_unbillable_sort($report_time_sort_unbillable){
	$report_time_hour_details = preg_replace('/\_\s+/', '_', $report_time_sort_unbillable);	
	$sort_hour_array = array();
	foreach($report_time_hour_details as $report_time_hour_detail){
		if($report_time_hour_detail != 'asc' && $report_time_hour_detail != 'desc'){
			if (substr($report_time_hour_detail, 0, 1) === '_'){
				$report_time_hour_clean = substr($report_time_hour_detail, 1, -1);
			}else{
				$report_time_hour_clean = $report_time_hour_detail;
			}
			$report_time_hour_explode = explode('_', $report_time_hour_clean);
			$first_column = $report_time_hour_explode[0];
			$second_column = $report_time_hour_explode[1];
			$third_column = $report_time_hour_explode[2];
			$fourth_column = $report_time_hour_explode[3];
			$fifth_column = $report_time_hour_explode[4];
			$sixth_column = $report_time_hour_explode[5];
			$seventh_column = $report_time_hour_explode[6];
			$eight_column = $report_time_hour_explode[7];
			$info_div_id = $report_time_hour_explode[8];
			$tab_id = $report_time_hour_explode[9];
			$ninth_column = $report_time_hour_explode[10];

			$report_time_hour_implode = $first_column .'_'. $second_column .'_'. $third_column .'_'. $fourth_column .'_'. $fifth_column .'_'. $sixth_column .'_'. $seventh_column .'_'. $eight_column .'_'. $tab_id . '_' .$ninth_column;
			$hour_count = count($fourth_column);
			if($hour_count == 1){
				$hour_key = $fourth_column . ".00";
			}else{
				$hour_key = $fourth_column;
			}
			$sort_hour_array[$hour_key ."_". $info_div_id] = $report_time_hour_implode;
		}else{
			$sort_type = $report_time_hour_detail;
		}
		
	}
	
	if($sort_type == 'asc'){
		ksort($sort_hour_array, SORT_NUMERIC);
	}elseif($sort_type == 'desc'){
		krsort($sort_hour_array, SORT_NUMERIC);
	}
	
	return $sort_hour_array;
}


/* ==================================== SORT HOUR REPORTS TIME ==================================== */
function report_time_hour_sort($report_time_sort_hour){
	$report_time_hour_details = preg_replace('/\_\s+/', '_', $report_time_sort_hour);	
	$sort_hour_array = array();
	foreach($report_time_hour_details as $report_time_hour_detail){
		if($report_time_hour_detail != 'asc' && $report_time_hour_detail != 'desc'){
			if (substr($report_time_hour_detail, 0, 1) === '_'){
				$report_time_hour_clean = substr($report_time_hour_detail, 1, -1);
			}else{
				$report_time_hour_clean = $report_time_hour_detail;
			}
			$report_time_hour_explode = explode('_', $report_time_hour_clean);
			$first_column = $report_time_hour_explode[0];
			$second_column = $report_time_hour_explode[1];
			$third_column = $report_time_hour_explode[2];
			$fourth_column = $report_time_hour_explode[3];
			$fifth_column = $report_time_hour_explode[4];
			$sixth_column = $report_time_hour_explode[5];
			$seventh_column = $report_time_hour_explode[6];
			$eight_column = $report_time_hour_explode[7];
			$info_div_id = $report_time_hour_explode[8];
			$tab_id = $report_time_hour_explode[9];
			$ninth_column = $report_time_hour_explode[10];

			$report_time_hour_implode = $first_column .'_'. $second_column .'_'. $third_column .'_'. $fourth_column .'_'. $fifth_column .'_'. $sixth_column .'_'. $seventh_column .'_'. $eight_column .'_'. $tab_id . '_' .$ninth_column;
			$hour_count = count($second_column);
			if($hour_count == 1){
				$hour_key = $second_column . ".00";
			}else{
				$hour_key = $second_column;
			}
			$sort_hour_array[$hour_key ."_". $info_div_id] = $report_time_hour_implode;
		}else{
			$sort_type = $report_time_hour_detail;
		}
		
	}
	
	if($sort_type == 'asc'){
		ksort($sort_hour_array, SORT_NUMERIC);
	}elseif($sort_type == 'desc'){
		krsort($sort_hour_array, SORT_NUMERIC);
	}
	
	return $sort_hour_array;
}
/* ==================================== END SORT HOUR REPORTS TIME ==================================== */

/* ==================================== SORT UNBILLABLE AMOUNT REPORTS TIME ==================================== */
function report_time_billable_a_sort($report_time_sort_billable_a){
	$report_name_details = preg_replace('/\_\s+/', '_', $report_time_sort_billable_a);	
	$sort_hour_array = array();
	foreach($report_name_details as $report_name_detail){
		if($report_name_detail != 'asc' && $report_name_detail != 'desc'){
			if (substr($report_name_detail, 0, 1) === '_'){
				$report_time_hour_clean = substr($report_name_detail, 1, -1);
				}else{
				$report_time_hour_clean = $report_name_detail;
			}
			$report_time_hour_explode = explode('_', $report_time_hour_clean);
			$first_column = $report_time_hour_explode[0];
			$second_column = $report_time_hour_explode[1];
			$third_column = $report_time_hour_explode[2];
			$fourth_column = $report_time_hour_explode[3];
			$fifth_column = $report_time_hour_explode[4];
			$sixth_column = $report_time_hour_explode[5];
			$seventh_column = $report_time_hour_explode[6];
			$eight_column = $report_time_hour_explode[7];
			$info_div_id = $report_time_hour_explode[8];
			$tab_id = $report_time_hour_explode[9];
			$ninth_column = $report_time_hour_explode[10];
			$report_time_hour_implode = $first_column .'_'. $second_column .'_'. $third_column .'_'. $fourth_column .'_'. $fifth_column .'_'. $sixth_column .'_'. $seventh_column .'_'. $eight_column .'_'. $tab_id . '_'. $ninth_column;			
			$sort_name_array[$fifth_column ."_". $info_div_id] = $report_time_hour_implode;
			}else{
			$sort_type = $report_name_detail;
		}
	}
	if($sort_type == 'asc'){
		ksort($sort_name_array, SORT_NUMERIC);
		}elseif($sort_type == 'desc'){
		krsort($sort_name_array, SORT_NUMERIC);
	}
	return $sort_name_array;
}
/* ==================================== SORT UNBILLABLE AMOUNT REPORTS TIME ==================================== */
function report_time_unbillable_a_sort($report_time_sort_unbillable_a){
	$report_name_details = preg_replace('/\_\s+/', '_', $report_time_sort_unbillable_a);	
	$sort_hour_array = array();
	foreach($report_name_details as $report_name_detail){
		if($report_name_detail != 'asc' && $report_name_detail != 'desc'){
			if (substr($report_name_detail, 0, 1) === '_'){
				$report_time_hour_clean = substr($report_name_detail, 1, -1);
				}else{
				$report_time_hour_clean = $report_name_detail;
			}
			$report_time_hour_explode = explode('_', $report_time_hour_clean);
			$first_column = $report_time_hour_explode[0];
			$second_column = $report_time_hour_explode[1];
			$third_column = $report_time_hour_explode[2];
			$fourth_column = $report_time_hour_explode[3];
			$fifth_column = $report_time_hour_explode[4];
			$sixth_column = $report_time_hour_explode[5];
			$seventh_column = $report_time_hour_explode[6];
			$eight_column = $report_time_hour_explode[7];
			$info_div_id = $report_time_hour_explode[8];
			$tab_id = $report_time_hour_explode[9];
			$ninth_column = $report_time_hour_explode[10];
			$report_time_hour_implode = $first_column .'_'. $second_column .'_'. $third_column .'_'. $fourth_column .'_'. $fifth_column .'_'. $sixth_column .'_'. $seventh_column .'_'. $eight_column .'_'. $tab_id . '_'. $ninth_column;			
			$sort_name_array[$sixth_column ."_". $info_div_id] = $report_time_hour_implode;
			}else{
			$sort_type = $report_name_detail;
		}
	}
	if($sort_type == 'asc'){
		ksort($sort_name_array, SORT_NUMERIC);
		}elseif($sort_type == 'desc'){
		krsort($sort_name_array, SORT_NUMERIC);
	}
	return $sort_name_array;
}
/* ==================================== SORT NAME REPORTS TIME ==================================== */
function report_time_name_sort($report_time_sort_name){
	$report_name_details = preg_replace('/\_\s+/', '_', $report_time_sort_name);	
	$sort_hour_array = array();
	foreach($report_name_details as $report_name_detail){
		if($report_name_detail != 'asc' && $report_name_detail != 'desc'){
			if (substr($report_name_detail, 0, 1) === '_'){
				$report_time_hour_clean = substr($report_name_detail, 1, -1);
				}else{
				$report_time_hour_clean = $report_name_detail;
			}
			$report_time_hour_explode = explode('_', $report_time_hour_clean);
			$first_column = $report_time_hour_explode[0];
			$second_column = $report_time_hour_explode[1];
			$third_column = $report_time_hour_explode[2];
			$fourth_column = $report_time_hour_explode[3];
			$fifth_column = $report_time_hour_explode[4];
			$sixth_column = $report_time_hour_explode[5];
			$seventh_column = $report_time_hour_explode[6];
			$eight_column = $report_time_hour_explode[7];
			$info_div_id = $report_time_hour_explode[8];
			$tab_id = $report_time_hour_explode[9];
			$ninth_column = $report_time_hour_explode[10];
			$report_time_hour_implode = $first_column .'_'. $second_column .'_'. $third_column .'_'. $fourth_column .'_'. $fifth_column .'_'. $sixth_column .'_'. $seventh_column .'_'. $eight_column .'_'. $tab_id . '_'. $ninth_column;			
			$sort_name_array[$first_column ."_". $info_div_id] = $report_time_hour_implode;
			}else{
			$sort_type = $report_name_detail;
		}
	}
	if($sort_type == 'asc'){
		ksort($sort_name_array);
		}elseif($sort_type == 'desc'){
		krsort($sort_name_array);
	}
	return $sort_name_array;
}
/* ==================================== END SORT NAME REPORTS TIME ==================================== */

function get_data_type_list($filter_type){
	global $wpdb;

	switch($filter_type){
		case 'Clients':
			$table_name = $wpdb->prefix . "custom_client";
			$clients = $wpdb->get_results("SELECT * FROM {$table_name}");
			$dropdown_html = '';
			foreach($clients as $client){
				$dropdown_html .= '<option>'.$client->client_name.'</option>';
			}
			return print_r($dropdown_html);
		break;
		case 'Tasks':
			$table_name = $wpdb->prefix . "custom_task";
			$tasks = $wpdb->get_results("SELECT * FROM {$table_name}");
			$dropdown_html = '';
			foreach($tasks as $task){
				$dropdown_html .= '<option>'.$task->task_name.'</option>';
			}
			return print_r($dropdown_html);
		break;
		case 'Projects':
			$table_name = $wpdb->prefix . "custom_project";
			$projects = $wpdb->get_results("SELECT DISTINCT project_name FROM {$table_name}");
			$dropdown_html = '';
			foreach($projects as $project){
				$dropdown_html .= '<option>'.$project->project_name.'</option>';
			}
			return print_r($dropdown_html);
		case 'Persons':
			$table_name = $wpdb->prefix . "custom_person";
			$persons = $wpdb->get_results("SELECT * FROM {$table_name}");
			$dropdown_html = '';
			foreach($persons as $person){
				$dropdown_html .= '<option>'.$person->person_fullname.'</option>';
			}
			return print_r($dropdown_html);
		break;
	}

}

/* ==================================== FILTER REPORTS DETAILED TIME ==================================== */
function filter_report_time_detailed($filter_details_detailed_time, $report_sorting_type){


	global $wpdb;
	$table_name = $wpdb->prefix . "custom_timesheet";
	$table_name_color = $wpdb->prefix . "custom_project";
	$table_taskname  = $wpdb->prefix . "custom_task";
	$projects = $wpdb->get_results("SELECT DISTINCT project_name FROM {$table_name_color}");
	$table_name_client = $wpdb->prefix . "custom_client";
	$clients = $wpdb->get_results("SELECT * FROM {$table_name_client}");

	$filter_details_detailed_time_explode = explode("_", $filter_details_detailed_time);
	$week_number_filter = $filter_details_detailed_time_explode[0];
	$month_number_filter = $filter_details_detailed_time_explode[1];
	$year_filter = $filter_details_detailed_time_explode[2];
	$project_name_filter = $filter_details_detailed_time_explode[3];
	$client_name_filter = $filter_details_detailed_time_explode[4];
	$person_name_filter = $filter_details_detailed_time_explode[5];
	$from_date_filter = $filter_details_detailed_time_explode[6];
	$to_date_filter = $filter_details_detailed_time_explode[7];
	$filter_unbillable = $filter_details_detailed_time_explode[8];

	if($week_number_filter != 'null'){
		$week = getStartAndEndDate($week_number_filter, $year_filter);
		$start = date("d_m_Y", strtotime($week[0]));
		$end = date("d_m_Y", strtotime($week[1]));
		$start_explode = explode('_', $start);
		$start_month = $start_explode[1];
		$end_explode = explode('_', $end);
		$end_month = $start_explode[1];
	}

	/* Filter Week */	
	if(	$week_number_filter != 'null' && $month_number_filter != 'null' && $year_filter != 'null' && $project_name_filter == 'null' && $client_name_filter == 'null' && $person_name_filter == 'null' && $from_date_filter == 'null' && $to_date_filter == 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$start_month/$year_filter', '%d/%m/%Y') AND STR_TO_DATE('31/$end_month/$year_filter', '%d/%m/%Y') AND week_number = '$week_number_filter'";
		$week = getStartAndEndDate($week_number_filter, $year_filter);
		$start_num = $week[0];
		$end_num = $week[1];
		$start = date("Y-m-d", strtotime($start_num));
		$end = date("Y-m-d", strtotime($end_num));		
		$report_top_label = "Week " . $week_number_filter . " : " . $start . " / " . $end;
	
	}
	/* Filter Month */
	elseif(	$week_number_filter == 'null' && $month_number_filter != 'null' && $year_filter != 'null' && $project_name_filter == 'null' && $client_name_filter == 'null' && $person_name_filter == 'null' && $from_date_filter == 'null' && $to_date_filter == 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('01/$month_number_filter/$year_filter', '%d/%m/%Y') AND STR_TO_DATE('31/$month_number_filter/$year_filter', '%d/%m/%Y')";	
		$month_name = date("F", mktime(0, 0, 0, $month_number_filter, 10));
		$report_top_label = "Month: " . $month_name ." ". $year_filter;	
	}
	
	/* Custom Filter */
	elseif($week_number_filter == 'null' && $month_number_filter == 'null' && $year_filter == 'null' &&	$project_name_filter != 'null' && $client_name_filter != 'null' && $person_name_filter != 'null' && $from_date_filter != 'null' && $to_date_filter != 'null'){
		$filter = "STR_TO_DATE(date_now, '%d/%m/%Y') BETWEEN STR_TO_DATE('$from_date_filter', '%d/%m/%Y') AND STR_TO_DATE('$to_date_filter', '%d/%m/%Y')";
		$report_top_label = "Custom: " . $from_date_filter ." - ". $to_date_filter;
	}
	
	$report_detailed_time['report_top_label'] = $report_top_label;
	

	if($project_name_filter != 'null'){

	$timesheets = $wpdb->get_results("SELECT * FROM {$table_name} WHERE $filter ORDER BY STR_TO_DATE(date_now, '%d/%m/%Y') ASC");	
	$date_now_array = array();
	$detailed_time_details_array = array();	
	foreach($timesheets as $timesheet){
		$date_now = $timesheet->date_now;		
		$date_now_array[] = $date_now;
	}
	$task_dates = array_unique($date_now_array);
	$report_detailed_time['task_dates'] = $task_dates;
	$total_hours = "";
	foreach($task_dates as $task_date){	
		if($week_number_filter == 'null' && $month_number_filter == 'null' && $year_filter == 'null' &&	$project_name_filter != 'null' && $client_name_filter != 'null' && $person_name_filter != 'null' && $from_date_filter != 'null' && $to_date_filter != 'null'){			
			if($project_name_filter == "Any Project" && $client_name_filter == 'Any Client' && $person_name_filter == "Any Person"){
				$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date'";					
			}
			if($project_name_filter != "Any Project" && $client_name_filter == 'Any Client' && $person_name_filter == "Any Person"){
				$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_project_name='$project_name_filter'";			
			}
			if($project_name_filter != "Any Project" && $client_name_filter != 'Any Client' && $person_name_filter == "Any Person"){
				$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_project_name='$project_name_filter' AND task_label='$client_name_filter'";			
			}
			if($project_name_filter != "Any Project" && $client_name_filter != 'Any Client' && $person_name_filter != "Any Person"){
				$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_project_name='$project_name_filter' AND task_label='$client_name_filter' AND task_person='$person_name_filter'";			
			}
			if($project_name_filter == "Any Project" && $client_name_filter != 'Any Client' && $person_name_filter == "Any Person"){
				$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_label='$client_name_filter'";			
			}
			if($project_name_filter == "Any Project" && $client_name_filter != 'Any Client' && $person_name_filter != "Any Person"){
				$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_label='$client_name_filter' AND task_person='$person_name_filter'";			
			}
			if($project_name_filter == "Any Project" && $client_name_filter == 'Any Client' && $person_name_filter != "Any Person"){
				$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_person='$person_name_filter'";			
			}
			if($project_name_filter != "Any Project" && $client_name_filter == 'Any Client' && $person_name_filter != "Any Person"){
				$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_project_name='$project_name_filter' AND task_person='$person_name_filter'";			
			}			
		}else{
			$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date'";
		}
		$task_timesheets = $wpdb->get_results($timesheet_filter);
		$total_day_hours = "";
		foreach($task_timesheets as $task_timesheet){
			$task_id = $task_timesheet->ID;
			$client_name = $task_timesheet->task_label;
			$project_name = $task_timesheet->task_project_name;
			$orderno = ($task_timesheet->orderno == NULL)? "--" : $task_timesheet->orderno;
			$kilometer = ($task_timesheet->km == NULL)? "--" : $task_timesheet->km;
			$task_suffix = $task_timesheet->task_suffix;
			$task_billable = $wpdb->get_row("SELECT task_billable FROM ".$table_taskname." WHERE task_name = '". $task_timesheet->task_name ."'");
			if($task_suffix != null){
				$task_name = format_task_name($task_timesheet->task_name) ." - ". $task_suffix;
			}else{
				$task_name = format_task_name($task_timesheet->task_name);
			}

			$person_name 			= $task_timesheet->task_person;
			$task_hour				= $task_timesheet->task_hour;
			$task_hour_decimal 		= round(decimalHours($task_hour), 2);			
			$total_day_hours		+= $task_hour_decimal;
			$task_date 				= $task_timesheet->date_now;
			$task_description 		= $task_timesheet->task_description;			
			$detailed_time_details 	= $client_name ."<_>". $project_name ."<_>". $task_name ."<_>". $person_name ."<_>". round_quarter($task_hour_decimal) ."<_>". $task_description ."<_>". $task_date ."<_>". $task_id  ."<_>". $orderno  ."<_>".$kilometer ."<_>".$task_billable->task_billable;	;			
			$detailed_time_details_array[] = $detailed_time_details;
			
			$task_today_array = array();
			$tasks_done_today = unserialize($task_timesheet->task_done_today);
			if($tasks_done_today != null){
				foreach($tasks_done_today as $task_done_today){
					$task_done_today_explode = explode('_', $task_done_today);
					$task_done_today_id = $task_done_today_explode[2];
					if($task_done_today != null){						
						$report_detailed_time['tasks_done_today'][] = $task_done_today;
					}
				}
			}else{
				$report_detailed_time['tasks_done_today'][] = '';
			}			
		}
		
		$report_detailed_time['total_day_hours'][] = round_quarter($total_day_hours) ."_". $task_date;
		$total_hours += $total_day_hours;
	}
	}else{
		
	
	if($report_sorting_type == 'Client'){

		// $client_records = array();
		// $clients = $wpdb->get_results('SELECT DISTINCT task_label FROM '. $table_name . ' WHERE ' .$filter);
		// foreach($clients as $client){
		// 	$client_gather_data = $wpdb->get_results('SELECT * FROM '. $table_name . ' WHERE ' .$filter. ' AND task_label = "' .$client->task_label .'"');
		// 	array_push($client_records,$client_gather_data);
		// }
		$sort = " ORDER BY task_label";

	}else if($report_sorting_type == 'Order No'){
		$sort = " ORDER BY orderno";
	}else if($report_sorting_type == 'Consultant'){
		$sort = " ORDER BY task_person";
	}
	
	$timesheets = $wpdb->get_results('SELECT * FROM '. $table_name . ' WHERE ' . $filter . $sort);

	$date_now_array = array();
	$detailed_time_details_array = array();	
	foreach($timesheets as $timesheet){
		$date_now = $timesheet->date_now;
		$date_now_array[] = $date_now;
	}
	$task_dates = array_unique($date_now_array);
	$report_detailed_time['task_dates'] = $task_dates;
	$total_hours = "";


	// foreach($task_dates as $task_date){	

		// if($week_number_filter == 'null' && $month_number_filter == 'null' && $year_filter == 'null' &&	$project_name_filter != 'null' && $client_name_filter != 'null' && $person_name_filter != 'null' && $from_date_filter != 'null' && $to_date_filter != 'null'){			
		// 	if($project_name_filter == "Any Project" && $client_name_filter == 'Any Client' && $person_name_filter == "Any Person"){
		// 		$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date'";					
		// 	}
		// 	if($project_name_filter != "Any Project" && $client_name_filter == 'Any Client' && $person_name_filter == "Any Person"){
		// 		$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_project_name='$project_name_filter'";			
		// 	}
		// 	if($project_name_filter != "Any Project" && $client_name_filter != 'Any Client' && $person_name_filter == "Any Person"){
		// 		$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_project_name='$project_name_filter' AND task_label='$client_name_filter'";			
		// 	}
		// 	if($project_name_filter != "Any Project" && $client_name_filter != 'Any Client' && $person_name_filter != "Any Person"){
		// 		$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_project_name='$project_name_filter' AND task_label='$client_name_filter' AND task_person='$person_name_filter'";			
		// 	}
		// 	if($project_name_filter == "Any Project" && $client_name_filter != 'Any Client' && $person_name_filter == "Any Person"){
		// 		$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_label='$client_name_filter'";			
		// 	}
		// 	if($project_name_filter == "Any Project" && $client_name_filter != 'Any Client' && $person_name_filter != "Any Person"){
		// 		$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_label='$client_name_filter' AND task_person='$person_name_filter'";			
		// 	}
		// 	if($project_name_filter == "Any Project" && $client_name_filter == 'Any Client' && $person_name_filter != "Any Person"){
		// 		$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_person='$person_name_filter'";			
		// 	}
		// 	if($project_name_filter != "Any Project" && $client_name_filter == 'Any Client' && $person_name_filter != "Any Person"){
		// 		$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date' AND task_project_name='$project_name_filter' AND task_person='$person_name_filter'";			
		// 	}			
		// }else{
		// 	$timesheet_filter = "SELECT * FROM {$table_name} WHERE date_now = '$task_date'";
		// }
		// $task_timesheets = $wpdb->get_results($timesheet_filter . $sort);


		$task_timesheets = $timesheets;


		$total_day_hours = "";
		foreach($task_timesheets as $task_timesheet){
			$task_id = $task_timesheet->ID;
			$client_name = $task_timesheet->task_label;
			$project_name = $task_timesheet->task_project_name;
			$orderno = ($task_timesheet->orderno == NULL)? "--" : $task_timesheet->orderno;
			$kilometer = ($task_timesheet->km == NULL)? "--" : $task_timesheet->km;
			$task_suffix = $task_timesheet->task_suffix;
			$task_billable = $wpdb->get_row("SELECT task_billable FROM ".$table_taskname." WHERE task_name = '". $task_timesheet->task_name ."'");
			if($task_suffix != null){
				$task_name = format_task_name($task_timesheet->task_name) ." - ". $task_suffix;
			}else{
				$task_name = format_task_name($task_timesheet->task_name);
			}
			$person_name 			= $task_timesheet->task_person;
			$task_hour				= $task_timesheet->task_hour;
			$task_hour_decimal 		= round(decimalHours($task_hour), 2);			
			$total_day_hours		+= $task_hour_decimal;
			$task_date 				= $task_timesheet->date_now;
			$task_description 		= $task_timesheet->task_description;			
			$detailed_time_details 	= $client_name ."<_>". $project_name ."<_>". $task_name ."<_>". $person_name ."<_>". round_quarter($task_hour_decimal) ."<_>". $task_description ."<_>". $task_date ."<_>". $task_id  ."<_>". $orderno  ."<_>".$kilometer ."<_>".$task_billable->task_billable;			
			$detailed_time_details_array[] = $detailed_time_details;
			
			$task_today_array = array();
			$tasks_done_today = unserialize($task_timesheet->task_done_today);
			if($tasks_done_today != null){
				foreach($tasks_done_today as $task_done_today){
					$task_done_today_explode = explode('_', $task_done_today);
					$task_done_today_id = $task_done_today_explode[2];
					if($task_done_today != null){						
						$report_detailed_time['tasks_done_today'][] = $task_done_today;
					}
				}
			}else{
				$report_detailed_time['tasks_done_today'][] = '';
			}			
		}
		
		$report_detailed_time['total_day_hours'][] = round_quarter($total_day_hours) ."_". $task_date;
		$total_hours += $total_day_hours;
	// }		
	}


	
	foreach($projects as $project){
		$report_detailed_time['project_name_select'][] = $project->project_category;
	}
	foreach($clients as $client){
		$report_detailed_time['client_name_select'][] = $client->client_name;
	}
	
	$report_detailed_time['total_hours'] = round_quarter($total_hours);
	$report_detailed_time['detailed_time_details'] = $detailed_time_details_array;
	return $report_detailed_time;
}
/* ==================================== END FILTER REPORTS DETAILED TIME ==================================== */

/* ==================================== EDIT PROJECT NAME ==================================== */
function project_name_edit($project_name_edit_details){	
	$project_name_edit_details_explode = explode('_', $project_name_edit_details);
	$project_name = $project_name_edit_details_explode[0];
	$project_id = $project_name_edit_details_explode[1];
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_timesheet";
	
	$update = $wpdb->update( $table_name , array( 
	'task_project_name'	=> $project_name
	),	
	array( 'ID' => $project_id ),
	array( '%s', '%s' ));
	return $project_name_edit_details;
}
/* ==================================== END EDIT PROJECT NAME ==================================== */

/* ==================================== EDIT PROJECT NAME ==================================== */
function client_name_edit($client_name_edit_details){	
	$client_name_edit_details_explode = explode('_', $client_name_edit_details);
	$client_name = $client_name_edit_details_explode[0];
	$client_id = $client_name_edit_details_explode[1];
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_timesheet";
	
	$update = $wpdb->update( $table_name , array( 
	'task_label'	=> $client_name
	),	
	array( 'ID' => $client_id ),
	array( '%s', '%s' ));
	return $client_name_edit_details;
}
/* ==================================== END EDIT PROJECT NAME ==================================== */

/* ==================================== GET WP DETAILS ==================================== */
function wp_detail($site_url){
	$url = $site_url . '/readme.html';
	$get_readme_content = @file_get_contents($url);
	
	if(!$get_readme_content){
		$readme_content = "Can't get Wordpress info. The site maybe secured.";		
	}else{
		$readme_content = $get_readme_content;		
	}
	return $readme_content;
	
}
/* ==================================== END GET WP DETAILS ==================================== */

/* ==================================== GET THEME DETAILS ==================================== */
function theme_detail($site_url){
	require_once('check_version/whatpress.class.php');
	require_once('check_version/config.php');

	$theme       = new WhatPress;
	$css         = $theme->theme_css($site_url);
	$information = $theme->theme_information($css);
	
	if ($css == false) {
		$response = array('Error' => 'This website doesn\'t use WordPress or has been heavily modified or is secured.');
	}
	else if ($information == false) {
		$response = array('Error' => 'WordPress detected, but no information can be determined. The theme is either customized or secured.');
	}
	else {
		$response = $information;
	}
	
	return json_encode($response);
	
}
/* ==================================== END GET THEME DETAILS ==================================== */

/* ==================================== SAVE HOSTING OR DOMAIN ==================================== */
function save_host_domain($hosting_domain){
	$hosting_domain_explode = explode("_", $hosting_domain);
	$hosting_name 		= (isset($hosting_domain_explode[0]) ? $hosting_domain_explode[0] : '');
	$hosting_url 		= (isset($hosting_domain_explode[1]) ? $hosting_domain_explode[1] : '');
	$hosting_username 	= (isset($hosting_domain_explode[2]) ? $hosting_domain_explode[2] : '');
	$hosting_password	= (isset($hosting_domain_explode[3]) ? $hosting_domain_explode[3] : '');
	$domain_name 		= (isset($hosting_domain_explode[4]) ? $hosting_domain_explode[4] : '');
	$domain_url 		= (isset($hosting_domain_explode[5]) ? $hosting_domain_explode[5] : '');
	$domain_username 	= (isset($hosting_domain_explode[6]) ? $hosting_domain_explode[6] : '');
	$domain_password 	= (isset($hosting_domain_explode[7]) ? $hosting_domain_explode[7] : '');
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_hosting_domain";
	if($hosting_name != 'null' && $domain_name == 'null'){
		$insert = $wpdb->insert( $table_name , array( 
			'site_status'			=> 'Hosting',
			'site_hosting_name'		=> $hosting_name,
			'site_hosting_url' 		=> $hosting_url,
			'site_hosting_username' => $hosting_username,
			'site_hosting_password' => $hosting_password			
		), array( '%s', '%s' ));
		$return_value = $hosting_name;
	}elseif($hosting_name == 'null' && $domain_name != 'null'){
		$insert = $wpdb->insert( $table_name , array( 
			'site_status' 			=> 'Domain',
			'site_domain_name' 		=> $domain_name,
			'site_domain_url' 		=> $domain_url,
			'site_domain_username'	=> $domain_username,
			'site_domain_password'	=> $domain_password
		), array( '%s', '%s' ));
		$return_value = $domain_name;
	}
	return $return_value;
}

/* ==================================== END SAVE HOSTING OR DOMAIN ==================================== */

/* ==================================== SAVE WEBSITE ==================================== */
function save_website_form($website_form){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_website";
	
	$website_form_array = array();
	parse_str($website_form, $website_form_array);
	
	$site_url 				= (isset($website_form_array['site_url']) ? $website_form_array['site_url'] : '');
	$site_wp_version		= (isset($website_form_array['site_wp_version']) ? $website_form_array['site_wp_version'] : '');
	$site_theme_name 		= (isset($website_form_array['site_theme_name']) ? $website_form_array['site_theme_name'] : '');
	$site_theme_version		= (isset($website_form_array['site_theme_version']) ? $website_form_array['site_theme_version'] : '');
	$site_type				= (isset($website_form_array['site_type']) ? $website_form_array['site_type'] : ''); 
	$site_client 			= (isset($website_form_array['site_client']) ? $website_form_array['site_client'] : '');
	$site_platform 			= (isset($website_form_array['site_platform']) ? $website_form_array['site_platform'] : '');
	$site_login_url 		= (isset($website_form_array['site_login_url']) ? $website_form_array['site_login_url'] : '');
	$site_username 			= (isset($website_form_array['site_username']) ? $website_form_array['site_username'] : '');
	$site_password 			= (isset($website_form_array['site_password']) ? $website_form_array['site_password'] : '');
	$site_hosting_name		= (isset($website_form_array['site_hosting_name']) ? $website_form_array['site_hosting_name'] : '');
	$site_domain_name		= (isset($website_form_array['site_domain_name']) ? $website_form_array['site_domain_name'] : '');
	$site_domain_owner		= (isset($website_form_array['site_domain_owner']) ? $website_form_array['site_domain_owner'] : '');
	$site_renewal_date		= (isset($website_form_array['site_renewal_date']) ? $website_form_array['site_renewal_date'] : '');
	$site_cost				= (isset($website_form_array['site_cost']) ? $website_form_array['site_cost'] : '');
	$site_mysql_url 		= (isset($website_form_array['site_mysql_url']) ? $website_form_array['site_mysql_url'] : '');
	$site_mysql_username 	= (isset($website_form_array['site_mysql_username']) ? $website_form_array['site_mysql_username'] : '');
	$site_mysql_password 	= (isset($website_form_array['site_mysql_password']) ? $website_form_array['site_mysql_password'] : '');
	$site_database_name 	= (isset($website_form_array['site_database_name']) ? $website_form_array['site_database_name'] : '');
	$site_database_username	= (isset($website_form_array['site_database_username']) ? $website_form_array['site_database_username'] : '');
	$site_database_password = (isset($website_form_array['site_database_password']) ? $website_form_array['site_database_password'] : '');
	$site_ftp_server 		= (isset($website_form_array['site_ftp_server']) ? $website_form_array['site_ftp_server'] : '');
	$site_ftp_username 		= (isset($website_form_array['site_ftp_username']) ? $website_form_array['site_ftp_username'] : '');
	$site_ftp_password 		= (isset($website_form_array['site_ftp_password']) ? $website_form_array['site_ftp_password'] : '');
	$site_additional_info	= (isset($website_form_array['site_additional_info']) ? $website_form_array['site_additional_info'] : '');
	
	
	$insert = $wpdb->insert( $table_name , array( 
		'site_url'					=> $site_url,
		'site_wp_version'			=> $site_wp_version,
		'site_theme_name'			=> $site_theme_name,
		'site_theme_version'		=> $site_theme_version,
		'site_type'					=> $site_type,
		'site_client'				=> $site_client,
		'site_platform'				=> $site_platform,
		'site_login_url'			=> $site_login_url,
		'site_username'				=> $site_username,
		'site_password'				=> $site_password,
		'site_hosting_name'			=> $site_hosting_name,
		'site_domain_name'			=> $site_domain_name,
		'site_domain_owner'			=> $site_domain_owner,
		'site_renewal_date'			=> $site_renewal_date,
		'site_cost'					=> $site_cost,
		'site_mysql_url'			=> $site_mysql_url,
		'site_mysql_username'		=> $site_mysql_username,
		'site_mysql_password'		=> $site_mysql_password,
		'site_database_name'		=> $site_database_name,
		'site_database_username'	=> $site_database_username,
		'site_database_password'	=> $site_database_password,
		'site_ftp_server'			=> $site_ftp_server,
		'site_ftp_username'			=> $site_ftp_username,
		'site_ftp_password'			=> $site_ftp_password,
		'site_additional_info'		=> $site_additional_info
	), array( '%s', '%s' ));
	
	return $site_url;
}
/* ==================================== END SAVE WEBSITE ==================================== */

/* ==================================== EDIT GOALS ==================================== */
function edit_goals($goals_div_id){
	$goals_div_id_explode = explode('_', $goals_div_id);
	$goal_time = $goals_div_id_explode[2];
	$goal_key = $goals_div_id_explode[3];
	$goal_person_id = $goals_div_id_explode[4];
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_goals";
	$table_name_person = $wpdb->prefix . "custom_person";
	$person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE ID ='$goal_person_id'");
	$goal_person = $person->person_fullname;
	if($goal_person != null){
		$goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goal_time' AND goal_person = '$goal_person'");
	}else{
		$goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goal_time'");
	}
	
	$goals_list = unserialize($goals->goals);
	foreach($goals_list as $key => $goal_list){
		if($key == $goal_key){
			$edit_goal = $goal_list;
		}		
	}
	$html = '
	<form method="post" id="edit_modal_goals">		
	<div class="input_div">
	<label class="modal_label">Goal '.$goal_time.'</label>
	<textarea class="modal_edit_goals" name="goals">'.$edit_goal.'</textarea>
	<input type="hidden" name="goals_time" value="'.$goal_time.'" />
	<input type="hidden" name="goal_key" value="'.$goal_key.'" />
	<input type="hidden" name="goal_person" value="'.$goal_person.'" />
	<input type="hidden" name="goal_person_id" value="'.$goal_person_id.'" />
	</div>	
	<div id="update_'.$goal_time .'_'. $goal_key.'" class="modal_save_edit_goals button_1 action_button">Update</div>
	<div style="display:none;" class="loader"></div>
	</form>';
	return $html;	
}

function update_edit_goals($goal_update_edit_details){
	parse_str($goal_update_edit_details, $goals_form_array);
	
	$edited_goal = $goals_form_array['goals'];
	$goals_time = $goals_form_array['goals_time'];
	$goal_key = $goals_form_array['goal_key'];
	$goal_person = $goals_form_array['goal_person'];
	$goal_person_id = $goals_form_array['goal_person_id'];
	
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_goals"; 
	$table_name_person = $wpdb->prefix . "custom_person";
	$person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$goal_person'");
	$goal_person_id = $person->ID;
	if($goal_person != null){
		$goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goals_time' AND goal_person = '$goal_person'");
	}else{
		$goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goals_time'");
	}
	
	$goals_list = unserialize($goals->goals);
	$goals_id = $goals->ID;
	$goals_list[$goal_key] = $edited_goal;
	$serialized_array = serialize($goals_list);
	
	$update = $wpdb->update( $table_name , array( 
		'goals'	=> $serialized_array
	),	
	array( 'ID' => $goals_id ),
	array( '%s', '%s' ));
	
	return $goals_form_array;
}
/* ==================================== END EDIT GOALS ==================================== */

/* ==================================== DELETE GOALS ==================================== */
function confirm_delete_goals($goals_div_id){	
	$goals_div_id_explode = explode('_', $goals_div_id);
	$goal_time = $goals_div_id_explode[2];
	$goal_key = $goals_div_id_explode[3];
	$goal_person_id = $goals_div_id_explode[4];
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_goals"; 
	$table_name_person = $wpdb->prefix . "custom_person";		
	$person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE ID ='$goal_person_id'");
	$goal_person = $person->person_fullname;
	if($goal_person != null){
		$goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goal_time' AND goal_person = '$goal_person'");
	}else{
		$goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goal_time'");
	}
		
	$goals_list = unserialize($goals->goals);
	foreach($goals_list as $key => $goal_list){
		if($key == $goal_key){
			$delete_goal = $goal_list;
		}		
	}
	$html = '
	<form method="post" id="delete_modal_goals">		
	<div class="input_div">
	<label class="modal_label">Goal '.$goal_time.'</label>
	<p>'.$delete_goal.'</p>
	<input type="hidden" name="goals" value="'.$delete_goal.'" />
	<input type="hidden" name="goals_time" value="'.$goal_time.'" />
	<input type="hidden" name="goal_key" value="'.$goal_key.'" />
	<input type="hidden" name="goal_person" value="'.$goal_person.'" />
	<input type="hidden" name="goal_person_id" value="'.$goal_person_id.'" />
	</div>	
	<div id="delete_'.$goal_time .'_'. $goal_key.'" class="modal_save_delete_goals button_1 action_button">Delete</div>
	<div style="display:none;" class="loader"></div>
	</form>';
	return $html;	
}
function delete_goals($goal_delete_details){	
	parse_str($goal_delete_details, $goals_form_array);
	$delete_goal = $goals_form_array['goals'];
	$goals_time = $goals_form_array['goals_time'];
	$goal_key = $goals_form_array['goal_key'];
	$goal_person = $goals_form_array['goal_person'];
	$goal_person_id = $goals_form_array['goal_person_id'];
	
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_goals";
	if($goal_person != null){
		$goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goals_time' AND goal_person ='$goal_person'");
	}else{
		$goals = $wpdb->get_row("SELECT * FROM {$table_name} WHERE goals_time = '$goals_time'");
	}
	$goals_list = unserialize($goals->goals);
	$goals_id = $goals->ID;
	unset($goals_list[$goal_key]);
	$serialized_array = serialize($goals_list);
	$update = $wpdb->update( $table_name , array( 
	'goals'	=> $serialized_array
	),	
	array( 'ID' => $goals_id ),
	array( '%s', '%s' ));
	
	return $goals_form_array;
}
/* ==================================== END DELETE GOALS ==================================== */

/* ==================================== DASHBOARD GOALS ==================================== */
function dashboard_goals($dashboard_goals_value){	
	$dashboard_goals_value_explode = explode('_', $dashboard_goals_value);	
	$goal_type = $dashboard_goals_value_explode[0];
	$goal_year = $dashboard_goals_value_explode[1];
	$goal_time = $dashboard_goals_value_explode[2];
	$key = $dashboard_goals_value_explode[3];
	$person_id = $dashboard_goals_value_explode[4];	
	$goal = array();
	$goal[] = $goal_type ."_". $goal_year ."_". $goal_time ."_". $key;
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_person";
	$person = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = '$person_id'");
	$person_goal = $person->person_goal;
	
	$global_goals = $wpdb->get_results("SELECT * FROM {$table_name}");	
	
	if($goal_type == 'yearly' || $goal_type == 'monthly'){
		foreach($global_goals as $global_goal){
			$persons_id = $global_goal->ID;
			$persons_goal = $global_goal->person_goal;
			if($persons_goal == null){
				$serialized_array = serialize($goal);				
				$update = $wpdb->update( $table_name , array( 
				'person_goal' => $serialized_array
				),	
				array( 'ID' => $persons_id ),
				array( '%s', '%s' ));
			}else{
				$persons_goal = $global_goal->person_goal;
				$unserialize_array = unserialize($persons_goal);
				$array_merge = array_merge($unserialize_array, $goal);
				$serialized_array = serialize($array_merge);
				$update = $wpdb->update( $table_name , array( 
				'person_goal' => $serialized_array
				),
				array( 'ID' => $persons_id ),
				array( '%s', '%s' ));		
			}
		}
	}else{
		if($person_goal == null){
			$serialized_array = serialize($goal);
			$update = $wpdb->update( $table_name , array( 
				'person_goal' => $serialized_array
			),	
			array( 'ID' => $person_id ),
			array( '%s', '%s' ));
		}else{
			$unserialize_array = unserialize($person_goal);
			$array_merge = array_merge($unserialize_array, $goal);
			$serialized_array = serialize($array_merge);
			$update = $wpdb->update( $table_name , array( 
				'person_goal' => $serialized_array
			),	
			array( 'ID' => $person_id ),
			array( '%s', '%s' ));		
		}
	}
	return $dashboard_goals_value;
}

function dashboard_goals_uncheck($dashboard_goals_value_uncheck){
	$dashboard_goals_value_explode = explode('_', $dashboard_goals_value_uncheck);
	$goal_type = $dashboard_goals_value_explode[0];
	$goal_year = $dashboard_goals_value_explode[1];
	$goal_time = $dashboard_goals_value_explode[2];
	$key = $dashboard_goals_value_explode[3];
	$person_id = $dashboard_goals_value_explode[4];		
	$goal = array();
	$goal[] = $goal_type ."_". $goal_year ."_". $goal_time ."_". $key;
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_person";
	$person = $wpdb->get_row("SELECT * FROM {$table_name} WHERE person_fullname = '$current_user'");
	$global_goals = $wpdb->get_results("SELECT * FROM {$table_name}");	
		
	if($goal_type == 'yearly' || $goal_type == 'monthly'){
		$persons_id_array = array();
		foreach($global_goals as $global_goal){
			$persons_id = $global_goal->ID;
			$persons_id_array[] = $persons_id; 
			$persons_goal = $global_goal->person_goal;
			$unserialize_array = unserialize($persons_goal);
			$goal_array = array();			
			foreach($unserialize_array as $goal_list){
				$goal_list_explode = explode('_', $goal_list);
				$goal_type = $goal_list_explode[0];
				$goal_year = $goal_list_explode[1];
				$goal_time = $goal_list_explode[2];
				$goal_key = $goal_list_explode[3];
				if($key != $goal_key){
					$goal_array[] = $goal_list;
				}
			}			
		}		
		foreach($persons_id_array as $persons_id){
			$serialized_array = serialize($goal_array);
			$update = $wpdb->update( $table_name , array( 
			'person_goal' => $serialized_array
			),	
			array( 'ID' => $persons_id ),
			array( '%s', '%s' ));
		}
	}else{			
		$person_goal = $person->person_goal;
		$unserialize_array = unserialize($person_goal);
		$goal_array = array();
		foreach($unserialize_array as $goal_list){
			$goal_list_explode = explode('_', $goal_list);
			$goal_type = $goal_list_explode[0];
			$goal_year = $goal_list_explode[1];
			$goal_time = $goal_list_explode[2];
			$goal_key = $goal_list_explode[3];
			if($key != $goal_key){
				$goal_array[] = $goal_list;
			}
		}
		$serialized_array = serialize($goal_array);
		$update = $wpdb->update( $table_name , array( 
			'person_goal' => $serialized_array
		),	
		array( 'ID' => $person_id ),
		array( '%s', '%s' ));
	}
}
/* ==================================== END DASHBOARD GOALS ==================================== */

/* ==================================== EDIT MESSAGE ==================================== */
function edit_message($message_div_id){
	$message_div_id_explode = explode('_', $message_div_id);
	$message_type = $message_div_id_explode[2];
	$message_key = $message_div_id_explode[3];
	$message_person_id = $message_div_id_explode[4];
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_message";
	$table_name_person = $wpdb->prefix . "custom_person";
	$person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE ID ='$message_person_id'");
	$message_person = $person->person_fullname;
	if($message_person != null){
		$messages = $wpdb->get_row("SELECT * FROM {$table_name} WHERE message_type = '$message_type' AND message_person = '$message_person'");
	}else{
		$messages = $wpdb->get_row("SELECT * FROM {$table_name} WHERE message_type = '$message_type'");
	}
	
	$messages_list = unserialize($messages->message);
	foreach($messages_list as $key => $message_list){
		if($key == $message_key){
			$edit_message = $message_list;
			$edit_message_explode = explode("_", $edit_message);
			$message = $edit_message_explode[0];
			$message_date = $edit_message_explode[1];
		}		
	}
	$html = '
	<form method="post" id="edit_modal_message">		
	<div class="input_div">
	<label class="modal_label">'.ucfirst($message_type).' Message </label>
	<textarea class="modal_edit_messages" name="messages">'.$message.'</textarea>
	<input type="hidden" name="message_date" value="'.$message_date.'" />
	<input type="hidden" name="message_type" value="'.$message_type.'" />
	<input type="hidden" name="message_key" value="'.$message_key.'" />
	<input type="hidden" name="message_person" value="'.$message_person.'" />
	<input type="hidden" name="message_person_id" value="'.$message_person_id.'" />
	</div>	
	<div class="modal_save_edit_messages button_1 action_button">Update</div>
	<div style="display:none;" class="loader"></div>
	</form>';
	return $html;	
	
}

function update_edit_message($message_update_edit_details){
	parse_str($message_update_edit_details, $message_form_array);
	$edited_message = $message_form_array['messages'];
	$message_date = $message_form_array['message_date'];
	$message_type = $message_form_array['message_type'];
	$message_key = $message_form_array['message_key'];
	$message_person = $message_form_array['message_person'];
	$message_person_id = $message_form_array['message_person_id'];
	
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_message"; 
	$table_name_person = $wpdb->prefix . "custom_person";
	$person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname ='$message_person'");
	$message_person_id = $person->ID;
	if($message_person != null){
		$messages = $wpdb->get_row("SELECT * FROM {$table_name} WHERE message_type = '$message_type' AND message_person = '$message_person'");
	}else{
		$messages = $wpdb->get_row("SELECT * FROM {$table_name} WHERE message_type = '$message_type'");
	}
	
	$messages_list = unserialize($messages->message);
	$messages_id = $messages->ID;
	$messages_list[$message_key] = $edited_message ."_". $message_date;
	$serialized_array = serialize($messages_list);
	
	$update = $wpdb->update( $table_name , array( 
		'message'	=> $serialized_array
	),	
	array( 'ID' => $messages_id ),
	array( '%s', '%s' ));
	
	return $message_form_array;
}
/* ==================================== END EDIT MESSAGE ==================================== */

/* ==================================== DELETE MESSAGE ==================================== */
function confirm_delete_message($message_div_id){
	$messages_div_id_explode = explode('_', $message_div_id);
	$message_type = $messages_div_id_explode[2];
	$message_key = $messages_div_id_explode[3];
	$message_person_id = $messages_div_id_explode[4];
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_message"; 
	
	$table_name_person = $wpdb->prefix . "custom_person";
	$person = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE ID ='$message_person_id'");
	$message_person = $person->person_fullname;
	if($message_person != null){
		$messages = $wpdb->get_row("SELECT * FROM {$table_name} WHERE message_type = '$message_type' AND message_person = '$message_person'");
	}else{
		$messages = $wpdb->get_row("SELECT * FROM {$table_name} WHERE message_type = '$message_type'");
	}
		
	$messages_list = unserialize($messages->message);
	foreach($messages_list as $key => $message_list){
		if($key == $message_key){
			$delete_message = $message_list;
			$delete_message_explode = explode('_', $delete_message);
			$message = $delete_message_explode[0];
		}		
	}
	$html = '
	<form method="post" id="delete_modal_message">		
	<div class="input_div">
	<label class="modal_label">Message '.$message_type.'</label>
	<p>'.$message.'</p>
	<input type="hidden" name="message" value="'.$delete_message.'" />
	<input type="hidden" name="message_type" value="'.$message_type.'" />
	<input type="hidden" name="message_key" value="'.$message_key.'" />
	<input type="hidden" name="message_person" value="'.$message_person.'" />
	<input type="hidden" name="message_person_id" value="'.$message_person_id.'" />
	</div>	
	<div id="delete_'.$message_type .'_'. $message_key.'" class="modal_save_delete_message button_1 action_button">Delete</div>
	<div style="display:none;" class="loader"></div>
	</form>';
	return $html;	
}
function delete_message($message_delete_details){
	parse_str($message_delete_details, $message_form_array);
	$delete_message = $message_form_array['delete_message'];
	$message_type = $message_form_array['message_type'];
	$message_key = $message_form_array['message_key'];
	$message_person = $message_form_array['message_person'];
	$message_person_id = $message_form_array['message_person_id'];
	
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_message";
	if($message_person != null){
		$messages = $wpdb->get_row("SELECT * FROM {$table_name} WHERE message_type = '$message_type' AND message_person ='$message_person'");
	}else{
		$messages = $wpdb->get_row("SELECT * FROM {$table_name} WHERE message_type = '$message_type'");
	}
	$messages_list = unserialize($messages->message);
	$messages_id = $messages->ID;
	unset($messages_list[$message_key]);
	$serialized_array = serialize($messages_list);
	$update = $wpdb->update( $table_name , array( 
	'message'	=> $serialized_array
	),	
	array( 'ID' => $messages_id ),
	array( '%s', '%s' ));
	
	return $message_form_array;
}
/* ==================================== END DELETE MESSAGE ==================================== */

/* ==================================== EDIT CHECKLIST TEMPLATE ==================================== */
function edit_checklist_template($data_id){
	global $wpdb;
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 
	$checklist_template = $wpdb->get_row("SELECT * FROM {$table_name_checklist_template} WHERE ID = '$data_id'");
	$template_name = $checklist_template->checklist_template;
	
	return $data_id ."_". $template_name;
}

function update_checklist_template($update_checklist_template_details){
	parse_str($update_checklist_template_details, $edit_template_form_data);
	$checklist_template_name = $edit_template_form_data['checklist_template_name'];
	$checklist_template_id = $edit_template_form_data['checklist_template_id'];
	$checklist_current_template_name = $edit_template_form_data['checklist_current_template_name'];
	
	global $wpdb;
	$table_name_checklist_task = $wpdb->prefix . "custom_checklist_task"; 
	$checklist_tasks = $wpdb->get_row("SELECT * FROM {$table_name_checklist_task} WHERE task_checklist_template='$checklist_current_template_name'");
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 		
	$checklist_task_id = $checklist_tasks->ID;	
	$update_task_template = $wpdb->update( $table_name_checklist_task , array( 
		'task_checklist_template'	=> $checklist_template_name
	),	
	array( 'ID' => $checklist_task_id ),
	array( '%s', '%s' ));
	
	$update_template = $wpdb->update( $table_name_checklist_template , array( 
		'checklist_template'	=> $checklist_template_name
	),	
	array( 'ID' => $checklist_template_id ),
	array( '%s', '%s' ));
	
	$title_class = preg_replace("/\s+/", " ", $checklist_current_template_name);
	$title_class = str_replace(" ", "_", $title_class);
	$title_class = preg_replace("/[^A-Za-z0-9_]/","",$title_class);
	$title_class = strtolower($title_class);	
	
	return $checklist_template_name .'<_>'. $title_class;
}
/* ==================================== END EDIT CHECKLIST TEMPLATE ==================================== */

/* ==================================== DELETE CHECKLIST TEMPLATE ==================================== */
function confirm_delete_checklist_template($data_id){
	global $wpdb;
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 
	$checklist_template = $wpdb->get_row("SELECT * FROM {$table_name_checklist_template} WHERE ID = '$data_id'");
	$template_name = $checklist_template->checklist_template;
	
	return $data_id ."_". $template_name;
}

function delete_checklist_template($delete_checklist_template_details){	
	parse_str($delete_checklist_template_details, $delete_template_form_data);	
	$checklist_template_name = $delete_template_form_data['checklist_template_name'];
	$checklist_template_id = $delete_template_form_data['checklist_template_id'];	   
	
	global $wpdb;
	$table_name_checklist_task = $wpdb->prefix . "custom_checklist_task"; 	
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template";
	$checklist_tasks = $wpdb->get_row("SELECT * FROM {$table_name_checklist_task} WHERE task_checklist_template='$checklist_template_name'");
	$checklist_task_id = $checklist_tasks->ID;
			
	$delete_template_checklist_task = $wpdb->query( "DELETE FROM {$table_name_checklist_task} WHERE ID = '$checklist_task_id'" ) ;		
	$delete_template_checklist = $wpdb->query( "DELETE FROM {$table_name_checklist_template} WHERE ID = '$checklist_template_id'" );
	
	return $checklist_template_id;
}
/* ==================================== END DELETE CHECKLIST TEMPLATE ==================================== */

/* ==================================== EDIT CHECKLIST CATEGORY ==================================== */
function edit_checklist_category($data_id){
	global $wpdb;
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category"; 
	$checklist_categories = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE ID = '$data_id'");
		
	$category_name = $checklist_categories->check_list_category;	
	
	return $data_id ."_". $category_name;
}

function update_checklist_category($update_checklist_category_details){
	parse_str($update_checklist_category_details, $edit_category_form_data);	
	$category_name = $edit_category_form_data['checklist_category_name'];
	$category_id = $edit_category_form_data['checklist_category_id'];
	$checklist_current_category_name = $edit_category_form_data['checklist_current_category_name'];
	
	global $wpdb;
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category"; 
	
	$table_name_checklist = $wpdb->prefix . "custom_checklist"; 
	$checklists = $wpdb->get_results("SELECT * FROM {$table_name_checklist} WHERE checklist_category='$checklist_current_category_name'");
	$table_name_checklist_task = $wpdb->prefix . "custom_checklist_task"; 
	$checklist_tasks = $wpdb->get_results("SELECT * FROM {$table_name_checklist_task} WHERE task_checklist_status = 'Ongoing'");
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 
	$checklist_templates = $wpdb->get_results("SELECT * FROM {$table_name_checklist_template}");	
	$checklist_category = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE check_list_category='$checklist_current_category_name'");
	$checklist_category_priority = $checklist_category->checklist_category_priority;
	
	/* custom_checklist_category */
	$update_custom_checklist_category = $wpdb->update( $table_name_checklist_category , array( 
	'check_list_category'	=> $category_name
	),	
	array( 'ID' => $category_id ),
	array( '%s', '%s' ));	
	/* END custom_checklist_category */
	
	/* custom_checklist */	
	foreach($checklists as $checklist){
		$checklist_id = $checklist->ID;
		$update_custom_checklist = $wpdb->update( $table_name_checklist , array( 
			'checklist_category'	=> $category_name
		),	
		array( 'ID' => $checklist_id ),
		array( '%s', '%s' ));
	}
	/* END custom_checklist */	
	
	/* custom_checklist_task */
	foreach($checklist_tasks as $checklist_task){		
		$checklist_task_items = unserialize($checklist_task->task_checklist_items);
		if($checklist_task_items != null){
			foreach($checklist_task_items as $checklist_task_category => $checklist_task_item){
				if($checklist_task_category == $checklist_category_priority .'_'. $checklist_current_category_name){
					$checklist_task_id = $checklist_task->ID;
					print_var($checklist_task_id);
					unset ($checklist_task_items[$checklist_task_category]);
					$checklist_task_items[$checklist_category_priority .'_'. $category_name] = $checklist_task_item;					
					$edited_category = serialize($checklist_task_items);					
					$update_custom_checklist_task = $wpdb->update( $table_name_checklist_task , array( 
						'task_checklist_items'	=> $edited_category
					),	
					array( 'ID' => $checklist_task_id ),
					array( '%s', '%s' ));					
				}				
			}
		}
	}
	/* END custom_checklist_task */
	
	/* END custom_checklist_template */
	foreach($checklist_templates as $checklist_template){
		$checklist_items = unserialize($checklist_template->checklist_items);		
		if($checklist_items != null){
			foreach($checklist_items as $checklist_category => $checklist_item){
				if($checklist_category == $checklist_category_priority .'_'. $checklist_current_category_name){
					$checklist_id = $checklist_template->ID;		
					unset ($checklist_items[$checklist_category]);
					$checklist_items[$checklist_category_priority .'_'. $category_name] = $checklist_item;								
					$edited_category = serialize($checklist_items);					
					$update_custom_checklist_template = $wpdb->update( $table_name_checklist_template , array( 
						'checklist_items'	=> $edited_category
					),	
					array( 'ID' => $checklist_id ),
					array( '%s', '%s' ));					
				}				
			}
		}
	}
	/* END custom_checklist_template */
	
	$toggle_class = preg_replace("/\s+/", " ", $checklist_current_category_name);
	$toggle_class = str_replace(" ", "_", $toggle_class);
	$toggle_class = preg_replace("/[^A-Za-z0-9_]/","",$toggle_class);
	$toggle_class = strtolower($toggle_class);	
	
	return $category_name .'<_>'. $toggle_class;
}
/* ==================================== END EDIT CHECKLIST CATEGORY ==================================== */

/* ==================================== CONFIRM DELETE CHECKLIST CATEGORY ==================================== */
function confirm_delete_checklist_category($data_id){
	global $wpdb;
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category"; 
	$checklist_categories = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE ID = '$data_id'");
	
	$category_name = $checklist_categories->check_list_category;	
	
	return $data_id ."_". $category_name;
}

function delete_checklist_category($delete_checklist_category_details){
	parse_str($delete_checklist_category_details, $delete_category_form_data);	
	$category_name = $delete_category_form_data['checklist_category_name'];
	$category_id = $delete_category_form_data['checklist_category_id'];	
	
	global $wpdb;
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category"; 	
	$table_name_checklist = $wpdb->prefix . "custom_checklist"; 
	$checklists = $wpdb->get_results("SELECT * FROM {$table_name_checklist} WHERE checklist_category='$category_name'");
	$table_name_checklist_task = $wpdb->prefix . "custom_checklist_task"; 
	$checklist_tasks = $wpdb->get_results("SELECT * FROM {$table_name_checklist_task} WHERE task_checklist_status = 'Ongoing'");
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 
	$checklist_templates = $wpdb->get_results("SELECT * FROM {$table_name_checklist_template}");
	$checklist_category = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE check_list_category='$category_name'");
	$checklist_category_priority = $checklist_category->checklist_category_priority;
	 /* custom_checklist_category */
	$delete_custom_checklist_category = $wpdb->query( "DELETE FROM {$table_name_checklist_category} WHERE ID = '$category_id'" ) ;		
	/* END custom_checklist_category */
	
	/* custom_checklist */	
	foreach($checklists as $checklist){		
		$checklist_id = $checklist->ID;
		$delete_custom_checklist = $wpdb->query( "DELETE FROM {$table_name_checklist} WHERE ID = '$checklist_id'" ) ;		
	}
	/* END custom_checklist */
	
	/* custom_checklist_task */
	foreach($checklist_tasks as $checklist_task){		
		$checklist_task_items = unserialize($checklist_task->task_checklist_items);
		if($checklist_task_items != null){
			foreach($checklist_task_items as $checklist_task_category => $checklist_task_item){
				if($checklist_task_category == $checklist_category_priority .'_'. $category_name){
					$checklist_task_id = $checklist_task->ID;	
					unset ($checklist_task_items[$checklist_task_category]);					
					$edited_category = serialize($checklist_task_items);									
					$update_custom_checklist_task = $wpdb->update( $table_name_checklist_task , array( 
					'task_checklist_items'	=> $edited_category
					),	
					array( 'ID' => $checklist_task_id ),
					array( '%s', '%s' ));					
				}				
			}
		}
	}
	/* END custom_checklist_task */
	
	/* END custom_checklist_template */
	foreach($checklist_templates as $checklist_template){
		$checklist_items = unserialize($checklist_template->checklist_items);		
		if($checklist_items != null){
			foreach($checklist_items as $checklist_category => $checklist_item){
				if($checklist_category == $checklist_category_priority .'_'. $category_name){
					$checklist_id = $checklist_template->ID;
					unset ($checklist_items[$checklist_category]);					
					$edited_category = serialize($checklist_items);
					$update_custom_checklist_template = $wpdb->update( $table_name_checklist_template , array(
					'checklist_items'	=> $edited_category
					),	
					array( 'ID' => $checklist_id ),
					array( '%s', '%s' ));
				}
			}
		}
	}
	/* END custom_checklist_template */
	$toggle_class = preg_replace("/\s+/", " ", $category_name);
	$toggle_class = str_replace(" ", "_", $toggle_class);
	$toggle_class = preg_replace("/[^A-Za-z0-9_]/","",$toggle_class);
	$toggle_class = strtolower($toggle_class);	
	
	return $toggle_class;
}
/* ==================================== END CONFIRM DELETE CHECKLIST CATEGORY ==================================== */

/* ==================================== EDIT CHECKLIST ==================================== */
function edit_checklist($checklist_div_id){
	$checklist_div_id_explode = explode('_', $checklist_div_id);
	$check_list_category = $checklist_div_id_explode[2];
	$checklist_key = $checklist_div_id_explode[3];
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_checklist";
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category"; 
	$checklist_categories = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE ID ='$check_list_category'");
	$checklist_category_name = $checklist_categories->check_list_category;
	$checklists = $wpdb->get_row("SELECT * FROM {$table_name} WHERE checklist_category ='$checklist_category_name'");
	$checklist = $checklists->checklist;
	$unserialize = unserialize($checklist);	
	foreach($unserialize as $key => $list){
		if($key == $checklist_key){
			$list_explode = explode('<__>', $list);
			$checklist_name = $list_explode[0];
			$checklist_description = $list_explode[1];
		}
	}
	$html = '
	<form method="post" id="edit_modal_checklist">		
	<div class="input_div">
	<p class="label">Checklist Name</p>	
	<input type="text" name="checklist_name" class="checklist_name" value="'.$checklist_name.'"/>
	</div>
	<div class="input_div">
	<p class="label">Checklist Description</p>	
	<textarea type="text" name="checklist_description" class="checklist_description">'.$checklist_description.'</textarea>
	</div>
	<input type="hidden" name="checklist_category" value="'.$checklist_category_name.'" />
	<input type="hidden" name="checklist_key" value="'.$checklist_key.'" />
	<input type="hidden" name="checklist_category_id" value="'.$check_list_category.'" />
	<div class="modal_save_edit_checklist button_1 action_button">Update</div>
	<div style="display:none;" class="loader"></div>
	</form>';
	return $html;	
	
}

function update_edit_checklist($checklist_update_edit_details){
	parse_str($checklist_update_edit_details, $checklist_form_array);	
	$checklist_name = $checklist_form_array['checklist_name'];
	$checklist_description = $checklist_form_array['checklist_description'];
	$checklist_category = $checklist_form_array['checklist_category'];
	$checklist_key = $checklist_form_array['checklist_key'];
	$checklist_category_id = $checklist_form_array['checklist_category_id'];	
	
	global $wpdb;	 	
	$table_name_checklist = $wpdb->prefix . "custom_checklist"; 
	$checklists = $wpdb->get_row("SELECT * FROM {$table_name_checklist} WHERE checklist_category ='$checklist_category'");
	$table_name_checklist_task = $wpdb->prefix . "custom_checklist_task"; 
	$checklist_tasks = $wpdb->get_results("SELECT * FROM {$table_name_checklist_task} WHERE task_checklist_status = 'Ongoing'");
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 
	$checklist_templates = $wpdb->get_results("SELECT * FROM {$table_name_checklist_template}");
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category"; 
	$checklist_category_items = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE check_list_category='$checklist_category'");
	$add_checklist_category_id = $checklist_category_items->ID;
	$checklist_category_priority = $checklist_category_items->checklist_category_priority;
	
	/* custom_checklist */
	$checklist_id = $checklists->ID;
	$checklist = unserialize($checklists->checklist);	
	$checklist[$checklist_key] = $checklist_name .'<__>'. $checklist_description;
	$serialized = serialize($checklist);	
	$update = $wpdb->update( $table_name_checklist , array( 
		'checklist'	=> $serialized
	),	
	array( 'ID' => $checklist_id ),
	array( '%s', '%s' ));
	/* END custom_checklist */
	
	/* custom_checklist_task */	
	foreach($checklist_tasks as $checklist_task){
		$task_checklist_items = unserialize($checklist_task->task_checklist_items);
		if($task_checklist_items != null){
			foreach($task_checklist_items as $task_checklist_category => $task_checklist_item){				
				if($checklist_category_priority .'_'. $checklist_category == $task_checklist_category){
					$checklist_task_id = $checklist_task->ID;
					$task_checklist_items[$task_checklist_category][$checklist_key] = $checklist_name .'<__>'. $checklist_description;
					$serialized = serialize($task_checklist_items);	
					$update = $wpdb->update( $table_name_checklist_task , array( 
						'task_checklist_items'	=> $serialized
					),	
					array( 'ID' => $checklist_task_id ),
					array( '%s', '%s' ));
				}				
			}
		}
	}
	/* END custom_checklist_task */
	
	/* custom_checklist_template */	
	foreach($checklist_templates as $checklist_template){
		$template_checklist_items = unserialize($checklist_template->checklist_items);
		foreach($template_checklist_items as $template_checklist_category => $template_checklist_item){
			if($checklist_category_priority .'_'. $checklist_category == $template_checklist_category){
				$checklist_template_id = $checklist_template->ID;
				$template_checklist_items[$template_checklist_category][$checklist_key] = $checklist_name .'<__>'. $checklist_description;
				$serialized = serialize($template_checklist_items);	
				$update = $wpdb->update( $table_name_checklist_template , array( 
					'checklist_items'	=> $serialized
				),	
				array( 'ID' => $checklist_template_id ),
				array( '%s', '%s' ));
			}
		}
	}
	/* END custom_checklist_template */
	
	$checklist_form_array['add_checklist_category_id'] = $add_checklist_category_id;
	return $checklist_form_array;
}
/* ==================================== END EDIT CHECKLIST ==================================== */

/* ==================================== DELETE CHECKLIST ==================================== */
function confirm_delete_checklist($checklist_div_id){	
	$checklist_div_id_explode = explode('_', $checklist_div_id);
	$check_list_category = $checklist_div_id_explode[2];
	$checklist_key = $checklist_div_id_explode[3];
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_checklist";
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category"; 
	$checklist_categories = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE ID ='$check_list_category'");
	$checklist_category_name = $checklist_categories->check_list_category;
	$checklists = $wpdb->get_row("SELECT * FROM {$table_name} WHERE checklist_category ='$checklist_category_name'");
	$checklists_list = unserialize($checklists->checklist);
	foreach($checklists_list as $key => $checklist_list){
		if($key == $checklist_key){			
			$delete_checklist = $checklist_list;
			$delete_checklist_explode = explode('<__>', $delete_checklist);
			$checklist_name = $delete_checklist_explode[0];
		}		
	}
	$html = '
	<form method="post" id="delete_modal_checklist">		
	<div class="input_div">
	<p>Are you sure you want to delete <span class="span_bold">'.$checklist_name.'</span> from <span class="span_bold">'.$checklist_category_name.'</span>?</p>
	<input type="hidden" name="checklist" value="'.$delete_checklist.'" />
	<input type="hidden" name="checklist_category_name" value="'.$checklist_category_name.'" />
	<input type="hidden" name="checklist_category_id" value="'.$check_list_category.'" />
	<input type="hidden" name="checklist_key" value="'.$checklist_key.'" />
	</div>	
	<div class="modal_save_delete_checklist button_1 action_button">Delete</div>
	<div style="display:none;" class="loader"></div>
	</form>';
	return $html;	
}
function checklist_delete_details($checklist_delete_details){
	parse_str($checklist_delete_details, $checklist_form_array);
	$checklist = $checklist_form_array['checklist'];
	$checklist_category_name = $checklist_form_array['checklist_category_name'];
	$checklist_key = $checklist_form_array['checklist_key'];
	$checklist_category_id = $checklist_form_array['checklist_category_id'];
	
	global $wpdb;	 	
	$table_name_checklist = $wpdb->prefix . "custom_checklist"; 
	$checklists = $wpdb->get_row("SELECT * FROM {$table_name_checklist} WHERE checklist_category ='$checklist_category_name'");
	$table_name_checklist_task = $wpdb->prefix . "custom_checklist_task"; 
	$checklist_tasks = $wpdb->get_results("SELECT * FROM {$table_name_checklist_task} WHERE task_checklist_status = 'Ongoing'");
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 
	$checklist_templates = $wpdb->get_results("SELECT * FROM {$table_name_checklist_template}");	
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category"; 
	$checklist_category_items = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE check_list_category='$checklist_category_name'");
	$checklist_category_priority = $checklist_category_items->checklist_category_priority;
	
	/* custom_checklist */
	$checklist_id = $checklists->ID;
	$checklist = unserialize($checklists->checklist);	
	unset($checklist[$checklist_key]);	
	$serialized = serialize($checklist);	
	$update = $wpdb->update( $table_name_checklist , array( 
		'checklist'	=> $serialized
	),	
	array( 'ID' => $checklist_id ),
	array( '%s', '%s' ));
	/* END custom_checklist */
	
	/* custom_checklist_task */	
	foreach($checklist_tasks as $checklist_task){
		$task_checklist_items = unserialize($checklist_task->task_checklist_items);
		if($task_checklist_items != null){
			foreach($task_checklist_items as $task_checklist_category => $task_checklist_item){				
				if($checklist_category_priority .'_'. $checklist_category_name == $task_checklist_category){
					foreach($task_checklist_item as $key => $checklist_item_task){					
						if ($checklist == $checklist_item_task) {
							$checklist_task_id = $checklist_task->ID;							
							unset($task_checklist_items[$task_checklist_category][$key]);							
							$serialized = serialize($task_checklist_items);	
							$update = $wpdb->update( $table_name_checklist_task , array( 
								'task_checklist_items'	=> $serialized
							),	
							array( 'ID' => $checklist_task_id ),
							array( '%s', '%s' ));							
						}
					}					
				}				
			}
		}
	}
	/* END custom_checklist_task */
	
	/* custom_checklist_template */	
	foreach($checklist_templates as $checklist_template){		
		$template_checklist_items = unserialize($checklist_template->checklist_items);
		foreach($template_checklist_items as $template_checklist_category => $template_checklist_item){
			if($checklist_category_priority .'_'. $checklist_category_name == $template_checklist_category){
				foreach($template_checklist_item as $key => $checklist_item_template){					
					if ($checklist == $checklist_item_template) {
						$checklist_template_id = $checklist_template->ID;						
						unset($template_checklist_items[$template_checklist_category][$key]);
						$serialized = serialize($template_checklist_items);						
						$update = $wpdb->update( $table_name_checklist_template , array( 
							'checklist_items'	=> $serialized
						),	
						array( 'ID' => $checklist_template_id ),
						array( '%s', '%s' ));						
					}
				}
			}			
		}
	}
	/* END custom_checklist_template */
	
	return $checklist_form_array;
}
/* ==================================== END DELETE CHECKLIST ==================================== */

/* ==================================== CHECKLIST CATEGORY PRIORITY ==================================== */
/* ==================================== END CHECKLIST CATEGORY PRIORITY ==================================== */
function checklist_category_priority($category_priority_details){
	global $wpdb;
	$table_checklist = $wpdb->prefix . "custom_checklist"; 
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category";
	$table_checklist_task = $wpdb->prefix . "custom_checklist_task";
	$table_checklist_template = $wpdb->prefix . "custom_checklist_template";
	
	$checklist_category_name_array = array();
	foreach($category_priority_details['category_priority_details'] as $category_priority => $id){
		$update_checklist_category = $wpdb->update( $table_name_checklist_category , array( 
		'checklist_category_priority'	=> $category_priority
		),	
		array( 'ID' => $id ),
		array( '%s', '%s' ));
		$checklist_category = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE ID = '$id'");		
		$checklist_category_name_array[$category_priority] = $checklist_category->check_list_category;		
	}

	foreach($checklist_category_name_array as $category_priority => $checklist_category_name){
		$checklists = $wpdb->get_row("SELECT * FROM {$table_checklist} WHERE checklist_category = '$checklist_category_name'");
		$checklist_id = $checklists->ID;
		$update_checklist = $wpdb->update( $table_checklist , array( 
		'checklist_category_priority'	=> $category_priority
		),	
		array( 'ID' => $checklist_id ),
		array( '%s', '%s' ));		
	}
	
	$checklist_tasks = $wpdb->get_results("SELECT * FROM {$table_checklist_task}");
		
	foreach($checklist_tasks as $checklist_task){		
		$checklist_task_items = unserialize($checklist_task->task_checklist_items);
		if($checklist_task_items != null){
			foreach($checklist_task_items as $checklist_task_category => $checklist_task_item){
				foreach($checklist_category_name_array as $category_priority => $checklist_category_name){
					$checklist_task_category_explode = explode('_',$checklist_task_category);
					$task_category_checklist = $checklist_task_category_explode[1];
					if($task_category_checklist == $checklist_category_name){
						$checklist_task_id = $checklist_task->ID;
						unset ($checklist_task_items[$checklist_task_category]);
						$checklist_task_items[$category_priority ."_". $checklist_category_name] = $checklist_task_item;					
						$edited_category = serialize($checklist_task_items);					
						$update_custom_checklist_task = $wpdb->update( $table_checklist_task , array( 
							'task_checklist_items'	=> $edited_category
						),	
						array( 'ID' => $checklist_task_id ),
						array( '%s', '%s' ));					
					}
				}								
			}
		}
	}
	
	$checklist_templates = $wpdb->get_results("SELECT * FROM {$table_checklist_template}");
	
	foreach($checklist_templates as $checklist_template){
		$checklist_items = unserialize($checklist_template->checklist_items);		
		if($checklist_items != null){
			foreach($checklist_items as $checklist_category => $checklist_item){
				foreach($checklist_category_name_array as $category_priority => $checklist_category_name){
					$checklist_category_explode = explode('_',$checklist_category);
					$category_checklist = $checklist_category_explode[1];
					if($category_checklist == $checklist_category_name){
						$checklist_id = $checklist_template->ID;		
						unset ($checklist_items[$checklist_category]);
						$checklist_items[$category_priority ."_". $checklist_category_name] = $checklist_item;								
						$edited_category = serialize($checklist_items);					
						$update_custom_checklist_template = $wpdb->update( $table_checklist_template , array( 
						'checklist_items'	=> $edited_category
						),	
						array( 'ID' => $checklist_id ),
						array( '%s', '%s' ));					
					}
				}
			}
		}
	}
	
	return $category_priority_details['this_data_id'];
}
/* ==================================== CHECK TEMPLATE EXIST ==================================== */
function check_template_exist($template_name){
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_checklist_template"; 
	$template_checklists = $wpdb->get_row("SELECT * FROM {$table_name} WHERE checklist_template = '$template_name'");
	if($template_checklists == null){
		$check_result = 'not_exist<_>'.$template_name;
	}else{
		$check_result = 'exist';
	}
	return $check_result;
}
/* ==================================== END CHECK TEMPLATE EXIST ==================================== */

/* ==================================== TEMPLATE CHECKLIST SELECT ==================================== */
function template_checklist_select($template_name){
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_checklist_template"; 
	$template_checklists = $wpdb->get_row("SELECT * FROM {$table_name} WHERE checklist_template = '$template_name'");	
	if($template_checklists != null){
		$unserialized = unserialize($template_checklists->checklist_items);
		$checked_item_array = array();
		if($unserialized != null){			
			foreach($unserialized as $category_name => $checklist_items){
				foreach($checklist_items as $checklist_item){
					$checked_item_array[] = $checklist_item ."_". $category_name;
				}
			}
		}
	}
	return $checked_item_array;
}
/* ==================================== END TEMPLATE CHECKLIST SELECT ==================================== */

/* ==================================== CATEGORY CHECKLIST SELECT ==================================== */
function add_checklist_category_select($checklist_category_name){
	global $wpdb;
	$table_name_checklist = $wpdb->prefix . "custom_checklist";
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category"; 
	$checklist_categories = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE check_list_category = '$checklist_category_name'");
	$checklist_category_id = $checklist_categories->ID;
	$checklist_category_items = $wpdb->get_row("SELECT * FROM {$table_name_checklist} WHERE checklist_category = '$checklist_category_name'");
	if($checklist_category_items != null){
		$category_items = unserialize($checklist_category_items->checklist);
		if($category_items != null){
			$html = "";
			foreach($category_items as $key => $category_item){			
				$checklist_name_description_explode = explode('<__>', stripslashes($category_item));
				$checklist_name = $checklist_name_description_explode[0];
				$checklist_description = $checklist_name_description_explode[1];
				$checklist_description_display = find_url($checklist_description);
				
				$html .='
				<li id="checklist_display_'. $checklist_category_id .'_'. $key .'">
				<div class="section">
				<div class="left">
				<p id="name_item_p_'. $key .'" class="checklist_name_display">'. $checklist_name .'</p>
				<input type="text" style="display:none" id="checklist_name_input_'. $key .'" value="'. $checklist_name .'" />
				<p id="description_item_p_'. $key .'" class="checklist_description_display">'. $checklist_description_display .'</p>
				<textarea style="display:none" id="checklist_description_input_'. $key .'">'. $checklist_description .'</textarea>				
				</div>
				<div class="action_buttons right">
				<div style="display:none" id="check_item_'. $key .'" class="check_button"></div>
				<div id="checklist_delete_'. $checklist_category_id .'_'. $key .'" class="delete_item_'. $key .' checklist_delete button_2 checklist_action_button">D</div>
				<div id="edit_item_'. $key .'" class="button_2 checklist_action_button edit_checklist_item">E</div>
				<div style="display:none" id="check_item_loader_'. $key .'" class="loader"></div>			
				</div>
				</div>
				</li>';
			}
		}else{
			$html = 'No checklist Found.';
		}
	}
	
	
	return $html .'<_>'. $checklist_category_name .'<_>'. $checklist_category_id;
}
/* ==================================== END CATEGORY CHECKLIST SELECT ==================================== */

/* ==================================== PERSON CHECKLIST SELECT ==================================== */
function task_person_checklist_select($person_name){
	$checklist_details_array = array();
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_checklist_task";
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 	
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category";
	$checklist_tasks = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_checklist_person_name='$person_name'");
	
	foreach($checklist_tasks as $key => $checklist_task){
		$checklist_details_array['checklist_task_template_names'][] = $checklist_task->task_checklist_template;
		if($key == 0){
			$selected_template_name = $checklist_task->task_checklist_template;
			$checklist_task_id = $checklist_task->ID;
		}		
	}	
	
	$checklist_items_array = array();
	$checklists = $wpdb->get_results("SELECT * FROM {$table_name_checklist_template} WHERE checklist_template = '$selected_template_name'");	
	foreach($checklists as $checklist){
		$checklist_item = $checklist->checklist_items;
		$checklist_items_array[] = $checklist_item;		
	}
	$unique_checklist_items = array_unique($checklist_items_array);
	foreach($unique_checklist_items as $unique_checklist_item){
		$checklist_items = unserialize($unique_checklist_item);
		foreach($checklist_items as $checklist_category => $checklists_item){
			$checklist_category_explode = explode('_', $checklist_category);
			$checklist_category_name = $checklist_category_explode[1];
			$checklist_details_array['checklist_categories'][] = $checklist_category_name;
			$check_category = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE check_list_category = '$checklist_category_name'");								
			$checklist_category_id = $check_category->ID;
			foreach($checklists_item as $checklist_key => $checklist_item){
				$checklist_details_array['checklist_items'][] = stripslashes($checklist_item) ."_". $checklist_category ."_". $checklist_key ."_". $checklist_category_id;
			}
		}
	}
		
	$checked_checklist_task = $wpdb->get_row("SELECT * FROM {$table_name} WHERE task_checklist_template = '$selected_template_name' AND task_checklist_person_name='$person_name'");	
	$checklist_details_array['checklist_project'] = $checked_checklist_task->task_checklist_project_name;
	$checklist_details_array['checklist_client'] = $checked_checklist_task->task_checklist_client_name;
	$checked_items_array = array();							
	$unserialized = unserialize($checked_checklist_task->task_checklist_items);
	if($unserialized != null){
		foreach($unserialized as $checked_checklist_category => $task_checklist_items){			
			foreach($task_checklist_items as $task_checklist_item){
				$checklist_details_array['checked_items_array'][] = stripslashes($task_checklist_item) ."_". $checked_checklist_category;
			}							
		}
	}
	
	$checklist_details_array['checklist_task_id'] = $checklist_task_id;
	$checklist_details_array['selected_template_name'] = $selected_template_name;
	
	return $checklist_details_array;
}
/* ==================================== END TASK CHECKLIST SELECT ==================================== */

/* ==================================== TASK CHECKLIST SELECT ==================================== */
function task_checklist_select($task_checklist_details){	
	$task_checklist_details_explode = explode('_', $task_checklist_details);
	$template_id = $task_checklist_details_explode[0];
	$person_name = $task_checklist_details_explode[1];
	$checklist_details_array = array();
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_checklist_task";
	$table_name_checklist_template = $wpdb->prefix . "custom_checklist_template"; 
	$table_name_checklist_category = $wpdb->prefix . "custom_checklist_category";
	$checklist_task = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID = $template_id AND task_checklist_person_name='$person_name'");
	$template_name = $checklist_task->task_checklist_template;
	$checklists = $wpdb->get_results("SELECT * FROM {$table_name_checklist_template} WHERE checklist_template = '$template_name'");
	
	$checklist_task_id = $checklist_task->ID;	
	$checklist_details_array['checklist_project'] = $checklist_task->task_checklist_project_name;
	$checklist_details_array['checklist_client'] = $checklist_task->task_checklist_client_name;
	
	$checklist_items_array = array();	
	foreach($checklists as $checklist){
		$checklist_items_array[] = $checklist->checklist_items;
		
	}
	
	$unique_checklist_items = array_unique($checklist_items_array);
	foreach($unique_checklist_items as $unique_checklist_item){
		$checklist_items = unserialize($unique_checklist_item);
		ksort($checklist_items);
		foreach($checklist_items as $checklist_category => $checklists_item){
			$checklist_category_explode = explode('_', $checklist_category);
			$checklist_category_name = $checklist_category_explode[1];
			$checklist_details_array['checklist_categories'][] = $checklist_category_name;
			$check_category = $wpdb->get_row("SELECT * FROM {$table_name_checklist_category} WHERE check_list_category = '$checklist_category_name'");								
			$check_category_id = $check_category->ID;
			foreach($checklists_item as $key => $checklist_item){
				$checklist_details_array['checklist_items'][] = stripslashes($checklist_item) ."_". $checklist_category ."_". $key ."_". $check_category_id;
			}
		}
	}
	
	$checked_items_array = array();							
	$unserialized = unserialize($checklist_task->task_checklist_items);
	if($unserialized != null){
		foreach($unserialized as $key => $task_checklist_items){
			foreach($task_checklist_items as $task_checklist_item){
				$checklist_details_array['checked_items_array'][] = $task_checklist_item ."_". $key;
			}							
		}
	}
	
	$checklist_details_array['checklist_task_id'] = $checklist_task_id;
	return $checklist_details_array;
}
/* ==================================== END TASK CHECKLIST SELECT ==================================== */

/* ==================================== DELETE AJAX ==================================== */
function delete_ajax($delete_ajax_details){
	parse_str($delete_ajax_details, $delete_ajax_form_array);	
	$delete_id = $delete_ajax_form_array['delete_id'];
	$delete_type = $delete_ajax_form_array['delete_type'];
	
	global $wpdb;
	$table_name_project = $wpdb->prefix . "custom_project";
	$table_name_client = $wpdb->prefix . "custom_client";
	$table_name_person = $wpdb->prefix . "custom_person";	
	$table_name_task = $wpdb->prefix . "custom_task";
	$table_name_department = $wpdb->prefix . "custom_department";
	$table_name_monthly_plan = $wpdb->prefix . "custom_monthly_plan"; 
	$table_name_website = $wpdb->prefix . "custom_website";
	$table_name_hosting_domain = $wpdb->prefix . "custom_hosting_domain";
	
	if($delete_type == 'Project'){
		$delete = $wpdb->query( "DELETE FROM {$table_name_project} WHERE ID = '$delete_id'");
	}
	
	if($delete_type == 'Client'){
		$delete = $wpdb->query( "DELETE FROM {$table_name_client} WHERE ID = '$delete_id'");
	}
	
	if($delete_type == 'Person'){
		$delete = $wpdb->query( "DELETE FROM {$table_name_person} WHERE ID = '$delete_id'");
	}
	
	if($delete_type == 'Task'){
		$delete = $wpdb->query( "DELETE FROM {$table_name_task} WHERE ID = '$delete_id'");
	}
	
	if($delete_type == 'Department'){
		$delete = $wpdb->query( "DELETE FROM {$table_name_department} WHERE ID = '$delete_id'");
	}
	
	if($delete_type == 'Monthly Plan'){
		$delete = $wpdb->query( "DELETE FROM {$table_name_monthly_plan} WHERE ID = '$delete_id'");
	}
	
	if($delete_type == 'Website'){
		$delete = $wpdb->query( "DELETE FROM {$table_name_website} WHERE ID = '$delete_id'");
	}
	
	if($delete_type == 'Hosting Domain'){
		$delete = $wpdb->query( "DELETE FROM {$table_name_hosting_domain} WHERE ID = '$delete_id'");
	}
	
	return $delete_id;
}
/* ==================================== END DELETE AJAX ==================================== */

/* ==================================== ARCHIVE PERSON ==================================== */
function archive_person($person_details){
	parse_str($person_details, $person_details_form_array);
	$person_id = $person_details_form_array['person_id'];
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_person"; 
	$person = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID=$person_id");		
	
	$update = $wpdb->update( $table_name , array( 
		'person_status' => 1
	),	
	array( 'ID' => $person_id ),
	array( '%s', '%s' ));
	
	$person_details_form_array['person_hourly_rate'] = $person->person_hourly_rate;
	$person_details_form_array['person_permission'] = $person->person_permission;
	return $person_details_form_array;
}
/* ==================================== END ARCHIVE PERSON ==================================== */

/* ==================================== UNARCHIVE PERSON ==================================== */
function unarchive_person($person_details){
	parse_str($person_details, $person_details_form_array);
	$person_id = $person_details_form_array['person_id'];
	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_person"; 
	$person = $wpdb->get_row("SELECT * FROM {$table_name} WHERE ID=$person_id");		
	
	$update = $wpdb->update( $table_name , array( 
	'person_status' => 0
	),	
	array( 'ID' => $person_id ),
	array( '%s', '%s' ));
	
	$person_details_form_array['person_hourly_rate'] = $person->person_hourly_rate;
	$person_details_form_array['person_permission'] = $person->person_permission;
	return $person_details_form_array;
}
/* ==================================== END UNARCHIVE PERSON ==================================== */

/* ==================================== CLIENT INFORMATION ==================================== */
function client_information($client_name){	
	global $wpdb;
	$table_name = $wpdb->prefix . "custom_client"; 
	$table_name_website = $wpdb->prefix . "custom_website"; 
	$table_name_project = $wpdb->prefix . "custom_project";
	$client_detail = $wpdb->get_row("SELECT * FROM {$table_name} WHERE client_name='$client_name'");
	$client_website_details = $wpdb->get_results("SELECT * FROM {$table_name_website} WHERE site_client = '$client_name'");
	$projects = $wpdb->get_results("SELECT * FROM {$table_name_project} ORDER BY project_client ASC");
	$client_information = array();
	
	$client_address = ($client_detail->client_address) ? $client_detail->client_address : "--";
	$client_contact_person = ($client_detail->client_contact_person) ? $client_detail->client_contact_person : "--";
	$client_contact_phone = ($client_detail->client_contact_phone) ? $client_detail->client_contact_phone : "--";
	$client_contact_email = ($client_detail->client_contact_email) ? $client_detail->client_contact_email : "--";
	$client_monthly_plan = ($client_detail->client_monthly_plan) ? $client_detail->client_monthly_plan : "--";
	$client_satisfaction = ($client_detail->client_satisfaction) ? $client_detail->client_satisfaction : "--";
	
	foreach($client_website_details as $client_website_detail){
		$site_url = ($client_website_detail->site_url) ? $client_website_detail->site_url : "--";		
		$site_type = ($client_website_detail->site_type) ? $client_website_detail->site_type : "--";
		$site_platform = ($client_website_detail->site_platform) ? $client_website_detail->site_platform : "--";
		$site_wp_version = ($client_website_detail->site_wp_version) ? $client_website_detail->site_wp_version : "--";
		$site_username = ($client_website_detail->site_username) ? $client_website_detail->site_username : "--";
		$site_password = ($client_website_detail->site_password) ? $client_website_detail->site_password : "--";
		$site_login_url = ($client_website_detail->site_login_url) ? $client_website_detail->site_login_url : "--";
		$client_information['client_site_information'][] = $site_url ."<_>". $site_type ."<_>". $site_platform ."<_>". $site_wp_version ."<_>". $site_username ."<_>". $site_password ."<_>". $site_login_url;
	}
	
	$webdev_projects = array();
	foreach($projects as $project){									
		if($project->project_status == 'unarchived'){
			$project_client_name = $project->project_client;
			$project_name = $project->project_name;
			if($project_client_name == $client_name){
				if($project_name != 'Monthly Ongoing Dev' && $project_name != 'Monthly Ongoing SEO' && $project_name != 'Training' && $project_name !='Non working team' ){
					$webdev_projects[] = $project_name;
				}
			}
		}
	}
	
	$client_information['current_active_webdev_projects'] = count($webdev_projects);
	$client_information['client_information'] = $client_name ."<_>". $client_address ."<_>". $client_contact_person ."<_>". $client_contact_phone ."<_>". $client_contact_email ."<_>". $client_monthly_plan ."<_>". $client_satisfaction;
	return $client_information;
}
/* ==================================== END CLIENT INFORMATION ==================================== */

/* ==================================== EXCLUDE MENU ITEM ==================================== */
function exclude_menu_item( $items, $menu, $args ) {
	
	$current_user = wp_get_current_user();
	$current_user_role = $current_user->roles['0'];
	$page_manage_projects 		= get_page_by_title('Manage Projects');
	$page_client 				= get_page_by_title('Client');
	$page_people 				= get_page_by_title('People');
	$page_task 					= get_page_by_title('Task');
	$page_department			= get_page_by_title('Department');
	$page_manage_projects_id 	= $page_manage_projects->ID;
	$page_client_id 			= $page_client->ID;
	$page_people_id 			= $page_people->ID;
	$page_task_id 				= $page_task->ID;
	$page_department_id 		= $page_department->ID;
	
	if($current_user_role != 'administrator' && $current_user_role != 'editor'){
		foreach ( $items as $key => $item ) {			
			if ( $item->object_id == $page_manage_projects_id ){
				unset( $items[$key] );
			}
		}
	}
	
	if ($current_user_role == 'editor'){
		foreach ( $items as $key => $item ) {
			if ( $item->object_id == $page_client_id || $item->object_id == $page_people_id || $item->object_id == $page_task_id || $item->object_id == $page_department_id){
				unset( $items[$key] );
			}
		}
	}
	
	return $items;
}

add_filter( 'wp_get_nav_menu_items', 'exclude_menu_item', null, 3 );
/* ==================================== END EXCLUDE MENU ITEM ==================================== */

/* ==================================== FIND URL IN STRING ==================================== */
function find_url($string){
	preg_match('/(http:\/\/[^\s]+)/', $string, $text);
	$hypertext = "<a href=\"". $text[0] . "\">" . $text[0] . "</a>";
	$wrap_anchor = preg_replace('/(http:\/\/[^\s]+)/', $hypertext, $string);
	return $wrap_anchor;
}
/* ==================================== END FIND URL IN STRING ==================================== */

/* ==================================== RENAME WORDPRESS ROLES ==================================== */
function change_role_name() {
	global $wp_roles;
	
	if ( ! isset( $wp_roles ) )
	$wp_roles = new WP_Roles();
	
	//$roles = $wp_roles->get_names();
	//print_r($roles);
	
	//You can replace "administrator" with any other role "editor", "author", "contributor" or "subscriber"...
	$wp_roles->roles['editor']['name'] = 'Project Manager';
	$wp_roles->role_names['editor'] = 'Project Manager';
	
	$wp_roles->roles['subscriber']['name'] = 'User';
	$wp_roles->role_names['subscriber'] = 'User';
}
add_action('init', 'change_role_name');
/* ==================================== END RENAME WORDPRESS ROLES ==================================== */

/* ==================================== LIST COUNT WEEKDAYS ==================================== */
//The function returns the no. of business days between two dates and it skips the holidays
function getWorkingDays($startDate,$endDate){
	// do strtotime calculations just once
	$endDate = strtotime($endDate);
	$startDate = strtotime($startDate);
	
	
	//The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
	//We add one to inlude both dates in the interval.
	$days = ($endDate - $startDate) / 86400 + 1;
	
	$no_full_weeks = floor($days / 7);
	$no_remaining_days = fmod($days, 7);
	
	//It will return 1 if it's Monday,.. ,7 for Sunday
	$the_first_day_of_week = date("N", $startDate);
	$the_last_day_of_week = date("N", $endDate);
	
	//---->The two can be equal in leap years when february has 29 days, the equal sign is added here
	//In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
	if ($the_first_day_of_week <= $the_last_day_of_week) {
		if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
		if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
	}
	else {
		// (edit by Tokes to fix an edge case where the start day was a Sunday
		// and the end day was NOT a Saturday)
		
		// the day of the week for start is later than the day of the week for end
		if ($the_first_day_of_week == 7) {
			// if the start date is a Sunday, then we definitely subtract 1 day
			$no_remaining_days--;
			
			if ($the_last_day_of_week == 6) {
				// if the end date is a Saturday, then we subtract another day
				$no_remaining_days--;
			}
		}
		else {
			// the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
			// so we skip an entire weekend and subtract 2 days
			$no_remaining_days -= 2;
		}
	}
	
	//The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
	//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
	$workingDays = $no_full_weeks * 5;
	if ($no_remaining_days > 0 )
	{
		$workingDays += $no_remaining_days;
	}	
	
	return round($workingDays);
}
/* ==================================== END COUNT WEEKDAYS ==================================== */
/* ==================================== DATE RANGE ==================================== */
function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {
	
	$dates = array();
	$current = strtotime($first);
	$last = strtotime($last);
	
	while( $current <= $last ) {
		
		$dates[] = date($output_format, $current);
		$current = strtotime($step, $current);
	}
	
	return $dates;
}
/* ==================================== END DATE RANGE ==================================== */
/* ==================================== TIME FORMAT ==================================== */
function time_format($time){
	$colon_count = substr_count($time, ':'); 
	if(strlen($time) > 1){
		if($colon_count == 2){
			//echo "1";
			$hour_format_unrounded = substr($time, 0, strrpos( $time, ':'));
			$hour_format_unrounded_explode = explode(":", $hour_format_unrounded);
			$hour = $hour_format_unrounded_explode[0];
			$minutes = $hour_format_unrounded_explode[1];
			if(strlen($hour) == 1){				
				$format_hour = "0" . $hour;
			}elseif(strlen($hour) > 1 ){				
				$format_hour = $hour;
			}
			$round_minutes = round_nearest($minutes, 5);
			if(strlen($round_minutes) == 1){
				$rounded_minute = "0" . $round_minutes;
			}elseif(strlen($round_minutes) > 1){
				$rounded_minute = $round_minutes;
			}
			$hour_format = $format_hour .":". $rounded_minute;
		}elseif($colon_count == 1){
			$explode_time = explode(":", $time);
			$hour = $explode_time[0];
			$minutes = $explode_time[1];
			if($hour == null){
				//echo "2";
				$round_minutes = round_nearest($minutes, 5);
				if(strlen($round_minutes) == 1){
					$rounded_minute = "0" . $round_minutes;
				}elseif(strlen($round_minutes) > 1){
					$rounded_minute = $round_minutes;
				}
				$hour_format =  "00:" . $rounded_minute;
			}else{
				//echo "3 <br/>";
				$hour_count = strlen($hour);
				if($hour_count == 1){					
					//echo "3.1";
					$round_minutes = round_nearest($minutes, 5);
					if(strlen($round_minutes) == 1){
						$rounded_minute = "0" . $round_minutes;
					}elseif(strlen($round_minutes) > 1){
						$rounded_minute = $round_minutes;
					}
					$hour_format = "0" . $hour . ":" . $rounded_minute;
				}elseif($hour_count > 1){
					//echo "3.2";
					$round_minutes = round_nearest($minutes, 5);
					if(strlen($round_minutes) == 1){
						$rounded_minute = "0" . $round_minutes;
					}elseif(strlen($round_minutes) > 1){
						$rounded_minute = $round_minutes;
					}
					$hour_format = $hour . ":" . $rounded_minute;
				}
			}
		}
	}elseif(strlen($time) == 1){
		// echo "4";
		$hour_format = "0" . $time . ":00";
	}
	return $hour_format;
}
/* ==================================== END TIME FORMAT ==================================== */

/* ==================================== ROUND TO NEAREST 5 ==================================== */
function round_nearest($number,$round_to=5) {
	return 5 * round($number / 5);
}
/* ==================================== END ROUND TO NEAREST 5 ==================================== */

/* ==================================== ROUND TO NEAREST 15 ==================================== */
function round_quarter($input_time){
	$colon = strpos($input_time, ":");
	if($colon){
		$time_explode = explode(":", $input_time);
		$hours = $time_explode[0];
		$minute = $time_explode[1];
		$round_minute = round($minute/15)*15;								
		$format = $hours .":". $round_minute;
		$decimal = decimalHours($format);
		$rounded_quarter = time_format(convertTime($decimal));
		}else{		
		$input_time = time_format(convertTime($input_time));
		$time_explode = explode(":", $input_time);
		$hours = $time_explode[0];
		$minute = $time_explode[1];
		$round_minute = round($minute/15)*15;								
		$format = $hours .":". $round_minute;
		$decimal = decimalHours($format);
		$rounded_quarter = time_format(convertTime($decimal));
	}
	return $rounded_quarter;
}
/* ==================================== END ROUND TO NEAREST 15 ==================================== */

/* ==================================== FORMAT TASK NAME ==================================== */
function format_task_name($task_name){
	$task_name_explode = explode(' ', $task_name);
	$task_name_array = array();
	foreach($task_name_explode as $exploded_task_name){			
		if(strtoupper($exploded_task_name) !== $exploded_task_name){
			$exploded_task_name = ucwords($exploded_task_name);
		}
		$task_name_array[] = $exploded_task_name;
	}		
	$task_name = implode(" ",$task_name_array);
	
	return $task_name;
}
/* ==================================== END FORMAT TASK NAME ==================================== */

add_action('daily_empty_task_notification', 'mail_empty_task');

// function daily_email_empty_task() {
	// date_default_timezone_set('Asia/Manila');
	// $month = date("n");
	// $day = date("j");
	// $year = date("Y");
	// $timestamp = mktime('05', '0', '0', $month, $day , $year);
	//print_var(date('m/d/Y H:i:s a',$timestamp));
	//wp_schedule_event($timestamp, 'daily', 'email_empty_task_daily');
	//wp_unschedule_event( $timestamp, 'email_empty_task_daily', '');
// }

function mail_empty_task(){
	// $end_date = date("Y-m-d", strtotime("yesterday"));
	// $yesterday = date("d/m/Y", strtotime("yesterday"));
	// $date = date_create($end_date);
	// date_sub($date,date_interval_create_from_date_string("5 days"));
	// $start_date = date_format($date,"Y-m-d");
	// $date_range = date_range($start_date, $end_date);
	// global $wpdb;
	// $table_name = $wpdb->prefix . "custom_timesheet";
	// $table_name_person = $wpdb->prefix . "custom_person";
	// $persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	
	// $empty_dates_array = array();
	// foreach($persons as $person){		
		// $person_first_name = $person->person_first_name;
		// $person_fullname = $person->person_first_name ." ". $person->person_last_name;
		// foreach($date_range as $date){
			// $explode_date = explode('/', $date);
			// $day = $explode_date[0];
			// $month = $explode_date[1];
			// $year = $explode_date[2];
			// $date_format = $year."/".$month."/".$day;
			// $day_number = date('w', strtotime($date_format));					
			// if($day_number != 0 && $day_number != 6){
				// $timesheet_empty_days = $wpdb->get_results("SELECT * FROM {$table_name} WHERE task_person = '$person_fullname' AND date_now = '$date'");					
				// if($timesheet_empty_days == null){						
					// $empty_dates_array[] = $person_fullname ."_". $date;
				// }
			// }
		// }		
	// }
	
	// $empty_dates_new_array = array();
	// foreach($empty_dates_array as $empty_dates){
		// if($empty_dates_new_array != null){
			// $count = 0;
			// $existed = 0;
			// $previous_dates_explode = explode("_", $empty_dates);
			// foreach($empty_dates_new_array as $previous_date){
				// $newarrayexplode = explode("_", $previous_date);
				// if($previous_dates_explode[0] == $newarrayexplode[0]){
					// $empty_dates_new_array[$count] = $previous_date . ", " . $previous_dates_explode[1];					
					// $existed = 1;
					// break;
				// }
				// $count++;
			// }
			// if($existed == 0){
				// array_push($empty_dates_new_array, $empty_dates);
			// }
			// }else{
			// array_push($empty_dates_new_array, $empty_dates);
		// }
	// }
	// $empty_dates_admin = "";
	// foreach($empty_dates_new_array as $empty_name_dates){
		// $previous_dates_explode = explode("_", $empty_name_dates);
		// $person_name = $previous_dates_explode[0];
		// $empty_dates = $previous_dates_explode[1];
		// $empty_dates_explode = explode(',', $empty_name_dates);
		// $count_empty_dates = count($empty_dates_explode);
		
		// $fullname_explode = explode(" ",$person_name);
		// $name_count = count($fullname_explode);
		// if($name_count == 2){
			// $first_name = $fullname_explode[0];
			// $last_name = $fullname_explode[1];
			// }elseif($name_count == 3){
			// $first_name = $fullname_explode[0] ." ". $fullname_explode[1];
			// $last_name = $fullname_explode[2];
		// }
		
		// $person_info = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_first_name = '$first_name' AND person_last_name = '$last_name'");
		// $person_fullname = $person_info->person_first_name ." ". $person_info->person_last_name;		
		// $notification = $person_info->person_email_notification;
		// if($notification == 1){
			// if($person_fullname == $person_name){
				// $person_email = $person_info->person_email;				
				// if($person_email != null){
					// if($count_empty_dates == 1){						
						// $subject = 'Timesheet Reminder';
						// $message = 'Dear ' . $first_name .',<br/><br/> You have no hours reported for ' . $empty_dates . '. Please fill in your timesheet asap.<br/><br/> Thank you!';									
						// $headers[] = 'Content-Type: text/html; charset=UTF-8';
						// $headers[] = 'From: SEOweb Solutions <info@seowebsolutions.se>';						
						// wp_mail( $person_email, $subject, $message, $headers, '' );
						////////wp_mail('gray.gonzales@greecos.net', $subject, $message, $headers, '' );
						// }else{
						// $empty_dates_admin .= $empty_name_dates ."<br/>";
						// $subject = 'Timesheet Reminder';
						// $message = 'Dear ' . $first_name .',<br/><br/> You have no hours reported for ' . $empty_dates . '. Please fill in your timesheet asap.<br/><br/> Thank you!';									
						// $headers[] = 'Content-Type: text/html; charset=UTF-8';
						// $headers[] = 'From: SEOweb Solutions <info@seowebsolutions.se>';					
						// wp_mail( $person_email, $subject, $message, $headers, '' );					
						////////wp_mail('gray.gonzales@greecos.net', $subject, $message_admin, $headers, '' );
					// }
				// }
			// }		
		// }
	// }
	// if($empty_dates_admin != null){		
		// $subject = 'Timesheet Reminder';
		// $message_admin = "Dear Patrik,<br/><br/>The following person missed to fill in their timesheet:<br/><br/>". $empty_dates_admin ."<br/>";
		// $report_message = str_replace("_",": ",$message_admin);
		// $headers[] = 'Content-Type: text/html; charset=UTF-8';
		// $headers[] = 'From: SEOweb Solutions <info@seowebsolutions.se>';
		// wp_mail('patrik@seowebsolutions.se', $subject, $report_message, $headers, '' );
		// wp_mail('gray.gonzales@greecos.net', $subject, $report_message, $headers, '' );
	// }
}

function test_mail(){
	global $wpdb;
	$table_name_timesheet = $wpdb->prefix . "custom_timesheet";
	$table_name_person = $wpdb->prefix . "custom_person";
	$persons = $wpdb->get_results("SELECT * FROM {$table_name_person}");
	// $yesterday = date("Y-m-d", strtotime("yesterday"));
	$yesterday = date("Y-m-d", strtotime('tomorrow'));
	$week_start_date = date("Y-m-d", strtotime('monday this week'));
	$week_date_range = date_range($week_start_date, $yesterday);
	$week_empty_dates_array = array();	
	foreach($week_date_range as $date){
		$explode_date = explode('/', $date);
		$day = $explode_date[0];
		$month = $explode_date[1];
		$year = $explode_date[2];
		$date_format = $year."/".$month."/".$day;
		$day_number = date('w', strtotime($date_format));
		if($day_number != 0 && $day_number != 6){
			foreach($persons as $person){
				$person_fullname = $person->person_fullname;
				$person_time_track = $person->person_time_track;
				if($person_time_track == 1){
					$week_timesheet_empty_days = $wpdb->get_results("SELECT * FROM {$table_name_timesheet} WHERE task_person='$person_fullname' AND date_now = '$date'");			
					if($week_timesheet_empty_days == null){
						$week_empty_dates_array[$person_fullname][] = $date;
					}
				}
			}
		}	
	}
	if($week_empty_dates_array != null){
		$comma = '';
		$week_empty_date_message_array = array();
		foreach ($week_empty_dates_array as $task_person => $empty_dates){		
			foreach($empty_dates as $empty_date){
				if(!array_key_exists($task_person, $week_empty_date_message_array)){
					$week_empty_date_message_array[$task_person] = $empty_date;
					}else{
					$week_empty_date_message_array[$task_person] = $week_empty_date_message_array[$task_person] . ", " . $empty_date;
				}
			}
		}
	}
	$admin_email_message = "";
	if($week_empty_date_message_array != null){
		foreach($week_empty_date_message_array as $person_fullname => $week_empty_date_message ){
		 $admin_email_message .= '<p><strong>'. $person_fullname .': </strong>'. $week_empty_date_message .'</p>';
		 $person_details = $wpdb->get_row("SELECT * FROM {$table_name_person} WHERE person_fullname = '$person_fullname'");
		 $person_email = $person_details->person_email;
		 // print_var($person_email);
		} 
	}
	// print_var($admin_email_message);
	// if($admin_email_message != null){		
		// $admin_to = 'patrik@seowebsolutions.se';
		// $admin_subject = 'Timesheet Reminder';
		// $admin_message = "Dear Patrik,<br/><br/>The following person missed to fill in their timesheet:<br/><br/>". $admin_email_message ."<br/>";
		// $admin_headers = "MIME-Version: 1.0" . "\r\n";
		// $admin_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// $admin_headers .= 'From: SEOweb Solutions <info@seowebsolutions.se>' . "\r\n";
		// $admin_headers .= 'Cc: gray.gonzales@greecos.net' . "\r\n";
		
		// mail($admin_to, $admin_subject, $admin_message, $admin_headers);
	// }
	
	
}

function get_id_tag($tag, $attr, $value, $html ) {
	
	$attr = preg_quote($attr);
	$value = preg_quote($value);
	if($tag == 'h1'){
		$tag_regex = '/<'.$tag.'[^>]*'.$attr.'="'.$value.'">(.*?)<\\/'.$tag.'>/si';
		preg_match($tag_regex, $html, $matches);
		return $matches[1];
	}
	if($tag == 'link'){		
		// $tag_regex = '/<'.$tag.'[^>]*'.$attr.'="'.$value.'" href=(["\'])(.*?)\1.*$/';
		// $tag_regex = '/<'.$tag.'[^>]*'.$attr.'[\'"]"'.$value.'[\'"]?" href=[\'"]?(.+?)[\'"]';
		// $tag_regex = '/href=[\'"]?(.+?)[\'"]?.*?id=[\'"]?open-sans-css[\'"]?/si';		
		// $tag_regex = '/<\s*LINK[^>]HREF="(.*?)"\s?(.*?)>/i';		
		// $tag_regex = '#<link\s+href=[\'"]([^\'"]+)[\'"]\s*(?:id=[\'"]([^\'"]+)[\'"])?\s*>((?:(?!</a>).)*)</a>#i';
		
		// $result ='<link id="open-sans-css" href="http://example.jp/kigvlfa/index.php?type=1&amp;entryId=5">this is<b>REGEX</b> test<b> but</b> i stuck <b>...</b>';
		
		// preg_match('/<link id="open-sans-css" href="([^"]+)" >/', $result, $out);
		// print_Var($out);
		
		// foreach($html->find('link[id=open-sans-css]') as $a){
		  // print_var($a);
		// }

		
		
		// preg_match_all($tag_regex, $html, $matches);
		// preg_match($tag_regex1, $html, $matches1);
		// print_Var($tag_regex);
		// print_Var($matches);
		// print_Var($tag_regex1);
		// print_Var($matches1);
	}
}
/**
 * Add New service option function
 */
function add_new_service_option($option){
	global $wpdb;
	$table_services = $wpdb->prefix . "custom_service_options";

	//Check if the service name already on db.
	$check_string = $wpdb->get_row('SELECT *  FROM '.$table_services.' WHERE service_name="'.$option.'"');

	if($check_string == 1){
			$response = array(
				'status' => 'service-name-already-exist'
			);
	}else{
		$insert = $wpdb->insert( $table_services , array( 
			'service_name' => $option
		),
		array( '%s' ));

		if($insert == 1){
			$response = array(
				'new_service_option' => $option,
				'status' => 'save-new-service-option'
			);	
		}else{
			$response = array(
				'status' => 'failed-save-new-service-option'
			);
		}
	}

	return $response;
}
//Build Dropdown Options for "Default Project" , "Default Task" and "Hourly Rate" for Manage  Client page Editing.
function UpdateMangeClient($data_object){
	global $wpdb;

	$table_name_client = $wpdb->prefix . "custom_client";

	//Available variables on extract
	//$id
	//$type
	//$value - only use for hourly rate default value
	extract($data_object);

	//Get client info
	$client_info = $wpdb->get_row("SELECT * FROM {$table_name_client} WHERE ID = ". $id);

	//Build dropdown option for "Default Project".
 	if($type == 'project'){
 		$table_projects = $wpdb->prefix . "custom_project";
 		$projects = $wpdb->get_results("SELECT * FROM {$table_projects} WHERE project_client_id = ". $client_info->ID);

 		$project_html = '<select id="selected_id_'.$id.'" class="project">';
		foreach($projects as $project){
			//Select the Current Default Project
			$selected =  ($project->ID == $client_info->client_default_project)? 'selected' : '';
			$project_html .= '<option value="'.$project->project_name.'" '.$selected.'>'.$project->project_name. '</option>';
		}
		$project_html .= '</select>';
		$dropdown_html = array(
			'type' => $type,
			'option_dropdown' => $project_html,
			'id' => $id
		);
	//Build dropdown option for "Default Task".
 	}else if($type == 'task'){
 		$table_task = $wpdb->prefix . "custom_task";
 		$tasks = $wpdb->get_results("SELECT * FROM {$table_task}");

 		$task_html = '<select id="selected_id_'.$id.'" class="task">';
		foreach($tasks as $task){
			//Select the Current Default Task
			$selected =  ($task->ID == $client_info->client_default_task)? 'selected' : '';
			$task_html .= '<option value="'.$task->ID.'" '.$selected.'>'.$task->task_name. '</option>';
		}
		$task_html .= '</select>';
		$dropdown_html = array(
			'type' => $type,
			'option_dropdown' => $task_html,
			'id' => $id
		);
	//Build input box for "Hourly Rate".
 	}else if($type == 'hourly'){
 		$hourly_html = '<input id="selected_id_'.$id.'" class="hourly" value="'.$value.'"/>';
 		$dropdown_html = array(
			'type' => $type,
			'option_dropdown' => $hourly_html,
			'id' => $id
		);		
 	}

 	return $dropdown_html;
}
//Saving values for "Default Project" , "Default Task" and "Hourly Rate" for Manage  Client page Editing.
function UpdateMangeClientSave($data_object){
	global $wpdb;
	$table_name_client = $wpdb->prefix . "custom_client";
	
	extract($data_object);

	if($type == 'project'){
		$table_name_project= $wpdb->prefix . "custom_project";
		$projects = $wpdb->get_results("SELECT * FROM {$table_name_project} WHERE project_client_id = '" . $id . "'");

		foreach ($projects as $project) {
			if($value == $project->project_name){
				$default_id = $project->ID;
				$project_name = $project->project_name;
			}
		}

		$update_status = $wpdb->update( 
			$table_name_client, 
			array(
				'client_default_project' => $default_id
			), 
			array( 'ID' => $id ), 
			array( 
				'%s'
			)

		);
		$response = array(
				'status' => 'successfully-update-client-project',
				'type' => 'project',
				'id' => $id,
				'value' => $project_name
		);
	}else if($type == 'task'){
		$table_name_task= $wpdb->prefix . "custom_task";
		$task = $wpdb->get_row("SELECT * FROM {$table_name_task} WHERE ID = ". $value);
		$update_status = $wpdb->update( 
			$table_name_client, 
			array(
				'client_default_task' => $value
			), 
			array( 'ID' => $id ), 
			array( 
				'%s'
			)
		);
		$response = array(
				'status' => 'successfully-update-client-task',
				'type' => 'task',
				'id' => $id,
				'value' => $task->task_name
		);
	}else if($type == 'hourly'){
		$update_status = $wpdb->update( 
			$table_name_client, 
			array(
				'client_hourly_rate' => $value
			), 
			array( 'ID' => $id ), 
			array( 
				'%s'
			)
		);
		$response = array(
				'status' => 'successfully-update-client-hourly-rate',
				'type' => 'hourly',
				'id' => $id,
				'value' => $value
		);
	}
	return $response;
}
function DetailedTimeReportGetProjects($entry){
	global $wpdb;
	extract($entry);
	$table_client_name =  $wpdb->prefix . 'custom_client';
	$table_project_name = $wpdb->prefix . 'custom_project';
	$dropdown_html = '';

	//Get client ID and NAME from client table DB
	$client_info = $wpdb->get_row("SELECT ID, client_name FROM " . $table_client_name . " WHERE client_name = '" . $client_name . "'");
	//Get all projects related to client.
	$projects = $wpdb->get_results("SELECT project_name FROM " . $table_project_name . " WHERE project_client_id = '" . $client_info->ID . "'");

	//Build the select option for project
	$dropdown_html = '<select>';
	foreach($projects as $project){
		$select = ($project_current_selected == $project->project_name)? 'selected' : '';
		$dropdown_html .= '<option '.$select.'>'.$project->project_name.'</option>';
	}
	$dropdown_html .= '</select><div id="project_button_'.$id.'" class="detailed_time_update_project"></div>
<div id="project_loader_'.$id.'" class="row-update-loader-project" style="display: none; float: right;"></div>';

	$response = array(
		'option_dropdown' => $dropdown_html
	);
	return $response;
}
function DetailedTimeUpdateProject($entry){
	global $wpdb;
	extract($entry);
	$current_user = wp_get_current_user();
	$table_timesheet_name = $wpdb->prefix . 'custom_timesheet';

	$check_value = $wpdb->get_row("SELECT task_project_name FROM {$table_timesheet_name} WHERE ID = ".$project_id);

	$edited_by = $current_user->display_name . ' - ' . date("Y-m-d H:i");

	if((string)$check_value->task_project_name == (string)$project_name){
		$response = array(
			'project_id' => $project_id,
			'project_name' => $project_name,
			'status' => 'success-update-timesheet'
		);
	}else{
		//Updating to DB.
		$update_status = $wpdb->update( 
			$table_timesheet_name, 
			array( 
				'task_project_name' => $project_name,
				'edited_by' => $edited_by
			), 
			array( 'ID' => $project_id ), 
			array( 
				'%s'
			)
		);
		if($update_status == 1){
			$response = array(
				'project_id' => $project_id,
				'project_name' => $project_name,
				'edited_by' => $edited_by,
				'status' => 'success-update-timesheet'
			);
		}else{
			$response = array(
				'status' => 'failed-update-timesheet'
			);		
		}	
	}
	return $response;
}
function DetailedTimeEditTaskname($entry){
	global $wpdb;
	extract($entry);
	$table_client_name =  $wpdb->prefix . 'custom_client';
	$table_task_name = $wpdb->prefix . 'custom_task';
	$dropdown_html = '';
	$tasknames =  $wpdb->get_results("SELECT task_name FROM " . $table_task_name);
	$client_default_task = $wpdb->get_row("SELECT client_default_task FROM {$table_client_name} WHERE client_name ='". str_replace("&amp;","&",$client_name)."'");

	//Build the select option for project
	$dropdown_html = '<select>';
	foreach($tasknames as $taskname){
		// $select = ($taskname_current_selected == $taskname->task_name)? 'selected' : '';
		$select = ($client_default_task->client_default_task = $taskname->ID)? 'selected' : '';
		$dropdown_html .= '<option '.$select.'>'.$taskname->task_name.'</option>';
	}
	$dropdown_html .= '</select><div id="taskname_button_'.$id.'" class="check_update_detailed_time_taskname"></div><div class="loader" id="taskname_loader_'.$id.'" style="display:none;"></div>';

	$response = array(
		'option_dropdown' => $dropdown_html
	);

	return $response;
}

//Add Todo List
function AddTodoList($data){
	global $wpdb;
	$task_data = array();
	parse_str($data, $task_data);

	$checkboxes = array();
	$todolist_tablename = $wpdb->prefix . 'custom_client_todo_lists';
	$pieces = explode(",", $task_data['task_checkboxes']);

	foreach($pieces as $piece){
		array_push($checkboxes, array(trim($piece) => 0));
	}

	if($task_data['task_deadline'] == ''){
		$date = '00/00/0000';
	}else{
		$date = $task_data['task_deadline'];
	}

	//Loop on client ids
	foreach ($task_data['client_ids'] as $id) {
		$insert_data = $wpdb->insert( 
			$todolist_tablename, 
			array( 
				'taskname'		 	=> $task_data['taskname'], 
				'client_id'			=> $id,
				'consultant_id'		=> $task_data['task_consultant_id'],
				'priority'			=> $task_data['task_priority'],
				'status'			=> $task_data['task_status'],
				'descriptions' 		=> $task_data['task_description'],
				'deadline'  		=> date('Y-m-d', strtotime($date)),
				'task_checkboxes' 	=> serialize($checkboxes)
			), 
			array( 
				'%s', 
				'%d',
				'%d',
				'%s',
				'%s', 
				'%s',
				'%s',  
				'%s'
			) 
		);
	}

	if($insert == 1){
		$response = array(
			'status'		=>	'successfully-added-task'
		);
	}else{
		$response = array(
			'status'		=>	'failed-added-task'
		);
	}

	return $response;
	
}
function Get_TodoList_Info($id){
	global $wpdb;
	$searcharray= array();
	$client_tablename = $wpdb->prefix . "custom_client";
	$todolist_tablename = $wpdb->prefix . "custom_client_todo_lists";
	$consultant_tablename = $wpdb->prefix . "custom_person";

	$todolist_info = $wpdb->get_row('SELECT * FROM '.$todolist_tablename.' WHERE id = '. $id);

	$list_items = unserialize($todolist_info->task_checkboxes);
	$checklist = '';

	if(count($list_items) != 1){
		foreach($list_items as $item){
			$checked = (array_values($item)[0] == 1)? 'checked="checked"' : '';
			$checklist .= '<input name="todo_checklist[]" type="checkbox" '.$checked.' value="'.trim(array_keys($item)[0]).'">'.trim(array_keys($item)[0]).'<br />';
		}
	}else{
		$checklist = "<p>No subtasks</p>";
	}

	if($todolist_info->consultant_id != 0){
		$consultant_info = $wpdb->get_row("SELECT person_fullname FROM ".$consultant_tablename." WHERE wp_user_id = ". $todolist_info->consultant_id);
		$person_fullname = $consultant_info->person_fullname;
	}else{
		$person_fullname = 'Any';
	}
	$client_info = $wpdb->get_row("SELECT client_name FROM ".$client_tablename." WHERE ID = ". $todolist_info->client_id);

	$priorities = array('1 Urgent', '2 Asap', '3 Next visit');
	$priority_dropdown = '';

	foreach($priorities as $priority){
		if($priority == $todolist_info->priority){
			$selected = 'selected="selected"';
		}else{
			$selected = '';
		}
		$priority_dropdown .= '<option value="'.$priority.'" '.$selected.'>'.$priority.'</option>';
	}

	$statuses = array('Todo', 'Started', 'Completed');
	$status_dropdown = '';

	foreach($statuses as $status){
		if($status == $todolist_info->status){
			$selected = 'selected="selected"';
		}else{
			$selected = '';
		}
		$status_dropdown .= '<option value="'.$status.'" '.$selected.'>'.$status.'</option>';
	}

	$todolist_info->priority_dropdown = $priority_dropdown;
	$todolist_info->status_dropdown = $status_dropdown;
	$todolist_info->client_name = $client_info->client_name;
	$todolist_info->consultant_name = $person_fullname;
	$todolist_info->list = $checklist;

	return $todolist_info;
}
function SaveTodoListProgress($data){
	global $wpdb;
	$todolist_data = array();
	parse_str($data, $todolist_data);
	$todolist_tablename = $wpdb->prefix . "custom_client_todo_lists";

	$todolist_info = $wpdb->get_row('SELECT task_checkboxes FROM '.$todolist_tablename.' WHERE id = '. $todolist_data['todolist_id'] );

	$list = unserialize($todolist_info->task_checkboxes);
	$new_list = array();

	if($todolist_data['todo_checklist'] != ''){
		foreach($list as $item){
			if(in_array(trim(array_keys($item)[0]),$todolist_data['todo_checklist'])){
				array_push($new_list, array(trim(array_keys($item)[0]) => 1));
			 }else{
				array_push($new_list, array(trim(array_keys($item)[0]) => 0));
			}
		}
	}else{
		$new_list = $list;
	}

	$update_row = $wpdb->update(
		$todolist_tablename,
		array(
			'priority'				=>	$todolist_data['todolist_priority'],
			'status'				=>	$todolist_data['todolist_status'] ,
			'task_checkboxes'		=>	serialize($new_list)
		),
		array(
			'id'		=>	$todolist_data['todolist_id'] 
		),
		array(
			'%s',
			'%s',
			'%s'
		)
	);

	if($update_row == 1){
		$update_status = "success_update_todolist";
		$reponse = array(
			'update_status' 		=> 'success_update_todolist',
			'todolist_priority'		=> $todolist_data['todolist_priority'],
			'todolist_status'		=> $todolist_data['todolist_status'],
			'todolist_id'			=> $todolist_data['todolist_id']
		);
	}else{
		$reponse = array(
			'update_status' 		=> 'failed_update_todolist',
		);
	}
	return $reponse;
}
function DeleteTodoList($id){
	global $wpdb;
	$todolist_tablename = $wpdb->prefix . "custom_client_todo_lists";
	$query_result = $wpdb->delete( $todolist_tablename, array( 'id' => $id ), array( '%d' ) );
	if($query_result == 1){
		$response   = array(
			'status' 		=> 'delete-todolist-row',
			'id' 			=> $id
		);
	}else{
		$response   = array(
			'status' 		=> 'failed-delete-todolist-row'
		);
	}
	return $response;
}
function UpdateTodoListRowStatus($data){
	global $wpdb;
	extract($data);
	$todolist_tablename = $wpdb->prefix . "custom_client_todo_lists";

	$db_value = $wpdb->get_row('SELECT '. $type .' FROM '. $todolist_tablename .' WHERE id='.$id);	

	if($db_value->$type == $value){
		$update_row = 1;
	}else{
		$update_row = $wpdb->update(
			$todolist_tablename,
			array(
				$type		=>	$value
			),
			array(
				'id'		=>	$id 
			),
			array(
				'%s'
			)
		);
	}

	if($update_row == 1){
		$response   = array(
			'status' 		=> 'update-todolist-row',
			'id' 			=> $id,
			'value'			=> $value

		);
	}else{
		$response   = array(
			'status' 		=> 'failed-delete-todolist-row'
		);
	}
	return $response;

}
function ConsultantDropdownList($consultant_id){
	global $wpdb;
	$consultant_tablename = $wpdb->prefix . "custom_person";

	$consultants = $wpdb->get_results('SELECT wp_user_id, person_fullname, person_initial FROM '.$consultant_tablename);

	$dropdown_html = '<select name="default_consultant_id" id="default_consultant_id">';
	$dropdown_html .= '<option value="0">Any</option>';
	foreach($consultants as $consultant){
		$selected = ($consultant->wp_user_id == $consultant_id)? 'selected="selected"' : '';
		$dropdown_html .= '<option '.$selected.' value="'.$consultant->wp_user_id.'">'.$consultant->person_initial.'</option>';
	}
	$dropdown_html .= '</select><div class="update_todolist_row update_todolist_row_consultant"></div><div style="display: none;" class="row-update-loader pull-right"></div>';

	$response = array(
		'dropdown_consultant' => $dropdown_html 
	);
	return $response;
}
function UpdatingConsultantDefaultTodoList($data_object){
	global $wpdb;
	extract($data_object);
	$todolist_tablename = $wpdb->prefix . "custom_client_todo_lists";
	$consultant_tablename = $wpdb->prefix . "custom_person";

	if($consultant_id == 0){
		$wp_user_id = 0;
		$person_initial = 'Any';
	}else{
		$consultant_info = $wpdb->get_row('SELECT wp_user_id, person_fullname, person_initial FROM '.$consultant_tablename.' WHERE wp_user_id = '.$consultant_id);
		$person_initial = $consultant_info->person_initial;
		$wp_user_id = $consultant_info->wp_user_id;
	}
	$todolist_info = $wpdb->get_row('SELECT consultant_id FROM '.$todolist_tablename.' WHERE id = '.$row_id);
	
	//Prevent saving same value on DB
	if($todolist_info->consultant_id == $consultant_id){
			$response = array(
				'row_id' 			=> $row_id,
				'consultant_id'		=> $wp_user_id,
				'consultant_name'	=> $person_initial,
				'status'			=> 'successfullly-update-default-consultant'
			);
	}else{
		$update_row = $wpdb->update(
			$todolist_tablename,
			array(
				'consultant_id'		=>	$wp_user_id
			),
			array(
				'id'	=>	$row_id 
			),
			array(
				'%d'
			)
		);
		if($update_row == 1){
			if($consultant_id == 0){
				$response = array(
					'row_id' 			=> $row_id,
					'consultant_id'		=> $wp_user_id,
					'consultant_name'	=> $person_initial,
					'status'			=> 'successfullly-update-default-consultant'
				);	
			}else{
				$response = array(
					'row_id' 			=> $row_id,
					'consultant_id'		=> $wp_user_id,
					'consultant_name'	=> $person_initial,
					'status'			=> 'successfullly-update-default-consultant'
				);					
			}

		
		}else{
			$response = array(
				'status'			=> 'failed-update-default-consultant'
			);	
		}

	}
	return $response;

}
function UpdateTodoListDeadline($data){
	global $wpdb;
	extract($data);
	$todolist_tablename = $wpdb->prefix . "custom_client_todo_lists";

	$todolist_info = $wpdb->get_row('SELECT deadline FROM '.$todolist_tablename.' WHERE id = '.$row_id);

	if($deadline == $todolist_info->deadline){
		$response = array(
			'row_id' => $row_id,
			'deadline' => $deadline,
			'status'=> 'successfully-updating-dealine'
		);
	}else{
		if($deadline == ''){
			$deadline = '0000-00-00';
		}
		$update_row = $wpdb->update(
			$todolist_tablename,
			array(
				'deadline'		=>	date('Y-m-d', strtotime($deadline))
			),
			array(
				'id'	=>	$row_id 
			),
			array(
				'%s'
			)
		);
		if($update_row == 1){
			$response = array(
				'row_id' => $row_id,
				'deadline' => $deadline,
				'status'=> 'successfully-updating-dealine'
			);			
		}else{
		$response = array(
			'status'=> 'failed-updating-dealine'
		);
		}	
	}

	return $response;

}

function FilterTodoListTable($data){
	global $wpdb;
	$todolist_tablename = $wpdb->prefix . "custom_client_todo_lists";
	$consultant_tablename = $wpdb->prefix . "custom_person";
	$client_tablename = $wpdb->prefix . "custom_client";
	extract($data);

	$filter_array = array();

	if($client_id == 0){
		$filter_client = '';
	}else{
		$where = '';
		$filter_client .= ' todolist_tbl.client_id = '. $client_id;
		array_push($filter_array, $filter_client);
	}
	if($consultant_id == 0){
		$filter_consultant = '';
	}else{
		$filter_consultant .= $where.' todolist_tbl.consultant_id = '. $consultant_id;
		array_push($filter_array, $filter_consultant);
	}
	if($task_priority == 'Any'){
		$filter_priority = '';
	}else{
		$filter_priority .= ' todolist_tbl.priority = "'.$task_priority.'" AND consultant_tbl.wp_user_id is NULL';
		array_push($filter_array, $filter_priority);
	}
	if(count($filter_array) != 0){
		$filter = 'WHERE '. implode (" AND ", $filter_array);

	}else{
		$filter = '';
	}
	
	$query = 'SELECT 
			todolist_tbl.id,  
			todolist_tbl.taskname,
			todolist_tbl.consultant_id,  
			todolist_tbl.priority,
			todolist_tbl.status,
			todolist_tbl.descriptions,
			todolist_tbl.deadline,
			client_tbl.client_name,
			consultant_tbl.person_initial,
			consultant_tbl.person_fullname
				FROM '.$todolist_tablename.' as todolist_tbl 
				INNER JOIN '.$client_tablename.' as client_tbl
				ON todolist_tbl.client_id = client_tbl.ID
				LEFT OUTER JOIN '.$consultant_tablename.' as consultant_tbl
				ON todolist_tbl.consultant_id = consultant_tbl.wp_user_id
		'. $filter;
		// print_r($query);
		// die();

	$query_result = $wpdb->get_results($query);

	$html_rows = '';
	if(count($query_result) != 0){
		foreach($query_result as $item){
		$dateline = ($item->deadline == '0000-00-00' || $item->deadline == '1970-01-01')? '--' : $item->deadline;
		$consultant_initials = ($item->person_initial != '')?  $item->person_initial : 'Any';
		$html_rows .= '
			<tr id="'.$item->id.'">
				<td>'.$item->client_name.'</td>
				<td><span class="todolist_name_row">'.$item->taskname.'</span></td>
				<td><span class="todolist_consultant"><input class="consultant_id_row" value="'.$item->consultant_id.'" type="hidden">'.$consultant_initials.'</span></td>
				<td><span class="todolist_priority">'.$item->priority.'</span></td>
				<td><span class="todolist_status">'.$item->status.'</span></td>
				<td><span class="todolist_deadline">'.$dateline.'</span></td>
				<td>
					<div class="option-list">
						<i class="fa fa-trash-o delete_todolist_row pull-right" aria-hidden="true" title="Delete Task"></i>
						<i class="fa fa-eye view_list_button pull-right" aria-hidden="true" title="View Task"></i>
					</div>
				</td>
			</tr>';
		}	
	}else{
		$html_rows .= '
			<tr>
				<td colspan="6">No Currently List Available.</td>
			</tr>';		
	}

	$response = array(
		'list_data' => $html_rows
	);
	return $response;
}
function add_theme_scripts_fastselect() {
	wp_enqueue_style( 'style', get_template_directory_uri() . '/css/fastselect.css', array(), '1.1', 'all');
	wp_enqueue_script( 'script', get_template_directory_uri() . '/js/fastselect.standalone.min.js', array ( 'jquery' ), 1.1, true);
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts_fastselect' );
// load css into the login page
function add_font_awesome_icons() {
    wp_enqueue_style( 'mytheme-options-style', get_template_directory_uri() . '/css/font-awesome.min.css' ); 
}
add_action( 'wp_enqueue_scripts', 'add_font_awesome_icons' );
function IfDatePassed($date){
	$date_today = date('m/d/Y');
	if(new DateTime($date_today) < new DateTime($date)){
		$passed = 0;
	}else{
		$passed = 1;
	}
	return $passed;
}
function InvoiceClientService($id){
	// print_r($data);
	global $wpdb;
	$table_name_project = $wpdb->prefix . "custom_services";

	$query = $wpdb->prepare("SELECT * FROM {$table_name_project} WHERE id = %d", $id);

	$service_details = $wpdb->get_row($query);

	if($service_details->invoice_interval == '1M'){
		$add_date = "+1 month";
	}else if($service_details->invoice_interval == '3M'){
		$add_date = "+3 month";
	}else if($service_details->invoice_interval == '6M'){
		$add_date = "+6 month";
	}else if($service_details->invoice_interval == '1Y'){
		$add_date = "+1 year";
	}

	$current_date = strtotime($service_details->start_date);
	$new_invoice_date = date("m/d/Y", strtotime($add_date, $current_date));

	$update_status = $wpdb->update( 
			$table_name_project, 
			array( 
					'start_date' => $new_invoice_date 
			), 
			array( 
				'id' => $id 
			),
			array( '%s' ), 
			array( '%d' ) );

	if($update_status == 1){
		$response = array(
			'id' => $id,
			'new_invoice_date' => $new_invoice_date,
			'status' => 'successfully-updated-invoice-date'
		);
	}else{
		die('ERROR! UPDATE INVOICE DATE');
	}
	return $response;

}
function DeleteServiceOption($id){
	global $wpdb;
	$table_services_options = $wpdb->prefix . "custom_service_options";
	$delete_result = $wpdb->delete( $table_services_options , array( 'ID' => $id ), array( '%d' ) );

	if($delete_result == 1){
		$reponse = array(
			'service_id' => $id,
			'status' => 'successfully-deleted-options'
		);
	}else{
		die('FALED-DELETING-SERVICE-OPTION');
	}
	return $reponse;
}
//Load Team Member's Todolist on Timesheet page.
function LoadMemberTodoList($person){
	global $wpdb;
	$persons_tablename = $wpdb->prefix.'custom_person';
	$todolist_tablename = $wpdb->prefix.'custom_client_todo_lists';
	$clients_tablename = $wpdb->prefix.'custom_client';

	$todolist_html = "";

	//Get Person's User ID	
	$person_info = $wpdb->get_row('SELECT wp_user_id, person_initial FROM '. $persons_tablename .' WHERE person_fullname = "'. $person .'"');

	//Get Peron's TodoList
	$person_todolists = $wpdb->get_results('SELECT 
			todolist_tbl.id,  
			todolist_tbl.taskname, 
			todolist_tbl.client_id, 
			todolist_tbl.consultant_id,
			todolist_tbl.priority,
			todolist_tbl.status,
			todolist_tbl.descriptions,
			todolist_tbl.deadline,
			todolist_tbl.task_checkboxes,
			client_tbl.client_name					
			FROM '. $todolist_tablename . ' as todolist_tbl JOIN '. $clients_tablename .' as client_tbl
			ON todolist_tbl.client_id = client_tbl.ID 
			WHERE todolist_tbl.consultant_id = '. $person_info->wp_user_id .' OR todolist_tbl.consultant_id = 0
			');

	//Creating the HTML row by list
	foreach($person_todolists as $list){

		$date = ($list->deadline == '0000-00-00')? '--' : $list->deadline;

		if($list->consultant_id == 0){
			$any_person = 'Any';
			$user_id = 0;
		}else{
			$any_person = $person_info->person_initial;
			$user_id = $person_info->wp_user_id;
		}

		$todolist_html .= '';
		$todolist_html .= '
						<tr id="'.$list->id.'">
							<td>'. $list->client_name .'</td>
							<td><span class="todolist_name_row">'. $list->taskname .'</span></td>
							<td><span class="todolist_consultant"><input class="consultant_id_row" value="'.$user_id.'" type="hidden">'.$any_person.'</span></td>
							<td><span class="todolist_priority">'.$list->priority.'</span></td>
							<td><span class="todolist_status">'.$list->status.'</span></td>
							<td><span class="todolist_deadline">'.$date.'</span></td>
							<td>
								<div class="option-list">
								<i class="fa fa-trash-o delete_todolist_row pull-right" aria-hidden="true" title="Delete Task"></i>
								<i class="fa fa-eye view_list_button pull-right" aria-hidden="true" title="View Task"></i>
								</div>
							</td>
						</tr>
						';
	}
	return $todolist_html;
}
add_filter( 'wp_mail_from', function( $email ) {
	return get_bloginfo( 'admin_email');
});
?>