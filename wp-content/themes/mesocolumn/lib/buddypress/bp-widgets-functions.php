<?php
/*
BuddyPress Custom Widget
*/

///////////////////////////////////////////////////////////////////////////////////
//// BuddyPress Searchform
///////////////////////////////////////////////////////////////////////////////////
class My_THEME_BP_Searchform_Widget extends WP_Widget {
function My_THEME_BP_Searchform_Widget() {
//Constructor
parent::WP_Widget(false, $name = __('BuddyPress Search', 'mesocolumn'), array(
'description' => __('Displays your BuddyPress Directory Search.', 'mesocolumn')
));
}
function widget($args, $instance) {
// outputs the content of the widget
extract($args); // Make before_widget, etc available.
$bps_name = empty($instance['title']) ? __('BuddyPress Search', 'mesocolumn') : apply_filters('widget_title', $instance['title']);
$unique_id = $args['widget_id'];
echo $before_widget;
echo $before_title . $bps_name . $after_title; ?>
<?php do_action( 'bp_before_blog_search_form' ) ?>
<form action="<?php echo bp_search_form_action() ?>" class="bp-searchform" method="post" id="search-form">
<input type="text" id="search-terms" name="search-terms" onfocus="if (this.value == '<?php _e( 'Start Searching...', 'mesocolumn' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Start Searching...', 'mesocolumn' ) ?>';}" />
<?php echo bp_search_form_type_select() ?>
&nbsp;<input type="submit" name="search-submit" id="search-submit" value="<?php _e('Search', 'mesocolumn') ?>" />
<?php wp_nonce_field( 'bp_search_form' ) ?>
<?php do_action( 'bp_blog_search_form' ) ?>
</form>
<?php do_action( 'bp_after_blog_search_form' );
echo $after_widget; ?>
<?php }

function update($new_instance, $old_instance) {
//update and save the widget
return $new_instance;
}
function form($instance) {
// Get the options into variables, escaping html characters on the way
$bps_name = $instance['title'];
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php  _e('Name','mesocolumn'); ?>:</label>
<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" class="widefat" value="<?php echo $bps_name; ?>" /></p>
<?php }
}
register_widget('My_THEME_BP_Searchform_Widget');



if ( bp_is_active( 'groups' ) ) {
///////////////////////////////////////////////////////////////////////
/// fetch random groups
///////////////////////////////////////////////////////////////////////
function fetch_random_groups($limit='', $size='', $type='', $block_id='') {
global $wpdb, $bp;
$fetch_group = "SELECT * FROM " . $wpdb->base_prefix . "bp_groups WHERE status = 'public' ORDER BY rand() LIMIT $limit";
$sql_fetch_group = $wpdb->get_results($fetch_group); ?>

<ul class="random-groups item-list group-in-<?php echo $block_id; ?>">

<?php
$no_avatar = 'http://www.gravatar.com/avatar';
foreach($sql_fetch_group as $group_fe) {
$avatar_full = bp_core_fetch_avatar( 'item_id=' . $group_fe->id . '&class=avatar&object=group&type=' . $type . '&width=' . $size . '&height=' . $size );
$group_description = stripslashes($group_fe->description);
?>

<li>
<div class="item-avatar"><?php echo $avatar_full; ?></div>

<div class="item">
<div class="item-title">
<a title="<?php echo $group_fe->name . ' - ' . dez_get_short_text($group_description, 150); ?>" href="<?php echo home_url() . '/' . bp_get_root_slug( 'groups' ) . '/' . $group_fe->slug; ?>"><?php echo $group_fe->name; ?></a>
</div>
<div class="item-meta">
<span class="activity">
<?php echo groups_get_groupmeta( $group_fe->id, $meta_key = 'total_member_count'); ?> <?php echo bp_get_root_slug( 'members' ); ?>
</span>
</div>
</div>
</li>

<?php } ?>


</ul>
<?php }
///////////////////////////////////////////////////////////////////////////////////
//// BuddyPress Random Groups
///////////////////////////////////////////////////////////////////////////////////
class My_THEME_BP_Random_Groups_Widget extends WP_Widget {
function My_THEME_BP_Random_Groups_Widget() {
//Constructor
parent::WP_Widget(false, $name = __('BuddyPress Random Groups', 'mesocolumn'), array(
'description' => __('Displays your BuddyPress Groups Randomly.', 'mesocolumn')
));
}
function widget($args, $instance) {
// outputs the content of the widget
extract($args); // Make before_widget, etc available.
$rg_name = empty($instance['title']) ? __('BuddyPress Random Groups', 'mesocolumn') : apply_filters('widget_title', $instance['title']);
$unique_id = $args['widget_id'];

echo $before_widget;
echo $before_title . $rg_name . $after_title;
echo fetch_random_groups($limit=12, $size=50, $type='thumb',$block_id='');
echo $after_widget;
}


function update($new_instance, $old_instance) {
//update and save the widget
return $new_instance;
}
function form($instance) {
// Get the options into variables, escaping html characters on the way
$rg_name = $instance['title'];
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php  _e('Name','mesocolumn'); ?>:</label>
<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" class="widefat" value="<?php echo $rg_name; ?>" /></p>
<?php } }
register_widget('My_THEME_BP_Random_Groups_Widget');
}

?>