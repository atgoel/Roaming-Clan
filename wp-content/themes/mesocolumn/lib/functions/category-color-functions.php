<?php

function meso_get_global_cat() {
global $wp_cats2;
if( ( !is_admin() ) || ( isset($_GET['page']) && $_GET["page"] == "theme-options"  ) ) {
$categories2 = get_categories('hide_empty=0&orderby=name');
$wp_cats2 = array();
foreach ($categories2 as $category_list ) {
$wp_cats2[$category_list->cat_ID] = $category_list->cat_name;
}
}
}
add_action('init','meso_get_global_cat');

function dez_add_product_cat() {
global $wp_cats2;
$productcat = get_categories('hide_empty=0&orderby=name&taxonomy=product_cat');
$wp_productcat = array();
foreach ( $productcat as $category_list ) {
$wp_productcat[$category_list->cat_ID] = $category_list->name;
}
if( is_array( $wp_cats2 ) ) {
$wp_cats2 = array_merge($wp_cats2, $wp_productcat);
}
}

if( class_exists('woocommerce') || class_exists('jigoshop') ) {
add_action('init','dez_add_product_cat');
}


function meso_catcolor_theme_menu() {
global $theme_name;
add_theme_page( $theme_name . __(' Category Color Options', 'mesocolumn'), __('Category Color', 'mesocolumn'), 'edit_theme_options', 'category-color', 'meso_catcolor_theme_page');
}
//add_action('admin_menu', 'meso_catcolor_theme_menu');


function meso_catcolor_theme_page() {
global $wp_cats2,$theme_name;
?>
<div id="custom-theme-option" class="wrap">
<?php if ( isset($_GET['settings-updated']) && false !== $_REQUEST['settings-updated'] ) : ?>
<?php echo '<div class="updated fade"><p><strong>'. $theme_name . __(' Category Color Options Saved.', 'mesocolumn') . '</strong></p></div>'; ?>
<?php if( get_option('_meso_clear_db') ) { update_option('_meso_clear_db', '2'); } ?>
<?php if( get_transient('cat_color_option_cache') ) { delete_transient('cat_color_option_cache'); } ?>
<?php endif; ?>
<?php if ( isset($_POST['action']) && $_POST['action'] == 'settings-reset'  ) : ?>
<?php echo '<div class="updated fade"><p><strong>'. $theme_name . __(' Category Color Options Reset.', 'mesocolumn') . '</strong></p></div>'; ?>
<?php endif;
$custom_notice = "<div class='custom-message'>". __('The color options only work if use custom menu for <strong>primary menu</strong> in appearance -> menus', 'mesocolumn') . "</div>";
echo $custom_notice;
?>
<form id="wp-theme-options" method="post" action="options.php" >
<?php
settings_fields( MESO_OPTION . '_theme_options' );
do_settings_sections('category-color');
?>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Category Color', 'mesocolumn') ?>" />
</p>
</form>
<form action="<?php echo admin_url('themes.php?page=theme-options&tab='.$_GET['tab']); ?>" method="post">
<div style="float:left;padding:0;margin:0;" class="submit">
<?php
$alert_message = __("Are you sure you want to delete all saved category color?.", 'mesocolumn' ); ?>
<input name="reset" type="submit" class="button-secondary" onclick="return confirm('<?php echo $alert_message; ?>')" value="<?php echo esc_attr(__('Reset Category Color','mesocolumn')); ?>" />
<input type="hidden" name="action" value="settings-reset" />
</div>
</form>
</div>
<?php
}


function meso_catcolor_display_section($section){}

function meso_catcolor_display_setting($args) {
global $theme_name, $shortname;
extract( $args );
$option_name = 'meso_theme_options';
$options = get_option( $option_name );

switch ( $type ) {
case 'colorpicker':
$options[$id] = !empty($options[$id]) ? $options[$id] : "";
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
?>
<div id="<?php echo $id . '_picker'; ?>" class="colorSelector">
<div style="background-color:<?php if( $options[$id] ) { echo $options[$id]; } ?>"></div></div>&nbsp;
<input class="of-color" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" type="text" value="<?php if( $options[$id] ) { echo $options[$id]; } else { echo $preops; } ?>" />
<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>">&nbsp;&nbsp;&nbsp;<?php printf(__('Choose a color for %1$s', 'mesocolumn'), $desc); ?></label>
<?php } ?>
<?php
break;
default;
break;
}
}

//reset category color options
function meso_catcolor_reset() {
global $wpdb, $wp_cats2, $wp_pages, $theme_name, $shortname, $meso_options;
$option_name = MESO_OPTION . '_theme_options';
$options = get_option( $option_name );
if ( isset($_GET['page']) && $_GET["page"] == "theme-options" && isset($_GET['tab']) && $_GET["tab"] == "category-color" ) {
if ( isset($_POST['action']) && $_POST['action'] == 'settings-reset' ) {
foreach ($wp_cats2 as $cat_value) {
$cat_id = get_cat_ID($cat_value);
if(!$cat_id) {
$cat_name = get_term_by('name', $cat_value, 'product_cat');
$cat_id = $cat_name->term_id;
}
$cat_value_option = 'tn_cat_color_' . $cat_id;
$options[$cat_value_option] = '';
}
foreach ( $meso_options as $val ){
$options[$val['id']] = $options[$val['id']];
}
foreach ($wp_pages as $page_value) {
$page_id = $page_value;
$page_title = get_the_title( $page_id );
$page_value_option = 'tn_page_color_' . $page_id;
$options[$page_value_option] = $options[$page_value_option];
}
$options['custom_css'] = $options['custom_css'];
update_option( $option_name, $options );

if( get_transient('cat_color_option_cache') ) { delete_transient('cat_color_option_cache'); }
}
}
}
add_action('admin_head', 'meso_catcolor_reset');
?>