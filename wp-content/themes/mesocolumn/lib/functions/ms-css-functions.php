<?php

function meso_customcss_theme_menu() {
global $theme_name;
add_theme_page( $theme_name . __(' Custom CSS', 'mesocolumn'), __('Custom CSS', 'mesocolumn'), 'edit_theme_options', 'custom-css', 'meso_customcss_theme_page');
}
//add_action('admin_menu', 'meso_customcss_theme_menu');


function meso_customcss_theme_page() {
global $theme_name;
?>
<div id="custom-theme-option" class="wrap">
<?php if ( isset($_GET['settings-updated']) && false !== $_REQUEST['settings-updated'] ) : ?>
<?php echo '<div class="updated fade"><p><strong>'. $theme_name . __(' Custom CSS saved.', 'mesocolumn') . '</strong></p></div>';
if(get_option('tn_mesocolumn_custom_css')) { delete_option('tn_mesocolumn_custom_css'); }
?>
<?php endif; ?>
<?php if ( isset($_POST['action']) && $_POST['action'] == 'settings-reset' ) : ?>
<?php echo '<div class="updated fade"><p><strong>'. $theme_name . __(' Custom CSS Reset.', 'mesocolumn') . '</strong></p></div>';
?>
<?php endif; ?>

<form id="template" method="post" action="options.php" >
<?php
settings_fields( MESO_OPTION . '_theme_options' );
do_settings_sections('custom-css');
?>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Custom CSS', 'mesocolumn') ?>" />
</p>
</form>
<form action="<?php echo admin_url('themes.php?page=theme-options&tab='.$_GET['tab']); ?>" method="post">
<div style="float:left;padding:0;margin:0;" class="submit">
<?php
$alert_message = __("Are you sure you want to delete all saved custom css?.", 'mesocolumn' ); ?>
<input name="reset" type="submit" class="button-secondary" onclick="return confirm('<?php echo $alert_message; ?>')" value="<?php echo esc_attr(__('Reset Custom CSS','mesocolumn')); ?>" />
<input type="hidden" name="action" value="settings-reset" />
</div>
</form>
</div>
<?php
}



function meso_customcss_display_section($section){}

function meso_customcss_display_setting($args) {
global $theme_name, $shortname;
extract( $args );
$option_name = MESO_OPTION . '_theme_options';
$options = get_option( $option_name );

switch ( $type ) {
case 'textarea':
$options[$id] = !empty($options[$id]) ? $options[$id] : "";
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
?>

<textarea id="<?php echo $id; ?>" name="<?php echo $option_name . "[$id]"; ?>" cols="60%" rows="8" /><?php if ( $options[$id] != "" ) { echo $options[$id]; } else { echo $preops; } ?>
</textarea>
<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>
<?php
break;
default;
break;
}
}

//reset custom css options
function meso_custom_css_reset() {
global $wpdb, $wp_cats2, $wp_pages, $theme_name, $shortname, $meso_options;
$option_name = MESO_OPTION . '_theme_options';
$options = get_option( $option_name );
if ( isset($_GET['page']) && $_GET["page"] == "theme-options" && isset($_GET['tab']) && $_GET["tab"] == "custom-css" ) {
if ( isset($_POST['action']) && $_POST['action'] == 'settings-reset'  ) {
foreach ($wp_cats2 as $cat_value) {
$cat_id = get_cat_ID($cat_value);
if(!$cat_id) {
$cat_name = get_term_by('name', $cat_value, 'product_cat');
$cat_id = $cat_name->term_id;
}
$cat_value_option = 'tn_cat_color_' . $cat_id;
$options[$cat_value_option] = $options[$cat_value_option];
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
$options['custom_css'] = '';
update_option( $option_name, $options );
}
}
}
add_action('admin_head', 'meso_custom_css_reset');

?>