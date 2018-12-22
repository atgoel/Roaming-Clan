<?php
////////////////////////////////////////////////////////////////////////////////
// Global Define
////////////////////////////////////////////////////////////////////////////////
// do not change this, its for translation and options string
define('TEMPLATE_DOMAIN', 'mesocolumn');
// added option name
if( !defined('MESO_OPTION') ) { define('MESO_OPTION', 'meso'); }
if( !defined('SUPER_STYLE') ) { define('SUPER_STYLE', 'yes'); }
////////////////////////////////////////////////////////////////////////////////
// Additional Theme Support
////////////////////////////////////////////////////////////////////////////////

function mesocolumn_init_setup() {
if ( !isset( $content_width ) ) { $content_width = 550; }
////////////////////////////////////////////////////////////////////////////////
// Add Language Support
////////////////////////////////////////////////////////////////////////////////
load_theme_textdomain( 'mesocolumn', get_template_directory() . '/languages' );
add_theme_support( 'post-thumbnails' );
if( class_exists('woocommerce') ) { add_theme_support( 'woocommerce' ); }
add_theme_support( "title-tag" );
add_image_size( 'featured-slider-img', 640, 480, true );
add_image_size( 'featured-post-img', 480, 320, true );
// Add default posts and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );
add_editor_style();
add_theme_support( 'menus' );

register_nav_menus( array(
'top' => __( 'Top Menu', 'mesocolumn' ),
'primary' => __( 'Primary Menu', 'mesocolumn' ),
'footer' => __( 'Footer Menu', 'mesocolumn' ),
));

$custom_background_support = array(
	'default-color'          => '',
	'default-image'          => '',
	'wp-head-callback'       => '_custom_background_cb',
	'admin-head-callback'    => '',
	'admin-preview-callback' => ''
);
add_theme_support( 'custom-background', $custom_background_support );

// Add support for custom headers.
$custom_header_support = array(
// The default header text color.
		'default-text-color' => 'ffffff',
        'default-image' => '',
        'header-text'  => true,
		// The height and width of our custom header.
		'width' => 1440,
		'height' => '',
		// Support flexible heights.
		'flex-height' => true,
		// Random image rotation by default.
	   'random-default'	=> false,
		// Callback for styling the header.
		'wp-head-callback' => '',
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => '',
		// Callback used to display the header preview in the admin.
		'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $custom_header_support );
}
add_action( 'after_setup_theme', 'mesocolumn_init_setup' );

// add default callback for wp_pages
function mesocolumn_revert_wp_menu_page($args) {
global $bp, $bp_active;
$pages_args = array('depth' => 0,'echo' => false,'exclude' => '','title_li' => '');
$menu = wp_page_menu( $pages_args );
$menu = str_replace( array( '<div class="menu"><ul>', '</ul></div>' ), array( '<ul class="sf-menu">', '</ul>' ), $menu );
echo $menu;
if($bp_active=='true'):
do_action( 'bp_nav_items' );
endif; ?>
<?php }

// add default callback for wp_list_categories
function mesocolumn_revert_wp_menu_cat() {
global $bp;
$menu = wp_list_categories('orderby=name&show_count=0&title_li=');
return $menu;
 ?>
<?php }

// add home link in custom menus
function mesocolumn_dtheme_page_menu_args( $args ) {
$args['show_home'] = __('Home', 'mesocolumn');
return $args; }
add_filter( 'wp_page_menu_args', 'mesocolumn_dtheme_page_menu_args' );


///////////////////////////////////////////////////////////////////////////////
// Check if BuddyPress is installed
//////////////////////////////////////////////////////////////////////////////
if ( function_exists( 'bp_is_active' ) ) {
global $blog_id, $current_blog;
if ( is_multisite() ) {
//check if multiblog
if ( defined( 'BP_ENABLE_MULTIBLOG' ) && BP_ENABLE_MULTIBLOG ) {
$bp_active = 'true';
} else if ( defined( 'BP_ROOT_BLOG' ) && BP_ROOT_BLOG == $current_blog->blog_id ) {
$bp_active = 'true';
}
else if ( defined( 'BP_ROOT_BLOG' ) && ( $blog_id != 1 ) ) {
$bp_active = 'false';
}
} else {
$bp_active = 'true';
}
}
else {
$bp_active = 'false';
}


///////////////////////////////////////////////////////////////////////////////
// Check if BBPress installed and if in bbpress forum page
//////////////////////////////////////////////////////////////////////////////
if ( class_exists( 'bbPress' ) ) :
function mesocolumn_check_bpress_init() {
global $in_bbpress;
$forum_root_slug = get_option('_bbp_forum_slug');
$topic_root_slug = get_option('_bbp_topic_slug');
$reply_root_slug = get_option('_bbp_reply_slug');
$tag_root_slug = get_option('_bbp_tag_slug');
if( get_post_type() == 'forum' || is_page('forums') || is_page('support') || get_post_type() == $forum_root_slug ||
get_post_type() == $topic_root_slug || get_post_type() == $reply_root_slug || get_post_type() == $tag_root_slug ) {
$in_bbpress = 'true';
}
//echo $in_bbpress;
}
add_action('wp_head','mesocolumn_check_bpress_init');
endif;


function mesocolumn_theme_custom_style_init() {
global $theme_version,$is_IE,$bp_active;
if($is_IE): ?>
<style type="text/css">
#main-navigation,.post-meta,a.button,input[type='button'], input[type='submit'],h1.post-title,.wp-pagenavi a,#sidebar .item-options,.iegradient,h3.widget-title,.footer-bottom,.sf-menu .current_page_item a, .sf-menu .current_menu_item a, .sf-menu .current-menu-item a,.sf-menu .current_page_item a:hover, .sf-menu .current_menu_item a:hover, .sf-menu .current-menu-item a:hover {filter: none !important;} #buddypress .activity-list .activity-avatar {float: none !important;}
</style>
<?php endif; ?>
<?php print "<style type='text/css' media='all'>"; ?>
<?php get_template_part ( '/lib/options/options-css' ); ?>
<?php
$header_textcolor = get_theme_mod('header_textcolor');
if( get_header_image() && $header_textcolor == 'blank') { ?>
#custom #siteinfo h1,#custom #siteinfo div, #custom #siteinfo p {display:none;}
<?php }
if( get_header_image() && $header_textcolor != '' ): ?>
#custom #siteinfo a {color: #<?php echo $header_textcolor; ?> !important;text-decoration: none;}
#custom #siteinfo p#site-description {color: #<?php echo $header_textcolor; ?> !important;text-decoration: none;}
<?php endif; ?>
<?php
$header_overlay = get_theme_mod('custom_header_overlay');
if( get_header_image() && $header_overlay == 'Yes' ): ?>
#siteinfo {position:absolute;top:15%;left:2em;}
#topbanner {position:absolute;top:15%;right:2em;}
#custom #custom-img-header {margin:0;}
<?php endif; ?>

<?php $breadcrumb_on = get_theme_option('breadcrumbs_on');
if($breadcrumb_on != 'Enable'): ?>
.content, #right-sidebar {}
<?php endif; ?>

<?php
$feat_size = get_theme_option('feat_img_size');
if($feat_size == ''){ $feat_size = 'thumbnail'; }
$thumb_w = get_option($feat_size.'_size_w');
$thumb_h = get_option($feat_size.'_size_h');
?>

<?php if($feat_size != 'large'){ ?>
#post-entry div.post-thumb.size-<?php echo $feat_size; ?> {float:left;width:<?php echo $thumb_w; ?>px;}
#post-entry article .post-right {margin:0 0 0 <?php echo $thumb_w + 20; ?>px;}
<?php } else { ?>
#post-entry div.post-thumb {margin:0 0 1em;width:100%;}
#post-entry article .post-right {width:100%;float:left;margin:0;}
<?php } ?>

<?php
$get_feat_layout = get_theme_option('feat_layout');
if( $get_feat_layout == 'all thumbnail' ) { ?>
#post-entry aside.home-feat-cat .fpost {padding:0;}
#post-entry aside.home-feat-cat .fpost .feat-right {margin: 0em 0em 0em 140px;}
#post-entry aside.home-feat-cat .fpost .feat-thumb {width: 125px;}
#post-entry aside.home-feat-cat .fpost .entry-content {font-size:1.1em;line-height: 1.5em !important;}
#post-entry aside.home-feat-cat .fpost .feat-title {font-size:1.35em;margin:0;}
#post-entry aside.home-feat-cat .fpost .feat_comment {display:none;}
<?php } elseif($get_feat_layout == 'all medium') { ?>
#post-entry aside.home-feat-cat .apost .feat-right {margin: 0;}
#post-entry aside.home-feat-cat .apost .feat-thumb {width: 100%;}
#post-entry aside.home-feat-cat .apost .entry-content {font-size:1.25em;}
#post-entry aside.home-feat-cat .apost .feat-title {font-size:1.65em;margin:12px 0 8px !important;}
#custom #post-entry aside.home-feat-cat .apost {padding:0 0 2em !important;margin:0 0 2em !important;}
@media only screen and (min-width:300px) and (max-width:770px){
#post-entry aside.home-feat-cat .apost .feat-thumb {height:auto;max-height:1000px;} }
<?php } ?>

<?php do_action('meso_custom_style_init'); ?>

<?php if( get_theme_option('custom_css', 'css') ): ?>
<?php echo get_theme_option('custom_css', 'css'); ?>
<?php endif; ?>
<?php print "</style>"; ?>
<?php }
add_action('wp_head','mesocolumn_theme_custom_style_init');


///////////////////////////////////////////////////////////////////////////////
// Load Theme Styles and Javascripts
///////////////////////////////////////////////////////////////////////////////
/*---------------------------load google webfont style--------------------------------------*/
function mesocolumn_theme_load_gwf_styles() {
if( get_theme_option('body_font') == 'Choose a font' || get_theme_option('body_font') == '') {
wp_register_style('default_gwf', 'http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,300,300italic');
wp_enqueue_style( 'default_gwf');
}
}
add_action('wp_enqueue_scripts', 'mesocolumn_theme_load_gwf_styles');

/*---------------------------load styles--------------------------------------*/
function mesocolumn_theme_load_styles() {
global $theme_version,$is_IE,$bp_active;
$responsive_mode = get_theme_option('responsive_mode');

if ( $responsive_mode == 'Enable' ) {
wp_enqueue_style( 'style-responsive', get_template_directory_uri() . '/responsive.css', array(), $theme_version );
}

if ( function_exists('is_rtl') && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
wp_enqueue_style( 'style-rtl', get_template_directory_uri() . '/rtl.css', array(), $theme_version );
}

if ( class_exists('woocommerce') && get_theme_option('custom_shop') == 'Enable' ) {
if( file_exists( get_template_directory() . '/lib/woocommerce/woocommerce-theme-css.css' ) ):

wp_enqueue_style( 'custom-woo-css', get_template_directory_uri() . '/lib/woocommerce/woocommerce-theme-css.css', array(), $theme_version );

endif;
}

if ( class_exists('jigoshop') && get_theme_option('custom_shop') == 'Enable' ) {
if( file_exists( get_template_directory() . '/lib/jigoshop/jigoshop-theme-css.css' ) ):
wp_enqueue_style( 'custom-jigoshop-css', get_template_directory_uri() . '/lib/jigoshop/jigoshop-theme-css.css', array(), $theme_version );
endif;
}


if($bp_active=='true'):
/* activate buddypress css */
if( file_exists( get_template_directory() . '/lib/buddypress/bp-css.css' ) ):
wp_enqueue_style( 'bp-css', get_template_directory_uri() . '/lib/buddypress/bp-css.css', array(), $theme_version );
endif;
endif;


wp_enqueue_style( 'superfish', get_template_directory_uri(). '/lib/scripts/superfish-menu/css/superfish.css', array(), $theme_version );

if ( is_active_sidebar( 'tabbed-sidebar' ) ) {
wp_enqueue_style( 'tabber', get_template_directory_uri() . '/lib/scripts/tabber/tabber.css', array(), $theme_version );
}

if ( ( is_home() || is_front_page() || is_page_template('page-templates/template-blog.php') ) && get_theme_option('slider_on') == 'Enable'  ) {
wp_enqueue_style( 'jd-gallery-css', get_template_directory_uri(). '/lib/scripts/jd-gallery/jd.gallery.css', array(), $theme_version );
}

/*load font awesome */
wp_enqueue_style( 'font-awesome-cdn', get_template_directory_uri(). '/lib/scripts/font-awesome/css/font-awesome.css', array(), $theme_version );

?>

<?php
}
add_action( 'wp_enqueue_scripts', 'mesocolumn_theme_load_styles' );


/*---------------------------load js scripts--------------------------------------*/
function mesocolumn_theme_load_scripts() {
global $theme_version, $is_IE;
wp_enqueue_script("jquery");
wp_enqueue_script('hoverIntent');

wp_enqueue_script('modernizr', get_template_directory_uri() . '/lib/scripts/modernizr/modernizr.js', false, $theme_version, true );

if($is_IE) {
wp_enqueue_script('html5shim', get_template_directory_uri() . '/lib/scripts/html5shiv.js', false,$theme_version, false );
}

if ( is_active_sidebar( 'tabbed-sidebar' ) ) {
wp_enqueue_script( 'tabber', get_template_directory_uri() . '/lib/scripts/tabber/tabber.js', false, $theme_version, true );
}

wp_enqueue_script('superfish-js', get_template_directory_uri() . '/lib/scripts/superfish-menu/js/superfish.js', false, $theme_version, true );
wp_enqueue_script('supersub-js', get_template_directory_uri() . '/lib/scripts/superfish-menu/js/supersubs.js', false, $theme_version, true );

if ( ( is_home() || is_front_page() || is_page_template('page-templates/template-blog.php') ) && get_theme_option('slider_on') == 'Enable' ) {
wp_enqueue_script('mootools-js', get_template_directory_uri(). '/lib/scripts/jd-gallery/mootools.v1.11.js', false, $theme_version, true );
wp_enqueue_script('jd-gallery2-js', get_template_directory_uri(). '/lib/scripts/jd-gallery/jd.gallery.v2.js', false, $theme_version, true );
wp_enqueue_script('jd-gallery-set-js', get_template_directory_uri(). '/lib/scripts/jd-gallery/jd.gallery.set.js', false, $theme_version, true );
wp_enqueue_script('jd-gallery-transitions-js', get_template_directory_uri(). '/lib/scripts/jd-gallery/jd.gallery.transitions.js', false, $theme_version, true );
}
wp_enqueue_script('custom-js', get_template_directory_uri() . '/lib/scripts/custom.js', false,$theme_version, true );
if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php }
add_action( 'wp_enqueue_scripts', 'mesocolumn_theme_load_scripts' );

/* prior to mesocolumn theme custom.css */
function check_if_custom_css_exists() {
if( file_exists( get_template_directory() . '/custom.css') || file_exists( get_stylesheet_directory() . '/custom.css') ):
printf( __('<div class="error"><p>Custom.css found in your theme, please copy paste your <a href="%1$s">custom.css</a> content into wp-admin->appeareance->custom css and then delete/moved the custom.css file.</p></div>', 'mesocolumn'), admin_url('/theme-editor.php?file=custom.css&theme=mesocolumn') );
endif;
}
add_action('admin_notices', 'check_if_custom_css_exists', 10);


function check_if_option_db_updated() {
$check_themecleanup = get_option('tn_mesocolumn_body_font');
if( $check_themecleanup ) {
printf( __('<div class="error"><p>Theme Options database need to update! resave your theme options, category color, page color and custom css options one by one</p></div>', 'mesocolumn') );
}
}
add_action('admin_notices', 'check_if_option_db_updated', 10);


////////////////////////////////////////////////////////////////////////////////
// Add Theme Functions for parent and child theme compability
////////////////////////////////////////////////////////////////////////////////
/* check parent and child theme for theme-functions.php */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/theme-functions.php' ) ):
include( get_stylesheet_directory() . '/lib/functions/theme-functions.php' );
else:
include( get_template_directory() . '/lib/functions/theme-functions.php' );
endif;

/* check parent and child theme for option-functions.php */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/option-functions.php' ) ):
include( get_stylesheet_directory() . '/lib/functions/option-functions.php' );
else:
include( get_template_directory() . '/lib/functions/option-functions.php' );
endif;

/* check parent and child theme for option-functions.php */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/custom-header-functions.php' ) ):
include( get_stylesheet_directory() . '/lib/functions/custom-header-functions.php' );
else:
include( get_template_directory() . '/lib/functions/custom-header-functions.php' );
endif;


/* check parent and child theme for widget-functions.php */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/widget-functions.php' ) ):
include( get_stylesheet_directory() . '/lib/functions/widget-functions.php' );
else:
include( get_template_directory() . '/lib/functions/widget-functions.php' );
endif;

/* check parent and child theme for bp-widgets-functions.php */
if($bp_active=='true'):
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/buddypress/bp-widgets-functions.php' ) ):
include( get_stylesheet_directory() . '/lib/buddypress/bp-widgets-functions.php' );
else:
if( file_exists( get_template_directory() . '/lib/buddypress/bp-widgets-functions.php' ) ):
include( get_template_directory() . '/lib/buddypress/bp-widgets-functions.php' );
endif;
endif;
endif;

/* check parent and child theme for bbpress-theme-functions.php */
if ( class_exists('bbPress') ):
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/bbpress/bbpress-theme-functions.php' ) ):
include( get_stylesheet_directory() . '/lib/bbpress/bbpress-theme-functions.php' );
else:
if( file_exists( get_template_directory() . '/lib/bbpress/bbpress-theme-functions.php' ) ):
include( get_template_directory() . '/lib/bbpress/bbpress-theme-functions.php' );
endif;
endif;
endif;


/* check parent and child theme for woocommerce-theme-functions.php */
if ( class_exists('woocommerce') ) :
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-theme-functions.php' ) ):
include( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-theme-functions.php' );
else:
if ( file_exists( get_template_directory() . '/lib/woocommerce/woocommerce-theme-functions.php' ) ):
include( get_template_directory() . '/lib/woocommerce/woocommerce-theme-functions.php' );
endif;
endif;
endif;


/* check parent and child theme for jigoshop-theme-functions.php */
if ( class_exists('jigoshop') ) :
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/jigoshop/jigoshop-theme-functions.php' ) ):
include( get_stylesheet_directory() . '/lib/jigoshop/jigoshop-theme-functions.php' );
else:
if ( file_exists( get_template_directory() . '/lib/jigoshop/jigoshop-theme-functions.php' ) ):
include( get_template_directory() . '/lib/jigoshop/jigoshop-theme-functions.php' );
endif;
endif;
endif;


/* check parent and child theme for hooks-functions.php */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/hooks-functions.php' ) ):
include( get_stylesheet_directory() . '/lib/functions/hooks-functions.php' );
else:
if ( file_exists( get_template_directory() . '/lib/functions/hooks-functions.php' ) ):
include( get_template_directory() . '/lib/functions/hooks-functions.php' );
endif;
endif;



/* check if custom function file is active */
if( file_exists( WP_CONTENT_DIR . '/meso-custom-functions.php' ) ) {
include_once( WP_CONTENT_DIR . '/meso-custom-functions.php' );
}

?>