<?php
/*--------------------------------------------
Description: add custom image header location
---------------------------------------------*/
function mesocolumn_cih_loc() {
$header_overlay = get_theme_mod('custom_header_overlay');
if( get_header_image() && $header_overlay == 'No' ) {
echo '<div id="custom-img-header"><img src="'. get_header_image() . '" alt="' . get_bloginfo('name') . '" /></div>';
}
}
add_action('bp_after_main_nav','mesocolumn_cih_loc');

function mesocolumn_cih_overlay() {
$header_overlay = get_theme_mod('custom_header_overlay');
if( get_header_image() && $header_overlay == 'Yes' ) {
echo '<div id="custom-img-header"><img src="'. get_header_image() . '" alt="' . get_bloginfo('name') . '" /></div>';
}
}
add_action('bp_inside_header','mesocolumn_cih_overlay');


/*--------------------------------------------
Description: add mobile menu in navigation
---------------------------------------------*/
function mesocolumn_add_mobile_menu_nav() { ?>
<div id="mobile-nav">
<?php if ( has_nav_menu( 'top' ) ) {  ?>
<p class="select-pri"><?php _e('Select Page:', 'mesocolumn'); ?> <?php dez_get_mobile_navigation( $type='top', $nav_name="top" ); ?></p>
<?php } ?>
<?php if ( has_nav_menu( 'primary' ) ) {  ?>
<p class="select-pri sec"><?php _e('Select Category:', 'mesocolumn'); ?> <?php dez_get_mobile_navigation( $type='main', $nav_name="primary" ); ?></p>
<?php } ?>
</div>
<?php }
add_action('bp_inside_top_nav','mesocolumn_add_mobile_menu_nav');


/*--------------------------------------------
Description: add sub category in paren category
---------------------------------------------*/
function mesocolumn_add_subcat() {
if( get_theme_option('allow_subcat') == 'Enable' && is_category() ) {
$in_category = get_category( get_query_var( 'cat' ) );
$cat_id = $in_category->cat_ID;
$this_category = wp_list_categories('show_option_none=&orderby=id&depth=5&show_count=0&title_li=&use_desc_for_title=1&child_of='.$cat_id."&echo=0");
if($this_category) {
echo '<ul class="subcat sub_tn_cat_color_'. $cat_id . '">'. $this_category . '</ul>';
}
}
}
add_action('bp_after_main_nav','mesocolumn_add_subcat');


/*--------------------------------------------
Description: add featured slider
---------------------------------------------*/
remove_action('bp_before_blog_home','dez_add_slider_frontpage');
function mesocolumn_add_featured_slider() {
if('page' == get_option( 'show_on_front' )) {
$paged = get_query_var( 'page' );
} else {
$paged = get_query_var( 'paged' );
}
if( ( is_home() || is_front_page() || is_page_template('page-templates/template-blog.php')) && get_theme_option('slider_on') == 'Enable') {
if ( !$paged ) {
get_template_part( 'lib/sliders/jd-gallery-slider' );
}
}
}
add_action('bp_before_blog_entry','mesocolumn_add_featured_slider');



/*--------------------------------------------
Description: add archive header
---------------------------------------------*/
function mesocolumn_add_archive_header() {
$archive_headline = get_theme_option('archive_headline');
if( ( is_archive() || is_search() ) && $archive_headline != 'Disable') {
get_template_part( 'lib/templates/headline' );
}
}
add_action('bp_before_blog_entry','mesocolumn_add_archive_header');


/*--------------------------------------------
Description: add ads in post loop
---------------------------------------------*/
function mesocolumn_add_ads_post_loop() {
global $postcount;
$get_ads_code_one = get_theme_option('ads_code_one');
$get_ads_code_two = get_theme_option('ads_code_two');
if( !is_single() ) {
if( $get_ads_code_one == '' && $get_ads_code_two == '') {
} else {
if( 2 == $postcount ){
echo '<div class="adsense-post">';
echo stripcslashes(do_shortcode($get_ads_code_one));
echo '</div>';
} elseif( 4 == $postcount ){
echo '<div class="adsense-post">';
echo stripcslashes(do_shortcode($get_ads_code_two));
echo '</div>';
}
}
}
}
add_action('bp_after_blog_post','mesocolumn_add_ads_post_loop');


