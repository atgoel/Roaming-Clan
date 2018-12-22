<?php
/**
 * Plugin Name: WooCommerce Expand Tabs 
 * Plugin URI: http://wordpress.org/plugins/woocommerce-expand-tabs
 * Description: Expand the tabs in Products page as that is considered hidden content by Google. 
 * Version: 1.8
 * Author: Diana Burduja 
 * Author URI: https://www.silkypress.com 
 * License: GPL2
 *
 * WC requires at least: 2.3.0
 * WC tested up to: 3.4.0
 *
 */
 
defined('ABSPATH') or die();

/**
 * Replace the /wp-content/plugins/woocommerce/templates/single-product/tabs/tabs.php
 * with /wp-content/plugins/woocommerce-expand-tabs/tabs-template.php
 * where the code for showing the <ul> of tabs is stripped down
 */
if ( ! function_exists( 'woocommerce_output_product_data_tabs' ) && use_expand_tabs() ) {
    function woocommerce_output_product_data_tabs() {

        $folder = woocommerce_expand_tabs_get_folder();
        if ( !$folder) return;
        
        include (plugin_dir_path( __FILE__ ) . $folder . '/tabs-template.php');
    }
}

/**
 * Replace the /wp-content/plugins/woocommerce/assets/js/frontend/single-product.min.js
 * with  /wp-content/plugins/woocommerce-expand-tabs/single-product.js
 * where the code for hidding the content of the tabs is stripped down
 */
function woocommerce_expand_tabs_js() {

    $folder = woocommerce_expand_tabs_get_folder();
    if ( !$folder) return;

    wp_deregister_script('wc-single-product');

    wp_register_script( 'wc-single-product', plugins_url( '/', __FILE__) . $folder . '/single-product.min.js', array( 'jquery' ), 1.4, true );
    wp_enqueue_script('wc-single-product');
}
if ( use_expand_tabs() ) {
    add_action('wp_enqueue_scripts', 'woocommerce_expand_tabs_js', 100);
}


/**
 * Load the correct `wc` folder for the WooCommerce version
 */
function woocommerce_expand_tabs_get_folder() {
    if ( !defined( 'WC_VERSION' ) ) return false;

    if ( version_compare( WC_VERSION, '3.0', '<' ) ) return 'wc26';
    if ( version_compare( WC_VERSION, '3.0.50', '<=' ) ) return 'wc30';
    if ( version_compare( WC_VERSION, '3.1.50', '<=' ) ) return 'wc31';
    if ( version_compare( WC_VERSION, '3.2.50', '<=' ) ) return 'wc32';
    if ( version_compare( WC_VERSION, '3.3.50', '<=' ) ) return 'wc33';
    return 'wc34';
}


/**
 * As in ABS_PATH . WP_INC . '/vars.php';
 *
 * on multi-site installations the vars.php file is loaded later.
 *
 * if I include the file, then it throws an error because the wp_is_mobile is declared twice
 */
function woocommerce_expand_tabs_is_mobile() {
    static $is_mobile = null;

    if ( isset( $is_mobile ) ) {
        return $is_mobile;
    }

    if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
        $is_mobile = false;
    } elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
            $is_mobile = true;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}

/**
 * Check if you need to expand tabs or not
 */
function use_expand_tabs() {
    if ( woocommerce_expand_tabs_is_mobile() ) {
        $option = get_option( 'expand_tabs_mobile' );
    } else {
        $option = get_option( 'expand_tabs_desktop' );
    }

    if ( ! $option ) $option = 'yes';

    if ( $option == 'yes' )
        return true;

    return false;
}


/**
 * Compatibility with the Enfold theme
 */
if ( get_template() === 'enfold' ) {
    function expand_tabs_enfold() {
        if ( ! use_expand_tabs() ) return false;
        $output = 
            '<style type="text/css"> ' .
                '.js_active .woocommerce-tabs .panel { ' .
                    ' display: block !important; ' .
                ' } ' .
            '</style>' . 
            PHP_EOL;
        echo $output;
    } 
    add_action( 'wp_head', 'expand_tabs_enfold' );
}


/**
 * Compatibility with the Flatsome theme
 */
if ( get_template() === 'flatsome' ) { 
    function expand_tabs_flatsome() {
        if ( ! use_expand_tabs() ) return false;
        $output = 
            '<style type="text/css"> ' .
                '.vertical-tabs .tabs-inner, .tabbed-content .panel { '.
                    ' margin: 15px 0; ' .
                    ' float: none !important; ' .
                    ' line-height: 130%; '.
                    ' visibility: visible !important; '.
                    ' height: auto !important; '.
                    ' overflow: visible !important; '.
                    ' opacity: 1.0 !important; ' .
                ' } ' .
                '.tabbed-content ul.tabs { ' .
                    ' display: none !important; '.
                '} ' .
            '</style>' . 
            PHP_EOL;
        echo $output;
    } 
    add_action( 'wp_head', 'expand_tabs_flatsome' );
}

if( get_template() === 'storefront' ) {
    function expand_tabs_storefront() {
        if ( ! use_expand_tabs() ) return false;
        $output = 
            '<style type="text/css"> ' .
                '.woocommerce-tabs .panel {' . 
                    'width: 100% !important;'.
                ' } ' .
            '</style>' . 
            PHP_EOL;
        echo $output;

    }
    add_action( 'wp_head', 'expand_tabs_storefront' );
}


/**
 * Add the settings in the `admin.php?page=wc-settings&tab=products` page
 */
function expand_tabs_settings( $settings ) {
    $settings[] =    array(
        'title'     => __( 'Expand Tabs Settings', 'woocommerce' ),
        'desc'      => __( 'These settings are added by the <a href="https://wordpress.org/plugins/woocommerce-extend-tabs/" target="_blank">woocommerce-expand-tabs</a> plugin. '), 
        'type'      => 'title',
        'id'        => 'expand_tabs_options'
    );
    $settings[] =   array(
        'desc'            => __( 'Expand tabs for desktop devices', 'woocommerce' ),
        'id'              => 'expand_tabs_desktop',
        'default'         => 'yes',
        'type'            => 'checkbox',
        'checkboxgroup'   => 'start',
    );
    $settings[] =   array(
        'desc'            => __( 'Expand tabs for mobile devices', 'woocommerce' ),
        'id'              => 'expand_tabs_mobile',
        'default'         => 'yes',
        'type'            => 'checkbox',
        'checkboxgroup'   => 'end',
    );
    $settings[] =   array(
        'type' => 'sectionend',
        'id' => 'expand_tabs_options',
    );

    return $settings;

}
add_filter( 'woocommerce_product_settings', 'expand_tabs_settings' );


/**
 * Plugin action link to Settings page
 */
function woocommerce_expand_tabs_settings_link( $links ) {

    $settings_link = '<a href="admin.php?page=wc-settings&tab=products&section=display">' .
        esc_html( __('Settings' ) ) . '</a>';

    return array_merge( array( $settings_link), $links );

}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'woocommerce_expand_tabs_settings_link' );


