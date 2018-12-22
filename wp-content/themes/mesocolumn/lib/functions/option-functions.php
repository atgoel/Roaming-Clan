<?php
////////////////////////////////////////////////////////////////////////////////
// get theme option
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('get_theme_option') ):
function get_theme_option($option_n ='', $option_g='') {
global $shortname;
if( $option_g == '') {
$options = get_option( MESO_OPTION .'_theme_options' );
$get_the_option = $options[ $shortname . '_'. $option_n ];
if( !empty($get_the_option) ) { return stripslashes($get_the_option); }
} else {
$options = get_option( MESO_OPTION . '_theme_options' );
if( !empty($options[ $option_n ]) ) { return stripslashes( $options[ $option_n ] ); }
}
}
endif;

////////////////////////////////////////////////////////////////////////////////
// get alt style list
////////////////////////////////////////////////////////////////////////////////
$alt_stylesheet_path = get_template_directory() . '/lib/styles/alt-styles/';
$alt_stylesheets = array();
if ( is_dir($alt_stylesheet_path) ) {
if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) {
while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
if(stristr($alt_stylesheet_file, ".css") !== false) {
$alt_stylesheets[] = $alt_stylesheet_file;
}
}
}
}
$styles_bulk_list = array_unshift($alt_stylesheets, "default.css");

////////////////////////////////////////////////////////////////////////////////
// global upload path
////////////////////////////////////////////////////////////////////////////////
$option_upload = wp_upload_dir();
$option_upload_path = $option_upload['basedir'];
$option_upload_url = $option_upload['baseurl'];

////////////////////////////////////////////////////////////////////////////////
// multiple string option page
////////////////////////////////////////////////////////////////////////////////
function _g($str) { return $str; }

function dez_theme_admin_head_script() {
global $shortname, $theme_version;
if ( isset($_GET["page"]) && $_GET["page"] == "theme-options" ) {
wp_enqueue_script( 'theme-color-picker-js', get_template_directory_uri() . '/lib/admin/js/colorpicker.js', array( 'jquery' ), $theme_version );
wp_enqueue_script( 'theme-option-custom-js', get_template_directory_uri() . '/lib/admin/js/options-custom.js', array( 'jquery' ), $theme_version );
?>

<script type="text/javascript">
jQuery(document).ready(function(){
jQuery("select#<?php echo $shortname . '_body_font'; ?>, select#<?php echo $shortname . '_headline_font'; ?>, select#<?php echo $shortname . '_navigation_font'; ?>").change(function(){

var val = jQuery("select#<?php echo $shortname . '_body_font'; ?>").val();
var val_strip = val.replace(/ /g,"+");
var val2 = jQuery("select#<?php echo $shortname . '_headline_font'; ?>").val();
var val_strip2 = val2.replace(/ /g,"+");
var val3 = jQuery("select#<?php echo $shortname . '_navigation_font'; ?>").val();
var val_strip3 = val3.replace(/ /g,"+");
//var valx = val.replace(/ /g, "+");

jQuery("#cFontStyleWColor11").text('#testtext-<?php echo $shortname . "_body_font"; ?> { font-size: 16px; font-family: "'+ val +'" !important; }');

jQuery("#cFontStyleWColor12").text('#testtext-<?php echo $shortname . "_headline_font"; ?> { font-size: 16px; font-family: "'+ val2 +'" !important; }');

jQuery("#cFontStyleWColor13").text('#testtext-<?php echo $shortname . "_navigation_font"; ?> { font-size: 16px; font-family: "'+ val3 +'" !important; }');

var oLink = document.getElementById('gwfbody');
var gLink = 'http://fonts.googleapis.com/css?family='+ val_strip +'';
oLink.href = gLink;

var oLink = document.getElementById('gwfheadline');
var gLink = 'http://fonts.googleapis.com/css?family='+ val_strip2 +'';
oLink.href = gLink;

var oLink = document.getElementById('gwfnav');
var gLink = 'http://fonts.googleapis.com/css?family='+ val_strip3 +'';
oLink.href = gLink;


});
});

</script>

<?php
}
}

