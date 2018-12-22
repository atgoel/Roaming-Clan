<?php
/*/////////////////////////////////////////////////////////////////////////////
/////////////////////////DEPRECATED///////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////*/
function dez_custom_image_options() { ?>
<table class="form-table">
<tbody>
<tr valign="top"><th scope="row"><?php _e( 'Custom Header Overlay with logo:', 'mesocolumn' ); ?></th>
<td>
<?php
$radio_setting = get_theme_mod('custom_header_overlay');
?>
<input id="custom_header_overlay" type="radio" name="custom_header_overlay" value="Yes" <?php if ( isset($radio_setting) && $radio_setting == 'Yes' ) { echo "checked='checked'"; } ?> />&nbsp;<?php _e('Yes', 'mesocolumn'); ?>&nbsp;&nbsp;&nbsp;
<input id="custom_header_overlay" type="radio" name="custom_header_overlay" value="No" <?php if ( isset($radio_setting) && $radio_setting == 'No' ) { echo "checked='checked'"; } ?> />&nbsp;<?php _e('No', 'mesocolumn'); ?>
<br /><label class="description" for="custom_header_overlay"><?php _e('Header on top after Top Navigation', 'mesocolumn'); ?></label>
</td>
</tr>
</tbody>
</table>
<?php } // end my_custom_image_options
function save_dez_custom_options() {
if ( isset( $_POST['custom_header_overlay'] )  ) {
// validate the request itself by verifying the _wpnonce-custom-header-options nonce
// (note: this nonce was present in the normal Custom Header form already, so we didn't have to add our own)
check_admin_referer( 'custom-header-options', '_wpnonce-custom-header-options' );
// be sure the user has permission to save theme options (i.e., is an administrator)
if ( current_user_can('manage_options') ) {
// NOTE: Add your own validation methods here
set_theme_mod( 'custom_header_overlay', $_POST['custom_header_overlay'] );
}
}
return;
}
//add_action('custom_header_options', 'dez_custom_image_options');
//add_action('admin_head', 'save_dez_custom_options');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

add_action( 'customize_register', 'themename_customize_register' );
function themename_customize_register($wp_customize) {
$wp_customize->add_setting('custom_header_overlay' , array(
'default' => 'No',
'type' => 'theme_mod',
'transport' => 'refresh',
'sanitize_callback' => 'wp_filter_post_kses',
'capability' => 'edit_theme_options',
)
);

$wp_customize->add_section( 'header_overlay' , array(
'title'      => __( 'Custom Header Overlay', 'mytheme' ),
'priority'   => 60,
)
);

$wp_customize->add_control( 'custom_header_overlay', array(
'label'   => 'Header Logo Overlay',
'section' => 'header_image',
'settings'   => 'custom_header_overlay',
'type'     => 'radio',
'choices'  => array(
'Yes'  => 'Yes',
'No' => 'No',
),
)
);
}


?>