/*--------------------------------------------
Description: add ads in home feat block one
---------------------------------------------*/
function mesocolumn_add_ads_home_feat() {
$get_ads_code_one = get_theme_option('ads_code_one');
if( $get_ads_code_one != '') {
echo '<div class="adsense-post adsense-home">';
echo stripcslashes(do_shortcode($get_ads_code_one));
echo '</div>';
echo '<br />';
}
}
add_action('bp_home_feat_block_one','mesocolumn_add_ads_home_feat');


/*--------------------------------------------
Description: add ads in home feat block two
---------------------------------------------*/
function mesocolumn_add_ads_home_feat_two() {
$get_ads_code_two = get_theme_option('ads_code_two');
if( $get_ads_code_two != '') {
echo '<div class="adsense-post adsense-home">';
echo stripcslashes(do_shortcode($get_ads_code_two));
echo '</div>';
echo '<br />';
}
}
add_action('bp_home_feat_block_two','mesocolumn_add_ads_home_feat_two');


/*--------------------------------------------
Description: Author Footer Credits
---------------------------------------------*/
function meso_author_footer_credit() {
if( get_theme_option('footer_credit') != 'Disable') {
$paged = get_query_var( 'paged' );
if( (is_home() || is_front_page()) && !$paged ){
$author_link = '<a target="_blank" href="http://www.dezzain.com/wordpress-themes/mesocolumn/">Mesocolumn</a>';
printf( __( '%s Theme by Dezzain', 'mesocolumn' ), $author_link );
} else {
$author_link = 'Mesocolumn';
printf( __( '%s Theme by Dezzain', 'mesocolumn' ), $author_link );
}
} else {
echo '<!-- Mesocolumn Theme by Dezzain, download and info at https://wordpress.org/themes/mesocolumn -->';
}
}
add_action('bp_footer_right','meso_author_footer_credit');


/*--------------------------------------------
Description: layout load filter
---------------------------------------------*/
function meso_feat_set_thumbnail() {
$feat_thumb = dez_get_featured_post_image('<div class="feat-thumb"><a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">','</a></div>',120, 120, 'alignleft','thumbnail',dez_get_singular_cat('false'),the_title_attribute('echo=0'), false);
return $feat_thumb;
}

function meso_feat_set_fpostimg() {
$feat_thumb = dez_get_featured_post_image('<div class="feat-thumb"><a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">','</a></div>',480, 200, 'alignleft','featured-post-img',dez_get_singular_cat('false'),the_title_attribute('echo=0'), false);
return $feat_thumb;
}

function meso_feat_set_full() {
$feat_thumb = dez_get_featured_post_image('<div class="feat-thumb"><a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">','</a></div>','', '', 'alignleft','large',dez_get_singular_cat('false'),the_title_attribute('echo=0'), false);
return $feat_thumb;
}

function mesocolumn_layout_load() {
$get_feat_layout = get_theme_option('feat_layout');
if($get_feat_layout == 'all thumbnail') {
add_filter('meso_top_feat_thumb','meso_feat_set_thumbnail');
} elseif($get_feat_layout == 'all medium') {
add_filter('meso_bottom_feat_thumb','meso_feat_set_fpostimg');
}
}
add_action('wp_head','mesocolumn_layout_load');




/*--------------------------------------------
Description: add schema for post
---------------------------------------------*/
if( !function_exists('meso_out_custom_excerpt') ) {
function meso_out_custom_excerpt($text,$limit) {
global $post;
$output = strip_tags($text);
$output = strip_shortcodes($output);
$output = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $output );
$output = str_replace( '"', "'", $output);
$output = explode(' ', $output, $limit);
if (count($output)>=$limit) {
array_pop($output);
$output = implode(" ",$output).'...';
} else {
$output = implode(" ",$output);
}
return trim($output);
}
}

if(!function_exists('meso_get_user_role')) {
function meso_get_user_role($id) {
$user = new WP_User( $id );
if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
foreach ( $user->roles as $role )
return ucfirst($role);
} else {
return 'User';
}
}
}

function meso_add_itemtype_header() { echo ' itemscope itemtype="http://schema.org/WPHeader"'; }
function meso_add_itemtype_nav() { echo ' itemscope itemtype="http://schema.org/SiteNavigationElement"'; }
function meso_add_itemtype_sidebar() { echo ' itemscope itemtype="http://schema.org/WPSideBar"'; }
function meso_add_itemtype_footer() { echo ' itemscope itemtype="http://schema.org/WPFooter"'; }
function meso_add_itemtype_article() { echo ' itemscope="" itemtype="http://schema.org/Article"'; }
function meso_add_itemtype_post_title() { echo ' itemprop="name headline"'; }
function meso_add_itemtype_post_content() { echo ' itemprop="articleBody"'; }