function dez_theme_admin_head_style() {
global $shortname, $theme_version;
if ( isset($_GET["page"]) && $_GET["page"] == "theme-options" ) {
wp_enqueue_style( 'admin-css', get_template_directory_uri() . '/lib/admin/css/admin.css', array(), $theme_version );
wp_enqueue_style( 'color-picker-main', get_template_directory_uri() . '/lib/admin/css/colorpicker.css', array(), $theme_version );
?>
<style id="cFontStyleWColor11" type="text/css"></style>
<style id="cFontStyleWColor12" type="text/css"></style>
<style id="cFontStyleWColor13" type="text/css"></style>
<link id="gwfbody" rel="stylesheet" href="">
<link id="gwfheadline" rel="stylesheet" href="">
<link id="gwfnav" rel="stylesheet" href="">
<?php print "<style>"; ?>
<?php if(get_theme_option('body_font') == 'Choose a font' || get_theme_option('body_font') == ''): ?>
<?php else: ?>
#testtext-<?php echo $shortname . "_body_font"; ?> { font-size: 16px; font-family: <?php echo get_theme_option('body_font'); ?>; }
<?php endif; ?>
<?php if(get_theme_option('body_font') == 'Choose a font' || get_theme_option('headline_font') == ''): ?>
<?php else: ?>
#testtext-<?php echo $shortname . "_headline_font"; ?> { font-size: 16px; font-family: <?php echo get_theme_option('headline_font'); ?>; }
<?php endif; ?>
<?php if(get_theme_option('body_font') == 'Choose a font' || get_theme_option('navigation_font') == ''): ?>
<?php else: ?>
#testtext-<?php echo $shortname . "_navigation_font"; ?> { font-size: 16px; font-family: <?php echo get_theme_option('navigation_font'); ?>; }
<?php endif; ?>
<?php print "</style>"; ?>
<?php }
}
add_action('admin_footer', 'dez_theme_admin_head_script');
add_action('admin_print_styles', 'dez_theme_admin_head_style');
add_action('admin_print_styles', 'dez_custom_google_font');


////////////////////////////////////////////////////////////////////////////////
// Theme Option
////////////////////////////////////////////////////////////////////////////////
$theme_data = wp_get_theme();
$theme_version = $theme_data['Version'];
$theme_name = $theme_data['Name'];
$shortname = 'tn_'. TEMPLATE_DOMAIN;
$choose_count = array("Select a number","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20");
$choose_weight = array("Select font weight",'light','lighter','normal','bold','100','200','300','400','600','700','800','900');
$choose_layout = array("default","all thumbnail","all medium");
////////////////////////////////////////////////////////////////////////////////
// Add Theme Data
////////////////////////////////////////////////////////////////////////////////
function meso_get_theme_data($data) {
$theme_data = wp_get_theme();
if($data == 'ThemeURI' || $data == 'Author URI' || $data == 'TextDomain'){
$the_theme_data = $theme_data->get($data);
} else {
$the_theme_data = $theme_data->$data;
}
return $the_theme_data;
}

////////////////////////////////////////////////////////////////////////////////
// Add Child Path File Detect
////////////////////////////////////////////////////////////////////////////////
function meso_get_child_file($file_path) {
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . $file_path )) {
$realpath = get_stylesheet_directory_uri() . $file_path;
} elseif( file_exists( get_template_directory() . $file_path ) ) {
$realpath = get_template_directory_uri() . $file_path;
}
return $realpath;
}


/* including fonts functions */
if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/fonts-functions.php' ) ) {
include_once( get_stylesheet_directory() . '/lib/functions/fonts-functions.php');
} else {
include_once( get_template_directory() . '/lib/functions/fonts-functions.php');
}


function meso_get_wp_cat() {
global $wp_cats;
if ( isset ( $_GET['page'] ) &&  $_GET['page'] == 'theme-options' ) {
$categories = get_categories('hide_empty=0&orderby=name');
//print_r($categories);
$wp_cats = array();
foreach ($categories as $category_list ) {
$wp_cats[$category_list->cat_ID] = $category_list->cat_ID;
}
array_unshift($wp_cats, "Choose a category");
}
}
add_action('admin_head','meso_get_wp_cat');

