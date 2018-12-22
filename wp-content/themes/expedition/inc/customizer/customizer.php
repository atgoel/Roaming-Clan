<?php
/**
 * evision themes Theme Customizer
 *
 * @package eVision themes
 * @subpackage expedition
 * @since expedition 0.0.2
 */
add_filter('evision_customizer_framework_url', 'expedition_customizer_framework_url');

if( ! function_exists( 'expedition_customizer_framework_url' ) ):

    function expedition_customizer_framework_url(){
        return trailingslashit( get_template_directory_uri() ) . 'inc/frameworks/evision-customizer/';
    }

endif;

add_filter('evision_customizer_framework_path', 'expedition_customizer_framework_path');

if( ! function_exists( 'expedition_customizer_framework_path' ) ):
    function expedition_customizer_framework_path(){
        return trailingslashit( get_template_directory() ) . 'inc/frameworks/evision-customizer/';
    }
endif;

/*define constant for coder-customizer-constant*/
if(!defined('EVISION_CUSTOMIZER_NAME')){
    define('EVISION_CUSTOMIZER_NAME','expedition-options');
}


/**
 * reset options
 * @param  array $reset_options
 * @return void
 *
 * @since expedition 1.0
 */
if ( ! function_exists( 'expedition_reset_options' ) ) :
    function expedition_reset_options( $reset_options ) {
        set_theme_mod( EVISION_CUSTOMIZER_NAME, $reset_options );
    }
endif;
/**
 * Customizer framework added.
 */
require get_template_directory().'/inc/frameworks/evision-customizer/evision-customizer.php';

global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/******************************************
Modify Site Identity sections
 *******************************************/
require get_template_directory().'/inc/customizer/site-identity/site-identity.php';

/******************************************
Modify Site Color sections
 *******************************************/
require get_template_directory().'/inc/customizer/colors/general.php';

/******************************************
Added font setting options
 *******************************************/
require get_template_directory().'/inc/customizer/font-setting/font-family.php';

/******************************************
Featured Slider options
 *******************************************/
require get_template_directory().'/inc/customizer/featured-slider/slider-panel.php';

/******************************************
Popular Trip options
 *******************************************/
require get_template_directory().'/inc/customizer/home-trips/home-trips-panel.php';

/******************************************
Home About options 
 *******************************************/
require get_template_directory().'/inc/customizer/home-about/home-about-panel.php';

/******************************************
Home Testimonial options 
 *******************************************/
require get_template_directory().'/inc/customizer/testimonial/testimonial-panel.php';

/******************************************
Home Blog options 
 *******************************************/
require get_template_directory().'/inc/customizer/home-blog/home-blog-panel.php';

/******************************************
Theme options panel
 *******************************************/
require get_template_directory().'/inc/customizer/theme-options/option-panel.php';

/*Resetting all Values*/
/**
 * Reset color settings to default
 * @param  $input
 *
 * @since expedition 1.0
 */
$expedition_customizer_defaults['expedition-customizer-reset'] = '';
if ( ! function_exists( 'expedition_customizer_reset' ) ) :
    function expedition_customizer_reset( $input ) {
        if ( $input == 1 ) {
            global $expedition_customizer_defaults;

            $expedition_customizer_defaults['expedition-customizer-reset'] = '';
            /*resetting fields*/
            expedition_reset_options( $expedition_customizer_defaults );
        }
        else {
            return '';
        }
    }
endif;
$expedition_sections['expedition-customizer-reset'] =
    array(
        'priority'       => 999,
        'title'          => __( 'Reset All Options', 'expedition' )
    );
$expedition_settings_controls['expedition-customizer-reset'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-customizer-reset'],
            'sanitize_callback'    => 'expedition_customizer_reset',
            'transport'            => 'postmessage'
        ),
        'control' => array(
            'label'                 =>  __( 'Reset All Options', 'expedition' ),
            'description'           =>  __( 'Caution: Reset all options settings to default. Refresh the page after save to view the effects. ', 'expedition' ),
            'section'               => 'expedition-customizer-reset',
            'type'                  => 'checkbox',
            'priority'              => 10
        )
    );

/******************************************
Removing section setting control
 *******************************************/

$expedition_remove_sections =
    array(
        'header_image' 
    );
$expedition_remove_settings_controls =
    array(
        'display_header_text'
    );

$expedition_customizer_args = array(
    'panels'            => $expedition_panels, /*always use key panels */
    'sections'          => $expedition_sections,/*always use key sections*/
    'settings_controls' => $expedition_settings_controls,/*always use key settings_controls*/
    'repeated_settings_controls' => $expedition_repeated_settings_controls,/*always use key sections*/
    'remove_sections'   => $expedition_remove_sections,/*always use key remove_sections*/
    'remove_settings_controls' => $expedition_remove_settings_controls/*always use key remove_settings_controls*/
);

/*registering panel section setting and control start*/
function expedition_add_panels_sections_settings() {
    global $expedition_customizer_args;
    return $expedition_customizer_args;
}
add_filter( 'evision_customizer_panels_sections_settings', 'expedition_add_panels_sections_settings' );
/*registering panel section setting and control end*/

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function expedition_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'expedition_customize_register' );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function expedition_customize_preview_js() {
    wp_enqueue_script( 'expedition-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20160105', true );
}
add_action( 'customize_preview_init', 'expedition_customize_preview_js' );



/**
 * get all saved options
 * @param  null
 * @return array saved options
 *
 * @since expedition 1.0
 */
if ( ! function_exists( 'expedition_get_all_options' ) ) :
    function expedition_get_all_options( $merge_default = 0 ) {
        $expedition_customizer_saved_values = evision_customizer_get_all_values( );
        if( 1 == $merge_default ){
            global $expedition_customizer_defaults;
            if(is_array( $expedition_customizer_saved_values )){
                $expedition_customizer_saved_values = array_merge($expedition_customizer_defaults, $expedition_customizer_saved_values );
            }
            else{
                $expedition_customizer_saved_values = $expedition_customizer_defaults;
            }
        }
        return $expedition_customizer_saved_values;
    }
endif;