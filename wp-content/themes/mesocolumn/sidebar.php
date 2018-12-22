<?php
global $in_bbpress, $bp_active;
if( $bp_active == 'true' && function_exists('bp_is_blog_page') && !bp_is_blog_page() ) {
$dynamic_sidebar = 'buddypress-sidebar';
$wpsidebar = 'false';
} elseif( function_exists('is_in_woocommerce_page') && is_in_woocommerce_page() ) {
$dynamic_sidebar = 'shop-sidebar';
$wpsidebar = 'false';
} elseif( function_exists('is_in_jigoshop_page') && is_in_jigoshop_page() ) {
$dynamic_sidebar = 'shop-sidebar';
$wpsidebar = 'false';
} elseif( $in_bbpress == 'true' ) {
$dynamic_sidebar = 'forum-sidebar';
$wpsidebar = 'false';
} elseif ( get_post_type() == 'portfolio' ) {
$dynamic_sidebar = 'portfolio-sidebar';
$wpsidebar = 'false';
} else {
$dynamic_sidebar = 'right-sidebar';
$wpsidebar = 'true';
}
?>

<div id="right-sidebar" class="sidebar <?php echo $dynamic_sidebar; ?>"<?php do_action('bp_section_sidebar'); ?>>
<div class="sidebar-inner">
<div class="widget-area the-icons">
<?php do_action('bp_before_right_sidebar'); ?>

<?php if ( is_active_sidebar( $dynamic_sidebar ) ) : ?>
<?php dynamic_sidebar( $dynamic_sidebar ); ?>
<?php else: ?>
<?php if($wpsidebar == 'true'): ?>
<?php get_template_part('lib/templates/advertisement'); ?>
<?php $get_ads_right_sidebar = get_theme_option('ads_right_sidebar'); if($get_ads_right_sidebar == '') { ?>
<?php } else { ?>
<aside id="ctr-ad" class="widget">
<div class="textwidget"><?php echo stripcslashes(do_shortcode($get_ads_right_sidebar)); ?></div>
</aside>
<?php } ?>
<?php if ( is_active_sidebar( 'tabbed-sidebar' ) ) : ?>
<div id="tabber-widget"><div class="tabber">
<?php dynamic_sidebar( 'tabbed-sidebar' ); ?>
</div></div>
<?php endif; ?>
<?php endif; ?>
<aside class="widget">
<h3 class="widget-title"><?php _e('Search','mesocolumn'); ?></h3>
<?php get_search_form(); ?>
</aside>
<aside class="widget widget_recent_entries">
<h3 class="widget-title"><?php _e('Recent Posts', 'mesocolumn'); ?></h3>
<ul><?php wp_get_archives('type=postbypost&limit=5'); ?></ul>
</aside>
<aside class="widget widget">
<h3 class="widget-title"><?php _e('Pages', 'mesocolumn'); ?></h3>
<ul><?php wp_list_pages('title_li='); ?></ul>
</aside>
<aside class="widget">
<h3 class="widget-title"><?php _e('Tags','mesocolumn'); ?></h3>
<div class="tagcloud"><ul><?php wp_tag_cloud('smallest=10&largest=20&number=30&unit=px&format=flat&orderby=name'); ?></ul></div>
</aside>
<?php endif; ?>

<?php do_action('bp_after_right_sidebar'); ?>

</div>
</div><!-- SIDEBAR-INNER END -->
</div><!-- RIGHT SIDEBAR END -->