/**
 * Theme Option Page Example
 */
function meso_theme_menu() {
global $theme_name;
add_theme_page( $theme_name . __(' Theme Options', 'mesocolumn'), __('Theme Options', 'mesocolumn'), 'edit_theme_options', 'theme-options', 'meso_theme_page');
}
add_action('admin_menu', 'meso_theme_menu');


function meso_theme_admin_tabs( $current = 'general' ) {
$tabs = array( 'general' => 'General', 'category-color' => 'Category Color', 'page-color' => 'Page Color', 'custom-css' => 'Custom CSS' );
$links = array();
echo '<div id="icon-themes" class="icon32"><br></div>';
echo '<h2 class="nav-tab-wrapper">';
foreach( $tabs as $tab => $name ){
$class = ( $tab == $current ) ? ' nav-tab-active' : '';
echo "<a class='nav-tab$class' href='?page=theme-options&tab=$tab'>$name</a>";
}
echo '</h2>';
}

/**
 * Callback function to the add_theme_page
 * Will display the theme options page
 */
function meso_theme_page() {
global $theme_name;
?>

<?php if ( isset ( $_GET['tab'] ) ) meso_theme_admin_tabs($_GET['tab']); else meso_theme_admin_tabs('general'); ?>

<?php
if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
else $tab = 'general';
switch ( $tab ){
case 'category-color' :
meso_catcolor_theme_page();
break;
case 'page-color' :
meso_pagecolor_theme_page();
break;
case 'custom-css' :
meso_customcss_theme_page();
break;
case 'general' :
?>
<div id="custom-theme-option" class="wrap">
<?php if ( isset($_GET['settings-updated']) && false !== $_REQUEST['settings-updated'] ) : ?>
<?php echo '<div class="updated fade"><p><strong>'. $theme_name . __(' settings saved.', 'mesocolumn') . '</strong></p></div>'; ?>
<?php if( get_option('tn_mesocolumn_body_font') ) { update_option('_meso_clear_db', '1'); } endif; ?>
<?php if ( isset($_GET['page']) && $_GET['page'] == 'theme-options' && isset($_POST['action']) && $_POST['action'] == 'settings-reset' ) : ?>
<?php echo '<div class="updated fade"><p><strong>'. $theme_name . __(' settings reset.', 'mesocolumn') . '</strong></p></div>'; ?>
<?php endif; ?>
<br />
<?php add_thickbox(); ?>

<a target="_blank" href="<?php echo meso_get_child_file('/changelog.txt'); ?>?TB_iframe=true&width=600&height=550" class="thickbox"><?php _e('Changelog', 'mesocolumn'); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a target="_blank" href="<?php echo meso_get_child_file('/faq.txt'); ?>?TB_iframe=true&width=600&height=550" class="thickbox"><?php _e('Frequently Ask Questions', 'mesocolumn'); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a target="_blank" href="<?php echo meso_get_theme_data('ThemeURI'); ?>"><?php _e('Theme Support', 'mesocolumn'); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a target="_blank" href="http://www.dezzain.com/donation?to=<?php echo strtolower(meso_get_theme_data('Name')); ?>"><?php _e('Make a Donation', 'mesocolumn'); ?></a>

<form id="wp-theme-options" method="post" action="options.php">
<?php
settings_fields( MESO_OPTION . '_theme_options' );
do_settings_sections('theme-options');
?>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Options', 'mesocolumn') ?>" />
</p>
</form>
<form action="<?php echo admin_url('themes.php?page=theme-options&tab=general'); ?>" method="post">
<div style="float:left;padding:0;margin:0;" class="submit">
<?php
$alert_message = __("Are you sure you want to delete all saved settings for this theme?.", 'mesocolumn' ); ?>
<input name="reset" type="submit" class="button-secondary" onclick="return confirm('<?php echo $alert_message; ?>')" value="<?php echo esc_attr(__('Reset Options','mesocolumn')); ?>" />
<input type="hidden" name="action" value="settings-reset" />
</div>
</form>
</div>
<?php break; } ?>
<?php
}


/**
 * Register the settings to use on the theme options page
 */
add_action( 'admin_init', 'meso_register_settings' );

