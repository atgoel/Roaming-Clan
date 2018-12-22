<?php
/**
 * Admin View: Notice - MaxMind GeoIP database
 *
 * @package WCPBC/Admin/Views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="notice notice-info notice-pbc pbc-is-dismissible">
	<a class="notice-dismiss pbc-hide-notice notice-pbc-close" data-nonce="<?php echo esc_attr( wp_create_nonce( 'pbc-hide-notice' ) ); ?>" data-notice="maxmind_geoip_database" href="#"><?php esc_html_e( 'Dismiss' ); ?></a>
	<p><strong>WooCommerce Price Based on Country: </strong>
	<?php // Translators: HTML tags. ?>
	<?php printf( esc_html__( 'The MaxMind GeoIP Database does not exist, geolocation will not function. %1$sClick here to install the MaxMind GeoIP Database now%2$s.', 'wc-price-based-country' ), '<a href="' . esc_url( add_query_arg( 'wcpbc_update_geoip_database', wp_create_nonce( 'wcpbc-update-geoipdb' ) ) ) . '">', '</a>' ); ?></p>
</div>