function meso_add_custom_schema($content) {
global $post,$aioseop_options;
if( is_single() ) {
$post_aioseo_title = get_post_meta($post->ID, '_aioseop_title', true);
$author_id = get_the_author_meta('ID');
$author_email = get_the_author_meta('user_email');
$author_displayname = get_the_author_meta('display_name');
$author_nickname = get_the_author_meta('nickname');
$author_firstname = get_the_author_meta('first_name');
$author_lastname = get_the_author_meta('last_name');
$author_url = get_the_author_meta('user_url');
$author_status = get_the_author_meta('user_level');
$author_description = get_the_author_meta('user_description');
$author_role = meso_get_user_role($author_id);
$author_googleplus_profile = '';

// get post thumbnail
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "thumbnail" );
$large_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "large" );
$schema = '';
?>
<?php
$schema .=  '<!-- start data:schema --><span class="post-schema">';
$schema .= '<a itemprop="url" href="'. get_permalink() . '" rel="bookmark" title="' . the_title_attribute('echo=0') . ' ">' . get_permalink() . '</a>';

if($post_aioseo_title):
$schema .= '<span itemprop="alternativeHeadline">' . $post_aioseo_title . '</span>';
endif;

if($large_src):
$schema .= '<span itemprop="image">' . $large_src[0] . '</span>';
endif;
if($thumbnail_src):
$schema .= '<span itemprop="thumbnailUrl">' . $thumbnail_src[0] . '</span>';
endif;
$getmodtime = get_the_modified_time();
if( $getmodtime > get_the_time() ) {
$modtime = get_the_modified_time('c');
} else {
$modtime = get_the_time('c');
}
$schema .= '<time datetime="'.get_the_time('Y-m-d') . '" itemprop="datePublished"><span class="date updated">'. $modtime . '</span></time><span class="vcard author"><span class="fn">'.get_the_author().'</span></span>';
$categories = get_the_category();
$separator = ', ';
$output = '';
if($categories){
foreach($categories as $category) {
$schema .= '<span itemprop="articleSection">' . $category->cat_name . '</span>';
}
}
$posttags = get_the_tags();
$post_tags_list = '';
if ($posttags) {
$schema .= '<span itemprop="keywords">';
foreach($posttags as $tag) {
$post_tags_list .= $tag->name . ',';
}
$schema .= substr( $post_tags_list,0,-1 );
$schema .= '</span>';
}
$schema .= '<div itemprop="description">'. meso_out_custom_excerpt(get_the_content(),50) .'</div>';
$schema .= '<span itemprop="author" itemscope="" itemtype="http://schema.org/Person">';
if($author_googleplus_profile):
$schema .= '<span itemprop="name">'.$author_displayname.'</span><a href="'. $author_googleplus_profile. '?rel=author" itemprop="url">'. $author_googleplus_profile . '</a>';
endif;
$schema .= '<span itemprop="givenName">'.$author_firstname.'</span>
<span itemprop="familyName">'.$author_lastname.'</span><span itemprop="email">'.$author_email . '</span><span itemprop="jobTitle">'. $author_role . '</span>';
if($author_description):
$schema .= '<span itemprop="knows">'.stripcslashes($author_description).'</span>';
endif;
$schema .= '<span itemprop="brand">'. get_bloginfo('name').'</span>';
$schema .= '</span>';
$schema .= '</span><!-- end data:schema -->';
return $content . $schema;
} else {
return $content;
}
}

function meso_init_schema_features() {
/* check if schema is on */
$schema_on = '';
$schema_on = get_theme_option('schema_on');
/* if another plugin schema is active */
if( function_exists('sj_add_google_author_schema') && get_option('sj_gplus_schema') == 'Enable' ) {
} else {
if( $schema_on == 'Enable' ) {
add_filter('the_content', 'meso_add_custom_schema');
add_action('bp_article_start','meso_add_itemtype_article');
add_action('bp_article_post_title','meso_add_itemtype_post_title');
add_action('bp_article_post_content','meso_add_itemtype_post_content');
add_action('bp_section_header','meso_add_itemtype_header');
add_action('bp_section_nav','meso_add_itemtype_nav');
add_action('bp_section_sidebar','meso_add_itemtype_sidebar');
add_action('bp_section_footer','meso_add_itemtype_footer');
}
}
}
add_action('wp_head','meso_init_schema_features');



?>