/**
 * Function to register the settings
 */
function meso_register_settings() {
global $font_family_group, $wp_cats, $wp_cats2, $wp_pages, $choose_layout, $choose_count, $theme_name, $shortname, $meso_options;

if( is_child_theme() && 'mesocolumn' == get_template() && file_exists( get_stylesheet_directory() . '/lib/functions/option-settings.php' ) ) {
include_once( get_stylesheet_directory() . '/lib/functions/option-settings.php');
} else {
include_once( get_template_directory() . '/lib/functions/option-settings.php');
}

// Register the settings with Validation callback
register_setting( MESO_OPTION . '_theme_options', MESO_OPTION . '_theme_options', 'meso_validate_settings' );

// main options setting
$setting_list = array('header','typography','designs','posts','shop','slider','home','advertisement','sidebar', 'misc');

foreach($setting_list as $list) {
add_settings_section( 'meso_'. $list . '_section', ucfirst($list). __(' Settings', 'mesocolumn'), 'meso_display_section', 'theme-options' );
}
foreach ($meso_options as $value){
if( get_option($value['id']) ){ $previous_ops = get_option($value['id']); } else { $previous_ops = $value['default']; }
// Create textbox field
    $field_args = array(
      'type'      => $value['type'],
      'section'   => $value['section'],
      'id'        => $value['id'],
      'name'      => $value['name'],
      'desc'      => $value['description'],
      'std'       => $previous_ops,
      'label_for' => $value['name'],
      'class'     => 'css_class'
    );
add_settings_field( $value['id'], $value['name'], 'meso_display_setting', 'theme-options', 'meso_'. $value['section'] . '_section', $field_args );
}


// cat color options setting
add_settings_section( 'meso_catcolor_section', __('Category Color Settings', 'mesocolumn'), 'meso_catcolor_display_section', 'category-color' );

if( is_array($wp_cats2) ) {
foreach ($wp_cats2 as $cat_value) {
$cat_id = get_cat_ID($cat_value);
if(!$cat_id) {
$cat_name = get_term_by('name', $cat_value, 'product_cat');
$cat_id = $cat_name->term_id;
}
$cat_value_option = 'tn_cat_color_' . $cat_id;
$previous_ops = get_option($cat_value_option);

// Create textbox field
    $field_args = array(
      'type'      => 'colorpicker',
      'section'   => 'catcolor',
      'id'        => $cat_value_option,
      'name'      => $cat_value,
      'desc'      => $cat_value,
      'std'       => '',
      'preops'    => $previous_ops,
      'label_for' => $cat_value,
      'class'     => ''
    );
add_settings_field( $cat_value_option, $cat_value, 'meso_catcolor_display_setting', 'category-color', 'meso_catcolor_section', $field_args );
}
}

// page color options setting
add_settings_section( 'meso_pagecolor_section', __('Pages Color Settings','mesocolumn'), 'meso_pagecolor_display_section', 'page-color' );

if( is_array($wp_pages) ) {
foreach ($wp_pages as $page_value) {
$page_id = $page_value;
$page_title = get_the_title( $page_id );
$page_value_option = 'tn_page_color_' . $page_id;
$previous_ops = get_option($page_value_option);

// Create textbox field
    $field_args = array(
      'type'      => 'colorpicker',
      'section'   => 'pagecolor',
      'id'        => $page_value_option,
      'name'      => $page_value_option,
      'desc'      => $page_title,
      'std'       => '',
      'preops'    => $previous_ops,
      'label_for' => $page_title,
      'class'     => ''
    );
add_settings_field( $page_value_option, $page_title, 'meso_pagecolor_display_setting', 'page-color', 'meso_pagecolor_section', $field_args );
}
}

// custom css options setting
add_settings_section( 'meso_customcss_section', __('Custom CSS', 'mesocolumn'), 'meso_customcss_display_section', 'custom-css' );
$previous_ops = get_option('tn_mesocolumn_custom_css');
// Create textbox field
    $field_args = array(
      'type'      => 'textarea',
      'section'   => 'customcss',
      'id'        => 'custom_css',
      'name'      => 'custom_css',
      'desc'      => __("Insert Custom CSS for this theme", 'mesocolumn' ),
      'std'       => '',
      'preops'    => $previous_ops,
      'label_for' => 'custom-css',
      'class'     => ''
    );
add_settings_field( $shortname . '_custom_css', __('Custom CSS', 'mesocolumn'), 'meso_customcss_display_setting', 'custom-css', 'meso_customcss_section', $field_args );

}


