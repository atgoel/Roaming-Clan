<?php
/**
 * Admin View: Notice - Upgrade to Pro to import/export tool support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="notice notice-info notice-pbc pbc-is-dismissible pbc-request-review">	    
    <p class="rate-description"><?php printf( __( 'Hi! Do you need to %s the Pricing Zone fields? %sUpgrade to Price Based on Country Pro%s and get support to the WooCommerce import and export tool.', 'wc-price-based-country' ), $import_export, '<a href="https://www.pricebasedcountry.com/pricing/?utm_source=import-export-tool&utm_medium=banner&utm_campaign=Get_Pro" target="_blank" rel="noopener noreferrer">', '</a>' ); ?> </p>		
    <a class="notice-dismiss pbc-hide-notice" data-nonce="<?php echo wp_create_nonce( 'pbc-hide-notice' )?>" data-notice="pro_csv_tool" href="#"><span class="screen-reader-text"><?php _e( 'Dismiss this notice.' ); ?></span></a>		
</div>	