/**
 * Function to add extra text to display on each section
 */
function meso_display_section($section){}

/**
 * Function to display the settings on the page
 * This is setup to be expandable by using a switch on the type variable.
 * In future you can add multiple types to be display from this function,
 * Such as checkboxes, select boxes, file upload boxes etc.
 */
function meso_display_setting($args) {
global $font_family_group, $choose_layout,$wp_cats, $choose_count, $choose_weight,$theme_name, $shortname, $meso_options, $option_upload_path, $option_upload_url;
extract( $args );
$option_name = MESO_OPTION . '_theme_options';
$options = get_option( $option_name );

switch ( $type ) {
case 'text':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);

echo "<input class='regular-text' type='text' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";
echo ($desc != '') ? "<br /><label class='description'>$desc</label>" : "";


break;
case 'textarea':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
?>

<textarea id="<?php echo $id; ?>" name="<?php echo $option_name . "[$id]"; ?>" cols="60%" rows="8" /><?php if ( $options[$id] != "" ) { echo $options[$id]; } else { echo $std; } ?>
</textarea>
<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>

<?php break;

case 'radio':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
$checked = "checked=\"checked\"";
?>
<?php foreach ( $choose_layout as $layout ) { ?>
<input type="radio" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo 'layout' . $layout; ?>" value="<?php echo $layout; ?>" <?php if($options[$id] == $layout ) { echo $checked; } ?> />&nbsp;&nbsp;<?php echo $layout; ?>&nbsp;&nbsp;&nbsp;&nbsp;
<?php } ?>

<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>


<?php break;
case 'colorpicker':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
?>

<div id="<?php echo $id . '_picker'; ?>" class="colorSelector">
<div style="background-color:<?php if( $options[$id] ) { echo $options[$id]; } ?>"></div></div>&nbsp;
<input class="of-color" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" type="text" value="<?php if( $options[$id] ) { echo $options[$id]; } ?>" />
<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>">&nbsp;&nbsp;&nbsp;<?php echo $desc; ?></label>
<?php } ?>


<?php break;
case 'select-fonts':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
?>
<select name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>">
<?php foreach ($font_family_group as $font) { ?>
<option value="<?php echo $font; ?>"<?php if ( $options[$id]  == $font ) { echo ' selected="selected"'; } ?>><?php echo $font; ?></option>
<?php } ?>
</select>
<div style="<?php $the_font_family = $options[$id]; if( $options[$id] == '' || $options[$id] == 'Choose a font' ) { } else { echo 'font-family:'.$the_font_family.';'; } ?>" class="testtextbox" id="testtext-<?php echo $id; ?>">The Quick Brown Fox Jumps Over The Lazy Dog. 1234567890</div>
<?php if($desc != '') { ?>
<label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>

<?php break;
case 'select-fonts-weight':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
?>

<select name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>">
<?php foreach ($choose_weight as $count) { ?>
<option value="<?php if($count == 'Select font weight') { echo 'Select font weight'; } else { echo $count; } ?>"<?php if ( $options[$id] == $count ) { echo ' selected="selected"'; } ?>><?php echo $count; ?></option>
<?php } ?>
</select>

<?php if($desc != '') { ?>
<label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>

<?php break;

case 'select-cat':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
?>
<select name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>">
<?php foreach ($wp_cats as $cat) { ?>
<option value="<?php if($cat == 'Choose a category') { echo 'Choose a category'; } else { echo $cat; } ?>"<?php if ( $options[$id] == $cat ) { echo ' selected="selected"'; } ?>><?php if( !get_cat_name( $cat ) ) { echo 'Choose a category'; } else { echo get_cat_name( $cat ); }?></option>
<?php } ?>
</select>
<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>


<?php break;

case 'select-count':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
?>
<select name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>">
<?php foreach ($choose_count as $count) { ?>
<option value="<?php if($count == 'Select a number') { echo 'Select a number'; } else { echo $count; } ?>"<?php if ( $options[$id] == $count ) { echo ' selected="selected"'; } ?>><?php echo $count; ?></option>
<?php } ?>
</select>
<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>


<?php break;

case 'checkbox-enable-disable':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
$checked = "checked=\"checked\"";
?>
<input type="checkbox" class="checkbox" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" value="Enable" <?php if($options[$id] == 'Enable') { echo $checked; } ?> />&nbsp;&nbsp;<?php _e('Enable', 'mesocolumn'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" class="checkbox" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" value="Disable" <?php if($options[$id] == 'Disable') { echo $checked; } ?> />&nbsp;&nbsp;<?php _e('Disable', 'mesocolumn'); ?>
<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>

<?php break;

case 'radio-enable-disable':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
$checked = "checked=\"checked\"";
?>
<input type="radio" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" value="Enable" <?php if($options[$id] == 'Enable') { echo $checked; } ?> />&nbsp;&nbsp;<?php _e('Enable', 'mesocolumn'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" value="Disable" <?php if($options[$id] == 'Disable') { echo $checked; } ?>  />&nbsp;&nbsp;<?php _e('Disable', 'mesocolumn'); ?>
<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>

<?php break;

case 'radio-image-size':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
$checked = "checked=\"checked\"";
?>
<input type="radio" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" value="thumbnail" <?php if($options[$id] == 'thumbnail') { echo $checked; } ?> />&nbsp;&nbsp;<?php _e('Thumbnail', 'mesocolumn'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" value="medium" <?php if($options[$id] == 'medium') { echo $checked; } ?>  />&nbsp;&nbsp;<?php _e('Medium', 'mesocolumn'); ?>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" value="large" <?php if($options[$id] == 'large') { echo $checked; } ?>  />&nbsp;&nbsp;<?php _e('Large', 'mesocolumn'); ?>
<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>

<?php break;

case 'radio-blog-style':
$options[$id] = !empty($options[$id]) ? $options[$id] : $std;
$options[$id] = stripslashes($options[$id]);
$options[$id] = esc_attr( $options[$id]);
$checked = "checked=\"checked\"";
?>
<input type="radio" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" value="default" <?php if($options[$id] == 'default') { echo $checked; } ?> />&nbsp;&nbsp;<?php _e('Default', 'mesocolumn'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="<?php echo $option_name. "[$id]"; ?>" id="<?php echo $id; ?>" value="magazine" <?php if($options[$id] == 'magazine') { echo $checked; } ?>  />&nbsp;&nbsp;<?php _e('Magazine', 'mesocolumn'); ?>
<?php if($desc != '') { ?>
<br /><label class="description" for="<?php echo $label_for; ?>"><?php echo $desc; ?></label>
<?php } ?>

<?php break;

default;
break;
}
}



/* including category color options functions */
include_once( get_template_directory() . '/lib/functions/category-color-functions.php');
/* including page color options functions */
include_once( get_template_directory() . '/lib/functions/page-color-functions.php');
/* including multisite custom css functions */
include_once( get_template_directory() . '/lib/functions/ms-css-functions.php');



/**
 * Callback function to the register_settings function will pass through an input variable
 * You can then validate the values and the return variable will be the values stored in the database.
 */

 // default options - not used
function meso_options_get_defaults(){
global $font_family_group, $wp_cats, $wp_cats2, $wp_pages, $choose_layout,$choose_count, $theme_name, $shortname, $meso_options;
include_once( get_template_directory() . '/lib/functions/option-settings.php');
$option_name = MESO_OPTION . '_theme_options';
$options = get_option( $option_name );
$default_options = array();
//default main options
foreach ($meso_options as $val){$default_options = array( $val['id'] => $options[$val['id']] );}
foreach ($wp_cats2 as $cat_value) {
$cat_id = get_cat_ID($cat_value);
if(!$cat_id) {
$cat_name = get_term_by('name', $cat_value, 'product_cat');
$cat_id = $cat_name->term_id;
}
$cat_value_option = 'tn_cat_color_' . $cat_id;
$default_options = array( $options[$cat_value_option] => $options[$cat_value_option] );
}
foreach ($wp_pages as $page_value) {
$page_id = $page_value;
$page_title = get_the_title( $page_id );
$page_value_option = 'tn_page_color_' . $page_id;
$default_options = array( $options[$page_value_option] => $options[$page_value_option] );
}
$default_options = array( $options['custom_css'] => $options['custom_css'] );
return $default_options;
}


//validate all options
function meso_validate_settings($input) {
global $meso_options,$wp_cats2,$wp_pages;
$option_name = MESO_OPTION . '_theme_options';
$newinput = get_option( $option_name );
foreach($input as $k => $v) {
$newinput[$k] = trim($v);
$newinput[$k] = wp_filter_post_kses($v);
}
return $newinput;
}

//cleaup previous theme options
function meso_cleanup_options() {
global $shortname,$meso_options,$wp_cats2,$wp_pages;
$check_themecleanup = get_option('_meso_clear_db');
//let start update
$option_name = MESO_OPTION . '_theme_options';
$options = get_option( $option_name );

if( $check_themecleanup == '1'  ) {
include_once( get_template_directory() . '/lib/functions/option-settings.php');
//let clean up the previous old db row
foreach( $meso_options as $val ) {
$get_opval = get_option( $val['id'] );
delete_option( $val['id'] ); }
}

if( $check_themecleanup == '2'  ) {
if( is_array($wp_cats2) ) {
foreach ($wp_cats2 as $cat_value) {
$cat_id = get_cat_ID($cat_value);
if(!$cat_id) {
$cat_name = get_term_by('name', $cat_value, 'product_cat');
$cat_id = $cat_name->term_id; }
$cat_value_option = 'tn_cat_color_' . $cat_id;
delete_option( $cat_value_option ); }
}
}

if( $check_themecleanup == '3'  ) {
if( is_array($wp_pages) ) {
foreach ($wp_pages as $page_value) {
$page_id = $page_value;
$page_title = get_the_title( $page_id );
$page_value_option = 'tn_page_color_' . $page_id;
delete_option( $page_value_option );
}
}
}

//update/delete the previous multi array option db if existed
if(get_option('meso_cat_color')){delete_option( 'meso_cat_color' );}
if(get_option('meso_page_color')){delete_option( 'meso_page_color' );}
if(get_option('meso_custom_css')){delete_option( 'meso_custom_css' );}
if(get_option('meso_clear_db')){delete_option( 'meso_clear_db' );}
//echo 'all old options db had been updated';

}
add_action('admin_head','meso_cleanup_options',10);

//reset main theme options
function meso_theme_options_reset() {
global $wpdb, $wp_cats2, $wp_pages, $theme_name, $shortname, $meso_options;
$option_name = MESO_OPTION . '_theme_options';
$options = get_option( $option_name );
if ( isset($_GET['page']) && $_GET["page"] == "theme-options" && ( ( isset($_GET['tab']) && $_GET["tab"] == "general" ) || !isset($_GET["tab"] ) ) ) {
if ( isset($_POST['action']) && $_POST['action'] == 'settings-reset' ) {

if( is_array($wp_cats2) ) {
foreach ($wp_cats2 as $cat_value) {
$cat_id = get_cat_ID($cat_value);
if(!$cat_id) {
$cat_name = get_term_by('name', $cat_value, 'product_cat');
$cat_id = $cat_name->term_id;
}
$cat_value_option = 'tn_cat_color_' . $cat_id;
$options[$cat_value_option] = $options[$cat_value_option];
}
}

foreach ( $meso_options as $val ){
$options[$val['id']] = '';
}

if( is_array($wp_pages) ) {
foreach ($wp_pages as $page_value) {
$page_id = $page_value;
$page_title = get_the_title( $page_id );
$page_value_option = 'tn_page_color_' . $page_id;
$options[$page_value_option] = $options[$page_value_option];
}
}
$options['custom_css'] = $options['custom_css'];
update_option( $option_name, $options );
}
}
}
add_action('admin_head', 'meso_theme_options_reset');

?>